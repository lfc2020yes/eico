<script language="javascript" type="text/javascript" src="aktpp/cookie.js"></script>
<script language="javascript" type="text/javascript" src="aktpp/index_js_function.js"></script>

<script type="text/javascript">

$(document).ready(function(){

    console.log("document ready");

    var id_doc=getCookie('doc'+<?="'".$id_user."'"?>);
    if (id_doc == undefined) id_doc=0;
    Show_table(<?="'".$id_visor."'"?>,id_doc,<? echo($id_user); ?>);                              //Вывести таблицу закладки для просматриваемого пользователя


    $(document).on('change', "#zay" , function(){
        //alert ('zay');
        var id_user=$(this).attr("id_user");
        var id_doc=this.getElementsByTagName('input')[0].value;
        setCookie('doc'+id_user,id_doc,60,'/');
        var id_visor=getCookie('visor'+id_user);
        if (id_visor == undefined) id_visor=id_user;
        var id_uu=$('.users_rule').attr('ui');
        Show_table(id_visor,id_doc,id_uu);
        if (id_doc>0) {
            $(this).addClass('redass');  //error_formi
        } else {
            $(this).removeClass('redass');
        }
    });
    $(document).on('change', "#user_select" , function(){
        //$("#user_select").on("change",function(){                         //Смена ответственного
          var id_user=$(this).attr("id_user");
          //alert(id_user);
          //alert("id_visor="+this.getElementsByTagName('input')[0].value);
          var id_visor=this.getElementsByTagName('input')[0].value;
          setCookie('visor'+id_user,id_visor,60,'/');                         //Сохранить (переписать)
          //----------------------------------перевывести таблицу
          var id_doc=getCookie('doc'+id_user);
          if (id_doc == undefined) id_doc=0;

        var id_uu=$('.users_rule').attr('ui');
          Show_table(id_visor,id_doc,id_uu);
    });


function Show_table(id_visor,id_doc,id_uu) {   //показать таблицу закладки
    //alert (id_visor+' : '+id_doc);  //' : '+ sheet

    var showx='<>0';

    var cookie_flag_current = $.cookie('showx_'+id_uu);


    if(cookie_flag_current==1)
    {

        showx='IS NOT NULL';
    }



        jQuery.ajax({
                    url:     "/aktpp/ajax_table.php", //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных json html
                    data:  {
                        id_visor: id_visor,
                        sheet:  '<?=$_GET['by']?>',
                        id_akt: '<?=$_GET['id']?>',
                        n_st:'<?=$_GET['n_st']?>',
                        id_doc: id_doc,
                        showx:showx
                        },
                    success: function(response) { //Если все нормально
                //document.getElementById('akt'+id).innerHTML = "1";   //ok - галочка
                document.getElementById('page_aktpp').innerHTML=response;
                menu_anime();
                ToolTip();
                },
                error: function(response) { //Если ошибка
                   document.getElementById('page_aktpp').innerHTML = response;  //+response;  !-трудности
               alert (response);
                }
             });
}
//-----------------------------------------------------------------------------
   $(document).on('click', ".mat_div_x" , function(){
   //$(".mat_div").on("click",function(){  	//Отметить материал
       //console.log(".mat_div id: "+$(this).attr("id"));
       var id=$(this).attr("id");
       var id_user_visor=$(this).attr("id_usv");
       var cnt=0;
       var make_akt = document.getElementById('make_akt');

       //alert ("!");
       //var make_akt_i=$(make_akt).children('i')[0];
       //alert (make_akt_i);

       //if  ($(this).children('i')[0].textContent=='y') {

       if  ($(this).is('.active_yy')) {
            //$(this).children('i')[0].textContent='';
           $(this).removeClass('active_yy');
            cnt=DelFromCookie('material'+id_user_visor,id,60,'/',window.is_session,false);
            if (cnt>0) {
              //$(make_akt).children('i')[0].textContent=cnt;

                $(make_akt).find('i').empty().append(cnt);
              make_akt.style.display = 'inline-block';
              //document.getElementById('make_akt').innerHTML=make+cnt+'</i>';
            } else {
             // $(make_akt).children('i')[0].textContent='';
                $(make_akt).find('i').empty();

                $(make_akt).find('i').empty();
              make_akt.style.display = 'none';
              //document.getElementById('make_akt').innerHTML='';
            }
        } else {
            //$(this).children('i')[0].textContent='y';
           $(this).addClass('active_yy');
            cnt=AddToCookie('material'+id_user_visor,id,60,'/',window.is_session,false);
           // $(make_akt).children('i')[0].textContent=cnt;
           $(make_akt).find('i').empty().append(cnt);
            //alert("!");
            make_akt.style.display = 'inline-block';
            //document.getElementById('make_akt').innerHTML=make+cnt+'</i>';
        }
    });

    $(document).on('click', ".plus_table" , function(){
    //$(".plus_table").on("click",function(){    //Раскрыть содержание акта
        var id = $(this).attr("id");

        console.log(id);
        /*
        var elements = $(this).children('i');   //getElementsByTagName
        console.log(elements);
        console.log(elements[0]);
        console.log(elements[0].textContent);
        */
        var id_mat='mat'+id;
        var display = document.getElementById(id_mat).style.display;
        if (display=='none') {
            document.getElementById(id_mat).style.display = 'table-row';
            //$(this).children('i')[0].textContent='-';

            $(this).find('i').empty().append('-');
        } else {
            document.getElementById(id_mat).style.display = 'none';
            //$(this).children('i')[0].textContent='+';

            $(this).find('i').empty().append('+');
        }
    });

    $(document).on('click', ".del_akt" , function(){  //Удалить акт
       console.log(".del_akt id: "+$(this).attr("id_rel"));
       var id=$(this).attr("id_rel");
       //--------------------------------выбросить окно подтверждения
       if(confirm('Удалить акт?')) {
       //--------------------------------удалить акт
            AjaxDelete(id);
       }
    });

    $(document).on('click', ".accept" , function(){
    //$(".accept").on("click",function(){  	//принять документ (подписать и провести
       //console.log(".accept id: "+$(this).attr("id_rel"));
       var id=$(this).attr("id_rel");
       if (document.getElementById('akt'+id).textContent=='S') {
           AjaxAccept(id);

       }
    });
//-----------------------------------------------------------------------------
  console.log("document ready end");
  });

</script>
