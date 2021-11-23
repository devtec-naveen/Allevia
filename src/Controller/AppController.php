<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Routing\DispatcherFilter;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {  
        parent::initialize();
        //pr($this->request->host());die;
        
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('General');
        $this->loadComponent('Auth', [
           'authError'    => 'Please sign in again.',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
             //use isAuthorized in Controllers
            'authorize' => ['Controller'],
             // If unauthorized, return them to page they were just on
            'unauthorizedRedirect' =>[
                'controller' => 'Users',
                'action' => 'login'
            ],
        'logoutRedirect'       => [
                'controller' => 'Users',
                'action'     => 'login'
        ],
        'loginRedirect'       => [
                'controller' => 'Users',
                'action'     => 'dashboard'
        ] 
        ]);

        $authUser = ($this->Auth->user()) ? ($this->Auth->user()) : [];
        // pr($authUser);exit;
        // Configure::write('Auth.authError', 'Did you really think you are allowed to see that?');
        $this->loadModel('Organizations') ; 
        if(!empty($authUser['organization_id'])){
        $authUser['organization_id'] = $this->Organizations->find('all')->where(['id' => $authUser['organization_id'] ])->first();
    }
        // pr($authUser);  die; 
        $this->set(compact("authUser"));

        $global_settings = TableRegistry::get('global_settings');
        $allsettings    =   $global_settings->find('list', ['keyField' => 'slug','valueField' => 'value'])->toArray();
        $this->set(compact("allsettings"));



     $all_cms_page = TableRegistry::get('cms');
        $all_cms_page    =   $all_cms_page->find('all')->toArray();
        $this->set(compact("all_cms_page"));


  $cms_table = TableRegistry::get('cms');
        $cms_page_arr    =   $cms_table->find('list', ['keyField' => 'slug','valueField' => 'menu_display_title'])->toArray();
        $this->set(compact("cms_page_arr"));

// $session = $this->getRequest()->getSession();

// $name = $session->read('User.name');
// print_r($name);exit;
        // $clinic_color_scheme = array(); 
// pr($authUser); die; 

//         if(!empty($authUser) && !empty($authUser['organization_id'])){
//             // pr($authUser); die; 
// $clinic_color_scheme['heading_color'] = isset($authUser['organization_id']['heading_color']) ?  $authUser['organization_id']['heading_color'] : '' ; 
// $clinic_color_scheme['background_color'] = isset($authUser['organization_id']['background_color']) ? $authUser['organization_id']['background_color'] : '' ; 
// $clinic_color_scheme['dashboard_background_color'] = isset($authUser['organization_id']['dashboard_background_color']) ? $authUser['organization_id']['dashboard_background_color'] : '' ; 
// $clinic_color_scheme['text_color'] = isset($authUser['organization_id']['text_color']) ? $authUser['organization_id']['text_color'] : '' ; 
// $clinic_color_scheme['button_gradient_color1'] = isset($authUser['organization_id']['button_gradient_color1']) ? $authUser['organization_id']['button_gradient_color1'] : '' ; 
// $clinic_color_scheme['button_gradient_color2'] = isset($authUser['organization_id']['button_gradient_color2']) ? $authUser['organization_id']['button_gradient_color2'] : '' ; 
// $clinic_color_scheme['button_gradient_color3'] = isset($authUser['organization_id']['button_gradient_color3']) ? $authUser['organization_id']['button_gradient_color3'] : '' ; 

// $clinic_color_scheme['active_button_color'] = isset($authUser['organization_id']['active_button_color']) ? $authUser['organization_id']['active_button_color'] : '' ; 

// $clinic_color_scheme['hover_state_color'] = isset($authUser['organization_id']['hover_state_color']) ? $authUser['organization_id']['hover_state_color'] : '' ; 
// $clinic_color_scheme['active_state_color'] = isset($authUser['organization_id']['active_state_color']) ? $authUser['organization_id']['active_state_color'] : '' ; 


// $clinic_color_scheme['link_color'] = isset($authUser['organization_id']['link_color']) ? $authUser['organization_id']['link_color'] : '' ; 
// $clinic_color_scheme['link_hover_color'] = isset($authUser['organization_id']['link_hover_color']) ? $authUser['organization_id']['link_hover_color'] : '' ; 

// $clinic_color_scheme['appoint_box_bg_color'] = isset($authUser['organization_id']['appoint_box_bg_color']) ? $authUser['organization_id']['appoint_box_bg_color'] : '' ; 
//         }
// pr($clinic_color_scheme); die; 

           if(!empty($authUser))
        {  
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                
            }
            else
            {    
            $url = $_SERVER['HTTP_HOST'].$this->request->here();
            $this->General->userActivity(['action_performed' => 5, 'user_id' => $this->Auth->user('id'), 'url' =>$url]);
            }
        }  

// $session = $this->getRequest()->getSession();
// // $name = $session->read('User.name');
// $session->write([
//   'clinic_color_scheme' => $clinic_color_scheme 
// ]);

        $url_detail = explode("/", trim($_SERVER['REQUEST_URI']));
        $iframe_prefix = isset($url_detail[2]) && $url_detail[2] == 'services' ? $url_detail[2] : false;
        Configure::write('iframe_prefix',$iframe_prefix);
        // Allow the display action so our PagesController
        // continues to work. Also enable the read only actions.
        $this->Auth->allow(['forgotPassword', 'login', 'resetPassword','logout','home', 'aboutus', 'contactus', 'services', 'howItWorks', 'termsConditions', 'privacyPolicy', 'forgotpassword', 'forPatients', 'forProviders', 'forPayors', 'phiAuthorization', 'faq', 'cms']);
  
       
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }




    public function isAuthorized($user)
    {
      //pr($user);die;
        // By default deny access.
        if($this->request->getParam('prefix') == 'admin'){
             if($this->Auth->user('role_id') == 1){
                return true;
             }else{
                return false;
            }   
        }
        elseif($this->request->getParam('prefix') == 'providers'){

          //pr($this->Auth->user());die;
             if($this->Auth->user('role_id') == 3 && $this->Auth->user('is_shown') == 1){
                return true;
             }else{
                return false;
            }   
        }
        elseif($this->request->getParam('prefix') == 'organizations'){

          //pr($this->Auth->user());die;
             if($this->Auth->user('role_id') == 4){
                return true;
             }else{
                return false;
            }   
        }

        else {

             if($this->Auth->user('role_id') == 1){
                return false;
             }else{
                return true;
            }  
        }
        return true;
    }

    public function beforeFilter(Event $event)
    {

        $dataList = TableRegistry::get('global_settings'); 
        $data = $dataList->find('all')->toArray();
    
        foreach($data as $key => $value )
        {
          Configure::write('App.'.$value->slug,$value->value);
        }
   
    }
    
}
