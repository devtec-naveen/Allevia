<?php
namespace App\Controller\Organizations;

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

/*
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
            $session = $this->request->session();
            if( $session->check('Auth.User')){
                $USER    = $session->read('Auth.User');
                if($USER['role_id'] == 1) {  // 02-05-18
                    $this->redirect('/admin/dashboard');
                } else  {
                     // $this->redirect(['action' => 'viewer']);
            $this->redirect('/users/dashboard');
                }
            }   
    }

*/

    public function login()
    {

        $this->loadModel('Users');
        $this->viewBuilder()->setLayout('provider-login');

        if ($curuser = $this->Auth->user()) {

            if($curuser['role_id'] == 4 && $curuser['is_shown'] == 1 ){

                return $this->redirect(array('controller' => 'Users','action' =>'index'));
            }
        }

         if ($this->request->is('post')) { 
            
           $this->request->data['email'] = base64_encode($this->CryptoSecurity->encrypt($this->request->data['email'],SEC_KEY));


           $checkUser = $this->Users->find('all')->where(['email' => $this->request->data['email']])->first();
           if(!empty($checkUser) && $checkUser['password'] == '')
           {
            return $this->Flash->error('Your password is not reset please check your email to reset password.');
           } 
            
          
            $user = $this->Auth->identify();


            
           
            if(!empty($user) && $user['role_id']!= 4 ){
                $this->Flash->error(__('You are not allowed to login here.'));
                return $this->redirect($this->referer()); 
              }if ($user && $user['is_shown'] == 1) {                
                $this->Auth->setUser($user);
                $session = $this->request->getSession();
                $session->write('is_start_tour',1);
                $activity = array();
                $activity['action_performed'] = 1;
                $activity['user_id'] = $user['id'];
                $this->General->userActivity($activity);                
                return $this->redirect(array('controller' => 'Users'));
            }

            if(empty($user))
            {   
              $this->loadModel('Users');             
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

      $this->Auth->logout();
      $this->loadModel('Users');
      $users = $this->Users->newEntity();
      $this->viewBuilder()->setLayout('provider-login');
          
      $users = $this->Users->find()
                           ->select(['id'])
                           ->where(['activation_link' => $token,'status IN' => [0,1], 'is_shown' =>1])
                           ->first();
      
      
      if( empty($users) ){
         $this->Flash->error(__('Link Expired'));
        return $this->redirect(['controller' =>'Users','action'=>'login']);
      }
      
      /* end ---- check token validation */
      if( $this->request->is(['post','put']) ){
      $users->activation_link = '';
      $data =  $this->Users->patchEntity($users,$this->request->data);
         
         if(!$users->errors() ){

            if ($this->Users->save($data)) { 
                     $this->Flash->success('Password updated successfully.');
                     return $this->redirect(['controller' =>'Users','action'=>'login']);
              }
            
         }
         else{              
            foreach($users->errors() as $key => $value){
                     $messageerror = [];
                     foreach($value as $key2 => $value2){
                             $messageerror[] = $value2;
                     }
                     $errorInputs[$key] = implode(",",$messageerror);
                     $this->Flash->error(__($errorInputs[$key]));
             }             
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


    public function index()
    {      
        $this->viewBuilder()->setLayout('organization');
        $userTlb = TableRegistry::get('Users');
        $organization_id = $this->Auth->user('organization_id');

        $this->loadModel('Organizations');

        $getSecretStatus = $this->loadModel('Organizations')->find('all')->where(['is_show_secret_key' =>1])->first();

        if(!empty($getSecretStatus))
        {
           $this->loadModel('Organizations')->updateAll(['is_show_secret_key' => 2],['id' => $organization_id]);
        }         
        $user = $userTlb->find('all')->where(['organization_id' => $organization_id,'role_id' =>3])->toArray();        
        $this->set(compact('user'));

    }
   

   public function viewsecret()
   {
       $login_user = $this->Auth->user();
       $this->loadModel('Organizations');
       $this->Organizations->updateAll(['is_show_secret_key' => 1],['id' => $login_user['organization_id']]);
       return $this->redirect($this->referer());
   }

   public function sendrequest()
   {
           $login_user = $this->Auth->user();
           $this->loadModel('Organizations');
           $organizationData = $this->Organizations->find('all')->where(['id' =>$login_user['organization_id']])->first();

           $this->Organizations->updateAll(['is_request_accept' => 1],['id' => $login_user['organization_id']]);
           $adminMail = Configure::read('App.admin_receive_email');           
           $mailData = array();
           $mailData['slug'] = 'send_request_admin';
           $mailData['email'] = $adminMail;
           $mailData['replaceString'] = array('{clinic}');
           $mailData['replaceData'] = array($organizationData['organization_name']);            
           $this->MailSend->send( $mailData );
           $this->Flash->providersuccess(__('Your request successfully sent to admin for view secret key again.'));           
           return $this->redirect($this->referer());
   }

   public function keyrequest()
   {    
           $login_user = $this->Auth->user();
           $this->loadModel('Organizations');
           $organizationData = $this->Organizations->find('all')->where(['id' =>$login_user['organization_id']])->first();

           $this->Organizations->updateAll(['is_generate_new_key' => 1],['id' => $login_user['organization_id']]);
           $adminMail = Configure::read('App.admin_receive_email');           
           $mailData = array();
           $mailData['slug'] = 'send_request_admin_for_new_key_generate';
           $mailData['email'] = $adminMail;
           $mailData['replaceString'] = array('{clinic}');
           $mailData['replaceData'] = array($organizationData['organization_name']);            
           $this->MailSend->send( $mailData );
           $this->Flash->providersuccess(__('Your request successfully sent to admin for generate new key.'));           
           return $this->redirect($this->referer());

   }


    public function addUri()
    {
        $this->viewBuilder()->setLayout('organization');
        $id = $this->Auth->user('id');
        $user = $this->Users->get($id); 
               
        $invalidUrl = array();     
        $validUrl = array(); 
        $this->loadModel('Organizations');
        $organizationData = $this->Organizations->find('all')->where(['id' =>$user['organization_id']])->first();  

            
            if($this->request->is(['patch', 'post', 'put'])) {  

                $redirectUri = $this->request->data['allow_redirect_uri'];    

                $splitRedirectUri = explode(';',$redirectUri);

                if(!empty($splitRedirectUri))
                {
                   $splitRedirectUri = array_filter($splitRedirectUri);

                   foreach ($splitRedirectUri as $key => $value) {

                        $checkurl = $this->check_url($value);   

                        if(!$checkurl)
                        {
                          $invalidUrl[] = $value;
                        } 
                        else
                        {
                          $validUrl[] = $value;
                        }  
                   }
                }

                $invalidUri = '';
                if(!empty($invalidUrl))
                {
                  $invalidUri = 'Invalid Url: ';
                  $invalidUri .= implode(', ', $invalidUrl);
                }  

                if(!empty($splitRedirectUri)){  
                  
                        $organizationData->allow_redirect_uri = !empty($validUrl)?implode(';', $validUrl):'';
                        
                        if ($this->Organizations->save($organizationData)) {                                              
                            
                            $this->Flash->providersuccess(__('Redirect uri updated successfully. '.$invalidUri));

                            return $this->redirect(['action' => 'add_uri']);
                        }
                        $this->Flash->providererror(__('Redirect uri not be saved. Please, try again.'));
                }else{
                    $this->Flash->providererror(__('Redirect uri is empty.'));
                }                       
            }
            $this->set(compact('organizationData')); 
    }


      public function check_url($url)
      { 
           $url = preg_match_all('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $url);
           return $url;
      }
}
