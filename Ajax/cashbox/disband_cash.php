<?php
//распроводка выдачи с удалением старого скана и изменения статуса операции

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$token=htmlspecialchars($_GET['tk']);
$dom=0;
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


if(token_access_new($token,'disband_cash',$id,"s_form"))
{

		  if (($role->permission('Касса','A'))or($sign_admin==1))
{	

if ((isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
	  if(isset($_SESSION["user_id"]))
	  { 
		 //может ли читать наряды 
		 
		 if (($role->permission('Касса','R'))or($sign_admin==1))
	     { 
			 
		   $result_t=mysql_time_query($link,'select A.*,B.name_user from c_cash as A,r_user as B where A.id_cash=B.id and A.id="'.htmlspecialchars(trim($_GET['id'])).'" and not(A.sign_rco=0)');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
			
         $status_ee='ok';
			
			 //удалить файл
			 $filename = '/path/to/foo.txt';
$uploaddir = $_SERVER["DOCUMENT_ROOT"];
				 
$uploadfile = $uploaddir.$row_t["file_name"];
			   
			   
             if (file_exists($uploadfile)) {
			    unlink($uploadfile);
			 }
			   
			   
			 //изменить rco
			   mysql_time_query($link,'update c_cash set sign_rco="0",file_name="",status=0 where id = "'.htmlspecialchars(trim($_GET['id'])).'"');  
			   
		   $result_t=mysql_time_query($link,'select A.*,B.name_user from c_cash as A,r_user as B where A.id_cash=B.id and A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
			$row_t = mysqli_fetch_assoc($result_t);   
			   
			$echo.='';   
			
if((($row_t["sign_rco"]!=0)and($row_t["id_cash"]!=$row_t["sign_rco"]))or($row_t["sign_rco"]==0))
{
    /*
$echo.='<div style="margin-left: 0px;" data-tooltip="Выписал - '.$row_t["name_user"].'" class="user_soz">'.avatar_img('<img src="img/users/',$row_t["id_cash"],'_100x100.jpg">').'</div>';
*/

    $echo.='<div m="'.$row_t["id_cash"].'" class="pass_wh_trips_2021" style="margin-top: 10px;"><label>Выписал</label><div class="obi">'.$row_t["name_user"].'</div></div>';


}
if($row_t["sign_rco"]!=0)
{
			   $result_txs=mysql_time_query($link,'Select a.name_user from r_user as a where a.id="'.$row_t["sign_rco"].'"');
	            if($result_txs->num_rows!=0)
	            {   
					
		          $rowxs = mysqli_fetch_assoc($result_txs);	
	if($row_t["id_cash"]==$row_t["sign_rco"])
	{
	/*
$echo.='<div style="margin-left: 0px;" data-tooltip="Провел - '.$rowxs["name_user"].'" class="user_soz n_yes">'.avatar_img('<img src="img/users/',$row_t["sign_rco"],'_100x100.jpg">').'</div>';
*/
        $echo.='<div class="pass_wh_trips_2021" style="margin-top: 10px;"><label>Провел</label><div class="obi">'.$rowxs["name_user"].'</div></div>';


	} else {

	   // $echo.='<div  data-tooltip="Провел - '.$rowxs["name_user"].'" class="user_soz n_yes">'.avatar_img('<img src="img/users/',$row_t["sign_rco"],'_100x100.jpg">').'</div>';

	    $echo.='<div class="pass_wh_trips_2021" style="margin-top: 10px;"><label>Провел</label><div class="obi">'.$rowxs["name_user"].'</div></div>';

	}
				}
/*
$echo.='<div data-tooltip="проведен" class="user_soz naryd_yes"></div>
<div class="status_nana">проведен - <a target="_blank" class="scan_pay"  href="implementer/scan/'.$row_t["file_name"].'">скан</a></div>';
*/

    $echo.='<div class="status-imp-2021">проведен</div><div></div>';
    $query_string='';
    $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="14" and A.visible=1 and A.id_object="' . ht($row_t["id"]) . '"');

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

            //$query_string .= '<span class="del-img js-dell-image" id="' . $row_6["name"] . '"></span>';


            $query_string .= '<div class="progress-img"><div class="p-img" style="width: 0px; display: none;"></div></div></div>';
            $i++;
        }
    }


    $query_string .= '</div></div>';







    $query_string .= '</div></div>';
    $echo.=$query_string;


} else
{

   /*
$echo.='<div id_upload="'.$row_t["id"].'" data-tooltip="загрузить кассовый ордер" class="user_soz naryd_upload"></div>';	
$echo.='<form  class="form_up" id="upload_sc_'.$row_t["id"].'" id_sc="'.$row_t["id"].'" name="upload'.$row_t["id"].'"><input class="sc_sc_loo" type="file" name="myfile'.$row_t["id"].'"></form><div class="loaderr_scan scap_load_'.$row_t["id"].'"><div class="scap_load__" style="width: 0%;"></div></div>';
*/


    $query_string='';
    $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="14" and A.visible=1 and A.id_object="' . ht($row_t["id"]) . '"');

    $num_results_uu = $result_6->num_rows;

    $class_aa = '';
    $style_aa = '';
    if ($num_results_uu != 0) {
        $class_aa = 'eshe-load-file';
        $style_aa = 'style="display: block;"';
    }


    $query_string .= '<div style="display: inline-block" class=""><div class="img_invoice_div1 js-image-gl"><div style="display: inline-block"><div class="list-image list-image-icons" ' . $style_aa . '>';
    /*
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
    */

    $query_string .= '</div></div>';



    $query_string .= '<input type="hidden" class="js-files-acc-new" name="files_9" value=""><div type_load="14" id_object="' . ht($row_t["id"]) . '" data-tooltip="загрузить кассовый ордер" class="invoice_upload js-upload-file js-helps ' . $class_aa . ' upload-but-2021 upload-but-2023" style="background-color: #fff !important;" ></div>';







    $query_string .= '</div></div>';


    $echo.=$query_string;



}
				   
			   
$echo1='<div class="font-rank del_pay" data-tooltip="Удалить" id_rel="'.$row_t["id"].'"><span class="font-rank-inner">x</span></div>';				 
	$echo2='';		


			   		   $result_t1=mysql_time_query($link,'select A.* from i_implementer as A where A.id="'.htmlspecialchars(trim($row_t['id_implementer'])).'"');
			$row_t1 = mysqli_fetch_assoc($result_t1);
			   
			   
  if($row_t1["summa_made"]>0)
  {
		 $echo2.='<div class="pay_summ4">'.rtrim(rtrim(number_format($row_t1["summa_made"], 2, '.', ' '),'0'),'.').'</div>';	
  }
    if($row_t1["summa_paid"]>0)
  {		
	  $echo2.='<div class="pay_summ3">'.rtrim(rtrim(number_format($row_t1["summa_paid"], 2, '.', ' '),'0'),'.').'</div>';
  }
     if($row_t1["summa_debt"]>0)
  { 
     $echo2.='<div class="pay_summ2">'.rtrim(rtrim(number_format($row_t1["summa_debt"], 2, '.', ' '),'0'),'.').'</div>';
  }			   
			   
			 
		 }
	  }
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

}

}


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo,"echo1" =>  $echo1,"echo2" =>  $echo2);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>