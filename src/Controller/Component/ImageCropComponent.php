<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class ImageCropComponent extends Component{
   
    public function ext( $str ){
        
        $i = strrpos($str,".");
        if (!$i)
        {
        return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
        
    }
    
    
    
    public function compressImage($ext,$uploadedfile,$newwidth,$path,$actual_image_name){
        
        if($ext=="jpg" || $ext=="jpeg" )
        {
        $src = imagecreatefromjpeg($uploadedfile);
        }
        else if($ext=="png")
        {
        $src = imagecreatefrompng($uploadedfile);
        }
        else if($ext=="gif")
        {
        $src = imagecreatefromgif($uploadedfile);
        }
        else
        {
        $src = imagecreatefromgif($uploadedfile);
        }
        
        list($width,$height)=getimagesize($uploadedfile);
        $newheight=($height/$width)*$newwidth;
        $newheight = $newwidth;
        $tmp=imagecreatetruecolor($newwidth,$newheight);
        imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
        $filename = $path.$newwidth.'_'.$actual_image_name; //PixelSize_TimeStamp.jpg
        imagejpeg($tmp,$filename,100);
        imagedestroy($tmp);
    }
    
    
    
    
    public function resizeImage($ext,$uploadedfile,$newwidth,$path,$actual_image_name){
        
        if($ext=="jpg" || $ext=="jpeg" )
        {
        $src = imagecreatefromjpeg($uploadedfile);
        }
        else if($ext=="png")
        {
        $src = imagecreatefrompng($uploadedfile);
        }
        else if($ext=="gif")
        {
        $src = imagecreatefromgif($uploadedfile);
        }
        else
        {
        $src = imagecreatefromgif($uploadedfile);
        }
        
        list($width,$height)=getimagesize($uploadedfile);
        $newheight=($height/$width)*$newwidth;
        
        $tmp=imagecreatetruecolor($newwidth,$newheight);
        imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
        $filename = $path.$newwidth.'_'.$actual_image_name; //PixelSize_TimeStamp.jpg
        imagejpeg($tmp,$filename,100);
        imagedestroy($tmp);
    }
    
}