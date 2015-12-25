<?php
class Image
{

	/**
	+----------------------------------------------------------
	* 生成图像验证码
	+----------------------------------------------------------
	* @static
	* @access public
	* @param string $width  宽度
	* @param string $height  高度
	+----------------------------------------------------------
	* @return string
	+----------------------------------------------------------
	*/
	static function verify($randval=null,$width=48,$height=22)
	{
		$randval=empty($randval)? rand(1000,9999): $randval;
		$length=strlen($randval);
		$width = ($length*10+10)>$width?($length*10+10):$width;

		$im = imagecreate($width,$height);
		@imagefilledrectangle($im, 0, 0, $width, $height, ImageColorAllocate($im,mt_rand(100,255),mt_rand(100,255),mt_rand(100,255)));
		// 弧干扰
		for($i=0;$i<10;$i++){
			imagearc(
                $im,
                mt_rand(-10,$width),
                mt_rand(-10,$height),
                mt_rand(30,300),
                mt_rand(20,200),
                55,
                44
                ,
                imagecolorallocate($im,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100))
                );
		}
        //点干扰
		for($i=0;$i<25;$i++){
			imagesetpixel(
                $im,
                mt_rand(0,$width),
                mt_rand(0,$height),
                imagecolorallocate($im,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100))
                );
		}
		for($i=0;$i<$length;$i++) {
			imagestring(
                $im,
                5,
                $i*10+5,
                mt_rand(1,8),
                $randval{$i}, 
                ImageColorAllocate($im, mt_rand(0,100),mt_rand(0,100),mt_rand(0,100))
                );
		}
		header("Content-type: image/png");
		imagepng($im);
		imagedestroy($im);
		return $randval;
	}

	/**
	+----------------------------------------------------------
	* 生成缩略图
	+----------------------------------------------------------
	* @static
	* @access public
	+----------------------------------------------------------
	* @param string $image  原图
	* @param string $type 图像格式
	* @param string $thumbname 缩略图文件名
	* @param string $maxWidth  宽度
	* @param string $maxHeight  高度
	* @param boolean $interlace 启用隔行扫描
	+----------------------------------------------------------
	* @return void
	+----------------------------------------------------------
	*/
	static function thumb($image,$thumbname='',$maxWidth=200,$maxHeight=50,$type='',$interlace=true)
	{
		// 获取原图信息
		$i_size = getimagesize($image);
		if($i_size === false) return false;
		$info = array(
			"width"=>$i_size[0],
			"height"=>$i_size[1],
			"type"=>substr(image_type_to_extension($i_size[2]),1)
		);
		$info['type']= strtolower($info['type']=='jpg'?'jpeg':$info['type']);
		$srcWidth  = $info['width'];
		$srcHeight = $info['height'];
		$type = empty($type)?$info['type']:($type=='jpg'?'jpeg':strtolower($type));
		$interlace  =  $interlace? 1:0;
		$scale = min($maxWidth/$srcWidth, $maxHeight/$srcHeight); // 计算缩放比例
		if($scale>=1) {
			// 超过原图大小不再缩略
			$width   =  $srcWidth;
			$height  =  $srcHeight;
		}else{
			// 缩略图尺寸
			$width  = (int)($srcWidth*$scale);
			$height = (int)($srcHeight*$scale);
		}

		// 载入原图
		$createFun = 'ImageCreateFrom'.$type;
		$srcImg     = $createFun($image);

		//创建缩略图
		if($type!='gif' && function_exists('imagecreatetruecolor')){
			$thumbImg = imagecreatetruecolor($width, $height);
		}else{
			$thumbImg = imagecreate($width, $height);
		}
		
		// 复制图片
		if(function_exists("ImageCopyResampled")){
			imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth,$srcHeight);
		}else{
			imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height,  $srcWidth,$srcHeight);
		}
		
		if('gif'==$type || 'png'==$type){
			$background_color  =  imagecolorallocate($thumbImg,  0,255,0);  //  指派一个绿色
			imagecolortransparent($thumbImg,$background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
		}elseif('jpeg'==$type){ 	// 对jpeg图形设置隔行扫描
			imageinterlace($thumbImg,$interlace);
		}

		// 生成图片
		$imageFun = 'image'.$type;
		if(empty($thumbname)){
			$imageFun($thumbImg);
		}else{
			$imageFun($thumbImg,$thumbname);
		}		
		imagedestroy($thumbImg);
		imagedestroy($srcImg);
	}

}