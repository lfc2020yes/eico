<?
session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; include_once $url_system.'module/config.php'; include_once $url_system.'module/function.php'; include_once $url_system.'login/function_users.php'; initiate($link); include_once $url_system.'module/access.php';



$active_menu='invoices_1c';  // в каком меню


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
//правам к просмотру к действиям
//$user_send_new=array();




if((isset($_POST['save_invoice_two_step']))and($_POST['save_invoice_two_step']==1))
{
    //print_r($_POST);


	$token=htmlspecialchars($_POST['tk']);
	$id=htmlspecialchars($_GET['id']);
	
	//токен доступен в течении 120 минут
    if(token_access_new($token,'view_invoicess_x',$id,"rema",120))
	//if(token_access_yes($token,'view_invoicess_x',$id,120))
    {



		//echo("!");
	//возможно проверка что этот пользователь это может делать
	 if (($role->permission('Накладные','A'))or($sign_admin==1))
	 {	
	
		 
	$result_url=mysql_time_query($link,'select A.* from z_invoice as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {

			$row_list = mysqli_fetch_assoc($result_url);
			if($row_list["status"]==1)
			{
		 
		 
	$stack_memorandum = array();  // общий массив ошибок
	$stack_error = array();  // общий массив ошибок
	$error_count=0;  //0 - ошибок для сохранения нет
	$flag_podpis=0;  //0 - все заполнено можно подписывать

	//print_r($stack_error);
	//исполнитель	
	if(($_POST['ispol_work']==0)or($_POST['ispol_work']==''))
	{
		array_push($stack_error, "ispol_work");
		$error_count++;
		$flag_podpis++;  
	}
	
	//ндс без			
	if(($_POST['ispol_type']!=0)and($_POST['ispol_type']!=1))
	{
		array_push($stack_error, "ispol_type");
		$error_count++;
		$flag_podpis++;  
	}			
				
	//дата документ
	if($_POST['datess']=='')
	{
		array_push($stack_error, "datess");
		$error_count++;
		$flag_podpis++;
	}	

	if($_POST['number_invoices']=='')
	{
		array_push($stack_error, "number_invoices");
		$error_count++;
		$flag_podpis++;
	}
				
	
			
		
	    if((count($stack_error)==0)and($error_count==0))
		{
		   //ошибок нет
		   //сохраняем накладную
		   
		   $today[0] = date("y.m.d"); //присвоено 03.12.01
           $today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17
		   
			mysql_time_query($link,'update z_invoice set number="'.htmlspecialchars($_POST['number_invoices']).'",date="'.htmlspecialchars($_POST['date_invoice']).'",id_contractor="'.htmlspecialchars(trim($_POST["ispol_work"])).'",type_contractor="'.htmlspecialchars(trim($_POST["ispol_type"])).'",nds_view="'.htmlspecialchars($_POST['nds_ff']).'",nds_material="'.htmlspecialchars($_POST['nds_material']).'" where id = "'.htmlspecialchars($_GET['id']).'"');
			
		   
		}
				
			
				
		
				
		  $error_work = array();  //обнуляем массив ошибок по конкретной материалу				   
		  $flag_message=0;	//0 - вывод акта по работе нет
				
				
				if(isset($_POST['invoice'])) {
                    $works = $_POST['invoice'];
                    foreach ($works as $key => $value) {
                        //смотрим вдруг был удален этот материал при оформлении
                        if ($value['id'] != '') {
                            /*
                           $value['id']
                           $value['price']
                           $value['count']
                           $value['price_nds']


                           $_POST['invoice'][0]["id"]
                           */
                            if ($value['prime'] == 0) {
                                $result_tx = mysql_time_query($link, 'Select a.id from z_invoice_material as a where a.id="' . htmlspecialchars(trim($value['id'])) . '"');
                                $num_results_tx = $result_tx->num_rows;
                                if ($num_results_tx != 0) {
                                    //такой материал есть
                                    $rowx = mysqli_fetch_assoc($result_tx);
                                    $count_mat = $value['count'];
                                    $price_mat = $value['price'];
                                    //$price_nds_mat = $value['price_nds'];
                                    $count_mat_akt = $value['count_defect'];
                                    $comment_mat_akt = $value['text'];
                                    $defect = $value['defect'];

                                    if ($defect == 1) {
                                        $flag_message = 1;
                                        if ((!is_numeric($count_mat_akt)) or ($count_mat_akt <= 0) or ($count_mat < $count_mat_akt)) {
                                            $flag_podpis++;
                                            array_push($error_work, $value['id'] . "_w_count_defect");
                                        }

                                        //смотрим есть ли прикрепленные акты
                                        //$result_scorexx=mysql_time_query($link,'Select a.* from z_invoice_attach_defect as a where a.type_invoice=0 and a.id_invoice_material="'.htmlspecialchars(trim($value['id'])).'"');


                                        $result_scorexx = mysql_time_query($link, 'SELECT b.id FROM image_attach AS b,z_invoice_material AS c WHERE b.for_what=7 AND b.visible=1 and b.id_object=c.id AND c.id="' . htmlspecialchars(trim($value['id'])) . '"');


                                        $num_results_scorexx = $result_scorexx->num_rows;
                                        if ($num_results_scorexx == 0) {
                                            if ($comment_mat_akt == '') {
                                                $flag_podpis++;
                                                array_push($error_work, $value['id'] . "_w_text");
                                            }

                                        }


                                    }
                                }
                            } else {
                                //проверка для автоматически добавленного материала из себестоимости
                                $result_tx = mysql_time_query($link, 'Select a.id from i_material as a where a.id="' . htmlspecialchars(trim($value['id'])) . '"');
                                $num_results_tx = $result_tx->num_rows;
                                if ($num_results_tx != 0) {
                                    //такой материал есть
                                    $rowx = mysqli_fetch_assoc($result_tx);
                                    $count_mat = $value['count'];
                                    $price_mat = $value['price'];
                                    //$price_nds_mat = $value['price_nds'];
                                    $count_mat_akt = $value['count_defect'];
                                    $comment_mat_akt = $value['text'];
                                    $defect = $value['defect'];

                                }
                            }
                        }
                    }
                }
				
		if(($flag_message==1)and(count($error_work)!=0))
				 {
					 //echo("!");
					 //print_r($error_work);
					 //ошибка общая для служебной записке не все поля заполнены
					 //добавляем ошибки из $error_work в $stack_error
					 foreach ($error_work as $keys_w => $value_w) 
			         {
					   array_push($stack_error, $error_work[$keys_w]);
					 }
					 $error_count++;
				 }		
				
				
		if((count($stack_error)==0)and($error_count==0))
		{			
		
		

		   $summa_all=0;
				
$count_material=0;

//echo(count($works));
            if(isset($_POST['invoice'])) {
                $works = $_POST['invoice'];
                foreach ($works as $key => $value) {
                    //смотрим вдруг был удален этот материал при оформлении
                    if ($value['id'] != '') {
                        /*
                       $value['id']
                       $value['price']
                       $value['count']
                       $value['price_nds']


                       $_POST['invoice'][0]["id"]
                       */

                        $summ_tr = 0;
                        //echo'id-'.$value['id'].'<br>';

                        if ($value['prime'] == 0) {
                            $result_tx = mysql_time_query($link, 'Select a.id from z_invoice_material as a where a.id="' . htmlspecialchars(trim($value['id'])) . '"');
                            $num_results_tx = $result_tx->num_rows;
                            if ($num_results_tx != 0) {
                                //такой материал есть
                                $rowx = mysqli_fetch_assoc($result_tx);
                                $count_material++;
                                $count_mat = $value['count'];
                                $price_mat = $value['price'];
                               // $price_nds_mat = $value['price_nds'];
                                $count_mat_akt = $value['count_defect'];
                                $comment_mat_akt = $value['text'];
                                $defect = $value['defect'];


                                if ($defect == 1) {

                                    if ((!is_numeric($count_mat_akt)) or ($count_mat_akt <= 0) or ($count_mat < $count_mat_akt)) {
                                        $flag_podpis++;
                                        array_push($error_work, $value['id'] . "_w_count_defect");
                                    }

                                    //смотрим есть ли прикрепленные акты
                                    //$result_scorexx=mysql_time_query($link,'Select a.* from z_invoice_attach_defect as a where a.type_invoice=0 and a.id_invoice_material="'.htmlspecialchars(trim($value['id'])).'"');


                                    $result_scorexx = mysql_time_query($link, 'SELECT b.id FROM image_attach AS b,z_invoice_material AS c WHERE b.for_what=7 AND b.visible=1 and b.id_object=c.id AND c.id="' . htmlspecialchars(trim($value['id'])) . '"');


                                    $num_results_scorexx = $result_scorexx->num_rows;
                                    if ($num_results_scorexx == 0) {
                                        if ($comment_mat_akt == '') {
                                            $flag_podpis++;
                                            array_push($error_work, $value['id'] . "_w_text");
                                        }

                                    }


                                }

                                if ($value['mild'] == 0) {
                                    if ((($price_nds_mat == 0) or ($price_nds_mat == '') or (!is_numeric($price_nds_mat))) and (($price_mat == 0) or ($price_mat == '') or (!is_numeric($price_mat)))) {
                                        $flag_podpis++;
                                        $summ_tr++;
                                    }
                                }
                                if ((!is_numeric($count_mat)) or ($count_mat <= 0)) {
                                    $flag_podpis++;
                                    $summ_tr++;
                                }
                                $s_tr = 0;
                                $s_tr1 = 0;
                                $cost_table = 0;
                                $cost_table_nds = 0;
                                $row_price=0;
                                $row_price_nds=0;


                                // echo'sum-'.$summ_tr.'<br>';

                                //if ($summ_tr == 0) {

                                $s_tr = $price_mat * $count_mat;
                                $s_tr1 = $price_mat * $count_mat_akt;
                                $cost_table = $price_mat;

                                if ($_POST["ispol_type"] == 0) {

                                    //счет с ндс
                                    if($_POST["nds_material"] == 0)
                                    {
                                        //Цена за материал указана с ндс
                                        $row_price_nds=$price_mat;
                                        $row_price=0;
                                    } else
                                    {
                                        //Цена за материал указана без ндс
                                        $row_price=$price_mat;
                                        $row_price_nds=0;
                                    }

/*

                                    if ($_POST['nds_ff'] == 0) {
                                        $s_tr = $price_nds_mat * $count_mat;
                                        $s_tr1 = $price_nds_mat * $count_mat_akt;
                                        $cost_table_nds = $price_nds_mat;
                                    } else {
                                        $s_tr = $price_mat * 1.18 * $count_mat;
                                        $s_tr1 = $price_mat * 1.18 * $count_mat_akt;
                                        $cost_table = $price_mat;
                                    }
*/
                                    /*
                                   if((is_numeric($price_nds_mat))and($price_nds_mat!=0))
                                   {
                                     $s_tr=$price_nds_mat*$count_mat;
                                     $s_tr1=$price_nds_mat*$count_mat_akt;
                                     $cost_table_nds=$price_nds_mat;
                                    } else
                                   {
                                      $s_tr=$price_mat*1.18*$count_mat;
                                      $s_tr1=$price_mat*1.18*$count_mat_akt;
                                       $cost_table=$price_mat;
                                   }
                                   */
                                } else {

                                    $row_price=$price_mat;
                                    $row_price_nds=0;

                                }


                                //}

                                $summa_all = $summa_all + $s_tr;
                                //echo('update z_invoice_material set count_units="'.htmlspecialchars($count_mat).'",price="'.htmlspecialchars($cost_table).'",price_nds="'.htmlspecialchars(trim($cost_table_nds)).'",subtotal="'.htmlspecialchars(trim($s_tr)).'" where id = "'.htmlspecialchars($value['id']).'"');
                                mysql_time_query($link, 'update z_invoice_material set count_units="' . htmlspecialchars($count_mat) . '",price="' . htmlspecialchars($row_price) . '",price_nds="' . htmlspecialchars(trim($row_price_nds)) . '",subtotal="' . htmlspecialchars(trim($s_tr)) . '",subtotal_defect="' . htmlspecialchars(trim($s_tr1)) . '",defect="' . htmlspecialchars($value['defect']) . '",count_defect="' . htmlspecialchars($value['count_defect']) . '",defect_comment="' . htmlspecialchars($value['text']) . '",mild="' . htmlspecialchars($value['mild']) . '",alien="' . htmlspecialchars($value['alien']) . '" where id = "' . htmlspecialchars($value['id']) . '"');

                                //echo'update z_invoice_material set count_units="'.htmlspecialchars($count_mat).'",price="'.htmlspecialchars($cost_table).'",price_nds="'.htmlspecialchars(trim($cost_table_nds)).'",subtotal="'.htmlspecialchars(trim($s_tr)).'",subtotal_defect="'.htmlspecialchars(trim($s_tr1)).'",defect="'.htmlspecialchars($value['defect']).'",count_defect="'.htmlspecialchars($value['count_defect']).'",defect_comment="'.htmlspecialchars($value['text']).'" where id = "'.htmlspecialchars($value['id']).'"';
                                //echo'<br>';

                                if ($value['defect'] == 0) {
                                    //удаляем всю инфу по актам по этому материалу

                                    /*
                                    $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/invoices/scan_akt/';
                                    $uploaddir1 = $_SERVER["DOCUMENT_ROOT"].'/invoices/scan_material/';

                                    $result_scorex1=mysql_time_query($link,'Select a.* from z_invoice_attach_defect as a where a.id_invoice_material="'.htmlspecialchars(trim($value['id'])).'"');





                                    $num_results_scorex1 = $result_scorex1->num_rows;



                                    if($num_results_scorex1!=0)
                                    {
                                        for ($ssx=0; $ssx<$num_results_scorex1; $ssx++)
                                        {
                                            $row_scorex1 = mysqli_fetch_assoc($result_scorex1);
                                             $uploadfile = $uploaddir.$value['id'].'_'.$row_scorex1["name"].'.jpg';
                                             $uploadfile1 = $uploaddir1.$value['id'].'_'.$row_scorex1["name"].'.jpg';
                                            if (file_exists($uploadfile)) {unlink($uploadfile);}
                                             if (file_exists($uploadfile1)) {unlink($uploadfile1);}
                                        }


                                    }
                                   */
                                    // mysql_time_query($link,'delete FROM z_invoice_attach_defect where id_invoice_material="'.htmlspecialchars(trim($value['id'])).'"');

                                    //mysql_time_query($link,'delete FROM image_attach as b where ((b.for_what=7)or(b.for_what=6)) AND b.visible=1 and b.id_object="'.htmlspecialchars(trim($value['id'])).'"');

                                    mysql_time_query($link, 'update image_attach set
                       
                       visible="0"
                       
                       where ((for_what=7)or(for_what=6)) AND visible=1 and id_object="' . htmlspecialchars(trim($value['id'])) . '"');

                                    // $result_scorexx=mysql_time_query($link,'SELECT b.id FROM image_attach AS b,z_invoice_material AS c WHERE b.for_what=7 AND b.visible=1 and b.id_object=c.id AND c.id="'.htmlspecialchars(trim($value['id'])).'"');


                                }


                            }
                        } else {
                            //для материалов автоматически подгруженных с себестоимости
                            $result_tx = mysql_time_query($link, 'Select a.id from i_material as a where a.id="' . htmlspecialchars(trim($value['id'])) . '"');
                            $num_results_tx = $result_tx->num_rows;
                            if ($num_results_tx != 0) {
                                //такой материал есть
                                $rowx = mysqli_fetch_assoc($result_tx);
                                $count_material++;
                                $count_mat = $value['count'];
                                $price_mat = $value['price'];
                                $price_nds_mat = $value['price_nds'];


                                //проверка на нулевую стоимость
                                if ($value['mild'] == 0) {
                                    if ((($price_nds_mat == 0) or ($price_nds_mat == '') or (!is_numeric($price_nds_mat))) and (($price_mat == 0) or ($price_mat == '') or (!is_numeric($price_mat)))) {
                                        $flag_podpis++;
                                        $summ_tr++;
                                    }
                                }
                                //проверка на нулевое количество
                                if ((!is_numeric($count_mat)) or ($count_mat <= 0)) {
                                    $flag_podpis++;
                                    $summ_tr++;
                                }

                                $s_tr = 0;
                                $s_tr1 = 0;
                                $cost_table = 0;
                                $cost_table_nds = 0;
                                $row_price_nds=0;
                                $row_price=0;

                                $s_tr = $price_mat * $count_mat;
                                $s_tr1 = $price_mat * $count_mat_akt;
                                $cost_table = $price_mat;

                                if ($_POST["ispol_type"] == 0) {

                                    //счет с ндс
                                    if($_POST["nds_material"] == 0)
                                    {
                                        //Цена за материал указана с ндс
                                        $row_price_nds=$price_mat;
                                        $row_price=0;
                                    } else
                                    {
                                        //Цена за материал указана без ндс
                                        $row_price=$price_mat;
                                        $row_price_nds=0;
                                    }

                                    /*

                                                                        if ($_POST['nds_ff'] == 0) {
                                                                            $s_tr = $price_nds_mat * $count_mat;
                                                                            $s_tr1 = $price_nds_mat * $count_mat_akt;
                                                                            $cost_table_nds = $price_nds_mat;
                                                                        } else {
                                                                            $s_tr = $price_mat * 1.18 * $count_mat;
                                                                            $s_tr1 = $price_mat * 1.18 * $count_mat_akt;
                                                                            $cost_table = $price_mat;
                                                                        }
                                    */
                                    /*
                                   if((is_numeric($price_nds_mat))and($price_nds_mat!=0))
                                   {
                                     $s_tr=$price_nds_mat*$count_mat;
                                     $s_tr1=$price_nds_mat*$count_mat_akt;
                                     $cost_table_nds=$price_nds_mat;
                                    } else
                                   {
                                      $s_tr=$price_mat*1.18*$count_mat;
                                      $s_tr1=$price_mat*1.18*$count_mat_akt;
                                       $cost_table=$price_mat;
                                   }
                                   */
                                } else {

                                    $row_price=$price_mat;
                                    $row_price_nds=0;

                                }


                                // echo'sum-'.$summ_tr.'<br>';
/*
                                // if ($summ_tr == 0) {
                                if ($_POST["ispol_type"] == 0) {
                                    //c ндс

                                    if ($_POST['nds_ff'] == 0) {
                                        $s_tr = $price_nds_mat * $count_mat;
                                        $s_tr1 = $price_nds_mat * $count_mat_akt;
                                        $cost_table_nds = $price_nds_mat;
                                    } else {
                                        $s_tr = $price_mat * 1.18 * $count_mat;
                                        $s_tr1 = $price_mat * 1.18 * $count_mat_akt;
                                        $cost_table = $price_mat;
                                    }

                                } else {
                                    //без ндс
                                    //echo($price_mat);
                                    $s_tr = $price_mat * $count_mat;
                                    $s_tr1 = $price_mat * $count_mat_akt;
                                    $cost_table = $price_mat;
                                }
*/

                                //}

                                $summa_all = $summa_all + $s_tr;
                                //echo('update z_invoice_material set count_units="'.htmlspecialchars($count_mat).'",price="'.htmlspecialchars($cost_table).'",price_nds="'.htmlspecialchars(trim($cost_table_nds)).'",subtotal="'.htmlspecialchars(trim($s_tr)).'" where id = "'.htmlspecialchars($value['id']).'"');

                                mysql_time_query($link, 'INSERT INTO z_invoice_material (id_invoice,id_acc,id_doc_material_acc,id_stock,count_units,price,price_nds,subtotal,alien,mild) VALUES ("' . htmlspecialchars(trim($_GET['id'])) . '","0","0","' . htmlspecialchars(trim($value['stock'])) . '","' . htmlspecialchars($count_mat) . '","' . htmlspecialchars($row_price) . '","' . htmlspecialchars(trim($row_price_nds)) . '","' . htmlspecialchars(trim($s_tr)) . '","' . ht($value['alien']) . '","' . ht($value['mild']) . '")');

                                //echo('INSERT INTO z_invoice_material (id_invoice,id_acc,id_doc_material_acc,id_stock,count_units,price,price_nds,subtotal,alien,mild) VALUES ("'.htmlspecialchars(trim($_GET['id'])).'","0","0","'.htmlspecialchars(trim($value['stock'])).'","' . htmlspecialchars($count_mat) . '","' . htmlspecialchars($cost_table) . '","' . htmlspecialchars(trim($cost_table_nds)) . '","' . htmlspecialchars(trim($s_tr)) . '","'.ht($value['alien']).'","'.ht($value['mild']).'")');

                                $ID_INV = mysqli_insert_id($link);


                                //echo'update z_invoice_material set count_units="'.htmlspecialchars($count_mat).'",price="'.htmlspecialchars($cost_table).'",price_nds="'.htmlspecialchars(trim($cost_table_nds)).'",subtotal="'.htmlspecialchars(trim($s_tr)).'",subtotal_defect="'.htmlspecialchars(trim($s_tr1)).'",defect="'.htmlspecialchars($value['defect']).'",count_defect="'.htmlspecialchars($value['count_defect']).'",defect_comment="'.htmlspecialchars($value['text']).'" where id = "'.htmlspecialchars($value['id']).'"';
                                //echo'<br>';

                                if ($value['defect'] == 0) {
                                    //удаляем всю инфу по актам по этому материалу

                                    /*
                                    $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/invoices/scan_akt/';
                                    $uploaddir1 = $_SERVER["DOCUMENT_ROOT"].'/invoices/scan_material/';

                                    $result_scorex1=mysql_time_query($link,'Select a.* from z_invoice_attach_defect as a where a.id_invoice_material="'.htmlspecialchars(trim($value['id'])).'"');





                                    $num_results_scorex1 = $result_scorex1->num_rows;



                                    if($num_results_scorex1!=0)
                                    {
                                        for ($ssx=0; $ssx<$num_results_scorex1; $ssx++)
                                        {
                                            $row_scorex1 = mysqli_fetch_assoc($result_scorex1);
                                             $uploadfile = $uploaddir.$value['id'].'_'.$row_scorex1["name"].'.jpg';
                                             $uploadfile1 = $uploaddir1.$value['id'].'_'.$row_scorex1["name"].'.jpg';
                                            if (file_exists($uploadfile)) {unlink($uploadfile);}
                                             if (file_exists($uploadfile1)) {unlink($uploadfile1);}
                                        }


                                    }
                                   */
                                    // mysql_time_query($link,'delete FROM z_invoice_attach_defect where id_invoice_material="'.htmlspecialchars(trim($value['id'])).'"');

                                    //mysql_time_query($link,'delete FROM image_attach as b where ((b.for_what=7)or(b.for_what=6)) AND b.visible=1 and b.id_object="'.htmlspecialchars(trim($value['id'])).'"');

                                    mysql_time_query($link, 'update image_attach set
                       
                       visible="0"
                       
                       where ((for_what=7)or(for_what=6)) AND visible=1 and id_object="' . htmlspecialchars(trim($ID_INV)) . '"');

                                    // $result_scorexx=mysql_time_query($link,'SELECT b.id FROM image_attach AS b,z_invoice_material AS c WHERE b.for_what=7 AND b.visible=1 and b.id_object=c.id AND c.id="'.htmlspecialchars(trim($value['id'])).'"');


                                }


                            }
                        }
                    }
                }
            }

            if((isset($_GET["prime"]))and(( isset($_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['prime']))]))and($_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['prime']))]!='')))
            {

                			 setcookie("basket1_".$id_user."_".htmlspecialchars($_GET['prime']), "", time()-3600,"/", $base_cookie, false, false);
            }

		
		if((count($stack_error)==0)and($error_count==0))
		{
		   //ошибок нет
		   //сохраняем накладную

			mysql_time_query($link,'update z_invoice set summa="'.$summa_all.'" where id = "'.htmlspecialchars($_GET['id']).'"');	
			
		   
		}		
	

		if(($flag_podpis==0)and($count_material!=0))
		{
			
			//все заполнено можно ставить ready на передачу
			mysql_time_query($link,'update z_invoice set ready="1" where id = "'.htmlspecialchars($_GET['id']).'"');
			
		} else
		{
			mysql_time_query($link,'update z_invoice set ready="0" where id = "'.htmlspecialchars($_GET['id']).'"');
		}

            header("Location:".$base_usr."/invoices/".$_GET["id"].'/save/');
            die();


        }
		}
		}

}

}
	
	
}


/*
$secret=rand_string_string(4);
$_SESSION['s_t'] = $secret;	
*/




//проверить и перейти к последней себестоимости в которой был пользователь


//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /invoices/add/
//    0    1      2  
$echo_r=1; //выводить или нет ошибку 0 -нет
$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

if (strripos($url_404, 'index_view.php') !== false) {
   header404(1,$echo_r);	
}

//**************************************************
/*
if (( count($_GET) != 1 ) )
{
   header404(2,$echo_r);		
}
*/
if((!$role->permission('Накладные_1c','R'))and($sign_admin!=1))
{
  header404(3,$echo_r);
}


include_once '../ilib/lib_import.php';


$csv = new CSV($link, $id_user);
$mask = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/*.csv';
$mask_attach = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/1c_attach/';
$arFiles = $csv->read_dir ($mask,$mask_attach);
if(isset($_GET["id"])) {
    //iconv( 'windows-1251','UTF-8',$debug)\
    //echo(base64_decode($_GET['id']));
    $data = $csv->read_data(iconv( 'UTF-8','windows-1251',base64_decode($_GET['id'])));
    if(count($data)==0)
    {
        header404(5,$echo_r);
    }
} else
{
    header404(4,$echo_r);
}

if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//echo "<pre> ФАЙЛЫ [$mask]: ".print_r($data,true)."</pre>";

$status_edit='';
$status_class='';
$status_edit1='';
if($row_list["status"]==3)		
{	
   $status_edit='readonly';	
   $status_edit1='disabled';
   $status_class='grey_edit';		
}



include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('invoices_1c_view','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php'; include $url_system.'template/head.php';
?>
</head><body><div class="alert_wrapper"><div class="div-box"></div></div>
<?
include_once $url_system.'template/body_top.php';	
?>

<div class="container">
<?


if ( isset($_COOKIE["iss"]))
{
    if($_COOKIE["iss"]=='s')
    {
        echo'<div class="iss small">';
    } else
    {
        echo'<div class="iss big">';
    }
} else
{
    echo'<div class="iss big">';
}


	
?>

<div class="left_block">
  <div class="content">

<?
                $act_='display:none;';
	            $act_1='';
	            if(cookie_work('it_','on','.',60,'0'))
	            {
		            $act_='';
					$act_1='on="show"';
	            }

	  include_once $url_system.'template/top_invoices_view_1c.php';

?>

      <div id="fullpage" class="margin_60  input-block-2020 ">
          <div class="section" id="section0">
              <div class="height_100vh">
                  <div class="oka_block_2019">
                      <div class="div_ook" style="border-bottom: 1px solid rgba(0,0,0,0.05);">

                          <form id="lalala_add_form" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">

<?
$date_mass = explode(" ", ht($data[0]["Дата"]));
$date_mass1 = explode(":", $date_mass[1]);

$date_start = $date_mass[0] . ' ' . $date_mass1[0] . ':' . $date_mass1[1];
echo'<div class="one_s_flex">

    <div class="one_s_global">

        <div class="name_one">

            <div class="pass_wh_trips" ><label>Накладная</label><div class="obi">№ '.$data[0]["Номер"].'</div></div>

            <div class="pass_wh_trips" ><label>Дата создания</label><div class="obi">'.$date_start.'</div></div>
        </div>

        <div class="name_two">
            <div class="pass_wh_trips" ><label>Контрагент</label><div class="obi">'.$data[0]["НаименованиеПолноеКонтрагента"].'</div></div>

            <div class="pass_wh_trips" ><label>ИНН</label><div class="obi">'.$data[0]["ИНН"].'</div></div>

        </div>
        <div class="name_free">
        <div class="pass_wh_trips" ><label>Ответственный</label><div class="obi">'.$data[0]["Ответственный"].'</div></div>
            <div class="pass_wh_trips" ><label>Файлы 1с</label></div>';

$arAttach = $csv->list_attach( $data[0][УИДДокумента],$mask_attach);
//echo "<pre> ФАЙЛЫ: ".print_r($arAttach,true)."</pre>";

if(count($arAttach)!=0)
{
        echo'<div style="display: inline-block" class=""><div class="img_invoice_div1 js-image-gl"><div style="display: inline-block"><div class="list-image list-image-icons" style="display: block;">';

    foreach ($arAttach as $key => $value)
    {
        $type_file=explode(".",$value);
$type_s=end($type_file);
echo'<div class="li-image yes-load"><span style="z-index: 1" class="name-img"><a href="'.$value.'" target="_blank">&nbsp;</a></span><span style="z-index: 0; text-transform: uppercase;" class="type-img">'.$type_s.'</span></div>';


    }



                    echo'</div></div></div></div>';
}

        echo'</div>
    </div>
    <div class="one_s_acc">


        <div class="pass_wh_trips" ><label>Счета связанные с контрагентом</label></div>';

$CA=0;
//определяем какой по id у нас это контрагент
$contractor = new CONTRACTOR($link, $id_user);
if (($id=$contractor->get($data[0]["ИНН"])) !== false) { $CA=$id; }
else
    if (($id=$contractor->put($data[0]))!==false) { $CA=$id; }



$result_score=mysql_time_query($link,

'select DISTINCT a.id,a.number,a.date,a.summa,a.id_contractor from z_acc as a where a.status IN ("2","3", "4","20") and a.id_contractor="'.htmlspecialchars(trim($CA)).'"');

//если по счету все приняли не видеть этого счета

/*
			   <div class="score_a score_active"><i>2</i></div>
			   <div class="score_a"><i>10</i></div>
				*/
			   //score_pay score_app score_active

        $num_results_score = $result_score->num_rows;
	    if($num_results_score!=0) {
            $echo .= '<!--select start-->';

            $os = array();
            $os_id = array();

            /*
            $echo.='<select class="demo-6" name="posta_posta">';
            $echo.='<option selected value="0">Выберите счет</option>';*/
            for ($ss = 0; $ss < $num_results_score; $ss++) {
                $row_score = mysqli_fetch_assoc($result_score);

                echo'<a target="_blank" class="acc_1c" href="acc/'.$row_score["id"].'/"><span class="spans ggh-e name-blue-b"><span>Cчет №'.$row_score["number"].' ('.date_ex(0,$row_score["date"]).')</span></span></a>';


            }
        } else
        {
            echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Связанных счетов не найдено!</span></span></div>';
        }





    echo'</div>

</div>';



	  
echo'<div class="info-suit" style="background-color: transparent;
padding: 0px;">';

echo'<span class="h3-f" style="margin-bottom: 0px;">Материалы в накладной</span>';

	  //echo'</div>';
	  
	  
	 // echo'<div class="comme_invoice" style="margin-top:30px;">Материалы в накладной</div>';
		
	$ss=0;
$prime=0;



   foreach ($data as $key => $value)
    {

        echo'<div class="material-1c" id_key="'.$key.'">

        <div class="name_one">

        <span class="label-task-gg ">Наименование/Связь со складом 
</span>    
<span class="nm">'.$value["Номенклатура"].'</span>
<!--<div id_status="9" class="status_admin js-status-preorders s_pr_4 ">нет связи со складом</div>-->
<span data-tooltip="название товара на складе" class="stock_name_mat">'.$value["Номенклатура"].'</span>
            
        </div>

        <div class="name_two">
             <span class="label-task-gg ">ед. изм.
</span>  

            '.$value["ЕдиницаИзмерения"].'

        </div>
        <div class="name_free">
                  <span class="label-task-gg ">Количество
</span>    
'.$value["Количество"].'

            </div>
            
            <div class="name_four">
            <span class="label-task-gg ">Цена за единицу
</span><span class="price_supply_1c summa_ii">&nbsp;</span>'.$value["Цена"].' 
            </div>
                        <div class="name_five">
            <span class="label-task-gg ">Сумма
</span>   <span class="price_supply_1c summa_ii">&nbsp;</span>'.$value["Сумма"].' 
            </div>
            
             <div class="name_six">
             
             <div class="load-1c-i">Обработать</div>
             
            </div>
    </div>';

      //  echo($value["Номенклатура"].' '.$value["ЕдиницаИзмерения"].' '.$value["Количество"].' '.$value["Цена"].'<br>');



    }



	if((isset($_GET["prime"]))and(( isset($_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['prime']))]))and($_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['prime']))]!='')))
    {



        $D = explode('.', $_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['prime']))]);
        $D1=implode("\",\"", $D);

    $prime=1;
    $result_score_prime = mysql_time_query($link, 'select `id`,
  `alien`,
       1 as prime,
  0 as `id_acc`,
  0 as `id_doc_material_acc`,
  `id_stock`,
  0 as `count_units`,
  `price`,
  0 as `price_nds`,
  0 as`subtotal`,
  0 as`subtotal_defect`,
  0 as`count_defect`,
  0 as`defect`,
  0 as`defect_comment` from i_material where id in("'.$D1.'")');

    }

        $result_score = mysql_time_query($link, 'select DISTINCT a.*,0 as prime from z_invoice_material as a where a.id_invoice="' . htmlspecialchars(trim($_GET['id'])) . '" order by a.id');


      $num_results_score = $result_score->num_rows;
      $num_results_score_prime = $result_score_prime->num_rows;
	  if(($num_results_score==0)and($num_results_score_prime==0))
	  {
	       $display_vv='display:none;';
	  }
	

	echo'<div class="content_block block_primes1 block_invoice_2019 " style="margin-top:15px; '.$display_vv.'"><table cellspacing="0"  cellpadding="0" border="0" id="table_freez_0" class="smeta1"><thead>
				
				
				
				
			<tr class="title_smeta"><th class="t_2 no_padding_left_ jk4" rowspan="2">Материал</th>';
	
	  echo'<th class="t_4 jk44" colspan="3">Счет</th><th colspan="2" class="t_7 jk5">Накладная</th><th class="t_7 jk5 x130" rowspan="2" >всего (руб.)</th></tr>	
				
				
		   <tr class="title_smeta">';
	
	  echo'<th class="t_4 jk44">№ счета</th><th class="t_5">Дата</th><th class="t_6">Кол-во</th><th class="t_7 jk5 x170">Кол-во</th>';
echo'<th class="t_7 jk5 x170 cost-bottom-js-x"><div class="div-cost-global">
<i class="cost-js-no-nds">Цена без ндс</i>
<i class="cost-js-yes-nds">Цена с ндс</i>
<i class="cost-js-nono-nds">Цена</i>';


//как указана цена за товар в накладной с ндс или без
echo'<input type="hidden" '.$status_edit.' class="gloab  js-nds-cost-material" name="nds_material" value="'.$row_list["nds_material"].'">';

      $check='';
      $mild='mild_mild_nds';

      if($row_list["status"]!=1)
      {
          $mild='mild_mild1_nds';
      }

echo'<div class="mild-nds '.$check.'"><div class="'.$mild.'">
<i class="select-mild-nds"></i></div></div>';

echo'</div></th>';
/*
echo'<th class="t_7 jk5 x170 cosy_title"></th><th class="t_7 jk5 x170 active_n_ac">Цена с НДС ';
	if($row_list["status"]==1)		
    {
	echo'<div class="checkbox_cost_inv yes_nds"><i></i></div>';
    }
				
	echo'</th>';
	*/

echo'</tr></thead><tbody>';
						 echo'<tr class="loader_tr" style="height:20px;"><td colspan="7"></td></tr>';
	
	$nds_save=0;  //c ндс по умолчания


      //вдруг есть то что со себестоимости выбрали тогда выводим сначала их
      if($num_results_score_prime!=0)
      {

          $echo='';
          for ($ss=0; $ss<$num_results_score_prime; $ss++)
          {
              $row_score = mysqli_fetch_assoc($result_score_prime);


              //узнаем какой это материал
              $result_url=mysql_time_query($link,'select A.name,A.units from z_stock as A where A.id="'.htmlspecialchars(trim($row_score['id_stock'])).'"');
              $num_results_custom_url = $result_url->num_rows;
              if($num_results_custom_url!=0)
              {
                  $row_list1 = mysqli_fetch_assoc($result_url);
              }



              //узнаем что за счет если есть
              if(($row_score['id_acc']!='')and($row_score['id_acc']!=0))
              {
                  $result_url1=mysql_time_query($link,'select A.number,A.date,A.summa,A.id from z_acc as A where A.id="'.htmlspecialchars(trim($row_score['id_acc'])).'"');
                  $num_results_custom_url1 = $result_url1->num_rows;
                  if($num_results_custom_url1!=0)
                  {
                      $row_list2 = mysqli_fetch_assoc($result_url1);
                      $date_graf2  = explode("-",$row_list2["date"]);
                  }
              }
              //количество материала в этом счете
              $summ=0;
              $count_max='';
              $PROC='';
              $summ1='';
              $summ2='';
              if(($row_score['id_acc']!='')and($row_score['id_acc']!=0))
              {
                  if($row_list["status"]==1)
                  {
                      $count_max=0;
                      $result_url2=mysql_time_query($link,'select sum(A.count_material) as cc,sum(A.price_material) as cc1,count(A.price_material) as cc2  from z_doc_material_acc as A,z_doc_material as B where A.id_doc_material=B.id and B.id_stock="'.$row_score['id_stock'].'" and A.id_acc="'.htmlspecialchars(trim($row_score['id_acc'])).'"');

                      $num_results_custom_url2 = $result_url2->num_rows;
                      if($num_results_custom_url2!=0)
                      {
                          $row_list3 = mysqli_fetch_assoc($result_url2);
                          if($row_list3["cc"]!='')
                          {
                              $summ=round($row_list3["cc"],3);
                              $summ1=round($row_list3["cc"],3);
                          }
                          if(($row_list3["cc1"]!='')and($row_list3["cc"]!='')and($row_list3["cc"]!=0))
                          {
                              $summ2=round($row_list3["cc1"]/$row_list3["cc2"],3);
                          }


                      }



                      $result_proc=mysql_time_query($link,'select sum(a.count_units) as summ,sum(a.count_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.htmlspecialchars(trim($row_score['id_acc'])).'" and a.id_stock="'.$row_score['id_stock'].'"');

                      $num_results_proc = $result_proc->num_rows;
                      if($num_results_proc!=0)
                      {
                          $row_proc = mysqli_fetch_assoc($result_proc);

                          $result_proc1=mysql_time_query($link,'select sum(a.count_material) as ss from z_doc_material_acc as a,z_doc_material as b where a.id_doc_material=b.id and a.id_acc="'.htmlspecialchars(trim($row_score['id_acc'])).'" and b.id_stock="'.$row_score['id_stock'].'"');
                          $num_results_proc1 = $result_proc1->num_rows;

                          if($num_results_proc1!=0)
                          {
                              $row_proc1 = mysqli_fetch_assoc($result_proc1);
                          }

                          if($row_proc1["ss"]!=0)
                          {
                              $PROC=round($row_proc1["ss"]-($row_proc["summ"]-$row_proc["summ1"]),3);
                              $count_max=$PROC;
                          }

                      }

                  }
              }

              echo'<tr invoice_group="'.$row_score['id'].'" invoice_material="'.$row_score['id'].'" style="background-color:#f0f4f6;" class="jop" >';
              $dav1='';$dav2='';
              $check_dav='';
              $mild_dav='mild_mild_dav';
              if($row_score['alien'])
              {
                  $dav1='dava';
                  $dav2='<div class="chat_kk" data-tooltip="давальческий материал"></div>';
                  $check_dav='chechers';
              }
              $check='';
              if(ipost_x($_POST['invoice'][$ss]["mild"],$row_score['mild'],"0")==1)
              {
                  $check='chechers';
              }
              $mild='mild_mild';
              if($row_list["status"]!=1)
              {
                  $mild='mild_mild1';
                  $mild_dav='mild_mild1_dav';
              }

              echo'<td class="no_padding_left_ pre-wrap one_td"><div class="mild_dava_xx">
<div class="mild '.$check.'"><div class="'.$mild.'" data-tooltip="мягкая накладная">
<i class="select-mild"></i></div></div>';


              echo'<div class="mild_dav '.$check_dav.'"><div class="'.$mild_dav.'" data-tooltip="Давальческий материал">
<i class="select-mild_dav"></i></div></div>';


echo'<i class="name_invoice_dava '.$dav1.'">'.$row_list1["name"].'</i>'.$dav2.' <span class="invoice_units">('.$row_list1["units"].')</span>';

              if(($row_list["status"]==1)and(($role->permission('Накладные','A'))or($sign_admin==1)))
              {
                  if($prime==1) {
                      echo '<div style="margin-right:10px;" class="font-ranks del_invoice_material_prime" data-tooltip="Удалить материал" id_rel="' . $row_score['id'] . '"><span class="font-ranks-inner">x</span><div></div></div>';
                  } else
                  {
                      echo '<div style="margin-right:10px;" class="font-ranks del_invoice_material" data-tooltip="Удалить материал" id_rel="' . $row_score['id'] . '"><span class="font-ranks-inner">x</span><div></div></div>';
                  }
                  //иконка акта на отбраковку

                  if($prime!=1) {
                      echo '<div id_rel="' . $row_score['id'] . '" class="material_defect" data-tooltip="Добавить акт на отбраковку"><span>></span></div>';
                  }
              }


              echo'</div></td>';
              if(($row_score['id_acc']!='')and($row_score['id_acc']!=0))
              {
                  echo'<td class="pre-wrap center_text_td number_st_invoice"><a class="link-acc-2021" href="acc/'.$row_list2["id"].'/">'.$row_list2["number"].'</a></td><td class="pre-wrap center_text_td invoice_units">'.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</td><td class="pre-wrap center_text_td count_st_invoice">'.$summ.'</td>';
              } else
              {
                  echo'<td class="pre-wrap center_text_td"> -</td><td class="pre-wrap center_text_td">- </td><td class="pre-wrap center_text_td">- </td>';
              }


              echo'<td class="t_7 jk5">';


              echo'<div class="width-setter"><label>КОЛ-ВО ВСЕГО</label><input style="margin-top:0px;" name="invoice['.$ss.'][count]"  max="'.$count_max.'" id="count_invoice_'.$ss.'"  class="input_f_1 input_100 white_inp label_s count_in_  count_mask '.$class_c.' '.$status_class.' '.iclass_($row_score['id'].'_w_count',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" placeholder="'.$PROC.'" value="'.ipost_x($_POST['invoice'][$ss]["count"],$row_score['count_units'],"").'"></div>';


              echo'</td>';

              echo'<td class="t_7 jk5">';

              $price_x=$row_score['price'];

              if($row_list['nds_view']==0)
              {
                  //c ндс в счете
                                if($row_list['nds_material']==0)
              {
                  //цена указана с ндс за материал
                  $price_x=$row_score['price_nds'];
              } else
                                {
                                    //цена указана без ндс за материал

                                }

              }


              echo'<div class="width-setter"><label>ЦЕНА</label><input style="margin-top:0px;" name="invoice['.$ss.'][price]"  id="price_invoice_'.$ss.'" placeholder="" class="input_f_1 input_100 white_inp label_s price_in_  count_mask  '.iclass_($row_score['id'].'_w_price',$stack_error,"error_formi").'"   autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["price"],$price_x,"").'"></div>';

              echo'</td>';

/*
echo'<td class="t_7 jk5">';

              echo'<div class="width-setter"><label>БЕЗ НДС</label><input style="margin-top:0px;" name="invoice['.$ss.'][price]"  id="price_invoice_'.$ss.'" placeholder="" class="input_f_1 input_100 white_inp label_s price_in_  count_mask '.$class_c.' '.$status_class.'  '.iclass_($row_score['id'].'_w_price',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["price"],$row_score['price'],"").'"></div>';

              echo'</td><td class="t_7 jk5">';

              echo'<div class="width-setter"><label>С НДС</label><input style="margin-top:0px;" name="invoice['.$ss.'][price_nds]"  id="price_nds_invoice_'.$ss.'" placeholder="'.$summ2.'" class="input_f_1 input_100 white_inp label_s price_nds_in_  count_mask '.$class_c.' '.$status_class.'  '.iclass_($row_score['id'].'_w_price_nds',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["price_nds"],$row_score['price_nds'],"").'"></div>';




              if(ipost_x($_POST['invoice'][$ss]["price_nds"],$row_score['price_nds'],"0")!=0)
              {
                  $nds_save=1; //без ндс
              }

              echo'</td>';
  */

              echo'<td class="t_7 jk5" ><span  class="price_supply_ summa_ii"></span><input type=hidden value="'.$row_score['id'].'" name="invoice['.$ss.'][id]"><input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["defect"],$row_score['defect'],"0").'" class="defect_inp" name="invoice['.$ss.'][defect]">
			   <input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["stock"],$row_score['id_stock'],"0").'" class="stock_inp" name="invoice['.$ss.'][stock]">
			   
	<input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["mild"],$row_score['mild'],"0").'" class="mild_inp" name="invoice['.$ss.'][mild]">		   
	
	<input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["alien"],$row_score['alien'],"0").'" class="alien_inp" name="invoice['.$ss.'][alien]">	
	
		<input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["prime"],$row_score['prime'],"0").'" class="prime_inp" name="invoice['.$ss.'][prime]">
			   
			   </td></tr>';



              //акт на отбраковку
              if(ipost_x($_POST['invoice'][$ss]["defect"],$row_score['defect'],"0")==0)
              {
                  echo'<tr invoice_group="'.$row_score['id'].'" invoices_messa="'.$row_score['id'].'" class=" jop messa_invoice" style="display:none" >';
              } else
              {
                  echo'<tr invoice_group="'.$row_score['id'].'"  invoices_messa="'.$row_score['id'].'" class=" jop messa_invoice" >';
              }

              echo'<td>

	 <span class="hsi">Акт на отбраковку<div></div></span>';
              if(($row_list["status"]==1)and(($role->permission('Накладные','A'))or($sign_admin==1)))
              {
                  echo'<div class="del_invoice_akt" data-tooltip="Удалить акт" id_rel="'.$row_score['id'].'"><span class="font-ranks-inner">x</span><div></div></div>';

                  echo'<a class="print_invoice_akt" data-tooltip="Распечатать акт" href="invoices/print/'.$row_score['id'].'/"><span class="font-ranks-inner">*</span><div></div></a>';
              }


              echo'</td><td style="padding:0px;white-space: nowrap">';

              $query_string='';
              $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="7" and A.visible=1 and A.id_object="' . ht($row_score['id']) . '"');

              $num_results_uu = $result_6->num_rows;

              $class_aa = '';
              $style_aa = '';
              if ($num_results_uu != 0) {
                  $class_aa = 'eshe-load-file';
                  $style_aa = 'style="display: block;"';
              }


              $query_string .= '<div style="display: inline-block" class="photo-akt-invoice"><div class="img_invoice_div1 js-image-gl"><div style="display: inline-block"><div class="list-image list-image-icons" ' . $style_aa . '>';

              if ($num_results_uu != 0) {
                  $i = 1;
                  while ($row_6 = mysqli_fetch_assoc($result_6)) {
                      $query_string .= '	<div number_li="' . $i . '" class="li-image yes-load"><span class="name-img"><a href="/upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '">' . $row_6["name_user"] . '</a></span>';

                      $query_string .= '<span class="type-img">'.$row_6["type"].'</span>';

                      $query_string .= '<span class="del-img js-dell-image" id="' . $row_6["name"] . '"></span>';


                      $query_string .= '<div class="progress-img"><div class="p-img" style="width: 0px; display: none;"></div></div></div>';
                      $i++;
                  }
              }


              $query_string .= '</div></div>';



              $query_string .= '<input type="hidden" class="js-files-acc-new" name="files_9" value=""><div type_load="7" id_object="' . ht($row_score['id']) . '" data-tooltip="загрузить акт на отбраковку" class="invoice_upload js-upload-file js-helps ' . $class_aa . ' upload-but-2022" style="background-color: #fff !important;" ></div>';







              $query_string .= '</div></div>';


              echo $query_string;





              echo'</td><td colspan="2" style="padding:0px;white-space: nowrap">';




//фото браков


              $query_string='';
              $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="6" and A.visible=1 and A.id_object="' . ht($row_score['id']) . '"');

              $num_results_uu = $result_6->num_rows;

              $class_aa = '';
              $style_aa = '';
              if ($num_results_uu != 0) {
                  $class_aa = 'eshe-load-file';
                  $style_aa = 'style="display: block;"';
              }


              $query_string .= '<div style="display: inline-block" class=""><div class="img_invoice_div1 js-image-gl"><div style="display: inline-block"><div class="list-image list-image-icons" ' . $style_aa . '>';

              if ($num_results_uu != 0) {
                  $i = 1;
                  while ($row_6 = mysqli_fetch_assoc($result_6)) {
                      $query_string .= '	<div number_li="' . $i . '" class="li-image yes-load"><span class="name-img"><a href="/upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '">' . $row_6["name_user"] . '</a></span>';

                      $query_string .= '<span class="type-img">'.$row_6["type"].'</span>';

                      $query_string .= '<span class="del-img js-dell-image" id="' . $row_6["name"] . '"></span>';


                      $query_string .= '<div class="progress-img"><div class="p-img" style="width: 0px; display: none;"></div></div></div>';
                      $i++;
                  }
              }


              $query_string .= '</div></div>';



              $query_string .= '<input type="hidden" class="js-files-acc-new" name="files_9" value=""><div type_load="6" id_object="' . ht($row_score['id']) . '" data-tooltip="загрузить фото с браком" class="invoice_upload js-upload-file js-helps ' . $class_aa . ' upload-but-2021" style="background-color: #fff !important;" ></div>';







              $query_string .= '</div></div>';


              echo $query_string;


              echo'</td><td>';

              echo'<div class="width-setter"><label>КОЛ-ВО БРАКА</label><input style="margin-top:0px;" name="invoice['.$ss.'][count_defect]" id="count_invoice_defect_'.$ss.'"  class="input_f_1 akt_ss input_100 white_inp label_s count_defect_in_  count_mask '.$class_c.' '.$status_class.' '.iclass_($row_score['id'].'_w_count_defect',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["count_defect"],$row_score['count_defect'],"0").'"></div>';

              echo'</td><td colspan="2">';

              echo'<div class="width-setter"><input style="margin-top:0px;" name="invoice['.$ss.'][text]"  placeholder="Комментарий по браку" class="akt_ss input_f_1 input_100  '.$status_class.' white_inp label_s text_zayva_message_ '.iclass_($row_score['id'].'_w_text',$stack_error,"error_formi").'" '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["text"],$row_score['defect_comment'],"").'"></div>';


              echo'
	 </td></tr>';
              echo'<tr class="loader_tr" style="height:2px;"><td colspan="7"></td></tr>';


          }


      }




      //выводим те которые добавлены уже в накладную
	    if($num_results_score!=0)
	    {
				
	$echo='';
		   for ($ss=0; $ss<$num_results_score; $ss++)
		   {			   			  			   
			   $row_score = mysqli_fetch_assoc($result_score);
	
	
	//узнаем какой это материал
			  $result_url=mysql_time_query($link,'select A.name,A.units from z_stock as A where A.id="'.htmlspecialchars(trim($row_score['id_stock'])).'"');
                  $num_results_custom_url = $result_url->num_rows;
                  if($num_results_custom_url!=0)
                  {
			         $row_list1 = mysqli_fetch_assoc($result_url);
		          }
			   
			   
			   
	//узнаем что за счет если есть
			    if(($row_score['id_acc']!='')and($row_score['id_acc']!=0))
				{
				  $result_url1=mysql_time_query($link,'select A.number,A.date,A.summa,A.id from z_acc as A where A.id="'.htmlspecialchars(trim($row_score['id_acc'])).'"');
                  $num_results_custom_url1 = $result_url1->num_rows;
                  if($num_results_custom_url1!=0)
                  {
			         $row_list2 = mysqli_fetch_assoc($result_url1);
					  $date_graf2  = explode("-",$row_list2["date"]);
		          }
				}
	//количество материала в этом счете		 
			   $summ=0;
			   $count_max='';
			   $PROC='';
			   $summ1='';
			   $summ2='';
				if(($row_score['id_acc']!='')and($row_score['id_acc']!=0))
				{
					if($row_list["status"]==1)		
    {
		 $count_max=0;
				  $result_url2=mysql_time_query($link,'select sum(A.count_material) as cc,sum(A.price_material) as cc1,count(A.price_material) as cc2  from z_doc_material_acc as A,z_doc_material as B where A.id_doc_material=B.id and B.id_stock="'.$row_score['id_stock'].'" and A.id_acc="'.htmlspecialchars(trim($row_score['id_acc'])).'"');

                  $num_results_custom_url2 = $result_url2->num_rows;
                  if($num_results_custom_url2!=0)
                  {
			         $row_list3 = mysqli_fetch_assoc($result_url2);
					  if($row_list3["cc"]!='')
					  {
						  $summ=round($row_list3["cc"],3);
						  $summ1=round($row_list3["cc"],3);
					  }
					  if(($row_list3["cc1"]!='')and($row_list3["cc"]!='')and($row_list3["cc"]!=0))
					  {
						  $summ2=round($row_list3["cc1"]/$row_list3["cc2"],3);
					  }
					  
					  
		          }		
		
		
			
			   $result_proc=mysql_time_query($link,'select sum(a.count_units) as summ,sum(a.count_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.htmlspecialchars(trim($row_score['id_acc'])).'" and a.id_stock="'.$row_score['id_stock'].'"');
                
	           $num_results_proc = $result_proc->num_rows;
               if($num_results_proc!=0)
               {
		          $row_proc = mysqli_fetch_assoc($result_proc);
				   				   
				  $result_proc1=mysql_time_query($link,'select sum(a.count_material) as ss from z_doc_material_acc as a,z_doc_material as b where a.id_doc_material=b.id and a.id_acc="'.htmlspecialchars(trim($row_score['id_acc'])).'" and b.id_stock="'.$row_score['id_stock'].'"');	
				  $num_results_proc1 = $result_proc1->num_rows;
				   
				  if($num_results_proc1!=0)
                  { 				   
				    $row_proc1 = mysqli_fetch_assoc($result_proc1); 
				  }
				   
				  if($row_proc1["ss"]!=0)
				  {
		            $PROC=round($row_proc1["ss"]-($row_proc["summ"]-$row_proc["summ1"]),3); 
					$count_max=$PROC;
				  }
				   
	           } 
		
				}
			}
			   
	echo'<tr invoice_group="'.$row_score['id'].'" invoice_material="'.$row_score['id'].'" style="background-color:#f0f4f6;" class="jop" >';
               $dav1='';$dav2='';
               $check_dav='';
				if($row_score['alien'])
                {
                    $dav1='dava';
                    $dav2='<div class="chat_kk" data-tooltip="давальческий материал"></div>';
                    $check_dav='chechers';
                }
$check='';
				if(ipost_x($_POST['invoice'][$ss]["mild"],$row_score['mild'],"0")==1)
                {
                    $check='chechers';
                }
               $mild='mild_mild';
               $mild_dav='mild_mild_dav';
               if($row_list["status"]!=1)
               {
                   $mild='mild_mild1';
                   $mild_dav='mild_mild1_dav';
               }
			   echo'<td class="no_padding_left_ pre-wrap one_td"><div class="mild_dava_xx">
<div class="mild '.$check.'"><div class="'.$mild.'" data-tooltip="мягкая накладная">
<i class="select-mild"></i></div></div>';

              echo'<div class="mild_dav '.$check_dav.'"><div class="'.$mild_dav.'" data-tooltip="Давальческий материал">
<i class="select-mild_dav"></i></div></div>';

echo'<i class="name_invoice_dava '.$dav1.'">'.$row_list1["name"].'</i>'.$dav2.' <span class="invoice_units">('.$row_list1["units"].')</span>';

		if(($row_list["status"]==1)and(($role->permission('Накладные','A'))or($sign_admin==1)))
		{

                echo '<div style="margin-right:10px;" class="font-ranks del_invoice_material" data-tooltip="Удалить материал" id_rel="' . $row_score['id'] . '"><span class="font-ranks-inner">x</span><div></div></div>';

		//иконка акта на отбраковку


            echo '<div id_rel="' . $row_score['id'] . '" class="material_defect" data-tooltip="Добавить акт на отбраковку"><span>></span></div>';

		}
			  
			   
			   echo'</div></td>';
			   				if(($row_score['id_acc']!='')and($row_score['id_acc']!=0))
				{
			   echo'<td class="pre-wrap center_text_td number_st_invoice"><a class="link-acc-2021" href="acc/'.$row_list2["id"].'/">'.$row_list2["number"].'</a></td><td class="pre-wrap center_text_td invoice_units">'.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</td><td class="pre-wrap center_text_td count_st_invoice">'.$summ.'</td>';
				} else
				{
			   echo'<td class="pre-wrap center_text_td"> -</td><td class="pre-wrap center_text_td">- </td><td class="pre-wrap center_text_td">- </td>';					
				}
			   
			   
			   echo'<td class="t_7 jk5">';
			   
			   
			   echo'<div class="width-setter"><label>КОЛ-ВО ВСЕГО</label><input style="margin-top:0px;" name="invoice['.$ss.'][count]"  max="'.$count_max.'" id="count_invoice_'.$ss.'"  class="input_f_1 input_100 white_inp label_s count_in_  count_mask '.$class_c.' '.$status_class.' '.iclass_($row_score['id'].'_w_count',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" placeholder="'.$PROC.'" value="'.ipost_x($_POST['invoice'][$ss]["count"],$row_score['count_units'],"").'"></div>';
			   
			   
			   echo'</td>';

              echo'<td class="t_7 jk5">';


               $price_x=$row_score['price'];

               if($row_list['nds_view']==0)
               {
                   //c ндс в счете
                   if($row_list['nds_material']==0)
                   {
                       //цена указана с ндс за материал
                       $price_x=$row_score['price_nds'];
                   } else
                   {
                       //цена указана без ндс за материал

                   }

               }

              echo'<div class="width-setter"><label>ЦЕНА</label><input style="margin-top:0px;" name="invoice['.$ss.'][price]"  id="price_invoice_'.$ss.'" placeholder="" class="input_f_1 input_100 white_inp label_s price_in_  count_mask  '.iclass_($row_score['id'].'_w_price',$stack_error,"error_formi").'"   autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["price"],$price_x,"").'"></div>';

              echo'</td>';



/*
<td class="t_7 jk5">';



			   echo'<div class="width-setter"><label>БЕЗ НДС</label><input style="margin-top:0px;" name="invoice['.$ss.'][price]"  id="price_invoice_'.$ss.'" placeholder="" class="input_f_1 input_100 white_inp label_s price_in_  count_mask '.$class_c.' '.$status_class.'  '.iclass_($row_score['id'].'_w_price',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["price"],$row_score['price'],"").'"></div>';	
			   
			   echo'</td><td class="t_7 jk5">';
			   
			   echo'<div class="width-setter"><label>С НДС</label><input style="margin-top:0px;" name="invoice['.$ss.'][price_nds]"  id="price_nds_invoice_'.$ss.'" placeholder="'.$summ2.'" class="input_f_1 input_100 white_inp label_s price_nds_in_  count_mask '.$class_c.' '.$status_class.'  '.iclass_($row_score['id'].'_w_price_nds',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["price_nds"],$row_score['price_nds'],"").'"></div>';	
			   
			   
			   if(ipost_x($_POST['invoice'][$ss]["price_nds"],$row_score['price_nds'],"0")!=0)
			   {
				   $nds_save=1; //без ндс
			   }
			   
			   echo'</td>
*/
echo'<td class="t_7 jk5" ><span  class="price_supply_ summa_ii"></span><input type=hidden value="'.$row_score['id'].'" name="invoice['.$ss.'][id]"><input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["defect"],$row_score['defect'],"0").'" class="defect_inp" name="invoice['.$ss.'][defect]">
			   <input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["stock"],$row_score['id_stock'],"0").'" class="stock_inp" name="invoice['.$ss.'][stock]">
			   
	<input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["mild"],$row_score['mild'],"0").'" class="mild_inp" name="invoice['.$ss.'][mild]">		   
	
	<input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["alien"],$row_score['alien'],"0").'" class="alien_inp" name="invoice['.$ss.'][alien]">	
	
		<input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["prime"],$row_score['prime'],"0").'" class="prime_inp" name="invoice['.$ss.'][prime]">
			   
			   </td></tr>';
						
	

			 //акт на отбраковку	
			   if(ipost_x($_POST['invoice'][$ss]["defect"],$row_score['defect'],"0")==0)
			   {
	 echo'<tr invoice_group="'.$row_score['id'].'" invoices_messa="'.$row_score['id'].'" class=" jop messa_invoice" style="display:none" >';
			   } else
			   {
		 echo'<tr invoice_group="'.$row_score['id'].'"  invoices_messa="'.$row_score['id'].'" class=" jop messa_invoice" >';			   
			   }
				   
				   echo'<td>

	 <span class="hsi">Акт на отбраковку<div></div></span>';
		if(($row_list["status"]==1)and(($role->permission('Накладные','A'))or($sign_admin==1)))
		{  
			   echo'<div class="del_invoice_akt" data-tooltip="Удалить акт" id_rel="'.$row_score['id'].'"><span class="font-ranks-inner">x</span><div></div></div>';
			
			 echo'<a class="print_invoice_akt" data-tooltip="Распечатать акт" href="invoices/print/'.$row_score['id'].'/"><span class="font-ranks-inner">*</span><div></div></a>';
		}
/*
echo'<div class="div_textarea_otziv div_text_glo '.iclass_($row_mat["id"].'_m_text',$stack_error,"error_formi").'" style="margin-top:15px;">
			<div class="otziv_add">
          <textarea placeholder="Напиши руководству причину привышения параметров по этой работе относительно запланированной себестоимости" cols="40" rows="1" id="otziv_area_'.$i.'" name="works['.$i.'][mat]['.$mat.'][text]" class="di text_area_otziv">'.ipost_($_POST['works'][$i]["mat"][$mat]["text"],"").'</textarea>		  
        </div></div>';
*/
			   
			   echo'</td><td style="padding:0px;white-space: nowrap">';

               $query_string='';
               $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="7" and A.visible=1 and A.id_object="' . ht($row_score['id']) . '"');

               $num_results_uu = $result_6->num_rows;

               $class_aa = '';
               $style_aa = '';
               if ($num_results_uu != 0) {
                   $class_aa = 'eshe-load-file';
                   $style_aa = 'style="display: block;"';
               }


               $query_string .= '<div style="display: inline-block" class="photo-akt-invoice"><div class="img_invoice_div1 js-image-gl"><div style="display: inline-block"><div class="list-image list-image-icons" ' . $style_aa . '>';

               if ($num_results_uu != 0) {
                   $i = 1;
                   while ($row_6 = mysqli_fetch_assoc($result_6)) {
                       $query_string .= '	<div number_li="' . $i . '" class="li-image yes-load"><span class="name-img"><a href="/upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '">' . $row_6["name_user"] . '</a></span>';

                       $query_string .= '<span class="type-img">'.$row_6["type"].'</span>';

                       $query_string .= '<span class="del-img js-dell-image" id="' . $row_6["name"] . '"></span>';


                       $query_string .= '<div class="progress-img"><div class="p-img" style="width: 0px; display: none;"></div></div></div>';
                       $i++;
                   }
               }


               $query_string .= '</div></div>';



                   $query_string .= '<input type="hidden" class="js-files-acc-new" name="files_9" value=""><div type_load="7" id_object="' . ht($row_score['id']) . '" data-tooltip="загрузить акт на отбраковку" class="invoice_upload js-upload-file js-helps ' . $class_aa . ' upload-but-2022" style="background-color: #fff !important;" ></div>';







               $query_string .= '</div></div>';


               echo $query_string;




			   
			   
			   echo'</td><td colspan="2" style="padding:0px;white-space: nowrap">';
			   

//фото браков


               $query_string='';
               $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="6" and A.visible=1 and A.id_object="' . ht($row_score['id']) . '"');

               $num_results_uu = $result_6->num_rows;

               $class_aa = '';
               $style_aa = '';
               if ($num_results_uu != 0) {
                   $class_aa = 'eshe-load-file';
                   $style_aa = 'style="display: block;"';
               }


               $query_string .= '<div style="display: inline-block" class=""><div class="img_invoice_div1 js-image-gl"><div style="display: inline-block"><div class="list-image list-image-icons" ' . $style_aa . '>';

               if ($num_results_uu != 0) {
                   $i = 1;
                   while ($row_6 = mysqli_fetch_assoc($result_6)) {
                       $query_string .= '	<div number_li="' . $i . '" class="li-image yes-load"><span class="name-img"><a href="/upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '">' . $row_6["name_user"] . '</a></span>';

                       $query_string .= '<span class="type-img">'.$row_6["type"].'</span>';

                       $query_string .= '<span class="del-img js-dell-image" id="' . $row_6["name"] . '"></span>';


                       $query_string .= '<div class="progress-img"><div class="p-img" style="width: 0px; display: none;"></div></div></div>';
                       $i++;
                   }
               }


               $query_string .= '</div></div>';



               $query_string .= '<input type="hidden" class="js-files-acc-new" name="files_9" value=""><div type_load="6" id_object="' . ht($row_score['id']) . '" data-tooltip="загрузить фото с браком" class="invoice_upload js-upload-file js-helps ' . $class_aa . ' upload-but-2021" style="background-color: #fff !important;" ></div>';







               $query_string .= '</div></div>';


               echo $query_string;

			   
				echo'</td><td>';  
			
			    echo'<div class="width-setter"><label>КОЛ-ВО БРАКА</label><input style="margin-top:0px;" name="invoice['.$ss.'][count_defect]" id="count_invoice_defect_'.$ss.'"  class="input_f_1 akt_ss input_100 white_inp label_s count_defect_in_  count_mask '.$class_c.' '.$status_class.' '.iclass_($row_score['id'].'_w_count_defect',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["count_defect"],$row_score['count_defect'],"0").'"></div>';	
				   
				   echo'</td><td colspan="2">';
			   
echo'<div class="width-setter"><input style="margin-top:0px;" name="invoice['.$ss.'][text]"  placeholder="Комментарий по браку" class="akt_ss input_f_1 input_100  '.$status_class.' white_inp label_s text_zayva_message_ '.iclass_($row_score['id'].'_w_text',$stack_error,"error_formi").'" '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["text"],$row_score['defect_comment'],"").'"></div>';								
							
							
	 echo'
	 </td></tr>';  
		 echo'<tr class="loader_tr" style="height:2px;"><td colspan="7"></td></tr>';
			   
			   
		   }
	
	
		}
	
	echo'<tr style="" class="jop1 mat itogss js-itog-all"><td class="no_padding_left_ pre-wrap one_td title_itog_invoice" colspan="6" style="text-align:right">Итого</td><td style="padding-left:10px;"><span  class="price_supply_ itog_invoice js-itog-all-text"></span></td></tr>';

	echo'<tr style="" class="jop1 mat itogss_defect"><td class="no_padding_left_ pre-wrap one_td title_itog_nds_invoice" colspan="6" style="text-align:right">В том числе отбраковка на сумму</td><td style="padding-left:10px;"><span  class="price_supply_ itog_invoice_defect">0</span></td></tr>';

      echo'<tr style="" class="jop1 mat itogss_nds js-itog-nds-all"><td class="no_padding_left_ pre-wrap one_td title_itog_nds_invoice" colspan="6" style="text-align:right">НДС</td><td style="padding-left:10px;"><span  class="price_supply_ itog_invoice_nds js-itog-nds-text"></span></td></tr>';

      echo'<tr style="" class="jop1 mat itogss_nds js-itog-snds-all"><td class="no_padding_left_ pre-wrap one_td title_itog_nds_invoice" colspan="6" style="text-align:right">ИТОГО С НДС</td><td style="padding-left:10px;"><span  class="price_supply_ itog_invoice_nds js-itog-snds-text"></span></td></tr>';

      echo'<tr style="" class="jop1 mat itogss_nds js-itog-vnds-all"><td class="no_padding_left_ pre-wrap one_td title_itog_nds_invoice" colspan="6" style="text-align:right">В том числе НДС</td><td style="padding-left:10px;"><span  class="price_supply_ itog_invoice_nds js-itog-vnds-text"></span></td></tr>';
		  
		   echo'</tbody></table></div>'; echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_0").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';

		

	?>
	
	<script type="text/javascript"> 
	  $(function (){ 
itog_invoice();
		  nds_invoice();
		  countErrorMax();
          NumberBlockFile();
          cost_mild();
});

	</script>
	<?


	
	
		if(($row_list["status"]==1)and(($role->permission('Накладные','A'))or($sign_admin==1)))
		{ 	
	echo'<div style="margin-top: 30px;" class="invoices_mess add_material_invoice" for="'.$row_list["id"].'" col="'.ipost_x($_POST['ispol_work'],$row_list["id_contractor"],"0").'">Добавить материал в накладную</div>';


/*
            echo'<div class="buy_turs">
<div class="choice-head-buy js-buy-turs-client">Выберите покупателя тура</div>
		</div>';
*/

		}
		
					
			$token=token_access_compile($_GET['id'],'view_invoicess_x',$secret);				
						
						echo'<input type="hidden" value="'.$token.'" name="tk">';   
					 echo'<input type="hidden" value="'.$ss.'" name="ss">'; 
echo'<input type="hidden" class="popa_nds" value="'.ipost_($_POST['nds_ff'],$row_list["nds_view"]).'" name="nds_ff">'; 

	  

	  
		   
	//echo'<div class="content_block1">';	
/*
<div class="close_all_r">закрыть все</div>
<div data-tooltip="Удалить всю себестоимость" class="del_seb"></div>
<div data-tooltip="Добавить раздел" class="add_seb"></div>
';
*/
  
	  
	  	//echo'</div>';  
	

	
 
   
	  

	
    ?>
    



                  </div></div></div></div></div></div>
      </form>
<?
echo'<div class="messa_form_a">'.$echo.'</div>';
include_once $url_system.'template/left.php';
?>

</div>
</div><script src="Js/rem.js" type="text/javascript"></script>
<?
echo'<script type="text/javascript">var b_co=\''.$b_co.'\'</script>';
?>
<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
	
</div>

</body></html>
<?php
$echo_help=0;
if (( isset($_GET["a"]))or((isset($_POST["save_invoice_two_step"]))))
{

    $echo_help++;
}



            if ($prime == 1) {
                echo'<script type="text/javascript">var b_cm=\''.$b_cm.'\'</script>';
            }


if($echo_help!=0)
{
    ?>
    <script type="text/javascript">

        <?
        echo'var text_xx=\''.$end_step_task.'\';';




        ?>
        $(function (){
            setTimeout ( function () {

                $('.js-hide-help').slideUp("slow");
                <?
                if (( isset($_GET["a"]))and($_GET["a"]=='yes')) {
                    echo "alert_message('ok', 'Материалы приняты по накладной');";
                } else
                {
                    if(( isset($_GET["a"]))and($_GET["a"]=='dell'))
                    {
                        echo "alert_message('ok', 'позиция удалена из счета');";
                    } else {

                        if(( isset($_GET["a"]))and($_GET["a"]=='save'))
                        {
                            echo "alert_message('ok', 'данные сохранены');";
                        } else {
                            if(isset($_POST["save_invoice_two_step"]))
                            {

                                echo " alert_message('error', 'Ошибка - попробуйте еще раз');";

                            } else {
                                echo "alert_message('ok', text_xx);";
                            }
                        }
                    }
                }
                ?>
                var title_url=$(document).attr('title'); var url=window.location.href;
                url=url.replace('add/', '');
                url=url.replace('order/', '');
                url=url.replace('yes/', '');
                url=url.replace('dell/', '');
                url=url.replace('save/', '');
                var url1 = removeParam("a", url);
                History.pushState('', title_url, url1);

            }, 500 );




        });
    </script>
    <?




}

