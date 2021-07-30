<?php
ini_set ('gd.jpeg_ignore_warning', 1);
ini_set("memory_limit","10000M");


//Если в php.ini будет стоять то все будет работать
//post_max_size = 8M
//upload_max_filesize = 10M


//Вертикальные фотографии, снятые в портретном режиме на Android и iPhone сохраняются как горизонтальные, но в EXIF пишется ориентация фото. 

function image_fix_orientation($filename) {
    $exif = exif_read_data($filename);
	
if( isset($exif['Orientation']) )
        $orientation = $exif['Orientation'];
    elseif( isset($exif['IFD0']['Orientation']) )
        $orientation = $exif['IFD0']['Orientation'];
    else
        return false;	
	
	
	
    if (!empty($orientation)) {
        $image = imagecreatefromjpeg($filename);
	}
		
		
		//echo($exif['Orientation']);
switch ($orientation) {
    case 3:
        $image = imagerotate($image, 180, 0);
        break;
    case 6:
        $image = imagerotate($image, 90, 0);
        break;
    case 8:
        $image = imagerotate($image, -90, 0);
        break;
}

        imagejpeg($image, $filename, 100);
    
}


function mod($zn)
{
	if($zn<0)
	{
	  return -$zn;	
	} else
	{
	  return $zn;		
	}
}


// php image resize static class
class Rimage {
 
protected function __construct() { }
 
static $max_size = 800; # максимально допустимый размер (по ширине/высоте) уменьшенной картинки
 
static function resize($file,$path1,$path2) {
// 0 - ширина  1 - высота	
$params = getimagesize($path1); 
# в зависимости от типа оригинальной картинки применяем соответствующую функцию для считывания и создания изображения с которым будем работать
//echo($params[2]);
switch ( $params[2] ) {
  case 1: $source = @imagecreatefromgif($path1); break;
  case 2: $source = @imagecreatefromjpeg($path1); break;
  case 3: $source = @imagecreatefrompng($path1); break;
}
	
if (!$source){ $source= imagecreatefromstring(file_get_contents($path1)); }	
	
# если ширина или высота оригинальной картинки больше ограничения производим вычисления
if ( $params[0]>self::$max_size || $params[1]>self::$max_size ) {
	
	
  	
    $way='/img/index/';                           //путь к папке где хранятся фото
  $way_logo='/image/logo_shtrix.png';             //путь к логотипу
   
  $mas[0]["logo"]=0;                            //добавлять логотип на созданные фото или нет 
  $mas[0]["w"]=0;                             //ширина // или 0- если обризать не надо а просто уменьшить до $mas[0]["max"]
  $mas[0]["h"]=0;                             //высота // или 0- если обризать не надо а просто уменьшить до $mas[0]["max"]
  $mas[0]["large"]=0;                           //увеличивать или нет если загружаемая фото меньше необходимой. 1-увеличивать 0 нет  
  $mas[0]["max"]=800;                           //Максимальное значение по высоте или ширине в px. или просто 0 если фотки должны обрезаться
  $mas[0]["quality"]=100;                       //качество создаваемых миниатюр и фотографий
	
	$ip=0;
 $jpeg_quality=$mas[$ip]["quality"]; $quality=$mas[$ip]["quality"]; $oldw=0; $oldh=0;	$imgPath=$_SERVER["DOCUMENT_ROOT"].$way;
	
	list ($oldw, $oldh, $type) = $params;

	$procent=($oldh*100)/$oldw;
	$raznica1=mod(77-$procent);
	$raznica2=mod(130-$procent);	
	
	
	//горизонтальная
	if($raznica1<$raznica2)
	{
		if(($oldh>$mas[$ip]["max"])or($oldw>$mas[$ip]["max"]))
		{	 
   	      $oldw1=floor($oldw);
	      $oldh1=floor(($mas[$ip]["max"]*$oldh)/$oldw);
	      $resource = imagecreatetruecolor($mas[$ip]["max"], $oldh1); //создаем пустое изображение с черным фоном
			
	      imagecopyresampled($resource, $source, 0, 0, 0, 0, $mas[$ip]["max"], $oldh1, $oldw, $oldh);	 	
  //imagecopyresampled($resource, $source, 0, 0, 0, 0, $resource_width, $resource_height, $params[0], $params[1]);
		  	  		  
		  	
		} else
		{
		 //если горизонтальная и не нужно увеличивать до пропорция max то значит она меньше и ее можно просто скопировать в таких же размерах
	     $resource = imagecreatetruecolor($oldw, $oldh); //создаем пустое изображение с черным фоном
	     imagecopyresampled($resource, $source, 0, 0, 0, 0, $oldw, $oldh, $oldw, $oldh);	   

		}
	   
	 //вертикальная    	   
	} else
	{
		if(($oldh>$mas[$ip]["max"])or($oldw>$mas[$ip]["max"]))
		{	
   	      $oldh1=floor($oldh);
	      $oldw1=floor(($mas[$ip]["max"]*$oldw)/$oldh);
	     $resource = imagecreatetruecolor($oldw1, $mas[$ip]["max"]); //создаем пустое изображение с черным фоном
	      imagecopyresampled($resource, $source, 0, 0, 0, 0, $oldw1,$mas[$ip]["max"], $oldw, $oldh);	
		  
		  		  	
		} else
		{
	     $resource = imagecreatetruecolor($oldw, $oldh); //создаем пустое изображение с черным фоном
	     imagecopyresampled($resource, $source, 0, 0, 0, 0, $oldw,$oldh, $oldw, $oldh);

		    
		}
	   
	   
	}

	
	$exif = exif_read_data($path1);

if( isset($exif['Orientation']) )
        $orientation = $exif['Orientation'];
    elseif( isset($exif['IFD0']['Orientation']) )
        $orientation = $exif['IFD0']['Orientation'];	
	
	//echo($orientation);
	/*
if (!empty($orientation)) {

switch ($orientation) {
case 8:
 $resource = imagerotate( $resource, -90, 0 );
break;
case 3:
 $resource = imagerotate( $resource,180,0);
break;
case 6:
 $resource = imagerotate( $resource,90,0);
break;
}
} 
*/	
	
	
	//image_fix_orientation($file);
/*	
	
  # выбираем большее: ширины или высота оригинальной картинки
  if ( $params[0]>$params[1] ) $size = $params[0]; # ширина
  else $size = $params[1]; # высота
  # используя нехитрую пропорцию вычислям ширину и высоту уменьшенной картинки
  $resource_width = floor($params[0] * self::$max_size / $size);
  $resource_height = floor($params[1] * self::$max_size / $size);
  # создание "подкладки"
  $resource = imagecreatetruecolor($resource_width, $resource_height);
  # изменение размера и копирование полученного на "подкладку"
  //imagecopyresampled (resource dst_im, resource src_im, int dstX, int dstY, int srcX, int srcY, int dstW, int dstH, int srcW, int srcH)
  imagecopyresampled($resource, $source, 0, 0, 0, 0, $resource_width, $resource_height, $params[0], $params[1]);
  */
}
# если изменять размер не надо просто присваиваем переменной $resource идентификатор оригинальной картинки
else $resource = $source;
	
	
	$exif = exif_read_data($path1);

if( isset($exif['Orientation']) )
        $orientation = $exif['Orientation'];
    elseif( isset($exif['IFD0']['Orientation']) )
        $orientation = $exif['IFD0']['Orientation'];	
	
	//echo($orientation);
	
if (!empty($orientation)) {

switch ($orientation) {
case 8:
 $resource = imagerotate( $resource, 90, 0 );
break;
case 3:
 $resource = imagerotate( $resource,180,0);
break;
case 6:
 $resource = imagerotate( $resource,-90,0);
break;
}
}
	
imagejpeg($resource,$path2,100);
@chmod($path2, 0755);		
unset($resource);
unset($source);
}
 
static function resolution($path) { // строка разрешения изображения
    $size=getimagesize($path);
    return $size[0].'x'.$size[1];
}
 
static function png2jpg($originalFile, $outputFile, $quality = 80) {
    $size=getimagesize($originalFile);
    $image = imagecreatetruecolor($size[0],$size[1]);
    $c=imagecolorallocate($image,255,255,255); // white
    imagefilledrectangle($image,0,0,$size[0],$size[1],$c);
    $image1 = imagecreatefrompng($originalFile);
    imagecopyresampled($image,$image1, 0, 0, 0, 0,$size[0], $size[1],$size[0],$size[1]);  
    imagejpeg($image, $outputFile, $quality);
    imagedestroy($image1);
    imagedestroy($image);
}
 
} // end class


// класс загрузки файлов 
 
class upload {
 
protected function __construct() { }
 
//static $save_path = 'img/users/';
static $error = '';
 
static function saveimg($name,$file_end,$save_path = 'img/users/',$max_mb = 100,$exts = 'jpg|png|jpeg|gif') {
    if (isset($_FILES[$name])) {
        $f = &$_FILES[$name];
		//echo($f['name']);
        if (($f['size'] <= $max_mb*1024*1024) && ($f['size'] > 0)) {
            if (
                (preg_match('/\.('.$exts.')$/i',$f['name'],$ext))&&
                (preg_match('/image/i',$f['type']))
            ) {
                $ext[1] = strtolower($ext[1]);
                $fn = uniqid('f_',true).'.'.$ext[1];
                $fn2 = uniqid('f_',true).'.jpg';
                if (move_uploaded_file($f['tmp_name'], $save_path . $fn)) {
                    // система изменения размера , требуется Rimage
					@chmod($save_path . $fn, 0755);	
                    Rimage::resize($f,$save_path . $fn,$save_path . $file_end);
                    unlink($save_path . $fn); // удаление файла
                    return $save_path . $file_end;
                } else {
                    self::$error = 'Ошибка загрузки файла';
                }
            } else {
                self::$error = 'Неверный тип файла. Допустимые типы : <b>'.$exts.'</b>';
            }
        } else {
            self::$error = 'Неверный размер файла. Максимальный размер файла <b>'.$max_mb.' МБ</b>';
        }
    } else {
        self::$error = 'Файл не найден';
    }
    return false;
} // end saveimg
 
} // end class


