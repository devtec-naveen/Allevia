<?php
namespace App\Controller\Services;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use App\Controller\AppController;
use Cake\Network\Email\Email;
use Cake\Utility\Security;
use Cake\Network\Request;
use Cake\I18n\Time;

class WebserviceController extends AppController
{

	public function initialize()
    {

      parent::initialize();
      $this->loadComponent('RequestHandler');
      $this->loadComponent('CryptoSecurity');
      $this->loadComponent('ProviderMailSend');
      $this->loadComponent('TextMsgSend');
      $this->loadComponent('General');
      $this->loadComponent('ApiGenaral');

      $this->loadModel('ScheduleToken');
      $this->loadModel('UserInfo');
      $this->autoRender = false;

    }

     public function beforeFilter(Event $event)
    {
    	//$this->Auth->allow(['token','management','allAppointments']);
        $this->Auth->allow();
        parent::beforeFilter($event);
       // $this->getEventManager()->off($this->Csrf);
    }

    private function checkRedirectUri($redirectUri,$org_provider_ids)
    {
      $getOrganizationDetail  = $this->Organizations->find('all')->where(['id' =>$org_provider_ids])->first();
      $allow_redirect_uri = $getOrganizationDetail['allow_redirect_uri'];
      $splitURl = explode(';', $allow_redirect_uri);
      if(!empty($splitURl))
      {
        if(in_array($redirectUri, $splitURl))
        {
            return array('redirectUri' => $redirectUri);
        }
        else
        {
            $header = array(
                'statusCode' => 402,
                'message' => 'Redirect uri not supported.'
            );
            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
      }
    }


    public function token()
    {
        try{

            $this->autoRender = false;
            $response = array();
            if(empty($this->request->getData())){

            	$header = array(
            		'statusCode' => 400,
            		'message' => 'Blank Parameter Error'
            	);

            	$response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $clientId = $this->request->data('clientId');
            $clientSecret = $this->request->data('clientSecret');
    	    $providerSecret =  $this->request->data('providerSecret');

    	    if(empty($clientId)){

            	$header = array(
            		'statusCode' => 400,
            		'message' => 'Client id is empty.'
            	);

            	$response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($clientSecret)){

            	$header = array(
            		'statusCode' => 400,
            		'message' => 'Client secret is empty.'
            	);

            	$response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($providerSecret)){

            	$header = array(
            		'statusCode' => 400,
            		'message' => 'Provider secret is empty.'
            	);

            	$response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

        	$users= TableRegistry::get('Users');
        	$userApiInfoObj = $this->loadModel('UserInfo');
    	 	$clientId =  base64_encode($this->CryptoSecurity->encrypt($clientId,SEC_KEY));
        	$clientSecret =  base64_encode($this->CryptoSecurity->encrypt($clientSecret,SEC_KEY));
        	$providerSecret =  base64_encode($this->CryptoSecurity->encrypt($providerSecret,SEC_KEY));
    	    $checkOrganizationData = $this->Organizations->find('all')->where(['client_id' =>$clientId,'client_secret' =>$clientSecret])->first();   //check client id and client secret match to organization

            if(empty($checkOrganizationData))
            {

            	$header = array(
            		'statusCode' => 402,
            		'message' => 'Invalid client id or client secret.'
            	);

            	$response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));

            }

    	    $getApiData = $users->find('all')->where(['provider_secret' =>$providerSecret])->first();

    	    if(empty($getApiData))
            {

            	$header = array(
            		'statusCode' => 402,
            		'message' => 'Invalid provider secret.'
            	);

            	$response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));

            }

            if($checkOrganizationData['id'] != $getApiData['organization_id'])
            {

            	$header = array(
            		'statusCode' => 402,
            		'message' => 'Provider secret not belong to this organzation.'
            	);

            	$response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));

            }
    	    $random_str = $this->General->generateClientSecret(15);
    		$accessToken = $checkOrganizationData['id'].'O'.$getApiData['id'].'P'.time().'T'.$random_str;
    		$accessToken = $this->CryptoSecurity->tokenEncrypt($accessToken);  //access token encrypt with cake security component
            //echo $accessToken;die;
    		$encryptedToken =  base64_encode($this->CryptoSecurity->encrypt($accessToken,SEC_KEY));
    		// $checkExistRecord = $userApiInfoObj->find('all')->where(['organization_id' =>$checkOrganizationData['id'],'provider_id'=>$getApiData['id']])->first();  //check already exist token with organization and with provider

             // if(!empty($checkExistRecord))
             // {
             // 		$userApiInfoObj->updateAll(['access_token' =>$encryptedToken,'timestamp' => date('Y-m-d H:i:s')],['id' =>$checkExistRecord['id']]);
             // }
             // else
             // {
     	     $data = array();
	         $data['organization_id'] = $checkOrganizationData['id'];
	         $data['provider_id'] = $getApiData['id'];
	         $data['access_token'] = $encryptedToken;
             $data['timestamp'] = date('Y-m-d H:i:s');
	         $userAPiInfoEntity = $userApiInfoObj->newEntity();
	         $patchuserApiInfo = $userApiInfoObj->patchEntity($userAPiInfoEntity,$data);
	         $userApiInfoObj->save($patchuserApiInfo);
             //}

            $dataList = TableRegistry::get('global_settings');
            $access_token_expire_time = $dataList->find('all')->where(['slug' => 'iframe-access-token-expire'])->first();
            $expired_time = 0;
            if(!empty($access_token_expire_time)){

                $expired_time = $access_token_expire_time['value'];
            }

            $header = array(
        		'statusCode' => 200,
        		'message' => 'Access token Generated Successfully.'
            );

            $payload = array(
        		'accessToken' => $accessToken,
        		'expiryIn' => $expired_time
            );

           	$response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

    }

    public function scheduleAppointments()
    {
        try{
            $this->loadModel('Users');
            $this->loadModel('Schedules');
            $this->loadModel('ProviderEmailTemplates');
            $this->loadModel('Organizations');
            $response = array();
            $mrnCheck = '';
            $RaceValue = array('1' =>'American Indian or Alaska Native','2' =>'Asian', '3' => 'Black or African American', '4' =>'Native Hawaiian or Other Pacific Islander', '5' =>'White' , '6' =>'Other Race');
            $ethinicityValue = array('1' =>'Hispanic or Latino', '2' =>'Not Hispanic or Latino');
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $appointment_data = $this->request->data('appointmentData');
            if(empty($appointment_data)){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Appointment data is blank.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(!is_array($appointment_data)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid appointment data format.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $appointment_data = array_filter($appointment_data);
            $access_token = $this->request->data('accessToken');
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);
            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }
            
            //get the email templete
            $email_templete = $this->ProviderEmailTemplates->find('all')->where(['provider_id' => $org_provider_ids['provider_id'],'slug' => 'pre_appointment_form_link'])->first();
            $organization_detail = $this->Organizations->find('all')->where(['id' => $org_provider_ids['organization_id']])->first();
            //start processing the appointment data


            $error = array();
            $scheduled_appointments = array();
            $app_count = 1;

            foreach ($appointment_data as $app_key => $app_value) {

                $app_value = array_filter($app_value);
                $temp_err = array();
                $appointment_number = $app_key+1; 
                //validate the appointment data

                //required field validation
                if(!isset($app_value['firstName']) || (isset($app_value['firstName']) && empty($app_value['firstName']))){

                    $temp_err[] = 'First name is required.';

                }

                if(!isset($app_value['lastName']) || (isset($app_value['lastName']) && empty($app_value['lastName']))){

                    $temp_err[] = 'Last name is required.';

                }

                if(!isset($app_value['dob']) || (isset($app_value['dob']) && empty($app_value['dob']))){

                    $temp_err[] = 'DOB is required.';

                }

                if(isset($app_value['dob']) && !$this->General->checkDateFormat($app_value['dob'])){

                    $temp_err[] = 'Invalid DOB.';
                }

                if(!isset($app_value['gender']) || (isset($app_value['gender']) && empty($app_value['gender']))){

                    $temp_err[] = 'Gender is required.';
                }


                if(!isset($app_value['mrn']) || (isset($app_value['mrn']) && empty($app_value['mrn']))){
                    
                    $temp_err[] = 'Mrn is required.';

                }
                

                if(isset($app_value['gender']) && !in_array($app_value['gender'], ['F','M','O'])){

                    $temp_err[] = 'Gender sould be M for male, F for female and O for other';

                }

              /*  if(!isset($app_value['country']) || (isset($app_value['country']) && empty($app_value['country']))){

                    $temp_err[] = 'Country is required.';

                }

                if(!isset($app_value['state']) || (isset($app_value['state']) && empty($app_value['state']))){

                    $temp_err[] = 'State is required.';

                }

                if(!isset($app_value['city']) || (isset($app_value['city']) && empty($app_value['city']))){

                    $temp_err[] = 'City is required.';

                }                

                if(!isset($app_value['address']) || (isset($app_value['address']) && empty($app_value['address']))){

                    $temp_err[] = 'Address is required.';

                }

                if(!isset($app_value['zip']) || (isset($app_value['zip']) && empty($app_value['zip']))){

                    $temp_err[] = 'Zip is required.';

                }*/


                if(isset($app_value['timezone']) && !empty($app_value['timezone']) && !in_array($app_value['timezone'],['PST','MST','CST','EST','HST'])){

                    $temp_err[] = 'Invalid timezone.';
                }

                if(!isset($app_value['appointmentTime']) || (isset($app_value['appointmentTime']) && empty($app_value['appointmentTime']))){

                    $temp_err[] = 'Appointment time is required.';
                }

                $timezone = isset($app_value['timezone']) && !empty($app_value['timezone']) ? $app_value['timezone'] : 'CST';

                if(isset($app_value['appointmentTime']) && !empty($app_value['appointmentTime'])){

                    $date = new \DateTime($app_value['appointmentTime'], new \DateTimeZone($timezone));                    
                   // $date->setTimezone(new \DateTimeZone('America/Chicago'));
                    
                    $appointment_date =  strtotime($date->format("Y-m-d H:i"));                    

                    $current_date = date('Y-m-d H:i');  
                    $date = new \DateTime($current_date, new \DateTimeZone('CST')); 
                    $date->setTimezone(new \DateTimeZone($timezone));
                    //echo $date->format("Y-m-d H:i");die;
                    $current_date =  strtotime($date->format("Y-m-d H:i"));  
                    //pr($current_date);die;


                   // echo date('Y-m-d H:i',$current_date);die;     
                    //var_dump($appointment_date < $current_date);die;      

                    if(isset($app_value['appointmentTime']) && $appointment_date < $current_date){

                        $temp_err[] = 'Invalid appointment time.';
                    }
                }
                

               // $appointment_date = isset($app_value['appointmentTime']) && !empty($app_value['appointmentTime']) ? strtotime(date('Y-m-d H:i',strtotime($app_value['appointmentTime']))) : "";
                

                

                //email validation check is still pending
                if(isset($app_value['email']) && !empty($app_value['email']) && !preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{1,})+$/",trim($app_value['email']))){

                  $temp_err[] = 'Invalid email address.';
                }

                if(isset($app_value['phone']) && !empty($app_value['phone']) && (!is_numeric($app_value['phone']) || strlen($app_value['phone']) != 10 )){

                    $temp_err[] = 'Invalid phone number.';
                }

                  if(isset($app_value['race']) && !empty($app_value['race']))
                {
                    if(!in_array(strtolower($app_value['race']), array_map('strtolower',$RaceValue)))
                    {
                        $temp_err[] = 'Invalid race value.';
                    }    
                } 

                if(isset($app_value['ethnicity']) && !empty($app_value['ethnicity']))
                {
                    if(!in_array(strtolower($app_value['ethnicity']), array_map('strtolower',$ethinicityValue)))
                    {
                        $temp_err[] = 'Invalid ethnicity value.';
                    }    
                } 

                if(isset($app_value['notifyEmailSchedule']) && !is_array($app_value['notifyEmailSchedule'])){

                    $temp_err[] = 'notifyEmailSchedule must be an array.';
                }

                if(isset($app_value['notifyTextSchedule']) && !is_array($app_value['notifyTextSchedule'])){

                    $temp_err[] = 'notifyTextSchedule must be an array.';
                }

                $user_detail = null;

                //check patient is registered or not on allevia platform
                if((isset($app_value['email']) && !empty($app_value['email'])) || (isset($app_value['phone']) && !empty($app_value['phone']))){

                    $filter = array();
                    $enc_phone = isset($app_value['phone']) && !empty($app_value['phone']) ? base64_encode($this->CryptoSecurity->encrypt($app_value['phone'],SEC_KEY)) : '';
                    $enc_email = isset($app_value['email']) && !empty($app_value['email']) ? base64_encode($this->CryptoSecurity->encrypt(strtolower($app_value['email']),SEC_KEY)) : '';
                    if(!empty($enc_email)){

                       $filter['email'] = $enc_email;
                    }

                    if(!empty($enc_phone)){

                       $filter['phone'] = $enc_phone;
                    }


                    $user_detail_all = $this->Users->find('all')->where(['OR'=> $filter])->toArray();
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

                           $temp_err[] = 'Invalid appointment detail.';
                        }
                    }
                }
                elseif(empty($app_value['email']) && empty($app_value['phone']) && (!empty($app_value['firstName']) && !empty($app_value['lastName']) && !empty($app_value['dob'])))
                {

                    $enc_first_name = base64_encode($this->CryptoSecurity->encrypt($app_value['firstName'],SEC_KEY));
                    $enc_last_name = base64_encode($this->CryptoSecurity->encrypt($app_value['lastName'],SEC_KEY));
                    $enc_dob = base64_encode($this->CryptoSecurity->encrypt(date('Y-m-d',strtotime($app_value['dob'])),SEC_KEY));

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

                //check user detail is patient detail or not
                if(!empty($user_detail) && $user_detail['role_id'] != 2){

                    $temp_err[] = 'Patient is registered as provider or admin.';
                }

                if(!empty($temp_err)){

                    $error[$appointment_number] = $temp_err;
                    continue;
                }

                //die('ff');

                //schedule appointment and register patient

                $gender = '';
                if(isset($app_value['gender'])){

                    switch ($app_value['gender']) {
                        case 'F':
                            $gender = 0;
                            break;
                        case 'M':
                            $gender = 1;
                            break;
                        case 'O':
                            $gender = 2;
                            break;
                    }
                }

                $appointment_date = ""; 
                $appointment_time = "";

                if(isset($app_value['timezone']) && !empty($app_value['timezone'])){

                    $date = new \DateTime($app_value['appointmentTime'], new \DateTimeZone($app_value['timezone']));
                    //$date->setTimezone(new \DateTimeZone('America/Chicago'));
                    $converted_date =  $date->format("Y-m-d H:i");

                    $appointment_date = date('Y-m-d',strtotime($converted_date)); 
                    $appointment_time = date('H:i',strtotime($converted_date));
                }
                else{

                  $appointment_date = date('Y-m-d',strtotime($app_value['appointmentTime']));
                  $appointment_time = date('H:i',strtotime($app_value['appointmentTime'])); 
                }
                
                $dob = date('Y-m-d',strtotime($app_value['dob']));

               // echo $appointment_time;die;

                //encrypt the appointemt data

                $enc_email = isset($app_value['email']) && $app_value['email'] != '' ? base64_encode($this->CryptoSecurity->encrypt(strtolower($app_value['email']),SEC_KEY)):'';
                $enc_phone = isset($app_value['phone']) && $app_value['phone'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['phone'],SEC_KEY)) : '';
                $enc_first_name = isset($app_value['firstName']) && $app_value['firstName'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['firstName'],SEC_KEY)) : '';
                $enc_last_name = isset($app_value['lastName']) && $app_value['lastName'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['lastName'],SEC_KEY)) : '';
                $enc_dob = $dob != '' ? base64_encode($this->CryptoSecurity->encrypt($dob,SEC_KEY)) : '';
                $enc_gender = in_array($gender, [0,1,2]) ? base64_encode(Security::encrypt($gender, SEC_KEY)) : '';
                $enc_mrn = isset($app_value['mrn']) && $app_value['mrn'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['mrn'],SEC_KEY)) : '';
                $enc_doctor_name = isset($app_value['doctorName']) && $app_value['doctorName'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['doctorName'],SEC_KEY)) : '';
                $enc_appointment_reason = isset($app_value['visitReason']) && $app_value['visitReason'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['visitReason'],SEC_KEY)) : '';
                $enc_appointment_time = $appointment_time != '' ? base64_encode($this->CryptoSecurity->encrypt($appointment_time,SEC_KEY)) : '';

                $enc_country = isset($app_value['country']) && $app_value['country'] != '' ? base64_encode(Security::encrypt($app_value['country'],SEC_KEY)) : '';
                $enc_state = isset($app_value['state']) && $app_value['state'] != '' ? base64_encode(Security::encrypt($app_value['state'], SEC_KEY)):'';
                $enc_city = isset($app_value['city']) && $app_value['city'] != '' ? base64_encode(Security::encrypt($app_value['city'],SEC_KEY)) : '';                
                $enc_address = isset($app_value['address']) && $app_value['address'] != '' ? base64_encode(Security::encrypt($app_value['address'],SEC_KEY)) : '';
                $enc_zip = isset($app_value['zip']) && $app_value['zip'] != '' ? base64_encode(Security::encrypt($app_value['zip'],SEC_KEY)) : '';
                //$enc_appointment_time = $appointment_time;

                $RaceValueFlip = array_flip(array_map('strtolower',$RaceValue));
                $ethinicityValueFlip = array_flip(array_map('strtolower',$ethinicityValue));                

                $enc_race = isset($app_value['race']) && $app_value['race'] != '' ? $RaceValueFlip[strtolower($app_value['race'])]  : '';
                $enc_ethnicity = isset($app_value['ethnicity']) && $app_value['ethnicity'] != '' ? $ethinicityValueFlip[strtolower($app_value['ethnicity'])]  : '';

                $notifyEmailSchedule = [];
                if(!empty($app_value['notifyEmailSchedule'])){

                    foreach ($app_value['notifyEmailSchedule'] as $key => $value) {
                        
                        if(is_numeric($value) && $value > 0){

                            $notifyEmailSchedule[] = $value;
                        }
                    }
                }

                $notifyEmailSchedule = !empty($notifyEmailSchedule) ? array_unique($notifyEmailSchedule) : $notifyEmailSchedule;

                $notifyTextSchedule = [];
                if(!empty($app_value['notifyTextSchedule'])){

                    foreach ($app_value['notifyTextSchedule'] as $key => $value) {
                        
                        if(is_numeric($value) && $value > 0){

                            $notifyTextSchedule[] = $value;
                        }
                    }
                }

                $notifyTextSchedule = !empty($notifyTextSchedule) ? array_unique($notifyTextSchedule) : $notifyTextSchedule;

                //$enc_appointment_date =   $appointment_date != '' ? base64_encode($this->CryptoSecurity->encrypt($appointment_date,SEC_KEY)) : '';

                //register patient
                /*if(empty($user_detail)){

                    $user = $this->Users->newEntity();
                    $user_data = array();
                    $user_data['email'] = $enc_email;
                    $user_data['role_id'] = 2;
                    $user_data['first_name'] = $enc_first_name;
                    $user_data['last_name'] = $enc_last_name;
                    $user_data['phone'] = $enc_phone;
                    $user_data['dob'] = $enc_dob;
                    $user_data['gender'] = $enc_gender;
                    $user = $this->Users->patchEntity($user,$user_data);
                    if(!$user->errors()){

                        $user_detail = $this->Users->save($user);
                    }
                    else{

                        $error[$appointment_number] = $user->errors();
                        continue;
                    }
                }*/

                //schedule appointment for patient
                //if(!empty($user_detail)){
                    $schedule = $this->Schedules->newEntity();
                    $schedule_data = array();
                    $schedule_data['email'] = $enc_email;
                    $schedule_data['first_name'] = $enc_first_name;
                    $schedule_data['last_name'] = $enc_last_name;
                    $schedule_data['phone'] = $enc_phone;
                    $schedule_data['dob'] = $enc_dob;
					$schedule_data['gender'] = $enc_gender;
                    $schedule_data['mrn'] = $enc_mrn;
                    $schedule_data['doctor_name'] = $enc_doctor_name;
                    $schedule_data['appointment_reason'] = $enc_appointment_reason;
                    $schedule_data['provider_id'] = $org_provider_ids['provider_id'];
                    $schedule_data['organization_id'] = $org_provider_ids['organization_id'];
                    $schedule_data['user_id'] = !empty($user_detail) ? $user_detail->id : '';
                    $schedule_data['appointment_date'] = $appointment_date;
                    $schedule_data['appointment_time'] = $enc_appointment_time;
                    $schedule_data['clinical_race'] = $enc_race;
                    $schedule_data['clinical_ethnicity'] = $enc_ethnicity;
                    $schedule_data['country'] = $enc_country;
                    $schedule_data['state'] = $enc_state;
                    $schedule_data['city'] = $enc_city;                    
                    $schedule_data['address'] = $enc_address;
                    $schedule_data['zip'] = $enc_zip;

                    //$schedule_data['timezone'] = isset($app_value['timezone']) && !empty($app_value['timezone']) ? $app_value['timezone'] : "";

                    if(!empty($enc_phone)){

                        $schedule_data['notify_text_schedule'] = !empty($notifyTextSchedule) ? serialize($notifyTextSchedule) : "";
                        $schedule_data['notify_text_remaining_schedule'] = !empty($notifyTextSchedule) ? serialize($notifyTextSchedule) : "";
                    }

                    if(!empty($enc_email)){

                        $schedule_data['notify_email_schedule'] = !empty($notifyEmailSchedule) ? serialize($notifyEmailSchedule) : "";
                        $schedule_data['notify_email_remaining_schedule'] = !empty($notifyEmailSchedule) ? serialize($notifyEmailSchedule) : "";
                    }                    

                   $checkAlreadyAppointment = $this->save_appointment_schedule_data($schedule_data);

                   
                   $mrnCheck = $this->ApiGenaral->mrnVerify($access_token,$app_value['mrn'],$schedule_data);
                   if($mrnCheck == 1)
                   {
                         $error[$appointment_number] = 'Mrn already exists for another patient!';
                         continue;
                   }
                   elseif($mrnCheck == 2)
                   {
                         $error[$appointment_number] = 'This mrn is not assinged with any registered patient';
                         continue;
                   }
                   

                   if(!empty($checkAlreadyAppointment))  //already appointemt scheduled
                   {
                        $error[$appointment_number] = "Appointment has already scheduleded";
                        continue;
                   }
                   

                    
                    if(!empty($app_value['clinicAppointmentId']))
                    {
                        $existSameClinicRecord = $this->Schedules->find('all')->where(['clinic_appointment_id' =>$app_value['clinicAppointmentId'],'organization_id' => $org_provider_ids['organization_id']])->first();

                        if(!empty($existSameClinicRecord))
                        {
                            if(strtotime(date('Y-m-d')) > strtotime($existSameClinicRecord->appointment_date) ){

                                $error[$appointment_number] = "Appointment with clinic appointment id ".$app_value['clinicAppointmentId']." has been expired.";
                            }
                            elseif($existSameClinicRecord->status == 3){

                                $error[$appointment_number] = "Appointment with clinic appointment id ".$app_value['clinicAppointmentId']." has been completed.";
                            }
                            else{

                                $scheduled_appointments[] = array('appointmentId' => $existSameClinicRecord->id, 'clinicAppointmentId' => $existSameClinicRecord->clinic_appointment_id);
                            }
                            continue;
                        }
                    }
                    $schedule_data['clinic_appointment_id'] = !empty($app_value['clinicAppointmentId'])?$app_value['clinicAppointmentId']:'';

                    

                    $schedule = $this->Schedules->patchEntity($schedule,$schedule_data);
                    if(!$schedule->errors()){

                        $link = "#";

                        $schedule_detail = $this->Schedules->save($schedule);

                        /*if(!empty($schedule_detail) && !empty($schedule_detail->id)){

                            //generate the pre-appointent link for send in mail
                            if((isset($app_value['notifyEmail']) && $app_value['notifyEmail'] == 1 && isset($app_value['email']) && !empty($app_value['email'])) || (isset($app_value['notifyText']) && $app_value['notifyText'] == 1 && isset($app_value['phone']) && !empty($app_value['phone'])) ){

                                    //here v denote that we need to verify the user
                                    $iframe_enid = $schedule_detail->id.'S'.'0V';
                                    $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                                    $schedule_detail->go_through_medical_history = 0;
                                    $schedule_detail->iframe_enid = $iframe_enid;
                                    $schedule_detail->iframe_enid_created_at = date('Y-m-d H:i:s');
                                    $this->Schedules->save($schedule_detail);
                                    $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid);
                            }
                        }*/

                        $scheduled_appointments[] = array('appointmentId' => $schedule_detail->id, 'clinicAppointmentId' => $schedule_detail->clinic_appointment_id);


                        //set the links for send text massage or email to patient
                        $clinic_name = !empty($organization_detail) ? $organization_detail->organization_name : 'clinic';

                        $org_logo = !empty($organization_detail) && !empty($organization_detail->clinic_logo) ? WEBROOT.'img/'.$organization_detail->clinic_logo : WEBROOT."images/logo.png";
                        

                        //send email to patient
                        if(!empty($schedule_detail) && isset($app_value['notifyEmail']) && $app_value['notifyEmail'] == 1 && isset($app_value['email']) && !empty($app_value['email'])){

                            $iframe_enid = $schedule_detail->id.'S'.'0V';
                            $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                            $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid); 
                            $schedule_token = $this->ScheduleToken->newEntity();
                            $schedule_token->schedule_id = $schedule_detail->id;
                            $schedule_token->iframe_enid = $iframe_enid;
                            $this->ScheduleToken->save($schedule_token);

                            try{

                                $mailData = array(
                                    'provider_id' => $org_provider_ids['provider_id'],
                                    'username' => $app_value['firstName'],
                                    'slug' => 'api_notification',
                                    'email' => $app_value['email'],
                                    'replaceString' => array('{username}','{clinic}','{link}','{logo}'),
                                    'replaceData' => array($app_value['firstName'],$clinic_name,$link,$org_logo),
                                );

                                $this->ProviderMailSend->send($mailData);
                            }
                            catch(\Exception $e){
                                
                            }
                        }

                        //send text message to patient
                        if(!empty($schedule_detail) && isset($app_value['notifyText']) && $app_value['notifyText'] == 1 && isset($app_value['phone']) && !empty($app_value['phone'])){

                            $iframe_enid = $schedule_detail->id.'S'.'0V';
                            $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                            $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid); 
                            $schedule_token = $this->ScheduleToken->newEntity();
                            $schedule_token->schedule_id = $schedule_detail->id;
                            $schedule_token->iframe_enid = $iframe_enid;
                            $this->ScheduleToken->save($schedule_token);

                            try{

                                $mailData = array(
                                    'provider_id' => $org_provider_ids['provider_id'],
                                    'slug' => 'api_notification',
                                    'phone' => $app_value['phone'],
                                    'replaceString' => array('{username}','{clinic}','{link}'),
                                    'replaceData' => array($app_value['firstName'],$clinic_name,$link),
                                );
                                $this->TextMsgSend->send( $mailData);
                            }
                            catch(\Exception $e){

                            }
                        }
                    }
                    else{

                        $error[$appointment_number] = $schedule->errors();
                        continue;
                    }
               // }
            }


            $header = array(
                    'statusCode' => 200,
                    'message' => 'Result of scheduled appointments'
                );

            $payload = array(
                'totalScheduledAppointments' => count($scheduled_appointments),
                'resultOfScheduleAppointment' => $scheduled_appointments,
                'errors' => $error
            );

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){

            echo $e;die;

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

    }



    public function scheduleAppointmentMrn()
    {
        try{
            $this->loadModel('Users');
            $this->loadModel('Schedules');
            $this->loadModel('ProviderEmailTemplates');
            $this->loadModel('Organizations');
            $response = array();
            $mrnCheck = '';            
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $appointment_data = $this->request->data('appointmentData');
            if(empty($appointment_data)){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Appointment data is blank.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(!is_array($appointment_data)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid appointment data format.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $appointment_data = array_filter($appointment_data);
            $access_token = $this->request->data('accessToken');
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);
            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }
            
            //get the email templete
            $email_templete = $this->ProviderEmailTemplates->find('all')->where(['provider_id' => $org_provider_ids['provider_id'],'slug' => 'pre_appointment_form_link'])->first();
            $organization_detail = $this->Organizations->find('all')->where(['id' => $org_provider_ids['organization_id']])->first();
            //start processing the appointment data


            $error = array();
            $scheduled_appointments = array();
            $app_count = 1;

            foreach ($appointment_data as $app_key => $app_value) {

                $app_value = array_filter($app_value);
                $temp_err = array();
                $appointment_number = $app_key+1; 
                //validate the appointment data

                //required field validation
                if(!isset($app_value['mrn']) || (isset($app_value['mrn']) && empty($app_value['mrn']))){
                    
                    $temp_err[] = 'Mrn is required.';

                }

                if(isset($app_value['timezone']) && !empty($app_value['timezone']) && !in_array($app_value['timezone'],['PST','MST','CST','EST','HST'])){

                    $temp_err[] = 'Invalid timezone.';
                }

                if(!isset($app_value['appointmentTime']) || (isset($app_value['appointmentTime']) && empty($app_value['appointmentTime']))){

                    $temp_err[] = 'Appointment time is required.';
                }

                $timezone = isset($app_value['timezone']) && !empty($app_value['timezone']) ? $app_value['timezone'] : 'CST';

                if(isset($app_value['appointmentTime']) && !empty($app_value['appointmentTime'])){

                    $date = new \DateTime($app_value['appointmentTime'], new \DateTimeZone($timezone));
                   // $date->setTimezone(new \DateTimeZone('America/Chicago'));
                    $appointment_date =  strtotime($date->format("Y-m-d H:i"));

                    $current_date = strtotime(date('Y-m-d H:i'));

                    if(isset($app_value['appointmentTime']) && $appointment_date < $current_date){

                        $temp_err[] = 'Invalid appointment time.';
                    }
                }
                

                //email validation check is still pending 
                if(isset($app_value['notifyEmailSchedule']) && !is_array($app_value['notifyEmailSchedule'])){

                    $temp_err[] = 'notifyEmailSchedule must be an array.';
                }

                if(isset($app_value['notifyTextSchedule']) && !is_array($app_value['notifyTextSchedule'])){

                    $temp_err[] = 'notifyTextSchedule must be an array.';
                }

                $user_detail = null;

                //check patient is registered or not on allevia platform            

                if(!empty($temp_err)){

                    $error[$appointment_number] = $temp_err;
                    continue;
                }
               

                //schedule appointment and register patient              
                $appointment_date = ""; 
                $appointment_time = "";

                if(isset($app_value['timezone']) && !empty($app_value['timezone'])){

                    $date = new \DateTime($app_value['appointmentTime'], new \DateTimeZone($app_value['timezone']));
                    //$date->setTimezone(new \DateTimeZone('America/Chicago'));
                    $converted_date =  $date->format("Y-m-d H:i");

                    $appointment_date = date('Y-m-d',strtotime($converted_date)); 
                    $appointment_time = date('H:i',strtotime($converted_date));
                }
                else{

                  $appointment_date = date('Y-m-d',strtotime($app_value['appointmentTime']));
                  $appointment_time = date('H:i',strtotime($app_value['appointmentTime'])); 
                }             

                //encrypt the appointemt data                                                               
                $enc_mrn = isset($app_value['mrn']) && $app_value['mrn'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['mrn'],SEC_KEY)) : '';
                $enc_doctor_name = isset($app_value['doctorName']) && $app_value['doctorName'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['doctorName'],SEC_KEY)) : '';
                $enc_appointment_reason = isset($app_value['visitReason']) && $app_value['visitReason'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['visitReason'],SEC_KEY)) : '';
                $enc_appointment_time = $appointment_time != '' ? base64_encode($this->CryptoSecurity->encrypt($appointment_time,SEC_KEY)) : '';
                $notifyEmailSchedule = [];
                if(!empty($app_value['notifyEmailSchedule'])){

                    foreach ($app_value['notifyEmailSchedule'] as $key => $value) {
                        
                        if(is_numeric($value) && $value > 0){

                            $notifyEmailSchedule[] = $value;
                        }
                    }
                }

                $notifyEmailSchedule = !empty($notifyEmailSchedule) ? array_unique($notifyEmailSchedule) : $notifyEmailSchedule;

                $notifyTextSchedule = [];
                if(!empty($app_value['notifyTextSchedule'])){

                    foreach ($app_value['notifyTextSchedule'] as $key => $value) {
                        
                        if(is_numeric($value) && $value > 0){

                            $notifyTextSchedule[] = $value;
                        }
                    }
                }

                  $notifyTextSchedule = !empty($notifyTextSchedule) ? array_unique($notifyTextSchedule) : $notifyTextSchedule;  


                    $checkMrnAlreadyExist = $this->Schedules->find('all')->where(['mrn' =>$enc_mrn, 'user_id IS NOT NULL'])->first();

                  

                    if(empty($checkMrnAlreadyExist))
                    {
                        $error[$appointment_number] = "Mrn does not exist";
                        continue;
                    }            

                //schedule appointment for patient
                //if(!empty($user_detail)){
                    $schedule = $this->Schedules->newEntity();
                    $schedule_data = array();
                    $schedule_data['email'] = !empty($checkMrnAlreadyExist['email'])?$checkMrnAlreadyExist['email']:'';
                    $schedule_data['first_name'] = !empty($checkMrnAlreadyExist['first_name'])?$checkMrnAlreadyExist['first_name']:'';
                    $schedule_data['last_name'] = !empty($checkMrnAlreadyExist['last_name'])?$checkMrnAlreadyExist['last_name']:'';
                    $schedule_data['phone'] = !empty($checkMrnAlreadyExist['phone'])?$checkMrnAlreadyExist['phone']:'';
                    $schedule_data['dob'] = !empty($checkMrnAlreadyExist['dob'])?$checkMrnAlreadyExist['dob']:'';
                    $schedule_data['gender'] = !empty($checkMrnAlreadyExist['gender'])?$checkMrnAlreadyExist['gender']:'';
                    $schedule_data['mrn'] = $enc_mrn;
                    $schedule_data['doctor_name'] = $enc_doctor_name;
                    $schedule_data['appointment_reason'] = $enc_appointment_reason;
                    $schedule_data['provider_id'] = $org_provider_ids['provider_id'];
                    $schedule_data['organization_id'] = $org_provider_ids['organization_id'];
                    $schedule_data['user_id'] = !empty($checkMrnAlreadyExist['user_id'])?$checkMrnAlreadyExist['user_id']:'';
                    $schedule_data['appointment_date'] = $appointment_date;
                    $schedule_data['appointment_time'] = $enc_appointment_time;
                    $schedule_data['clinical_race'] = !empty($checkMrnAlreadyExist['clinical_race'])?$checkMrnAlreadyExist['clinical_race']:'';
                    $schedule_data['clinical_ethnicity'] = !empty($checkMrnAlreadyExist['clinical_ethnicity'])?$checkMrnAlreadyExist['clinical_ethnicity']:'';
                    $schedule_data['country'] = !empty($checkMrnAlreadyExist['country'])?$checkMrnAlreadyExist['country']:'';
                    $schedule_data['state'] = !empty($checkMrnAlreadyExist['state'])?$checkMrnAlreadyExist['state']:'';
                    $schedule_data['city'] = !empty($checkMrnAlreadyExist['city'])?$checkMrnAlreadyExist['city']:'';                   
                    $schedule_data['address'] = !empty($checkMrnAlreadyExist['address'])?$checkMrnAlreadyExist['address']:'';      
                    $schedule_data['zip'] = !empty($checkMrnAlreadyExist['zip'])?$checkMrnAlreadyExist['zip']:'';  

                    $app_value['email'] =  $this->CryptoSecurity->decrypt(base64_decode($checkMrnAlreadyExist['email']),SEC_KEY);
                    $app_value['phone'] =  $this->CryptoSecurity->decrypt(base64_decode($checkMrnAlreadyExist['phone']),SEC_KEY);
                    $app_value['firstName'] =  $this->CryptoSecurity->decrypt(base64_decode($checkMrnAlreadyExist['first_name']),SEC_KEY);
                    //$schedule_data['timezone'] = isset($app_value['timezone']) && !empty($app_value['timezone']) ? $app_value['timezone'] : "";

                    if(!empty($checkMrnAlreadyExist['phone'])){

                        $schedule_data['notify_text_schedule'] = !empty($notifyTextSchedule) ? serialize($notifyTextSchedule) : "";
                        $schedule_data['notify_text_remaining_schedule'] = !empty($notifyTextSchedule) ? serialize($notifyTextSchedule) : "";
                    }

                    if(!empty($checkMrnAlreadyExist['email'])){

                        $schedule_data['notify_email_schedule'] = !empty($notifyEmailSchedule) ? serialize($notifyEmailSchedule) : "";
                        $schedule_data['notify_email_remaining_schedule'] = !empty($notifyEmailSchedule) ? serialize($notifyEmailSchedule) : "";
                    }     

                                 

                    $checkAlreadyAppointment = $this->save_appointment_schedule_data_mrn($schedule_data);
                   //pr($checkAlreadyAppointment);die;
                                  

                    if(!empty($checkAlreadyAppointment))  //already appointemt scheduled
                    {
                        $error[$appointment_number] = "Appointment has already scheduleded";
                        continue;
                    }                    

                    $schedule = $this->Schedules->patchEntity($schedule,$schedule_data);
                    if(!$schedule->errors()){

                        $link = "#";

                        $schedule_detail = $this->Schedules->save($schedule);                      

                        $scheduled_appointments[] = array('appointmentId' => $schedule_detail->id);


                        //set the links for send text massage or email to patient
                        $clinic_name = !empty($organization_detail) ? $organization_detail->organization_name : 'clinic';

                        $org_logo = !empty($organization_detail) && !empty($organization_detail->clinic_logo) ? WEBROOT.'img/'.$organization_detail->clinic_logo : WEBROOT."images/logo.png";
                        

                        //send email to patient
                        if(!empty($schedule_detail) && isset($app_value['notifyEmail']) && $app_value['notifyEmail'] == 1 && isset($app_value['email']) && !empty($app_value['email'])){

                            $iframe_enid = $schedule_detail->id.'S'.'0V';
                            $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                            $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid); 
                            $schedule_token = $this->ScheduleToken->newEntity();
                            $schedule_token->schedule_id = $schedule_detail->id;
                            $schedule_token->iframe_enid = $iframe_enid;
                            $this->ScheduleToken->save($schedule_token);

                            try{

                                $mailData = array(
                                    'provider_id' => $org_provider_ids['provider_id'],
                                    'username' => $app_value['firstName'],
                                    'slug' => 'api_notification',
                                    'email' => $app_value['email'],
                                    'replaceString' => array('{username}','{clinic}','{link}','{logo}'),
                                    'replaceData' => array($app_value['firstName'],$clinic_name,$link,$org_logo),
                                );

                                $this->ProviderMailSend->send($mailData);
                            }
                            catch(\Exception $e){
                                
                            }
                        }

                        //send text message to patient
                        if(!empty($schedule_detail) && isset($app_value['notifyText']) && $app_value['notifyText'] == 1 && isset($app_value['phone']) && !empty($app_value['phone'])){

                            $iframe_enid = $schedule_detail->id.'S'.'0V';
                            $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                            $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid); 
                            $schedule_token = $this->ScheduleToken->newEntity();
                            $schedule_token->schedule_id = $schedule_detail->id;
                            $schedule_token->iframe_enid = $iframe_enid;
                            $this->ScheduleToken->save($schedule_token);

                            try{

                                $mailData = array(
                                    'provider_id' => $org_provider_ids['provider_id'],
                                    'slug' => 'api_notification',
                                    'phone' => $app_value['phone'],
                                    'replaceString' => array('{username}','{clinic}','{link}'),
                                    'replaceData' => array($app_value['firstName'],$clinic_name,$link),
                                );
                                $this->TextMsgSend->send( $mailData);
                            }
                            catch(\Exception $e){

                            }
                        }
                    }
                    else{

                        $error[$appointment_number] = $schedule->errors();
                        continue;
                    }
               // }
            }

            if(!empty($error))
            {
                $header = array(
                    'statusCode' => 402,
                    'message' => 'Result of scheduled appointments'
                );
            }
            else
            {
                $header = array(
                    'statusCode' => 200,
                    'message' => 'Result of scheduled appointments'
                );
            }
            $payload = array(
                'totalScheduledAppointments' => count($scheduled_appointments),
                'resultOfScheduleAppointment' => $scheduled_appointments,
                'errors' => $error
            );

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

    }


    public function allAppointments(){

        try
        {
            $this->loadModel('Schedule');
            $this->loadModel('ProviderGlobalSettings');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $access_token = $this->request->data('accessToken');
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);
            $timezone = $this->request->data('timezone');

            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }   
             

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            if(!empty($timezone) && !in_array($timezone,['PST','MST','CST','EST','HST'])){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Timezone must be in PST, MST, CST, EST, HST.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $providerTimeZone = 'CST';         

            if(!empty($org_provider_ids) && isset($org_provider_ids['provider_id'])){
            $providerGlobalSetting =   $this->ProviderGlobalSettings->find('all')->where(['provider_id' => $org_provider_ids['provider_id']])->first();

                if(!empty($providerGlobalSetting) && !empty($providerGlobalSetting['timezone']))
                {
                    $providerTimeZone = $providerGlobalSetting['timezone'];
                } 
           }            

            $schedule_data = $this->Schedule->find('all',array('order' => ['Schedule.id' => 'desc']))->where(['Date(Schedule.appointment_date) >=' => date('Y-m-d')])->where(['Schedule.organization_id' =>$org_provider_ids['organization_id'],'Schedule.provider_id' => $org_provider_ids['provider_id']])
            ->contain(['Doctors'])
            ->toArray();

            $appointments = array();

            if(!empty($schedule_data) && is_array($schedule_data)){

                foreach ($schedule_data as $key => $value) {

                    $status = 'pending';
                        switch ($value->status) {
                            case 2:
                                $status = 'in-progress';
                                break;
                            case 3:
                                $status = 'completed';
                                break;
                        }

                    $appointment_date = $value->appointment_date;
                    $appointment_time = $value->appointment_time;
                    if(!empty($appointment_time)){

                        $appointment_time = $this->CryptoSecurity->decrypt(base64_decode($appointment_time),SEC_KEY);
                    }
                    //pr($appointment_time);die;

                    $appointment_date_time = $appointment_date;

                    //merge date and time
                    if(!empty($appointment_time)){

                        if(strpos($appointment_time, "-") !== false){

                            $temp_time = explode("-", $appointment_time);
                           // $send_reminder_time = '';
                            if(isset($temp_time[1]) && !empty(trim($temp_time[1]))){

                                $appointment_time = trim($temp_time[1]);
                            }
                        }

                        $hours = date('H',strtotime($appointment_time));
                        $mintus = date('i',strtotime($appointment_time));
                        // pr('hours '.$hours);
                        // pr('mintus '.$mintus);
                        $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$hours.'hours'));
                        $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$mintus.'minutes'));

                        //pr('appointment_date_time '.$appointment_date_time);
                    }


                    if(!empty($timezone)){

                        $appointment_date_time = $this->ApiGenaral->timezoneConverter($appointment_date_time, $providerTimeZone, $timezone);
                        //$appointment_date_time = $appointment_date_time;
                    }
                    else{

                       //$appointment_date = date('Y-m-d',$appointment_date);
                       $timezone = 'CST';
                    }

                    $appointments[] = array(

                        'encounterId' => $value->id,
                        'clinicAppointmentId' => !empty($value->clinic_appointment_id) ? $value->clinic_appointment_id : "",
                        'firstName' => !empty($value->first_name) ? $this->CryptoSecurity->decrypt(base64_decode($value->first_name),SEC_KEY) : '',
                        'lastName' => !empty($value->last_name) ? $this->CryptoSecurity->decrypt(base64_decode($value->last_name),SEC_KEY) : '',
                        'email' => !empty($value->email) ? $this->CryptoSecurity->decrypt(base64_decode($value->email),SEC_KEY) : '',
                        'mrn' => !empty($value->mrn) ? $this->CryptoSecurity->decrypt(base64_decode($value->mrn),SEC_KEY) : '',
                        'phone' => !empty($value->phone) ? $this->CryptoSecurity->decrypt(base64_decode($value->phone),SEC_KEY) : '',
                        'dob' => !empty($value->dob) ? $this->CryptoSecurity->decrypt(base64_decode($value->dob),SEC_KEY) : '',
                        'visitReason' => !empty($value->appointment_reason) ? $this->CryptoSecurity->decrypt(base64_decode($value->appointment_reason),SEC_KEY) : '',
                        'appointmentTime' => $appointment_date_time,
                        'status' => $status
                    );
                }
            }

           // die;

            $header = array(
                'statusCode' => 200,
                'message' => 'All appointments list'
            );

            $payload = array(

                'totalAppointments' => count($schedule_data),
                'timezone' => $timezone,
                'appointments' => $appointments
            );

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
    }


    public function allAppointmentsByMrn(){
        try
        {
            $this->loadModel('Schedule');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $access_token = $this->request->data('accessToken');
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);
            $timezone = $this->request->data('timezone');
            $mrn = $this->request->data('mrn');

            pr($org_provider_ids);die;

            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            if(!empty($timezone) && !in_array($timezone,['PST','MST','CST','EST','HST'])){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Timezone must be in PST, MST, CST, EST, HST.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($mrn))
            {
                $header = array(
                    'statusCode' => 400,
                    'message' => 'Mrn is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }  

             $mrn = base64_encode($this->CryptoSecurity->encrypt($mrn,SEC_KEY));
             $schedulesDetails = $this->Schedule->find('all')->where(['mrn' => $mrn])->first();               
             if(empty($schedulesDetails))
             {
                 $header = array(
                    'statusCode' => 400,
                    'message' => 'Mrn is not valid.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
             } 

            // $schedule_data = $this->Schedule->find('all',array('order' => ['Schedule.id' => 'desc']))->where(['Date(Schedule.appointment_date) >=' => date('Y-m-d')])->where(['Schedule.mrn' =>$mrn])
            // ->toArray(); 
            $schedule_data = $this->Schedule->find('all',array('order' => ['Schedule.id' => 'desc']))->where(['Schedule.mrn' =>$mrn,'   organization_id' =>$org_provider_ids['organization_id']])->toArray(); 

            if(empty($schedule_data))
             {
                 $header = array(
                    'statusCode' => 400,
                    'message' => 'Appointments not exists with this clinic.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
             }           

            $appointments = array();

            if(!empty($schedule_data) && is_array($schedule_data)){

                foreach ($schedule_data as $key => $value) {

                    $status = 'pending';
                        switch ($value->status) {
                            case 2:
                                $status = 'in-progress';
                                break;
                            case 3:
                                $status = 'completed';
                                break;
                        }

                    $appointment_date = $value->appointment_date;
                    $appointment_time = $value->appointment_time;
                    if(!empty($appointment_time)){

                        $appointment_time = $this->CryptoSecurity->decrypt(base64_decode($appointment_time),SEC_KEY);
                    }                   

                    $appointment_date_time = $appointment_date;

                    //merge date and time
                    if(!empty($appointment_time)){

                        if(strpos($appointment_time, "-") !== false){

                            $temp_time = explode("-", $appointment_time);
                           // $send_reminder_time = '';
                            if(isset($temp_time[1]) && !empty(trim($temp_time[1]))){

                                $appointment_time = trim($temp_time[1]);
                            }
                        }

                        $hours = date('H',strtotime($appointment_time));
                        $mintus = date('i',strtotime($appointment_time));
                        // pr('hours '.$hours);
                        // pr('mintus '.$mintus);
                        $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$hours.'hours'));
                        $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$mintus.'minutes'));

                        //pr('appointment_date_time '.$appointment_date_time);
                    }
                    if(!empty($timezone)){

                        $appointment_date_time = $this->ApiGenaral->timezoneConverter($appointment_date_time, 'CST', $timezone);
                    }
                    else{

                       //$appointment_date = date('Y-m-d',$appointment_date);
                       $timezone = 'CST';
                    }

                    $appointments[] = array(

                        'encounterId' => $value->id,
                        'clinicAppointmentId' => !empty($value->clinic_appointment_id) ? $value->clinic_appointment_id : "",
                        'firstName' => !empty($value->first_name) ? $this->CryptoSecurity->decrypt(base64_decode($value->first_name),SEC_KEY) : '',
                        'lastName' => !empty($value->last_name) ? $this->CryptoSecurity->decrypt(base64_decode($value->last_name),SEC_KEY) : '',
                        'email' => !empty($value->email) ? $this->CryptoSecurity->decrypt(base64_decode($value->email),SEC_KEY) : '',
                        'mrn' => !empty($value->mrn) ? $this->CryptoSecurity->decrypt(base64_decode($value->mrn),SEC_KEY) : '',
                        'phone' => !empty($value->phone) ? $this->CryptoSecurity->decrypt(base64_decode($value->phone),SEC_KEY) : '',
                        'dob' => !empty($value->dob) ? $this->CryptoSecurity->decrypt(base64_decode($value->dob),SEC_KEY) : '',
                        'visitReason' => !empty($value->appointment_reason) ? $this->CryptoSecurity->decrypt(base64_decode($value->appointment_reason),SEC_KEY) : '',
                        'appointmentTime' => $appointment_date_time,
                        'status' => $status
                    );
                }
            }

           // die;
            $header = array(
                'statusCode' => 200,
                'message' => 'All appointments list'
            );

            $payload = array(
                'totalAppointments' => count($schedule_data),
                'timezone' => $timezone,
                'appointments' => $appointments
            );

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
    }




    public function deleteAppointment()
    {
        try
        {
            $this->loadModel('Schedule');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $access_token = $this->request->data('accessToken');
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);

            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            $encounter_ids = $this->request->data('encounterIds');
            $clinic_appointment_ids = $this->request->data('clinicAppointmentIds');

            /*if(empty($encounter_ids)){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Encounter ids is empty.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }*/

            if(empty($encounter_ids) && empty($clinic_appointment_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Encounter ids or clinic apointment ids, one of them is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            //$encounter_ids = explode(",", $encounter_ids);

            if(!empty($encounter_ids) && !is_array($encounter_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Encounter ids should be a array.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(!empty($clinic_appointment_ids) && !is_array($clinic_appointment_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Clinic apointment ids should be a array.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $scheduled_appointment = null;

            if(!empty($clinic_appointment_ids)){

               $scheduled_appointment = $this->Schedule->find('all')->where(['clinic_appointment_id IN' =>$clinic_appointment_ids,'organization_id' => $org_provider_ids['organization_id']])->toArray();
            }

            if(!empty($encounter_ids)){

               $scheduled_appointment = $this->Schedule->find('all')->where(['id IN' =>$encounter_ids])->toArray();
            }

            if(empty($scheduled_appointment)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointments not found.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $error = array();
            $deleted_appointments = array();

            foreach ($scheduled_appointment as $key => $value) {

                if($value->status == 3){

                    $error[$value->id] = 'Completed appointment could not be deleted.';
                    continue;
                }

                $appointment_date = strtotime($value->appointment_date);
                //echo $appointment_date.'  '.strtotime(date('Y-m-d'));die;
                if(strtotime(date('Y-m-d')) > $appointment_date){

                    $error[$value->id] = 'Past appointment could not be deleted.';
                    continue;
                }
                $deleted_appointments[] = $value->id;
                $this->Schedule->delete($value);
            }


            $header = array(
                    'statusCode' => 200,
                    'message' => 'Deleted Appointments list'
                );
            $payload = array('deletedAppointments' => $deleted_appointments,'error' => $error);

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
    }

    public function accessPreAppointmentquestionnaire()
    {
        try
        {
            $this->loadModel('Schedule');
			$this->loadModel('Users');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $access_token = $this->request->data('accessToken');
            $redirectUri = $this->request->data('redirectUri');

            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);
            $checkRedirectUri = "";

            if(!empty($redirectUri)){
                $checkRedirectUri = $this->checkRedirectUri($redirectUri,$org_provider_ids['organization_id']);
            }

            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }


            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            $encounter_id = $this->request->data('encounterId');
            $clinic_appoinment_id = $this->request->data('clinicAppointmentId');
            if(empty($encounter_id) && empty($clinic_appoinment_id)){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Encounter id or clinic apointment id, one of them is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $go_through_medical_history = $this->request->data('goThroughMedicalHistory');
            $go_through_medical_history = empty($go_through_medical_history) ? 0 : $go_through_medical_history;
            if(!in_array($go_through_medical_history, [0,1])){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Values should be 0 or 1 for go through medical history parameter.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(!empty($encounter_id) && !empty($clinic_appoinment_id))
            {
                $scheduled_appointment = $this->Schedule->find('all')->where(['id' => $encounter_id,'clinic_appointment_id' => $clinic_appoinment_id,'organization_id' => $org_provider_ids['organization_id'] ])->first();

                     if(empty($scheduled_appointment)){

                            $header = array(
                                'statusCode' => 402,
                                'message' => 'Appointment not found.'
                            );
                            $response = ['header' => $header];
                            return $this->response->withType("application/json")->withStringBody(json_encode($response));
                      }

                      if($scheduled_appointment->status == 3){

                            $header = array(
                            'statusCode' => 402,
                            'message' => 'Appointment has been completed.'
                            );

                            $response = ['header' => $header];
                            return $this->response->withType("application/json")->withStringBody(json_encode($response));
                        }

            }
            elseif(!empty($encounter_id) && empty($clinic_appoinment_id)) {

                $scheduled_appointment = $this->Schedule->find('all')->where(['id' => $encounter_id,'organization_id' => $org_provider_ids['organization_id']])->first();

                if(empty($scheduled_appointment)){

                            $header = array(
                                'statusCode' => 402,
                                'message' => 'Appointment not found.'
                            );
                            $response = ['header' => $header];
                            return $this->response->withType("application/json")->withStringBody(json_encode($response));
                      }

                      if($scheduled_appointment->status == 3){

                            $header = array(
                            'statusCode' => 402,
                            'message' => 'Appointment has been completed.'
                            );

                            $response = ['header' => $header];
                            return $this->response->withType("application/json")->withStringBody(json_encode($response));
                        }
            }
            elseif(empty($encounter_id) && !empty($clinic_appoinment_id)) {

                $scheduled_appointment = $this->Schedule->find('all')->where(['clinic_appointment_id' => $clinic_appoinment_id,'organization_id' => $org_provider_ids['organization_id']])->first();

                if(empty($scheduled_appointment)){

                            $header = array(
                                'statusCode' => 402,
                                'message' => 'Appointment not found.'
                            );
                            $response = ['header' => $header];
                            return $this->response->withType("application/json")->withStringBody(json_encode($response));
                      }

                      if($scheduled_appointment->status == 3){

                            $header = array(
                            'statusCode' => 402,
                            'message' => 'Appointment has been completed.'
                            );

                            $response = ['header' => $header];
                            return $this->response->withType("application/json")->withStringBody(json_encode($response));
                        }

                # code...
            }

            // $scheduled_appointment = $this->Schedule->find('all')->where(['OR' => array('id' => $encounter_id,
            //                                                   'clinic_appointment_id' => $clinic_appoinment_id
            //                                                 )])->first();

            $appointment_date = strtotime($scheduled_appointment->appointment_date);

            if(strtotime(date('Y-m-d')) > $appointment_date){

                $header = array(
                'statusCode' => 402,
                'message' => 'Your appointment has been expired, Please schedule appointment again.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            /*if(strtotime(date('Y-m-d')) < $appointment_date){

                $header = array(
                'statusCode' => 402,
                'message' => 'Your appointment has been scheduled on '.$scheduled_appointment->appointment_date.'.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }*/




            $iframe_enid = $scheduled_appointment->id.'S'.$go_through_medical_history;
            $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
            $scheduled_appointment->go_through_medical_history = $go_through_medical_history;
            //$scheduled_appointment->iframe_enid = $iframe_enid;
            //$scheduled_appointment->iframe_enid_created_at = date('Y-m-d H:i:s');
            $scheduled_appointment->bare_bones = $this->request->getData('bareBones');
		    $scheduled_appointment->skip_registration = $this->request->getData('skipRegistration');
            $scheduled_appointment->api_redirect_uri = isset($checkRedirectUri['redirectUri']) && !empty($checkRedirectUri['redirectUri']) ? $checkRedirectUri['redirectUri'] : "";

            $schedule_token = $this->ScheduleToken->newEntity();
            $schedule_token->schedule_id = $scheduled_appointment->id;
            $schedule_token->iframe_enid = $iframe_enid;
            $this->ScheduleToken->save($schedule_token);


            if($this->Schedule->save($scheduled_appointment)){

				$user_detail_data = $this->General->is_registered($scheduled_appointment);
                              
								if($scheduled_appointment['skip_registration'] == 1 && empty($user_detail_data))
								{
									$user = $this->Users->newEntity();
									$dec_phone =$this->CryptoSecurity->decrypt(base64_decode($scheduled_appointment['phone']),SEC_KEY);
									$dec_phone =str_replace("-", '', $dec_phone);
									$enc_phone = base64_encode($this->CryptoSecurity->encrypt($dec_phone,SEC_KEY));
									$data = array(
										'role_id' => 2,
										'first_name'=> $scheduled_appointment['first_name'],
										'last_name' => $scheduled_appointment['last_name'],
										'phone' => $enc_phone,
										'email' => $scheduled_appointment['email'],
										'dob' => $scheduled_appointment['dob'],
										'organization_id' => $scheduled_appointment['organization_id'],
										'gender' => $scheduled_appointment['gender'],
									);

									$user = $this->Users->patchEntity($user, $data);

									if(!$user->errors()){

										if($record = $this->Users->save($user)){

											if(!empty($scheduled_appointment) && isset($record['id'])){

												$this->Schedule->updateAll(['user_id' => $record->id],['id' => $scheduled_appointment['id']]);
											}
											//save data of provider logout in user activities table
									    //$this->General->userActivity(['action_performed' => 2, 'user_id' => $scheduled_appointment['provider_id']]);
											//$registerd_user = $this->Users->find('all')->where(['id' =>$record['id']])->first()->toArray();
											//$this->Auth->setUser($registerd_user);
											//save data of patient login in user activities table
										  //$this->General->userActivity(['action_performed' => 1, 'user_id' => $record['id']]);
										}
									}
								}
                                else{

                                    if(!empty($scheduled_appointment) && !empty($user_detail_data)){

                                        $this->Schedule->updateAll(['user_id' => $user_detail_data->id],['id' => $scheduled_appointment['id']]);
                                    }  
                                }
                $url = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid);
                $header = array(
                    'statusCode' => 200,
                    'message' => 'Pre-appointment form link.'
                );

                $payload = array('preAppointmentLink' => $url);
                $response = ['header' => $header,'payload' => $payload];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
            else{
                $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal server error, Please try again.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
        }
        catch(\Exception $e){

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

    }


    public function viewNote()
    {
        try
        {
            $this->loadModel('Schedule');
            $this->loadModel('ChiefCompliantUserdetails');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $access_token = $this->request->data('accessToken');
            $encounter_id = $this->request->data('encounterId');
            $format = $this->request->data('format');

            $clinic_appointment_id = $this->request->data('clinicAppointmentId');
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);
            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            $timezone = $this->request->data('timezone');
            if(!empty($timezone) && !in_array($timezone,['PST','MST','CST','EST','HST'])){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Timezone must be in PST, MST, CST, EST, HST.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($encounter_id) && empty($clinic_appointment_id)){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Encounter id or clinic apointment id, one of them is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($format))
            {
                $header = array(
                    'statusCode' => 400,
                    'message' => 'Format is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }  

            if(!in_array($format, ['FHIR','readable','raw','rawAndReadable']))
            {
                $header = array(
                    'statusCode' => 400,
                    'message' => 'Format should only FHIR, readable, raw, rawAndReadable.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }   

            $schedule_data = null;

            if(!empty($encounter_id)){

                $schedule_data = $this->Schedule->find('all')->where(['id' => $encounter_id,'organization_id' => $org_provider_ids['organization_id']])->first();

                if(empty($schedule_data)){

                    $header = array(
                        'statusCode' => 402,
                        'message' => 'Invalid appointment id.'
                    );

                    $response = ['header' => $header];
                    return $this->response->withType("application/json")->withStringBody(json_encode($response));

                }
            }

            if(!empty($clinic_appointment_id)){

                $schedule_data = $this->Schedule->find('all')->where(['clinic_appointment_id' => $clinic_appointment_id,'organization_id' => $org_provider_ids['organization_id']])->first();

                if(empty($schedule_data)){

                    $header = array(
                        'statusCode' => 402,
                        'message' => 'Invalid clinic appointment id.'
                    );

                    $response = ['header' => $header];
                    return $this->response->withType("application/json")->withStringBody(json_encode($response));

                }
            }

            if(empty($schedule_data)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointment not found.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if($schedule_data->status != 3){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointment has not completed.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));

            }

             $appointment_data = $this->ChiefCompliantUserdetails->find('all')->where(['appointment_id' => $schedule_data['appointment_id']])->first();

            if(empty($appointment_data)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointment not found.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(!in_array($appointment_data['current_step_id'],[18,19,21,25,1,2,16,4,17])){

                $header = array(
                    'statusCode' => 503,
                    'message' => 'Appointment note is available for oncology,chronic care, and internal medication module only.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($appointment_data['ehr_note_json'])){

                $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($appointment_data['ehr_note_json_readable'])){

                $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($appointment_data['ehr_note_json_raw'])){

                $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if($format == 'FHIR')
            {
                $note = json_decode(Security::decrypt(base64_decode($appointment_data['ehr_note_json']),SEC_KEY));    
            }
            else if ($format == 'readable') {
                 $note = json_decode(Security::decrypt(base64_decode($appointment_data['ehr_note_json_readable']),SEC_KEY));                        
            }    
            else if ($format == 'raw') {
                 $note = json_decode(Security::decrypt(base64_decode($appointment_data['ehr_note_json_raw']),SEC_KEY));                        
            }
            else if ($format == 'rawAndReadable')
            {
                 $note = json_decode(Security::decrypt(base64_decode($appointment_data['ehr_note_json_raw_readable']),SEC_KEY));
            }
            

            if(!empty($timezone) && $timezone != 'CST'){

                $dateOfService = !empty($note->basicDetails->dateOfService) && isset($note->basicDetails->dateOfService[0]) ? $note->basicDetails->dateOfService[0] : "";
                if(!empty($dateOfService)){

                    //pr($dateOfService);
                    $converted_date = $this->ApiGenaral->timezoneConverter($dateOfService,'CST',$timezone);
                    //pr($converted_date);die;
                    $note->basicDetails->dateOfService = $converted_date;
                    $note->basicDetails->timezone = $timezone;
                }
            }

            //pr($note);die;

            $header = array(
                'statusCode' => 200,
                'message' => 'Appointment note retrieved successfully.'
            );

            $payload = array(
                'appointmentNote' => $note
            );

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){
           //pr($e);die;
            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
    }


    public function viewRecentNotes()
    {
        try
        {
            $this->loadModel('Schedule');
            $this->loadModel('ChiefCompliantUserdetails');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $access_token = $this->request->data('accessToken');            
            $completedInLastXMinutes = $this->request->data('completedInLastXMinutes');
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);
            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            if(empty($completedInLastXMinutes))
            {
                $header = array(
                    'statusCode' => 402,
                    'message' => 'CompletedInLastXMinutes should not be blank.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));

            }    

            if(!is_numeric($completedInLastXMinutes))
            {
                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid completedInLastXMinutes.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }            
            
             $currenttime = date('Y-m-d H:i:s', strtotime('-'.$completedInLastXMinutes.' minutes'));            

             $appointment_data = $this->Schedule->find('all')->contain(['ChiefCompliantUserdetails'])->where(['Schedule.status' =>3,'Schedule.modified >=' => $currenttime])->order(['Schedule.id' =>'desc'])->toArray();

             $note = array();
             $counter = 0;
             foreach ($appointment_data as $key => $value) { 
                if(isset($value['chief_compliant_userdetail']) && !empty($value['chief_compliant_userdetail']) && !empty($value['chief_compliant_userdetail']['ehr_note_json']))
                {   
                    $note[] = json_decode(Security::decrypt(base64_decode($value['chief_compliant_userdetail']['ehr_note_json']),SEC_KEY));   
                    $counter++;           
                }                
            }

            $header = array(
                'statusCode' => 200,
                'message' => 'Appointment note retrieved successfully.'
            );

            $payload = array(
                'totalNotesList' =>$counter,
                'appointmentNotes' => $note
            );

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){
           //pr($e);die;
            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
    }


   
    public function latestNote()
    {
        try
        {
            $this->loadModel('Schedule');
            $this->loadModel('ChiefCompliantUserdetails');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $access_token = $this->request->data('accessToken');
            $mrn = $this->request->data('mrn');
            $format = $this->request->data('format');

            
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);
            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            $timezone = $this->request->data('timezone');
            if(!empty($timezone) && !in_array($timezone,['PST','MST','CST','EST','HST'])){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Timezone must be in PST, MST, CST, EST, HST.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

          

            if(empty($format))
            {
                $header = array(
                    'statusCode' => 400,
                    'message' => 'Format is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }


            if(empty($mrn))
            {
                $header = array(
                    'statusCode' => 400,
                    'message' => 'Mrn is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }  

             $mrn = base64_encode($this->CryptoSecurity->encrypt($mrn,SEC_KEY));
             $schedulesDetails = $this->Schedule->find('all')->where(['mrn' => $mrn])->first();               
             if(empty($schedulesDetails))
             {
                 $header = array(
                    'statusCode' => 400,
                    'message' => 'Mrn is not valid.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
             }             


            if(!in_array($format, ['FHIR','readable']))
            {
                $header = array(
                    'statusCode' => 400,
                    'message' => 'Format should only FHIR or readable.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }           
            

            $appointment_data = $this->Schedule->find('all')->contain(['ChiefCompliantUserdetails'])->where(['Schedule.status' =>3,'Schedule.mrn' => $mrn])->order(['Schedule.id' =>'desc'])->first();

            if(empty($appointment_data)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointment not found.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            //pr($appointment_data['chief_compliant_userdetail']['current_step_id']);die;
            if(!in_array($appointment_data['chief_compliant_userdetail']['current_step_id'],[18,19,21,25,1,2,16,4,17])){

                $header = array(
                    'statusCode' => 503,
                    'message' => 'Appointment note is available for oncology,chronic care, and internal medication module only.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($appointment_data['chief_compliant_userdetail']['ehr_note_json'])){

                $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($appointment_data['chief_compliant_userdetail']['ehr_note_json_readable'])){

                $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if($format == 'FHIR')
            {
                $note = json_decode(Security::decrypt(base64_decode($appointment_data['chief_compliant_userdetail']['ehr_note_json']),SEC_KEY));    
            }
            else if ($format == 'readable') {
                 $note = json_decode(Security::decrypt(base64_decode($appointment_data['chief_compliant_userdetail']['ehr_note_json_readable']),SEC_KEY));                        
            } 


            if(!empty($timezone) && $timezone != 'CST'){

                $dateOfService = !empty($note->basicDetails->dateOfService) && isset($note->basicDetails->dateOfService[0]) ? $note->basicDetails->dateOfService[0] : "";
                if(!empty($dateOfService)){

                    //pr($dateOfService);
                    $converted_date = $this->ApiGenaral->timezoneConverter($dateOfService,'CST',$timezone);
                    //pr($converted_date);die;
                    $note->basicDetails->dateOfService = $converted_date;
                    $note->basicDetails->timezone = $timezone;
                }
            }

            //pr($note);die;
            $header = array(
                'statusCode' => 200,
                'message' => 'Appointment note retrieved successfully.'
            );

            $payload = array(
                'appointmentNote' => $note
            );                  

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){
           //pr($e);die;
            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
    }


    public function allNotesMrn()
    {
        try
        {
            $this->loadModel('Schedule');
            $this->loadModel('ChiefCompliantUserdetails');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $access_token = $this->request->data('accessToken');
            $mrn = $this->request->data('mrn');
            $format = $this->request->data('format');

            
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);
            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }           
          

            if(empty($format))
            {
                $header = array(
                    'statusCode' => 400,
                    'message' => 'Format is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }


            if(empty($mrn))
            {
                $header = array(
                    'statusCode' => 400,
                    'message' => 'Mrn is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }  

             $mrn = base64_encode($this->CryptoSecurity->encrypt($mrn,SEC_KEY));
             $schedulesDetails = $this->Schedule->find('all')->where(['mrn' => $mrn])->first();               
             if(empty($schedulesDetails))
             {
                 $header = array(
                    'statusCode' => 400,
                    'message' => 'Mrn is not valid.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
             }             


            if(!in_array($format, ['FHIR','readable']))
            {
                $header = array(
                    'statusCode' => 400,
                    'message' => 'Format should only FHIR or readable.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }           
            

            $appointment_data = $this->Schedule->find('all')->contain(['ChiefCompliantUserdetails'])->where(['Schedule.status' =>3,'Schedule.mrn' => $mrn])->order(['Schedule.id' =>'desc'])->toArray();
            
            if(empty($appointment_data)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointment not found.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
            
            
             $note = array();
             $counter = 0;
             foreach ($appointment_data as $key => $value) { 
                if(isset($value['chief_compliant_userdetail']) && !empty($value['chief_compliant_userdetail']) && !empty($value['chief_compliant_userdetail']['ehr_note_json']))
                {  
                    if($format == 'FHIR')
                    {
                        $note[] = !empty($value['chief_compliant_userdetail']['ehr_note_json']) ? json_decode(Security::decrypt(base64_decode($value['chief_compliant_userdetail']['ehr_note_json']),SEC_KEY)) : '';    
                    }
                    else if ($format == 'readable') {
                         $note[] = !empty($value['chief_compliant_userdetail']['ehr_note_json_readable'])?json_decode(Security::decrypt(base64_decode($value['chief_compliant_userdetail']['ehr_note_json_readable']),SEC_KEY)):'';                        
                    }                     
                    $counter++;           
                }                
            }

            $header = array(
                'statusCode' => 200,
                'message' => 'Appointment note retrieved successfully.'
            );

            $payload = array(
                'totalNotesList' =>$counter,
                'appointmentNotes' => $note
            );              

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){
           
            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
    }



    public function sendReminder()
    {
        try
        {
            $this->loadModel('Schedule');
            $this->loadModel('Users');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
            $access_token = $this->request->data('accessToken');
            $notifyEmail = $this->request->data('notifyEmail');
            $notifyText = $this->request->data('notifyText');


            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);            

            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }


            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            $organization_detail = $this->Organizations->find('all')->where(['id' => $org_provider_ids['organization_id']])->first();

            $encounter_id = $this->request->data('encounterId');
            $clinic_appoinment_id = $this->request->data('clinicAppointmentId');
            if(empty($encounter_id) && empty($clinic_appoinment_id)){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Encounter id or clinic apointment id, one of them is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }          



            $scheduled_appointment = $this->Schedule->find('all')->where(['OR' =>array('id' =>$encounter_id,'clinic_appointment_id' =>$clinic_appoinment_id)])->first();

          if(empty($scheduled_appointment)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointment not found.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if($scheduled_appointment->status == 3){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointment has been completed.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }



            $notifyEmailSchedule = [];
            $notifyEmailSchedule = $this->request->data('notifyEmailSchedule');

            if(!empty($notifyEmailSchedule) && is_array($notifyEmailSchedule)){

                foreach ($notifyEmailSchedule as $key => $value) {
                    
                    if(is_numeric($value) && $value > 0){

                        $notifyEmailSchedule[] = $value;
                    }
                }
                $notifyEmailSchedule = !empty($notifyEmailSchedule) ? array_unique($notifyEmailSchedule) : $notifyEmailSchedule;  

                   if(!empty($scheduled_appointment['email'])){

                       $getExistingEmailschedule = $scheduled_appointment['notify_email_remaining_schedule'];
                       $mergeemailSchedule = array();
                       if(!empty($getExistingEmailschedule))
                       { 
                         $getExistingEmailschedule = unserialize($getExistingEmailschedule);
                         $mergeemailSchedule = array_merge($getExistingEmailschedule,$notifyEmailSchedule);
                         $mergeemailSchedule =  !empty($mergeemailSchedule)?array_unique($mergeemailSchedule):$getExistingEmailschedule;
                       } 
                       else
                       {
                        $mergeemailSchedule = $notifyEmailSchedule;
                       } 

                         $scheduled_appointment['notify_email_schedule'] = !empty($mergeemailSchedule) ? serialize($mergeemailSchedule) : "";
                         $scheduled_appointment['notify_email_remaining_schedule'] = !empty($mergeemailSchedule) ? serialize($mergeemailSchedule) : "";
                                           
                 } 
            }

           

            $notifyTextSchedule = [];
            $notifyTextSchedule = $this->request->data('notifyTextSchedule');
            if(!empty($notifyTextSchedule) && is_array($notifyTextSchedule)){

                foreach ($notifyTextSchedule as $key => $value) {
                    
                    if(is_numeric($value) && $value > 0){

                        $notifyTextSchedule[] = $value;
                    }
                }
                $notifyTextSchedule = !empty($notifyTextSchedule) ? array_unique($notifyTextSchedule) : $notifyTextSchedule;

                   if(!empty($scheduled_appointment['phone'])){

                   $getExistingTextschedule = $scheduled_appointment['notify_text_remaining_schedule'];
                   $mergetextSchedule = array();
                   if(!empty($getExistingTextschedule))
                   { 
                     $getExistingTextschedule = unserialize($getExistingTextschedule);
                     $mergetextSchedule = array_merge($getExistingTextschedule,$notifyTextSchedule);
                     $mergetextSchedule =  !empty($mergetextSchedule)?array_unique($mergetextSchedule):$getExistingTextschedule;
                   }
                   else
                   {
                    $mergetextSchedule = $notifyTextSchedule;
                   } 


                    $scheduled_appointment['notify_text_schedule'] = !empty($mergetextSchedule) ? serialize($mergetextSchedule) : "";
                    $scheduled_appointment['notify_text_remaining_schedule'] = !empty($mergetextSchedule) ? serialize($mergetextSchedule) : "";
                                     
               }
            }

             //update existing email schedule and text schdule time in second   
             if(!empty($scheduled_appointment))
             {
                $this->Schedule->save($scheduled_appointment);
             }

             $first_name = $this->CryptoSecurity->decrypt(base64_decode($scheduled_appointment['first_name']),SEC_KEY); 
             $email = $this->CryptoSecurity->decrypt(base64_decode($scheduled_appointment['email']),SEC_KEY); 
             $phone = $this->CryptoSecurity->decrypt(base64_decode($scheduled_appointment['phone']),SEC_KEY);   

             $clinic_name = !empty($organization_detail) ? $organization_detail->organization_name : 'clinic';
             $org_logo = !empty($organization_detail) && !empty($organization_detail->clinic_logo) ? WEBROOT.'img/'.$organization_detail->clinic_logo : WEBROOT."images/logo.png";             
             
             if(!empty($scheduled_appointment)){

             //send email to patient
                     if(!empty($scheduled_appointment) && isset($notifyEmail) && $notifyEmail == 1 && isset($scheduled_appointment['email']) && !empty($scheduled_appointment['email'])){
                        $iframe_enid = $scheduled_appointment->id.'S'.'0V';
                        $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                        $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid); 
                        $schedule_token = $this->ScheduleToken->newEntity();
                        $schedule_token->schedule_id = $scheduled_appointment->id;
                        $schedule_token->iframe_enid = $iframe_enid;
                        $this->ScheduleToken->save($schedule_token);
                        try{
                            $mailData = array(
                                'provider_id' => $org_provider_ids['provider_id'],
                                'username' => $first_name,
                                'slug' => 'api_notification',
                                'email' => $email,
                                'replaceString' => array('{username}','{clinic}','{link}','{logo}'),
                                'replaceData' => array($first_name,$clinic_name,$link,$org_logo),
                            );                            
                            $this->ProviderMailSend->send($mailData);
                        }
                        catch(\Exception $e){
                            
                        }
                    }

                      //send text message to patient
                    if(!empty($scheduled_appointment) && isset($notifyText) && $notifyText == 1 && isset($scheduled_appointment['phone']) && !empty($scheduled_appointment['phone'])){

                        $iframe_enid = $scheduled_appointment->id.'S'.'0V';
                        $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                        $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid); 
                        $schedule_token = $this->ScheduleToken->newEntity();
                        $schedule_token->schedule_id = $scheduled_appointment->id;
                        $schedule_token->iframe_enid = $iframe_enid;
                        $this->ScheduleToken->save($schedule_token);

                        try{
                            $mailData = array(
                                'provider_id' => $org_provider_ids['provider_id'],
                                'slug' => 'api_notification',
                                'phone' => $phone,
                                'replaceString' => array('{username}','{clinic}','{link}'),
                                'replaceData' => array($first_name,$clinic_name,$link),
                            );
                            $this->TextMsgSend->send($mailData);
                        }
                        catch(\Exception $e){
                        }
                    }
                    $header = array(
                                'statusCode' => 200,
                                'message' => 'Reminder sent successfully.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
          }
          else
          {
              $header = array(
                                'statusCode' => 402,
                                'message' => 'Appointment not found.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
          }  
        
        }
        catch(\Exception $e){

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
    }


    public function getQuestionnaire()
    {
        try
        {
            $this->loadModel('Schedule');
            $this->loadModel('Users');
            $this->loadModel('ChiefCompliantUserdetails');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
            $access_token = $this->request->data('accessToken');
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);            

            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            $encounter_id = $this->request->data('encounterId');
            $clinic_appoinment_id = $this->request->data('clinicAppointmentId');
            if(empty($encounter_id) && empty($clinic_appoinment_id)){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Encounter id or clinic apointment id, one of them is required.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

              if(!empty($encounter_id)){

                $schedule_data = $this->Schedule->find('all')->where(['id' => $encounter_id,'organization_id' => $org_provider_ids['organization_id']])->first();

                if(empty($schedule_data)){

                    $header = array(
                        'statusCode' => 402,
                        'message' => 'Invalid appointment id.'
                    );

                    $response = ['header' => $header];
                    return $this->response->withType("application/json")->withStringBody(json_encode($response));
                }
            }


            if(!empty($clinic_appoinment_id)){

                $schedule_data = $this->Schedule->find('all')->where(['clinic_appointment_id' => $clinic_appoinment_id,'organization_id' => $org_provider_ids['organization_id']])->first();

                if(empty($schedule_data)){

                    $header = array(
                        'statusCode' => 402,
                        'message' => 'Invalid clinic appointment id.'
                    );

                    $response = ['header' => $header];
                    return $this->response->withType("application/json")->withStringBody(json_encode($response));
                }
            }

            if(empty($schedule_data)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointment not found.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if($schedule_data->status != 3){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointment has not completed.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $appointment_data = $this->ChiefCompliantUserdetails->find('all')->where(['appointment_id' => $schedule_data['appointment_id']])->first();

            if(empty($appointment_data)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Appointment not found.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(!in_array($appointment_data['current_step_id'],[19,21])){

                $header = array(
                    'statusCode' => 503,
                    'message' => 'Appointment note is available for oncology modules only.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(empty($appointment_data['ehr_note_json'])){

                $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $note = json_decode(Security::decrypt(base64_decode($appointment_data['ehr_note_json']),SEC_KEY));
            
            $header = array(
                'statusCode' => 200,
                'message' => 'raw questionnaire data retrieved successfully.'
            );

            $payload = array(
                'details' =>$note->medicalDetails->hpi,
                'cc' => $note->medicalDetails->cc,
                'meds' => $note->medicalDetails->meds,
                'ros' => $note->medicalDetails->ros,
            );

            

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));

        }
        catch(\Exception $e){
           //pr($e);die;
            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }


    }



    public function registerPatients()
    {
        try{

            $this->loadModel('Users');
            $response = array();
            $RaceValue = array('1' =>'American Indian or Alaska Native','2' =>'Asian', '3' => 'Black or African American', '4' =>'Native Hawaiian or Other Pacific Islander', '5' =>'White' , '6' =>'Other Race');
            $ethinicityValue = array('1' =>'Hispanic or Latino', '2' =>'Not Hispanic or Latino');
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $access_token = $this->request->data('accessToken');
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);

            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            $patient_data = $this->request->data('patientData');

            if(empty($patient_data)){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Patient data is blank.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(!is_array($patient_data)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid patient data format.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $patient_data = array_filter($patient_data);
            //start processing the patient data
            $error = array();
            $registered_patients = array();
            $app_count = 1;

            foreach ($patient_data as $patient_key => $patient_value) {

                $patient_value = array_filter($patient_value);
                $temp_err = array();
                $patient_number = $patient_key+1;

                //validate the appointment data

                //required field validation
                if(!isset($patient_value['firstName']) || (isset($patient_value['firstName']) && empty($patient_value['firstName']))){

                    $temp_err[] = 'First name is required.';

                }

                if(!isset($patient_value['lastName']) || (isset($patient_value['lastName']) && empty($patient_value['lastName']))){

                    $temp_err[] = 'Last name is required.';

                }

                if(!isset($patient_value['dob']) || (isset($patient_value['dob']) && empty($patient_value['dob']))){

                    $temp_err[] = 'DOB is required.';                    

                }

                if(isset($patient_value['dob']) && !$this->General->checkDateFormat($patient_value['dob'])){

                    $temp_err[] = 'Invalid DOB.';
                }

                if(!isset($patient_value['gender']) || (isset($patient_value['gender']) && empty($patient_value['gender']))){

                    $temp_err[] = 'Gender is required.';

                }

                if(isset($patient_value['gender']) && !in_array($patient_value['gender'], ['F','M','O'])){

                    $temp_err[] = 'Gender sould be M for male, F for female and O for other';

                }

                //email validation check is still pending
                if(isset($patient_value['email']) && !empty($patient_value['email']) && !preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{1,})+$/",trim($patient_value['email']))){

                  $temp_err[] = 'Invalid email address.';
                }

                if(isset($patient_value['phone']) && !empty($patient_value['phone']) && (!is_numeric($patient_value['phone']) || strlen($patient_value['phone']) != 10 )){

                    $temp_err[] = 'Invalid phone number.';
                }

                if(isset($patient_value['race']) && !empty($patient_value['race']))
                {
                    if(!in_array(strtolower($patient_value['race']), array_map('strtolower',$RaceValue)))
                    {
                        $temp_err[] = 'Invalid race value.';
                    }    
                } 

                if(isset($patient_value['ethnicity']) && !empty($patient_value['ethnicity']))
                {
                    if(!in_array(strtolower($patient_value['ethnicity']), array_map('strtolower',$ethinicityValue)))
                    {
                        $temp_err[] = 'Invalid ethnicity value.';
                    }    
                }               



                $user_detail = null;

                //check patient is registered or not on allevia platform
                if((isset($patient_value['email']) && !empty($patient_value['email'])) || (isset($patient_value['phone']) && !empty($patient_value['phone']))){

                    $filter = array();
                    $enc_phone = isset($patient_value['phone']) && !empty($patient_value['phone']) ? base64_encode($this->CryptoSecurity->encrypt($patient_value['phone'],SEC_KEY)) : '';
                    $enc_email = isset($patient_value['email']) && !empty($patient_value['email']) ? base64_encode($this->CryptoSecurity->encrypt(strtolower($patient_value['email']),SEC_KEY)) : '';
                    if(!empty($enc_email)){

                       $filter['email'] = $enc_email;
                    }

                    if(!empty($enc_phone)){

                       $filter['phone'] = $enc_phone;
                    }

                    $user_detail_all = $this->Users->find('all')->where(['OR'=> $filter])->toArray();
                    //\pr($user_detail_all);die;
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

                           $temp_err[] = 'Invalid patient detail.';
                        }
                    }
                }
                elseif(empty($patient_value['email']) && empty($patient_value['phone']) && (!empty($patient_value['firstName']) && !empty($patient_value['lastName']) && !empty($patient_value['dob'])))
                {

                    $enc_first_name = base64_encode($this->CryptoSecurity->encrypt($patient_value['firstName'],SEC_KEY));
                    $enc_last_name = base64_encode($this->CryptoSecurity->encrypt($patient_value['lastName'],SEC_KEY));
                    $enc_dob = base64_encode($this->CryptoSecurity->encrypt(date('Y-m-d',strtotime($patient_value['dob'])),SEC_KEY));

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

                //check user detail is patient detail or not
                if(!empty($user_detail) && $user_detail['role_id'] != 2){

                    $temp_err[] = 'Patient is registered as provider or admin.';
                }

                if(!empty($temp_err)){

                    $error[$patient_number] = $temp_err;
                   // pr($error);die;
                    continue;
                }

                //register patient

                $gender = '';
                if(isset($patient_value['gender'])){

                    switch ($patient_value['gender']) {
                        case 'F':
                            $gender = 0;
                            break;
                        case 'M':
                            $gender = 1;
                            break;
                        case 'O':
                            $gender = 2;
                            break;
                    }
                }

                $dob = date('Y-m-d',strtotime($patient_value['dob']));

                //encrypt the patient data

                $enc_email = isset($patient_value['email']) && $patient_value['email'] != '' ? base64_encode($this->CryptoSecurity->encrypt(strtolower($patient_value['email']),SEC_KEY)):'';
                $enc_phone = isset($patient_value['phone']) && $patient_value['phone'] != '' ? base64_encode($this->CryptoSecurity->encrypt($patient_value['phone'],SEC_KEY)) : '';

                $enc_first_name = isset($patient_value['firstName']) && $patient_value['firstName'] != '' ? base64_encode($this->CryptoSecurity->encrypt($patient_value['firstName'],SEC_KEY)) : '';

                $enc_last_name = isset($patient_value['lastName']) && $patient_value['lastName'] != '' ? base64_encode($this->CryptoSecurity->encrypt($patient_value['lastName'],SEC_KEY)) : '';

                $enc_dob = $dob != '' ? base64_encode($this->CryptoSecurity->encrypt($dob,SEC_KEY)) : '';
                $enc_gender = in_array($gender, [0,1,2]) ? base64_encode(Security::encrypt($gender, SEC_KEY)) : '';

                $RaceValueFlip = array_flip(array_map('strtolower',$RaceValue));
                $ethinicityValueFlip = array_flip(array_map('strtolower',$ethinicityValue));                

                $enc_race = isset($patient_value['race']) && $patient_value['race'] != '' ? $RaceValueFlip[strtolower($patient_value['race'])]  : '';
                $enc_ethnicity = isset($patient_value['ethnicity']) && $patient_value['ethnicity'] != '' ? $ethinicityValueFlip[strtolower($patient_value['ethnicity'])]  : '';

                $enc_address = isset($patient_value['address']) && $patient_value['address'] != '' ? base64_encode($this->CryptoSecurity->encrypt($patient_value['address'],SEC_KEY)):'';

                $enc_country = isset($patient_value['country']) && $patient_value['country'] != '' ? base64_encode($this->CryptoSecurity->encrypt($patient_value['country'],SEC_KEY)):'';

                $enc_state = isset($patient_value['state']) && $patient_value['state'] != '' ? base64_encode($this->CryptoSecurity->encrypt($patient_value['state'],SEC_KEY)):'';

                $enc_city = isset($patient_value['city']) && $patient_value['city'] != '' ? base64_encode($this->CryptoSecurity->encrypt($patient_value['city'],SEC_KEY)):'';
                $enc_zip = isset($patient_value['zip']) && $patient_value['zip'] != '' ? base64_encode($this->CryptoSecurity->encrypt($patient_value['zip'],SEC_KEY)):'';               


                //register patient
                if(empty($user_detail)){

                    $user = $this->Users->newEntity();
                    $user_data = array();
                    $user_data['email'] = $enc_email;
                    $user_data['role_id'] = 2;
                    $user_data['first_name'] = $enc_first_name;
                    $user_data['last_name'] = $enc_last_name;
                    $user_data['phone'] = $enc_phone;
                    $user_data['dob'] = $enc_dob;
                    $user_data['gender'] = $enc_gender;
                    $user_data['clinical_race'] = $enc_race;
                    $user_data['clinical_ethnicity'] = $enc_ethnicity;
                    $user_data['address'] = $enc_address;
                    $user_data['country'] = $enc_country;
                    $user_data['state'] = $enc_state;
                    $user_data['city'] = $enc_city;
                    $user_data['zip'] = $enc_zip;    

                    $user = $this->Users->patchEntity($user,$user_data);
                    if(!$user->errors()){

                        $user_detail = $this->Users->save($user);
                    }
                    else{

                        $error[$patient_number] = $user->errors();
                        continue;
                    }
                }

                if(!empty($user_detail)){

                	$gender = "";
                	if(!empty($user_detail['gender'])){

                		$temp_gender = Security::decrypt(base64_decode($user_detail['gender']),SEC_KEY);

	                    switch ($temp_gender) {

	                        case 0:
	                            $gender = "Female";
	                            break;
	                        case 1:
	                            $gender = "Male";
	                            break;
	                        case 2:
	                            $gender = "Other";
	                            break;
	                    }
	                }

                    //pr($user_detail);die;                    
                	$registered_patients[] = array(

                		'id' => $user_detail['id'],
                		'firstName' => !empty($user_detail['first_name']) ? $this->CryptoSecurity->decrypt(base64_decode($user_detail['first_name']),SEC_KEY) : "",
                		'lastName' => !empty($user_detail['last_name']) ? $this->CryptoSecurity->decrypt(base64_decode($user_detail['last_name']),SEC_KEY) : "",
                		'email' => !empty($user_detail['email']) ? $this->CryptoSecurity->decrypt(base64_decode($user_detail['email']),SEC_KEY) : "",
                		'phone' => !empty($user_detail['phone']) ? $this->CryptoSecurity->decrypt(base64_decode($user_detail['phone']),SEC_KEY) : "",
                		'dob' => !empty($user_detail['dob']) ? $this->CryptoSecurity->decrypt(base64_decode($user_detail['dob']),SEC_KEY) : "",
                		'gender' => $gender,
                        'race' => !empty($user_detail['clinical_race']) ? $RaceValue[$user_detail['clinical_race']] : "",
                        'ethnicity' => !empty($user_detail['clinical_ethnicity']) ? $ethinicityValue[$user_detail['clinical_ethnicity']] : "",
                        'address' => !empty($user_detail['address']) ? $this->CryptoSecurity->decrypt(base64_decode($user_detail['address']),SEC_KEY) : "",
                        'country' => !empty($user_detail['country']) ? $this->CryptoSecurity->decrypt(base64_decode($user_detail['country']),SEC_KEY) : "",
                         'state' => !empty($user_detail['state']) ? Security::decrypt( base64_decode($user_detail['state']), SEC_KEY) : "",
                         'city' => !empty($user_detail['city']) ? Security::decrypt( base64_decode($user_detail['city']), SEC_KEY): "",
                         'zip' => !empty($user_detail['zip']) ? Security::decrypt( base64_decode($user_detail['zip']), SEC_KEY) : "",              

                	);
                }
            }

            $header = array(
                    'statusCode' => 200,
                    'message' => 'Result of registered patients'
                );

            $payload = array(
                'totalRegisteredPatients' => count($registered_patients),
                'registeredPatientsDetail' => $registered_patients,
                'errors' => $error
            );

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

    }

    public function viewMedicalHistory()
    {
        try{

            $this->loadModel('Users');
            $commonTable = TableRegistry::get('common_conditions');
            $this->WomenSpecific = TableRegistry::get('WomenSpecific');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
            $user_id = $this->request->data('userId');
            $email = $this->request->data('email');
            $phone = $this->request->data('phone');
            $first_name = $this->request->data('firstName');
            $last_name = $this->request->data('lastName');
            $dob = $this->request->data('dob');

            $access_token = $this->request->data('accessToken');
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);

            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            //get the user_detail
            $user_data = null;
            $skip_search = 0;

            if(!empty($user_id)){

                $user_data = $this->Users->find('all')->where(['id' => $user_id])->first();
                $skip_search = 1;
            }

            if(!$skip_search){

                //check patient is registered or not on allevia platform
                if(!empty($email) ||!empty($phone)){

                    $filter = array();
                    $enc_phone = "";
                    $enc_email = "";
                    
                    if(!empty($email)){

                        $enc_email = base64_encode($this->CryptoSecurity->encrypt(strtolower($email),SEC_KEY));
                        $filter['email'] = $enc_email;
                    }

                    if(!empty($phone)){

                        $enc_phone = base64_encode($this->CryptoSecurity->encrypt($phone,SEC_KEY));
                        $filter['phone'] = $enc_phone;
                    }

                    $user_detail_all = $this->Users->find('all')->where(['OR'=> $filter])->toArray();
                    //pr($user_detail_all);die;
                    if(!empty($user_detail_all)){

                        $user_valid = 0;
                        foreach($user_detail_all as $all_user_key => $all_user_value){

                            if(($enc_email != '' && $all_user_value['email'] == $enc_email && $enc_phone != '' && $all_user_value['phone'] == $enc_phone) || ($enc_email == '' && $enc_phone != '' && $all_user_value['phone'] == $enc_phone) || ($enc_email != '' && $all_user_value['email'] == $enc_email && $enc_phone == '')){

                                $user_data = $all_user_value;
                                $user_valid = 1;
                                break;
                            }
                        }

                        if(!$user_valid){

                            $header = array(
                                'statusCode' => 402,
                                'message' => 'Invalid user.'
                            );
                            $response = ['header' => $header];
                            return $this->response->withType("application/json")->withStringBody(json_encode($response));
                        }
                    }
                }
                elseif(!empty($first_name) && !empty($last_name) && !empty($dob))
                {

                    $enc_first_name = base64_encode($this->CryptoSecurity->encrypt($first_name,SEC_KEY));
                    $enc_last_name = base64_encode($this->CryptoSecurity->encrypt($last_name,SEC_KEY));
                    $enc_dob = base64_encode($this->CryptoSecurity->encrypt(date('Y-m-d',strtotime($dob)),SEC_KEY));

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
                    $user_data = $this->Users->find('all')->where($filter)->first();
                }
            }

            if(empty($user_data)){

                $header = array(
                      'statusCode' => 402,
                      'message' => 'Invalid user.'
                  );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if($user_data['role_id'] != 2){

                $header = array(
                      'statusCode' => 402,
                      'message' => 'User is registered as admin or provider.'
                );
                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $women_field =  $this->WomenSpecific->find('all')->where(['user_id' => $user_id ])->first();

            //decrypt the user details

            if(!empty($user_data->first_name)){
	            $user_data->first_name = $this->CryptoSecurity->decrypt( base64_decode($user_data->first_name), SEC_KEY);
	        }

	        if(!empty($user_data->last_name)){
	            $user_data->last_name = $this->CryptoSecurity->decrypt( base64_decode($user_data->last_name), SEC_KEY);
	        }
	        if(!empty($user_data->email)){
	            $user_data->email = $this->CryptoSecurity->decrypt( base64_decode($user_data->email), SEC_KEY);
	        }
	        if(!empty($user_data->phone)){
	            $user_data->phone = $this->CryptoSecurity->decrypt( base64_decode($user_data->phone), SEC_KEY);
	        }

	        if(!empty($user_data->dob)){
	            $user_data->dob = $this->CryptoSecurity->decrypt( base64_decode($user_data->dob), SEC_KEY);
	        }

	        if(!empty($user_data->height)){
	            $user_data->height = Security::decrypt( base64_decode($user_data->height), SEC_KEY);
	        }

	        if(!empty($user_data->weight)){
	            $user_data->weight = Security::decrypt( base64_decode($user_data->weight), SEC_KEY);
	        }

	        if(!empty($user_data->address)){
	            $user_data->address = Security::decrypt( base64_decode($user_data->address), SEC_KEY);
	        }

	        if(!empty($user_data->city)){
	            $user_data->city = Security::decrypt( base64_decode($user_data->city), SEC_KEY);
	        }

	        if(!empty($user_data->state)){
	            $user_data->state = Security::decrypt( base64_decode($user_data->state), SEC_KEY);
	        }

	        if(!empty($user_data->zip)){
	            $user_data->zip = Security::decrypt( base64_decode($user_data->zip), SEC_KEY);
	        }

	        if(!empty($user_data->bmi)){
	            $user_data->bmi = Security::decrypt( base64_decode($user_data->bmi), SEC_KEY);
	        }

	        if(!empty($user_data->is_uterus_removal)){
	            $user_data->is_uterus_removal = Security::decrypt( base64_decode($user_data->is_uterus_removal), SEC_KEY);
	        }

	        if(!empty($user_data->is_latex_allergy)){
	            $user_data->is_latex_allergy = Security::decrypt( base64_decode($user_data->is_latex_allergy), SEC_KEY);
	        }
	        if(!empty($user_data->is_retired)){
	            $user_data->is_retired = Security::decrypt( base64_decode($user_data->is_retired), SEC_KEY);
	        }

	        if(!empty($user_data->occupation)){
	            $user_data->occupation = Security::decrypt( base64_decode($user_data->occupation), SEC_KEY);
	        }

	        if(!empty($user_data->marital_status)){
	            $user_data->marital_status = Security::decrypt( base64_decode($user_data->marital_status), SEC_KEY);
	        }

	        if(!empty($user_data->sexual_orientation)){
	            $user_data->sexual_orientation = Security::decrypt( base64_decode($user_data->sexual_orientation), SEC_KEY);
	        }

	        if(!empty($user_data->ethinicity)){
	            $user_data->ethinicity = Security::decrypt( base64_decode($user_data->ethinicity), SEC_KEY);
	        }

	        if(!empty($user_data->current_smoke_pack)){
	            $user_data->current_smoke_pack = Security::decrypt( base64_decode($user_data->current_smoke_pack), SEC_KEY);
	        }

	        if(!empty($user_data->current_smoke_year)){
	            $user_data->current_smoke_year = Security::decrypt( base64_decode($user_data->current_smoke_year), SEC_KEY);
	        }

	        if(!empty($user_data->past_smoke_pack)){
	            $user_data->past_smoke_pack = Security::decrypt( base64_decode($user_data->past_smoke_pack), SEC_KEY);
	        }
	        if(!empty($user_data->past_smoke_year)){
	            $user_data->past_smoke_year = Security::decrypt( base64_decode($user_data->past_smoke_year), SEC_KEY);
	        }

	        if(!empty($user_data->current_drink_pack)){
	            $user_data->current_drink_pack = Security::decrypt( base64_decode($user_data->current_drink_pack), SEC_KEY);
	        }

	        if(!empty($user_data->current_drink_year)){
	            $user_data->current_drink_year = Security::decrypt( base64_decode($user_data->current_drink_year), SEC_KEY);
	        }
	        if(!empty($user_data->past_drink_pack)){
	            $user_data->past_drink_pack = Security::decrypt( base64_decode($user_data->past_drink_pack), SEC_KEY);
	        }

	        if(!empty($user_data->past_drink_year)){
	            $user_data->past_drink_year = Security::decrypt( base64_decode($user_data->past_drink_year), SEC_KEY);
	        }

	        if(!empty($user_data->is_currentlysmoking)){
	            $user_data->is_currentlysmoking = Security::decrypt( base64_decode($user_data->is_currentlysmoking), SEC_KEY);
	        }

	        if(!empty($user_data->is_pastsmoking)){
	            $user_data->is_pastsmoking = Security::decrypt( base64_decode($user_data->is_pastsmoking), SEC_KEY);
	        }

	        if(!empty($user_data->is_currentlydrinking)){
	            $user_data->is_currentlydrinking = Security::decrypt( base64_decode($user_data->is_currentlydrinking), SEC_KEY);
	        }

	        if(!empty($user_data->is_pastdrinking)){
	            $user_data->is_pastdrinking = Security::decrypt( base64_decode($user_data->is_pastdrinking), SEC_KEY);
	        }

	        if(!empty($user_data->is_otherdrug)){
	            $user_data->is_otherdrug = Security::decrypt( base64_decode($user_data->is_otherdrug), SEC_KEY);
	        }

	        if(!empty($user_data->is_otherdrugpast)){
	            $user_data->is_otherdrugpast = Security::decrypt( base64_decode($user_data->is_otherdrugpast), SEC_KEY);
	        }

	        if(!empty($user_data->gender)){
	            $user_data->gender = Security::decrypt( base64_decode($user_data->gender), SEC_KEY);
	        }

	        if(!empty($user_data->race)){
	            $user_data->race = Security::decrypt( base64_decode($user_data->race), SEC_KEY);
	        }
	        if(!empty($user_data->pharmacy)){
	            $user_data->pharmacy = Security::decrypt(base64_decode($user_data->pharmacy),SEC_KEY);
	        }

	        if(!empty($user_data->insurance_company)){
	            $user_data->insurance_company = Security::decrypt( base64_decode($user_data->insurance_company), SEC_KEY);
	        }

	        if(!empty($user_data->guarantor)){
	            $user_data->guarantor = Security::decrypt( base64_decode($user_data->guarantor), SEC_KEY);
	        }

	        if(!empty($user_data->is_check_med_his)){
	            $user_data->is_check_med_his = Security::decrypt( base64_decode($user_data->is_check_med_his), SEC_KEY);
	        }


	        if(!empty($user_data->medical_history)){

	        	$user_data->medical_history = unserialize((Security::decrypt(base64_decode($user_data->medical_history), SEC_KEY)));
	        }

	        if(!empty($user_data->is_check_surg_his)){
	            $user_data->is_check_surg_his = Security::decrypt( base64_decode($user_data->is_check_surg_his), SEC_KEY);
	        }

	        if(!empty($user_data->surgical_history)){

	        	$user_data->surgical_history = unserialize((Security::decrypt(base64_decode($user_data->surgical_history), SEC_KEY)));
	        }

	        if(!empty($user_data->is_family_his)){
	            $user_data->is_family_his = Security::decrypt( base64_decode($user_data->is_family_his), SEC_KEY);
	        }

	        if(!empty($user_data->family_history)){

	        	$user_data->family_history = unserialize((Security::decrypt(base64_decode($user_data->family_history), SEC_KEY)));
	        }

	        if(!empty($user_data->is_check_allergy_his)){
	            $user_data->is_check_allergy_his = Security::decrypt( base64_decode($user_data->is_check_allergy_his), SEC_KEY);
	        }

	        if(!empty($user_data->allergy_history)){

	        	$user_data->allergy_history = unserialize((Security::decrypt(base64_decode($user_data->allergy_history), SEC_KEY)));
	        }

	        if(!empty($user_data->other_drug_history)){

	        	$user_data->other_drug_history = unserialize((Security::decrypt(base64_decode($user_data->other_drug_history), SEC_KEY)));
	        }

	        if(!empty($user_data->other_drug_history_past)){

	        	$user_data->other_drug_history_past = unserialize((Security::decrypt(base64_decode($user_data->other_drug_history_past), SEC_KEY)));
	        }

	        if(!empty($user_data->shots_history)){

	        	$user_data->shots_history = unserialize((Security::decrypt(base64_decode($user_data->shots_history), SEC_KEY)));
	        }

            if(!empty($user_data->other_shots_history)){

                $user_data->other_shots_history = unserialize((Security::decrypt(base64_decode($user_data->other_shots_history), SEC_KEY)));
            }

            $is_retired_trans = array(
                '0' => 'not retired',
                '1' => 'retired'
            );

            $race_trans = array(
                '1' =>'hispanic',
                '0' => 'non hispanic'
            );
            $marital_status_trans = array(
                '0' => 'single',
                '1' => 'married',
                '2' => 'divorced'
            );

            $sexual_orientation_trans = array(

                '0' => 'heterosexual',
                '1' => 'homosexual',
                '2' => 'bisexual',
                '9' => 'prefer not to say'
            );

            $ethinicity_trans = array(
                '0' => 'asian',
                '1' => 'caucasian',
                '2' => 'hispanic',
                '3' => 'pacific',
                '4' => 'native American',
                '5' => 'african American',
                '9' => 'prefer not to say'
            );

            //basic detail tab

            $basic_details = array(
                'isRetired' => isset($is_retired_trans[$user_data->is_retired]) ? $is_retired_trans[$user_data->is_retired] : "",
                'height' => $user_data->height,
                'weight' => $user_data->weight,
                'guarantor' => $user_data->guarantor,
                'insuranceCompany' => $user_data->insurance_company,
                'pharmacy' =>$user_data->pharmacy,
                'address' => $user_data->address,
                'city' => $user_data->city,
                'state' => $user_data->state,
                'zip' => $user_data->zip,
                'race' => isset($race_trans[$user_data->race]) ? $race_trans[$user_data->race] : "",
                'bmi' => $user_data->bmi,
                'occupation' => $user_data->occupation,
                'maritalStatus' => isset($marital_status_trans[$user_data->marital_status]) ? $marital_status_trans[$user_data->marital_status] : "",
                'sexualOrientation' => isset($sexual_orientation_trans[$user_data->sexual_orientation]) ? $sexual_orientation_trans[$user_data->sexual_orientation] : "",
                'ethnicity' => isset($ethinicity_trans[$user_data->ethinicity]) ? $ethinicity_trans[$user_data->ethinicity] : "",
                //'tab' => 1
            );

            //pr($user_data);die;


	        //generate the response according to tab

	        //medical history tab detail
	        $medical_history_detail = array(

	        	'isCheckMedHis' => $user_data->is_check_med_his,
	        	'medicalHistory' => !empty($user_data->medical_history) ? $user_data->medical_history : [],
	        	//'tab' => 2
	        );


	        //surgical history tab detail
	        $surgical_history_detail = array(

	        	'isCheckSurgHis' => $user_data->is_check_surg_his,
	        	'surgicalHistory' => !empty($user_data->surgical_history) ? $user_data->surgical_history : [],
	        	//'tab' => 3
	        );


            $family_members_trans = array(
                1 => 'father',
                2=> 'mother',
                3=> 'grandmother (dad-side)',
                4=> "grandfather (dad-side)",
                5=> "grandmother (mom-side)",
                6=> "grandfather (mom-side)",
                7=> "brother",
                8=> "sister",
                9=> "son",
                10=> "daughter",
                11=> "cousin(mom's side)",
                12=> "cousin(dad's side)",
                13=> "aunt(mom's side)",
                14=> "aunt(dad's side)",
                15=> "uncle(mom's side)",
                16=> "uncle(dad's side)"
            );

            $family_history = [];
            if(!empty($user_data->family_history)){

                

                foreach ($user_data->family_history as $key => $value) {

                    $temp_arr = [];
                    $temp_arr['name'] = isset($family_members_trans[$value['name']]) ? $family_members_trans[$value['name']]: "";

                    $temp_arr['disease'] = $value['disease'];
                    
                    if(isset($value['alive_status'])){
                        $temp_arr['aliveStatus'] = $value['alive_status'];
                    }
                    if(isset($value['decease_year'])){
                        $temp_arr['deceaseYear'] = $value['decease_year'];
                    }
                    if(isset($value['cause_of_death'])){
                        $temp_arr['causeOfDeath'] = $value['cause_of_death'];
                    }

                    $family_history[] = $temp_arr;
                }
            }

	        //family history tab detail
	        $family_history_detail = array(

	        	'isFamilyHistory' => $user_data->is_family_his,
	        	'familyHistory' => $family_history,
	        	//'tab' => 4
	        );

	        //allergy history tab detail
	        $allergy_history_detail = array(

	        	'isCheckAllergyHis' => $user_data->is_check_allergy_his,
	        	'allergyHistory' => !empty($user_data->allergy_history) ? $user_data->allergy_history : [],
	        	//'tab' => 5
	        );


	        //social history tab detail

            $other_drug_history = [];
            if(!empty($user_data->other_drug_history)){

                foreach ($user_data->other_drug_history as $key => $value) {

                    $value['year'] = $value['year'] == 'morethan10' ? 'more than 10' : $value['year'];
                    $other_drug_history[] = $value;
                }
            }

            $other_drug_history_past = [];
            if(!empty($user_data->other_drug_history_past)){

                foreach ($user_data->other_drug_history_past as $key => $value) {

                    $value['year'] = $value['year'] == 'morethan10' ? 'more than 10' : $value['year'];
                    $other_drug_history_past[] = $value;
                }
            }


	        $social_history_detail = array(

	        	'isCurrentlySmoking' => $user_data->is_currentlysmoking,
                'currentSmokePack' => $user_data->current_smoke_pack == 'morethan10' ? "more than 10" : $user_data->current_smoke_pack,
                'isPastsmoking' => $user_data->is_pastsmoking,
                'pastSmokePack' => $user_data->past_smoke_pack == 'morethan10' ? "more than 10" : $user_data->past_smoke_pack,
                'pastSmokeYear' => $user_data->past_smoke_year == 'morethan10' ? "more than 10" : $user_data->past_smoke_year,
                'isCurrentlyDrinking' => $user_data->is_currentlydrinking,
                'currentDrinkPack' => $user_data->current_drink_pack == 'morethan10' ? "more than 14" : $user_data->current_drink_pack,
                'isPastDrinking' => $user_data->is_pastdrinking,
                'pastDrinkPack' => $user_data->past_drink_pack == 'morethan10' ? "more than 14" : $user_data->past_drink_pack,
                'pastDrinkYear' => $user_data->past_drink_year == 'morethan10' ? "more than 10" : $user_data->past_drink_year,
                'isOtherdrug' => $user_data->is_otherdrug,
                'otherDrugHistory' => $other_drug_history,
                'isOtherDrugPast' => $user_data->is_otherdrugpast,
                'otherDrugHistoryPast' => $other_drug_history_past,
	        	//'tab' => 6
	        );

            //pr($user_data->shots_history);die;
            //shots history
            $shots_history = [];
            if(!empty($user_data->shots_history)){

                $shot_cond_ids = array_keys($user_data->shots_history);


                $shot_cond = $commonTable->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'name'
                ])->where(['cond_type' => 4,'id IN' => $shot_cond_ids])->toArray();

                if(!empty($shot_cond)){

                    foreach ($shot_cond as $key => $value) {

                        $shots_history[] = array(
                            'name' => $value,
                            'year' => isset($user_data->shots_history[$key]) ? $user_data->shots_history[$key] : ""
                        );
                    }
                }
            }


            $shots_history_details = array(

                'shotsHistory' => $shots_history,
                'otherShotsHistory' => !empty($user_data->other_shots_history) ? $user_data->other_shots_history : []
               // 'tab' => 8
            );

	        $response = array(
                "userId" => $user_data['id'],
                'basicDetails' => $basic_details,
	        	'medicalHistoryDetails' => $medical_history_detail,
	        	'surgicalHistoryDetails' => $surgical_history_detail,
	        	'familyHistoryDetails' => $family_history_detail,
	        	'allergyHistoryDetails' => $allergy_history_detail,
                'socialHistoryDetails' => $social_history_detail
	        );

            //decrypt the women data

            //pr($women_field);die;

            if(!empty($women_field))
            {
                $womanrec = $women_field;
                if(!empty($womanrec->age_of_first_priod)){
                    $womanrec->age_of_first_priod = Security::decrypt( base64_decode($womanrec->age_of_first_priod), SEC_KEY);
                }

                if(!empty($womanrec->no_of_pregnency)){
                    $womanrec->no_of_pregnency = Security::decrypt( base64_decode($womanrec->no_of_pregnency), SEC_KEY);
                }

                if(!empty($womanrec->no_of_miscarriage)){
                    $womanrec->no_of_miscarriage = Security::decrypt( base64_decode($womanrec->no_of_miscarriage), SEC_KEY);
                }


                if(!empty($womanrec->is_regular_papsmear)){
                    $womanrec->is_regular_papsmear = Security::decrypt( base64_decode($womanrec->is_regular_papsmear), SEC_KEY);
                }

                if(!empty($womanrec->papsmear_finding)){
                    $womanrec->papsmear_finding = Security::decrypt( base64_decode($womanrec->papsmear_finding), SEC_KEY);
                }

                if(!empty($womanrec->papsmear_month)){
                    $womanrec->papsmear_month = Security::decrypt( base64_decode($womanrec->papsmear_month), SEC_KEY);
                }

                if(!empty($womanrec->papsmear_year)){
                    $womanrec->papsmear_year = Security::decrypt( base64_decode($womanrec->papsmear_year), SEC_KEY);
                }

                if(!empty($womanrec->is_curently_pregnant)){
                    $womanrec->is_curently_pregnant = Security::decrypt( base64_decode($womanrec->is_curently_pregnant), SEC_KEY);
                }

                if(!empty($womanrec->current_baby_sex)){
                    $womanrec->current_baby_sex = Security::decrypt( base64_decode($womanrec->current_baby_sex), SEC_KEY);
                }

                if(!empty($womanrec->currently_pregnant_week)){
                    $womanrec->currently_pregnant_week = Security::decrypt( base64_decode($womanrec->currently_pregnant_week), SEC_KEY);
                }

                if(!empty($womanrec->currently_pregnant_days)){
                    $womanrec->currently_pregnant_days = Security::decrypt( base64_decode($womanrec->currently_pregnant_days), SEC_KEY);
                }

                if(!empty($womanrec->currently_pregnant_complication)){
                    $womanrec->currently_pregnant_complication = Security::decrypt( base64_decode($womanrec->currently_pregnant_complication), SEC_KEY);
                }

                if(!empty($womanrec->is_previous_birth)){
                    $womanrec->is_previous_birth = Security::decrypt( base64_decode($womanrec->is_previous_birth), SEC_KEY);
                }

                if(!empty($womanrec->previous_birth_sex)){
                    $womanrec->previous_birth_sex = Security::decrypt( base64_decode($womanrec->previous_birth_sex), SEC_KEY);
                }

                if(!empty($womanrec->previous_delivery_method)){
                    $womanrec->previous_delivery_method = Security::decrypt( base64_decode($womanrec->previous_delivery_method), SEC_KEY);
                }

                if(!empty($womanrec->previos_pregnancy_duration)){
                    $womanrec->previos_pregnancy_duration = Security::decrypt( base64_decode($womanrec->previos_pregnancy_duration), SEC_KEY);
                }
                if(!empty($womanrec->previous_complication)){
                    $womanrec->previous_complication = Security::decrypt( base64_decode($womanrec->previous_complication), SEC_KEY);
                }

                if(!empty($womanrec->previous_hospital)){
                    $womanrec->previous_hospital = Security::decrypt( base64_decode($womanrec->previous_hospital), SEC_KEY);
                }

                if(!empty($womanrec->is_mammogram))
                {
                    $womanrec->is_mammogram = Security::decrypt( base64_decode($womanrec->is_mammogram), SEC_KEY);
                }

                if(!empty($womanrec->mammogram_month)){
                    $womanrec->mammogram_month = Security::decrypt( base64_decode($womanrec->mammogram_month), SEC_KEY);
                }

                if(!empty($womanrec->mammogram_year)){
                    $womanrec->mammogram_year = Security::decrypt( base64_decode($womanrec->mammogram_year), SEC_KEY);
                }

                if(!empty($womanrec->previous_abnormal_breast_lump)){
                    $womanrec->previous_abnormal_breast_lump = Security::decrypt( base64_decode($womanrec->previous_abnormal_breast_lump), SEC_KEY);
                }

                if(!empty($womanrec->any_biopsy)){
                    $womanrec->any_biopsy = Security::decrypt( base64_decode($womanrec->any_biopsy), SEC_KEY);
                }

                if(!empty($womanrec->is_sti_std)){
                    $womanrec->is_sti_std = Security::decrypt( base64_decode($womanrec->is_sti_std), SEC_KEY);
                }

                if(!empty($womanrec->sti_std_detail)){

                    $womanrec->sti_std_detail = unserialize((Security::decrypt(base64_decode($womanrec->sti_std_detail), SEC_KEY)));
                }

                if(!empty($womanrec->breast_lump_biopsy_result)){

                    $womanrec->breast_lump_biopsy_result = unserialize((Security::decrypt(base64_decode($womanrec->breast_lump_biopsy_result), SEC_KEY)));
                }

                if(!empty($womanrec->prev_birth_detail)){

                    $womanrec->prev_birth_detail = @unserialize(Security::decrypt( base64_decode($womanrec->prev_birth_detail), SEC_KEY));
                }

                $women_field  = $womanrec;
                //pr($women_field);die;

                $breast_lump_biopsy_result = [];
                if(!empty($women_field->breast_lump_biopsy_result)){

                    foreach ($women_field->breast_lump_biopsy_result['biopsy_month'] as $key => $value) {

                        if(isset($women_field->breast_lump_biopsy_result['biopsy_year'][$key]) && isset($women_field->breast_lump_biopsy_result['biopsy_result'][$key])){

                            $breast_lump_biopsy_result[] = array(
                                'biopsyMonth' => $value,
                                'biopsyYear' => $women_field->breast_lump_biopsy_result['biopsy_year'][$key],
                                'biopsyResult' => $women_field->breast_lump_biopsy_result['biopsy_year'][$key]
                            );
                        }
                    }
                }

                $ob_gyn_history = array(

                   'ageOfFirstPeriod' => $women_field->age_of_first_priod,
                   'numberOfPregnancy'  => $women_field->no_of_pregnency,
                   'numberOfMiscarriage' => $women_field->no_of_miscarriage,
                   'numberOfLiveBirth' => $women_field->no_of_live_birth,
                   //'last_papsmear' => $women_field->last_papsmear,
                   'isRegularPapsmear' => $women_field->is_regular_papsmear == 1 ? "regular" : "irregular",
                   'papsmearFinding' => $women_field->papsmear_finding,
                   'papsmearMonth' => $women_field->papsmear_month,
                   'papsmearYear' => $women_field->papsmear_year,
                   'isCurentlyPregnant' => $women_field->is_curently_pregnant,
                   'currentBabySex' => $women_field->current_baby_sex,
                   'currentlyPregnantWeek' => $women_field->currently_pregnant_week,
                   'currentlyPregnantDays' => $women_field->currently_pregnant_days,
                   'currentlyPregnantComplication' => $women_field->currently_pregnant_complication,
                   'isPreviousBirth' => $women_field->is_previous_birth,
                   'previousBirthSex' => $women_field->previous_birth_sex,
                   'previousDeliveryMethod' => $women_field->previous_delivery_method,
                   'previosPregnancyDuration' => $women_field->previos_pregnancy_duration,
                   'previousComplication' => $women_field->previous_complication,
                   'previousHospital' => $women_field->previous_hospital,
                   'isMammogram' => $women_field->is_mammogram,
                   'mammogramMonth' => $women_field->mammogram_month,
                   'mammogramYear' => $women_field->mammogram_year,
                   'previousAbnormalBreastLump' => $women_field->previous_abnormal_breast_lump,
                   'anyBiopsy' => $women_field->any_biopsy,
                   'isStiStd' => $women_field->is_sti_std,
                   'stiStdDetail' => !empty($women_field->sti_std_detail) ? $women_field->sti_std_detail : [],
                   'breastLumpBiopsyResult' => $breast_lump_biopsy_result

                );

                $ob_gyn_history_details = array(

                    'obGynHistory' => $ob_gyn_history,
                    //'tab' => 7
                );

                $response['obGynHistoryDetails'] = $ob_gyn_history_details;
            }

            //$check_emh_field_view = unserialize($user_data->check_emh_field_view);

            $response['shotsHistoryDetails'] = $shots_history_details;
           // $response['check_emh_field_view'] = $check_emh_field_view;

            $header = array(
                    'statusCode' => 200,
                    'message' => 'Patient medical history details retrieved successfully.'
                );

            $payload = array(
                'patientDetail' => $response
            );

            $response = ['header' => $header,'payload' => $payload];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        catch(\Exception $e){

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

    }

    public function editMedicalHistory()
    {
        try
        {
            $this->loadModel('Users');
            $response = array();
            if(empty($this->request->getData())){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Blank Parameter Error'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $access_token = $this->request->data('accessToken');
            $userId = $this->request->data('userId');
            $bare_bones = $this->request->getData('bareBones');
            $bare_bones = $bare_bones != "" && $bare_bones == 0 ? 0 : 1;
            $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);
            if(empty($org_provider_ids)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid access token.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if(isset($org_provider_ids['header'])){
                
                return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
            }

            $user_data = $this->Users->find('all')->where(['id' => $userId])->first();
            if(empty($user_data)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid user id.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            if($user_data->role_id != 2){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'User is registered as admin or provider.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }

            $uuid_token = $user_data->id.'U'.$bare_bones;
            $uuid_token = $this->CryptoSecurity->tokenEncrypt($uuid_token);
            $user_data->uuid_token = $uuid_token;
            $user_data->bare_bones = $bare_bones;
            $user_data->uuid_token_created_at = date('Y-m-d H:i:s');

            if($this->Users->save($user_data)){

                $url = SITE_URL.'services/api/medical-history?uuid='.urlencode($uuid_token);
                $header = array(
                    'statusCode' => 200,
                    'message' => 'Edit medical history link.'
                );
                $payload = array('medicalHistoryLink' => $url);
                $response = ['header' => $header,'payload' => $payload];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
            else{
                $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal server error, Please try again.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
        }
        catch(\Exception $e){

            $header = array(
                    'statusCode' => 500,
                    'message' => 'Internal error, Please try again.'
                );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
    }

    public function saveEditMedicalHistory()
    {   
        try{
        
        $this->loadModel('Users');
        $commonTable = TableRegistry::get('common_conditions');
        $this->WomenSpecific = TableRegistry::get('WomenSpecific');

        if(empty($this->request->getData())){

          $header = array(
              'statusCode' => 400,
              'message' => 'Blank Parameter Error'
          );

          $response = ['header' => $header];
          return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

        $access_token = $this->request->data('accessToken');
        $userId = $this->request->data('userId');
        $email = $this->request->data('email');
        $phone = $this->request->data('phone');
        $first_name = $this->request->data('firstName');
        $last_name = $this->request->data('lastName');
        $dob = $this->request->data('dob');

        $org_provider_ids = json_decode($this->ApiGenaral->tokenVerify($access_token),true);

        if(empty($org_provider_ids)){

          $header = array(
              'statusCode' => 402,
              'message' => 'Invalid access token.'
          );
          $response = ['header' => $header];
          return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

        if(isset($org_provider_ids['header'])){
                
            return $this->response->withType("application/json")->withStringBody(json_encode($org_provider_ids));
        }

        
        //get the user_detail
        $user_data = null;
        $skip_search = 0;

        if(!empty($userId)){

            $user_data = $this->Users->find('all')->where(['id' => $userId])->first();
            $skip_search = 1;
        }
        //pr($skip_search);die();

        if(!$skip_search){

            //check patient is registered or not on allevia platform
            if(!empty($email) || !empty($phone)){

                $filter = array();
                $enc_phone = "";
                $enc_email = "";
                
                if(!empty($email)){

                    $enc_email = base64_encode($this->CryptoSecurity->encrypt(strtolower($email),SEC_KEY));
                    $filter['email'] = $enc_email;
                }

                if(!empty($phone)){

                    $enc_phone = base64_encode($this->CryptoSecurity->encrypt($phone,SEC_KEY));
                    $filter['phone'] = $enc_phone;
                }

                //pr($filter);die;

                $user_detail_all = $this->Users->find('all')->where(['OR'=> $filter])->toArray();
                //pr($user_detail_all);die;
                if(!empty($user_detail_all)){

                    $user_valid = 0;
                    foreach($user_detail_all as $all_user_key => $all_user_value){

                        if(($enc_email != '' && $all_user_value['email'] == $enc_email && $enc_phone != '' && $all_user_value['phone'] == $enc_phone) || ($enc_email == '' && $enc_phone != '' && $all_user_value['phone'] == $enc_phone) || ($enc_email != '' && $all_user_value['email'] == $enc_email && $enc_phone == '')){

                            $user_data = $all_user_value;
                            $user_valid = 1;
                            break;
                        }
                    }

                    if(!$user_valid){

                        $header = array(
                            'statusCode' => 402,
                            'message' => 'Invalid user.'
                        );
                        $response = ['header' => $header];
                        return $this->response->withType("application/json")->withStringBody(json_encode($response));
                    }
                }
            }
            elseif(!empty($first_name) && !empty($last_name) && !empty($dob))
            {

                $enc_first_name = base64_encode($this->CryptoSecurity->encrypt($first_name,SEC_KEY));
                $enc_last_name = base64_encode($this->CryptoSecurity->encrypt($last_name,SEC_KEY));
                $enc_dob = base64_encode($this->CryptoSecurity->encrypt(date('Y-m-d',strtotime($dob)),SEC_KEY));

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
                $user_data = $this->Users->find('all')->where($filter)->first();
            }
        }

        if(empty($user_data)){

            $header = array(
                  'statusCode' => 402,
                  'message' => 'Invalid user.'
              );
            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

        if($user_data['role_id'] != 2){

            $header = array(
                  'statusCode' => 402,
                  'message' => 'User is registered as admin or provider.'
            );
            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        
        
        $response = array();
        $error = array();
        $saved_tabs = [];

        $start_year = 1930;
        $curyear = date("Y");
        $year_whitelist_arr = array();
        for($curyear ; $curyear>= $start_year ; $curyear--){
            $year_whitelist_arr[] = $curyear ;
        }
        $year_whitelist_arr[] = ''; $year_whitelist_arr[] = 1;
        $month_whitelist_arr = array('',0,1,2,3,4,5,6,7,8,9,10,11);     

      $data_arr = array();
      $data_arr['medical_history_update_date'] = Time::now();

       if(empty($user_data->check_emh_field_view)){

            $check_emh_field_view = array(

              'checkbasic' => 0,
              'checkmedical' => 0,
              'checksurgical' => 0,
              'checkfamily' => 0,
              'checkallergy' => 0,
              'checkshots' => 0,
              'checksocial' => 0,
              'checkobgyn' => 0
            );
          }
          else{

            $check_emh_field_view = unserialize($user_data->check_emh_field_view);

          }

        $user_gender = $user_data->gender;
        if(!empty($user_gender)){

            $user_gender = Security::decrypt(base64_decode($user_gender),SEC_KEY);
        }
        //$patient_detail_Data = $this->request->data('basicDetails.isRetired');
        //pr($patient_detail_Data);die;

          $patient_detail_Data = $this->request->data('basicDetails');
          $medicalHistoryDetails = $this->request->data('medicalHistoryDetails');
          $surgicalHistoryDetails = $this->request->data('surgicalHistoryDetails');
          $familyHistoryDetails = $this->request->data('familyHistoryDetails');
          $allergyHistoryDetails = $this->request->data('allergyHistoryDetails');
          $shotsHistoryDetails = $this->request->data('shotsHistoryDetails');
          $socialHistoryDetails = $this->request->data('socialHistoryDetails');
          $shotsHistoryDetails = $this->request->data('shotsHistoryDetails');
          $obGynHistoryDetails = $this->request->data('obGynHistoryDetails');
          
          

      	if(!empty($patient_detail_Data))
      	{
            $is_retired = $this->request->data('basicDetails.isRetired');
            $height = $this->request->data('basicDetails.height');
            $height_inches = $this->request->data('basicDetails.heightInches');
            $weight = $this->request->data('basicDetails.weight');
            $zip = $this->request->data('basicDetails.zip');
            $sexual_orientation = $this->request->data('basicDetails.sexualOrientation');
            $marital_status = $this->request->data('basicDetails.maritalStatus');
            $ethinicity = $this->request->data('basicDetails.ethnicity');
            $occupation = $this->request->data('basicDetails.occupation');
            $guarantor = $this->request->data('basicDetails.guarantor');
            $insurance_company = $this->request->data('basicDetails.insuranceCompany');
            $pharmacy = $this->request->data('basicDetails.pharmacy');
            $address = $this->request->data('basicDetails.address');
            $city = $this->request->data('basicDetails.city');
            $state = $this->request->data('basicDetails.state');
            $race = $this->request->data('basicDetails.race');
           // $bmi = $patient_detail_Data['bmi'];

            $temp_err = array();

            //whitelisting the all input fields of tab number 1

            if($is_retired !== "" && !in_array($is_retired, array(0,1))){
                $temp_err['isRetired'][] =  'Invalid value for isRetired.';
                $is_retired = "";
            }
                       
            
            if(!empty($height) && !in_array($height, array(1,2,3,4,5,6,7))){
              $temp_err['height'][] =  'invalid value for height.';
              $height = "";
            }

            if($height_inches !== "" && !in_array($height_inches, array(0,1,2,3,4,5,6,7,8,9,10,11))){
                $temp_err['heightInches'] =  'invalid value for heightInches.';
                $height_inches = "";
            }

            if(!empty($weight) && !is_numeric($weight)){
                $temp_err['weight'][] =  'invalid value for weight.';
                $weight = "";
            }

            

            if(!empty($zip) && !is_numeric($zip)){
                $temp_err['zip'][] =  'invalid value for zip.';
                $zip = "";
            }

            

            if($sexual_orientation !== "" && !in_array($sexual_orientation, array(0,1,2,9))){

                $temp_err['sexualOrientation'][] =  'invalid value for sexualOrientation.';
                $sexual_orientation = ""; 
            }

            

            if($marital_status !== "" && !in_array($marital_status, array(0,1,2))){
                $temp_err['maritalStatus'][] =  'invalid value for maritalStatus.';
                $marital_status = "";
            }

           
            if($ethinicity !== "" && !in_array($ethinicity, array(0,1,2,3,4,5,9))){
                $temp_err['ethnicity'][] =  'invalid value for ethnicity.';
                $ethinicity = "";
            }
            

            if(!empty($guarantor) && !in_array($guarantor, ["self-pay","health insurance","medicare","medicaid","others"])){

              $temp_err['guarantor'][] = 'invalid value for guarantor.';
              $guarantor = "";  
            }
            
            if(!empty($state) && !in_array($state, ["AL","AK","AZ","AR","CA","CO","CT","DE","DC","FL","GA","HI","ID","IL","IN","IA","KS","KY","LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VT","VA","WA","WV","WI","WY","AS","GU","MP","PR","UM","VI"])){
                $temp_err['state'][] =  'invalid value for state.';
                $state = "";
            }

            if($race !== "" && !in_array($race, [0,1])){

              $temp_err['race'][] = 'invalid value for race.'; 
              $race = ""; 
            }

            if($guarantor != 'health insurance'){

            	$insurance_company = "";
            }
            $error["basicDetails"] = $temp_err;

            /*if(empty($error["basicDetails"]))
            {*/
              $data_arr['height'] = $height;
              $data_arr['heightInches'] = $height_inches;
              if(is_numeric($data_arr['height']) && is_numeric($data_arr['heightInches'])){
                $data_arr['height'] = ($data_arr['height'] * 12 ) + $data_arr['heightInches'];
              }

              	$bmi = "";
	            if(!empty($data_arr['height']) && !empty($weight)){
					 	$bmi = ($weight * 0.45) / (pow(($data_arr['height']*0.025), 2)) ;
					 	$bmi = round($bmi, 1);
				}

              if(!empty($data_arr['height'])){
                $data_arr['height'] = base64_encode(Security::encrypt($data_arr['height'], SEC_KEY));
              }

              $data_arr['weight'] = !empty($weight) ? base64_encode(Security::encrypt($weight, SEC_KEY)): $weight;
              $data_arr['guarantor'] = !empty($guarantor) ? base64_encode(Security::encrypt($guarantor, SEC_KEY)) : $guarantor;
              $data_arr['insurance_company'] = !empty($insurance_company) ? base64_encode(Security::encrypt($insurance_company, SEC_KEY)) : $insurance_company;
              $data_arr['pharmacy'] = !empty($pharmacy) ? base64_encode(Security::encrypt($pharmacy, SEC_KEY)) : $pharmacy;
              $data_arr['address'] = !empty($address) ? base64_encode(Security::encrypt($address, SEC_KEY)) : $address;
              $demptyata_arr['city'] = !empty($city) ? base64_encode(Security::encrypt($city, SEC_KEY)) : $city;
              $data_arr['state'] = !empty($state) ? base64_encode(Security::encrypt($state, SEC_KEY)) : $state;
              $data_arr['zip'] = !empty($zip) ? base64_encode(Security::encrypt($zip, SEC_KEY)) : $zip;
              $data_arr['race'] = isset($race) ? base64_encode(Security::encrypt($race, SEC_KEY)) : $race;
              $data_arr['bmi'] = !empty($bmi) ? base64_encode(Security::encrypt($bmi, SEC_KEY)) : $bmi;
              $data_arr['is_retired'] = !empty($is_retired) ? base64_encode(Security::encrypt($is_retired, SEC_KEY)) : $is_retired;
              $data_arr['occupation'] = !empty($occupation) ? base64_encode(Security::encrypt($occupation, SEC_KEY)) : $occupation;
              $data_arr['marital_status'] = !empty($marital_status) ? base64_encode(Security::encrypt($marital_status, SEC_KEY)) : $marital_status;
              $data_arr['sexual_orientation'] = !empty($sexual_orientation) ? base64_encode(Security::encrypt($sexual_orientation, SEC_KEY)) : $sexual_orientation;
              $data_arr['ethinicity'] = !empty($ethinicity) ? base64_encode(Security::encrypt($ethinicity, SEC_KEY)) : $ethinicity;
              $data_arr['current_tab'] = 2;
              //$check_emh_field_view['checkbasic'] = 1;
              $saved_tabs[] = "basicDetails";
              
           // }
      }
      //pr($medicalHistoryDetails);die;

      if(!empty($medicalHistoryDetails))
      {
        $temp_err = array();
        $medical_history = $this->request->data('medicalHistoryDetails.medicalHistory');
        $is_check_med_his = $this->request->data('medicalHistoryDetails.isCheckMedHis');

        /*if($check_emh_field_view['checkbasic'] != 1){

          $temp_err['checkbasic'][] =  'Please fill the basic detail before fill the medical history details.';  
        }*/

        if(!in_array($is_check_med_his, array(0,1))){
             $temp_err['isCheckMedHis'][] =  'invalid value for isCheckMedHis.';
             $is_check_med_his = "";
        }

        $tempar = array();
        $i = 0 ;

        if($is_check_med_his == 1 && !empty($medical_history))
        {
            foreach ($medical_history as $key => $value) {
                if(!isset($value['name']) || empty($value['name'])) continue;

                if(isset($value['year']) && !in_array($value['year'], $year_whitelist_arr) ){
                  $temp_err['medicalHistory'][$key][] = 'invalid Year';
                  continue;
                }

                $tempar[$i]['name'] = $value['name'];
                $tempar[$i]['year'] = isset($value['year']) ? $value['year'] : "";
                $i++ ;

            }            
        }

        $error["medicalHistoryDetails"] = $temp_err;
        /*if(empty($error["medicalHistoryDetails"]))
        {*/

            $tempar = $is_check_med_his == 1 ? $tempar : "";
            $data_arr['medical_history'] = !empty($tempar) ? base64_encode(Security::encrypt((serialize($tempar)), SEC_KEY)) : "";

            if(is_numeric($is_check_med_his) && in_array($is_check_med_his, array(0,1))){

              $data_arr['is_check_med_his'] = base64_encode(Security::encrypt($is_check_med_his, SEC_KEY));
            }

            $data_arr['current_tab'] = 3;
            //$check_emh_field_view['checkmedical'] = 1;
            $saved_tabs[] = "medicalHistoryDetails";
       // }  
      }


      if(!empty($surgicalHistoryDetails))
      {
        $temp_err = array();
        $surgical_history = $this->request->data('surgicalHistoryDetails.surgicalHistory');
        $is_check_surg_his = $this->request->data('surgicalHistoryDetails.isCheckSurgHis');

        /*if($check_emh_field_view['checkmedical'] != 1){

          $temp_err['checkmedical'][] =  'Please fill the medical history details before fill the surgical history details.';  
        }*/

        if(!in_array($is_check_surg_his, array(0,1))){
             $temp_err['isCheckSurgHis'][] =  'invalid value for isCheckSurgHis';
             $is_check_surg_his = "";
        }

        $tempar = array();
        $i = 0 ;

        if($is_check_surg_his == 1 && !empty($surgical_history))
        {
            foreach ($surgical_history as $key => $value) {
                if(!isset($value['name']) || empty($value['name'])) continue;

                if(isset($value['year']) && !in_array($value['year'], $year_whitelist_arr) ){
                  $temp_err['surgicalHistory'][$key][] = 'invalid year.';
                  continue;
                }

                $tempar[$i]['name'] = $value['name'];
                $tempar[$i]['year'] = isset($value['year']) ? $value['year'] : "";
                $i++ ;

            }            
        }

        $error['surgicalHistoryDetails'] = $temp_err;
        // if(empty($error['surgicalHistoryDetails']))
        // {
            $tempar = $is_check_surg_his == 1 ? $tempar : "";
            $data_arr['surgical_history'] = !empty($tempar) ?  base64_encode(Security::encrypt((serialize($tempar)), SEC_KEY)) : "";

            if(is_numeric($is_check_surg_his) && in_array($is_check_surg_his, array(0,1))){

              $data_arr['is_check_surg_his'] = base64_encode(Security::encrypt($is_check_surg_his, SEC_KEY));
            }

            $data_arr['current_tab'] = 4;
            //$check_emh_field_view['checksurgical'] = 1;
            $saved_tabs[] = "surgicalHistoryDetails";
        //}
      }

      //Family history
      if(!empty($familyHistoryDetails))
      {
        $temp_err = array();
        $family_history = $this->request->data('familyHistoryDetails.familyHistory');
        $is_family_his = $this->request->data('familyHistoryDetails.isFamilyHistory');

        /*$family_members_trans = array(
            'father' =>1,
            'mother' =>2,
            'grandmother (dad-side)' =>3,
            "grandfather (dad-side)" =>4,
            "grandmother (mom-side)" =>5,
            "grandfather (mom-side)" =>6,
            "brother" =>7,
            "sister" =>8,
            "son" =>9,
            "daughter" =>10,
            "cousin(mom's side)" =>11,
            "cousin(dad's side)" =>12,
            "aunt(mom's side)" => 13,
            "aunt(dad's side)" => 14,
            "uncle(mom's side)" =>15,
            "uncle(dad's side)" =>16
        );*/

        $age_whitelist_dece_arr = array();
        for($dece = 0 ; $dece <= 110 ; $dece++){
          $age_whitelist_dece_arr[] = $dece ;
        }
        $age_whitelist_dece_arr[] = 911; $age_whitelist_dece_arr[] = 999;

        /*if($check_emh_field_view['checksurgical'] != 1){

          $temp_err['checksurgical'][] =  'Please fill the surgical history details before fill the family history details.';  
        }*/

        if(!in_array($is_family_his, array(0,1))){
            $temp_err['isFamilyHistory'][] =  'invalid value for isFamilyHistory';
            $is_family_his = "";
        }

        $tempar = array();
        $i = 0 ;

        if($is_family_his == 1 && !empty($family_history))
        {
            $check_for_unique_family_name = array();
            foreach ($family_history as $key => $value) {

                if(!isset($value['name']) || !isset($value['disease'])){

                    continue;
                }

                if(!in_array($value['name'], array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16)))
                {
                    $temp_err['familyHistory'][$key][] = 'invalid family member.';
                }
                if(isset($value['aliveStatus']) && !in_array($value['aliveStatus'], array('',0,1)))
                {
                    $temp_err['familyHistory'][$key][] = 'invalid valuse for aliveStatus.';
                }
                if((isset($value['deceaseYear']) && !in_array($value['deceaseYear'], $age_whitelist_dece_arr)))
                {
                    $temp_err['familyHistory'][$key][] = 'invalid value for deceaseYear';
                }

                if(!empty($temp_err['familyHistory'][$key])){
                    continue;
                }

              if(in_array($value['name'], $check_for_unique_family_name)) continue;
               $check_for_unique_family_name[] = $value['name'];
               $tempar[$i]['name'] = $value['name'];
                $tempar[$i]['disease'] =  $value['disease'];
                if(isset($value['aliveStatus'])){
                 $tempar[$i]['alive_status'] =  $value['aliveStatus'];
                 if($tempar[$i]['alive_status'] == 0)
                 {
                     $tempar[$i]['decease_year'] =  isset($value['deceaseYear']) ? $value['deceaseYear'] : "";
                     $tempar[$i]['cause_of_death'] =  isset($value['causeOfDeath']) ? $value['causeOfDeath'] : "";
                 }
                }                
                $i++ ;
            }            
        }

        $error['familyHistoryDetails'] = $temp_err;
        // if(empty($error['familyHistoryDetails']))
        // {
            $tempar = $is_family_his == 1 ? $tempar : "";
            $data_arr['family_history'] = !empty($tempar) ? base64_encode(Security::encrypt((serialize($tempar)), SEC_KEY)) : "";
            if(is_numeric($is_family_his) && in_array($is_family_his, array(0,1))){

              $data_arr['isFamilyHis'] = base64_encode(Security::encrypt($is_family_his, SEC_KEY));
            }

            $data_arr['current_tab'] = 5;
            //$check_emh_field_view['checkfamily'] = 1;
            $saved_tabs[] = "familyHistoryDetails";
       // }
      }


      if(!empty($allergyHistoryDetails))
      {
        $temp_err = array();

        $allergy_history = $this->request->data('allergyHistoryDetails.allergyHistory');
        $is_check_allergy_his = $this->request->data('allergyHistoryDetails.isCheckAllergyHis');

        /*if($check_emh_field_view['checkfamily'] != 1){

          $temp_err['checkfamily'][] =  'Please fill the family history details before fill the allergy history details.';  
        }*/

        if(!in_array($is_check_allergy_his, array(0,1))){
             $temp_err['isCheckAllergyHis'] =  'invalid value for isCheckAllergyHis';
             $is_check_allergy_his = "";
        }

        $tempar = array();
        $i = 0 ;

        if($is_check_allergy_his == 1 && !empty($allergy_history))
        {
            foreach ($allergy_history as $key => $value) {
                if(!isset($value['name']) || empty($value['name'])) continue;

                $tempar[$i]['name'] = $value['name'];
                $tempar[$i]['reaction'] = isset($value['reaction']) ? $value['reaction'] : "";
                $i++;
            }            
        }

        $error["allergyHistoryDetails"] = $temp_err;
        /*if(empty($error["allergyHistoryDetails"]))
        {*/
            $tempar = $is_check_allergy_his == 1 ? $tempar : "";
            $data_arr['allergy_history'] = !empty($tempar) ? base64_encode(Security::encrypt((serialize($tempar)), SEC_KEY)) : "";

            if(is_numeric($is_check_allergy_his) && in_array($is_check_allergy_his, array(0,1))){

              $data_arr['is_check_allergy_his'] = base64_encode(Security::encrypt($is_check_allergy_his, SEC_KEY));
            }

            $data_arr['current_tab'] = 6;
            //$check_emh_field_view['checkallergy'] = 1;
            $saved_tabs[] = "allergyHistoryDetails";          
        //}        
      }

      if(!empty($socialHistoryDetails))
      {
        $temp_err = array();
        /*if($check_emh_field_view['checkallergy'] != 1){

          $temp_err['checkallergy'][] =  'Please fill the alleries detail before fill the social history details.';  
        }*/

        $current_smoke_pack = $this->request->data('socialHistoryDetails.currentSmokePack');
        $past_smoke_pack = $this->request->data('socialHistoryDetails.pastSmokePack');

        $past_smoke_year = $this->request->data('socialHistoryDetails.pastSmokeYear');
        $current_drink_pack = $this->request->data('socialHistoryDetails.currentDrinkPack');

        $past_drink_pack = $this->request->data('socialHistoryDetails.pastDrinkPack');
        $past_drink_year = $this->request->data('socialHistoryDetails.pastDrinkYear');

        $is_currentlysmoking = $this->request->data('socialHistoryDetails.isCurrentlySmoking'); 
        $is_pastsmoking = $this->request->data('socialHistoryDetails.isPastSmoking');


        $is_currentlydrinking = $this->request->data('socialHistoryDetails.isCurrentlyDrinking');
        $is_pastdrinking = $this->request->data('socialHistoryDetails.isPastDrinking');

        $is_otherdrug = $this->request->data('socialHistoryDetails.isOtherDrug');
        $is_otherdrugpast = $this->request->data('socialHistoryDetails.isPastOtherDrug');

        $other_drug_history = $this->request->data('socialHistoryDetails.otherDrugHistory');
        $other_drug_history_past = $this->request->data('socialHistoryDetails.pastOtherDrugHistory');

        

        if($is_currentlysmoking !== "" && !in_array($is_currentlysmoking, array(0,1))){
             $temp_err['isCurrentlySmoking'][] =  'invalid value for isCurrentlySmoking.';
             $is_currentlysmoking = "";
        }

        if(!empty($current_smoke_pack) && !in_array($current_smoke_pack, array('1','2','3','4','5','6','7','8','9','10',"morethan10"))){
             $temp_err['currentSmokePack'][] =  'invalid value for currentSmokePack.';
             $current_smoke_pack = "";
        }

        if($is_pastsmoking !== "" && !in_array($is_pastsmoking, array(0,1))){
            $temp_err['isPastSmoking'][] =  'invalid value for isPastSmoking.';
            $is_pastsmoking = "";
        }

        if(!empty($past_smoke_pack) && !in_array($past_smoke_pack, array('1','2','3','4','5','6','7','8','9','10',"morethan10"))){
             $temp_err['pastSmokePack'][] =  'invalid value for pastSmokePack.';
             $past_smoke_pack = "";
        }

        if(!empty($past_smoke_year) && !in_array($past_smoke_year, array('1','2','3','4','5','6','7','8','9','10',"morethan10"))){
             $temp_err['pastSmokeYear'][] =  'invalid value for pastSmokeYear.';
             $past_smoke_year = "";
        }

        if($is_currentlydrinking !== "" && !in_array($is_currentlydrinking, array(0,1))){
             $temp_err['isCurrentlyDrinking'][] =  'invalid value for isCurrentlyDrinking.';
             $is_currentlydrinking = "";
        }

        if(!empty($current_drink_pack) && !in_array($current_drink_pack, array('1','2','3','4','5','6','7','8','9','10','11','12','13','14',"morethan14"))){
             $temp_err['currentDrinkPack'][] =  'invalid value for currentDrinkPack.';
             $current_drink_pack = "";
        }

        if($is_pastdrinking !== "" && !in_array($is_pastdrinking, array(0,1))){
             $temp_err['isPastDrinking'][] =  'invalid value for isPastDrinking.';
             $is_pastdrinking = "";
        }

        if(!empty($past_drink_pack) && !in_array($past_drink_pack, array('1','2','3','4','5','6','7','8','9','10','11','12','13','14',"morethan14"))){
             $temp_err['pastDrinkPack'][] =  'invalid value for pastDrinkPack.';
             $past_drink_pack = "";
        }

        if(!empty($past_drink_year) && !in_array($past_drink_year, array('1','2','3','4','5','6','7','8','9','10',"morethan10"))){
             $temp_err['pastDrinkYear'][] =  'invalid value for pastDrinkYear.';
             $past_drink_year = "";
        }

        if($is_otherdrug !== "" && !in_array($is_otherdrug, array(0,1))){
             $temp_err['isOtherDrug'][] =  'invalid value for isOtherDrug.';
             $is_otherdrug = "";
        }

        if($is_otherdrugpast !== "" && !in_array($is_otherdrugpast, array(0,1))){
            $temp_err['isPastOtherDrug'][] =  'invalid value for isPastOtherDrug.';
            $is_otherdrugpast = "";
        }

        $temp_other_drug_history = array();
        $i = 0 ;

        if($is_otherdrug == 1 && !empty($other_drug_history))
        {
            foreach ($other_drug_history as $key => $value) {
                if(!isset($value['name']) || (isset($value['name']) && empty($value['name']))) continue;

                if(isset($value['year']) && !empty($value['year']) && !in_array($value['year'], ['1','2','3','4','5','6','7','8','9','10','morethan10']) ){
                  $temp_err['otherDrugHistory'][$key][] = 'invalid Year';
                  continue;
                }

                $temp_other_drug_history[$i]['name'] = $value['name'];
                $temp_other_drug_history[$i]['year'] = isset($value['year']) ? $value['year'] : "";
                $i++ ;

            }        
        }

        $temp_other_drug_history_past = array();
        $i = 0 ;

        if($is_otherdrugpast == 1 && !empty($other_drug_history_past))
        {
            foreach ($other_drug_history_past as $key => $value) {
                if(!isset($value['name']) || (isset($value['name']) && empty($value['name']))) continue;

                if(isset($value['year']) && !empty($value['year']) && !in_array($value['year'], ['','1','2','3','4','5','6','7','8','9','10','morethan10']) ){
                  $temp_err['pastOtherDrugHistory'][$key][] = 'invalid Year';
                  continue;
                }

                $temp_other_drug_history_past[$i]['name'] = $value['name'];
                $temp_other_drug_history_past[$i]['year'] = isset($value['year']) ? $value['year'] : "";
                $i++ ;

            }        
        }

        $error["socialHistoryDetails"] = $temp_err;
        // if(empty($error["socialHistoryDetails"]))
        // {
            $current_smoke_pack = $is_currentlysmoking == 1 ? $current_smoke_pack : "";
            $current_drink_pack = $is_currentlydrinking == 1 ? $current_drink_pack : "";

            $temp_other_drug_history = $is_otherdrug == 1 ? $temp_other_drug_history : "";
            $temp_other_drug_history_past = $is_otherdrugpast == 1 ? $temp_other_drug_history_past : "";

            if($is_pastsmoking != 1){

                $past_smoke_pack = "";
                $past_smoke_year = "";
            }

            if($is_pastdrinking != 1){

                $past_drink_pack = "";
                $past_drink_year = "";
            }

            $data_arr['current_smoke_pack'] = !empty($current_smoke_pack) ? base64_encode(Security::encrypt($current_smoke_pack, SEC_KEY)) : "";

            $data_arr['past_smoke_pack'] = !empty($past_smoke_pack) ? base64_encode(Security::encrypt($past_smoke_pack, SEC_KEY)) : "";

            $data_arr['past_smoke_year'] = !empty($past_smoke_year) ? base64_encode(Security::encrypt($past_smoke_year, SEC_KEY)) : "";

            $current_drink_pack = $current_drink_pack == "morethan14" ? "morethan10" : $current_drink_pack;

            $data_arr['current_drink_pack'] = !empty($current_drink_pack) ? base64_encode(Security::encrypt($current_drink_pack, SEC_KEY)) : "";

            $past_drink_pack = $past_drink_pack == "morethan14" ? "morethan10" : $past_drink_pack;

            $data_arr['past_drink_pack'] = !empty($past_drink_pack) ? base64_encode(Security::encrypt($past_drink_pack, SEC_KEY)) : "";
            $data_arr['past_drink_year'] = !empty($past_drink_year) ? base64_encode(Security::encrypt($past_drink_year, SEC_KEY)) : "";
        

            $data_arr['is_currentlysmoking'] = $is_currentlysmoking;
            if(!empty($data_arr['is_currentlysmoking'])){

                $data_arr['is_currentlysmoking'] = base64_encode(Security::encrypt($data_arr['is_currentlysmoking'], SEC_KEY));
            }

            $data_arr['is_pastsmoking'] = $is_pastsmoking;
            if(!empty($data_arr['is_pastsmoking'])){

                $data_arr['is_pastsmoking'] = base64_encode(Security::encrypt($data_arr['is_pastsmoking'], SEC_KEY));
            }
            $data_arr['is_currentlydrinking'] = $is_currentlydrinking;
            if(!empty($data_arr['is_currentlydrinking'])){

                $data_arr['is_currentlydrinking'] = base64_encode(Security::encrypt($data_arr['is_currentlydrinking'], SEC_KEY));
            }
            $data_arr['is_pastdrinking'] = $is_pastdrinking;
            if(!empty($data_arr['is_pastdrinking'])){

                $data_arr['is_pastdrinking'] = base64_encode(Security::encrypt($data_arr['is_pastdrinking'], SEC_KEY));
            }
            $data_arr['is_otherdrug'] = $is_otherdrug;
            if(!empty($data_arr['is_otherdrug'])){

                $data_arr['is_otherdrug'] = base64_encode(Security::encrypt($data_arr['is_otherdrug'], SEC_KEY));
            }
            $data_arr['is_otherdrugpast'] = $is_otherdrugpast;
            if(!empty($data_arr['is_otherdrugpast'])){

                $data_arr['is_otherdrugpast'] = base64_encode(Security::encrypt($data_arr['is_otherdrugpast'], SEC_KEY));
            }

            $data_arr['other_drug_history_past'] = !empty($temp_other_drug_history_past) ? base64_encode(Security::encrypt(serialize($temp_other_drug_history_past), SEC_KEY)):"";

            $data_arr['other_drug_history'] = !empty($temp_other_drug_history) ? base64_encode(Security::encrypt((serialize($temp_other_drug_history)), SEC_KEY)) : "";
            
            if($user_gender == 0){

                $data_arr['current_tab'] = 7;
            }
            else{

                $data_arr['current_tab'] = 8;
            }
            //$check_emh_field_view['checksocial'] = 1;
            $saved_tabs[] = "socialHistoryDetails";
        //}  
      }

    if(!empty($obGynHistoryDetails))
    {
        $temp_err = array();
        if($user_gender != 0){

            $temp_err[] = "obGynHistoryDetails is used for female.";
        }
        /*if(isset($check_emh_field_view['checksocial']) && $check_emh_field_view['checksocial'] != 1){

          $temp_err['checksocial'][] =  'Please fill the social history details before fill the ob/gyn history details.';  
        }*/


        //get the all variables form request
        
        $is_previous_birth = $this->request->data('obGynHistoryDetails.isPreviousBirth');
        $no_of_pregnency = $this->request->data('obGynHistoryDetails.numberOfPregnancy');
        $no_of_miscarriage = $this->request->data('obGynHistoryDetails.numberOfMiscarriage');
        $no_of_live_birth = $this->request->data('obGynHistoryDetails.numberOfLiveBirth');
        $previousBirthDetails = $this->request->data('obGynHistoryDetails.previousBirthDetails');
        $age_of_first_priod = $this->request->data('obGynHistoryDetails.ageOfFirstPeriod');
        $is_mammogram = $this->request->data('obGynHistoryDetails.isMammogram');
        $mammogram_month = $this->request->data('obGynHistoryDetails.mammogramMonth');
        $mammogram_year = $this->request->data('obGynHistoryDetails.mammogramYear');
        $previous_abnormal_breast_lump = $this->request->data('obGynHistoryDetails.previousAbnormalBreastLump');
        $any_biopsy = $this->request->data('obGynHistoryDetails.isBiopsy');
        $breastLumpBiopsyResultDetails = $this->request->data('obGynHistoryDetails.breastLumpBiopsyResultDetails');
        $papsmear_month = $this->request->data('obGynHistoryDetails.papsmearMonth');
        $papsmear_year = $this->request->data('obGynHistoryDetails.papsmearYear');
        $is_regular_papsmear = $this->request->data('obGynHistoryDetails.isRegularPapsmear');
        $papsmear_finding = $this->request->data('obGynHistoryDetails.papsmearFinding');
        $is_sti_std = $this->request->data('obGynHistoryDetails.isStiStd');
        $stiStdDetail = $this->request->data('obGynHistoryDetails.stiStdDetail');

        

        if(!empty($age_of_first_priod) && !is_numeric($age_of_first_priod)) {

            $temp_err['ageOfFirstPeriod'][] =  'invalid value for ageOfFirstPeriod.';
            $age_of_first_priod = "";
        }      

        if(!in_array($is_previous_birth, array(0,1))){
            $temp_err['isPreviousBirth'][] =  'invalid value for isPreviousBirth';
            $is_previous_birth = "";
        }

        if(!in_array($is_mammogram, array(0,1))){
            $temp_err['isMammogram'][] =  'invalid value for isMammogram';
            $is_mammogram = "";
        }

        if(!in_array($mammogram_month, $month_whitelist_arr)){

            $temp_err['mammogramMonth'][] = "invalid value for mammogramMonth. ";
            $mammogram_month = "";
        }

        if(!in_array($mammogram_year, $year_whitelist_arr)){

            $temp_err['mammogramYear'][] = "invalid value for mammogramYear. ";
            $mammogram_year = "";
        }

        if(!in_array($no_of_pregnency, array("",0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15))){
            $temp_err['numberOfPregnancy'][] =  'invalid value for numberOfPregnancy';
            $no_of_pregnency = "";
        }

        if(!in_array($no_of_miscarriage, array("",0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15))){
            $temp_err['numberOfMiscarriage'][] =  'invalid value for numberOfMiscarriage';
            $no_of_miscarriage = "";
        }

        if(!in_array($no_of_live_birth, array("",0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15))){
            $temp_err['numberOfLiveBirth'][] =  'invalid value for numberOfLiveBirth';
            $no_of_live_birth = "";
        }

        if(!empty($previousBirthDetails) && !is_array($previousBirthDetails)){

            $temp_err['previousBirthDetails'][] =  'previousBirthDetails must be an array.';
            //$previousBirthDetails = [];
        }

        if(!in_array($any_biopsy, array(0,1))){
            $temp_err['isBiopsy'][] =  'invalid value for isBiopsy';
            $any_biopsy = "";
        }

        if(!empty($breastLumpBiopsyResultDetails) && !is_array($breastLumpBiopsyResultDetails)){

            $temp_err['breastLumpBiopsyResultDetails'][] =  'breastLumpBiopsyResultDetails must be an array.';
        }

        if(!in_array($previous_abnormal_breast_lump, array(0,1))){
            $temp_err['previousAbnormalBreastLump'][] =  'invalid value for previousAbnormalBreastLump';
            $previous_abnormal_breast_lump = "";
        }

        if(!in_array($papsmear_month, $month_whitelist_arr)){

            $temp_err['papsmearMonth'][] = "invalid value for papsmearMonth. ";
            $papsmear_month = "";
        }

        if(!in_array($papsmear_year, $year_whitelist_arr)){

            $temp_err['papsmearYear'][] = "invalid value for papsmearYear. ";
            $papsmear_year = "";
        }

        if(!in_array($is_regular_papsmear, array(0,1))){
            $temp_err['isRegularPapsmear'][] =  'invalid value for isRegularPapsmear';
            $is_regular_papsmear = "";
        }

        
        $temp_previousBirthDetails = array();
        $i = 0;
        

        if(!empty($previousBirthDetails) && is_array($previousBirthDetails))
        {
            $previousBirthDetails = array_filter($previousBirthDetails);
            foreach ($previousBirthDetails as $key => $value) {
                
                /*if(
                    !isset($value['previousBirthSex']) || (isset($value['previousBirthSex']) && empty($value['previousBirthSex'])) 
                    || !isset($value['previousBirthMonth']) || (isset($value['previousBirthMonth']) && empty($value['previousBirthMonth']))
                    || !isset($value['previousBirthYear']) || (isset($value['previousBirthYear']) && empty($value['previousBirthYear']))
                    || !isset($value['previousDeliveryMethod']) || (isset($value['previousDeliveryMethod']) && empty($value['previousDeliveryMethod']))
                    || !isset($value['previousPregnancyDuration']) || (isset($value['previousPregnancyDuration']) && empty($value['previousPregnancyDuration'])) 
                    || !isset($value['previousComplication']) || (isset($value['previousComplication']) && empty($value['previousComplication'])) 
                    || !isset($value['previousHospital']) || (isset($value['previousHospital']) && empty($value['previousHospital']))
                ){

                    $temp_err['previousBirthDetails'][$key][] = "previousBirthSex, previousBirthMonth, previousBirthYear, previousDeliveryMethod, previousPregnancyDuration, previousComplication, previousHospital are required.";
                    continue;
                }*/
                if(!in_array($value['previousBirthSex'], array('',0,1))){

                    $temp_err['previousBirthDetails']['detail'][$key][] = "invalid value for previousBirthSex. ";
                }

                if(!in_array($value['previousBirthMonth'], $month_whitelist_arr)){

                    $temp_err['previousBirthDetails']['detail'][$key][] = "invalid value for previousBirthMonth. ";
                }

                if(!in_array($value['previousBirthYear'], $year_whitelist_arr)){

                    $temp_err['previousBirthDetails']['detail'][$key][] = "invalid value for previousBirthYear. ";
                }

                if(!in_array($value['previousDeliveryMethod'], array('',0,1))){

                    $temp_err['previousBirthDetails']['detail'][$key][] = "invalid value for previousDeliveryMethod. ";
                }

                if(!empty($value['previousPregnancyDuration']) && ($value['previousPregnancyDuration'] < 20 && $value['previousPregnancyDuration'] > 50)){

                    $temp_err['previousBirthDetails']['detail'][$key][] = "previousPregnancyDuration value must be between 20 weeks to 50 weeks.";
                }

                if(empty($temp_err['previousBirthDetails']['detail'][$key])){

                    $temp_previousBirthDetails['previous_birth_sex'][$i] = isset($value['previousBirthSex']) ? $value['previousBirthSex'] : "";
                    $temp_previousBirthDetails['previous_birth_month'][$i] = isset($value['previousBirthMonth']) ? $value['previousBirthMonth'] : "";
                    $temp_previousBirthDetails['previous_birth_year'][$i] = isset($value['previousBirthYear']) ? $value['previousBirthYear'] : "";

                    $temp_previousBirthDetails['previous_delivery_method'][$i] = isset($value['previousDeliveryMethod']) ? $value['previousDeliveryMethod'] : "";

                    $temp_previousBirthDetails['previos_pregnancy_duration'][$i] = isset($value['previousPregnancyDuration']) ? $value['previousPregnancyDuration'] : "";

                    $temp_previousBirthDetails['previous_complication'][$i] = isset($value['previousComplication']) ? $value['previousComplication'] : "";

                    $temp_previousBirthDetails['previous_hospital'][$i] = isset($value['previousHospital']) ? $value['previousHospital'] : "";

                    $i++;

                }
            }            
        }

        
        $temp_breastLumpBiopsyResultDetails = array();
        $i = 0;

        if(!empty($breastLumpBiopsyResultDetails) && is_array($breastLumpBiopsyResultDetails))
        {
            $breastLumpBiopsyResultDetails = array_filter($breastLumpBiopsyResultDetails);
            foreach ($breastLumpBiopsyResultDetails as $key => $value) {

                if(!in_array($value['biopsyMonth'], $month_whitelist_arr)){

                    $temp_err['breastLumpBiopsyResultDetails']['detail'][$key][] = "invalid value for biopsyMonth. ";
                }

                if(!in_array($value['biopsyYear'], $year_whitelist_arr)){

                    $temp_err['breastLumpBiopsyResultDetails']['detail'][$key][] = "invalid value for biopsyYear. ";
                }

                if(empty($temp_err['breastLumpBiopsyResultDetails']['detail'][$key])){

                    $temp_breastLumpBiopsyResultDetails['biopsy_month'][$i] = isset($value['biopsyMonth']) ? $value['biopsyMonth'] : "";

                    $temp_breastLumpBiopsyResultDetails['biopsy_year'][$i] = isset($value['biopsyYear']) ? $value['biopsyYear'] : "";

                    $temp_breastLumpBiopsyResultDetails['biopsy_result'][$i] = isset($value['biopsyResult']) ? $value['biopsyResult'] : "";

                    $i++;

                }
            }            
        }

        $stiStdDetail = isset($obGynHistoryDetails['stiStdDetail']) ? $obGynHistoryDetails['stiStdDetail'] : "";
        
        $temp_stiStdDetail = array();
        $i = 0;

        $sti_other = "";
        
        if(!empty($stiStdDetail) && is_array($stiStdDetail))
        {
            $stiStdDetail = array_filter($stiStdDetail);
            if(isset($stiStdDetail['other'])){

              $sti_other = $stiStdDetail['other'];
              unset($stiStdDetail['other']); 
            }

            $sti_keys = array_column($stiStdDetail, "stiStdKey");
            foreach ($stiStdDetail as $key => $value) {

                if(!isset($value['stiStdKey']) || (isset($value['stiStdKey']) && $value['stiStdKey'] == "")){

                    continue;
                }

                if(!in_array($value['stiStdKey'], array('',0,1,2,3,4,5,6,7))){

                    $temp_err['stiStdDetail']['detail'][$key][] = "invalid value for stiStdKey. ";
                }

                if(isset($value['year']) && !in_array($value['year'], $year_whitelist_arr)){

                    $temp_err['stiStdDetail']['detail'][$key][] = "invalid value for year. ";
                }

                if(empty($temp_err['stiStdDetail']['detail'][$key])){

                    $temp_stiStdDetail[$value['stiStdKey']] = isset($value['year']) ? $value['year'] : "";
                    $sti_other = isset($value['other']) && $value['stiStdKey'] == 7 ? $value['other'] : "";        

                }

                if(!empty($sti_other)){

                    $temp_stiStdDetail['other'] = $sti_other;
                }
                else{

                    if(isset($temp_stiStdDetail[7])){

                        unset($temp_stiStdDetail[7]);
                    } 
                }

                
            }

            //pr($temp_stiStdDetail);die;

            //set the key from 0 to 7
            /*$temp_sti_detail = []; 

            for($i = 0 ; $i < 8 ; $i++){

                if(isset($temp_stiStdDetail[$i])){

                   $temp_sti_detail[$i] = $temp_stiStdDetail[$i];  
                }
                else{

                    $temp_sti_detail[$i]['year'] = "";
                }
            }

            $temp_stiStdDetail = $temp_sti_detail;  */        
        }

        //pr($temp_stiStdDetail);die;

        $error["obGynHistoryDetails"] = $temp_err;
        // if(empty($error["obGynHistoryDetails"]))
        // {
            $womenspecific = [];
            $womenspecific['user_id'] = $user_data['id'];
            $womenspecific['is_previous_birth'] = $is_previous_birth;
            //pr($temp_previousBirthDetails);die;

            if(empty($is_previous_birth)){

                
                $womenspecific['no_of_live_birth'] = '' ;
                $womenspecific['no_of_pregnency'] = '' ;
                $womenspecific['no_of_miscarriage'] = '' ;
                $womenspecific['prev_birth_detail'] = '';
                

               /* $womenspecific['previous_delivery_method'] = '' ;
                $womenspecific['previos_pregnancy_duration'] = '' ;
                $womenspecific['previous_complication'] = '' ;
                $womenspecific['previous_hospital'] = '' ;*/
                
            }
            else{

                $womenspecific['no_of_live_birth'] = $no_of_live_birth;
                $womenspecific['no_of_pregnency'] = $no_of_pregnency ;
                $womenspecific['no_of_miscarriage'] = $no_of_miscarriage ;
                $womenspecific['prev_birth_detail'] = $temp_previousBirthDetails;
            }

            if(!empty($womenspecific['prev_birth_detail'])){

               $womenspecific['prev_birth_detail'] = base64_encode(Security::encrypt((serialize($womenspecific['prev_birth_detail'])), SEC_KEY)); 
            }

            $womenspecific['is_mammogram'] = $is_mammogram;

            if(empty($is_mammogram)){

                
                $womenspecific['mammogram_month'] = '' ;
                $womenspecific['mammogram_year'] = '' ;
                
            }
            else{

                $womenspecific['mammogram_month'] = $mammogram_month ;
                $womenspecific['mammogram_year'] = $mammogram_year;
            }

            
            $womenspecific['previous_abnormal_breast_lump'] = $previous_abnormal_breast_lump;
            $womenspecific['any_biopsy'] = $any_biopsy;
            $womenspecific['breast_lump_biopsy_result'] = empty($any_biopsy) ? "" : $temp_breastLumpBiopsyResultDetails;

            if(empty($womenspecific['previous_abnormal_breast_lump'])){

                $womenspecific['any_biopsy'] = "";
                $womenspecific['breast_lump_biopsy_result'] = "";
            }

            if(empty($womenspecific['any_biopsy'])){

                $womenspecific['breast_lump_biopsy_result'] = "";
            }

            if(!empty($womenspecific['breast_lump_biopsy_result'])){

               $womenspecific['breast_lump_biopsy_result']= base64_encode(Security::encrypt((serialize($womenspecific['breast_lump_biopsy_result'])), SEC_KEY)); 
            }

                      

            $womenspecific['age_of_first_priod'] = $age_of_first_priod;
            $womenspecific['papsmear_month'] = $papsmear_month;
            $womenspecific['papsmear_year'] = $papsmear_year;
            $womenspecific['is_regular_papsmear'] = $is_regular_papsmear;
            $womenspecific['papsmear_finding'] = $papsmear_finding;

            if($womenspecific['is_regular_papsmear'] == 1){

                $womenspecific['papsmear_finding'] = "";
            }

            $womenspecific['is_sti_std'] = $is_sti_std;
            $womenspecific['sti_std_detail'] = $temp_stiStdDetail;

            if(empty($womenspecific['is_sti_std'])){

                $womenspecific['sti_std_detail'] = "";
            }

            if(!empty($womenspecific['sti_std_detail'])){

               $womenspecific['sti_std_detail'] = base64_encode(Security::encrypt((serialize($womenspecific['sti_std_detail'])), SEC_KEY)); 
            }  
            //pr($womenspecific);die;

            $womanrec = $this->WomenSpecific->find()->where(['user_id' => $user_data['id']])->first();
            if(empty($womanrec)){
              $womanrec = $this->WomenSpecific->newEntity();
            }
            else
            {
              $womanrec = $this->WomenSpecific->get($womanrec->id);
            }

            $this->WomenSpecific->patchEntity($womanrec, $womenspecific);

            //encrypt the woman data

            if(!empty($womanrec->age_of_first_priod)){

              $womanrec->age_of_first_priod = base64_encode(Security::encrypt($womanrec->age_of_first_priod, SEC_KEY));
            }

            if(!empty($womanrec->no_of_pregnency))
              $womanrec->no_of_pregnency = base64_encode(Security::encrypt($womanrec->no_of_pregnency, SEC_KEY));

            if(!empty($womanrec->no_of_miscarriage))
              $womanrec->no_of_miscarriage = base64_encode(Security::encrypt($womanrec->no_of_miscarriage, SEC_KEY));
            if(!empty($womanrec->is_regular_papsmear))
              $womanrec->is_regular_papsmear = base64_encode(Security::encrypt($womanrec->is_regular_papsmear, SEC_KEY));

            if(!empty($womanrec->papsmear_month))
              $womanrec->papsmear_month = base64_encode(Security::encrypt($womanrec->papsmear_month, SEC_KEY));
            if(!empty($womanrec->papsmear_year))
              $womanrec->papsmear_year = base64_encode(Security::encrypt($womanrec->papsmear_year, SEC_KEY));
            if(!empty($womanrec->papsmear_finding))
              $womanrec->papsmear_finding = base64_encode(Security::encrypt($womanrec->papsmear_finding, SEC_KEY));
            if(!empty($womanrec->is_curently_pregnant))
              $womanrec->is_curently_pregnant = base64_encode(Security::encrypt($womanrec->is_curently_pregnant, SEC_KEY));
            if(!empty($womanrec->current_baby_sex))
              $womanrec->current_baby_sex = base64_encode(Security::encrypt($womanrec->current_baby_sex, SEC_KEY));
            if(!empty($womanrec->currently_pregnant_week))
              $womanrec->currently_pregnant_week = base64_encode(Security::encrypt($womanrec->currently_pregnant_week, SEC_KEY));
            if(!empty($womanrec->currently_pregnant_days))
              $womanrec->currently_pregnant_days = base64_encode(Security::encrypt($womanrec->currently_pregnant_days, SEC_KEY));
            if(!empty($womanrec->currently_pregnant_complication))
              $womanrec->currently_pregnant_complication = base64_encode(Security::encrypt($womanrec->currently_pregnant_complication, SEC_KEY));

            if(!empty($womanrec->is_previous_birth))
              $womanrec->is_previous_birth = base64_encode(Security::encrypt($womanrec->is_previous_birth, SEC_KEY));

            if(!empty($womanrec->previous_birth_sex))
              $womanrec->previous_birth_sex = base64_encode(Security::encrypt($womanrec->previous_birth_sex, SEC_KEY));
            if(!empty($womanrec->previous_delivery_method))
              $womanrec->previous_delivery_method = base64_encode(Security::encrypt($womanrec->previous_delivery_method, SEC_KEY));
            if(!empty($womanrec->previos_pregnancy_duration))
              $womanrec->previos_pregnancy_duration = base64_encode(Security::encrypt($womanrec->previos_pregnancy_duration, SEC_KEY));

            if(!empty($womanrec->previous_complication))
              $womanrec->previous_complication = base64_encode(Security::encrypt($womanrec->previous_complication, SEC_KEY));
            if(!empty($womanrec->previous_hospital))
              $womanrec->previous_hospital = base64_encode(Security::encrypt($womanrec->previous_hospital, SEC_KEY));

            if(!empty($womanrec->is_mammogram))
              $womanrec->is_mammogram = base64_encode(Security::encrypt($womanrec->is_mammogram, SEC_KEY));
            if(!empty($womanrec->mammogram_month))
              $womanrec->mammogram_month = base64_encode(Security::encrypt($womanrec->mammogram_month, SEC_KEY));
            if(!empty($womanrec->mammogram_year))
              $womanrec->mammogram_year = base64_encode(Security::encrypt($womanrec->mammogram_year, SEC_KEY));
            if(!empty($womanrec->previous_abnormal_breast_lump))
              $womanrec->previous_abnormal_breast_lump = base64_encode(Security::encrypt($womanrec->previous_abnormal_breast_lump, SEC_KEY));
            if(!empty($womanrec->any_biopsy))
              $womanrec->any_biopsy = base64_encode(Security::encrypt($womanrec->any_biopsy, SEC_KEY));
            if(!empty($womanrec->is_sti_std))
              $womanrec->is_sti_std = base64_encode(Security::encrypt($womanrec->is_sti_std, SEC_KEY));

            if($result = $this->WomenSpecific->save($womanrec)){
                $data_arr['current_tab'] = 8;
                $check_emh_field_view['checkobgyn'] = 1;
                $saved_tabs[] = "obGynHistoryDetails";
            }
            else{

              $error["obGynHistoryDetails"] = ['something went wrong, Please try again.'];  
            }
                      
       // }        
      }


    //Shot history
    if(!empty($shotsHistoryDetails))
    {

        $temp_err = array();

        /*if($user_gender == 0){

            if($check_emh_field_view['checkobgyn'] != 1){

              $temp_err['checkobgyn'][] =  'Please fill the ob/gyn history details before fill the shots history details.';  
            }
        }
        else{

            if($check_emh_field_view['checksocial'] != 1){

              $temp_err['checksocial'][] =  'Please fill the social history details before fill the shots history details.';  
            }
        }*/

        $shothistory = $shotsHistoryDetails['shotsHistory'];
        $tempar = array();
        $unique_shot = array();
        $i = 0 ;
        $other_shots_history = [];

        if(!empty($shothistory))
        {

            foreach ($shothistory as $key => $value) {

                //echo $key;
                if(!isset($value['name']) || (isset($value['name']) && empty($value['name'])))
                {
                                   
                  $temp_err['shotsHistory'][$key][] = "shot name is required.";
                    continue;
                }

                // whitelisting validation for shots history field start
                if(isset($value['year']) && !empty($value['year']) && !in_array($value['year'], $year_whitelist_arr))
                {
                    $value['year'] = "";
                } 


                $shot_cond_details = $commonTable->find('all')->where(['cond_type' => 4,'name' => strtolower($value['name'])])->first();

                if(!empty($shot_cond_details)){

                    $tempar[$shot_cond_details['id']] = isset($value['year']) ? $value['year']: "";
                }
                else{

                   $other_shots_history[] = array(
                        'name' => $value['name'],
                        'year' => isset($value['year']) ? $value['year'] : ""
                    );
                }
                /*if(empty($shot_cond_details)){

                    $temp_err['shotsHistory'][$key][] = "invalid shot name.";
                    continue;
                }
                // whitelisting validation for shots history field start
                if(isset($value['year']) && !empty($value['year']) && !in_array($value['year'], $year_whitelist_arr))
                {
                    $temp_err['shotsHistory'][$key][] = "invalid year.";
                    continue;
                }

                if(!in_array($shot_cond_details['id'], $unique_shot))
                {
                    // removing duplicate shot id
                    $tempar[$shot_cond_details['id']] = $value['year'];
                    $unique_shot[] = $shot_cond_details['id'];
                }*/
            }

            // pr($tempar);
            // pr($other_shots_history);die;

            $error['shotsHistoryDetails'] = $temp_err;
            /*if(empty($error['shotsHistoryDetails']))
            {*/
                $data_arr['shots_history'] = !empty($tempar) ? base64_encode(Security::encrypt((serialize($tempar)), SEC_KEY))  : "";

                $data_arr['other_shots_history'] = !empty($other_shots_history) ? base64_encode(Security::encrypt((serialize($other_shots_history)), SEC_KEY))  : "";

                $data_arr['current_tab'] = 8;
                //$data_arr['max_visited_tab'] = 8;
                $check_emh_field_view['checkshots'] = 1;
                $saved_tabs[] = "shotsHistoryDetails";
            //}
        }
    }


      //

      $this->Users->patchEntity($user_data, $data_arr);
      //check the tabs completely filled or not, if filled then mark as completed
      if($user_data->height && $user_data->weight && $user_data->guarantor && $user_data->pharmacy && $user_data->address && $user_data->city && $user_data->state && $user_data->zip && $user_data->race !== "" && !is_null($user_data->race) && $user_data->bmi && $user_data->is_retired !== "" && !is_null($user_data->is_retired) && $user_data->occupation && $user_data->marital_status !== "" && !is_null($user_data->marital_status) && $user_data->sexual_orientation !== "" && !is_null($user_data->sexual_orientation) && $user_data->ethinicity !== "" && !is_null($user_data->ethinicity)){

        $check_emh_field_view['checkbasic'] = 1;
      }

        if($user_data->is_check_med_his !== "" && !is_null($user_data->is_check_med_his)){

            $check_emh_field_view['checkmedical'] = 1;
        }
        else{

            $check_emh_field_view['checkmedical'] = 0;
        }

        if($user_data->is_check_surg_his !== "" && !is_null($user_data->is_check_surg_his)){

            $check_emh_field_view['checksurgical'] = 1;
        }
        else{

            $check_emh_field_view['checksurgical'] = 0;
        }


        if($user_data->is_family_his !== "" && !is_null($user_data->is_family_his)){

            $check_emh_field_view['checkfamily'] = 1;
        }
        else{

            $check_emh_field_view['checkfamily'] = 0;
        }

        if($user_data->is_check_allergy_his !== "" && !is_null($user_data->is_check_allergy_his)){

            $check_emh_field_view['checkallergy'] = 1;
        }
        else{

            $check_emh_field_view['checkallergy'] = 0;
        }

        if(
            $user_data->is_currentlysmoking !== "" && !is_null($user_data->is_currentlysmoking) 
            && $user_data->is_pastsmoking !== "" && !is_null($user_data->is_pastsmoking)
            && $user_data->is_currentlydrinking !== "" && !is_null($user_data->is_currentlydrinking)
            && $user_data->is_pastdrinking !== "" && !is_null($user_data->is_pastdrinking)
            && $user_data->is_otherdrug !== "" && !is_null($user_data->is_otherdrug)
            && $user_data->is_otherdrugpast !== "" && !is_null($user_data->is_otherdrugpast)
        ){

            $check_emh_field_view['checksocial'] = 1;
        }
        else{

            $check_emh_field_view['checksocial'] = 0;
        }
        
      $user_data['check_emh_field_view'] = serialize($check_emh_field_view);
      $this->Users->save($user_data);

      $header = array(
            'statusCode' => 200,
            'message' => 'User medical information saved'
        );
        $payload = array(
            'savedDetails' => $saved_tabs,
            'errors' => $error,
        );
        $response = ['header' => $header,'payload' => $payload];
        return $this->response->withType("application/json")->withStringBody(json_encode($response));
    }
    catch(\Exception $e)
    {

        $header = array(
                'statusCode' => 500,
                'message' => 'Internal error, Please try again.'
            );

        $response = ['header' => $header];
        return $this->response->withType("application/json")->withStringBody(json_encode($response));
    }

}


    public function save_appointment_schedule_data($detail){

        $isMatched = 0;

      if(!empty($detail) && is_array($detail)){

        $this->Schedule = TableRegistry::get('Schedule');

        $enc_last_name = isset($detail['last_name']) && !empty($detail['last_name']) ? $detail['last_name'] : '';

        $enc_first_name = isset($detail['first_name']) && !empty($detail['first_name']) ? $detail['first_name'] : '';

        $enc_dob = isset($detail['dob']) && !empty($detail['dob']) ? $detail['dob'] : '';

        $enc_mrn = isset($detail['mrn']) && !empty($detail['mrn']) ? $detail['mrn'] : '';

        $enc_phone = isset($detail['phone']) && !empty($detail['phone']) ? $detail['phone'] : '';

        $enc_email = isset($detail['email']) && !empty($detail['email']) ? strtolower($detail['email']) : '';

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
            $checkAlreadyScheduleData  = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['email' =>$enc_email,'appointment_date >=' => date('Y-m-d'),'organization_id' =>$organization_id])->toArray();          
        }
        elseif(isset($enc_phone) && !empty($enc_phone)){

                $checkAlreadyScheduleData = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['phone' =>$enc_phone,'appointment_date >=' => date('Y-m-d'),'organization_id' =>$organization_id])->toArray();
                   
        }
        elseif(isset($enc_first_name) && isset($enc_last_name) && isset($enc_dob)){

            $checkAlreadyScheduleData = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['first_name' =>$enc_first_name,'last_name' => $enc_last_name,'dob' => $enc_dob,'appointment_date >=' => date('Y-m-d'),'organization_id' =>$organization_id])->toArray();                     
        } 

        $app_date = isset($detail['appointment_date']) && !empty($detail['appointment_date']) ?  strtotime($detail['appointment_date']) : date('Y-m-d');   

        if(!empty($checkAlreadyScheduleData)){

            foreach ($checkAlreadyScheduleData as $key => $value) {

                $date = !empty($value['appointment_date']) ? strtotime($value['appointment_date']) : "";
                
                if($value['status'] == 3){
                    continue;
                }

                if(!empty($enc_doctor_name) && $enc_doctor_name == $value['doctor_name'] && !empty($enc_appointment_time) && $enc_appointment_time == $value['appointment_time'] && !empty($app_date) && $date == $app_date){

                    $isMatched = 1;
                }
            }
        }        
      }

      return $isMatched;
    }




    public function save_appointment_schedule_data_mrn($detail){

      $isMatched = 0;

      if(!empty($detail) && is_array($detail)){

        $this->Schedule = TableRegistry::get('Schedule');       

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

        if(isset($enc_mrn) && !empty($enc_mrn))
        {
            $checkAlreadyScheduleData  = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['mrn' =>$enc_mrn,'appointment_date >=' => date('Y-m-d'),'organization_id' =>$organization_id])->toArray();          
        }
       

        $app_date = isset($detail['appointment_date']) && !empty($detail['appointment_date']) ?  strtotime($detail['appointment_date']) : date('Y-m-d');   

        if(!empty($checkAlreadyScheduleData)){

            foreach ($checkAlreadyScheduleData as $key => $value) {

                $date = !empty($value['appointment_date']) ? strtotime($value['appointment_date']) : "";
                
                if($value['status'] == 3){
                    continue;
                }

                if(!empty($enc_doctor_name) && $enc_doctor_name == $value['doctor_name'] && !empty($enc_appointment_time) && $enc_appointment_time == $value['appointment_time'] && !empty($app_date) && $date == $app_date){

                    $isMatched = 1;
                }
            }
        }        
      }

      return $isMatched;
    }
}
