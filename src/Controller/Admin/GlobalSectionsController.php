<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Controller\Component\PaginatorComponent;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;



/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class GlobalSectionsController extends AppController
{

    public function initialize()
    {
      parent::initialize();
      $this->loadComponent('Paginator');
    }

    public function index()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        // $global_settings    =   $this->GlobalSections->find('all')->contain(['global_settings'])->toArray();
        $this->loadModel('GlobalSettings');

        if($this->request->is(['post','put'])){

 // favicon_image   logo_image  footer_logo_image

             if (!empty($this->request->data['footer_logo_image']['name'])) {
                $file = $this->request->data['footer_logo_image'];
                $setNewFileName = time() . "_" . $file['name'];
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                // $data->favicon_image = $setNewFileName;
                $this->request->data['footer_logo_image'] = $setNewFileName ;
            } else {
                unset($this->request->data['footer_logo_image']);
            } 


             if (!empty($this->request->data['favicon_image']['name'])) {
                $file = $this->request->data['favicon_image'];
                $setNewFileName = time() . "_" . $file['name'];
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                // $data->favicon_image = $setNewFileName;
                $this->request->data['favicon_image'] = $setNewFileName ;
            } else {
                unset($this->request->data['favicon_image']);
            }  
            
             if (!empty($this->request->data['logo_image']['name'])) {
                $file = $this->request->data['logo_image'];
                $setNewFileName = time() . "_" . $file['name'];
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                // $data->logo_image = $setNewFileName;
                $this->request->data['logo_image'] =  $setNewFileName; 
            } else {
                unset($this->request->data['logo_image']);
            }                    

          $inputdata = $this->request->data ; 
      
          foreach($inputdata as $key => $val){

            $this->GlobalSettings->query()
                    ->update()
                    ->set(['value' => $val])
                    ->where(['slug' => $key])
                    ->execute();

          }

           $this->Flash->success(__('Saved Successfully.'));


        }



$global_settings    =   $this->GlobalSettings->find('all')->toArray();

        // pr($global_settings); die; 
        $this->set(compact('global_settings'));
    }

     public function global_update(){
        $this->autoRender('false');
        $global_settings = TableRegistry::get('global_settings');

           if ($this->request->is(['post', 'put'])) {

            $globaldata = $global_settings->find('all')->where(['slug' => $this->request->data['slug']])->first();
            $globaldata->value = $this->request->getData('value');
           if ($global_settings->save($globaldata)) {
                $this->Flash->adminsuccess(__($globaldata['title'].'is updated'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->adminerror(__('Settings could not be saved. Please, try again.'));
            
        }



     }

}
