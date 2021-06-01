<?php
//форма выдачи денежных средств исполнителю

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';


//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;
//$dom=0;
$id=htmlspecialchars($_GET['id']);

//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) ==1)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
    //
	

  if(((isset($_GET['id']))and(is_numeric($_GET['id']))))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		if (($role->permission('Касса','R'))or($sign_admin==1))  
		{
		
	
	    //составление секретного ключа формы
		//составление секретного ключа формы		
		//$token=token_access_compile($_GET['id'],'pay_implementer',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   //существует ли такой наряд
	   $result_t1=mysql_time_query($link,'Select a.id  from c_cash as a where a.id="'.htmlspecialchars(trim($id)).'" and a.status=0');
			
		//echo('Select a.*,b.date_doc,b.numer_doc,b.id as idd  from n_work as a,n_nariad as b where b.signedd_nariad=1 and a.id_nariad=b.id and a.id_razdeel2="'.htmlspecialchars(trim($id)).'" order by b.date_doc');
			
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  	
			
			
		   $row_t1 = mysqli_fetch_assoc($result_t1);
		   $status=1;
		   
		   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h3 class="head_h pay_uf" mor="" for="'.htmlspecialchars(trim($_GET['id'])).'">Выдача денежных средств<div></div></h3>';
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'<div class="imp_p"><span>Распечатать кассовый ордер?</span></div>';

	 echo'<a class="print_pay" href="cashbox/print/'.htmlspecialchars(trim($_GET['id'])).'/"><div class="dfp">*</div><div class="ripplepay"></div></a>';	   

  
    
        	  echo'<script type="text/javascript"> 
	  $(function (){ 
$(".ripplepay").addClass("rippleEffectPay");
});

	</script>';
         

		   
		   
			?>
	


			<br>
 <div class="over">            

<div id="no_rd" class="no_button"><i>Закрыть</i></div>            
           
            
<input type=hidden name="ref" value="00">
            </form>
            </span></div>
            
            </div>		
<?	   
		   
		   
	   

		   } 
	   
		}
	
	}

	}
	  
}
if($status==0)
{
	//что то не так. Почему то бронировать нельзя
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();	
}
/*

						 $datetime1 = date_create('Y-m-d');
                         $datetime2 = date_create('2017-01-17');
						 
                         $interval = date_create(date('Y-m-d'))->diff( $datetime2	);				 
                         $date_plus=$interval->days;
						 */
						 //echo(dateDiff_(date('Y-m-d'),'2017-01-17'));
						 


?>
<script type="text/javascript">initializeTimer();</script>
<?
include_once $url_system.'template/form_js.php';
?>

