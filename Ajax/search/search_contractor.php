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
$token=isset($_GET['tk']) ? htmlspecialchars($_GET['tk']) : '';
$disco=0;
$query=mb_convert_case(htmlspecialchars($_GET['search']), MB_CASE_LOWER, "UTF-8");
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
 if ((!$role->permission('Счета','A'))and($sign_admin!=1))
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
if ((!isset($_GET['search'])))
{
   $debug=h4a(4,$echo_r,$debug);
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


function search_text_strong_2019($regime,$search,$beginText)
{
//$regime    //Режим поиска (1 - точный поиск, 0 - вхождение)
//$search    // Что ищем (в примере: $search = "про"; )
//$beginText // Текст по которому необходимо провести поиск
 
/* Точный поиск. (Найдёт: "...не [B]про[/B] меня", 
Не найдёт "Этот ком[U]про[/U]мат не..." - ) отдельное слово */

if($regime == 1)                                       
  { $patterns = "/(\b".$search."\b)+/i"; }// Регулярное выражение
 
 
/* Отдельное слово и Вхождение в другие слова. 
(Найдёт: "...не [B]про[/B] меня", 
Найдёт: "Этот ком[B]про[/B]мат не...") */
else                                                       
  { $patterns = "/(".$search.")+/i"; }// Регулярное выражение
 
$replace = "<strong>$1</strong>";// На что заменить

setlocale(LC_ALL, 'ru_RU.CP1251'); 
$endText = PREG_REPLACE($patterns,$replace,$beginText);// Замена
 
return $endText;
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
if($query!='')
{

  $sql='

select * from(     
   (   
SELECT A.id,A.name,A.inn FROM z_contractor AS A where LOWER(A.inn) LIKE "%'.$query.'%"   
)
UNION
(

SELECT A.id,A.name,A.inn FROM z_contractor AS A where LOWER(A.name) LIKE "%'.$query.'%"
AND A.id NOT IN 
(SELECT A.id FROM z_contractor A WHERE LOWER(A.inn) LIKE "%'.$query.'%")
) 



) Z order by Z.name limit 0,20';
} else
{
	$sql='SELECT A.name,A.id,A.inn FROM z_contractor as A ORDER BY A.name limit 0,40';
}

//echo($sql);

$query_string='';
if($query=='') {
   // $query_string.='<li><a href="javascript:void(0);" rel="0">Любой</a></li>';
}

$result_work_zz=mysql_time_query($link,$sql);
$num_results_work_zz = $result_work_zz->num_rows;
	    if($num_results_work_zz!=0)
	    {
		   for ($i=0; $i<$num_results_work_zz; $i++)
		   {			   			  			   
			   $row_work_zz = mysqli_fetch_assoc($result_work_zz);	
			   if($query!='')
			   {
			   $query_string.='<li><a href="javascript:void(0);" rel="'.$row_work_zz["id"].'">'.search_text_strong(0,$query,$row_work_zz["name"]).'<span class="gray-date">(ИНН-'.search_text_strong(0,$query,$row_work_zz["inn"]).')</span></a></li>';
			   } else
			   {
			   $query_string.='<li><a href="javascript:void(0);" rel="'.$row_work_zz["id"].'">'.$row_work_zz["name"].'<span class="gray-date">(ИНН-'.$row_work_zz["inn"].')</span></a></li>';
			   }
			   
			   
		   }	
		} else
		{
			
						   $query_string.='<li><a href="javascript:void(0);" rel="0">Ничего не найдено</a></li>';
			

		}


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"query" => $query_string,"echo"=>$echo);
/*require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);
*/
echo json_encode($aRes);
?>