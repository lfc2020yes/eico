<?php
//выдача денег исполнителю в кассе

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$flag=htmlspecialchars($_GET['flag']);
$summ=htmlspecialchars($_GET['summ']);
$token=htmlspecialchars($_GET['tk']);
$dom=0;
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


if(token_access_new($token,'pay_implementer_avans',$id,'s_form'))
{

if (($role->permission('Касса','A'))or($sign_admin==1))
{	
    //
	if (($role->permission('Аванс','R'))or($sign_admin==1)) 
	{
if ((isset($_GET["id"]))and((is_numeric($_GET["id"])))and(isset($_GET["summ"]))and((is_numeric($_GET["summ"])))) 
{
	  if(isset($_SESSION["user_id"]))
	  { 
		 //может ли читать наряды 
		 
		 if (($role->permission('Касса','R'))or($sign_admin==1))
	     { 
			 
		   $result_t=mysql_time_query($link,'Select a.* from i_implementer as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд
		     if($_GET["summ"]<=100000)
		     { 
						   $result_t1=mysql_time_query($link,'Select a.id  from c_cash as a where a.id_implementer="'.htmlspecialchars(trim($_GET['id'])).'" and a.status=0');
			   $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1==0)
	   {  

			
         $status_ee='ok';
			
				 $numer=get_numer_doc(&$link,htmlspecialchars(trim(date("y-m-d"))),1);
         mysql_time_query($link,'INSERT INTO c_cash (id_cash,numer,date_rco,id_implementer,summa_rco,status,sign_rco,cashless,prepayment) VALUES ("'.$id_user.'","'.$numer.'","'.date("y.m.d").'","'.htmlspecialchars(trim($_GET['id'])).'","'.htmlspecialchars(trim($_GET["summ"])).'","0","0","0","1")');
			$ID_N=mysqli_insert_id($link);    
		 
				 
				
				 $result_t2=mysql_time_query($link,'Select sum(a.summa_rco) as sums  from c_cash as a where a.id_implementer="'.htmlspecialchars(trim($_GET['id'])).'" and status=0');
			
		//echo('Select a.*,b.date_doc,b.numer_doc,b.id as idd  from n_work as a,n_nariad as b where b.signedd_nariad=1 and a.id_nariad=b.id and a.id_razdeel2="'.htmlspecialchars(trim($id)).'" order by b.date_doc');
			
       $num_results_t2 = $result_t2->num_rows;
	   if($num_results_t2!=0)
	   {  	
			
			
		   $row_t2 = mysqli_fetch_assoc($result_t2);
		   $vid=$row_t2["sums"];
	   }
				 
				 
				 
	   if($flag==2)
	   {
		    $result_txs=mysql_time_query($link,'Select a.name_user from r_user as a where a.id="'.$id_user.'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);	
				}
		   
		   
		   $echo='<tr class="nary n1n " rel_cash="'.$ID_N.'"><td></td><td class="no_padding_left_ pre-wrap"><a target="_black" href="cashbox/print/'.$ID_N.'/">'.$numer.'</a><span style="border-bottom: 1px solid #ff540e; float:none;" class="status_nana">аванс</span></td><td class="no_padding_left_ pre-wrap">'.date_fik(date("y-m-d")).'</td><td><span class="s_j pay_summ boldi">'.rtrim(rtrim(number_format($_GET["summ"], 2, '.', ' '),'0'),'.').'</span></td><td cl_pay="'.$ID_N.'"><div style="margin-left: 0px;" data-tooltip="Выписал - '.$rowxs["name_user"].'" class="user_soz">'.avatar_img('<img src="img/users/',$id_user,'_100x100.jpg">').'</div><div id_upload="'.$ID_N.'" data-tooltip="загрузить кассовый ордер" class="user_soz naryd_upload"></div><form class="form_up" id="upload_sc_'.$ID_N.'" id_sc="'.$ID_N.'" name="upload'.$ID_N.'"><input class="sc_sc_loo" name="myfile'.$ID_N.'" type="file"></form><div class="loaderr_scan scap_load_'.$ID_N.'"><div class="scap_load__" style="width: 0%;"></div></div>
		   
		   <div id_bez="'.$ID_N.'" data-tooltip="безналичный расчет" class="user_soz beznal_upload"></div>
		   
		   </td><td or_pay="'.$ID_N.'"><div class="font-rank del_pay" data-tooltip="Удалить" id_rel="'.$ID_N.'"><span class="font-rank-inner">x</span></div></td><td></td></tr>';
		   
	   }
				 
	   if($flag==1)
	   {			 
		$echo1.='<h3 class="head_h" style=" margin-bottom:0px;">История выдачи денежных средств<div></div></h3>';				  
		$echo1.='<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_cash" class="smeta2 pay_imp"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">№ документа</th><th class="t_1">Дата выдачи</th><th class="t_2 no_padding_left_">сумма</th><th class="t_8">Выписал/Статус</th><th class="t_10"></th><th class="t_10"></th></tr></thead><tbody>';	
		   

		   		    $result_txs=mysql_time_query($link,'Select a.name_user from r_user as a where a.id="'.$id_user.'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);	
				}
		   
		   
		   $echo1.='<tr class="nary n1n " rel_cash="'.$ID_N.'"><td></td><td class="no_padding_left_ pre-wrap"><a target="_black" href="cashbox/print/'.$ID_N.'/">'.$numer.'</a></td><td class="no_padding_left_ pre-wrap">'.date_fik(date("y-m-d")).'</td><td><span class="s_j pay_summ boldi">'.rtrim(rtrim(number_format($_GET["summ"], 2, '.', ' '),'0'),'.').'</span></td><td cl_pay="'.$ID_N.'"><div style="margin-left: 0px;" data-tooltip="Выписал - '.$rowxs["name_user"].'" class="user_soz">'.avatar_img('<img src="img/users/',$id_user,'_100x100.jpg">').'</div><div id_upload="'.$ID_N.'" data-tooltip="загрузить кассовый ордер" class="user_soz naryd_upload"></div><form class="form_up" id="upload_sc_'.$ID_N.'" id_sc="'.$ID_N.'" name="upload'.$ID_N.'"><input class="sc_sc_loo" name="myfile'.$ID_N.'" type="file"></form><div class="loaderr_scan scap_load_'.$ID_N.'"><div class="scap_load__" style="width: 0%;"></div></div><div id_bez="'.$ID_N.'" data-tooltip="безналичный расчет" class="user_soz beznal_upload"></div></td><td or_pay="'.$ID_N.'"><div class="font-rank del_pay" data-tooltip="Удалить" id_rel="'.$ID_N.'"><span class="font-rank-inner">x</span></div></td><td></td></tr>';
		   
		   
		   $echo1.='</tbody></table><script>
				  OLD(document).ready(function(){  OLD("#table_freez_cash").freezeHeader({\'offset\' : \'67px\'}); });
				  </script>';
	   }
			 }
		   }
		 }
	  }
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }
}
}
 

}


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo, "echo1" =>  $echo1,"id" =>  $ID_N,"vid" =>  $vid);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>