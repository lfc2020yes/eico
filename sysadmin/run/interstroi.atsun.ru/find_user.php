<?php

include_once '../ilib/lib_interstroi.php';
include_once '../ilib/Isql.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{
  
    
  $GT=array();
  GET_PARAM(&$GT,$PARAM);
     $id_object = (isset($_POST["id_object"])===false) ? 53 : $_POST["id_object"];
     $module = (isset($_POST["module"])===false) ? 'Счета' :$_POST["module"];

          if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          }
          else { $styleH=''; $styleF=''; }
  ?>        
  <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="getnumer" value="1"/>

  <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">            
  <caption <?=$styleH?>><div style="padding:3px;">поиск пользователей по доступу к модулю и объекту</div></caption>


    <tr><td style="padding-right: 10px">id_object<td>
    <input class="text"  name="id_object" size="2" value="<?=$id_object?>" />

    <tr><td style="padding-right: 10px">Модуль:<td>
    <input class="text"  name="module" size="25" value="<?=$module?>"/>
<?php
   SHOW_tfoot(4,1,1,1);

//==============================================================================
  if ($_POST["getnumer"]>0) {   
    $ret=0;
    
    $mysqli=new_connect(&$ret);
    echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
    if (!$mysqli->connect_errno) {
      echo "<p>step 3";
        $FUSER=new find_user($mysqli,$id_object,'R',$module);
        echo "<pre>".print_r($FUSER->id_user,true)."</pre>";
    }
    $mysqli->close();
?>
    <tr><td style="padding-right: 10px">номер:<td><?=$numer?>
<?php
  }
?>
  </table>
  </form>
  </html>
<?php
}
?>