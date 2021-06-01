//var nprogress=0; //показывать загрузчик линию при ajax запросах	
function getRandomInt(min, max) { return Math.floor(Math.random() * (max - min + 1)) + min; }


function AjaxClient(dir_name,  //директория 
                    file_name, //имя файла без php
					typeQ, //тип запроса GET - POST
					data, //переменные которые передаются методом пост или гет username=Vasya&age=18&sex=male
					result_function,  //выполняемая функция при приходе ответа
					varibl, //переменная которую надо передать в вып. функцию
					form_id,  //id формы если нужно передать форму целиком или 0
					nprogress,  
 					cache,
					onyouself  //отправляет ajax на себя. для аjax запросов с историей
					) {	
					if(form_id==0)
					{
					   var data__ss=data;	
					} else
					{
					   var data__ss=jQuery("#"+form_id).serialize();
					}
					var vv='';
					if(varibl!=null)
					{
						
						if (typeof(varibl) == "string") 
						{
							vv=',"'+varibl+'"';
						} else
						{

						vv=','+varibl;
						}
					}
					
					var cache_ajax=true;
					if (cache === undefined) {
						
					} else
					{
						cache_ajax=cache;
					}
					
					if (onyouself=== undefined) 
					{
						var hop_url='Ajax/'+dir_name+'/'+file_name+'.php';
					} else
					{
						if(onyouself=='local')
						{
						var hop_url=window.location.href;
						} else
						{
						var hop_url=onyouself;	
						}
					}
					if ((nprogress=== undefined)||(nprogress== 0)) 
					{
						/*
					$('#nprogress').show();
					var width=getRandomInt(10,50);
					var width1=getRandomInt(50,70);
					var width2=getRandomInt(70,90);
					var width3=getRandomInt(95,97);
		            $('#nprogress .bar').animate({width: width+"%"}, 1000, function() {  $('#nprogress .bar').animate({width: width1+"%"}, 1000, function() { $('#nprogress .bar').animate({width: width2+"%"}, 2000, function() { $('#nprogress .bar').animate({width: width3+"%"}, 4000, function() {  }); }); }); });
					*/
						$('.loader_ada_forms').show();
						$('.loader_ada1_forms').addClass('select_ada');
						
					}
                    jQuery.ajax({
                    url:     hop_url, //Адрес подгружаемой страницы
                    type:     typeQ, //Тип запроса
                    dataType: "json",
					cache: cache_ajax,

                    data: data__ss,  //form_id - id формы html которую нужно передать
                    success: function(jsondata) { //Если все нормально
					if ((nprogress=== undefined)||(nprogress== 0)) 
					{
						/*
					  $('#nprogress .bar').stop(true);
					  $('#nprogress .bar').animate({width: "100%"}, 500, function() {  $('#nprogress').hide(); $('#nprogress .bar').width('0'); });
					*/
						$('.loader_ada_forms').hide();
						$('.loader_ada1_forms').removeClass('select_ada');
					}
					//window.jsozn=$.parseJSON(jsondata);
                    window.jsozn=jsondata;
					//alert(jsozn['debug']);

					if((jsozn['debug']!='')&&(jsozn['debug']!==undefined))
					{
					   //$('.w_size').show();
					   //$('.w_size').empty().append(jsozn['debug']);
					   //alert(jsozn['debug']);

						alert_message('error','Ошибка №'+jsozn['debug']);

					}
					//alert(result_function);
					
					$.globalEval(result_function+'(jsozn'+vv+')');
					
					
					
                },
                error: function(response) { //Если ошибка
                }
             });
        }
 
//отправка целой формы скрипту Ajax/best/add.php
/*
AjaxClient('best','add','POST',0,'AfterBestAdd',50,'add_best');
AfterBestAdd(data,varibl)
{
	if ( data.status == 'ok' )
	{

	}		
		
	if ( data.status == 'error' )
	{
		
	}	

}

##add.php
$_POST["name"] принемаем переданные переменные
$aRes = array('status' => 'ok', 'nickname' => 'Aramis');
require_once('Services_JSON.php');
$oJson = new Services_JSON();
echo $oJson->encode($aRes);
*/

//отправка переменных методом пост  
/*
AjaxClient('best','add1','POST','username=Vasya&age=18&sex=male','AfterBestAdd',null,0);
AfterBestAdd(data)
{
}
##add1.php
$_POST['username']
$_REQUEST['username'] принемаем переданные переменные
*/
