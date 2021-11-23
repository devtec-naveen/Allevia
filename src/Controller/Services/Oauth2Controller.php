<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
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

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class Oauth2Controller extends AppController
{

	public function initialize()
    {

      parent::initialize();
      $this->loadComponent('RequestHandler');      
      $this->loadComponent('CryptoSecurity');
      $this->loadComponent('General');
      $this->loadModel('UserInfo');
      $this->autoRender = false;
      
    }
   
     public function beforeFilter(Event $event)
    {
    	$this->Auth->allow(['token','management']);       	
        parent::beforeFilter($event);
        $this->getEventManager()->off($this->Csrf);               
    }

    private function tokenVerify($access_token, $organization_id = null,$provider_id = null)
    {
        if(empty($access_token)){

            $header = array(
                'statusCode' => 400,
                'message' => 'Access token is empty.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }
        $encryptToken = base64_encode($this->CryptoSecurity->encrypt($access_token,SEC_KEY));
        $token_detail = $this->UserInfo->find('all')->where(['access_token' =>$encryptToken])->first();
       // echo $token_detail['timestamp'];
       //pr($token_detail);
        if(empty($token_detail)){

            $header = array(
                'statusCode' => 402,
                'message' => 'Invalid access token.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        //token valid for 7200 seconds so we add 7200 in time stamp
        $tokenValidTime =  strtotime($token_detail['timestamp'])+7200;
        $currenttime = time();
        if($tokenValidTime < $currenttime){

            $header = array(
                'statusCode' => 402,
                'message' => 'Access token has been expired.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        //now we check the saved organization id with decrypt the token & fetch organization id

        $dec_access_token = $this->CryptoSecurity->tokenDecrypt($access_token);
        $t_org_id = substr($dec_access_token, 0, strpos($dec_access_token, 'O'));
        $temp_rem_str = substr($dec_access_token, strpos($dec_access_token, 'O')+1);
        $t_provider_id = substr($temp_rem_str, 0, strpos($temp_rem_str, 'P'));

        if($t_provider_id != $token_detail['provider_id'] || $t_org_id != $token_detail['organization_id']){

            $header = array(
                'statusCode' => 402,
                'message' => 'Invalid access token.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        //first we check the input organization id with database organization id

        if(!empty($organization_id) && $organization_id != $token_detail['organization_id']){

           $header = array(
                'statusCode' => 402,
                'message' => 'Invalid organization id.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die; 
        }

        //first we check the input provider id with database provider id

        if(!empty($provider_id) && $provider_id != $token_detail['provider_id']){

            $header = array(
                'statusCode' => 402,
                'message' => 'Invalid provider id.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die; 
        }

        return array('organization_id' => $token_detail['organization_id'], 'provider_id' => $token_detail['provider_id']);
        //die;
    }


    public function token()
    { 

        $this->autoRender = false;
        $response = array();
        if(empty($this->request->getData())){

        	$header = array(
        		'statusCode' => 400,
        		'message' => 'Blank Parameter Error'
        	);

        	$response = ['header' => $header];
            echo json_encode($response);die;
        }

        $clientId = $this->request->data('client_id');
        $clientSecret = $this->request->data('client_secret');
	    $providerSecret =  $this->request->data('provider_secret');

	    if(empty($clientId)){

        	$header = array(
        		'statusCode' => 400,
        		'message' => 'Client id is empty.'
        	);

        	$response = ['header' => $header];
            echo json_encode($response);die;
        }

        if(empty($clientSecret)){

        	$header = array(
        		'statusCode' => 400,
        		'message' => 'Client secret is empty.'
        	);

        	$response = ['header' => $header];
            echo json_encode($response);die;
        }

        if(empty($providerSecret)){

        	$header = array(
        		'statusCode' => 400,
        		'message' => 'Provider secret is empty.'
        	);

        	$response = ['header' => $header];
            echo json_encode($response);die;
        }       

    	$users= TableRegistry::get('Users');
    	$userApiInfoObj = $this->loadModel('UserInfo');
	 	$clientId =  base64_encode($this->CryptoSecurity->encrypt($this->request->data('client_id'),SEC_KEY));
    	$clientSecret =  base64_encode($this->CryptoSecurity->encrypt($this->request->data('client_secret'),SEC_KEY));
    	$providerSecret =  base64_encode($this->CryptoSecurity->encrypt($this->request->data('provider_secret'),SEC_KEY));
	    $checkOrganizationData = $this->Organizations->find('all')->where(['client_id' =>$clientId,'client_secret' =>$clientSecret])->first();   //check client id and client secret match to organization

        if(empty($checkOrganizationData))
        {

        	$header = array(
        		'statusCode' => 402,
        		'message' => 'Invalid client id or client secret.'
        	);

        	$response = ['header' => $header];
            echo json_encode($response);die;
        	
        }	

	    $getApiData = $users->find('all')->where(['provider_secret' =>$providerSecret])->first();

	    if(empty($getApiData))
        {

        	$header = array(
        		'statusCode' => 402,
        		'message' => 'Invalid provider secret.'
        	);

        	$response = ['header' => $header];
            echo json_encode($response);die;
        	
        }

        if($checkOrganizationData['id'] != $getApiData['organization_id'])
        {

        	$header = array(
        		'statusCode' => 402,
        		'message' => 'Provider secret not belong to this organzation.'
        	);

        	$response = ['header' => $header];
            echo json_encode($response);die;
        	
        }
	    	
		$accessToken = $checkOrganizationData['id'].'O'.$getApiData['id'].'P'.time();
		$accessToken = $this->CryptoSecurity->tokenEncrypt($accessToken);  //access token encrypt with cake security component
        //echo $accessToken;die;
		$encryptedToken =  base64_encode($this->CryptoSecurity->encrypt($accessToken,SEC_KEY));
		$checkExistRecord = $userApiInfoObj->find('all')->where(['organization_id' =>$checkOrganizationData['id'],'provider_id'=>$getApiData['id']])->first();  //check already exist token with organization and with provider

         if(!empty($checkExistRecord))
         {
         		$userApiInfoObj->updateAll(['access_token' =>$encryptedToken,'timestamp' => date('Y-m-d H:i:s')],['id' =>$checkExistRecord['id']]);
         } 	
         else
         {
         	     $data = array();
		         $data['organization_id'] = $checkOrganizationData['id'];
		         $data['provider_id'] = $getApiData['id'];
		         $data['access_token'] = $encryptedToken;
                 $data['timestamp'] = date('Y-m-d H:i:s');
		         $userAPiInfoEntity = $userApiInfoObj->newEntity();
		         $patchuserApiInfo = $userApiInfoObj->patchEntity($userAPiInfoEntity,$data);  			         
		         $userApiInfoObj->save($patchuserApiInfo);
         }

        $header = array(
    		'statusCode' => 200,
    		'message' => 'Access token Generated Successfully.'
        );

        $payload = array(
    		'access_token' => $accessToken,
    		//'organization_id' => $checkOrganizationData['id'],
    		//'provider_id' => $getApiData['id'],
    		'expiry_in' => '7200'
        );

       	$response = ['header' => $header,'payload' => $payload];
        echo json_encode($response);die;	         
        
    }

    public function management()
    {   
        //pr($this->request->getData());die;
        $this->loadModel('Users');
        $this->loadModel('Schedules');
        $response = array();
        if(empty($this->request->getData())){

            $header = array(
                'statusCode' => 400,
                'message' => 'Blank Parameter Error'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }
        $appointment_data = $this->request->data('appointment_data');
        if(empty($appointment_data)){

            $header = array(
                'statusCode' => 400,
                'message' => 'Appointment data is blank.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        if(!is_array($appointment_data)){

            $header = array(
                'statusCode' => 402,
                'message' => 'Invalid appointment data format.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        $access_token = $this->request->data('access_token');
        $organization_id = $this->request->data('organization_id');
        $provider_id = $this->request->data('provider_id');
        $org_provider_ids = $this->tokenVerify($access_token, $organization_id, $provider_id);

        //start processing the appointment data

        $appointment_data = array_filter($appointment_data);
        $error = array();
        $scheduled_appointments = array();
        $app_count = 1;

        foreach ($appointment_data as $app_key => $app_value) {
            
            $app_value = array_filter($app_value);
            $temp_err = array();
            $appointment_number = $app_key+1;

            //validate the appointment data

            //required field validation
            if(!isset($app_value['first_name']) || (isset($app_value['first_name']) && empty($app_value['first_name']))){

                $temp_err[] = 'First name is required.';

            }

            if(!isset($app_value['last_name']) || (isset($app_value['last_name']) && empty($app_value['last_name']))){

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

            if(isset($app_value['gender']) && !in_array($app_value['gender'], ['F','M','O'])){

                $temp_err[] = 'Gender sould be M for male, F for female and O for other';

            }

            if(!isset($app_value['appointment_date']) || (isset($app_value['appointment_date']) && empty($app_value['appointment_date']))){

                $temp_err[] = 'Appointment date is required.';
            }

            if(isset($app_value['appointment_date']) && !$this->General->checkDateFormat($app_value['appointment_date'])){

                $temp_err[] = 'Invalid appointment date.';
            }

            /*$appointment_date = strtotime($app_value['appointment_date']);

            if($appointment_date < strtotime(date('Y-m-d'))()){

                $temp_err[] = 'Invalid appointment date.';
            }*/

            //email validation check is still pending

            if(isset($app_value['phone']) && !empty($app_value['phone']) && (!is_numeric($app_value['phone']) || strlen($app_value['phone']) != 10 )){

                $temp_err[] = 'Invalid phone number.';
            }

            $user_detail = null;

            //check patient is registered or not on allevia platform
            if((isset($app_value['email']) && !empty($app_value['email'])) || (isset($app_value['phone']) && !empty($app_value['phone']))){

                $enc_phone = !empty($app_value['phone']) ? base64_encode($this->CryptoSecurity->encrypt($app_value['phone'],SEC_KEY)) : '';
                $enc_email = !empty($app_value['email']) ? base64_encode($this->CryptoSecurity->encrypt($app_value['email'],SEC_KEY)) : '';
                $user_detail_all = $this->Users->find('all')->where(['OR'=>['email' => $enc_email,'phone' => $enc_phone]])->toArray();
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
            elseif(empty($app_value['email']) && empty($app_value['phone']) && (!empty($app_value['first_name']) && !empty($app_value['last_name']) && !empty($app_value['dob'])))
            {

                $enc_first_name = base64_encode($this->CryptoSecurity->encrypt($app_value['first_name'],SEC_KEY));
                $enc_last_name = base64_encode($this->CryptoSecurity->encrypt($app_value['last_name'],SEC_KEY));  
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

            $appointment_date = date('Y-m-d',strtotime($app_value['appointment_date']));
            $dob = date('Y-m-d',strtotime($app_value['dob']));

            //encrypt the appointemt data

            $enc_email = isset($app_value['email']) && $app_value['email'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['email'],SEC_KEY)):'';
            $enc_phone = isset($app_value['phone']) && $app_value['phone'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['phone'],SEC_KEY)) : '';
            $enc_first_name = isset($app_value['first_name']) && $app_value['first_name'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['first_name'],SEC_KEY)) : '';
            $enc_last_name = isset($app_value['last_name']) && $app_value['last_name'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['last_name'],SEC_KEY)) : '';
            $enc_dob = $dob != '' ? base64_encode($this->CryptoSecurity->encrypt($dob,SEC_KEY)) : '';
            $enc_gender = $gender != '' ? base64_encode($this->CryptoSecurity->encrypt($gender,SEC_KEY)) : '';
            $enc_mrn = isset($app_value['mrn']) && $app_value['mrn'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['mrn'],SEC_KEY)) : '';
            $enc_doctor_name = isset($app_value['doctor_name']) && $app_value['doctor_name'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['doctor_name'],SEC_KEY)) : '';
            $enc_appointment_reason = isset($app_value['appointment_reason']) && $app_value['appointment_reason'] != '' ? base64_encode($this->CryptoSecurity->encrypt($app_value['appointment_reason'],SEC_KEY)) : '';

            $enc_appointment_date =   $appointment_date != '' ? base64_encode($this->CryptoSecurity->encrypt($appointment_date,SEC_KEY)) : '';

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
                $user = $this->Users->patchEntity($user,$user_data);
                if(!$user->errors()){

                    $user_detail = $this->Users->save($user);
                }
                else{

                    $error[$appointment_number] = $user->errors();
                    continue;
                }
            }

            //schedule appointment for patient
            if(!empty($user_detail)){

                $schedule = $this->Schedules->newEntity();
                $schedule_data = array();
                $schedule_data['email'] = $enc_email;                
                $schedule_data['first_name'] = $enc_first_name;
                $schedule_data['last_name'] = $enc_last_name;
                $schedule_data['phone'] = $enc_phone;
                $schedule_data['dob'] = $enc_dob;
                $schedule_data['mrn'] = $enc_mrn;
                $schedule_data['doctor_name'] = $enc_doctor_name;
                $schedule_data['appointment_reason'] = $enc_appointment_reason;
                $schedule_data['provider_id'] = $org_provider_ids['provider_id'];
                $schedule_data['organization_id'] = $org_provider_ids['organization_id'];
                $schedule_data['user_id'] = $user_detail->id;
                $schedule_data['appointment_date'] = $enc_appointment_date;
                $schedule = $this->Schedules->patchEntity($schedule,$schedule_data);
                if(!$schedule->errors()){

                    $schedule_detail = $this->Schedules->save($schedule);
                    $scheduled_appointments[] = $schedule_detail->id;  
                }
                else{

                    $error[$appointment_number] = $schedule->errors();
                    continue;
                }
            }


            // pr($scheduled_appointments);
            // pr($error);
            //increase the counter variable
            //$app_count++;
        }
        //die('zxczx');

        $header = array(
                'statusCode' => 200,
                'message' => 'Result of scheduled appointments'
            );

        $payload = array(

            'total_scheduled_appointments' => count($scheduled_appointments),
            'scheduled_appointment_ids' => $scheduled_appointments,
            'errors' => $error
        );

        $response = ['header' => $header,'payload' => $payload];
        echo json_encode($response);die;
    }

}
