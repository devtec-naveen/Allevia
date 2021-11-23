<?php

namespace App\Test\TestCase\Controller;


use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Cake\TestSuite\TestCase;
use Cake\Core\App;
//App::uses('Component', 'CryptoSecurity');

class WebserviceControllerTest extends IntegrationTestCase
{   


    public function initialize()
    {
      parent::initialize();   
      $this->loadComponent('General');    
    }
       
    public $fixtures = ['app.organizations','app.cms','app.user_info','app.ProviderEmailTemplates','app.Doctors','app.ChiefCompliantUserdetails'];
    

    // public $clientId = 'OXuAXToEWYrHpyz1NNdhWTwID8#KwsYFlNNkNJT01afnn8S53TTBOt*2TZHtQ73k';  
    // public $clientSecret = 'bgbgmrItho&U&Txs1YTBOXUK1J7g!3b@MEBZP8kPyzd!ZzswqcimWk&sJuKz42qc';  
    // public $providerSecret = 'sIis1#yOawwgy#kk5!Jym6rxU8@iL&rMhL6SQGVV3gn632lxq5JLOOYWKJ#0mV1o';
 
     public $clientId = 'CKrc02W2Bg8ehdChk5fTwBmS1xqonPfhzW&479L#iepx&molpydh&Z$!iBXlK81e';
     public $clientSecret = '9rbWoad1XECn505Ham4HMEzSpc#Vlb&5K162js55BvY5w6jt7&6fNZId9jmruTGy';
     public $providerSecret = 'Fo68e!Qq6#qy*gau*vCnnrHv6Xr&m!tvLYqi3zXAQ4Tiul!zaftDL3Ipc$5rIK8a';

    
    public function testWithBlankData()
    {
        $data = [];
        $this->post('/services/oauth2/token', $data);
        $exp_res = json_decode($this->_response,true);
        $this->assertEquals('400', $exp_res['header']['statusCode']);
        $this->assertEquals('Blank Parameter Error', $exp_res['header']['message']);

    }

    public function testWithBlankClientId()
    {
         $data = [
            'clientId' => '',
            'clientSecret' => '9rbWoad1XECn505Ham4HMEzSpc#Vlb&5K162js55BvY5w6jt7&6fNZId9jmruTGy',
            'providerSecret' => 'Fo68e!Qq6#qy*gau*vCnnrHv6Xr&m!tvLYqi3zXAQ4Tiul!zaftDL3Ipc$5rIK8a',           
        ];
        $this->post('/services/oauth2/token', $data);
        $exp_res = json_decode($this->_response,true);        
        $this->assertEquals('400', $exp_res['header']['statusCode']);
        $this->assertEquals('Client id is empty.', $exp_res['header']['message']);
        
    }

    public function testWithBlankClientSecret()
    {
         $data = [
            'clientId' => 'g08G#3vxXq9d7N7WuiA8yNopoxrWqXHh$#MceVGM0adCZNN86m3OrNL7xxi#yQ6Z',
            'clientSecret' => '',
            'providerSecret' => 'VbztVqPZWo7*pm@9ooV54RuimBfmu!6ujiemvDmB9Q!O*z@@YPyLRHLbA30reS3R',           
        ];
        $this->post('/services/oauth2/token', $data);
        $exp_res = json_decode($this->_response,true);        
        $this->assertEquals('400', $exp_res['header']['statusCode']);
        $this->assertEquals('Client secret is empty.', $exp_res['header']['message']);        
    }

    public function testWithBlankProviderSecret()
    {
       
        $data = [
            'clientId' => 'g08G#3vxXq9d7N7WuiA8yNopoxrWqXHh$#MceVGM0adCZNN86m3OrNL7xxi#yQ6Z',
            'clientSecret' => 'FpCDzIFMI&ox$#I@MQJrmxH9CQIaMCjN5x$jt1u97kxUbn*bC2zheLB6tjyt$QQ8',
            'providerSecret' => '',           
        ];
        
        $this->post('/services/oauth2/token', $data);
        $exp_res = json_decode($this->_response,true);           
        $this->assertEquals('400', $exp_res['header']['statusCode']);
        $this->assertEquals('Provider secret is empty.', $exp_res['header']['message']);        
    }


      public function testInvalidClientIdInvalidClientSecret()
    {
       
        $data = [
            'clientId' => 'OXuAXToEWYrHpyz1NNdhWTwID8#KwsYFlNNkNJT01afnn8S53TTBOt*2TZHtQ73ktt',
            'clientSecret' => 'bgbgmrItho&U&Txs1YTBOXUK1J7g!3b@MEBZP8kPyzd!ZzswqcimWk&sJuKz42qctt',
            'providerSecret' => 'sIis1#yOawwgy#kk5!Jym6rxU8@iL&rMhL6SQGVV3gn632lxq5JLOOYWKJ#0mV1o',          
        ];
        
        $this->post('/services/oauth2/token', $data);
        $exp_res = json_decode($this->_response,true);                
        $this->assertEquals('402', $exp_res['header']['statusCode']);
        $this->assertEquals('Invalid client id or client secret.', $exp_res['header']['message']);    

    }


     public function testInvalidProviderSecret()
    {
       
        $data = [
            'clientId' => 'OXuAXToEWYrHpyz1NNdhWTwID8#KwsYFlNNkNJT01afnn8S53TTBOt*2TZHtQ73k',
            'clientSecret' => 'bgbgmrItho&U&Txs1YTBOXUK1J7g!3b@MEBZP8kPyzd!ZzswqcimWk&sJuKz42qc',
            'providerSecret' => 'sIis1#yOawwgy#kk5!Jym6rxU8@iL&rMhL6SQGVV3gn632lxq5JLOOYWKJ#0mV1otestt',           
        ];
        
        $this->post('/services/oauth2/token', $data);
        $exp_res = json_decode($this->_response,true);                
        $this->assertEquals('402', $exp_res['header']['statusCode']);
        $this->assertEquals('Invalid client id or client secret.', $exp_res['header']['message']); 
       
    }


     public function testProviderNotBelongtoOrganization()
    {       
        $data = [
            'clientId' => 'OXuAXToEWYrHpyz1NNdhWTwID8#KwsYFlNNkNJT01afnn8S53TTBOt*2TZHtQ73k',
            'clientSecret' => 'bgbgmrItho&U&Txs1YTBOXUK1J7g!3b@MEBZP8kPyzd!ZzswqcimWk&sJuKz42qc',
            'providerSecret' => 'js4tfL2ojmCdMvGUmXR@0VrR0Ch$2ktGU8QOv7rTvOZ@I7I6HEoQL*!wwwPGNveN',           
        ];
        
        $this->post('/services/oauth2/token', $data);
        $this->assertEquals(1, 1);       
    }

   

    public function testValidData()
    {
        $data = [
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
            'providerSecret' => $this->providerSecret,         
        ];               
        $this->post('/services/oauth2/token', $data);
        $this->assertEquals(1, 1);  
                  
    }



    public function encrypt($val,$key)
    {
        if(!empty($val)){

            $iv = $this->get_vi();
            // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
            $encrypted = openssl_encrypt($val, 'aes-256-ecb', $key, 0, $iv);
            // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
            return base64_encode($encrypted . '::' . $iv); 
        }

        return $val;
        
    }

     public function get_vi(){

       $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-ecb'));
       return $iv;
    }

      public function decrypt($val,$key)
    {
        if(!empty($val)){

            $iv = $this->get_vi();
            // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
            list($encrypted_data, $iv) = explode('::', base64_decode($val), 2);
            return openssl_decrypt($encrypted_data, 'aes-256-ecb', $key, 0, $iv); 
        }

        return $val;        
    }



    private function getToken()
    {
        $clientId =  base64_encode($this->encrypt($this->clientId,SEC_KEY));        
        $clientSecret = base64_encode($this->encrypt($this->clientSecret,SEC_KEY));
        $providerSecret = base64_encode($this->encrypt($this->providerSecret,SEC_KEY));

        $this->organizations = TableRegistry::getTableLocator()->get('organizations');  

        $organizationsData = $this->organizations->find('all')->where(['client_id' =>$clientId,'client_secret' =>$clientSecret])->first();

        $this->users = TableRegistry::getTableLocator()->get('users');  

        $providerData = $this->users->find('all')->where(['provider_secret' =>$providerSecret])->first();

        $this->user_info = TableRegistry::getTableLocator()->get('user_info'); 

        $user_info = $this->user_info->find('all')->where(['organization_id' =>$organizationsData['id'],'provider_id' =>$providerData['id']])->first();

        $accessToken = $user_info['access_token'];

        $accessToken = $this->decrypt(base64_decode($accessToken),SEC_KEY);
        return $accessToken; 
    }



   // public $accessToken = $this->user_info->access_token; 

    /* Schedule Appointments */


     public function testscheduleAppointmentsBlank()
    {        
         $data = [];
         $this->post('/services/api/schedule-appointments', $data);
         $this->assertEquals(1, 1);  

    }


     public function testscheduleAppointmentsDataBlank()
    {      

       $this->accessToken =  $this->getToken();
        $data = [
           "accessToken" => $this->accessToken, 
           "appointmentData" => [] 
         ];
         $this->post('/services/api/schedule-appointments', $data);
         $this->assertEquals(1, 1);  
    }

        public function testscheduleInvalidAppointmentsData()
    {        
        $this->accessToken =  $this->getToken();    
        $data = [
           "accessToken" => $this->accessToken, 
           "appointmentData" => 'test' 
         ];
         $this->post('/services/api/schedule-appointments', $data);
         $this->assertEquals(1, 1);  

    }

        public function testscheduleAppointments()
    {   
     
        $this->accessToken =  $this->getToken();      
        $data = [
           "accessToken" => $this->accessToken, 
           "appointmentData" => [
                 [
                    "firstName" => "Johnny", 
                    "lastName" => "Appleseed", 
                    "dob" => "15-01-1992", 
                    "mrn" => "125444", 
                    "phone" => "5674532342", 
                    "email" => "brajesh@getnada.com", 
                    "doctorName" => "test", 
                    "visitReason" => "test", 
                    "gender" => "M", 
                    "notifyText" => 1, 
                    "notifyEmail" => 1, 
                    "appointmentDate" => "2021-05-20", 
                    "appointmentTime" =>'11:30',  
                    "appointmentDateTime" =>"2021-05-20 11:30", 
                    "timezone" => 'MST',
                    "notifyEmailSchedule" =>[10000,11000,12000,14000],
                    "notifyTextSchedule" =>[4500,3600,4200,3000],                 
                 ] 
              ] 
         ];
         $this->post('/services/api/schedule-appointments', $data);
         $this->assertEquals(1, 1); 
    }


    //   public function testscheduleAppointmentsEmptyValue()
    // {   
    //     $this->accessToken =  $this->getToken();         
    //     $data = [
    //        "accessToken" => $this->accessToken, 
    //        "appointmentData" => [
    //              [
    //                 "firstName" => "", 
    //                 "lastName" => "", 
    //                 "dob" => "", 
    //                 "mrn" => "", 
    //                 "phone" => "", 
    //                 "email" => "", 
    //                 "doctorName" => "", 
    //                 "visitReason" => "", 
    //                 "gender" => "", 
    //                 "notifyText" => 1, 
    //                 "notifyEmail" => 1, 
    //                 "appointmentDate" => "",                     
    //              ] 
    //           ] 
    //      ];
    //      $this->post('/services/api/schedule-appointments', $data);
    //      $this->assertEquals(1, 1); 
    // }


         public function testscheduleAppointmentsCheckUserRegisterorNot()
    {        
        $this->accessToken =  $this->getToken();   
        $email = $this->generateRandomString(); 
        $data = [
           "accessToken" => $this->accessToken, 
           "appointmentData" => [
                 [       
                    "firstName" => "Johnny", 
                    "lastName" => "Appleseed", 
                    "dob" => "15-01-1992",  
                    "phone" => "1232581111",          
                    "email" => $email."@getnada.com",                    
                    "gender" => "M", 
                    "notifyText" => 1, 
                    "notifyEmail" => 1, 
                    "appointmentDate" => "2021-02-20", 
                    "appointmentTime" =>'11:30',  
                    "appointmentDateTime" =>"2021-02-20 11:30"                   
                 ] 
              ] 
         ];
         $this->post('/services/api/schedule-appointments', $data);
         $this->assertEquals(1, 1); 
    }


      public function testscheduleAppointmentsInvalidValue()
    {  
        $this->accessToken =  $this->getToken();          
        $data = [
           "accessToken" => $this->accessToken, 
           "appointmentData" => [
                 [
                    "firstName" => "", 
                    "lastName" => "", 
                    "dob" => "1123334", 
                    "mrn" => "", 
                    "phone" => "tetetet", 
                    "email" => "testtttt@getnada", 
                    "doctorName" => "", 
                    "visitReason" => "", 
                    "gender" => "t", 
                    "notifyTextSchedule" => 0, 
                    "notifyEmailSchedule" => 'test',     
                    "appointmentDate" => "12222233",   
                    "appointmentTime" =>'',
                    "appointmentDateTime" =>"2021-02-20 11:30"                  
                 ] 
              ] 
         ];
         $this->post('/services/api/schedule-appointments', $data);
         $this->assertEquals(1, 1); 
    }


    public function testscheduleAppointmentsInvalidAppointmenttime()
    {      

        $this->accessToken =  $this->getToken();      
        $data = [
           "accessToken" => $this->accessToken, 
           "appointmentData" => [
                 [                   
                    "appointmentDate" => date('Y-m-d'),   
                    "appointmentTime" =>'11:30'                  
                 ] 
              ] 
         ];
         $this->post('/services/api/schedule-appointments', $data);
         $this->assertEquals(1, 1); 
    }


    public function testscheduleAppointmentsEmptyEmailandPhone()
    {    
        $this->accessToken =  $this->getToken();        
        $data = [
           "accessToken" => $this->accessToken, 
           "appointmentData" => [
                 [
                    "firstName" => "Johnny", 
                    "lastName" => "Appleseed", 
                    "dob" => "15-01-1992", 
                    "mrn" => "125444", 
                    "phone" => "", 
                    "email" => "", 
                    "doctorName" => "test", 
                    "visitReason" => "test", 
                    "gender" => "F", 
                    "notifyText" => 1, 
                    "notifyEmail" => 1, 
                    "appointmentDate" => "2021-02-20",
                    "appointmentTime" =>'11:30',
                    "appointmentDateTime" =>"2021-02-20 11:30"                     
                 ] 
              ] 
         ];
         $this->post('/services/api/schedule-appointments', $data);
         $this->assertEquals(1, 1); 
    }


    function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
   }




       public function testscheduleAppointmentswithClinicAppointmentId()
    {      

         $clinic_appointment_id = rand(500,2000);
         $email = $this->generateRandomString();
         $this->accessToken =  $this->getToken();     
         $data = [
           "accessToken" => $this->accessToken, 
           "appointmentData" => [
                 [
                    "firstName" => "Johnny", 
                    "lastName" => "Appleseed", 
                    "dob" => "15-01-1992", 
                    "mrn" => "125444", 
                    "phone" => "1232582544", 
                    "email" => $email."@getnada.com", 
                    "doctorName" => "test", 
                    "visitReason" => "test", 
                    "gender" => "F", 
                    "notifyText" => 1, 
                    "notifyEmail" => 1, 
                    "appointmentDate" => "2021-02-20", 
                    "appointmentTime" =>'11:30', 
                    "appointmentDateTime" =>"2021-02-20 11:30",
                    "clinicAppointmentId" => $clinic_appointment_id                  
                 ] 
              ] 
         ];
         $this->post('/services/api/schedule-appointments', $data);
         $this->assertEquals(1, 1); 
    }

    /*All Apointments */


     public function testAllApointmentWithBlankParameter()
    {
        $data = [];
         $this->post('/services/api/all-appointments', $data);
         $this->assertEquals(1, 1); 
    }


     public function testAllApointmentWithWrongTimezone()
    {
         $this->accessToken =  $this->getToken();    
         $data = ["timezone" =>'TST'];
         $this->post('/services/api/all-appointments', $data);
         $this->assertEquals(1, 1); 
    }

    public function testAllApointment()
    {
        $this->accessToken =  $this->getToken();                
        $data = [
           "accessToken" => $this->accessToken,         
         ];
         $this->post('/services/api/all-appointments', $data);
         $this->assertEquals(1, 1); 
    }


       /*Delete appointment*/

     public function testDeleteAppointmentWithBlankParameter()
    {
         $data = [];
         $this->post('/services/api/delete-appointments', $data);
         $this->assertEquals(1, 1); 
    }


    // public function testDeleteAppointmentInvalidAccessToken(){

    //      $data = [
    //        "accessToken" => $this->invalidaccessToken,       
    //        "encounterIds" =>  ''
    //      ];         
    //      $this->post('/services/api/delete-appointments', $data);
    //      $this->assertEquals(1, 1);          
    // }

    public function testDeleteAppointmentEmpytEncounterId(){

        $this->accessToken =  $this->getToken();    
         $data = [
           "accessToken" => $this->accessToken,       
           "encounterIds" =>  ''
         ];         
         $this->post('/services/api/delete-appointments', $data);
         $this->assertEquals(1, 1); 
    }

     public function testDeleteAppointmentEncounterIdNotArray(){

        $this->accessToken =  $this->getToken();    
         $data = [
           "accessToken" => $this->accessToken,       
           "encounterIds" =>  '5385'
         ];         
         $this->post('/services/api/delete-appointments', $data);
         $this->assertEquals(1, 1); 
    }

     public function testDeleteAppointmentClinicAppointmentIDNotArray(){

        $this->accessToken =  $this->getToken();    
         $data = [
           "accessToken" => $this->accessToken,       
           "clinicAppointmentIds" =>  '62'
         ];         
         $this->post('/services/api/delete-appointments', $data);
         $this->assertEquals(1, 1); 
    }

     public function testDeleteAppointmentEncounterIdNotEmpty(){

            $this->accessToken =  $this->getToken();    
         $data = [
           "accessToken" => $this->accessToken,       
           "encounterIds" =>  ['5385','5371']
         ];         
         $this->post('/services/api/delete-appointments', $data);
         $this->assertEquals(1, 1); 
    }

       public function testDeleteAppointmentclinicAppointmentIdsNotEmpty(){

            $this->accessToken =  $this->getToken();    
         $data = [
           "accessToken" => $this->accessToken,       
           "clinicAppointmentIds" =>  ['62']
         ];         
         $this->post('/services/api/delete-appointments', $data);
         $this->assertEquals(1, 1); 
    }


        /*Preappointment-questionnaires*/

    public function testPreAppointmentWithBlankParameter()
    {
         $data = [];
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }
    

    //    public function testPreAppointmentWithInvalidAccessToken(){

    //      $this->invalidAccessToken =  'MjllNWI3ZDQzNmZlNmY1NTI1YzNlN2Y0M2YwYWYxYWZmOGI2N2ZlNmE0YjRiMjJmZThlYjgxMDVjZDE3MTQyOFNwjw5kHAzPykfbZaO53wDXRnkdOGRoXU1WcLzFWIajeZrIe64xLtefzbQ3utzP9ziNSXmrCBh/nC4cAOyyhAwgb/VViF/2q76onVR/ZD3n3cfbPSHwnLTVGPa0plI9Q6GqQvxrbaeCGVC94dpuHLE=';
    //      $data = [
    //        "accessToken" => $this->invalidAccessToken,       
    //        "encounterIds" =>  '',
    //        "clinicAppointmentId" =>  '',
    //        "redirectUri" =>'https://www.bing.com'
    //      ];         
    //      $this->post('/services/api/preappointment-questionnaires', $data);
    //      $this->assertEquals(1, 1); 
    // }


      public function testPreAppointmentWithRedirecturi(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "encounterId" =>  '',
           "redirectUri" =>'https://www.bing.com'
         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }


    public function testPreAppointmentWithWrongRedirecturi(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "encounterId" =>  '5155',
           "redirectUri" =>'www.httttp.com'
         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }

    


      public function testPreAppointmentClinicAppointmentIdsandEncounterIdBlank(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "clinicAppointmentId" =>  '',
           "encounterId" =>''

         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }

      public function testPreAppointmentgoThroughMedicalHistoryWrongValue(){

        $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,
           "encounterId" =>  '',
           "clinicAppointmentId" =>  '' ,
           "goThroughMedicalHistory" =>'5'  
           
         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
      }


      public function testPreAppointmentAppointmentAppoinmentNotFound(){          /* Appoinment Not found*/

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "clinicAppointmentId" =>  '60',
           "encounterId" =>'202144',
           "redirectUri" =>'https://www.bing.com'
         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }

      public function testPreAppointmentAppointmentIdsNotBlank(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "clinicAppointmentId" =>  '60',
           "encounterId" =>'5155',
           "goThroughMedicalHistory" =>  '1',
           "skipRegistration" =>'1',
           "redirectUri" =>'https://www.bing.com'
         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }


    public function testPreAppointmentClinicIdBlankEncounterIDNotBlankNotFound(){  /* Appoinment Not found*/

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,  
           "encounterId" =>'2544455',   
           "clinicAppointmentId" =>  '',
           "goThroughMedicalHistory" =>  '1',
           "redirectUri" =>'https://www.bing.com'
           
         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }

      public function testPreAppointmentClinicIdBlankEncounterIDNotBlank(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,  
           "encounterId" =>'5155',   
           "clinicAppointmentId" =>  '',
           "goThroughMedicalHistory" =>  '1',
           "redirectUri" =>'https://www.bing.com'
           
         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }


     public function testPreAppointmentClinicIdNotBlankEncounterIDBlankNotFound(){   /* Appoinment Not found*/

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken, 
           "encounterId" =>'',     
           "clinicAppointmentId" =>  '56855556',
           "redirectUri" =>'https://www.bing.com'           
         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }


     public function testPreAppointmentClinicIdNotBlankEncounterIDBlank(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken, 
           "encounterId" =>'',     
           "clinicAppointmentId" =>  '102',
           "redirectUri" =>'https://www.bing.com'
           
         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }

    public function testPreAppointmentAppoinmentExprired(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken, 
           "encounterId" =>'5359',     
           "clinicAppointmentId" =>  '',
           "skipRegistration" =>'1',
           "redirectUri" =>'https://www.bing.com'
           
         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }


      public function testPreAppointmentAppoinmentNotExprired(){         // current day schedule appointment

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken, 
           "encounterId" =>'-45555',     
           "clinicAppointmentId" =>  '',
           "skipRegistration" =>'1',  
           "redirectUri" =>'https://www.bing.com'

         ];         
         $this->post('/services/api/preappointment-questionnaires', $data);
         $this->assertEquals(1, 1); 
    }


  


    /*View Note*/

    public function testViewNoteWithBlankParameter()
    {
         $data = [];
         $this->post('/services/api/view-note', $data);
         $this->assertEquals(1, 1); 
    }




     public function testViewNoteEncounterIdNotBlank(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "encounterId" =>  '4607',
           "timezone" =>'PST'
         ];         
         $this->post('/services/api/view-note', $data);
         $this->assertEquals(1, 1); 
    }    


      public function testViewNoteWithWrongTimezone()
    {
         $this->accessToken =  $this->getToken();    
         $data = [
                "accessToken" => $this->accessToken,  
                "timezone" =>'sst'
                 ];
         $this->post('/services/api/view-note', $data);
         $this->assertEquals(1, 1); 
    }


      public function testViewNoteNotBelongToStepId(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,                  
           "encounterId" =>'5298'
         ];         
         $this->post('/services/api/view-note', $data);
         $this->assertEquals(1, 1); 
    }


    public function testViewNoteClinicAppointmentIdsandEncounterIdBlank(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "clinicAppointmentId" =>  '',
           "encounterId" =>''

         ];         
         $this->post('/services/api/view-note', $data);
         $this->assertEquals(1, 1); 
    }

     public function testViewNoteWrongEncounterId(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,                  
           "encounterId" =>'543543545'
         ];         
         $this->post('/services/api/view-note', $data);
         $this->assertEquals(1, 1); 
    }  

     public function testViewNoteClinicAppointmentIdNotBlank(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "clinicAppointmentId" =>  '12541',
           "encounterId" =>''

         ];         
         $this->post('/services/api/view-note', $data);
         $this->assertEquals(1, 1); 
    }


     public function testViewNoteEncounterIdAppointmentNotFound(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,                  
           "encounterId" =>'29'
         ];         
         $this->post('/services/api/view-note', $data);
         $this->assertEquals(1, 1); 
    }        


       public function testViewNoteEhrNoteNotEmpty(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "clinicAppointmentId" =>  '',
           "encounterId" =>'4607'
         ];    


         $dfdsf = $this->General->ipc_note_detail(4387,4607);
         pr($dfdsf);die;


         $this->post('/services/api/view-note', $data);
         $exp_res = json_decode($this->_response,true);
         pr($exp_res);die;
         $this->assertEquals(1, 1); 
    }


         public function testViewNoteEhrNoteEmpty(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "clinicAppointmentId" =>  '',
           "encounterId" =>'5298'

         ];  

         $this->post('/services/api/view-note', $data);

         $this->assertEquals(1, 1); 
    }



    /* Register Patient */


     public function testRegisterPatientWithBlankParameter()
    {
         $data = [];
         $this->post('/services/api/register-patients', $data);
         $this->assertEquals(1, 1); 
    }



      public function testRegisterPatientpatientDataBlank(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "patientData" =>  []
         ];         
         $this->post('/services/api/register-patients', $data);
         $this->assertEquals(1, 1); 
    }  


    public function testRegisterPatientpatientDataIsNotCorrect(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "patientData" =>  'test'
         ];         
         $this->post('/services/api/register-patients', $data);
         $this->assertEquals(1, 1); 
    }  

    public function testRegisterPatientpatientEmptyPatientData(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "patientData" =>  [ 
                             [ "firstName" => "", 
                                "lastName" => "", 
                                "dob" => "",                                 
                                "phone" => "", 
                                "email" => "",                                 
                                "gender" => "", 
                               ]
                             ]
         ];         
         $this->post('/services/api/register-patients', $data);
         $this->assertEquals(1, 1); 
    }  

      public function testRegisterPatientpatientInvalidData(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "patientData" =>  [ 
                             [ "firstName" => "Johnny", 
                                "lastName" => "Appleseed", 
                                "dob" => "1123334",                                 
                                "phone" => "tetetet", 
                                "email" => "testtttt@getnada",                                 
                                "gender" => "t", 
                               ]
                             ]
         ];         
         $this->post('/services/api/register-patients', $data);
         $this->assertEquals(1, 1); 
    }


     public function testRegisterPatientpatientDataFNLNDOBNOtEmpty(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "patientData" =>  [
                              ["firstName" => "Johnny",
                                "lastName" => "Appleseed",
                                "dob" =>"15-01-1992",
                                "phone" => "",          
                                "email" => "",
                                "gender" => "F",                                
                               ]
                             ]
         ];         
         $this->post('/services/api/register-patients', $data);
         $this->assertEquals(1, 1); 
    } 

     public function testRegisterPatientpatientEmailGenderF(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "patientData" =>  [   
                               [    
                                "firstName" => "Johnny", 
                                "lastName" => "Appleseed", 
                                "dob" => "15-01-1992", 
                                "gender" => "F",
                                "email" => "testuser514@getnada.com"                                
                               ]
                             ]
         ];         
         $this->post('/services/api/register-patients', $data);
         $this->assertEquals(1, 1); 
    } 

    public function testRegisterPatientpatientEmailGenderM(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "patientData" =>  [   
                               [    
                                "firstName" => "Johnny", 
                                "lastName" => "Appleseed", 
                                "dob" => "15-01-1992", 
                                "gender" => "M",
                                "email" => "testuser515@getnada.com"                                
                               ]
                             ]
         ];         
         $this->post('/services/api/register-patients', $data);
         $this->assertEquals(1, 1); 
    } 

     public function testRegisterPatientpatientEmailGenderO(){

         $this->accessToken =  $this->getToken();
         $data = [
           "accessToken" => $this->accessToken,       
           "patientData" =>  [   
                               [    
                                "firstName" => "Johnny", 
                                "lastName" => "Appleseed", 
                                "dob" => "15-01-1992", 
                                "gender" => "O",
                                "email" => "testuser516@getnada.com"
                               ]
                             ]
         ];         
         $this->post('/services/api/register-patients', $data);
         $this->assertEquals(1, 1); 
    } 

    public function testRegisterPatientNewRecord(){

         $this->accessToken =  $this->getToken();
         $email = $this->generateRandomString(); 
         $data = [
           "accessToken" => $this->accessToken,       
           "patientData" =>  [   
                               [    
                                "firstName" => "Johnny", 
                                "lastName" => "Appleseed", 
                                "dob" => "15-01-1992", 
                                "gender" => "O",
                                "email" => $email."@getnada.com"
                               ]
                             ]
         ];         
         $this->post('/services/api/register-patients', $data);
         $this->assertEquals(1, 1); 
    } 


    /* View Medical History */


    public function testviewMedicalHistoryWithBlankParameter()
    {
         $data = [];
         $this->post('/services/api/view-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


     public function testviewMedicalHistorywithoutUserId()
    {
         $this->accessToken =  $this->getToken();   
         $data = [
            "accessToken" => $this->accessToken,    
            "email" => "testuser514@getnada.com",
            "phone" => "9636231037",                                                                   
          ];
         $this->post('/services/api/view-medical-history', $data);
         $this->assertEquals(1, 1); 
    }

      public function testviewMedicalHistorywithoutUserIdWithFNLNDOB()
    {
         $this->accessToken =  $this->getToken();   
         $data = [
            "accessToken" => $this->accessToken,    
            "firstName" => "Johnny",
            "lastName" => "Appleseed",
            "dob" =>"15-01-1992",                                                     
          ];
         $this->post('/services/api/view-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


     public function testviewMedicalHistorywithUserId()
    {
         $this->accessToken =  $this->getToken();   
         $data = [
            "accessToken" => $this->accessToken,  
            "userId" => 83,                                                   
            "email" => "testuser514@getnada.com" 
          ];
         $this->post('/services/api/view-medical-history', $data);
         $this->assertEquals(1, 1); 
    }

    public function testviewMedicalHistoryWithUserIdAdminOrProvider()  //User is registered as admin or provider
    {
         $this->accessToken =  $this->getToken(); 
         $data = [
            "accessToken" => $this->accessToken,  
            "userId" => 69,                                                               
          ];
         $this->post('/services/api/view-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


     /* Edit Medical History */


       public function testEditMedicalHistoryWithBlankParameter()
    {
         $data = [];
         $this->post('/services/api/edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


       public function testEditMedicalHistoryWithoutUserId()
    {
         $this->accessToken =  $this->getToken(); 
         $data = [
            "accessToken" => $this->accessToken,                                                                        
          ];
         $this->post('/services/api/edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }



      public function testEditMedicalHistoryWithUserId()
    {
         $this->accessToken =  $this->getToken(); 
         $data = [
            "accessToken" => $this->accessToken,  
            "userId" => 375,                                                               
          ];
         $this->post('/services/api/edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


     public function testEditMedicalHistoryWithUserIdAdminOrProvider()  //User is registered as admin or provider
    {
         $this->accessToken =  $this->getToken(); 
         $data = [
            "accessToken" => $this->accessToken,  
            "userId" => 69,                                                               
          ];
         $this->post('/services/api/edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


    /* Save Medical History */


    public function testSaveMedicalHistoryWithBlankParameter()
    {
         $data = [];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


        public function testSaveMedicalHistoryWithoutUserId()
    {
         $this->accessToken =  $this->getToken(); 
         $data = [
            "accessToken" => $this->accessToken,    
            "email" => "testuser514@getnada.com",
            "phone" => "9636231037",                                                                     
          ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


       public function testSaveMedicalHistoryWithUserId()
    {
         $this->accessToken =  $this->getToken(); 
         $data = [
            "accessToken" => $this->accessToken,  
            "userId" => 375,                                                               
          ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


    public function testSaveMedicalHistoryWithUserIdAdminOrProvider()  //User is registered as admin or provider
    {
         $this->accessToken =  $this->getToken(); 
         $data = [
            "accessToken" => $this->accessToken,  
            "userId" => 69,                                                               
          ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }

     public function testSaveMedicalHistoryWithInvalidUserId()  
    {
         $this->accessToken =  $this->getToken(); 
         $data = [
            "accessToken" => $this->accessToken,  
            "userId" => 27554,                                                               
          ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }

       public function testSaveMedicalHistorywithoutUserIdWithFNLNDOB()
    {
         $this->accessToken =  $this->getToken();   
         $data = [
            "accessToken" => $this->accessToken,    
            "firstName" => "Johnny",
            "lastName" => "Appleseed",
            "dob" =>"15-01-1992",                                                     
          ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


     public function testSaveMedicalHistoryBasicDetailPositive()
    {
         $this->accessToken =  $this->getToken();   
         $data = [
            "accessToken" => $this->accessToken,   
            "userId" => 375,  
            'basicDetails' =>['is_retired' =>'1',
                            'height' => '1',
                            'heightInches' => '1',
                            'weight' => 1,
                            "zip" => "3223",
                            "sexualOrientation" => "1",
                            "maritalStatus" => '1',
                            "ethinicity" => "1",
                            "occupation" => 'test',
                            "guarantor" =>'3',
                            "insuranceCompany" =>'test',
                            "pharmacy" =>'3',
                            "address" => 'jaipur',
                            "city" =>'1',
                            "state" =>'IN',
                            "race" =>'1',
                            "bmi" =>'1']                                              
          ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


       public function testSaveMedicalHistoryBasicDetailNegative()
    {
         $this->accessToken =  $this->getToken();   
         $data = [
            "accessToken" => $this->accessToken,   
            "userId" => 375,  
            'basicDetails' =>['isRetired' =>'5',
                            'height' => '8',
                            'heightInches' => '20',
                            'weight' => 'test',
                            "zip" => "abxd",
                            "sexualOrientation" => "7",
                            "maritalStatus" => '8',
                            "ethnicity" => "12",
                            "occupation" => 'test',
                            "guarantor" =>'3',
                            "insurance_company" =>'test',
                            "pharmacy" =>'3',
                            "address" => 'jaipur',
                            "city" =>'1',
                            "state" =>'dsfdsf',
                            "race" =>'3',
                            "bmi" =>'1']                                              
          ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


     public function testSaveMedicalHistoryMedicalDetailPositive()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "medicalHistoryDetails" =>['isCheckMedHis' =>1, 'medicalHistory' =>

                                array(array('name' =>'Anthrax','year'=>'2011'),array('name' =>'Chicken pox','year'=>'1999'),array('name' =>'Chlamydia','year'=>'120'))
                            ]
        
                ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


      public function testSaveMedicalHistoryMedicalDetailNegative()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "medicalHistoryDetails" =>['isCheckMedHis' =>5, 'medicalHistory' =>
                                array(array('name' =>'Anthrax','year'=>'2011'),array('name' =>'Chicken pox','year'=>'1999'),array('name' =>'Chlamydia','year'=>'120'))
                            ],
        
                ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


    public function testSaveMedicalHistorySurgicalHistoryPositive()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "surgicalHistoryDetails" =>['isCheckSurgHis' =>1, 'surgicalHistory' =>
                                array(array('name' =>'Breast removal (whole)','year'=>'2004'),array('name' =>'Colon (large intestine) partial removal (partial colectomy)','year'=>'1984'),array('name' =>'Debridement of wound, burn or infection naveen','year'=>'120'))
                            ],
        
                ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


        public function testSaveMedicalHistorySurgicalHistoryNegative()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "surgicalHistoryDetails" =>['isCheckSurgHis' =>5, 'surgicalHistory' =>
                                array(array('name' =>'Breast removal (whole)','year'=>'2004'),array('name' =>'Colon (large intestine) partial removal (partial colectomy)','year'=>'1984'),array('name' =>'Debridement of wound, burn or infection naveen','year'=>'120'))
                            ],
        
                ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


     public function testSaveMedicalHistoryFamilyHistoryPositive()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "familyHistoryDetails" =>['isFamilyHistory' =>1, 'familyHistory' =>
                                 array(array('name' =>'13','disease'=>'Breast cancer','aliveStatus' =>'0','deceaseYear' =>'37','causeOfDeath' =>'Adhd,Adenovirus'),array('name' =>'2','disease'=>'Adenovirus','aliveStatus' =>'1'))
                            ],
        
                ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


        public function testSaveMedicalHistoryFamilyHistoryNegative()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "familyHistoryDetails" =>['isFamilyHistory' =>5, 'familyHistory' =>
                               array(array('name' =>'20','disease'=>'Breast cancer','aliveStatus' =>'5','deceaseYear' =>'720','causeOfDeath' =>'Adhd,Adenovirus'),array('name' =>'2','disease'=>'Adenovirus','aliveStatus' =>'1'),array('name' =>'','disease'=>'','aliveStatus' =>'1'))
                            ],
        
                ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }



       public function testSaveMedicalHistoryAllergiyHistoryPositive()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "allergyHistoryDetails" =>['isCheckAllergyHis' =>1, 'allergyHistory' =>
                                 array(array('name' =>'Beefs','reaction'=>'Nasal congestion'),array('name' =>'Fishs','reaction'=>'Shock'),array('name' =>'Eggss','reaction'=>'Swelling'))
                            ],
        
                ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


       public function testSaveMedicalHistoryAllergiyHistoryNegative()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "allergyHistoryDetails" =>['isCheckAllergyHis' =>5, 'allergyHistory' =>
                                array(array('name' =>'Beefs','reaction'=>'Nasal congestion'),array('name' =>'Fishs','reaction'=>'Shock'),array('name' =>'Eggss','reaction'=>'Swelling'))
                            ],
        
                ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


    public function testSaveMedicalHistorySocialHistoryNegative()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "socialHistoryDetails" => 
                                [   "currentSmokePack" => 20,             
                                    "pastSmokePack" =>'20',
                                    "pastSmokeYear" =>'50',
                                    "currentDrinkPack" =>'40',
                                    "pastDrinkPack" =>'80',
                                    "pastDrinkYear" =>'20',
                                    "isCurrentlySmoking" =>'5',
                                    "isPastSmoking" =>'5',
                                    "isCurrentlyDrinking" =>'7',
                                    "isPastDrinking" =>'6',
                                    "isOtherDrug" =>'66',
                                    "isPastOtherDrug" =>'99',
                                    "otherDrugHistory" =>
                                    array(array('name' =>'drug1','year'=>'4'),array('name' =>'drug2','year'=>'8')),
                                    "pastOtherDrugHistory" =>
                                     array(array('name' =>'drug1','year'=>'4'),array('name' =>'drug2','year'=>'8')),
                                ],        
            ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }




       public function testSaveMedicalHistorySocialHistoryPositive()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "socialHistoryDetails" => 
                                [   "currentSmokePack" => 4,             
                                    "pastSmokePack" =>'6',
                                    "pastSmokeYear" =>'7',
                                    "currentDrinkPack" =>'6',
                                    "pastDrinkPack" =>'5',
                                    "pastDrinkYear" =>'8',
                                    "isCurrentlySmoking" =>'1',
                                    "isPastSmoking" =>'1',
                                    "isCurrentlyDrinking" =>'1',
                                    "isPastDrinking" =>'1',
                                    "isOtherDrug" =>'1',
                                    "isPastOtherDrug" =>'1',
                                    "otherDrugHistory" =>array(array('name' =>'drug1','year'=>'4'),array('name' =>'drug2','year'=>'8'),array('name' =>'','year'=>'20')),
                                    "pastOtherDrugHistory" => array(array('name' =>'drug1','year'=>'4'),array('name' =>'drug2','year'=>'8'),array('name' =>'','year'=>'20'))
                                    ]
                                       
            ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }



    public function testSaveMedicalHistoryObgynoHistoryPositive()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "obGynHistoryDetails" =>array('isPreviousBirth' =>1,'numberOfPregnancy' =>3,'numberOfMiscarriage' =>'6','numberOfLiveBirth' =>6,'prevBirth' =>array('previosPregnancyDuration' => array('34','26'),
                                                               'previousBirthSex' => array('1','0'),
                                                               'previousBirthMonth' => array('2','4'),
                                                               'previousBirthYear' => array('2018','2006'),
                                                               'previousDeliveryMethod' => array('0','0'),
                                                               'previousComplication' => array('test','test'),
                                                               'previousHospital' => array('test','test'),


                ),
                'previousBirthDetails' =>array(array('previousBirthSex' =>'0','previousBirthMonth'=>'0','previousBirthYear' =>'1990','previousDeliveryMethod' =>'0','previousPregnancyDuration' =>'30','previousComplication' =>'hk','previousHospital' =>'test'),array('previousBirthSex' =>'1','previousBirthMonth'=>'11','previousBirthYear' =>'1990','previousDeliveryMethod' =>'1','previousPregnancyDuration' =>'30','previousComplication' =>'hk','previousHospital' =>'test')),
                'ageOfFirstPeriod' =>43,
                'isRegularPapsmear' =>1,
                'papsmearMonth' =>'5',
                'papsmearYear' =>'2013',
                'papsmearFinding' =>'test',
                'isStiStd' =>1,
                'stiStdDetail' =>array(array('stiStdKey' =>'6','year'=>'1990'),array('stiStdKey' =>'7','Year'=>'1990','other' =>'')),
                'isMammogram' =>'1',
                'mammogramMonth' =>'8',
                'mammogramYear' =>'2007',
                'previousAbnormalBreastLump' =>'1',
                'isBiopsy' =>'1',
                'breastLumpBiopsyResultDetails' =>array(array('biopsyMonth' =>'10','biopsyYear'=>'1930','biopsyResult' =>'ffff')),
                 ),  
                            
            
        
                ];
                
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }

        public function testSaveMedicalHistoryObgynoHistoryNegative()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "obGynHistoryDetails" =>array('isPreviousBirth' =>6,'numberOfPregnancy' =>18,'numberOfMiscarriage' =>'50','numberOfLiveBirth' =>60,'prevBirth' =>array('previosPregnancyDuration' => array('34','26'),
                                                               'previousBirthSex' => array('1','0'),
                                                               'previousBirthMonth' => array('2','4'),
                                                               'previousBirthYear' => array('2018','2006'),
                                                               'previousDeliveryMethod' => array('0','0'),
                                                               'previousComplication' => array('test','test'),
                                                               'previousHospital' => array('test','test'),


                ),
                'previousBirthDetails' =>array(array('previousBirthSex' =>'0','previousBirthMonth'=>'0','previousBirthYear' =>'1990','previousDeliveryMethod' =>'0','previousPregnancyDuration' =>'30','previousComplication' =>'hk','previousHospital' =>'test'),array('previousBirthSex' =>'1','previousBirthMonth'=>'11','previousBirthYear' =>'1990','previousDeliveryMethod' =>'1','previousPregnancyDuration' =>'30','previousComplication' =>'hk','previousHospital' =>'test')),
                'ageOfFirstPeriod' =>'test',
                'isRegularPapsmear' =>55,
                'papsmearMonth' =>'999',
                'papsmearYear' =>'4564564',
                'papsmearFinding' =>'test',
                'isStiStd' =>1,
                'stiStdDetail' =>array('0' =>array('stiStdKey' =>0,'year' =>'2018'),'1' =>array('stiStdKey' =>1,'year' =>'2013'),'7' =>array('stiStdKey' =>7,'year' =>'2011'),'other' =>'Testing'),
                'isMammogram' =>'5',
                'mammogramMonth' =>'254',
                'mammogramYear' =>'154444',
                'previousAbnormalBreastLump' =>'1',
                'isBiopsy' =>'8',
                'breastLumpBiopsyResult' =>'test'
                 ),          
                ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }


         public function testSaveMedicalHistoryShotHistoryPositive()
    {
         $this->accessToken =  $this->getToken();   
          $data = [   
                "accessToken" => $this->accessToken,   
                "userId" => 375,              
                "shotsHistoryDetails" =>['shotsHistory' =>
                                array('name' =>'Tetanus/diptheri','year' =>'2006'),array('name' =>'Measles/mumps/rubella (MMR)','year' =>'2006')
                                ],
        
                  ];
         $this->post('/services/api/save-edit-medical-history', $data);
         $this->assertEquals(1, 1); 
    }





    
}
