<html xmlns="http://www.w3.org/1999/xhtml">
<?
/*
// Вывести НАИМЕНОВАНИЕ если существует переменная OBJ
function FORM_OBJ ($PR,$OBJ)
{ $status=0;
  if (array_key_exists($OBJ, $_GET))
  { $OBJ=explode(':',$_GET[$OBJ]);  //id:paragraf     where id="id" or PARAGRAF="paragraf"
    $sql_TREE = new Tsql('select * from _TREE where PARAGRAF="'.$OBJ[1].'"');
    if($sql_TREE->num>0)    //параграф выбран
    {
      $sql_TREE->NEXT();
      $status=1;    }
  }
  if ($status==1)  FORM_PR ($PR,&$row_OBJ);
  else             FORM_PR ($PR);
}
*/
// Вывести меню если существует переменная PR
function FORM_PR ($PR,&$row_OBJ)      //function FORM_PR ($PR,&$row_OBJ=0)
{ $status=0;
  if (array_key_exists($PR, $_GET))
  { $PR=explode(':',$_GET['PR']);  //id:prefix:paragraf
    $sql_TREE = new Tsql('select * from _TREE where PARAGRAF="'.$PR[2].'"');
    if($sql_TREE->num>0)
    {
           $sql_TREE->NEXT();
           $status=1;    }
  }
  if ($status==1)  FORM_pref (&$sql_TREE->row, true, &$row_OBJ);
//  else             FORM_pref ($status, true, &$row_OBJ);

}

//function FORM_pref (&$row_TREE=0, $SHOW=true, &$row_OBJ=0)
function FORM_pref (&$row_TREE, $SHOW=true, &$row_OBJ)
{  if ($SHOW)
   {
?>

<style>
/* superNEW shapka 594px*/
.n_spTop {background-image: url(http://img1.imgsmail.ru/mail/ru/images/ru/_sp_top.png?1);}
.n_shT {background-color: #00468C; border-left: 1px solid #FFF; border-right: 1px solid #FFF; height: 1px; position: relative; font-size: 0; line-height: 0; height: 1px; //height: 0; //display: inline-block; //width: 100%;}
.n_shMain {position: relative; height: 40px; width: 98px; min-width: 694px; background-color: #99FF99; background-repeat: repeat-x; background-position: 0 -220px; margin: 1px 0 7px;}
.n_shLogo {position: absolute; height: 47px; width: 25%; background-repeat: no-repeat; background-position: center 0; text-align: center; top: 0;}
.n_shLogoA {display: inline-block; height: 34px; width: 160px; margin-top: 11px;}
.n_shLogoW {display: inline-block; height: 14px; width: 38px; vertical-align: top; margin-top: 11px;}
.n_shForm {color: #FFF; white-space: nowrap; margin: 0; font-size: 11px; font-family: Tahoma !important; position: absolute; right: 5px; top: 5px;}
.n_shSns2 {color: #FFF; vertical-align: middle; position: absolute; display:inline-block; font-size: 95%; font-family: Tahoma !important; padding: 0 0 0 24%; //padding: 0 0 0 36%;}
.n_shSns2 a {color: #FFF;}
.n_shSns2 a:HOVER {color: #FFF;}
/* end superNEW shapka */


/* superNEW shapka menu #5977b3 #013572*/
.n_shBook {position: relative; top: 22px; padding-left: 4%; white-space: nowrap; display: block; height: 18px; overflow: hidden;}
.nm_menuA {background-color: #00CC66; display: inline-block; vertical-align: top; padding: 3px 0 2px 0;}
.nm_menuAaa {margin: 0 4px 0 3px; float: left; color: #FFF; text-decoration: none; position: relative; z-index: 100;}
a:HOVER.nm_menuAaa {text-decoration: underline; float: left; color: #FFF !important; position: relative; z-index: 100;}
.nm_menuS {border-top: 0; border-left: 0; border-bottom: 20px solid #00CC66; border-right: 20px solid transparent; font-size: 0; line-height: 0; display: inline-block;vertical-align:top; position: relative; z-index: 1;}
.nm_menuSp {border-bottom: 12px solid transparent; border-right: 12px solid #00CC66; font-size: 0; line-height: 0; display: inline-block; vertical-align:top; padding: 7px 0 0 0; margin-top: 1px;position: relative; z-index: 1;}
.nm_menuSp2 {border-top: 1px solid #00CC66; font-size: 0; line-height: 0; display: inline-block; width: 11px; position: absolute; top: 0; left: 1px; vertical-align:top; z-index: 1;}

.nm_menuA_act {background-color: #FFF;}
.nm_menuAaa_act {color: #006633 !important; font-weight: bold; margin-left: 1px;}
a:HOVER.nm_menuAaa_act {color: #006633 !important;}
.nm_menuS_act {border-bottom: 20px solid #FFF;}
.nm_menuSp_act {border-right: 12px solid #FFF; border-bottom: 12px solid #FFF;}
.nm_menuSp2_act {border-top: 1px solid #FFF;}

.nm_menuSp_f {border-bottom: 12px solid #00CC66;}
.nm_menuAaa_f {margin-left: 1px;}

.nm_menu2 {float:left; position: relative; margin-left: -11px;}
@media all and (-webkit-min-device-pixel-ratio:10000),
not all and (-webkit-min-device-pixel-ratio:0)
{ .nm_menu2 {margin-left: -10px;} }
/* end superNEW shapka menu */
</style>

<style type="text/css">
.nm_menuA_mark {background-color: #ca0606;}
.nm_menuAaa_mark {color: #FFFFFF !important;}
a:HOVER.nm_menuAaa_mark {color: #FFFFFF !important;}
.nm_menuS_mark {border-bottom-color: #ca0606;}
.nm_menuSp_mark {border-right-color: #ca0606;}
.nm_menuSp2_mark {border-top-color: #ca0606;}

.nm_menuAaa {margin: 0 0 0 -3px;}
.nm_menuAaa_act {margin-left: -3px !important;}
.nm_menuAaa_f {margin-left: -3px !important;}

</style>

<!--[if lt IE 7]>
<style>
.ie6bT {border-top-color: #00468c; filter:chroma(color='#00468c');}
.ie6bR {border-right-color: #00468c; filter:chroma(color='#00468c');}
.ie6bB {border-bottom-color: #00468c; filter:chroma(color='#00468c');}
.ie6bL {border-left-color: #00468c; filter:chroma(color='#00468c');}
</style>
<![endif]-->


<div class="n_shMain n_t12 n_tal" style="overflow: hidden; //overflow: visible; //display: inline-block;">
<span class="n_shSns2 n_t11"></span>
<div class="n_shBook arial">

<!--
<div class="nm_menu2"><span class="nm_menuSp2 nm_menuSp2_f"></span><span class="nm_menuSp nm_menuSp_f"></span><span class="nm_menuA nm_menuA_f"><a href="start?top=1" class="nm_menuAaa nm_menuAaa_f">Почта</a></span><span class="nm_menuS ie6bR nm_menuS_f"></span></div>

<div class="nm_menu2"><span class="nm_menuSp2 nm_menuSp2_act"></span><span class="nm_menuSp nm_menuSp_act"></span><span class="nm_menuA nm_menuA_act"><a href="top=1" class="nm_menuAaa nm_menuAaa_act">Почта</a></span><span class="nm_menuS ie6bR nm_menuS_act"></span></div>
<div class="nm_menu2"><span class="nm_menuSp2"></span>        <span class="nm_menuSp ie6bB"></span>               <span class="nm_menuA"><a href="top=1" class="nm_menuAaa">Адреса</a></span><span class="nm_menuS ie6bR"></span></div>
<div class="nm_menu2"><span class="nm_menuSp2"></span><span class="nm_menuSp ie6bB"></span><span class="nm_menuA"><a href="http:from_commercial=3" class="nm_menuAaa">Мой мир</a></span><span class="nm_menuS ie6bR"></span></div>
-->
<?php
  //echo '<tr><td>'.'Программа menu';
    /*
    if ($row_OBJ>0)
    {
       echo '<span class="n_shSns2 n_t11">'
           .'<span style="white-space: nowrap;">Здравствуйте'
           .'</span></span>';
    }
    */
  //проверка существования PR
    if ($row_TREE>0)
    {
     $sql_M = new Tsql('select * from '.$row_TREE['parent_TABLE']);   //выбрать одну запись как пример для чтения полей
  //echo_dd(&$row_TREE,$sql_M->num.'-'.$sql_M->sql);
  //echo '<tr><td>'.'Количество строк: '.$sql_M->num; //

      for ($i=0; $i<$sql_M->num; $i++)
	  {
	  	$sql_M->NEXT();
	  	//echo_dd(&$row_TREE,$i.'-'.$sql_M->row[$row_TREE["parent_COLUMN"]]);

	  	if (array_key_exists('PR', $_GET)==true)
	  	    $PR=explode(':',$_GET["PR"]);
        if ($sql_M->row[$row_TREE["parent_COLUMN"]]==$PR[1])  // Типа текущая страница
        echo '<div class="nm_menu2">'
             .'<span class="nm_menuSp2 nm_menuSp2_act"></span>'
             .'<span class="nm_menuSp nm_menuSp_act"></span>'
             .'<span class="nm_menuA nm_menuA_act"><a href="'.MODUL.dTREE().dFORM.$row_TREE["PARAGRAF"].'&PR='.$sql_M->row['id'].':'.$sql_M->row[$row_TREE["parent_COLUMN"]].':'.$row_TREE["PARAGRAF"].'" class="nm_menuAaa nm_menuAaa_act">'.$sql_M->row[$row_TREE["parent_TITLE"]].'</a></span>'
             .'<span class="nm_menuS ie6bR nm_menuS_act"></span></div>';
        else
       {if ($i==0)                              //Нулевая неактивная закладка
        echo '<div class="nm_menu2">'
             .'<span class="nm_menuSp2 nm_menuSp2_f"></span>'
             .'<span class="nm_menuSp nm_menuSp_f"></span>'
             .'<span class="nm_menuA nm_menuA_f"><a href="'.MODUL.dTREE().dFORM.$row_TREE["PARAGRAF"].'&PR='.$sql_M->row['id'].':'.$sql_M->row[$row_TREE["parent_COLUMN"]].':'.$row_TREE["PARAGRAF"].'" class="nm_menuAaa nm_menuAaa_act">'.$sql_M->row[$row_TREE["parent_TITLE"]].'</a></span>'
             .'<span class="nm_menuS ie6bR nm_menuS_f"></span></div>';

        else                                    //Средняя неактивная закладка
        echo '<div class="nm_menu2">'
            .'<span class="nm_menuSp2"></span>'
            .'<span class="nm_menuSp ie6bB"></span>'
            .'<span class="nm_menuA"><a href="'.MODUL.dTREE().dFORM.$row_TREE["PARAGRAF"].'&PR='.$sql_M->row['id'].':'.$sql_M->row[$row_TREE["parent_COLUMN"]].':'.$row_TREE["PARAGRAF"].'" class="nm_menuAaa">'.$sql_M->row[$row_TREE["parent_TITLE"]].'</a></span>'
            .'<span class="nm_menuS ie6bR"></span></div>';
	   }
	  }
	  echo '</div></div>';
    }  //$row_TREE>0

  } //show
  return true;
}

?>
</html>