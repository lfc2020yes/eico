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




if((isset($_POST['load_invoice']))and($_POST['load_invoice']==1))
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
	 if (($role->permission('Накладные_1c','A'))or($sign_admin==1))
	 {

         echo "<pre> $_GET: " . print_r($_POST, true) . "</pre>";



         die();
		 
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
$arFiles = $csv->read_dir($mask,$mask_attach);
if(isset($_GET["id"])) {
    //iconv( 'windows-1251','UTF-8',$debug)\
    //echo(base64_decode($_GET['id']));
    echo(iconv( 'UTF-8','windows-1251',base64_decode($_GET['id'])));
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
echo'<input type="hidden" value="1" name="load_invoice">';
echo'<input class="id-file" type="hidden" value="'.$_GET['id'].'" name="id">';

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

echo'<input name="contr" type="hidden" class="ca-1c" value="'.$CA.'">';

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
<span class="nm">'.$value["Номенклатура"].'</span>';
        $stock = new STOCK($link, $id_user);
        $arFiles = $stock->find_byName($value["Номенклатура"],2);
      //  echo(count($arFiles));
      //  echo "<pre> $arFiles: " . print_r( $arFiles, true) . "</pre>";
        if((count($arFiles)==0)or($arFiles==false))
        {
            echo'<div id_status="'.$key.'" class="status_admin status-button-1c js-status-1c-mat s_pr_4 ">нет связи со складом</div>';
        } else {
            if (count($arFiles) > 0) {
                echo '<div id_status="' . $key . '" class="status_admin status-button-1c js-status-1c-mat s_pr_2 ">есть варианты соответсвия</div>';
            }
        }

/*
echo'<span data-tooltip="название товара на складе" class="stock_name_mat">'.$value["Номенклатура"].'</span>';
*/
echo'<input type="hidden" name="mat[key][]" value="'.$key.'">
<input type="hidden" name="mat[edit][]" value="0">
<input type="hidden" name="mat[new][]" value="">
<input type="hidden" name="mat[id_stock][]" value="">
<input type="hidden" name="mat[unit][]" value="">
<input type="hidden" name="mat[cor_unit][]" value="">
<input type="hidden" name="mat[acc][]" value="">';



echo'</div>

        <div class="name_two">
             <span class="label-task-gg ">ед. изм.
</span>  

            <span class="js-ed-1c">'.$value["ЕдиницаИзмерения"].'</span>

        </div>
        <div class="name_free">
                  <span class="label-task-gg ">Количество
</span>    
<span class="js-col-1c">'.$value["Количество"].'</span>

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
             
             <div class="load-1c-i js-load-click-1c"><span>Обработать</span><i>q</i></div>
             
            </div>
    </div>';

      //  echo($value["Номенклатура"].' '.$value["ЕдиницаИзмерения"].' '.$value["Количество"].' '.$value["Цена"].'<br>');



    }



		

	?>
	

	<?


	

					
			$token=token_access_compile($_GET['id'],'view_invoicess_x',$secret);				
						
						echo'<input type="hidden" value="'.$token.'" name="tk">';   


	  

	  
		   
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

