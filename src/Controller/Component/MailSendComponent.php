<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
use Cake\Core\Configure;

class MailSendComponent extends Component{
   /**
    * array ['slug' => '...', 'replaceString' => [...], 'replaceData' => [....], 'email' => 'emailid']
   **/
   
    public function send( $arg ){
       
        //$this->loadComponent('Email');

        $emailTemplates = TableRegistry::get('emailTemplates');
        $data = $emailTemplates->find()->where(['slug' => $arg['slug'], 'status IN' => [1,2]])->first();

        if( !empty($data) ){
            
            // $arg['replaceString'][] = '{{sender_email}}';
            // $arg['replaceData'][] = Configure::read('App.EmailFrom');
            
            
            $mailMessage = str_replace($arg['replaceString'],$arg['replaceData'],$data->description);
         /*
            if(!isset($arg['senderEmail']) || empty( $arg['senderEmail'] ) ){
                //$sender = 'notification@abc.com';
                 $sender =Configure::read('App.EmailFrom');
            }else{

                $sender = $arg['senderEmail'];
                }
                */
            $sender = 'admin@allevia.com';
            $email = new Email('default');
            try{
              
                $result = $email->from(['admin@allevia.com' => 'Allevia Admin'])
                              ->to($arg['email'])
                              ->emailFormat('html')
                              ->subject($data->subject)
                              ->send($mailMessage);
                       
                  return true;			
               }
                  catch(Exception $e){
                    pr($e) ;die; 
                  return false;
               }
         }
    }


 public function send_news( $arg ){
       
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
    }
    
}
