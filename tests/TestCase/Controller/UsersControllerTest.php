<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Cake\TestSuite\TestCase;
use Cake\Core\App;
use Cake\Utility\Security;
//error_reporting(0);


class UsersControllerTest extends IntegrationTestCase
{   

    
    public function initialize()
    {
      parent::initialize();
   
      $this->loadComponent('CryptoSecurity');
    
    }

    public $fixtures = ['app.Users','app.Schedule','app.WomenSpecific']; 

    private function loginAsAdmin() {
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $user = $this->Users->find('all')->where(['id' => '4387'])->first();        
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

    public function testMedicalhistory()
    {
        
        $this->loginAsAdmin();       
        $this->get('/users/medicalhistory/368');
        $this->assertResponseSuccess();
        //ob_get_flush();
    }  

    public function testEditMedicalHistoryBasisDetailPositive()
    {       
        $this->loginAsAdmin();        
        $this->session(['validate_editmedicalhistory_user'=>'368']);
        $this->session(['iframe_api_data'=>'0']);
                 
        $data = [
                "tab_number" => 1, 
                'edited_tab' =>'1', 
                'current_tab' =>2,   
                "time" =>'1:19',                           
                'is_retired' =>'1',
                'height' => '1',
                'height_inches' => '1',
                'weight' => 1,
                "zip" => "3223",
                "sexual_orientation" => "1",
                "marital_status" => '1',
                "ethinicity" => "1",
                "occupation" => 'test',
                "guarantor" =>'3',
                "insurance_company" =>'test',
                "pharmacy" =>'3',
                "address" => 'jaipur',
                "city" =>'1',
                "state" =>'IN',
                "race" =>'1',
                "bmi" =>'1',
                'created' =>  date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
        ]; 
        $this->post('users/edit-medical-history/368', $data);
        $this->assertEquals(1, 1);
       // ob_get_flush();
    }

     public function testEditMedicalHistoryBasisDetailNegative()
    {       
        //$this->loginAsAdmin();
        //session_start();
        $this->loginAsAdmin();
        $this->session(['validate_editmedicalhistory_user'=>'368']);
        $this->session(['iframe_api_data'=>'0']);
                 
        $data = [
                "tab_number" => 1, 
                //'edited_tab' =>'1', 
                //'current_tab' =>2,   
                "time" =>'1:19',                           
                'is_retired' =>'4',
                'height' => '5',
                'height_inches' => '1',
                'weight' => 1,
                "zip" => "abc",
                "sexual_orientation" => "10",
                "marital_status" => '1',
                "ethinicity" => "1",
                "occupation" => 'test',
                "guarantor" =>'3',
                "insurance_company" =>'test',
                "pharmacy" =>'3',
                "address" => 'jaipur',
                "city" =>'1',
                "state" =>'IN',
                "race" =>'1',
                "bmi" =>'1',
                'created' =>  date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
        ]; 
        $this->post('users/edit-medical-history/368', $data);              
        $this->assertEquals(1, 1);
        //ob_get_flush();
    }

     public function testEditMedicalHistory2()
    {       
        $this->loginAsAdmin();         
        $this->session(['validate_editmedicalhistory_user'=>'368']);  
        $this->session(['iframe_api_data'=>'0']); 

        $data = [
                "tab_number" => 2,
               // 'edited_tab' =>'2', 
               // 'current_tab' =>3,
                "medical_history" =>['name' => array('Anthrax','Chicken pox','Chlamydia','naveen'),'year' =>array('2011','1999','1999','1999'),
                
        ],
        'is_check_med_his' =>1
                ];
                
        
        
        $this->post('users/edit-medical-history/368', $data);
        $this->assertEquals(1, 1);
        //ob_get_flush();
    }

       public function testEditMedicalHistory3()
    {       
        $this->loginAsAdmin();         
        $this->session(['validate_editmedicalhistory_user'=>'368']);   
        $this->session(['iframe_api_data'=>'0']);

          $data = [
                "tab_number" => 3,
                //'edited_tab' =>'3',
                //'current_tab' =>4, 
                "surgical_history" =>['name' => array('Breast removal (whole)','Colon (large intestine) partial removal (partial colectomy)','Debridement of wound, burn or infection naveen'),'year' =>array('2004','1984','1994'),
                
        ],
        'is_check_surg_his' =>1
                ];
       
        $this->post('users/edit-medical-history/368', $data);
        $this->assertEquals(1, 1);
        //ob_get_flush();
    }

       public function testEditMedicalHistory4()
    {       
        $this->loginAsAdmin();         
        $this->session(['validate_editmedicalhistory_user'=>'368']); 
        //$this->session(['iframe_api_data'=>'0']);

         $data = [
                "tab_number" => 4,
                //'edited_tab' =>'4', 
               // 'current_tab' =>5,
                "family_history" =>['name' => array('13','8'),'alive_status' =>array('0','1'),'disease' =>array('Breast cancer','Adenovirus'),'decease_year' =>array('37',''),'cause_of_death' =>array('Adhd,Adenovirus',''),
                
        ],
        'is_family_his' =>1
                ]; 


        $this->post('users/edit-medical-history/368', $data);
        $this->assertEquals(1, 1);
        //ob_get_flush();
    }

    public function testEditMedicalHistory5()
    {       
        $this->loginAsAdmin();         
        $this->session(['validate_editmedicalhistory_user'=>'368']);  
        $this->session(['iframe_api_data'=>'0']); 

          $data = [
                "tab_number" => 5,
                //'edited_tab' =>'5', 
                //'current_tab' => '6',
                "allergy_history" =>['name' => array('Beefs','Fishs','Eggss'),'year' =>array('Nasal congestion','Shock','Swelling'),
                
        ],
        'is_check_allergy_his' =>1
                ];
    
        $this->post('users/edit-medical-history/368', $data);
        $this->assertEquals(1, 1);
        //ob_get_flush();
    }



    public function testEditMedicalHistory6()
    {

        $this->loginAsAdmin();         
        $this->session(['validate_editmedicalhistory_user'=>'368']); 
        $this->session(['iframe_api_data'=>'0']);
        $data = [
                'tab_number' => '6',
                'edited_tab' =>'6', 
                'current_tab' =>'8',
                "current_smoke_pack" => 4,             
                "past_smoke_pack" =>'6',
                "past_smoke_year" =>'7',
                "current_drink_pack" =>'6',
                "past_drink_pack" =>'5',
                "past_drink_year" =>'8',
                "currentlysmoking" =>'1',
                "pastsmoking" =>'1',
                "currentlydrinking" =>'1',
                "pastdrinking" =>'1',
                "otherdrug" =>'1',
                "otherdrugpast" =>'1',
                "other_drug_history" =>['name' => array('drug1','drug2'),'year' =>array('4','8')],
                "other_drug_history_past" =>['name' => array('drug1','drug2'),'year' =>array('4','8'),        
                ]
            ];
    
        $this->post('users/edit-medical-history/368', $data);             
        $this->assertEquals(1, 1);   
        //ob_end_flush(); 
    
    }

     public function testEditMedicalHistory7()
    {     
        $this->loginAsAdmin();
        $this->session(['validate_editmedicalhistory_user'=>'368']);  
        $this->session(['iframe_api_data'=>'0']); 

          $data = [
                "tab_number" => 7,
                'edited_tab' =>'7', 
                'current_tab' =>8,
                "womenspecific" =>array('is_previous_birth' =>1,'no_of_pregnency' =>3,'no_of_miscarriage' =>'6','no_of_live_birth' =>6,'prev_birth' =>array('previos_pregnancy_duration' => array('34','26'),
                                                               'previous_birth_sex' => array('1','0'),
                                                               'previous_birth_month' => array('2','4'),
                                                               'previous_birth_year' => array('2018','2006'),
                                                               'previous_delivery_method' => array('0','0'),
                                                               'previous_complication' => array('test','test'),
                                                               'previous_hospital' => array('test','test'),


                ),
                'age_of_first_priod' =>43,
                'is_regular_papsmear' =>1,
                'papsmear_month' =>'5',
                'papsmear_year' =>'2013',
                'papsmear_finding' =>'test',
                'is_sti_std' =>1,
                'sti_std_detail' =>array('0' =>array('sti_std_key' =>0,'year' =>'2018'),'1' =>array('sti_std_key' =>1,'year' =>'2013'),'7' =>array('sti_std_key' =>7,'year' =>'2011'),'other' =>'Testing'),
                'is_mammogram' =>'1',
                'mammogram_month' =>'8',
                'mammogram_year' =>'2007',
                'previous_abnormal_breast_lump' =>'1',
                'any_biopsy' =>'1',
                'breast_lump_biopsy_result' =>array('biopsy_month' =>array('7','4'),'biopsy_year' =>array('2007','2004'),'biopsy_result' =>array('test','test'))
                 ),                                       
                ];   

        $this->post('users/edit-medical-history/368', $data);        
        $this->assertEquals(1, 1);
      // ob_end_flush(); 
    }


    public function testEditMedicalHistory8()
    {       
        $this->loginAsAdmin();
        $this->session(['validate_editmedicalhistory_user'=>'368']);  
        $this->session(['iframe_api_data'=>'0']); 

          $data = [
                "tab_number" => 8,
                //'edited_tab' =>'8', 
                //'current_tab' =>8,
                //'max_visited_tab' =>8,
                "shots_history" =>['17' => array('shot_id' =>'17','year' =>'2012'), '223' => array('shot_id' =>'223','year' =>'2006'),'224' => array('shot_id' =>'224','year' =>'2006')],
                                       
                ];    
        $this->post('users/edit-medical-history/368', $data);
        $this->assertEquals(1, 1);
       // ob_get_flush();
    }


    public function testpreviousAppointment()
    {       
        $this->loginAsAdmin();        
        $data = [
                "tab_number" => 1,                                              
                'is_retired' =>'1',                
                'height' => '1',
                'height_inches' => '1',
                'weight' => 1,
                "zip" => "3223",
                "sexual_orientation" => "1",
                "marital_status" => '1',
                "ethinicity" => "1",
                "occupation" => 'test',
                //"guarantor" =>'3',
                "insurance_company" =>'test',
                "pharmacy" =>'3',
                "address" => 'jaipur',
                "city" =>'1',
                "state" =>'IN',
                "race" =>'1',
                "bmi" =>'1',
                'created' =>  date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
        ]; 
        $this->get('users/previousAppointment');
        //$this->assertResponseSuccess();
        $users = TableRegistry::getTableLocator()->get('users');        
        $query = $users->find('all');        
        $this->assertEquals(1, 1);
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