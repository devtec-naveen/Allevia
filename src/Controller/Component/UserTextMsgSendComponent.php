<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
use Cake\Core\Configure;
use Twilio\Rest\Client;

class UserTextMsgSendComponent extends Component{
   /**
    * array ['slug' => '...', 'replaceString' => [...], 'replaceData' => [....], 'email' => 'emailid']
   **/
   
    public function send( $arg ){
      //pr($arg);
       
        //$this->loadComponent('Email');
        require_once(ROOT . DS  . env('twillo_path'));
        $sid = env('twilio_sid');
        $token = env('twilio_access_token');
        $twilio_number = env('twilio_number');
        $emailTemplates = TableRegistry::get('emailTemplates');
        $data = $emailTemplates->find()->where(['slug' => $arg['slug']])->first();
        //pr($data->toArray());
        if(!empty($data) && !empty($data->text_message)){            
            
            $text_msg = strip_tags(str_replace($arg['replaceString'],$arg['replaceData'],$data->text_message));
            //pr($text_msg);die;
            $client = new Client($sid, $token);
            try{

              $message = $client->messages->create(
               '+1'.$arg['phone'], // Text this number  '+1'.$user_data['phone']
                array(
                  'from' => $twilio_number, // From a valid Twilio number
                  'body' => $text_msg
                )
              );
              
              return true;
            }
            catch(\Exception $e){

             // pr($e) ;die; 
              return false;
            } 
            
        }
    }
    
}
