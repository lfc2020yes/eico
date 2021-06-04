<?php
/* ------------------------------local
  $dblocation ="localhost"; 
  $dbname = "interstroi";
  $dbuser = "root"; 
  $dbpasswd = "vlfcg2005"; 

*/
  /*$dblocation ="localhost";
  $dbname = "atsunru_interstroi";
  $dbuser = "atsunru_inter"; 
  $dbpasswd = "inter2017";*/

$base_cookie='soft.umatravel.club';

//$dblocation = "mysql.hosting.nic.ru";
$dblocation ="localhost";
$dbname = "atsunru_interstroi";
$dbuser = "atsunru_inter";
$dbpasswd = "inter2017";

  //$version = "1.0";
   
  mysql_set_charset("utf8");
  //mysql_set_charset("cp1251");
  $dbcnx = @mysql_connect($dblocation,$dbuser,$dbpasswd);

  if (!$dbcnx) {
    echo( "<p>connect не доступен.</p>" );
    exit();
  }
  if (!@mysql_select_db($dbname,$dbcnx) ) {
    echo( "<p>DB не доступна .</p>" );
    exit();
  }
  @mysql_query ('SET character_set_client="utf8"');
  @mysql_query ('SET character_set_connection="utf8"');
  @mysql_query ('SET character_set_results="utf8"');
  @mysql_query ('SET character_set_database="utf8"');
  @mysql_query ('SET collation_connection="utf8_general_ci"');
  $charset = mysql_client_encoding($dbcnx);
  echo "current character set is $charset <p/>";