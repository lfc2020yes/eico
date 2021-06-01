<?
/*                          $format
                            /img/photo/s_,[FILE_NAME]_postpref,jpg;W=168;H=252;Q=100;0-4 hor;0-4 ver;0-1 inner
                             0-0                       0-1      0-2 1     2     3     4      5       6
                                           значение поля по имени                                    вписать
                                                                 none - не надо расширения
$tempfile - то что нужно грузить
&$Fname - сюда формируется полное имя файла
&$ID - главная часть имени файла
$field_type - jpg image  если image - то может быть замена $ID по расширению и не только
*/

class IMG {
var $w2;
var $h2;
var $quality;

var $iPAR;
var $pPREF;
var $pEXT;

var $BASE;   // Z:\home\atsun.rr\www

 function NumVER($name,$reEXT='')     //поддержка версионности подгрузки в имени файла _00
 {
          $Fname= explode('.',$name);
          $num=count($Fname);              //Взять последний элемент в массиве
          if ($num>1) // Присутствует явно расширение
          {   --$num;
              $ext=$Fname[$num];
          }
          else   $ext='';
          $Fn=''; $PR='';
          for ($i=0; $i<$num; $i++)
          {
          	 $Fn.=$PR.$Fname[$i];   //Собрали новое имя без расширения
             $PR='.';
          }
          $Fname= explode('_',$Fn);
          $num=count($Fname);
          if ($num>1)    //Версионность присутствует явно
          {  --$num;
          	 $ver=$Fname[$num]+1;
          }
          else   $ver=1;
          $Fn=''; $PR='';
          for ($i=0; $i<$num; $i++)
          {
            $Fn.=$PR.$Fname[$i];
            $PR='_';
          }
          if (!$reEXT=='') $ext=$reEXT;
          return  $Fn.'_'.$ver.'.'.$ext;
 }


/*
1-source
2-distination

w1 h1 - ширина высота source
w2 h2 - distination

*/  // Корректировка размера взодящего изображения
function RESIZE(&$ImSour,&$ImDest,
                 $w1,$h1,$w2,$h2,
                 $horizont=1, $vertical=2,       //с какой стороны базироваться (L C R) (T C B) 0 1 2 3 4
                 $inner=false)                    //TRUE- вписать в середину
{
  echo "<p/>horizont=$horizont vertical=$vertical inner=$inner";
  if ($inner==false)
  { $k2 = $h2/$w2;
	if ( $h1/$w1 < $k2)
	{     // нужно резать по ширине в будущей пропорции
	  // с какой стороны базироваться (L C R) 0 1 2 3 4
	  $w1_= floor($h1 / $k2);
	  switch ( $horizont)
	  { case 0:  $X1=0;
	             break;
	    case 1:  $X1=floor(($w1-$w1_)/4);
	             break;
	    case 2:  $X1=floor(($w1-$w1_)/2);
	             break;
	    case 3:  $X1=$w1-$w1_-floor(($w1-$w1_)/4);
	             break;
	    case 4:  $X1=$w1-$w1_;
	             break;	  }
	  $Y1=0;
	  echo "<p/>резать по ширине X1=$X1 Y1=$Y1 w1=$w1 h1=$h1 w1_=$w1_";
	  $w1 = $w1_;
	}
	else
	{ // нужно резать по высоте в будущей пропорции
	  // с какой стороны базироваться (T C B) 0 1 2 3 4
	  $h1_=floor($k2 * $w1)  ;
	  switch ( $vertical)
	  { case 0:  $Y1=0;
	             break;
	    case 1:  $Y1=floor(($h1-$h1_)/4);
	             break;
	    case 2:  $Y1=floor(($h1-$h1_)/2);
	             break;
	    case 3:  $Y1=$h1-$h1_-floor(($h1-$h1_)/4);
	             break;
	    case 4:  $Y1=$h1-$h1_;
	             break;
	  }
	  $X1=0;
	  echo "<p/>резать по высоте X1=$X1 Y1=$Y1 w1=$w1 h1=$h1 h1_=$h1_";
	  $h1 = $h1_;
    }
    $X2=0; $Y2=0;
  }
  else //-------------------------вписать изображение  - это значит, что вставлять нужно по без обрезки
  { $k1=$h1/$w1;                //Вписывает всегда в середину
    $X1=0; $Y1=0;

    if ( $k1 < $h2/$w2)         //нужно вписывать по горизонтали - вертикаль получиться с пустыми областями    {  $X2=0;
       $h2_= floor($k1 * $w2);
       $Y2 = floor(($h2-$h2_)/2);
 	   echo "<p/>вписать по горизонтали X2=$X2 Y2=$Y2 w2=$w2 h2=$h2 h2_=$h2_";
       $h2=$h2_;    }
    else                              //нужно вписывать по вертикали - горизонталь получиться с пустыми областями
    {  $Y2=0;
       $w2_= floor($h2 / $k1);
       $X2=  floor(($w2-$w2_)/2);
 	   echo "<p/>вписать по вертикали X2=$X2 Y2=$Y2 w2=$w2 h2=$h2 w2_=$w2_";
       $w2=$w2_;    }

    $pngtype=false;
    if ($pngtype==false)
    {      $X2=0; $Y2=0;                  //Тогда просто создается подобный файл , но вписанный по одному из размеров
      echo "<p/>png type X2=$X2 Y2=$Y2 w2=$w2 h2=$h2";
    }  }

 $errT='';
 $ImDest = imagecreatetruecolor($w2,$h2); //создаем пустое изображение с черным фоном

                        //dst_im,  src_im, dstX, dstY, srcX, srcY, dstW, dstH, srcW, srcH
 if(!imagecopyresampled ($ImDest, $ImSour,$X2,  $Y2,  $X1,  $Y1,  $w2,  $h2,  $w1,  $h1))
    $errT='Ошибка resize файла';
 return $errT;
}




	function IMG($base,$FILE_DIR) {     //конструктор
	    $this->BASE=$base;                // !!!!!!!Не используется
	    $this->iPAR=explode(';',$FILE_DIR);
        $this->pPREF=explode(',',$this->iPAR[0]);             //0-конструктор имени файла
        $this->pEXT=$this->GET_FEXT($this->pPREF[2]);                 //получить расширение - по умолчанию - jpg

        if (count($this->iPAR)>1) $this->w2=$this->iPAR[1];
        else                      $this->w2=0;
        if (count($this->iPAR)>2) $this->h2=$this->iPAR[2];
        else   { if ($this->w2>0) $this->h2=$this->w2;            //ровнять по ширине
                 else             $this->h2=0;
        }
        if ($this->w2==0 and $this->h2>0)     $this->w2=$this->h2;   //ровнять по высоте
        if (count($this->iPAR)>3 and $this->iPAR[3]>=0 and  $this->iPAR[3]<=100)
        { $this->quality=$this->iPAR[3]; }
        else $this->quality=75;
        echo("<p/>Настройка: $this->w2 | $this->h2 | $this->quality");	}

    function GET_FEXT($name,$def='jpg')   //получить расширение
    {
          $FLOAD= explode('.',$name);
          $num=count($FLOAD)-1;              //Взять последний элемент в массиве и
          if ($num>0) $ext=$FLOAD[$num];
          else        $ext=$def;
          return strtolower( $ext );
    }

     function  MAP(
                    $tempfile,                        //**
                    &$Fname , &$ID ,                  //**    Fname заполнять перед запуском для поля image
                    $horizont, $vertical ,$inner,
                    $field_type='')                   //**
 {

        //--------------------------------------------Проверка корректности загружаемого файла
      $errT='';
      do
      {
          if($tempfile=='')
          {  $errT='Не передано имя файла.';
	         break;
	      }
	      $loadEXT=$this->GET_FEXT($tempfile);                  //получить расширение загружаемого файла

		  $whitelist = array("jpg", "gif", "png","jpeg");
		  $mime=       array('image/jpeg','image/gif','image/png','image/jpeg');
          $mime_ext=   array('.jpg','.gif','.png','.jpg');


            $tip=-1;
            for ($e=0; $e<count($whitelist); $e++)                 //получение типа загружаемого файла
            { if ($loadEXT===$whitelist[$e])
              { $tip=$e;
                break;              }            }

		  if($tip==-1)
		  {  $errT=' Загружаемый файл неверного формата. Допускается только JPG,JPEG, GIF, PNG.';
		     break;
		  }

		  //-------------------------Проверка на соответствие расширения содержанию загружаемого файла
		  if (!$imageinfo = @getimagesize($tempfile))
		  {  $errT=' Невозможно получить информацию о подгружаемом файле.';
		     break;		  }
		  echo ("<p/>файл: ".$tempfile.'|'.$imageinfo['mime'].'|'.$whitelist[$tip]);
		  if($imageinfo['mime'] != $mime[$tip])
		  {  $errT=' Формат файла не соответствует его расширению: '.$imageinfo['mime'].' '.$whitelist[$tip] ;
		     break;		  }

          echo "<p/>field_type=$field_type | $Fname";
          //$Fname='';
		  if ($this->pEXT<>$loadEXT)     //Смена расширения
		  {
		    if ($field_type=='image')    //Возможна замена типов
		    {
               $ID=NAME_VER($ID.$this->pPREF[1].$this->pEXT,$loadEXT);
               echo(" Смена расширения на:".$ID);
		    }
		    else
		    {
		       $errT=' Замена типа файла недопустима: '.$this->pEXT.' '.$loadEXT ;
		       break;
		    }
		  }
		  else    //Расширение не изменилось - ведение версионности загрузок
		  {		  	if ($field_type=='image')       //Нужно значение поля IMG
		    {		       $ID=NAME_VER($Fname,$this->pEXT);        //$ID.$this->pPREF[1]
		       echo " Новая версия:".$ID;
		       $Fname=$this->BASE.$this->pPREF[0].$ID;
		    }		  }


		  if (!file_exists($tempfile))                 //Определяет, был ли файл загружен при помощи HTTP POST
		  { $errT=' файл не существует';
		    break;
		  }
          echo ("|Предварительно подгружен");
          if ($Fname=='')
              $Fname=$this->BASE.$this->pPREF[0].$ID.$this->pPREF[1].'.'.$this->pEXT;     //Сформировать полное имя файла
          echo "<p/><font color='blue'><b>$Fname</b></font>";
          //=============================================загрузка
		  list ($w1, $h1, $typI) = $imageinfo;                          //размеры подгруженного файла
		  if ($typI<0 or $typI>3)
		  {  $errT='Недопустимый тип файла: '.$typI;   //Содержание соответствует расширению
		     break;		  }

          if ($this->w2==0) // Размеры не определены
          {   $this->w2=$w1;
              $this->h2=$h1;
          }
          echo "<p/>SOURCE: $w1 x $h1 TARGET: $this->w2 x $this->h2";

        if ( ($this->w2==$w1 and  $this->h2==$h1)
          or ( $tip==1 and $field_type=='image' )) //--Размер подгрузки совпадает или GIF в поле image - просто перегрузить
        {
             echo (" Прямое копирование: $Fname");          	 if(!copy($tempfile,$Fname))
          	 { $errT="Ошибка копирования файла $Fname";
          	   break;
          	 }        }       //copy
        else
        {
          //------------------Создание пустого файла, соответствующего типу графики
		  $funcs = array(1 => 'imagecreatefromgif', 'imagecreatefromjpeg', 'imagecreatefrompng');    //Функции
		  if (!($ImgSour = $funcs[$typI]($tempfile)))         //вызов 3х разных функций
		  {  $errT='Невозможно создать файл изображения: '.$tempfile;
		     break;
          }
          echo (" Создан файл IMAGE");
          //$ImgDest resource;

          $ImgDest=0;
		  $errT=$this->RESIZE(&$ImgSour,&$ImgDest,
		                       $w1,$h1,$this->w2,$this->h2,
		                       $horizont, $vertical ,$inner);         //Вписать в целевой размер
		  if($errT=='')
		  {		       if(!imagejpeg( $ImgDest, $Fname, $this->quality))  //Преобразовать файл из image
		           $errT='Невозможно создать файл функций imagejpeg';
		  }
		  imagedestroy($ImgDest);
		  imagedestroy($ImgSour);
		  @chmod($Fname, 0755);
		} //Маппирование
	  } while(0==1); //Общий цикл загрузки
	  if ($errT<>'')
	      echo ("<p><font color='red'><b>errT=$errT</b></font></p>" );
	  return $errT;
 }
//проверка фото закончина
}
?>