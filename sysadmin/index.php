<?php
header('Content-type: text/html; charset=utf-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

session_start();
define ("SYS_DIR","sysadmin");

  $HBS=-1;            //&DB=0
  include("module/tree/login.php");

  if ($HBS>=0)
  {
     //Отмена кеширования  (здесь работает)
//     if (array_key_exists('RFR', $_GET)) {    //Refresh
				  /*header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
				  header('Cache-Control: no-store, no-cache, must-revalidate');
				  header('Cache-Control: post-check=0, pre-check=0', FALSE);
				  header('Pragma: no-cache');*/
//     }                             
	//выбор иконки отображения favicon
	if (gethostbyname($base->H[$HBS][5])=='127.0.0.1' ) $FAV='favicon.ico';
	else $FAV='favicon_cr.ico';
	if (count($base->H)==1)      $FAV='favicon_neg.ico';
	if ($base->F[$HBS][0]==true) $FAV='favicon_ftp.ico';
        
  $RUN='http://'.$_SERVER['HTTP_HOST'];     //'http://'.
  //APIKzU0BAAAA9kP0RwIAwgAadwiLzKG8iNJYwltzwwI3RXUAAAAAAAAAAABqWyxRx-a-_imE43XkcQvDf-2Lbw==
  //AO1Gyk0BAAAAdyKoVAIAdYDYxjWrc_GTC1BJRfWR4Kq31vcAAAAAAAAAAADghkpgMlc4-xO1-pPQiUyba9drkQ==
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?=$base->H[$HBS][5]?></title>
	<link rel="stylesheet" type="text/css" href="/style/tree.css" />
<!--
	<link rel="icon" type="image/x-icon" href="favicon.ico" />
-->
	<link rel="shortcut icon" type="image/x-icon" href="<?=$FAV?>" />

        
<!--Файловый PHP5
    <script type="text/javascript" src="/sysadmin/js/selectingFiles.js"></script>
-->

<!--календарь-->
    <script src="/PLUGIN/JSCal2_1_8/src/js/jscal2.js"></script>
    <script src="/PLUGIN/JSCal2_1_8/src/js/lang/ru.js"></script>
    <link rel="stylesheet" type="text/css" href="/PLUGIN/JSCal2_1_8/src/css/jscal2.css" />
<!--   <link rel="stylesheet" type="text/css" href="/PLUGIN/JSCal2_1_8/src/css/border-radius.css" />  -->
    <link rel="stylesheet" type="text/css" href="/PLUGIN/JSCal2_1_8/src/css/steel/steel.css" />
    <style type="text/css">
      .highlight { color: #f00 !important; }
      .highlight2 { color: #0f0 !important; font-weight: bold; }
    </style>

<!--календарь-->

<!-- -------------------------------------------------------------  -->
<script type="text/javascript" src="/PLUGIN/ckeditor3/ckeditor.js"></script>
<script type="text/javascript" src="/PLUGIN/AjexFileManager/ajex.js"></script>

<script src="/PLUGIN/ckeditor3/_samples/sample.js" type="text/javascript"></script>
<link href="/PLUGIN/ckeditor3/_samples/sample.css" rel="stylesheet" type="text/css"/>
<link href="/PLUGIN/ckfinder/_samples/sample.css" rel="stylesheet" type="text/css"/>


<!-- по стандарту подключаем три библиотеке в них ничего менять не надо, можно посмотреть файл mosse_ajax.js-->

<script language="javascript" type="text/javascript" src="/Js/jquery-2.1.1.js"></script>
<script language="javascript" type="text/javascript" src="/Js/jquery.ajax.js"></script>
<script language="javascript" type="text/javascript" src="/Js/respond.src.js"></script>


<!--файл в который пишем наши функции, пишется самостоятельно  -->
<script language="javascript" type="text/javascript" src="/sysadmin/js/master.js"></script>
<script language="javascript" type="text/javascript" src="/sysadmin/js/master_xy.js"></script>
<base href="<?=$RUN.'/'.SYS_DIR.'/'?>" >
</head>

<?php
function console($log,$str) {   //log info warn error   ВЫВОД НА КОНСОЛЬ
?>    
  <script type="text/javascript">
  console.<?=$log?>("<?=$str?>");
  </script> 
  <?php
}
?>
    
<body style="padding:0; margin:0;" link="red" alink="purple">



  <div id="left"  style=" display:none; position:absolute; left:0px; top:0px; border:1px solid #999999; white-space: nowrap; width:28%; height:100%; max-width:500px; overflow:scroll;">
      <!--Меню может заходить за границы полей<br><br>вот такой примерчик-->
      <!-- Меню дерева -->
 <?php
 
 /*
<script type="text/javascript" src="/Ajax/lib/JsHttpRequest/JsHttpRequest.js"></script>
<script language="javascript" type="text/javascript" src="/sysadmin/js/jquery-1.3.min.js"></script>
<script language="javascript" type="text/javascript" src="/sysadmin/js/mosse_ajax.js"></script>
  */
 
 //include("module/tree/notification.php");
 
 //console ("warn","HELLO, ПРИВЕТ");
 include("module/tree/TreeSQL_sys.php"); 
 ?>
  </div>

<script type="text/javascript">
  document.getElementById('left').style.display = 'block';
</script>  

  <div style=" position:absolute; left:29%; top:0px; min-width:1024px; width:100%; height:100%;  border:0px; ">
      <!--Правая сторона Основное содержание--   solid:#999999;  -->
<?php      
include("module/tree/tree.php"); 
?>
  </div>
</body>
<?php
console ("log","/body");
}
exit();