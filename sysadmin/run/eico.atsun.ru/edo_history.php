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
    $id_user =  (isset($_POST["id_user"]))?$_POST["id_user"]:0;
    $status_task = (isset($_POST["status_task"]))?$_POST["status_task"]:'=0';
    $only_user =  (isset($_POST["only_user"]))?$_POST["only_user"]:0;
  
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
  <caption <?=$styleH?>><div style="padding:3px;">История согласования документа</div></caption>

      <tr><td style="padding-right: 10px">тип документа (0-doc 1-acc 2-nariad):<td>
      <input class="text"  name="type" size="2" value="<?=$type?>" />

      <tr><td style="padding-right: 10px">id_doc:<td>
      <input class="text"  name="id_doc" size="2" value="<?=$id_doc?>" />

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
      $edo = new EDO($mysqli,$id_user,false);
      $arr_history = $edo->history($_POST["id_doc"], $_POST["type"]);
          echo '<pre>'.print_r($edo->arr_sql,true) .'</pre>';
          echo '<pre>'.print_r($edo->func,true) .'</pre>';
      echo '<pre>arr_history:'.print_r($arr_history,true) .'</pre>';
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