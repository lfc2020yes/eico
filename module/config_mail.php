<?
$mail_admin='lfc2005@mail.ru';

$mail_ulmenu = array(
    'password' => array(
	    'smtp' =>false,
        'host'     => 'cf34.hc.ru',
        'login' => 'interstroi@atsun.ru',
        'password'  => 'inter12344321',
		'port' => 465,
		'auth' => true,
		'secure' => ''		
    )
);

include_once $url_system.'library/PHPMailer5.2/PHPMailerAutoload.php';


//SMTP_MAIL('password','Прочитай','Привет как дела?','joe@example.net||Сергей');

function SMTP_MAIL($mail_ulmenu,$email,$subject,$body,$komy)
{

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output
if($mail_ulmenu[$email]['smtp']==true)
{
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = $mail_ulmenu[$email]['host'];  // Specify main and backup SMTP servers
$mail->SMTPAuth = $mail_ulmenu[$email]['auth'];                               // Enable SMTP authentication
$mail->Username = $mail_ulmenu[$email]['login'];                 // SMTP username
$mail->Password = $mail_ulmenu[$email]['password'];                           // SMTP password
if($mail_ulmenu[$email]['secure']!='')
{
  $mail->SMTPSecure = $mail_ulmenu[$email]['secure'];       // Enable TLS encryption, `ssl` also accepted
}
$mail->Port = $mail_ulmenu[$email]['port'];         
}
                           // TCP port to connect to
$mail->CharSet = 'UTF-8';
$mail->setFrom($mail_ulmenu[$email]['login'], $mail_home);         //от кого
$addAddress = explode("||", $komy);

$mail->addAddress($addAddress[0], $addAddress[1]);     // кому
             // Name is optional
$mail->addReplyTo('lfc2005@mail.ru', 'Команда Интер-Строй');
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;  //заголовок
$mail->Body    = $body;  //текст письма


if(!$mail->send()) {
    return false;
} else {
    return true;
}
	
	
}


?>