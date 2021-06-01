<html xmlns="http://www.w3.org/1999/xhtml">
<?php
//перенести ниже выше
    function FORM_moveUP(&$row_TREE)
	{
        $TABLE=$row_TREE["ID_TABLE"];

        $sql='select * from '.$TABLE.' where id='.$_GET["id"];
        $result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$up1=$row["displayOrder"];             //ордер текущей записи
        echo_pp(&$row_TREE,"FORM_moveUP=".$sql);

          $sql_data='';
          $Where=' where ';
	      if ($row_TREE["parent_TABLE"]<>"")         //маска выбора
		  {   $sql_data.=$Where.$row_TREE["ID_COLUMN"].' = "'.$_GET["in"].'"';
		      $Where=' and ';
		  }
		  if ($row_TREE["FILTER"]<>"")                   //Фильтер дополнительный в _TREE
		  {  $sql_data.=$Where.$row_TREE["FILTER"];
		     $Where=' and ';
		  }
        $sql_data.=$Where.'displayOrder<="'.$up1.'" and id<>"'.$_GET["id"].'"';
        echo_pp(&$row_TREE,$sql_data);
        //узнаем наибольший displayOrder
		$result = mysql_query('select * from '.$TABLE.$sql_data.' order by displayOrder desc' );
//		$result = mysql_query('select * from razdel as A where displayOrder>(select displayOrder from razdel as b where b.id="'.$_GET["id"].'") order by displayOrder');
		$num_results = mysql_num_rows($result);

        if($num_results<>0)
        {
		      $row = mysql_fetch_array($result);
			  $up=$row["displayOrder"];
              //echo $_GET["id"] .  ' $up1=' .$up1 .  ' $up=' .$up ;
			  mysql_query('update '.$TABLE.' set displayOrder= '.$up.' where id = "'.$_GET["id"].'"');
			  mysql_query('update '.$TABLE.' set displayOrder= '.$up1.' where id = "'.$row["id"].'"');

        }
        return true;
    }

//перенести ниже раздел
    function FORM_moveDOWN(&$row_TREE)
	{
        $TABLE=$row_TREE["ID_TABLE"];

        $sql='select * from '.$TABLE.' where id='.$_GET["id"];
        $result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$up1=$row["displayOrder"];             //ордер текущей записи
        echo_pp(&$row_TREE,"FORM_moveDOWN=".$sql);

          $sql_data='';
          $Where=' where ';
	      if ($row_TREE["parent_TABLE"]<>"")         //маска выбора
		  {   $sql_data.=$Where.$row_TREE["ID_COLUMN"].' = "'.$_GET["in"].'"';
		      $Where=' and ';
		  }
		  if ($row_TREE["FILTER"]<>"")                   //Фильтер дополнительный в _TREE
		  {  $sql_data.=$Where.$row_TREE["FILTER"];
		     $Where=' and ';
		  }
        $sql_data.=$Where.'displayOrder>="'.$up1.'" and id<>"'.$_GET["id"].'"';
        echo_pp(&$row_TREE,$sql_data);
        //узнаем наибольший displayOrder
		$result = mysql_query('select * from '.$TABLE.$sql_data.' order by displayOrder' );
		$num_results = mysql_num_rows($result);

        if($num_results<>0)
        {
		      $row = mysql_fetch_array($result);
			  $up=$row["displayOrder"];
              //echo $_GET["id"] .  ' $up1=' .$up1 .  ' $up=' .$up ;
			  mysql_query('update '.$TABLE.' set displayOrder= '.$up.' where id = "'.$_GET["id"].'"');
			  mysql_query('update '.$TABLE.' set displayOrder= '.$up1.' where id = "'.$row["id"].'"');

        }
        return true;
    }


?>
</html>