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


               if ($role->is_column('i_razdel2','summa_r2_today',true,false)==false)
               {
                   $count_rows=$count_rows-2;
                   array_push($stack_td, "summa_r2_today");
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



if(!token_access_new($token,'add_material',$id,"rema",2880))
{
    $debug=h4a(100,$echo_r,$debug);
    goto end_code;
}

if(!isset($_SESSION["user_id"])) {
    $status_ee='reg';
    $debug=h4a(102,$echo_r,$debug);
    goto end_code;
}

if ((!$role->permission('Себестоимость','A'))and($sign_admin!=1))
{
    $debug=h4a(103,$echo_r,$debug);
    goto end_code;
}


$result_t1=mysql_time_query($link,'Select a.name1,a.id,a.id_object,a.razdel1,b.* from i_razdel1 as a,i_razdel2 as b where b.id_razdel1=a.id and b.id="'.htmlspecialchars(trim($id)).'"');
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


mysql_time_query($link,'INSERT INTO i_material(id,id_razdel2,razdel1,razdel2,material,id_implementer,units,count_units,price,price_today,id_stock,alien) VALUES ("","'.htmlspecialchars(trim($id)).'","'.$row1["razdel1"].'","'.$row1["razdel2"].'","'.htmlspecialchars(trim($name_mat)).'","","'.htmlspecialchars(trim($ed_mat)).'","'.htmlspecialchars(trim(trimc($_POST['count_work']))).'","'.htmlspecialchars(trim(trimc($_POST['price_work']))).'","'.htmlspecialchars(trim(trimc($_POST['price_work_today']))).'","'.ht($ID_P).'","'.ht($_POST["dava_stock"]).'")');


$ID_D1=mysqli_insert_id($link);
		   
		   
		   
		   
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
				$text_not='В себестоимость - <strong>'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</strong> в раздел - <strong>'.$row1["name1"].'</strong>, в работу - <strong>'.htmlspecialchars(trim($row1["name_working"])).'</strong>, добавлен новый материал - <strong>'.htmlspecialchars(trim($name_mat)).'</strong>, количество -  <strong>'.htmlspecialchars(trim($_POST['count_work'])).' '.htmlspecialchars(trim($ed_mat)).'</strong>, стоимость за единицу - <strong>'.htmlspecialchars(trim($_POST['price_work'])).' руб.</strong>';
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);		   
		} 
		   
	//уведомления уведомления уведомления уведомления уведомления уведомления
	//уведомления уведомления уведомления уведомления уведомления уведомления
	//уведомления уведомления уведомления уведомления уведомления уведомления			   


$result_uu55 = mysql_time_query($link, 'select * from i_material where id="'.ht($ID_D1).'"');
$num_results_uu55 = $result_uu55->num_rows;

if ($num_results_uu55 != 0) {
    $row_uu55 = mysqli_fetch_assoc($result_uu55);


    $echo .= '<tr class="material" rel_ma="' . $ID_D1 . '">';


    $echo .= '<td colspan="2" class="no_padding_left_ pre-wrap name_m"><div class="nm"><i></i>';

    $class_dava = '';
    if ($_POST["dava_stock"] == 1) {
        $class_dava = 'dava';
    }

    $echo .= '<span class="s_j ' . $class_dava . '">' . htmlspecialchars(trim($name_mat)) . '</span>';

    if ($_POST["dava_stock"] == 1) {
        $echo .= '<div class="chat_kk" data-tooltip="давальческий материал"></div>';
    }

    $echo .= '<span class="edit_panel_">';
    if (($role->permission('Себестоимость', 'U')) or ($sign_admin == 1)) {
        $echo .= '<span data-tooltip="редактировать материал" for="' . $ID_D1 . '" class="edit_icon_m">3</span>';
    }
    if (($role->permission('Себестоимость', 'D')) or ($sign_admin == 1)) {
        $echo .= '<span data-tooltip="удалить материал" for="' . $ID_D1 . '" class="del_icon_m">5</span>';
    }

    $echo .= '</span></div></td>
<td class="pre-wrap"></td>
<td><span class="s_j">' . htmlspecialchars(trim($ed_mat)) . '</span></td>';


    $echo .= '<td style="text-align: right;"><span class="s_j">'.number_format($row_uu55["count_units"], 3, '.', ' ').'</span></td>';

    $echo .= '<td style="text-align: right;"><span class="s_j" style="line-height: 15px;" data-tooltip="стоимость / текущая">'.number_format($row_uu55["price"], 2, '.', ' ');


                      if($row_uu55["price_today"]!=0)
                      {
                          $echo .= '<br><span style=""><span style="color:red; font-size:18px;">‣</span> '.number_format($row_uu55["price_today"], 2, '.', ' ').'</span>';
                      }

    $echo .= '</span></td>
<td style="text-align: right;"><span class="s_j">'.number_format($row_uu55["subtotal"], 2, '.', ' ').'</span></td>';
if($row_uu55["count_units"]!=0)
{
    $echo .= '<td style="text-align: right;"><span class="s_j" data-tooltip="'.ceil($row_uu55["count_realiz"]*100/$row_uu55["count_units"]).'%">'.mor_class(($row_uu55["count_units"]-$row_uu55["count_realiz"]),number_format($row_uu55["count_realiz"], 3, '.', ' '),0).'</span></td>';
} else
{
    $echo .= '<td style="text-align: right;"><span class="s_j" data-tooltip="0%">'.mor_class(($row_uu55["count_units"]-$row_uu55["count_realiz"]),number_format($row_uu55["count_realiz"], 3, '.', ' '),0).'</span></td>';
}

	if(array_search('summa_r2_realiz',$stack_td) === false)
	{
        $echo .= '<td style="text-align: right;"><span class="s_j">'.mor_class(($row_uu55["subtotal"]-$row_uu55["summa_realiz"]),number_format($row_uu55["summa_realiz"], 2, '.', ' '),0).'</span></td>';

//echo'<td style="text-align: right;"><strong><span class="s_j">'.mor_class(($row_t3["subtotal"]-$row_t3["summa_realiz"]),number_format(($row_t3["subtotal"]-$row_t3["summa_realiz"]), 2, '.', ' '),1).'</span></strong></td>';
	}

                      if(array_search('summa_r2_today',$stack_td) === false) {
                          $echo .= '<td style="text-align: right;"><span class="s_j">'.number_format($row_uu55["summa_today"], 2, '.', ' ').'</span></td>';
                      }



    /*
<td><span class="s_j">' . rtrim(rtrim(number_format(htmlspecialchars(trimc($_POST['count_work'])), 2, '.', ' '), '0'), '.') . '</span></td>
<td><span class="s_j">' . rtrim(rtrim(number_format(htmlspecialchars(trimc($_POST['price_work'])), 2, '.', ' '), '0'), '.') . '</span></td>
<td><span class="s_j">' . rtrim(rtrim(number_format((trimc($_POST['count_work']) * trimc($_POST['price_work'])), 2, '.', ' '), '0'), '.') . '</span></td>
<td>0</td>';
    if (array_search('summa_r2_realiz', $stack_td) === false) {
        $echo .= '<td>0</td>
<td>0</td>';
    }
 */


    $echo .= '</tr>';
}

end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>