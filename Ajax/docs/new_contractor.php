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
$query=mb_convert_case(htmlspecialchars($_GET['inn']), MB_CASE_LOWER, "UTF-8");
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
 if ((!$role->permission('Договора','A'))and($sign_admin!=1))
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
//**************************************************
if ((!isset($_GET['inn'])))
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;
}
if((is_numeric($query))and((strlen($query)==10)or(strlen($query)==12))) {

} else
{
    $debug=h4a(55,$echo_r,$debug);
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




$nna='ЮЛ';
if(strlen($query)==12)
{
$nna='ИП';
}

$query_ob='';

//если это служба безопасности или админ видит всех
/*
if(($sign_level<4)and($sign_admin!=1)) {
    $mass_ee=all_office_users($link,$id_user);
    if (count($mass_ee) != 0) {
        $query_ob = ' and A.id_office in(' . implode(',', $mass_ee) . ') ';
    }
}
*/

    //если ничего не найдено то пробуем найти в фнс
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api-fns.ru/api/egr?req=".$query."&key=d2285e4ef8869568d71663c9b2000a17480b9eb4");
    //$debug .= "GET:https://api-fns.ru/api/search?q=".$query.'&key=d2285e4ef8869568d71663c9b2000a17480b9eb4";

    //curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "q='.$query.'&key=d2285e4ef8869568d71663c9b2000a17480b9eb4");
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


    $headers = array("Content-Type: application/json; charset=utf-8");//изменить на нужный
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($ch, CURLOPT_HEADER , true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);



    if (curl_errno($ch)) {
        $debug .= 'Error:' . curl_error($ch);
        $error_msg = curl_error($ch);
    }

    $server_output = curl_exec($ch);
    curl_close($ch);

    if (!isset($error_msg)) {
        //$debug .= 'Ответ:' .$server_output;
        $storage = json_decode($server_output,true);
        if($storage!=null) {
            foreach ($storage[items] as $item) {
                //echo "<pre>".$item[ЮЛ][ИНН]." ".$item[ЮЛ][НаимСокрЮЛ]." ".$item[ЮЛ][Статус]."</pre>";

if($nna=='ЮЛ') {
    $name_long = $item[$nna][НаимПолнЮЛ];
    $name_small = $item[$nna][НаимСокрЮЛ];
    $dir = $item[$nna][Руководитель][ФИОПолн];
    $adress = $item[$nna][Адрес][АдресПолн];
    $status = $item[$nna][Статус];
    $ogrn = $item[$nna][ОГРН];
    $inn = $item[$nna][ИНН];
}
                if($nna=='ИП') {
                    $name_long = $item[$nna][ВидИП].' '.$item[$nna][ФИОПолн];
                    $name_small = $item[$nna][ВидИП].' '.$item[$nna][ФИОПолн];
                    $dir = $item[$nna][ФИОПолн];
                    $adress = $item[$nna][Адрес][АдресПолн];
                    $status = $item[$nna][Статус];
                    $ogrn = $item[$nna][ОГРНИП];
                    $inn = $item[$nna][ИННФЛ];
                }

                /*$query_string .= '<li><a style="padding-right: 50px;" href="javascript:void(0);" rel="n' . $item[ЮЛ][ИНН] . '">' . $item[ЮЛ][НаимСокрЮЛ] . ' - ' . $item[ЮЛ][АдресПолн] . ' <span class="gray-date">(ИНН-' . $item[ЮЛ][ИНН] . ')</span><span class="gray-date">(статус-' . $item[ЮЛ][Статус] . ')</span><span class="red-fns">ФНС</span></a></li>';
                $search_fns = 1;*/
                $status_ee='ok';
            }
        }
    } else {
        $debug .= ' ошибка fns-'.$server_output;
    }






end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"query" => $query_string,"echo"=>$echo,

"name"=>$name_long,
"name_small"=>$name_small,
"adress"=>$adress,
"dir"=>$dir,
"inn"=>$inn,
"ogrn"=>$ogrn,
"status_f"=>$status);

/*require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);
*/
echo json_encode($aRes);
?>