<?php

//------------------------------Класс SQL для чтения файлов
class Tsql
{
  var  $sql;
  var  $result;
  var  $num;
  var  $row;
  function Tsql($str,$key=0)        //key=1 insert delete
  { $this->sql=$str;
    //echo "<p>".$str;
    //mysql_query("SET NAMES 'cp1251'");
    $this->result=mysql_query($this->sql);
    if (!$this->result)
        echo "<p>sql=".$this->sql;
    if ($key==0)
        $this->num = mysql_num_rows($this->result);
  }
  function NEXT()
  {
    $this->row=mysql_fetch_array($this->result);
  }
  function FIRST() {
    return (mysql_data_seek($this->result,0));
  }
  function SELECT($num) {
    return (mysql_data_seek($this->result,$num));
  }
  function FREE() {
    mysql_free_result($this->result);
  }
}

?>