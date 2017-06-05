<?php
class Imgs{
	public $imageArr;

	/*
	*获取网页中所有img标签
	 */
	function getImgFromHttp($http){
		//取得指定位址的內容，并储存至 $text
		$text=file_get_contents($http);
		//取得所有img标签，并储存至二维数组 $match 中
		preg_match_all('/<img[^>]*>/i', $text, $match);
		return $match;
	}
	/*
	*获取字符串所有img标签
	 */
	function getImgFromString($string){
		preg_match_all('/<img[^>]*>/i', $string, $match);   
		return $match;
	}
	/*
	*将Base64编码图片转成Url
	*$path 从根目录下开始写
	 */
	function saveBase64toImg($path,$base64){
		if(empty($base64)){
			return '';
		}
        if (is_dir($_SERVER['DOCUMENT_ROOT'].$path)){  
	    }else{
	       $res=@mkdir($_SERVER['DOCUMENT_ROOT'].$path,0777,true); 
	       if ($res){
			   //echo "目录 $path 创建成功";
	       }else{
		       return "";
	       }
        }
		//修改照片
		date_default_timezone_set('PRC');//设置时区
        $t=date('Y-m-d', time());
        $str="qwertyuiopasdghjklzxcvbnm1234567890";
        $file=$t.substr(str_shuffle($str),0,6);
	    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)){
			$type = $result[2];
            $new_file = "$path/$file.{$type}";
            if (file_put_contents($_SERVER['DOCUMENT_ROOT'].$new_file, base64_decode(str_replace($result[1], '', $base64)))){
              return $new_file;
            }
        }
        return "";
	}
	/*
	*获得base64编码的图片
	*输入图片路径
	 */
/*	function base64EncodeImage ($image_file) {
	  $base64_image='';
	  $image_info = getimagesize($image_file);
	  $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
	  $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
	  return $base64_image;
	}*/
	/*
	*压缩图片
	 */
	function image_png_size_add($imgsrc,$imgdst,$maxwidth=1000){
	  list($width,$height,$type)=getimagesize($imgsrc); 
	  $new_width=$width;
	  $new_height=$height;
	  while ($new_width>$maxwidth) {
	  	$new_width*=0.9;
	  	$new_height*=0.9;
	  }
	  switch($type){ 
	    case 1: 
	      $giftype=$this->check_gifcartoon($imgsrc); 
	      if($giftype){ 
	        header('Content-Type:image/gif'); 
	        $image_wp=imagecreatetruecolor($new_width, $new_height); 
	        $image = imagecreatefromgif($imgsrc); 
	        imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height); 
	        imagejpeg($image_wp, $imgdst,100); 
	        imagedestroy($image_wp); 
	      } 
	      break; 
	    case 2: 
	      header('Content-Type:image/jpeg'); 
	      $image_wp=imagecreatetruecolor($new_width, $new_height); 
	      $image = imagecreatefromjpeg($imgsrc); 
	      imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height); 
	      imagejpeg($image_wp, $imgdst,100); 
	      imagedestroy($image_wp); 
	      break; 
	    case 3: 
	      header('Content-Type:image/png'); 
	      $image_wp=imagecreatetruecolor($new_width, $new_height); 
	      $image = imagecreatefrompng($imgsrc); 
	      imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height); 
	      imagejpeg($image_wp, $imgdst,100); 
	      imagedestroy($image_wp);
	      break; 
	  } 
	} 
	/** 
	* desription 判断是否gif动画 
	* @param sting $image_file图片路径 
	* @return boolean t 是 f 否 
	*/
	function check_gifcartoon($image_file){ 
	  $fp = fopen($image_file,'rb'); 
	  $image_head = fread($fp,1024); 
	  fclose($fp); 
	  return preg_match("/".chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0'."/",$image_head)?false:true; 
	}

	function smart_resize_image( $file,  $output = 'file' )
	{
	    /*if ( $height <= 0 && $width <= 0 ) {
	      return false;
	    }*/
	    $proportional = false;
	    $delete_original = true;
	    $use_linux_commands = false;
	    $info = getimagesize($file);
	    $image = '';
	    $final_width = 0;
	    $final_height = 0;
	    list($width_old, $height_old) = $info;
	    $width = ($width_old>600?600:$width_old)*0.9; 
	  	$height =($height_old>600?600:$height_old)*0.9; 
	    if ($proportional) {
	      if ($width == 0) $factor = $height/$height_old;
	      elseif ($height == 0) $factor = $width/$width_old;
	      else $factor = min ( $width / $width_old, $height / $height_old); 
	      $final_width = round ($width_old * $factor);
	      $final_height = round ($height_old * $factor);
	    }
	    else {    
	      $final_width = ( $width <= 0 ) ? $width_old : $width;
	      $final_height = ( $height <= 0 ) ? $height_old : $height;
	    }
	    switch ($info[2] ) {
	      case IMAGETYPE_GIF:
	        $image = imagecreatefromgif($file);
	      break;
	      case IMAGETYPE_JPEG:
	        $image = imagecreatefromjpeg($file);
	      break;
	      case IMAGETYPE_PNG:
	        $image = imagecreatefrompng($file);
	      break;
	      default:
	        return false;
	    }
	    $image_resized = imagecreatetruecolor( $final_width, $final_height );
	    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
	      $trnprt_indx = imagecolortransparent($image);
	      // If we have a specific transparent color
	      if ($trnprt_indx >= 0) {
	        // Get the original image's transparent color's RGB values
	        $trnprt_color  = imagecolorsforindex($image, $trnprt_indx);
	        // Allocate the same color in the new image resource
	        $trnprt_indx  = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
	        // Completely fill the background of the new image with allocated color.
	        imagefill($image_resized, 0, 0, $trnprt_indx);
	        // Set the background color for new image to transparent
	        imagecolortransparent($image_resized, $trnprt_indx);
	      }
	      // Always make a transparent background color for PNGs that don't have one allocated already
	      elseif ($info[2] == IMAGETYPE_PNG) {
	        // Turn off transparency blending (temporarily)
	        imagealphablending($image_resized, false);
	        // Create a new transparent color for image
	        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
	        // Completely fill the background of the new image with allocated color.
	        imagefill($image_resized, 0, 0, $color);
	        // Restore transparency blending
	        imagesavealpha($image_resized, true);
	      }
	    }
	    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
	    if ( $delete_original ) {
	      if ( $use_linux_commands )
	        exec('rm '.$file);
	      else
	        @unlink($file);
	    }
	    switch ( strtolower($output) ) {
	      case 'browser':
	        $mime = image_type_to_mime_type($info[2]);
	        header("Content-type: $mime");
	        $output = NULL;
	      break;
	      case 'file':
	        $output = $file;
	      break;
	      case 'return':
	        return $image_resized;
	      break;
	      default:
	      break;
	    }
	    switch ($info[2] ) {
	      case IMAGETYPE_GIF:
	        imagegif($image_resized, $output);
	      break;
	      case IMAGETYPE_JPEG:
	        imagejpeg($image_resized, $output);
	      break;
	      case IMAGETYPE_PNG:
	        imagepng($image_resized, $output);
	      break;
	      default:
	        return false;
	    }
	    return true;
	}

}
/*$test=new getImgs();
echo trim($test->getAttributeFromImg($test->getImgFromHttp('http://www.baidu.com')[0][0])['src'],'"');*/
?>