<?php
namespace App\Controller\Admin;

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

    public function index()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $users =$this->Users->find()->where(['role_id' => 2, 'Users.is_shown' => 1])->order(['Users.id' => 'desc']);

        //pr($users->toArray()); die;
        // $users=$this->paginate($users);
        $this->set(array('users' => $users));

    }

    public function view($id = null){
        $this->viewBuilder()->setLayout('admin');
        $login_user = $this->Users->find('all')->where(['Users.id' => $id])->first();
        $this->loadModel('WomenSpecific');
      $women_field =  $this->WomenSpecific->find('all')->where(['user_id' => $id ])->first();






  // decrypting user data and woman data start ************************


// decrypting women specific data start ******************
if(!empty( $women_field)){
  $womanrec = $women_field;
    if(!empty($womanrec->age_of_first_priod))
     $womanrec->age_of_first_priod = Security::decrypt( base64_decode($womanrec->age_of_first_priod), SEC_KEY);

    if(!empty($womanrec->no_of_pregnency))
     $womanrec->no_of_pregnency = Security::decrypt( base64_decode($womanrec->no_of_pregnency), SEC_KEY);

         if(!empty($womanrec->no_of_miscarriage))
     $womanrec->no_of_miscarriage = Security::decrypt( base64_decode($womanrec->no_of_miscarriage), SEC_KEY);
        if(!empty($womanrec->is_regular_papsmear))
     $womanrec->is_regular_papsmear = Security::decrypt( base64_decode($womanrec->is_regular_papsmear), SEC_KEY);

        if(!empty($womanrec->papsmear_finding))
     $womanrec->papsmear_finding = Security::decrypt( base64_decode($womanrec->papsmear_finding), SEC_KEY);
        if(!empty($womanrec->is_curently_pregnant))
     $womanrec->is_curently_pregnant = Security::decrypt( base64_decode($womanrec->is_curently_pregnant), SEC_KEY);
        if(!empty($womanrec->current_baby_sex))
     $womanrec->current_baby_sex = Security::decrypt( base64_decode($womanrec->current_baby_sex), SEC_KEY);
        if(!empty($womanrec->currently_pregnant_week))
     $womanrec->currently_pregnant_week = Security::decrypt( base64_decode($womanrec->currently_pregnant_week), SEC_KEY);
        if(!empty($womanrec->currently_pregnant_days))
     $womanrec->currently_pregnant_days = Security::decrypt( base64_decode($womanrec->currently_pregnant_days), SEC_KEY);
        if(!empty($womanrec->currently_pregnant_complication))
     $womanrec->currently_pregnant_complication = Security::decrypt( base64_decode($womanrec->currently_pregnant_complication), SEC_KEY);

        if(!empty($womanrec->is_previous_birth))
     $womanrec->is_previous_birth = Security::decrypt( base64_decode($womanrec->is_previous_birth), SEC_KEY);
        if(!empty($womanrec->previous_birth_sex))
     $womanrec->previous_birth_sex = Security::decrypt( base64_decode($womanrec->previous_birth_sex), SEC_KEY);
        if(!empty($womanrec->previous_delivery_method))
     $womanrec->previous_delivery_method = Security::decrypt( base64_decode($womanrec->previous_delivery_method), SEC_KEY);
        if(!empty($womanrec->previos_pregnancy_duration))
     $womanrec->previos_pregnancy_duration = Security::decrypt( base64_decode($womanrec->previos_pregnancy_duration), SEC_KEY);

        if(!empty($womanrec->previous_complication))
     $womanrec->previous_complication = Security::decrypt( base64_decode($womanrec->previous_complication), SEC_KEY);
        if(!empty($womanrec->previous_hospital))
     $womanrec->previous_hospital = Security::decrypt( base64_decode($womanrec->previous_hospital), SEC_KEY);
        if(!empty($womanrec->is_mammogram))
     $womanrec->is_mammogram = Security::decrypt( base64_decode($womanrec->is_mammogram), SEC_KEY);
        if(!empty($womanrec->mammogram_month))
     $womanrec->mammogram_month = Security::decrypt( base64_decode($womanrec->mammogram_month), SEC_KEY);
        if(!empty($womanrec->mammogram_year))
     $womanrec->mammogram_year = Security::decrypt( base64_decode($womanrec->mammogram_year), SEC_KEY);
        if(!empty($womanrec->previous_abnormal_breast_lump))
     $womanrec->previous_abnormal_breast_lump = Security::decrypt( base64_decode($womanrec->previous_abnormal_breast_lump), SEC_KEY);

        if(!empty($womanrec->any_biopsy))
     $womanrec->any_biopsy = Security::decrypt( base64_decode($womanrec->any_biopsy), SEC_KEY);

        if(!empty($womanrec->is_sti_std))
     $womanrec->is_sti_std = Security::decrypt( base64_decode($womanrec->is_sti_std), SEC_KEY);

  $women_field  = $womanrec  ;
 }


//pr($login_user);die;

// decrypting women specific data end ******************

// decrypting user data start
$user_data = $login_user ;
if(!empty($user_data)){


if(!empty($user_data->first_name))
$user_data->first_name = $this->CryptoSecurity->decrypt(base64_decode($user_data->first_name), SEC_KEY);

if(!empty($user_data->last_name))
$user_data->last_name = $this->CryptoSecurity->decrypt( base64_decode($user_data->last_name), SEC_KEY);

if(!empty($user_data->email))
$user_data->email = $this->CryptoSecurity->decrypt( base64_decode($user_data->email), SEC_KEY);

if(!empty($user_data->phone))
$user_data->phone = $this->CryptoSecurity->decrypt( base64_decode($user_data->phone), SEC_KEY);

if(!empty($user_data->dob))
$user_data->dob = $this->CryptoSecurity->decrypt( base64_decode($user_data->dob), SEC_KEY);




if(!empty($user_data->height))
$user_data->height = Security::decrypt( base64_decode($user_data->height), SEC_KEY);

if(!empty($user_data->weight))
$user_data->weight = Security::decrypt( base64_decode($user_data->weight), SEC_KEY);

if(!empty($user_data->is_uterus_removal))
$user_data->is_uterus_removal = Security::decrypt( base64_decode($user_data->is_uterus_removal), SEC_KEY);


if(!empty($user_data->is_latex_allergy))
$user_data->is_latex_allergy = Security::decrypt( base64_decode($user_data->is_latex_allergy), SEC_KEY);

if(!empty($user_data->is_retired))
$user_data->is_retired = Security::decrypt( base64_decode($user_data->is_retired), SEC_KEY);

if(!empty($user_data->occupation))
$user_data->occupation = Security::decrypt( base64_decode($user_data->occupation), SEC_KEY);

if(!empty($user_data->marital_status))
$user_data->marital_status = Security::decrypt( base64_decode($user_data->marital_status), SEC_KEY);

if(!empty($user_data->sexual_orientation))
$user_data->sexual_orientation = Security::decrypt( base64_decode($user_data->sexual_orientation), SEC_KEY);

if(!empty($user_data->ethinicity))
$user_data->ethinicity = Security::decrypt( base64_decode($user_data->ethinicity), SEC_KEY);

if(!empty($user_data->current_smoke_pack))
$user_data->current_smoke_pack = Security::decrypt( base64_decode($user_data->current_smoke_pack), SEC_KEY);


if(!empty($user_data->current_smoke_year))
$user_data->current_smoke_year = Security::decrypt( base64_decode($user_data->current_smoke_year), SEC_KEY);

if(!empty($user_data->past_smoke_pack))
$user_data->past_smoke_pack = Security::decrypt( base64_decode($user_data->past_smoke_pack), SEC_KEY);

if(!empty($user_data->past_smoke_year))
$user_data->past_smoke_year = Security::decrypt( base64_decode($user_data->past_smoke_year), SEC_KEY);

if(!empty($user_data->current_drink_pack))
$user_data->current_drink_pack = Security::decrypt( base64_decode($user_data->current_drink_pack), SEC_KEY);

if(!empty($user_data->current_drink_year))
$user_data->current_drink_year = Security::decrypt( base64_decode($user_data->current_drink_year), SEC_KEY);

if(!empty($user_data->past_drink_pack))
$user_data->past_drink_pack = Security::decrypt( base64_decode($user_data->past_drink_pack), SEC_KEY);

if(!empty($user_data->past_drink_year))
$user_data->past_drink_year = Security::decrypt( base64_decode($user_data->past_drink_year), SEC_KEY);

if(!empty($user_data->is_currentlysmoking))
$user_data->is_currentlysmoking = Security::decrypt( base64_decode($user_data->is_currentlysmoking), SEC_KEY);

if(!empty($user_data->is_pastsmoking))
$user_data->is_pastsmoking = Security::decrypt( base64_decode($user_data->is_pastsmoking), SEC_KEY);

if(!empty($user_data->is_currentlydrinking))
$user_data->is_currentlydrinking = Security::decrypt( base64_decode($user_data->is_currentlydrinking), SEC_KEY);

if(!empty($user_data->is_pastdrinking))
$user_data->is_pastdrinking = Security::decrypt( base64_decode($user_data->is_pastdrinking), SEC_KEY);

if(!empty($user_data->is_otherdrug))
$user_data->is_otherdrug = Security::decrypt( base64_decode($user_data->is_otherdrug), SEC_KEY);

if(!empty($user_data->is_otherdrugpast))
$user_data->is_otherdrugpast = Security::decrypt( base64_decode($user_data->is_otherdrugpast), SEC_KEY);


if(!empty($user_data->gender))
$user_data->gender = Security::decrypt( base64_decode($user_data->gender), SEC_KEY);


}

 $login_user = $user_data ;

// decrypting user data end




 // decrypting user data and woman data end *****************************





// pr($women_field); die;
// pr(unserialize(base64_decode($women_field->prev_birth_detail)) );

      $commonTable = TableRegistry::get('common_conditions');
        $common_medical_cond = $commonTable->find('list', [
                                            'keyField' => 'id',
                                            'valueField' => 'name'
                                        ])->order(['name'=>'ASC'])->toArray();

// die;
         $this->set(compact('login_user', 'women_field', 'common_medical_cond'));
    }

    public function edit($id = null){

        $this->viewBuilder()->setLayout('admin');
        $organizations = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            if(!empty($this->request->data['first_name']))
                $this->request->data['first_name'] = base64_encode($this->CryptoSecurity->encrypt($this->request->data['first_name'], SEC_KEY))  ;
            if(!empty($this->request->data['last_name']))
                $this->request->data['last_name'] = base64_encode($this->CryptoSecurity->encrypt($this->request->data['last_name'], SEC_KEY))  ;

            $organizations = $this->Users->patchEntity($organizations, $this->request->getData());
            if ($this->Users->save($organizations)) {
                $this->Flash->adminsuccess(__('Updated successfully.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->adminerror(__('Record could not be saved. Please, try again.'));
        }
        if(!empty($organizations->first_name))
            $organizations->first_name = $this->CryptoSecurity->decrypt( base64_decode($organizations->first_name), SEC_KEY);

        if(!empty($organizations->last_name))
            $organizations->last_name = $this->CryptoSecurity->decrypt( base64_decode($organizations->last_name), SEC_KEY);

        if(!empty($organizations->email))
            $organizations->email = $this->CryptoSecurity->decrypt( base64_decode($organizations->email), SEC_KEY);

        if(!empty($organizations->phone))
            $organizations->phone = $this->CryptoSecurity->decrypt( base64_decode($organizations->phone), SEC_KEY);

        $this->set(compact('organizations'));
    }

    public function login()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin-login');

        if ($curuser = $this->Auth->user()) {
            if($curuser['role_id'] == 1){
                return $this->redirect(array('controller' => 'Dashboard'));
            } else {
                $this->Flash->error('You are not allowed to login here.');
                 return $this->redirect('/users/login');
            }
        }

         if ($this->request->is('post')) {

           // pr($this->request->data());die;
            $this->request->data['email'] = base64_encode($this->CryptoSecurity->encrypt($this->request->data['email'], SEC_KEY))  ;
            $user = $this->Auth->identify();
            if( !empty($user) && $user['role_id']!= 1 ){
                $this->Flash->error(__('You are not allowed to login here.'));
                return $this->redirect($this->referer());
              }if ($user) {
                $this->Auth->setUser($user);
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


   // this forgotpassword function copied from the front
    public function forgotpassword(){
      //$this->viewBuilder()->layout(false);

      // $this->autoRender = false;
        $this->viewBuilder()->setLayout('admin-login');


         // $result = $this->Users->find()->select(['id','email','username'])->where(['email' => $email, 'status IN' => [0,1]])->first();
        $result = $this->Users->find()->select(['id','email','username','status'])->where(['id' => 1])->first();
        if(empty($result)){
           $this->Flash->error(__('Record not found for this email Id, Please try again!'));
           return $this->redirect($this->referer());

        }

        //pr($result); die;
         if( !empty($result) ){

            $userEmail = $this->CryptoSecurity->decrypt(base64_decode($result->email),SEC_KEY);
            $username = ucfirst($this->CryptoSecurity->decrypt(base64_decode($result->username),SEC_KEY));
            $hashCode = sha1($result->id . rand(0, 100));

            $activationLink = Router::url(['controller' => 'Users','action' => 'reset_password',$hashCode], true);

             $link = $activationLink;


            /* Update to database */
           $result->activation_link = $hashCode;
            $this->Users->save($result);

            /* End update to database */

             /* Start Send email */
           $mailData = array();
           $mailData['slug'] = 'admin_reset_password'; // 'forgot_password';
           $mailData['email'] = $userEmail;
           $mailData['replaceString'] = array('{username}','{activation_link}');
           $mailData['replaceData'] = array($username,$link);

            $this->MailSend->send( $mailData );

           /* end send email  */

           $this->Flash->success(__('An activation link has been sent to admin e-mail,please check to reset admin password.'));
            // $this->redirect(['controller'=>'users','action'=>'login']);
         }else{
                $this->Flash->error(__('Not Found!'));
                // $this->redirect(['action'=>'login','#' => 'toregister']);
            }

        return $this->redirect(array('action' => 'login'));
    }


    public function resetPassword($token = null){

        $users = $this->Users->newEntity();
        $this->viewBuilder()->setLayout('admin-login');
        $users = $this->Users->find()
                           ->select(['id'])
                           ->where(['activation_link' => $token,'status IN' => [0,1]])
                           ->first();

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
        $this->Flash->adminsuccess('You are now logged out.');
        $activity = array();
        $activity['action_performed'] = 2;
        $activity['user_id'] =  $this->Auth->user('id');
        $this->General->userActivity($activity);
        return $this->redirect($this->Auth->logout());
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */


     public function profile()
    {
        $this->viewBuilder()->setLayout('admin');
        $id = $this->Auth->user('id');
        $user = $this->Users->get($id, [
            'contain' => []
            ]);

            if ($this->request->is(['patch', 'post', 'put'])) {


            if(isset($this->request->data['profile'])){
                if (!empty($this->request->data['profile']['name'])) {
                $file = $this->request->data['profile'];
                $setNewFileName = time() . "_" . $file['name'];
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/profile/' . $setNewFileName);
                $this->request->data['profile'] = $setNewFileName;
                } else {
                $this->request->data['profile'] = $this->request->data['oldprofile'];
                }

            }

            $this->request->data['first_name'] =base64_encode($this->CryptoSecurity->encrypt($this->request->data['first_name'],SEC_KEY));

            $this->request->data['last_name'] =base64_encode($this->CryptoSecurity->encrypt($this->request->data['last_name'],SEC_KEY));

            if(empty($this->request->data['password'])){
               unset($this->request->data['password']);
            }
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {

                 $this->Auth->setUser($user);

                $this->Flash->adminsuccess(__('User Profile has Updated.'));

                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->adminerror(__('User could not be saved. Please, try again.'));
        }

         unset($user->password);
        // pr($user); die;
        // $user->first_name = $this->CryptoSecurity->decrypt(base64_decode($user->first_name),SEC_KEY);
        // $user->last_name = $this->CryptoSecurity->decrypt(base64_decode($user->last_name),SEC_KEY);
        $this->set(array('user' => $user));
    }




    public function delete($id=null)
    {

        $Cms_pages = TableRegistry::get('Users');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->email = base64_encode($this->CryptoSecurity->encrypt($this->CryptoSecurity->decrypt(base64_decode($cms_pages->email),SEC_KEY).'(deleted-'.time().')',SEC_KEY));
         $cms_pages->phone = base64_encode($this->CryptoSecurity->encrypt($this->CryptoSecurity->decrypt(base64_decode($cms_pages->phone),SEC_KEY).'(deleted-'.time().')',SEC_KEY));
        $cms_pages->is_shown = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The User has been deleted.'));
        return $this->redirect(['action'=>'index']);

    }

    public function active($id=null)
    {
        $Cms_pages = TableRegistry::get('Users');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 1;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Users has been activated.'));
        return $this->redirect(['action'=>'index']);
    }

    public function deactive($id=null)
    {
        $Cms_pages = TableRegistry::get('Users');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Users has been deactivated.'));
        return $this->redirect(['action'=>'index']);
    }

    public function useractivity(){

          ini_set('memory_limit', '-1');
          $this->viewBuilder()->setLayout('admin');
          $session= $this->request->session();

           $conditions = array("Date(UserActivities.timestamp)" => date('Y-m-d'));
           if ($this->request->is(['patch', 'post', 'put']))
           {
             
             $session->write("Searchfilter", $this->request->data);
             $filterType = $this->request->data['file_type'];

             if ($session->check('Searchfilter.file_type') && $session->read('Searchfilter.file_type') == '1') {            
                $conditions = array("Date(UserActivities.timestamp)" => date('Y-m-d'));
             }
             elseif ($session->check('Searchfilter.file_type') && $session->read('Searchfilter.file_type') == '2') {            
                $conditions = array("Date(UserActivities.timestamp) >" => date('Y-m-d', strtotime("-7 days")));
             }
             elseif ($session->check('Searchfilter.file_type') && $session->read('Searchfilter.file_type') == '3') {
                 
                 $conditions = array("Date(UserActivities.timestamp) >" => date('Y-m-00'));                 
             }
             elseif ($session->check('Searchfilter.file_type') && $session->read('Searchfilter.file_type') == '4') {
                 $conditions = array("Date(UserActivities.timestamp) >" => date('Y-m-d', strtotime("-1 month")));
                 # code...
             }
             elseif ($session->check('Searchfilter.file_type') && $session->read('Searchfilter.file_type') == '5') {

                  $conditions = array("Date(UserActivities.timestamp) >" => date('Y-m-d', strtotime("-2 month")));
                 
             }

             // if($filterType == 1)
             // {                
             //    $conditions = array("Date(UserActivities.timestamp)" => date('Y-m-d'));
             // }   
             // elseif ($filterType == 2) 
             // {
             //    $conditions = array("Date(UserActivities.timestamp) >" => date('Y-m-d', strtotime("-7 days")));
             // }
             // elseif($filterType == 3)
             // {
             //    $conditions = array("Date(UserActivities.timestamp) >" => date('Y-m-00'));
             // }
             // elseif($filterType == 4)
             // {
             //    $conditions = array("Date(UserActivities.timestamp) >" => date('Y-m-d', strtotime("-1 month")));
             // }
             // elseif($filterType == 5)
             // {
             //    $conditions = array("Date(UserActivities.timestamp) >" => date('Y-m-d', strtotime("-3 month")));
             // }                  
           }
          $userActivityObj = $this->loadModel('UserActivities');
          $userActivityData = $userActivityObj->find('all')->contain('users')->where(['is_shown' =>1, $conditions])->order(['UserActivities.id' =>'desc'])->toArray();
          $this->set(array('userActivityData' => $userActivityData,'session' =>$session));
    }

    public function timetracking()
    {
      ini_set('memory_limit', '-1');
      $this->viewBuilder()->setLayout('admin');
      $userTimeObj = $this->loadModel('TimeManagement');
      $userTimeData = $userTimeObj->find('all')->contain('users')->where(['is_shown' =>1])->order(['TimeManagement.id' =>'desc'])->toArray();
      $this->set(array('userTimeData' => $userTimeData));
    }





}
