<?php
session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
require_once $url_system.'module/config.php';
require_once $url_system.'module/function.php';
require_once $url_system.'login/function_users.php';
require_once $url_system.'aktpp/lib.php';
initiate($link);
require_once $url_system.'module/access.php';


//правам к просмотру к действиям
$hie = new hierarchy($link,$id_user);
$role->GetColumns();
$role->GetRows();
$role->GetPermission();

$active_menu='aktpp';  // в каком меню

$err=0;
$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);

$D_404 = explode('/', $url_404);

//index.php не должно быть в $url_404
if (strripos($url_404, 'index.php') !== false) {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
               $err=3;
}

if (( count($_GET) == 1 )or( count($_GET) == 0 )or( count($_GET) == 2 )) {
    if ( ! ($role->permission('Прием-Передача','R'))or($sign_admin==1))  {
       header("HTTP/1.1 404 Not Found");    //нет прав
       header("Status: 404 Not Found");
       $error_header=404;
       $err=1;
    }


} else  {                       //count($_GET)>2
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
   $err=2;
}

if($error_header==404)
{
    echo "<p>err=$err";
    echo "<p> $url_404";
    include $url_system.'module/error404.php';

    die();
}

//проверка адреса сайта на существование такой страницы

include_once $url_system.'template/html.php';
include $url_system.'module/seo.php';

if($error_header!=404)
         { SEO('aktpp','','','',$link); }
    else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php';
include $url_system.'template/head.php';
?>
<link rel="stylesheet" type="text/css" href="aktpp/index.css" />
</head><body><div class="container">

<?php
if ( isset($_COOKIE["iss"]))
{
    if($_COOKIE["iss"]=='s'){
        echo'<div class="iss small">';
    } else {
        echo'<div class="iss big">';
    }
} else {
    echo'<div class="iss">';
}
//echo(mktime());
$act_='display:none;';
$act_1='';
if(cookie_work('it_','on','.',60,'0')){
    $act_='';
    $act_1='on="show"';
}

$id_visor=$id_user;
if($role->permission('Прием-Передача','S'))   {   //  [S] !!!!
    $visor=ReadCookie('visor'.$id_user);
    if (count($visor)>0 and $visor[0]>0) $id_visor=$visor[0];
}
?>
    <div class="left_block">
        <div class="content">
            <div id="page_aktpp"></div>
        </div>
<?php 
include_once $url_system."aktpp/index_js.php";
include_once $url_system.'template/left.php'; 
?>        
    </div>
</div>

<script src="Js/rem.js" type="text/javascript"></script>
<div id="nprogress">
    <div class="bar" role="bar" >
        <div class="peg"></div>
    </div>
</div>
</body></html>
