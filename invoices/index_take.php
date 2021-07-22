<?
//согласовать для прорабов которые заполнили всю заявку на материал но у них есть служебные записки

session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; include_once $url_system.'module/config.php'; include_once $url_system.'module/function.php'; include_once $url_system.'login/function_users.php'; initiate($link); include_once $url_system.'module/access.php';

//правам к просмотру к действиям
$hie = new hierarchy($link,$id_user);
//echo($id_user);
$hie_object=array();
$hie_town=array();
$hie_kvartal=array();
$hie_user=array();	
$hie_object=$hie->obj;
$hie_kvartal=$hie->id_kvartal;
$hie_town=$hie->id_town;
$hie_user=$hie->user;

$sign_level=$hie->sign_level;
$sign_admin=$hie->admin;


$role->GetColumns();
$role->GetRows();
$role->GetPermission();



//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /finery/plus/28/
//     0   1     2  3
$error=0;
$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);




if ( count($_GET) != 1 ) 
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

//**************************************************
$token=htmlspecialchars($_POST['tk_sign']);
$id=htmlspecialchars($_GET['id']);
//if(!token_access_yes($token,'take_invoices_2018',$id,120))

    if(!token_access_new($token,'take_invoices_2018',$id,"rema",120)) {
        header404(4, $echo_r);
    }




//**************************************************
$result_url=mysql_time_query($link,'Select a.* from z_invoice as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_custom_url = $result_url->num_rows;
if($num_results_custom_url==0)
{
   $debug=h4a(43,$echo_r,$debug);
   goto end_code;				
}
//**************************************************
$row_t = mysqli_fetch_assoc($result_url);
		   
//проверяем может ли видеть этот наряд
if((($row_t["status"]!=1)))
{ 
	$debug=h4a(5,$echo_r,$debug);
    goto end_code;	
}

//**************************************************
	if($row_t["id_user"]!=$id_user)
	{
	$debug=h4a(51,$echo_r,$debug);
    goto end_code;	
	}
//**************************************************



//изменяем статус у накладной - получено
mysql_time_query($link,'update z_invoice set status="3" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');


//начисляем все материалы которые есть в накладной на него
$result_score=mysql_time_query($link,'select DISTINCT a.* from z_invoice_material as a where a.id_invoice="'.htmlspecialchars(trim($_GET['id'])).'" order by a.id');

$num_results_score = $result_score->num_rows;

if($num_results_score!=0)
{
    $nak='';
	for ($ss=0; $ss<$num_results_score; $ss++)
	{			   			  			   
		$row_score = mysqli_fetch_assoc($result_score);



		//если есть счет отправить создателю уведомление о том что пришел товар
		if(($row_score["id_acc"]!=0)and($row_score["id_acc"]!=''))
        {
if($nak!=$row_score["id_acc"]) {
    $result_uu8 = mysql_time_query($link, 'select number,date,id_contractor,id_user from z_acc where id="' . ht($row_score["id_acc"]) . '"');
    $num_results_uu8 = $result_uu8->num_rows;

    if ($num_results_uu8 != 0) {
        $row_uu8 = mysqli_fetch_assoc($result_uu8);


        $user_send_new = array();
        //уведомление
        array_push($user_send_new, $row_uu8["id_user"]);
        $text_not = 'По счету <a class="link-history" href="acc/' . $row_score["id_acc"] . '/">№' . $row_uu8['number'] . ' от ' . date_ex(0, $row_uu8["date"]) . '</a> поступил материал. Подробности в накладной <a class="link-history" href="/invoices/' . $_GET['id'] . '/">№' . $row_t["number"] . '</a>.';
        $user_send_new = array_unique($user_send_new);
        notification_send($text_not, $user_send_new, $id_user, $link);
    }
}
            $nak=$row_score["id_acc"];

        }






		
		$price=0;
		if($row_t["type_contractor"]==1)
		{
			//без ндс
			$price=$row_score["price"];
		} else
		{
			if(($row_score["price_nds"]!=0)and($row_score["price_nds"]!=''))
			{
				$price=$row_score["price_nds"];
			} else
			{
				$price=$row_score["price"];
			}
		}
		
		
		$count=$row_score["count_units"];
		if($row_score["defect"]==1)
		{
			$count=$count-$row_score["count_defect"];
		}
		
		
	    mysql_time_query($link,'INSERT INTO z_stock_material (id,id_stock,count_units,price,subtotal,id_user,id_object) VALUES ("","'.$row_score["id_stock"].'","'.$count.'","'.$price.'","'.$row_score["subtotal"].'","'.$id_user.'","0")');
			
		//смотрим есть ли акт на отбраковку
		if(($row_score["defect"]==1)and($row_score["id_acc"]!=0))
		{
			 //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	
				  $user_send= array();	
				  $user_send_new= array();		


			
			    
				  $result_url=mysql_time_query($link,'select A.* from z_stock as A where A.id="'.htmlspecialchars(trim($row_score["id_stock"])).'"');
                  $num_results_custom_url = $result_url->num_rows;
                  if($num_results_custom_url!=0)
                  {
			         $row_list1 = mysqli_fetch_assoc($result_url);
		          }
			
				  $result_url1=mysql_time_query($link,'select A.number,A.id_contractor,A.id_user,B.name from z_acc as A,z_contractor as B where A.id_contractor=B.id and A.id="'.htmlspecialchars(trim($row_score["id_acc"])).'"');
                  $num_results_custom_url1 = $result_url1->num_rows;
                  if($num_results_custom_url1!=0)
                  {
			         $row_list11 = mysqli_fetch_assoc($result_url1);
		          }	
			
		$user_send_new= array();		
		array_push($user_send_new,$row_list11["id_user"]);
   
			
		//найти сумму отбраковки по накладной
		$sum_defect_all=0;	

$result_score1=mysql_time_query($link,'Select a.* from z_invoice_material as a where a.id_invoice="'.htmlspecialchars(trim($_GET['id'])).'" and a.defect=1');
$num_results_score1 = $result_score1->num_rows;
if($num_results_score1!=0)
{
	for ($ss1=0; $ss1<$num_results_score1; $ss1++)
	{			   			  			   
		$row_score1 = mysqli_fetch_assoc($result_score1);
		$sum_defect_all=$sum_defect_all+$row_score1["subtotal_defect"];
	}
}	
			

			$text_not='';
			if($row_score["defect_comment"]!='')
			{
				$text_not.=', со следующим комментарием - <strong>'.$row_score["defect_comment"].'</strong>';
			}
			
						
			
		//создателя договора	
		$text_not='По счету <a class="link-history" href="acc/' . $row_score["id_acc"] . '/">№'.$row_list11["number"].'</a> от поставщика - <strong>'.$row_list11["name"].'</strong>, был оформлен акт на отбработку по <a class="link-history" href="invoices/'.$_GET['id'].'/">накладной №'.$row_t["number"].'</a>, материал - <strong>'.$row_list1["name"].'</strong>, в количестве - <strong>'.$row_score["count_defect"].' '.$row_list1["units"].'</strong>, на сумму <strong>'.$row_score["subtotal_defect"].' рублей</strong>'.$text_not.'. Необходимо связаться с поставщиком и <strong>переделать накладную <a class="link-history" href="invoices/'.$_GET['id'].'/">№'.$row_t["number"].'</a></strong> согласно принятых материалов на сумму '.($row_t["summa"]-$sum_defect_all).' рублей';
			
		//в бухгалтерию	
		/*$text_not1='По счету №'.$row_list11["number"].' от поставщика - <strong>'.$row_list11["name"].'</strong>, был оформлен акт на отбработку по <a href="invoices/'.$_GET['id'].'/">накладной №'.$row_t["number"].'</a>, материал - <strong>'.$row_list1["name"].'</strong>, в количестве - <strong>'.$row_score["count_defect"].' '.$row_list1["units"].'</strong>, на сумму <strong>'.$row_score["subtotal_defect"].' рублей</strong>. В ближайшее время вам поступит от снабженца переделанная накладная №'.$row_t["number"].' от '.$row_list11["name"].', на сумму '.($row_t["summa"]-$sum_defect_all).' рублей.';
		*/
			

				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);
				  /*
	            $FUSER=new find_user($link,'*','U','','buh');
		        $user_send_new=$FUSER->id_user;
                $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not1,$user_send_new,$id_user,$link);
  */
				  		  
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде		
		}

			   
	}
}



//проверяем закрываем счет или нет

$DEFECT_FLAG=0;   //0 - учитывать и закрывать только с дефектом 1- закрывать без учета дефекта
//начисляем все материалы которые есть в накладной на него
$result_score=mysql_time_query($link,'select DISTINCT a.* from z_invoice_material as a where a.id_invoice="'.htmlspecialchars(trim($_GET['id'])).'" order by a.id');

$num_results_score = $result_score->num_rows;

if($num_results_score!=0) {

    for ($ss = 0; $ss < $num_results_score; $ss++) {
        $row_score = mysqli_fetch_assoc($result_score);


        if(($row_score["id_acc"]!=0)and($row_score["id_acc"]!=''))
        {
            $PROC_All=0;

            $result_uu_in = mysql_time_query($link, 'select a.*,b.id_contractor,b.number,b.date from z_doc_material_acc as a,z_acc as b where a.id_acc="' . ht($row_score["id_acc"]) . '" and a.id_acc=b.id');
            $num_results_uu_in = $result_uu_in->num_rows;
            if ($result_uu_in) {
                while ($row_uu_in = mysqli_fetch_assoc($result_uu_in)) {
$PROC_STEP=0;

                    $result_proc=mysql_time_query($link,'select sum(a.count_units) as summ,sum(a.count_defect) as summ1  from             
             z_invoice_material as a,
             z_invoice as b                                                                              
where 
      a.id_acc="'.$row__2["id_acc"].'" and
      b.id=a.id_invoice and 
      not(b.status=1) and 
      a.id_doc_material_acc="'.$row_uu_in["id"].'"');

                    //echo('select sum(a.subtotal) as summ,sum(a.subtotal_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.$row_score["id"].'"');
                    $num_results_proc = $result_proc->num_rows;
                    if($num_results_proc!=0)
                    {
                        $row_proc = mysqli_fetch_assoc($result_proc);
                        //$PROC_STEP=$row_proc["summ"]-$row_proc["summ1"];


                        //$PROC_STEP=round((($row_proc["summ"]-$row_proc["summ1"])*100)/$row_uu_in["count_material"]);
                        if($DEFECT_FLAG==0) {
                            $PROC_STEP = $row_uu_in["count_material"] - ($row_proc["summ"] - $row_proc["summ1"]);
                        } else
                        {
                            $PROC_STEP = $row_uu_in["count_material"] - $row_proc["summ"];
                        }
                        echo('PROC_STEP-'.$PROC_STEP."<br>");
                        if($PROC_STEP<=0) {$PROC_All=$PROC_All+100;}
                        echo $row_uu_in["id"]."<br>";
                    }
                }
            }
echo('All-'.$PROC_All."<br>");
echo('Number-'.($num_results_uu_in*100));
if($PROC_All==($num_results_uu_in*100))
{
    //можно закрывать

    include_once $url_system.'/ilib/lib_interstroi.php';
    include_once $url_system.'/ilib/lib_edo.php';

    $edo = new EDO($link, $id_user, false);
    $arr_document = $edo->my_documents(1, ht($row_score["id_acc"]), '=0', true);
    //echo '<pre>arr_document:' . print_r($arr_document, true) . '</pre>';

    $id_s=0;
    foreach ($arr_document as $key => $value)
    {
        if((is_array($value["state"]))and(!empty($value["state"]))) {

            foreach ($value["state"] as $keys => $val) {
//echo($val["id_run_item"]);
                $id_s=$val["id_s"];
                $class_by = '';
                if ($val["id_status"] != 0) {
                    goto end_code1;
                }

                $but_mass = $edo->get_action($val["id_run_item"]);
            }} else
        {
            goto end_code1;
        }


    }

//изменяем статус по

    $array_status=$edo->set_status($id_s, 2);
    if($array_status==false)
    {
        goto end_code1;
    }


//отправляем следующим уведомления
    if (($edo->next($id, 1))===false) {


        $name_c='';
        $result_uu = mysql_time_query($link, 'select * from z_contractor where id="' . ht($row_uu_in['id_contractor']) . '"');
        $num_results_uu = $result_uu->num_rows;

        if ($num_results_uu != 0) {
            $row_uud = mysqli_fetch_assoc($result_uu);
            $name_c='Контрагент - '.$row_uud["name"];
        }

//echo(gettype($edo->arr_task));
        if(isset($edo->arr_task)) {
            foreach ($edo->arr_task as $key => $value) {
                //оправляем всем уведомления кому нужно рассмотреть этот документ далее


                $user_send_new = array();
                //уведомление
                array_push($user_send_new, $value["id_executor"]);



                $text_not='Вам поступила задача по счету <a class="link-history" href="acc/'.$row_score["id_acc"].'/">Счет №'.$row_uu_in['number'].' от '.date_ex(0,$row_uu_in['date']).'</a>. '.$name_c.' '.$value["description"];

                /*

                            } else {

                                $text_not = 'Вам поступила задача <a class="link-history" href="app/' . $_GET['id'] . '/">' . $row_list['name'] . '</a> - ' . $row_list1["object_name"] . ' (' . $row_town["town"] . ', ' . $row_town["kvartal"] . ')' . $value["description"];
                            }
                */
                //$text_not='Поступила <strong>новая заявка на материал №'.$row_list['number'].'</strong>, от '.$name_user.', по объекту -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].'). Детали в разделе <a href="supply/">cнабжение</a>.';
                //отправка уведомления
                $user_send_new = array_unique($user_send_new);
                notification_send($text_not, $user_send_new, $id_user, $link);


            }
        }



        // echo '<pre>arr_task:'.print_r($edo->arr_task,true) .'</pre>';

        if ($edo->error == 1) {
            // в array $edo->arr_task задания на согласование
        } else {

        }
    } else {
        // процесс согласования со всеми заданиями выполнен
        // echo '<pre>'.$edo->error_name[$edo->error].' - процесс согласования со всеми заданиями выполнен </pre>';
    }

    mysql_time_query($link, 'update z_acc set status="7" where id = "' . ht($row_score["id_acc"]) . '"');

    end_code1:


}



        }

    }
}






//echo($error);
//header("Location:".$base_usr."/invoices/".$_GET['id'].'/yes/');

end_code:

//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
	
?>