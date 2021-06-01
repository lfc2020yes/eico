
function menu_anime() {
       var tabs = $('#tabs2017');
       tabs.on('click', '.tab', function(e){
           $(this).children('a')[0].click();

       });
       tabs_activation(tabs);
}

function tabs_activation(tabs) {
  tabs.find(".slider").css({left: tabs.find('li.active').position().left + "px",width: tabs.find('li.active').width()+"px"});
}


function AjaxDelete(id) {   //
    jQuery.ajax({
                    url:     "/aktpp/ajax_delete_akt.php", //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных json html
                data:  {
                        id: id
                },
                success: function(response) { //Если все нормально
                //alert (response);
                if (response!="") {   //Ошибка удаления
                    document.getElementById('akt'+id).innerHTML = "%";
                } else {
                //Удалить со страницы запись об акте
                document.getElementById('row_'+id).style.display = 'none';
                document.getElementById('mat'+id).style.display = 'none';
                }
                    
                },
                error: function(response) { //Если ошибка
                  // document.getElementById('row_'+id).innerHTML = "%";  //+response;  !-трудности
                alert ('ERROR '+response);

                }
             });
}

function AjaxAccept(id) {   //Подтверждение загрузки в базу
    console.log ('AjaxAccept:'+id);
    jQuery.ajax(
    {
                    url:     "/aktpp/ajax_accept_akt.php", //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных json html
                    data:  {
                        id: id
                        },
                    success: function(response) { //Если все нормально
                if (response!=="") {
                    document.getElementById('akt'+id).innerHTML = "%";  //+response;  !-трудности
                    alert (response);
                } else {
                    //document.getElementById('akt'+id).style.display = 'none';
                document.getElementById('div'+id).innerHTML=
                '<a target="_blank" class="font-rank22" data-tooltip="Принят" >'
                +'<span id="akt'+id+'" class="font-rank-inner">1</span></a>';
                location.href = 'aktpp/akt/';
               }
                },
                error: function(response) { //Если ошибка
                   document.getElementById('akt'+id).innerHTML = "%";  //+response;  !-трудности
               alert (response);
              //document.getElementById('akt'+id).style.display = 'none';
                }
    });
}