<?
//----------------------получение уникального 20ти символьного идентификатора
function rand_string_user($chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',$name_table,$name_row,$id)
{
    do
    { $string = '';
      for ($i = 0; $i < 8; $i++)            //Формирование произвольного 8 символьного кода
      { $pos = rand(0, strlen($chars)-1);
        $string .= $chars{$pos};
      }
      $string =md5($id.$string);
      $string =substr($string,0,20);        //получение 20 символьного идентификатора
	  $results1222=mysql_query('select count(id) as r from '.$name_table.' where '.$name_row.'="'.$string.'"');
	  $row1222 = mysql_fetch_array($results1222);
	} while($row1222["r" ]!=0);                      //подбор значения пока не получиться уникальное
	return $string;
 }


 function GET_FEXT($name)   //получить расширение
 {
          $FLOAD= explode('.',$name);
          $num=count($FLOAD)-1;              //Взять последний элемент в массиве и
          if ($num>0) $ext=$FLOAD[$num];
          else        $ext='';
          return strtolower( $ext );
 }

 function NAME_VER($name,$reEXT='')     //поддержка версионности подгрузки в имени файла _00
{
          $Fname= explode('.',$name);
          $num=count($Fname);              //Взять последний элемент в массиве
          if ($num>1) // Присутствует явно расширение
          {   --$num;
              $ext=$Fname[$num];          }
          else   $ext='';
          $Fn=''; $PR='';
          for ($i=0; $i<$num; $i++)
          {          	 $Fn.=$PR.$Fname[$i];   //Собрали новое имя бех расширения
             $PR='.';
          }
          $Fname= explode('_',$Fn);
          $num=count($Fname);
          if ($num>1)    //Версионность присутствует явно
          {  --$num;          	 $ver=$Fname[$num]+1;
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
function CREATE_IMAGE(&$row_TREE,&$ImDest,&$ImSour, $w1,$h1,$w2,$h2,$horizont=1, $vertical=2, $inner=false)
{
  echo_pp(&$row_TREE,"horizont=$horizont vertical=$vertical inner=$inner");
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
	  echo_pp(&$row_TREE,"резать по ширине X1=$X1 Y1=$Y1 w1=$w1 h1=$h1 w1_=$w1_");
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
	  echo_pp(&$row_TREE,"резать по высоте X1=$X1 Y1=$Y1 w1=$w1 h1=$h1 h1_=$h1_");
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
 	   echo_pp(&$row_TREE,"вписать по горизонтали X2=$X2 Y2=$Y2 w2=$w2 h2=$h2 h2_=$h2_");
       $h2=$h2_;    }
    else                              //нужно вписывать по вертикали - горизонталь получиться с пустыми областями
    {  $Y2=0;
       $w2_= floor($h2 / $k1);
       $X2=  floor(($w2-$w2_)/2);
 	   echo_pp(&$row_TREE,"вписать по вертикали X2=$X2 Y2=$Y2 w2=$w2 h2=$h2 w2_=$w2_");
       $w2=$w2_;    }

    $pngtype=false;
    if ($pngtype==false)
    {      $X2=0; $Y2=0;                  //Тогда просто создается подобный файл , но вписанный по одному из размеров
      echo_pp(&$row_TREE,"png type X2=$X2 Y2=$Y2 w2=$w2 h2=$h2");
    }  }

 $errT='';
 $ImDest = imagecreatetruecolor($w2,$h2); //создаем пустое изображение с черным фоном

 //int  imagecopyresampled (dst_im,  src_im, dstX, dstY, srcX, srcY, dstW, dstH, srcW, srcH)
 if(!imagecopyresampled ($ImDest, $ImSour,$X2,  $Y2,  $X1,  $Y1,  $w2,  $h2,  $w1,  $h1))
    $errT='Ошибка resize файла';
 return $errT;
}

//Функция получения идентификатора файла формирования нового уникального имени файла
function GET_IMAGE5_ID($IDf,&$IDd)
{	return $IDf.'_'.++$IDd;
}

/*                          $format
                            /img/photo/s_,[FILE_NAME]_postpref,jpg;W=168;H=252;Q=100;0-4 hor;0-4 ver;0-1 inner
                             0-0                       0-1      0-2 1     2     3     4      5       6
                                           значение поля по имени                                    вписать
                                                                 none - не надо расширения
$file - то что нужно грузить
&$Fname - сюда формируется полное имя файла
&$ID - главная часть имени файла
$field_type - jpg image  если image - то может быть замена $ID по расширению и не только
*/



function  IMAGE_MAP(&$row_TREE,&$base,$file, $format, &$Fname , &$ID ,$horizont, $vertical ,$inner, $field_type='')
 {
        $iPAR=explode(';',$format);
        $pPREF=explode(',',$iPAR[0]);             //0-конструктор имени файла
        $pEXT=GET_EXT($pPREF[2]);                 //получить расширение - по умолчанию - jpg
        //echo_pp(&$row_TREE,$_GET['DB']." -> ".$base->H[$_GET['DB']][5]);


        if (count($iPAR)>1) $w2=$iPAR[1]; else $w2=0;
        if (count($iPAR)>2) $h2=$iPAR[2];
        else
        { if ($w2>0) $h2=$w2;            //ровнять по ширине
          else       $h2=0;
        }
        if ($w2==0 and $h2>0) $w2=$h2;   //ровнять по высоте
        if (count($iPAR)>3 and $iPAR[3]>=0 and  $iPAR[3]<=100)
        { $quality=$iPAR[3]; }
        else $quality=75;
        echo_pp(&$row_TREE,"$w2 -> $h2 -> $quality");
        //----------------------------------Проверка корректности загружаемого файла
      $errT='';
      do
      {
          if($_FILES[$file]['tmp_name']=='')
          {  $errT='Фото не загружена, файл не определен.';
	         break;
	      }
          echo_pp(&$row_TREE,"предварительно загружен на HTTP");
	      $tip=0;

		  $whitelist = array("jpg", "gif", "png","jpeg");
		  $mime=       array('image/jpeg','image/gif','image/png','image/jpeg');
          $mime_ext=   array('.jpg','.gif','.png','.jpg');

          $tEXT=GET_FEXT($ID.$pPREF[1].$pEXT);                     //получить расширение уже загруженного файла
          $lEXT=GET_FEXT($_FILES[$file]['name']);                  //получить расширение загружаемого файла
          echo_pp(&$row_TREE,"$tEXT->$lEXT");

           $tip=-1;
           for ($e=0; $e<count($whitelist); $e++)                 //получение типа загружаемого файла
            { if ($lEXT===$whitelist[$e])
              { $tip=$e;
                break;              }            }
		  /*
		  foreach ($whitelist as $item)
		  { if(preg_match("/$item\$/i", $_FILES[$file]['name']))   //Ищет в заданном тексте subject совпадения с шаблоном pattern
		    { $tip++;
		      break;
		    }
		  }
		  */
		  if($tip==-1)
		  { $errT='Загружаемый файл неверного формата. Допускается только JPG,JPEG, GIF, PNG.';
		    break;
		  }

          echo_pp(&$row_TREE,"правильное расширение: ".$lEXT);
		  //------------------------------------------------------Проверка на соответствие расширения содержанию загружаемого файла
		  if (!$imageinfo = @getimagesize($_FILES[$file]['tmp_name']))
		  { $errT='Невозможно получить информацию о подгружаемом файле.';
		    break;		  }
		  echo_pp(&$row_TREE,"Есть информация о файле: ".$imageinfo['mime'].' '.$whitelist[$tip]);
		  if($imageinfo['mime'] != $mime[$tip])
		  { $errT='Формат файла не соответствует его расширению: '.$imageinfo['mime'].' '.$whitelist[$tip] ;
		    break;		  }
		  echo_pp(&$row_TREE,"Формат соответствует");
          $Fname='';
		  if ($tEXT<>$lEXT)     //Смена расширения
		  {
		    if ($field_type=='image')    //Возможна замена типов
		    {  //получить в массиве $mime новый номер по $imageinfo['mime']
               /*
		       $newA=array_keys($mime,$imageinfo['mime']); //Номер в массиве типор $mime
               if ( count($newA)>0 )
               {
                  $ID=$FileLOAD[0].'_00'.$mime_ext[ $newA[0] ];         //Расширение, соответствующее типу файла
                  echo_pp(&$row_TREE,"Новое расширение:".$ID);               }
               else
               { $errT='Неизвесный формат подгружаемого файла: '.$imageinfo['mime'];
		         break;
		       }
               */
               //$FileLOAD= explode('.',$_FILES[$file]['name']);
               $ID=NAME_VER($ID.$pPREF[1].$pEXT,$lEXT);

		       //$FileLOAD= explode('.',$ID.$pPREF[1].$pEXT);
		       //$ID=$FileLOAD[0].'_0.'.$lEXT;         //Расширение, соответствующее типу файла      //теряет отрезки между точек в имени файла
               echo_pp(&$row_TREE,"Новое расширение:".$ID);
		    }
		    else
		    {
		     $errT='Замена типа файла недопустима: '.$tEXT.' '.$lEXT ;
		     break;
		    }
		  }
		  else    //Расширение не изменилось - ведение версионности загрузок
		  {		  	if ($field_type=='image')
		    {		       $ID=NAME_VER($ID.$pPREF[1].$pEXT);
		       echo_pp(&$row_TREE,"Новая версия:".$ID);
		        $Fname=$base->F[$_GET['DB']][3].$pPREF[0].$ID;
		    }		  }


		  if (!is_uploaded_file($_FILES[$file]['tmp_name']))                 //Определяет, был ли файл загружен при помощи HTTP POST
		  { $errT='файл не был загружен при помощи HTTP POST';
		    break;
		  }
          echo_pp(&$row_TREE,"Предварительно файл загружен правильно");
          if ($Fname=='')
          $Fname=$base->F[$_GET['DB']][3].$pPREF[0].$ID.$pPREF[1].$pEXT;     //Сформировать полное имя файла
          echo_pp(&$row_TREE,$Fname);
          //=============================================загрузка
		  list ($w1, $h1, $typI) = $imageinfo;
		  if ($typI<0 or $typI>3)
		  {  $errT='Недопустимый тип файла: '.$typI;
		     break;		  }
		  echo_pp(&$row_TREE,"Содержание соответствует расширению");

          if ($w2==0) // Размеры не определены
          { $w2=$w1; $h2=$h1;
          }
          echo_pp(&$row_TREE,"SOURCE: $w1 x $h1 TARGET: $w2 x $h2");

        if ( ($w2==$w1 and  $h2==$h1) or ( $tip==1 and $field_type=='image' )) //--Размер подгрузки совпадает или GIF в поле image - просто перегрузить
        {
             echo_pp(&$row_TREE,"Просто копирование  файла $Fname");          	 if(!copy($_FILES[$file]['tmp_name'],$Fname))
          	 { $errT="Ошибка копирования файла $Fname";
          	   break;
          	 }        }       //copy
        else
        {
          //------------------Создание пустого файла, соответствующего типу графики
		  $funcs = array(1 => 'imagecreatefromgif', 'imagecreatefromjpeg', 'imagecreatefrompng');    //Функции
		  if (!($ImSour = $funcs[$typI]($_FILES[$file]['tmp_name'])))         //вызов 3х разных функций
		  {  $errT='Невозможно создать файл изображения: '.$_FILES[$file]['tmp_name'];
		     break;
          }
          echo_pp(&$row_TREE,"Создан файл IMAGE из подгруженного");
          //$ImDest resource;

          $ImDest=0;
	      //$ImDest = imagecreatetruecolor($w2,$h2); //создаем пустое изображение с черным фоном
		  $errT=CREATE_IMAGE(&$row_TREE,&$ImDest, &$ImSour, $w1,$h1,$w2,$h2, $horizont, $vertical ,$inner);
		  if($errT=='')
		  {		       if(!imagejpeg( $ImDest, $Fname, $quality))  //Преобразовать файл из image
		       $errT='Невозможно создать файл функций imagejpeg';
		  }
		  imagedestroy($ImDest);
		  imagedestroy($ImSour);
		  @chmod($Fname, 0755);
		} //Маппирование
	  } while(0==1); //Общий цикл загрузки
	  echo_pp(&$row_TREE,"errT=$errT" );
	  return $errT;
 }
//проверка фото закончина

?>