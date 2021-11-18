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
//print_r($hie_user);
//print_r($hie_object);
$role->GetColumns();
$role->GetRows();
$role->GetPermission();
//правам к просмотру к действиям


//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /prime/23/
//     0   1   2  3
//      /prime/23/add/5/
//     0   1   2  3   4  5


$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);


if (( count($_GET) == 1 )or( count($_GET) == 2 )) //--Если были приняты данные из HTML-формы
{
 if ( count($_GET) == 1 )
 {	
  $active_menu='prime';	 
  //просмотр себестоимости	 
  if($D_404[3]=='')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
		//echo("!");
        $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0)
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} else
		{
			$row_list = mysqli_fetch_assoc($result_url);
			//echo("!");
			//может ли вообще этот пользователь просматривать эту себестоимость
			if(($sign_admin!=1)and(array_search($_GET['id'],$hie_object)===false))
			{
				 //echo($sign_admin);
				 header("HTTP/1.1 404 Not Found");
	             header("Status: 404 Not Found");
	             $error_header=404;
				 //echo('!');
			}
			if (($role->permission('Себестоимость','R'))or($sign_admin==1))
	        {
				//echo("4");
			} else
			{
				//echo("4");
				 header("HTTP/1.1 404 Not Found");
	             header("Status: 404 Not Found");
	             $error_header=404;				
			}


			
		}
	} else
	{
       header("HTTP/1.1 404 Not Found");
	   header("Status: 404 Not Found");
	   $error_header=404;
	}
  } else
  {
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $error_header=404;	  
  }
 }
 if ( count($_GET) == 2 )
 {	
	 
//echo("4");	 
   //добавить работы в существующий наряд
	if($D_404[5]=='')
  {		
	
	if((isset($_GET["id"]))and(isset($_GET["add"])))
	{
		$active_menu='finery';
        $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0)
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} else
		{
			 $row_list= mysqli_fetch_assoc($result_url);
			$result_url1=mysql_time_query($link,'select A.* from n_nariad as A where A.id="'.htmlspecialchars(trim($_GET['add'])).'" and A.id_object="'.htmlspecialchars(trim($_GET['id'])).'"');
            $num_results_custom_url1 = $result_url1->num_rows;
            if($num_results_custom_url1==0)
            {
               header("HTTP/1.1 404 Not Found");
	           header("Status: 404 Not Found");
	           $error_header=404;			
		    } else
		    {
			   $row_list1 = mysqli_fetch_assoc($result_url1);
				
			   	if (($role->permission('Наряды','R'))or($sign_admin==1))
	            {	
					
					 if((sign_naryd_level($link,$id_user,$sign_level,$_GET['add'],$sign_admin)))
	                 {
						 
					    		    //проверяем может ли видеть этот наряд
						 //print_r($row_list["id_user"]);
		                            if(array_search($row_list1["id_user"],$hie_user)!==false)
									{
										//echo("!");
									} else
									{
									   header("HTTP/1.1 404 Not Found");
	                                   header("Status: 404 Not Found");
	                                   $error_header=404;		
									}
		      
					 } else
					 {
	                   header("HTTP/1.1 404 Not Found");
	                   header("Status: 404 Not Found");
	                   $error_header=404;						 
					 }
					
				} else
				{
	              header("HTTP/1.1 404 Not Found");
	              header("Status: 404 Not Found");
	              $error_header=404;				
				}
		    }
		}
	} else
	{
	if((isset($_GET["id"]))and(isset($_GET["add_a"])))
	{
		$active_menu='app';
        $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0)
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} else
		{
			 $row_list= mysqli_fetch_assoc($result_url);
			$result_url1=mysql_time_query($link,'select A.* from z_doc as A where A.id="'.htmlspecialchars(trim($_GET['add_a'])).'" and A.id_object="'.htmlspecialchars(trim($_GET['id'])).'"');
            $num_results_custom_url1 = $result_url1->num_rows;
            if($num_results_custom_url1==0)
            {
               header("HTTP/1.1 404 Not Found");
	           header("Status: 404 Not Found");
	           $error_header=404;			
		    } else
		    {
			   $row_list1 = mysqli_fetch_assoc($result_url1);
				
			   	if ((($role->permission('Заявки','A'))and($row_list1["id_user"]==$id_user))or($sign_admin==1))
	            {	
					
					 if($row_list1["status"]==1)
	                 {
						 		      
					 } else
					 {
	                   header("HTTP/1.1 404 Not Found");
	                   header("Status: 404 Not Found");
	                   $error_header=404;						 
					 }
					
				} else
				{
	              header("HTTP/1.1 404 Not Found");
	              header("Status: 404 Not Found");
	              $error_header=404;				
				}
		    }
		}
	}	   
		
		else {	
       header("HTTP/1.1 404 Not Found");
	   header("Status: 404 Not Found");
	   $error_header=404;
	   }
	}
  } else
  {
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $error_header=404;	  
  } 
 }
	 
} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}
//echo($error_header);

//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
//echo("4");

//проверяем что этот пользователь может добавлять в выбранный наряд
//этот наряд им еще не подписан
//он имеет доступ к этому наряду
/*
if((isset($_GET["id"]))and(isset($_GET["add"])))
{


if($sign_admin==1)
{
	if($row_list["signedd_nariad"]==1)
	{
		//уже выполнен нельзя добавлять
		header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        $error_header=404;		
	}
} else
{
//$id_object[]=implode(',', $hie->obj);
$found_object = array_search($_GET['id'],$hie_object);   
if($found_object !== false) 
{
	if(($row_list["signedd_nariad"]!=0)or($row_list["id_signed".$sign_level]!=0))
	{
		//Этот наряд подписан выше по рангу или им же или вообще
		header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        $error_header=404;
	}
} else
{
   //Это не его наряды	
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}
}
}

//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
*/

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы

$b_co='basket_'.$id_user;
$b_cm='basket1_'.$id_user;

if(($error_header!=404)and(isset($_GET['add']))){
	//формируем корзину уже с существующими в ней работами из наряда
	$basket_cookie='';
	$result_t__=mysql_time_query($link,'Select a.id_razdeel2 from n_work as a where a.id_nariad="'.htmlspecialchars(trim($_GET['add'])).'"');
    $num_results_t__ = $result_t__->num_rows;
	if($num_results_t__!=0)
	{
		   for ($i__=0; $i__<$num_results_t__; $i__++)
             {  
			    $row_t__ = mysqli_fetch_assoc($result_t__);
				 if($i__==0)
				 {
					 $basket_cookie=$row_t__["id_razdeel2"];
				 } else
				 {
					 $basket_cookie.='.'.$row_t__["id_razdeel2"];
				 }
			 }
		//echo($basket_cookie);
        $b_co='edit_basket_'.$id_user;
		setcookie($b_co."_".htmlspecialchars(trim($_GET['id'])), $basket_cookie, 0, "/", $base_cookie, false, false); //на год
		$_COOKIE[$b_co."_".htmlspecialchars(trim($_GET['id']))]=$basket_cookie;
		//setcookie("basket_".htmlspecialchars(trim($_GET['id'])), $basket_cookie, 0, "/", "is.ru", false, false); //на год
		//echo($basket_cookie);
	}
	
	
	
}


if(($error_header!=404)and(isset($_GET['add_a']))){
	//формируем корзину уже с существующими в ней работами из наряда
	$basket_cookie='';
	$result_t__=mysql_time_query($link,'Select a.id_i_material from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['add_a'])).'"');
    $num_results_t__ = $result_t__->num_rows;
	if($num_results_t__!=0)
	{
		   for ($i__=0; $i__<$num_results_t__; $i__++)
             {  
			    $row_t__ = mysqli_fetch_assoc($result_t__);
				 if($i__==0)
				 {
					 $basket_cookie=$row_t__["id_i_material"];
				 } else
				 {
					 $basket_cookie.='.'.$row_t__["id_i_material"];
				 }
			 }
        $b_co='edit_basket1_'.$id_user;
		setcookie($b_co."_".htmlspecialchars(trim($_GET['id'])), $basket_cookie, 0, "/", $base_cookie, false, false); //на год
		$_COOKIE[$b_co."_".htmlspecialchars(trim($_GET['id']))]=$basket_cookie;
		//setcookie("basket_".htmlspecialchars(trim($_GET['id'])), $basket_cookie, 0, "/", "is.ru", false, false); //на год
		//echo($basket_cookie);
	}
	
	
	
}



setcookie("pr_", $_GET["id"], time() + 60 * 60 * 24 * 365, "/", $base_cookie, false, false); //на год

include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('prime','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php'; include $url_system.'template/head.php';
?>
</head><body>
<div class="alert_wrapper"><div class="div-box"></div></div>
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
    echo'<div class="iss small">';
}
//echo(mktime());

//echo($row_list["id_kvartal"]);
        $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}


	 	   //эти столбцы видят только особые пользователи	
		   $count_rows=10;	
		   $stack_td = array();


/*

по доступу к колонкам данных в Себестоимости:
По Трубочникову: (прораб)
тест прав доступа к колонкам данных: { [Трубочников Александр Николаевич (a.trubochnikov)]}
запрос	таблица	столбец	права
$role->is_column('i_object','total_r0','разрешен','запрещен')	i_object	total_r0:	запрещен
$role->is_column('i_object','total_m0','разрешен','запрещен')	i_object	total_m0:	запрещен
$role->is_column('i_razdel1','summa_r1','разрешен','запрещен')	i_razdel1	summa_r1:	запрещен
$role->is_column('i_razdel1','summa_m1','разрешен','запрещен')	i_razdel1	summa_m1:	запрещен
$role->is_column('i_razdel2','summa_r2_realiz','разрешен','запрещен')	i_razdel2	summa_r2_realiz:	запрещен
$role->is_column('i_razdel2','summa_material','разрешен','запрещен')	i_razdel2	summa_material:	запрещен
$role->is_column('i_material','price','разрешен','запрещен')	i_material	price	запрещен
$role->is_column('i_material','subtotal','разрешен','запрещен')	i_material	subtotal	запрещен
$role->is_column('i_razdel2','summa_r2_realiz','разрешен','запрещен')	i_razdel2	summa_r2_realiz:	запрещен
$role->is_column('n_work','price','разрешен','запрещен')	n_work	price:	разрешен
$role->is_column('n_material','price','разрешен','запрещен')	n_material	price:	разрешен
*/

if($sign_admin!=1)
{
			 //столбцы  выполнено на сумму - остаток по смете  
	         if ($role->is_column('i_razdel2','summa_r2_realiz',true,false)==false) 
		     { 
			  $count_rows=$count_rows-2;
			  array_push($stack_td, "summa_r2_realiz"); 
		     } 
             //строка итого по работе, по материалам, по разделу
		     if ($role->is_column('i_razdel1','summa_r1',true,false)==false) 
		     { 
			    array_push($stack_td, "summa_r1"); 
		     } 	  
             //строка итого по объекту
		     if ($role->is_column('i_object','total_r0',true,false)==false) 
		     { 
			    array_push($stack_td, "total_r0"); 
		     } 
	         //строка итого за метр кв
		     if ($role->is_column('i_object','object_area',true,false)==false) 
		     { 
			    array_push($stack_td, "object_area"); 
		     } 		
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

$uor = new User_Object_Razdel($link, $id_user);
$id_object = htmlspecialchars(trim($_GET['id']));

if(isset($_GET["add"]))
{
  include_once $url_system.'template/top_prime_add.php';
  echo(' <input class="add_v_naryad" name="add_v_naryad" value="1" type="hidden">');
} else
{ 
	if(isset($_GET["add_a"]))
{
  include_once $url_system.'template/top_prime_add_mat.php';
  echo(' <input class="add_v_zay" name="add_v_zay" value="1" type="hidden">');
} else {	
  include_once $url_system.'template/top_prime.php';
}
}
?>
<div id="fullpage" class="margin_60  input-block-2020 ">
    <div class="oka_block_2019" style="min-height:auto;">
        <div class="div_ook hop_ds"><div class="search_task">
                <?
                $result_t=mysql_time_query($link,'Select a.id,a.town from i_town as a order by a.id');
                $num_results_t = $result_t->num_rows;
                if($num_results_t!=0)
                {
                    echo'<div class="left_drop menu1_prime book_menu_sel js--sort gop_io"><label>Город</label><div class="select eddd"><a class="slct" data_src="'.$row_town["id_town"].'">'.$row_town["town"].'</a><ul class="drop">';
                    for ($i=0; $i<$num_results_t; $i++)
                    {
                        $row_t = mysqli_fetch_assoc($result_t);
                        if((array_search($row_t["id"],$hie_town) !== false)or($sign_admin==1))
                        {
                            if($row_t["id"]==$row_town["id_town"])
                            {
                                echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["town"].'</a></li>';
                            } else
                            {
                                echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["town"].'</a></li>';
                            }
                        }
                    }
                    echo'</ul><input type="hidden" name="city" id="city" value="'.$row_town["id_town"].'"></div></div>';
                }


                $result_t=mysql_time_query($link,'Select a.id,a.kvartal from i_kvartal as a where a.id_town="'.$row_town["id_town"].'" order by a.id');
                $num_results_t = $result_t->num_rows;
                if($num_results_t!=0)
                {
                    echo'<div class="left_drop menu2_prime book_menu_sel js--sort gop_io"><label>Квартал</label><div class="select eddd"><a class="slct" data_src="'.$row_list["id_kvartal"].'">'.$row_town["kvartal"].'</a><ul class="drop">';
                    for ($i=0; $i<$num_results_t; $i++)
                    {
                        $row_t = mysqli_fetch_assoc($result_t);
                        if((array_search($row_t["id"],$hie_kvartal) !== false)or($sign_admin==1))
                        {
                            if($row_t["id"]==$row_list["id_kvartal"])
                            {
                                echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["kvartal"].'</a></li>';
                            } else
                            {
                                echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["kvartal"].'</a></li>';
                            }
                        }
                    }
                    echo'</ul><input type="hidden"  name="kvartal" id="kvartal" value="'.$row_list["id_kvartal"].'"></div></div>';
                }




                $result_t=mysql_time_query($link,'Select a.id,a.object_name from i_object as a where a.id_kvartal="'.$row_list["id_kvartal"].'" order by a.id');
                $num_results_t = $result_t->num_rows;
                if($num_results_t!=0)
                {
                    echo'<div class="left_drop menu3_prime book_menu_sel js--sort gop_io"><label>Объект</label><div class="select eddd"><a class="slct" data_src="'.$row_list["id"].'">'.$row_list["object_name"].'</a><ul class="drop">';
                    for ($i=0; $i<$num_results_t; $i++)
                    {
                        $row_t = mysqli_fetch_assoc($result_t);
                        $url_prime="prime/";


                        if((array_search($row_t["id"],$hie_object) !== false)or($sign_admin==1))
                        {
                            //он может видеть этот объект

                            if($row_t["id"]==$row_list["id"])
                            {
                                echo'<li class="sel_active"><a href="'.$url_prime.$row_t["id"].'/"  rel="'.$row_t["id"].'">'.$row_t["object_name"].'</a></li>';
                            } else
                            {
                                echo'<li><a href="'.$url_prime.$row_t["id"].'/"  rel="'.$row_t["id"].'">'.$row_t["object_name"].'</a></li>';
                            }
                        }

                    }
                    echo'</ul><input type="hidden"  name="dom" id="dom" value="'.$row_list["id"].'"></div></div>';
                }

if(($role->permission('График','U'))or($role->permission('График','R'))or($sign_admin==1)) {
    echo '<a href="/prime/' . $_GET["id"] . '/gant/" class="search-count-csv search-count-csv-new">график работ</a>';
}

                ?>


            </div>
    </div>
        <div class="oka_block">
            <div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">

<?
//echo'<span class="h3-f">Себестоимость <span class="pol-card"> '.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</span></span>';


    echo'<div class="content_block" style="overflow: hidden;" dom="'.$row_list["id"].'" id_content="'.$id_user.'">';
	?>

  <?


//echo'<h1>Себестоимость - '.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</h1>';
/*
<div class="close_all_r">закрыть все</div>
<div data-tooltip="Удалить всю себестоимость" class="del_seb"></div>
<div data-tooltip="Добавить раздел" class="add_seb"></div>
';
*/




       $result_t=mysql_time_query($link,"select a.* from i_razdel1 as a where a.id_object='$id_object'". $uor->select($id_object) .' order by a.razdel1');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   for ($i=0; $i<$num_results_t; $i++)
             {  
			    $row_t = mysqli_fetch_assoc($result_t);
				 
				if($role->is_row('i_razdel1','razdel1',$row_t["razdel1"]))
				{
				 
				$actv='';
	            $pl='+';
				 //раскрыт раздел или не раскрыт
                if(cookie_work('l_'.$id_user,$row_t["id"],'.',60,'0'))
	            {
		            $actv='active';
		            $pl='-';
	            }								
                echo'<div rel="'.$row_t["id"].'" class="block_i '.$actv.'"><div class="top_bl"><i  class="i__">'.$pl.'</i><h2><span class="s_j">'.$row_t["razdel1"].'. '.$row_t["name1"].'</span><span class="edit_12">';


                if($uor->select($id_object)=='') {
                    if (($role->permission('Себестоимость', 'U')) or ($sign_admin == 1)) {
                        echo '<span for="' . $row_t["id"] . '" data-tooltip="редактировать раздел" class="edit_icon_block">3</span>';
                    }
                    if (($role->permission('Себестоимость', 'D')) or ($sign_admin == 1)) {
                        echo '<span for="' . $row_t["id"] . '" data-tooltip="Удалить раздел" class="del_icon_block">5</span>';
                    }
                }



				if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	            {		
				echo'<span for="'.$row_t["id"].'" data-tooltip="Добавить работу" class="add_icon_block">J</span>';
				}
				echo'</span></h2>';
				if(array_search('summa_r1',$stack_td) === false) 
	            { 	
				echo'<div style="'.$act_.'" class="summ_blogi" id_sub="'.$row_t["id"].'">
				<div class="ss1" data-tooltip="итого работа"><span class="s_j">'.rtrim(rtrim(number_format($row_t["summa_r1"], 2, '.', ' '),'0'),'.').'</span></div>
				<div class="ss2" data-tooltip="итого материал"><span class="s_j">'.rtrim(rtrim(number_format($row_t["summa_m1"], 2, '.', ' '),'0'),'.').'</span></div>
				<div class="ss3" data-tooltip="итого сумма + ндс"><span class="s_j">'.rtrim(rtrim(number_format(($row_t["summa_m1"]+$row_t["summa_r1"]), 2, '.', ' '),'0'),'.').' (НДС 20% - '.rtrim(rtrim(number_format((($row_t["summa_m1"]+$row_t["summa_r1"])/1.20*0.20), 2, '.', ' '),'0'),'.').')</span></div>
				</div>';
				}
				echo'<div class="count_basket_razdel"></div></div><div class="rls">';
    
	            $result_t1=mysql_time_query($link,'Select a.* from i_razdel2 as a where a.id_razdel1="'.$row_t["id"].'" order by a.id');
                $num_results_t1 = $result_t1->num_rows;
	            if($num_results_t1!=0)
	            {
				  echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_'.$i.'" class="smeta"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_2 no_padding_left_">Наименование работ</th><th class="t_3">Исполнитель</th><th class="t_4">ед. изм.</th><th class="t_5">кол-во</th><th class="t_6">стоимость ед.<br>(руб.)</th><th class="t_7">всего (руб.)</th><th class="t_9">выполнено<br>объемов</th>';


		   
					
		   if(array_search('summa_r2_realiz',$stack_td) === false) 
	       {
		  echo'<th class="t_8">выполнено<br>на сумму</th>
			   <th class="t_10">остаток<br>по смете</th>';		   
		   }
		
					
		   
		   echo'</tr></thead><tbody>';
					
				   	
		          for ($iu=0; $iu<$num_results_t1; $iu++)
                  {  
			         $row_t1 = mysqli_fetch_assoc($result_t1);
					 //процент выполненных работ
					 if($row_t1["count_units"]!=0)
					 {	 
					   $proc_realiz=round(($row_t1["count_r2_realiz"]*100)/$row_t1["count_units"]); 
					 } else
					 {
						$proc_realiz=0; 
					 }
					 //echo($proc_realiz);
					  
				     echo'<tr class="loader_tr"><td colspan="'.$count_rows.'"><div class="loaderr"><div class="teps" rel_w="'.$proc_realiz.'" style="width:0%"><div class="peg_div"><div><i class="peg"></i></div></div></div></div></td></tr>';
					 //вывод работы проверяем есть ли в корзине нарядов для этого дома
					 $actv1='';
					  
					 //смотрим в корзине материал или нет 
                     if((cookie_work($b_co.'_'.htmlspecialchars(trim($_GET['id'])),$row_t1["id"],'.',60,'0'))and(!isset($_GET["add_a"])))
	                 {
		                $actv1='checher';
	                 }
					 
					 //мигает красным если дата прошла а работа не выполнена
					  $actv12='';
					 if(($proc_realiz<100)and(($role->permission('График','R'))or($sign_admin==1))and($row_t1["date1"]!=''))
					 {
						 if((time_compare($row_t1["date1"].' 00:00:00',0)==0))
						 {
						   $actv12.=' redgraf';
						 }
					 }
					 
					 $class_st_div='st_div';
					  if(isset($_GET["add_a"]))
					  {
						  $class_st_div='st_div1';
					  }
					  
					  $st_div_none='none';
					  	  if (($role->permission('Наряды','A'))or($sign_admin==1))
	                      {
							 $st_div_none=''; 
						  }

					  
					  
					  
        
                     echo'<tr class="jop n1n '.$actv1.'" rel_id="'.$row_t1["id"].'"><td class="middle_"><div class="'.$class_st_div.' '.$st_div_none.'"><i class="'.$actv12.'"></i></div></td>
                  <td class="no_padding_left_ pre-wrap"><span class="s_j">'.$row_t["razdel1"].'.'.$row_t1["razdel2"].' '.$row_t1["name_working"].'</span><br>';
				  
					  
					  
					  //вывод дат начала и конца работы
					  if (($role->permission('График','R'))or($sign_admin==1))
					  {
					    $class_graf='';
					    if($row_t1["date0"]!='')
					    {
						  if (($role->permission('График','U'))or($sign_admin==1))
					      {	
							  $class_graf='class="UGRAFE"';
						  }
					      echo'<span data-tooltip="редактировать график работы" for="'.$row_t1["id"].'" '.$class_graf.'><span class="UD0">'.MaskDate_D_M_Y_ss($row_t1["date0"]).'</span><span> - </span>';
					      echo'<span class="UD1">'.MaskDate_D_M_Y_ss($row_t1["date1"]).'</span></span>';
					    } else
						{
						   if (($role->permission('График','U'))or($sign_admin==1))
					      {	
							  $class_graf='class="UGRAFE"';
							   echo'<span data-tooltip="редактировать график работы" for="'.$row_t1["id"].'" '.$class_graf.'><span class="UD0">задать график работ</span></span>';
							  
						  }
							
						}
					  }
				  
					  
				  
				  echo'<span class="edit_panel">';
				      if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	                  {
				         echo'<span data-tooltip="редактировать работу" for="'.$row_t1["id"].'" class="edit_icon">3</span>';
	                  }
				      if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	                  {
				         echo'<span data-tooltip="удалить работу" for="'.$row_t1["id"].'" class="del_icon">5</span>';
	                  }
				      if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	                  {
				         echo'<span data-tooltip="Добавить материал" for="'.$row_t1["id"].'" class="addd_icon">J</span>';
	                  }
					  if ((($role->permission('Заявки','A'))or($sign_admin==1))and(!isset($_GET["add"])))
                      {
						 echo'<span data-tooltip="Добавить/Удалить материалы из заявки" for="'.$row_t1["id"].'" class="addd_icon_mateo">\'</span>'; 
					  }
					  
				echo'</span></td>
<td class="pre-wrap">';
	            $result_t2=mysql_time_query($link,'Select a.* from i_implementer as a where a.id="'.$row_t1["id_implementer"].'"');
                $num_results_t2 = $result_t2->num_rows;
	            if($num_results_t2!=0)
	            {
					$row_t2 = mysqli_fetch_assoc($result_t2);
					
					
						if (($role->permission('Исполнители','R'))or($sign_admin==1))
	        {	
                    echo'<a class="musa" href="implementer/'.$row_t2["id"].'/"><span class="s_j">'.$row_t2["implementer"].'</span></a>';
			} else
			{
				echo'<span class="s_j">'.$row_t2["implementer"].'</span>';
			}
					
					
					
				}
				//количество нарядов по данной работе
				
//<div class="musa_plus">3</div>
//echo'<div class="musa_plus mpp">+</div>';
echo'</td>
<td><span class="s_j">'.$row_t1["units"].'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row_t1["count_units"], 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row_t1["price"], 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row_t1["subtotal"], 2, '.', ' '),'0'),'.').'</span></td>';
if($row_t1["count_r2_realiz"]!=0)
{
echo'<td><span class="s_j musa hist_mu" data-tooltip="'.$proc_realiz.'%">'.mor_class(($row_t1["count_units"]-$row_t1["count_r2_realiz"]),rtrim(rtrim(number_format($row_t1["count_r2_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td>';	
} else
{
echo'<td><span class="s_j" data-tooltip="'.$proc_realiz.'%">'.mor_class(($row_t1["count_units"]-$row_t1["count_r2_realiz"]),rtrim(rtrim(number_format($row_t1["count_r2_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td>';
}
	//echo(array_search('summa_r2_realiz',$stack_td));				  
	if(array_search('summa_r2_realiz',$stack_td) === false) 
	{			  
echo'<td><span class="s_j">'.mor_class(($row_t1["subtotal"]-$row_t1["summa_r2_realiz"]),rtrim(rtrim(number_format($row_t1["summa_r2_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td>
<td><strong><span class="s_j">'.mor_class(($row_t1["subtotal"]-$row_t1["summa_r2_realiz"]),rtrim(rtrim(number_format(($row_t1["subtotal"]-$row_t1["summa_r2_realiz"]), 2, '.', ' '),'0'),'.'),1).'</span></strong></td>';
		   }
           echo'</tr>';
				
				
				
				//вывод материала относящегося к данной работе
				$result_t3=mysql_time_query($link,'Select a.* from i_material as a where a.id_razdel2="'.$row_t1["id"].'" order by a.id');
                $num_results_t3 = $result_t3->num_rows;
	            if($num_results_t3!=0)
	            {
				  	
				  for ($y=0; $y<$num_results_t3; $y++)
                  {  
			         $row_t3 = mysqli_fetch_assoc($result_t3);
					  
					 
				  $actv2='';
				  $actv3='';
					  
					 //смотрим в корзине материал или нет 
				  if ((($role->permission('Заявки','A'))or($role->permission('Накладные','A'))or($sign_admin==1))and(!isset($_GET["add"])))
                  {
					  
					 if(!isset($_GET["add_a"]))
					 {
                     if(cookie_work($b_cm.'_'.htmlspecialchars(trim($_GET['id'])),$row_t3["id"],'.',60,'0'))
	                 {
		                $actv2='chechers';
						
	                 }
					 } else
					 {
			                     if(cookie_work($b_co.'_'.htmlspecialchars(trim($_GET['id'])),$row_t3["id"],'.',60,'0'))
	                 {
		                $actv2='chechers';
						
	                 }			 
					 }
					  
					 $actv3='nm_nm';  
				  }
					  
					  
				  echo'<tr class="material material-prime-v2 '.$actv2.'" rel_ma="'.$row_t3["id"].'">
           
           <td colspan="2" class="no_padding_left_ pre-wrap name_m"><div class="nm '.$actv3.'">';


				  echo'<i></i>';
				  $class_dava='';
                      if($row_t3["alien"]==1)
                      {
                          $class_dava='dava';

                      }
                      echo'<span class="s_j '.$class_dava.'">'.$row_t3["material"].'</span>';
if($row_t3["alien"]==1)
{
    echo'<div class="chat_kk" data-tooltip="давальческий материал"></div>';
}


                      echo'<span class="edit_panel_">';
					if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	                  {		  
		                 echo'<span data-tooltip="редактировать материал" for="'.$row_t3["id"].'" class="edit_icon_m">3</span>';
					  }
					if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	                  {		
		                 echo'<span data-tooltip="удалить материал" for="'.$row_t3["id"].'" class="del_icon_m">5</span></span></div></td>';
			          }
					  
echo'<td class="pre-wrap"></td>
<td><span class="s_j">'.$row_t3["units"].'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row_t3["count_units"], 2, '.', ' '),'0'),'.').'</span>';


                      if(($role->permission('Заявки','R'))or($sign_admin==1)) {


                          $result_uu_xo = mysql_time_query($link, 'select a.id,a.status,b.count_units,b.id as id_doc_material from z_doc as a,z_doc_material as b where a.id=b.id_doc and a.status NOT IN ("1","8") and b.id_i_material="' . ht($row_t3["id"]) . '"');

                          $num_results_histo = $result_uu_xo->num_rows;
                          if($num_results_histo!=0) {

                              echo '<span class="edit_panel11_mat"><span data-tooltip="история заявок по позиции" for="' . $row_t3["id"] . '" class="history_icon">M</span>';

                              echo '<div class="history_act_mat history-prime-mat">
                                             <div class="line_brock"><div class="count_brock"><span>↑ Заявка</span></div><div class="count_brock"><span>Кол-во</span></div><div class="count_brock"><span>Статус</span></div></div>';

                              if ($result_uu_xo) {
                                  $i = 0;
                                  $count_m=0;
                                  while ($row_uu_xo = mysqli_fetch_assoc($result_uu_xo)) {


                                      echo '<div class="line_brock"><div class="count_brock"><a target="_blank" href="app/'.$row_uu_xo["id"].'/">№' . $row_uu_xo["id"] . '</a></div><div class="count_brock">' . rtrim(rtrim(number_format($row_uu_xo["count_units"], 2, '.', ' '),'0'),'.') . '<b>' . $row_t3["units"] . '</b></div>
<div class="count_brock">';
                                      $count_m=$count_m+$row_uu_xo["count_units"];
                                      //вывод статуса по материалу
                                      $result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row_uu_xo["status"].'" and a.id_system=13');
                                      //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
                                      if($result_status->num_rows!=0)
                                      {
                                          $row_status = mysqli_fetch_assoc($result_status);
                                          if($row_work_zz["status"]==10)
                                          {
                                              echo'<div class="status_material1">'.$row_status["name_status"].'</div><div class="user_mat naryd_yes"></div>';
                                          } else
                                          {
                                              echo'<div style="margin-right: 20px;" class="status_materialz status_z'.$row_work_zz["status"].'">'.$row_status["name_status"].'</div>';
                                              if($row_work_zz["status"]==14)
                                              {
                                                  //если статус оплачено
                                                  //выводим доп информацию какое количество и когда примерно ждать
                                                  $result_book=mysql_time_query($link,'SELECT b.*,a.delivery_day,a.date_paid,c.id_stock FROM z_acc as a,z_doc_material_acc as b,z_doc_material as c WHERE b.id_acc=a.id and a.status=4 and b.id_doc_material=c.id and b.id_doc_material="'.$row_uu_xo["id_doc_material"].'"');
                                                  $num_results_book = $result_book->num_rows;
                                                  if($num_results_book!=0)
                                                  {

                                                      for ($srs=0; $srs<$num_results_book; $srs++)
                                                      {
                                                          $row_book = mysqli_fetch_assoc($result_book);

                                                          $date_delivery=date_step($row_book["date_paid"],$row_book["delivery_day"]);

                                                          $date_graf2  = explode("-",$date_delivery);


                                                          //узнаем единицу измерения на складе
                                                          $result_t1_1=mysql_time_query($link,'SELECT b.units FROM z_stock as b WHERE b.id="'.$row_book["id_stock"].'"');

                                                          $num_results_t1_1 = $result_t1_1->num_rows;
                                                          if($num_results_t1_1!=0)
                                                          {
                                                              //такая работа есть
                                                              $row1ss_1 = mysqli_fetch_assoc($result_t1_1);
                                                          }


                                                          //подсвечиваем красным за 2 дня до доставки
                                                          $date_delivery1=date_step($row_book["date_paid"],($row_book["delivery_day"]-2));


                                                          $style_book='';
                                                          if(dateDiff_1(date("y-m-d").' '.date("H:i:s"),$date_delivery1.' 00:00:00')>=0)
                                                          {
                                                              $style_book='reddecision1';
                                                          }


                                                          echo'<span class="dop_status_app '.$style_book.'">'.$row_book["count_material"].' '.$row1ss_1["units"].' ~ до '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</span><br>';
                                                      }
                                                  }



                                              }
                                          }
                                      }


                                      echo'</div>

</div>';
                                      $i++;
                                  }

                                  if($i>1)
                                  {
                                      //вывод итога
                                      echo'<div class="line_brock"><div class="count_brock" style="color: #01a5fe;">Всего</div><div class="count_brock" style="color:#01a5fe">' . rtrim(rtrim(number_format($count_m, 2, '.', ' '),'0'),'.') . '<b>' . $row_t3["units"] . '</b></div>
<div class="count_brock"></div>

</div>';
                                  }
                              }
                              echo'</div>';
                              echo '</span>';
                          }


                      }


echo'</td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row_t3["price"], 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row_t3["subtotal"], 2, '.', ' '),'0'),'.').'</span></td>';
if($row_t3["count_units"]!=0)
{
echo'<td><span class="s_j" data-tooltip="'.ceil($row_t3["count_realiz"]*100/$row_t3["count_units"]).'%">'.mor_class(($row_t3["count_units"]-$row_t3["count_realiz"]),rtrim(rtrim(number_format($row_t3["count_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td>';
} else
{
echo'<td><span class="s_j" data-tooltip="0%">'.mor_class(($row_t3["count_units"]-$row_t3["count_realiz"]),rtrim(rtrim(number_format($row_t3["count_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td>';	
}

	if(array_search('summa_r2_realiz',$stack_td) === false) 
	{					  
echo'<td><span class="s_j">'.mor_class(($row_t3["subtotal"]-$row_t3["summa_realiz"]),rtrim(rtrim(number_format($row_t3["summa_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td>
<td><strong><span class="s_j">'.mor_class(($row_t3["subtotal"]-$row_t3["summa_realiz"]),rtrim(rtrim(number_format(($row_t3["subtotal"]-$row_t3["summa_realiz"]), 2, '.', ' '),'0'),'.'),1).'</span></strong></td>';
	}
           echo'</tr>';      
				  }
				}
				
				
				
				
			      }
				  
				  //вывод итогов по разделу
				  /*
				  echo'<tr class="itog_1">
           
           <td colspan="2" class="no_padding_left_ pre-wrap name_m">Итого работа:</td>
<td class="pre-wrap"></td>
<td></td>
<td></td>
<td></td>
<td>'.rtrim(rtrim(number_format($row_t["summa_r1"], 2, '.', ' '),'0'),'.').'</td>
<td></td>
<td></td>
<td></td>
           </tr>';  
			*/	  
				  
				  
				  echo'</tbody></table>';
	if(array_search('summa_r1',$stack_td) === false) 
	{	
				  echo'<div class="itog">Итого работа<i><span class="s_j">'.rtrim(rtrim(number_format($row_t["summa_r1"], 2, '.', ' '),'0'),'.').'</span></i></div>';
				  echo'<div class="itog">Итого материал<i><span class="s_j">'.rtrim(rtrim(number_format($row_t["summa_m1"], 2, '.', ' '),'0'),'.').'</span></i></div>';
				  echo'<div class="itog">Итого по разделу: "'.$row_t["name1"].'"<i><span class="s_j">в т.ч. НДС 20% - '.rtrim(rtrim(number_format((($row_t["summa_m1"]+$row_t["summa_r1"])/1.20*0.20), 2, '.', ' '),'0'),'.').' / '.rtrim(rtrim(number_format(($row_t["summa_m1"]+$row_t["summa_r1"]), 2, '.', ' '),'0'),'.').'</span></i></div>';
	}
				  
				  echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_'.$i.'").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';
                  
	            }
	
	
	
                echo'</div></div>';  
				
			 }
							 
			 }
		   
		   echo'<input type=hidden id="frezezz" name="frezz" value="'.$i.'">';
		   
		   
		   
	   }
  
    

	if(array_search('total_r0',$stack_td) === false) 
	{
	
    echo'<div class="block_is"><div class="top_bl"><h2>всего по смете</h2><div class="summs"><span class="s_j">'.rtrim(rtrim(number_format(($row_list["total_r0"]+$row_list["total_m0"]), 2, '.', ' '),'0'),'.').'</span></div></div>
    <div>
    
    </div>
    </div>';

    echo'<div class="block_is"><div class="top_bl"><h2>в т. ч. НДС 20%</h2><div class="summs"><span class="s_j">'.rtrim(rtrim(number_format((($row_list["total_r0"]+$row_list["total_m0"])/1.20*0.20), 2, '.', ' '),'0'),'.').'</span></div></div>
    <div>
    
    </div>
    </div>';	
	} 
	if((array_search('object_area',$stack_td) === false)and($row_list["object_area"]!=0)) 
	{
    echo'<div class="block_is"><div class="top_bl"><h2>Стоимость 1 м2</h2><div class="summs"><span class="s_j">'.rtrim(rtrim(number_format((($row_list["total_r0"]+$row_list["total_m0"])/$row_list["object_area"]), 2, '.', ' '),'0'),'.').'</span></div></div>
    <div>
    
    </div>
    </div>';		
	}
	
	//echo($_COOKIE[$b_co."_".htmlspecialchars(trim($_GET['id']))]);
    ?>
    </div>
  </div>

</div>

<?
include_once $url_system.'template/left.php';
?>
</div></div></div>
</div>
</div><script src="Js/rem.js" type="text/javascript"></script>
<?
if(isset($_GET["add"]))
{
echo'<script type="text/javascript">var b_co=\''.$b_co.'\'</script>';
} else{
	if(isset($_GET["add_a"]))
{
	echo'<script type="text/javascript">var b_co=\''.$b_co.'\'</script>';
} else
{
	echo'<script type="text/javascript">var b_co=\''.$b_co.'\'</script>';
	echo'<script type="text/javascript">var b_cm=\''.$b_cm.'\'</script>';
}
}
	?>
<div id="nprogress"><div class="bar" role="bar" ><div class="peg"></div></div></div>

</body></html>