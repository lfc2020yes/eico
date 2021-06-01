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
        echo "<p/> id_user=".$id_user;
    } else exit();
    if(array_key_exists('name',$GT)) $name=htmlspecialchars(trim( $GT["name"] ));
    
   $ret=0;
   $mysqli=new_connect(&$ret);
   echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
   if (!$mysqli->connect_errno) {
    echo "<p>step 3";  
    
    $role = new RoleUser(&$mysqli,$id_user);
    $role->GetPermission();
    $role->GetRows();  
    $role->GetColumns();  
  } else exit;

         if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          }
          else { $styleH=''; $styleF=''; }
?>
  <form id="per_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="permission" value="1"/>

  <table  <?=$styleF?> id="per_table" cellspacing="0" align="left" class="theform" border>            
  <caption  <?=$styleH?>><div style="padding:3px;">тест прав доступа: <?=$name?></div></caption>

  <tr><td style="padding-right: 10px">запрос
      <td style="padding-right: 10px">модуль/таблица
      <td style="padding-right: 10px" align="right">действие/объект    
      <td>права
<?php
    /*
    $modul=array('Себестоимость','Наряды','Служебные записки','Финансирование');
    for($i=0;$i<count($modul);$i++) {
        $name=iconv("WINDOWS-1251","UTF-8",$modul[$i]);    
        getPermission($role,$name,'чтение','R');
        getPermission($role,$name,'добавление','A');
        getPermission($role,$name,'редактирование','U');
        getPermission($role,$name,'удаление','D');
    }  
    */
    if($result=$mysqli->query('SELECT * FROM r_alias_table WHERE smeta=1')){
        while( $row = $result->fetch_assoc() ){
            getPermission($role,$row['alias'],'чтение','R');
            getPermission($role,$row['alias'],'добавление','A');
            getPermission($role,$row['alias'],'редактирование','U');
            getPermission($role,$row['alias'],'удаление','D'); 
            getPermission($role,$row['alias'],'С.З.','S'); 
        }
        $result->close();
    }
    
    ?>        
  <tr><td>if ($role->is_row('i_razdel1','razdel1','100'))
        <td style="padding-right: 10px">таблица: i_razdel1
        <td style="padding-right: 10px" align="right">раздел 100:<td>
<?php
    if ($role->is_row('i_razdel1','razdel1','100'))$res='разрешен'; else $res='запрещен'; 
    echo $res;        

    ?>  
    <tr><td>if ($role->is_row('i_razdel1','razdel1','90'))
        <td style="padding-right: 10px">таблица: i_razdel1
        <td style="padding-right: 10px" align="right">раздел 90:<td>
<?php
    if ($role->is_row('i_razdel1','razdel1','90'))$res='разрешен'; else $res='запрещен'; 
    echo $res;        

    ?>           
    <tr><td>$role->is_column('i_object','total_r00','разрешен','запрещен')
        <td style="padding-right: 10px">таблица: i_object
        <td style="padding-right: 10px" align="right">столбец: total_r00:<td>
<?php
    echo $role->is_column('i_object','total_r00','разрешен','запрещен');
    ?>        
    <tr><td>$role->is_column('i_object','total_m0','разрешен','запрещен')
        <td style="padding-right: 10px">таблица: i_object
        <td style="padding-right: 10px" align="right">столбец: total_m0:<td>
<?php
    echo $role->is_column('i_object','total_m0','разрешен','запрещен');

    
 ?>        
    <tr><td>$role->is_column('n_work','price','разрешен','запрещен')
        <td style="padding-right: 10px">таблица: n_work
        <td style="padding-right: 10px" align="right">столбец: price:<td>
<?php
    echo $role->is_column('n_work','price','разрешен','запрещен');  
?>        
    <tr><td>$role->is_column('n_material','price','разрешен','запрещен')
        <td style="padding-right: 10px">таблица: n_material
        <td style="padding-right: 10px" align="right">столбец: price:<td>
<?php
    echo $role->is_column('n_material','price','разрешен','запрещен');      

?>        
    <tr><td>$role->is_column('i_razdel2','summa_r2_realiz','разрешен','запрещен')
        <td style="padding-right: 10px">таблица: i_razdel2
        <td style="padding-right: 10px" align="right">столбец: summa_r2_realiz:<td>
<?php
    echo $role->is_column('i_razdel2','summa_r2_realiz','разрешен','запрещен');      
    
    
    
?>        
    <tr><td>if ($role->is_column_edit('n_work','price'))
        <td style="padding-right: 10px">таблица: n_work
        <td style="padding-right: 10px" align="right">столбец: price:<td>
<?php
    if ($role->is_column_edit('n_work','price')) echo "edit";
    else echo "not edit";
?>        
    <tr><td>if ($role->is_column_edit('n_material','price'))
        <td style="padding-right: 10px">таблица: n_material
        <td style="padding-right: 10px" align="right">столбец: price:<td>
<?php
    if ($role->is_column_edit('n_material','price')) echo "edit";
    else echo "not edit";

//==============================================================================
  //if ($_POST["permission"]>0) {                
  //   $numer = get_numer_doc('"'.$_POST["date"].'"',$_POST["type"]);

?>
  </table>
  </form>
<?php
}

function getPermission(&$role,$smeta,$name,$right){
$text=$role->codec->iconv('if ($role->permission(\''.$smeta.'\',\''.$right.'\'))');   
?>        
    
<tr><td> <?=$text?>
        <td><?=$role->codec->iconv($smeta)?><td style="padding-right: 10px" align="right"><?=$name?>:<td>
<?php
//iconv("UTF-8", "WINDOWS-1251",
    if ($role->permission($smeta,$right))  $per="Y"; else $per='N';
    echo $per;
}
