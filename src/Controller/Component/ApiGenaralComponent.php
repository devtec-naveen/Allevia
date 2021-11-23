<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\Controller\Controller;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class ApiGenaralComponent extends Component{

    public $components = array('CryptoSecurity','General');

    public function tokenVerify($access_token)
    {
        $this->UserInfo  = TableRegistry::get('UserInfo');

        if(empty($access_token)){

            $header = array(
                'statusCode' => 400,
                'message' => 'Access token is empty.'
            );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }
        $encryptToken = base64_encode($this->CryptoSecurity->encrypt($access_token,SEC_KEY));
        $token_detail = $this->UserInfo->find('all')->where(['access_token' =>$encryptToken])->first();
       // echo $token_detail['timestamp'];
       //pr($token_detail);
        // if(empty($token_detail)){

        //     $header = array(
        //         'statusCode' => 402,
        //         'message' => 'Invalid access token.'
        //     );

        //     $response = ['header' => $header];
        //     return $this->response->withType("application/json")->withStringBody(json_encode($response));
        // }

        //token valid for 7200 seconds so we add 7200 in time stamp
        $dataList = TableRegistry::get('global_settings');
        $access_token_expire_time = $dataList->find('all')->where(['slug' => 'iframe-access-token-expire'])->first();

        if(!empty($access_token_expire_time) && $access_token_expire_time['value'] > 0){
            $tokenValidTime =  strtotime($token_detail['timestamp'])+$access_token_expire_time['value'];
            $currenttime = time();
            
            if($tokenValidTime < $currenttime){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Access token has been expired.'
                );

                $response = ['header' => $header];
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
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
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

        //first we check the input organization id with database organization id

        if(!empty($organization_id) && $organization_id != $token_detail['organization_id']){

           $header = array(
                'statusCode' => 402,
                'message' => 'Invalid organization id.'
            );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

        //first we check the input provider id with database provider id

        if(!empty($provider_id) && $provider_id != $token_detail['provider_id']){

            $header = array(
                'statusCode' => 402,
                'message' => 'Invalid provider id.'
            );

            $response = ['header' => $header];
            return $this->response->withType("application/json")->withStringBody(json_encode($response));
        }

        //return array('organization_id' => $token_detail['organization_id'], 'provider_id' => $token_detail['provider_id']);
        $response = array('organization_id' => $token_detail['organization_id'], 'provider_id' => $token_detail['provider_id']);
        return $this->response->withType("application/json")->withStringBody(json_encode($response));
        //die;
    }

    public function mrnVerify($access_token,$mrn,$schedule_data = null)
    {
          $dec_access_token = $this->CryptoSecurity->tokenDecrypt($access_token);
          $t_org_id = substr($dec_access_token, 0, strpos($dec_access_token, 'O'));
          $this->Schedules  = TableRegistry::get('Schedules');
          $mrn = base64_encode($this->CryptoSecurity->encrypt($mrn,SEC_KEY));
          $schedule_detail = $this->Schedules->find('all')->where(['organization_id' => $t_org_id,'mrn' =>$mrn])->first();
          
          $checkExistScheduleAppointment = $this->checkExistScheduleAppointment($schedule_data);

          
          if(!empty($schedule_detail) && $checkExistScheduleAppointment == 0)
          {
                return 1;
          }            
          else if(empty($schedule_detail) && $checkExistScheduleAppointment == 1)
          {
                return 2;
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

        $enc_last_name = isset($detail['last_name']) && !empty($detail['last_name']) ? $detail['last_name'] : '';

        $enc_first_name = isset($detail['first_name']) && !empty($detail['first_name']) ? $detail['first_name'] : '';

        $enc_dob = isset($detail['dob']) && !empty($detail['dob']) ? $detail['dob'] : '';

        $enc_mrn = isset($detail['mrn']) && !empty($detail['mrn']) ? $detail['mrn'] : '';

        $enc_phone = isset($detail['phone']) && !empty($detail['phone']) ? $detail['phone'] : '';

        $enc_email = isset($detail['email']) && !empty($detail['email']) ? $detail['email'] : '';

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

            

             /* if(empty($checkAlreadyScheduleData) || (!empty($checkAlreadyScheduleData) && $checkAlreadyScheduleData['status'] == 3)){
                $is_saved = 1;
              }
              else{

                $is_saved = 0;
              }*/
        }
        elseif(isset($enc_phone) && !empty($enc_phone)){

                $checkAlreadyScheduleData = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['phone' =>$enc_phone,'appointment_date >=' => date('Y-m-d'),'organization_id' =>$organization_id])->toArray();

                    /*if(empty($checkAlreadyScheduleData) || (!empty($checkAlreadyScheduleData) && $checkAlreadyScheduleData['status'] == 3)){
                      $is_saved = 1;
                    }
                    else{
                      //using phone number schedule is already running
                      $is_saved = 0;
                    }*/
        }
        elseif(isset($enc_first_name) && isset($enc_last_name) && isset($enc_dob)){

            $checkAlreadyScheduleData = $this->Schedule->find('all',array('order'=> array('id' => 'desc')))->where(['first_name' =>$enc_first_name,'last_name' => $enc_last_name,'dob' => $enc_dob,'appointment_date >=' => date('Y-m-d'),'organization_id' =>$organization_id])->toArray();

                      // if(empty($checkAlreadyScheduleData) || (!empty($checkAlreadyScheduleData) && $checkAlreadyScheduleData['status'] == 3)){
                      //   $is_saved = 1;
                      // }
                      // else{
                      //  //using first name, last name, dob schedule is alredy running
                      //   $is_saved = 0;
                      // }
        } 

        $app_date = isset($detail['appointment_date']) && !empty($detail['appointment_date']) ?  strtotime($detail['appointment_date']) : date('Y-m-d');   

        if(!empty($checkAlreadyScheduleData)){

            $isMatched = 1;
            // foreach ($checkAlreadyScheduleData as $key => $value) {

            //     $date = !empty($value['appointment_date']) ? strtotime($value['appointment_date']) : "";

            //     if(!empty($enc_doctor_name) && $enc_doctor_name == $value['doctor_name'] && !empty($enc_appointment_time) && $enc_appointment_time == $value['appointment_time'] && !empty($app_date) && $date == $app_date){

            //         $isMatched = 1;
            //     }
            // }
        }        
      }
      return $isMatched;
    }


    public function timezoneConverter($datatime, $cur_timezone = 'CST', $conv_timezone = 'CST'){

            
        if($cur_timezone != $conv_timezone){

            $date = new \DateTime($datatime, new \DateTimeZone($cur_timezone));
           // pr($date);die;
            $date->setTimezone(new \DateTimeZone($conv_timezone));
            $converted_date =  $date->format("Y-m-d H:i");
            return $converted_date;
        }

        return $datatime;
    }

}