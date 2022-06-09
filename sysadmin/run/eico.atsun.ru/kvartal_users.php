<?php

//include_once '../ilib/lib_interstroi.php';
include_once '../ilib/lib_import.php';
include_once '../ilib/Isql.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{
  
    
  $GT=array();
  GET_PARAM($GT,$PARAM);
    $id_user =  (isset($_POST["id_user"]))?$_POST["id_user"]:'';
    $id_kvartal =  (isset($_POST["id_kvartal"]))?$_POST["id_kvartal"]:'';
    $mats =  (isset($_POST["mats"]))?$_POST["mats"]:null;

  
          if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          }
          else { $styleH=''; $styleF=''; }
//$mysqli
//$id_user
//$id_kvartal
//$mats

  ?>        
  <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="kvusers" value="1"/>

  <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">            
  <caption <?=$styleH?>><div style="padding:3px;">Тест поиска пользователей, связанных с другим через объекты</div></caption>


    <tr><td style="padding-right: 10px">Пользователь передающий:<td>
    <input class="text"  name="id_user" size="60" value="<?=$id_user?>" />

    <tr><td style="padding-right: 10px">Квартал (если пользователь не указан):<td>
    <input class="text"  name="id_kvartal" size="20" value="<?=$id_kvartal?>" />

      <tr><td style="padding-right: 10px">Материальная ответственность (null 0 1):<td>
              <input class="text"  name="mats" size="1" value="<?=$mats?>" />
<?php
   SHOW_tfoot(4,1,1,1);

//==============================================================================
  if ($_POST["kvusers"]>0) {
    $ret=0;
    
    $mysqli=new_connect($ret);
    echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
    if (!$mysqli->connect_errno) {
      echo "<p>step one";
      /*
      $ku = new kvartal_users($mysqli);
      $users = $ku->get_users( $kvartals,1);
      echo "<pre> связанные пользователи [$mats]: ".print_r($users,true)."</pre>";
      */
//-----------------------------------------------------------------------------
        $ku = new kvartal_users($mysqli,true);

        if($id_user==0) { $kvartals[] = $id_kvartal; }
        else { $kvartals = $ku->get_kvartals($id_user); }

        $users = $ku->get_users($kvartals,$mats);

        echo "<pre> связанные пользователи [$mats]: ".print_r($users,true)."</pre>";

    $mysqli->close();
?>

<?php
    }
?>
  </table>
  </form>
  </html>
<?php
  }
}
?>