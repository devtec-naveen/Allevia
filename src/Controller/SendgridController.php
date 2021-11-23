<?php
 
namespace App\Controller;

//use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
//use Cake\Network\Email\Email;
//use Cake\Utility\Security;
use Twilio\Rest\Client;
use Cake\Network\Email\Email;
use Cake\Core\Configure;
use Cake\Log\Log;

class SendgridController extends AppController
{
    public function initialize()
    {

        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Schedule');
        $this->loadModel('SentMails');
        $this->loadModel('ProviderEmailTemplates');
        $this->loadModel('Organizations');
        $this->loadModel('ScheduleToken');
        $this->loadModel('ProviderGlobalSettings');
        $this->autoRender = false;
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['sendEmail']);
        $this->loadComponent('CryptoSecurity');
        $this->loadComponent('General');
    
       
    }

    public function sendEmail($priority = 0)
    {
        // echo getenv('SENDGRID_API_KEY');
        // die;
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("testbydev.pr@gmail.com", "test User");
        $email->setSubject("Sending with Twilio SendGrid is Fun");
        $email->addTo("u@getnada.com", "U User");
        //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public function sendReminderEmail()
    {   
        $this->sendEmailText();

    }

    public function sendScheduleEmail()
    {   
       
        $this->sendEmailText(1);

    }

   
    public function sendReminder()
    {        

        $provider_org_detail = $this->Users->find('list',['keyField' => 'id','valueField' => 'organization_id'])->where(['role_id'=> 3])->toArray();
        //pr($provider_org_detail);

        $providers_ids = array_keys($provider_org_detail);
      // pr($providers_ids);      
        $provider_config_detail = $this->ProviderGlobalSettings->find('all')->where(['provider_id IN' => $providers_ids])->toArray();
       // pr($provider_config_detail);die;   
        $organization_detail = $this->Organizations->find('all')->toArray();
        $temp_provider_config = array();
        if(!empty($provider_config_detail)){

            foreach ($provider_config_detail as $key => $value) {
                
                $temp_provider_config[$value->provider_id] = $value;
            }

            $provider_config_detail = $temp_provider_config;
        }

        $temp_org = array();
        if(!empty($organization_detail)){

            foreach ($organization_detail as $key => $value) {
                
                $temp_org[$value->id] = $value;
            }

            $organization_detail = $temp_org;
        }

       
        $schedule_data = $this->Schedule->find('all',array('order' => ['Schedule.id' => 'desc']))->where(['Date(Schedule.created)' => date('Y-m-d')])->where(['Schedule.status != ' =>3,'is_sent_before_time_reminder'=> 0, 'OR' => ['appointment_time is not null','appointment_time != ' => '']])
        ->contain(['Doctors'])
        ->toArray();

        //pr($schedule_data);die;

        

        if(!empty($schedule_data)){

            foreach ($schedule_data as $key => $value) {
                //decrypt the schedule data
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

                $dec_first_name = $value['first_name'];
                if(!empty($dec_first_name)){

                  $dec_first_name = $this->CryptoSecurity->decrypt(base64_decode($value['first_name']),SEC_KEY);
                }

                $dec_appointment_time = $value['appointment_time'];
                if(!empty($dec_appointment_time)){

                  $dec_appointment_time = $this->CryptoSecurity->decrypt(base64_decode($value['appointment_time']),SEC_KEY);
                }

                $user_data = '';
                if(!empty($value['email'])){

                  $user_data = $this->Users->find('all')->where(['email'=> $value['email']])->first();
                }
                elseif(!empty($value['phone'])){

                  $enc_phone = base64_encode($this->CryptoSecurity->encrypt($dec_phone,SEC_KEY));
                  $user_data = $this->Users->find('all')->where(['phone'=> $enc_phone])->first();
                }
                else
                { 
                    $filter = ['AND'=>
                        ['first_name'=> $value['first_name'],
                        'last_name' => $value['last_name'],
                        "dob" => $value['dob'],
                        ["OR"=>[
                        'email'=>"",
                        'email IS NULL']
                        ],
                        ["OR"=>[
                        'phone'=>"",
                        'phone IS NULL']
                        ]
                        ]];
                    $user_data =$this->Users->find('all')->where($filter)->first();
                }

                $username = !empty($dec_first_name) ? $dec_first_name : 'user';
                $org_url = '';
                $clinic_name = 'clinic';
                $org_id = isset($provider_org_detail[$value['provider_id']]) ? $provider_org_detail[$value['provider_id']] : '';
                if(!empty($org_id) && isset($organization_detail[$org_id])){

                  $org_url = $organization_detail[$org_id]['org_url'];
                  $clinic_name = $organization_detail[$org_id]['organization_name'];
                }

                $iframe_enid = $value['id'].'S'.'0V';
                $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid);

                /*$link = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'users/register-front-user/'.base64_encode($value['id'].'-E-'.time());
                $mlink = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'users/register-front-user/'.base64_encode($value['id'].'-M-'.time());


                if(!empty($user_data)){

                    $link = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'dashboard/fill-appointment-link/'.base64_encode($user_data['id']).'/'.base64_encode($value['id']);

                    $mlink = SITE_URL.(!empty($org_url) ? $org_url.'/' : "").'dashboard/fill-appointment-link/'.base64_encode($user_data['id']).'/'.base64_encode($value['id']);
                }*/ 


                /*//check the time for send the reminder
                $reminder_time = explode("-", $dec_appointment_time);
                $send_reminder_time = '';
                if(isset($reminder_time[1]) && !empty(trim($reminder_time[1]))){

                    $send_reminder_time = trim($reminder_time[1]);
                }

                $current_time = strtotime(date('H:i A'));
                if(!empty($send_reminder_time)){

                    $send_reminder_time = strtotime($send_reminder_time);
                }

                $diff_time = round(($send_reminder_time - $current_time)/60, 2);*/

                //combine appointment date and time
                $send_reminder_time = $dec_appointment_time;

                if(strpos($dec_appointment_time, "-") !== false){

                    $reminder_time = explode("-", $dec_appointment_time);
                   // $send_reminder_time = '';
                    if(isset($reminder_time[1]) && !empty(trim($reminder_time[1]))){

                        $send_reminder_time = trim($reminder_time[1]);
                    }
                }

                $appointment_date_time = $value['appointment_date'];

                if(!empty($send_reminder_time)){
                    
                    $hours = date('H',strtotime($send_reminder_time));
                    $mintus = date('i',strtotime($send_reminder_time));
                    $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$hours.'hours'));
                    $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$mintus.'minutes'));
                }

                $current_time = strtotime(date('Y-m-d H:i'));
                $appointment_date_time = strtotime($appointment_date_time);

                //calculate the difference between time
                $diff_time = round($appointment_date_time - $current_time);
                         
                //send patient telehealth reminder
                $check_telehealth_data = $this->General->checkTelehealthAppointmentData($value->provider_id, $value['organization_id'],$value);
                //echo 'valid for telehealth '.$check_telehealth_data.'<br>';

                if( $check_telehealth_data && isset($provider_config_detail[$value->provider_id]) && $provider_config_detail[$value->provider_id]['telehealth_before_appointment_reminder'] == 1 && $diff_time <= $provider_config_detail[$value->provider_id]['telehealth_appointment_reminder_time'])
                {
                    //echo 'telehealth <br>';
                    //send patient intake reminder
                    $emailTemplates = $this->ProviderEmailTemplates->find('all')->where(['slug' =>'telehealth_reminder_before_x_time', 'provider_id' => $value['provider_id']])->first();
                    if(!empty($emailTemplates) && (!empty($dec_email) || !empty($dec_phone))){

                        //send email
                        $sent_mail = $this->SentMails->newEntity();
                        if(!empty($dec_email)){

                          $checExistMail = $this->SentMails->find('all')->where(['to_mail' =>$dec_email,'is_sent' =>0,'slug' =>'telehealth_reminder_before_x_time','organization_id' => $value['organization_id']])->first();
                            if(empty($checExistMail)){

                                $iframe_enid = $value['id'].'S'.'0V';
                                $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                                $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid); 

                                $sent_mail->content = str_replace(['{username}','{time}','{clinic}'], [$username,$diff_time,$clinic_name], $emailTemplates['description']);
                                $sent_mail->content = str_replace("at .", ".", $sent_mail->content);
                                $sent_mail->subject = $emailTemplates['subject'];
                                $sent_mail->to_mail =  $dec_email;
                                $sent_mail->slug =  $emailTemplates['slug'];
                                $sent_mail->organization_id = $value['organization_id'];

                                $schedule_token = $this->ScheduleToken->newEntity();
                                $schedule_token->schedule_id = $value['id'];
                                $schedule_token->iframe_enid = $iframe_enid;
                                $this->ScheduleToken->save($schedule_token);
                            }
                            
                        }
                        if(!empty($dec_phone)){

                             $checExistPhone = $this->SentMails->find('all')->where(['phone' =>$dec_phone,'is_sent' =>0,'slug' =>'telehealth_reminder_before_x_time','organization_id' => $value['organization_id']])->first();
                            if(empty($checExistPhone)){

                                $iframe_enid = $value['id'].'S'.'0V';
                                $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                                $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid); 


                                $sent_mail->text_message = str_replace(['{username}','{time}','{clinic}'], [$username,$diff_time,$clinic_name], $emailTemplates['text_message']);
                                $sent_mail->text_message = str_replace("at .", ".", $sent_mail->text_message);
                                $sent_mail->phone = $dec_phone; 
                                $sent_mail->slug =  $emailTemplates['slug'];
                                $sent_mail->organization_id = $value['organization_id'];

                                $schedule_token = $this->ScheduleToken->newEntity();
                                $schedule_token->schedule_id = $value['id'];
                                $schedule_token->iframe_enid = $iframe_enid;
                                $this->ScheduleToken->save($schedule_token);
                            }                           
                        }
                        $this->SentMails->save($sent_mail);

                        $value->is_sent_before_time_reminder = 1;
                        if($value->status == 0){

                            $value->status = 1;
                        }
                        echo $value['id'].' schedule telehealth reminder sent.<br>';                       
                    }
                }

                //send patient intake reminder                
                if(isset($provider_config_detail[$value->provider_id]) && $provider_config_detail[$value->provider_id]['patient_intake_before_appointment_reminder'] == 1 && !empty($provider_config_detail[$value->provider_id]['patient_intake_before_appointment_reminder_time']) && $diff_time <= $provider_config_detail[$value->provider_id]['patient_intake_before_appointment_reminder_time'])
                {
                    //echo 'intake <br>';
                    //send patient intake reminder
                    $emailTemplates = $this->ProviderEmailTemplates->find('all')->where(['slug' =>'pre_appointment_reminder', 'provider_id' => $value['provider_id']])->first();
                    if(!empty($emailTemplates) && (!empty($dec_email) || !empty($dec_phone))){

                        //send email
                        $sent_mail = $this->SentMails->newEntity();
                        if(!empty($dec_email)){
                                
                            $checExistMail = $this->SentMails->find('all')->where(['to_mail' =>$dec_email,'is_sent' =>0,'slug' =>'pre_appointment_reminder','organization_id' => $value['organization_id']])->first();
                            if(empty($checExistMail)){                    

                                $iframe_enid = $value['id'].'S'.'0V';
                                $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                                $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid); 

                                $sent_mail->content = str_replace(['{username}','{link}','{clinic}'], [$username,$link,$clinic_name], $emailTemplates['description']);
                                $sent_mail->subject = $emailTemplates['subject'];
                                $sent_mail->to_mail =  $dec_email;
                                $sent_mail->slug =  $emailTemplates['slug'];
                                $sent_mail->organization_id = $value['organization_id'];

                                $schedule_token = $this->ScheduleToken->newEntity();
                                $schedule_token->schedule_id = $value['id'];
                                $schedule_token->iframe_enid = $iframe_enid;
                                $this->ScheduleToken->save($schedule_token);
                            }
                            
                        }
                        if(!empty($dec_phone)){

                            $checExistPhone = $this->SentMails->find('all')->where(['phone' =>$dec_phone,'is_sent' =>0,'slug' =>'pre_appointment_reminder','organization_id' => $value['organization_id']])->first();
                            if(empty($checExistPhone)){

                                $iframe_enid = $value['id'].'S'.'0V';
                                $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                                $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid); 

                                $sent_mail->text_message = str_replace(['{username}','{link}','{clinic}'], [$username,$link,$clinic_name], $emailTemplates['text_message']);
                                $sent_mail->phone = $dec_phone;  
                                $sent_mail->slug =  $emailTemplates['slug'];
                                $sent_mail->organization_id = $value['organization_id'];

                                $schedule_token = $this->ScheduleToken->newEntity();
                                $schedule_token->schedule_id = $value['id'];
                                $schedule_token->iframe_enid = $iframe_enid;
                                $this->ScheduleToken->save($schedule_token);
                            }                         
                        }
                        $this->SentMails->save($sent_mail);                        

                        $value->is_sent_before_time_reminder = 1;
                        echo $value['id'].' schedule patient intake reminder sent.<br>';                     
                    }
                }

                if(!empty($user_data)){
                    $value->user_id = $user_data['id'];
                }
                $value->go_through_medical_history = 0;
                //$value->iframe_enid = $iframe_enid;
                //$value->iframe_enid_created_at = date('Y-m-d H:i:s');
                $this->Schedule->save($value);      
            }
            //die('sccxz');
        }
        die();
    }

    public function scheduleReminder()
    {
        
        $provider_org_detail = $this->Users->find('list',['keyField' => 'id','valueField' => 'organization_id'])->where(['role_id'=> 3])->toArray();

        $providers_ids = array_keys($provider_org_detail);    
        $organization_detail = $this->Organizations->find('all')->toArray();
        $temp_org = array();
        if(!empty($organization_detail)){

            foreach ($organization_detail as $key => $value) {
                
                $temp_org[$value->id] = $value;
            }

            $organization_detail = $temp_org;
        }

        $schedule_data = $this->Schedule->find('all',array('order' => ['Schedule.id' => 'desc']))->where(['Date(Schedule.appointment_date) >=' => date('Y-m-d')])->where(['Schedule.status != ' =>3,'appointment_time is not null','appointment_time != ' => '',
            'OR' => [ 
                        ['notify_email_remaining_schedule is not null','notify_email_remaining_schedule != ' => ''],
                        ['notify_text_remaining_schedule is not null','notify_text_remaining_schedule != ' => '']
                    ]
                ]
            )

            ->contain(['Doctors'])
            ->toArray();

        //pr($schedule_data);die;

        if(!empty($schedule_data)){

            foreach ($schedule_data as $key => $value) {
                
                //decrypt the schedule data
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

                $dec_appointment_time = $value['appointment_time'];
                if(!empty($dec_appointment_time)){

                  $dec_appointment_time = $this->CryptoSecurity->decrypt(base64_decode($dec_appointment_time),SEC_KEY);
                }

                $notify_email_remaining_schedule = $value['notify_email_remaining_schedule'];
                if(!empty($notify_email_remaining_schedule)){

                  $notify_email_remaining_schedule = unserialize($notify_email_remaining_schedule);
                }

                $notify_text_remaining_schedule = $value['notify_text_remaining_schedule'];
                if(!empty($notify_text_remaining_schedule)){

                  $notify_text_remaining_schedule = unserialize($notify_text_remaining_schedule);
                }

                //combine appointment date and time
                $send_reminder_time = $dec_appointment_time;

                if(strpos($dec_appointment_time, "-") !== false){

                    $reminder_time = explode("-", $dec_appointment_time);
                   // $send_reminder_time = '';
                    if(isset($reminder_time[1]) && !empty(trim($reminder_time[1]))){

                        $send_reminder_time = trim($reminder_time[1]);
                    }
                }

                $appointment_date_time = $value['appointment_date'];

                if(!empty($send_reminder_time)){
                    
                    $hours = date('H',strtotime($send_reminder_time));
                    $mintus = date('i',strtotime($send_reminder_time));
                    $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$hours.'hours'));
                    $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$mintus.'minutes'));
                }

                $current_time = strtotime(date('Y-m-d H:i'));
                $appointment_date_time = strtotime($appointment_date_time);

                //calculate the difference between time
                $diff_time = round($appointment_date_time - $current_time);
                $before_15mints = abs($diff_time-(7*60));
                $after_15mints = abs($diff_time+(8*60));
                pr('appointment id'.$value['id']);
                pr('diff_time'.$diff_time);

                pr('before_15mints'.$before_15mints);
                pr('after_15mints'.$after_15mints);

                $send_text = 0;
                $send_email = 0;

                pr('notify_text_remaining_schedule');
                pr($notify_text_remaining_schedule);

                pr('notify_email_remaining_schedule');
                pr($notify_email_remaining_schedule);

                if(!empty($notify_text_remaining_schedule)){

                    foreach ($notify_text_remaining_schedule as $tk => $tv) {
                        
                        if($before_15mints >= $tv && $tv <= $after_15mints){
                           $send_text = 1;
                           unset($notify_text_remaining_schedule[$tk]);
                           break; 
                        }
                    }
                }

                if(!empty($notify_email_remaining_schedule)){

                    foreach ($notify_email_remaining_schedule as $ek => $ev) {
                        
                        if($before_15mints >= $ev && $ev <= $after_15mints){
                           $send_email = 1;
                           unset($notify_email_remaining_schedule[$ek]);
                           break; 
                        }
                    }
                }

                // $send_text = 1;
                // $send_email = 1;

                if($send_text != 1 && $send_email != 1){

                    continue;
                }   


                $user_data = '';
                if(!empty($value['email'])){

                  $user_data = $this->Users->find('all')->where(['email'=> $value['email']])->first();
                }
                elseif(!empty($value['phone'])){

                  $enc_phone = base64_encode($this->CryptoSecurity->encrypt($dec_phone,SEC_KEY));
                  $user_data = $this->Users->find('all')->where(['phone'=> $enc_phone])->first();
                }
                else
                { 
                    $filter = ['AND'=>
                        ['first_name'=> $value['first_name'],
                        'last_name' => $value['last_name'],
                        "dob" => $value['dob'],
                        ["OR"=>[
                        'email'=>"",
                        'email IS NULL']
                        ],
                        ["OR"=>[
                        'phone'=>"",
                        'phone IS NULL']
                        ]
                        ]];
                    $user_data =$this->Users->find('all')->where($filter)->first();
                }

                $username = !empty($dec_first_name) ? $dec_first_name : 'user';
                $org_url = '';
                $clinic_name = 'clinic';
                $org_id = isset($provider_org_detail[$value['provider_id']]) ? $provider_org_detail[$value['provider_id']] : '';
                if(!empty($org_id) && isset($organization_detail[$org_id])){

                  $org_url = $organization_detail[$org_id]['org_url'];
                  $clinic_name = $organization_detail[$org_id]['organization_name'];
                }

                
                
                $emailTemplates = $this->ProviderEmailTemplates->find('all')->where(['slug' =>'pre_appointment_reminder', 'provider_id' => $value['provider_id']])->first();
                if(!empty($emailTemplates) && (!empty($dec_email) || !empty($dec_phone))){

                    //send email
                    $sent_mail = $this->SentMails->newEntity();
                    if(!empty($dec_email) && $send_email == 1 ){

                        $checExistMail = $this->SentMails->find('all')->where(['to_mail' =>$dec_email,'is_sent' =>0,'priority' =>1,'organization_id' => $value['organization_id']])->first();
                        if(empty($checExistMail)){

                            //here v denote that we need to verify the user
                            $iframe_enid = $value['id'].'S'.'0V';
                            $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                            $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid);                  

                            $sent_mail->content = str_replace(['{username}','{link}','{clinic}'], [$username,$link,$clinic_name], $emailTemplates['description']);
                            $sent_mail->subject = $emailTemplates['subject'];
                            $sent_mail->to_mail =  $dec_email;
                            $sent_mail->slug =  $emailTemplates['slug'];
                            $sent_mail->organization_id = $value['organization_id'];
                            $sent_mail->priority = 1;

                            $sent_email_msg = 'email reminder save to db for '.$dec_email.' of schedule id '.$value['id'].' at '.date('Y-m-d h:i:s A');
                            Log::debug($sent_email_msg);

                            $schedule_token = $this->ScheduleToken->newEntity();
                            $schedule_token->schedule_id = $value['id'];
                            $schedule_token->iframe_enid = $iframe_enid;
                            $this->ScheduleToken->save($schedule_token);
                        }
                        
                    }
                    if(!empty($dec_phone) && $send_text == 1){

                        $checExistPhone = $this->SentMails->find('all')->where(['phone' =>$dec_phone,'is_sent' =>0,'priority' =>1,'organization_id' => $value['organization_id']])->first();
                        if(empty($checExistPhone)){

                            //here v denote that we need to verify the user
                            $iframe_enid = $value['id'].'S'.'0V';
                            $iframe_enid = $this->CryptoSecurity->tokenEncrypt($iframe_enid);
                            $link = SITE_URL.'services/api/pre-appointment?enid='.urlencode($iframe_enid);

                            $sent_mail->text_message = str_replace(['{username}','{link}','{clinic}'], [$username,$link,$clinic_name], $emailTemplates['text_message']);
                            $sent_mail->phone = $dec_phone;  
                            $sent_mail->slug =  $emailTemplates['slug'];
                            $sent_mail->organization_id = $value['organization_id']; 
                            $sent_mail->priority = 1;

                            $sent_text_msg = 'text reminder save to db for '.$dec_phone.' of schedule id '.$value['id'].' at '.date('Y-m-d h:i:s A');
                            Log::debug($sent_text_msg);

                            $schedule_token = $this->ScheduleToken->newEntity();
                            $schedule_token->schedule_id = $value['id'];
                            $schedule_token->iframe_enid = $iframe_enid;
                            $this->ScheduleToken->save($schedule_token);
                        }                         
                    }
                    $this->SentMails->save($sent_mail);                        

                    $value->notify_email_remaining_schedule = !empty($notify_email_remaining_schedule) ? serialize($notify_email_remaining_schedule) : "";

                    $value->notify_text_remaining_schedule = !empty($notify_text_remaining_schedule) ? serialize($notify_text_remaining_schedule) : "";

                    $value->go_through_medical_history = 0;
                    //$value->iframe_enid = $iframe_enid;
                   // $value->iframe_enid_created_at = date('Y-m-d H:i:s');
                    
                    if(!empty($user_data)){
                        $value->user_id = $user_data['id'];
                    }
                    $this->Schedule->save($value);                    
                    echo $value['id'].' schedule patient schedule reminder sent.<br>';                     
                }
            }
            
        }
        die();
    }

    public function deleteMail(){

        //get the 7 days back date
        $date  = date('Y-m-d', strtotime('-7 days'));
        //$mails = $this->SentMails->find('list',['keyField' => 'id','valueField' => 'id'])->where(['Date(created) <=' => $date,'is_sent' => 1])->toArray();
        //pr(count($mails));die;
        if($result = $this->SentMails->deleteAll(['Date(created) <=' => $date,'is_sent' => 1])){

            echo $result;
        }
        //deleteAll
        //echo $date;
        die;
    }



}
