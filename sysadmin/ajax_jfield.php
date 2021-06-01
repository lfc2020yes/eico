<?php
header('Content-type: text/html; charset=utf-8');

include_once '../ilib/Isql.php';
/**
 * Обработчик формы jfields.php
 */
//Если форма была отправленна, то выводим ее содержимое на экран
if (isset($_POST["field"])) { 
 /*
  echo  '<p/>'.$_POST["field"] ;
  echo  '<p/>'.$_POST["data"] ;
  echo  '<p/>'.$_POST["table"] ;
  echo  '<p/>'.$_POST["order"] ; */
  
    
    $ret=0;  
    $mysqli=new_connect(&$ret);
  // echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
    if (!$mysqli->connect_errno) {
      $sql='select * from '.$_POST["table"]
          .' where '.$_POST["field"].'="'.$_POST["data"].'"'
          .' order by '.$_POST["order"]; 
    // echo '<p/>'.$sql; 
            if ($result = $mysqli->query($sql)) {
                echo '<option value = "0">не выбрано</option>';         
                while( $row = $result->fetch_assoc() ){
                   //echo '<p/>'.$i++; 
                   echo ';<option value="'.$row['id'].'">'.$row[$_POST["order"]].'</option>'; 
                }
                $result->close();  
            } else echo '<p/>'.$result;
    } 
    $mysqli->close();
}


