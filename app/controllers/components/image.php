<?
class ImageComponent extends Object
{
   function resize_img($imgname,$size)
   {
       Header("Content-Type: image/jpeg");	 
      $img_src = imagecreatefromjpeg($imgname);
      $true_width = imagesx($img_src);
      $true_height = imagesy($img_src);
 
      if ($true_width>=$true_height)
      {
        $width=$size;
        $height = ($width/$true_width)*$true_height;
      }
      else
      {
       // $height=$size;
       $width=$size;
       $height = ($width/$true_width)*$true_height;
       // $width = ($height/$true_height)*$true_width;
      }
        $img_des = imagecreatetruecolor($width,$height);
        imagecopyresampled ($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);
        return $img_des;
    }
	
	 function resize_img_gif($imgname,$size)
   {
       Header("Content-Type: image/gif");	 
      $img_src = imagecreatefromgif($imgname);
      $true_width = imagesx($img_src);
      $true_height = imagesy($img_src);
 
      if ($true_width>=$true_height)
      {
        $width=$size;
        $height = ($width/$true_width)*$true_height;
      }
      else
      {
       // $height=$size;
       $width=$size;
       $height = ($width/$true_width)*$true_height;
       // $width = ($height/$true_height)*$true_width;
      }
        $img_des = imagecreatetruecolor($width,$height);
        imagecopyresampled ($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);
        return $img_des;
    }
 
    function getFileExtension($str) {
 
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
	
	/*function test()
	{
	  echo "asasd";
	  exit;
	} */	
	
	
} 

?>