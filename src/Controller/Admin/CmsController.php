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
class CmsController extends AppController
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
        $Cms = $this->paginate($this->Cms->find('all'));
        $this->set(compact('Cms'));
    }


    public function add()
    {
        $this->viewBuilder()->setLayout('admin');
        $Cms = $this->Cms->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['slug'] = $this->slugify($this->request->data['title']);
            $this->request->data['menu_type'] = !empty($this->request->data['menu_type']) && is_array($this->request->data['menu_type']) ? implode(',', $this->request->data['menu_type']) : '' ; 
            $Cms = $this->Cms->patchEntity($Cms, $this->request->getData());
            if ($this->Cms->save($Cms)) {
                $this->Flash->adminsuccess(__('Cms page has saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->adminerror(__('Cms page could not be saved. Please, try again.'));
        }
        $this->set(compact('Cms'));
    }

   
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $Cms = $this->Cms->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->request->data['menu_type'] = !empty($this->request->data['menu_type']) && is_array($this->request->data['menu_type']) ? implode(',', $this->request->data['menu_type']) : '' ; 
            
            $Cms = $this->Cms->patchEntity($Cms, $this->request->getData());



                 if (!empty($this->request->data['image']['name'])) {
                    $file = $this->request->data['image'];
                    $setNewFileName = time() . "_" . $file['name'];
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                    $Cms->image = $setNewFileName;
                } else {
                    unset($Cms->image);
                }



            if ($this->Cms->save($Cms)) {
                $this->Flash->adminsuccess(__('Cms page has  Updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->adminerror(__('Cms page could not be saved. Please, try again.'));
        }
        $this->set(compact('Cms'));
    }

    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $Cms = $this->Cms->find('all')->where(['id'=>$id])->first();
        $this->set('Cms', $Cms);
    }


      public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        //$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }


        // check slug exist in database
        $slugdata = $this->Cms->find('all')->where(['slug'=>$text])->first();
        if($slugdata) {
            $text =     $text.'-'.rand(10,100);
        }  
        return $text;
    }


   





    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */  
}
