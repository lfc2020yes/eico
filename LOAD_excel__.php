<?php
header('Content-type: text/html; charset=utf-8');
?>
<head>
  <title>Load XLSX SMETA</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/'."sysadmin/run/interstroi.atsun.ru/XLS_DB.php";
//include("./XLS_DB__.php");

//function RUN_($PARAM, &$row_TREE=0)
{

  //$GT=array();
  //GET_PARAM(&$GT,$PARAM);


//echo'<form id="signupForm" class="form-fiz" action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">';


//$FN="./run/taganka62.ru/excel/catalog.xls";        //./Excel/

//echo '<p>'.$_SERVER['REQUEST_METHOD'].'</p>';

 if ($_SERVER['REQUEST_METHOD']=='GET')
 {
  //if ($row_TREE>0)   //передан адрес
  {
                                           // readonly
      echo'<form enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'" name="theform" method="post" class="theform" >';
      echo'<strong style="padding:0; margin:0;">'.'Программа подгрузки плановой сметы XLS</strong><br> ';
      echo'<input class="text" type="file" name="FileXLS" SIZE="100" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
      	   <div id="theform_visible_error" class="error" style="display:none"></div>';

      //echo'<label><input class="text" type="file" name="'.$FLD.'" /></label>';
      echo'<p><input type="submit" class="button" value="Отправить" />';
	  echo'<input type="reset" class="button" value=" Сброс " /></p>';

  	  echo '</form>';
  }
 }
 else  // Это POST
 {       $eLOAD=false;
    //-------------------------------------Копирование файла на HOST
         //echo '<p>'.' 1'  .'</p>';
         $isCorrectAddInstr = "true";
         if(isset($_FILES[ "FileXLS" ]))
         {  //echo '<p>'.' 2'  .'</p>';
			$error_flag = $_FILES[ "FileXLS"  ]["error"];
            if($_FILES[ "FileXLS"  ]["error"] == 0) $isCorrectAddInstr = "false";
         }
         //echo '<p>'.' 3'  .'</p>';

         //---------------------------------------------------
         if($isCorrectAddInstr == "false")
         {      // надо грузить  файл
            //echo '<p>'.' 4'  .'</p>';
            
            echo '<p>from: '.$_FILES[ "FileXLS" ] ["tmp_name"].'</p>';
            $name=$_FILES["FileXLS"]["name"];
            $FileName=iconv("UTF-8","WINDOWS-1251",$name);
            echo '<p>name: '.$name.'</p>'; 
            if($_FILES["FileXLS"]["type"] == 'application/vnd.ms-excel') {
               $ext = ".xls";
            } elseif ($_FILES["FileXLS"]["type"] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
               $ext = ".xlsx";
                
            }
            $FN=realpath('.').DIRECTORY_SEPARATOR.'for_load_excel'.DIRECTORY_SEPARATOR.$FileName;              //Каталог размещения файла
            $FN_=realpath('.').DIRECTORY_SEPARATOR.'for_load_excel'.DIRECTORY_SEPARATOR.$name;
            echo '<p>  to: '.$FN_.'</p>';
            //------------------------загрузка в каталог по определенному пути (с корректировкой пути)

		if(copy($_FILES[ "FileXLS" ] ["tmp_name"],$FN))
                {     echo '<p>'.$FN_. ' Файл обновлен. Ok.'    .'</p>';
  	              $eLOAD=true;
  	        }
  	           else  echo '<p>'.$FN_. ' Файл НЕ ОБНОВЛЕН !!!'  .'</p>';
         }

   if($eLOAD)
   XLS_DB( $FN);

 }  //POST
}

?>

</body>