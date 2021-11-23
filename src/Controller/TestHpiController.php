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
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

 use Cake\Network\Email\Email;
 use Cake\Utility\Security;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class TestHpiController extends AppController
{

     public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['symptomDetail','UserDetail','synonymsDetail','appointmentDetail','ScheduleDetail']);
        $this->loadComponent('CryptoSecurity');
    
       
    }

    public function symptomDetail(){

        $this->viewBuilder()->setLayout('front');
        $this->loadModel('ChiefCompliants');
        $this->loadModel('ChiefCompliantDetails');
        $all_symptoms = $this->ChiefCompliants->find('all')->toArray();
        if(!empty($all_symptoms)){

            foreach ($all_symptoms as $key => $value) {
                
                $question_ids = explode(",", $value->default_compliant_detail_ids);
                $all_detail_questions = $this->ChiefCompliantDetails->find('all')->where(['id IN' => $question_ids])->toArray();
               // pr($all_detail_questions);die;
                $all_symptoms[$key]['all_detail_questions'] = $all_detail_questions;

            }
        }

        $this->set(['data' => $all_symptoms]);
    }


    public function synonymsDetail(){

        $this->viewBuilder()->setLayout('front');
        $this->loadModel('ChiefCompliants');
        $all_symptoms = $this->ChiefCompliants->find('all')->order(['doctor_specific_name' => 'desc'])->toArray();
        //pr($all_symptoms);die;
        $this->set(['data' => $all_symptoms]);
    }

    public function UserDetail(){

        $this->viewBuilder()->setLayout('front');
        $this->loadModel('Users');
        $all_users = $this->Users->find('all')->toArray();
        foreach ($all_users as $key => $value) {
                
                $value['first_name'] = $this->CryptoSecurity->decrypt(base64_decode($value['first_name']),SEC_KEY);
                $value['last_name'] = $this->CryptoSecurity->decrypt(base64_decode($value['last_name']),SEC_KEY);
                $value['dob'] = $this->CryptoSecurity->decrypt(base64_decode($value['dob']),SEC_KEY);
                $value['email'] = $this->CryptoSecurity->decrypt(base64_decode($value['email']),SEC_KEY);
                $value['phone'] = $this->CryptoSecurity->decrypt(base64_decode($value['phone']),SEC_KEY);
                if(!empty($value['gender'])){
                $value['gender'] = Security::decrypt(base64_decode($value['gender']),SEC_KEY);
                }
                $all_users[$key] = $value;

            }

       // pr($all_users);die;       

        $this->set(['data' => $all_users]);
    }


     public function ScheduleDetail(){

        $this->viewBuilder()->setLayout('front');
        $this->loadModel('Schedule');
        $all_schedule = $this->Schedule->find('all')->toArray();
       // pr($all_schedule);die;
        error_reporting(0);
        foreach ($all_schedule as $key => $value) {
                
                $value['first_name'] = !empty($value['first_name']) ? $this->CryptoSecurity->decrypt(base64_decode($value['first_name']),SEC_KEY) :'';
                $value['last_name'] = !empty($value['last_name']) ? $this->CryptoSecurity->decrypt(base64_decode($value['last_name']),SEC_KEY) :'';
                $value['dob'] =  !empty($value['dob']) ? $this->CryptoSecurity->decrypt(base64_decode($value['dob']),SEC_KEY) :'';
                $value['email'] = !empty($value['email']) ? $this->CryptoSecurity->decrypt(base64_decode($value['email']),SEC_KEY):'';
                $value['phone'] = !empty($value['phone']) ? $this->CryptoSecurity->decrypt(base64_decode($value['phone']),SEC_KEY) :'';
                $value['mrn'] = !empty($value['mrn']) ? $this->CryptoSecurity->decrypt(base64_decode($value['mrn']),SEC_KEY) :'';
                if(!empty($value['gender'])){
                //$value['gender'] = Security::decrypt(base64_decode($value['gender']),SEC_KEY);
                }
                $all_schedule[$key] = $value;
            }

       // pr($all_users);die;       

        $this->set(['data' => $all_schedule]);
    }


    public function appointmentDetail(){

        $this->viewBuilder()->setLayout('front');
        $this->loadModel('Schedule');
        $all_users = $this->Schedule->find('all')->order(['id' => 'desc'])->limit(50)->toArray();
        // pr($all_users);die;       
        foreach ($all_users as $key => $value) {
                
                $value['appointment_time'] = !empty($value['appointment_time']) ? $this->CryptoSecurity->decrypt(base64_decode($value['appointment_time']),SEC_KEY) : "";
                $value['notify_email_schedule'] = !empty($value['notify_email_schedule']) ? @unserialize($value['notify_email_schedule']) : "";
                $value['notify_text_schedule'] = !empty($value['notify_text_schedule']) ? @unserialize($value['notify_text_schedule']) : "";
                $value['email'] = !empty($value['email']) ? $this->CryptoSecurity->decrypt(base64_decode($value['email']),SEC_KEY) : "";
                $value['phone'] = !empty($value['phone']) ? $this->CryptoSecurity->decrypt(base64_decode($value['phone']),SEC_KEY) : "";
                $all_users[$key] = $value;

            }

       

        $this->set(['data' => $all_users]);
    }

}
