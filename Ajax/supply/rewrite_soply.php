<?php
//добавление нового счета

/*
   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&summa='+$("#summa_soply").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&post_p='+$(".post_p").val();
	} else
	{
   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&summa='+$("#summa_soply").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&name_c='+$("#name_contractor").val()+'&address_c='+$("#address_contractor").val()+'&inn_c='+$("#inn_contractor").val();	
*/

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

$id=htmlspecialchars($_GET['id']);
$token=htmlspecialchars($_GET['tk']);

$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=1; //выводить или нет ошибку 0 -нет
$debug='';



if(!token_access_new($token,'update_soply',$id,"s_form"))
{
   $debug=h4a(111,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
if (( count($_GET) != 10 )&&( count($_GET) != 12 ))
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
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
//**************************************************
if((htmlspecialchars(trim($_GET['number']))=='')or(htmlspecialchars(trim($_GET['date1']))==''))
{
  $debug=h4a(35,$echo_r,$debug);
  goto end_code;	
}
//**************************************************


if((isset($_GET['post_p']))and($_GET["new_c"]==0))
{
$result_t=mysql_time_query($link,'Select a.* from z_contractor as a where a.id="'.htmlspecialchars(trim($_GET['post_p'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{	
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
}
} else
{
if((!isset($_GET['name_c']))or(trim($_GET['name_c']=='')or!isset($_GET['inn_c']))or(trim($_GET['inn_c'])=='')or(!isset($_GET['address_c']))or(trim($_GET['address_c'])==''))
{	
	    $debug=h4a(66,$echo_r,$debug);
		goto end_code;	
	
}
}
//**************************************************
/*
if(($row_t["id_user"]!=$id_user)and($sign_admin!=1))
{ 
	    $debug=h4a(7,$echo_r,$debug);
		goto end_code;	
}
*/
//**************************************************

$result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.$id.'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд
		     if((($row_t["status"]==2))or($row_t["id_user"]!=$id_user))
		     { 
				    $debug=h4a(5,$echo_r,$debug);
   goto end_code;	
			 }
			   
		   } else
		   {
			      $debug=h4a(6,$echo_r,$debug);
   goto end_code;	
		   }


//**************************************************
//**************************************************

//проверка что количество не больше нужного
// $D = explode('.', $_COOKIE["basket_supply_".$id_user]);

  $result_t22=mysql_time_query($link,'Select DISTINCT a.id from z_doc_material_acc as d,z_doc_material as a where a.id=d.id_doc_material and d.id_acc="'.$id.'"');				
$xvg= explode('-', trim(htmlspecialchars($_GET['xvg'])));
$summaa=0;
  $num_results_t22 = $result_t22->num_rows; 
  if($num_results_t22!=0)
  {
	  for ($i=0; $i<$num_results_t22; $i++)
      {
		  $row__22= mysqli_fetch_assoc($result_t22);

	$xvg1= explode(':', $xvg[$i]);
	$summaa=$summaa+($xvg1[1]*$xvg1[0]);
	$result_t3=mysql_time_query($link,'SELECT a.count_units
FROM 
z_doc_material AS a
WHERE 
a.id="'.trim(htmlspecialchars($row__22["id"])).'"');	
	
	
		if(($xvg1[0]==0)or(!is_numeric($xvg1[0])))
		{
			$debug=h4a(79,$echo_r,$debug);
		    goto end_code;	
		}
		if(($xvg1[1]==0)or(!is_numeric($xvg1[1])))
		{
			$debug=h4a(89,$echo_r,$debug);
		    goto end_code;	
		}	
	
	
  		$num_results_t3 = $result_t3->num_rows; 
        if($num_results_t3==0)
        {	
				    $debug=h4a(77,$echo_r,$debug);
		            goto end_code;	
		} else
		{
		       $row__3= mysqli_fetch_assoc($result_t3);
			if($row__3["count_units"]<$xvg1[0])
			{
					    $debug=h4a(777,$echo_r,$debug);
		                goto end_code;	
			}
		}
	
			  // mysql_time_query($link,'INSERT INTO z_doc_material_acc (id_doc_material,count_material,id_acc) VALUES ("'.htmlspecialchars(trim($D[$i])).'","'.htmlspecialchars(trim($xvg[$i])).'","'.$ID_D.'")');			   
}
  }



$status_ee='ok';

	
//добавить новых поставщиков если надо
if((!isset($_GET['post_p']))and($_GET["new_c"]==1))
{	
 mysql_time_query($link,'INSERT INTO z_contractor (name,adress,inn) VALUES ("'.htmlspecialchars(trim($_GET['name_c'])).'","'.htmlspecialchars(trim($_GET['address_c'])).'","'.htmlspecialchars(trim($_GET['inn_c'])).'")');	
$ID_P=mysqli_insert_id($link);	
} else
{
	$ID_P=htmlspecialchars(trim($_GET['post_p']));
}

	
$DATER1 = explode('.', trim(htmlspecialchars($_GET['date1'])));
//$DATER2 = explode('.', trim(htmlspecialchars($_GET['date2'])));
		

 mysql_time_query($link,'update z_acc set number="'.htmlspecialchars(trim($_GET['number'])).'",date="'.$DATER1[2].'-'.$DATER1[1].'-'.$DATER1[0].'",id_contractor="'.$ID_P.'",summa="'.htmlspecialchars(trim($summaa)).'",delivery_day="'.htmlspecialchars(trim($_GET['date2'])).'",comment="'.htmlspecialchars(trim($_GET['com'])).'" where id = "'.$id.'"');


  $result_t2=mysql_time_query($link,'Select DISTINCT d.id from z_doc_material_acc as d where d.id_acc="'.$id.'"');				

  $num_results_t2 = $result_t2->num_rows; 
  if($num_results_t2!=0)
  {
	  $xvg= explode('-', trim(htmlspecialchars($_GET['xvg'])));
	  for ($ksss=0; $ksss<$num_results_t2; $ksss++)
      {
		  $row__2= mysqli_fetch_assoc($result_t2);
		  $xvg1= explode(':', $xvg[$ksss]);
		   mysql_time_query($link,'update z_doc_material_acc set count_material="'.htmlspecialchars(trim($xvg1[0])).'",price_material="'.htmlspecialchars(trim($xvg1[1])).'" where id = "'.$row__2["id"].'"');
	  }
  }

end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"number" => htmlspecialchars(trim($_GET['number'])),"summa" => htmlspecialchars(trim($summaa)),"dd"=>trim(htmlspecialchars($_GET['date1'])));
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>