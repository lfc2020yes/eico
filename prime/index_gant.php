<?
session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; include_once $url_system.'module/config.php'; include_once $url_system.'module/function.php'; include_once $url_system.'login/function_users.php'; initiate($link); include_once $url_system.'module/access.php';


//правам к просмотру к действиям
$hie = new hierarchy($link,$id_user);
//echo($id_user);
$hie_object=array();
$hie_town=array();
$hie_kvartal=array();
$hie_user=array();	
$hie_object=$hie->obj;
$hie_kvartal=$hie->id_kvartal;
$hie_town=$hie->id_town;
$hie_user=$hie->user;

$sign_level=$hie->sign_level;
$sign_admin=$hie->admin;
//print_r($hie_user);
//print_r($hie_object);
$role->GetColumns();
$role->GetRows();
$role->GetPermission();
//правам к просмотру к действиям


//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /prime/23/
//     0   1   2  3
//      /prime/23/add/5/
//     0   1   2  3   4  5


$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);


if (( count($_GET) == 1 )or( count($_GET) == 2 )) //--Если были приняты данные из HTML-формы
{
 if ( count($_GET) == 1 )
 {	
  $active_menu='prime';	 
  //просмотр себестоимости	 
  if($D_404[3]=='gant')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
		//echo("!");
        $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0)
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} else
		{
			$row_list = mysqli_fetch_assoc($result_url);
			//echo("!");
			//может ли вообще этот пользователь просматривать эту себестоимость
			if(($sign_admin!=1)and(array_search($_GET['id'],$hie_object)===false))
			{
				 //echo($sign_admin);
				 header("HTTP/1.1 404 Not Found");
	             header("Status: 404 Not Found");
	             $error_header=404;
				 //echo('!');
			}
			if (($role->permission('Себестоимость','R'))or($sign_admin==1))
	        {
				//echo("4");
			} else
			{
				//echo("4");
				 header("HTTP/1.1 404 Not Found");
	             header("Status: 404 Not Found");
	             $error_header=404;				
			}


			
		}
	} else
	{
       header("HTTP/1.1 404 Not Found");
	   header("Status: 404 Not Found");
	   $error_header=404;
	}
  } else
  {
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $error_header=404;	  
  }
 }

	 
} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}
//echo($error_header);

//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
//echo("4");

//проверяем что этот пользователь может добавлять в выбранный наряд
//этот наряд им еще не подписан
//он имеет доступ к этому наряду
/*
if((isset($_GET["id"]))and(isset($_GET["add"])))
{


if($sign_admin==1)
{
	if($row_list["signedd_nariad"]==1)
	{
		//уже выполнен нельзя добавлять
		header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        $error_header=404;
	}
} else
{
//$id_object[]=implode(',', $hie->obj);
$found_object = array_search($_GET['id'],$hie_object);
if($found_object !== false)
{
	if(($row_list["signedd_nariad"]!=0)or($row_list["id_signed".$sign_level]!=0))
	{
		//Этот наряд подписан выше по рангу или им же или вообще
		header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        $error_header=404;
	}
} else
{
   //Это не его наряды
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}
}
}

//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
*/

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы

include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('prime_gant','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php'; include $url_system.'template/head.php';
?>


<script src="prime/gant/dhtmlxgantt.js?v=7.1.6"></script>

<!--<link rel="stylesheet" href="prime/gant/dhtmlxgantt_material.css?v=7.1.6">-->
<link rel="stylesheet" href="prime/gant/dhtmlxgantt_terrace.css?v=7.1.6">
<link rel="stylesheet" href="prime/gant/controls_styles.css?v=7.1.6">



<style>

    .main-content {
        height: 600px;
        height: calc(100vh - 50px);
    }

    .status_line {
        background-color: #0ca30a;
    }
    .weekend {
        background: #f4f7f4 !important;
    }



</style>



</head><body>
<div class="alert_wrapper"><div class="div-box"></div></div>
<?
include_once $url_system.'template/body_top.php';	
?>

<div class="container">
<?


if ( isset($_COOKIE["iss"]))
{
    if($_COOKIE["iss"]=='s')
    {
        echo'<div class="iss small">';
    } else
    {
        echo'<div class="iss big">';
    }
} else
{
    echo'<div class="iss small">';
}
//echo(mktime());

//echo($row_list["id_kvartal"]);
        $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}


	 	   //эти столбцы видят только особые пользователи	
		   $count_rows=10;	
		   $stack_td = array();			

?>

	
	
	
<div class="left_block">
  <div class="content">

<?
                $act_='display:none;';
	            $act_1='';
	            if(cookie_work('it_','on','.',60,'0'))
	            {
		            $act_='';
					$act_1='on="show"';
	            }

  include_once $url_system.'template/top_prime_gant.php';

?>
<div id="fullpage" class="margin_60  input-block-2020 ">
    <div class="oka_block_2019" style="min-height:auto;">
        <div class="div_ook hop_ds"><div class="search_task">
                <?
                $result_t=mysql_time_query($link,'Select a.id,a.town from i_town as a order by a.id');
                $num_results_t = $result_t->num_rows;
                if($num_results_t!=0)
                {
                    echo'<div class="left_drop menu1_prime book_menu_sel js--sort gop_io"><label>Город</label><div class="select eddd"><a class="slct" data_src="'.$row_town["id_town"].'">'.$row_town["town"].'</a><ul class="drop">';
                    for ($i=0; $i<$num_results_t; $i++)
                    {
                        $row_t = mysqli_fetch_assoc($result_t);
                        if((array_search($row_t["id"],$hie_town) !== false)or($sign_admin==1))
                        {
                            if($row_t["id"]==$row_town["id_town"])
                            {
                                echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["town"].'</a></li>';
                            } else
                            {
                                echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["town"].'</a></li>';
                            }
                        }
                    }
                    echo'</ul><input type="hidden" name="city" id="city" value="'.$row_town["id_town"].'"></div></div>';
                }


                $result_t=mysql_time_query($link,'Select a.id,a.kvartal from i_kvartal as a where a.id_town="'.$row_town["id_town"].'" order by a.id');
                $num_results_t = $result_t->num_rows;
                if($num_results_t!=0)
                {
                    echo'<div class="left_drop menu2_prime book_menu_sel js--sort gop_io"><label>Квартал</label><div class="select eddd"><a class="slct" data_src="'.$row_list["id_kvartal"].'">'.$row_town["kvartal"].'</a><ul class="drop">';
                    for ($i=0; $i<$num_results_t; $i++)
                    {
                        $row_t = mysqli_fetch_assoc($result_t);
                        if((array_search($row_t["id"],$hie_kvartal) !== false)or($sign_admin==1))
                        {
                            if($row_t["id"]==$row_list["id_kvartal"])
                            {
                                echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["kvartal"].'</a></li>';
                            } else
                            {
                                echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["kvartal"].'</a></li>';
                            }
                        }
                    }
                    echo'</ul><input type="hidden"  name="kvartal" id="kvartal" value="'.$row_list["id_kvartal"].'"></div></div>';
                }




                $result_t=mysql_time_query($link,'Select a.id,a.object_name from i_object as a where a.id_kvartal="'.$row_list["id_kvartal"].'" order by a.id');
                $num_results_t = $result_t->num_rows;
                if($num_results_t!=0)
                {
                    echo'<div class="left_drop menu3_prime book_menu_sel js--sort gop_io"><label>Объект</label><div class="select eddd"><a class="slct" data_src="'.$row_list["id"].'">'.$row_list["object_name"].'</a><ul class="drop">';
                    for ($i=0; $i<$num_results_t; $i++)
                    {
                        $row_t = mysqli_fetch_assoc($result_t);
                        $url_prime="prime/";


                        if((array_search($row_t["id"],$hie_object) !== false)or($sign_admin==1))
                        {
                            //он может видеть этот объект

                            if($row_t["id"]==$row_list["id"])
                            {
                                echo'<li class="sel_active"><a href="'.$url_prime.$row_t["id"].'/"  rel="'.$row_t["id"].'">'.$row_t["object_name"].'</a></li>';
                            } else
                            {
                                echo'<li><a href="'.$url_prime.$row_t["id"].'/"  rel="'.$row_t["id"].'">'.$row_t["object_name"].'</a></li>';
                            }
                        }

                    }
                    echo'</ul><input type="hidden"  name="dom" id="dom" value="'.$row_list["id"].'"></div></div>';
                }


                ?>
            </div>
    </div>
        <div class="oka_block">
            <!--<div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">-->

<?
//echo'<span class="h3-f">Себестоимость <span class="pol-card"> '.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</span></span>';


    echo'<div class="content_block" dom="'.$row_list["id"].'" id_content="'.$id_user.'">';
	?>

  <?

  $data_global = array();

       $uor = new User_Object_Razdel($link, $id_user);
       $id_object = htmlspecialchars(trim($_GET['id']));

       $result_t=mysql_time_query($link,"select a.* from i_razdel1 as a where a.id_object='$id_object'". $uor->select($id_object) .' order by a.razdel1');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   for ($i=0; $i<$num_results_t; $i++)
             {  
			    $row_t = mysqli_fetch_assoc($result_t);
                 $data = array();
				if($role->is_row('i_razdel1','razdel1',$row_t["razdel1"]))
				{

		            $actv='active';
		            $pl='-';
	           // }


                    //$row_t["id"]
                //echo ($row_t["razdel1"].'. '.$row_t["name1"]);
             $data["id"]=$row_t["id"];
             $data["text"]=$row_t["razdel1"].'. '.$row_t["name1"];

             $data["duration"]='';
             $data["start_date"]='';
$data["end_date"]='';
$data["progress"]='';
$data["open"]="true";

                    array_push($data_global, $data);

	            $result_t1=mysql_time_query($link,'Select a.* from i_razdel2 as a where a.id_razdel1="'.$row_t["id"].'" order by a.id');
                $num_results_t1 = $result_t1->num_rows;
	            if($num_results_t1!=0)
	            {

		          for ($iu=0; $iu<$num_results_t1; $iu++)
                  {  
			         $row_t1 = mysqli_fetch_assoc($result_t1);
                      $data = array();
					 //процент выполненных работ
					 if($row_t1["count_units"]!=0)
					 {	 
					   $proc_realiz=round(($row_t1["count_r2_realiz"]*100)/$row_t1["count_units"]); 
					 } else
					 {
						$proc_realiz=0; 
					 }

                      $proc_realiz=50;
					 //echo($proc_realiz);

              //   echo ($row_t1["id"]);
  //echo($row_t["razdel1"].'.'.$row_t1["razdel2"].' '.$row_t1["name_working"]);

				  
					// echo ($row_t1["date0"]);
					// echo ($row_t1["date1"]);


                      $data["id"]=$row_t1["id"];
                      $data["text"]=$row_t["razdel1"].'.'.$row_t1["razdel2"].' '.$row_t1["name_working"];


                      $data["duration"]='';



                      $data["start_date"]=date_ex(0,$row_t1["date0"]);
                      $data["end_date"]=date_ex(0,$row_t1["date1"]);
                      $data["progress"]=$proc_realiz;
                      $data["parent"]=$row_t["id"];

                      array_push($data_global, $data);

					  //вывод дат начала и конца работы

					  if (($role->permission('График','R'))or($sign_admin==1))
					  {
					  }
                      if (($role->permission('График','U'))or($sign_admin==1))
                      {
                      }


					  }

//echo (rtrim(rtrim(number_format($row_t1["count_units"], 2, '.', ' '),'0'),'.'));

			      }
	            }
			 }
			 }

  require_once $url_system.'Ajax/lib/Services_JSON.php';
  $oJson = new Services_JSON();
  //функция работает только с кодировкой UTF-8
  //echo $oJson->encode($data_global);


  ?>
                <div class="main-content">
                    <div id="gantt_here" style='width:100%; height:100%;padding: 0px;'></div>
                </div>

                <script>/*
                    gantt.plugins({
                        quick_info: true,
                        tooltip: true,
                        critical_path: true
                    });*/
/*
                    var toggleCritical = function () {
                        if (gantt.config.highlight_critical_path)
                            gantt.config.highlight_critical_path = !true;
                        else
                            gantt.config.highlight_critical_path = true;
                        gantt.render();
                    };

*/
                    gantt.plugins({
                        marker: true
                    });

                    var textEditor = {type: "text"};
                    var dateEditor = {type: "date", map_to: "start_date", min: new Date(2018, 0, 1), max: new Date(2022, 0, 1)};
                    var dateEditor1 = {type: "date", map_to: "end_date", min: new Date(2018, 0, 1), max: new Date(2022, 0, 1)};
                    var durationEditor = {type: "number", map_to: "duration", min:0, max: 100};


                    gantt.config.columns = [

                        {name: "text", label: "Работы", tree: true, width: 200, resize: true, min_width: 10, template:function(obj){
                        return ""+obj.text+"!";
                    }},
                        {name: "duration", label: "Дни", align: "center", width: 80, resize: true,editor: durationEditor},
                        {name: "start_date", label: "Начало", align: "center", width: 90, resize: true,editor: dateEditor},
                        {name: "end_date", label: "Конец", align: "center", width: 90, resize: true,editor: dateEditor1},


                    ];
                    gantt.config.date_format = "%d.%m.%Y";


                    //gantt.config.show_progress = false;




/*
                    gantt.templates.rightside_text = function (start, end, task) {
                        if (task.type == gantt.config.types.milestone)
                            return task.text + " / ID: #" + task.id;
                        return "";
                    };*/
/*
                    gantt.config.start_on_monday = false;

                    gantt.config.scale_height = 36 * 3;
                    gantt.config.scales = [
                        {unit: "month", step: 1, format: "%F"},
                        {unit: "week", step: 1, format: function (date) {
                                var dateToStr = gantt.date.date_to_str("%d %M");
                                var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
                                return dateToStr(date) + " - " + dateToStr(endDate);
                            }},
                        {unit: "day", step: 1, format: "%D"}
                    ];
*/

                    //var dateToStr = gantt.date.date_to_str(gantt.config.task_date);
                    var today = new Date(2021, 10, 7);
                    gantt.addMarker({
                        start_date: today,
                        css: "today",
                        text: "Today",
                        title: "Today: "
                    });

                    var start = new Date(2018, 2, 28);
                    gantt.addMarker({
                        start_date: start,
                        css: "status_line",
                        text: "Start project",
                        title: "Start project: "
                    });

                    gantt.config.scale_height = 50;
                    gantt.config.scales = [
                        {unit: "day", step: 1, format: "%j"},
                        {unit: "month", step: 1, format: "%F, %Y"},
                    ];



                    gantt.templates.scale_cell_class = function (date) {
                        if (!gantt.isWorkTime(date))
                            return "weekend";
                    };
                    gantt.templates.timeline_cell_class = function (item, date) {
                        if (!gantt.isWorkTime(date))
                            return "weekend";
                    };
                    gantt.config.work_time = true;
                    //gantt.config.auto_scheduling = true;
                    //Wgantt.config.auto_scheduling_strict = true;

                   // gantt.config.date_format = "%d-%m-%Y";

                   // gantt.config.start_date = new Date(2021, 10, 1);
                   // gantt.config.end_date = new Date(2022, 1, 1);


                    gantt.init("gantt_here");

                    var data = {
                        tasks:<? echo($oJson->encode($data_global)); ?>
                    };

                    gantt.parse(data);

                </script>



           <!-- </div> -->
  </div>

</div>

<?
include_once $url_system.'template/left.php';
?>
</div></div></div>
</div>
</div><script src="Js/rem.js" type="text/javascript"></script>
<?
if(isset($_GET["add"]))
{
echo'<script type="text/javascript">var b_co=\''.$b_co.'\'</script>';
} else{
	if(isset($_GET["add_a"]))
{
	echo'<script type="text/javascript">var b_co=\''.$b_co.'\'</script>';
} else
{
	echo'<script type="text/javascript">var b_co=\''.$b_co.'\'</script>';
	echo'<script type="text/javascript">var b_cm=\''.$b_cm.'\'</script>';
}
}
	?>
<div id="nprogress"><div class="bar" role="bar" ><div class="peg"></div></div></div>

</body></html>