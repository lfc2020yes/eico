<?php
include_once("./run/interstroi.atsun.ru/RUN_style.php");
include_once("./run/interstroi.atsun.ru/XLS_export.php");

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0) {
    if ($row_TREE["DEBUG"]==1) {
        $DBG=true;
        console ("log","DEBUG");
    } else $DBG=false;
    //echo "<p/>PARAM: $PARAM";
    $GT=array();
    GET_PARAM(&$GT,$PARAM);
    //echo "<p/>".json_encode($GT);
    
    if(array_key_exists('id_object',$GT))           //$_GET
    {
	$id_object=htmlspecialchars(trim( $GT["id_object"] ));
         //echo "<p/> id_user=".$id_user;
    } else exit();
    if(array_key_exists('name',$GT))           //$_GET
    {
	$name=htmlspecialchars(trim( $GT["name"] ));
         //echo "<p/> name=".$name;
    }
  //echo "<p/> id_object=$id_object name=$name";
  $ret=0;

 if ($_SERVER['REQUEST_METHOD']=='GET')
 {  $fn='object_'.$id_object.'.xlsx';
                                           // readonly  padding:0; 
      ?>
      <form enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>" id="form_xls" method="post" class="theform" >
        <strong style="margin:8px;">Export XLSX: <?=$name?></strong><br>
       
        <br>
            <div id="read_sheet" class="abs" ><img width=400px height=400px src="../images/tree_S/load/giphy.gif"></div>   
            <div id="load_data" class="abs1" ><img width=200px height=150px src="../images/tree_S/load/loader.gif"></div>
          
            <input type="hidden" name="id_object" id="id_object" value="<?=$id_object?>" />
            <input type="hidden" name="fn" id="fn" value="<?=$fn?>" />
            <input type="hidden" name="debug" id="debug" value="<?=$DBG?>" />
             <div id_upload="33"  id="dload"  data-filename="<?=$fn?>" class="upload">Download <?=$fn?></div>
             <div id="div_data" style="display:none">Создание отчета</div>
             <br>
             
             <div class="loaderr_scan scap_load_20">
                 <div class="scap_load__" style="width: 0%;"></div>
            </div>
             
      </form>
      <?php 
      //CH_cell(1);
 }
 else  // Это POST
 {
     echo '<br>post id_object='. $_POST["id_object"];
     export2XLS('Estimate',$_POST["id_object"],true); 
 }
} 
?>
<script type="text/javascript">

jQuery(document).ready(function() {
  $("#dload").on("click",function(){
    var id = document.getElementById('id_object').value;  
    Make_XLS(id);
    
 });
}); 

function Make_XLS(id) { 
    document.getElementById('read_sheet').style.display = 'block';
    document.getElementById('div_data').style.display = 'block';
    jQuery.ajax({
                    url:     "/sysadmin/run/interstroi.atsun.ru/xls_make.php", //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных json html
                    data:  {
                            id: id,   
                            db: '<?=$_GET['DB']?>', 
                            debug: document.getElementById('debug').value
                            },
                    success: function(response) { //Если все нормально
                    document.getElementById('div_data').innerHTML = response;
                    document.getElementById('read_sheet').style.display = 'none';
                    //if (response=='ok') {
                        DLoad(id);
                    //}    
                },
                error: function(response) { //Если ошибка
                  document.getElementById('div_data').innerHTML = "Ошибка при отправке формы: "+response;
                  document.getElementById('read_sheet').style.display = 'none';
                }
             });   
}

function DLoad(id) {
    var that = this;
    var req = new XMLHttpRequest();
    
    req.addEventListener("progress", function (event) {
        if((event.lengthComputable) && (event.total>0)) {
            //  var percentComplete = event.loaded / event.total;
            //  console.log(percentComplete);
            //}
    ///    alert ('total='+event.total+':'+event.loaded)
        $('.scap_load_20').show();  
    		var widths=Math.round((event.loaded*100)/event.total);
    		$('.scap_load_20').find('.scap_load__').width(widths+'%');
            }
    }, false);
/*  
     req.!download!.onprogress = function(event) {         // обработчик для закачки
     req.DLoad.onprogress = function(event) { 		 
		$('.scap_load_20').show();  
		var widths=Math.round((event.loaded*100)/event.total);
		$('.scap_load_20').find('.scap_load__').width(widths+'%');
               
     }
*/    

    req.responseType = "blob";
    req.onreadystatechange = function () {
        if ((req.readyState === 4) && (req.status === 200)) {
            //alert (req.status);
            //var filename = $(that).data('filename');
            //var filename = req.getResponseHeader("filename")
            var filename = document.getElementById('fn').value;
            if (typeof window.chrome !== 'undefined') {
                // Chrome version
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(req.response);
                link.download = filename;
                link.click();
            } else if (typeof window.navigator.msSaveBlob !== 'undefined') {
                // IE version
                var blob = new Blob([req.response], { type: 'application/force-download' });
                window.navigator.msSaveBlob(blob, filename);
            } else {
                // Firefox version
                var file = new File([req.response], filename, { type: 'application/force-download' });
                //alert (filename);
                //document.getElementById('div_data').innerHTML = req.response;
                window.open(URL.createObjectURL(file));
            }
        }
    };
    var page_url = '/sysadmin/run/interstroi.atsun.ru/download.php';
    req.open("POST", page_url, true);
    var formData = new FormData();
    var filename="object_"+id+".xlsx";
    //alert (filename);
    formData.append("file", filename);
    //alert ('id: '+id);
    req.send(formData);
}  
</script>