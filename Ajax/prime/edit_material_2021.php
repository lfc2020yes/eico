<?php
//добавление материала к работе в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");


$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_POST['id']);
$token=htmlspecialchars($_POST['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

	 	   //эти столбцы видят только особые пользователи	
		   $count_rows=10;	
		   $stack_td = array();			
		   
	       
	       if($sign_admin!=1)
		   {   
			 //столбцы  выполнено на сумму - остаток по смете  
	         if ($role->is_column('i_razdel2','summa_r2_realiz',true,false)==false) 
		     { 
			  $count_rows=$count_rows-2;
			  array_push($stack_td, "summa_r2_realiz"); 
		     } 
             //строка итого по работе, по материалам, по разделу
		     if ($role->is_column('i_razdel1','summa_r1',true,false)==false) 
		     { 
			    array_push($stack_td, "summa_r1"); 
		     } 	  
             //строка итого по объекту
		     if ($role->is_column('i_object','total_r0',true,false)==false) 
		     { 
			    array_push($stack_td, "total_r0"); 
		     } 
	         //строка итого за метр кв
		     if ($role->is_column('i_object','object_area',true,false)==false) 
		     { 
			    array_push($stack_td, "object_area"); 
		     } 		
		   }



if(!token_access_new($token,'edit_material',$id,"rema",2880))
{
    $debug=h4a(100,$echo_r,$debug);
    goto end_code;
}

if(!isset($_SESSION["user_id"])) {
    $status_ee='reg';
    $debug=h4a(102,$echo_r,$debug);
    goto end_code;
}

if ((!$role->permission('Себестоимость','U'))and($sign_admin!=1))
{
    $debug=h4a(103,$echo_r,$debug);
    goto end_code;
}


$result_t1=mysql_time_query($link,'Select a.name1,a.id,a.id_object,a.razdel1,b.name_working,c.* from i_razdel1 as a,i_razdel2 as b,i_material as c where c.id_razdel2=b.id and b.id_razdel1=a.id and c.id="'.htmlspecialchars(trim($id)).'"');
$num_results_t1 = $result_t1->num_rows;
if($num_results_t1==0)
{
    $debug=h4a(501,$echo_r,$debug);
    goto end_code;
} else
{
    $row1 = mysqli_fetch_assoc($result_t1);
}



	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';


if($_POST["new_sklad_i"]==1) {
/*
    $os = array('шт','м3','м2','т','пог.м','маш/час','компл');
    $os_id = array('0','1','2','3','4','5','6');
*/
    $os = array('шт','тыс. шт','м3','м2','т','пог.м','маш/час','компл','кг');
    $os_id = array('0','7','1','2','3','4','5','6','8');

    $name_ed='';
    $rtyy=array_search(ht($_POST["ed_new_stock"]), $os_id );
    if ($rtyy !== false) {

        $name_ed=$os[$rtyy];

    }


    //добавляем новый материал в склад
    mysql_time_query($link, 'INSERT INTO z_stock (name,units,id_stock_group) VALUES ("' . htmlspecialchars(trim($_POST['name_new_stock'])) . '","' . htmlspecialchars(trim($name_ed)) . '","' . htmlspecialchars(trim($_POST["group_new_stock"])) . '")');
    $ID_P = mysqli_insert_id($link);
    $name_mat=$_POST['name_new_stock'];
    $ed_mat=$name_ed;


} else {
    $ID_P = ht($_POST["posta_posta"]);

    $result_uu = mysql_time_query($link, 'select * from z_stock where id="' . ht($ID_P) . '"');
    $num_results_uu = $result_uu->num_rows;

    if ($num_results_uu != 0) {
        $row_uu = mysqli_fetch_assoc($result_uu);
        $name_mat=$row_uu['name'];
        $ed_mat=$row_uu['units'];
    }

}

mysql_time_query($link,'update i_material set 
                      material="'.htmlspecialchars(trim($name_mat)).'",
                      units="'.htmlspecialchars(trim($ed_mat)).'",
                      count_units="'.htmlspecialchars(trim(trimc($_POST['count_work']))).'",
                      price="'.htmlspecialchars(trim(trimc($_POST['price_work']))).'",
                      id_stock="'.ht($ID_P).'",
                      alien="'.ht($_POST["dava_stock"]).'",
                      count_realiz ="'.htmlspecialchars(trim(trimc($_POST['count_realiz']))).'", 
                      summa_realiz="'.htmlspecialchars(trim(trimc($_POST['summ_realiz']))).'" 
                      
                      where id = "'.htmlspecialchars(trim($id)).'"');


//mysql_time_query($link,'INSERT INTO i_material(id,id_razdel2,razdel1,razdel2,material,id_implementer,units,count_units,price,id_stock,alien) VALUES ("","'.htmlspecialchars(trim($id)).'","'.$row1["razdel1"].'","'.$row1["razdel2"].'","'.htmlspecialchars(trim($name_mat)).'","","'.htmlspecialchars(trim($ed_mat)).'","'.htmlspecialchars(trim(trimc($_POST['count_work']))).'","'.htmlspecialchars(trim(trimc($_POST['price_work']))).'","'.ht($ID_P).'","'.ht($_POST["dava_stock"]).'")');


//$ID_D1=mysqli_insert_id($link);




//уведомления уведомления уведомления уведомления уведомления уведомления
//уведомления уведомления уведомления уведомления уведомления уведомления
//уведомления уведомления уведомления уведомления уведомления уведомления

if($sign_admin!=1)
{


    $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row1['id_object'])).'"');
    $num_results_custom_url = $result_url->num_rows;
    if($num_results_custom_url!=0)
    {

        $row_list= mysqli_fetch_assoc($result_url);
    }

    $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list["id_kvartal"].'"');
    $num_results_custom_town = $result_town->num_rows;
    if($num_results_custom_town!=0)
    {
        $row_town = mysqli_fetch_assoc($result_town);
    }



    $user_send= array();
    $user_send_new= array();


    //$FUSER=new find_user($link,$row_list['id_object'],'U','Группировка');
    $user_send_new=array_merge($hie->boss['4']);
    $text_not='В себестоимость - <strong>'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</strong> в разделе - <strong>'.$row1["name1"].'</strong>, в работе - <strong>'.htmlspecialchars(trim($row1["name_working"])).'</strong>, был изменен материал - <strong>'.htmlspecialchars(trim($row1['material'])).'</strong>, с количеством -  <strong>'.htmlspecialchars(trim($row1['count_units'])).' '.htmlspecialchars(trim($row1['units'])).'</strong>, стоимость за единицу - <strong>'.htmlspecialchars(trim($row1['price'])).' руб.</strong> на <strong>'.htmlspecialchars(trim($name_mat)).'</strong>, с количеством -  <strong>'.htmlspecialchars(trim($_POST['count_work'])).' '.htmlspecialchars(trim($ed_mat)).'</strong>, стоимость за единицу - <strong>'.htmlspecialchars(trim($_POST['price_work'])).' руб.</strong>';
    //отправка уведомления
    $user_send_new= array_unique($user_send_new);
    notification_send($text_not,$user_send_new,$id_user,$link);
}

//уведомления уведомления уведомления уведомления уведомления уведомления
//уведомления уведомления уведомления уведомления уведомления уведомления
//уведомления уведомления уведомления уведомления уведомления уведомления




$result_t=mysql_time_query($link,'Select a.* from i_material as a where a.id="'.htmlspecialchars(trim($id)).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t!=0)
{
    $row_t = mysqli_fetch_assoc($result_t);

    $echo.='<td colspan="2" class="no_padding_left_ pre-wrap name_m"><div class="nm"><i></i><span class="s_j">'.$row_t["material"].'</span><span class="edit_panel_"><span data-tooltip="редактировать материал" for="'.$row_t["id"].'" class="edit_icon_m">3</span><span data-tooltip="удалить материал" for="'.$row_t["id"].'" class="del_icon_m">5</span></span></div></td>
<td class="pre-wrap"></td>
<td><span class="s_j">'.$row_t["units"].'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row_t["count_units"], 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row_t["price"], 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row_t["subtotal"], 2, '.', ' '),'0'),'.').'</span></td>
<td>'.rtrim(rtrim(number_format($row_t["count_realiz"], 2, '.', ' '),'0'),'.').'</td>';
    if(array_search('summa_r2_realiz',$stack_td) === false)
    {
        $echo.='<td>'.rtrim(rtrim(number_format($row_t["summa_realiz"], 2, '.', ' '),'0'),'.').'</td>
<td><strong><span class="s_j">'.mor_class(($row_t["subtotal"]-$row_t["summa_realiz"]),rtrim(rtrim(number_format(($row_t["subtotal"]-$row_t["summa_realiz"]), 2, '.', ' '),'0'),'.'),1).'</span></strong></td>
';
    }
}

end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>