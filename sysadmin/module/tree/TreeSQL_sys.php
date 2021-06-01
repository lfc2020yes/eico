<script language="JavaScript" type="text/javascript">
	function visiPLUS(item) {
          //var stat = document.getElementById(item).style.display; 
          //alert ('plus'+item);
          //if (stat!==type) {
             // alert (type+': '+item+' stat: '+stat);
	     document.getElementById('plus'+item).style.display = 'none';
             document.getElementById('minus'+item).style.display = 'inline-block';
             document.getElementById('level'+item).style.display = 'inline-block';
             AddToCookie('uzl',item,60);
             //if(type==='none') {
             //  alert (type+' на '+item);
             //   document.getElementById(item+'_').textContent=".";
             //}
          //}
	}
        function visiMINUS(item) {
            //alert ('minus'+item);
	    document.getElementById('plus'+item).style.display = 'inline-block';
            document.getElementById('minus'+item).style.display = 'none';
            document.getElementById('level'+item).style.display = 'none';
            DelFromCookie('uzl',item,60);
	}
        
        
</script>
<script language="JavaScript" type="text/javascript">
// name - имя cookie
// value - значение cookie
// [expires] - дата окончания действия 
//             cookie (по умолчанию - до конца сессии)
// [path] - путь, для которого cookie действительно
//          (по умолчанию - документ, в котором значение было установлено)
// [domain] - домен, для которого cookie действительно 
//           (по умолчанию - домен, в котором значение было установлено)
// [secure] - логическое значение, показывающее требуется ли 
//            защищенная передача значения cookie

function setCookie(name, value, expires, path, domain, secure) {
    if (expires) {
       var day =  new Date(new Date().getTime() + expires * 86400000);
    }
    var curCookie = name + "=" + escape(value) +
    ((expires) ? "; expires=" + day.toUTCString() : "") +
    ((path) ? "; path=" + path : "") +
    ((domain) ? "; domain=" + domain : "") +
    ((secure) ? "; secure" : "");
    if ((escape(value)).length <= 4000-10)
    document.cookie = curCookie;
    else
    if (confirm("Cookie превышает 4KB и будет вырезан !"))
    document.cookie = curCookie;
    //alert (curCookie);
}
function isValueInArr(value,arr){
    var ret=false;
    for (var i = 0; i < arr.length; i++) {
        if(arr[i]==value) {
            ret=true;
            break;
        }
    }
    return ret;
}
function DelValueArr(value,arr) {
    var arr1=[]; 
        for (var i = 0; i < arr.length; i++) {
          if(arr[i]!=value) arr1.push(arr[i]);
        }
    return arr1;
}

function AddToCookie(name, value, expires, path, domain, secure) {
    var curCookie =getCookie(name);
    if (curCookie) {
       //alert (curCookie);
       var arr = curCookie.split(',');  //join('-')
       if(isValueInArr(value,arr)==false) {
          arr.push(value); 
       }
       setCookie(name, arr.join(','), expires, path, domain, secure);
    } else setCookie(name, value, expires, path, domain, secure);
}
function DelFromCookie(name, value, expires, path, domain, secure) {
    var curCookie =getCookie(name);
    if (curCookie) {
       //alert (curCookie);
       var arr = curCookie.split(',');  //join('-')
       if(isValueInArr(value,arr)==true) {
          arr=DelValueArr(value,arr);
          setCookie(name, arr.join(','), expires, path, domain, secure);
       }
    } 
}
//я вроде просто JS сохранил cookie (одну пока со временем до конца сессии)
function getCookie(name) {
    var prefix = name + "=";
    var cookieStartIndex = document.cookie.indexOf(prefix);
    if (cookieStartIndex == -1)
        return null;
    var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length);
    if (cookieEndIndex == -1)
        cookieEndIndex = document.cookie.length;
    return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex));
}
</script>  
<?php
$DR='../images/tree_S/';
$ICON='';
?>
<style>
   a.mask1,a.mask2,a.plus,a.minus,a.hed {
    display: inline-block; 
    width: 16px; 
    height: 25px; 
   }    
   a.mask1       { background: url(<?=$DR.$ICON?>010.png);}
   a.mask1:hover { background: url(<?=$DR.$ICON?>010h.png);}
   a.mask2       { background: url(<?=$DR.$ICON?>011.png);}
   a.mask2:hover { background: url(<?=$DR.$ICON?>011h.png);}
   a.plus        { background: url(<?=$DR.$ICON?>001.png);}
   a.plus:hover  { background: url(<?=$DR.$ICON?>001h.png);}
   a.minus       { background: url(<?=$DR.$ICON?>002.png);}
   a.minus:hover { background: url(<?=$DR.$ICON?>002h.png);}
   a.hed         { background: url(<?=$DR.$ICON?>007.png);}
   a.hed:hover   { background: url(<?=$DR.$ICON?>007h.png);}
   
   a.star0,a.star1, a.obj0 {
    display: inline-block; 
    width: 16px; 
    height: 16px; 
   }   
   a.star0       { background: url(<?=$DR.$ICON?>o001.png);}
   a.star0:hover { background: url(<?=$DR.$ICON?>o001h.png);}
   
   a.star1       { background: url(<?=$DR.$ICON?>o003h.png);}
   a.star1:hover { background: url(<?=$DR.$ICON?>o003.png);}
   a.obj0        { background: url(<?=$DR.$ICON?>o004.png); }
   
   a.object0 {
   marging: 0px 2px;
   color: #ffffff;
   background-color: #ff6666;
   /* white-space: nowrap; */
   text-decoration: none;
   font: bold 12px tahoma;
   
   }
    a.object0:hover { background-color: #993333; }
   
   a.comand {
    color: #333333; 
    font: 12px tahoma;
    vertical-align: 40%;
   }
   a.comand:hover   {color: #999999;}
   a.comand:active  {color: #ff9966;}
   
   a.sel {
    color: #ffffff; 
    font: 14px tahoma;
    vertical-align: 40%;
   }
   a.sel:hover   {color: #ffff00;}
   a.sel:active  {color: #ff9966;}
   
  </style>
<?php
include_once '../Ajax/master/master_connect.php';


include_once ("module/lib/debug.php");
include_once ("module/tree/user.php");
include_once ("module/tree/Tsql.php");
include_once ("module/tree/login.php");


//define ("MODUL","/syss/index.php");
define ("MODUL","");
define ("dTREE","?TREE=");
define ("dB","&DB=");
define ("dFORM","&FORM=");

//--------------------------------Поиск поля в таблице
function isFIELD($FIELD, $TABLE)
{
   $sql_FLD='select '.$FIELD.' from '.$TABLE.' where 0';
   $r= mysql_query($sql_FLD);
   //echo "<p>".$sql_FLD.'=='.$r."</p>";    ///
   if ($r) return true;      //Поле существует
   else    return false;
}
//------------------------------2017.02.07 Добавление (фильтр)
function GET_SHOW_DATA($sql) {
   $r= mysql_query($sql); 
   $row_num=mysql_num_rows($r);

   if ($row_num>0)
   { $row = mysql_fetch_array($r);
     return $row[0];
   }
   else return 0;
}
function InArray(&$array,$elm) {
        $ret=false;
        for ($j=0; $j<count($array);$j++) {
                if ($elm==$array[$j]) {
                    $ret=true;
                    break;
                }
        }
        return $ret;
}    

//--------------------------------Класс чтения дерева
class TiSQL
{
  var  $SQL;
  var  $RESULT;
  var  $ROW_COUNT;
  var  $ROW;
  var  $user;
  var  $admin;
  var  $PERMISSION;

// ID  - с каким значением PARENT собрать данные
// URV - уровень вложения
// Tree - структура для заполнения ДЕРЕВОМ
// CMD ='12,56,57' Id узлов для открытия
// CMD = '' - только нулевой уровень IN
// IN = '' - по CMD
// IN = '2' - открыть до второго уровня вложения
// IN = '999' - понятно что все
 function TiSQL($user,$admin,&$PERMISSION) {
   $this->user=$user; 
   $this->admin=$admin;
   $this->PERMISSION=$PERMISSION;
 } 
  
 function Read( $ID,$URV,&$Tree,&$ITEM,$IN=0)
 {
 //разбор параметров для открытия дерева
     //$ITEM=explode(',',$CMD);

       if ($ID=='')  $EQ='is null';
               else $EQ='="'.$ID.'"';
       //echo "<p>".'$ID='.$ID.'->'.$EQ."</p>";
                                        //2011/09/09 Изменение сортировки вывода дерева меню
       $this->SQL='SELECT
                    STRCMP(
					REPLACE(
					REPLACE(
					REPLACE(TYPE_FORM,"FORM_ADD","1")
					              ,"FORM_EDIT","1")
					              ,"FORM_DELETE","1")
					              ,"1")   AS TF,
                   _TREE.* 
                   -- ,F.USER, F.FINDER, F.FIELD_DATA, F.NAME as sNAME, F.PARENT as fPARENT, F.DATA as uDATA
                    from _TREE 
                    -- LEFT JOIN _FIND F ON F.USER="'.$this->user.'" and _TREE.PARAGRAF=F.PARAGRAF
                    WHERE _TREE.PARENT '.$EQ.'
                    ORDER BY TF,_TREE.PARAGRAF,_TREE.NAME';
                    /*and TYPE_FORM in ("MENU","TABLE","FORM_MENU") and PARENT_TABLE="" */
       //echo "<p>".$this->SQL."</p>";
       
       $this->RESULT=mysql_query($this->SQL);              //Open;
       $this->ROW_COUNT = mysql_num_rows($this->RESULT);

       $ret=$this->ROW_COUNT;
       for ($i=0; $i < $this->ROW_COUNT; $i++)
       {
           $this->ROW = mysql_fetch_array($this->RESULT);    //очередная запись
           //Писать саму запись
           //echo "<p>"."1=".$this->ROW['PARAGRAF'];
         if ($ID=='0.') $this->System();                 //Выполнить системные процедуры первого запуска
         if ($this->isShow()==false)  {
             $ret--;
         } else {
           $Tree->NAME[]=/*$VED. */$this->ROW['NAME'];
           $Tree->PARAGRAF[]=$this->ROW['PARAGRAF'];
           $Tree->PARENT[]=$this->ROW['PARENT'];
           $Tree->ID_TABLE[]=$this->ROW['ID_TABLE'];
           $Tree->ID[]=$this->ROW['id'];
           $Tree->TYPE_FORM[]=$this->ROW['TYPE_FORM'];
           $Tree->PARENT_TABLE[]=$this->ROW['parent_TABLE'];
           $Tree->IN[]=$URV;
           //----------------------------Получить вложенный фильтр
           $sql_find=new Tsql( 'SELECT * 
                                FROM _FIND  WHERE USER="'.$this->user.'" AND PARAGRAF="'.$this->ROW['PARAGRAF'].'" 
                                AND LEVEL>"0" 
                                ORDER BY LEVEL DESC
                                LIMIT 0,1' );
           if ($sql_find->num>0) {
               $sql_find->NEXT();
               $Tree->FINDER[]=$sql_find->row['FINDER'];       //Пользовательский фильтр  FIELD_DATA
               $Tree->FIELD_DATA[]=$sql_find->row['FIELD_DATA'];
               $Tree->PARENT_FIND[]=$sql_find->row['PARENT'];
               $Tree->uNAME[]=$sql_find->row['DATA'];
               //echo "<p/>".$sql_find->sql;
               //echo "<p/>".$sql_find->row['FINDER'].':'.$sql_find->row['FIELD_DATA'].':'.$sql_find->row['PARAGRAF'] ;
               $sql_find->FREE();
           } else {
                $Tree->FINDER[]=null;       
                $Tree->FIELD_DATA[]=null;
                //------------------------------2017.02.07 Добавление (фильтр)
                $Tree->PARENT_FIND[]=null;
                $Tree->uNAME[]=null;
           }
           unset($sql_find);
           //echo "<p>".$URV.' '.$this->ROW['PARAGRAF']." ".$this->ROW['NAME']."</p>";   //
           // echo "<p>".$id.' '.$this->ROW['id']." ".$this->ROW['NAME']."</p>";     //
           //-------------------------получение плюсика (количество продолжения ветви)
           //$Tree->CNT[]=$this->ROW_COUNT;
           //$Tree->CNT[]=$this->GET_CNT('select count(id) as CNT from _TREE where PARENT="'.$this->ROW['PARAGRAF'].'" /*and TYPE_FORM in ("MENU","TABLE","FORM_MENU") and PARENT_TABLE="" */ ');
           //-------------------------выбор узлов открытия  по переданным ID
           $need_IN=InArray(&$ITEM,$this->ROW['id']);  //Входит в uzl

          /*
           //---------------------------получение плюсика
           if ($Tree->CNT[count($Tree->CNT)-1]==0)
                                        $Tree->PLUS[]='@';
           else {
           	      if (($need_IN==true))
           	                            $Tree->PLUS[]='-';
           	      else                  $Tree->PLUS[]='+';
           	    }
            */
          //echo "<p>".'$URV='.$URV.' $IN='.$IN.' $need_IN='.$need_IN."</p>";            //
           //----------------------------------Вызов объекта рекурсивно
           $Tree->PLUS[]='@';  
           $Tree->CNT[]=0;
           $num=count($Tree->CNT)-1;
           if (($URV<$IN) or ($need_IN==true))
           { //каждую нужно просмотреть вглубь
             $iSQL_N = new  TiSQL($this->user,$this->admin,&$this->PERMISSION);
             $cnt=$iSQL_N->Read($this->ROW['PARAGRAF'],$URV+1,&$Tree,&$ITEM,$IN);            // считать все дерево
             $Tree->CNT[$num]=$cnt;
             if ($cnt>0) {    //---------------------------получение плюсика
                 if ($need_IN==true) $Tree->PLUS[$num]='-';
           	 else                $Tree->PLUS[$num]='+';
             }
             unset($iSQL_N); 
           }
         }  
       }
       mysql_free_result($this->RESULT);
       return $ret;
 }
 function System() {   //Выполнить системные процедуры первого запуска
    if ($this->ROW['sys_SQL']<>'') {
        $SQL=explode(';',$this->ROW['sys_SQL']);
        for ($i=0;$i<count($SQL);$i++) {
            //if (strpos($SQL[$i],'$id_user')>0) {
            //}
            mysql_query($SQL[$i]);
            //echo "<p/>$i:".$SQL[$i];
            
            $IS= new Tsql('SELECT @id_user,@from_R0,@from_R1,@from_R2,@from_work,@from_nariad');
            if ($IS->num>0) {
                $IS->NEXT();
              
             
                /*
                echo '<p/>';
                //current($IS->row);
                //key($IS->row[$k]);
                for($k=0;$k<count($IS->row);$k++) {
                    echo ' '.$k.': '.$IS->row[$k];
                }
                
                echo '<p/>';
                $k=0;
                $arr=current($IS->row);
                do {
                    echo ' '.$k++.': '.key($arr).'='.$arr;
                }   while ($arr=next($IS->row));
                */
                /*
                echo "<p/>".' @id_user='.$IS->row['@id_user']
                        .' @from_R0='.$IS->row['@from_R0']
                        .' @from_R1='.$IS->row['@from_R1']
                        .' @from_R2='.$IS->row['@from_R2']
                        .' @from_work='.$IS->row['@from_work']
                        .' @from_nariad='.$IS->row['@from_nariad'];*/
            }
        }
    } 
 } 
 
 function isShow() { 
     $show=true;
     
     if ($this->admin==false)    //это не админ - показывать выборочно строки
     {

       switch($this->ROW['TYPE_FORM'])
        { case 'MENU_SYS':            // Не должна быть определена
          case 'FORM_ADD':
          case 'FORM_DELETE':
          case 'FORM_EDIT':
                $show=false;
                break;
          case 'TABLE':
          case 'TABLE_XY':
          case 'TABLE_XYi':
                if ($this->ROW['parent_TABLE']<>'')
                    $show=false;
                break;
        }
        if($show)
        {                        //??Прописывать права прямо в дерево в дополнительное поле
          $PRM=find_permission(&$this->PERMISSION,$this->ROW['PARAGRAF']);  //Права на параграф
          if (if_permission($PRM,'r')==false)
              $show=false;
        }
     }
     return $show;
  }
} //class

class TTree
 {
//----------------------массивы для заполнения
  var  $PARAGRAF =array();         //параграфф
  var  $PARENT =array();       //родительский параграфф (наверное ненужен)
  var  $ID_TABLE =array();
  var  $IN =array();           //номер вложенности. Всегда в возрастающей последоватльности
  var  $FINDER=array();        //значение поля фильтра
  var  $FIELD_DATA=array();    //Наименование поля фильтра
  //var  $FIELD_SHOW=array();    //Наименование поля отображения //------2017.02.07 Добавление (фильтр)
  var  $PARENT_FIND=array();    //6-Родительский параграф фильтра
  var  $uNAME=array();         //Значение поля отображения
  var  $ID =array();           //ID параграфа
  var  $NAME =array();         //наименование параграфа
  var  $TYPE_FORM=array();
  var  $PARENT_TABLE=array();  //Родительская таблица
  var  $CNT =array();         //количество дочек ITEM
  var  $PLUS =array();         // + - ()

 //var  $COUNT;        //количество (сквозное) узлов дерева

  function TTree()
  {
  	//$this->PARAGRAF=0;
  	//$this->PARENT=0;
  	//$this->PARENT=0;
  	//$this->COUNT=0;         ///??????
  }

  // $uzl - начальный узел
  // $sql_OBJ - указатель на _TREE OBJ
  //-----------------------показать дерево
  
  function Show($HBS,$uzl,&$ROW_role)
  {
    //echo '<div id="main">';
    $LEVEL=-1;
    $devL='';
    echo '<ul class="links" >';
    $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));
    $DR='../images/tree_S/';

    $admin=if_role_admin(&$ROW_role);       //true->admin

    for ($i=0; $i<count($this->ID);$i++)
    {
       
      if ($this->uNAME[$i]<>'')    //Пользовательский фильтр на ветку  (сердечко)
              {
	  	           //Есть ли это поле в таблице???
	  	          if ( isFIELD($this->FIELD_DATA[$i], $this->ID_TABLE[$i]) )
	  	                 $CLASS='class="mask1"'; // 'heart_outline.png; //Поле существует
                          else   $CLASS='class="mask2"'; // 'heart_outline.png'; //не существует



                  $MASK= '<a href='.MODUL.dTREE.$this->PARENT_FIND[$i]
                          .$PR.dB.$HBS
                          .'&cmd=del:'.$this->FINDER[$i].':'.$this->PARENT_FIND[$i]
                          //.'&uzl='.$uzl
                          .'&li='.$this->ID[$i]
                          .'&FORM='.$this->PARENT_FIND[$i].'#YK'
                       .' '.$CLASS   
                       .' title="'.$this->uNAME[$i].'">'
                          . '</a>';

      } else $MASK=''; //фильтр
      //-----------------------------------Формирование div
      if ($LEVEL>$this->IN[$i]) {             //уменьшение уровня
          //echo "<p/> step ------level_old=".$LEVEL.' new='.$this->IN[$i].' ['. implode(',',$LV).'] count='.count($LV).' x='.(($this->IN[$i])-$LEVEL);
          for($k=0; $k<$LEVEL-$this->IN[$i]; $k++) {
            echo '</div>';  //Возврат
            unset($LV[($LEVEL-$k)]);
          }
          $LV=array_values($LV);
          //$LV=array_splice($LV,(($this->IN[$i])-$LEVEL));
          //echo "<p/> step ------level_old=".$LEVEL.' new='.$this->IN[$i].' ['. implode(',',$LV).'] count='.count($LV);
          //$LV[(int) $this->IN[$i] ]=$this->CNT[$i];
      } elseif ($LEVEL<$this->IN[$i]) {       //увеличение уровня
          echo $devL;                              //Новый div
          //echo "<p/> step 1:".$this->IN[$i];
          $LV[]=-1;
      } else {                                //тот же уровень
        //$LV[(int) $LEVEL]=$this->CNT[$i];  
      }
      $VED=''; 
      
      $le3='<img src="'.$DR.'003.png" />';
      $le5='<img src="'.$DR.'005.png" />';
      $le9='<img src="'.$DR.'009.png" />';
      $le6='<img src="'.$DR.'006.png" />';
      $le4='<img src="'.$DR.'004.png" />';
       
      $LEVEL=$this->IN[$i];
      $LV[(int) $LEVEL]=$this->CNT[$i];
      //echo "<p/>in=".$this->IN[$i].' cnt='.$this->CNT[$i].':'.$this->PLUS[$i]."[". implode(',',$LV).']';
       // echo "<pre>";
       //print_r($LV);
       // echo "</pre>";
      if($admin) { $le05=$le5; $le06=$le6; }
      else       { $le05=''; $le06=''; }
      for($k=0; $k<$LEVEL; $k++) {           //Построение линейки
          if ($k==($LEVEL-1)) {        //Последний уровень 
            if ($MASK<>'') {
                if ($LV[$k]==1)      { $VED.=$le4.$le05.$MASK; $LV[$k]--; }
                elseif  ($LV[$k]==0) { $VED.=$le6.$le06.$le6; }
                else                 { $VED.=$le3.$le05.$MASK; $LV[$k]--;} 
            } else {    
                if ($LV[$k]==1)      { $VED.=$le4.$le05.$le5; $LV[$k]--; }
                elseif  ($LV[$k]==0) { $VED.=$le6.$le06.$le6; }
                else                 { $VED.=$le3.$le05.$le5; $LV[$k]--;}
            }
          } else {
            if ($LV[$k]==1)      { $VED.=$le9.$le06.$le6; }  //$VED.=$le4.$le5.$le5;
            elseif ($LV[$k]==0)  { $VED.=$le6.$le06.$le6; }
            else                 { $VED.=$le9.$le06.$le6; } 
          }
      }
      
                              // Определение цвета фона
      
      $OP='';
      //----------------------Якорь, чтобы форма была видна - 2017.02.07
      $comm='comand';
      $BRCOLOR='background-color: white;';        //#FFFFFF  white silver
      if (array_key_exists('TREE', $_GET))
      { if ($this->PARAGRAF[$i]===$_GET["TREE"])    //это текущая строка (выделить)
        {  
          $BRCOLOR='background-color: '.$ROW_role['color1'].';';
          $comm='sel';
          $YK_TREE=$_GET["TREE"];
          $OP='<a name="YK"></a>';
        }
        else {
            $YK_TREE='';
            if ($this->PARENT[$i]===$_GET["TREE"])          //Подразделы
                $BRCOLOR='background-color: '.$ROW_role['color2'].';';
            elseif (!(strpos($this->PARENT[$i],($_GET["TREE"].'.'))===false))
                $BRCOLOR='background-color: #eee9f7;';   //#eee9f7
                
        }
        // Это темный фон
      } 
         //if ($this->TYPE_FORM[$i]=='STOP')
         //$FCOLOR='color: #FF9999;';
          
      $STL=' style="padding: 0px 4px; line-height: 80%; width: 500px;'.$BRCOLOR.'"';   //$FCOLOR.
      echo '<li '.$STL.'><NOBR>';         //type="1" <NOWRAP>  <div NOWRAP> style="'.$BRCOLOR.$FCOLOR.'"
      //echo '<span></span>';

              $PR=''; $FONT='';  $FE='';
              if (array_key_exists('PR', $_GET)==true)
	  	      { $PRF=explode(':',$_GET["PR"]);   //id:pref:paragraf
	  	        $SM=strpos( $this->PARAGRAF[$i],$PRF[2]);
	  	        if (!($SM===false) and $SM==0)   //По параграфу
	  	        //if ($PRF[2]==$this->PARENT[$i])                   //По паренту
	  	        {    $PR='&PR='.$_GET["PR"];
	  	             $FONT='<font color="'.green.'">';
	  	             $FE='</font>';
	  	        }
              }
              

      
      echo '<a>'.$VED.'</a>';
     
      
      if ($this->PLUS[$i]=='-')     { $disp_m='inline-block'; $disp_p='none'; }
      elseif ($this->PLUS[$i]=='+') { $disp_p='inline-block'; $disp_m='none'; }
      $devL='';
      switch ($this->PLUS[$i])    //Это узел
      {
        case '@':                      //выбор иконки по дереву
          echo '<a ><img src="'.$DR.'005.png" alt="узел" /></a>';
          break;
        case '-':
        case '+':                   //inline-block
            $devL='<div style="display:'.$disp_m.';" id="level'.$this->ID[$i].'">';
          echo
            '<div style="display:'.$disp_m.';" id="minus'.$this->ID[$i].'">'
            .'<a class="minus"'
                  .' title="Закрыть"  onclick="visiMINUS(\''.$this->ID[$i].'\')"'
                  . '></a></div>';
          echo 
            '<div style="display:'.$disp_p.';" id="plus'.$this->ID[$i].'">'
            .'<a class="plus"'
                  .' title="Открыть" onclick="visiPLUS(\''.$this->ID[$i].'\')"'
                  . '></a></div>';
          break;
      /*
          echo '<a href='.MODUL.dTREE.$this->PARAGRAF[$i].$PR.dB.$HBS.'&cmd=minus'.'&uzl='.$uzl.'&li='.$this->ID[$i]
          .' title="Закрыть"><img src="'.$DR.'minus.gif" alt="Закрыть" /> </a>';
          break;
        case '+':
          echo '<a href='.MODUL.dTREE.$this->PARAGRAF[$i].$PR.dB.$HBS.'&cmd=plus'.'&uzl='.$uzl.'&li='.$this->ID[$i]
          .' title="Открыть"><img src="'.$DR.'plus_red.jpg" alt="Открыть" /> </a>';
          break;
       * 
       */
      }
      //---------вывод метки заголовка формы редактирования _TREE
      if($admin)
      echo '<a class="hed" href='.MODUL.dTREE.$this->PARAGRAF[$i].dB.$HBS
              //.'&uzl='.$uzl
              .'&li='.$this->ID[$i]
                           .dFORM.'sys'.'&id='.$this->ID[$i] /* $this->PARAGRAF[$i]   .'&atr=sys'  */
                     .' title="Редактировать заголовок формы"></a>';

      //---------вывод метки формы  ////
      if($admin==true)$href='<a href='.MODUL.dTREE.$this->PARAGRAF[$i].dB.$HBS
              //.'&uzl='.$uzl
              .'&li='.$this->ID[$i]
                            .dFORM.'sys.table'.'&in='.$this->PARAGRAF[$i]; /* $this->PARAGRAF[$i] .'&atr=sys'  */
      else            $href='';
      switch ($this->TYPE_FORM[$i])
      {
        case 'TABLE':
             if($admin==true) $ttl=' title="Таблица">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'tabl.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'TABLE_XY':
        case 'TABLE_XYi':
             if($admin==true) $ttl=' title="Таблица">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'application_osx_edit.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'TABLE_KIND':
             if($admin==true) $ttl=' title="Таблица свойств">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'application_windows.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;                  //calendar_month_edit.png                            //application_windows.png
        case 'TABLE_OBJ':
             if($admin==true) $ttl=' title="Таблица объектов">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'star_full.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM_MENU':
             if($admin==true) $ttl=' title="Форма меню">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'pad.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM':
             if($admin==true) $ttl=' title="Форма">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'form.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM_ADD':
             if($admin==true) $ttl=' title="Добавить форму">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'form_add.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM_EDIT':
             if($admin==true) $ttl=' title="Редактировать форму">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'form_edit.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM_DELETE':
             if($admin==true) $ttl=' title="Удалить форму">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'form_delete.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'MENU':
             if($admin==true) $ttl=' title="Строка Меню">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'menu.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'STOP':
             if($admin==true) $ttl=' title="Стоп">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'stop.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'MENU_SYS':
             if($admin==true) $ttl=' title="Системное меню">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'key.png" border="2" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM_MAKE':
             if($admin==true) $ttl=' title="Создать форму">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'form_new.png"  alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM_COPY':
             if($admin==true) $ttl=' title="раскопировать форму">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'calendar_week_add.png"  alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM_MASTER':
             if($admin==true) $ttl=' title="Создать MASTER">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'zoom.png"  alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM_MASTER_XY':
             if($admin==true) $ttl=' title="Создать MASTER XY">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'search.png"  alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM_RUN':
             if($admin==true) $ttl=' title="Форма выполнения">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'arrow_right.png"  alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        case 'FORM_PREF':
             if($admin==true) $ttl=' title="Форма префиксов">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'menu_dropdown.png"  alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
        default:
             if($admin==true) $ttl=' title="Неизвестная форма">'; else $ttl='';
             echo $href.$ttl
                     .'<img src="'.$DR.'error.png" alt="'.$this->TYPE_FORM[$i].'" /></a>';
             break;
      }
      //----------------------Якорь, чтобы форма была видна - 2017.02.07
      if (array_key_exists('TREE', $_GET)) {$YK_TREE=$_GET["TREE"]; } else $YK_TREE=''; 
      if ($this->PARAGRAF[$i]===$YK_TREE)
         echo $OP; 
      
      //------------------просмотр формы этого параграфа на предмет незаполненности
      $SQL_F= new Tsql('select * from _FORM where PARAGRAF="'.$this->PARAGRAF[$i].'"');
      if ($SQL_F->num>0)  //форма определена
      {  switch($this->TYPE_FORM[$i])
         { case 'MENU_SYS':            // Но не должна быть определена
           case 'MENU':
           case 'FORM_MAKE':
           case 'FORM_COPY':
           case 'FORM_RUN':
           case 'FORM_PREF':
                 echo '<a title="лишнее определение формы"><img src="'.$DR.'warning.png" alt="лишнее определение формы" /> </a>';
                 break;
           default:
                 //echo '<a ><img src="'.$DR.'burst.png" alt="ок" /> </a>';
                 //break;
                 continue;
         }
      }
      else  //форма не определена
      { switch($this->TYPE_FORM[$i])
        { case 'MENU_SYS':            // Не должна быть определена
          case 'MENU':
          case 'FORM_MAKE':
          case 'FORM_COPY':
          case 'FORM_RUN':
          case 'FORM_PREF':
                break;
          default:
                echo '<a title="форма незаполненна"><img src="'.$DR.'error_small.png" alt="форма не определена" /> </a>';
        }
      }
      //---------вывод ссылки
     // if (strpos( $this->PARAGRAF[$i],'sys')===false) //это обычная форма
     // {
      //$STL='style="vertical-align: 50%; "';  //'.$FCOLOR.'
      switch ($this->TYPE_FORM[$i])
      { case 'TABLE':
        case 'TABLE_XY':
        case 'TABLE_XYi':
        case 'TABLE_KIND':
        case 'TABLE_OBJ':
        case 'FORM_MENU':
        case 'FORM':
//        case 'FORM_ADD':
//        case 'FORM_EDIT':
//        case 'FORM_DELETE':
        case 'FORM_MASTER':
        case 'FORM_MASTER_XY':
        case 'FORM_RUN':
        case 'FORM_PREF':
        case 'STOP':
        case 'MENU_SYS':
        /*
              $PR=''; $FONT='';  $FE='';
              if (array_key_exists('PR', $_GET)==true)
	  	      { $PRF=explode(':',$_GET["PR"]);   //id:pref:paragraf
	  	        if ($PRF[2]==$this->PARENT[$i])                   //По паренту
	  	        //if (strpos( $this->PARAGRAF[$i],$PRF[2])===false);   //По параграфу
	  	        //else
	  	        {    $PR='&PR='.$_GET["PR"];
	  	             $FONT='<font color="'.green.'">';
	  	             $FE='</font>';
	  	        }
              }
              $OBJ_MODE='';
              if (array_key_exists('OBJ', $_GET)==true)
	  	      { $OBJ=explode(':',$_GET["OBJ"]);   //id:pref:paragraf
	  	        //if ($OBJ[1]==$this->PARENT[$i])            //По паренту
	  	        //echo '/n ['.$this->PARAGRAF[$i].'='.$OBJ[1].']';
	  	        $SM=strpos( $this->PARAGRAF[$i],$OBJ[1]);
	  	        if (!($SM===false) and $SM==0)   //По параграфу
	  	        {    $OBJ_MODE='&OBJ='.$_GET["OBJ"];
	  	             $FONT='<font color="'.green.'"><b>';
	  	             $FE='</b></font>';
	  	        }
              }
         */
              echo '<a class="'.$comm.'" href='.MODUL.dTREE.$this->PARAGRAF[$i].dB.$HBS
                //.'&uzl='.$uzl
                .'&li='.$this->ID[$i]
                   .dFORM.$this->PARAGRAF[$i].$PR.'#YK>'
                   .$FONT.' '.$this->NAME[$i].$FE.'</a>';         //</font>  </span>
              break;
        case 'FORM_ADD':
        case 'FORM_EDIT':
        case 'FORM_DELETE':
              echo '<a class="'.$comm.'" style="color: #999999;">'.' '.$this->NAME[$i].'</a>';    //</font>
              break;
        default:      /*$this->ID[$i].' '.$this->CNT[$i].' '.$this->PLUS[$i].' '.$this->IN[$i].*/
              echo '<a class="'.$comm.'" style="color: #999999;"><b>'.' '.$this->NAME[$i].'</b></a>';    //</font>
      }
      //if($admin) 
          echo '<a class="'.$comm.'" >'.' '.$this->PARAGRAF[$i].'</a>';        //Вывод параграфа
      //else
      //{                 //Получить права на меню
      //}
      echo '</NOBR></li>';

      //Рисовать дерево
      //if ($Tree->PLUS[$i]>0)   //Это узел - его надопоказать [+]Если он
    } //for
    if ($LEVEL>$this->IN[$i]) {
          echo '</dev>';
    }      
    echo '</ul>';  //</div>';
    //echo "<script language=javascript>location.hash='TR';</script>";
  }
 }

//-----------------------вывести кнопку UL
  function UL($HBS,$user)
  {
    //include("connect/connect.php");
    $base=new Thost2;
    echo '<ul class="links" >';
    echo '<li>';
        echo '<a onclick="setCookie(\'uzl\',\'\')"'
                .' href='.MODUL.dTREE.dB.$HBS
                //.'&uzl='
                .' title="Закрыть все"><img src="http:../images/tree_S/log1.png" alt="Минимизировать меню" /></a>';
       // echo '<a href='.MODUL.'&do='.$this->PARAGRAF[$i].'&cmd=minus'.'&uzl='.$uzl.'&id='.$this->ID[$i].' title="Закрыть"><img src="http://www.ulyanovskmenu.ru/images/tree/minus.gif" alt="Закрыть" /></a>';

        echo '<a href=?'.' title="Logout"><b><font face="cursive" color="grey"> '
                //.$HBS.'>>'
                .$base->H[$HBS][0]
                //.' '.$base->H[$HBS][1]
                .' ['.$user.']</font></b></a>';
       // echo '<a href='.MODUL.dTREE.dB.$HBS.'&login'.'&uzl='.' title="Login"><b><font face="cursive" color="grey"> '.$user.'</font></b></a>';


//        echo '<b><font face="cursive" color="grey"> '.$user.'</font></b>';
      echo '</li>';
    echo '</ul>';
  }
//---------------------------Вычислить уровень вложености OBJ (начиная с 1)
function GetObjLevel($parent) {
    $level=1;
    //echo "<p>begin parent=$parent";
    do {
       $sql = new Tsql('select TYPE_FORM,PARENT from _TREE where PARAGRAF="'.$parent.'"');    
       if ($sql->num>0) {
           $sql->NEXT();    
           if ($sql->row["TYPE_FORM"]=='TABLE_OBJ') $level++;
           $parent=$sql->row["PARENT"];
           if ($parent=='0.') break;
           //echo "<p>parent=$parent";
        }
        $sql->FREE();
        unset($sql);
    } while (1==1);
    $sql->FREE();
    unset($sql);
    return $level;
}

//---------------------------Установить фильтр объекта на ветвь
function SET_OBJ($user) {
    if (array_key_exists('OBJ', $_GET)==true)
    { $OBJ=explode(':',$_GET["OBJ"]);   //id:parent:table:field_show          2:6:i_town:town
        $sql_OBJ = new Tsql('select * from _TREE where PARAGRAF="'.$OBJ[1].'"');
        if ($sql_OBJ->num>0)
        {   $sql_OBJ->NEXT();
            { 
              $level=GetObjLevel($sql_OBJ->row["PARENT"]);  
              //echo "<p>level=$level";
              $sql_DEL=new Tsql( 'delete from _FIND where USER="'.$user.'" and PARAGRAF like "'.$OBJ[1].'%" and PARAGRAF<>"'.$OBJ[1].'" AND LEVEL>="'.$level.'"',1);
              //echo "<p>".$sql_DEL->sql."</p>";   ///

              $sql_data=new Tsql('select '.$OBJ[3].' from '.$OBJ[2].' where id="'.$OBJ[0].'"');
              if ($sql_data->num>0) {
                  $sql_data->NEXT();
                  $data=$sql_data->row[0];  //Наименование фильтра
              }
              $sql_data->FREE();
              $sql_INS=new Tsql( 'insert into _FIND (USER,PARAGRAF,LEVEL,FINDER,FIELD_DATA,NAME,PARENT,DATA) SELECT '
                                .'"'.$user.'",'
                        .PARAGRAF
                        .',"'.$level.'"'
                        .',\''.$OBJ[0].'\',"'.$sql_OBJ->row["sys_BUTTON"].'","'.$OBJ[2].';'.$OBJ[3].'","'.$OBJ[1].'","'.$data.'"'
                                .' FROM _TREE where PARAGRAF like "'.$OBJ[1].'%" and PARAGRAF<>"'.$OBJ[1].'"',1);

       //echo "<p>".$sql_INS->sql."</p>";   ///
            }
        }
    }
}


?>
<html>
   <!-- левая половина -->

<?php //  Пример использования класса TiSQL и TTree
//  $Tree = new  TTree;
//  $iSQL = new  TiSQL;
//  $iSQL->Read('1.',0,&$Tree,'11,1,20',0);            // считать все дерево
//  $Tree->Show();
//  ========================cmd    uzl   id
//                          plus
//                          minus
//  $HBS=-1;            //&DB=0
//  LOG_HBase(&$HBS);
  $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));
  SET_OBJ($user);           //Установить фильтр

  $uzl='';
  if (array_key_exists('uzl', $_COOKIE))
      $uzl=$_COOKIE['uzl'];
  $ITEM=explode(',',$uzl);
  //echo "<p> uzl=$uzl";
  
  //echo_PP('GET_uzl',$_GET['uzl']); 
  /*
  if (array_key_exists('uzl', $_GET) and $_GET['uzl']<>'')   //Разбор узлов
  { $ITEM=explode(',',$_GET["uzl"]);
  }
  */

  if (array_key_exists('cmd', $_GET))
  { $CMD=explode(':',$_GET["cmd"]);
    switch ($CMD[0])
    { case  'plus':
                     $ITEM[]=$_GET["li"];
                     break;
      case  'minus':
                     for($k=0; $k<count($ITEM);$k++)  //Удаление из массива
                     { if ($ITEM[$k]<>$_GET['li'])
                           $IT[]=$ITEM[$k];
                     }
                     $ITEM=$IT;
                     break;
      case 'del':
                     $sql_DEL=new Tsql('delete from _FIND where USER="'.$user.'"'
                             //. ' and PARENT="'.$CMD[2].'"'
                             . ' and FINDER="'.$CMD[1].'" and LEVEL>"0"',1);
                     break;

    }

  }
  //----------------------------------Настройка на пользователя
  $PERMISSION = new  TRight;
  get_permission($user, &$PERMISSION);         //права
  $ROW_role=get_role($user);                   //Роль
  $admin=if_role_admin(&$ROW_role);
  
  $Tree = new  TTree;
  mysql_query("SET NAMES 'utf8'");
  $iSQL = new  TiSQL($user,$admin,&$PERMISSION);
  $iSQL->Read('0.',0,&$Tree,&$ITEM,999);            // считать все дерево $uzl-<$ITEM
  unset($iSQL);  
  UL($HBS,$user);


  //echo 'ROW_role='.$ROW_role;

  if(count($ITEM)==0) $uzl='';
  else $uzl=implode(',',$ITEM);
  //echo_PP('new_uzl]',$uzl);     //
  $Tree->Show($HBS,$uzl,&$ROW_role);      //рисовать дерево
  //UL();

