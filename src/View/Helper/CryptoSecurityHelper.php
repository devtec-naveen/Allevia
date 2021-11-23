<?php
/**
 * General Helper
 *
 *
 * @category Helper
 */
//App::uses('Helper', 'View');

namespace App\View\Helper;
use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Controller\Controller;
use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Network\Email;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use ReflectionClass;
use ReflectionMethod;



class CryptoSecurityHelper extends Helper {

  /*public function mysql_aes_key($key)
  {
      $new_key = str_repeat(chr(0), 16);
      for($i=0,$len=strlen($key);$i<$len;$i++)
      {
          $new_key[$i%16] = $new_key[$i%16] ^ $key[$i];
      }
      return $new_key;
  }

  public function encrypt($val,$salt)
  {
      $key = $this->mysql_aes_key($salt);
      $pad_value = 16-(strlen($val) % 16);
      $val = str_pad($val, (16*(floor(strlen($val) / 16)+1)), chr($pad_value));
      return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $val, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM));
  }


  public function decrypt($val,$salt)
  {
      $key = $this->mysql_aes_key($salt);
      $val = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $val, MCRYPT_MODE_ECB, mcrypt_create_iv( mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM));
      return rtrim($val, "\.\.16");
  }*/

  public function get_vi(){

       $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-ecb'));
       return $iv;
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
}

?>