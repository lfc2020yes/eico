<?php
header('Content-type: text/html; charset=utf-8');

include_once("./XLS_export.php");   ///run/interstroi.atsun.ru

export2XLS('Estimate',$_POST["id"],true); 

