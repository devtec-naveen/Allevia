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
class ZipController extends AppController
{

    public function initialize()
    {
    parent::initialize();
      $this->loadComponent('Paginator');
      $this->loadModel('ZipCodes');
    }

    public function index()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $zipcodes = $this->paginate($this->ZipCodes->find('all'));
        $this->set(compact('zipcodes'));
    }


    public function add()
    {
        $this->viewBuilder()->setLayout('admin');
        $ZipCodes = $this->ZipCodes->newEntity();
        if ($this->request->is('post')) { 
            $ZipCodes = $this->ZipCodes->patchEntity($ZipCodes, $this->request->getData());
            if ($this->ZipCodes->save($ZipCodes)) {
                $this->Flash->adminsuccess(__('Zip code has saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->adminerror(__('Zip code could not be saved. Please, try again.'));
        }
        $this->set(compact('ZipCodes'));
    }

   
    public function edit($id = null)
    {
        $id = base64_decode($id);
        $this->viewBuilder()->setLayout('admin');
        $ZipCodes = $this->ZipCodes->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $ZipCodes = $this->ZipCodes->patchEntity($ZipCodes, $this->request->getData());

            if ($this->ZipCodes->save($ZipCodes)) {
                $this->Flash->adminsuccess(__('Zip Code has  Updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->adminerror(__('Zip Code could not be saved. Please, try again.'));
        }
        $this->set(compact('ZipCodes'));
    }

    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $Cms = $this->Cms->find('all')->where(['id'=>$id])->first();
        $this->set('Cms', $Cms);
    }
    public function delete($id)
    {
        $zipCodeTbl = TableRegistry::get('zip_codes');
        $zipcode = $zipCodeTbl->get($id);

        if(!empty($zipCodeTbl->delete($zipcode)))
        {
            $this->Flash->adminsuccess(__('The Zip Code has been deleted.'));
            return $this->redirect($this->referer());
        }
    }


   





    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */  
}
