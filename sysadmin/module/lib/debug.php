<html xmlns="http://www.w3.org/1999/xhtml">
<?php
  function echo_dd(&$row_TREE,$STR)
  {      if ($row_TREE["DEBUG"]==1)
      {   echo "\n".$STR;
      }
  }
  function echo_pp(&$row_TREE,$STR)
  {
      if ($row_TREE["DEBUG"]==1)
      {   echo "<p>".$STR."</p>";
      }
  }

//-------------------------Отладка вывод на экран
  function echo_PPP($nam,$dat)
  {  echo "<p>[".$nam.' = '.$dat."]</p>";
  }
//
define ('DEBUG', true, true);
  function echoo ($str) {    //Вывод неформатированных кодов
  	if (DEBUG)
    echo "<pre>$str</pre>";
  }
?>
</html>