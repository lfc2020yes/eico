<?
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
//правам к просмотру к действиям



$active_menu='supply';  // в каком меню


$count_write=30000;  //количество выводимых записей на одной странице
$edit_price=0;
if ($role->is_column_edit('n_material','price'))
{
    $edit_price=1;
}


$echo_r=1; //выводить или нет ошибку 0 -нет
$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

//index.php не должно быть в $url_404
if (strripos($url_404, 'index.php') !== false) {
    header404(1,$echo_r);
}

//**************************************************
if (( count($_GET) != 1 )and( count($_GET) != 0 )and( count($_GET) != 2 ) )
{
    header404(2,$echo_r);
}

if((!$role->permission('Снабжение','R'))and($sign_admin!=1))
{
    header404(3,$echo_r);
}



if($error_header==404)
{
    include $url_system.'module/error404.php';
    die();
}


function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
// disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

// force download
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

// disposition / encoding on response body
    header("Content-Disposition: attachment;filename=".$filename);
    header("Content-Transfer-Encoding: binary");
}

function array2csv(array &$array, $titles) {
    if (count($array) == 0) {
        return null;
    }
    ob_start();
    $df = fopen("php://output", 'w');
    fputcsv($df, $titles, ';');
    foreach ($array as $row) {
        fputcsv($df, $row, ';');
    }
    fclose($df);
    return ob_get_clean();
}



                            $os = array( "дата поставки","дата поступления заявки");
                            $os_id = array("0", "1", "2");

                            $su_1=0;
                            if (( isset($_COOKIE["su_1"]))and(is_numeric($_COOKIE["su_1"]))and(array_search($_COOKIE["su_1"],$os_id)!==false))
                            {
                                $su_1=$_COOKIE["su_1"];
                            }



                            $os2 = array( "любой","выбрать");
                            $os_id2 = array("0", "2");

                            $su_2=0;
                            $date_su='';
                            if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and(array_search($_COOKIE["su_2"],$os_id2)!==false))
                            {
                                $su_2=$_COOKIE["su_2"];
                            }
                            $val_su2=$os2[$su_2];


                            if ( isset($_COOKIE["suddbc".$id_user]))
                            {
                                $date_base__=explode(".",$_COOKIE["sudd"]);
                                if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and($_COOKIE["su_2"]==2))
                                {
                                    $date_su=$_COOKIE["suddbc_mor".$id_user];
                                    $val_su2=$_COOKIE["suddbc_mor".$id_user];
                                }
                            }




                            $os3 = array( "любой", "не обработанные","в работе","на согласовании","заказано");
                            $os_id3 = array("0", "9", "11","12","20");

                            $su_3=0;
                            if (( isset($_COOKIE["su_3"]))and(is_numeric($_COOKIE["su_3"]))and(array_search($_COOKIE["su_3"],$os_id3)!==false))
                            {
                                $su_3=$_COOKIE["su_3"];
                            }




                            $os4 = array( "краткий", "подробный");
                            $os_id4 = array("0", "1");

                            $su_4=0;
                            if (( isset($_COOKIE["su_4"]))and(is_numeric($_COOKIE["su_4"]))and(array_search($_COOKIE["su_4"],$os_id4)!==false))
                            {
                                $su_4=$_COOKIE["su_4"];
                            }


                            $dava_var=0;
                            $dava_class='';
$name_file2='our';

                            if (( isset($_COOKIE["dava_".$id_user]))and($_COOKIE["dava_".$id_user]==1))
                            {


                                $dava_var=1;
                                $dava_class='active_task_cb';
                                $name_file2='dava';
                            }




                            //дата поставки
                            $sql_order1=' order by b.date_delivery';
                            $sql_order=' ';
                            $sql_last='';
                            $name_file1='delivery';

                            if (( isset($_COOKIE["su_1"]))and(is_numeric($_COOKIE["su_1"]))and(array_search($_COOKIE["su_1"],$os_id)!==false))
                            {

                                if($_COOKIE["su_1"]==2)
                                {
                                    //по алфавиту
                                    $sql_order1=' order by c.material';
                                    $sql_order=' ';
                                }
                                if($_COOKIE["su_1"]==1)
                                {
                                    //новые
                                    $sql_order=' order by z.date_last desc';
                                    $sql_order1='';
                                    $sql_last=',a.date_last';
                                    $name_file1='last';
                                }
                            }

$name_file3='';
                            $sql_su2='';
                            $sql_su2_='';
                            if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and(array_search($_COOKIE["su_2"],$os_id2)!==false)and($_COOKIE["su_2"]!=0))
                            {

                                if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and($_COOKIE["su_2"]==2))
                                {
                                    //выбранный период

                                    $date_range = explode("/", $_COOKIE["suddbc" . $id_user]);
                                    $name_file3='_'.date_ex(0,$date_range[0])."_".date_ex(0,$date_range[1]);
                                    //Выбранные период пользователем
                                    if((!isset($_COOKIE["su_1"]))or((isset($_COOKIE["su_1"]))and($_COOKIE["su_1"]==0))) {

                                        $sql_su2 = ' and b.date_delivery>="' . ht($date_range[0]) . '" and b.date_delivery<="' . ht($date_range[1]) . '"';
                                        $sql_su2_ = ' and a.date_delivery>="' . ht($date_range[0]) . '" and a.date_delivery<="' . ht($date_range[1]) . '"';

                                    } else
                                    {
                                        $sql_su2 = ' and a.date_last>="' . ht($date_range[0]) . '" and a.date_last<="' . ht($date_range[1]) . '"';
                                        $sql_su2_ = ' and b.date_last>="' . ht($date_range[0]) . '" and b.date_last<="' . ht($date_range[1]) . '"';
                                    }


                                }


                            }
                            //echo("!".$sql_su2);

                            $sql_su3='';
                            $sql_su3_='';
                            if (( isset($_COOKIE["su_3"]))and(is_numeric($_COOKIE["su_3"]))and(array_search($_COOKIE["su_3"],$os_id3)!==false)and($_COOKIE["su_3"]!=0))
                            {
                                $sql_su3=' and b.status='.htmlspecialchars(trim($_COOKIE["su_3"]));
                                $sql_su3_=' and a.status='.htmlspecialchars(trim($_COOKIE["su_3"]));
                            }


                            $sql_su4='none';
                            $sql_su4_='';
                            if (( isset($_COOKIE["su_4"]))and(is_numeric($_COOKIE["su_4"]))and(array_search($_COOKIE["su_4"],$os_id4)!==false)and($_COOKIE["su_4"]==1))
                            {
                                $sql_su4='';
                                $sql_su4_='active_supplyx';
                            }
                            /*
                        $result_t2=mysql_time_query($link,'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and a.id_object in('.implode(',', $hie->obj ).')
                      AND a.id_user in('.implode(',',$hie->user).') AND b.status NOT IN ("1","8","10","3","5","4") '.$sql_su2.' '.$sql_su3.' '.$sql_su1.' '.limitPage('n_st',$count_write));
                      */


                            $result_t2=mysql_time_query($link,'SELECT * FROM 
(
SELECT DISTINCT 
b.id_stock,b.id_i_material'.$sql_last.'

FROM 
z_doc AS a,
z_doc_material AS b,
i_material AS c, 
edo_state AS edo

WHERE 
c.`alien` = '.$dava_var.'      
AND c.id=b.id_i_material 
AND a.id=b.id_doc 
 AND a.id_edo_run = edo.id_run
 AND edo.id_status = 0
 AND edo.id_executor IN ('.ht($id_user).')

 AND b.status NOT IN ("1","8","10","3","5","4") 
 '.$sql_su2.' 
  '.$sql_su3.' 
 '.$sql_order1.' 
) AS z 				
'.$sql_order.' '.limitPage('n_st',$count_write));
                            /*
                            echo 'SELECT * FROM
                            (
                            SELECT DISTINCT
                            b.id_stock,b.id_i_material'.$sql_last.'

                            FROM
                            z_doc AS a,
                            z_doc_material AS b,
                            i_material AS c,
                            edo_state AS edo

                            WHERE
                            c.`alien` = '.$dava_var.'
                            AND c.id=b.id_i_material
                            AND a.id=b.id_doc
                             AND a.id_edo_run = edo.id_run
                             AND edo.id_status = 0
                             AND edo.id_executor IN ('.ht($id_user).')

                             AND b.status NOT IN ("1","8","10","3","5","4")
                             '.$sql_su2.'
                              '.$sql_su3.'
                             '.$sql_order1.'
                            ) AS z
                            '.$sql_order.' '.limitPage('n_st',$count_write);

                                */
                            $sql_count='SELECT count(id_stock) as kol FROM 
(
SELECT DISTINCT 
b.id_stock,b.id_i_material

FROM 
z_doc AS a,
z_doc_material AS b,
i_material AS c, 
edo_state AS edo

WHERE 
c.`alien` = '.$dava_var.'      
AND c.id=b.id_i_material 
AND a.id=b.id_doc 
 AND a.id_edo_run = edo.id_run
 AND edo.id_status = 0
 AND edo.id_executor IN ('.ht($id_user).')

 AND b.status NOT IN ("1","8","10","3","5","4") 
 '.$sql_su2.' 
  '.$sql_su3.' 
 '.$sql_order1.' 
) AS z ';


                            /*echo('Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and a.id_object in('.implode(',', $hie->obj ).')
                      AND a.id_user in('.implode(',',$hie->user).') AND b.status NOT IN ("1","8","10","3","5","4") '.$sql_su2.' '.$sql_su3.' '.$sql_su1.' '.limitPage('n_st',$count_write));
                            */
                            $result_t221=mysql_time_query($link,$sql_count);
                            $row__221= mysqli_fetch_assoc($result_t221);


                            $num_results_t2 = $result_t2->num_rows;
                            if($num_results_t2!=0)
                            {



                                $data = array();
                                for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                                {
                                    $data1 = array();
                                    $row__2= mysqli_fetch_assoc($result_t2);
$name_material_data='';
$dava_material_data='наш материал';
                                    $result_url_m=mysql_time_query($link,'select A.material,A.units from i_material as A where A.id="'.htmlspecialchars(trim($row__2["id_i_material"])).'"');
                                    $num_results_custom_url_m = $result_url_m->num_rows;
                                    if($num_results_custom_url_m!=0)
                                    {
                                        $row_material = mysqli_fetch_assoc($result_url_m);
                                    }

                                    $name_material_data=$row_material["material"];




                                    //узнаем название
                                    $result_t22=mysql_time_query($link,'Select a.implementer from i_implementer as a where a.id="'.$row__2["id_implementer"].'"');
                                    $num_results_t22 = $result_t22->num_rows;
                                    if($num_results_t22!=0)
                                    {
                                        $row_t22 = mysqli_fetch_assoc($result_t22);
                                        // echo'<a class="musa" href="implementer/'.$row_t2["id"].'/"><span class="s_j">'.$row_t2["implementer"].'</span></a>';
                                    }
                                    $cll='';
                                    if($row_t22["status"]==10)
                                    {
                                        $cll='whites';
                                    }
                                    if($ksss!=0)
                                    {
                                        //echo'<tr><td colspan="8" height="20px"></td></tr>';
                                    }
                                    $dava='';
                                    $class_dava='';
                                    $style_dava='';
                                    if($dava_var==1) {
                                        $dava_material_data='давальческий';
                                    }


                                    if($row__2["id_stock"]!='')
                                    {
                                        $result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row__2["id_stock"].'"');
                                        $num_results_t1__341 = $result_t1__341->num_rows;
                                        if($num_results_t1__341!=0)
                                        {
                                            $row1ss__341 = mysqli_fetch_assoc($result_t1__341);

                                        } else
                                        {

                                        }
                                    } else
                                    {

                                    }






//вывод заложенной стоимости за единицу товара из себестоимости
                                    if($row__2["id_stock"]!=0)
                                    {

                                        $result_xp=mysql_time_query($link,'SELECT b.price FROM z_doc_material AS a,i_material as b WHERE a.id_stock="'.htmlspecialchars(trim($row__2["id_stock"])).'" and a.id_i_material=b.id');

                                        $num_results_xp = $result_xp->num_rows;
                                        if($num_results_xp!=0)
                                        {
                                            //такая работа есть
                                            $row_xp = mysqli_fetch_assoc($result_xp);

                                        }

                                    }


                                    if($row__2["id_stock"]==0)
                                    {
                                        $result_work_zz=mysql_time_query($link,'Select a.*,b.id as idd,b.id_user,b.id_object from z_doc_material as a,z_doc as b,i_material as c where a.id_i_material=c.id and c.alien='.$dava_var.' and a.id_i_material="'.$row__2["id_i_material"].'" and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_);

                                    } else
                                    {
                                        $result_work_zz=mysql_time_query($link,'Select a.*,b.id as idd,b.id_user,b.id_object,b.name as app_name,b.id as app_id from z_doc_material as a,z_doc as b,i_material as c where c.alien='.$dava_var.' and a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_);


                                        //echo 'Select a.*,b.id as idd,b.id_user,b.id_object,b.name as app_name,b.id as app_id from z_doc_material as a,z_doc as b,i_material as c where c.alien=0 and a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_;

                                    }


                                    $num_results_work_zz = $result_work_zz->num_rows;
                                    if($num_results_work_zz!=0)
                                    {



                                        $id_work=0;

                                        for ($i=0; $i<$num_results_work_zz; $i++) {
                                            $row_work_zz = mysqli_fetch_assoc($result_work_zz);
                                            $nhh = 0;
                                            $actvss = '';

                                            if ((isset($_COOKIE["current_supply_" . $id_user])) and (is_numeric($_COOKIE["current_supply_" . $id_user]))) {
                                                if (cookie_work('basket_score_' . htmlspecialchars(trim($id_user)), $row_work_zz["id"], '.', 60, '0')) {
                                                    $actvss = 'checher_supply';
                                                }
                                            } else {

                                                if (cookie_work('basket_supply_' . htmlspecialchars(trim($id_user)), $row_work_zz["id"], '.', 60, '0')) {
                                                    $actvss = 'checher_supply';
                                                }
                                            }

                                            //score_pay score_app


                                            $result_url = mysql_time_query($link, 'select A.* from i_object as A where A.id="' . htmlspecialchars(trim($row_work_zz["id_object"])) . '"');
                                            //echo('select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_work_zz["id_object"])).'"');
                                            $num_results_custom_url = $result_url->num_rows;
                                            if ($num_results_custom_url != 0) {
                                                $row_list1 = mysqli_fetch_assoc($result_url);

                                                $result_town = mysql_time_query($link, 'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="' . $row_list1["id_kvartal"] . '"');
                                                $num_results_custom_town = $result_town->num_rows;
                                                if ($num_results_custom_town != 0) {
                                                    $row_town = mysqli_fetch_assoc($result_town);
                                                }
                                            }


                                            array_push($data1, $name_material_data);
                                            array_push($data1, $row_material['units']);
                                            array_push($data1, $row_work_zz['count_units']);
                                            array_push($data1, MaskDate_D_M_Y_ss($row_work_zz['date_delivery']));

                                            //по какой статье

                                            $result_uuf = mysql_time_query($link, 'select b.razdel1,b.razdel2,b.name_working from i_material as a,i_razdel2 as b where a.id_razdel2=b.id and a.id="' . ht($row_work_zz['id_i_material']) . '"');
                                            $num_results_uuf = $result_uuf->num_rows;

                                            if ($num_results_uuf != 0) {
                                                $row_uuf = mysqli_fetch_assoc($result_uuf);
                                                array_push($data1, $row_uuf["razdel1"].'.'.$row_uuf["razdel2"].' '.$row_uuf["name_working"]);
                                            } else
                                            {
                                                array_push($data1, '-');
                                            }


                                            array_push($data1, $row_work_zz["idd"]);

                                            if ($row_work_zz["commet"] != '') {
                                                array_push($data1, $row_work_zz["commet"]);
                                            } else
                                            {
                                                array_push($data1, '-');
                                            }


                                            $actv12='';
                                            if((time_compare($row_work_zz['date_delivery'].' 00:00:00',0)==0))
                                            {
                                                $actv12.=' redsupply ';
                                            }


                                            //echo'<a href="app/'.$row_work_zz['app_id'].'/" class="app-soply">'.$row_work_zz['app_name'].'</a><span class="object-acc-xx">';


                                            if($num_results_custom_url!=0)
                                            {

                                                array_push($data1, $row_list1["object_name"]);
                                                array_push($data1, $row_town["kvartal"]);
                                                array_push($data1, $row_town["town"]);
                                            } else
                                            {
                                                array_push($data1, '-');
                                                array_push($data1, '-');
                                                array_push($data1, '-');
                                            }

                                        }
                                    }





                                    array_push($data, $data1);

                                }



                            }

$titles = array("Наименование", "Ед. Изм.","Количество","Дата поставки","Статья","№ заявки","Комментарий","Объект","Квартал","Город");
function utf8to1251(&$text) {
    $text = iconv("utf-8", "windows-1251", $text); //without return
}

if(count($data)!=0) {

    array_walk_recursive($titles, "utf8to1251");
    array_walk_recursive($data, "utf8to1251");


    download_send_headers($name_file1 . '_' . $name_file2 . $name_file3 . ".csv");
    echo array2csv($data, $titles);
} else
{
    echo('Файл не создан, таких записей в базе не найдено.');
}
die();
