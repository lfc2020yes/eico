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
if((!$role->permission('График','R'))and(!$role->permission('График','U'))and($sign_admin!=1)) {
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $error_header=404;
}



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

<link rel="stylesheet" href="prime/gant/controls_styles.css?v=7.1.6">



<style>

    .main-content {
        /*height: auto;*/
        height: calc(100vh - 60px - 80px);
    }

    .status_line {
        background-color: #0ca30a;
    }
    .weekend {
        background: #f4f7f4 !important;
    }
    html, body {
        height: 100%;
        padding: 0px;
        margin: 0px;
        overflow: hidden;
        display: block;
    }

    .owner-label {
        width: 20px;
        height: 20px;
        line-height: 20px;
        font-size: 12px;
        display: inline-block;
        border: 1px solid #cccccc;
        border-radius: 25px;
        background: #e6e6e6;
        color: #6f6f6f;
        margin: 0 3px;
        font-weight: bold;
    }

    .gantt_tooltip {
        font-size: 13px;
        line-height: 16px;
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

       //echo("select a.* from i_razdel1 as a where a.id_object='$id_object'". $uor->select($id_object) .' order by a.razdel1');
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
                    $id_parents=$row_t["id"].'.0';
                    $data["id"]=$id_parents;

             //$data["id"]=$row_t["id"];
             $data["text"]=ht($row_t["razdel1"].'. '.$row_t["name1"]);

                   // $data["text"]='22';
             $data["duration"]='';
             $data["start_date"]='';
$data["end_date"]='';
$data["progress"]='';
$data["open"]="true";
$data["editable"]=false;
                    $data["bar_height"]=10;
                    $data["linkable"]=false;
                    $data["dataEditable"]=false;


                    array_push($data_global, $data);

    $result_t1 = mysql_time_query($link, 'Select a.* from i_razdel2 as a where a.id_razdel1="' . $row_t["id"] . '" order by a.id');
    $num_results_t1 = $result_t1->num_rows;
    if ($num_results_t1 != 0) {

        for ($iu = 0; $iu < $num_results_t1; $iu++) {
            $row_t1 = mysqli_fetch_assoc($result_t1);
            $data = array();
            //процент выполненных работ
            if ($row_t1["count_units"] != 0) {
                $proc_realiz = round(($row_t1["count_r2_realiz"]*100) / $row_t1["count_units"]);
            } else {
                $proc_realiz = 0;
            }
            $proc_realiz=$proc_realiz/100;

            //$proc_realiz = 50;
            //echo($proc_realiz);

            //   echo ($row_t1["id"]);
            //echo($row_t["razdel1"].'.'.$row_t1["razdel2"].' '.$row_t1["name_working"]);


            // echo ($row_t1["date0"]);
            // echo ($row_t1["date1"]);


            $data["id"] = $row_t1["id"];
            $data["text"] = ht($row_t["razdel1"] . '.' . $row_t1["razdel2"] . ' ' . $row_t1["name_working"]);
            //$data["text"]='22';

            $data["duration"] = '';


            if (($row_t1["date0"] == '') or ($row_t1["date0"] == null)) {
                $data["start_date"] = date('d.m.Y');
            } else {
                $data["start_date"] = date_ex(0, $row_t1["date0"]);
            }

            if (($row_t1["date1"] == '') or ($row_t1["date1"] == null)) {
                $data["end_date"] = date_ex(0, date_step(date('Y-m-d'), 1));
            } else {
                $data["end_date"] = date_ex(0, $row_t1["date1"]);
            }

            //$data["end_date"]=date_ex(0,$row_t1["date1"]);
            $data["progress"] = $proc_realiz;
            //$data["parent"] = $row_t["id"];

            $data["parent"] =$id_parents;
            $data["editable"] = true;
            $data["bar_height"] = 25;
            $data["linkable"] = true;
            $data["dataEditable"] = true;
            array_push($data_global, $data);

            //вывод дат начала и конца работы

            if (($role->permission('График', 'R')) or ($sign_admin == 1)) {

            }
            if (($role->permission('График', 'U')) or ($sign_admin == 1)) {

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

  //print_r($oJson->encode($data_global));

  ?>
                <div class="main-content">
                    <div id="gantt_here" style='width:100%; height: 100% !important;'></div>
                </div>

                <script>

                    function linkTypeToString(linkType) {
                        switch (linkType) {
                            case gantt.config.links.start_to_start:
                                return "Start to start";
                            case gantt.config.links.start_to_finish:
                                return "Start to finish";
                            case gantt.config.links.finish_to_start:
                                return "Finish to start";
                            case gantt.config.links.finish_to_finish:
                                return "Finish to finish";
                            default:
                                return ""
                        }
                    }

                    /*
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
                        marker: true,
                        auto_scheduling: true,
                        tooltip: true
                    });

                    var textEditor = {type: "text"};

                    <?
                    if(($role->permission('График','U'))or($sign_admin==1))
                    {
                    ?>
                    var dateEditor = {type: "date", map_to: "start_date", min: new Date(2018, 0, 1), max: new Date(2022, 0, 1)};
                    var dateEditor1 = {type: "date", map_to: "end_date", min: new Date(2018, 0, 1), max: new Date(2022, 0, 1)};
                    var durationEditor = {type: "number", map_to: "duration", min:0, max: 100};


                    gantt.config.columns = [

                        {name: "text", label: "Работы", tree: true, width: 350, resize: true, min_width: 10, template:function(obj){
                                return ""+obj.text+"!";
                            }},
                        {name: "duration", label: "Дни", align: "center", width: 80, resize: true,editor: durationEditor},
                        {name: "start_date", label: "Начало", align: "center", width: 110, resize: true,editor: dateEditor},
                        {name: "end_date", label: "Конец", align: "center", width:110, resize: true,editor: dateEditor1},


                    ];
                    <?
                    } else
                        {
                    ?>


                    var dateEditor = {type: "date", map_to: "start_date", min: new Date(2018, 0, 1), max: new Date(2022, 0, 1)};
                    var dateEditor1 = {type: "date", map_to: "end_date", min: new Date(2018, 0, 1), max: new Date(2022, 0, 1)};
                    var durationEditor = {type: "number", map_to: "duration", min:0, max: 100};


                    gantt.config.columns = [

                        {name: "text", label: "Работы", tree: true, width: 350, resize: true, min_width: 10, template:function(obj){
                                return ""+obj.text+"!";
                            }},
                        {name:"progress",   label:"Прогресс",   align:"center", width: 80, resize: true,template:function(obj){
                                return ""+(obj.progress*100)+"%";
                            }}

                    ];

                    //запретить ссылки
                    gantt.config.drag_links = false;
                    //запретить передвижение задач
                    gantt.config.drag_move = false;
                    //запретить растягивание ширины задачи
                    gantt.config.drag_resize = false;
                    <?
                            //только чтение


                        }
                    ?>
                    gantt.config.date_format = "%d.%m.%Y";
                    gantt.config.date_grid = "%d.%m.%Y";
                    gantt.config.row_height = 50;
                    gantt.config.drag_progress = false;
                    gantt.config.show_progress = true;
                    gantt.config.details_on_dblclick = false;

//для связей когда заканчивается одна начитается другая если связаны
                    gantt.config.auto_scheduling = true;

                    //автоматически расширяться чтобы показывать все работы
                    gantt.config.fit_tasks = true;

                    //запретить все связи
                   // gantt.config.drag_links = false;




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

                   /* var today = new Date(2021, 10, 7);
                    gantt.addMarker({
                        start_date: today,
                        css: "today",
                        text: "Today",
                        title: "Today: "
                    });*/
/*
                    var start = new Date(2018, 2, 28);
                    gantt.addMarker({
                        start_date: start,
                        css: "status_line",
                        text: "Start project",
                        title: "Start project: "
                    });
*/                  gantt.config.duration_unit = "day";
                    gantt.config.scale_height = 50;
                    gantt.config.scales = [
                        {unit: "day", step: 1, format: "%j"},
                        {unit: "month", step: 1, format: "%F, %Y"},
                    ];
                    gantt.templates.tooltip_date_format = gantt.date.date_to_str("%d.%m.%Y");
                    //gantt.templates.tooltip_date_format = gantt.date.date_to_str("%F %j, %Y");
                    gantt.attachEvent("onGanttReady", function () {
                        var tooltips = gantt.ext.tooltips;

                        gantt.templates.tooltip_text = function (start, end, task) {
                            var store = gantt.getDatastore("resource");
                            var assignments = task[gantt.config.resource_property] || [];

                            var owners = [];
                            assignments.forEach(function (assignment) {
                                var owner = store.getItem(assignment.resource_id)
                                owners.push(owner.text);
                            });
                            return "<b>Работа:</b> " + task.text + "<br/>" +
                                "<b>Начало работ:</b> " +
                                gantt.templates.tooltip_date_format(start) +
                                "<br/><b>Конец работ:</b> " + gantt.templates.tooltip_date_format(end) +
                                "<br><b>Прогресс:</b> " +
                                (task.progress*100) +"%"


                                ;
                        };

                        tooltips.tooltipFor({
                            selector: ".gantt_task_link",
                            html: function (event, node) {

                                var linkId = node.getAttribute(gantt.config.link_attribute);
                                if (linkId) {
                                    var link = gantt.getLink(linkId);
                                    var from = gantt.getTask(link.source);
                                    var to = gantt.getTask(link.target);

                                    return [
                                        "<b>Тип:</b> " + linkTypeToString(link.type),
                                        "<b>Из: </b> " + from.text,
                                        "<b>В: </b> " + to.text
                                    ].join("<br>");
                                }
                            }
                        });

                        tooltips.tooltipFor({
                            selector: ".gantt_row[resource_id]",
                            html: function (event, node) {

                                var resourceId = node.getAttribute("resource_id");
                                var store = gantt.getDatastore(gantt.config.resource_store);
                                var resource = store.getItem(resourceId);
                                var assignments = getResourceAssignments(resource, store)

                                var totalDuration = 0;
                                for (var i = 0; i < assignments.length; i++) {
                                    var task = gantt.getTask(assignments[i].task_id);
                                    totalDuration += task.duration * assignments[i].value;
                                }

                                return [
                                    "<b>Resource:</b> " + resource.text,
                                    "<b>Tasks assigned:</b> " + assignments.length,
                                    "<b>Total load: </b>" + (totalDuration || 0) + "h"
                                ].join("<br>");

                            }
                        });


                        tooltips.tooltipFor({
                            selector: ".gantt_scale_cell",
                            html: function (event, node) {
                                var relativePosition = gantt.utils.dom.getRelativeEventPosition(event, gantt.$task_scale);
                                return gantt.templates.tooltip_date_format(gantt.dateFromPos(relativePosition.x));
                            }
                        });

                        tooltips.tooltipFor({
                            selector: ".gantt_resource_marker",
                            html: function (event, node) {
                                var dataElement = node.querySelector("[data-recource-tasks]");
                                var ids = JSON.parse(dataElement.getAttribute("data-recource-tasks"));

                                var date = gantt.templates.parse_date(dataElement.getAttribute("data-cell-date"));
                                var resourceId = dataElement.getAttribute("data-resource-id");

                                var relativePosition = gantt.utils.dom.getRelativeEventPosition(event, gantt.$task_scale);

                                var store = gantt.getDatastore("resource");

                                var html = [
                                    "<b>" + store.getItem(resourceId).text + "</b>" + ", " + gantt.templates.tooltip_date_format(date),
                                    "",
                                    ids.map(function (id, index) {
                                        var task = gantt.getTask(id);
                                        var assignenment = gantt.getResourceAssignments(resourceId, task.id);
                                        var amount = "";
                                        var taskIndex = (index + 1);
                                        if (assignenment[0]) {
                                            amount = " (" + assignenment[0].value + "h) ";
                                        }
                                        return "Task #" + taskIndex + ": " + amount + task.text;
                                    }).join("<br>")
                                ].join("<br>");

                                return html;
                            }
                        });
                    });



                    gantt.templates.scale_cell_class = function (date) {
                        if (!gantt.isWorkTime(date))
                            return "weekend";
                    };
                    gantt.templates.timeline_cell_class = function (item, date) {
                        if (!gantt.isWorkTime(date))
                            return "weekend";
                    };






                    //есть ли выходные или нет
                    gantt.config.work_time = true;

                    //определить когда нерабочие дни
                    //месяц почему то -1 от текущего. здесь нерабочий день 2021-10-19
                    gantt.setWorkTime({date:new Date(2021,9,21), hours:false});

                    //задать работаем ли мы по субботам и воскресеньям
                    gantt.setWorkTime({day : 6}); //cуббота рабочая

                    //gantt.setWorkTime({hours : ["8:30-12:00", "13:00-17:00"]})

                    //gantt.config.auto_scheduling = true;
                    //Wgantt.config.auto_scheduling_strict = true;

                    gantt.config.end_date = new Date(2022, 1, 20);

                   // gantt.config.start_date = new Date(2021, 10, 1);
                   // gantt.config.end_date = new Date(2022, 1, 1);


                    gantt.init("gantt_here");

                    var data = {
                        tasks:<? echo($oJson->encode($data_global)); ?>
                    };

                    gantt.parse(data);
                    $(function () {



                        var todayMarker = gantt.addMarker({
                            start_date: new Date(),
                            css: "today",
                            title: "12"
                        });
                        setInterval(function () {
                            var today = gantt.getMarker(todayMarker);
                            today.start_date = new Date();
                            today.title = date_to_str(today.start_date);
                            gantt.updateMarker(todayMarker);
                        }, 1000 * 60);


                        var inlineEditors = gantt.ext.inlineEditors;
                        inlineEditors.attachEvent("onBeforeEditStart", function(state){
                            var task = gantt.getTask(state.id);
                            if(task.dataEditable === false){
                                return false;
                            }
                            return true;
                        });

                        inlineEditors.attachEvent("onSave", function(state){
                           // console.log(state);
                            // -> { id: itemId,
                            //      columnName: columnName,
                            //      oldValue: value,
                            //      newValue: value
                            //    };
                            /*
                            var convert = gantt.date.date_to_str("%Y-%m-%d");
                            var s = convert(state.oldValue);
                            var e = convert(state.newValue);
*/
                            if(state.oldValue!=state.newValue) {
                                var taskObj = gantt.getTask(state.id);
                                var convert = gantt.date.date_to_str("%Y-%m-%d");
                                var s = convert(taskObj.start_date);
                                var e = convert(taskObj.end_date);
                               // alert(s+'/'+e);
                                var data ='url='+window.location.href+'&id='+state.id+'&start='+s+'&end='+e;
                                AjaxClient('prime','update_gant','GET',data,'AfterUpdateGant',state.id,0);
                            }


                        });


                        //запрещать связываться с работами у которых linkable == false (для названий общих разделов)
                        gantt.attachEvent("onBeforeLinkAdd", function(id,link){
                            var target_task = gantt.getTask(link.target);
                           // alert(target_task.linkable);
                            if (target_task.linkable == false) {
                                //gantt.message({type:"warning", text:"This task cannot be linked"});
                                return false;
                            }

                            var sourceTask = gantt.getTask(link.source);
                            var targetTask = gantt.getTask(link.target);



                            return true;
                        });

                        //пометить классом работы у которых не должно быть связей (общий раздел к примеру)
                        gantt.templates.task_class = function(start, end, task){
                            if(task.linkable == false) return "custom_task";
                            return "";
                        };

                        //событие по перетаскиваю или изменения размера работы
                        gantt.attachEvent("onAfterTaskDrag", function (id, mode) {
                            var task = gantt.getTask(id);
                            if (mode != gantt.config.drag_mode.progress) {

                                var convert = gantt.date.date_to_str("%Y-%m-%d");
                                var s = convert(task.start_date);
                                var e = convert(task.end_date);
                                //gantt.message(task.id + " " + s + "-" + e);

                                var data ='url='+window.location.href+'&id='+task.id+'&start='+s+'&end='+e;
                                AjaxClient('prime','update_gant','GET',data,'AfterUpdateGant',task.id,0);


                            }
                        });
/*
                        gantt.attachEvent("onBeforeGanttRender", function(){
                            var range = gantt.getSubtaskDates();
                            var scaleUnit = gantt.getState().scale_unit;

                            if(range.start_date && range.end_date){
                                gantt.config.start_date = gantt.calculateEndDate(range.start_date, -4, scaleUnit);
                                gantt.config.end_date = gantt.calculateEndDate(range.end_date, 5, scaleUnit);
                            }
                        });
*/


                        function showScaleDesc() {
                            var min = gantt.getState().min_date,
                                max = gantt.getState().max_date,
                                to_str = gantt.templates.task_date;

                           // return gantt.message("Scale shows days from " + to_str(min) + " to " + to_str(max));
                        }
                        setTimeout(showScaleDesc, 500);

                        gantt.attachEvent("onScaleAdjusted", showScaleDesc);


                    });



                    function AfterUpdateGant(data,update) {

                        if (data.status == 'reg') {
                            WindowLogin();
                        }

                        if (data.status == 'ok') {

                        }
                        /*
                        if (data.status == 'error') {
                            alert_message('error','Ошибка сохранения!');
                        }*/
                    }




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