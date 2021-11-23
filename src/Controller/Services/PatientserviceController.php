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
 //use Cake\Core\Configure;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PatientserviceController extends AppController
{

	public function initialize()
    {

      parent::initialize();
      $this->loadComponent('RequestHandler');
      $this->loadComponent('CryptoSecurity');
      //$this->loadComponent('ProviderMailSend');
      $this->loadComponent('TextMsgSend');
      $this->loadComponent('General');
      $this->loadModel('Schedule');
      $this->loadModel('Users');
      $this->loadModel('ScheduleToken');
      $this->autoRender = false;

    }

     public function beforeFilter(Event $event)
    {
    	//$this->Auth->allow(['token','management','allAppointments']);
        $this->Auth->allow();
        parent::beforeFilter($event);
        //$this->getEventManager()->off($this->Csrf);
    }

    private function enidVerify($enid)
    {
        if(empty($enid)){

            $header = array(
                'statusCode' => 400,
                'message' => 'Invalid url.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }


        $enid_detail = $this->ScheduleToken->find('all')->where(['ScheduleToken.iframe_enid' =>$enid])->contain(['Schedule1'])->first();
        //pr($enid_detail);die;
        if(empty($enid_detail)){

            $header = array(
                'statusCode' => 402,
                'message' => 'Invalid url.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        if(empty($enid_detail['schedule1'])){

            $header = array(
                'statusCode' => 402,
                'message' => 'Invalid url.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        if($enid_detail['schedule1']['status'] == 3){

            $header = array(
                'statusCode' => 402,
                'message' => 'Appointment has been completed, please schedule the appointment again.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        $appointment_date =  strtotime($enid_detail['schedule1']['appointment_date']);
        $currenttime = strtotime(date('Y-m-d'));
        if($appointment_date < $currenttime){

            $header = array(
                'statusCode' => 402,
                'message' => 'Appointment has been expired, please schedule the appointment again.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        //enid valid for 7200 seconds so we add 7200 in time stamp
        $dataList = TableRegistry::get('global_settings');
        $enid_expire_time = $dataList->find('all')->where(['slug' => 'iframe-pre-appointment-expire'])->first();

        if(!empty($enid_expire_time) && $enid_expire_time['value'] > 0){
            $enidValidTime =  strtotime($enid_detail['created'])+$enid_expire_time['value'];
            $currenttime = time();
            if($enidValidTime < $currenttime){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Link has been expired.'
                );

                $response = ['header' => $header];
                echo json_encode($response);die;
            }
        }

        //now we check the saved schedule id with decrypt the enid & fetch schedule id

        $dec_enid = $this->CryptoSecurity->tokenDecrypt($enid);
        $t_schedule_id = substr($dec_enid, 0, strpos($dec_enid, 'S'));
        $temp_rem_str = substr($dec_enid, strpos($dec_enid, 'S')+1);
        $t_go_through_medical_history = substr($temp_rem_str, 0,1);
        $last_char = substr($temp_rem_str,strlen($temp_rem_str)-1);

        if($t_schedule_id != $enid_detail['schedule1']['id'] || $t_go_through_medical_history != $enid_detail['schedule1']['go_through_medical_history']){

            $header = array(
                'statusCode' => 402,
                'message' => 'Invalid url.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        $user_verification = $last_char == 'V' ? 1 : 0;
        
        //pr($user_validation);die;

        return array('enid_detail' => $enid_detail,'user_verification' => $user_verification);
        //die;
    }

    private function uuidVerify($uuid)
    {
        if(empty($uuid)){

            $header = array(
                'statusCode' => 400,
                'message' => 'Invalid url.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }


        $uuid_detail = $this->Users->find('all')->where(['uuid_token' =>$uuid])->first();
        if(empty($uuid_detail)){

            $header = array(
                'statusCode' => 402,
                'message' => 'Invalid url.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

        //enid valid for 7200 seconds so we add 7200 in time stamp
        /*$dataList = TableRegistry::get('global_settings');
        $enid_expire_time = $dataList->find('all')->where(['slug' => 'iframe-pre-appointment-expire'])->first();

        if(!empty($enid_expire_time) && $enid_expire_time['value'] > 0){
            $enidValidTime =  strtotime($enid_detail['iframe_enid_created_at'])+$enid_expire_time['value'];
            $currenttime = time();
            if($enidValidTime < $currenttime){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Link has been expired.'
                );

                $response = ['header' => $header];
                echo json_encode($response);die;
            }
        }*/

        // $appointment_date =  strtotime($uuid_detail['appointment_date']);
        // $currenttime = strtotime(date('Y-m-d'));
        // if($appointment_date < $currenttime){

        //     $header = array(
        //         'statusCode' => 402,
        //         'message' => 'Appointment has been expired, please schedule the appointment again.'
        //     );

        //     $response = ['header' => $header];
        //     echo json_encode($response);die;
        // }

        //now we check the saved schedule id with decrypt the enid & fetch schedule id

        $dec_uuid = $this->CryptoSecurity->tokenDecrypt($uuid);
        $t_user_id = substr($dec_uuid, 0, strpos($dec_uuid, 'U'));
        $temp_rem_str = substr($dec_uuid, strpos($dec_uuid, 'U')+1);
        $t_bare_bone = substr($temp_rem_str, 0);



        if($t_user_id != $uuid_detail['id'] || $t_bare_bone != $uuid_detail['bare_bones']){

            $header = array(
                'statusCode' => 402,
                'message' => 'Invalid url.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

     return $uuid_detail;
    }


    public function preAppointment()
    {
        try{
        	$requestData = $this->request->getQueryParams();
        	if(!isset($requestData['enid']) || (isset($requestData['enid']) && empty($requestData['enid']))){

        		$header = array(
                    'statusCode' => 400,
                    'message' => 'Invalid url.'
                );

                $response = ['header' => $header];
                echo json_encode($response);die;
        	}

            $requestData['enid'] = str_replace(" ", "+",$requestData['enid']);
            $enid_detail = $this->enidVerify($requestData['enid']);
            if(empty($enid_detail)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid url.'
                );

                $response = ['header' => $header];
                echo json_encode($response);die;
            }
        	$schedule_detail = isset($enid_detail['enid_detail']) && isset($enid_detail['enid_detail']['schedule1']) && !empty($enid_detail['enid_detail']['schedule1']) ? $enid_detail['enid_detail']['schedule1'] : "";
            $user_verification = isset($enid_detail['user_verification']) ? $enid_detail['user_verification'] : 0;

        	if(empty($schedule_detail)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid url.'
                );

                $response = ['header' => $header];
                echo json_encode($response);die;
        	}
            $user_detail_data = null;
            if(empty($schedule_detail['user_id'])){
                //check user is registered or not
                $user_detail_data = $this->General->is_registered($schedule_detail);
            }
            else
            {

                $user_detail_data = $this->Users->find('all')->where(['id' => $schedule_detail['user_id']])->first();
            }

            //save the iframe api data in session to differencaite the normal session and iframe api session
            $session = $this->getRequest()->getSession();
            $session->write('iframe_api_data', $schedule_detail);

            $prefix = 'services';
            if($schedule_detail['bare_bones'] == 0)
            {
               $prefix = false;
            }
            //pr($user_detail_data);
            //die('vvcv');
            if(!empty($user_detail_data)){

                $user_detail_data = $user_detail_data->toArray();
                //set the patient in auth
                $this->Auth->setUser($user_detail_data);
                //save the patient login activity in database
                $this->General->userActivity(['action_performed' => 1, 'user_id' => $user_detail_data['id']]);

                if($schedule_detail['go_through_medical_history'] == 1){

                    if($user_verification){
                        
                        $data = $schedule_detail['id'].'-'.'editmedicalhistory'.'-'.'api';
                        return $this->redirect(['controller' => 'users', 'action' => 'verifyUserDetails', 'prefix' => $prefix, base64_encode($user_detail_data['id']), base64_encode($data)]);
                    }
                    else{

                       return $this->redirect(['controller' => 'users', 'action' => 'editMedicalHistory', 'prefix' => $prefix, $user_detail_data['id']]);
                    }
                }
                else{

                    if($user_verification){
                        
                        $data = $schedule_detail['id'].'-'.'preappointment'.'-'.'api';
                        return $this->redirect(['controller' => 'users', 'action' => 'verifyUserDetails', 'prefix' => $prefix, base64_encode($user_detail_data['id']), base64_encode($data)]);
                    }
                    else{

                        return $this->redirect(['controller' => 'users', 'action' => 'newAppointment', 'prefix' => $prefix, base64_encode($schedule_detail['id'].'-'.time())]);
                    }
                }
            }
            else{
                return $this->redirect(['controller' => 'users', 'action' => 'registerFrontUser', 'prefix' => $prefix, base64_encode($schedule_detail['id'].'-IF-'.time())]);
            }
        }
        catch(\Exception $e){
           // pr($e);die;
            $header = array(
                'statusCode' => 500,
                'message' => 'Internal server error.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

    }

    public function medicalHistory()
    {
        try{
            $requestData = $this->request->getQueryParams();
            if(!isset($requestData['uuid']) || (isset($requestData['uuid']) && empty($requestData['uuid']))){

                $header = array(
                    'statusCode' => 400,
                    'message' => 'Invalid url.'
                );

                $response = ['header' => $header];
                echo json_encode($response);die;
            }

            $user_detail = $this->uuidVerify($requestData['uuid']);

            if(empty($user_detail)){

                $header = array(
                    'statusCode' => 402,
                    'message' => 'Invalid url.'
                );

                $response = ['header' => $header];
                echo json_encode($response);die;
            }

            $prefix = 'services';
            if($user_detail['bare_bones'] == 0)
            {
               $prefix = false;
            }

            //pr($user_detail);die;

            $user_detail = $user_detail->toArray();
            //set the patient in auth
            $this->Auth->setUser($user_detail);
            //save the patient login activity in database
            $this->General->userActivity(['action_performed' => 1, 'user_id' => $user_detail['id']]);

            return $this->redirect(['controller' => 'users', 'action' => 'editMedicalHistory', 'prefix' => $prefix, $user_detail['id']]);
        }
        catch(\Exception $e){

            $header = array(
                'statusCode' => 500,
                'message' => 'Internal server error.'
            );

            $response = ['header' => $header];
            echo json_encode($response);die;
        }

    }

}
