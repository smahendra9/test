<?
class FunctionsComponent extends Object
{
 var $components = array("Image","Test");
/* for paging */

        function ShowNavigator($a, $offset, $q, $path, &$out)
        { 	
		//shows navigator [prev] 1 2 3 4 … [next]
		//$a - count of elements in the array, which is being navigated
		//$offset - current offset in array (showing elements [$offset ... $offset+$q])
		//$q - quantity of items per page
		//$path - link to the page (f.e: "index.php?categoryID=1&")

		if ($a > $q) //if all elements couldn't be placed on the page
		{

			//[prev]
			if ($offset>0) $out .= "<a href=\"".$path.($offset-$q)."\"><img src='".WEBSITEURL."/app/webroot/img/ar1.gif' align='bottom'></a> &nbsp;";

			//digital links
			$k = $offset / $q;

			//not more than 4 links to the left
			$min = $k - 5;
			if ($min < 0) { $min = 0; }
			else {
				if ($min >= 1)
				{ //link on the 1st page
					$out .= "<a href=\"".$path."0\">[1]</a> &nbsp;";
					if ($min != 1) { $out .= "... &nbsp;"; };
				}
			}

			for ($i = $min; $i<$k; $i++)
			{
				$m = $i*$q + $q;
				if ($m > $a) $m = $a;

				$out .= "<a href=\"".$path.($i*$q)."\">[".($i+1)."]</a> &nbsp;";
			}

			//# of current page
			if (strcmp($offset, "show_all"))
			{
				$min = $offset+$q;
				if ($min > $a) $min = $a;
				$out .= "[".($i+1)."] &nbsp;";
			}
			else
			{
				$min = $q;
				if ($min > $a) $min = $a;
				$out .= "<a href=\"".$path."0\">[1]</a> &nbsp;";
			}

			//not more than 5 links to the right
			$min = $k + 6;
			if ($min > $a/$q) { $min = $a/$q; };
			for ($i = $k+1; $i<$min; $i++)
			{
				$m = $i*$q+$q;
				if ($m > $a) $m = $a;

				$out .= "<a href=\"".$path.($i*$q)."\">[".($i+1)."]</a> &nbsp;";
			}

			if ($min*$q < $a) { //the last link
				if ($min*$q < $a-$q) $out .= " ... &nbsp;";
				$out .= "<a href=\"".$path.($a-$a%$q)."\">[".ceil(($a/$q))."]</a> ";
			}

			//[next]
			if ($offset<$a-$q) $out .= "<a href=\"".$path.($offset+$q)."\"><img src='".WEBSITEURL."/app/webroot/img/ar.gif'></a>";

			//[show all]
			/*if (strcmp($offset, "show_all"))
				$out .= " <a href=\"".$path."show_all=yes\">[".STRING_SHOWALL."]</a>";
			else
				$out .= " [".STRING_SHOWALL."]";*/

		}
}

   function timediff($time)
   {
		$startdate=$time;
		if($startdate>=24)
		{
			 $days=intval($startdate/24);
			 $hours=intval($startdate%24);
			 $format= $days." days and ".$hours." hours"; 
		}
		else
		{
			$format= intval($startdate)." hours"; 
		}  
	  return $format; 	 
   }

function saveDate($dt)
{
    return date("Y-m-d",strtotime($dt));

}

function displayDate($dt)
{
    return date("d-m-Y",strtotime($dt));

}

  function photoupload($name,$dist,$modal)
  {
		 
		  $temp="";
		  if (strlen($name['name'])>4)
		  {
					   
				   $error = 0;
				   $uploaddir1 = $dist; // the /big/ directory
				  // $uploaddir2 = "foto/small"; // the /small/ directory with resized images
				   
				   $filetype = $this->Test->getFileExtension($name['name']);
				   //echo $filetype;exit;
				  // $filetype = 'jpeg';// strtolower($filetype);                   
				   if (($filetype != "jpeg")  && ($filetype != "jpg") && ($filetype != "gif") && ($filetype != "png"))
				   {
					  $error=1;
				   }
				   else
				   {
					   $imgsize = getimagesize($name['tmp_name']); // image size					
				   }
				   if (($imgsize[0]> 800) || ($imgsize[1]> 600))
				   {
					   
					  // verify to see if the image exceds 800 x 600 px
					   unlink($name['name']); // delete the image in case is to big
					   $error=1;
				   }
					
				   if ($error==0)
					{
						  
						  // here is generated an unic id for the image name
						  $stamp = $_SESSION['Userid'].strtotime ("now").rand(0,99999);
						  $orderid = $stamp;
						  $orderid = str_replace(".", "", $orderid);
						  $id_unic = $orderid;
						  $temp = $id_unic;
						  settype($temp,"string");
						  $temp.= ".";
						  $temp.=$filetype;
						  $newfile = $uploaddir1 . "/$temp";
					   
						if (is_uploaded_file($name['tmp_name']))
						{
							if (!copy($name['tmp_name'],$newfile))
							{
								echo $newfile;
								print "Error Uploading File1.";
								exit(); 
							}
							else
							{
								
								 if (($filetype == "jpeg")  || ($filetype == "jpg"))
								 {
										
										$img_des= $this->Test->resize_img($newfile, 110); //here resizing
										imagejpeg($img_des,$newfile,80);
										$border=2; // Change the value to adjust width
										$im=imagecreatefromjpeg($newfile);
										$width=imagesx($im);
										$height=imagesy($im); 
										$img_adj_width=$width+(2*$border);
										$img_adj_height=$height+(2*$border);
										$newimage=imagecreatetruecolor($img_adj_width,$img_adj_height);
										$border_color = imagecolorallocate($newimage, 100, 255, 100);
										imagefilledrectangle($newimage,0,0,$img_adj_width,$img_adj_height,$border_color);
										imageCopyResized($newimage,$im,$border,$border,0,0,$width,$height,$width,$height);
										ImageJpeg($newimage,$newfile,80); // change here to $add2 if a new image is to be
										
										
								 }
								 if ($filetype == "gif")
								 {
								   
									$img_des= $this->Test->resize_img_gif($newfile, 110); //here resizing								   
									imagegif($img_des,$newfile);	
									
										$border=2; // Change the value to adjust width
										$im=imagecreatefromgif($newfile);
										$width=imagesx($im);
										$height=imagesy($im); 
										$img_adj_width=$width+(2*$border);
										$img_adj_height=$height+(2*$border);
										$newimage=imagecreatetruecolor($img_adj_width,$img_adj_height);
										$border_color = imagecolorallocate($newimage, 100, 255, 100);
										imagefilledrectangle($newimage,0,0,$img_adj_width,$img_adj_height,$border_color);
										imageCopyResized($newimage,$im,$border,$border,0,0,$width,$height,$width,$height);
										imagegif($newimage,$newfile,80);											   
								 } 
								 if ($filetype == "png")
								 {
								   
									$img_des= $this->Test->resize_img_png($newfile, 110); //here resizing								   
									imagepng($img_des,$newfile);	
									
										/*$border=2; // Change the value to adjust width
										$im=imagecreatefrompng($newfile);
										$width=imagesx($im);
										$height=imagesy($im); 
										$img_adj_width=$width+(2*$border);
										$img_adj_height=$height+(2*$border);
										$newimage=imagecreatetruecolor($img_adj_width,$img_adj_height);
										$border_color = imagecolorallocate($newimage, 100, 255, 100);
										imagefilledrectangle($newimage,0,0,$img_adj_width,$img_adj_height,$border_color);
										imageCopyResized($newimage,$im,$border,$border,0,0,$width,$height,$width,$height);
										imagepng($newimage,$newfile,80);*/											   
								 } 
								 
							}
						}			 
					 
				   } 

		  }
		  return $temp;
  }
  
  function musicupload($name,$dist,$modal)
  {
		 
		  ini_set("upload_max_filesize","10M");
		  
		 
		  $temp="";
		 
		  if (strlen($name['name'])>4)
		  {
					   
				   $error = 0;
				   $uploaddir1 = $dist; // the /big/ directory
				  // $uploaddir2 = "foto/small"; // the /small/ directory with resized images
				   
				   $filetype = $this->Test->getFileExtension($name['name']);
				  // echo $filetype;exit;
				  // $filetype = 'jpeg';// strtolower($filetype);                   
				   if (($filetype != "mp3")  && ($filetype != "wmv") && ($filetype != "wav") )
				   {
					  $error=1;
				   }
				   if ($error==0)
					{
						  
						  // here is generated an unic id for the image name
						  $stamp = $_SESSION['Userid'].strtotime ("now").rand(0,99999);
						  $orderid = $stamp;
						  $orderid = str_replace(".", "", $orderid);
						  $id_unic = $orderid;
						  $temp = $id_unic;
						  settype($temp,"string");
						  $temp.= ".";
						  $temp.=$filetype;
						  $newfile = $uploaddir1 . "/$temp";					   
						if (is_uploaded_file($name['tmp_name']))
						{
						  
							if (!copy($name['tmp_name'],$newfile))
							{
								echo $newfile;
								print "Error Uploading File1.";
								exit(); 
							}
							
							
						}			 
					 
				   } 

		  }
		  return $temp;
  }



function m3ufile($id=null,$filenames=null,$prefix=null)
{
  $fp=fopen('music/'.$prefix.$id.".m3u","w");
  $str="";
  foreach($filenames as $f)
  {
    $str.=WEBSITEURL."music/".$f."\r\n";
  }
  fputs($fp,$str);
  fclose($fp);
   
}

function remove_element($arr, $val)
{
	
	foreach ($arr as $key => $value)
	{
		if ($arr[$key] == $val)
		{
			unset($arr[$key]);
		}
	}
	return $arr = array_values($arr);
}

}
?>
