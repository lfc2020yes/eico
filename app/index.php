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


$active_menu='app';  // в каком меню



$count_write=20;  //количество выводимых записей на одной странице

$edit_price=0;
if ($role->is_column_edit('n_material','price'))
{
	$edit_price=1;
}

$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

//index.php не должно быть в $url_404
if (strripos($url_404, 'index.php') !== false) {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
}

			if (($role->permission('Заявки','R'))or($sign_admin==1)or($role->permission('Заявки','S')))
	        {
			} else
			{
			           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	
			}


if (( count($_GET) == 1 )or( count($_GET) == 0 )or( count($_GET) == 2 )) //--Åñëè áûëè ïðèíÿòû äàííûå èç HTML-ôîðìû
{

 if(( count($_GET) == 1 )and(isset($_GET["n_st"])))
 {
       //на главной по страничкам
         $result_url=mysql_time_query($link,'select a.id from z_doc as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user="'.$id_user.'"'.limitPage('n_st',$count_write));
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} 
 } else
 {

 }
	
	

	
} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}

if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}

$menu_no_my=0;
$subor_cc = array();
//если у него нет своих заявок то выводить только задания и выполненные
include_once '../ilib/lib_interstroi.php';
include_once '../ilib/lib_edo.php';

$edo = new EDO($link,$id_user,false);
$arr_document = $edo->my_documents(0, 0 );
// echo count($arr_document) ;
//array_push($subor_cc,count($arr_document));

    if (count($arr_document) == 0) {
        if(!isset($_GET["tabs"])) {
            header("Location:" . $base_usr . "/app/.tabs-1");
        }
        array_push($subor_cc,0);
    } else
    {
        $menu_no_my = count($arr_document);
        array_push($subor_cc,count($arr_document));
    }

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы

include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('app','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php'; include $url_system.'template/head.php';
?>
</head><body><div class="alert_wrapper"><div class="div-box"></div></div><div class="container">
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
//echo(mktime());

/*
        $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}
*/
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

	  include_once $url_system.'template/top_prime_app.php';
echo'<div id="fullpage" class="margin_60  input-block-2020 ">
    <div class="oka_block_2019" style="min-height:auto;">
 <div class="oka_block">
<div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">';
/*
echo'<span class="h3-f">Ваши заявки</span>';

echo'<span class="h3-f">Документы <span class="pol-card" >(Необходимо выполнить)</span></span>';

echo'<span class="h3-f">Документы <span class="pol-card" >(Выполненные вами)</span></span>';
*/
    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?
  $sql_mass = array();
$sql_mass=$arr_document;
  //необходимо выполнить
  if((isset($_GET["tabs"]))and($_GET["tabs"]==1))
  {
      $arr_tasks = $edo->my_tasks(0, '=0','ORDER BY d.date_create DESC',limitPage('n_st',$count_write) );
      $sql_mass=$arr_tasks;
  }

  //уже как то выполнено
  if((isset($_GET["tabs"]))and($_GET["tabs"]==2))
  {
      $arr_tasks = $edo->my_tasks(0, '>0','ORDER BY d.date_create DESC',limitPage('n_st',$count_write));
      $sql_mass=$arr_tasks;
  }

  if(!isset($_GET["tabs"]))
  {
      $arr_document = $edo->my_documents(0, 0 ,false, limitPage('n_st',$count_write));
      $sql_mass=$arr_document;
  }

 // echo '<pre>arr_document:'.print_r($sql_mass,true) .'</pre>';

  echo '<div class="ring_block ring-block-line js-global-preorders-link">';
  $small_block=1;
  foreach ($sql_mass as $key => $value)
  {
      $new_pre = 1;
      $task_cloud_block='';



      include $url_system . 'app/code/block_app.php';
      echo($task_cloud_block);

  }
  if(count($sql_mass)==0)
  {
      echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Заявок в данном разделе пока нет.</span></span></div>';
  }

  $count_pages=ceil($subor_cc[$mym]/$count_write);

  if($count_pages>1)
  {
      if(isset($_GET["tabs"]))
      {
          displayPageLink_new('app/.tabs-'.$_GET["tabs"].'','app/.tabs-'.$_GET["tabs"].'.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
      } else
      {
          displayPageLink_new('app/','app/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
      }

  }

  echo'</div>';





//echo'<span class="hh1" style=" margin-bottom:0px;">Наряды</span>';

	
	//echo'</div><div class="content_block block_primes1">';  
	  
	//echo'</div>';
	
	//echo'<div class="content_block1">';	
/*
<div class="close_all_r">закрыть все</div>
<div data-tooltip="Удалить всю себестоимость" class="del_seb"></div>
<div data-tooltip="Добавить раздел" class="add_seb"></div>
';
*/

	
    ?>
    </div>
  </div>

</div>

<?
include_once $url_system.'template/left.php';
?>
</div></div></div></div>
</div>
</div><script src="Js/rem.js" type="text/javascript"></script>

<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
</div>

</body></html>