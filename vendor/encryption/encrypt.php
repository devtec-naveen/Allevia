<?php

class CryptoSecurity{

    public function mysql_aes_key($key)
    {
        $new_key = str_repeat(chr(0), 16);
        for($i=0,$len=strlen($key);$i<$len;$i++)
        {
            $new_key[$i%16] = $new_key[$i%16] ^ $key[$i];
        }
        return $new_key;
    }

    public function aes_encrypt($val,$salt)
    {
        $key = $this->mysql_aes_key($salt);
        $pad_value = 16-(strlen($val) % 16);
        $val = str_pad($val, (16*(floor(strlen($val) / 16)+1)), chr($pad_value));
        return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $val, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM));
    }


    public function aes_decrypt($val,$salt)
    {
        $key = $this->mysql_aes_key($salt);
        $val = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $val, MCRYPT_MODE_ECB, mcrypt_create_iv( mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM));
        return rtrim($val, "..16");
    }
}

?>