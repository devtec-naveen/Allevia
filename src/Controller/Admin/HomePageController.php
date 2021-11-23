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
class HomePageController extends AppController
{

    public function initialize()
    {
    parent::initialize();
      $this->loadComponent('Paginator');
    }




  public function valueprops()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
         $Cms_pages = TableRegistry::get('value_props');
        $organizations = $this->paginate($Cms_pages->find('all')->where(['is_shown' => 1]));
        $this->set(compact('organizations'));
       
    }

    public function addValueprops()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
            $Cms_pages = TableRegistry::get('value_props');
        $organizations = $Cms_pages->newEntity();
        if ($this->request->is('post')) {




    
            $organizations = $Cms_pages->patchEntity($organizations, $this->request->getData());

         if (!empty($this->request->data['image']['name'])) {
            $file = $this->request->data['image'];
            $setNewFileName = time() . "_" . $file['name'];
            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
            $organizations->image = $setNewFileName;
        }        
    
            if ($Cms_pages->save($organizations)) {
                $this->Flash->success(__('Value Props has saved.'));

                return $this->redirect(['action' => 'valueprops']);
            }
            $this->Flash->error(__('Value Props could not be saved. Please, try again.'));
        }
        $this->set(compact('organizations'));
       
    }

    public function editValueprops($id = null)
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
          $Cms_pages = TableRegistry::get('value_props');
        $organizations = $Cms_pages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->request->data['description'] = trim($this->request->data['description']);
            $Cms_pages->patchEntity($organizations, $this->request->getData());

                 if (!empty($this->request->data['image']['name'])) {
                    $file = $this->request->data['image'];
                    $setNewFileName = time() . "_" . $file['name'];
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                    $organizations->image = $setNewFileName;
                } else {
                    unset($organizations->image);
                }


            if ($Cms_pages->save($organizations)) {
                $this->Flash->success(__('Value Props page has  Updated.'));

                return $this->redirect(['action' => 'valueprops']);
            }
            $this->Flash->error(__('Value Props could not be saved. Please, try again.'));
        }
        $this->set(compact('organizations'));
       
    }
  public function deleteValueprops($id=null)
    {

        $Cms_pages = TableRegistry::get('value_props');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->is_shown = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Value Props has been deletd.'));
        return $this->redirect(['action'=>'valueprops']);

    }
    
    public function activeValueprops($id=null)
    {
        $Cms_pages = TableRegistry::get('value_props');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 1;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Value Props has been activated.'));
        return $this->redirect(['action'=>'valueprops']);
    }
    
    public function deactiveValueprops($id=null)
    {
        $Cms_pages = TableRegistry::get('value_props');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Value Props has been deactivated.'));
        return $this->redirect(['action'=>'valueprops']);
    }
    


    public function homepage(){

        $this->viewBuilder()->setLayout('admin');
        $this->loadModel('HomePage');

         $home_page = TableRegistry::get('HomePage');



         $homepagedata = $home_page->get(1);



        // pr($this->request->data); die; 

        if( !empty($this->request->data['homepage_sec4_tabletext']) && is_array($this->request->data['homepage_sec4_tabletext']) ){

            $this->request->data['homepage_sec4_tabletext'] = implode('###', $this->request->data['homepage_sec4_tabletext']) ; 

        }




         // pr($homepagedata); die; 

        if($this->request->is(['post', 'put'])){

            // pr($this->request->data); die;

            $home_page->patchEntity($homepagedata, $this->request->data);
            if(empty($homepagedata->errors())) {

                 if (!empty($this->request->data['homepage_sec1_img1']['name'])) {
                    $file = $this->request->data['homepage_sec1_img1'];
                    $setNewFileName = time() . "_" . $file['name'];
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                    $homepagedata->homepage_sec1_img1 = $setNewFileName;
                } else {
                    unset($homepagedata->homepage_sec1_img1);
                }

                 if (!empty($this->request->data['homepage_sec1_img2']['name'])) {
                    $file = $this->request->data['homepage_sec1_img2'];
                    $setNewFileName = time() . "_" . $file['name'];
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                    $homepagedata->homepage_sec1_img2 = $setNewFileName;
                } else {
                    unset($homepagedata->homepage_sec1_img2);
                }


                 if (!empty($this->request->data['homepage_sec1_img3']['name'])) {
                    $file = $this->request->data['homepage_sec1_img3'];
                    $setNewFileName = time() . "_" . $file['name'];
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                    $homepagedata->homepage_sec1_img3 = $setNewFileName;
                } else {
                    unset($homepagedata->homepage_sec1_img3);
                }


                if (!empty($this->request->data['homepage_sec2_img']['name'])) {
                    $file = $this->request->data['homepage_sec2_img'];
                    $setNewFileName = time() . "_" . $file['name'];
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                    $homepagedata->homepage_sec2_img = $setNewFileName;
                } else {
                    unset($homepagedata->homepage_sec2_img);
                }


                 if (!empty($this->request->data['homepage_sec3_image']['name'])) {
                    $file = $this->request->data['homepage_sec3_image'];
                    $setNewFileName = time() . "_" . $file['name'];
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                    $homepagedata->homepage_sec3_image = $setNewFileName;
                } else {
                    unset($homepagedata->homepage_sec3_image);
                }  



            if ($res = $home_page->save($homepagedata)) {

                $this->Flash->success('Data saved successfully.');
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error('Home page data could not be saved.');
            }                              


            } else {
                 $this->Flash->error('Home page data could not be saved.');
            }   









        }
        

/*
        homepage_sec1_main_title       
        homepage_sec1_img1
        homepage_sec1_subtitle1
        homepage_sec1_content1

        homepage_sec1_img2
        homepage_sec1_subtitle2
        homepage_sec1_content2

        homepage_sec1_img3
        homepage_sec1_subtitle3
        homepage_sec1_content3   

        homepage_sec2_maintitle
        homepage_sec2_img
        homepage_sec2_subtitle
        homepage_sec2_content

        homepage_embed_video_url


        homepage_sec3_maintitle
        homepage_sec3_image

        homepage_sec4_maintitle
        homepage_sec4_content
        homepage_sec4_tabletext                  

    */


        $this->set(compact('homepagedata'));




    }






  public function ourpartner()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
         $Cms_pages = TableRegistry::get('our_partners');
        $organizations = $this->paginate($Cms_pages->find('all')->where(['is_shown' => 1]));
        $this->set(compact('organizations'));
       
    }

    public function addOurpartner()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
            $Cms_pages = TableRegistry::get('our_partners');
        $organizations = $Cms_pages->newEntity();
        if ($this->request->is('post')) {




    
            $organizations = $Cms_pages->patchEntity($organizations, $this->request->getData());

         if (!empty($this->request->data['image']['name'])) {
            $file = $this->request->data['image'];
            $setNewFileName = time() . "_" . $file['name'];
            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
            $organizations->image = $setNewFileName;
        }        
    
            if ($Cms_pages->save($organizations)) {
                $this->Flash->success(__('Our Partner has saved.'));

                return $this->redirect(['action' => 'ourpartner']);
            }
            $this->Flash->error(__('Our Partner could not be saved. Please, try again.'));
        }
        $this->set(compact('organizations'));
       
    }

    public function editOurpartner($id = null)
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
          $Cms_pages = TableRegistry::get('our_partners');
        $organizations = $Cms_pages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $Cms_pages->patchEntity($organizations, $this->request->getData());

                 if (!empty($this->request->data['image']['name'])) {
                    $file = $this->request->data['image'];
                    $setNewFileName = time() . "_" . $file['name'];
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                    $organizations->image = $setNewFileName;
                } else {
                    unset($organizations->image);
                }


            if ($Cms_pages->save($organizations)) {
                $this->Flash->success(__('Our Partner page has  Updated.'));

                return $this->redirect(['action' => 'ourpartner']);
            }
            $this->Flash->error(__('Our Partner could not be saved. Please, try again.'));
        }
        $this->set(compact('organizations'));
       
    }
  public function deleteOurpartner($id=null)
    {

        $Cms_pages = TableRegistry::get('our_partners');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->is_shown = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Our Partner has been deletd.'));
        return $this->redirect(['action'=>'ourpartner']);

    }
    
    public function activeOurpartner($id=null)
    {
        $Cms_pages = TableRegistry::get('our_partners');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 1;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Our Partner has been activated.'));
        return $this->redirect(['action'=>'ourpartner']);
    }
    
    public function deactiveOurpartner($id=null)
    {
        $Cms_pages = TableRegistry::get('our_partners');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Our Partner has been deactivated.'));
        return $this->redirect(['action'=>'ourpartner']);
    }







  public function banner()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
         $Cms_pages = TableRegistry::get('banner');
        $organizations = $this->paginate($Cms_pages->find('all')->where(['is_shown' => 1]));
        $this->set(compact('organizations'));
       
    }

    public function addBanner()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
            $Cms_pages = TableRegistry::get('banner');
        $organizations = $Cms_pages->newEntity();
        if ($this->request->is('post')) {




    
            $organizations = $Cms_pages->patchEntity($organizations, $this->request->getData());

         if (!empty($this->request->data['image']['name'])) {
            $file = $this->request->data['image'];
            $setNewFileName = time() . "_" . $file['name'];
            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
            $organizations->image = $setNewFileName;
        }        
    
            if ($Cms_pages->save($organizations)) {
                $this->Flash->success(__('Our Partner has saved.'));

                return $this->redirect(['action' => 'banner']);
            }
            $this->Flash->error(__('Banner could not be saved. Please, try again.'));
        }
        $this->set(compact('organizations'));
       
    }

    public function editBanner($id = null)
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
          $Cms_pages = TableRegistry::get('banner');
        $organizations = $Cms_pages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $Cms_pages->patchEntity($organizations, $this->request->getData());

                 if (!empty($this->request->data['image']['name'])) {
                    $file = $this->request->data['image'];
                    $setNewFileName = time() . "_" . $file['name'];
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                    $organizations->image = $setNewFileName;
                } else {
                    unset($organizations->image);
                }


            if ($Cms_pages->save($organizations)) {
                $this->Flash->success(__('Banner  has  Updated.'));

                return $this->redirect(['action' => 'banner']);
            }
            $this->Flash->error(__('Banner could not be saved. Please, try again.'));
        }
        $this->set(compact('organizations'));
       
    }
  public function deleteBanner($id=null)
    {

        $Cms_pages = TableRegistry::get('banner');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->is_shown = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Banner has been deletd.'));
        return $this->redirect(['action'=>'banner']);

    }
    
    public function activeBanner($id=null)
    {
        $Cms_pages = TableRegistry::get('banner');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 1;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Banner has been activated.'));
        return $this->redirect(['action'=>'banner']);
    }
    
    public function deactiveBanner($id=null)
    {
        $Cms_pages = TableRegistry::get('banner');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Banner has been deactivated.'));
        return $this->redirect(['action'=>'banner']);
    }






    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */  
}
