<?php
include_once '../Ajax/master/master_connect.php';

  $base=new Thost2;
  
//---------------------------------------------1. Проверка переменной DB
  if ( ! (array_key_exists('DB', $_GET) && $_GET['DB']<count($base->H)))   //Настройка на базу
  {
    //headerrrr( "HTTP/1.0 401 Unauthorized");
    // нарисовать таблицу
   ?>
   <script type="text/javascript">
   console.log("DB=<?=$_GET['DB']?>");
   </script>
   <?php
?>
<html>


<div id="main">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/style/tree.css" />
<form action=<? echo ($_SERVER['HTTP_REFERER']); ?> method="post" class="theform">
<table class="theform" align="center" border="1" bgcolor="white">
<caption ><div style="padding:3px;" align="left">Выбрать Хост базы данных <a href=/PHPinfo> <?=php_sapi_name()?></a></div></caption>
 <tr>    <th>№
         <th>Хост BASE
         <th>IP хоста
         <th>база данных
<!--     <th>пользователь
         <th>пароль       -->
         <th>коментарии
         <th>Хост сайта
         <th>IP сайта

 <tr>
<?php
   for ($i=0,$n=0; $i<count($base->H);$i++)
   {
     if ($base->H[$i][0]>'')
     { $num=++$n; $IP=gethostbyname($base->H[$i][0]); $IPB=gethostbyname($base->H[$i][5]);
         echo '<tr><td>'.$num
   	         .'<td>'.$base->H[$i][0]
   	         .'<td>'.$IP
   	         .'<td><u><a href=?DB='.$i.$base->H[$i][6].'>'.$base->H[$i][1].'</a></u>'
   	       //  .'<td>'.$base->H[2][$i]
   	       //  .'<td>'.$base->H[3][$i]
   	         .'<td>'.$base->H[$i][4]
   	         .'<td>'.$base->H[$i][5]
   	         .'<td>'.$IPB
   	         ;
     }
     else
     { $num='';  $IP=''; $IPB='';
       echo '<tr><td bgcolor="lightsteelblue" colspan=7 align="center">'.$base->H[$i][4];
     }
   }
?>
</table>
</form>
</div>


<?php
    if (count($base->H)==1)            //     REQUEST_URI HTTP_REFERER   'http://'.$base->H[0]][5]
    {
?>
  <SCRIPT>
  someTimeout = 000; <!-- редирект через 1 секунды   1000-->
  window.setTimeout("document.location = '<?=$_SERVER['HTTP_REFERER'].'?DB=0'.$base->H[0][6]?>';", someTimeout);
  </SCRIPT>
<?php
    }
    exit();
  }



	  if (array_key_exists('DB', $_GET) && $_GET['DB']<count($base->H))    // указатель на хост определен
	  {
	      $HBS=$_GET['DB'];
	      LHBase($HBS);
	      $LOCATION="[ ".$base->H[$HBS][1]." ".$base->H[$HBS][4]." ]";
	  }
	  else
	  {         Header ("WWW-Authenticate: Basic realm=\"ERROR\"");
		        Header ("HTTP/1.0 401 Unauthorized");
		        exit();
	  }

	  if (strpos($_SERVER['REQUEST_URI'], "sysadmin") == false )            // Изменен каталог
	  {
			Header ("WWW-Authenticate: Basic realm=\"".$LOCATION."\"");
	        Header ("HTTP/1.0 401 Unauthorized");
	        exit();
	  }

  $authenticated=false;

  //if (1==0)
  if (php_sapi_name()=='cgi')      //=============================================
  {

            //echo("authenticated");
			if(isset($_GET['authorization']))
			{
			    if(preg_match('/^Basic\s+(.*)$/i', $_GET['authorization'], $user_pass))
			    {
			        list($user,$pass)=explode(':',base64_decode($user_pass[1]));
			        // Проверка корректности введенных реквизитов доступа
			        $_SERVER['PHP_AUTH_USER'] = mysql_escape_string($user);    //искуственное получение переменных
                    $_SERVER['PHP_AUTH_PW'] = mysql_escape_string($pass);
                    $authenticated=true;
			    }
			}
            /*
			if($authenticated)
			{
			    // Авторизация успешно пройдена
			    echo("user: ".$user."<br>pass: ".$pass);
			} */
			else
			{
			    header('WWW-Authenticate: Basic realm="Restricted Area"');
			    header('HTTP/1.1 401 Unauthorized');
			    //echo("user: ".$user."<br>pass: ".$pass);
			    echo("user: ".$_SERVER['PHP_AUTH_USER']."<br>pass: ".$_SERVER['PHP_AUTH_PW']);
			    ?>
  <SCRIPT>
  someTimeout = 9000; <!-- редирект через 1 секунды   1000-->
  window.setTimeout("document.location = '<?=$_SERVER['HTTP_REFERER']?>';", someTimeout);
  </SCRIPT>
<?php
			    exit("0. CGI Access denied.");
			}
  }
  else       //----------------------------------------Метод апач

      if (!isset($_SERVER['PHP_AUTH_USER']))
	  {    header( "HTTP/1.0 401 Unauthorized");       //$base[1][$HBS].' '.$base[4][$HBS]
	       //Header ("WWW-Authenticate: Basic realm=\"ENTER YOUR LOGIN & PASSWORD\"");

		   header( "WWW-Authenticate: Basic realm=\"".$LOCATION."\"");             //Окно Логин Пароль
           header( "HTTP/1.0 401 Unauthorized");

          //-----------------------------------Кнопка cancel
?>
  <SCRIPT>
  someTimeout = 9000; <!-- редирект через 1 секунды   1000-->
  window.setTimeout("document.location = '<?=$_SERVER['HTTP_REFERER']?>';", someTimeout);
  </SCRIPT>
<?php

          exit("1. Необходимо ввести правильные login и пароль для доступа к ресурсу ".$LOCATION.' '.count($base->H));
	  }
	  else
	  {
        //$user $pass

        if (!get_magic_quotes_gpc()) {
                //$_SERVER['PHP_AUTH_USER'] = mysql_escape_string($_SERVER['PHP_AUTH_USER']);
                //$_SERVER['PHP_AUTH_PW'] = mysql_escape_string($_SERVER['PHP_AUTH_PW']);

        }
        $authenticated=true;
      }

      if ($authenticated==false)
      {
      	   Header ("WWW-Authenticate: Basic realm=\"".$LOCATION."\"");
           Header ("HTTP/1.0 401 Unauthorized");
 ?>
  <SCRIPT>
  someTimeout = 3000; <!-- редирект через 1 секунды   1000-->
  window.setTimeout("document.location = '<?=$_SERVER['HTTP_REFERER']?>';", someTimeout);
  </SCRIPT>
<?php

          exit("2. неправильные login или пароль для доступа к ресурсу ".$LOCATION.' '.count($base->H));
      }

      {
        //echo("user: ".$_SERVER['PHP_AUTH_USER']."<br>pass: ".$_SERVER['PHP_AUTH_PW']);

        $query = "SELECT password,id_access FROM admin WHERE user='".htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']))."'";
        $lst = @mysql_query($query);

        if (!$lst)
        {
           Header ("WWW-Authenticate: Basic realm=\"".$LOCATION."\"");
           Header ("HTTP/1.0 401 Unauthorized");
           exit();
        }
        //echo '<p>2</p>';          ///
        if (mysql_num_rows($lst) == 0)
        {
           Header ("WWW-Authenticate: Basic realm=\"".$LOCATION."\"");
           Header ("HTTP/1.0 401 Unauthorized");
           exit();
        }
        //echo '<p>3</p>';          ///
        $pass =  @mysql_fetch_array($lst);
        if (md5($_SERVER['PHP_AUTH_PW'])!= $pass['password'])
        {
           Header ("WWW-Authenticate: Basic realm=\"".$LOCATION."\"");
           Header ("HTTP/1.0 401 Unauthorized");
           exit();
        }
        //echo '<p>4</p>';          ///
      }    //else   PHP_AUTH_USER

?>
<!-- login 1 -->
