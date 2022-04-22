<?php
//забронировали заявку
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;
$basket='';
$disco=0;
$id=isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************
	/*
if(!token_access_new($token,'bt_booking_end_client',$id,"s_form"))
{
   $debug=h4a(100,$echo_r,$debug);
   goto end_code;
}
*/	
	
	/*
if ( count($_GET) != 4 ) 
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
*/
//**************************************************
 if ((!$role->permission('Себестоимость','A'))and($sign_admin!=1))
{
  $debug=h4a(2,$echo_r,$debug);
  goto end_code;	
}
//**************************************************
 if(!isset($_SESSION["user_id"]))
{ 
  $status_ee='reg';	
  $debug=h4a(3,$echo_r,$debug);
  goto end_code;
}


//он имеет доступ к этому objecty
if((array_search($id,$hie_object) !== false)or($sign_admin==1)) {

} else
{
    $debug=h4a(48,$echo_r,$debug);
    goto end_code;
}


/*
if(($_GET['search']=='')or(strlen($_GET['search'])<'1'))
{
	   $debug=h4a(224,$echo_r,$debug);
   goto end_code;	
}
*/
//**************************************************
/*
$result_t=mysql_time_query($link,'Select b.id_user,b.status,b.ready,b.id_object from booking as b where b.id="'.htmlspecialchars(trim($_GET['id'])).'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
			   
		   } else
		   {
			      $debug=h4a(6,$echo_r,$debug);
   goto end_code;	
		   }
*/

//**************************************************
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';



$su_5_name='';
$su_5='';

$echo.='<!--input start	-->';

$echo.='<div class=" big_list" style="margin-bottom: 10px;">';
//$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

$echo.='<div class="list_2021 input_2021 input-search-list gray-color js-zindex" list_number="box2"><i class="js-open-search"></i><div class="b_loading_small loader-list-2021"></div><label>Поиск раздела (название)</label><input name="kto" value="'.$su_5_name.'" fns="'.$id.'" id="date_124" sopen="search_razdel" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 25px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search gloab js-posta js-mat-inv-posta10" name="posta_posta" id="search_items_5"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';



$result_work_zz=mysql_time_query($link,'
            
            SELECT DISTINCT t.id,t.name1,t.razdel1
            FROM 
                 i_razdel1 as t where t.id_object="'.ht($id).'"
             ORDER BY t.razdel1 limit 0,40


');
$num_results_work_zz = $result_work_zz->num_rows;
if($num_results_work_zz!=0)
{
    //echo'<li><a href="javascript:void(0);" rel="0"></a></li>';
    for ($i=0; $i<$num_results_work_zz; $i++)
    {
        $row_work_zz = mysqli_fetch_assoc($result_work_zz);

        if($role->is_row('i_razdel1','razdel1',$row_work_zz["razdel1"])) {
            $yop = '';
            if ($row_work_zz["id"] == $su_5) {
                $yop = 'sel_active';
            }

            $echo.='<li class="' . $yop . ' li_search_stock "><a href="javascript:void(0);" rel="' . $row_work_zz["id"] . '">' . $row_work_zz["razdel1"] . '. ' . $row_work_zz["name1"] . '';
            $echo.='</a></li>';
        }

    }
}

$echo.='</ul><div class="div_new_2021"><div class="oper_name"></div></div></div></div><!--input end	-->';



end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"query" => $query_string,"echo"=>$echo);
/*require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);
*/
echo json_encode($aRes);
?>