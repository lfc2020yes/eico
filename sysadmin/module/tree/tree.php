<?php
//include("../php/config.php");
//include("module/lib/debug.php");

include("module/lib/thumb.php");
include("module/tree/buton.php");
include("module/tree/page.php");
include("module/tree/table.php");
include("module/tree/table_XY.php");
include("module/tree/table_XYi.php");
include("module/tree/image.php");
include("module/tree/add.php");
include("module/tree/add_gallery.php");
include("module/tree/edit.php");
include("module/tree/delete.php");
include("module/tree/move.php");
include("module/tree/make.php");
include("module/tree/copy.php");
include("module/tree/master.php");
include("module/tree/master_XY.php");
include("module/tree/run.php");
include("module/tree/prefix.php");


define ("MODUL","");
define ("dFORM",'&FORM=');

//pas - пароль который хочет задать
//email - логин пользователя

//то есть если нужно задать пароль для пользователя с id - 25 и логином marat, и хотим задать пароль 123
//----------------------------------$password=password_crypt_(25,'123','marat')
//и заносим в базу данных 
	
function password_crypt_id($id_user,$pas,$email) //----(от Влада)
{
$chars = $email.$email.$email.$email.$email.$email;
$posl_chifra_id=$id_user%10;
$ch=10+$posl_chifra_id;	
$st=$email.$email;
$st_1 = substr($st, 0, $posl_chifra_id);
$st_2= substr($st, $posl_chifra_id);
$crypt=sha1($st_1.$id_user.$pas.$chars[$ch].$st_2); 	
return($crypt);	
}


//=======================================================================заменить параметр $PAR на значение $DATA
//                                                                       удалить параметры массива $DelPAR
function MAKE_URL($PAR,$DATA,$DelPAR=array()) {                            // ?TREE=3.5&DB=0&uzl=10,855&li=909&FORM=3.5#TR
  //echo '<p>'.$_SERVER['REQUEST_URI'];
  $find=false;                                 //признак замены
  $one = explode ('?',$_SERVER['REQUEST_URI']);
  if (count($one)>1) {
  	 //echo '|'.$one[1];
     $two = explode ('#',$one[1]);             //TREE=3.5&DB=0&uzl=10,855&li=909&FORM=3.5#TR
     //echo '|'.$two[1];
     if (count($two)>0) {
        $three = explode ('&',$two[0]);        //TREE=3.5&DB=0&uzl=10,855&li=909&FORM=3.5
        for ($i=0; $i<count($three); $i++) {
          $param = explode ('=',$three[$i]);
          if ($param[0]==$PAR) {               // Найден искомый параметр
              $three[$i]=$PAR.'='.$DATA;
              $find=true;
          }
          for ($n=0;$n<count($DelPAR);$n++) {   // Удаление заданных параметров
              if ($param[0]==$DelPAR[$n]) {
                  $three[$i]='';
                  //unset($three[$i]);
              }
          }
        }
     }
  }
  //----------------сборка
  $URL=$one[0];
  if (count($one)>1) {
     //$URL.='?'.implode('&',$three);
     $DOT='?';
     for($i=0;$i<count($three);$i++) {
        if ($three[$i]<>'') { $URL.=$DOT.$three[$i]; $DOT='&'; }
     }
     if (!$find)$URL.=$DOT.$PAR.'='.$DATA;
     if (count($two)>1) {
     	 //echo ' + '.$two[1];
         unset($two[0]);
         //echo ' + '.$two[0];
         $URL.='#'.implode('#',$two);
     }
  }
  else $URL.='&'.$PAR.'='.$DATA;
  //echo '<p>'.$URL;
  return $URL;
}
//====================================== Заполнить в GT разобранную строку параметров $PARAM
	function GET_PARAM(&$GT,$PARAM)
	{
	  $GT1=explode('&',$PARAM);              //DB=3&id=17
	  for ($i=0; $i<count($GT1); $i++)
	  { $GT2=explode('=',$GT1[$i]);
	    $GT[$GT2[0]]=$GT2[1];               //именованный массив
	  }
	}

/*====================================================================================
получить фильтр на таблицу
$Source[0]= $TITLE

*/
function GET_SOURCE(&$row_TREE,&$Source)
{
  $Source[0]='';                                 //TITLE
  $Source[1]=$row_TREE['FILTER'];
  $Source[2]=$row_TREE['ID_COLUMN'];
  $Source[3]=$row_TREE['parent_COLUMN'];
  $Source[4]=$row_TREE['parent_TABLE'];
  $Source[5]=$row_TREE['parent_TITLE'];
  $Source[6]='';                                //&child=PARAGRAF;ID
  $Source[7]='';                                //PARAGRAF (child)
  $Source[8]='';                                //ID (child)

  if ($row_TREE["parent_TABLE"]<>""       //Обычный зависимый заголовок
  and (array_key_exists('in', $_GET))
  and ($_GET['in']>0)
  and $Source[3]<>'' and $Source[4]<>'' and $Source[5]<>''
  )

  {
  	$sql_T = new Tsql('select '.$Source[5].' from '.GET_TN($Source[4]).' where '.$Source[3].'="'.$_GET['in'].'"');
  	echo_dd($row_TREE,'T:'.$sql_T->sql.' S4:'.$Source[4]); ///
  	//echo "\n".$sql_T->sql;   /////
  	if ($sql_T->num>0)
  	{  $sql_T->NEXT();
  	   $Source[0]=$sql_T->row[$row_TREE["parent_TITLE"]];       // $TITLE
  	}
  }
  else
  { if (array_key_exists('child', $_GET)   //---------------Запуск от перекрестного Родителя без parent_TABLE
    and array_key_exists('in', $_GET))    //id запустившей записи в TREE_
    {
      $CLD=explode(';',$_GET['child']);   //0-параграф возврата 1- ID поля вызвавший процесс в FORM_
      $Source[6]='&child='.$_GET['child'];
      $Source[7]=$CLD[0];
      $Source[8]=$CLD[1];
      $sql_CLILD = new Tsql('select * from _FORM where id="'.$CLD[1].'"');
  	  echo_dd($row_TREE,'C1:'.$sql_CLILD->sql); ///
      if ($sql_CLILD->num>0)
  	  {   $sql_CLILD->NEXT();

  	         $Source[1]=$sql_CLILD->row['SOURCE_FILTER'];
		  	 $Source[2]=$sql_CLILD->row['SOURCE_ID'];
		  	 $Source[3]=$sql_CLILD->row['COLUMN_FIELD'];
		  	 $Source[4]=$sql_CLILD->row['TABLE_NAME'];
		  	 $Source[5]=$sql_CLILD->row['COLUMN_DEFAULT'];

  	      $sql_T = new Tsql('select '.$Source[5].' from '.$Source[4].' where '.$Source[3].'="'.$_GET['in'].'"');
  	      echo_dd($row_TREE,'C2:'.$sql_T->sql); ///
  	      if ($sql_T->num>0)                              //$sql_T->row запись из таблицы с данными
		  {  $sql_T->NEXT();                              //$sql_CLILD->row  описание поля в _FORM
		  	 $Source[0]=$sql_T->row[0];          //$TITLE

		  }

      }
    }
  }

}

  function SCOBA($STR,$type=0)
  { $scb=array( array(' [',']'),
                array(' (',')'),
                array(' {','}')
              );
    if ($STR=='') return '';
    else          return $scb[$type][0].$STR.$scb[$type][1];
  }


//====================================== Взять расширение для графического файла
  function GET_EXT($CHILD)
{
  if ($CHILD=='') $pEXT='.jpg';
  else
    if ($CHILD=='none') $pEXT='';
    else                $pEXT='.'.$CHILD;
  return $pEXT;
}


//========================================================================
    function dTREE()
    {
      return '?DB='.$_GET['DB'].'&TREE='.$_GET['TREE'];
    }
//====================================выбор имени или если нет - названия поля
    function GET_NAME(&$row_FORM)
    { if($row_FORM["COLUMN_NAME"]<>'')   return $row_FORM["COLUMN_NAME"];
      else                               return $row_FORM["COLUMN_FIELD"];
    }
//=====================================получить переменную фильтра
    function GET_PARENT(&$row_TREE)
    {
    	if  ( /*$row_TREE['parent_TABLE']<>''
        and */array_key_exists('in', $_GET)
        and $_GET['in']<>'')
             return '&in='.$_GET['in'];
        else return '';
	}
//=====================================поиск в названии PARAGRAF sys
    function FIND_SYS(&$row_TREE)    //Если нет === false  или позицию
    {  return strpos( $row_TREE['PARAGRAF'],'sys');
    }
//=====================================Проверить ComboBox
function GET_CHECK($name_column)
{
  if (isset($_POST[$name_column])) $GC=1; else $GC=0;
  //if (array_key_exists($name_column,$_POST)) { echo("0-!!!"); }
  return $GC;
}
//====================================== Получить маску пользователя на параграф
function  GET_MASK_USER(&$user,&$row_TREE,&$MASK,&$uNAME,&$uPARENT,&$FINDD,&$FD)
{
  $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));
  if ($row_TREE["kind_FIND"])
  {
       //----------------------------------Получить фильтр данных
        $sql_FND=new Tsql('select * from _FIND where USER="'.$user.'" and PARAGRAF="'.$row_TREE["PARAGRAF"].'"');
        //echo_pp($row_TREE,'sql_FND->sql='.$sql_FND->sql);  ///
        if ($sql_FND->num>0)   //Есть запись о фильтре
        {
           $sql_FND->NEXT();
           $uPARENT=$sql_FND->row['PARENT'];    //Если пусто - это главная таблица
           $uNAME=$sql_FND->row['NAME'];
           $FD=$sql_FND->row['FIELD_DATA'];
           //-----------------------проверяет - если это PARENT фильтр (одного поля) и нет поля
           if ($uPARENT<>'')
           { if (isFIELD($FD, $row_TREE['ID_TABLE'])==true)
             {           $MASK=$sql_FND->row['FINDER'];

                      //   echo_pp($row_TREE,'MASK0='.$MASK);
             }
           }
           else
           $MASK=$sql_FND->row['FINDER'];
           $FINDD=explode(':',$FD);     //FIELD_FND:DATA   $FINDD[2]
        }
  }
}

//=========================================================Получить инфу по маске
function GET_mask(&$row_TREE,&$MASK,&$MASK_FIELD,&$uPARENT)
{
        GET_mask_paragraf( $row_TREE["PARAGRAF"],$MASK,$MASK_FIELD,$uPARENT,$row_TREE['ID_TABLE']);
}
//=========================================================Получить инфу по маске
function GET_mask_paragraf($PARAGRAF,&$MASK,&$MASK_FIELD,&$uPARENT,$ID_TABLE)
{
        $MASK='';          //$MASK[1]-значение
        $MASK_FIELD='';
        $uPARENT='';
        $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));

        $sql_FND=new Tsql('select * from _FIND where USER="'.$user.'" and PARAGRAF="'.$PARAGRAF.'"');
        //echo_pp($row_TREE,'sql_FND->sql='.$sql_FND->sql);  ///
        if ($sql_FND->num>0)   //Есть запись о фильтре
        {
           $sql_FND->NEXT();
           $uPARENT=$sql_FND->row['PARENT'];    //Если пусто - это главная таблица
           //-----------------------проверяет - если это МАСКА -  PARENT фильтр (одного поля) и наличие поля
           if ($uPARENT<>'')
           { if (isFIELD($sql_FND->row['FIELD_DATA'], $ID_TABLE)==true)
             {
               $MASK=explode('"',$sql_FND->row['FIELD_DATA'].'="'.$sql_FND->row['FINDER'].'"');              // значение $MASK[1] Это выражение - через = и ""
               $MASK_FIELD=$sql_FND->row['FIELD_DATA'];    //это н азвание одиночного поля
                      //   echo_pp$row_TREE,'MASK0='.$MASK);

             }
           }
        }
}
//=================================================================================
/*
          $findM = new find_mask($user);
          $findM->Get_FIND$row_TREE);   // Заполнить массив фильтрами _FIND
   * 
   */
  class find_mask {
  var $ArrFIND = array();   //level,parent,data,item_mask/FINDER,  ''/FIELD_DATA,
  var $user;
  function find_mask($user) {
      $this->user=$user;
  }
  function Get_FIND_HEAD() {  
      $str='';
      for ($i=0;$i<count($this->ArrFIND);$i++) {
         if ($this->ArrFIND[$i][0]==0) continue;
         //if ($this->ArrFIND[$i][3]=='') continue;
         $str.=SCOBA($this->ArrFIND[$i][2],0);
      }
      if ($str>'')$str=SCOBA($str,2);
      return $str;
  }
  function Get_FIND_MASK() {
      $str=''; $and='';
      for ($i=0;$i<count($this->ArrFIND);$i++) {
         if ($this->ArrFIND[$i][0]==0) continue;
         if ($this->ArrFIND[$i][3]=='') continue;
         $str.=$and.$this->ArrFIND[$i][3];
         $and=' AND ';
      }
      return $str;
  }
  function Get_ADD_MASK() {
      $arr=array('',''); $coma=''; 
      for ($i=0;$i<count($this->ArrFIND);$i++) {
         if ($this->ArrFIND[$i][0]==0) continue;
         if ($this->ArrFIND[$i][3]=='') continue;
         $arr[0].=$coma.$this->ArrFIND[$i][5];
         $arr[1].=$coma.'"'.$this->ArrFIND[$i][6].'"';
         $coma=',';
      }
      return $arr;
  }
  
  function Get_FIND_TEK($paragraf) {
      $ret='';
      $sql_FND=new Tsql('SELECT DISTINCT DATA FROM _FIND WHERE USER="'.$this->user.'" AND PARENT="'.$paragraf.'" AND LEVEL>0');
      if ($sql_FND->num>0) {
          $sql_FND->NEXT(); 
          $ret=$sql_FND->row['DATA'];
          $sql_FND->FREE();
      }
      unset($sql_FND);
      return $ret;
  }
  function isField($field) {
      $ret=false;
      for ($i=0;$i<count($this->ArrFIND);$i++) {
         if ($this->ArrFIND[$i][0]==0) continue;
         if ($this->ArrFIND[$i][5]==$field) {
             $ret=true;
             break;
         }
      }
      return $ret;
  }
  function getFieldData($field) {
      $ret='';
      for ($i=0;$i<count($this->ArrFIND);$i++) {
         if ($this->ArrFIND[$i][0]==0) continue;
         if ($this->ArrFIND[$i][5]==$field) {
             $ret=$this->ArrFIND[$i][6];
             break;
         }
      }
      return $ret;
  }
  
  function Get_FIND(&$row_TREE) {    
       //----------------------------------Получить фильтр данных
        $sql_FND=new Tsql('select * from _FIND where USER="'.$this->user.'"'
                . ' and PARAGRAF="'.$row_TREE["PARAGRAF"].'"'
                . ' order by LEVEL'
                . '');
        echo_pp($row_TREE,'sql_FND->sql='.$sql_FND->sql);  ///
        if ($sql_FND->num>0)   //Есть запись о фильтре
        { for ($i=0;$i<$sql_FND->num;$i++) {
           $sql_FND->NEXT();
           $this->ArrFIND[]=array();                       //                       0    1      2    3           4        5      6
           $this->ArrFIND[$i][]=$sql_FND->row['LEVEL'];    //0                                       FINDER     FIELD_DATA
           $this->ArrFIND[$i][]=$sql_FND->row['PARENT'];   //1 $uPARENT     ArrFIND=level,parent,data,item_mask,  ,,        field, id
           $this->ArrFIND[$i][]=$sql_FND->row['DATA'];     //2 $uNAME
           if ($sql_FND->row['LEVEL']==0) {          //фильтр (одного поля)
              $this->ArrFIND[$i][]=$sql_FND->row['FINDER'];   //3
              $this->ArrFIND[$i][]=$sql_FND->row['FIELD_DATA'];  //4
              $this->ArrFIND[$i][]='';  //5 
              $this->ArrFIND[$i][]='';  //6 
           } else {
              if (isFIELD($sql_FND->row['FIELD_DATA'], $row_TREE['ID_TABLE'])==true) {
                      $this->ArrFIND[$i][]= $sql_FND->row['FIELD_DATA'].'="'.$sql_FND->row['FINDER'].'"'; //3
                      $this->ArrFIND[$i][]='';  //4
                      $this->ArrFIND[$i][]=$sql_FND->row['FIELD_DATA']; //5
                      $this->ArrFIND[$i][]=$sql_FND->row['FINDER'];   //6
              } else  { $this->ArrFIND[$i][]=''; //3
                        $this->ArrFIND[$i][]=''; //4
                        $this->ArrFIND[$i][]='';  //5
                        $this->ArrFIND[$i][]='';  //6 
              }
           }
           //-----------------------проверяет - если это PARENT фильтр (одного поля) и нет поля
          }
          $sql_FND->FREE();
        }
        echo_pp($row_TREE, "<pre>".print_r($this->ArrFIND,true)."</pre>");
        unset($sql_FND);
    } 
  } // class    

function FORM_switch(&$row_TREE) {
  $ROW_role=get_role(htmlspecialchars(trim($_SERVER['PHP_AUTH_USER'])));
        echo_dd($row_TREE,' TYPE_FORM='.$row_TREE["TYPE_FORM"]);   ///
	    switch($row_TREE["TYPE_FORM"])
            { case "FORM_EDIT":
              case "FORM_MENU":
                           FORM_edit($row_TREE,&$ROW_role);
                           break;
              case "TABLE":
              case 'TABLE_KIND':
              case 'TABLE_OBJ':
                           echo_dd($row_TREE,$row_TREE["PARAGRAF"]);
                           FORM_table($row_TREE,&$ROW_role);
                           break;
              case "TABLE_XY":                       //Устаревший вариант для совместимости (продажи)
                           FORM_table_XY($row_TREE);
                           break;
              case "TABLE_XYi":
                           FORM_table_XYi($row_TREE);
                           break;
              case "FORM_MASTER":
                           FORM_master($row_TREE);
                           break;
              case "FORM_MASTER_XY":
                           FORM_master_XY($row_TREE);
                           break;
              case "FORM_RUN":
                           FORM_run($row_TREE,&$ROW_role);
                           break;
              case "FORM_PREF":
                           $O=0;
                           if (array_key_exists('PR', $_GET)) $SHOW=false;
                           else                               $SHOW=true;
                           if (FORM_pref($row_TREE,$SHOW,$O))
                           {   if (array_key_exists('PR', $_GET))
                                   FORM_pref_CHILD($row_TREE,true,$O);
                           }
                           break;

            }  //switch
}

function FORM_pref_CHILD(&$row_TREE)
{
  if ($row_TREE["FILTER"]<>"")  //Передать управление Prefix_forme
  {
    $sql_T= new Tsql('select * from _TREE where PARAGRAF="'.$row_TREE["FILTER"].'"');
    if ($sql_T->num>0)
    {   echo_dd($row_TREE,'num='.$sql_T->num.' sql='.$sql_T->sql.' PR='.$_GET['PR']);  //
        $sql_T->NEXT();
        FORM_switch($sql_T->row);          //Запус CHILD формы из префикса  "FILTER"
        return true;
    }
  }
}


// Заменить название переданной таблицы или поля по префиксу
function GET_TN($ID_TABLE)
{
        $TN=explode('_',$ID_TABLE); //Разобрать имя таблицы

        if  (count($TN)>1                            //Заменять
        and  array_key_exists('PRR', $_GET))         //PR PR PR
        { $PR=explode(':',$_GET['PR']);  //id:prefix
          $TN[0]=$PR[1];                                    //Подставить префикс - [0]-ID
          $TN=implode('_',$TN);                                 //Создать новую таблицу
        }
        else $TN=$ID_TABLE;     //не заменять

        return $TN;
}



//================================================================Правое окно
  $ROW_role=get_role(htmlspecialchars(trim($_SERVER['PHP_AUTH_USER'])));
  //echo "\n".'TREE';
  if (array_key_exists('FORM', $_GET) /*and $_GET['do_menu'] == 'FORM'*/)
  {   console ("log","GET analis");
      //echo "\n"."FORM get- нулевой";   ///
      if (array_key_exists('FORM', $_GET) and array_key_exists('atr', $_GET))  //определен вызов какой-то формы  'do'
      { //echo "\n(FORM - определено в GET)";  ///
        $sql='select * from _TREE where PARAGRAF="'.$_GET["FORM"].'"';
        $result=mysql_query($sql);
        $num_results = mysql_num_rows($result);
        //echo "\n".$sql;                   ////
        //echo "\n num_results=".$num_results; ////
        if($num_results>0)
        {
          $row_TREE = mysql_fetch_array($result);
          //echo "\n параграф=".$row_TREE["PARAGRAF"];  ////
          $RTN=false;                          // признак выполнения подпрограммы
          //if (array_key_exists('do', $_GET))   //определена запись для действий
          if (array_key_exists('atr', $_GET))
            { 
              switch ($_GET["atr"])                 //Производные действия над текущей формой
              { case  'up':
                             FORM_moveUP($row_TREE);
                             break;
                case  'down':
                             FORM_moveDOWN($row_TREE);
                             break;
                              //Парараграф на новую форму
                case  'open':
                              //!!!!!!!!
                              break;
                case  'add':  if ($row_TREE["TYPE_FORM"]=="FORM_ADD")
                                  $RTN=FORM_add($row_TREE,&$ROW_role);
                              break;
                 case  'photo':  if ($row_TREE["TYPE_FORM"]=="FORM_ADD")
                                  $RTN=FORM_photo($row_TREE);
                              break;
                case  'edit':
                              if (($row_TREE["TYPE_FORM"]=="FORM_EDIT")
                              or  ($row_TREE["TYPE_FORM"]=="TABLE")
                              or  ($row_TREE["TYPE_FORM"]=="TABLE_KIND")
                              or  ($row_TREE["TYPE_FORM"]=="TABLE_OBJ")
                                  )
                                  $RTN=FORM_edit($row_TREE,&$ROW_role);
                              else
                              if ($row_TREE["TYPE_FORM"]=="FORM_MASTER")
                                  $RTN=FORM_master($row_TREE);
                              break;
                case  'delete':
                              if ($row_TREE["TYPE_FORM"]=="FORM_DELETE")
                                  $RTN=FORM_delete($row_TREE);
                              break;
                case  'make':
                               if ($row_TREE["TYPE_FORM"]=="FORM_MAKE")
                                  $RTN=FORM_make($row_TREE);
                              break;
                case  'copy':
                               if ($row_TREE["TYPE_FORM"]=="FORM_COPY")
                                  $RTN=FORM_copy($row_TREE);
                              break;
                case  'tmove':
                               if ($row_TREE["TYPE_FORM"]=="FORM_MAKE") {
                                    include_once("module/tree/tree_move.php");
                                    $RTN=TREE_MOVE($row_TREE);
                               }
                              break;   
                case  'tcopy':
                               if ($row_TREE["TYPE_FORM"]=="FORM_MAKE") {
                                    include_once("module/tree/tree_copy.php");
                                    $RTN=TREE_COPY($row_TREE);
                               }
                              break;
                case  'tdelete':
                               if ($row_TREE["TYPE_FORM"]=="FORM_MAKE") {
                                   include_once("module/tree/tree_delete.php");
                                  $RTN=TREE_DELETE($row_TREE);
                               }   
                              break;              
              }
            }  //if

          //echo ("\n return GET RTN=".$RTN);
          console ("log","return GET RTN=".$RTN);  
          if($RTN==true) return;
        }
      }  //GET
       
      //===================================POST
      if (array_key_exists('do', $_POST)) //завершение какой-то формы
      { 
        console ("log","POST analis");
        $sql='select * from _TREE where PARAGRAF="'.$_POST["do"].'"';
//        echo '<p> sql_do='.$sql;    //
        $result=mysql_query($sql);
        $num_results = mysql_num_rows($result);
        if($num_results>0)
        {
          $row_TREE = mysql_fetch_array($result);
//          echo "<p> TYPE_FORM=".$row_TREE["TYPE_FORM"];     //
          switch($row_TREE["TYPE_FORM"])
          {   case "FORM_MENU":
              case "FORM_EDIT":
                           FORM_edit_post($row_TREE);
                           break;
              case "TABLE":
              case "TABLE_KIND":
              case "TABLE_OBJ":
                           echo_pp($row_TREE,'выбор _post, idform='.array_key_exists('idform', $_POST));

                           if (array_key_exists('idform', $_POST))
                             FORM_edit_post($row_TREE);
                           else
                           FORM_table_post($row_TREE);
                           break;

              case "TABLE_XY":
              case "FORM_MASTER_XY":
                           FORM_table_XY_post($row_TREE);
                           break;
               case "TABLE_XYi":
                           FORM_table_XYi_post($row_TREE);
                           break;
              case "FORM_ADD":
                           if (array_key_exists('atr', $_POST))
                           { if ($_POST["atr"]=='photo')
                                  FORM_add_gallery_post($row_TREE);
                             else FORM_add_post($row_TREE);
                           }
                           else FORM_add_post($row_TREE);
                           break;
              case "FORM_DELETE":
                           FORM_delete_post($row_TREE["ID_TABLE"]);
                           break;
              case "FORM_MAKE":
                           FORM_make_post($row_TREE);
                           break;
              case "FORM_COPY":
                           FORM_copy_post($row_TREE);
                           break;
              case "FORM_MASTER":
                           FORM_master_post($row_TREE);
                           break;
              //case "FORM_MASTER_XY":
//                           FORM_master_XY_post($row_TREE);
                          // break;

          } //switch
          //return;
        }  //if
      }  //POST
//============================================================подстановка вхождения с середины
    // echo "\n". "\nглавная";     ///

      if (array_key_exists('FORM', $_GET)) //завершение какой-то формы
        $PRG=$_GET["FORM"]; else $PRG='1.04.01.01';
      $sql_T='select * from _TREE where PARAGRAF="'.$PRG.'"';
      $result_T=mysql_query($sql_T);
      $num_results_T = mysql_num_rows($result_T);
      //echo "\n (num_results_x=".$num_results_T.") sql_T=".$sql_T;
//============================================================Базовая форма отладки
      if($num_results_T>0)
	  {
	    $row_TREE = mysql_fetch_array($result_T);
	    $O=0;
        FORM_PR('PR',$O);   //Вывести горизонтальное меню PREFIX  если PR определено
        FORM_switch($row_TREE);
	  }  //if

  }  //do_menu
  else   //class="art"
  echo '<div  style=" position:absolute; left:0%; top:0px; width:100%; height:100%; border:0px solid #999999;">'
       ."<a>   Copyright &#169 &#174 AtSun.ru v.1.08 2017.04.17</a>"
       .'</div>';
  ; //echo "\n".'Не Определено';

console ("log","The END");



