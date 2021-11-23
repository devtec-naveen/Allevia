<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Controller\Component\PaginatorComponent;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Utility\Security;


/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class EmailTemplatesController extends AppController
{

    public function initialize()
    {
      parent::initialize();
      $this->loadComponent('Paginator');
      $this->loadComponent('ControllerList');
       $this->loadComponent('MailSend');
       $this->loadComponent('CryptoSecurity');
    }

    public function index()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $emailtemplates = $this->paginate($this->EmailTemplates);
        $this->set(compact('emailtemplates'));
       
    }


    public function sendemail()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $this->loadModel('Users');

        if($this->request->is(['post', 'put'])){

            // pr($this->request->data); die; 
            $user_id = $this->request->getData('user_id');
            // $subject = $this->request->getData('subject');
            $message = $this->request->getData('message');

            $user_list = $this->Users->find('all')->where(['id IN' => $user_id])->all();

            foreach ($user_list as $key => $value) {

                $first_name = "user";
                if(!empty($value->first_name)){

                  $first_name = $this->CryptoSecurity->decrypt(base64_decode($value->first_name), SEC_KEY);  
                }

                $last_name = "";
                if(!empty($value->last_name)){

                  $last_name = $this->CryptoSecurity->decrypt(base64_decode($value->last_name), SEC_KEY);  
                }

              $email_pattern = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{1,})+$/";
              $email = $this->CryptoSecurity->decrypt(base64_decode($value['email']),SEC_KEY);
                    
              if(!empty($email) && preg_match($email_pattern,trim($email))){


                $mailData = array();
                $mailData['slug'] = 'admin_email_template';
                $mailData['email'] = $email;
                $mailData['replaceString'] = array('{username}','{message}');
                $mailData['replaceData'] = array(h($first_name).' '.h($last_name),$message);
                try{

                  $this->MailSend->send( $mailData );
                }
                catch(\Exception $e){

                    echo  $this->Flash->adminsuccess(__('Something went wrong, Please try again'));
                    $this->redirect($this->referer());
                }
              }         
           
            }        
            echo  $this->Flash->adminsuccess(__('Email sent successfully.'));
            $this->redirect($this->referer());
        }

/*$users = $this->Users->find('list', [
            'keyField' => 'id',
            'valueField' => function ($e) {

                        $first_name = "";
                        if(!empty($e->first_name)){

                         // $first_name = $this->CryptoSecurity->decrypt(base64_decode($e->first_name), SEC_KEY);  
                        }

                        $last_name = "";
                        if(!empty($e->last_name)){

                          $last_name = $this->CryptoSecurity->decrypt(base64_decode($e->last_name), SEC_KEY);  
                        }

                         $email = $e->email;
                         if(!empty($email)){

                            //$email = $this->CryptoSecurity->decrypt(base64_decode($e->email), SEC_KEY); 
                         }                       

                        return h( $e->first_name). ' ' . h($last_name) . ' (' . $e->email.')';
                    }          
        ])->where(['id !=' => 1,'email !=' => "",'role_id !=' => 1])->toArray();*/

        $users_data = $this->Users->find('all')->where(['id !=' => 1,'email !=' => "",'role_id !=' => 1,'status' => 1])->toArray();
        $users = array();
        if(count($users_data)){

            foreach ($users_data as $key => $value) {
               
               $name = "";
               if(!empty($value['first_name'])){

                    $name .= $this->CryptoSecurity->decrypt(base64_decode($value['first_name']), SEC_KEY);
               }

               if(!empty($value['last_name'])){

                    $name .= " ".$this->CryptoSecurity->decrypt(base64_decode($value['last_name']), SEC_KEY);
               }

               if(!empty($value['email'])){

                    $name .= ' ('.$this->CryptoSecurity->decrypt(base64_decode($value['email']), SEC_KEY).')';
               }


               $users[$value['id']] = $name;
            }
        }

        //pr($users);die;
        $this->set(compact('users'));



       
    }

     public function add()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $emailtemplates = $this->EmailTemplates->newEntity();
        if ($this->request->is('post')) {
            $emailtemplates = $this->EmailTemplates->patchEntity($emailtemplates, $this->request->getData());
            if ($this->EmailTemplates->save($emailtemplates)) {
                $this->Flash->adminsuccess(__('E-mail Template has created.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->adminerror(__('Email Template could not be saved. Please, try again.'));
        }
        $this->set(compact('emailtemplates'));
       
    }

    public function edit($id = null)
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $emailtemplates = $this->EmailTemplates->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

          if(!empty($emailtemplates) && in_array($emailtemplates['slug'], ['forgot_password','user_registration','pre_appointment_form_link','pre_appointment_reminder','activate-account'])){

            if(empty($this->request->data['description']) || empty($this->request->data['text_message'])){

                $this->Flash->adminerror(__('Email Template description and text message is required.'));
                return $this->redirect($this->referer());  
            }
          }
            $emailtemplates = $this->EmailTemplates->patchEntity($emailtemplates, $this->request->getData());
            if ($this->EmailTemplates->save($emailtemplates)) {
                $this->Flash->adminsuccess(__('E-mail Template  has Updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->adminerror(__('Email Template could not be saved. Please, try again.'));
        }
        $this->set(compact('emailtemplates'));
       
    }

    public function view($id = null)
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $emailtemplates = $this->EmailTemplates->get($id, [
            'contain' => []
            ]);

        $this->set('emailtemplates', $emailtemplates);
       
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */  
}
