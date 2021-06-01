<?


class Thost2
{
//                            0                         1                      2                 3             4                             5                      6
 //                      $dblocation                 $dbname                $dbuser             dbpasswd      comment                   host site                   default

var $H=
      array(
            "0" =>array('localhost',             'atsunru_interstroi', 'atsunru_inter',    'inter2017',  'CCM local'  ,'eico.atsun.ru',  '')
            );


var $F=     //             0      1                    2               3
    array(  //            ftp  login                  pass           correct dir
             "0" =>array(false,'',                    ''             ,'../')                  //Управление с сайта
            );
}
//-------------------------------------------------------------------------------
function FTPconnect(&$Tunel,$HBS)            //"ftp.server.com"     //ftp_close($Tunel);
{
  $base=new Thost2;
  $FC=false;
  $Tunel = ftp_connect($base->H[$HBS][5], 21, 30);      // 21порт 30сек
  $FC=ftp_login($Tunel, $base->F[$HBS][1], $base->F[$HBS][2]);
  return $FC;

}


//===============================================================================

function LHBase($HBS)
{
      $base=new Thost2;


      //echo "HBS=$HBS  base[0][HBS]=".$base[0][$HBS].'каталог:'.getcwd();
      $h= $HBS;
	  $dblocation = $base->H[$h][0];
	  $dbname = $base->H[$h][1];
	  $dbuser = $base->H[$h][2];
	  $dbpasswd = $base->H[$h][3];
	  $version = "1.0";
	  $dbcnx = @mysql_connect($dblocation,$dbuser,$dbpasswd);
	  if (!$dbcnx) {
	    exit('В настоящий момент сервер базы данных не доступен [1] , поэтому корректное отображение страницы невозможно');
	  }
	  if (! @mysql_select_db($dbname,$dbcnx) ) {
	    exit('В настоящий момент база данных не доступна [2], поэтому корректное отображение страницы невозможно');
	  }
}
?>
