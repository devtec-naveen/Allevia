<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

 use Cake\Network\Email\Email;
 use Cake\Utility\Security;

class TestController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['runTest','runTest1','runJavaTest','runJavaTest1']);
    
       
    }
    public function runTest(){

        //echo WWW_ROOT;
        $output_py = shell_exec("python ".WWW_ROOT."automation_test/allv.py 2>&1 ");
        print_r($output_py);
        die('end');           
    }
    public function runTest1(){

        //echo WWW_ROOT;
        $output_py = shell_exec("python ".WWW_ROOT."automation_test/allv1.py 2>&1 ");
        print_r($output_py);
        die('end');           
    }

    public function runJavaTest(){

        //echo WWW_ROOT;
        // shell_exec("javac ".WWW_ROOT."automation_test/Alleviajv.java");
        // $output_py = shell_exec("java ".WWW_ROOT."automation_test/Alleviajv");
        // print_r($output_py);
        // die('end');  

        //Compile the code
        $compile_output = '';
        $run_output = '';
        try {
          $compile_output = (shell_exec("javac ".WWW_ROOT."automation_test/Alleviajv.java 2>&1"));
        }
        catch(\Exception $e) {
          die('fghf');
          echo 'Message: ' .$e->getMessage();
        }
        //check weather error or not after code compilation
        if($compile_output == ''){
          $run_output = (shell_exec("java -cp ".WWW_ROOT."automation_test/ Alleviajv 2>&1"));
        }else{
            //throw the exception if there is error while compilation
            throw new \Exception($compile_output);
        }

        echo "<pre>";
        echo $run_output;
        die;         
    }

    public function runJavaTest1(){

        // echo WWW_ROOT;
        //  shell_exec("javac ".WWW_ROOT."automation_test/Demo.java");
        // $output_py = shell_exec("java ".WWW_ROOT."automation_test/Demo");
        // print_r($output_py);
        // die('end');  

        //Compile the code
        $compile_output = '';
        $run_output = '';
        try {
        $compile_output = (shell_exec("javac ".WWW_ROOT."automation_test/Demo.java 2>&1"));
        }
        catch(\Exception $e) {
        die('fghf');
        echo 'Message: ' .$e->getMessage();
        }
        //check weather error or not after code compilation
        if($compile_output == ''){
        $run_output = (shell_exec("java -cp ".WWW_ROOT."automation_test/ Demo 2>&1"));
        }else{
        //throw the exception if there is error while compilation
        throw new \Exception($compile_output);
        }

        echo "<pre>";
        echo $run_output;
        die('end');      
    }

    public function scheduleSettings(){

        $this->autoRender = false;
        $this->loadModel('Users');
        $ScheduleFieldSettingsTbl = TableRegistry::get('ScheduleFieldSettings');
        $users = $this->Users->find()->select(['id'])->where(['role_id' => 3])->toArray();

        if(count($users)){


            foreach ($users as $user_key => $user_val) {
               
                //save provider table display columns settings
                 $provider_display_columns = array(

                    0 => array(

                        'provider_id' => $user_val->id,
                        'title' => 'File Type',
                        'field_name' => 'file_type',
                        'field_index' => 'csv'
                    ),
                    1 => array(

                        'provider_id' => $user_val->id,
                        'title' => 'Appointment Reason',
                        'field_name' => 'appointment_reason',
                        'field_index' => 12
                    )                    

                );

                $entities1 = $ScheduleFieldSettingsTbl->newEntities($provider_display_columns);
                $data1 = $ScheduleFieldSettingsTbl->patchEntities($entities1, $provider_display_columns);
                $ScheduleFieldSettingsTbl->saveMany($entities1);

                echo $user_val->id.' columns data inserted.<br>';
            }
        }                  
    }


    public function emailSettings(){

        $this->autoRender = false;
        $this->loadModel('Users');
        $users = $this->Users->find()->select(['id'])->where(['role_id' => 3])->toArray();

        $ProviderEmailTemplatesTlb  = TableRegistry::get('ProviderEmailTemplates');
        $EmailTemplateTlb           = TableRegistry::get('EmailTemplates');
        $emailTemplates = $EmailTemplateTlb->find('all')->where(['slug IN' => ['api_notification']])->toArray();

        if(count($users)){


            foreach ($users as $user_key => $user_val) {
               
                //save provider email templates
                if(count($emailTemplates)){

                    $email_template_data = array();

                    foreach ($emailTemplates as $email_key => $email_value) {
                       
                        $email_template_data[] = array(

                            'provider_id' => $user_val->id,
                            'name' => $email_value->name,
                            'slug' => $email_value->slug,
                            'subject' => $email_value->subject,
                            'description' => $email_value->description
                        );
                    }


               // pr($email_template_data);die;

                $entities1 = $ProviderEmailTemplatesTlb->newEntities($email_template_data);
                $data1 = $ProviderEmailTemplatesTlb->patchEntities($entities1, $email_template_data);
                $ProviderEmailTemplatesTlb->saveMany($entities1);
            }

                echo $user_val->id.' columns data inserted.<br>';
            }
        }          

    }


    public function sepecializationDetail($type){

        $this->viewBuilder()->setLayout('front');
        $this->loadModel('ChiefCompliants');
        $this->loadModel('ChiefCompliantMedication');

        $final_data = array();

        if($type == 2){

            $cheifcompliants_data = $this->ChiefCompliants->find('all')->where(['specialization_id' => 0])->toArray();

        }else{

            $cheifcompliants_data = $this->ChiefCompliants->find('all')->where(['specialization_id' => $type])->toArray();
        }

        
        //pr($cheifcompliants_data);die;

        if(count($cheifcompliants_data)){

            foreach ($cheifcompliants_data as $key => $value) {

                $temp_med = array();
                if(!empty($value['default_medication_ids'])){

                    $med_ids = explode(",",$value['default_medication_ids']);
                    $medication_data = $this->ChiefCompliantMedication->find('all')->where(['id IN' => $med_ids])->toArray();

                    if(count($medication_data)){

                        
                        foreach ($medication_data as $med_key => $med) {
                            
                            $temp_med[] = $med['layman_name'].'('.$med['doctor_specific_name'].')';
                            
                        }
                    }
                }

                $final_data[] = array('chief_complaint' => $value['name'],'medications' => $temp_med); 

            }

             switch ($type) {
                    
                    case 0:

                        $title = 'General Sepecialization Detail';
                        break;

                    case 2:

                        $title = 'OB/GYN Sepecialization Detail';
                        break;

                    case 3:
                        
                        $title = 'Orthopedic (coming soon) Sepecialization Detail';
                        break;

                    case 4:

                        
                         $title = 'Orthopedic spine Sepecialization Detail';
                        break;

                    case 5:
                        
                        $title = 'Cardiology Sepecialization Detail';
                        break;

                    case 6:

                       $title = 'GI Sepecialization Detail';
                        break;

                     case 7:
                        $title = 'Pain medicine Sepecialization Detail';
                        break;

                    default:
                        $title = "";
                        break;
                }
        }

       $this->set(['data' => $final_data,'title' => $title]);

    }

    public function healthQuestion($type){

        $this->viewBuilder()->setLayout('front');
        $this->loadModel('ChiefCompliantQuestionnaire');
        $healthquestion_data = $this->ChiefCompliantQuestionnaire->find('all')->where(['specialization_ids LIKE' => '%'.$type.'%'])->toArray();

        //pr($healthquestion_data);die;

        $health = array();

        foreach ($healthquestion_data as $key => $value) {
            
            $health[] = $value['questionnaire_text'].(!empty($value['medical_name']) ? '('.$value['medical_name'].')' : "");
        }

        switch ($type) {
                    
                case 1:

                    $title = 'General Sepecialization Health questions Detail';
                    break;

                case 2:

                    $title = 'OB/Gyn Sepecialization Health questions Detail';
                    break;

                case 3:
                    
                    $title = 'Orthopedic (coming soon) Sepecialization Health questions Detail';
                    break;

                case 4:

                    
                     $title = 'Orthopedic spine Sepecialization Health questions Detail';
                    break;

                case 5:
                    
                    $title = 'Cardiology Sepecialization Health questions Detail';
                    break;

                case 6:

                   $title = 'GI Sepecialization Health questions Detail';
                    break;

                 case 7:
                    $title = 'Pain medicine Sepecialization Health questions Detail';
                        break;
                default:
                    $title = "";
                    break;
                }

            $this->set(['data' => $health,'title' => $title]);
       
    } 


    public function getConditions($type){

         //$this->autoRender = false;
        $this->viewBuilder()->setLayout('front');
        $this->loadModel('CommonConditions');

        $conditions_data = $this->CommonConditions->find('all')->where(['cond_type' => $type])->toArray();

        switch ($type) {
            case 1:
               $title = "Medical conditions";
                break;
            case 2:
               $title = "Surgical conditions";
                break;
            case 3:
               $title = "Allergies";
                break;
            case 4:
               $title = "Shots";
                break;
            case 5:
               $title = "Reaction to Allergy";
                break;           
            
            default:
                $title = "";
                break;
        }

        $health = array();

        foreach ($conditions_data as $key => $value) {
            
            $health[] = $value['name'].(!empty($value['medical_name']) ? '('.$value['medical_name'].')' : "");
        }

        $this->set(['data' => $health]);
        $this->set(['title' => $title]);

        //pr($health);die;
    }


    public function updateFirstLastName(){

        $this->loadComponent('CryptoSecurity');
        //echo base64_encode($this->CryptoSecurity->encrypt('Allevia',SEC_KEY));
        echo $this->CryptoSecurity->decrypt(base64_decode('YjI5YVVuVjBaMGQ0WTFoR1VHTXlLekppUWs4eU0xRlpUa0l2YUZkeVVUaDFNbkpZYW1sTFluaDRRVDA2T2c9PQ=='),SEC_KEY);
        echo '<br>';
        echo $this->CryptoSecurity->decrypt(base64_decode('YW5kVVJtRjNXVlJWWTBJeFdHZHNRWEIyYkZaVk0xRlpUa0l2YUZkeVVUaDFNbkpZYW1sTFluaDRRVDA2T2c9PQ=='),SEC_KEY);
        die;;
        $this->autoRender = false;
        $this->loadModel('Users');
        
        $users = $this->Users->find('all')->where(['role_id !=' => 1])->toArray();
        if(count($users)){

            foreach ($users as $user_key => $user_val) {

                if(!empty($user_val['email'])){
                    
                    $user_val->email = base64_encode($this->CryptoSecurity->encrypt($user_val['email'],SEC_KEY));

                }

                if(!empty($user_val['phone'])){
                
                    $user_val->phone = base64_encode($this->CryptoSecurity->encrypt($user_val['phone'],SEC_KEY));

                }
                 if(!empty($user_val['dob'])){
                
                    $user_val->dob = base64_encode($this->CryptoSecurity->encrypt($user_val['dob'],SEC_KEY));

                }

                $this->Users->save($user_val);
                echo $user_val->id.' user data updated.<br>';
            }

            die('hello');
        }                  
    }


    public function updateScheduleData(){

        $this->autoRender = false;
        $this->loadModel('Schedules');
        $this->loadComponent('CryptoSecurity');
        $schedule_data = $this->Schedules->find('all')->toArray();
        if(count($schedule_data)){

            foreach ($schedule_data as $key => $val) {

                if(!empty($val['last_name'])){
                    
                    $val->last_name = base64_encode($this->CryptoSecurity->encrypt($val['last_name'],SEC_KEY));

                }

                if(!empty($val['first_name'])){
                                    
                    $val->first_name = base64_encode($this->CryptoSecurity->encrypt($val['first_name'],SEC_KEY));
                }

                if(!empty($val['email'])){
                    
                    $val->email = base64_encode($this->CryptoSecurity->encrypt($val['email'],SEC_KEY));

                }

                if(!empty($val['mrn'])){
                    
                    $val->mrn = base64_encode($this->CryptoSecurity->encrypt($val['mrn'],SEC_KEY));
                }

                if(!empty($val['phone'])){
                    
                    $val->phone = base64_encode($this->CryptoSecurity->encrypt($val['phone'],SEC_KEY));

                }

                if(!empty($val['dob'])){
                    
                    $val->dob = base64_encode($this->CryptoSecurity->encrypt($val['dob'],SEC_KEY));

                }

                if(!empty($val['appointment_time'])){
                    
                    $val->appointment_time = base64_encode($this->CryptoSecurity->encrypt($val['appointment_time'],SEC_KEY));

                }

                if(!empty($val['appointment_reason'])){
                    
                    $val->appointment_reason = base64_encode($this->CryptoSecurity->encrypt($val['appointment_reason'],SEC_KEY));

                }

                if(!empty($val['doctor_name'])){
                    
                    $val->doctor_name = base64_encode($this->CryptoSecurity->encrypt($val['doctor_name'],SEC_KEY));

                }

                $this->Schedules->save($val);
                echo $val->id.' data updated.<br>';
            }

            die('end');
        }                  
    }

    public function getClinics(){

        $this->viewBuilder()->setLayout('front');
       $this->loadModel('Organizations');
       $this->loadModel('Specializations');
       $org_data = $this->Organizations->find('all')->toArray();
       foreach ($org_data as $key => $value) {
           
           $specialization_ids = explode(",", $value['specialization_ids']);
           $sp_data = $this->Specializations->find('all')->where(['id IN' => $specialization_ids])->toArray();
           $specialization = '';
           if(!empty($sp_data)){

                foreach ($sp_data as $k => $v) {
                    
                    $specialization .= $v['name'].', ';
                }
           }

           $value['specialization'] = rtrim($specialization,', ');
           $org_data[$key] = $value;
       }

       //pr($org_data);die;

       $this->set(['data' => $org_data]);
       
    }


    public function getVisitReasons(){

        $this->viewBuilder()->setLayout('front');
       $this->loadModel('StepDetails');
       $org_data = $this->StepDetails->find('all')->toArray();
       $this->set(['data' => $org_data]);
      // pr($org_data);die;
    }

    public function getPreAppointment(){

        $this->viewBuilder()->setLayout('front');
       $this->loadModel('ChiefCompliantUserdetails');
       $this->loadModel('ChiefCompliants');
       $data = $this->ChiefCompliantUserdetails->find('all')->contain(['Appointments','Appointments.Organizations'])->where(['ChiefCompliantUserdetails.current_step_id' => 1,'ChiefCompliantUserdetails.chief_compliant_id !=' => '','ChiefCompliantUserdetails.chief_compliant_id IS NOT NULL'])->order(['ChiefCompliantUserdetails.id' => 'desc'])->toArray();
       if(!empty($data)){

        foreach ($data as $key => $value) {
            
            $chief_complaint = '';
            if(!empty($value['chief_compliant_id'])){
                $value['chief_compliant_id'] = Security::decrypt(base64_decode($value['chief_compliant_id']),SEC_KEY);

                $chief_compliant_id = explode(",", $value['chief_compliant_id']);
                $chief_complaint_data = $this->ChiefCompliants->find('all')->where(['id IN' => $chief_compliant_id ])->toArray();

                //pr($chief_complaint_data);

                if(!empty($chief_complaint_data)){

                    foreach ($chief_complaint_data as $ckey => $cvalue) {
                        
                        $chief_complaint .= $cvalue['name'].', ';
                    }
                }
            }

            if(!empty($value['chief_compliant_details'])){
                $value['chief_compliant_details'] = @unserialize(Security::decrypt(base64_decode($value['chief_compliant_details']),SEC_KEY));
            }

            if(!empty($value['questionnaire_detail'])){

                $value['questionnaire_detail'] = @unserialize(Security::decrypt(base64_decode($value['questionnaire_detail']),SEC_KEY));
            }

            $value['chief_complaint'] = rtrim($chief_complaint,', ');

            if(empty($value['chief_complaint'])){

                unset($data[$key]);
                continue;
            }

            $data[$key] = $value;

           //pr($value);die;
        } 
       }

       //pr($data);die;
       $this->set(['data' => $data]);
       // pr($data);die;
    }

    public function getAllVisits(){

        $this->viewBuilder()->setLayout('front');
       $this->loadModel('ChiefCompliantUserdetails');
       $this->loadModel('StepDetails');
       $data = $this->ChiefCompliantUserdetails->find('all')->contain(['Appointments','Appointments.Organizations','Appointments.Specializations'])->order(['ChiefCompliantUserdetails.id' => 'desc'])->toArray();
      
       if(!empty($data)){

        foreach ($data as $key => $value) {
            
            
            if(!empty($value['current_step_id'])){

                $step_detail = $this->StepDetails->find('all')->where(['id' => $value['current_step_id']])->first();

                $value['current_step_id'] =  $step_detail;
                $data[$key] = $value; 
            }
        } 
       }

      // pr($data);die;
       $this->set(['data' => $data]);
       // pr($data);die;
    }

    public function addOrgUrl(){

        $this->autoRender = false;
        $this->loadModel('Organizations');
        $this->loadComponent('General');
        $org_data = $this->Organizations->find('all')->toArray();
        if(count($org_data)){

            foreach ($org_data as $key => $val) {

                $org_url = $this->General->slugify($val['organization_name']);
                $val->org_url = $org_url;
                $this->Organizations->save($val);
                echo $val->id.' data updated.<br>';
            }
        }

        die('23');

    }


    public function decrypt($cipher,$key){

       $hmacSalt = '8b98f46742e88e085fd3ee4bba302a12130d8ff8ba762b4800c2439f68d7c814';
       $key = 'h4o:%ZbUF5vE(3Q8g541VF4045>mzuR{&0Z@$m=P$3^Ww';

       // Generate the 32 character long encryption and hmac key.
       $key = mb_substr(hash('sha256', $key . $hmacSalt), 0, 32, '8bit');

       

        // generate the 64 character long hmac
        $macSize = 64;
        $hmac = mb_substr($cipher, 0, $macSize, '8bit');        
        $cipher = mb_substr($cipher, $macSize, null, '8bit');

        $method = 'AES-256-CBC';

        //get the iv size
        $ivSize = openssl_cipher_iv_length($method);

        //get the iv
        $iv = mb_substr($cipher, 0, $ivSize, '8bit');
        $cipher = mb_substr($cipher, $ivSize, null, '8bit');
        return openssl_decrypt($cipher, $method, $key,1, $iv);
    }

    public function providerConfigSettings(){

        $this->autoRender = false;
        $this->loadModel('Users');
        $this->loadModel('ProviderGlobalSettings');
        $users = $this->Users->find()->select(['id'])->where(['role_id' => 3])->toArray();

        if(count($users)){


            foreach ($users as $user_key => $user_val) {
               
                //set the default provider global setting
                $global_setting = $this->ProviderGlobalSettings->newEntity();
                $global_setting->provider_id = $user_val->id;
                $this->ProviderGlobalSettings->save($global_setting);
                echo $user_val->id.' global setting inserted.<br>';
            }
        }                  
    }


    public function providerTelehealthTemplate(){

        $this->autoRender = false;
        $this->loadModel('Users');
        $this->loadModel('ProviderEmailTemplates');
        $users = $this->Users->find()->select(['id'])->where(['role_id' => 3])->toArray();
        $this->loadModel('EmailTemplates');
        $emailTemplates = $this->EmailTemplates->find('all')->where(['slug IN' => ['telehealth_reminder','telehealth_reminder_before_x_time']])->toArray();

        if(count($users)){
            
            foreach ($users as $user_key => $user_val) {
               
                //set the default provider global setting

                if(count($emailTemplates)){

                    $email_template_data = array();

                    foreach ($emailTemplates as $email_key => $email_value) {
                       
                        $email_template_data[] = array(

                            'provider_id' => $user_val->id,
                            'name' => $email_value->name,
                            'slug' => $email_value->slug,
                            'subject' => $email_value->subject,
                            'description' => $email_value->description,
                            'text_message' => $email_value->text_message
                        );
                    }

                    $entities1 = $this->ProviderEmailTemplates->newEntities($email_template_data);
                    $data1 = $this->ProviderEmailTemplates->patchEntities($entities1, $email_template_data);
                    $this->ProviderEmailTemplates->saveMany($entities1);
                }

                /*$global_setting = $this->ProviderEmailTemplates->newEntity();
                $global_setting->provider_id = $user_val->id;
                $global_setting->name = $emailTemplates->name;
                $global_setting->slug = $emailTemplates->slug;
                $global_setting->subject = $emailTemplates->subject;
                $global_setting->description = $emailTemplates->description;
                $global_setting->text_message = $emailTemplates->text_message;
                $this->ProviderEmailTemplates->save($global_setting);*/
                echo $user_val->id.' Telehealth reminder template inserted.<br>';
            }
        }                  
    }


    public function cronicDatabase(){

        $this->autoRender = false;
        $this->loadModel('CommonQuestionsBk');
        $this->loadModel('CommonQuestions');
        $cronoc_questions = $this->CommonQuestionsBk->find('all')->where(['id >=' => 219])->toArray();

        foreach ($cronoc_questions as $key => $value) {
            
            /*$data = array(

                'question' => $value->question,
                'question_type' => $value->question_type,
                'options' => $value->options,
                'placeholder' => $value->placeholder,
                'hint' => $value->hint,
                'specialization_id' => $value->specialization_id,
                'step_id' => $value->step_id,
                'tab_number' => strtolower($value->tab_number)
            );*/

            echo $value->id;

            $question = $this->CommonQuestions->newEntity();
            $question->question = $value->question;
            $question->question_type = $value->question_type;
            $question->options = $value->options;
            $question->placeholder = $value->placeholder;
            $question->hint = $value->hint;
            $question->specialization_id = $value->specialization_id;
            $question->step_id = $value->step_id;
            $question->tab_number = strtolower($value->tab_number);


            $record = $this->CommonQuestions->save($question);
            echo ' '.$record->id.'<br>';
        }

        die('end');
        
    }

    public function updateClProviderId(){

        $this->loadComponent('CryptoSecurity');
        /*//echo base64_encode($this->CryptoSecurity->encrypt('Allevia',SEC_KEY));
        echo $this->CryptoSecurity->decrypt(base64_decode('YjI5YVVuVjBaMGQ0WTFoR1VHTXlLekppUWs4eU0xRlpUa0l2YUZkeVVUaDFNbkpZYW1sTFluaDRRVDA2T2c9PQ=='),SEC_KEY);
        echo '<br>';
        echo $this->CryptoSecurity->decrypt(base64_decode('YW5kVVJtRjNXVlJWWTBJeFdHZHNRWEIyYkZaVk0xRlpUa0l2YUZkeVVUaDFNbkpZYW1sTFluaDRRVDA2T2c9PQ=='),SEC_KEY);
        die;;*/
        $this->autoRender = false;
        $this->loadModel('Users');
        
        $users = $this->Users->find('all')->where(['role_id' => 3])->toArray();
        if(count($users)){

            foreach ($users as $user_key => $user_val) {

                if(!empty($user_val['cl_provider_id'])){
                    
                    $user_val->cl_provider_id = base64_encode($this->CryptoSecurity->encrypt($user_val['cl_provider_id'],SEC_KEY));

                }

                /*if(!empty($user_val['phone'])){
                
                    $user_val->phone = base64_encode($this->CryptoSecurity->encrypt($user_val['phone'],SEC_KEY));

                }
                 if(!empty($user_val['dob'])){
                
                    $user_val->dob = base64_encode($this->CryptoSecurity->encrypt($user_val['dob'],SEC_KEY));

                }*/

                $this->Users->save($user_val);
                echo $user_val->id.' user data updated.<br>';
            }

            die('hello');
        }                  
    }


    public function updateClGroupId(){

        $this->loadComponent('CryptoSecurity');
        /*//echo base64_encode($this->CryptoSecurity->encrypt('Allevia',SEC_KEY));
        echo $this->CryptoSecurity->decrypt(base64_decode('YjI5YVVuVjBaMGQ0WTFoR1VHTXlLekppUWs4eU0xRlpUa0l2YUZkeVVUaDFNbkpZYW1sTFluaDRRVDA2T2c9PQ=='),SEC_KEY);
        echo '<br>';
        echo $this->CryptoSecurity->decrypt(base64_decode('YW5kVVJtRjNXVlJWWTBJeFdHZHNRWEIyYkZaVk0xRlpUa0l2YUZkeVVUaDFNbkpZYW1sTFluaDRRVDA2T2c9PQ=='),SEC_KEY);
        die;;*/
        $this->autoRender = false;
        $this->loadModel('Organizations');
        
        $users = $this->Organizations->find('all')->toArray();
        if(count($users)){

            foreach ($users as $user_key => $user_val) {

                if(!empty($user_val['cl_group_id'])){
                    
                    $user_val->cl_group_id = base64_encode($this->CryptoSecurity->encrypt($user_val['cl_group_id'],SEC_KEY));

                }

                /*if(!empty($user_val['phone'])){
                
                    $user_val->phone = base64_encode($this->CryptoSecurity->encrypt($user_val['phone'],SEC_KEY));

                }
                 if(!empty($user_val['dob'])){
                
                    $user_val->dob = base64_encode($this->CryptoSecurity->encrypt($user_val['dob'],SEC_KEY));

                }*/

                $this->Organizations->save($user_val);
                echo $user_val->id.' user data updated.<br>';
            }

            die('hello');
        }                  
    }
}
