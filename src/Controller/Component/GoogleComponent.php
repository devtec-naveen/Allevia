<?php
namespace App\Controller\Component;
require_once(ROOT . DS  . 'vendor' . DS  . 'google' . DS . 'Google_Client.php');
require_once(ROOT . DS  . 'vendor' . DS  . 'google' . DS . 'Google_Oauth2Service.php');
 
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\Controller\Controller;
use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Braintree\Braintree;

class GoogleComponent extends Component{
   /**
    * array ['slug' => '...', 'replaceString' => [...], 'replaceData' => [....], 'email' => 'emailid']
   **/

 
 protected $_controller = null;

    
    public function __construct() {
         
        $this->BASE_URL = filter_var(SITE_URL, FILTER_SANITIZE_URL);
		$this->CLIENT_ID = '308887502282-4t6it5q7s5fkekduer2b4biedb5oasoo.apps.googleusercontent.com' ; // '811101941025-mnlekh04pmmn619mvb71hi41nf9l7pgo.apps.googleusercontent.com';
		$this->CLIENT_SECRET = '3YW44vPQht76VUuzqRIWwELo'; //'h3XOLJ1y31sf2B7HEa0f1guK';
		$this->REDIRECT_URI = SITE_URL.'/users/googlelogin';
		$this->APPROVAL_PROMPT = 'auto';
		$this->ACCESS_TYPE = 'offline';
        
       }
   

 
  public function google(){	        
			$client = new \Google_Client();
			$client->setApplicationName("Idiot Minds Google Login Functionallity");
			$client->setClientId($this->CLIENT_ID);
			$client->setClientSecret($this->CLIENT_SECRET);
			$client->setRedirectUri($this->REDIRECT_URI);
			$client->setApprovalPrompt($this->APPROVAL_PROMPT);
			$client->setAccessType($this->ACCESS_TYPE);
			$oauth2 = new \Google_Oauth2Service($client);
			
			if (isset($_GET['code'])) {
			  $client->authenticate($_GET['code']);
			   $_SESSION['token'] = $client->getAccessToken();
			  $client->setAccessToken($_SESSION['token']);
 
			}
			
			if (isset($_REQUEST['error'])) {
			 echo '<script type="text/javascript">window.close();</script>'; exit;
			}
			if ($client->getAccessToken()) {  
			    $user = $oauth2->userinfo->get();
			  //$user['role_id'] = $role_id;
			 return $user;
			 
			  $_SESSION['User']=$user;
			  $_SESSION['token'] = $client->getAccessToken();
	
			} else {
			  $authUrl = $client->createAuthUrl();
			   header('Location: '.$authUrl);
			
			}
      }
    
}