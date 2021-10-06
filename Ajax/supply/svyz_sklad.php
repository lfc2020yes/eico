<?php
//добавление материала к работе в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");


$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_POST['id']);
$token=htmlspecialchars($_POST['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

//эти столбцы видят только особые пользователи
$count_rows=10;
$stack_td = array();




if(!token_access_new($token,'edit_sklad',$id,"rema",2880))
{
    $debug=h4a(100,$echo_r,$debug);
    goto end_code;
}

if(!isset($_SESSION["user_id"])) {
    $status_ee='reg';
    $debug=h4a(102,$echo_r,$debug);
    goto end_code;
}

if ((!$role->permission('Счета','A'))and($sign_admin!=1))
{
    $debug=h4a(103,$echo_r,$debug);
    goto end_code;
}


$result_t1=mysql_time_query($link,'Select a.id_stock,a.id_i_material from z_doc_material as a where a.id="'.htmlspecialchars(trim($_POST['id'])).'"');
$num_results_t1 = $result_t1->num_rows;
if($num_results_t1==0)
{
    $debug=h4a(501,$echo_r,$debug);
    goto end_code;
} else
{
    $row1 = mysqli_fetch_assoc($result_t1);
}



//возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';


if($_POST["new_sklad_i"]==1) {

    $os = array('шт','м3','м2','т','пог.м','маш/час','компл');
    $os_id = array('0','1','2','3','4','5','6');

    $name_ed='';
    $rtyy=array_search(ht($_POST["ed_new_stock"]), $os_id );
    if ($rtyy !== false) {

        $name_ed=$os[$rtyy];

    }


    //добавляем новый материал в склад
    mysql_time_query($link, 'INSERT INTO z_stock (name,units,id_stock_group) VALUES ("' . htmlspecialchars(trim($_POST['name_new_stock'])) . '","' . htmlspecialchars(trim($name_ed)) . '","' . htmlspecialchars(trim($_POST["group_new_stock"])) . '")');
    $ID_P = mysqli_insert_id($link);
    $name_mat=$_POST['name_new_stock'];
    $ed_mat=$name_ed;


} else {
    $ID_P = ht($_POST["posta_posta"]);

    $result_uu = mysql_time_query($link, 'select * from z_stock where id="' . ht($ID_P) . '"');
    $num_results_uu = $result_uu->num_rows;

    if ($num_results_uu != 0) {
        $row_uu = mysqli_fetch_assoc($result_uu);
        $name_mat=$row_uu['name'];
        $ed_mat=$row_uu['units'];
    }

}

mysql_time_query($link,'update z_doc_material set id_stock="'.$ID_P.'" where id = "'.htmlspecialchars(trim($_POST['id'])).'"');



end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"select" => $ID_P,"basket"=>$row1["id_i_material"]);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>