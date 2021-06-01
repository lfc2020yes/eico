<?php
//получение материалов из счета при выборе текущего счета

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

//$query=htmlspecialchars($_GET['query']);
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************
if ( count($_GET) != 3 ) 
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
 if ((!$role->permission('Накладные','A'))and($sign_admin!=1))
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
if ((!isset($_GET["id"]))or((!is_numeric($_GET["id"])))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}

if ((!isset($_GET["col"]))or((!is_numeric($_GET["col"])))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}


$result_t=mysql_time_query($link,'Select a.id from z_contractor as a where a.id="'.htmlspecialchars(trim($_GET['col'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{	
		$debug=h4a(7,$echo_r,$debug);
		goto end_code;
	
}


$result_t=mysql_time_query($link,'Select a.id from z_stock as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{	
		$debug=h4a(5,$echo_r,$debug);
		goto end_code;
	
}
//**************************************************
//**************************************************
/*
if(($row_t["id_user"]!=$id_user)and($sign_admin!=1))
{ 
	    $debug=h4a(7,$echo_r,$debug);
		goto end_code;	
}
*/
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';





$result_score=mysql_time_query($link,
							  
'select DISTINCT a.id,a.number,a.date,a.summa,a.id_contractor from z_acc as a,z_doc_material_acc as b,z_doc_material as c where a.id=b.id_acc and b.id_doc_material=c.id and c.id_stock="'.htmlspecialchars(trim($_GET['id'])).'" and a.status IN ("3", "4","20") and a.id_contractor="'.htmlspecialchars(trim($_GET['col'])).'"');
	
//если по счету все приняли не видеть этого счета

/*		 
			   <div class="score_a score_active"><i>2</i></div>
			   <div class="score_a"><i>10</i></div>			 
				*/	
			   //score_pay score_app score_active
				 
        $num_results_score = $result_score->num_rows;
	    if($num_results_score!=0)
	    {
			$echo.='<select class="demo-6" name="posta_posta">';	  
            $echo.='<option selected value="0">Выберите счет</option>';
		   for ($ss=0; $ss<$num_results_score; $ss++)
		   {			   			  			   
			   $row_score = mysqli_fetch_assoc($result_score);
			   
			   
			   
			   $PROC=0;	
			   $result_proc=mysql_time_query($link,'select sum(a.count_units) as summ,sum(a.count_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.$row_score["id"].'" and a.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');
                
	           $num_results_proc = $result_proc->num_rows;
               if($num_results_proc!=0)
               {
		          $row_proc = mysqli_fetch_assoc($result_proc);
				   				   
				  $result_proc1=mysql_time_query($link,'select sum(a.count_material) as ss from z_doc_material_acc as a,z_doc_material as b where a.id_doc_material=b.id and a.id_acc="'.$row_score["id"].'" and b.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');	
				  $num_results_proc1 = $result_proc1->num_rows;
				   
				  if($num_results_proc1!=0)
                  { 				   
				    $row_proc1 = mysqli_fetch_assoc($result_proc1); 
				  }
				   
				  if($row_proc1["ss"]!=0)
				  {
		            $PROC=round((($row_proc["summ"]-$row_proc["summ1"])*100)/$row_proc1["ss"]); 					  
				  }
				   
	           } 
	  	       if($PROC<100)
			   {
				
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   $result_t3=mysql_time_query($link,'SELECT a.name FROM z_contractor as a where a.id="'.$row_score["id_contractor"].'"');				

		  $class='';
  $num_results_t3 = $result_t3->num_rows; 
  if($num_results_t3!=0)
  {
	  $row__3= mysqli_fetch_assoc($result_t3);
	   $class=$row__3["name"];
  }
			   
			   
			   $date_graf2  = explode("-",$row_score["date"]);
			   $echo.='<option '.$select.' '.$class.' value="'.$row_score["id"].'">№'.$row_score["number"].' от '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].' на сумму '.$row_score["summa"].' руб. Поставщик - '.$class.'. - '.$PROC.'%</option>'; 
			   }
		   }
			$echo.='</select>';
		}


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>