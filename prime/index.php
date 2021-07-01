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
$active_menu='prime';
//проверить и перейти к последней себестоимости в которой был пользователь

if (( isset($_COOKIE["pr_"]))and(is_numeric($_COOKIE["pr_"])))
		{		
			//проверим вдруг эта себестоимость уже недоступна пользователю
			if(($sign_admin!=1)and(array_search($_COOKIE["pr_"],$hie_object)===false))
			{
			   //удалить этот кукки и перезагузить страницу
			   setcookie("pr_", "", time()-3600,"/", "eico.atsun.ru");
			   header("Location:".$base_usr."/prime/");	
			   die();	
				
			}
		    
			if (($role->permission('Себестоимость','R'))or($sign_admin==1))
	        {
				
			} else
			{
			   //удалить этот кукки и перезагузить страницу
			   setcookie("pr_", "", time()-3600,"/", "eico.atsun.ru");
			   header("Location:".$base_usr."/prime/");	
			   die();					
			}
			
			header("Location:".$base_usr."/prime/".$_COOKIE["pr_"].'/');	
			die();

		}


//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /news/23/
//     0   1  2  3




$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);


if ( count($_GET) == 0 ) //--Если были приняты данные из HTML-формы
{
			if (($role->permission('Себестоимость','R'))or($sign_admin==1))
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

//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы

include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('prime','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php'; include $url_system.'template/head.php';
?>
</head><body><div class="alert_wrapper"><div class="div-box"></div></div><div class="container">
<?

	
	 	   //эти столбцы видят только особые пользователи	
		   $count_rows=8;	
		   $stack_td = array();			
		   
	       
	       if($sign_admin!=1)
		   {   
			 //столбцы  выполнено на сумму - остаток по смете  
	         if ($role->is_column('i_object','total_r0',true,false)==false) 
		     { 
			  $count_rows=$count_rows-3;
			  array_push($stack_td, "total_r0"); 
		     } 
             //строка итого по работе, по материалам, по разделу
		     if ($role->is_column('i_object','total_r0_realiz',true,false)==false) 
		     { 
			    array_push($stack_td, "total_r0_realiz"); 
				$count_rows=$count_rows-2; 
		     } 	   
		   }


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

	  include_once $url_system.'template/top_prime_index.php';
?>

	            <div id="fullpage" class="margin_60  input-block-2020 ">
      <div class="section" id="section0">
          <div class="height_100vh">
              <div class="oka_block_2019">

                  <?
                  echo'<div class="line_mobile_blue">Себестоимость';
                 /*
                  $D = explode('.', $_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);

                  if(count($D)>0)
                  {
                      echo'<span all="8" class="menu-mobile-count">'.count($D).'</span>';
                  }
*/
                  echo'</div>';

                  ?>
      <div class="div_ook" style="border-bottom: 1px solid rgba(0,0,0,0.05);">

          <?






          //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо

     //  echo'<div class="info-suit">';


echo'<span class="h3-f">Себестоимость</span>';

          echo'<div class="content_block" id_content="'.$id_user.'">';
	?>

  <?

/*
echo'<h1 style=" margin-bottom:0px;">Себестоимость</h1>';
	  
	echo'</div>';
*/	
	//echo'<div class="content_block1">';	
/*
<div class="close_all_r">закрыть все</div>
<div data-tooltip="Удалить всю себестоимость" class="del_seb"></div>
<div data-tooltip="Добавить раздел" class="add_seb"></div>
';
*/
  
	  
	  	//echo'</div>';  
	

	
 
     echo'<div class="tabs-content" rel_uu="0">';

echo($echo);
   
   echo'</div>';
   
	  
	
	  
?>

    <script>
$(document).ready(function(){
		
	
	var tabs = $('#tabs2017');
		
	
    //$('.tabs-content > div.tb', tabs).each(function(i){ if ( i != 0 ) { $(this).hide(0); }});
   
	
	
	tabs.on('click', '.tab', function(e){
		
        /* Предотвращаем стандартную обработку клика по ссылке */
        e.preventDefault();

        /* Узнаем значения ID блока, который нужно отобразить */
        var tabId = $(this).children().attr('id');
		
        /* Удаляем все классы у якорей и ставим active текущей вкладке */
		$(this).closest('.tabs_hed').find('li').removeClass('active');
		$(this).closest('.tabs_hed').find('a').removeClass('active');
		
        
		$(this).children().addClass('active');
        $(this).addClass('active');
		
        /* Прячем содержимое всех вкладок и отображаем содержимое нажатой */
		//$(this).closest('[rel_tabs]').attr('rel_tabs');
        //$('.tabs-content > div.tb', tabs).hide(0);
        //$(tabId).show();
		$('.tabs-content[rel_uu='+$(this).closest('[rel_tabs]').attr('rel_tabs')+']').find('.tb').hide();
		$('.tabs-content[rel_uu='+$(this).closest('[rel_tabs]').attr('rel_tabs')+']').find('#tabs_0-'+tabId).show();
	
		 
		
		//alert($(this).position().left);
		$(".slider").css({left: $(this).position().left + "px",width: $(this).width()+"px"});

		
		$(".ripple").remove();
		
	  var posX = $(this).offset().left,
      posY = $(this).offset().top,
      buttonWidth = $(this).width(),
      buttonHeight = $(this).height();

 
  $(this).append("<span class='ripple'></span>"); if (buttonWidth >= buttonHeight) { buttonHeight = buttonWidth; } else { buttonWidth = buttonHeight; }
  var x = e.pageX - posX - buttonWidth / 2;
  var y = e.pageY - posY - buttonHeight / 2;
 
  $(".ripplepay").css({width: buttonWidth,height: buttonHeight,top: y + 'px',left: x + 'px'}).addClass("rippleEffect");
		
    });	
	
	 tabs.find('li.active').trigger('click');
	
	
	   });	

	</script>         
        
  <?       

	
    ?>
    </div>
  </div>

</div>


<?
include_once $url_system.'template/left.php';
?>
      </div></div></div></div></div></div>
</div>
</div><script src="Js/rem.js" type="text/javascript"></script>

<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
</div>

</body></html>