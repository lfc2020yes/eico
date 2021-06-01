<?php
include_once ("module/tree/tree_m_class.php");

function TREE_DELETE(&$row_TREE) {

  
   if (FIND_SYS(&$row_TREE)===false) $SyS=false;
 else                              $SyS=true;    //системной формы
 if ($SyS)   { $bgcolor='bgcolor=#FFFFCC';   }
 else        { $bgcolor='bgcolor=white';     }

 //Выбрать данные из _TREE по id
 $sql_MT=new Tsql('select * from '.$row_TREE["ID_TABLE"].' where id='.$_GET["id"]);
 if ($sql_MT->num>0)
 { $sql_MT->NEXT();
   
     $t = new tree_m(false,2,$sql_MT->row['PARAGRAF']);
     unset ($t); 
// показать форму
?>
<div id="main">

<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data" class="theform" >
<input type="hidden" name="do" value="<?=$row_TREE["PARAGRAF"]?>" />


  <table cellspacing="0" <?=$bgcolor ?> class="theform" align="left" border="1">
  <caption><div style="padding:3px;"><?=$row_TREE["NAME"]?></div></caption>
  <tr><th colspan="2">Наименование<th>текущее значение</tr>
  <tr>
     <td style="padding-right: 10px" colspan="2">Параграф:  
     <td style="padding-right: 10px"><?=$sql_MT->row["PARAGRAF"]?>
  </tr>
  
<?php
   if ($_POST["do"]==$row_TREE["PARAGRAF"]) { 
       $t = new tree_m(true,2,$sql_MT->row['PARAGRAF']); 
       unset ($t);    
   } else {
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


