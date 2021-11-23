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
class SpecializationsController extends AppController
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
        $organizations = $this->paginate($this->Specializations->find('all')->where(['is_shown' => 1])->order(['id' => 'DESC']));
        $this->set(compact('organizations'));
       
    }

    public function add()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $organizations = $this->Specializations->newEntity();
        if ($this->request->is('post')) {
            
            $organizations = $this->Specializations->patchEntity($organizations, $this->request->getData());
            if ($this->Specializations->save($organizations)) {
                $this->Flash->success(__('Specialization has saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Specialization could not be saved. Please, try again.'));
        }
        $this->set(compact('organizations'));
       
    }

    public function edit($id = null)
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $organizations = $this->Specializations->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $organizations = $this->Specializations->patchEntity($organizations, $this->request->getData());
            if ($this->Specializations->save($organizations)) {
                $this->Flash->success(__('Specialization page has  Updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Specialization could not be saved. Please, try again.'));
        }
        $this->set(compact('organizations'));
       
    }

    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $organizations = $this->Specializations->find('all')->where(['id'=>$id])->first();
        $this->set('organizations', $organizations);
    }

    public function addSteps($id = null) {

          $this->viewBuilder()->setLayout('admin');


        $this->loadModel('StepDetails');
        $step_detial = $this->StepDetails->find('all');

          if($this->request->is(['post','put'])){

            $steps = $this->request->getData('steps');

            if(!empty($steps) && is_array($steps)){
                $steps = implode(',', $steps); 
                $this->Specializations->query()
                                        ->update()
                                        ->set(['intermediate_steps' => $steps])
                                        ->where(['id' => $id])
                                        ->execute();
               $this->Flash->success(__('Steps saved successfully.'));

            }


          }
          $inputsteps = array(); 
          $steps = $this->Specializations->find('all')->where(['id'=>$id])->first(); 
          if(!empty($steps->intermediate_steps)){
            $inputsteps = explode(',', $steps->intermediate_steps) ; 
         
          }
          $this->set(compact('inputsteps', 'step_detial'));


    }


    public function substeps() {

          $this->viewBuilder()->setLayout('admin');
          $this->loadModel('StepDetails');
          $step_detail = $this->StepDetails->find('all');
          $this->set(compact('step_detail'));
    }


        public function addSubsteps($id = null) {

// 1 - Chief complaint, 2- chief complaint details, 3- associated symptoms , 4- health questionnaire ,5- summary

          $this->loadModel('StepDetails');
          $this->viewBuilder()->setLayout('admin');

          if($this->request->is(['post','put'])){

            $steps = $this->request->getData('substeps');

            if(!empty($steps) && is_array($steps)){
                $steps = implode(',', $steps); 
                $this->StepDetails->query()
                                        ->update()
                                        ->set(['next_steps' => $steps])
                                        ->where(['id' => $id])
                                        ->execute();
               $this->Flash->success(__('Substeps saved successfully.'));

            }


          }
          $inputsteps = array(); 
          $steps = $this->StepDetails->find('all')->where(['id'=>$id])->first(); 
          if(!empty($steps->next_steps)){
            $inputsteps = explode(',', $steps->next_steps) ; 
         
          }
          $this->set(compact('inputsteps'));



        }
    
    public function delete($id=null)
    {

        $Cms_pages = TableRegistry::get('Specializations');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->is_shown = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Specialization has been deletd.'));
        return $this->redirect(['action'=>'index']);

    }
    
    public function active($id=null)
    {
        $Cms_pages = TableRegistry::get('Specializations');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 1;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Specialization has been activated.'));
        return $this->redirect(['action'=>'index']);
    }
    
    public function deactive($id=null)
    {
        $Cms_pages = TableRegistry::get('Specializations');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Specialization has been deactivated.'));
        return $this->redirect(['action'=>'index']);
    }
    




   
}
