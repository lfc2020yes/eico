<?php

include_once '../ilib/lib_interstroi.php';
include_once '../ilib/lib_edo.php';
include_once '../ilib/Isql.php';
define('TABLE','shablon');

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{
  
    
    $GT=array();
    GET_PARAM($GT,$PARAM);
    echo "<pre>".TABLE.print_r($GT,true)."</pre>";
    if(array_key_exists('id_shablon',$GT))           //$_GET
    {
        $id=htmlspecialchars(trim( $GT["id_shablon"] ));
        echo "\n id = ".$id;
    } else exit();


    if ($ROW_role!=0) {
      $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
      $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
    } else { $styleH=''; $styleF=''; }


  ?>        
  <form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="after" value="1"/>
  <br>
  <table border="0" width="700px" <?=$styleF?> cellspacing="0" align="left" class="theform">
  <caption <?=$styleH?>><div style="padding:3px;">Последовательность выполнения операций согласования</div></caption>

    <!--table border="0" width="100%" cellpadding="1" cellspacing="1" -->


      <?
    $ret=0;
    $mysqli=new_connect($ret);
    //echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
    if (!$mysqli->connect_errno) {

      $sql = "
SELECT I.*,U.`name_user`,A.`name_action` FROM `edo_".TABLE."_items` I 
LEFT JOIN `r_user` U
 	ON (I.`id_executor`=U.`id`)
LEFT JOIN `edo_action` A
	ON (I.`id_action`=A.`id`)
WHERE I.id_".TABLE."=$id 
ORDER BY I.displayOrder
";
      //echo "<pre> sql=".print_r($sql,true)."</pre>";

    if ($result = $mysqli->query($sql)) {
        ?>
<style>
.FC6 {
    background: #FFCC66;
    font-size: large !important;
    color: white !important;
}
.fc6 td {
    background: #FFCC66;
}
.num {
    width: 30px;
    padding-left: 20px !important;
    font-size: large !important;
    color: white !important;
}
.checkker td {
    background: white;
}
.checkker td:hover {
    color: darkred;
}
</style>
        <?
        while ($row = $result->fetch_assoc()) {
            echo '<tr class="fc6">
                    <td class="num">'.$row[displayOrder].'
                    <td class="FC6">'.$row[name_items].'
                    <td>'.$row[name_user].'
                    <td style="text-align: center;">('.$row[name_action].')';



            $sql1 = "
SELECT I.id AS idItem, I.`name_items`, I.`displayOrder` AS displayItem, I.`description`, A.* 
FROM `edo_".TABLE."_items` I
	LEFT JOIN `edo_".TABLE."_item_after` A
 	ON (A.id_".TABLE."_item=".$row[id]." AND I.id=A.`id_".TABLE."_item_after`)
WHERE I.id_".TABLE."=".$row[id_.TABLE]." AND I. displayOrder < ".$row[displayOrder]." 
ORDER BY I.displayOrder      
";
            //echo "<pre> sql1=".print_r($sql1,true)."</pre>";
            if ($result1 = $mysqli->query($sql1)) {
                while ($row1 = $result1->fetch_assoc()) {
                    if  ($row1['id_'.TABLE.'_item'] == $row[id])  { $CHK='checked';  $CData=1;}
                    else  { $CHK=''; $CData=0; }
                    echo'<tr class="checkker"><td><td colspan="4"><div><input '.$CHK.' type="checkbox"
                               value="'.$CData.'"
                               name="w_'.$row1['id_'.TABLE].'_'.$row1['id_'.TABLE.'_item'].'_'.$row1['id_'.TABLE.'_item'].'_'.$row1['displayOrder']
                        .'"><label style=" padding-left:2px;" >'.$row1['displayItem'].' '.$row1['name_items'].'</label></div>';
                }
                $result1->close();
            }
        }
        $result->close();
    }

   SHOW_tfoot(4,1,1,1);

//==============================================================================
  if ($_POST["after"]>0) {
      /*$STR='delete FROM custom_kind where id_custom="'.$id_custom.'"';
      if(!mysql_query($STR))          //Выполнить INSERT
          echo "<p> Ошибка DELETE $STR</p>";
      else*/
      for ( $i=0; $i<count($_POST);$i++)        //Обход по полям формы
      {  $pst=each($_POST);
          if($pst[1]>'')              //value
          { $name=explode('_',$pst[0]);               //$name[1]-id_custom $name[2]-id_razdel $name[3]-id_type_custom
              if($name[0]=='w')
              { echo "<pre> i=$i".print_r($name,true).'</pre>';

                  /*$STR="insert into custom_kind
                         (id_custom,id_razdel,id_type_custom)
                         values ('$name[1]','$name[2]','$name[3]')";
                  if(!mysql_query($STR))          //Выполнить INSERT
                  { echo "<p> Ошибка INSERT $STR</p>";
                      break;
                  }*/
              }
          }
      }
    } 
    $mysqli->close();
  }

?>
  </table><br>
  </form>
  </html>
<?php
}
?>