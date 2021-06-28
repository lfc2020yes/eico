<?php
$sys=$_SERVER['DOCUMENT_ROOT'];
include_once $sys.'/Ajax/master/master_connect.php';

function new_connect(&$ret,$charset="utf8") {   
    $base=new Thost2;
    
    if (array_key_exists('DB', $_GET))
       $numDB=$_GET['DB']; 
    elseif (array_key_exists('db', $_POST))
       $numDB=$_POST['db'];     
    else $numDB=0;  
     $h= $numDB;
    /*echo "<div class='div_info' id='info'>"
                             . "<br>numDB: $numDB"
                             . "<br>base: h[$h][0]=".$base->H[$h][0]
                             . '<br>каталог: '.getcwd()
                             . "</div>";*/
    $dblocation = $base->H[$h][0];
    $dbname = $base->H[$h][1];
    $dbuser = $base->H[$h][2];
    $dbpasswd = $base->H[$h][3];
    do {
         $mysqli = new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
         if ($mysqli->connect_errno) {
             $ret=$mysqli->connect_errno;
             break;
         }
         // Установить кодировку
         if (!$mysqli->set_charset($charset)) {
             $ret=$mysqli->errno;
             break;
         }
    } while (1==0);
    return $mysqli;
}

function iAuto($mysqli) {           // Не используется
  $mysqli->autocommit(FALSE);
}
function iInsert_1R($mysqli,$sql,$show=true) {   // Добавление только 1й записи
  $id=0;    
  if (!$mysqli->query($sql)) {
            //$ret=$mysqli->errno;
            if($show) echo "<p/>(".$mysqli->errno.')'.$sql;
  } else {
            $arows=$mysqli->affected_rows;
            if ($arows==1) {
               $id=$mysqli->insert_id;
            }
  }
  return $id;
}
function iDelUpd($mysqli,$sql,$show=true) {   // Добавление только 1й записи
  $arows=false;
  
  if (!$mysqli->query($sql)) {
            if($show) echo "<p/>(".$mysqli->errno.')'.$sql;
  }
  if($show) echo "<p/>".$sql.' arows='.$mysqli->affected_rows ;
  return $mysqli->affected_rows;
}

function iCommit($mysqli,$type) {   // Не используется
    if ($type)  $ret=$mysqli->commit();
    else        $ret=$mysqli->rollback(); 
    return $ret;
}


  