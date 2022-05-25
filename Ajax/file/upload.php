<?
set_time_limit(300); //файл должен загрузиться за 5 минут
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
//include_once $url_system.'module/ajax_access.php';
session_start();
//подключение к базе
include_once $url_system.'module/config.php';
//include_once $url_system.'module/rimg.php';

function reset_url($url) {
    $value = str_replace ( "http://", "", $url );
    $value = str_replace ( "https://", "", $value );
    $value = str_replace ( "www.", "", $value );
    $value = explode ( "/", $value );
    $value = reset ( $value );
    return $value;
}

$_SERVER['HTTP_REFERER'] = reset_url ( $_SERVER['HTTP_REFERER'] );
$_SERVER['HTTP_HOST'] = reset_url ( $_SERVER['HTTP_HOST'] );
 
if ($_SERVER['HTTP_HOST'] != $_SERVER['HTTP_REFERER']) {
  $v_error='HTTP_HOST!=HTTP_REFERER';
	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")'); 
	
    // @header ( 'Location: ' . $config['http_home_url'] );
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
    die ();
}
     
    // echo($_SERVER['HTTP_X_REQUESTED_WITH']);
 
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    /* значит ajax-запрос */
     
    /* обрабатываем */
     
} else {
	  $v_error='HTTP_X_REQUESTED_WITH';	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")'); 

	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
}




define( '_SECRETJ', 7 );

//Проверяем чтобы доступ напрямую был закрыт для этого файла
//Пишем в файле который присоединяем в ajax
//if (!defined('_SECRETJ')){  header("HTTP/1.1 404 Not Found"); header("Status: 404 Not Found"); die(); }
//Проверяем чтобы доступ напрямую был закрыт для этого файла


//header("Content-type: application/json");

//подключение написанных функций для сайта
include_once $url_system.'module/function.php';
//проверка авторизации
include_once $url_system.'module/function.php';
//проверка авторизации
include_once $url_system.'login/function_users.php';
initiate($link);

//Проверяем вдруг это взлом. смотрим есть ли такой тип, относятся ли эти условия поиска к этому типу, существует ли сортировка
//если есть n_st смотрим число ли это, append тоже проверяем

function img_name($log,$link)
{
   $result=mysql_time_query($link,'select id from image_attach where name="'.htmlspecialchars(trim($log)).'"');
   $num_results = $result->num_rows;
   if($num_results!=0)
   {         
     return true; //такой xah уже есть
   } else
   {
     return false; //такого xah еще нет
   }
}

if((isset($_SESSION["user_id"]))) {
    $id_user = id_key_crypt_encrypt(htmlspecialchars(trim($_SESSION['user_id'])));


    if ((isset($_POST["type"])) and ((is_numeric($_POST["type"])))) {

        //проверяем. Если это не аванс то может ли столько провести человек. возможно долг уже меньше
        //если аванс проводить в любом случае

        $today[0] = date("Y-m-d"); //присвоено 03.12.01
        $today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17

        $date_ = $today[0] . ' ' . $today[1];

        $id_object = 0;
        if (ht($_POST["object"]) != '') {
            $id_object = ht($_POST["object"]);
        }

        mysql_time_query($link, 'INSERT INTO image_attach (name,name_user,type,for_what,id_object,displayOrder,visible,datetimes) VALUES ("","","","' . ht($_POST["type"]) . '","' . $id_object . '","0","0","' . $date_ . '")');
        $ID_D = mysqli_insert_id($link);

        $uploaddir = $_SERVER["DOCUMENT_ROOT"] . '/upload/file/';


        do {
            $name_imgs = rand_string_string_image(20);
        } while (img_name($name_imgs, $link));


//application/vnd.ms-excel
        if ($_POST["type"])


            switch ($_POST["type"]) {
                case 1:
                case 2:
                    $allowedExts = array("pdf", "jpg", "jpeg", "png");
                    break;
                case 6:
                case 3:
                case 4:
                case 5:
                case 8:
                case 7:
                case 9:
                case 10:
                case 11:
                case 13:
                case 14:
                case 15:
                    $allowedExts = array("pdf", "jpg", "jpeg", "png", "doc", "docx", "zip", "xls", "xlsx");
                    break;
                default:
                    $allowedExts = array("pdf", "jpg", "jpeg", "png");
            }


        $error_im == 1;
        if ($_POST["type"] == 14) {


            $result_t = mysql_time_query($link, 'Select a.*,b.summa_debt from c_cash as a,i_implementer as b where a.id_implementer=b.id and a.id="' . htmlspecialchars(trim($_POST["object"])) . '"');
            $num_results_t = $result_t->num_rows;
            if ($num_results_t != 0) {

                $row_t = mysqli_fetch_assoc($result_t);

                //проверяем может ли видеть этот наряд
                if (($row_t["sign_rco"] == 0)) {


                    //проверяем. Если это не аванс то может ли столько провести человек. возможно долг уже меньше
                    //если аванс проводить в любом случае

                    if (((($row_t["prepayment"] == 0) and ($row_t["summa_rco"] <= $row_t["summa_debt"]))) or ($row_t["prepayment"] == 1)) {
                        $error_im == 0;

                    }
                }
            }

        } else {
            $error_im == 0;
        }


        if ($error_im == 0) {


            $mass_end = explode(".", $_FILES["thefile"]["name"]);
            $extension = end($mass_end);
            //echo($extension);
            if (in_array(trim($extension), $allowedExts)) {

                $file_na = $ID_D . '_' . $name_imgs . '.' . $allowedExts[array_search(trim($extension), $allowedExts)];
                $uploadfile = $uploaddir . $file_na;
//echo($uploadfile);	


                // if ($file = upload::saveimg('thefile',$file_na,$uploadfile)) {


                if (move_uploaded_file($_FILES['thefile']['tmp_name'], $uploadfile)) {


                    //загрузился
                    mysql_time_query($link, 'update image_attach set visible="1",name="' . $name_imgs . '",name_user="' . ht($_FILES["thefile"]["name"]) . '",type="' . $allowedExts[array_search($extension, $allowedExts)] . '",id_user="'.$id_user.'" where id = "' . $ID_D . '"');


                    $links = '/upload/file/' . $ID_D . '_' . $name_imgs . '.' . $allowedExts[array_search($extension, $allowedExts)];

                    if ($_POST["type"] == 14) {


                        echo('update c_cash set sign_rco="' . $id_user . '",status=1,file_name="' . htmlspecialchars(trim($links)) . '" where id = "' . htmlspecialchars(trim($_POST["object"])) . '"');

                        mysql_time_query($link, 'update c_cash set sign_rco="' . $id_user . '",status=1,file_name="' . htmlspecialchars(trim($links)) . '" where id = "' . htmlspecialchars(trim($_POST["object"])) . '"');
                    }


                    $aRes = array("echo" => $name_imgs, "type" => $allowedExts[array_search($extension, $allowedExts)], "link" => $links);
                    /*require_once $url_system.'Ajax/lib/Services_JSON.php';
                    $oJson = new Services_JSON();
                    //функция работает только с кодировкой UTF-8
                    echo $oJson->encode($aRes);
                        */
                    echo json_encode($aRes);
                } else {
                    mysqli_query($link, 'delete FROM image_attach where id="' . $ID_D . '"');

                    $v_error = '1';
                    mysqli_query($link, 'insert into v_error (module,error,date_error)  values ("' . htmlspecialchars($_SERVER['REQUEST_URI']) . '","' . htmlspecialchars($v_error) . '","' . date("y.m.d") . ' ' . date("H:i:s") . '")');

                    header("HTTP/1.1 404 Not Found");
                    header("Status: 404 Not Found");
                    die ();
                }
            } else {
                mysqli_query($link, 'delete FROM image_attach where id="' . $ID_D . '"');

                $v_error = '5';
                mysqli_query($link, 'insert into v_error (module,error,date_error)  values ("' . htmlspecialchars($_SERVER['REQUEST_URI']) . '","' . htmlspecialchars($v_error) . '","' . date("y.m.d") . ' ' . date("H:i:s") . '")');

                header("HTTP/1.1 404 Not Found");
                header("Status: 404 Not Found");
                die ();
            }
        }

    } else {

        $v_error = '4';
        mysqli_query($link, 'insert into v_error (module,error,date_error)  values ("' . htmlspecialchars($_SERVER['REQUEST_URI']) . '","' . htmlspecialchars($v_error) . '","' . date("y.m.d") . ' ' . date("H:i:s") . '")');
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        die ();
    }
}
		  			
				 
?>