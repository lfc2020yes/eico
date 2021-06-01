<style>
.hie li {
   
    padding: 0px;
    margin: 0px;
    font: 18px tahoma;
    white-space: nowrap;
    line-height: 80%;
    list-style-type: none;
}
.hie li a {
    text-decoration: none;
    vertical-align: 40%;
}   
.level {
        display:inline-block;   
        position:relative;
}
.level span { 
        display:inline-block;
        position:absolute;
         top:15px;   
         left:8px; 
        /*оформление текста*/
        color:blue;
        font: 14px tahoma;
        
}
</style>    
<?php

include_once '../ilib/lib_interstroi.php';
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
    
    $ret=0;
    $mysqli=new_connect(&$ret);
    //echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
  if (!$mysqli->connect_errno) {
      //echo "<p>step 3";  
  } else exit;
  //=========================================================================
          if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          }
          else { $styleH=''; $styleF=''; }
  
  ?>
  <form id="per_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="permission" value="1"/>

  <table <?=$styleF?> id="per_table" cellspacing="0" align="left" class="theform" border>            
  <caption <?=$styleH?>><div style="padding:3px; white-space: nowrap;">карта иерархии: <?=$name?></div></caption>
  <tr><td>
  <ul class="hie">
<!--
  <tr><th style="padding-right: 10px">Подпись
      <th style="padding-right: 10px" align="right">ФИО    
      <th>должность
-->
 <?php
      $hie = new hierarchy(&$mysqli,$id_user,1);
  
  echo '</ul></table>';
  echo '<p/> obj='.implode(',', $hie->obj);
  echo '<p/> user='.implode(',', $hie->user);
  echo '<p/> sign_level='.$hie->sign_level;
  echo '<p/> admin='.$hie->admin;
  echo '<p/> kvartal='.implode(',', $hie->id_kvartal);
  echo '<p/> town='.implode(',', $hie->id_town);
  
  //for ($i=0; $i<count($hie->boss);$i++) {
     echo "<p/> boss['2']=".implode(',', $hie->boss[2]); 
     echo "<p/> boss['3']=".implode(',', $hie->boss['3']);
     echo "<p/> boss['4']=".implode(',', $hie->boss['4']); 
  //}
     echo "<p/> --------- кладовщик";
     for ($i=0; $i<count($hie->obj);$i++) {
         $stock=new stock_user(&$mysqli,$hie->obj[$i],1);
         echo "<p/> stock [id_object=".$hie->obj[$i]."]=".$stock->id_stock; 
     }
     echo "<p/> --------- СЗ по заявкам";
     $FUSER=new find_user(&$mysqli,implode(',', $hie->obj),'S','Заявки',1 );
     
     for ($i=0;$i<count($FUSER->id_user);$i++) {
        echo "<p/>".($FUSER->id_user[$i]);
            
     }
     echo "<p/> --------- id_notification_user";
     $NUser = new notification_user (&$hie);
      echo '<p/> $NUser->id=['.implode(',', $NUser->id).']'; 
}

 