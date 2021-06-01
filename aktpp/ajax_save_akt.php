<?php
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header('Content-type: text/html; charset=utf-8');

//include_once("./XLS_DB.php");
$id_act=htmlspecialchars(trim($_POST["id"]));
$id1_user=htmlspecialchars(trim($_POST["id1_user"]));
$date=htmlspecialchars(trim($_POST["date"]));
$id_doc=htmlspecialchars(trim($_POST["id_doc"]));
$mat=json_decode($_POST["mat"],true);
echo '<p>id_act='.$id_act;
echo '<p>id_user='.$id_user;
echo '<p>id1_user='.$id1_user;
echo '<p>date='.$date;
echo print_r ($mat);
if (false) {
/*
Новый акт
  получить номер акта №
  insert Z_act
  insert Z_act_material
  очистить корзину
  перейти на страницу редактирования №
сохранить акт
  update Z_act
  если idm==0 (новая позиция)
       insert Z_act_material
  else
       update Z_act_material
 очистить корзину
 перейти на страницу редактирования №

 */
if (isset($_POST['id_akt_edit']) && $_POST['id_akt_edit']>0) {    //Редактировать акт
    $new=false;
    $id_akt_edit=htmlspecialchars(trim($_POST['id_akt_edit']));
    $sqlE='update z_act set id1_user="'.$id1_user.'", id_user="'.$id_user.'" where id="'.$id_akt_edit.'"';
   //------------------------------Транзакция
    $not_errorT=TRUE;
    $link->autocommit(FALSE);
    //echo "<p/>".$sqlE; /////
    //echo "<p/> _POST['count_mat']=".$_POST['count_mat'];
    $cnt=iDelUpd($link,$sqlE,false);   //Исправить запись об акте
    if ($cnt<=1) {      // исправить и добавить информацию о материалах
        for($p=0;$p<$_POST['count_mat'];$p++) {    //----------------обойти материала
            $volI=$_POST['act_id_'.$p];  //          0                      1                       2                   3
            $arrI=explode('_',$volI);    //value="'.$row_act['ids'].'_'.$row_act['idsm'].'_'.$row_act['id_act'].'_'.$row_act['idm'].'"
            if ($arrI[3]>0 && $arrI[2]>0) {  //Редактировать
                $sqlM= 'update z_act_material set
                        id_stock="'.$arrI[0].'",
                        id_stock_material="'.$arrI[1].'",
                        count_units="'.$_POST['count_'.$p].'",
                        price_nds="'.$_POST['act_price_'.$p].'"
                        where id="'.$arrI[3].'"';
                //echo "<p/>".$sqlM;    /////
                $cnt=iDelUpd($link,$sqlM,false);
                if ($cnt>1) {
                   $not_errorT=FALSE;
                   break;
                }
            } else {  //Добавить
                $sqlM= 'insert into z_act_material
                        (id_act,id_stock,id_stock_material,count_units,price_nds)
                        VALUES
                        ("'.$id_akt_edit.'","'.$arrI[0].'","'.$arrI[1].'","'.$_POST['count_'.$p].'","'.$_POST['act_price_'.$p].'"
                        )';
                //echo "<p/>".$sqlM;    /////
                $id_mat=iInsert_1R($link,$sqlM,false);
                if ($id_mat==0) {
                   $not_errorT=FALSE;
                   break;
                }
            }
        }
    } else  $not_errorT=FALSE;
    iCommit($link,$not_errorT);
    $link->autocommit(TRUE);

} else {  //=====================================================Создать новый
}
} //1==0
