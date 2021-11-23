<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
use Cake\Core\Configure;
use Cake\Utility\Security;

class ProviderMailSendComponent extends Component{
   /**
    * array ['slug' => '...', 'replaceString' => [...], 'replaceData' => [....], 'email' => 'emailid']
   **/
   
    public function send( $arg ){

        $emailTemplates = TableRegistry::get('ProviderEmailTemplates');
        $data = $emailTemplates->find()->where(['slug' => $arg['slug'], 'provider_id' => $arg['provider_id']])->first();
        $ProviderGlobalSettingsTlb = TableRegistry::get('ProviderGlobalSettings');
        $provider_config = $ProviderGlobalSettingsTlb->find()->where(['provider_id' => $arg['provider_id']])->first();
        // pr($data);
        // pr($provider_config);die('g');

        if(!empty($data))
        {   

            $mailMessage = str_replace($arg['replaceString'],$arg['replaceData'],$data->description);

            $mailMessage = str_replace("at .", ".", $mailMessage);

            if(!empty($provider_config) && !empty($provider_config['sendgrid_api_key']) && !empty($provider_config['sendgrid_email'])){
              //die('sdsa');
              $provider_config['sendgrid_api_key'] = Security::decrypt(base64_decode($provider_config['sendgrid_api_key']),SEC_KEY);

              $provider_config['sendgrid_email'] = Security::decrypt(base64_decode($provider_config['sendgrid_email']),SEC_KEY);
              $username = isset($arg['username']) ? $arg['username'] : "User";

              //pr($provider_config);die('df');
              $email = new \SendGrid\Mail\Mail();
              $email->setFrom($provider_config['sendgrid_email'],"Allevia Provider");
              $email->setSubject($data->subject);
              $email->addTo($arg['email'],$username);
              $email->addContent("text/html", $mailMessage);
              $sendgrid = new \SendGrid($provider_config['sendgrid_api_key']);
              //pr($sendgrid);die;
              try {
                  $response = $sendgrid->send($email);
                  return true;
                  // print $response->statusCode() . "\n";
                  // print_r($response->headers());
                  // print $response->body() . "\n";
                 // die;
              } catch (Exception $e) {
                 //echo 'Caught exception: '. $e->getMessage() ."\n";
                 //die;
                return false;
              }
            }
            else{

              $sender = 'admin@allevia.com';
              $email = new Email('default');
              try{
                
                $result = $email->from(['admin@allevia.com' => 'Allevia Provider'])
                              ->to($arg['email']) //$arg['email']
                              ->emailFormat('html')
                              ->subject($data->subject)
                              ->send($mailMessage);
                       
                return true;      
              }
              catch(Exception $e){
                //pr($e) ;die; 
                return false;
              }
            }
            
         }

         return true;
         //die('fdsf');
    }


/* public function send_news( $arg ){
       
        //$this->loadComponent('Email');
 
        $emailTemplates = TableRegistry::get('NewsletterTemplates');
        $data = $emailTemplates->find()->where(['slug' => $arg['slug'], 'status' => 1])->first();
        
        if( !empty($data) ){
            
            $arg['replaceString'][] = '{{sender_email}}';
            $arg['replaceData'][] = Configure::read('App.EmailFrom');
            
            
             $mailMessage = str_replace($arg['replaceString'],$arg['replaceData'],$data->content);
           
            if( !isset($arg['senderEmail']) || empty( $arg['senderEmail'] ) ){
                //$sender = 'notification@abc.com';
                 $sender =Configure::read('App.EmailFrom');
            }else{

                $sender = $arg['senderEmail'];
            }
            
            $email = new Email('default');
            try{
              
                $result = $email->from([$sender => ''])
                              ->to($arg['email'])
                              ->emailFormat('html')
                              ->subject($data->subject)
                              ->send($mailMessage);
                           //pr($mailMessage); die;
                           
                return true;			
            }
            catch(Exception $e){
            return false;
            }
        }
    }*/
    
}
