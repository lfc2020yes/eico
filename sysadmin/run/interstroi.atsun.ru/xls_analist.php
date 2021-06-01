<?php
header('Content-type: text/html; charset=utf-8');

//include_once '../ilib/Isql.php';
include_once("./XLS_DB.php");
// Без перегрузки данных в базу данных
//echo '<br>file='.$_POST["file"];
//echo '<br>sheet='.$_POST["sheet"];
//xls_analist($_POST["file"],$_POST["sheet"],$_POST["shablon"]);
 XLS_DB( 0,$_POST["id_r1"],$_POST["id_r2"],false,$_POST["file"],$_POST["sheet"],$_POST["shablon"],true);

