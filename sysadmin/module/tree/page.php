<style>
.page_tek {
    background-image: url("/images/tree_S/form.png");
    background-repeat: no-repeat;
    height: 17px;
    width: 17px;
    marging : 2px;
    padding: 0 4px;
    display: inline;
}
.page_non {    background-image: url("/images/tree_S/form_.png");
    background-repeat: no-repeat;
    height: 17px;
    width: 17px;
    marging : 2px;
    padding: 0 4px;
    display: inline;
}
.page_text {    color:black;
    font-size:8px;
    text-decoration:none;
    marging : 2px;
    padding: 0 0px;
}
</style>



<?
// предполагает ?page=3
//===================================================================Постраничный вывод
  function PAGE($sql_data,$page=10,$count_page=5) {                   //from table where...


  $LIMIT='';
  if (array_key_exists('page', $_GET) )                                //Уже страница определена в запросе
  {
    $numP = $_GET['page'];
  }
  else //Это первый запрос на страницу
  {
    $numP=1;
  }

  $str_date=mysql_query('select count(id) as CS '.$sql_data);         //предварительное количество строк по запросу Постраничный вывод
  $num_str_date = mysql_num_rows($str_date);
  if ($num_str_date>0)
  {  $row_CS = mysql_fetch_array($str_date);
     $CS=$row_CS['CS'];                          //Общее количество записей
     //$page=10;                                                     //Количество строк на странице
     //$count_page=5;                                                //Кличество страниц
     //Получить количество строк на странице
     //$sqlSP=new Tsql ("select value from config where id_vendor='".htmlspecialchars(trim($_SESSION['user_id']))."' and name='page'");
     //if ( $sqlSP->num>0) { $sqlSP->NEXT(); $page=$sqlSP->row['value']; }
     $all_page= (int) ceil($CS/$page);
     $half=(int) ceil($count_page/2);
     if (($numP-$half)>2) $dot1=' ... ';
     else $dot1='';
     if (($numP+$half)<($all_page-1)) $dot2=' ... ';
     else $dot2='';
     /*
     echo '<p>'.' $CS='.$CS
                .' $all_page='.$all_page
                .' $half='.$half
                .'</p>';
     */
     if ($CS>$page and $SyS==false) //-------------------------------------------------Нужно делить на страницы
     {  echo '<p>';
     	for ($v=0,$s=1; $v<$CS; $v+=$page,$s++)              //$s - счетчик страниц с 1й
     	{ //$Bpage=$v;                                       //$v - номер начальной записи
     	  $Epage=$v+$page;                                   //$Epage - номер конечной записи
     	  if ($Epage>$CS) $Epage=$CS;
     	  if ($s==$numP)
     	  { $LIMIT=' LIMIT '.($numP-1)*$page.','.$page;
     	    $PNG='form.png';           //Оранжевая
     	  }
     	  else
     	  {
     	    $PNG='form_.png';       //Белая   <img src="/images/tree_S/'.$PNG.'" />
     	  }
          if($s==$all_page) echo $dot2;
          if (($s==1) or ($s==$all_page)
               or (($s>=($numP-$half)) and ($s<=($numP+$half))  ))

          echo '<a class="page_text"
     	        href="'.MAKE_URL('page',$s).'" title="стр.'.$s.' c '.($v+1).'-'.$Epage.'">
     	        <img src="/images/tree_S/'.$PNG.'" /></a>';
         /*
     	  echo '<span class="'.$style.'">
     	        <a class="page_text"
     	        href="'.$_SERVER['REQUEST_URI'].'&page='.$s.'" title="стр.'.$s.' c '.($v+1).'-'.$Epage.'">
     	                               '.$s.'</a></span>';
     	  */
     	  if($s==1) echo $dot1;
     	}
     	echo '</p>';
     	//$LIMIT=' LIMIT 0,'.$page;
     }
  }
  return $LIMIT;

 }
  //=================================================Конец вставки - постраничный ввод
?>