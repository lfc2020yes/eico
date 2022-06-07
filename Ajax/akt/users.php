<?php
//получение в меню сверху в разделе себестоимость домов после выбора квартала


$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$debug='';
$count_all_all=0;

$id_city=htmlspecialchars($_GET['id']);


//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


  if((isset($_GET['id']))and(is_numeric($_GET['id'])))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
		  if (($role->permission('Прием-Передача','R'))or($sign_admin==1))
	      { 
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';

              $echo.='<div class="_50_x igor-2022-input menu3_prime_akt">'
              ;
              $echo.='<div class="input-width m10_right m10_left">';  //margin-right: 10px;
              $echo.='<input id="id_akt_edit" name="id_akt_edit" value="" type="hidden">';
              //====================================Список пользователей
              // ограничить объектами
              // не выводить себя самого, если это не S
//echo "<pre>".print_r($hie->id_kvartal,true)."$user_select_kvartal $user_select_kvartal_name  </pre>";
              ?>

              <?
              $select_id_users='';
              $select_name_users='';

              $ku = new kvartal_users($link);
              $mas_ar=(array) $_GET['id'];
              $users = $ku->get_users( $mas_ar,1);

              $select_id_users='';
              if(findArray($users,$_GET["ispol"], array('id_user'))) {
                  $select_id_users=$_GET["ispol"];

              }



                  //==========================================кому
                  $echo.='<div class="select_box eddd_box">'
                      . '<a class="slct_box '.iclass_('ispol_work',$stack_error,"error_formi").' '.$status_class.'"'
                      . 'data-tooltip="Принимающий" data_src="'.$select_id_users.'" id="id1_user">'
                      . '<span class="ccol">'.ipost_x($_POST['ispol_work'],$select_id_users,"Принимающий","r_user","name_user",$link).'</span>'
                      . '</a><ul class="drop_box" >';   //style="display:block"
                  //=====================Возможные получатели документа


                  // echo "<pre> связанные пользователи: ".print_r($users,true)."</pre>";

                  foreach ($users as $index => $usery) {
                      //$row_t = mysqli_fetch_assoc($result_t);
                      $echo.='<li><a href="javascript:void(0);"  rel="'.$usery["id_user"].'" data-tooltip="Выбрать принимающего">'.$usery["name_user"].'</a></li>';
                  }

                  /*
                              for ($i=0; $i<$result_t->num_rows; $i++)
                              {
                                  $row_t = mysqli_fetch_assoc($result_t);
                                  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'" data-tooltip="Выбрать принимающего">'.$row_t["name_user"].'</a></li>';
                              }*/
              $echo.='</ul>'                    //ispol
                      . '<input defaultv="'.$select_id_users
                      .'" '.$status_edit
                      .' name="id1_user" '
                      . 'id="ispol" '
                      . 'value="'.$select_id_users.'" type="hidden">'
                      . '</div>';





          $echo.='</div>';
          $echo.='</div>';



		  }
		 	  
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }



$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>