<?
class TCOMA
{   var $BUF;
    var $TEK;
    var $LEN;
    var $COUNT;

    function TCOMA()       //������������ ���������� �������
    {

    }

function First()    //��������� ���������� ������
{
 $this->TEK=0;
 $this->COUNT=0;
}

function Next()     //��������� ��������� �� ������ ������,�������� �� �����������
{
  for ($i=$this->TEK; $i<$this->LEN; $i++)
  {
     if (!  (($this->BUF[$i]==' ')
          or ($this->BUF[$i]==',')
          or ($this->BUF[$i]==':')
          or ($this->BUF[$i]==';')
          or ($this->BUF[$i]<'!')))
             break;
  }
  $this->TEK=$i;
}


function  Next_CH($CH)   //��������� ��������� �� ������ ������,�������� �� ���������� �����������
{
  for ($i=$this->TEK; $i<$this->LEN; $i++)
  {   if (! ($this->BUF[$i]==$CH))
            break;
  }
  $this->TEK=$i;
}

function Open($STR)
{ $this->BUF=$STR;
 $this->LEN=strlen($STR);
 $this->First;
 //$this->Next;
}

function Open_CH($STR,$CH)
{ $this->BUF=$STR;
 //echo_PP('BUF',$this->BUF);   //

 $this->LEN=strlen($STR);
 $this->First;
 $this->Next_CH($CH);
}


function Eof()
{
   //echo_PP('BUF',$this->BUF);   //
   //echo_PP('TEK',$this->TEK);   //
   //echo_PP('LEN',$this->LEN);   //
  if (($this->BUF=='') or   ($this->TEK>=$this->LEN))
     return true;
  else
     return false;
}


function Get()         //�������� ��������� item

{
 $ST='';
 for( $i=$this->TEK; $i<$this->LEN ;$i++)
 {    if     (($this->BUF[$i]==' ')
          or ($this->BUF[$i]==',')
          or ($this->BUF[$i]==':')
          or ($this->BUF[$i]==';')
          or ($this->BUF[$i]<'!'))
              break;
      $ST.=$this->BUF[$i];
 }
 $this->TEK=$i;
 $this->COUNT++;
 return $ST;
}


function Get_CH($CH)         //�������� ��������� item �� ���������� �����������
{
 $ST='';
 for( $i=$this->TEK; $i<$this->LEN ;$i++)
 {   if ($this->BUF[$i]==$CH)
         break;
     $ST.=$this->BUF[$i];
 }
 $this->TEK=$i;
 $this->COUNT++;
 return $ST;
}


// ������ - ������� ���������� $_POST["do"] �� items � ������ $ITEM
/*
   $COMA= new TCOMA('one,two,three');
   $COMA->Open_CH(',');
   while ($COMA->Eof()==false)
   { $ITEM[$COMA->COUNT]=$COMA->Get_CH(',');
     $COMA->Next_CH(',');
   }
*/
} //class

 function echo_PP($nam,$dat)
    {  echo "<p>[".$nam.' = '.$dat."]</p>";
	}

?>