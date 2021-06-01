<?php //include $url_system.'php/seo/seo.php';
session_start();
$size_page = array(
    array(2,3,14,1),                  //portret   первая-одна первая средняя последняя
    array(1,3,10,6,)                   //landscape первая-одна первая средняя прследняя
);
$type_page=0;                        //portret

$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; 
include_once $url_system.'module/config.php'; 
include_once $url_system.'module/function.php'; 
include_once $url_system.'login/function_users.php';
initiate($link);
include_once $url_system.'module/access.php';


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


$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

//index.php не должно быть в $url_404
if (strripos($url_404, 'print_akt.php') !== false) {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
}

if (( count($_GET) == 1 )) 
{
 if(( count($_GET) == 1 )and(isset($_GET["id"])))
 {
       //на главной по страничкам
            $sqlA="select * from z_act a  
                left join (select id,name_user as name0,id_role as id_role0 from r_user) u0 on (a.id0_user=u0.id)
                left join (select id,name_user as name1,id_role as id_role1 from r_user) u1 on (a.id1_user=u1.id)
                where a.id='".htmlspecialchars(trim($_GET["id"]))."'";
        $result_url=mysql_time_query($link,$sqlA);
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0){
               header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
	} else {			
	    $row_list= mysqli_fetch_assoc($result_url);
			
			//узнаем организацию
	    $result_url1=mysql_time_query($link,'select a.* from i_company as a where a.id=1');
            $num_results_custom_url1 = $result_url1->num_rows;
            if($num_results_custom_url1!=0) {
                $row_list1= mysqli_fetch_assoc($result_url1);
                $result_url2=mysql_time_query($link,'select a.name_role from r_user as b,r_role as a where a.id=b.id_role and b.id="'.$row_list1["id_boss"].'"');
                $num_results_custom_url2 = $result_url2->num_rows;
                if($num_results_custom_url2!=0){
                    $row_list2= mysqli_fetch_assoc($result_url2);
		}
			
			
            }
            if(isset($_SESSION["user_id"])) { 
                //может ли читать Прием-Передача 
                if(($role->permission('Прием-Передача','R'))or($sign_admin==1)){ 
		} else {
                    header("HTTP/1.1 404 Not Found");
                    header("Status: 404 Not Found");
                    $error_header=404;   
		}
            } else {
                header("HTTP/1.1 404 Not Found");
                header("Status: 404 Not Found");
                $error_header=404;		
            }
        }    
 } else {
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
 }
} else {
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}

if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
//=========================================================================

function name_role($link,$id_role) {
   $name=''; 
   $sql='select * from r_role where id="'.$id_role.'"';
   $result=mysql_time_query($link,$sql);
   $result->num_rows;
   if($result->num_rows>0){
     $row= mysqli_fetch_assoc($result);
     $name=$row['name_role'];
   }
   return $name;
} 


  function minut_stamp($date_time) 
{ 

//2017-10-27 15:07:31

$date_elements  = explode(" ",$date_time);
$date_elements1  = explode(":",$date_elements[1]);
$date_elements2  = explode("-",$date_elements[0]);

	
      $vremy=$date_elements1[0].":".$date_elements1[1];
	  return $vremy;	


} 


function kopee($num) {
	$num= round(($num-intval($num))*pow(10,2));
	return($num);
}

function num2str($num) {
    $nul='ноль';
    $ten=array(
        array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
    );
    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
    $unit=array( // Units
        array('копейка' ,'копейки' ,'копеек',	 1),
        array('рубль'   ,'рубля'   ,'рублей'    ,0),
        array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
        array('миллион' ,'миллиона','миллионов' ,0),
        array('миллиард','милиарда','миллиардов',0),
    );
    //
    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub)>0) {
        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit)-$uk-1; // unit key
            $gender = $unit[$uk][3];
            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
        } //foreach
    }
    else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
    //$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}


function morph($n, $f1, $f2, $f5) {
    $n = abs(intval($n)) % 100;
    if ($n>10 && $n<20) return $f5;
    $n = $n % 10;
    if ($n>1 && $n<5) return $f2;
    if ($n==1) return $f1;
    return $f5;
}


function NumToIndex4($num)
{
 $octatok1=$num%100; 
 if((($num>=11)and($num<=14))or(($octatok1>=11)and($octatok1<=14))) { $ind=2; } else
 {
	
   $octatok=$num%10;
   if($octatok==0) { $ind=2; } else
   {
	  if($octatok==1) { $ind=0; } else
	  { 
   if ($octatok>4) $ind=2; else $ind=1; 
	  }
   }
 }
 return $ind;
}


function PadejToStr4($Age,$type)
{
  $SKL=explode(',',$type);
  $ind=NumToIndex4($Age);
	



  return $SKL[$ind];	
  
}




include_once $url_system.'template/html.php';
include_once $url_system.'module/config_url.php'; 
echo'<title>Печать - Акт приемо-передачи №'.$row_list["numer"].'</title>';
?>
<link rel="stylesheet" type="text/css" href="aktpp/print/akt.css" />
	

</head>
<body>
<?php
	
$date_rc=explode('-',$row_list["date_rco"]);
$date_rcc=$date_rc[2].'.'.$date_rc[1].'.'.$date_rc[0];
include_once $url_system.'aktpp/lib.php'; 
include_once $url_system.'aktpp/print/akt.php'; 

 
?>

</body>
</html>