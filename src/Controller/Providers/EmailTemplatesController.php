<?php
namespace App\Controller\Providers;

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
      //$this->loadComponent('ControllerList');
        //$this->loadComponent('MailSend');
    }

    public function index()
    {   
        $login_user = $this->Auth->user();
        $this->viewBuilder()->setLayout('provider');
        $this->loadModel('ProviderEmailTemplates');
       
        $emailtemplates = $this->ProviderEmailTemplates->find('all')->where(['provider_id' => $login_user['id']])->toArray();
       
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
                         
           $mailData = array();
           $mailData['slug'] = 'admin_email_template';
           $mailData['email'] = $value->email;
           $mailData['replaceString'] = array('{username}','{message}');
           $mailData['replaceData'] = array(h(Security::decrypt(base64_decode($value->first_name), SEC_KEY)).' '.h(Security::decrypt(base64_decode($value->last_name), SEC_KEY)),$message);
      
      
        //pr($mailData); die;
      
          $this->MailSend->send( $mailData );
            }

        
          echo  $this->Flash->adminsuccess(__('Email sent successfully.'));
         $this->redirect($this->referer());

        }




$users = $this->Users->find('list', [
            'keyField' => 'id',
            'valueField' => function ($e) {
                        return h(Security::decrypt(base64_decode($e->first_name), SEC_KEY)) . ' ' . h(Security::decrypt(base64_decode($e->last_name), SEC_KEY)) . ' (' . $e->email.')';
                    }          
        ])->where(['id !=' => 1])->toArray();

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
        $this->viewBuilder()->setLayout('provider');
        $this->loadModel('ProviderEmailTemplates');
        $emailtemplates = $this->ProviderEmailTemplates->get(base64_decode($id), [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            //pr($this->request->data());die;
            if(empty($this->request->data['description']) || empty($this->request->data['text_message'])){

                $this->Flash->providererror(__('Email Template description and text message is required.'));
                return $this->redirect($this->referer());  
            }
            $emailtemplates = $this->ProviderEmailTemplates->patchEntity($emailtemplates, $this->request->getData());
            if ($this->ProviderEmailTemplates->save($emailtemplates)) {
                $this->Flash->providersuccess(__('E-mail Template  has Updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->providererror(__('Email Template could not be saved. Please, try again.'));
        }
        $this->set(compact('emailtemplates'));
       
    }

    public function view($id = null)
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('provider');
        $this->loadModel('ProviderEmailTemplates');
        $emailtemplates = $this->ProviderEmailTemplates->get(base64_decode($id), [
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
