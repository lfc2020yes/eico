<?php
include_once ("module/tree/tree_m_class.php");

function TREE_COPY(&$row_TREE) {

  
   if (FIND_SYS(&$row_TREE)===false) $SyS=false;
 else                              $SyS=true;    //системной формы
 if ($SyS)   { $bgcolor='bgcolor=#FFFFCC';   }
 else        { $bgcolor='bgcolor=white';     }

 //Выбрать данные из _TREE по id
 $sql_MT=new Tsql('select * from '.$row_TREE["ID_TABLE"].' where id='.$_GET["id"]);
 if ($sql_MT->num>0)
 { $sql_MT->NEXT();
   
     $t = new tree_m(false,1,$sql_MT->row['PARAGRAF']);
     unset ($t); 
     if (array_key_exists("newPARAGRAF",$_POST)) $newPARAGRAF=$_POST["newPARAGRAF"]; else $newPARAGRAF='';
     if (array_key_exists("newPARENT",$_POST)) $newPARENT=$_POST["newPARENT"];else $newPARENT='';
     if (array_key_exists("newID_TABLE",$_POST)) $newID_TABLE=$_POST["newID_TABLE"];
// показать форму
?>
<div id="main">

<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data" class="theform" >
<input type="hidden" name="do" value="<?=$row_TREE["PARAGRAF"]?>" />
<!--
  <input type="hidden" name="PARAGRAF"      value="<?=$sql_MT->row["PARAGRAF"]?>" />
  <input type="hidden" name="TYPE_FORM"     value="<?=$sql_MT->row["TYPE_FORM"]?>" />
  <input type="hidden" name="ID_TABLE"      value="<?=$sql_MT->row["ID_TABLE"]?>" />
-->  
  

  <table cellspacing="0" <?=$bgcolor ?> class="theform" align="left" border="1">
  <caption><div style="padding:3px;"><?=$row_TREE["NAME"]?></div></caption>
  <tr><th>Наименование<th>текущее значение<th>новое значение></tr>
  <tr>
     <td style="padding-right: 10px">Параграф:  
     <td style="padding-right: 10px"><?=$sql_MT->row["PARAGRAF"]?>
     <td style="padding-right: 10px"><input type="text" name="newPARAGRAF"  value="<?=$newPARAGRAF?>" />
  </tr>
  <tr>
     <td style="padding-right: 10px">Родительский параграф:   
     <td style="padding-right: 10px"><?=$sql_MT->row["PARENT"]?>
     <td style="padding-right: 10px"><input type="text" name="newPARENT"  value="<?=$newPARENT?>" />
  </tr>
  <tr>
     <td style="padding-right: 10px">Новая таблица:  
     <td style="padding-right: 10px"><?=$sql_MT->row["ID_TABLE"]?>
     <td style="padding-right: 10px"><input type="text" name="newID_TABLE" value="<?=$newID_TABLE?>" />
  </tr>
<?php
   if ($_POST["do"]==$row_TREE["PARAGRAF"]) { 
       if(($newPARAGRAF<>'') and ($newPARENT<>'')) {
        $t = new tree_m(true,1,$sql_MT->row['PARAGRAF'],$newPARAGRAF,$newPARENT,$newID_TABLE); 
        unset ($t);    
       } else echo "<tfoot><tr><td colspan=3>Заполните параметры копирования</td></tr></tfoot>";
   }  
   if(($newPARAGRAF=='') or ($newPARENT=='') or ($_POST["do"]<>$row_TREE["PARAGRAF"])) {
     SHOW_tfoot(3,1,0,1);
?>
  <tfoot><tr>
    <td colspan=3 style="padding-right: 10px"><?=$row_TREE["sys_TEXT"].' ['.$sql_MT->row["NAME"].']'?></td>
      </tr></tfoot>
<?php
   }
   echo '</table></form></div>';

      
   
 } //-->num
 return true; 
}

