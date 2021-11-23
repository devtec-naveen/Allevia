<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Email\Email;

class PagesController extends AppController
{
    public $prefix = '';
    public function initialize()
    {

        parent::initialize();
        $this->prefix = Configure::read('iframe_prefix');
        $this->viewBuilder()->setLayout('front');
    }
    public function beforeFilter(Event $event)
    {
       //parent::beforeFilter($event);

     $this->Auth->allow(['chiefComplaintDetail','pageNotFound','reports']);
        
        
    }

    public function display(...$path)
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    public function home()
    {
        //$this->viewBuilder()->setLayout('front');
        $home_page = TableRegistry::get('HomePage');
        $value_props = TableRegistry::get('value_props');
        $our_partners = TableRegistry::get('our_partners');
        $banner = TableRegistry::get('banner');
        $banner_data = $banner->find('all')->where(['status' => 1, 'is_shown' => 1]);
        $value_props_data = $value_props->find('all')->where(['is_shown' => 1, 'status' => 1]);
        $our_partners_data = $our_partners->find('all')->where(['is_shown' => 1, 'status' => 1]);
        $homepagedata = $home_page->get(1);
        $this->set(compact('homepagedata', 'value_props_data', 'banner_data', 'our_partners_data'));
    }

    public function aboutUs(){
        
        // $this->viewBuilder()->setLayout('front');
        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'aboutus'])->first(); 

        $this->set(compact('aboutus_data'));

    }

    public function contactUs(){

            //$this->viewBuilder()->setLayout('front');
            if($this->request->is(['post'])){
                // pr($this->request->data); die; 
                $name = $this->request->getData('name'); 
                $email = $this->request->getData('email'); 
                $contact_subject = $this->request->getData('subject'); 
                $message = $this->request->getData('message'); 
                $contatus_with_role = $this->request->getData('contatus_with_role'); 

                $template = TableRegistry::get('email_templates');
                $query2 = $template->find('all')->where(['slug' => 'contact_us']);
                $template = $query2->first();
                    $title = $template->name;
                $subject = $template->subject;
                $description = $template->description;

                $admin_email = "admin@allevia.com"; 
               // pr($admin_email);die;

               $mailMessage = str_replace(array('{name}','{userrole}', '{email}', '{subject}', '{message}'), array($name, $contatus_with_role, $email, $contact_subject, $message), $description);
               
                $email = new Email('default');
                $email->emailFormat('html')->to($admin_email)->from([$admin_email => 'Allevia Team'])->subject($subject)->emailFormat('html')->send($mailMessage);
                $this->Flash->success(__('Successfully submitted your details and an email is also sent to the admin.'));
                return $this->redirect($this->referer());


        }


        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'contactus'])->first(); 

        $this->set(compact('aboutus_data'));

    }

    public function services(){
         //$this->viewBuilder()->setLayout('front');
        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'services'])->first(); 

        $this->set(compact('aboutus_data'));

    }

    public function howItWorks(){
        // $this->viewBuilder()->setLayout('front');
        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'how_it_works'])->first(); 

        $this->set(compact('aboutus_data'));
    }


    public function privacyPolicy(){
        //$this->viewBuilder()->setLayout('front');
        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'privacy-policy'])->first(); 

        $this->set(compact('aboutus_data'));
     }

     public function termsConditions(){
        //$this->viewBuilder()->setLayout('front');
        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'terms-conditions'])->first(); 

        $this->set(compact('aboutus_data'));        
        
     }



     public function forPatients(){
        //$this->viewBuilder()->setLayout('front');
        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'for-patients'])->first(); 

        $this->set(compact('aboutus_data'));        
        
     }
        public function forProviders(){
        //$this->viewBuilder()->setLayout('front');
            $cmsTable = TableRegistry::get('cms');
            $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'for-providers'])->first(); 

            $this->set(compact('aboutus_data'));        
        
        }
    public function forPayors(){
        //$this->viewBuilder()->setLayout('front');
        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'for-payors'])->first();
        $this->set(compact('aboutus_data'));        
        
     }
    public function phiAuthorization(){
        //$this->viewBuilder()->setLayout('front');
        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'phi-authorization'])->first(); 

        $this->set(compact('aboutus_data'));        
        
     }     
    public function faq(){
        //$this->viewBuilder()->setLayout('front');
        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => 'faq'])->first(); 

        $this->set(compact('aboutus_data'));        
        
     }

    public function cms($slug = null){
// pr($slug); die; 
       // $this->viewBuilder()->setLayout('front');
        if($slug == 'aboutus'){
            return $this->redirect(['action' => 'aboutUs', 'prefix' => $this->prefix]);

        }else if($slug == 'contactus'){
             return $this->redirect(['action' => 'contactUs', 'prefix' => $this->prefix]);
        }
        $cmsTable = TableRegistry::get('cms');
        $aboutus_data =   $cmsTable->find('all')->where(['slug' => $slug])->first(); 

        $this->set(compact('aboutus_data'));        
        
     }


     public function chiefComplaintDetail(){
        //$this->viewBuilder()->setLayout('front');
     } 

    public function pageNotFound(){
        //$this->viewBuilder()->setLayout('front');
    }   

    public function reports(){

    }
}
