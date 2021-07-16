<?php

include_once '../ilib/lib_interstroi.php';
include_once '../ilib/lib_edo.php';
include_once '../ilib/Isql.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{
  
    
  $GT=array();
  GET_PARAM($GT,$PARAM);
  /*if (isset($_POST["date"])===false) {
     $DAY1=date("Y-m-d");    
  } else $DAY1=$_POST["date"];*/
    $id_doc =  (isset($_POST["id_doc"]))?$_POST["id_doc"]:0;
    $type =  (isset($_POST["type"]))?$_POST["type"]:0;
    $restart =  (isset($_POST["restart"]))?$_POST["restart"]:0;
  
          if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          }
          else { $styleH=''; $styleF=''; }
//$mysqli
//$id_user
//$id_doc
//$type

  ?>        
  <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="edo" value="1"/>

  <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">            
  <caption <?=$styleH?>><div style="padding:3px;">Произвести запуск процесса согласования</div></caption>


    <tr><td style="padding-right: 10px">id_doc:<td>
    <input class="text"  name="id_doc" size="2" value="<?=$id_doc?>" />

    <tr><td style="padding-right: 10px">тип документа (0-doc 1-acc 2-nariad):<td>
    <input class="text"  name="type" size="2" value="<?=$type?>" />

      <tr><td style="padding-right: 10px">restart (0 1):<td>
              <input class="text"  name="restart" size="2" value="<?=$restart?>" />
<?php
   SHOW_tfoot(4,1,1,1);

//==============================================================================
  if ($_POST["edo"]>0) {
    $ret=0;
    
    $mysqli=new_connect($ret);
    echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
    if (!$mysqli->connect_errno) {
      echo "<p>step one";
//-----------------------------------------------------------------------------
      $id_user = 777;
      $edo = new EDO($mysqli,$id_user,true);
      if (($edo->next($_POST["id_doc"], $_POST["type"],0,$restart))===false) {
          echo '<pre>'.$edo->error.'='.$edo->error_name[$edo->error].'</pre>';
          echo '<pre>'.print_r($edo->arr_sql,true) .'</pre>';
          echo '<pre>'.print_r($edo->func,true) .'</pre>';
          echo '<pre>arr_task:'.print_r($edo->arr_task,true) .'</pre>';

         if ($edo->error == 1) {
             // в array $edo->arr_task задания на согласование
         } else {

         }
      } else {
          // процесс согласования со всеми заданиями выполнен
          echo '<pre>'.$edo->error_name[$edo->error].' - процесс согласования со всеми заданиями выполнен </pre>';
      }
    } 
    $mysqli->close();
?>
    <tr><td style="padding-right: 10px">error:<td><?=$edo->error?>
<?php
  }
?>
  </table>
  </form>
  </html>
<?php
}
?>