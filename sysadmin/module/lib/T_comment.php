<?php
include("module/tree/coma.php");

class T_comment
{
  var  $SQL;
  var  $RESULT;
  var  $ROW_COUNT;
  var  $ROW;

//$ID - начальный id чтени€
//$URV - ”ровень. ѕри первом вызове =0
//$Tree - —труктура,куда в пам€ть считаетс€ вс€ информаци€
//$CMD - узлы через зап€тую,которые необходимо раскрыть
//$IN - ”ровень открыти€ вложенности
 function Read( $ID,$URV,&$Tree,$CMD,$IN=0)
 {
 //разбор параметров дл€ открыти€ дерева
     $ITEM=explode(',',$CMD);
/*
     $COMA= new TCOMA;
     $COMA->Open_CH($CMD,',');

     while ($COMA->Eof()==false)
     {
       $ITEM[]=$COMA->Get_CH(',');
       //echo_PP("COMA->COUNT",$COMA->COUNT);
       //echo_PP("ITEM",$ITEM[$COMA->COUNT-1]);
       $COMA->Next_CH(',');
     }
*/
       if ($ID==0)  $EQ='is null';         //твой случай
               else $EQ='="'.$ID.'"';      //возможно без ковычек

       //$VED='';                                   //Ёто дл€ отступа  - думаю тебе надо использовать $IN после при выводе - =количеству табул€ций
       //for ($i=0; $i<$URV;$i++) $VED.='........';

       $this->SQL='SELECT * from news_comments WHERE id_comments '.$EQ.'  ORDER BY datetime';   //тут еще id_new использовать чтобы локализовать коментарии
       //echo "<p>".$this->SQL."</p>";
       $this->RESULT=mysql_query($this->SQL);              //Open;
       $this->ROW_COUNT = mysql_num_rows($this->RESULT);

       for ($i=0; $i < $this->ROW_COUNT; $i++)              //ѕросмотр комментариев относ€щихс€ к одной новости
       {
           $this->ROW = mysql_fetch_array($this->RESULT);    //очередна€ запись
           //ѕисать саму запись
           $Tree->text[]       =$this->ROW['text'];
           $Tree->id[]         =$this->ROW['id'];
           $Tree->id_comments[]=$this->ROW['id_comments'];
           $Tree->id_news[]    =$this->ROW['id_news'];
           $Tree->id_user[]    =$this->ROW['id_user'];
           $Tree->datetime[]   =$this->ROW['datetime'];

           $Tree->IN[]=$URV;
           //echo "<p>".$URV.' '.$this->ROW['PARAGRAF']." ".$this->ROW['NAME']."</p>";

           //-------------------------получение плюсика (количество продолжени€ ветви)
 //          $Tree->PLUS[]=$this->GET_COUNT('select count(ID) from _TREE where PARENT="'.$this->ROW['PARAGRAF'].'"');
           //-------------------------выбор узлов открыти€  по переданным ID
           $need_IN=false;

 //          for ($j=0; $j<$COMA->COUNT;$j++)
           for ($j=0; $j<count($ITEM);$j++)
             { if ($this->ROW['id']==$ITEM[$j])
             {   $need_IN=true;
                 break;             }           }

           //----------------------------------¬ызов объекта рекурсивно
           if (($URV<$IN) or ($need_IN==true))
           { //каждую нужно просмотреть вглубь
             $TCom_N = new  T_comment;
             $TCom_N->Read($this->ROW['id'],$URV+1,&$Tree,$CMD,$IN);            // считать все дерево
           }
       }
 }
}
?>

<?php
 class TTree
 {

//----------------------массивы дл€ заполнени€
  var  $text =array();
  var  $id =array();
  var  $id_comments =array();
  var  $id_news =array();
  var  $id_user =array();
  var  $datetime =array();
  var  $IN =array();       //вложенность
  //var  $COUNT;        //количество (сквозное) узлов дерева
 }
?>

<html>
 <head>
 </head>

 <body>


<?php //  ѕример использовани€ класса TiSQL и TTree
  $Tree = new  TTree;
  $TCom = new  T_comment;
  $TCom->Read('1.',0,&$Tree,'',999);            // считать все дерево
 // $iSQL->Read('1.',0,&$Tree,'11,20,14,1',0);            // считать все дерево

  for ($i=0; $i<count($Tree->id);$i++)
  { echo "<p>".$Tree->id[$i].' '.$Tree->IN[$i].' '.$Tree->datetime[$i].' '.$Tree->text[$i]."</p>";  }
?>
 </body>
</html>
