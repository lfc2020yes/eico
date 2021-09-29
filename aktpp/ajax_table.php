<?php
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';   //$link $id_user $role
include_once $url_system.'aktpp/lib.php';
header('Content-type: text/html; charset=utf-8');


$id_visor=htmlspecialchars(trim($_POST['id_visor']));
$by=htmlspecialchars(trim($_POST['sheet']));
$id_akt=htmlspecialchars(trim($_POST['id_akt']));
$id_zay=htmlspecialchars(trim($_POST['id_doc']));

$arr=ReadCookie('material'.$id_user.'_'.$id_visor);
//$id_zay=GetCookie('doc'.$id_user);
 /*
  echo '<br><br><br>';
  echo '<p>id_visor='.$id_visor;
  echo " by=".$by;
  echo " id_user=$id_user";
  //echo " right=".$role->right[0];
  //echo " id_akt=".$id_akt;
  echo " id_zay=".$id_zay;
*/



$menu_b=array("Прием","Передача","Документы","Материалы","Черновик");
$menu_get=array("res","sen","akt","mat","work");
$menu_role_sign0=array(1,1,1,1,1);
$menu_role_sign012=array(1,1,1,1,1);
$menu_sql=array("select count(id) as kol from z_act where id1_user='$id_visor' and date1 is null and date0 is not null"
                ,"select count(id) as kol from z_act where id0_user='$id_visor' and date1 is null and date0 is not null"
                ,"select count(id) as kol from z_act where (id0_user='$id_visor' or id1_user='$id_visor') and date1 is not null and date0 is not null"
                ,"select count(m.id) as kol from z_stock_material m, z_stock s where m.id_user='$id_visor' and m.id_stock=s.id"
                ,"select count(id) as kol from z_act where id0_user='$id_visor' and date0 is null"
               );
$menu_sql1=array(' where a.summa_debt>0'
                ,''
                ,''
                ,''
                );

    $page_sql=array(
     "select *,a.id as act from z_act a left join r_user u on (a.id0_user=u.id) where a.id1_user='$id_visor' and a.date1 is null and a.date0 is not null order by a.date desc"
    ,"select *,a.id as act from z_act a left join r_user u on (a.id1_user=u.id) where id0_user='$id_visor' and a.date1 is null and a.date0 is not null order by a.date desc"
    ,"select *,a.id as act from z_act a
      left join (select id,name_user as name0 from r_user) u0 on (a.id0_user=u0.id)
      left join (select id,name_user as name1 from r_user) u1 on (a.id1_user=u1.id)
      where (a.id0_user='$id_visor' or a.id1_user='$id_visor') and a.date1 is not null and a.date0 is not null order by a.date desc"
    ,"select *, m.id as idsm from z_stock_material m, z_stock s where m.id_user='$id_visor' and m.id_stock=s.id and m.count_units>0 order by s.name"
    ,"select *,a.id as act from z_act a left join r_user u on (a.id1_user=u.id) where id0_user='$id_visor' and a.date0 is null order by a.date desc"
            );

$head_page=array(
    array("акт","дата","передающий","когда"),
    array("акт","дата","принимающий","когда"),
    array("акт","дата","от кого","кому"),
    array("Наименование","Ед.изм","Дата","Кол-во","Цена","Сумма"),
    array("акт","дата","принимающий","когда")
);
$field_page=array(
    array("number","date","name_user","date0"),
    array("number","date","name_user","date0"),
    array("number","date","name0","name1"),
    array("name","units","date_res","count_units","price","subtotal"),
    array("number","date","name_user","date0"),
);
$field_span=array(
    array("","","",""),
    array("","","",""),
    array("","","",""),
    array('',"","",""   //block_i
        ,'<span class="s_j pay_summ font16">','<span class="s_j pay_summ font16">'),
    array("","","",""),
);  
$field_type=array(
    array("","","",""),
    array("","","",""),
    array("","","",""),
    array('',"","",""   //block_i
        ,'money','money'),
    array("","","",""),
);  
$field_button=array(
    array("","","",""),
    array("","","",""),
    array("","","",""),
    array('<div class=""st_div"><i class=""></i></div>',"","","") //<span class="font-rank22">*</span>"
);
//------------------------------------------------menu


include_once $url_system.'aktpp/top_prime_aktpp.php';
//echo " title_key=$title_key";


echo'<div id="fullpage" class="margin_60  input-block-2020 ">
    <div class="oka_block_2019" style="min-height:auto;">
 <div class="oka_block">
<div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">';


echo'<div class="content_block" id_content="'.$id_visor.'">';   //???????



//------------------------------------------Настройка списка Visor [S]
if($role->permission('Прием-Передача','S'))  {    //  [S] !!!!
    // $visor_style='style=" float:left; margin-bottom: 10px; min-width: 30%; max-width: 50%;'; //width:50%;
     $show_visor=true;
} else {
    //$visor_style='style="display: none;';
    $show_visor=false;
}

    //echo '<div style="height:70px;">';              //Общая полоса панели
    //echo '<div class="_50_na_50_1" '.$visor_style.' ">';
    //echo '<div class="_50_x">';
if ($show_visor) {
    echo '<div class="input-width m10_right m10_left" >';  //margin-right: 10px;


    //====================================Список пользователей
        // ограничить объектами
        // не выводить себя самого, если это не S  (не надо)
	$result_t=mysql_time_query($link,'
select us.*, count(m.id) as mat
from (
Select u.id,u.name_user,count(a.id) as akt_out
from
r_user u left join
(select * from z_act where date1 is null and date0 is not null)
a on (u.id=a.id0_user)
where u.enabled=1
group by u.name_user
) us left join z_stock_material m on ( us.id=m.id_user)
group by us.name_user
order by us.name_user
');
        if($result_t->num_rows>0)
        {
             //==========================================
            echo'<div class="select_box visor_box" id="user_select" id_user="'.$id_user.'" >'   //eddd   $_POST['ispol_work']
              . '<a class="slct_box '.iclass_('ispol_work',$stack_error,"error_formi").' '.$status_class
                    .'" style="margin-bottom: 0px;"' 
                    .' data_src="0">'
              . '<span class="ccol">'.ipost_x($id_visor,$id_user,"Ответственный","r_user","name_user",$link).'</span>'
              . '</a><ul class="drop_box" >';   //style="display:block"
               //=====================Возможные получатели документа

            for ($i=0; $i<$result_t->num_rows; $i++)
            {
                $row_t = mysqli_fetch_assoc($result_t);
                echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name_user"]
                .'</a><div class=info_mat><font size="1" color="grey"> [акты: '.$row_t["akt_out"].' мат: '.$row_t["mat"].']</font></div></li>';
            }
            echo'</ul>'
            . '<input defaultv="'.ipost_x($id_visor,$id_user,"0")
                    .'" '.$status_edit
                    .' name="ispol_work" '
                    . 'id="ispol" '
                    . 'value="'.ipost_x($id_visor,$id_user,"0")
                    .'" type="hidden">'
            . '</div>';
        }
        //=========================================Заявки на обработку материалов
if ($title_key==3) {
    $hie = new hierarchy($link,$id_user);
// (11,5,9)
    $res_zay=mysql_time_query($link,'
Select z.*,u.name_user,s.name_status from z_doc z, r_user u, r_status s
where z.ready=1
and z.status in (13,14,15,9) 
and z.id_object in ('.implode(',',$hie->obj).')
and z.id_user=u.id
and s.id_system = 13 
and z.status=s.numer_status
order by date');
    if($res_zay->num_rows>0) {
        if ($id_zay>0) $cls='red_select'; // redass error_formi
        else $cls='';
        echo'<div class="select_box visor_box" id="zay" id_user="'.$id_user.'" >'   //eddd   $_POST['ispol_work']
              . '<a class="slct_box '.$cls.' '.iclass_('ispol_work',$stack_error,"error_formi").' '.$status_class
                .'" style="margin-bottom: 0px;"' 
                .' data_src="0">'
              . '<span class="ccol">'.get_box_data($id_zay,"все материалы [Заявки]"
,"z_doc"
//0   1     2     3    4    5     6    7           8     9    10   11         12
,"id,№ ,id, ,от ,date, ,отв: ,name_user, ,[,name_status,]"
,$link
,'Select z.*,u.name_user,s.name_status from z_doc z, r_user u, r_status s
where z.id="'.$id_zay.'"
and z.id_user=u.id
and z.status=s.numer_status'
                      ).'</span>'
              . '</a><ul class="drop_box" >';
        echo'<li><a href="javascript:void(0);"  rel="">все материалы</a></li>';
            for ($i=0; $i<$res_zay->num_rows; $i++)
            {
                $row_z = mysqli_fetch_assoc($res_zay);
                echo'<li><a href="javascript:void(0);" class="my-new-2021-list"  rel="'.$row_z["id"]
                        .'">№ '.$row_z['id']
                        .' ('.date_ex(0,$row_z['date'])
                        .') '.$row_z['name'].' <span style=" font-size: 11px;
opacity: 0.4;">('.$row_z['name_user'].')</span>
                    <span class="gray-date">'.$row_z['name_status'].'</span>
                        </a></li>';
            }
        echo'</ul>'
            .'<input defaultv="'.ipost_x($id_zay,"0","0")
                    .'" '.$status_edit
                    .' name="doc_zay" '
                    . 'id="doc_zay" '
                    . 'value="'.ipost_x($id_zay,"0","0")
                    .'" type="hidden">';
        echo '</div>';
        if ($id_zay>0) {
            $sqlZ='select * from z_doc_material where id_doc="'.$id_zay.'"';    //Получить материал по заявке
            $result_Z=mysql_time_query($link,$sqlZ);
            $COMA=''; $arrZ='';
            for ($m=0; $m<$result_Z->num_rows; $m++) {
                $rowZ= mysqli_fetch_assoc($result_Z);
                $arrZ.=$COMA.$rowZ['id_stock'];
                $COMA=',';
            }
            unset( $result_Z);
            if ($m>0) {             //Кнопка - получить акт по заявке

                echo '<div style="display: inline-block;">
                            <a class="user_press key_zay"
                            data-tooltip="создать акт по заявке"
                            href="aktpp/make/0/'.$id_zay.'/">
                            <i></i></a></div>';
                echo '<div style="display: inline-block;">
                            <a class="user_press key_zay_view"
                            data-tooltip="посмотреть заявку"
                            href="app/'.$id_zay.'/">
                            <i></i></a></div>';
                
            }
        }
    }
    echo '</div>'; //</div></div>';
  }
}
//==================================Таблица
echo '<div id="table_sheet" >';

$count_write=20;  //количество выводимых записей на одной странице

if ($title_key==3 && $id_zay>0) {
    $sqlP="
select s.name,s.units,m.date_res,m.count_units,m.price,m.subtotal,
m.id as idsm,z.count_units as countz
from z_stock_material m, z_stock s, z_doc_material z
where m.id_user='$id_visor'
and z.id_doc='$id_zay'
and m.id_stock in ($arrZ)
and m.id_stock=s.id
and m.id_stock=z.id_stock
and z.count_units > 0
order by s.name";

}   else {
    $sqlP=$page_sql[$title_key].limitPage('str',$count_write);
}   //echo('!'.$title_key. " ".$sqlP);
$result_t2=mysql_time_query($link,$sqlP);
$num_results_t2 = $result_t2->num_rows;
if($num_results_t2!=0) {

echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2"><thead>
     <tr class="title_smeta"><th class="t_1"></th>';
//=======================заголовок таблиц
 for ($n=0;$n<count($head_page[$title_key]);$n++) {
        if ($field_type[$title_key][$n]=='money') 
            echo '<th style="text-align: right;">';
        else echo '<th class="t_1">';
        echo $head_page[$title_key][$n].'</th>';
 }
 echo'<th class="t_10"></th></tr></thead><tbody>';

for ($ksss=0; $ksss<$num_results_t2; $ksss++) {
    $row__2= mysqli_fetch_assoc($result_t2);

    if ($title_key<>3) {
        $sql_MAT=  'select * from z_act_material m, z_stock s
                    where m.id_act="'.$row__2['act'].'"
                    and m.id_stock=s.id';
        $result_MAT=mysql_time_query($link,$sql_MAT);
        echo '<tr class="nary n1n" id="row_'.$row__2["act"].'">';
        //echo '<div class="akt_row" id="row_'.$row__2['act'].'>';
        if ($result_MAT->num_rows>0) {
            echo '<td class="plus_table" id="'.$row__2["act"].'"><i>+</i></td>';
        }   else {
            echo '<td></td>';   //нет тела акта
        }
    }   else {          //это страница материалы  //nary n1n   jop n1n checher
        if(($role->permission('Прием-Передача','A'))
        or  (($role->permission('Прием-Передача','U')) and (isset($_GET['id'])) and ($_GET['id']>0))
                or($sign_admin==1)) {
            if (IsDataIn(&$arr,$row__2["idsm"])) { $ok='y'; $ok_st='active_yy'; }
            else { $ok=''; $ok_st=''; }

            echo '<tr class="nary n1n">'
               . '<td class="middle_" style="width: 5%;">'
              . '<div class="mat_div_x '.$ok_st.'" id="'.$row__2["idsm"].'" id_usv="'.$id_user.'_'.$id_visor.'"><i></i></div></td>';
        } else
          echo '<tr class="nary n1n"><td></td>';

    }
    //================================================данные полей  !!!!!
    for ($n=0;$n<count($field_page[$title_key]);$n++) {
        if ($title_key==3 && $n==3 && $id_zay>0) $countz='<div class="red_select"> ('.$row__2['countz'].')</div>';
        else $countz='';
        
        
        if ($field_type[$title_key][$n]=='money') {
            echo '<td align="right">'.$field_span[$title_key][$n]; 
            echo number_format($row__2[$field_page[$title_key][$n]], 2, '-', ' ');  
        } else {
            $alien = '';
            //$alien = ($title_key==3 and $n=0 and $row__2[alien]==1) ? "name_invoice_dava dava" : '';
            echo "<td class='no_padding_left_ pre-wrap $alien'>{$field_span[$title_key][$n]}";  //class="name_invoice_dava dava"
            echo $row__2[$field_page[$title_key][$n]];
        }
        echo $countz;
    }
    echo'<td>';
    if ($title_key<>3) {
        echo'<a target="_blank" href="aktpp/print/'.$row__2['act'].'/" class="font-rank22"  id_rel="'.$row__2['act'].'"><span class="font-rank-inner">*</span></a>';
    }
    if ($title_key==1) {
      if(($role->permission('Прием-Передача','U'))or($sign_admin==1)) {
        echo'<a target="_self" '
        . 'href="aktpp/edit/'.$row__2['act'].'/revers/"'
        . 'class="font-rank22" style="margin-left: 6px;" data-tooltip="Отозвать на доработку"'
        . 'id_rel="'.$row__2['act'].'">'
                . '<span class="font-rank-inner">3</span>'
        . '</a>';
      }
    }
    if ($title_key==0) {  //принять
        if(!( (($role->permission('Прием-Передача','S'))or($sign_admin==1) )
                and 
              ($id_visor<>$id_user)) 
           ) {
            echo '<div class="accept" id="div'.$row__2['act'].'" id_rel="'.$row__2['act'].'" style="display: inline-block;">';
            echo '<a target="_blank"  class="font-rank22" data-tooltip="Принять документ" >'
                    . '<span class="font-rank-inner" id="akt'.$row__2['act'].'">S</span></a>';
            echo '</div>';
        }
    }
    if ($title_key==4) {  //Редактировать без корзины
      if(($role->permission('Прием-Передача','U'))or($sign_admin==1)) {
        echo'<a target="_self" '
        . 'href="aktpp/edit/'.$row__2['act'].'/"'
        . 'class="font-rank22" style="margin-left: 6px;" data-tooltip="Редактировать"'
        . 'id_rel="'.$row__2['act'].'">'
                . '<span class="font-rank-inner">3</span>'
        . '</a>';
      }
      if(($role->permission('Прием-Передача','D'))or($sign_admin==1)) {
         echo '<div class="del_akt" id="del'.$row__2['act'].'" id_rel="'.$row__2['act'].'" style="display: inline-block;">';
         echo '<a target="_blank"  class="font-rank22" style="margin-left: 6px;" data-tooltip="Удалить" >'
            . '<span class="font-rank-inner" '
            . 'id="akt'.$row__2['act'].'">x</span></a>';
         echo '</div>';
      }

    }
    echo'</td></tr>';
    if ($title_key<>3) {
       //=================================================содержание акта
       if ($result_MAT->num_rows>0) {
           echo '<tr class="block_i" id="mat'.$row__2["act"].'" style="display:none"><td>&nbsp;</td>&nbsp;<td>&nbsp;</td><td colspan="'.(count($field_page[$title_key])-1).'">'
                   .'<table class="smeta3"><tr class="fonth"><th>&nbsp;<th align="left">наименование<th>ед.изм<th align="right">кол-во<th align="right">цена<th align="right">сумма<th>&nbsp;';

           for ($j=0;$j<$result_MAT->num_rows;$j++) {

                $row_MAT= mysqli_fetch_assoc($result_MAT);
                echo '<tr><td>&nbsp;<td>'.$row_MAT['name']
                            .'<td align="center">'.$row_MAT['units']
                            .'<td align="right">'.$row_MAT['count_units']
                            .'<td align="right"><span class="pay_summ font16">'.number_format($row_MAT['price_nds'], 2, '-', ' ').'</span>'
                            .'<td align="right"><span class="pay_summ font16">'.number_format($row_MAT['subtotal'], 2, '-', ' ').'</span>'
                            .'<td></tr>'
                            ;
           }
            echo '</table><td>&nbsp;</td></tr>';
       }
    }
}    //список данных на странице
echo'</tbody></table>';
echo '</div>';
}

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';