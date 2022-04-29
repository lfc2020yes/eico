<?
//согласовать без замечаний

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

$echo_r=1; //выводить или нет ошибку 0 -нет
//**************************************************
if ( count($_GET) != 1 )
{
    header404(1,$echo_r);
}
//**************************************************
if($D_404[4]!='')
{
    header404(2,$echo_r);
}
//**************************************************
if(!isset($_GET["id"]))
{
    header404(3,$echo_r);
}
if((!isset($_SESSION["user_id"]))or(!is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
{
    header404(31,$echo_r);
}


if((!$role->permission('Наряды','R'))and($sign_admin!=1)) {

    header404(4,$echo_r);

}

/*
if((!isset($_POST["tk1"]))or($_POST["tk1"]!='wEVR678vmrIrt'))
{
    header404(99,$echo_r);
}
*/
//header404(94,$echo_r);
//**************************************************
$result_url=mysql_time_query($link,'select A.* from n_nariad as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_custom_url = $result_url->num_rows;
if($num_results_custom_url==0)
{
    header404(6,$echo_r);
} else
{
    $row_list = mysqli_fetch_assoc($result_url);
}

if($row_list["status"]!=9)
{
    header404(604,$echo_r);
}


$token=htmlspecialchars($_POST['tk_sign']);
$id=htmlspecialchars($_GET['id']);

//echo($token);
if(!token_access_new($token,'seal_naryd_plus_2021',$id,"rema",120)) {
    header404(47, $echo_r);
}


include_once $url_system.'/ilib/lib_interstroi.php';
include_once $url_system.'/ilib/lib_edo.php';

$edo = new EDO($link, $id_user, false);
$arr_document = $edo->my_documents(2, ht($_GET["id"]), '=0', true);
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
                header404(5, $echo_r);
            }

            $but_mass = $edo->get_action($val["id_run_item"]);
        }} else
    {
        header404(6, $echo_r);
    }


}

if(($but_mass["id_action"]!=9)) {
    header404(156, $echo_r);
}

//изменяем статус по



/*
if((memo_count_nariad($link,$_GET["id"])!=0)and($sign_admin!=1))
{
    header404(7854, $echo_r);
}
*/
$flag_podpis=0;
$result_pro=mysql_time_query($link,'Select b.*,c.id_stock from n_work as a,n_material as b,i_material as c where b.id_material=c.id and a.id_nariad="'.htmlspecialchars(trim($_GET['id'])).'" and a.id=b.id_nwork');
$num_results_pro = $result_pro->num_rows;
if($num_results_pro!=0)
{
    for ($ip=0; $ip<$num_results_pro; $ip++)
    {
        $row_pro = mysqli_fetch_assoc($result_pro);


        $result_tx=mysql_time_query($link,'Select sum(a.count_units) as dd from n_material as a,i_material as b,n_work as c where a.id_material=b.id and c.id_nariad="'.htmlspecialchars(trim($_GET['id'])).'" and c.id=a.id_nwork and b.id_stock="'.$row_pro["id_stock"].'"');

        $num_results_tx = $result_tx->num_rows;
        if($num_results_tx!=0)
        {
            $row_tx = mysqli_fetch_assoc($result_tx);
        }


        $my_material=0;	//свой
        $my_material1=0;	//давальческий
        //Определяем сколько материала на пользователе который оформляет наряд
        if($row_pro["id_stock"]!='')
        {
            if($row_list["id_user"]==$id_user)
            {
                $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.alien=0 and a.id_user="'.$id_user.'" and a.id_stock="'.htmlspecialchars(trim($row_pro["id_stock"])).'"');
            } else
            {
                $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.alien=0 and a.id_user="'.$row_list["id_user"].'" and a.id_stock="'.htmlspecialchars(trim($row_pro["id_stock"])).'"');
            }
            $num_results_t1_ = $result_t1_->num_rows;
            if($num_results_t1_!=0)
            {

                $row1ss_ = mysqli_fetch_assoc($result_t1_);
                if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
                {
                    $my_material=$row1ss_["summ"];
                }
            }


            if($row_list["id_user"]==$id_user)
            {
                $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.alien=1 and a.id_user="'.$id_user.'" and a.id_stock="'.htmlspecialchars(trim($row_pro["id_stock"])).'"');
            } else
            {
                $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.alien=1 and a.id_user="'.$row_list["id_user"].'" and a.id_stock="'.htmlspecialchars(trim($row_pro["id_stock"])).'"');
            }
            $num_results_t1_ = $result_t1_->num_rows;
            if($num_results_t1_!=0)
            {

                $row1ss_ = mysqli_fetch_assoc($result_t1_);
                if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
                {
                    $my_material1=$row1ss_["summ"];
                }
            }

        }

        $my_material_prior=$my_material;  // по какому количеству материалу будет проверяться хватает ли материала у этого пользователя для оформления наряда
        if($row_pro["alien"]==1)
        {
            $my_material_prior=$my_material1;
        }

        if($my_material_prior<$row_tx["dd"]) {  $flag_podpis++; }



    }
}

if($flag_podpis!=0)
{
    //echo("!");
    //mysql_time_query($link,'update n_nariad set ready="0" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
    header("Location:".$base_usr."/worder/".htmlspecialchars(trim($_GET['id'])).'/no/25/');
    die();
} else {


    $result_work=mysql_time_query($link,'Select a.* from n_work as a where a.id_nariad="'.htmlspecialchars(trim($_GET['id'])).'" order by a.id');
    $num_results_work = $result_work->num_rows;
    if($num_results_work!=0)
    {


        for ($i=0; $i<$num_results_work; $i++)
        {
            $row_work = mysqli_fetch_assoc($result_work);



            $result_t1_=mysql_time_query($link,'Select c.count_r2_realiz,c.count_r2_replace,c.count_units as count_all,a.count_units,c.price  from n_work as a, i_razdel2 as c where c.id=a.id_razdeel2 and a.id_razdeel2="'.$row_work["id_razdeel2"].'"');
            $num_results_t1_ = $result_t1_->num_rows;
            if($num_results_t1_!=0)
            {
                $row1ss_ = mysqli_fetch_assoc($result_t1_);

                //сохраняем последние данные по работе
                mysql_time_query($link,'update n_work set 				 
					 count_units_razdel2="'.$row1ss_["count_all"].'",					 
					 count_units_razdel2_realiz="'.$row1ss_["count_r2_realiz"].'",
					 count_units_razdel2_replace="'.$row1ss_["count_r2_replace"].'",
					 price_razdel2="'.$row1ss_["price"].'"					 					 
					 where id = "'.$row_work["id"].'"');

                //такая работа есть
                $result_mat=mysql_time_query($link,'Select a.*,b.count_units as count_seb,b.price as price_seb,b.count_realiz from n_material as a,i_material as b where a.id_material=b.id and a.id_nwork="'.$row_work["id"].'" order by a.id');
                $num_results_mat = $result_mat->num_rows;
                if($num_results_mat!=0)
                {
                    for ($mat=0; $mat<$num_results_mat; $mat++)
                    {
                        $row_mat = mysqli_fetch_assoc($result_mat);
                        //сохраняем последние данные по материалу
                        mysql_time_query($link,'update n_material set 				 
					 count_units_material="'.$row_mat["count_seb"].'",					 
					 count_units_material_realiz="'.$row_mat["count_realiz"].'",
					 price_material="'.$row_mat["price_seb"].'"					 					 
					 where id = "'.$row_mat["id"].'"');
                    }
                }


            }
        }
    }

    $result=nariad_sign($link, $_GET["id"], 1,$sign_level, $id_user);
    //nariad_sign(&$mysqli,$id_narid, $sinedd,$sign_level, $id_user
    //echo($result);

    if($result!==true)
    {
        //echo("!");
        header("Location:".$base_usr."/worder/".htmlspecialchars(trim($_GET['id'])).'/no/30/');
        die();
    } else {


        $array_status=$edo->set_status($id_s, 2);
        if($array_status==false)
        {
            header("Location:".$base_usr."/worder/".htmlspecialchars(trim($_GET['id'])).'/no/32/');
            die();
        }

//отправляем следующим уведомления
        if (($edo->next($id, 2)) === false) {

            //id_executor
            //mysql_time_query($link,'update z_doc set status="9" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
//меняем статусы у материалов на заказано
            /*
            $result_tyd1=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'"');
            $num_results_tyd1 = $result_tyd1->num_rows;

            for ($ids=0; $ids<$num_results_tyd1; $ids++)
            {
                $row_tyd1 = mysqli_fetch_assoc($result_tyd1);
                mysql_time_query($link,'update z_doc_material set status="9" where id = "'.htmlspecialchars(trim($row_tyd1['id'])).'"');
            }
        */

            $result_url = mysql_time_query($link, 'select A.* from i_object as A where A.id="' . htmlspecialchars(trim($row_list['id_object'])) . '"');
            $num_results_custom_url = $result_url->num_rows;

            if ($num_results_custom_url != 0) {
                $row_list1 = mysqli_fetch_assoc($result_url);
            }

            $result_town = mysql_time_query($link, 'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="' . $row_list1["id_kvartal"] . '"');
            $num_results_custom_town = $result_town->num_rows;
            if ($num_results_custom_town != 0) {
                $row_town = mysqli_fetch_assoc($result_town);
            }

//echo(gettype($edo->arr_task));
            if (isset($edo->arr_task)) {

                $admin_note=0;
                $admin_users='';

                foreach ($edo->arr_task as $key => $value) {
                    //оправляем всем уведомления кому нужно рассмотреть этот документ далее


                    $user_send_new = array();
                    //уведомление
                    array_push($user_send_new, $value["id_executor"]);

                    //если это задача на подготовить счета
                    if ($value["id_action"] == 4) {

                        //    $text_not = 'Вам поступила задача <a class="link-history" href="app/' . $_GET['id'] . '/">' . $row_list['name'] . '</a> - ' . $row_list1["object_name"] . ' (' . $row_town["town"] . ', ' . $row_town["kvartal"] . ')' . $value["description"];
                        /*
                                        $text_not='Вам поступила задача по заявке <a class="link-history" href="app/' . $_GET['id'] . '/">' . $row_list['name'] . '</a> -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].').' . $value["description"].'Детали в разделе <a class="link-history" href="supply/">cнабжение</a>.';
                        */


                    } else {

                        $text_not = 'Вам поступила задача <a class="link-history" href="worder/' . $_GET['id'] . '/">Наряд №' . $row_list['numer_doc'] . '</a> - ' . $row_list1["object_name"] . ' (' . $row_town["town"] . ', ' . $row_town["kvartal"] . ')' . $value["description"];
                    }

                    //$text_not='Поступила <strong>новая заявка на материал №'.$row_list['number'].'</strong>, от '.$name_user.', по объекту -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].'). Детали в разделе <a href="supply/">cнабжение</a>.';
                    //отправка уведомления
                    $user_send_new = array_unique($user_send_new);
                    notification_send($text_not, $user_send_new, $id_user, $link);

                    //пишем уведомление админу что новая заявка создана и отправлена на согласование
                    //пишем уведомление админу что новая заявка создана и отправлена на согласование
                    $admin_note=1;
                    $kto1=name_sql_x($value["id_executor"]);
                    if($admin_users=='')
                    {
                        $admin_users=$kto1;
                    } else
                    {
                        $admin_users.=', '.$kto1;
                    }
                    //пишем уведомление админу что новая заявка создана и отправлена на согласование
                    //пишем уведомление админу что новая заявка создана и отправлена на согласование
                }
                if($admin_note!=0)
                {
                    $admin_note=1;
                    //пишем уведомление админу что новая заявка создана и отправлена на согласование
                    //пишем уведомление админу что новая заявка создана и отправлена на согласование
                    $user_admin= array();
                    array_push($user_admin, 11);

                    $kto=name_sql_x($id_user);
                    $title=$kto.' провел(а) наряд №'.$row_list['numer_doc'];


                    $message=$kto.' провел(а) <a class="link-history" href="worder/' . $_GET['id'] . '/">Наряд №' . $row_list['numer_doc'] . '</a> - ' . $row_list1["object_name"] . ' (' . $row_town["town"] . ', ' . $row_town["kvartal"] . '). Наряд поступил к - '.$admin_users;
                    notification_send_admin($title,$message,$user_admin,$id_user,$link);

                    //пишем уведомление админу что новая заявка создана и отправлена на согласование
                    //пишем уведомление админу что новая заявка создана и отправлена на согласование
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
    }
}

/*
mysql_time_query($link,'update z_doc set status="3" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
				//меняем статусы у материалов у которых нет решения по служебной записки или оно отрицательное
				$result_tyd1=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'" and ((not(a.memorandum="") and a.id_sign_mem=0)or(not(a.memorandum="") and not(a.id_sign_mem=0)and a.signedd_mem=0))');
                $num_results_tyd1 = $result_tyd1->num_rows;

				for ($ids=0; $ids<$num_results_tyd1; $ids++)
		        {
				   $row_tyd1 = mysqli_fetch_assoc($result_tyd1);
				   mysql_time_query($link,'update z_doc_material set status="3" where id = "'.htmlspecialchars(trim($row_tyd1['id'])).'"');
				}



				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  $user_send= array();
				  $user_send_new= array();

				  $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_list['id_object'])).'"');
                  $num_results_custom_url = $result_url->num_rows;
                  if($num_results_custom_url!=0)
                  {
			         $row_list1 = mysqli_fetch_assoc($result_url);
		          }

				  $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list1["id_kvartal"].'"');
                  $num_results_custom_town = $result_town->num_rows;
                  if($num_results_custom_town!=0)
                  {
			         $row_town = mysqli_fetch_assoc($result_town);
		          }

				  //echo($row_list['id_object']);
                $FUSER=new find_user($link,$row_list['id_object'],'S','Заявки','plan');

				$user_send_new=$FUSER->id_user;
				// print_r($user_send_new);
				$text_not='Поступила новая <a href="app/'.$row_list['id'].'/">служебная записка</a> по заявке на материал №'.$row_list['number'].', от <strong>'.$name_user.'</strong>, по объекту -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);
			    notification_send($text_not,$user_send_new,$id_user,$link);




				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде

					*/






//echo($error);
header("Location:".$base_usr."/worder/".$_GET['id'].'/yes/');
die();

//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
    include $url_system.'module/error404.php';
    die();
}

?>