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

$id=htmlspecialchars($_GET["id"]);



$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************
if ( count($_GET) != 2 ) 
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
 if ((!$role->permission('Снабжение','R'))and($sign_admin!=1))
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

//**************************************************
	if((!is_numeric($id))or($id==0))
	{

	    $debug=h4a(9,$echo_r,$debug);
		goto end_code;	
	}
//**************************************************
$result_t=mysql_time_query($link,'Select a.id from z_stock as a where a.id="'.htmlspecialchars(trim($id)).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t!=0)
{	
	$row_t = mysqli_fetch_assoc($result_t);
	//проверяем может ли видеть этот наряд
} else
{
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
}
//**************************************************

		
		
$status_ee='ok';

		
//узнаем сколько материала на складе



$result_t1_=mysql_time_query($link,'SELECT b.units,(SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_stock=b.id) as summ FROM z_stock as b WHERE b.id="'.htmlspecialchars(trim($id)).'"');


					$z_stock_count_users=0;
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_stock_count_users=$row1ss_["summ"];
					  }
					 $units=$row1ss_["units"];
					 // $echo.='<div class="yoop_rt"><span>на складе</span><i>'.$z_stock_count_users.'</i> <strong>'.$row1ss_["units"].'</strong></div>';
				 }						 

//узнаем сколько материала в заявке


$result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a,i_material as b,z_doc as doc, edo_state AS edo WHERE doc.id=a.id_doc and doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and a.id_i_material=b.id and b.alien=0 and a.status=9 and  a.id_stock="' . htmlspecialchars(trim($id)) . '"');
/*
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.status=9 and  a.id_stock="'.htmlspecialchars(trim($id)).'"');
*/

					$z_zakaz=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_zakaz=$row1ss_["summ"];
					  }
					 // $echo.='<div class="yoop_rt "><span>в заявках</span><i>'.$z_zakaz.'</i> <strong>'.$units.'</strong></div>';
				 }						 
//узнаем сколько материала в работе

$result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a,z_doc as doc, edo_state AS edo WHERE doc.id=a.id_doc and doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and  a.status=11 and  a.id_stock="' . htmlspecialchars(trim($id)) . '"');
/*
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.status=11 and  a.id_stock="'.htmlspecialchars(trim($id)).'"');
*/
					$z_rabota=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_rabota=$row1ss_["summ"];
					  }
					//  $echo.='<div class="yoop_rt "><span>в работе</span><i>'.$z_rabota.'</i> <strong>'.$units.'</strong></div>';
				 }		

//узнаем сколько материала на согласовании со счетом

$result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c,z_doc as doc,edo_state AS edo WHERE doc.id=c.id_doc and 
                                                                                                                                     doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and
                                                                                                                                     a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($id)) . '" AND a.id_acc=b.id AND b.status=2');
/*
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="'.htmlspecialchars(trim($id)).'" AND a.id_acc=b.id AND b.status=2');
*/
					$z_rabota1=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_rabota1=$row1ss_["summ"];
					  }
					 // $echo.='<div class="yoop_rt "><span>на согласовании со счетом</span><i>'.round($z_rabota1,3).'</i> <strong>'.$units.'</strong></div>';
				 }		

//узнаем сколько материала согласовано со счетом

$result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c,z_doc as doc,edo_state AS edo WHERE doc.id=c.id_doc and 
                                                                                                                          doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and          
                                                                                                                                     a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($id)) . '" AND a.id_acc=b.id AND b.status=3');

/*
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="'.htmlspecialchars(trim($id)).'" AND a.id_acc=b.id AND b.status=3');
*/
					$z_rabota2=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_rabota2=$row1ss_["summ"];
					  }
					 // $echo.='<div class="yoop_rt"><span>согласовано со счетом</span><i>'.round($z_rabota2,3).'</i> <strong>'.$units.'</strong></div>';
				 }	
//узнаем сколько материала оплачено


$result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c,z_doc as doc,edo_state AS edo WHERE doc.id=c.id_doc and 
                                                                                                                         doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and            
                                                                                                                                     a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($id)) . '" AND a.id_acc=b.id AND b.status=4');

/*
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="'.htmlspecialchars(trim($id)).'" AND a.id_acc=b.id AND b.status=4');
*/
					$z_rabota3=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_rabota3=$row1ss_["summ"];
					  }
					 // $echo.='<div class="yoop_rt "><span>оплачено</span><i>'.round($z_rabota3,3).'</i> <strong>'.$units.'</strong></div>';
				 }
//узнаем сколько материала получено

$result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c,z_doc as doc,edo_state AS edo WHERE doc.id=c.id_doc and 
                                                                                                                             doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and        
                                                                                                                                     a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($id)) . '" AND a.id_acc=b.id AND b.status=7');
/*
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="'.htmlspecialchars(trim($id)).'" AND a.id_acc=b.id AND b.status=7');
*/
$z_take=0;
$num_results_t1_ = $result_t1_->num_rows;
if($num_results_t1_!=0)
{
    //такая работа есть
    $row1ss_ = mysqli_fetch_assoc($result_t1_);
    if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
    {
        $z_take=$row1ss_["summ"];
    }
    //$echo.='<div class="yoop_rt "><span>оплачено</span><i>'.round($z_rabota3,2).'</i> <strong>'.$units.'</strong></div>';
}


//узнаем сколько материала необходимо еще

$result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a,i_material as b,z_doc as doc,edo_state AS edo WHERE doc.id=a.id_doc and 
  
                                                                                                               doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and
                                                                                                               a.id_i_material=b.id and b.alien=0 and a.status NOT IN ("1","8","10","3","5","4") and  a.id_stock="' . htmlspecialchars(trim($id)) . '"');
/*
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.status NOT IN ("1","8","10","3","5","4") and  a.id_stock="'.htmlspecialchars(trim($id)).'"');
*/
					$z_zakaz=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_zakaz=$row1ss_["summ"];
					  }
					 
					  $neo=round(($z_zakaz-$z_rabota1-$z_rabota2-$z_rabota3-$z_take),3);
					 $class_ada="red_ada";
					  if($neo<=0)
					  {
						  $neo=0;
						  $class_ada="green_ada";
					  }
					 // $echo.='<div class="yoop_rt yoop_click '.$class_ada.'"><span>еще необходимо</span><i>'.$neo.'</i> <strong>'.$units.'</strong></div>';
				 }




$echo.='<div class="neo-supply-yes '.$class_ada.'"><span class="eshe-span-boo">еще необходимо</span><span class="edit_panel11_mat more-panel-supply"><span data-tooltip="Подробнее" for="'.$id.'" class="history_icon">M</span><div class="history_act_mat history-prime-mat">
                                             <div class="line_brock"><div class="count_brock"><span>Состояние</span></div><div class="count_brock"><span>Кол-во</span></div></div>
                                             
<div class="line_brock"><div class="count_brock">На складе</div><div class="count_brock">'.rtrim(rtrim(number_format($z_stock_count_users, 3, '.', ' '),'0'),'.')
.'<b>'.$units.'</b></div></div>
<div class="line_brock"><div class="count_brock">в заявках</div><div class="count_brock">'.rtrim(rtrim(number_format($z_zakaz, 3, '.', ' '),'0'),'.').'<b>'.$units.'</b></div></div>
<div class="line_brock"><div class="count_brock">в работе</div><div class="count_brock">'.rtrim(rtrim(number_format($z_rabota, 3, '.', ' '),'0'),'.').'<b>'.$units.'</b></div></div>
<div class="line_brock"><div class="count_brock">на согласовании со счетом</div><div class="count_brock">'.rtrim(rtrim(number_format($z_rabota1, 3, '.', ' '),'0'),'.').'<b>'.$units.'</b></div></div>
<div class="line_brock"><div class="count_brock">согласовано со счетом</div><div class="count_brock">'.rtrim(rtrim(number_format($z_rabota2, 3, '.', ' '),'0'),'.').'<b>'.$units.'</b></div></div>
<div class="line_brock"><div class="count_brock">оплачено</div><div class="count_brock">'.rtrim(rtrim(number_format($z_rabota3, 3, '.', ' '),'0'),'.').'<b>'.$units.'</b></div></div></div></span><strong class="eshe-unit-boo">'.$units.'</strong><i class="eshe-count-boo">'.rtrim(rtrim(number_format($neo, 3, '.', ' '),'0'),'.').'</i> </div>';

		
//echo($echo);
	
	
			
		

end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"number" => $dom,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>