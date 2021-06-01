<?php

include_once '../ilib/lib_interstroi.php';
include_once '../Ajax/master/master_connect.php ';
include_once '../ilib/Isql.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{
    
    $GT=array();
    GET_PARAM(&$GT,$PARAM);
    //echo "<p/>".json_encode($GT);
    
    if(array_key_exists('id_user',$GT))           //$_GET
    {
	$id_user=htmlspecialchars(trim( $GT["id_user"] ));
         //echo "<p/> id_user=".$id_user;
    } else exit();
    if(array_key_exists('name',$GT)) $name=htmlspecialchars(trim( $GT["name"] ));

    
  echo "<p/> id_user=$id_user name=$name";
  
  $ret=0;
  $mysqli=new_connect(&$ret);
  echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
  if (!$mysqli->connect_errno) {
    echo "<p>connect";  
    $hie = new hierarchy(&$mysqli,$id_user);
    $signedd=0;
    $ret=nariad_sign(&$mysqli,4, $signedd,$hie->sign_level, $id_user,true);
    
    switch ($signedd) {
        case 0:
            $str='РАСПРОВЕДЕНО';
            break;
        case 1:
            $str='ПРОВЕДЕНО';
            break;
        default:
            $str='Ошибочная операция - РАСПРОВЕДЕНО';
    }
    if ($ret==0)
          echo "<p/> result=".$ret.' '.$str;
    else echo "<p/> result=".$ret.' Ошибка проведения операции';
  }
  $mysqli->close();
}//end