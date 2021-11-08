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


$active_menu='index';


//проверим можно редактировать или нет цены в наряде
$edit_price=0;
if ($role->is_column_edit('n_material','price'))
{
	$edit_price=1;
}


//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

//index.php не должно быть в $url_404
if (strripos($url_404, 'new_index.php') !== false) {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
}

if(( count($_GET)!= 0 )and( count($_GET)!= 1 ))
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

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы




include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('finery','','','',$link); } else { SEO('0','','','',$link); }

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
    echo'<div class="iss small">';
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
    <?
    include_once $url_system.'template/left.php';
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

	  include_once $url_system.'template/top_index.php';


echo'<div id="fullpage" class="" id_content="'.$id_user.'">';
?>
      <div class="section" id="section0">
          <div class="oka_block">


<?
              echo'<div class="oka1 task-left js-task-left" style="width:100%; padding-top: 60px;">	';

$count_task=0;

if((count($arr_index_1)!=0)or(count($arr_index_2)!=0)or(count($arr_index_3)!=0)or(count($arr_index_4)!=0))
{
    $count_task=1;
}




                  //echo'<h2>Добро пожаловать в систему заявок, '.$rowxs["name_user"].'!</h2>';

                  if((isset($_GET["a"]))and($_GET["a"]=='yes'))
                  {

                  $result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.$id_user.'"');
                    if($result_txs->num_rows!=0)
                    {
                      $rowxs = mysqli_fetch_assoc($result_txs);
                    }
                  echo'<h2 class="hello">Добро пожаловать в систему CCM, '.$rowxs["name_user"].'!</h2>';

                  echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Не забудьте посмотреть все созданные для вас задачи. Все самое важное всегда в ваших уведомлениях.</span></span></div>';
                  } else
                  {

                  if($count_task!=0)
                  {
                  //echo'<p>У вас есть нерешенные задачи. Не забудьте посмотреть и исполнить их. Следите за уведомлениями системы, вашей комиссией и бонусами.</p>';

                  echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>У вас есть нерешенные задачи. Не забудьте посмотреть и исполнить их. Следите за уведомлениями системы.</span></span></div>';

                  } else
                  {
                  echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Один сервис
для всей нашей строительной команды</span></span></div>';
                  }
                  }

//наряды
if(((count($arr_index_1)!=0))and(($role->permission('Наряды','R'))or($sign_admin==1)or($role->permission('Наряды','S'))))
{
    $small_block=1;
    $_GET["tabs"]=0;
    
    
    echo '<div class="hello-h">Ваши Задачи по нарядам →</div>';
    
    foreach ($arr_index_1 as $key => $value)
    {
        $new_pre = 1;
        $task_cloud_block='';

        include $url_system . 'worder/code/block_worder.php';
        echo($task_cloud_block);

    }
}
//заявки
if(((count($arr_index_2)!=0))and(($role->permission('Заявки','R'))or($sign_admin==1)or($role->permission('Заявки','S'))))
{
    $small_block=1;
    $_GET["tabs"]=0;


    echo '<div class="hello-h">Ваши Задачи по заявкам →</div>';

    foreach ($arr_index_2 as $key => $value)
    {
        $new_pre = 1;
        $task_cloud_block='';

        include $url_system . 'app/code/block_app.php';
        echo($task_cloud_block);

    }
}

//счета
if(((count($arr_index_3)!=0))and(($role->permission('Счета','R'))or($sign_admin==1)or($role->permission('Счета','S'))))
{
    $small_block=1;
    $_GET["tabs"]=0;


    echo '<div class="hello-h">Ваши Задачи по счетам →</div>';

    foreach ($arr_index_3 as $key => $value)
    {
        $new_pre = 1;
        $task_cloud_block='';

        include $url_system . 'acc/code/block_app.php';
        echo($task_cloud_block);

    }
}

//договора
if(((count($arr_index_4)!=0))and(($role->permission('Договора','R'))or($sign_admin==1)or($role->permission('Договора','S'))))
{
    $small_block=1;
    $_GET["tabs"]=0;


    echo '<div class="hello-h">Ваши Задачи по счетам →</div>';

    foreach ($arr_index_4 as $key => $value)
    {
        $new_pre = 1;
        $task_cloud_block='';

        include $url_system . 'docs/code/block_app.php';
        echo($task_cloud_block);

    }
}

?></div> </div> </div>
    </div>
  </div>

</div>



</div>
</div><script src="Js/rem.js" type="text/javascript"></script>

<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
</div>

</body></html>
