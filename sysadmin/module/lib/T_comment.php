<?php
include("module/tree/coma.php");

class T_comment
{
  var  $SQL;
  var  $RESULT;
  var  $ROW_COUNT;
  var  $ROW;

//$ID - ��������� id ������
//$URV - �������. ��� ������ ������ =0
//$Tree - ���������,���� � ������ ��������� ��� ����������
//$CMD - ���� ����� �������,������� ���������� ��������
//$IN - ������� �������� �����������
 function Read( $ID,$URV,&$Tree,$CMD,$IN=0)
 {
 //������ ���������� ��� �������� ������
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
       if ($ID==0)  $EQ='is null';         //���� ������
               else $EQ='="'.$ID.'"';      //�������� ��� �������

       //$VED='';                                   //��� ��� �������  - ����� ���� ���� ������������ $IN ����� ��� ������ - =���������� ���������
       //for ($i=0; $i<$URV;$i++) $VED.='........';

       $this->SQL='SELECT * from news_comments WHERE id_comments '.$EQ.'  ORDER BY datetime';   //��� ��� id_new ������������ ����� ������������ ����������
       //echo "<p>".$this->SQL."</p>";
       $this->RESULT=mysql_query($this->SQL);              //Open;
       $this->ROW_COUNT = mysql_num_rows($this->RESULT);

       for ($i=0; $i < $this->ROW_COUNT; $i++)              //�������� ������������ ����������� � ����� �������
       {
           $this->ROW = mysql_fetch_array($this->RESULT);    //��������� ������
           //������ ���� ������
           $Tree->text[]       =$this->ROW['text'];
           $Tree->id[]         =$this->ROW['id'];
           $Tree->id_comments[]=$this->ROW['id_comments'];
           $Tree->id_news[]    =$this->ROW['id_news'];
           $Tree->id_user[]    =$this->ROW['id_user'];
           $Tree->datetime[]   =$this->ROW['datetime'];

           $Tree->IN[]=$URV;
           //echo "<p>".$URV.' '.$this->ROW['PARAGRAF']." ".$this->ROW['NAME']."</p>";

           //-------------------------��������� ������� (���������� ����������� �����)
 //          $Tree->PLUS[]=$this->GET_COUNT('select count(ID) from _TREE where PARENT="'.$this->ROW['PARAGRAF'].'"');
           //-------------------------����� ����� ��������  �� ���������� ID
           $need_IN=false;

 //          for ($j=0; $j<$COMA->COUNT;$j++)
           for ($j=0; $j<count($ITEM);$j++)
             { if ($this->ROW['id']==$ITEM[$j])
             {   $need_IN=true;
                 break;             }           }

           //----------------------------------����� ������� ����������
           if (($URV<$IN) or ($need_IN==true))
           { //������ ����� ����������� ������
             $TCom_N = new  T_comment;
             $TCom_N->Read($this->ROW['id'],$URV+1,&$Tree,$CMD,$IN);            // ������� ��� ������
           }
       }
 }
}
?>

<?php
 class TTree
 {

//----------------------������� ��� ����������
  var  $text =array();
  var  $id =array();
  var  $id_comments =array();
  var  $id_news =array();
  var  $id_user =array();
  var  $datetime =array();
  var  $IN =array();       //�����������
  //var  $COUNT;        //���������� (��������) ����� ������
 }
?>

<html>
 <head>
 </head>

 <body>


<?php //  ������ ������������� ������ TiSQL � TTree
  $Tree = new  TTree;
  $TCom = new  T_comment;
  $TCom->Read('1.',0,&$Tree,'',999);            // ������� ��� ������
 // $iSQL->Read('1.',0,&$Tree,'11,20,14,1',0);            // ������� ��� ������

  for ($i=0; $i<count($Tree->id);$i++)
  { echo "<p>".$Tree->id[$i].' '.$Tree->IN[$i].' '.$Tree->datetime[$i].' '.$Tree->text[$i]."</p>";  }
?>
 </body>
</html>
