<?
//заказать для прорабов которые заполнили всю заявки на материал без служебок
//заказать для инженеров ПТО которые приняли служебку и заказали

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
//**************************************************

$token=htmlspecialchars($_POST['tk_sign']);
$id=htmlspecialchars($_GET['id']);
	
//if(!token_access_yes($token,'sign_app_order',$id,120))
if(!token_access_new($token,'sign_naryd_plus',$id,"rema",120)) {
    header404(4, $echo_r);
}
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
//**************************************************

if(($row_list["status"]!=1)and($row_list["status"]!=8))
{	
	header404(7,$echo_r);
}
//**************************************************



$status_user_zay=array("0","0"); //по умолчанию это никто
if((($row_list["id_user"]==$id_user)and($role->permission('Наряды','A')))or($sign_admin==1))
{
    $status_user_zay[0]=1;
}

	
if((($role->permission('Наряды','S'))and(array_search($row_list["id_user"],$hie_user)!==false)and($row_list["id_user"]!=$id_user))or($sign_admin==1))
{
    $status_user_zay[1]=1;
}


//**************************************************	
if(($status_user_zay[0]==0)and($status_user_zay[1]==0))
{
	header404(8,$echo_r);
}


include_once '../ilib/lib_interstroi.php';
include_once '../ilib/lib_edo.php';


$edo = new EDO($link,$id_user,false);

$restart=false;
if(($row_list["id_edo_run"]!='')and($row_list["id_edo_run"]!=0))
{
    //значит ему возвращали уже и это просто пересоглашение
    $restart=true;
}
//echo($next_edo);


if(($row_list["ready"]==0))
{
    header404(207,$echo_r);
}

$flag_podpis=0;
$result_pro=mysql_time_query($link,'Select b.*,c.id_stock from n_work as a,n_material as b,i_material as c where b.id_material=c.id and a.id_nariad="'.htmlspecialchars(trim($_GET['id'])).'" and a.id=b.id_nwork');
$num_results_pro = $result_pro->num_rows;
if($num_results_pro!=0)
{
    for ($ip=0; $ip<$num_results_pro; $ip++)
    {
        $row_pro = mysqli_fetch_assoc($result_pro);


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

        if($my_material_prior<$row_pro["count_units"]) {  $flag_podpis++; }



    }
}

if($flag_podpis!=0)
{
    mysql_time_query($link,'update n_nariad set ready="0" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
    header("Location:".$base_usr."/worder/".htmlspecialchars(trim($_GET['id'])).'/no/');
    die();
} else {

    if ($edo->next($id, 2, 0, $restart) === false) {
//echo("!");
        //id_executor
        mysql_time_query($link, 'update n_nariad set status="9" where id = "' . htmlspecialchars(trim($_GET['id'])) . '"');
//меняем статусы у материалов на заказано

        mysql_time_query($link,'update n_nariad set id_signed'.($sign_level-1).'="'.$id_user.'" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');


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
        foreach ($edo->arr_task as $key => $value) {
            //оправляем всем уведомления кому нужно рассмотреть этот документ далее


            $user_send_new = array();
            //уведомление
            array_push($user_send_new, $value["id_executor"]);


            $text_not = 'Вам поступила задача <a class="link-history" href="worder/' . $row_list['id'] . '/"> Наряд №' . $row_list['numer_doc'] . '</a> - ' . $row_list1["object_name"] . ' (' . $row_town["town"] . ', ' . $row_town["kvartal"] . ')' . $value["description"];

            //$text_not='Поступила <strong>новая заявка на материал №'.$row_list['number'].'</strong>, от '.$name_user.', по объекту -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].'). Детали в разделе <a href="supply/">cнабжение</a>.';
            //отправка уведомления
            $user_send_new = array_unique($user_send_new);
            notification_send($text_not, $user_send_new, $id_user, $link);


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
header("Location:".$base_usr."/worder/".$_GET['id'].'/order_yes/');


	
?>