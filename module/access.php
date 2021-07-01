<?
//переход на вход в систему при отсутствии сессиии

   if(!isset($_SESSION['user_id']))
   {
	    
		header("Location: /login/?next=".base64_encode("https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']));
   
   } else
{     
     //
     //mysqli_query($link,'CALL set_user('.$id_user.')');
     
     include_once $url_system.'ilib/lib_interstroi.php'; 
	 $id_user=id_key_crypt_encrypt(htmlspecialchars(trim($_SESSION['user_id'])));
		$auth_key_query = mysql_time_query($link,"SELECT id,name_user FROM r_user WHERE id='".safe_var($id_user)."'");
		$num_results = $auth_key_query->num_rows;
        if($num_results!=0)
        {	       
$row_town_user = mysqli_fetch_assoc($auth_key_query);
$name_user=$row_town_user['name_user'];
        }     
$role=new RoleUser($link,$id_user);  //создаем класс прав
}
   

//создание секрет для формы
$secret=rand_string_string(16);
//echo($secret);
if(!isset($_SESSION['rema']))
{
    $_SESSION['rema'] = $secret;
} else
{
    $secret=$_SESSION['rema'];
}


   
?>