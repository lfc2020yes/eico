

var disabledDays = [];

$(document).ready(function(){
   //console.log("document ready");
   $('.eddd_box').on("change", function(){
      //alert("change");
      $('.save_akt').show();
      $('.send_akt').hide();
   });
   $('.input_100').on("change keyup input click", function(){   //Редактирование кол-ва
      //alert("id="+this.id);
              /*  получить id
               *  получить цену
               *  изменить сумму
               */                   //0   1 2   3    4      5
      var arr = this.id.split('_'); //act i ids idsm id_act idm
      //alert(arr[0]+' ! '+ arr[1]);

      if (arr[0].trim()==='act') {
          //alert(arr[0].trim()==='act');
          //alert(document.getElementById('act_price_'+arr[1]));
          //alert(document.getElementById('act_price_'+arr[1]).value
          //        +' !! '+document.getElementById('act_sh_'+arr[1]).value
          //        +' !! '+document.getElementById(this.id).value);
          var price=document.getElementById('act_price_'+arr[1]).value;
          var summa=price*document.getElementById(this.id).value;
          document.getElementById('act_sh_'+arr[1]).value=summa;
          document.getElementById('act_summa_'+arr[1]).innerHTML=number_format(summa,2,'-',' ');
          $('.save_akt').show();
          $('.send_akt').hide();
      }

   });
   /***
number - исходное число
decimals - количество знаков после разделителя
dec_point - символ разделителя
thousands_sep - разделитель тысячных
***/
            function number_format(number, decimals, dec_point, thousands_sep) {
              number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
              var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                  var k = Math.pow(10, prec);
                  return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
                };
              // Fix for IE parseFloat(0.55).toFixed(0) = 0;
              s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
                .split('.');
              if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
              }
              if ((s[1] || '')
                .length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1)
                  .join('0');
              }
              return s.join(dec);
            }
   $("#date_table").datepicker({

    altField:'#date_hidden_table',
    onClose : function(dateText, inst){
           //alert(dateText); //

    },
    onSelect: function(dateText, inst) {
            savedefault($("#date_table"));
    },
    altFormat:'yy-mm-dd',
    defaultDate:null,
    beforeShowDay: disableAllTheseDays,
    dateFormat: "d MM yy"+' г.',
    firstDay: 1,
    minDate: "-90D", maxDate: "+90D",
    beforeShow:function(textbox, instance){
            //alert('before');
            setTimeout(function () {
                instance.dpDiv.css({
                    position: 'absolute',
                    top: 65,
                    left: 0
                });
            }, 10);

        $('.bookingBox').append($('#ui-datepicker-div'));
        $('#ui-datepicker-div').hide();
    } });

$("#date_table1").datepicker({
range: 'period', // режим - выбор периода
numberOfMonths: 2,
//altField:'#date_hidden_period',

onSelect: function(dateText, inst, extensionRange) {
    	// extensionRange - объект расширения
	resizeDatepicker();
	$('#date_table1').val(jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.startDate) + ' - ' + jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.endDate));


	$('#date_hidden_start').val(jQuery.datepicker.formatDate('yy-mm-dd',extensionRange.startDate));
	$('#date_hidden_end').val(jQuery.datepicker.formatDate('yy-mm-dd',extensionRange.endDate));

	$('#date_table1').prev('label').show();

	savedefault($("#date_table1"));

    },

//beforeShowDay: disableAllTheseDays,
//dateFormat: "d MM yy"+' г.',
//firstDay: 1,
//minDate: "-60D", maxDate: "+60D",
onChangeMonthYear: resizeDatepicker,
beforeShow:function(textbox, instance, extensionRange){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 65,
                left: 0,
				width:'100%'
            });
        }, 10);

    $('.bookingBox1').append($('#ui-datepicker-div'));
    $('#ui-datepicker-div').hide();
}

});
    function resizeDatepicker() {
        setTimeout(function() { $('.bookingBox1 > .ui-datepicker').width('100%'); }, 10);
    }

 });

function jopacalendar(queryDate,queryDate1,date_all) {
    if(date_all!==''){
        var dateParts = queryDate.match(/(\d+)/g), realDate = new Date(dateParts[0], dateParts[1] -1, dateParts[2]);
        var dateParts1 = queryDate1.match(/(\d+)/g), realDate1 = new Date(dateParts1[0], dateParts1[1] -1, dateParts1[2]);
        $('#date_table1').datepicker('setDate', [realDate,realDate1]);
        $('#date_table1').val(date_all);
    }
}
//------------------------------------------------------------------------------


function SetCLS(arrID,class_name) {  //'error_formi'  //Установить отображение ошибки по списку
    if (arrID!=null ) {
        console.log(arrID);
        var id;
        for (var i = 0; i < arrID.length; i++) {
             console.log(arrID[i]);
             id=document.getElementById(arrID[i]);
             $(id).addClass(class_name);
        }
    }
}


    
function AjaxDeleteMat(id) {     //Удаление материала из акта (SQL)
    //console.log ('AjaxAccept:'+id);
    jQuery.ajax({
                    url:     "/aktpp/ajax_delete_mat.php", //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных json html
                data:  {
                        id: id
                },
                success: function(response) { //Если все нормально
                //alert (response);
                if (response!="") {   //Ошибка удаления
                    document.getElementById('mat'+id).innerHTML = "%";
                } else {
                //===========================Удалить со страницы запись о материале
                    document.getElementById('row_'+id).style.display = 'none';
                    //$('.save_akt').show();
                }
                    
                },
                error: function(response) { //Если ошибка
                alert ('ERROR '+response);
                }
             });
}
function AjaxDeleteAkt(id) {            //Удалить весь акт
    jQuery.ajax({
                    url:     "/aktpp/ajax_delete_akt.php", //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных json html
                data:  {
                        id: id
                },
                success: function(response) { //Если все нормально
                //alert (response);
                if (response!="") {   //Ошибка изменения
                    //document.getElementById('mat'+id).innerHTML = "%";
                    alert ('ERROR '+response);
                } else {
                    location.href = 'aktpp/work/';
                    //$('.send_akt').hide();
                }
                    
                },
                error: function(response) { //Если ошибка
                alert ('ERROR '+response);
                }
             });
}

function AjaxSendAkt(id) {            //Послать акты на подписи
    jQuery.ajax({
                    url:     "/aktpp/ajax_send_akt.php", //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных json html
                data:  {
                        id: id
                },
                success: function(response) { //Если все нормально
                //alert (response);
                if (response!="") {   //Ошибка изменения
                    //document.getElementById('mat'+id).innerHTML = "%";
                    alert ('ERROR '+response);
                } else {
                    location.href = 'aktpp/sen/';
                    //$('.send_akt').hide();
                }
                    
                },
                error: function(response) { //Если ошибка
                alert ('ERROR '+response);
                }
             });
}
    function AjaxSaveAkt(id,id_user) {            //Сохранить акт
        var date = document.getElementById('date_hidden_table').value;
        var user= document.getElementById('ispol').value;
        var cm=document.getElementById('count_mat').value;
        var arr_data=[];
        for (var i = 0; i < cm; i++) {             //количество по позиции
          //console.log (i + ' count='+ document.getElementsByName('count_'+i)[0].value);
          arr_data[i] = [];
          arr_data[i][0] =document.getElementsByName('works['+i+'][id]')[0].value;
          arr_data[i][1] = document.getElementsByName('count_'+i)[0].value;
        }

        //------------------------------------------------------------------
        jQuery.ajax({
                    url:     "/aktpp/ajax_save_akt.php", //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных json html
                data:  {
                            id: id  ,
                            id1_user: user,
                            date: date,
                            mat: JSON.stringify(arr_data)
                    },
                success: function(response) { //Если все нормально
                    //alert (response);
                    if (response!=="") {   //Ошибка изменения
                        //document.getElementById('mat'+id).innerHTML = "%";
                        alert ('ERROR '+response);
                    } else {  //------------Нормально удалить корзину
                        var id_user=id_user;
                        var id_visor=user;  // <?=$id_visor?>;
                        //alert ('clear basket '+id_user+':'+id_visor);
                        setCookie('material'+id_user+'_'+id_visor,'', -100,'/',window.is_session,false);
                    }
                    
                },
                error: function(response) { //Если ошибка
                    alert ('ERROR '+response);
                }
             });
    }
    function ControlAkt(type) {             //0-на сохранение 1-на подпись
       var noterr = true;
       var date = document.getElementById('date_hidden_table').value;
       var date0= document.getElementById('date_table');  //$_POST['date_akt'])
       if ( date==null) {                      //дата документа
           $(date0).addClass('error_formi');
           noterr = false;
       } else $(date0).removeClass('error_formi');

       var user= document.getElementById('ispol').value;  //Исполнитель
       var user0=document.getElementById('id1_user');
       if ( user==0) {
           $(user0).addClass('error_formi');
           noterr = false;
       } else $(user0).removeClass('error_formi');

       console.log ('date:'+date+' user:'+user);
       var cm=document.getElementById('count_mat').value;
       var tek;
       for (var i = 0; i < cm; i++) {

           if($('[name=count_'+i+']').length!=0) {
               //количество по позиции
               console.log(i + ' count=' + document.getElementsByName('count_' + i)[0].value);                 //$_POST['count_'.$p];
               tek = document.getElementsByName('count_' + i)[0];
               if (tek.value == 0) {
                   $(tek).addClass('error_formi');
                   if (type == 1) {
                       noterr = false;
                   }
               } else
                   $(tek).removeClass('error_formi');

           }
       }
       //alert ('return='+noterr);
       return noterr;
    }





