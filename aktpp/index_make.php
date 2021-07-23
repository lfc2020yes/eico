<?php
session_start();
$clear_cookie=0;
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/config.php';
include_once $url_system.'module/function.php';
include_once $url_system.'login/function_users.php';
include_once $url_system.'aktpp/lib.php';
initiate($link);
include_once $url_system.'module/access.php';
$hie = new hierarchy($link,$id_user);

$role->GetColumns();
$role->GetRows();
$role->GetPermission();
//if(($role->permission('Прием-Передача','R'))or($sign_admin==1))   //RAUD S- Супервизор, управление чужими актами
$active_menu='aktpp/res';  // в каком меню

//подготовка для вызова POST
//=========================================$id_visor
$id_visor=$id_user;
$visor=GetCookie('visor'.$id_user);
if(!$visor===false) $id_visor=$visor;
//==========================================Вызов POST
if((isset($_POST['save_form']))and($_POST['save_form']==1)) {  //=========Это Сохранение формы
   include_once $url_system.'ilib/Isql.php';                  //Библиотека
   include_once $url_system.'aktpp/make_control.php';
   $stack_error=array();
   $stack_warn=array();
   POST_control(&$stack_error,&$stack_warn);
   include_once $url_system.'aktpp/make_save.php';
}


$podpis=0;  //по умолчанию нельзя редактировать подписана свыше
        if((sign_naryd_level($link,$id_user,$sign_level,$_GET["id"],$sign_admin)))
        {
                $podpis=1;
        }
	$status_edit='';
	$status_class='';


//формирование нового секретного ключа
$secret=rand_string_string(4);
$_SESSION['s_t'] = $secret;


//проверка адреса сайта на существование такой страницы
//      /finery/add/28/
//     0   1     2  3

$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
$D_404 = explode('/', $url_404);

/*
if ( count($_GET) == 1 ) //--Если были приняты данные из HTML-формы
{

  if($D_404[4]=='')
  {
	//echo("!");

  } else
  {
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $error_header=404;
  }
} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}
 *
 */
//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
//проверка адреса сайта на существование такой страницы


include_once $url_system.'template/html.php';
include $url_system.'module/seo.php';

if($error_header!=404){ SEO('make','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php';
include $url_system.'template/head.php';
?>
<link rel="stylesheet" type="text/css" href="aktpp/make.css?542363" />
</head><body><div class="alert_wrapper"><div class="div-box"></div></div><div class="container">
<?php


if ( isset($_COOKIE["iss"]))
{
    if($_COOKIE["iss"]=='s')
    {
        echo'<div class="iss small">';
    } else
    {
        echo'<div class="iss big">';
    }
} else
{
    echo'<div class="iss big">';
}
//echo(mktime());

?>
<div class="left_block">
  <div class="content">

<?php
    $act_='display:none;';
    $act_1='';
    if(cookie_work('it_','on','.',60,'0'))
    {
        $act_='';
        $act_1='on="show"';
    }
$trole='Прием-Передача';
if($role->permission($trole,'U')
or $role->permission($trole,'A')
or $role->permission($trole,'S')
        or $sign_admin==1) {

include_once $url_system.'ilib/Isql.php';
include_once $url_system.'aktpp/top_prime_aktpp_view.php';
?>
<form id="aktpp_make_form" class="my_n" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
 <input name="save_form" value="1" type="hidden">
<?php

echo'<div id="fullpage" class="margin_60  input-block-2020 ">
    <div class="oka_block_2019" style="min-height:auto;">
 <div class="oka_block">
<div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">';

    echo'<div class="content_block1" style="width: 100%; padding-top: 20px;"  iu="'.$id_user.'"  id_content="'.$id_user.'">';

//print_r($stack_error);
	/*echo '<pre>';
print_r($_POST["works"]);
	echo '</pre>';
	*/
echo '<pre>';
print_r($row_list);
echo '</pre>';

echo '<h3 style="margin-bottom:0px;">Подготовка документа </h3>';
if ($rowE['id_doc']>0) {
    echo'<div style="display:inline-block;">'.$zay_info.'</div><br/>';
}
if (isset($name0_user)) echo'<div style="display:inline-block;">( передающий: '.$name0_user.' )</div>';
//echo'<div class="comme" >'.$row_town["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</div>';



	  $rrtt=0;


	echo'<div style="height:70px;">'              //Общая полоса панели
          . '<div class="_50_na_50_1" style="width:50%; float:left;">'
          . '<div class="_50_x">';
	echo'<div class="input-width m10_right m10_left">';  //margin-right: 10px;
	echo '<input id="id_akt_edit" name="id_akt_edit" value="'.$id_edit.'" type="hidden">';
	//====================================Список пользователей
        // ограничить объектами
        // не выводить себя самого, если это не S
	$result_t=mysql_time_query($link,'Select * from r_user order by name_user and enabled=1');
        if($result_t->num_rows>0)
        {
            //==========================================кому
            echo'<div class="select_box eddd_box">'
              . '<a class="slct_box '.iclass_('ispol_work',$stack_error,"error_formi").' '.$status_class.'"'
                    . 'data-tooltip="Принимающий" data_src="'.$id1_user.'" id="id1_user">'
              . '<span class="ccol">'.ipost_x($_POST['ispol_work'],$id1_user,"Принимающий","r_user","name_user",$link).'</span>'
              . '</a><ul class="drop_box" >';   //style="display:block"
               //=====================Возможные получатели документа

            for ($i=0; $i<$result_t->num_rows; $i++)
            {
                $row_t = mysqli_fetch_assoc($result_t);
                echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'" data-tooltip="Выбрать принимающего">'.$row_t["name_user"].'</a></li>';
            }
            echo'</ul>'                    //ispol
            . '<input defaultv="'.$id1_user
                    .'" '.$status_edit
                    .' name="id1_user" '
                    . 'id="ispol" '
                    . 'value="'.$id1_user.'" type="hidden">'
            . '</div>';
        }




		echo'</div>';
		echo'</div>';
	//============================дата
		echo'<div class="_50_x">';
		   echo'<div class="input-width m10_right" style="position:relative; margin-right: 0px;">';

		    echo'<input id="date_hidden_table" name="date_akt" value="'.$ddate.'" type="hidden">'; //name="date_naryad"
			if ($id_edit>0) $dis='disabled="disabled"';
                        else    $dis='';
			echo'<input '.$status_edit1.' defaultv="'.date_fik($ddate).'" '
                                . $dis.' readonly="true" name="datess" defuat="" '
                                . 'value="'.date_fik($ddate).'" '
                                . 'id="date_table" '
                                . 'class="input_f_1 input_100 calendar_t white_inp '.$status_class.' '.iclass_("date_naryad",$stack_error,"error_formi").'" '
                                . 'placeholder="Дата документа"  '
                                . 'data-tooltip="Дата документа" '
                                . 'autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div></div>';
?>
		<div class="pad10" style="padding: 0;">
                    <span class="bookingBox"></span>
                </div>
	</div>
        <div class="pad10" style="padding: 0; width:100%;">
            <span class="bookingBox1"></span>
        </div>
    </div>
    <script type="text/javascript" src="Js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" src="Js/jquery.datepicker.extension.range.min.js"></script>
    <script type="text/javascript" src="aktpp/index_make.js"></script>

<?php
//Содержание акта
// ?by=cookie & id=7 или id_zay=18
// взять id (акта)
// заполнить по нему таблицу
// Взять cookie
// заполнить по ним таблицу

echo'</div><div class="content_block block_primes1">';

if ($id_edit>0) {                     //материалы акта

$sql1=
"
select
s.id as ids
,s.name
,s.units
,s.id_stock_group
,sm.id as idsm
,sm.count_units as count_units_stock
,sm.price
,sm.subtotal

,m.id as idm
,m.count_units as count_units_act
,m.subtotal as subtotal_act

,a.id as id_act
,a.number
,a.date
,a.id0_user
,a.id1_user

from z_act_material m
left join z_stock s on (m.id_stock =s.id)
left join z_stock_material sm on (m.id_stock_material=sm.id)
, z_act a
where
a.id='$id_edit'
and m.id_act=a.id
";
} else  { $sql1=''; $UNION=''; }

$sql2='';
if ($id_zay>0) {   //заполнение по заявке
    //=======================================//Получить материал по заявке
             $sqlZ='select * from z_doc_material where id_doc="'.$id_zay.'"';
            $result_Z=mysql_time_query($link,$sqlZ);
            $arrZ=array();
            for ($m=0; $m<$result_Z->num_rows; $m++) {
                $rowZ= mysqli_fetch_assoc($result_Z);
                $arrZ[]=$rowZ['id_stock'];
            }
            unset( $result_Z);
    //======================================получить запрос
$sql2="
select
s.id as ids
,s.name
,s.units
,s.id_stock_group
,sm.id as idsm
,sm.count_units as count_units_stock
,sm.price
,sm.subtotal

,0 as idm
,sm.count_units as count_units_act
,sm.subtotal as subtotal_act

,0 as id_act
,null as number
,null as date
,null as id0_user
,null as id1_user
,z.count_units as countz
from z_stock_material as sm, z_stock s,
z_doc_material z
where
sm.id_stock in (".implode(',',$arrZ).")
and sm.id_user='$id_visor'
and sm.id_stock=s.id
and z.id_doc='$id_zay' and sm.id_stock=z.id_stock
    ";
}
else if (!isset($_GET['nmat'])) { //добавление по корзине
  $arr=ReadCookie('material'.$id_user.'_'.$id_visor);
  if (count($arr)>0 and $arr[0]>0) {
    //echo '<p/>cookie='.$arr[0].'!';
  $sql2="
select
s.id as ids
,s.name
,s.units
,s.id_stock_group
,sm.id as idsm
,sm.count_units as count_units_stock
,sm.price
,sm.subtotal

,0 as idm
,sm.count_units as count_units_act
,sm.subtotal as subtotal_act

,0 as id_act
,null as number
,null as date
,null as id0_user
,null as id1_user

from z_stock_material as sm, z_stock s
where
sm.id in (".implode(',',$arr).")
and sm.id_stock=s.id
    ";
 //echo '<p/>sql2='.$sql2;
  }
}
if ($sql1=='' || $sql2=='') $UNION='';
else $UNION='UNION';
$show_save=0;
if (!($sql1=='' && $sql2=='')) {
$sql= "select * from ( $sql1  $UNION $sql2 )  as z
group by z.idsm
order by z.name";
    //echo '<p/>sql='.$sql;
    $result_act=mysql_time_query($link,$sql);
    if ($result_act->num_rows>0) {
        echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_0" class="smeta1"><thead>
	<tr class="title_smeta">
          <th class="t_2 no_padding_left_ jk4">Материалы</th>
          <th class="t_4 jk44">ед. изм.</th>
          <th class="t_5">кол-во</th>
          <th class="t_6">стоимость ед. (руб.)</th>
          <th class="t_7 jk5">всего (руб.)</th>
          <th class="t_10 jk6"></th>
        </tr></thead><tbody>';
        echo'<tr class="loader_tr" style="height:20px;"><td colspan="7"></td></tr>';

        for ($i=0; $i<$result_act->num_rows; $i++) {
             $row_act= mysqli_fetch_assoc($result_act);
             if ($row_act["idm"]==0) {  //материал из корзины
                $bcolor='style="background-color:#ffec57;"';    //yellow потемнее
                $show_save=1;
             } else {
             //=============Проверка дублиата по кукам
                $num=IsDataNum($arr,$row_act["idm"]);
                if (!($num===false)) {
                  $arr[$num]=0;              //Временно занулить значение в массиве
                }
                $bcolor='style="background-color:#f0f4f6;"';
             }
 //---------------------------------наименование работы    //rel_id="'.$row_act["idm"].'"
            echo'<tr id="row_'.$row_act["idm"].'" '.$bcolor.' class="jop work__s workx" id_trr="'.$i.'" >
                 <td class="no_padding_left_ pre-wrap one_td" '.$bcolor.'>
                    <span class="s_j">'.$row_act["name"].'</span>
                    <input type=hidden value="'.$row_act["idm"].'" name="works['.$i.'][id]"></td>';
 //---------------------------------Единицы измерения
            echo'<td class="pre-wrap center_text_td" '.$bcolor.'>'.$row_act["units"].'';
            if ($id_zay>0) {
                echo '<div class="red_select" style="float:right;">['.$row_act["countz"].']</div>';
                echo '<input type="hidden" name="zay_id_'.$i.'" value="'.$row_act['countz'].'">';

            }
 //---------------------------------кол-во
            $ostatok=$row_act["count_units_stock"];
            $val_count=$row_act["count_units_act"];
            if ($id_zay>0) {
                if ($row_act["countz"]<$val_count) $val_count=$row_act["countz"];
            }
            echo'<td '.$bcolor.'>
                  <input type="hidden" name="act_id_'.$i.'" value="'.$row_act['ids'].'_'.$row_act['idsm'].'_'.$row_act['id_act'].'_'.$row_act['idm'].'">
                  <div class="width-setter" id="edc'.$i.'">
                     <label>MAX('.$ostatok.')</label>
                     <input defaultv="'.$ostatok.'" '.$status_edit.'
                        style="margin-top:0px;"
                        name="count_'.$i.'"
                        all="'.$ostatok.'"
                        max="'.$ostatok.'"'
                        .'id="act_'.$i.'_'.$row_act['ids'].'_'.$row_act['idsm'].'_'.$row_act['id_act'].'_'.$row_act['idm'].'"
                        placeholder="MAX - '.$ostatok.'"
                        class="input_f_1 input_100 white_inp label_s '.$class_c.' count_finery_ '.iclass_($row1ss["id"].'_w_count',$stack_error,"error_formi").' '.$status_class.'" '
                    . ' autocomplete="off" '
                    . ' type="text" '
                    . ' value="'.$val_count.'"></div>';

            echo'</td>';
//----------------------------------цена
            echo'<td '.$bcolor.'><div class="width-setter money" >'   //text-align: right;
                . MONEY($row_act["price"],'-',' ')
                . '</div><input type="hidden" id="act_price_'.$i.'" name="act_price_'.$i.'" value="'.$row_act["price"].'"></td>';

//----------------------------------сумма   ПЕРЕСЧИТАТЬ!!!!
            echo'<td '.$bcolor.'><div class="width-setter money" id="act_summa_'.$i.'">'
                . MONEY($row_act["subtotal_act"],'-',' ')
                . '</div><input type="hidden" id="act_sh_'.$i.'" value="'.$row_act["subtotal_act"].'"></td>';

            //echo'<td><span class="summ_price s_j " id="summa_finery_'.$i.'" ></span>';
            //echo'<div class="exceed"></div>';
             echo '<td '.$bcolor.'><div class="smeta2 del_mat" id_rel="'.$row_act['idm'].'" style="margin-top:0px">'
            . '<a target="_blank"  class="font-rank22" data-tooltip="Удалить" >'
            . '<span class="font-rank-inner" id="mat'.$row_act['idm'].'">x</span></a>';
             echo '</div></td>';
        } //for
        echo '<input type=hidden value="'.$i.'" id="count_mat" name="count_mat"></td>';
        //---Конец таблицы
    } //if row

}




	$result_work=mysql_time_query($link,'Select a.* from n_work as a where a.id_nariad="'.$row_list["id"].'" order by a.id');
        $num_results_work = $result_work->num_rows;
	    if($num_results_work!=0)
	    {


		   for ($i=0; $i<$num_results_work; $i++)
		   {
			   $row_work = mysqli_fetch_assoc($result_work);

					$rrtt++;
					if($rrtt==1)
					{

		$token=token_access_compile($_GET['id'],'save_naryd_x',$secret);


						echo'<input type="hidden" value="'.$token.'" name="tk">';


						//заголовок таблицы

						 echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_0" class="smeta1"><thead>
		   <tr class="title_smeta"><th class="t_2 no_padding_left_ jk4">Наименование работ</th><th class="t_4 jk44">ед. изм.</th><th class="t_5">кол-во</th><th class="t_6">стоимость ед. (руб.)</th><th class="t_7 jk5">всего (руб.)</th><th class="t_10 jk6"></th></tr></thead><tbody>';
						 echo'<tr class="loader_tr" style="height:20px;"><td colspan="7"></td></tr>';
					}

				 $summ=0;
                 $ostatok=0;
                 $proc_view=0;
				 $flag_history=0;

			     $result_t1_=mysql_time_query($link,'Select c.count_r2_realiz,c.count_units as count_all,a.count_units from n_work as a, i_razdel2 as c where c.id=a.id_razdeel2 and a.id_razdeel2="'.$row_work["id_razdeel2"].'"');

                 //echo('Select sum(a.count_units) as summ from n_work as a where a.id_razdeel2="'.$row1ss["id"].'" and a.status="1"');

			     //если наряд проведен то выводим информацию какая была на момент проводки а не та которая сейчас по этому наряду в зависимости от себестоимости
			     if($row_list["signedd_nariad"]==1)
				 {

					$result_t1_=mysql_time_query($link,'Select a.count_units_razdel2_realiz as count_r2_realiz,a.count_units_razdel2 as count_all,a.count_units from n_work as a where a.id_razdeel2="'.$row_work["id_razdeel2"].'" and a.id_nariad="'.$row_list["id"].'"');
				 } else
				 {

					$result_t1_=mysql_time_query($link,'Select c.count_r2_realiz,c.count_units as count_all,a.count_units from n_work as a, i_razdel2 as c where c.id=a.id_razdeel2 and a.id_razdeel2="'.$row_work["id_razdeel2"].'" and a.id_nariad="'.$row_list["id"].'"');
				 }



			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["count_r2_realiz"]!='')and($row1ss_["count_r2_realiz"]!=0))
					 {
					  $summ=$row1ss_["count_r2_realiz"];
						 $flag_history=1;
					 }
				 }
					 $ostatok=$row1ss_["count_all"]-$summ;
			   //echo($ostatok);
					 if($ostatok<0)
				     {
					     $ostatok=0;
					 }
			        //echo($ostatok);
			   if($row1ss_["count_all"]!=0)
			   {
					 $proc_view=round((($row1ss_["count_all"]-$ostatok)*100)/$row1ss_["count_all"]);
			   } else
			   {
				 $proc_view=0;
			   }
					 //линия выполеннных работ
					echo'<tr work="'.$row_work["id"].'" class="loader_tr"><td colspan="6"><div class="loaderr"><div id_loader="'.$row_work["id"].'" class="teps" rel_w="'.$proc_view.'" style="width:0%"><div class="peg_div"><div><i class="peg"></i></div></div></div></div></td></tr>';

					 //история нарядов по этой работе
if(($flag_history==1)or($row_list["signedd_nariad"]==1))

{
		 echo'<tr work="'.$row_work["id"].'" class="loader_tr loader_history" fo="'.$row_work["id_razdeel2"].'" style="height:0px;"><td colspan="6"><div class="loader_inter"><div></div><div></div><div></div><div></div></div></td></tr>';
}

                     //работа сама
					 echo'<tr work="'.$row_work["id"].'" style="background-color:#f0f4f6;" class="jop work__s workx" id_trr="'.$i.'" rel_id="'.$row_work["id"].'">
                  <td class="no_padding_left_ pre-wrap one_td"><span class="s_j">'.$row_work["name_work"].'</span><input type=hidden value="'.$row_work["id"].'" name="works['.$i.'][id]">';
					 if(($flag_history==1)or($row_list["signedd_nariad"]==1))
					 {
					   echo'<span class="edit_panel11"><span data-tooltip="история нарядов" for="'.$row_work["id_razdeel2"].'" class="history_icon">M</span></span>';
					 }

						 echo'</td>';


echo'<td class="pre-wrap center_text_td">'.$row_work["units"].'';

				//количество нарядов по данной работе

//<div class="musa_plus">3</div>
//echo'<div class="musa_plus mpp">+</div>';
echo'</td>
<td>';

//проверим сколько работ уже было закрыто

$class_c='';
if($ostatok==0)
{
	$class_c='redaa';
}
echo'<div class="width-setter"><label>MAX('.$ostatok.')</label><input defaultv="'.ipost_($_POST['works'][$i]["count"],$row_work["count_units"]).'" '.$status_edit.' style="margin-top:0px;" name="works['.$i.'][count]" all="'.$row1ss_["count_all"].'" max="'.$ostatok.'" id="count_work_'.$i.'" placeholder="MAX - '.$ostatok.'" class="input_f_1 input_100 white_inp label_s '.$class_c.' count_finery_ '.iclass_($row1ss["id"].'_w_count',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["count"],$row_work["count_units"]).'"></div>';

echo'</td>
<td>';
if($edit_price==1)
{
echo'<div class="width-setter"><label>MAX('.$row_work["price_razdel2"].')</label><input defaultv="'.ipost_($_POST['works'][$i]["price"],$row_work["price"]).'" '.$status_edit.' style="margin-top:0px;" name="works['.$i.'][price]" max="'.$row_work["price_razdel2"].'" id="price_work_'.$i.'" placeholder="MAX - '.$row_work["price_razdel2"].'" class="input_f_1 input_100 white_inp label_s price_finery_ '.iclass_($row_work["id"].'_w_price',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["price"],$row_work["price"]).'"></div>';
} else
{
echo'<div class="width-setter"><label>MAX('.$row_work["price_razdel2"].')</label><input readonly="true" defaultv="'.ipost_($_POST['works'][$i]["price"],$row_work["price"]).'" '.$status_edit.' style="margin-top:0px;" name="works['.$i.'][price]" max="'.$row_work["price_razdel2"].'" id="price_work_'.$i.'" placeholder="MAX - '.$row_work["price_razdel2"].'" class="input_f_1 input_100 white_inp label_s price_finery_ grey_edit '.iclass_($row_work["id"].'_w_price',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["price"],$row_work["price"]).'"></div>';
}
echo'</td>
<td><span class="summ_price s_j " id="summa_finery_'.$i.'" ></span>';
if($edit_price==1)
{
echo'<div class="exceed"></div>';
}
echo'</td>

<td>';

	if($podpis==1) {
            echo'<div class="font-rank del_naryd_work1" naryd="'.$_GET['id'].'" id_rel="'.$row_work["id"].'">'
              . '<span class="font-rank-inner">x</span></div>';
	}

echo'</td>
           </tr>';


	//служебная записка по работе
	 echo'<tr work="'.$row_work["id"].'" class="loader_tr workx" style="height:0px;"><td colspan="6">
	 <div class="messa" id_mes="'.$row_work["id"].'">
	 <span class="hs">';
	if(($sign_level==3)or($sign_admin==1))
	{
	   echo'Cлужебная записка';
	} else
	{
	   echo'Оформление служебной записки';
	}

	if(($sign_level!=3)and($sign_admin!=1))
	{

	  //для прорабов и начальникам участка выводим просто статус служебных записок
	  if(($row_work["signedd_mem"]==1)and($row_work["id_sign_mem"]!=0)and($row_work["id_sign_mem"]!=''))
	  {
		echo'<span style="visibility:visible" class="edit_12"><i data-tooltip="Подписана руководством">S</i></span>';

	  }
	  if(($row_work["signedd_mem"]==0)and($row_work["id_sign_mem"]!=0)and($row_work["id_sign_mem"]!=''))
	  {
		echo'<span style="visibility:visible" class="edit_12"><i style="color:#ff2828; font-size: 21px;" data-tooltip="Отказано руководством">5</i></span>';

	  }
	}



	$readyonly='';
	if($podpis==0)
	{
		$readyonly='ready';
	}

	//если это главный инженер смотрим не подписан ли наряд и если нет выводим кнопки по ответам служебных записок
	if(($sign_level==3)or($sign_admin==1))
	{
	  $decision=-1;
	  if(($row_work["signedd_mem"]==0)and(($row_work["id_sign_mem"]==0)or($row_work["id_sign_mem"]=='')))
	  {
		//решения пока нет
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes"  for_s="w" for="'.$row_work["id"].'" data-tooltip="Согласовать">S</i><i class="no"  for_s="w" for="'.$row_work["id"].'" data-tooltip="Отказать">5</i></span>';
		$decision=-1;
	  }
	  if(($row_work["signedd_mem"]==0)and(($row_work["id_sign_mem"]!=0)and($row_work["id_sign_mem"]!='')))
	  {
		//отказано
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes"  for_s="w" for="'.$row_work["id"].'" data-tooltip="Согласовать">S</i><i class="no active"  for_s="w" for="'.$row_work["id"].'"  data-tooltip="Отказать">5</i></span>';
		$decision=0;
	  }
	  if(($row_work["signedd_mem"]==1)and(($row_work["id_sign_mem"]!=0)and($row_work["id_sign_mem"]!='')))
	  {
		//согласовано
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes active" for_s="w" for="'.$row_work["id"].'" data-tooltip="Согласовать">S</i><i class="no"  for_s="w" for="'.$row_work["id"].'"  data-tooltip="Отказать">5</i></span>';
		$decision=1;
	  }
	 	if($podpis==1)
	{
	  echo'<input class="decision_mes" name="works['.$i.'][decision]" value="'.$decision.'" type="hidden">';
	}

	}


	echo'<div></div></span>';

echo'<div class="width-setter mess_slu"><input defaultv="'.ipost_($_POST['works'][$i]["text"],$row_work["memorandum"]).'" style="margin-top:0px;" name="works['.$i.'][text]" '.$status_edit.'  placeholder="Напиши руководству причину превышения параметров относительно запланированной себестоимости" class="input_f_1 input_100 white_inp label_s text_finery_message_ '.iclass_($row_work["id"].'_w_text',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["text"],$row_work["memorandum"]).'"></div>';


	 echo'</div>
	 </td></tr>';


					 //смотрим может есть материалы с этой работой
			   		 if($row_list["signedd_nariad"]==1)
				     {
					   $result_mat=mysql_time_query($link,'Select a.*,a.count_units_material as count_seb,a.price_material as price_seb,a.count_units_material_realiz as count_realiz from n_material as a where a.id_nwork="'.$row_work["id"].'" order by a.id');
					 } else
					 {
					   $result_mat=mysql_time_query($link,'Select a.*,b.count_units as count_seb,b.price as price_seb,b.count_realiz from n_material as a,i_material as b where a.id_material=b.id and a.id_nwork="'.$row_work["id"].'" order by a.id');
					 }
                     $num_results_mat = $result_mat->num_rows;
	                 if($num_results_mat!=0)
	                 {

		               for ($mat=0; $mat<$num_results_mat; $mat++)
                        {
                            $row_mat = mysqli_fetch_assoc($result_mat);


							//подсчитываем оставшееся количество материала по смете для этой работы

					    if(($row_mat["count_realiz"]!='')and($row_mat["count_realiz"]!=0))
						{
					     $summ=$row_mat["count_realiz"];
					    }


					 $ostatok=$row_mat["count_seb"]-$summ;
					 if($ostatok<0)
				     {
					     $ostatok=0;
					 }

							echo'<tr work="'.$row_work["id"].'" style="background-color:#f0f4f6;" class="jop1 mat mattx" rel_w="'.$row_work["id"].'" rel_mat="'.$row_mat["id"].'" rel_matx="'.$row_mat["id"].'">
                  <td  class="no_padding_left_ pre-wrap one_td"><div class="nm"><span class="s_j">'.$row_mat["material"].'</span></div>
				  <input type=hidden value="'.$row_mat["id"].'" name="works['.$i.'][mat]['.$mat.'][id]">
				  <input type=hidden class="hidden_max_count" value="" name="works['.$i.'][mat]['.$mat.'][max_count]"></td>
<td class="pre-wrap center_text_td">'.$row_mat["units"].'';
echo'</td>
<td>';
//макс возможное количество берем всегда из себестоимости.
echo'<div class="width-setter"><label>';
$maxmax='';
$placeh='';
if($row_mat["count_seb"]!='')
{
//echo'MAX ('.$row_mat["count_units_material"].')';
//$maxmax=$row_mat["count_units_material"];
//$placeh='MAX - '.$row_mat["count_units_material"];
}
echo'</label><input
defaultv="'.ipost_($_POST['works'][$i]["mat"][$mat]["count"],$row_mat["count_units"]).'" '.$status_edit.' style="margin-top:0px;"
ost="'.$ostatok.'"
all="'.$row_mat["count_seb"].'"
name="works['.$i.'][mat]['.$mat.'][count]"
max="'.$maxmax.'" placeholder="'.$placeh.'"
class="input_f_1 input_100 white_inp label_s count_finery_mater_ '.iclass_($row_mat["id"].'_m_count',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text"

value="'.ipost_($_POST['works'][$i]["mat"][$mat]["count"],$row_mat["count_units"]).'"></div>';


echo'</td>
<td>';
if($edit_price==1)
{
echo'<div class="width-setter"><label>MAX ('.$row_mat["price_material"].')</label><input defaultv="'.ipost_($_POST['works'][$i]["mat"][$mat]["price"],$row_mat["price"]).'" '.$status_edit.' style="margin-top:0px;" name="works['.$i.'][mat]['.$mat.'][price]" max="'.$row_mat["price_material"].'" placeholder="MAX - '.$row_mat["price_material"].'" class="input_f_1 input_100 white_inp label_s price_finery_mater_ '.iclass_($row_mat["id"].'_m_price',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["mat"][$mat]["price"],$row_mat["price"]).'"></div>';
} else
{
echo'<div class="width-setter"><label>MAX ('.$row_mat["price_material"].')</label><input readonly="true" defaultv="'.ipost_($_POST['works'][$i]["mat"][$mat]["price"],$row_mat["price"]).'" '.$status_edit.' style="margin-top:0px;" name="works['.$i.'][mat]['.$mat.'][price]" max="'.$row_mat["price_material"].'" placeholder="MAX - '.$row_mat["price_material"].'" class="input_f_1 input_100 white_inp label_s price_finery_mater_ grey_edit '.iclass_($row_mat["id"].'_m_price',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["mat"][$mat]["price"],$row_mat["price"]).'"></div>';
}
echo'</td>
<td><span class="s_j summa_finery_mater_"></span>';
if($edit_price==1)
{
echo'<div class="exceed"></div>';
}
echo'</td>

<td></td>
           </tr>';

		//служебная записка по материалу
	 echo'<tr rel_matx="'.$row_mat["id"].'" work="'.$row_work["id"].'" class="loader_tr mattx" style="height:0px;"><td colspan="6">
	 <div class="messa" id_mes="'.$row_work["id"].'_'.$row_mat["id"].'">
	 <span class="hs">';
	if(($sign_level==3)or($sign_admin==1))
	{
	   echo'Cлужебная записка';
	} else
	{
	   echo'Оформление служебной записки';
	}
	if(($sign_level!=3)and($sign_admin!=1))
	{

	  //для прорабов и начальникам участка выводим просто статус служебных записок
	  if(($row_mat["signedd_mem"]==1)and($row_mat["id_sign_mem"]!=0)and($row_mat["id_sign_mem"]!=''))
	  {
		echo'<span style="visibility:visible" class="edit_12"><i data-tooltip="Подписана руководством">S</i></span>';

	  }
	  if(($row_mat["signedd_mem"]==0)and($row_mat["id_sign_mem"]!=0)and($row_mat["id_sign_mem"]!=''))
	  {
		echo'<span style="visibility:visible" class="edit_12"><i style="color:#ff2828; font-size: 21px;" data-tooltip="Отказано руководством">5</i></span>';

	  }
	}

	$readyonly='';
	if($podpis==0)
	{
		$readyonly='ready';
	}

	//если это главный инженер смотрим не подписан ли наряд и если нет выводим кнопки по ответам служебных записок
	if(($sign_level==3)or($sign_admin==1))
	{
	  $decision=-1;
	  if(($row_mat["signedd_mem"]==0)and(($row_mat["id_sign_mem"]==0)or($row_mat["id_sign_mem"]=='')))
	  {
		//решения пока нет
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes"  for_s="m" for="'.$row_mat["id"].'" data-tooltip="Согласовать">S</i><i class="no" for_s="m" for="'.$row_mat["id"].'" data-tooltip="Отказать">5</i></span>';
		$decision=-1;
	  }
	  if(($row_mat["signedd_mem"]==0)and(($row_mat["id_sign_mem"]!=0)and($row_mat["id_sign_mem"]!='')))
	  {
		//отказано
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes" for_s="m" for="'.$row_mat["id"].'" data-tooltip="Согласовать">S</i><i class="no active" for_s="m" for="'.$row_mat["id"].'"  data-tooltip="Отказать">5</i></span>';
		$decision=0;
	  }
	  if(($row_mat["signedd_mem"]==1)and(($row_mat["id_sign_mem"]!=0)and($row_mat["id_sign_mem"]!='')))
	  {
		//согласовано
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes active" for_s="m" for="'.$row_mat["id"].'" data-tooltip="Согласовать">S</i><i class="no" for_s="m" for="'.$row_mat["id"].'"  data-tooltip="Отказать">5</i></span>';
		$decision=1;
	  }
      if(($row_mat["signedd_mem"]==1)and(($row_mat["id_sign_mem"]==0)or($row_mat["id_sign_mem"]=='')))
	  {
		//пока вообще нет служебной записки
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes"  for_s="m" for="'.$row_mat["id"].'" data-tooltip="Согласовать">S</i><i class="no" for_s="m" for="'.$row_mat["id"].'" data-tooltip="Отказать">5</i></span>';
	  }
	if($podpis==1)
	{
	   echo'<input class="decision_mes" name="works['.$i.'][mat]['.$mat.'][decision]" value="'.$decision.'" type="hidden">';
	}
	}

	echo'<div></div></span>';

echo'<div class="width-setter mess_slu"><input defaultv="'.ipost_($_POST['works'][$i]["mat"][$mat]["text"],$row_mat["memorandum"]).'" style="margin-top:0px;" name="works['.$i.'][mat]['.$mat.'][text]" '.$status_edit.'  placeholder="Напиши руководству причину превышения параметров относительно запланированной себестоимости" class="input_f_1 input_100 white_inp label_s text_finery_message_ '.iclass_($row_mat["id"].'_m_text',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["mat"][$mat]["text"],$row_mat["memorandum"]).'"></div>';

	 echo'</div>
	 </td></tr>';

						}
					 }
					 echo'<tr work="'.$row_work["id"].'" class="loader_tr" style="height:20px;"><td colspan="6"><input class="count_workssss" type=hidden value="'.$num_results_mat.'" name="works['.$i.'][count_mat]"></td></tr>';
				 //}
		   }
		  //вывод итогов
		   echo'<tr style="" class="jop1 mat itogss">
                  <td class="no_padding_left_ pre-wrap one_td">Итого Работа</td>

<td class="pre-wrap center_text_td"></td>
<td style="padding-left:30px;"></td>
<td style="padding-left:20px;"></td><td style="padding-left:10px;"><span class="itogsumwork"></span></td><td></td></tr>';

		  		   echo'<tr style="" class="jop1 mat itogss">
                  <td class="no_padding_left_ pre-wrap one_td">Итого Материал</td>

<td class="pre-wrap center_text_td"></td>
<td style="padding-left:30px;"></td>
<td style="padding-left:20px;"></td><td style="padding-left:10px;"><span class="itogsummat"></span></td><td></td></tr>';

	if($edit_price==1)
{
		  		   echo'<tr style="" class="previ">
                  <td class="no_padding_left_ pre-wrap one_td previs">Превышение по наряду</td>

<td class="pre-wrap center_text_td previs"></td>
<td class="previs" style="padding-left:30px;"></td>
<td class="previs" style="padding-left:20px;"></td><td class="previs" style="padding-left:0px !important;"><span class="itogsumall1"></span></td><td  class="previs"></td></tr>';

}

		   if($rrtt>0){
                       echo'</tbody></table>';
                        echo'<script>
                          OLD(document).ready(function(){  OLD("#table_freez_0").freezeHeader({\'offset\' : \'59px\'}); });
                          </script>';
                   }

		  //запускаем загрузку лодеров выполенных работ
		  //делаем пересчет суммы и итоговой
		  //выводим служебные записки где нужно
		  /*
		  if((isset($_POST['save_naryad']))and($_POST['save_naryad']==1))
          {

		     echo'<script>
				  $(function (){  $(\'.count_finery_,.price_finery_,.count_finery_mater_,.price_finery_mater_\').change();  });
				  </script>';
		*/
		 // }
	  }
    $control=0;
    if(!($result_act->num_rows>0)) {
        echo'Добавьте материалов (+) для оформления акта передачи';
    } else {
        //$id11_user=htmlspecialchars(trim($_POST['id1_user']));
        if ($id1_user>0 && $id0_user!=$id1_user && $id0_user>0)
            $control=1;
        //echo "<p>:$id0_user:$id1_user";
       // проверка заполненности акта и материалов
    }

    ?>
    </div>
  </div>
</div></div></div></div>
</form>
<?php
}  //права доступа
include_once $url_system."aktpp/index_make_js.php";
include_once $url_system.'template/left.php';
?>
<!--<div class="w_size debug"></div>-->
	</div>
</div>
<script src="Js/rem.js" type="text/javascript"></script>

<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>

</div>

</body></html>
