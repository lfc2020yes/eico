<?php

include_once '../ilib/lib_interstroi.php';
include_once '../ilib/Isql.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{
  
    
  $GT=array();
  GET_PARAM(&$GT,$PARAM);
  if (isset($_POST["date"])===false) {
     $DAY1=date("Y-m-d");    
  } else $DAY1=$_POST["date"];
  
          if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          }
          else { $styleH=''; $styleF=''; }
  ?>        
  <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="getnumer" value="1"/>

  <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">            
  <caption <?=$styleH?>><div style="padding:3px;">Получить номер документа</div></caption>


    <tr><td style="padding-right: 10px">дата:<td>
    <input class="text"  name="date" size="20" value="<?=$DAY1?>" />

    <tr><td style="padding-right: 10px">тип документа:<td>
    <input class="text"  name="type" size="2" value="1" />
<?php
   SHOW_tfoot(4,1,1,1);

//==============================================================================
  if ($_POST["getnumer"]>0) {   
    $ret=0;
    
    $mysqli=new_connect(&$ret);
    echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
    if (!$mysqli->connect_errno) {
      echo "<p>step 3";  
      $numer = get_numer_doc(&$mysqli,'"'.$_POST["date"].'"',$_POST["type"]);
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