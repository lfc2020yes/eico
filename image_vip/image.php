<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><!--<meta name="viewport" content="width=device-width; initial-scale=1.0">--><link rel="icon" type="image/png" href="favicon.png" /><link rel="apple-touch-icon" href="apple-touch-favicon.png"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="keywords" content="" /><meta name="description" content="" /><base href="http://www.eico.atsun.ru/">

<script language="javascript" type="text/javascript" src="/Js/jquery-2.1.1.js"></script>
<script language="javascript" type="text/javascript" src="/Js/jquery.ajax.js"></script>
<script language="javascript" type="text/javascript" src="/Js/respond.src.js"></script>


<!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.min.js"></script><![endif]-->

<style type="text/css">
	
.naryd_upload {
    border: 1px solid #ccc;
    border-radius: 50px;
    cursor: pointer;
	display: inline-block;
	padding: 10px;
}
.form_up {
    display: none;
}
.loaderr_scan {
    background-color: rgba(0, 0, 0, 0.05) !important;
    display: none;
    float: left;
    height: 2px;
    margin-left: 10px;
    margin-top: 30px;
    position: relative;
    width: 100%;
}
.loaderr_scan .scap_load__ {
    background-color: #24c32d;
    height: 4px;
    left: 0;
    position: absolute;
    top: 0;
    transition: all 0s ease 0s, all 2s ease 0s;
}	
	
</style>

</head><body class="image_primer">
<script language="javascript">

//эмуляция нажатия на старую страшную кнопку
var UploadScan = function()
{
	var id_upload=$(this).attr('id_upload');
	$('[name=myfile'+id_upload+']').trigger('click');
}	

function upload(file,id) {

      var xhr = new XMLHttpRequest();

      // обработчики можно объединить в один,
      // если status == 200, то это успех, иначе ошибка
      xhr.onload = xhr.onerror = function() {
        if (this.status == 200) {
		  $('[id_upload='+id+']').before('Все загрузилось!');	
          //загрузилось удаляю кнопку выбора файла и полосу загрузки
		  $('[id_upload='+id+']').remove();
		  $('.scap_load_'+id).remove(); 
		  
        } else {
			//ошибка показываю снова кнопку выбора файла и полосу загрузки
          $('[id_upload='+id+']').show();
		  $('.scap_load_'+id).find('.scap_load__').width(0); 
		  $('.scap_load_'+id).hide();
        }
      };

      // обработчик для закачки
      xhr.upload.onprogress = function(event) {
		 //пока скрываю кнопку выбора файла и показываю полосу загрузки 
		$('[id_upload='+id+']').hide();  
		$('.scap_load_'+id).show();  
		var widths=Math.round((event.loaded*100)/event.total);
		$('.scap_load_'+id).find('.scap_load__').width(widths);  
      }

      xhr.open("POST", "image_vip/upload.php", true);
      //xhr.send(file);
	
	 //передаю в файл и нужную мне переменную id
	 var formData = new FormData();
     formData.append("thefile", file);
	 formData.append("id",id);
     xhr.send(formData);

    }



//выполняется когда выбрали файл
var UploadScanChange = function()
{
	//тут я в атрибуте сохранил нужное id с которым связать загружаемую фотку
	//достаю это значение и передаю в функцию загрузки и файл сам
	var id=$(this).parents('form').attr('id_sc');
	file = this.files[0];
	      if (file) {
        upload(file,id);
      } 
      return false;	
}
	
$(function (){	
$('.image_primer').on("click",'.naryd_upload',UploadScan);
$('.image_primer').on("change",'.sc_sc_loo',UploadScanChange);	
});
	
</script>	  

<!-- кнопка по нажатию на которую будет открывать окно выбора файла. избавляемся от привычной страшной кнопки -->	  	  
<div id_upload="20"  class="naryd_upload">Загрузить</div>
<!-- сама форма отправки ее не видно скрываем с помощью стилей-->
<form class="form_up" id="upload_sc_20" id_sc="20" name="upload20"><input class="sc_sc_loo" name="myfile20" type="file"></form>
<!-- полоса загрузки файла. по умолчанию не видно  -->
<div class="loaderr_scan scap_load_20"><div class="scap_load__" style="width: 0%;"></div></div>

</body></html>