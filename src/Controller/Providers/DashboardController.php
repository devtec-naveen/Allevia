<?php
namespace App\Controller\Providers;

use App\Controller\AppController;
use Cake\Controller\Component\PaginatorComponent;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\Utility\Security;
use Dompdf\Dompdf;
use \PHPExcel_IOFactory;
use Cake\View\View;
use Twilio\Rest\Client;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Date;
//use Cake\I18n\DateTime;



/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class DashboardController extends AppController
{
    public $timezone = "CST";
    public function initialize()
    {

      parent::initialize();
      $this->loadComponent('Paginator');
      $this->loadComponent('ProviderMailSend');
      $this->loadComponent('General');
      $this->loadComponent('CryptoSecurity');
      $this->loadComponent('TextMsgSend');
      $this->loadComponent('ApiGenaral');

      $this->loadModel('Schedule');
      $this->loadModel('Users');
      $this->loadModel('ProviderDisplayColumns');
      $this->loadModel('Organizations');
      $this->loadModel('Doctors');
      $this->loadModel('ScheduleFieldSettings');
      $this->loadModel('Specializations');
      $this->loadModel('UserLocations');
      $this->loadModel('ProviderGlobalSettings');
      $this->viewBuilder()->setLayout('provider');

      $login_user = $this->Auth->user();
      $provider_config_detail = $this->ProviderGlobalSettings->find('all')->where(['provider_id' => $login_user['id']])->first();
      $this->timezone = !empty($provider_config_detail) ? $provider_config_detail['timezone'] : "CST";

    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['fillAppointmentLink','telehealthAppointment','getTelehealthRecords']);
    }

    public function index($page_length = null, $filter = null)
    {
        
        $login_user = $this->Auth->user();        
        $user = $this->Users->find('all')->where(['id' => $login_user['id']])->first();
        $display_columns = $this->ProviderDisplayColumns->find('list',['keyField' => 'field_name','valueField' => 'is_show'])->where(['provider_id' => $login_user['id']])->toArray();
       // $current_date = new \DateTime("now", new \DateTimeZone('CST') );
       // $current_date = $current_date->format('Y-m-d');

        $schedule_data = $this->Schedule->find('all',array('order' => ['Schedule.id' => 'desc']))->where(['Date(Schedule.appointment_date) >=' => date('Y-m-d')])->where(['Schedule.organization_id' =>$login_user['organization_id'],'Schedule.provider_id' => $login_user['id']])
        ->contain(['Doctors','Users'])
        ->toArray();        

        $schedule_data = $this->convertAppointmentTime($schedule_data,$login_user['id']);

        if($this->request->is(['ajax'])){

          //pr($filter);die;
          if(!empty($this->Auth->user()) && $this->Auth->user()['role_id'] == 3){

              $view = new View($this->request,$this->response,null);
              $view->set(compact('schedule_data','display_columns','user'));
              $html = $view->render('Providers/Dashboard/index');
              $response = array('success' => true,'view' => $html,'search' =>$filter,'page_length' => $page_length);
              echo json_encode($response);
              die;
            } 
            else{

              $url = SITE_URL.'/providers';
              $response = array('success' => false,'url' => $url);
              echo json_encode($response);
              die;
            }
        }

      $this->set(compact('schedule_data','display_columns','user'));

    }

    public function analytics()
    {

       $login_user = $this->Auth->user(); 
       if($login_user['is_allow_analytics'] == 0)
       {
          $this->Flash->providererror(__('You are not allowed to access allevia analytics dashboard. Please contact from administrator'));
          return $this->redirect(['action' => 'index']);
       } 
       $display_columns = $this->ProviderDisplayColumns->find('list',['keyField' => 'field_name','valueField' => 'is_show'])->where(['provider_id' => $login_user['id']])->toArray();
       $schedule_data = $this->Schedule->find('all',array('order' => ['Schedule.id' => 'desc']))->where(['Schedule.organization_id' =>$login_user['organization_id'],'Schedule.provider_id' => $login_user['id'],'Schedule.status' =>3,'step_id' =>23])
         ->contain(['users','ChiefCompliantUserdetails'])
         ->toArray(); 

        foreach ($schedule_data as $key => $value) {

            if(!empty($value->chief_compliant_userdetail->questionnaire_detail)){
              $healthQuestionnair = unserialize(Security::decrypt(base64_decode($value->chief_compliant_userdetail->questionnaire_detail), SEC_KEY)); 
    
              $positiveH = array();
              if(!empty($healthQuestionnair[1])){
                foreach($healthQuestionnair[1] as $optionKey => $questionnaireId)
                {                
                  $positiveH[] = $questionnaireId;                                  
                }  
              }
              if(!empty($positiveH))
              {
                    $analytics = $this->getCalculationQuestionnair($positiveH); 
                    if(!empty($analytics)){
                    $value['uremiaSymtoms'] = isset($analytics['uremiaSymtoms'])?$analytics['uremiaSymtoms']:0;
                    $value['volumeoverload'] = isset($analytics['volumeoverload'])?$analytics['volumeoverload']:0;
                    $value['absoluteIndication'] = isset($analytics['absoluteIndication'])?$analytics['absoluteIndication']:0; 
                    $value['uremicpericarditis'] = isset($analytics['uremicpericarditis'])?$analytics['uremicpericarditis']:0; 
                    $value['uremicneuropathy'] = isset($analytics['uremicneuropathy'])?$analytics['uremicneuropathy']:0;   
                    $value['uremicPlatlet'] = isset($analytics['uremicPlatlet'])?$analytics['uremicPlatlet']:0; 
                    }
              }
                                               
         }            
         }         
         $this->set(compact('schedule_data','display_columns')); 
                
    }


    public function getCalculationQuestionnair($positiveH)
    {     
      $tablecolumn = array();
      $this->loadModel('ChiefCompliantQuestionnaire');
      $compliant_questin = $this->ChiefCompliantQuestionnaire->find('all')->select(['questionnaire_text'])->where(['id IN' =>$positiveH])->toArray();   
         

      $uremiaSymtoms = array('nausea','vomiting','anorexia','fatigue','decreased libido','erectile dysfunction','missing periods','fever','pleurisy','restless leg','burning feet','seizures','loss of concentration','numbness/tingling','weakness','easy bruising','nosebleeds','blood in urine','dark stools','bleeding gums','sudden blindness');
      $volumeoverload = array('swollen feet','pulmonary edema');
      $absoluteIndication = array('burning feet','restless leg','seizures','sudden blindness');
      $uremicpericarditis = array('fever','pleuritic chest pain');
      $uremicneuropathy = array('restless leg','burning feet','seizures','loss of concentration','numbness/tingling','weakness');
      $uremicPlatlet = array('easy bruising','nosebleeds','blood in urine','dark stools','bleeding gums');

      
      $counter = 1;
      foreach($compliant_questin as $key => $value)
      {          
          if(in_array($value['questionnaire_text'],$uremiaSymtoms))
          {                 
              $tablecolumn['uremiaSymtoms'] = $counter;              
          } 
          if(in_array($value['questionnaire_text'],$volumeoverload))
          {
              $tablecolumn['volumeoverload'] = 1;
          }
          if(in_array($value['questionnaire_text'],$absoluteIndication))
          {
              $tablecolumn['absoluteIndication'] = 1;
          }
          if(in_array($value['questionnaire_text'],$uremicpericarditis))
          {
              $tablecolumn['uremicpericarditis'] = 1;
          }
          if(in_array($value['questionnaire_text'],$uremicneuropathy))
          {
              $tablecolumn['uremicneuropathy'] = 1;
          }
          if(in_array($value['questionnaire_text'],$uremicPlatlet))
          {
              $tablecolumn['uremicPlatlet'] = 1;
          }
          $counter++; 
      }       
      return $tablecolumn;      
    }


    public function validateCsv()
    {
      $this->autoRender = false;
      $login_user = $this->Auth->user();
      $messages = array();
      $errors = array();
      $warnings = array();
      $final_result = array();
      $save_data = array();
      $input = $this->request->data();

      if(isset($input['excel_file']) && !empty($input['excel_file'])){

        $filename = $input['excel_file']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if($extension == 'csv' || $extension == 'xlsx' || $extension == 'xls'){


          $uploadFile = WWW_ROOT.'uploads/validate_file/'.date('d-m-Y').uniqid().'.'.$extension;
          if(move_uploaded_file($input['excel_file']['tmp_name'],$uploadFile))
          {

            $i = 0;

            $fields = $this->ScheduleFieldSettings->find('list',[

              'keyField' => 'field_name',
              'valueField' => 'field_index'
            ])->where(['provider_id' => $login_user['id']])->toArray();
            $schedule_fields = $this->Schedule->schema()->columns();
            if($extension == 'xlsx' || $extension == 'xls'){

              if(!isset($fields['file_type']) || $fields['file_type'] != 'excel'){

                  $response = array(
                    'messages' => [],
                    'errors' => ['File type is invalid, Please set excel file type in schedule field setting section.'],
                    'warnings' => [],
                    'save_data' => [],
                    'final_result' => 'File type is invalid, Please set excel file type in schedule field setting section.'
                  );

                  echo json_encode($response);
                  die;
              }
              $messages[] = "Its a ecxel file.";
              require(ROOT .'/vendor/Classes/PHPExcel.php');
              require(ROOT.'/vendor/Classes/PHPExcel/IOFactory.php');

               /**  Identify the type of $inputFileName  **/
              $inputFileType = \PHPExcel_IOFactory::identify($uploadFile);
              /**  Create a new Reader of the type that has been identified  **/
              $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
              /** Set read type to read cell data onl **/
              $objReader->setReadDataOnly(true);
              /**  Load $inputFileName to a PHPExcel Object  **/
              $objPHPExcel = $objReader->load($uploadFile);
              //Get worksheet and built array with first row as header
              $objWorksheet = $objPHPExcel->getActiveSheet();

              $highestRow      = $objWorksheet->getHighestRow();
              $highestColumn = $objWorksheet->getHighestColumn();
              $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
              $headingsArray = $headingsArray[1];

              $messages[] = "Total number of lines is ".$highestRow.".";
             //set starting row from where we need to read file and ending row
              $starting_row = -1;
              $ending_row = -1;

              if(!empty($fields)){

                $starting_row = $fields['starting_row'];
                $ending_row = $fields['ending_row'];
              }

              if($starting_row <= 0){

                $starting_row = 1;
              }

              if($ending_row <= 0){

                $ending_row = $highestRow;
              }

              $messages[] = "We are start reading the file from line number ".$starting_row.".";
              $messages[] = "we are end reading the file on line number ".$ending_row.".";

              if($starting_row > $ending_row){

                $errors[] = "Starting row number should be less than ending row number.";
              }

              //check file has enough number of row to read the file
              if($starting_row > $highestRow){

                $errors[] = "Invalid file starting row number, Please set starting row number less than or equal to total number of rows in file.";
              }

              //fetch the fields column number in which data found in file
              $email_field_index = -1;
              $phone_field_index = -1;
              $first_name_field_index = -1;
              $last_name_field_index = -1;
              $dob_field_index = -1;
              $gender_field_index = -1;
              if(!empty($fields) && isset($fields['email'])){

                  $email_field_index = $fields['email'];
                  $email_field_index = $email_field_index -1;
              }

              if(!empty($fields) && isset($fields['phone'])){

                  $phone_field_index = $fields['phone']-1;
              }

              if(!empty($fields) && isset($fields['first_name'])){

                  $first_name_field_index = $fields['first_name']-1;
              }

              if(!empty($fields) && isset($fields['last_name'])){

                  $last_name_field_index = $fields['last_name']-1;
              }

              if(!empty($fields) && isset($fields['dob'])){

                  $dob_field_index = $fields['dob']-1;
              }
              if(!empty($fields) && isset($fields['gender'])){

                  $gender_field_index = $fields['gender']-1;
              }

              $erro_mail = 0;

              for ($r = $starting_row; $r <= $ending_row; ++$r)
              {

                $row = $objWorksheet->rangeToArray('A'.$r.':'.$highestColumn.$r,null, true, false)[0];
                $row = array_filter($row);

                if(!empty($row)){

                  $is_saved = 1;

                  if(!isset($row[$email_field_index]) && !isset($row[$phone_field_index]) && (!isset($row[$first_name_field_index]) || !isset($row[$last_name_field_index]) || !isset($row[$dob_field_index]))){

                    $warnings[] = "Line".$r.": Require data not found";
                    continue;
                  }

                   $k = $i;

                    if(!empty($fields)){

                      foreach ($fields as $fkey => $fvalue) {

                        //skip the field when field number is less than 1
                        if($fvalue < 1){

                          continue;
                        }

                        if(in_array($fkey, $schedule_fields) && isset($row[$fvalue-1])){

                          $save_data[$r][$fkey] = trim($row[$fvalue-1]);
                        }
                      }
                    }
                }
              }
             // die;

            }else{

              if(!isset($fields['file_type']) || $fields['file_type'] != 'csv'){

                  $response = array(
                    'messages' => [],
                    'errors' => ['File type is invalid, Please set csv file type in schedule field setting section.'],
                    'warnings' => [],
                    'save_data' => [],
                    'final_result' => 'File type is invalid, Please set csv file type in schedule field setting section.'
                  );

                  echo json_encode($response);
                  die;
              }



              $messages = array();
              $errors = array();
              $warnings = array();
              $messages[] = 'Its a csv file.';
              // open the file
              $handle = fopen($uploadFile, "r");
              $fp = file($uploadFile);
              //count the total number of records in file
              $csv_total_rows = count($fp);
              $messages[] = 'Total number of lines is '.$csv_total_rows." .";
               //set starting row from where we need to read file and ending row
              $starting_row = -1;
              $ending_row = -1;

              if(!empty($fields)){

                $starting_row = $fields['starting_row'];
                $ending_row = $fields['ending_row'];
              }

               if($starting_row <=  0){

                  $starting_row = 1;
               }

               if($ending_row <= 0){

                  $ending_row = $csv_total_rows;
               }

               $messages[] = 'We are start reading the file from line number '.$starting_row.' .';
               $messages[] = "we are end reading the file on line number ".$ending_row.' .';

               if($starting_row > $ending_row){

                $errors[] = "Starting row number should be less than ending row number.";
              }

              if($starting_row > $csv_total_rows){

                $errors[] = "Invalid file starting row number, Please set starting row number less than or equal to total number of rows in file.";
              }

              // read the 1st row as headings
              $header = fgetcsv($handle);
              $i  = 0;

              $erro_mail = 0;
              $count_row = 1;
              $read_excel_type = $fields['read_by'];
              $read_column_index = $fields['single_column_index']-1;

              if($read_excel_type == 1){

                $messages[] = "CSV file is read using iPatientCare.";
                $messages[] = "We read only column number ".$fields['single_column_index'].' from file.';

              }else{

                $messages[] = "CSV file is read using Default.";
                $messages[] = "Email data found in column number ".$fields['email']." .";
              }

              //fetch the fields column number in which data found in file
              $email_field_index = -1;
              $phone_field_index = -1;
              $first_name_field_index = -1;
              $last_name_field_index = -1;
              $dob_field_index = -1;
              $appointment_reason_index = 12;
              $doctor_name_index = 10;
              $gender_field_index = -1;

              if(!empty($fields) && isset($fields['email'])){

                  $email_field_index = $fields['email']-1;
              }

              if(!empty($fields) && isset($fields['phone'])){

                  $phone_field_index = $fields['phone']-1;
              }

              if(!empty($fields) && isset($fields['first_name'])){

                  $first_name_field_index = $fields['first_name']-1;
              }

              if(!empty($fields) && isset($fields['last_name'])){

                  $last_name_field_index = $fields['last_name']-1;
              }

              if(!empty($fields) && isset($fields['dob'])){

                  $dob_field_index = $fields['dob']-1;
              }
              if(!empty($fields) && isset($fields['gender'])){

                  $gender_field_index = $fields['gender']-1;
              }

              if(isset($fields['appointment_reason']) || $fields['appointment_reason'] > 0){

                $appointment_reason_index = $fields['appointment_reason']-1;

              }

              if(isset($fields['doctor_name']) || $fields['doctor_name'] > 0){

                $doctor_name_index = $fields['doctor_name']-1;

              }


              if($read_excel_type == 1){

                while ($row = fgetcsv($handle))
                {
                  //pr($row);
                  //start read the csv file from starting_row
                  if($count_row < $starting_row){

                    $count_row++;
                    continue;
                  }

                  //end the reading of csv file on end_row
                  if($count_row > $ending_row){

                    break;
                  }

                  $count_row++;
                  $row = array_filter($row);
                  if(!empty($row))
                  {

                    if(!isset($row[$read_column_index])){

                      $warnings[] = "Line".$count_row.": Reading column not found.";
                      continue;
                    }

                    $patient_detail_data = explode(",", $row[$read_column_index]);
                   // pr($patient_detail_data);
                    $temp_patient_detail = array();
                    $columns_count = 1;

                    foreach ($patient_detail_data as $pkey => $pdata) {

                      if($columns_count == 2){

                        $temp_patient_detail['first_name'] = trim($pdata);
                        //continue;
                      }else{

                        $temp_data = strtolower(trim($pdata));
                        if(stripos($temp_data,'patient details') !== false){

                          $temp_patient_detail['last_name'] = trim(substr($pdata,stripos($pdata,':')+1));
                        }
                        elseif(stripos($temp_data,'dob') !== false){

                          $temp_patient_detail['dob'] = trim(substr($pdata,stripos($pdata,':')+1));
                        }
                        elseif(stripos($temp_data,'mrn') !== false){

                          $temp_patient_detail['mrn'] = trim(substr($pdata,stripos($pdata,'#')+1));
                        }
                        elseif(stripos($temp_data,'mobile') !== false){

                          $temp_patient_detail['phone'] = trim(substr($pdata,stripos($pdata,':')+1));
                        }
                        elseif(stripos($temp_data,'e-mail') !== false){

                          $temp_patient_detail['email'] = strtolower(trim(substr($pdata,stripos($pdata,':')+1)));
                        }
                        elseif(stripos($temp_data,'gender') !== false){

                          $temp_patient_detail['gender'] = strtolower(trim(substr($pdata,stripos($pdata,':')+1)));
                        }
                      }

                      $columns_count++;

                    }

                    $temp_appointment_reason = trim(end($patient_detail_data));
                    if(!empty($temp_appointment_reason) && strpos($temp_appointment_reason,":") === false && strpos($temp_appointment_reason,"MRN") === false){

                        $temp_patient_detail['appointment_reason'] = $temp_appointment_reason;
                    }

                    if(!empty($row[4])){

                      $temp_patient_detail['appointment_time'] = trim($row[4]);
                    }

                    if(isset($row[$doctor_name_index]) && !empty($row[$doctor_name_index])){

                      $temp_patient_detail['doctor_name'] = trim($row[$doctor_name_index]);
                    }

                    if(empty($temp_patient_detail['appointment_reason']) && isset($row[$appointment_reason_index]) && !empty($row[$appointment_reason_index])){

                      $temp_patient_detail['appointment_reason'] = trim(substr($row[$appointment_reason_index],stripos($row[$appointment_reason_index],':')+1));
                    }

                    if(empty($temp_patient_detail)){

                      $warnings[] = "Line".$count_row.": Reading column is found but schedule valid data not found.";
                      continue;
                    }

                    if(!isset($temp_patient_detail['email']) && !isset($temp_patient_detail['phone']) && (!isset($temp_patient_detail['first_name']) || !isset($temp_patient_detail['last_name']) || !isset($temp_patient_detail['dob']) || !isset($temp_patient_detail['gender']))){

                      $warnings[] = "Line".$count_row.": require data not found";
                      continue;
                    }

                    $save_data[$count_row] = $temp_patient_detail;

                  }
                    //die;

                }
                // pr($save_data);
                // die;

              }
                else{
                  //need to start the work from monday
                  while ($row = fgetcsv($handle)) {
                    //pr($row);
                    //start read the csv file from starting_row
                    if($count_row < $starting_row){

                      $count_row++;
                      continue;
                    }

                    //end the reading of csv file on end_row
                    if($count_row > $ending_row){

                      break;
                    }

                    $count_row++;

                    $row = array_filter($row);

                    if(!empty($row)){

                     if(!isset($row[$email_field_index]) && !isset($row[$phone_field_index]) && (!isset($row[$first_name_field_index]) || !isset($row[$last_name_field_index]) || !isset($row[$dob_field_index]))){

                        $warnings[] = "Line".$count_row.": Require data not found";
                        continue;
                      }

                      if(!empty($fields)){

                        //pr($fields);die;
                        foreach ($fields as $fkey => $fvalue) {

                          //skip the field when field number is less than 1
                          if($fvalue < 1){

                            continue;
                          }

                          if(in_array($fkey, $schedule_fields) && isset($row[$fvalue-1])){

                            $save_data[$count_row][$fkey] = trim($row[$fvalue-1]);
                          }
                        }
                      }
                    }
                  }
                }
              }

            $temp_data = array();

              
            $save_data = $this->checkuniqueness($save_data);                       

            if(!empty($save_data)){

              foreach ($save_data as $key => $value) {

                  $value = array_filter($value);

                  if(isset($value['email'])){

                    if(!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{1,})+$/",trim($value['email']))){
                      $errors[] = "Line".$key.": Inavlid email.";
                      unset($save_data[$key]);
                      continue;
                    }

                    $value['email'] = trim($value['email']);
                  }

                  if(isset($value['phone'])){
                    $temp_phone = trim($value['phone']);
                    $temp_phone = str_replace("-", "", $value['phone']);
                    if(!is_numeric($temp_phone)){
                      $errors[] = "Line".$key.": Inavlid phone.";
                      unset($save_data[$key]);
                      continue;
                    }

                    $value['phone'] = trim($value['phone']);
                  }

                  //get the date and time according to current timezone of provider
                  $time = isset($value['appointment_time']) ? $value['appointment_time'] : "";
                  $date_time_arr = $this->getDateTime($this->timezone,'CST',$time);
                  //pr($date_time_arr);
                  if(empty($date_time_arr)){

                    $errors[] = "Line".$key.": Inavlid appointment time.";
                    unset($save_data[$key]);
                    continue;
                  }

                  $value['appointment_time'] = $date_time_arr['appointment_time'];
                  $value['appointment_date'] = $date_time_arr['appointment_date'];

                  if(isset($value['dob'])){
                    $value['dob'] = date('Y-m-d',strtotime($value['dob']));
                  }

                  if(!isset($value['email']) && !isset($value['phone']) && (!isset($value['first_name']) || !isset($value['last_name']) || !isset($value['dob']) || !isset($value['gender']))){

                    $warnings[] = "Line".$key.": Require data not found";
                    continue;
                  }

                  $value['organization_id'] = $login_user['organization_id'];
                  $value['provider_id'] = $login_user['id'];

                  //check user data valid or not, registered or not
                 $user_detail_data = $this->checkUserRegistered($value);

                /* $mrn = !empty($value['mrn'])? $value['mrn'] :'';
                 $mrnCheck = $this->General->mrnVerify($login_user['organization_id'],$mrn,$value);
                 if($mrnCheck == 1)
                 {  

                     $errors[] = "Line".$key.":Mrn already exists for another patient!. ".$mrn;
                     unset($save_data[$key]);
                     continue;           
                 }*/


                 if(!empty($user_detail_data['error'])){

                    $errors[] = "Line".$key.": ".$user_detail_data['error'].'.';
                    unset($save_data[$key]);
                    continue;
                  }

                  $already_schedule_detail = $this->save_appointment_schedule_data($value, $validationflag = 1);

                  if(!empty($already_schedule_detail['schedule']) && !empty($already_schedule_detail['schedule']['gender']))
                  {
                    $gender  = array(0 =>"Fenmale",1=>"Male",2=>"Other" );
                    $already_schedule_detail['schedule']['gender']  = $gender[$already_schedule_detail['schedule']['gender']];
                  }

                  if(!empty($already_schedule_detail['schedule']))
                  {
                    $temp_data[]  = $already_schedule_detail['schedule'];
                  }

                  //echo $schedule_detail.' ';
                  if(!empty($already_schedule_detail['already_appointment'])){

                    $already_appointment = '';
                    $already_appointment .= isset($already_schedule_detail['already_appointment']['first_name']) && !empty($already_schedule_detail['already_appointment']['first_name'])?'First Name: '.$already_schedule_detail['already_appointment']['first_name']:'';
                    $already_appointment .= isset($already_schedule_detail['already_appointment']['Name']) && !empty($already_schedule_detail['already_appointment']['Name'])?' Last Name: '.$already_schedule_detail['already_appointment']['Name']:'';
                    $already_appointment .= isset($already_schedule_detail['already_appointment']['dob']) && !empty($already_schedule_detail['already_appointment']['dob'])?' Dob: '.$already_schedule_detail['already_appointment']['dob']:'';
                    $already_appointment .= isset($already_schedule_detail['already_appointment']['phone']) && !empty($already_schedule_detail['already_appointment']['phone'])?' Phone: '.$already_schedule_detail['already_appointment']['phone']:'';
                    $already_appointment .= isset($already_schedule_detail['already_appointment']['email']) && !empty($already_schedule_detail['already_appointment']['email'])?' Email: '.$already_schedule_detail['already_appointment']['email']:'';
                    $warnings[] = "Line".$key.": ".$already_appointment .'(Already scheduleded appointment).';
                  }
              }

            }

            $save_data = $temp_data;
            if(empty($save_data)){

              $final_result = "No data found.";
            }
            else{

              $final_result = "You can upload the file.";
            }

          }
          else{

              $errors[] = "File not uploaded successfully.";
              $final_result = "File not uploaded successfully.";
          }

        }
        else{

          $errors[] = "Please upload csv or xlsx file only.";
          $final_result = "Please upload csv or xlsx file only.";
        }
       }

       $response = array(
                    'messages' => $messages,
                    'errors' => $errors,
                    'warnings' => $warnings,
                    'save_data' => $save_data,
                    'final_result' => $final_result
                     );

      echo json_encode($response);
      die;
    }

    public function uploadScheduleCsv(){
      $this->autoRender = false;
      $login_user = $this->Auth->user();
      $locations = $this->UserLocations->find('list',['keyField' => 'id','valueField' => 'location_id'])->where(['user_id' => $login_user['id'],'user_type' =>2])->toArray();

      $input = $this->request->data();

      if(isset($input['csv_file']) && !empty($input['csv_file'])){

        $filename = $input['csv_file']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if($extension == 'csv' || $extension == 'xlsx' || $extension == 'xls'){

          // pr($extension);die;
           $uploadFile = WWW_ROOT.'uploads/schedule/'.date('d-m-Y').uniqid().'.'.$extension;
          if(move_uploaded_file($input['csv_file']['tmp_name'],$uploadFile)){

            $i = 0;

            $save_data = array();
            $fields = $this->ScheduleFieldSettings->find('list',[

              'keyField' => 'field_name',
              'valueField' => 'field_index'
            ])->where(['provider_id' => $login_user['id']])->toArray();



            $schedule_fields = $this->Schedule->schema()->columns();
            $error = array();

            if($extension == 'xlsx' || $extension == 'xls'){

              if(!isset($fields['file_type']) || $fields['file_type'] != 'excel'){

                  $response = array('success' => false,'msg' => '<p>File type is invalid, Please set excel file type in schedule field setting section.</p>');


                  echo json_encode($response);
                  die;
              }

              require(ROOT .'/vendor/Classes/PHPExcel.php');
              require(ROOT.'/vendor/Classes/PHPExcel/IOFactory.php');

               /**  Identify the type of $inputFileName  **/
              $inputFileType = \PHPExcel_IOFactory::identify($uploadFile);
              /**  Create a new Reader of the type that has been identified  **/
              $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
              /** Set read type to read cell data onl **/
              $objReader->setReadDataOnly(true);
              /**  Load $inputFileName to a PHPExcel Object  **/
              $objPHPExcel = $objReader->load($uploadFile);
              //Get worksheet and built array with first row as header
              $objWorksheet = $objPHPExcel->getActiveSheet();

              $highestRow = $objWorksheet->getHighestRow();
              $highestColumn = $objWorksheet->getHighestColumn();
              $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
              $headingsArray = $headingsArray[1];

             //set starting row from where we need to read file and ending row
              $starting_row = -1;
              $ending_row = -1;

             // pr($highestRow);die;

              if(!empty($fields)){

                $starting_row = $fields['starting_row'];
                $ending_row = $fields['ending_row'];
              }

              if($starting_row <= 0){

                $starting_row = 1;
              }

              if($ending_row <= 0){

                $ending_row = $highestRow;
              }

              if($starting_row > $ending_row){

                  $response = array('success' => false,'msg' => '<p>Starting row number should be less than ending row number.</p>');
                echo json_encode($response);
                die;
              }

              //check file has enough number of row to read the file
              if($starting_row > $highestRow){

                $response = array('success' => false,'msg' => '<p>Invalid file starting row number, Please set starting row number less than or equal to total number of records in file.</p>');
                echo json_encode($response);
                die;
              }

               for ($r = $starting_row; $r <= $ending_row; ++$r) {

                $row = $objWorksheet->rangeToArray('A'.$r.':'.$highestColumn.$r,null, true, false)[0];
                $row = array_filter($row);

                if(!empty($row)){

                  $k = $i;
                  if(!empty($fields)){

                    foreach ($fields as $fkey => $fvalue) {

                      //skip the field when field number is less than 1
                      if($fvalue < 1){

                        continue;
                      }

                      if(in_array($fkey, $schedule_fields) && isset($row[$fvalue-1])){

                       if($fkey == 'doctor_name'){

                          $save_data[$k][$fkey] = trim($row[$fvalue-1]);
                        }
                        else{

                          $save_data[$k][$fkey] = trim($row[$fvalue-1]);
                        }
                      }
                    }
                  }

                  $i++;
                }
              }
             // die;

            }else{

              if(!isset($fields['file_type']) || $fields['file_type'] != 'csv'){

                  $response = array('success' => false,'msg' => '<p>File type is invalid, Please set csv file type in schedule field setting section.</p>');
                  echo json_encode($response);
                  die;
              }

              // open the file
              $handle = fopen($uploadFile, "r");
              $fp = file($uploadFile);

              //count the total number of records in file
              $csv_total_rows = count($fp);
               //set starting row from where we need to read file and ending row
              $starting_row = -1;
              $ending_row = -1;

              if(!empty($fields)){

                $starting_row = $fields['starting_row'];
                $ending_row = $fields['ending_row'];
              }

               if($starting_row <=  0){

                  $starting_row = 1;
               }

               if($ending_row <= 0){

                  $ending_row = $csv_total_rows;
               }

               if($starting_row > $ending_row){

                  $response = array('success' => false,'msg' => '<p>Starting row number should be less than ending row number.</p>');
                echo json_encode($response);
                die;
              }

              if($starting_row > $csv_total_rows){

                $response = array('success' => false,'msg' => '<p>Invalid file starting row number, Please set starting row number less than or equal to total number of records in file.</p>');
                echo json_encode($response);
                die;
              }

              // read the 1st row as headings
              $header = fgetcsv($handle);
              $i  = 0;

                $erro_mail = 0;
                $count_row = 1;
                $read_excel_type = $fields['read_by'];
                $read_column_index = $fields['single_column_index']-1;

                $email_field_index = -1;
                $phone_field_index = -1;
                $first_name_field_index = -1;
                $last_name_field_index = -1;
                $gender_field_index = -1;
                $dob_field_index = -1;
                $appointment_reason_index = 12;
                $doctor_name_index = 10;

                if(!empty($fields) && isset($fields['email'])){

                    $email_field_index = $fields['email']-1;
                }

                if(!empty($fields) && isset($fields['phone'])){

                    $phone_field_index = $fields['phone']-1;
                }

                if(!empty($fields) && isset($fields['first_name'])){

                    $first_name_field_index = $fields['first_name']-1;
                }

                if(!empty($fields) && isset($fields['last_name'])){

                    $last_name_field_index = $fields['last_name']-1;
                }

                if(!empty($fields) && isset($fields['gender'])){

                    $gender_field_index = $fields['gender']-1;
                }

                if(!empty($fields) && isset($fields['dob'])){

                    $dob_field_index = $fields['dob']-1;
                }

                if(isset($fields['appointment_reason']) || $fields['appointment_reason'] > 0){

                  $appointment_reason_index = $fields['appointment_reason']-1;

                }

                if(isset($fields['doctor_name']) || $fields['doctor_name'] > 0){

                  $doctor_name_index = $fields['doctor_name']-1;

                }

                if($read_excel_type == 1){

                   while ($row = fgetcsv($handle)) {


                      //start read the csv file from starting_row
                      if($count_row < $starting_row){

                        $count_row++;
                        continue;
                      }

                      //end the reading of csv file on end_row
                      if($count_row > $ending_row){

                        break;
                      }

                      $count_row++;

                      $row = array_filter($row);

                      if(!empty($row)){

                        if(!isset($row[$read_column_index])){

                          //column that data we need to read is not found
                          continue;
                        }
                        $patient_detail_data = explode(",", $row[$read_column_index]);

                        $temp_patient_detail = array();
                        $columns_count = 1;

                        foreach ($patient_detail_data as $pkey => $pdata) {

                          if($columns_count == 2){

                            $temp_patient_detail['first_name'] = trim($pdata);
                            //continue;
                          }else{

                            $temp_data = strtolower(trim($pdata));
                            if(stripos($temp_data,'patient details') !== false){

                              $temp_patient_detail['last_name'] = trim(substr($pdata,stripos($pdata,':')+1));
                            }
                            elseif(stripos($temp_data,'dob') !== false){

                              $temp_patient_detail['dob'] = trim(substr($pdata,stripos($pdata,':')+1));
                              if(!empty($temp_patient_detail['dob'])){

                                $temp_patient_detail['dob'] = date('Y-m-d',strtotime($temp_patient_detail['dob']));
                              }
                            }
                            elseif(stripos($temp_data,'mrn') !== false){

                              $temp_patient_detail['mrn'] = trim(substr($pdata,stripos($pdata,'#')+1));
                            }
                            elseif(stripos($temp_data,'mobile') !== false){

                              $temp_patient_detail['phone'] = trim(substr($pdata,stripos($pdata,':')+1));
                            }
                            elseif(stripos($temp_data,'gender') !== false){

                              $temp_patient_detail['gender'] = trim(substr($pdata,stripos($pdata,':')+1));
                            }
                            elseif(stripos($temp_data,'e-mail') !== false){

                              $temp_patient_detail['email'] = strtolower(trim(substr($pdata,stripos($pdata,':')+1)));
                            }
                          }

                          $columns_count++;

                        }



                        if(!empty($row[4])){

                            $temp_patient_detail['appointment_time'] = trim($row[4]);
                        }
                        else
                        {
                             $temp_patient_detail['appointment_time'] = date('h:i');
                        }

                        if(isset($row[$doctor_name_index]) && !empty($row[$doctor_name_index])){

                            $temp_patient_detail['doctor_name'] = trim($row[$doctor_name_index]);
                        }

                        $temp_appointment_reason = end($patient_detail_data);
                        if(!empty($temp_appointment_reason) && strpos($temp_appointment_reason,":") === false && strpos($temp_appointment_reason,"MRN") === false){

                            $temp_patient_detail['appointment_reason'] = $temp_appointment_reason;
                        }

                        if(!empty($temp_patient_detail['appointment_reason']) && isset($row[$appointment_reason_index]) && !empty($row[$appointment_reason_index])){

                            $temp_patient_detail['appointment_reason'] = trim(substr($row[$appointment_reason_index],stripos($row[$appointment_reason_index],':')+1));

                        }

                        if(empty($temp_patient_detail)){

                          //valid data not found
                          continue;
                        }

                        $save_data[$i] = $temp_patient_detail;
                        $i++;

                    }
                  }

                }
                else{

                  while ($row = fgetcsv($handle)) {
                    //pr($row);
                  //start read the csv file from starting_row
                  if($count_row < $starting_row){
                    $count_row++;
                    continue;
                  }

                  //end the reading of csv file on end_row
                  if($count_row > $ending_row){

                    break;
                  }

                  $count_row++;

                  $row = array_filter($row);



                  if(!empty($row)){

                    $k = $i;
                    if(!empty($fields)){


                      foreach ($fields as $fkey => $fvalue) {

                        //skip the field when field number is less than 1
                        if($fvalue < 1){

                          continue;
                        }

                        if(in_array($fkey, $schedule_fields) && isset($row[$fvalue-1])){

                          if($fkey == 'doctor_name'){

                            $save_data[$k][$fkey] = trim($row[$fvalue-1]);
                          }
                          else{

                            $save_data[$k][$fkey] =  trim($row[$fvalue-1]);
                          }
                        }
                      }
                    }
                    $i++;
                  }
                }
              }
            }
            //pr($save_data); die;
            //get setting of columns that show in table
            $display_columns = $this->ProviderDisplayColumns->find('list',['keyField' => 'field_name','valueField' => 'is_show'])->where(['provider_id' => $login_user['id']])->toArray();

            $insert_schedule_ids = [];
           // pr($save_data);die;
            if(!empty($save_data)){

              foreach ($save_data as $key => $value) {

                  $user_detail_data = null;
                  $value = array_filter($value);

                  if(isset($value['email'])){

                    if(!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{1,})+$/",trim($value['email']))){
                      //echo 'invalid email <br>';
                      continue;
                    }

                    $value['email'] = trim($value['email']);
                  }

                  if(isset($value['phone'])){

                    $temp_phone = trim($value['phone']);
                    $temp_phone = str_replace("-", "", $value['phone']);
                    if(!is_numeric($temp_phone)){
                     // echo 'invalid phone <br>';
                       continue;
                    }
                    $value['phone'] = trim($value['phone']);
                  }

                  if(isset($value['dob'])){
                    $value['dob'] = date('Y-m-d',strtotime($value['dob']));
                  }

                  if(!isset($value['email']) && !isset($value['phone']) && (!isset($value['first_name']) || !isset($value['last_name']) || !isset($value['dob']))){

                    continue;
                  }

                  //get the date and time according to current timezone of provider
                  $time = isset($value['appointment_time']) ? $value['appointment_time'] : date('h:i');
                  $date_time_arr = $this->getDateTime($this->timezone,'CST',$time);
                  //pr($date_time_arr);
                  if(empty($date_time_arr)){
                    //invalid date and time
                    continue;
                  }

                  $value['appointment_time'] = $date_time_arr['appointment_time'];
                  $value['appointment_date'] = $date_time_arr['appointment_date'];

                  if(isset($value['doctor_name'])){

                    if(!empty($locations))
                    {
                       $doctor_data = $this->Doctors->find('all')->innerJoinWith('UserLocations', function ($q) use ($locations) {
                                  return $q->where(['UserLocations.location_id IN' => $locations]);
                              })->where(['organization_id' =>$login_user['organization_id'],'doctor_name'=>$value['doctor_name'],'specialization_id <>'=>''])->first();
                    }
                    else
                    {
                       $doctor_data = $this->Doctors->find('all')->where(['organization_id' =>$login_user['organization_id'],'doctor_name'=>$value['doctor_name'],'specialization_id <>'=>''])->first();
                    }

                    if(!empty($doctor_data)){

                      $value['doctor_id'] = $doctor_data->id;
                    }
                  }

                  $value['organization_id'] = $login_user['organization_id'];
                  $value['provider_id'] = $login_user['id'];

                  //check user data valid or not, registered or not
                  $user_detail_data = $this->checkUserRegistered($value);
                  //pr($user_detail_data);
                  if(!empty($user_detail_data['error'])){
                    //echo $user_detail_data['error'];
                    continue;
                  }

                 $mrn = !empty($value['mrn'])? $value['mrn'] :'';
                 $mrnCheck = $this->mrnVerify($login_user['organization_id'],$mrn,$value);
                 if($mrnCheck == 1)
                 {      
                     $mrnDuplicacy = array();
                     $mrnDuplicacyArray[] = $mrn;
                     $mrnduplicate = !empty($mrnDuplicacyArray) ? implode(', ', $mrnDuplicacyArray) :'';
                     $mrnresponse = array('success' => false,'msg' => '<p>Mrn '.$mrnduplicate.' is assigned with another patient!.</p>');
                     continue;
                     //echo json_encode($response);
                     //die;               
                 }



                  if(!empty($user_detail_data['user_detail'])){
                    //echo $user_detail_data['error'];
                    $value['user_id'] = $user_detail_data['user_detail']['id'];
                  }

                  
                  //schedule appointment for patient
                 
                  
                  $schedule_detail = $this->save_appointment_schedule_data($value);
                  //echo $schedule_detail.' ';
                  if(!empty($schedule_detail)){

                    $insert_schedule_ids[] = $schedule_detail;
                  }
              }
             
            }

           // pr($insert_schedule_ids);
           // die('zdd');
            if(!empty($mrnresponse))
            {
                 echo json_encode($mrnresponse);
                 die;
            }  
            if(empty($insert_schedule_ids)){

              $response = array('success' => false,'msg' => '<p>No valid appointment data found.</p>');
              echo json_encode($response);
              die;

            }

            //send reminder for appointment for insert schedule
            if(!empty($insert_schedule_ids)){

                $provider_config_detail = $this->ProviderGlobalSettings->find('all')->where(['provider_id' => $login_user['id']])->first();
                if(!empty($provider_config_detail) && ($provider_config_detail['patient_intake_cvs_upload_reminder'] == 1 || $provider_config_detail['telehealth_cvs_upload_reminder'] == 1)){

                  $this->sendAll($provider_config_detail, $insert_schedule_ids);
                }
            }

            //$current_date = new \DateTime("now", new \DateTimeZone('CST') );
           // $current_date = $current_date->format('Y-m-d');

            $schedule_data = $this->Schedule->find('all',array('order' => ['Schedule.id' => 'desc']))->where(['Date(Schedule.appointment_date)' => date('Y-m-d') ])->where(['Schedule.organization_id' =>$login_user['organization_id'],'Schedule.provider_id' => $login_user['id']])
              ->contain(['Doctors','Users'])
              ->toArray();

            $schedule_data = $this->convertAppointmentTime($schedule_data,$login_user['id']);

            $user = $this->Users->find('all')->where(['id'=> $login_user['id']])->first();
            $view = new View($this->request,$this->response,null);
            //$view->layout = 'provider';
            $view->set(compact('schedule_data','display_columns','user'));
            $html = $view->render('Providers/Dashboard/upload_schedule_csv');
            $response = array('success' => true,'msg' => 'Csv file uploaded successfully.','view' => $html);
            echo json_encode($response);
            die;

          }

          $response = array('success' => false,'msg' => '<p>File not uploaded successfully.</p>');
          echo json_encode($response);
          die;

        }else{

          $response = array('success' => false,'msg' => '<p>Please upload csv or xlsx file only.</p>');
          echo json_encode($response);
          die;
        }

       }
     die;
    }

    public function sendMail($schedule_id,$send_reminder = null, $reminder_type = null)
    {

      $schedule = TableRegistry::get('Schedule');
      $user = TableRegistry::get('Users');
      $login_user = $this->Auth->user();
      $login_user = $user->find('all')->contain('Organizations')->where(['Users.id' => $login_user['id']])->first();
      $schedule_data = $schedule->find('all')->where(['id'=> $schedule_id])->first();

      if(!empty($schedule_data)){

        //decrypt schedule data
        $dec_email = !empty($schedule_data['email']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['email']),SEC_KEY) : '' ;

        $dec_phone = !empty($schedule_data['phone']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['phone']),SEC_KEY) : '' ;
        $dec_phone = trim(str_replace("-", "", $dec_phone));

        $dec_dob = !empty($schedule_data['dob']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['dob']),SEC_KEY) : '' ;

        $dec_first_name = !empty($schedule_data['first_name']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['first_name']),SEC_KEY) : '' ;

        $dec_appointment_time = $schedule_data['appointment_time'];
        $app_time = null;
        if(!empty($dec_appointment_time)){

          $dec_appointment_time = $this->CryptoSecurity->decrypt(base64_decode($schedule_data['appointment_time']),SEC_KEY);
          $temp_time = explode("-", $dec_appointment_time);
          $app_time = is_array($temp_time) ? (isset($temp_time[1]) ? trim($temp_time[1]) : $temp_time[0]) : trim($temp_time);
        }

        $org_url = !empty($login_user['organization']) ? $login_user['organization']['org_url'] :'';
        $link = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'users/register-front-user/'.base64_encode($schedule_id.'-E-'.time());
        $mlink = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'users/register-front-user/'.base64_encode($schedule_id.'-M-'.time());

        $user_detail_data = $this->checkUserRegistered($schedule_data,1);
        if(!empty($user_detail_data['error'])){

          $this->Flash->providererror($user_detail_data['error']);
          return $this->redirect(['action' => 'index']);
        }
        $user_data = $user_detail_data['user_detail'];
        if(!empty($user_data)){

          $schedule_slug = $schedule_id.'-'.time();
          //$link = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'users/new-appointment/'.base64_encode($schedule_slug);
          $link = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'dashboard/fill-appointment-link/'.base64_encode($user_data['id']).'/'.base64_encode($schedule_data['id']);

          $mlink = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'dashboard/fill-appointment-link/'.base64_encode($user_data['id']).'/'.base64_encode($schedule_data['id']);

          //$mlink = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'users/new-appointment/'.base64_encode($schedule_slug);
          $schedule_data->user_id = $user_data['id'];
          $schedule->save($schedule_data);
        }
        $username = 'user';
        if(!empty($schedule_data->first_name)){

          $username = $dec_first_name;
        }

        $clinic_name = 'clinic';
        $org_logo = WEBROOT."images/logo.png";
        if(!empty($login_user['organization'])){

          $clinic_name = $login_user['organization']['organization_name'];
          if(!empty($login_user['organization']['clinic_logo'])){

            $org_logo = WEBROOT.'img/'.$login_user['organization']['clinic_logo'];

          }
          
        }

        if(!empty($schedule_data->email)){

          $mailData = array();
          $mailData['provider_id'] = $login_user['id'];
          $mailData['username'] = $username;

          if($reminder_type == 'telehealth'){

            $mailData['slug'] = 'telehealth_reminder';
            $mailData['replaceString'] = array('{username}','{time}','{clinic}','{logo}');
            $mailData['replaceData'] = array($username,$app_time,$clinic_name,$org_logo);
          }
          else{

            $mailData['slug'] = !empty($send_reminder) && $send_reminder == 1 ? 'pre_appointment_reminder' : 'pre_appointment_form_link';
            $mailData['replaceString'] = array('{username}','{link}','{clinic}','{logo}');
            $mailData['replaceData'] = array($username,$link,$clinic_name,$org_logo);
          }
          $mailData['email'] = $dec_email;

         try{
            $this->ProviderMailSend->send( $mailData);

          }catch(\Exception $e){

            // $this->Flash->error('Internal server error. Please try again.');
            // return $this->redirect(['action' => 'index']);
          }

        }

        if(!empty($schedule_data['phone'])){

          if($reminder_type == 'telehealth')
          {

            $textData['slug'] = 'telehealth_reminder';
            $textData['phone'] = $dec_phone;
            $textData['replaceString'] = array('{username}','{time}','{clinic}');
            $textData['replaceData'] = array($username,$app_time,$clinic_name);
            $textData['provider_id'] = $login_user['id'];
            $this->TextMsgSend->send( $textData);

          }
          else{

            $textData['slug'] = !empty($send_reminder) && $send_reminder == 1 ? 'pre_appointment_reminder' : 'pre_appointment_form_link';
            $textData['phone'] = $dec_phone;
            $textData['replaceString'] = array('{username}','{link}','{clinic}');
            $textData['replaceData'] = array($username,$mlink,$clinic_name);
            $textData['provider_id'] = $login_user['id'];
            $this->TextMsgSend->send( $textData);
          }
        }

        if($schedule_data->status == 0){

          $schedule_data->status = 1;
        }
        if($schedule->save($schedule_data)){


          if($reminder_type == 'telehealth')
          {

            $this->Flash->providersuccess(__('Telehealth appointment time reminder sent successfully.'));
          }
          else{

            if(!empty($send_reminder) && $send_reminder == 1){

              $this->Flash->providersuccess(__('Pre-Appointment form reminder send successfully.'));

            }
            else{

              $this->Flash->providersuccess(__('Pre-Appointment form sent successfully.'));

            }
          }

          return $this->redirect(['action' => 'index']);
        }

        $this->Flash->providererror(__('Something went wrong, please try again.'));
        return $this->redirect(['action' => 'index']);
      }

      $this->Flash->providererror(__('Invalid schedule id'));
      return $this->redirect(['action' => 'index']);
      //echo $schedule_id;die('ZXczx');
    }

    public function pastschedule(){

      $this->viewBuilder()->setLayout('provider');
        $schedule = TableRegistry::get('Schedule');
        $columnSettingTbl = TableRegistry::get('ProviderDisplayColumns');
        $userTlb = TableRegistry::get('Users');
        //die('xcXC');
        $month = $this->request->getQuery('month');
        $year =  $this->request->getQuery('year');
        if(empty($month)){

          $month = date('m');
        }

        if(empty($year)){

          $year = date('Y');
        }

        $login_user = $this->Auth->user();

        $display_columns = $columnSettingTbl->find('list',['keyField' => 'field_name','valueField' => 'is_show'])->where(['provider_id' => $login_user['id']])->toArray();

        $user = $userTlb->find('all')->where(['id' => $login_user['id']])->first();

        $apt_cond = array();

        $apt_cond[] = array('Month(Schedule.appointment_date) ' => $month);

        $apt_cond[] = array('Year(Schedule.appointment_date) ' => $year);

       // $current_date = new \DateTime("now", new \DateTimeZone('CST') );
      //  $current_date = $current_date->format('Y-m-d');

        $apt_cond[] = array('Date(Schedule.appointment_date) <>' => date('Y-m-d'));
        $schedule_data = $schedule->find('all')->where($apt_cond)->where(['Schedule.organization_id' => $login_user['organization_id'],'Schedule.provider_id' => $login_user['id']])->order(['Schedule.appointment_date'=>'DESC','Schedule.id' => 'DESC'])->contain(['Doctors','Users'])->toArray();
          
        $schedule_data = $this->convertAppointmentTime($schedule_data,$login_user['id']);
        $temp_scheduled_data = array();
        foreach ($schedule_data as $key => $value) {

          $date = date('Y-m-d',strtotime($value['appointment_date']));
          $temp_scheduled_data[$date][] = $value;
        }

          //pr($temp_scheduled_data);die;

       $this->set(compact('temp_scheduled_data','month','year','display_columns','user'));
    }

   public function viewNote(){

       $this->autoRender = false;
       $schedule = TableRegistry::get('Schedule');
       $this->loadModel('Users');
       $login_user = $this->Auth->user();
       $login_user_data = $this->Users->find('all')->where(['id' => $login_user['id']])->first();
       $input = $this->request->data();

       if(isset($input['schedule_id']) && !empty($input['schedule_id'])){

         $schedule_data = $schedule->find('all')->where(['id'=> $input['schedule_id']])->first();

         if(!empty($schedule_data)){

            $apt_id = $schedule_data->appointment_id;
            $dec_mrn = $schedule_data['mrn'];
            if(!empty($dec_mrn)){
              $dec_mrn = $this->CryptoSecurity->decrypt(base64_decode($schedule_data['mrn']),SEC_KEY);
            }

            if(!empty($schedule_data->appointment_id) && !empty($schedule_data->user_id) && $schedule_data['status'] ==  3){

              if($login_user_data->note_formating == 'full'){

                $note = json_encode($this->General->ipc_note_detail($schedule_data['user_id'],$apt_id));
                echo $note;die;
              }
              else{

                $note = json_encode($this->General->note_detail_in_open_emr_format($schedule_data['user_id'],$apt_id,$dec_mrn,$login_user_data->note_formating));
                echo $note;die;
              }

            }
         }
       }
       die;
   }


     public function copyNote(){

       $this->autoRender = false;
       $note = "No data";
       $login_user = $this->Auth->user();
       $this->loadModel('Users');
       $login_user_data = $this->Users->find('all')->where(['id' => $login_user['id']])->first();

       $input = $this->request->data();

       if(isset($input['schedule_id']) && !empty($input['schedule_id'])){

         $schedule = TableRegistry::get('Schedule');

         $schedule_data = $schedule->find('all')->where(['id'=> $input['schedule_id']])->first();

         if(!empty($schedule_data)){

            $this->loadModel('ChiefCompliantUserdetails');

            $apt_id = $schedule_data->appointment_id;
            $dec_mrn = $schedule_data['mrn'];
            if(!empty($dec_mrn)){

              $dec_mrn = $this->CryptoSecurity->decrypt(base64_decode($schedule_data['mrn']),SEC_KEY);
            }

            if(!empty($schedule_data->appointment_id) && !empty($schedule_data->user_id) && $schedule_data['status'] ==  3){

              if($login_user_data->note_formating == 'full'){

                $note_data = $this->General->ipc_note_detail($schedule_data['user_id'],$apt_id,$dec_mrn);
                $note = $note_data['patient_medical_detail'];

              }else{

                $note_data = $this->General->note_detail_in_open_emr_format($schedule_data['user_id'],$apt_id,$schedule_data['mrn'],$login_user_data->note_formating);
               // $note = $note_data['Documents'][0]['DocumentSections'][0]['IdentifierText'];
                $note = $note_data['note'];
              }
            }

         }

       }

      echo $note;die;
   }

   /*public function viewIpc(){

       $this->autoRender = false;
       $login_user = $this->Auth->user();
       $this->loadModel('Users');
       $login_user_data = $this->Users->find('all')->where(['id' => $login_user['id']])->first();
       //pr($login_user_data);die;
        $note = json_encode(array('patient_basic_detail' => 'No data','patient_medical_detail' => 'No data'));
       $input = $this->request->data();
       if(isset($input['schedule_id']) && !empty($input['schedule_id'])){

         $schedule = TableRegistry::get('Schedule');
         $schedule_data = $schedule->find('all')->where(['id'=> $input['schedule_id']])->first();

        if(!empty($schedule_data)){

            $this->loadModel('ChiefCompliantUserdetails');
            $apt_id = $schedule_data->appointment_id;
            $dec_mrn = $schedule_data['mrn'];
            if(!empty($dec_mrn)){

              $dec_mrn = $this->CryptoSecurity->decrypt(base64_decode($schedule_data['mrn']),SEC_KEY);
            }

            if(!empty($schedule_data->appointment_id) && !empty($schedule_data->user_id) && $schedule_data['status'] ==  3){
              $note = json_encode($this->General->ipc_note_detail($schedule_data['user_id'],$apt_id));
            }
        }
      }

    echo $note;  die;
   }*/


   public function printPdf(){

      $note = "No data";
      $input = $this->request->data();
      $note = "";

       $input = $this->request->data();

       if(isset($input['schedule_id']) && !empty($input['schedule_id'])){

         $schedule = TableRegistry::get('Schedule');

         $schedule_data = $schedule->find('all')->where(['id'=> $input['schedule_id']])->first();

         if(!empty($schedule_data)){

            $this->loadModel('ChiefCompliantUserdetails');

            $apt_id = $schedule_data->appointment_id;
            $dec_mrn = $schedule_data['mrn'];
            if(!empty($dec_mrn)){

              $dec_mrn = $this->CryptoSecurity->decrypt(base64_decode($schedule_data['mrn']),SEC_KEY);
            }

            if(!empty($schedule_data->appointment_id) && !empty($schedule_data->user_id) && $schedule_data['status'] ==  3){
              $note_data = $this->General->note_detail_in_open_emr_format($schedule_data['user_id'],$apt_id,$dec_mrn);

              //$note = $note_data['Documents'][0]['DocumentSections'][0]['IdentifierText'];
              $note = $note_data['note'];
              $note .=  "DAST-10 details :\n".$note_data['dast_summary'];
              $note .=  "\nPADT details :\n".$note_data['padt_description'];
              $note = str_replace("<strong>", "", $note);
              $note = str_replace("</strong>", "", $note);
              $note = str_replace("&nbsp;", " ", $note);
              //echo $note;die;
            }

         }

         $filename = 'schedulenote'.$input['schedule_id'];

       }else{

        $filename = 'schedulenote';
       }


      // Include autoloader for dompdf
      require_once (ROOT . DS . 'vendor' . DS . 'dompdf' . DS . 'autoload.inc.php');

      $this->viewBuilder()->setLayout('ajax');
      $this->set('note', $note);
      $note_content = $this->render('/Email/html/note_pdf');
      $dompdf = new Dompdf();
      $dompdf->loadHtml($note_content);
      $dompdf->setPaper('A3', 'portrait');
      $dompdf->render();
      $output = $dompdf->output();
      $filename = $filename.'_'.time().'.pdf';
      file_put_contents(dompdfPath."/webroot/uploads/schedule_pdf/".$filename, $output);

      $url = WEBROOT."uploads/schedule_pdf/".$filename;

      $response = array('success' => true,'url' => $url);
      $this->General->userActivity(['action_performed' => 4, 'user_id' => $this->Auth->user('id'), 'pdf' =>$filename]);
      echo json_encode($response);
      die;

   }


   public function sendAll($provider_config, $schedule_ids){
    $this->autoRender = false;

    if(empty($schedule_ids)){
      return;
    }

    $login_user = $this->Auth->user();
    $schedule = TableRegistry::get('Schedule');
    $userTlb = TableRegistry::get('Users');
    $this->loadModel('ProviderEmailTemplates');
    $this->loadModel('SentMails');
    $login_user = $userTlb->find('all')->contain('Organizations')->where(['Users.id' => $login_user['id']])->first();
    $schedule_data = $schedule->find('all')->where(['id IN' =>$schedule_ids,'status !=' => 3])->order(['id' => 'desc']);
    $schedule_data = $schedule_data->group('email')->toList();

    $telehealth_emailTemplates = $this->ProviderEmailTemplates->find('all')->where(['slug' =>'telehealth_reminder', 'provider_id' => $login_user['id']])->first();

    $intake_emailTemplates = $this->ProviderEmailTemplates->find('all')->where(['slug' =>'pre_appointment_reminder', 'provider_id' => $login_user['id']])->first();



    if(count($schedule_data) > 0){

      foreach ($schedule_data as $key => $value) {

        //decrypt schedule data
        $dec_email = $value['email'];


        if(!empty($dec_email)){

           $dec_email = $this->CryptoSecurity->decrypt(base64_decode($value['email']),SEC_KEY);
        }

        $dec_phone = $value['phone'];
        if(!empty($dec_phone))
        {

          $dec_phone = $this->CryptoSecurity->decrypt(base64_decode($value['phone']),SEC_KEY);
          $dec_phone = trim(str_replace("-", "", $dec_phone));
        }


        $dec_dob = $value['dob'];
        if(!empty($dec_dob)){

          $dec_dob = $this->CryptoSecurity->decrypt(base64_decode($value['dob']),SEC_KEY);
        }

        $dec_first_name = $value['first_name'];

        if(!empty($dec_first_name)){

          $dec_first_name = $this->CryptoSecurity->decrypt(base64_decode($value['first_name']),SEC_KEY);
        }

        $dec_appointment_time = $value['appointment_time'];
        $app_time = null;
        if(!empty($dec_appointment_time)){

          $dec_appointment_time = $this->CryptoSecurity->decrypt(base64_decode($value['appointment_time']),SEC_KEY);
          $temp_time = explode("-", $dec_appointment_time);
          $app_time = is_array($temp_time) ? (isset($temp_time[1]) ? trim($temp_time[1]) : $temp_time[0]) : trim($temp_time);
        }

        $user_detail_data = $this->checkUserRegistered($value,1);
        $user_data = $user_detail_data['user_detail'];
        $org_url = '';
        if(!empty($login_user['organization'])){

          $org_url = $login_user['organization']['org_url'];
        }

      $link = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'users/register-front-user/'.base64_encode($value['id'].'-E-'.time());
      $mlink = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'users/register-front-user/'.base64_encode($value['id'].'-M-'.time());

      if(!empty($user_data)){

          $link = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'dashboard/fill-appointment-link/'.base64_encode($user_data['id']).'/'.base64_encode($value['id']);

          $mlink = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'dashboard/fill-appointment-link/'.base64_encode($user_data['id']).'/'.base64_encode($value['id']);

          $value->user_id = $user_data['id'];
          $schedule->save($value);
      }

      $username = 'user';
      if(!empty($value['first_name'])){

        $username = $dec_first_name;

      }

      $clinic_name = 'clinic';
      if(!empty($login_user['organization'])){

        $clinic_name = $login_user['organization']['organization_name'];
      }

      $check_telehealth_data = $this->General->checkTelehealthAppointmentData($login_user['id'],$login_user['organization_id'],$value);


      if(!empty($provider_config)){

        //send telehealth reminder
        if($provider_config['telehealth_cvs_upload_reminder'] == 1 && $check_telehealth_data && !empty($telehealth_emailTemplates) && (!empty($dec_email) || !empty($dec_phone)))
        {

            $sent_mail = $this->SentMails->newEntity();
            if(!empty($dec_email)){

              $checExistMail = $this->SentMails->find('all')->where(['to_mail' =>$dec_email,'is_sent' =>0,'slug' =>'telehealth_reminder','organization_id' => $login_user['organization_id']])->first();
              if(empty($checExistMail)){

                  $sent_mail->content = str_replace(['{username}','{time}','{clinic}'], [$username,$app_time,$clinic_name], $telehealth_emailTemplates['description']);
                  $sent_mail->content = str_replace("at .", ".", $sent_mail->content);
                  $sent_mail->subject = $telehealth_emailTemplates['subject'];
                  $sent_mail->to_mail =  $dec_email;
                  $sent_mail->slug =  $telehealth_emailTemplates['slug'];
                  $sent_mail->organization_id = $login_user['organization_id'];
              }
            }

            if(!empty($dec_phone)){

              $checExistPhone = $this->SentMails->find('all')->where(['phone' =>$dec_phone,'is_sent' =>0,'slug' =>'telehealth_reminder','organization_id' => $login_user['organization_id']])->first();
              if(empty($checExistPhone)){

                $sent_mail->text_message = str_replace(['{username}','{time}','{clinic}'], [$username,$app_time,$clinic_name], $telehealth_emailTemplates['text_message']);

                $sent_mail->text_message = str_replace("at .", ".", $sent_mail->text_message);
                $sent_mail->phone = $dec_phone;
                $sent_mail->slug =  $telehealth_emailTemplates['slug'];
                $sent_mail->organization_id = $login_user['organization_id'];
              }
            }
            $this->SentMails->save($sent_mail);

        }

        //send patient intake reminder
        if($provider_config['patient_intake_cvs_upload_reminder'] == 1 && !empty($intake_emailTemplates) && (!empty($dec_email) || !empty($dec_phone))){

            $sent_mail = $this->SentMails->newEntity();
            if(!empty($dec_email)){

              $checExistMail = $this->SentMails->find('all')->where(['to_mail' =>$dec_email,'is_sent' =>0,'slug' =>'pre_appointment_reminder','organization_id' =>$login_user['organization_id']])->first();

              if(empty($checExistMail)){

                $sent_mail->content = str_replace(['{username}','{link}','{clinic}'], [$username,$link,$clinic_name], $intake_emailTemplates['description']);
                $sent_mail->subject = $intake_emailTemplates['subject'];
                $sent_mail->to_mail =  $dec_email;
                $sent_mail->slug =  $intake_emailTemplates['slug'];
                $sent_mail->organization_id = $login_user['organization_id'];

              }
            }

            if(!empty($dec_phone)){

               $checExistPhone = $this->SentMails->find('all')->where(['phone' =>$dec_phone,'is_sent' =>0,'slug' =>'telehealth_reminder','organization_id' => $login_user['organization_id']])->first();
              if(empty($checExistPhone)){

                  $sent_mail->text_message = str_replace(['{username}','{link}','{clinic}'], [$username,$mlink,$clinic_name], $intake_emailTemplates['text_message']);
                  $sent_mail->phone = $dec_phone;
                  $sent_mail->slug =  $intake_emailTemplates['slug'];
                  $sent_mail->organization_id = $login_user['organization_id'];
              }
            }

            $this->SentMails->save($sent_mail);

        }
      }

      if($value->status == 0){

        $value->status = 1;
      }

      $schedule->save($value);

      }

    }
   }

   public function remindAll(){
    $this->autoRender = false;

    $reminder_type = $this->request->getData('type');
    $login_user = $this->Auth->user();
    $schedule = TableRegistry::get('Schedule');
    $userTlb = TableRegistry::get('Users');
    $login_user = $userTlb->find('all')->contain('Organizations')->where(['Users.id' => $login_user['id']])->first();
    $schedule_data = $schedule->find('all')->where(['Date(appointment_date)' => date('Y-m-d')])->where(['organization_id' =>$login_user['organization_id'],'status != ' => 3,'provider_id' => $login_user['id']])->group('email')
    //->sql();
    ->toList();



    if(count($schedule_data) > 0){

      foreach ($schedule_data as $key => $value) {

        //decrypt schedule data
        $dec_email = $value['email'];
        if(!empty($dec_email)){

          $dec_email = $this->CryptoSecurity->decrypt(base64_decode($value['email']),SEC_KEY);
        }

        $dec_phone = $value['phone'];
        if(!empty($dec_phone))
        {

          $dec_phone = $this->CryptoSecurity->decrypt(base64_decode($value['phone']),SEC_KEY);
          $dec_phone = trim(str_replace("-", "", $dec_phone));
        }


        $dec_dob = $value['dob'];
        if(!empty($dec_dob)){

          $dec_dob = $this->CryptoSecurity->decrypt(base64_decode($value['dob']),SEC_KEY);
        }

        $dec_first_name = $value['first_name'];

        if(!empty($dec_first_name)){

          $dec_first_name = $this->CryptoSecurity->decrypt(base64_decode($value['first_name']),SEC_KEY);
        }

        $dec_appointment_time = $value['appointment_time'];
        $app_time = null;
        if(!empty($dec_appointment_time)){

          $dec_appointment_time = $this->CryptoSecurity->decrypt(base64_decode($value['appointment_time']),SEC_KEY);
          $temp_time = explode("-", $dec_appointment_time);
          $app_time = is_array($temp_time) ? (isset($temp_time[1]) ? trim($temp_time[1]) : $temp_time[0]) : trim($temp_time);
        }

        $user_detail_data = $this->checkUserRegistered($value,1);
        $user_data = $user_detail_data['user_detail'];

        $org_url = '';
        if(!empty($login_user['organization'])){

          $org_url = $login_user['organization']['org_url'];
        }

       $link = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'users/register-front-user/'.base64_encode($value['id'].'-E-'.time());
       $mlink = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'users/register-front-user/'.base64_encode($value['id'].'-M-'.time());


      if(!empty($user_data)){

          $link = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'dashboard/fill-appointment-link/'.base64_encode($user_data['id']).'/'.base64_encode($value['id']);

          $mlink = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'dashboard/fill-appointment-link/'.base64_encode($user_data['id']).'/'.base64_encode($value['id']);

          if(empty($value['user_id'])){

            $value->user_id = $user_data['id'];
            $schedule->save($value);
          }
      }

      $username = 'user';

      if(!empty($value['first_name'])){

        $username = $dec_first_name;

      }

      $clinic_name = 'clinic';
      $org_logo = WEBROOT."images/logo.png";
      if(!empty($login_user['organization'])){

        $clinic_name = $login_user['organization']['organization_name'];
        if(!empty($login_user['organization']['clinic_logo'])){

          $org_logo = WEBROOT.'img/'.$login_user['organization']['clinic_logo'];

        }
      }

      $check_telehealth_data = $this->General->checkTelehealthAppointmentData($login_user['id'],$login_user['organization_id'],$value);

      if(!empty($value['email'])){

        if($reminder_type == 'telehealth' && $check_telehealth_data)
        {

          $mailData = array();
          $mailData['provider_id'] = $login_user['id'];
          $mailData['username'] = $username;
          $mailData['slug'] = 'telehealth_reminder';
          $mailData['email'] = $dec_email;
          $mailData['replaceString'] = array('{username}','{time}','{clinic}','{logo}');
          $mailData['replaceData'] = array($username,$app_time,$clinic_name,$org_logo);
          $message = 'Remind all for telehealth appointment time reminder sent successfully.';
        }
        else{

          $mailData = array();
          $mailData['provider_id'] = $login_user['id'];
          $mailData['username'] = $username;
          $mailData['slug'] = 'pre_appointment_reminder';
          $mailData['email'] = $dec_email;
          $mailData['replaceString'] = array('{username}','{link}','{clinic}','{logo}');
          $mailData['replaceData'] = array($username,$link,$clinic_name,$org_logo);
          $message = 'Remind all for pre-appointment link sent successfully.';

        }
       try{

          $this->ProviderMailSend->send( $mailData );

        }catch(\Exception $e){

          // $this->Flash->error('Internal server error. Please try again.');
          // return $this->redirect(['action' => 'index']);
        }

      }

      if(!empty($value['phone'])){

        if($reminder_type == 'telehealth' && $check_telehealth_data)
        {

          $message = 'Remind all for telehealth appointment time reminder sent successfully.';
          $textData['slug'] = 'telehealth_reminder';
          $textData['phone'] = $dec_phone;
          $textData['replaceString'] = array('{username}','{time}','{clinic}');
          $textData['replaceData'] = array($username,$app_time,$clinic_name);
          $textData['provider_id'] = $login_user['id'];
          $this->TextMsgSend->send( $textData);

        }
        else
        {

          $message = 'Remind all for pre-appointment link sent successfully.';
          $textData['slug'] = 'pre_appointment_reminder';
          $textData['phone'] = $dec_phone;
          $textData['replaceString'] = array('{username}','{link}','{clinic}');
          $textData['replaceData'] = array($username,$mlink,$clinic_name);
          $textData['provider_id'] = $login_user['id'];
          $this->TextMsgSend->send( $textData);
        }
      }

      if($value->status == 0){

        $value->status = 1;
      }

      $schedule->save($value);

      }

      $this->Flash->providersuccess(__($message));
      return $this->redirect(['action' => 'index']);

    }

    $this->Flash->providererror(__('No data found.'));
    return $this->redirect(['action' => 'index']);

   }


   public function fillAppointmentForm($user_id, $schedule_id){

      $this->autoload = false;
      if(!empty($user_id) && !empty($schedule_id)){

        $user_id = base64_decode($user_id);
        $schedule_id = base64_decode($schedule_id);
        $this->Users = $this->loadModel('Users');
        $this->Schedules = $this->loadModel('Schedules');
        $this->Organizations = $this->loadModel('Organizations');


       // pr($login_user);
        $front_user = $this->Users->find('all')->where(['id' => $user_id])->first();
     // pr($front_user); die;
        $schedule = $this->Schedules->find('all')->where(['id' => $schedule_id])->first();
      // pr($schedule);
        $organization = $this->Organizations->find('all')->where(['id' => $schedule['organization_id']])->first();
        $clinic_color_scheme['general_title_color'] = !empty($organization['general_title_color']) ? $organization['general_title_color'] : '' ;
        $clinic_color_scheme['general_text_color'] = !empty($organization['general_text_color']) ? $organization['general_text_color'] : '' ;

        $clinic_color_scheme['heading_color'] = !empty($organization['heading_color']) ?  $organization['heading_color'] : '' ;
        $clinic_color_scheme['background_color'] = !empty($organization['background_color']) ? $organization['background_color'] : '' ;
        $clinic_color_scheme['dashboard_background_color'] = !empty($organization['dashboard_background_color']) ? $organization['dashboard_background_color'] : '' ;
        $clinic_color_scheme['text_color'] = !empty($organization['text_color']) ? $organization['text_color'] : '' ;
        $clinic_color_scheme['button_gradient_color1'] = !empty($organization['button_gradient_color1']) ? $organization['button_gradient_color1'] : '' ;
        $clinic_color_scheme['button_gradient_color2'] = !empty($organization['button_gradient_color2']) ? $organization['button_gradient_color2'] : '' ;
        $clinic_color_scheme['button_gradient_color3'] = !empty($organization['button_gradient_color3']) ? $organization['button_gradient_color3'] : '' ;

        $clinic_color_scheme['active_button_color'] = !empty($organization['active_button_color']) ? $organization['active_button_color'] : '' ;

        $clinic_color_scheme['hover_state_color'] = !empty($organization['hover_state_color']) ? $organization['hover_state_color'] : '' ;
        $clinic_color_scheme['active_state_color'] = !empty($organization['active_state_color']) ? $organization['active_state_color'] : '' ;


        $clinic_color_scheme['link_color'] = !empty($organization['link_color']) ? $organization['link_color'] : '' ;
        $clinic_color_scheme['link_hover_color'] = !empty($organization['link_hover_color']) ? $organization['link_hover_color'] : '' ;

        $clinic_color_scheme['appoint_box_bg_color'] = !empty($organization['appoint_box_bg_color']) ? $organization['appoint_box_bg_color'] : '' ;

        $clinic_color_scheme['appoint_box_button_color'] = !empty($organization['appoint_box_button_color']) ? $organization['appoint_box_button_color'] : '' ;
        $clinic_color_scheme['progress_bar_graphic'] = !empty($organization['progress_bar_graphic']) ? $organization['progress_bar_graphic'] : '' ;

        $clinic_color_scheme['clinic_logo'] = !empty($organization['clinic_logo']) ? $organization['clinic_logo'] : '' ;
        $clinic_color_scheme['clinic_logo_status'] = !empty($organization['clinic_logo_status']) ? $organization['clinic_logo_status'] : '' ;
        // print_r($clinic_color_scheme);exit;
        $session = $this->getRequest()->getSession();
        // $name = $session->read('User.name');
        $session->write([
          'clinic_color_scheme' => $clinic_color_scheme,
        ]);

        if(!empty($front_user) && !empty($schedule)){

          if(empty($schedule['user_id'])){
            //die('ere');
            $schedule->user_id = $front_user['id'];
            $this->Schedules->save($schedule);
          }

          //save data of provider logout in user activity table
          $this->General->userActivity(['action_performed' => 2, 'user_id' => $this->Auth->user('id')]);

          $front_user = $front_user->toArray();
          $this->Auth->setUser($front_user);

          //save data of patient login in user activity table
          $this->General->userActivity(['action_performed' => 1 ,'user_id' => $front_user['id']]);
          //pr($front_user); die;
          if(empty($front_user['city']) || empty($front_user['state']) || empty($front_user['zip']) || empty($front_user['clinical_race']) || empty($front_user['clinical_ethnicity']))
          {
            return $this->redirect(['controller' => 'users','action' => 'addAddress','prefix' => false , base64_encode($schedule['id'])]);
          }
          else
          {
          return $this->redirect(['controller' => 'users', 'action' => 'registeredUserQuestion', 'prefix' => false, base64_encode($schedule_id.'-'.time())]);
          }
          // return $this->redirect(['controller' => 'users', 'action' => 'newAppointment', 'prefix' => false, base64_encode($schedule_id.'-'.time())]);

        }



        $this->Flash->providererror(__('Could not proceed as user or schedule not found'));
        return $this->redirect($this->referer());
      }

      $this->Flash->providererror(__('Could not proceed as user or schedule not found'));
      return $this->redirect($this->referer());

   }


   public function registerUser($schedule_id = null, $patient_type = null, $gender = null){

    $this->autoload = false;

    if(!in_array($gender,[0,1,2])){

        $this->Flash->providererror(__('Invalid patient gender.'));
        return $this->redirect($this->referer());

    }
    else{

      $schedule_id = base64_decode($schedule_id);
      $this->loadModel('Schedules');
      $this->loadModel('Users');
      $this->loadModel('UserSignedDocs');
      $login_user = $this->Auth->user();
      $login_user = $this->Users->find('all')->where(['id' => $login_user['id']])->first();
      $schedule_data = $this->Schedules->find('all')->where(['id' => $schedule_id])->first();
      $user_detail = "";

      //pr($login_user);die;

      if(!empty($schedule_data)){

        //$is_saved = 1;

        if(empty($schedule_data['first_name']) || empty($schedule_data['last_name']) || empty($schedule_data['dob']))
        {

            $this->Flash->providererror(__('First name, last name and dob are required.'));
            return $this->redirect($this->referer());
        }

        $user_detail_data = $this->checkUserRegistered($schedule_data,1);
        if(!empty($user_detail_data['error'])){

          $this->Flash->providererror($user_detail_data['error']);
          return $this->redirect($this->referer());
        }

        if(!empty($user_detail_data['user_detail'])){

          if(!empty($schedule_data)){

              $this->Schedules->updateAll(['user_id' => $user_detail_data['user_detail']['id']],['id' => $schedule_data['id']]);
            }

          $user_detail = $user_detail_data['user_detail']->toArray();
          //save data of provider logout in user activities table
          $this->General->userActivity(['action_performed' => 2, 'user_id' => $login_user['id']]);

          $this->Auth->setUser($user_detail_data['user_detail']);
          //save data of patient login in user activities table
          $this->General->userActivity(['action_performed' => 1, 'user_id' => $user_detail_data['user_detail']['id']]);
          return $this->redirect(['controller' => 'users', 'action' => 'scheduledAppointments', 'prefix' => false]);
        }

        $this->Users->validator();
        $user = $this->Users->newEntity();
        $dec_phone =$this->CryptoSecurity->decrypt(base64_decode($schedule_data['phone']),SEC_KEY);
        $dec_phone =str_replace("-", '', $dec_phone);
        $enc_phone = base64_encode($this->CryptoSecurity->encrypt($dec_phone,SEC_KEY));
        $data = array(

          'role_id' => 2,
          'first_name'=> $schedule_data['first_name'],
          'last_name' => $schedule_data['last_name'],
          'phone' => $enc_phone,
          'email' => $schedule_data['email'],
          'dob' => $schedule_data['dob'],
          'organization_id' => $login_user['organization_id'],
          'gender' => $gender
        );
        $user = $this->Users->patchEntity($user, $data);
        if(!$user->errors()){

         if(isset($user->gender) && $user->gender !== '')
            $user->gender = base64_encode(Security::encrypt($user->gender, SEC_KEY)) ;

          if($record = $this->Users->save($user)){

            if(!empty($schedule_data) && isset($record['id'])){

              $this->Schedules->updateAll(['user_id' => $record->id],['id' => $schedule_data['id']]);
            }

            //save data of provider logout in user activities table
            $this->General->userActivity(['action_performed' => 2, 'user_id' => $login_user['id']]);
            $registerd_user = $this->Users->find('all')->where(['id' =>$record['id']])->first()->toArray();
            $this->Auth->setUser($registerd_user);

            //save data of patient login in user activities table
            $this->General->userActivity(['action_performed' => 1, 'user_id' => $record['id']]);
            $this->Flash->providersuccess(__('Thank you for registering with Allevia.'));
            return $this->redirect(['controller' => 'users', 'action' => 'scheduledAppointments', 'prefix' => false]);

          }
        }
        else 
        {
          $error_msg = [];
          foreach($user->errors() as $errors){
             if(is_array($errors)){
                foreach($errors as $error){
                            $error_msg[]    =   $error;
                        }
                         }else{
                        $error_msg[]    =   $errors;
                    }
                  }
                   if(!empty($error_msg)){
                    $this->Flash->error(__("Please fix the following error(s):".implode("\n \r", $error_msg))
                    );
                }
        }  

        //$this->Flash->providererror(__('Could not register as user.'));
        return $this->redirect($this->referer());
      }

      $this->Flash->providererror(__('Schedule not found'));
      return $this->redirect($this->referer());
    }

  }


  public function fillAppointmentLink($user_id, $schedule_id){

      $this->autoload = false;
      if(!empty($user_id) && !empty($schedule_id)){

        $user_id = base64_decode($user_id);
        $schedule_id = base64_decode($schedule_id);
        $this->Users = $this->loadModel('Users');
        $this->Schedules = $this->loadModel('Schedules');

       // pr($login_user);
        $front_user = $this->Users->find('all')->where(['id' => $user_id])->first();
     // pr($front_user); die;
        $schedule = $this->Schedules->find('all')->where(['id' => $schedule_id])->first();
      // pr($schedule);
        if(!empty($front_user) && !empty($schedule)){

          if(empty($schedule['user_id'])){
            //die('ere');
            $schedule->user_id = $front_user['id'];
            $this->Schedules->save($schedule);
          }

          $front_user = $front_user->toArray();
          $this->Auth->setUser($front_user);
          $activity['action_performed'] = 1;
          $activity['user_id'] = $front_user['id'];
          $this->General->userActivity($activity);
          $session = $this->getRequest()->getSession();
          $session->write('is_validate_editmedicalhistory',1);

          return $this->redirect(['controller' => 'users', 'action' => 'newAppointment', 'prefix' => false, base64_encode($schedule_id.'-'.time())]);

        }

        $this->Flash->providererror(__('Could not proceed as user or schedule not found'));
        return $this->redirect(['controller' => 'users', 'action' => 'login', 'prefix' => false]);
        //return $this->redirect($this->referer());
      }

      $this->Flash->providererror(__('Could not proceed as user or schedule not found'));
      return $this->redirect(['controller' => 'users', 'action' => 'login', 'prefix' => false]);
      //return $this->redirect($this->referer());

   }

  public function addPatient()
  {
    $this->viewBuilder()->setLayout('provider');
    $schedule = TableRegistry::get('Schedule');
    $this->loadModel('Users');
    $this->loadModel('Doctors');
    $login_user = $this->Auth->user();
    $login_user = $this->Users->find('all')->where(['id' => $login_user['id']])->first();
    $doctors = $this->Doctors->find('list',[
    'keyField' => 'id',
    'valueField' => 'doctor_name'
    ])->where(['organization_id' => $login_user['organization_id']])->toArray();
    $user = $this->Users->newEntity();
    if($this->request->is('post'))
    {
      $input = $this->request->data();
      $user = $this->Users->patchEntity($user, $this->request->data);
      //pr($input); die;
      if(empty($input['email']) && empty($input['phone']) && (empty($input['first_name']) || empty($input['last_name']) || empty($input['dob'])))
      {
        $this->set(array('user'=>$user, 'doctors' => $doctors));
        return $this->Flash->providererror(__('Email or mobile number or first name, last name and dob as tuple is required and must be unique.'));
        // return $this->redirect($this->referer());
      }

      $dob = explode("-", $input['dob']);
      $input['dob'] = $dob[2].'-'.$dob[0].'-'.$dob[1];

      if(!empty($input['appointment_date']))
      {
        $appointmentDate = explode("-",$input['appointment_date']);        
        $input['appointment_date'] = $appointmentDate[2].'-'.$appointmentDate[0].'-'.$appointmentDate[1];
      }
      else
      {
        $input['appointment_date'] = date('Y-m-d');
      }  
      
      // Convert Date in current time zone of proveider
      $appointment_date = $this->ApiGenaral->timezoneConverter($input['appointment_date'], 'CST', $this->timezone);
      $input['appointment_date'] = date("Y-m-d", strtotime($appointment_date));
      // End converting

      $enc_first_name = base64_encode($this->CryptoSecurity->encrypt($input['first_name'],SEC_KEY));
      $enc_last_name = base64_encode($this->CryptoSecurity->encrypt($input['last_name'],SEC_KEY));
      $enc_dob = base64_encode($this->CryptoSecurity->encrypt($input['dob'],SEC_KEY));
      $enc_email = base64_encode($this->CryptoSecurity->encrypt($this->request->data['email'],SEC_KEY));
      $enc_phone = base64_encode($this->CryptoSecurity->encrypt($this->request->data['phone'],SEC_KEY));
      $enc_gender = base64_encode(Security::encrypt($this->request->data['gender'], SEC_KEY)) ;
      $user_data = null;

      if(empty($input['email']) && empty($input['phone']) && (!empty($input['first_name']) && !empty($input['last_name']) && !empty($input['dob'])))
      {
        $filter = ['AND'=>
        ['first_name'=> $enc_first_name,
        'last_name' => $enc_last_name,
        "dob" => $enc_dob,
        // "gender" => $enc_gender,
        ["OR"=>[
        'email'=>"",
        'email IS NULL']
        ],
        ["OR"=>[
        'phone'=>"",
        'phone IS NULL']
        ]
        ]];

        $user_detail = $this->Users->find('all')->where($filter)->first();
        if(!empty($user_detail))
        {
          $user_data = $user_detail;
        }
      }
      elseif((isset($input['email']) && !empty($input['email'])) || (isset($input['phone']) && !empty($input['phone'])))
      {
        $or_filter_arr = array();
        if(isset($input['email']) && !empty($input['email']))
        {
          $or_filter_arr['email'] = $enc_email;
        }

        if(isset($input['phone']) && !empty($input['phone']))
        {
          $or_filter_arr['phone'] = $enc_phone;
        }
        $user_detail = $this->Users->find('all',array('order'=> array('id' => 'desc')))->where(['OR' =>$or_filter_arr])->toArray();
        //pr($user_detail); die;

        if(!empty($user_detail)){

          $is_valid_data = 0;

          foreach ($user_detail as $key => $value) {

            if($value->email == $enc_email && $value->phone == $enc_phone && $value->role_id == 2){

              $user_data = $value;
              $is_valid_data = 1;
            }
          }

          if($is_valid_data == 0){
            $this->set(array('user'=>$user, 'doctors' => $doctors));
            return $this->Flash->providererror(__('Email or phone number is already registered.'));
            // return $this->redirect($this->referer());
          }
        }
      }

      if(empty($user_data))
      {
        //save user data when user is not registered
        $this->request->data['role_id'] = 2;
        $this->request->data['email'] = $enc_email;
        $this->request->data['phone'] = $enc_phone;

        $user = $this->Users->patchEntity($user, $this->request->data);
        if(!$user->errors())
        {
            $user->first_name = $enc_first_name;
            $user->last_name = $enc_last_name;
            $user->gender = $enc_gender;
            $user->dob = $enc_dob;
            //$user->appointment_date = $input['appointment_date'];
            $user_data = $this->Users->save($user);
        }
      }

      if(!empty($user_data))
      {

        $save_data['first_name'] = $input['first_name'];
        $save_data['last_name'] = $input['last_name'];
        $save_data['gender'] = $input['gender'];
        $save_data['dob'] = $input['dob'];
        $save_data['mrn'] = $input['mrn'];
        $save_data['phone'] = $input['phone'];
        $save_data['email'] = $input['email'];
        $save_data['doctor_id'] = $input['doctor_id'];
        $save_data['appointment_date'] = $input['appointment_date'];
        if(!empty($input['appointment_reason']))
        {
          $save_data['appointment_reason'] = $input['appointment_reason'];
        }
        $save_data['provider_id'] = $login_user['id'];
        $save_data['organization_id'] = $login_user['organization_id'];


       // $save_data['appointment_date'] = $input['appointment_date'];
        $save_data['user_id'] = $user_data->id;
        if(!empty($input['doctor_id'])){

          $doctor_detail = $this->Doctors->find('all')->where(['id' => $input['doctor_id']])->first();
          if(!empty($doctor_detail)){

            $save_data['doctor_name'] = $doctor_detail->doctor_name;
          }
        }        

         $mrnCheck = $this->mrnVerify($login_user['organization_id'],$input['mrn'],$save_data);
         if($mrnCheck == 1)
         {
            // $this->Flash->providererror(__('Mrn already exists for another patient!'));
           //  return $this->redirect(['action' =>'index']);
               $this->set(array('user'=>$user, 'doctors' => $doctors));
               return $this->Flash->providererror(__('Mrn already exists for another patient!'));               
         }

        $checkAlreadyAppointment = $this->save_appointment_schedule_data($save_data);
        //pr($checkAlreadyAppointment); die;



        if(isset($checkAlreadyAppointment) && $checkAlreadyAppointment == 0)  //already appointemt scheduled
        {
          $this->Flash->providererror(__('This Appointment is already scheduleded.'));
          return $this->redirect(['action' =>'index']);
        }      

        if($checkAlreadyAppointment)
        {
          $this->Flash->providersuccess(__('Data saved successfully'));
          return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        else{
          $this->set(array('user'=>$user, 'doctors' => $doctors));
          return $this->Flash->providererror(__('Something went wrong, please try again.'));          
        }
      }
      else
      {
        $this->set(array('user'=>$user, 'doctors' => $doctors));
        return $this->Flash->providererror(__('Something went wrong, please try again.'));        
      }
    }
    $this->set(array('user'=>$user, 'doctors' => $doctors));
  }



  public function getspecializationfordoctor(){

      if($this->request->is(['ajax'])){
        $doc_id = $this->request->data['doctor_id'];

        $doc_detail = $this->Doctors->find('all')->where(['id'=>$doc_id])->first();
        if(!empty($doc_detail->specialization_id)){

          $specialization_id  = explode(',', $doc_detail->specialization_id);

        $specialization_data = $this->Specializations->find('all')->where(['id IN' => $specialization_id])->first();
        $intermediate_steps = explode(',', $specialization_data->intermediate_steps);
        $stepDetails = TableRegistry::get('step_details');
        $stepDetail_Data = $stepDetails->find('list',[ 'keyField' =>   function ($row) {
                                  return $row['intermediate_steps'] ;
                              },
                              'valueField' => 'step_name'
                        ])->where(['id IN' => $intermediate_steps])->toArray();
        echo json_encode($stepDetail_Data);
        }
        die;
    }
  }

  	public function telehealthAppointment(){

  		$this->autoRender = false;
  		$schedule_id = $this->request->getData('schedule_id');
  		$login_user = $this->Auth->user();
  		$this->loadModel('Users');
  		$this->loadModel('Organizations');
  		$this->loadModel('Schedule');
      $this->loadModel('GlobalSettings');
  		if(!empty($schedule_id)){

  			$schedule_data = $this->Schedule->find('all')->where(['id' => $schedule_id])->first();

  			if(!empty($schedule_data)){

  				//decrypt the schedule data
  				$first_name = !empty($schedule_data['first_name']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['first_name']),SEC_KEY) : "";
  				$last_name = !empty($schedule_data['last_name']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['last_name']),SEC_KEY) : "";
  				$email = !empty($schedule_data['email']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['email']),SEC_KEY) : "";
  				$phone = !empty($schedule_data['phone']) ? str_replace("-", "", $this->CryptoSecurity->decrypt(base64_decode($schedule_data['phone']),SEC_KEY)) : "";

  				$mrn = !empty($schedule_data['mrn']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['mrn']),SEC_KEY) : "";

  				//check schedule data is completed or not
  				if(!empty($first_name) && !empty($last_name) && (!empty($email) || !empty($phone))){

		    		$login_user = $this->Users->find('all')->where(['id' => $login_user['id']])->first();
		    		$org_data = $this->Organizations->find('all')->where(['id' => $login_user['organization_id']])->first();
            $api_key_data = env('callidus_api_key',"");
            if(empty($api_key_data)){

              $res = array('success' => false, 'error' =>'Api Key is invalid.');
              echo json_encode($res);
              die;
            }

		    		//check cl_group_id and ci_provider_id is exist
		    		if(!empty($org_data) && !empty($login_user) && $login_user['is_telehealth_provider'] == 1)
		    		{

		    			//send curn request for telehealth appointment
		    			$fields = array(
				  		"api_key" => $api_key_data->value,//"ec457d0a974c48d5685a7efa03d137dc8bbde7e3",
							"group_id" => $this->CryptoSecurity->decrypt(base64_decode($org_data['cl_group_id']),SEC_KEY),//$org_data['cl_group_id'],//"NFM1YndMaVI0N2pnejFlSlVva0hRUT09",
							"provider_id" => $this->CryptoSecurity->decrypt(base64_decode($login_user['cl_provider_id']),SEC_KEY),//"K0syUWhNeUdybzlMcTNsb3JIM0N1QT09",
							"patient_first_name" => $first_name,
							"patient_last_name" => $last_name,
							"patient_email" =>  $email,
							"patient_contact" => $phone,
							"patient_mrn" => $mrn
				  		);

				  		$body_param = json_encode($fields);
				  		$curl = curl_init();
						  curl_setopt_array($curl, array(
							CURLOPT_URL => "https://stagecarelink.callidushealth.com/api/v1/telemedicine_video",
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => "",
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 30,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => "POST",
							CURLOPT_POSTFIELDS => $body_param ,
							CURLOPT_HTTPHEADER => array(
							    'Content-Type: application/json'
							)
						));

						$response = curl_exec($curl);
						$err = curl_error($curl);
						curl_close($curl);

						if(!empty($response)){

							$result = json_decode($response);
							//pr($result);die;
							if($result->header->statusCode == 200){

								$schedule_data->telemed_encounter_id = $result->payload->telemed_encounter_id;
								$schedule_data->telehealth_video_url = $result->payload->video_url;
								$this->Schedule->save($schedule_data);
								$res = array('success' => true, 'video_url' => $result->payload->video_url);
								echo json_encode($res);
								die;
							}
							else{

								$res = array('success' => false, 'error' => $result->header->message);
								echo json_encode($res);
								die;
							}
						}
		    		}

		    		$res = array('success' => false, 'error' =>'cl group ID and cl provider ID is required.');
					echo json_encode($res);
					die;
  				}

  				$res = array('success' => false, 'error' =>'Patient first name, last name, email, phone number is required.');
				echo json_encode($res);
				die;
  			}

  			$res = array('success' => false, 'error' =>'Schedule data not found.');
			echo json_encode($res);
			die;
  		}

  		$res = array('success' => false, 'error' =>'Schedule data not found.');
		echo json_encode($res);
		die;
  	}


  	public function telehealthRecords(){

  		$this->viewBuilder()->setLayout('provider');
      $records = json_decode($this->getTelehealthRecords());
      $link = "";

      if($records->success){

        $link = $records->link;
      }
      else{

        $this->Flash->providererror($records->error);
        return $this->redirect(['action' => 'index']);
      }
      $this->set('link',$link);
  	}


  	public function getTelehealthRecords(){

  		//$this->viewBuilder()->setLayout('provider');
  		//$this->autoRender = false;
  		$login_user = $this->Auth->user();
  		$this->loadModel('Users');
  		$this->loadModel('Organizations');
      $this->loadModel('GlobalSettings');
  		$login_user = $this->Users->find('all')->where(['id' => $login_user['id']])->first();
		  $org_data = $this->Organizations->find('all')->where(['id' => $login_user['organization_id']])->first();
      $api_key_data = env('callidus_api_key',"");
      if(empty($api_key_data)){

        return json_encode(array('success' => false,'error'=> 'Api Key is invalid.'));
      }

		//check cl_group_id and ci_provider_id is exist
		if(!empty($org_data) && !empty($login_user) && $login_user['is_telehealth_provider'] == 1)
		{

			//send curn request for telehealth appointment
			$fields = array(

	  		"api_key" => $api_key_data->value,//"ec457d0a974c48d5685a7efa03d137dc8bbde7e3",
				"group_id" => $this->CryptoSecurity->decrypt(base64_decode($org_data['cl_group_id']),SEC_KEY),//"NFM1YndMaVI0N2pnejFlSlVva0hRUT09",
				"provider_id" =>  $this->CryptoSecurity->decrypt(base64_decode($login_user['cl_provider_id']),SEC_KEY)//"K0syUWhNeUdybzlMcTNsb3JIM0N1QT09",
	  		);

	  		$body_param = json_encode($fields);
	  		$curl = curl_init();
			  curl_setopt_array($curl, array(
				CURLOPT_URL => "https://stagecarelink.callidushealth.com/api/v1/telemedicine_records",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $body_param ,
				CURLOPT_HTTPHEADER => array(
				    'Content-Type: application/json'
				)
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			if(!empty($response)){

				$result = json_decode($response);
        if($result->header->statusCode == 200 && isset($result->payload)){

          return json_encode(array('success' => true,'link'=> $result->payload->record_link));
        }
        else{

          return json_encode(array('success' => false,'error'=> $result->header->message));
        }
			}
      return json_encode(array('success' => false,'error'=> 'Something went wrong, please try again.'));
		}

    return json_encode(array('success' => false,'error'=> 'cl group ID and cl provider ID is required.'));
		/*else{

      echo 'cl group ID and cl provider ID is required.';die;

		}*/
		die;
  	}

    public function save_appointment_schedule_data($detail,$validateflag = null){      

      if(!empty($detail) && is_array($detail)){

        $enc_last_name = isset($detail['last_name']) && !empty($detail['last_name']) ? base64_encode($this->CryptoSecurity->encrypt($detail['last_name'],SEC_KEY)) : '';

        $enc_first_name = isset($detail['first_name']) && !empty($detail['first_name']) ? base64_encode($this->CryptoSecurity->encrypt($detail['first_name'],SEC_KEY)) : '';

        $enc_gender = isset($detail['gender']) && ($detail['gender'] != '') ? base64_encode($this->CryptoSecurity->encrypt($detail['gender'],SEC_KEY)) : '';
        

        $enc_dob = isset($detail['dob']) && !empty($detail['dob']) ? base64_encode($this->CryptoSecurity->encrypt($detail['dob'],SEC_KEY)) : '';

        $enc_mrn = isset($detail['mrn']) && !empty($detail['mrn']) ? base64_encode($this->CryptoSecurity->encrypt($detail['mrn'],SEC_KEY)) : '';

        $enc_phone = isset($detail['phone']) && !empty($detail['phone']) ? base64_encode($this->CryptoSecurity->encrypt($detail['phone'],SEC_KEY)) : '';

        $enc_email = isset($detail['email']) && !empty($detail['email']) ? base64_encode($this->CryptoSecurity->encrypt(strtolower($detail['email']),SEC_KEY)) : '';

        $enc_appointment_time = isset($detail['appointment_time']) && !empty($detail['appointment_time']) ? base64_encode($this->CryptoSecurity->encrypt($detail['appointment_time'],SEC_KEY)) : '';

        $enc_doctor_name = isset($detail['doctor_name']) && !empty($detail['doctor_name']) ? base64_encode($this->CryptoSecurity->encrypt($detail['doctor_name'],SEC_KEY)) : '';

        $enc_appointment_reason = isset($detail['appointment_reason']) && !empty($detail['appointment_reason']) ? base64_encode($this->CryptoSecurity->encrypt($detail['appointment_reason'],SEC_KEY)) : '';
        $provider_id = isset($detail['provider_id']) && !empty($detail['provider_id']) ? $detail['provider_id'] : '';
        $doctor_id = isset($detail['doctor_id']) && !empty($detail['doctor_id']) ? $detail['doctor_id'] : '';
        $organization_id = isset($detail['organization_id']) && !empty($detail['organization_id']) ? $detail['organization_id'] : '';
        $user_id = isset($detail['user_id']) && !empty($detail['user_id']) ? $detail['user_id'] : '';

        //check for all required data
        if(empty($enc_phone) && empty($enc_email) && (empty($enc_last_name) || empty($enc_first_name) || empty($dob)) && (empty($provider_id) || empty($organization_id))){

          return 0;
        }

        // //echo date('d-m-Y h:i:s');die;
        // $str = date('d-m-Y h:i:s');
        // pr($str);
        // echo $this->ApiGenaral->timezoneConverter($str,'CST','MST');die;
        // $appointment_date = new \DateTime($str, new \DateTimeZone('MST') );
        // pr($appointment_date);die;
        $appointment_date = date('Y-m-d');
        $schedule_data = array(
          'last_name' => $enc_last_name,
          'first_name' => $enc_first_name,
          'gender' => $enc_gender,
          'email' => $enc_email,
          'dob' => $enc_dob,
          'mrn' => $enc_mrn,
          'phone' => $enc_phone,
          'appointment_time' => $enc_appointment_time,
          'appointment_reason' => $enc_appointment_reason,
          'doctor_name' => $enc_doctor_name,
          'appointment_date' => isset($detail['appointment_date']) ? $detail['appointment_date'] : $appointment_date,
          'provider_id' => $provider_id,
          'doctor_id' => $doctor_id,
          'organization_id' => $organization_id,
          'user_id' => $user_id
        );


        if(isset($enc_email) && !empty($enc_email))
        {
        $checkAlreadyScheduleData  = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['email' =>$enc_email,'appointment_date >=' => date('Y-m-d'),'organization_id' =>$organization_id])->first();

              if(empty($checkAlreadyScheduleData) || (!empty($checkAlreadyScheduleData) && $checkAlreadyScheduleData['status'] == 3)){
              $is_saved = 1;
              }
              else{
              //using email schedule is already in running state
              $is_saved = 0;
              }
        }
        elseif(isset($enc_phone) && !empty($enc_phone)){

                    $checkAlreadyScheduleData = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['phone' =>$enc_phone,'appointment_date >=' => date('Y-m-d'),'organization_id' =>$organization_id])->first();

                    if(empty($checkAlreadyScheduleData) || (!empty($checkAlreadyScheduleData) && $checkAlreadyScheduleData['status'] == 3)){
                      $is_saved = 1;
                    }
                    else{
                      //using phone number schedule is already running
                      $is_saved = 0;
                    }
        }
        elseif(isset($enc_first_name) && isset($enc_last_name) && isset($enc_dob)){

                      $checkAlreadyScheduleData = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['first_name' =>$enc_first_name,'last_name' => $enc_last_name,'dob' => $enc_dob,'appointment_date >=' => date('Y-m-d'),'organization_id' =>$organization_id])->first();

                      if(empty($checkAlreadyScheduleData) || (!empty($checkAlreadyScheduleData) && $checkAlreadyScheduleData['status'] == 3)){
                        $is_saved = 1;
                      }
                      else{
                       //using first name, last name, dob schedule is alredy running
                        $is_saved = 0;
                      }
        }

        $appoinmentData = array();

        if(!empty($checkAlreadyScheduleData && $is_saved == 0))
        {
           $appoinmentData['already_appointment'] =  $detail;
        }

        if($is_saved == 1)
        {
           $appoinmentData['schedule'] = $detail;
        }

        if($validateflag == 1)
        {
          return $appoinmentData;
        }


        if($is_saved == 1)
        {
          $entity = $this->Schedule->newEntity($schedule_data);
          $schedule = $this->Schedule->patchEntity($entity,$schedule_data);
          $result = $this->Schedule->save($schedule);
          if(isset($result->id)){
            return $result->id;
          }
        }
      }
      return 0;
    }

    function array_iunique( $array ) {
      return array_intersect_key(
          $array,
          array_unique( array_map( "strtolower", $array ))
      );
    }


    public function checkuniqueness($scheduleData)
    {
        $unique_save_data = array();
            $copy_save_data = $scheduleData;
            $unique_email = array_unique(array_column($copy_save_data, 'email'));
            $unique_email = $this->array_iunique($unique_email);
            if(!empty($unique_email)){
              $temp_save_data = array();
              foreach ($unique_email as $uni_email_key => $uni_email) {

                  foreach ($copy_save_data as $save_key => $save_value) {

                      if(isset($save_value['email']) && $save_value['email'] == $uni_email){
                        $temp_save_data[] = $save_value;
                        break;
                      }
                  }
              }
              $unique_save_data = $temp_save_data;
            }

            $temp_save_data = array();
            foreach ($copy_save_data as $no_email_key => $no_email_value) {

                if(!isset($no_email_value['email'])){

                  $temp_save_data[] = $no_email_value;
                }
            }
            if(!empty($temp_save_data)){
              $unique_save_data = array_merge($unique_save_data,$temp_save_data);
            }

            $copy_save_data = $unique_save_data;


            //check uniqueness based on mrn

            $unique_mrn = array_unique(array_column($copy_save_data, 'mrn'));
            $unique_mrn = $this->array_iunique($unique_mrn);
            if(!empty($unique_mrn)){
              $temp_save_data = array();
              foreach ($unique_mrn as $uni_mrn_key => $uni_mrn) {

                  foreach ($copy_save_data as $save_key => $save_value) {

                      if(isset($save_value['mrn']) && $save_value['mrn'] == $uni_mrn){
                        $temp_save_data[] = $save_value;
                        break;
                      }
                  }
              }
              $unique_save_data = $temp_save_data;
            }

            $temp_save_data = array();
            foreach ($copy_save_data as $no_mrn_key => $no_mrn_value) {

                if(!isset($no_mrn_value['mrn'])){

                  $temp_save_data[] = $no_mrn_value;
                }
            }
            if(!empty($temp_save_data)){
              $unique_save_data = array_merge($unique_save_data,$temp_save_data);
            }

            $copy_save_data = $unique_save_data;

            $unique_save_data = array();
          // pr($save_data);
            //check uniquesness based on phone
            $unique_phone = array_unique(array_column($copy_save_data, 'phone'));

            if(!empty($unique_phone)){
              $temp_save_data = array();
              foreach ($unique_phone as $uni_phone_key => $uni_phone) {

                foreach ($copy_save_data as $save_key => $save_value) {

                  if(isset($save_value['phone']) && $save_value['phone'] == $uni_phone){

                    $temp_save_data[] = $save_value;
                    if(isset($save_value['first_name']) && isset($save_value['last_name']) && isset($save_value['dob']))
                    {
                      $temp_save_data[count($temp_save_data)-1]['encoded'] = base64_encode($save_value['first_name'].$save_value['last_name'].$save_value['dob']);
                    }
                    break;
                  }
                }
              }
              $unique_save_data = $temp_save_data;
            }

            $temp_save_data = array();
            foreach ($copy_save_data as $no_phone_key => $no_phone_value) {

                  if(!isset($no_phone_value['phone'])){

                    $temp_save_data[] = $no_phone_value;
                    if(isset($no_phone_value['first_name']) && isset($no_phone_value['last_name']) && isset($no_phone_value['dob']))
                    {

                      $temp_save_data[count($temp_save_data)-1]['encoded'] = base64_encode($no_phone_value['first_name'].$no_phone_value['last_name'].$no_phone_value['dob']);
                    }
                  }
              }

              if(!empty($temp_save_data)){
                $unique_save_data = array_merge($unique_save_data,$temp_save_data);
              }
              $copy_save_data = $unique_save_data;
              $unique_save_data = array();

            //check uniquesness according first name, last name and dob as triple
            $unique_encode = array_unique(array_column($copy_save_data, 'encoded'));
           // pr($unique_encode);
            if(!empty($unique_encode)){
              $temp_save_data = array();
              foreach ($unique_encode as $unique_encode_key => $uni_encode) {

                foreach ($copy_save_data as $save_key => $save_value) {

                  if(!isset($save_value['email']) && !isset($save_value['phone']) && isset($save_value['encoded']) && $save_value['encoded'] == $uni_encode){

                    unset($save_value['encoded']);
                    $temp_save_data[] = $save_value;
                    break;
                  }
                }

              }
              $unique_save_data = $temp_save_data;
             // $temp_save_data = array();
            }

            $temp_save_data = array();
            //save data with email and phone
            foreach ($copy_save_data as $with_emailphone_key => $with_emailphone_value) {

                if(isset($with_emailphone_value['encoded'])){

                    unset($with_emailphone_value['encoded']);
                }

                if(isset($with_emailphone_value['phone']) || isset($with_emailphone_value['email'])){

                  $temp_save_data[] = $with_emailphone_value;
                }
            }

            if(!empty($temp_save_data)){

            return $unique_save_data = array_merge($unique_save_data,$temp_save_data);
            }
    }

    public function checkUserRegistered($detail, $is_encrypted = 0)
    {

      $this->loadModel('Users');
      $enc_phone = "";
      $enc_email = "";
      $enc_first_name = "";
      $enc_last_name = "";
      $enc_dob = "";
      $user_detail = "";
      $response = array();

      if(!$is_encrypted){

        $enc_phone = isset($detail['phone']) && !empty($detail['phone']) ? base64_encode($this->CryptoSecurity->encrypt(str_replace("-", "",$detail['phone']),SEC_KEY)) : '';
        $enc_email = isset($detail['email']) && !empty($detail['email']) ? base64_encode($this->CryptoSecurity->encrypt($detail['email'],SEC_KEY)) : '';

        $enc_first_name = isset($detail['first_name']) && !empty($detail['first_name']) ? base64_encode($this->CryptoSecurity->encrypt($detail['first_name'],SEC_KEY)) : '';
        $enc_last_name = isset($detail['last_name']) && !empty($detail['last_name']) ? base64_encode($this->CryptoSecurity->encrypt($detail['last_name'],SEC_KEY)) : '';
        $enc_dob = isset($detail['dob']) && !empty($detail['dob']) ? base64_encode($this->CryptoSecurity->encrypt(date('Y-m-d',strtotime($detail['dob'])),SEC_KEY)) : '';

      }
      else{

        $dec_phone =$this->CryptoSecurity->decrypt(base64_decode($detail['phone']),SEC_KEY);
        $dec_phone = str_replace("-", '', $dec_phone);
        $enc_phone = base64_encode($this->CryptoSecurity->encrypt($dec_phone,SEC_KEY));

        $enc_email = isset($detail['email']) && !empty($detail['email']) ? $detail['email'] : '';

        $enc_first_name = isset($detail['first_name']) && !empty($detail['first_name']) ? $detail['first_name'] : '';
        $enc_last_name = isset($detail['last_name']) && !empty($detail['last_name']) ? $detail['last_name'] : '';
        $enc_dob = isset($detail['dob']) && !empty($detail['dob']) ? date('Y-m-d',strtotime($detail['dob'])) : '';
      }
      //check patient is registered or not on allevia platform
      if((isset($detail['email']) && !empty($detail['email'])) || (isset($detail['phone']) && !empty($detail['phone']))){

          $filter = array();

          if(!empty($enc_email)){

             $filter['email'] = $enc_email;
          }

          if(!empty($enc_phone)){

             $filter['phone'] = $enc_phone;
          }

          $user_detail_all = $this->Users->find('all')->where(['OR'=> $filter])->toArray();
          //pr($user_detail_all);die;
          if(!empty($user_detail_all)){

              $user_valid = 0;
              foreach($user_detail_all as $all_user_key => $all_user_value){

                  if(($enc_email != '' && $all_user_value['email'] == $enc_email && $enc_phone != '' && $all_user_value['phone'] == $enc_phone) || ($enc_email == '' && $enc_phone != '' && $all_user_value['phone'] == $enc_phone) || ($enc_email != '' && $all_user_value['email'] == $enc_email && $enc_phone == '')){

                      $user_detail = $all_user_value;
                      $user_valid = 1;
                      break;
                  }
              }

              if(!$user_valid){

                $response = array('user_detail' => '','error' => 'Invalid data');

              }
          }
      }
      elseif(empty($detail['email']) && empty($detail['phone']) && (!empty($detail['first_name']) && !empty($detail['last_name']) && !empty($detail['dob'])))
      {

          $filter = ['AND'=>
                        ['first_name'=> $enc_first_name,
                        'last_name' => $enc_last_name,
                        "dob" => $enc_dob,
                        ["OR"=>[
                          'email'=>"",
                          'email IS NULL']
                        ],
                        ["OR"=>[
                          'phone'=>"",
                          'phone IS NULL']
                        ]
                      ]];
          $user_detail = $this->Users->find('all')->where($filter)->first();
      }
      //pr($user_detail);die;

      //check user detail is patient detail or not
      if(!empty($user_detail)){

        if($user_detail['role_id'] != 2){

          $response = array('user_detail' => '','error' => 'User is registered as admin or provider');
        }
        else{

          $response = array('user_detail' => $user_detail,'error' => '');
        }
      }
      else{

        $response = array('user_detail' => '','error' => '');
      }

      return $response;
    }

    public function firstlogintour()
    {
       $this->autoRender = false;
       $login_user = $this->Auth->user();
       $this->Users = $this->loadModel('Users');
       if($this->request->is(['ajax'])){
         $updated = $this->Users->updateAll(['is_start_tour' => 1],['id' => $login_user['id']]);
         $response = array('success' => true,'status' => $updated);
         echo json_encode($response);
         die;
       }
    }

    public function convertAppointmentTime($schedule_data,$user_id){

      
      $provider_config_detail = $this->ProviderGlobalSettings->find('all')->where(['provider_id' => $user_id])->first();

      $timezone = !empty($provider_config_detail) ? $provider_config_detail['timezone'] : "CST";

      if(!empty($schedule_data)){

          foreach ($schedule_data as $key => $value) {
            
            
            $appointment_time = $value->appointment_time;
           // pr($value['id']." ".$appointment_time);
            if(!empty($appointment_time)){

                $appointment_time = $this->CryptoSecurity->decrypt(base64_decode($appointment_time),SEC_KEY);
            }

            if($timezone != 'CST'){

              $appointment_date = $value->appointment_date;
              $appointment_date_time = $appointment_date;
              $end_time = "";

              //merge date and time
              if(!empty($appointment_time)){

                $temp_time = explode("-", $appointment_time);
                $start_time = !empty($temp_time) && isset($temp_time[0]) ? $temp_time[0] : "";
                $temp_end_time = !empty($temp_time) && isset($temp_time[1]) ? $temp_time[1] : "";

                if(!empty($start_time)){

                  $hours = date('H',strtotime($start_time));
                  $mintus = date('i',strtotime($start_time));
                  $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$hours.'hours'));
                  $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$mintus.'minutes'));
                }

                $appointment_date_time = $this->ApiGenaral->timezoneConverter($appointment_date_time, 'CST', $timezone);

                $appointment_date = date('Y-m-d',strtotime($appointment_date_time));
                $appointment_time = date('h:i A',strtotime($appointment_date_time));
                $value->appointment_date = $appointment_date;

                if(!empty($temp_end_time)){

                  $hours = date('H',strtotime($temp_end_time));
                  $mintus = date('i',strtotime($temp_end_time));
                  $temp_appointment_date = date('Y-m-d H:i',strtotime($appointment_date.' +'.$hours.'hours'));
                  $temp_appointment_date = date('Y-m-d H:i',strtotime($temp_appointment_date.' +'.$mintus.'minutes'));

                  $temp_appointment_date = $this->ApiGenaral->timezoneConverter($temp_appointment_date, 'CST', $timezone);
                  $end_time = date('h:i A',strtotime($temp_appointment_date));
                }
              }

              if($end_time){

                $appointment_time = $appointment_time." - ".$end_time;
              }              
            }
            $value->appointment_time = $appointment_time;
            $schedule_data[$key] = $value;
          }
        }

        return $schedule_data;
    }

    public function getDateTime($curtimezone = 'CST', $converttimezone = 'CST', $time = ""){

      // pr($curtimezone,' curtimezone');
      // pr($converttimezone, ' converttimezone');
      //$appointment_date = new \DateTime("now", new \DateTimeZone($curtimezone));
      //$appointment_date = $appointment_date->format('Y-m-d');
      $appointment_date = date('Y-m-d');
     // pr('time  '.$time);
      $appointment_time = "";
      //combine appointment date and time
      if(!empty($time)){

        $temp_time = explode("-", $time);
        $start_time = !empty($temp_time) && isset($temp_time[0]) ? $temp_time[0] : "";
        $end_time = !empty($temp_time) && isset($temp_time[1]) ? $temp_time[1] : "";

        if(!empty($start_time)){

          $appointment_date_time = $appointment_date;

          try{

            $temp_date = new \DateTime($start_time, new \DateTimeZone($curtimezone));
            $hours = $temp_date->format('H');
            $mintus = $temp_date->format('i');
            $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$hours.'hours'));
            $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$mintus.'minutes'));
            $temp_appointment_date_time = $this->ApiGenaral->timezoneConverter($appointment_date_time, $curtimezone, $converttimezone);
           // pr('appointment_date_time  '.$appointment_date_time);
            //pr('temp_appointment_date_time  '.$temp_appointment_date_time);
            $current_datetime = new \DateTime("now", new \DateTimeZone($converttimezone));
            $current_datetime = $current_datetime->format('Y-m-d H:i');
           // pr('current_datetime  '.$current_datetime);
            if(strtotime($temp_appointment_date_time) < strtotime($current_datetime)){

              return 0;
            }
            else{

              $appointment_date = date('Y-m-d',strtotime($temp_appointment_date_time));
              $appointment_time = date('H:i',strtotime($temp_appointment_date_time));
            }

          }
          catch(\Exception $e){

          }
        }


        if(!empty($end_time)){

          $appointment_date_time = $appointment_date;

          try{

            $temp_date = new \DateTime($end_time, new \DateTimeZone($curtimezone));
            $hours = $temp_date->format('H');
            $mintus = $temp_date->format('i');
            $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$hours.'hours'));
            $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$mintus.'minutes'));
            $appointment_date_time = $this->ApiGenaral->timezoneConverter($appointment_date_time, $curtimezone , $converttimezone);

            $temp_end_time = date('H:i',strtotime($appointment_date_time));
            $appointment_time = $appointment_time." - ".$temp_end_time;

          }
          catch(\Exception $e){

          }
        }
      }
      //pr(array('appointment_date' => $appointment_date,'appointment_time' => $appointment_time));
      return array('appointment_date' => $appointment_date,'appointment_time' => $appointment_time);
    }



       // mrn uniqueness for provider patient panel
    public function mrnVerify($organization_id,$mrn,$schedule_data = null)
    {         
          $this->Schedules  = TableRegistry::get('Schedules');

          $schedule_detail = array();

          if(!empty($mrn))
          {
              $mrn = base64_encode($this->CryptoSecurity->encrypt($mrn,SEC_KEY));
              $schedule_detail = $this->Schedules->find('all')->where(['organization_id' => $organization_id,'mrn' =>$mrn])->first(); 
          }  
          $checkExistScheduleAppointment = $this->checkExistScheduleAppointment($schedule_data);          
          if(!empty($schedule_detail) && $checkExistScheduleAppointment == 0)
          {
                return 1;
          }                      
          else
          {
                return 0;
          }           
     }


      public function checkExistScheduleAppointment($detail)
    {
        $isMatched = 0;
        if(!empty($detail) && is_array($detail)){
        $this->Schedule = TableRegistry::get('Schedule');
        $enc_email = isset($detail['email']) && $detail['email'] != '' ? base64_encode($this->CryptoSecurity->encrypt($detail['email'],SEC_KEY)):'';
        $enc_phone = isset($detail['phone']) && $detail['phone'] != '' ? base64_encode($this->CryptoSecurity->encrypt($detail['phone'],SEC_KEY)) : '';
        $enc_first_name = isset($detail['first_name']) && $detail['first_name'] != '' ? base64_encode($this->CryptoSecurity->encrypt($detail['first_name'],SEC_KEY)) : '';
        $enc_last_name = isset($detail['last_name']) && $detail['last_name'] != '' ? base64_encode($this->CryptoSecurity->encrypt($detail['last_name'],SEC_KEY)) : '';
        $enc_dob = isset($detail['dob']) && $detail['dob'] != '' ? base64_encode($this->CryptoSecurity->encrypt($detail['dob'],SEC_KEY)) : '';
        $enc_mrn = isset($detail['mrn']) && !empty($detail['mrn']) ? $detail['mrn'] : '';

        $enc_appointment_time = isset($detail['appointment_time']) && !empty($detail['appointment_time']) ? $detail['appointment_time'] : '';


        $enc_appointment_date = isset($detail['appointment_date']) && !empty($detail['appointment_date']) ? $detail['appointment_date'] : '';

        $enc_doctor_name = isset($detail['doctor_name']) && !empty($detail['doctor_name']) ? $detail['doctor_name'] : '';

        $enc_appointment_reason = isset($detail['appointment_reason']) && !empty($detail['appointment_reason']) ? $detail['appointment_reason'] : '';

        $provider_id = isset($detail['provider_id']) && !empty($detail['provider_id']) ? $detail['provider_id'] : '';
        $doctor_id = isset($detail['doctor_id']) && !empty($detail['doctor_id']) ? $detail['doctor_id'] : '';
        $organization_id = isset($detail['organization_id']) && !empty($detail['organization_id']) ? $detail['organization_id'] : '';
        $user_id = isset($detail['user_id']) && !empty($detail['user_id']) ? $detail['user_id'] : '';

        $checkAlreadyScheduleData = "";

        if(isset($enc_email) && !empty($enc_email))
        {
            $checkAlreadyScheduleData  = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['email' =>$enc_email,'organization_id' =>$organization_id])->toArray();             
        }

      /*  if(empty($checkAlreadyScheduleData))
        {
          if(isset($enc_phone) && !empty($enc_phone)){

            $checkAlreadyScheduleData = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['phone' =>$enc_phone,'organization_id' =>$organization_id])->toArray();
                   
          }
        }
        if(empty($checkAlreadyScheduleData))
        {
          if(isset($enc_first_name) && isset($enc_last_name) && isset($enc_dob))
          {

            $checkAlreadyScheduleData = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['first_name' =>$enc_first_name,'last_name' => $enc_last_name,'dob' => $enc_dob,'organization_id' =>$organization_id])->toArray();                      
          } 
        }*/

        elseif(isset($enc_phone) && !empty($enc_phone)){

            $checkAlreadyScheduleData = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['phone' =>$enc_phone,'organization_id' =>$organization_id])->toArray();
                   
        }
        elseif(isset($enc_first_name) && isset($enc_last_name) && isset($enc_dob)){

            $checkAlreadyScheduleData = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['first_name' =>$enc_first_name,'last_name' => $enc_last_name,'dob' => $enc_dob,'organization_id' =>$organization_id])->toArray();                      
        } 

        $app_date = isset($detail['appointment_date']) && !empty($detail['appointment_date']) ?  strtotime($detail['appointment_date']) : date('Y-m-d');   

        if(!empty($checkAlreadyScheduleData)){

            $isMatched = 1;           
        }        
      }
      return $isMatched;
    }

}
