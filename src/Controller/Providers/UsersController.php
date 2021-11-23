<?php
namespace App\Controller\Providers;

use App\Controller\AppController;
use Cake\Controller\Component\PaginatorComponent;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Core\Configure; 
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\Routing\Router;
use Cake\Event\Event;
/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('MailSend');
        $this->loadComponent('CryptoSecurity');
        $this->loadComponent('General');
    }


    
    // public function beforeFilter(Event $event)
    // {
    //    if ($this->Auth->user()) { //If User is logged in.            
    //             $is_shown  = $this->Auth->user('is_shown'); //Get the Status
    //             if( $is_shown != '1' ) { //If Status is not active
    //                 //Redirect Here
    //                 return $this->redirect(
    //                     ['controller' => 'Users', 'action' => 'login']
    //                 );                  
    //             }   
            
    //     }
    // }



    public function login()
    {
        //die('VCcvc');
        // Set the layout.
        $this->viewBuilder()->setLayout('provider-login');

        if ($curuser = $this->Auth->user()) {
            if($curuser['role_id'] == 3 && $curuser['is_shown'] == 1){

                return $this->redirect(array('controller' => 'Dashboard'));
            }
        }

         if ($this->request->is('post')) {            
            
            $this->request->data['email'] = base64_encode($this->CryptoSecurity->encrypt($this->request->data['email'],SEC_KEY));

            $user = $this->Auth->identify();
           
            if(!empty($user) && $user['role_id']!= 3 ){
                $this->Flash->error(__('You are not allowed to login here.'));
                return $this->redirect($this->referer()); 
              }if ($user) {     

                $this->Auth->setUser($user);
                $session = $this->request->getSession();
                $session->write('is_start_tour',1);
                $activity = array();
                $activity['action_performed'] = 1;
                $activity['user_id'] = $user['id'];
                $this->General->userActivity($activity);
                return $this->redirect(array('controller' => 'Dashboard'));
            }

            if(empty($user))
            {      
              $userRecord =  $this->Users->find()->select(['id','email','password'])->toArray();        
              foreach($userRecord as $key => $value)
              {
                
                  if($this->request->data['email'] == $value['email'])
                  {                    
                    if((new DefaultPasswordHasher)->check($this->request->data['password'],$value['password'])){
                  }
                  else
                  {                    
                      $activity['action_performed'] = 3;
                      $activity['user_id'] = $value['id'];
                      $this->General->userActivity($activity);
                      return $this->Flash->error('Your email or password is incorrect.');
                  }  
                }   
              } 
            }
            $this->Flash->error('Your email or password is incorrect.');
        }
       
    }

    public function forgotpassword(){

        $this->viewBuilder()->setLayout('provider-login');
        if( $this->request->is(['post','put']) ){

         
         $email = base64_encode($this->CryptoSecurity->encrypt($this->request->data['email'],SEC_KEY));

         // $result = $this->Users->find()->select(['id','email','username'])->where(['email' => $email, 'status IN' => [0,1]])->first();
        $result = $this->Users->find()->select(['id','email','username','status'])->where(['email' => $email,'is_shown' =>1])->first();
        if(empty($result)){
           $this->Flash->error(__('Record not found for this email Id, Please try again!'));
           return $this->redirect($this->referer());

        }
        
        //pr($result); die;
         if( !empty($result) ){
            
            $userEmail = $this->CryptoSecurity->decrypt(base64_decode($result->email),SEC_KEY);
            $username = 'user';
            $hashCode = sha1($result->id . rand(0, 100));        
            $activationLink = Router::url(['controller' => 'Users','action' => 'reset_password',$hashCode], true);        
            $link = $activationLink;
            $result->activation_link = $hashCode;
            $this->Users->save($result);

           $mailData = array();
           $mailData['slug'] = 'forgot_password';
           $mailData['email'] = $userEmail;
           $mailData['replaceString'] = array('{username}','{activation_link}');
           $mailData['replaceData'] = array($username,$link);            
            $this->MailSend->send( $mailData );
           $this->Flash->success(__('An activation link has been sent to your e-mail,please check to reset your password.'));
            
         }else{
                $this->Flash->error(__('Please enter correct email!'));
               
            }
      }
    }
 
    public function resetPassword($token = null){
     
      $users = $this->Users->newEntity();
        $this->viewBuilder()->setLayout('provider-login');
          
      $users = $this->Users->find()
                           ->select(['id'])
                           ->where(['activation_link' => $token,'status IN' => [0,1],'is_shown' =>1])
                           ->first();
                 
      //pr($users); die;
      
      if( empty($users) ){
         $this->Flash->error(__('Link Expired'));
        return $this->redirect(['controller'=>'users','action'=>'login']);
      }
      
      /* end ---- check token validation */
      if( $this->request->is(['post','put']) ){
      $users->activation_link = '';
      $data =  $this->Users->patchEntity($users,$this->request->data);
         
         if( !$users->errors() ){
            
            if ($this->Users->save($data)) { 
                     $this->Flash->success('Password updated successfully.');
                     return $this->redirect(['controller'=>'users','action'=>'login']);
              }
            
         }
         else{  
            //pr($users->errors()); die;
            foreach($users->errors() as $key => $value){
                     $messageerror = [];
                     foreach($value as $key2 => $value2){
                             $messageerror[] = $value2;
                     }
                     $errorInputs[$key] = implode(",",$messageerror);
                     $this->Flash->error(__($errorInputs[$key]));
             }
             // $this->redirect(['controller'=>'users','action'=>'reset_password',$token]);
         }
         
      }
      
      $this->set(compact('token','users'));
      
    }


    public function logout()
    {
        //pr($this->Auth->user());die;
        $activity = array();
        $activity['action_performed'] = 2;
        $activity['user_id'] =  $this->Auth->user('id');
        $this->General->userActivity($activity);
        $this->Flash->adminsuccess('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */


     public function profile()
    {
        $this->viewBuilder()->setLayout('provider');
        $id = $this->Auth->user('id');
        $user = $this->Users->get($id, [
            'contain' => []
            ]);

            if ($this->request->is(['patch', 'post', 'put'])) {                

                if(!empty($this->request->data['old_password'])){

                    if((new DefaultPasswordHasher)->check($this->request->data['old_password'],$user['password'])){
            

                        if(!empty($this->request->data['updated_password'])){
                           $this->request->data['password'] =  $this->request->data['updated_password'];
                        }
                        $user = $this->Users->patchEntity($user, $this->request->getData());
                        if ($this->Users->save($user)) {

                            $this->Flash->providersuccess(__('User Profile has Updated.'));

                            return $this->redirect(['action' => 'profile']);
                        }
                        $this->Flash->providererror(__('User could not be saved. Please, try again.'));
                    }else{

                       $this->Flash->providererror(__('Old password does not matched.')); 
                    }
                    
                }else{

                    $this->Flash->providererror(__('Old password is required.'));
                }                
            }

         unset($user->password);
        $this->set(array('user' => $user));
    }

    public function scheduleFieldSetting(){
    
        $this->viewBuilder()->setLayout('provider');
        $login_user = $this->Auth->user();
       // pr($login_user);die;
        $FieldSettingTbl = TableRegistry::get('ScheduleFieldSettings'); 
        //pr($this->request->data());die;     

        if ($this->request->is(['post', 'put'])) {
            
            $input = $this->request->data();
            //pr($input);die;
            if($input['file_type'] == 'csv'){

                if($input['read_by'] == 1){

                   /* if($input['single_column_index'] < 1){ 

                        $this->Flash->adminerror(__('Single column index field is required, so set the value greater than or equal to 1.'));
                        return $this->redirect($this->referer());
                    }*/

                    if($input['appointment_reason'] > 0 && $input['doctor_name'] > 0 && $input['appointment_reason'] == $input['doctor_name']){

                        $this->Flash->providererror(__('appointment reason and doctor name must be unique.'));
                        return $this->redirect($this->referer());
                    }                    
                }
                else{

                    unset($input['starting_row']);
                    unset($input['ending_row']);
                    unset($input['single_column_index']);
                    unset($input['read_by']);
                    unset($input['file_type']);
                    unset($input['appointment_reason']);
                    $positiveInput = array();
                    foreach ($input as $key => $value) {
                       
                       if($value > 0){

                            $positiveInput[] = $value;
                       }
                    }

                    $inpCount = count($positiveInput);
                    $inpUnique = array_unique($positiveInput);                   
                    $uniqueCount = count($inpUnique);
                    if($inpCount != $uniqueCount){

                        $this->Flash->providererror(__('All fields value must be unique.'));
                        return $this->redirect($this->referer());
                    }
                }
            }
            else
            {
                //set excel file validation

                unset($input['starting_row']);
                unset($input['ending_row']);
                unset($input['single_column_index']);
                unset($input['read_by']);
                unset($input['file_type']);
                unset($input['appointment_reason']);
                $positiveInput = array();
                foreach ($input as $key => $value) {
                   
                   if($value > 0){

                        $positiveInput[] = $value;
                   }
                }

                $inpCount = count($positiveInput);
                $inpUnique = array_unique($positiveInput);                   
                $uniqueCount = count($inpUnique);
                if($inpCount != $uniqueCount){

                    $this->Flash->providererror(__('All fields value must be unique.'));
                    return $this->redirect($this->referer());
                }
            }
            
            $input = $this->request->data();  
            foreach($input as $k => $inp){

              //set the by default value 4
              if((empty($inp) || $inp < 1) && $k == 'single_column_index'){

                $inp = 4;
              }
              $FieldSettingTbl->updateAll(['field_index' => $inp],['provider_id' => $login_user['id'], 'field_name' => $k]);
             
            }
            $this->Flash->providersuccess(__('Schedule field setting saved successfully.'));

                    
        }
        
      
         $fields = $FieldSettingTbl->find('all')->where(['provider_id' => $login_user['id']])->toArray();
         //pr($fields);die;
         $read_by = 0;
         $file_type = '';
         if(!empty($fields)){

            foreach ($fields as $key => $value) {
                
                if($value['field_name'] == 'read_by'){
                    unset($fields[$key]);
                    $read_by = $value['field_index'];
                    //break;  
                }

                if($value['field_name'] == 'file_type'){
                    unset($fields[$key]);
                    $file_type = $value['field_index'];
                    //break;  
                }
                
            }
         }
        $this->set(compact('fields','read_by','file_type'));
    }

   public function tableColumnSetting(){
    
        $this->viewBuilder()->setLayout('provider');
        $login_user = $this->Auth->user();
        $columnSettingTbl = TableRegistry::get('ProviderDisplayColumns');

        if($this->request->is(['patch', 'post', 'put'])){

            $input = $this->request->data();
            if(isset($input['columns']) && !empty($input['columns'])){

                $columnSettingTbl->updateAll(['is_show' => 0],['provider_id' => $login_user['id']]);
              
                foreach($input['columns'] as $k => $value){

                    $columnSettingTbl->updateAll(['is_show' => 1],['id' => $value]);
                }

              $this->Flash->providersuccess(__('Table display columns setting saved successfully.'));

            }else{

                $this->Flash->providererror(__('Something went wrong, Please try again.'));

            }
        }
        $columns = $columnSettingTbl->find('all')->where(['provider_id' => $login_user['id']])->toArray(); 
        $this->set(compact('columns'));
   }

   public function noteFormating(){

        $this->viewBuilder()->setLayout('provider');
        $login_user = $this->Auth->user();
        $this->loadModel('Users');
        $user_data = $this->Users->find('all')->where(['id' => $login_user['id']])->first();

        if($this->request->is(['patch', 'post'])){
            
           $user_data = $this->Users->patchEntity($user_data, $this->request->getData());
           if ($this->Users->save($user_data)) 
           {    
            //pr($user_data);die;
                //$this->Auth->setUser($user_data);
                $this->Flash->providersuccess(__('Note formatting saved successfully.'));
                //return $this->redirect(['action' => 'profile']);
            }
            else{

                $this->Flash->providererror(__('Note formatting could not be saved. Please try again.'));
            }
        }

        $this->set(compact('user_data'));
        //pr($user_data);die;
   }

   public function support(){

        $this->viewBuilder()->setLayout('provider');
   }

   public function ancillaryDocuments(){

        $this->viewBuilder()->setLayout('provider');
        $login_user = $this->Auth->user();
        $this->loadModel('Users');
        $this->loadModel('Organizations');
        $user_data = $this->Users->find('all')->where(['Users.id' => $login_user['id']])->contain(['Organizations'])->first();
        if(empty($user_data['organization'])){

            $this->Flash->providererror(__('Organization not found.'));
        }
        else{

            $org_data = $this->Organizations->find('all')->where(['id' => $user_data['organization']['id']])->first();
            if(!empty($org_data)){

                if($this->request->is(['patch', 'post'])){

                    $input = array();
                    if (!empty($this->request->data['privacy_policy_docs']['name'])) {
                        $file = $this->request->data['privacy_policy_docs'];
                        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

                        if($extension != 'pdf'){

                            $this->Flash->providererror(__('Document must be pdf type.'));
                            return $this->redirect($this->referer()); 

                        }
                        $setNewFileName = time() . "_" . uniqid().'.'.$extension;
                        if(move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads/ancillary_docs/' . $setNewFileName)){

                            if(!empty($org_data->privacy_policy_docs) && file_exists(WWW_ROOT.'uploads/ancillary_docs/' . $org_data->privacy_policy_docs)){

                                @unlink(WWW_ROOT.'uploads/ancillary_docs/' . $org_data->privacy_policy_docs);
                            }
                            $input['privacy_policy_docs'] = $setNewFileName;  
                        }
                        
                    }
                    if (!empty($this->request->data['treatment_consent_docs']['name'])) {
                        $file = $this->request->data['treatment_consent_docs'];
                        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

                        if($extension != 'pdf'){

                            $this->Flash->providererror(__('Document must be pdf type.'));
                            return $this->redirect($this->referer()); 

                        }
                        $setNewFileName = time() . "_" . uniqid().'.'.$extension;
                        if(move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads/ancillary_docs/' . $setNewFileName)){

                            if(!empty($org_data->treatment_consent_docs) && file_exists(WWW_ROOT.'uploads/ancillary_docs/' . $org_data->treatment_consent_docs)){

                                @unlink(WWW_ROOT.'uploads/ancillary_docs/' . $org_data->treatment_consent_docs);
                               
                            }
                            $input['treatment_consent_docs'] = $setNewFileName;
                        }                
                    }

                    if(isset($this->request->data['is_show_ancillary_docs'])){

                        $input['is_show_ancillary_docs'] = $this->request->data['is_show_ancillary_docs'];
                    }
                    else{

                        $input['is_show_ancillary_docs'] = 0;
                    }



                   $org_data = $this->Organizations->patchEntity($org_data, $input);
                   //pr($org_data);die;
                   if ($this->Organizations->save($org_data)) 
                   {    
                    
                        $this->Flash->providersuccess(__('Ancillary Documents saved successfully.'));
                        return $this->redirect($this->referer());
                    }
                    else{

                        $this->Flash->providererror(__('Ancillary Documents could not be saved. Please, try again.'));
                        return $this->redirect($this->referer());
                    }
                }

            }
            else{

                $this->Flash->providererror(__('Organization not found.'));
            }            

        }      
        
        $this->set(compact('user_data'));        
   }

   public function telehealth(){

        $this->viewBuilder()->setLayout('provider');
        $login_user = $this->Auth->user();
        $this->loadModel('Users');
        $this->loadModel('Organizations');
        $user_data = $this->Users->find('all')->where(['id' => $login_user['id']])->first();
        //pr($user_data);die;
        if($this->request->is(['patch', 'post'])){
            
            $is_telehealth_provider = $this->request->getData('is_telehealth_provider');

            if($is_telehealth_provider == 1){

              if(empty($user_data->cl_provider_id) || $user_data->enable_telehealth == 0){

                $this->Flash->providererror(__('Please contact the admin to add callidus provider id or enable telehealth.'));
                return $this->redirect($this->referer());
              }

              $organization_detail = $this->Organizations->find('all')->where(['id' => $user_data->organization_id])->first();
              if(!empty($organization_detail)){

                if(empty($organization_detail->cl_group_id)){

                    $this->Flash->providererror(__('Please contact the admin to add callidus group id.'));
                    return $this->redirect($this->referer());
                } 
              }
              else{

                  $this->Flash->providererror(__('Clinic not found.'));
                  return $this->redirect($this->referer());
              }
            }
            $user_data->is_telehealth_provider = $is_telehealth_provider;
            if ($this->Users->save($user_data)) 
            {    
              $this->Flash->providersuccess(__('Telehealth setting saved successfully.'));
            }
            else
            {
              $this->Flash->providererror(__('Telehealth setting could not be saved. Please try again.'));
            }
        }

        $this->set(compact('user_data'));
        //pr($user_data);die;
   }

    public function globalSettings()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('provider');
        $this->loadModel('ProviderGlobalSettings');
        $login_user = $this->Auth->user();
        $global_settings    =   $this->ProviderGlobalSettings->find('all')->where(['provider_id' => $login_user['id']])->first();

        if($this->request->is(['post','put']))
        {
            $input = $this->request->data();            

            if(!is_numeric($input['patient_intake_before_appointment_reminder_time']) || $input['patient_intake_before_appointment_reminder_time'] > 600){

                $this->Flash->providererror(__('Patient intake reminder time is must be less than or equal to 600 mins.'));
                return $this->redirect($this->referer());
            }

            if(!is_numeric($input['telehealth_appointment_reminder_time']) || $input['telehealth_appointment_reminder_time'] > 600){

                $this->Flash->providererror(__('Telehealth reminder time is must be less than or equal to 600 mins.'));
                return $this->redirect($this->referer());
            }

            /*if(isset($input['telehealth_before_appointment_reminder']) && $input['telehealth_before_appointment_reminder'] == 1 && empty($input['telehealth_appointment_reminder_time'])){

                $this->Flash->adminerror(__('Telehealth reminder time is required.'));
                return $this->redirect($this->referer());
            }            

            if(isset($input['patient_intake_before_appointment_reminder']) && $input['patient_intake_before_appointment_reminder'] == 1 && empty($input['patient_intake_before_appointment_reminder_time'])){

                $this->Flash->adminerror(__('Patient intake reminder time is required.'));
                return $this->redirect($this->referer());
            }*/

            $global_settings->patient_intake_cvs_upload_reminder = isset($input['patient_intake_cvs_upload_reminder']) ? $input['patient_intake_cvs_upload_reminder'] : 0;
            
            $global_settings->patient_intake_before_appointment_reminder = isset($input['patient_intake_before_appointment_reminder']) ? $input['patient_intake_before_appointment_reminder'] : 0;

            $global_settings->telehealth_cvs_upload_reminder = isset($input['telehealth_cvs_upload_reminder']) ? $input['telehealth_cvs_upload_reminder'] : 0;

             $global_settings->telehealth_before_appointment_reminder = isset($input['telehealth_before_appointment_reminder']) ? $input['telehealth_before_appointment_reminder'] : 0;

              if(isset($input['patient_intake_before_appointment_reminder_time']) && !empty($input['patient_intake_before_appointment_reminder_time'])){

                $global_settings->patient_intake_before_appointment_reminder_time = $input['patient_intake_before_appointment_reminder_time'];
              }
              else{

                $global_settings->patient_intake_before_appointment_reminder_time = 45;
              }

              if(isset($input['telehealth_appointment_reminder_time']) && !empty($input['telehealth_appointment_reminder_time'])){

                $global_settings->telehealth_appointment_reminder_time = $input['telehealth_appointment_reminder_time'];
              }
              else{

                $global_settings->telehealth_appointment_reminder_time = 10;
              }

              if($this->ProviderGlobalSettings->save($global_settings)){

                $this->Flash->providersuccess(__('Saved Successfully.'));
              }
              else{

                $this->Flash->providererror(__('Could not saved, please try again.'));
              }
        }
        $this->set(compact('global_settings'));
    }

    public function timezone(){

        $this->viewBuilder()->setLayout('provider');
        $login_user = $this->Auth->user();
        $this->loadModel('Users');
        $this->loadModel('ProviderGlobalSettings');
        $user_data = $this->ProviderGlobalSettings->find('all')->where(['provider_id' => $login_user['id']])->first();
        //pr($user_data);die;
        if($this->request->is(['patch', 'post'])){
            
            $timezone = $this->request->getData('timezone');            
            $user_data->timezone = $timezone;
            if ($this->ProviderGlobalSettings->save($user_data)) 
            {    
              $this->Flash->providersuccess(__('Timezone setting saved successfully.'));
            }
            else
            {
              $this->Flash->providererror(__('Timezone setting could not be saved. Please try again.'));
            }
        }
        $this->set(compact('user_data'));
   }

      public function sendgridSettings()
      {
        // Set the layout.
        $this->viewBuilder()->setLayout('provider');
        $this->loadModel('ProviderGlobalSettings');
        $login_user = $this->Auth->user();
        $global_settings    =   $this->ProviderGlobalSettings->find('all')->where(['provider_id' => $login_user['id']])->first();

        if($this->request->is(['post','put']))
        {
            $sendgrid_api_key = $this->request->getData('sendgrid_api_key');
            $sendgrid_email = $this->request->getData('sendgrid_email');         

            if(empty($sendgrid_api_key) || empty($sendgrid_email)){

                $this->Flash->providererror(__('Sendgrid api key and sendgrid email are required.'));
                return $this->redirect($this->referer());
            }

            $global_settings->sendgrid_api_key = base64_encode(Security::encrypt($sendgrid_api_key,SEC_KEY));
            $global_settings->sendgrid_email = base64_encode(Security::encrypt($sendgrid_email,SEC_KEY));
            if($this->ProviderGlobalSettings->save($global_settings)){

              $this->Flash->providersuccess(__('Sendgrid setting saved Successfully.'));
            }
            else{

              $this->Flash->providererror(__('Could not saved, please try again.'));
            }
        }
        $this->set(compact('global_settings'));
    }

}
