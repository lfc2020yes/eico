<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/'."sysadmin/run/interstroi.atsun.ru/XLS_DB.php";

$DR='../images/tree_S/';   //giphy
$ICON='load/';
?>
<style type="text/css">
a.readsheet {
    display: inline-block; 
    margin-top: 20px;
width: 120px;
height: 120px;

background-repeat     : no-repeat;
background-size       : cover;
background-position-x : 50%;
background-position-y : 50%;
   }    
   a.readsheet      { background: url(<?=$DR.$ICON?>knife.gif);}

.abs {
    clear: both;
    display: none;
    height: 4px;
    position: absolute;
    left: 8px;
    top: 20px;
    filter: alpha(Opacity=80);
    opacity: 0.8; 
}
.abs1 {
    clear: both;
    display: none;
    height: 4px;
    left: 20px;
    top: 10px;
    filter: alpha(Opacity=10);
    opacity: 0.1; 
}
.content {
    clear: both;
    margin: 8px;
}    
    
.typefile {
    display: none;    
    }	
.upload {
    border: 1px solid #ccc;
    border-radius: 50px;
    cursor: pointer;
	display: inline-block;
	padding: 10px;
}

.loaderr_scan {
    background-color: rgba(0, 0, 0, 0.05) !important;
    display: none;
    float: left;
    height: 2px;
    margin-left: 10px;
    margin-top: 30px;
    position: relative;
    width: 50%;
}
.loaderr_scan .scap_load__ {
    background-color: #ebcd15;
    height: 4px;
    left: 0;
    position: absolute;
    top: 0;
    transition: all 0s ease 0s, all 2s ease 0s;
}	
	
</style>

<script type="text/javascript">
 
   
        function AjaxFormSheet(result_id,form_id,url) {
    
    
    
    //var data = jQuery("#"+form_id).serialize();
    var $input = $("#file");
    //var fd = new FormData;

    //fd.append('xls', $input.prop('files')[0]);
    //fd.append('xls',$input[0]);
    
    alert ($input[0].files[0].name
            +':'+$input[0].files[0].error);
    //$.each($input[0].files, function(count, This_File) {
    // fd.append("xls" + count, This_File);
    // alert (This_File.name);

             jQuery.ajax({
                    url:     url, //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных
                    //processData: false,
                    //contentType: false,
                    //cache:false,
                    data: jQuery("#"+form_id).serialize(), 
        //data: fd,
        //dataType: 'json',
        //beforeSend: function(loading) { $('.loading').css("display", "block"); },
                    success: function(response) { //Если все нормально
                    document.getElementById(result_id).innerHTML = response;
                    console.log("Successfully done!");
                },
                error: function(response) { //Если ошибка
                  document.getElementById(result_id).innerHTML = "Ошибка при отправке формы";
                }
             });
      //  });
 }
   </script>
<?php

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{
    if ($row_TREE["DEBUG"]==1) {
        $DBG=true;
        console ("log","DEBUG");
    } else $DBG=false;
    //echo "<p/>PARAM: $PARAM";
    $GT=array();
    GET_PARAM($GT,$PARAM);
    //echo "<p/>".json_encode($GT);
    //if($DBG) echo "<pre>".print_r($GT,true).'</pre>';


    if(array_key_exists('id_object',$GT))           //$_GET
    {   $id_object=htmlspecialchars(trim( $GT["id_object"] ));
    } elseif(array_key_exists('id_razdel1',$GT)) {
        $id_razdel1=htmlspecialchars(trim( $GT["id_razdel1"] ));
    } elseif(array_key_exists('id_razdel2',$GT)) {
        $id_razdel2=htmlspecialchars(trim( $GT["id_razdel2"] ));
    } else exit();
    if(array_key_exists('name',$GT))           //$_GET
    { $name=htmlspecialchars(trim( $GT["name"] ));
    }

    $full_reload =  (isset($_POST["full_reload"]))?1:0;
    $full_reload_ch = ($full_reload>0)?'checked':'';
  $ret=0;

 if ($_SERVER['REQUEST_METHOD']=='GET')
 {
                                           // readonly  padding:0; 
      ?>
      <form enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>" id="form_xls" method="post" class="theform" >
        <strong style="margin:8px;">Загрузка себестоимости XLS: <?=$name?></strong><br>
        
        <?php
        if (isset($id_razdel2)) {
            $id_object = $result = Get_Realiz_razdel2($id_razdel2);
        } elseif (isset($id_razdel1)) {
            $id_object = $result = Get_Realiz_razdel1($id_razdel1);
        } elseif (isset($id_object)) {
            $result = Get_Realiz_object($id_object);
        }
        if($result===false) exit();
        ?>
        <br>
        <div id="read_sheet" class="abs" ><img width=400px height=400px src="../images/tree_S/load/giphy.gif"></div>   
        
        <div class="content">
        <select name="shablon" id="shablon" class="text" >
            <?php
            $shablon=new Tsql('select * from shablon_xls where visible=1 order by displayOrder');
            if ($shablon->num>0) {
                for($i=0; $i<$shablon->num; $i++) {
                     $shablon->NEXT();
                     echo '<option value = "' . $shablon->row['id'] . '">' . $shablon->row['name'] . '</option>';
                }
            }
            else echo '<option value = "0">не определены шаблоны загрузки</option>';
            $shablon->FREE();
?>
        </select> - выбрать шаблон загрузки XLS
        </div>

      <div class="content">
          <label><input class="checkbox" type="checkbox" name="full_reload" id="full_reload" value="<?=$full_reload?>" <?=$full_reload_ch?> /> - полная перегрузка (удалит связи в настройках доступа к объектам и разделам)</label>
      </div>

          <input type="hidden" name="xlsx" value="1" />
        <? if (isset($id_object)) { ?>
            <input type="hidden" name="id_object" id="id_object" value="<?=$id_object?>" />
        <? }
           if (isset($id_razdel1)) { ?>
            <input type="hidden" name="id_razdel1" id="id_razdel1" value="<?=$id_razdel1?>" />
        <? }
           if (isset($id_razdel2)) { ?>
            <input type="hidden" name="id_razdel2" id="id_razdel2" value="<?=$id_razdel2?>" />
        <? } ?>
        <input type="hidden" name="debug" id="debug" value="<?=$DBG?>" />
        
        <input type="file" name="file" id="file" SIZE="100" class="typefile"
               onchange="AjaxFormSheet('div_sheet', 'form_xls', '/sysadmin/run/interstroi.atsun.ru /xls_sheet.php')"
               accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
        <input type="file" name="filexls" id="filexls" class="typefile"
               accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
         
         
         <div class="content">
           <div id_upload="22"  id="selectxls" class="upload">Выбрать файл сметы для загрузки</div>
           <input type="file" name="xls" id="xls" class="typefile"
                  accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
         </div>
        
        
         <div class="loaderr_scan scap_load_20">
             <div class="scap_load__" style="width: 0%;"></div>
         </div>
         <div id="read_data" class="abs1" ><img width=200px height=150px src="../images/tree_S/load/loader.gif"></div>
         
         <div id="div_sheet" class="content"></div>   
           
      	   <div id="button" style="display:none">
             
             <div id_upload="33"  id="sebe" class="upload">Себестоимость</div>
             <div id_upload="34"  id="vedo" class="upload">Ведомость</div>
             <div id_upload="34"  id="bitogo" class="upload">Итого</div>
              <div id_upload="42"  id="binfo" class="upload">Инфо</div>
             <div id_upload="52"  id="erro" class="upload">Ошибки</div>
             <div id_upload="32"  id="real" class="upload">Загрузить</div>
             <div id_upload="42"  id="show" class="upload">Скрыть</div>
            
             
             <input type="submit" name="real_xls" id="real_xls" class="typefile" value="Отправить" />
	     <!--
             <input type="reset" class="button" value=" Сброс " />
              -->
           </div><br>
          <div id="load_data" class="abs1" ><img width=200px height=150px src="../images/tree_S/load/loader.gif"></div>
          <div id="div_data" style="display:none">Это данные Excel</div>
               
      </form>
      <?php    
 }
 else  // Это POST
 {  /*
     $eLOAD=false;
    //-------------------------------------Копирование файла на HOST
         //echo '<p>'.' 1'  .'</p>';
         $isCorrectAddInstr = "true";
         if(isset($_FILES[ "FileXLS" ]))
         {  //echo '<p>'.' 2'  .'</p>';
			$error_flag = $_FILES[ "FileXLS"  ]["error"];
            if($_FILES[ "FileXLS"  ]["error"] == 0) $isCorrectAddInstr = "false";
         }
         //echo '<p>'.' 3'  .'</p>';

         //---------------------------------------------------
         if($isCorrectAddInstr == "false")
         {      // надо грузить  файл
            //echo '<p>'.' 4'  .'</p>';
            
            echo '<p>from: '.$_FILES[ "FileXLS" ] ["tmp_name"].'</p>';
            $name=$_FILES["FileXLS"]["name"];
            $FileName=iconv("UTF-8","WINDOWS-1251",$name);
            echo '<p>name: '.$name.'</p>'; 
            if($_FILE["FileXLS"]["type"] == 'application/vnd.ms-excel') {
               $ext = ".xls";
            } elseif ($_FILE["FileXLS"]["type"] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
               $ext = ".xlsx";
                
            }
            //$DIR=realpath('.').DIRECTORY_SEPARATOR.'ilib'.DIRECTORY_SEPARATOR.'XLShost'.DIRECTORY_SEPARATOR;
            $DIR=realpath('..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'ilib'.DIRECTORY_SEPARATOR.'XLShost'.DIRECTORY_SEPARATOR;
            
            $FN=$DIR.$FileName;              //Каталог размещения файла
            $FN_=$DIR.$name;
            echo '<p>  to: '.$FN_.'</p>';
            //------------------------загрузка в каталог по определенному пути (с корректировкой пути)

		if(copy($_FILES[ "FileXLS" ] ["tmp_name"],$FN_))
                {     echo '<p>'.$FN_. ' Файл обновлен. Ok.'    .'</p>';
  	              $eLOAD=true;
  	        }
  	           else  echo '<p>'.$FN_. ' Файл НЕ ОБНОВЛЕН !!!'  .'</p>';
         }

     if($eLOAD) 
  */{  
      $FN_=$_POST["file"];
      $sheet=$_POST["sheet"];
      echo '<br>post id_object='. $_POST["id_object"].' sheet:'.$_POST["sheet"].' loadfile:'.$_POST["loadfile"];
      /*
        do { 
            if (Get_Realiz_object($id_object)!=0) break; 
            if (Delete_Data_object($id_object)!=0) break;  
            if (Update_File_object($id_object,$name)!=0) break;
            XLS_DB( $id_object,$FN_,'Себестоимость');   //$FN
        } while (1==0);
       * 
       */
     }
 }  //POST
}

/*
 * Получить информацию по подразделу с целью перегрузки
 */
function Get_Realiz_razdel1($id_razdel1){
    $id_object=false;
    $Raz1=new Tsql(
        'SELECT *
from i_razdel1 as i1, i_object as o
where
i1.id="'.$id_razdel1.'"  and i1.id_object= o.id');
    echo "<p/>раздел: $Raz1->sql "; ///
    if($Raz1->num>0) {
        $Raz1->NEXT();
        echo  '<table class="mtable">'
            .'<tr><th>Наименование<th>план<th>реализация<tr/>'
            . '<tr><td> сумма работ: <td>'.number_format(0.0+$Raz1->row['summa_r1'], 2, '.', '')
            .'<td>'.number_format(0.0+$Raz1->row['summa_r1_realiz'], 2, '.', '')
            .'</tr>'
            ."<tr><td> сумма материалов: <td>".number_format(0.0+$Raz1->row['summa_m1'], 2, '.', '')
            .'<td>'.number_format(0.0+$Raz1->row['summa_m1_realiz'], 2, '.', '')
            .'</tr>'
            ."<tr><td> Итого: <td>".number_format(0.0+$Raz1->row['summa_r1']+$Raz1->row['summa_m1'], 2, '.', '')
            .'<td>'.number_format(0.0+$Raz1->row['summa_r1_realiz']+$Raz1->row['summa_m1_realiz'], 2, '.', '')
            .'</tr>'
            ."</table>";
        $id_object = $Raz1->row['id_object'];
    } else {
        echo "<p/>Нет доступа к вызываемому подразделу: $Raz1->sql ";
    }
    unset($Raz1);
    return $id_object;
}

/*
 * Получить информацию по разделу с целью перегрузки
 */
function Get_Realiz_razdel2($id_razdel2){
    $id_object=false;
    $Raz2=new Tsql(
'SELECT *
FROM i_razdel2 AS i2, i_razdel1 AS i1, i_object AS o
WHERE
i2.id="'.$id_razdel2.'" AND i2.id_razdel1=i1.id  AND i1.id_object= o.id');
    echo "<p/>статья: $Raz2->sql "; ///
    if($Raz2->num>0) {
        $Raz2->NEXT();
        echo  '<table class="mtable">'
            .'<tr><th>Наименование<th>план<th>реализация<tr/>'
            . '<tr><td> сумма работ: <td>'.number_format(0.0+$Raz2->row['subtotal'], 2, '.', '')
            .'<td>'.number_format(0.0+$Raz2->row['summa_r2_realiz'], 2, '.', '')
            .'</tr>'
            ."<tr><td> сумма материалов: <td>".number_format(0.0+$Raz2->row['summa_material'], 2, '.', '')
            .'<td>'.number_format(0.0+$Raz2->row['summa_mat_realiz'], 2, '.', '')
            .'</tr>'
            ."<tr><td> Итого: <td>".number_format(0.0+$Raz2->row['subtotal']+$Raz2->row['summa_material'], 2, '.', '')
            .'<td>'.number_format(0.0+$Raz2->row['summa_r2_realiz']+$Raz2->row['summa_mat_realiz'], 2, '.', '')
            .'</tr>'
            ."</table>";
        $id_object = $Raz2->row['id_object'];
    } else {
        echo "<p/>Нет доступа к вызываемому подразделу: $Raz2->sql ";
    }
     unset($Raz2);
     return $id_object;
}

/*todo  выбор нарядов с номерами разделов чтобы перезагрузить если нарядов в разделах нет: s.`razdel1` not in (2,3)

 SELECT
n.id_object, s.razdel1
,COUNT(n.id) AS ncount, SUM(n.summa_work) AS wsumma,SUM(n.summa_material) AS msumma
FROM n_nariad n, n_work m, i_razdel2 s
WHERE
n.id_object="53"
and m.`id_nariad` = n.`id`
AND m.`id_razdeel2` = s.`id`
and s.`razdel1` not in (2,3)
GROUP BY n.id_object ,s.razdel1
 */
function Get_Realiz_object($id_object){
 $ret=false;
 $Obj=new Tsql(
'select * 
from i_object o left join  
(
select id_object,count(id) as ncount,sum(summa_work) as wsumma,sum(summa_material) as msumma
from n_nariad 
where id_object="'.$id_object.'"
group by id_object
) n on( o.id= n.id_object)
where o.id="'.$id_object.'"');
 echo "<p/>объект: $Obj->sql "; ///
 if($Obj->num>0) {
    $Obj->NEXT();
    
     echo  '<table class="mtable">'
    .'<tr><th>Наименование<th>план<th>реализация<tr/>'
            . '<tr><td> сумма работ: <td>'.number_format(0.0+$Obj->row['total_r0'], 2, '.', '')
             .'<td>'.number_format(0.0+$Obj->row['total_r0_realiz'], 2, '.', '')
             .'</tr>'
            ."<tr><td> сумма материалов: <td>".number_format(0.0+$Obj->row['total_m0'], 2, '.', '')
             .'<td>'.number_format(0.0+$Obj->row['total_m0_realiz'], 2, '.', '')
             .'</tr>'
            ."<tr><td> Итого: <td>".number_format(0.0+$Obj->row['total_r0']+$Obj->row['total_m0'], 2, '.', '')
             .'<td>'.number_format(0.0+$Obj->row['total_r0_realiz']+$Obj->row['total_m0_realiz'], 2, '.', '')
             .'</tr>'
            ."</table>";
     $ret=$Obj->row[id];


     if ($Obj->row['ncount']>0) {
    //if (!(($Obj->row['total_r0_realiz']==0) and ($Obj->row['total_m0_realiz']==0))) {
       echo "<p/>Невозможно перегрузить объект: ".$Obj->row['object_name']
               ."<p/>, потому что по нему открыто выполнение по смете"
               ."<p/>, количество нарядов: ".$Obj->row['ncount']
               ."<p/> сумма выполненных работ: ".$Obj->row['wsumma']
               ."<p/> сумма затраченных материалов: ".$Obj->row['msumma'];  
    }
    $Obj->FREE();
 } else {
    echo "<p/>Нет доступа к вызываемому объекту: $Obj->sql "; 
 }
 unset($Obj);
 return $ret;
}



/*
<script type="text/javascript">
$(document).on("ready", function() {
  alert("hello");
})   
</script>

 * 
 */
?>
<script type="text/javascript">

jQuery(document).ready(function() {
   //console.log("ready");
   /*
    $(window).on('load', function() {
        console.log("window load");
    });
   */     
   $("#filexls").on("change", function(e){
   var file = this.files[0],
       fileName = file.name,
       fileSize = file.size;
       alert("Uploading: "+fileName+" @ "+fileSize+"bytes");
       
       e.preventDefault();
       var fd = new FormData($("form")[0]);    //ТО ЧТО ПЕРЕДАЕТ $_FILES
       
       jQuery.ajax({
                    url:     '/sysadmin/run/interstroi.atsun.ru/xls_sheet.php', //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    //dataType: "html", //Тип данных
                    processData: false,
                    contentType: false,
                    cache:false,
                    //data: jQuery("#form_xls").serialize(), 
                data: fd,
                success: function(response) { //Если все нормально
                    document.getElementById("div_sheet").innerHTML = response;
                    console.log("Successfully done!");
                },
                error: function(response) { //Если ошибка
                  document.getElementById("div_sheet").innerHTML = "Ошибка при отправке формы";
                }
             });
   //CustomFileHandlingFunction(file);
   });
   $("#selectxls").on("click",function(){     //Вызов нажатия кнопки выбора файлов input      
       //alert("#selectxls");
       document.getElementById('div_sheet').style.display = 'none';
       document.getElementById('button').style.display = 'none';
       document.getElementById('div_data').style.display = 'none';
       
       $('[name=xls]').trigger('click');
       
       document.getElementById('div_sheet').style.display = 'none';
       document.getElementById('button').style.display = 'none';
       $('.scap_load_20').find('.scap_load__').width('0%');
   });
   $("#xls").on("change", function(){         //Произведен выбор файла для загрузки
       //alert("#xls="+this.files[0].name);
       var file = this.files[0];
	      if (file) { upload(file,20); 
                                
                        }
        
   });
   $("#real").on("click",function(){ 
      //alert ('real'); 
      //----------------------$('[name=real_xls]').trigger('click'); //Вызов POST
      //alert ('real_xls');
      var FN = document.getElementById('loadfile').value;
      if (FN!='') {
      //Begin();    //Меню в начальное положение
      //$("#sebe").css('color', 'black');
      //$("#sebe").css('font-weight', 'normal');
      //$(this).css('color', 'blue');
      //$(this).css('font-weight', 'bold');
      //alert (FN); 
        AjaxConfirm(FN);
        document.getElementById('loadfile').value='';
      }
   });
   $("#show").on("click",function(){ 
     var display = document.getElementById('div_data').style.display;
     if (display=='none') { 
         $('#div_data').show();
         $(this).text('Скрыть');
     } else { 
         $('#div_data').hide();  
         $(this).text('Показать');
     }
   });
   $("#sebe").on("click",function(){ 
        Begin();
   });
   $("#vedo").on("click",function(){ 
      $('.div_ok').hide(); 
      $('.div_ved').show();
      $('.div_err').hide();
      $("#erro").text('Ошибки'); 
      $(this).css('color', 'blue');
      $(this).css('font-weight', 'bold');
      $("#sebe").css('color', 'black');
      $("#sebe").css('font-weight', 'normal');
   });
   $("#bitogo").on("click",function(){
      ShHi("#bitogo",'itogo','.div_itogo');
   });   
   $("#binfo").on("click",function(){
      ShHi("#binfo",'info','.div_info');
      
      /*
      var div = document.getElementById('info'); 
      if (div) {
         if (div.style.display=='none') $('.div_info').show(); 
         else $('.div_info').hide(); 
      }
      */
   });
   $("#erro").on("click",function(){ 
		//$('.div_err').show();  //.hide();
     var div = document.getElementById('ok'); //.style.display;
     var div01 = document.getElementById('ved'); //.style.display;
     var div02 = document.getElementById('xls_err'); //.style.display;
     //var display;
     if (div && div01 && div02) {
         if (div.style.display=='none' && div01.style.display=='none')  {   //Это были ошибки себестоимости
            $('.div_ok').show(); 
            $(this).text('Ошибки'); 
         }  else {                            //Это была себестоимость     
            if (div.style.display=='none' && div01.style.display!='none') {   //Это  ведомости
                if (div02.style.display=='none') {
                    $('.div_err').show(); 
                    $(this).text('Скрыть Ошибки'); 
                } else {
                    $('.div_err').hide(); 
                    $(this).text('Ошибки'); 
                }
         
            } else {
            if (div.style.display!='none' && div01.style.display=='none') {   //Это себестоимость 
              $('.div_ok').hide(); 
              $(this).text('Показать все');
            } 
         }      
     } 
    }
             /*
     if(div) {
        if (div.style.display=='none')  { 
            $('.div_ok').show(); 
            $(this).text('Ошибки');
        } else { 
            $('.div_ok').hide(); 
            $(this).text('Показать все');
        }
        //document.getElementById('div_err').style.display = display;  
     }
     */
   });
 }); 
    function ShHi(id_button,id,data_div) {  //переключатель
     var div = document.getElementById(id); 
      if (div) {
         if (div.style.display=='none'){ 
             $(data_div).show();
             button(id_button,'','blue','bold');
         } else {
             $(data_div).hide();
             button(id_button,'','black','normal');
         }
      }  
    }
    function button(id,text,color,bold) {
      if (text!='') {  
        $(id).text(text);
      }
      $(id).css('color', color);
      $(id).css('font-weight', bold);  
    }
    function Begin(){ 
      BeginSebe();
      BeginButton();
    } 
    function BeginButton(){ 
      button("#bitogo",'','blue','bold');
      $('.div_itogo').show();
      button("#binfo",'','black','normal');
      $('.div_info').hide();   
    }
    function LoadButton(){
      button("#sebe",'','black','normal');
      $('.div_ok').hide(); 
      button("#vedo",'','black','normal');
      $('.div_ved').hide();
      button("#bitogo",'','blue','bold');
      $('.div_itogo').show();
      button("#binfo",'','black','normal');
      $('.div_info').hide(); 
      button("#erro",'Ошибки','black','normal');
      $('.div_err').hide();
      button("#real",'Загружено','blue','bold');
      $("#real").css('background','lightgray');
      button("#show",'Скрыть','black','normal');
      $('#div_data').show();  
    } 
    function BeginSebe(){               //Начальное положение меню
      button("#sebe",'','blue','bold');
      $('.div_ok').show(); 
      button("#vedo",'','black','normal');
      $('.div_ved').hide();
      
      button("#erro",'Ошибки','black','normal');
      $('.div_err').show();
      //button("#real",'','black','normal');
      button("#show",'Скрыть','black','normal');
      $('#div_data').show();
    }

    function upload(file,id) {

      var xhr = new XMLHttpRequest();

      // обработчики можно объединить в один,
      // если status == 200, то это успех, иначе ошибка
      xhr.onload = xhr.onerror = function() {
        if (this.status == 200) {                     //Успешная загрузка файла
                  document.getElementById("selectxls").innerHTML= file.name+' !';
		  //$('#selectxls').before(file.name+' !');	
          //загрузилось удаляю кнопку выбора файла и полосу загрузки
		  //$('[id_upload='+id+']').remove();
		  //$('.scap_load_'+id).remove(); 
                  //alert(xhr.responseText);
                  document.getElementById("div_sheet").innerHTML = xhr.responseText;
                  document.getElementById('div_sheet').style.display = 'block';
                  //document.getElementById('read_sheet').style.display = 'none';
		  
        } else {
			//ошибка показываю снова кнопку выбора файла и полосу загрузки
          $('[id_upload='+id+']').show();
		  $('.scap_load_'+id).find('.scap_load__').width(0); 
		  $('.scap_load_'+id).hide();
        }
      };

      
     xhr.upload.onprogress = function(event) {         // обработчик для закачки
		 
		//$('[id_upload='+id+']').hide();       //пока скрываю кнопку выбора файла и показываю полосу загрузки
		$('.scap_load_'+id).show();  
		var widths=Math.round((event.loaded*100)/event.total);
		$('.scap_load_'+id).find('.scap_load__').width(widths+'%');
                if (widths==100) {
                    //alert (widths);
                    //document.getElementById('read_sheet').style.display = 'block';
                }
     }

     xhr.open("POST", "/sysadmin/run/interstroi.atsun.ru/xls_load.php", true);
        
     var formData = new FormData();
     formData.append("thefile", file);
     //formData.append("id",id);             //передаю в файл и нужную мне переменную id
     xhr.send(formData);
    }
    
    function AjaxXLS(FileName) {   //----------------------При Выборе закладки для загрузки
        var sel=document.getElementById('sheet');
        //alert ("AjaxXLS: "+FileName+"|"+sel.name+"|"+sel.value);
        //alert (sel.name+':'+sel.selectedIndex+':'+sel.options[sel.selectedIndex].text+':'+sel.value); //sheet:1:Себестоимость:Себестоимость
        document.getElementById('read_data').style.display = 'block';
        document.getElementById('button').style.display = 'none';

        var id_object=document.getElementById('id_object').value;

        var id_razdel1=document.getElementById('id_razdel1');
        var id_r1 = (id_razdel1) ? id_razdel1.value : 0;
        var id_razdel2=document.getElementById('id_razdel2');
        var id_r2 = (id_razdel2) ? id_razdel2.value : 0;

        var full_reload=document.getElementById('full_reload');
        var frel = 0;
        if (full_reload) {
            //alert ("full_reload="+full_reload.checked);
            frel = (full_reload.checked)? 1 : 0;
        }
        alert ("AjaxXLS: "+FileName+ "\n" +sel.name+"="+sel.value+"\n id_object=" +id_object + "\n id_r1=" +id_r1+ "\n id_r2=" +id_r2 + "\n frel="+ frel);


        jQuery.ajax({
                    url:     "/sysadmin/run/interstroi.atsun.ru/xls_analist.php", //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных json html
                    data:  {
                            id_r1: id_r1,
                            id_r2: id_r2,
                            //full_reload: frel,
                            file: FileName,
                            sheet: sel.value, 
                            shablon: document.getElementById('shablon').value,
                            db: '<?=$_GET['DB']?>',
                            debug: document.getElementById('debug').value
                            },
                    success: function(response) { //Если все нормально
                    document.getElementById('div_data').innerHTML = response;
                    document.getElementById('read_data').style.display = 'none';
                    document.getElementById('button').style.display = 'block';
                    document.getElementById('div_data').style.display = 'block';
                    Begin();    //Меню в начальное положение
                },
                error: function(response) { //Если ошибка
                  document.getElementById('div_data').innerHTML = "Ошибка при отправке формы: "+response;
                  document.getElementById('read_data').style.display = 'none';
                  document.getElementById('div_data').style.display = 'block';
                  Begin();    //Меню в начальное положение
                }
             });   
    }
    function AjaxConfirm(FileName) {   //Подтверждение загрузки в базу
        var sel=document.getElementById('sheet');
        
        //alert (sel.name+':'+sel.selectedIndex+':'+sel.options[sel.selectedIndex].text+':'+sel.value); //sheet:1:Себестоимость:Себестоимость
        document.getElementById('load_data').style.display = 'block';
        document.getElementById('button').style.display = 'none';
        var object_edit=document.getElementById('id_object');
        var id_object = (object_edit) ? object_edit.value : 0;
        var id_razdel1=document.getElementById('id_razdel1');
        var id_r1 = (id_razdel1) ? id_razdel1.value : 0;
        var id_razdel2=document.getElementById('id_razdel2');
        var id_r2 = (id_razdel2) ? id_razdel2.value : 0;

        var full_reload = document.getElementById('full_reload');
        var frel = 0;
        if (full_reload) {
            alert ("full_reload="+full_reload.checked);
            frel = (full_reload.checked)? 1 : 0;
        }

        alert ("AjaxXLS: "+FileName+ "\n" +sel.name+"="+sel.value+"\n id_object=" +id_object + "\n id_r1=" +id_r1+ "\n id_r2=" +id_r2+ "\n frel="+ frel);
        jQuery.ajax({
                    url:     "/sysadmin/run/interstroi.atsun.ru/xls_confirm.php", //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных json html
                    data:  {
                            id_object: id_object,
                            id_r1: id_r1,
                            id_r2: id_r2,
                            full_reload: frel,
                            file: FileName,
                            sheet: sel.value,
                            shablon: document.getElementById('shablon').value,
                            db: '<?=$_GET['DB']?>', 
                            debug: document.getElementById('debug').value
                            },
                    success: function(response) { //Если все нормально
                    document.getElementById('div_data').innerHTML = response;
                    document.getElementById('load_data').style.display = 'none';
                    document.getElementById('button').style.display = 'block';
                    LoadButton();
                },
                error: function(response) { //Если ошибка
                  document.getElementById('div_data').innerHTML = "Ошибка при отправке формы: "+response;
                  document.getElementById('load_data').style.display = 'none';
                  BeginSebe();
                }
             });   
    }
 </script>
 
 
 