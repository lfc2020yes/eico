<?php
//отправка сообщения пользователю

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$text=htmlspecialchars($_GET['text']);
$token=htmlspecialchars($_GET['tk']);



if(token_access_new($token,'new_message_users',$id,"s_form"))
{




  if(((isset($_GET['id']))and(is_numeric($_GET['id']))))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
		  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		$result_t1=mysql_time_query($link,'Select a.id from r_user as a where a.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
		  
		  
$status_ee='ok';

//добавляем новое сообщение 								 
mysql_time_query($link,'INSERT INTO r_message (id,id_user,message,status,id_sign,datesend) VALUES ("","'.htmlspecialchars(trim($id)).'","'.htmlspecialchars(trim($text)).'","1","'.htmlspecialchars(trim($id_user)).'","'.date("y.m.d").' '.date("H:i:s").'")');

//Если это письмо админу то отсылаем на почту уведомление
   $result_t56=mysql_time_query($link,'Select a.id,a.name_user,a.email from r_user as a,r_role as b where a.id_role=b.id and b.name_role="admin" and a.id="'.htmlspecialchars(trim($id)).'"');
         $num_results_t56 = $result_t56->num_rows;
	     if($num_results_t56!=0)
	     {	
			 
			 
		   $row_t56 = mysqli_fetch_assoc($result_t56); 		
		   
		   include $url_system.'module/config_mail.php';

							 
     $text_mail="<HTML>\r\n";
     $text_mail.="<HEAD>\r\n";
     $text_mail.="<META http-equiv=Content-Type content='html; charset=utf-8'>\r\n";
     $text_mail.="</HEAD>\r\n";
     $text_mail.="<BODY>\r\n";


$text_mail.="<br><span style=\"color: #66757f; font-family: 'Helvetica Neue Light',Helvetica,Arial,sans-serif; font-size: 16px; font-weight: 300;\">Помощь по сайту - ИНТЕР-СТРОЙ</span><br><br>";


$text_mail.='<div style=" width:100%; height:1px; border-top:1px solid #e1e8ed;"></div>';

$text_mail.="<br><span style=\" color: #292f33; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 24px; font-weight: 300; line-height: 30px; margin: 0; padding: 0; text-align: left;\">Только что поступило новое сообщение администратору системы со следующими данными:</span><br><br>
<span style=\"color: #292f33;
    font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 16px;
    font-weight: 400;
    line-height: 22px;
    margin: 0;
    padding: 0;
    text-align: left;\">".htmlspecialchars(trim($text))."<br>";


$text_mail.="</span><br><br>
<span style=\"color: #292f33;
    font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 16px;
    font-weight: 400;
    line-height: 22px;
    margin: 0;
    padding: 0;
    text-align: left;\">Просим вас отреагировать на это уведомление</span>\r\n";



     $text_mail.="</BODY>\r\n";
     $text_mail.="</HTML>";

     //mail($_POST["login"],"www.ulmenu.ru: Подтверждение регистрации",$text,$header);
     // /отправка письма на почту
			 
	 //находим email администратора		 
			 
	 

     SMTP_MAIL($mail_ulmenu,'password',"Помощь по сайту ООО ИНТЕР-СТРОЙ",$text_mail,$row_t56[email].'||Администратору системы');
								 
	 
			 
			 
		 }
		   
//добавляем в диалоги 
dialog($id,$id_user,$link);  

		   
//изменяем код уведомлений чтобы пользователь увидел об этом сообщении
$noti_key=new_key($link,10);
mysql_time_query($link,'update r_user set noti_key="'.$noti_key.'" where id = "'.htmlspecialchars(trim($id)).'"'); 
		   
							  



//$echo.='Раздел '.$number.'. '.$text; 



	  }
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

 //}
//}
}


$aRes = array("debug"=>$debug,"status"   => $status_ee);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>