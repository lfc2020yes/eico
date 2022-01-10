<?
//бухгалтерия
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



$menu_b=array("Необработанные","История");
	
$menu_title=array("Необработанные накладные","История накладных");
	/*
$menu_get=array("","old");
$menu_url=array("","old/");
$menu_role_sign0=array(1,1);
$menu_role_sign012=array(1,1);	
$menu_sql=array();
$menu_sql1=array();	

//к оплате
 array_push($menu_sql, 'Select count(DISTINCT b.id) as kol from z_invoice as b where b.status=1');	

 array_push($menu_sql1, '  b.status=1');	

//оплаченные счета
 array_push($menu_sql, 'Select count(DISTINCT b.id) as kol from z_invoice as b ');		
 array_push($menu_sql1, ' ');	


$var_get='by';	

*/

$active_menu='invoices_1c';  // в каком меню


$count_write=20;  //количество выводимых записей на одной странице
$edit_price=1;



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



if((($role->permission('Накладные_1с','R')))or($sign_admin==1)){} else
{
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	
}


if (( count($_GET) == 1 )or( count($_GET) == 0 )or( count($_GET) == 2 )) //--Åñëè áûëè ïðèíÿòû äàííûå èç HTML-ôîðìû
{
    /*
 if(( count($_GET) == 1 )and(isset($_GET["by"])))
 {
   //не на главной в побочных страницах
   
   $found1 = array_search($_GET["by"],$menu_get);   
   if($found1 === false)
   {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	   
   } 
	 
 } else
 {
 if(( count($_GET) == 2 )and(isset($_GET["by"]))and(isset($_GET["n_st"])))
 {	 
	 
	 //проверить может ли он туда заходить и есть ли такая страница
	    $found1 = array_search($_GET["by"],$menu_get);   
   if($found1 === false)
   {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	   
   } else
   {
	 
   //можно ли этому пользователю смотреть эти побочные страницы
	 
	     //есть ли такая страница
	   
	    if(($_GET["by"]=='old'))
		{
	    $result_url=mysql_time_query($link,'select b.id from z_invoice as b where '.$menu_sql1[$found1].' '.limitPage('n_st',$count_write));
			
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} 
		}

	   
	   
	   
  
   }
	 
	 
 } else
 {
	 if((isset($_GET["n_st"]))and(count($_GET)==1))
	 {
		 

	    $result_url=mysql_time_query($link,'select b.id from z_invoice as b where '.$menu_sql1[0].' '.limitPage('n_st',$count_write));
			
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} 
		 
		 
	 } else
	 {
	 
	 if(count($_GET) == 0)
	 {
	 } else
	 {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
	 }
	 }
 }
 }
 
*/

	
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


$subor_cc = array();
//невыполненные

$subor_cc[0]=0;
$result_uu = mysql_time_query($link, 'Select count(DISTINCT b.id) as kol from z_invoice as b where b.status=1 and b.id_user="'.ht($id_user).'"');
$num_results_uu = $result_uu->num_rows;

if ($num_results_uu != 0) {
    $row_uu = mysqli_fetch_assoc($result_uu);
    $subor_cc[0]=$row_uu["kol"];
}

$subor_cc[1]=0;
$result_uu = mysql_time_query($link, 'Select count(DISTINCT b.id) as kol from z_invoice as b where not(b.status=1) and b.id_user="'.ht($id_user).'"');
$num_results_uu = $result_uu->num_rows;

if ($num_results_uu != 0) {
    $row_uu = mysqli_fetch_assoc($result_uu);
    $subor_cc[1]=$row_uu["kol"];
}


/*
if(!isset($_GET['tabs'])) {
    if ($subor_cc[0] == 0) {

            header("Location:" . $base_usr . "/invoices_1с/.tabs-2");


    }
}
*/


//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы

include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('invoices','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_invoices_1c.php';

echo'<div id="fullpage" class="margin_60  input-block-2020 ">
    <div class="oka_block_2019" style="min-height:auto;">
 <div class="oka_block">
<div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">';



    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?



  
	  
	  	//echo'</didv>';  
  if((isset($_GET["tabs"]))and($_GET["tabs"]==2))
  {
      //история
  $result_t2=mysql_time_query($link,'Select DISTINCT b.* from z_invoice as b where not(b.status=1) and b.id_user="'.$id_user.'" order by b.date_create desc '.limitPage('n_st',$count_write));
      $count=$subor_cc[1];
      $title_key=1;
} else
{
    //это необработанные

    include_once '../ilib/lib_import.php';


    $csv = new CSV($link, $id_user);
    $mask = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/*.csv';
    $mask_attach = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/1c_attach/';
    $arFiles = $csv->read_dir ($mask,$mask_attach);
    //echo(count($arFiles));

    //echo "<pre> ФАЙЛЫ [$mask]: ".print_r($arFiles,true)."</pre>";
    /*echo'<br>';
    echo base64_encode($arFiles[0]['file']);
    */
/*
  $result_t2=mysql_time_query($link,'Select DISTINCT b.* from z_invoice as b where b.id_user="'.$id_user.'" and b.status=1 order by b.date_create desc  '.limitPage('n_st',$count_write));
*/
    $count=count($arFiles);
    $title_key=0;
}
   //запрос для определения общего количества = 
	  /*
   $sql_count='select count(a.id) as kol from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).')';
*/


echo' <h3 class="head_h" style=" margin-bottom:0px;">'.$menu_title[$title_key].'<i>'.$count.'</i><div></div></h3> ';


if(($title_key==0)and($count!=0))
{
/*
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
*/
    echo'<div class="ring_block ring-block-line js-global-1c-link">';


    foreach ($arFiles as $key => $value)
    {
       foreach ($value['data'] as $key1 => $value1)
    {


        $date_mass = explode(" ", ht($value1["Дата"]));
        $date_mass1 = explode(":", $date_mass[1]);

        $date_start = $date_mass[0] . ' ' . $date_mass1[0] . ':' . $date_mass1[1];

        $str =$value["file"];
       // $str = iconv("utf-8", "windows-1251", $value["file"]); /* Преобразование кодировки */

        // Возвращает строку, в которой все не алфавитно-числовые символы (кроме -_.) заменены на знак процентов (%) с последующими двумя 16-ричными цифрами и пробелами, кодированными как знаки плюс (+)

        //$str= urlencode(htmlspecialchars($str));
        echo($value["file"].'<br>');
$str=rawurlencode($str);
echo($str);
        //$str1 = iconv("utf-8", "windows-1251", $str1); /* Преобразование кодировки */
//echo($str1);

        echo'<div class="c_block_global " id_pre="13">
<span class="js-update-block-1c">




<div class="trips-b-number"><div style="width: 100%;">&nbsp;</div></div>
	<div class="trips-b-info"><span class="label-task-gg ">Номер/Дата 
</span><a style="display:block;" href="invoices_1c/index_view.php?id='.$str.'"><span class="spans ggh-e name-blue"><span>Накладная №'.$value1["Номер"].'</span></span></a><div id_status="9" class="status_admin js-status-preorders s_pr_2 ">не обработана</div><div class="pass_wh_trips" style="margin-top: 10px;"><label>Дата создания</label><div class="obi">'.$date_start .'</div></div></div><div class="trips-b-user"><span class="label-task-gg ">Контрагент
</span><div class="pass_wh_trips" style="margin-bottom: 5px;"><span class="kuda-trips">'.$value1["НаименованиеПолноеКонтрагента"].'</span></div>
<div class="pass_wh_trips"><label>Склад</label><div class="obi">'.$value1["Склад"].'</div></div>
</div><div class="trips-b-comment"><span class="label-task-gg ">Ответственный
</span>
<div class="pass_wh_trips"><span class="kuda-trips">'.$value1["Ответственный"].'</span></div></div>

</span></div>';



        break;
    }
        //echo('<br>');

    }


    echo'</div>';
    








					  
					  
				
					  


 } else
                  {
                      echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Необработанных накладных в разделе пока нет.</span></span></div>';

                  }
	  
?>


        
  <?       

	
    ?>
    </div>
  </div>

</div>
</div></div></div></div>
<?
include_once $url_system.'template/left.php';
?>

</div>
</div><script src="Js/rem.js" type="text/javascript"></script>

<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
</div>

</body></html>