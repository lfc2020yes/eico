<?php

//если грузить стандарт то функция должна выполняться со значением $KEY=0;
function SEO($KEY,$data_place,$data_word,$PAGE,$link,$URLT = null,$echo = null)
{
	
//$URLT - необязательная переменная - Для страниц в которых есть постраничное листание - url без страниц-элемента
//http://www.ulmenu.ru/journal/
//http://www.ulmenu.ru/journal/.page-2
//http://www.ulmenu.ru/journal/.page-3	
//Для них титл должен быть один только с допиской страница такая то, поэтому $URLT=/journal/
	
        $URI_NAME=$_SERVER['SERVER_NAME']; //     www.kedy.ulmenu.ru
        $URI=$_SERVER['REQUEST_URI'];      //     /opinions/
		if (null !== $URLT) {
			$URI=$URLT;
		}
	
	 $result_title=mysql_time_query($link,'select * from title where (url_name LIKE "'.$URI_NAME.'" or url_name LIKE "'.$URI_NAME.',%" or url_name LIKE "%,'.$URI_NAME.',%" or url_name LIKE "%,'.$URI_NAME.'")and(url LIKE "'.$URI.'" or url LIKE "'.$URI.',%" or url LIKE "%,'.$URI.',%" or url LIKE "%,'.$URI.'")');
   $num_results_title = $result_title->num_rows;
   
		if($num_results_title<>0)
		{
		  //если конкретный титл найден с учетом адреса и запроса	
          $row_title = mysqli_fetch_assoc($result_title);
	      $T=$row_title["title"];
	      $D=$row_title["description"];
	      $K=$row_title["keywords"];
		  
		  
		  //******************************************************
		  //******************************************************
		  //Если забит конкретный титл но есть страницы - для разделов каталог, журнал и т.д
		  
		  if((isset($_GET["n_st"]))and (is_numeric($_GET["n_st"])))
          {
			  $page='';
			  switch($KEY)
              {
				  case "journal": $page=' - Страница '.$_GET["n_st"]; break;
				  case "selection": $page=' - Страница '.$_GET["n_st"]; break;	
			  }
			  $T=$T.$page;
		  }
		  
		  //******************************************************
		  //******************************************************
		  //Если забит конкретный титл но есть страницы - для разделов каталог, журнал и т.д	  






	    } else
		{
          //не найдено, попробуем найти только по адресу($URI_NAME)
		  if($KEY=='0')
		  {	
		  
		  
		  if($PAGE=='0')  
		  {

		  
		  
		  	 $result_title1=mysql_time_query($link,'select * from title where (url_name LIKE "'.$URI_NAME.'" or url_name LIKE "'.$URI_NAME.',%" or url_name LIKE "%,'.$URI_NAME.',%" or url_name LIKE "%,'.$URI_NAME.'")and(url="")');
		  
		  
		  $num_results_title1 = $result_title1->num_rows;
		  
	 	  if($num_results_title1<>0)
		  {
		     //если конкретный титл найден с учетом адреса и запроса	
             $row_title1 = mysqli_fetch_assoc($result_title1);
	         $T=$row_title1["title"];
	         $D=$row_title1["description"];
	         $K=$row_title1["keywords"];
	      } else
		  {
            //ничего не найдено, выводим пустые значения
		    $T="";
	        $D="";
            $K="";
		  }
		  
		  } else
		  {
			  
		  	 $result_title1=mysql_time_query($link,'select * from title where (META="'.$PAGE.'")');		  
		  
		  $num_results_title1 = $result_title1->num_rows;
	 	  if($num_results_title1<>0)
		  {
		     //если конкретный титл найден с учетом адреса и запроса	
             $row_title1 = mysqli_fetch_assoc($result_title1);
	         $T=$row_title1["title"];
	         $D=$row_title1["description"];
	         $K=$row_title1["keywords"];
	      } else
		  {
		  
		 	$result_title1=mysql_time_query($link,'select * from title where (url_name LIKE "'.$URI_NAME.'" or url_name LIKE "'.$URI_NAME.',%" or url_name LIKE "%,'.$URI_NAME.',%" or url_name LIKE "%,'.$URI_NAME.'")and(url="")');	 
		  
		  $num_results_title1 = $result_title1->num_rows;
	 	  if($num_results_title1<>0)
		  {
		     //если конкретный титл найден с учетом адреса и запроса	
             $row_title1 = mysqli_fetch_assoc($result_title1);
			 
	         $T=$row_title1["title"];
	         $D=$row_title1["description"];
	         $K=$row_title1["keywords"];
	      } else
		  {
            //ничего не найдено, выводим пустые значения
		    $T="";
	        $D="";
            $K="";
		  }
		  }		
		  
		  
		  
		  }
		  
		  } else
		  {

			  

            //ничего не найдено, выводим пустые значения
		    $T="";
	        $D="";
            $K="";
		  
			  
			  
			switch($KEY)
              {
					  					 case "invoices_add":{    

  $title_news='Добавление накладной';
  $T=$title_news; 
 break; 
                                             }				 

					  					 case "notification":{    

  $title_news='Лента уведомлений';
  $T=$title_news; 
 break; 
                                             }	
					  
					 case "cashbox":{    

  $title_news='Касса - выплаты исполнителям';
  $T=$title_news; 
 break; 
                                             }	
					  

					 case "implementers":{    

  $title_news='Все Исполнители';
  $T=$title_news; 
 break; 
                                             }	
					  
					 case "app":{    

  $title_news='Заявки на материалы';
  $T=$title_news; 
 break; 
                                             }		
					  
					 case "bill":{    

  $title_news='Счета';
  $T=$title_news; 
 break; 
                                             }							  
					 case "supply":{    

  $title_news='Снабжение';
  $T=$title_news; 
 break; 
                                             }
					 case "stock":{    

  $title_news='Склад материалов';
  $T=$title_news; 
 break; 
                                             }						  

					  
					  
				 case "stock_view":{    

$title_news='';
if((isset($_GET["id"])))
{

$result_news=mysql_time_query($link,'select name from z_stock where id="'.htmlspecialchars(trim($_GET["id"])).'"');	 
			  


$num_results_news = $result_news->num_rows;
if($num_results_news!=0)
{             
  $row_news = mysqli_fetch_assoc($result_news);
  $title_news='Склад материалов - '.$row_news["name"];
}

}
			  
				  
  $T=$title_news; 
 break; 
                                             }						  
					  
	
				 case "invoices_view":{    

$title_news='';
if((isset($_GET["id"])))
{

$result_news=mysql_time_query($link,'select number from z_invoice where id="'.htmlspecialchars(trim($_GET["id"])).'"');	 
			  


$num_results_news = $result_news->num_rows;
if($num_results_news!=0)
{             
  $row_news = mysqli_fetch_assoc($result_news);
  $title_news='Накладная №'.$row_news["number"];
}

}
			  
				  
  $T=$title_news; 
 break; 
                                             }						  
					  
					  
				 case "app_view":{    

$title_news='';
if((isset($_GET["id"])))
{

$result_news=mysql_time_query($link,'select number from z_doc where id="'.htmlspecialchars(trim($_GET["id"])).'"');	 
			  


$num_results_news = $result_news->num_rows;
if($num_results_news!=0)
{             
  $row_news = mysqli_fetch_assoc($result_news);
  $title_news='Заявка на материал №'.$row_news["number"];
}

}
			  
				  
  $T=$title_news; 
 break; 
                                             }						  
					  
					  
				 case "implementer":{    

$title_news='';
if((isset($_GET["id"])))
{

$result_news=mysql_time_query($link,'select id,implementer from i_implementer where id="'.htmlspecialchars(trim($_GET["id"])).'"');	 
			  


$num_results_news = $result_news->num_rows;
if($num_results_news!=0)
{             
  $row_news = mysqli_fetch_assoc($result_news);
  $title_news='Исполнитель - '.$row_news["implementer"];
}

} else
{
if((!isset($_GET["by"]))and(!isset($_GET["n_st"])))
{
//главная страница нарядов

  $title_news='Исполнители';
	
}
}


					  
				  
  $T=$title_news; 
 break; 
                                             }						  
					  

				 case "finery":{    

$title_news='';
if((isset($_GET["id"])))
{

$result_news=mysql_time_query($link,'select id from n_nariad where id="'.htmlspecialchars(trim($_GET["id"])).'"');	 
			  


$num_results_news = $result_news->num_rows;
if($num_results_news!=0)
{             
  $row_news = mysqli_fetch_assoc($result_news);
  $title_news='Наряд №'.$row_news["id"];
}

} else
{
if((!isset($_GET["by"]))and(!isset($_GET["n_st"])))
{
//главная страница нарядов

  $title_news='Все наряды';
	
}
}

 
 if((isset($_GET["n_st"]))and(!isset($_GET["by"]))and(is_numeric($_GET["n_st"])))
 {
	$page='';
	$page=' - Страница '.$_GET["n_st"]; 
    $title_news='Все наряды'.$page;
 }
				  
if((isset($_GET["by"]))and(!isset($_GET["n_st"])))
{
	$menu_get=array("","okay","nosigned","seal","decision");
	$menu_title=array("Все Наряды","Подписанные наряды","Неподписанные наряды","Утвержденные наряды","Наряды ждут согласования");
	$found1 = array_search($_GET["by"],$menu_get);
	 $title_news=$menu_title[$found1];
}
if((isset($_GET["by"]))and(isset($_GET["n_st"])))
{
	$menu_get=array("","okay","nosigned","seal","decision");
	$menu_title=array("Все Наряды","Подписанные наряды","Неподписанные наряды","Утвержденные наряды","Наряды ждут согласования");
	$found1 = array_search($_GET["by"],$menu_get);
	 $title_news=$menu_title[$found1].' - Страница '.$_GET["n_st"]; ;
}
					  
				  
  $T=$title_news; 
 break; 
                                             }	

					  

case "booker":{    

$title_news='';

 
 if((isset($_GET["n_st"]))and(!isset($_GET["by"]))and(is_numeric($_GET["n_st"])))
 {
	$page='';
	$page=' - Страница '.$_GET["n_st"]; 
    $title_news='Бухгалтерия - Счета необходимые оплатить'.$page;
 }
				  
if((isset($_GET["by"]))and(!isset($_GET["n_st"])))
{
	$menu_get=array("","paid");
	$menu_title=array("Бухгалтерия - Счета необходимые оплатить","Бухгалтерия - История оплаченных счетов");
	$found1 = array_search($_GET["by"],$menu_get);
	 $title_news=$menu_title[$found1];
}
if((isset($_GET["by"]))and(isset($_GET["n_st"])))
{
	$menu_get=array("","paid");
	$menu_title=array("Бухгалтерия - Счета необходимые оплатить","Бухгалтерия - История оплаченных счетов");
	$found1 = array_search($_GET["by"],$menu_get);
	 $title_news=$menu_title[$found1].' - Страница '.$_GET["n_st"]; ;
}
if((!isset($_GET["by"]))and(!isset($_GET["n_st"])))
{	
	 $title_news='Бухгалтерия - Счета необходимые оплатить';
}
				  
  $T=$title_news; 
 break; 
                                             }						  
					  
	
					  
case "invoices":{    

$title_news='';

 
 if((isset($_GET["n_st"]))and(!isset($_GET["by"]))and(is_numeric($_GET["n_st"])))
 {
	$page='';
	$page=' - Страница '.$_GET["n_st"]; 
    $title_news=' Накладные - новые '.$page;
 }
				  
if((isset($_GET["by"]))and(!isset($_GET["n_st"])))
{
	$menu_get=array("","old");
	$menu_title=array("Накладные - Новые","Накладные - Все");
	$found1 = array_search($_GET["by"],$menu_get);
	 $title_news=$menu_title[$found1];
}
if((isset($_GET["by"]))and(isset($_GET["n_st"])))
{
	$menu_get=array("","old");
	$menu_title=array("Накладные - Новые","Накладные - Все");
	$found1 = array_search($_GET["by"],$menu_get);
	 $title_news=$menu_title[$found1].' - Страница '.$_GET["n_st"]; ;
}
if((!isset($_GET["by"]))and(!isset($_GET["n_st"])))
{	
	 $title_news='Накладные - Новые';
}
				  
  $T=$title_news; 
 break; 
                                             }						  
					  
					  
				 case "decision":{    

$title_news='';

 
 if((isset($_GET["n_st"]))and(!isset($_GET["by"]))and(is_numeric($_GET["n_st"])))
 {
	$page='';
	$page=' - Страница '.$_GET["n_st"]; 
    $title_news='Несогласованные служебные записки по нарядам'.$page;
 }
				  
if((isset($_GET["by"]))and(!isset($_GET["n_st"])))
{
	$menu_get=array("finery_new","finery","app_new","app");
	$menu_title=array("Несогласованные служебные записки по нарядам","Cогласованные служебные записки по нарядам","Несогласованные служебные записки по заявкам на материал","Согласованные служебные записки по заявкам на материал");
	$found1 = array_search($_GET["by"],$menu_get);
	 $title_news=$menu_title[$found1];
}
if((isset($_GET["by"]))and(isset($_GET["n_st"])))
{
	$menu_get=array("finery_new","finery","app_new","app");
	$menu_title=array("Несогласованные служебные записки по нарядам","Cогласованные служебные записки по нарядам","Несогласованные служебные записки по заявкам на материал","Согласованные служебные записки по заявкам на материал");
	$found1 = array_search($_GET["by"],$menu_get);
	 $title_news=$menu_title[$found1].' - Страница '.$_GET["n_st"]; ;
}
					  
				  
  $T=$title_news; 
 break; 
                                             }						  
					  
				 case "app_add":{    

$title_news='';
if((isset($_GET["id"])))
{

$result_news=mysql_time_query($link,'select a.object_name,b.kvartal,c.town from i_object as a,i_kvartal as b,i_town as c where b.id_town=c.id and a.id_kvartal=b.id and a.id="'.htmlspecialchars(trim($_GET["id"])).'"');	 
			  


$num_results_news = $result_news->num_rows;
if($num_results_news!=0)
{             
  $row_news = mysqli_fetch_assoc($result_news);
  $title_news='Оформление заявки на материал - '.$row_news["object_name"].' ('.$row_news["town"].', '.$row_news["kvartal"].')';
}
}
  $T=$title_news; 
 break; 
                                             }											 										 


					  
				 case "finery_add":{    

$title_news='';
if((isset($_GET["id"])))
{

$result_news=mysql_time_query($link,'select a.object_name,b.kvartal,c.town from i_object as a,i_kvartal as b,i_town as c where b.id_town=c.id and a.id_kvartal=b.id and a.id="'.htmlspecialchars(trim($_GET["id"])).'"');	 
			  


$num_results_news = $result_news->num_rows;
if($num_results_news!=0)
{             
  $row_news = mysqli_fetch_assoc($result_news);
  $title_news='Оформление наряда - '.$row_news["object_name"].' ('.$row_news["town"].', '.$row_news["kvartal"].')';
}
}
  $T=$title_news; 
 break; 
                                             }						  
					  
					  
				 case "prime":{    

$title_news='';
if((isset($_GET["id"])))
{

$result_news=mysql_time_query($link,'select a.object_name,b.kvartal,c.town from i_object as a,i_kvartal as b,i_town as c where b.id_town=c.id and a.id_kvartal=b.id and a.id="'.htmlspecialchars(trim($_GET["id"])).'"');	 
			  


$num_results_news = $result_news->num_rows;
if($num_results_news!=0)
{             
  $row_news = mysqli_fetch_assoc($result_news);
  $title_news='Себестоимость - '.$row_news["object_name"].' ('.$row_news["town"].', '.$row_news["kvartal"].')';
}

} else
{
  $title_news='Себестоимость';	
}


  $T=$title_news; 
 break; 
                                             }	
											 
										 



				 
				 }

			
			
		  }
		}
		if (null == $echo) {
		   echo'<title>'.$T.'</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="keywords" content="'.$K.'" /><meta name="description" content="'.$D.'" />';
		} else
		{
		   return $T.'--o--'.$K.'--o--'.$D;	
		}
}
?>