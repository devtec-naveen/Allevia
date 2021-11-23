<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Cake\TestSuite\TestCase;
use Cake\Core\App;

class CmsControllerTest extends IntegrationTestCase
{   

    public $fixtures = ['app.Cms']; 


    private function loginAsAdmin() {
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $user = $this->Users->get(1);
        
        $this->session(['Auth.User'=> $user->toArray()]);
    }

    // public function testLoginAsAdmin(): void
    // {
    //     $this->loginAsAdmin();
        
    //     $this->get('/admin/dashboard');    
        
    //     $this->assertSession(1, 'Auth.User.id'); //check if the user is logged in

    // }

    


  //   public function loggedIn() {
  //   return self::$_session->read(self::$sessionKey) != array();
  // }

    // public function __construct(){

    //     $users = TableRegistry::getTableLocator()->get('users');        
    //     $query = $users->find()->where(['id' => 1])->first()->toArray();
    //     //pr($query);die;
    //     //$this->Auth->setUser($query);
    //     // Set session data
    //     $this->session([
    //         'Auth' => [
    //             'User' => $query
    //         ]
    //     ]);
    // }

    /*public function testAddUnauthenticatedFails()
    {
        // No session data set.
        $this->get('/admin/cms');

        $this->assertRedirect(['controller' => 'Users', 'action' => 'login','prefix' => 'admin']);
    }*/
  

    /*public function testIndex()
    {       

        $this->get('/admin/cms',[]);
        $this->assertResponseOk();
        //$this->assertResponseSuccess();
        // More asserts.
    }*/

    public function testIndexQueryData()
    {
        $this->loginAsAdmin();
        $this->get('/admin/cms');
       // $this->assertresponse(200); 
        $this->assertResponseOk();
        //$this->assertResponseSuccess();
        //$this->assertnotext("error:"); 
        // More asserts.
    }  

    public function testAdd()
    {       
        $this->loginAsAdmin(); 
        $data = [
                'id' =>'20',
                'title' => 'First Article naveen',
                'menu_display_title' => 'Second Article Body',
                'menu_type' => 1,
                "slug" => "test",
                "content" => "ddsg",
                "image" => 'xxc',
                "video_url" => "hc",
                "bottom_content" => 'fdgdfg',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
        ];
        $this->post('/admin/cms/add', $data);

        //$this->assertResponseSuccess();

        $cms = TableRegistry::getTableLocator()->get('cms');        
        $query = $cms->find()->where(['title' => $data['title']]);
        
        
        $this->assertEquals(1, $query->count());
    }

    // public function testBasicAuthentication()
    // {
    //     $this->configRequest([
    //         'environment' => [
    //             'PHP_AUTH_USER' => 'allevia@mailinator.com',
    //             'PHP_AUTH_PW' => '12345678',
    //         ]
    //     ]);

    //     $this->get('/admin/cms/view');
    //     $this->assertResponseOk();
    // }

}


?>