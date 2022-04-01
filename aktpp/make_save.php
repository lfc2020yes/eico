<?php
//созранить по POST состояние формы
/*
  s  ids       z_stock
  sm idsm      z_stock_material 
  a  id_act    z_act
  m  idm       z_act_material 
 
новый акт
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

$adate=htmlspecialchars(trim($_POST['date_akt']));  //получить дату "2017-02-28"
$id1_user=htmlspecialchars(trim($_POST['id1_user']));

    
//echo "<p/>id_akt_edit=".$_POST['id_akt_edit'];
//echo "<p/>save_form=".$_POST['save_form'];
if (isset($_POST['id_akt_edit']) && $_POST['id_akt_edit']>0) {    //Редактировать акт
    $new=false;
    //------------------------------Транзакция
    $not_errorT=TRUE;
    $link->autocommit(FALSE);
    
    $id_akt_edit=htmlspecialchars(trim($_POST['id_akt_edit']));  
    $sqlE='update z_act set id1_user="'.$id1_user.'", id_user="'.$id_user.'" where id="'.$id_akt_edit.'"';
   
    //echo "<p/>".$sqlE; /////
    //echo "<p/> _POST['count_mat']=".$_POST['count_mat'];
    $cnt=iDelUpd($link,$sqlE,false);   //Исправить запись об акте
    if ($cnt<=1) {      // исправить и добавить информацию о материалах
        for($p=0;$p<$_POST['count_mat'];$p++) {    //----------------обойти материала
            //echo($_POST['count_' . $p].' ');

            $volI = $_POST['act_id_' . $p];  //          0                      1                       2                   3
            $arrI = explode('_', $volI);    //value="'.$row_act['ids'].'_'.$row_act['idsm'].'_'.$row_act['id_act'].'_'.$row_act['idm'].'"
            if ($arrI[3] > 0 && $arrI[2] > 0) {  //Редактировать
                $sqlM = 'update z_act_material set 
                        id_stock="' . $arrI[0] . '",
                        id_stock_material="' . $arrI[1] . '",
                        count_units="' . $_POST['count_' . $p] . '",
                        price_nds="' . $_POST['act_price_' . $p] . '"
                        where id="' . $arrI[3] . '"';
                //echo "<p/>".$sqlM;    /////
                $cnt = iDelUpd($link, $sqlM, false);
                if ($cnt > 1) {
                    $not_errorT = FALSE;
                    break;
                }
            } else {  //Добавить
                $sqlM = 'insert into z_act_material
                        (id_act,id_stock,id_stock_material,count_units,price_nds)
                        VALUES
                        ("' . $id_akt_edit . '","' . $arrI[0] . '","' . $arrI[1] . '","' . $_POST['count_' . $p] . '","' . $_POST['act_price_' . $p] . '"
                        )';
                if (!$link->query($sqlM)) {
                    $errno = $link->errno;
                    $not_errorT = FALSE;
                    break;
                }
            }

        } 
    } else  $not_errorT=FALSE;
    iCommit($link,$not_errorT);
    $link->autocommit(TRUE);
    
} else {  //=====================================================Создать новый
$new=true;    
if (isset($_GET['zay'])) 
        $id_doc=htmlspecialchars(trim($_GET['zay']));
else    $id_doc=0;
$number=get_numer_doc(&$link,$adate,4);  // получить номер акта № 

// echo "<pre> номер докумета тип 4: [$number] от [$adate] </pre>";

//Создать акт
$sqlA= 'insert into z_act 
        (number,date,date_create,
        id0_user,id1_user,
        id_user,id_doc)
            VALUES
        ("'.$number.'","'.$adate.'","'.date('Y-m-d H:i:s').'",
        "'.$id_visor.'","'.$id1_user.'",    
        "'.$id_user.'","'.$id_doc.'"
        )';
     $id_act=iInsert_1R($link,$sqlA,false);   //Добавить запись о новом акте
     //echo '<p/>$id_act:'.$id_act;
    if($id_act>0) {            //------------------------------Транзакция
    $not_errorT=TRUE;
    $link->autocommit(FALSE);
        for($p=0;$p<$_POST['count_mat'];$p++) {    //----------------переписать материалы
            if((isset($_POST['count_' . $p]))and($_POST['count_' . $p]!=''))
            {
            //     echo '<p/>$p:'.$p;
            $volI = $_POST['act_id_' . $p];  //          0                      1                       2                   3
            $arrI = explode('_', $volI);    //value="'.$row_act['ids'].'_'.$row_act['idsm'].'_'.$row_act['id_act'].'_'.$row_act['idm'].'"
            $sqlM = ' insert into z_act_material
                    (id_act,id_stock,id_stock_material,count_units,price_nds)
                        VALUES
                    ("' . $id_act . '","' . $arrI[0] . '","' . $arrI[1] . '","' . $_POST['count_' . $p] . '","' . $_POST['act_price_' . $p] . '"
                    )';
            //      echo '<p/>$sqlM:'.$sqlM;
            if (!$link->query($sqlM)) {
                $errno = $link->errno;
                $not_errorT = FALSE;
                //          echo '<p/>query:'.$errno;
                break;
            }
        }
        }
        $ret_commit=iCommit($link,$not_errorT);
    } else $not_errorT=FALSE;
    $link->autocommit(TRUE);
    //echo '<p/>$not_errorT:'.$not_errorT.':'.$ret_commit;
    if ($not_errorT==FALSE) {   //=====================Ошибка добавления записей акта по материалам
       if ($id_act>0) {
           $sqlA= "delete from z_act where id='$id_act'";
           iDelUpd($link,$sqlA,false);
       }    
    } else {
        //setcookie('basket'.$id_user.'_'.$id_visor, "", time() + 3600*24);

      //  setcookie('material'.$id_user.'_'.$id_visor, "", time() - 100,'/',window.is_session,false);

        //echo("material".$id_user."_".$id_visor);
        global $base_cookie;

        setcookie("material".$id_user."_".$id_visor, "", time()-3600,"/", $base_cookie, false, false);

        //$clear_cookie=1; 
        //die ('material'.$id_user.'_'.$id_visor);
        header ('Location: /aktpp/edit/'.$id_act.'/');  
        exit();  
    }    
} //insert
