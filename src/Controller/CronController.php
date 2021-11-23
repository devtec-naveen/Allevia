<?php
 
namespace App\Controller;

//use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
//use Cake\Network\Email\Email;
use Cake\Utility\Security;
use Twilio\Rest\Client;
use Cake\Network\Email\Email;
use Cake\Core\Configure;
use Cake\Log\Log;

class CronController extends AppController
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

        $this->Auth->allow(['sendReminder','sendReminderEmail','scheduleReminder','sendScheduleEmail','deleteMail','sendNotes']);
        $this->loadComponent('CryptoSecurity');
        $this->loadComponent('General');
        $this->loadModel('ProviderGlobalSettings');
    
       
    }

    private function sendEmailText($priority = 0)
    {

        require_once(ROOT . DS  . env('twillo_path'));
        $sid = env('twilio_sid');
        $token = env('twilio_access_token');
        $twilio_number = env('twilio_number');
        $email_data = $this->SentMails->find('all')->where(['is_sent' => 0,'priority' =>$priority])->limit(100)->toArray();
        //$sender = 'admin@allevia.com';
        if(!empty($email_data)){

            foreach ($email_data as $key => $value) {
                
                //send email
                if(!empty($value['to_mail']) && !empty($value['content'])){

                    $provider_config = "";

                    if(!empty($value['provider_id'])){

                        $provider_config = $this->ProviderGlobalSettings->find()->where(['provider_id' => $value['provider_id']])->first();
                    }

                    if(!empty($provider_config) && !empty($provider_config['sendgrid_api_key']) && !empty($provider_config['sendgrid_email']))
                    {

                        $provider_config['sendgrid_api_key'] = Security::decrypt(base64_decode($provider_config['sendgrid_api_key']),SEC_KEY);

                        $provider_config['sendgrid_email'] = Security::decrypt(base64_decode($provider_config['sendgrid_email']),SEC_KEY);
                        $username = isset($value['username']) ? $value['username'] : "User";

                      
                        $email = new \SendGrid\Mail\Mail();
                        $email->setFrom($provider_config['sendgrid_email'],"Allevia Provider");
                        $email->setSubject($value['subject']);
                        $email->addTo($value['to_mail'],$username);
                       // $email->addTo('u@getnada.com',$username);
                        $email->addContent("text/html", $value['content']);
                        $sendgrid = new \SendGrid($provider_config['sendgrid_api_key']);
                        try {
                            $response = $sendgrid->send($email);
                            $sent_mail_msg = 'email sent to '.$value['to_mail'].' at '.date('Y-m-d h:i:s A');
                            Log::debug($sent_mail_msg);
                            
                        } catch (Exception $e) {
                            
                        }
                    }
                    else{

                        $email = new Email('default');
                        try
                        {                          
                            $result = $email->from(['admin@allevia.com' => 'Allevia Provider'])
                                          ->to($value['to_mail'])
                                          //->to('u@getnada.com')
                                          ->emailFormat('html')
                                          ->subject($value['subject'])
                                          ->send($value['content']);
                            $sent_mail_msg = 'email sent to '.$value['to_mail'].' at '.date('Y-m-d h:i:s A');
                            Log::debug($sent_mail_msg);
                        }
                        catch(Exception $e)
                        {
                          
                        }  
                    }                    
                }

                //send text message
                if(!empty($value['phone']) && !empty($value['text_message']))
                {

                    $client = new Client($sid, $token);
                    try{

                          $message = $client->messages->create(
                           '+1'.$value['phone'], // Text this number  '+1'.$user_data['phone']//$arg['phone']
                            array(
                              'from' => $twilio_number, // From a valid Twilio number
                              'body' => strip_tags($value['text_message'])
                            )
                          );
                        $sent_text_msg = 'text sent to '.$value['phone'].' at '.date('Y-m-d h:i:s A');
                        Log::debug($sent_text_msg);
                    }
                    catch(\Exception $e)
                    {

                    }
                }

                $value->is_sent  =1;
                $this->SentMails->save($value);
                echo $value['id'].' email or text sent.<br>';
            }
        }
        die;
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
                $org_logo = WEBROOT."images/logo.png";
                $org_id = isset($provider_org_detail[$value['provider_id']]) ? $provider_org_detail[$value['provider_id']] : '';
                if(!empty($org_id) && isset($organization_detail[$org_id])){

                  $org_url = $organization_detail[$org_id]['org_url'];
                  $clinic_name = $organization_detail[$org_id]['organization_name'];
                  if(!empty($organization_detail[$org_id]['clinic_logo'])){

                    $org_logo = WEBROOT.'img/'.$organization_detail[$org_id]['clinic_logo'];
                  }
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

                                $sent_mail->content = str_replace(['{username}','{time}','{clinic}','{logo}'], [$username,$diff_time,$clinic_name,$org_logo], $emailTemplates['description']);
                                $sent_mail->content = str_replace("at .", ".", $sent_mail->content);
                                $sent_mail->subject = $emailTemplates['subject'];
                                $sent_mail->to_mail =  $dec_email;
                                $sent_mail->slug =  $emailTemplates['slug'];
                                $sent_mail->organization_id = $value['organization_id'];
                                $sent_mail->provider_id = $value['provider_id'];
                                $sent_mail->username =  $username;


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
                                $sent_mail->provider_id = $value['provider_id'];
                                $sent_mail->username =  $username;

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

                                $sent_mail->content = str_replace(['{username}','{link}','{clinic}','{logo}'], [$username,$link,$clinic_name,$org_logo], $emailTemplates['description']);
                                $sent_mail->subject = $emailTemplates['subject'];
                                $sent_mail->to_mail =  $dec_email;
                                $sent_mail->slug =  $emailTemplates['slug'];
                                $sent_mail->organization_id = $value['organization_id'];
                                $sent_mail->provider_id = $value['provider_id'];
                                $sent_mail->username =  $username;

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
                                $sent_mail->provider_id = $value['provider_id'];
                                $sent_mail->username =  $username;

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

            //->order(['Schedule.id'=>'desc'])
            //->limit(50)
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
                if(!empty($dec_appointment_time))
                {
                  $dec_appointment_time = $this->CryptoSecurity->decrypt(base64_decode($dec_appointment_time),SEC_KEY);
                }

                $notify_email_remaining_schedule = $value['notify_email_remaining_schedule'];
                if(!empty($notify_email_remaining_schedule))
                {
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
                    if(isset($reminder_time[1]) && !empty(trim($reminder_time[1]))){

                         $send_reminder_time = trim($reminder_time[1]); 
                    }
                }
                
                 $appointment_date_time = $value['appointment_date'];
                
                if(!empty($send_reminder_time))
                {    
                     $hours = date('H',strtotime($send_reminder_time));
                    $mintus = date('i',strtotime($send_reminder_time));
                     $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$hours.'hours'));
                    $appointment_date_time = date('Y-m-d H:i',strtotime($appointment_date_time.' +'.$mintus.'minutes'));
                }
                  
                $appointment_date_time = strtotime($appointment_date_time);
                $currentDate = date("Y-m-d H:i:s");

                //To Get Current DateTime - 15Min
                $before_15mints_date = strtotime(date("Y-m-d H:i:s", strtotime($currentDate) - (7 * 60)));
                $after_15mints_date = strtotime(date("Y-m-d H:i:s", strtotime($currentDate) + (8 * 60)));
                $send_text = 0;
                $send_email = 0;

                if(!empty($notify_text_remaining_schedule))
                {
                    foreach ($notify_text_remaining_schedule as $tk => $tv) 
                    {       
                        /*if($before_15mints >= $tv && $tv <= $after_15mints)
                        {
                           $send_text = 1;
                           unset($notify_text_remaining_schedule[$tk]);
                           break; 
                        }*/

                        //To Get Current DateTime - 15Min
                         $before_15mints_date1 = strtotime(date("Y-m-d H:i:s", $before_15mints_date + $tv));
                         $after_15mints_date1 = strtotime(date("Y-m-d H:i:s", $after_15mints_date + $tv));
                       
                        //If the appointment time is under 
                        if($appointment_date_time >= $before_15mints_date1 && $appointment_date_time <= $after_15mints_date1 )
                        {
                           $send_text = 1;
                           unset($notify_text_remaining_schedule[$tk]);
                           break; 
                        }
                    }
                }

                if(!empty($notify_email_remaining_schedule)){

                    foreach ($notify_email_remaining_schedule as $ek => $ev) {
                        
                        /*if($before_15mints >= $ev && $ev <= $after_15mints){
                           $send_email = 1;
                           unset($notify_email_remaining_schedule[$ek]);
                           break; 
                        }*/
                        //To Get Current DateTime - 15Min
                         $before_15mints_date2 = strtotime(date("Y-m-d H:i:s", $before_15mints_date + $ev));
                         $after_15mints_date2 = strtotime(date("Y-m-d H:i:s", $after_15mints_date + $ev));
                       
                        //If the appointment time is under 
                        if($appointment_date_time >= $before_15mints_date2 && $appointment_date_time <= $after_15mints_date2 )
                        {
                           $send_email = 1;
                           unset($notify_email_remaining_schedule[$ek]);
                           break; 
                        }
                    }
                }

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
                $org_logo = WEBROOT."images/logo.png";
                $org_id = isset($provider_org_detail[$value['provider_id']]) ? $provider_org_detail[$value['provider_id']] : '';
                if(!empty($org_id) && isset($organization_detail[$org_id])){

                  $org_url = $organization_detail[$org_id]['org_url'];
                  $clinic_name = $organization_detail[$org_id]['organization_name'];
                  if(!empty($organization_detail[$org_id]['clinic_logo'])){
                    $org_logo = WEBROOT.'img/'.$organization_detail[$org_id]['clinic_logo'];
                  }
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

                            $sent_mail->content = str_replace(['{username}','{link}','{clinic}','{logo}'], [$username,$link,$clinic_name,$org_logo], $emailTemplates['description']);
                            $sent_mail->subject = $emailTemplates['subject'];
                            $sent_mail->to_mail =  $dec_email;
                            $sent_mail->slug =  $emailTemplates['slug'];
                            $sent_mail->organization_id = $value['organization_id'];
                            $sent_mail->priority = 1;
                            $sent_mail->provider_id = $value['provider_id'];
                            $sent_mail->username =  $username;

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
                            $sent_mail->provider_id = $value['provider_id'];
                            $sent_mail->username =  $username;

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


     public function sendNotes()
    {  
        $schedule =  $this->loadModel('Schedule');        
        $providers = $this->Users->find('all')->contain(['Schedule','Schedule.chiefcompliantuserdetails'])->where(['role_id' => 3,'is_allow_note' =>1])->toArray();    

        //pr($providers);die;                                  

        foreach ($providers as $key => $value) {

                            $sendMethod = Security::decrypt(base64_decode($value->sending_method),SEC_KEY);
                            $end_point =  Security::decrypt(base64_decode($value->end_point),SEC_KEY);
                            $port =       !empty($value->port) ? Security::decrypt(base64_decode($value->port),SEC_KEY) : '22' ;
                            $sftp_username =  !empty($value->sftp_username) ? Security::decrypt(base64_decode($value->sftp_username),SEC_KEY):'';
                            $sftp_password =  !empty($value->sftp_password) ? Security::decrypt(base64_decode($value->sftp_password),SEC_KEY):'';
                            $note_format =  !empty($value->note_format) ? Security::decrypt(base64_decode($value->note_format),SEC_KEY) : '';
                            $apiKey = !empty($value->api_key)? Security::decrypt(base64_decode($value->api_key),SEC_KEY) :'';
                            $remote_host = !empty($end_point)?$end_point:'192.168.1.236';
                            $remote_port = !empty($port)?$port:'22';
                            $remote_user = !empty($sftp_username)?$sftp_username:'allevia';
                            $remote_pass = !empty($sftp_password)?$sftp_password:'i5uabtZF0hYc';
                            $remote_dir = WWW_ROOT."/Notes/";                                
 
                      
                        
                   foreach ($value['schedule'] as $schId => $schValue) {

                            if($note_format == 1){

                            $ehrNote = !empty($schValue['ChiefCompliantUserdetails']['ehr_note_json_readable']) ? Security::decrypt(base64_decode($schValue['ChiefCompliantUserdetails']['ehr_note_json_readable']),SEC_KEY):'';
                            }

                            else if($note_format == 2)
                            {
                                 $ehrNote = !empty($schValue['ChiefCompliantUserdetails']['ehr_note_json']) ? Security::decrypt(base64_decode($schValue['ChiefCompliantUserdetails']['ehr_note_json']),SEC_KEY):'';
                            }
                            if(!empty($ehrNote))
                            {
                                $ehrNote = $this->prettyPrint($ehrNote)."\n\n";    
                            } 

                            if($schValue['is_send_notes'] == 0)
                            {                                
                                if(isset($sendMethod) && $sendMethod == 1)
                                   {                                    
                                        try {                                            
                                         $remote_conn = ssh2_connect($remote_host, $remote_port);

                                        } catch (Exception $e) {
                                            die("could not connect to ".$remote_host);
                                        }

                                        try {
                                            ssh2_auth_password($remote_conn, $remote_user, $remote_pass);
                                        } catch (Exception $e) {
                                            die("Password failed on ".$remote_host);
                                        }

                                        $sftp = ssh2_sftp($remote_conn); 

                                        $remote_file = 'note_'.strtotime(date('Y-m-d h:i:s')).'_'.$this->General->generateClientSecret(15).'.txt';
                                        $fetch_string = "ssh2.sftp://" .intval($sftp). $remote_dir . $remote_file;
                                                                            
                                        $stream = fopen($fetch_string, 'w'); 
                                        if (!$stream) {
                                            die("Could not open remote file: " . $fetch_string . "\n");
                                        }

                                        fwrite($stream, $ehrNote);
                                        fclose($stream);                                       
                                        $this->Schedule->updateAll(['is_send_notes' =>1],['id' =>$schValue['id']]);
                                    } 
                                    else if(isset($sendMethod) && $sendMethod == 2)
                                    {                                                                         
                                        $url = $end_point; 
                                        $apiKey = $apiKey; // should match with Server key
                                       /* $headers = array(
                                             'Authorization: '.$apiKey
                                        ); */

                                        $headers = array();
                                        $headers[] = 'Authorization: Basic';
                                        $headers[] = 'X-Api-Key: ' . $apiKey;                                   

                                        $ch = curl_init( $url );                                       
                                        curl_setopt( $ch, CURLOPT_POST, 1);
                                        curl_setopt( $ch, CURLOPT_POSTFIELDS, $ehrNote);
                                        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                                        curl_setopt( $ch, CURLOPT_HEADER, 0);
                                        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                                        $response = curl_exec( $ch );
                                        $response = json_decode($response);    

                                        //pr($response);die;
                                                                            
                                        if(curl_exec($ch) === false)
                                        {
                                            echo 'Curl error: ' . curl_error($ch);
                                        }
                                        else
                                        {
                                            echo 'Operation completed without any errors';
                                        }   
                                                                          
                                        //if(isset($response->statusCode) && $response->statusCode == '200')
                                        //{                                                
                                            $errorMessage = !empty($response->errorMessage) ? $response->errorMessage : '';
                                            $this->Schedule->updateAll(['is_send_notes' =>1, 'error_message' =>$errorMessage ],['id' =>$schValue['id']]);  
                                       // }                                           
                                    }                                 
                             }
                       }                       
                }                
                die('Send note successfully');               
           }           


            function prettyPrint( $json )
            {
                $result = '';
                $level = 0;
                $in_quotes = false;
                $in_escape = false;
                $ends_line_level = NULL;
                $json_length = strlen( $json );

                for( $i = 0; $i < $json_length; $i++ ) {
                    $char = $json[$i];
                    $new_line_level = NULL;
                    $post = "";
                    if( $ends_line_level !== NULL ) {
                        $new_line_level = $ends_line_level;
                        $ends_line_level = NULL;
                    }
                    if ( $in_escape ) {
                        $in_escape = false;
                    } else if( $char === '"' ) {
                        $in_quotes = !$in_quotes;
                    } else if( ! $in_quotes ) {
                        switch( $char ) {
                            case '}': case ']':
                                $level--;
                                $ends_line_level = NULL;
                                $new_line_level = $level;
                                break;

                            case '{': case '[':
                                $level++;
                            case ',':
                                $ends_line_level = $level;
                                break;

                            case ':':
                                $post = " ";
                                break;

                            case " ": case "\t": case "\n": case "\r":
                                $char = "";
                                $ends_line_level = $new_line_level;
                                $new_line_level = NULL;
                                break;
                        }
                    } else if ( $char === '\\' ) {
                        $in_escape = true;
                    }
                    if( $new_line_level !== NULL ) {
                        $result .= "\n".str_repeat( "\t", $new_line_level );
                    }
                    $result .= $char.$post;
                }
                return $result;
     }

    /* public function sendNotes()
     {  
        $schedule =  $this->loadModel('Schedule');        
        $providers = $this->Users->find('all')->contain(['Schedule','Schedule.chiefcompliantuserdetails'])->where(['role_id' => 3,'is_allow_note' =>1])->toArray();         

        foreach ($providers as $key => $value) {

                        $sendMethod = Security::decrypt(base64_decode($value->sending_method),SEC_KEY);
                        $end_point =  Security::decrypt(base64_decode($value->end_point),SEC_KEY);

                        $remote_host = $end_point;
                        $remote_port = 22;
                        $remote_user = $value->sftp_username;
                        $remote_pass = $value->sftp_password;;
                        $remote_dir = WWW_ROOT."/Notes/";
                        $remote_file = 'note2.txt';    
                        
                   foreach ($value['schedule'] as $schId => $schValue) {

                            if($schValue['is_send_notes'] == 0)
                            {
                                if(isset($sendMethod) && $sendMethod == 1)
                                   {
                                  //  if(isset($value['time_interval']) && $value['time_interval'] == 1)
                                  //  {
                                       $ehrNote =  Security::decrypt(base64_decode($schValue['ChiefCompliantUserdetails']['ehr_note_json']),SEC_KEY);

                                        try {
                                            $remote_conn = ssh2_connect($remote_host, $remote_port);    
                                        } catch (Exception $e) {
                                            die("could not connect to ".$remote_host);
                                        }

                                        try {
                                            ssh2_auth_password($remote_conn, $remote_user, $remote_pass);
                                        } catch (Exception $e) {
                                            die("Password failed on ".$remote_host);
                                        }

                                        $sftp = ssh2_sftp($remote_conn);

                                        $fetch_string = "ssh2.sftp://$sftp" . $remote_dir . $remote_file;

                                        $fileExists = file_exists($fetch_string);

                                        if (!$fileExists) { 
                                            die('File does not exist');
                                        }

                                        //$localfile = file_get_contents(WWW_ROOT."/Notes/note1.txt");
                                       
                                        $stream = fopen($fetch_string, 'a');
                                        //$file = file_get_contents($localfile);
                                        // $contents = stream_get_contents($stream);
                                        fwrite($stream, $ehrNote);
                                        fclose($stream);

                                        if (!$stream) {
                                            die("Could not open remote file: " . $fetch_string . "\n");
                                        }

                                        $this->Schedule->updateAll(['is_send_notes' =>1],['id' =>$schId]);
                                   }
                                   elseif (isset($sendMethod) && $sendMethod == 2) {

                                       $ehrNote =  Security::decrypt(base64_decode($schValue['ChiefCompliantUserdetails']['ehr_note_json']),SEC_KEY);
                                   }
                             }
                       }
                }
               
           }*/
}
