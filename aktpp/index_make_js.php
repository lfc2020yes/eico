<script language="javascript" type="text/javascript" src="aktpp/cookie.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
    console.log("document ready - "+window.location.pathname);
    ControlAkt(1);

    var show_save=<?=$show_save?>;
    if (show_save>0) {
        $('.save_akt').show();
    } else {   // Может высветить кнопку Отправить
        Send_akt_control();
    }

    var clear_cookie=<?=$clear_cookie?>;
    if (clear_cookie>0) {
        var id_user= <?=$id_user?>;
        var id_visor=<?=$id_visor?>;
        setCookie('material'+id_user+'_'+id_visor,'', -100,'/');
    }
    function Send_akt_control() {    //Отображение кнопки "ОТПРАВИТЬ"
        var control=<?=$control?>;
        if (control>0) {
            $('.send_akt').show();
        }
    }
    //-----------------------------------------------------------
    $(document).on('click', ".send_akt" , function(){   //Отправить акт на подпись

        var id=<?=$id_edit?>;
                //alert('click '+id);
        if (ControlAkt(1)==false) {               //Контроль на отправку
            $('.error_text_add').show();
            setTimeout ( function () {
                $('.error_text_add').hide();
            }, 7000 );
        } else{
            AjaxSendAkt(id);
            $('.send_akt').hide();
        }
    });

    $(document).on('click', ".save_akt" , function(){
        //alert('click');
        if (ControlAkt(0)==false) {               //Контроль на сохранение
                //  var err=<?php echo json_encode($stack_error) ?>;
                // if (err!=null) {
            //if (err.length>0) {
                $('.error_text_add').show();
                //$('.error_text_add').empty().append('Не все поля заполнены для сохранения');
                //setTimeout ( function () { $('.error_text_add').empty(); }, 7000 );
                setTimeout ( function () {
                    $('.error_text_add').hide();
                }, 7000 );
            //}

        } else{
            //alert ('submit');
            var revers =<?php echo json_encode($revers)?>;
            console.log('$revers='+revers) ;
            if (!revers) {
                //AjaxSaveAkt($(this).attr("id_rel"),<?=$id_user?>);   //////////
                $('#aktpp_make_form').submit();
            } else {
                        var href = window.location.href;
                        href = href.replace('revers/','');
                        console.log('push save='+href) ;
                        window.history.pushState({}, null, href);
            }
            //$('.save_akt').hide();
            // Send_akt_control();
            //$('.send_akt').hide()
        }

    });
    $(document).on('click', ".del_mat" , function(){  //Удалить материал
       console.log(".del_mat id: "+$(this).attr("id_rel"));
       var id=$(this).attr("id_rel");
       //--------------------------------выбросить окно подтверждения
       if(confirm('Удалить материал из акта?')) {
       //--------------------------------удалить акт
            AjaxDeleteMat(id);
       }
    });
    $(document).on('click', ".div_delete" , function(){  //Удалить материал
       console.log(".key_delete id: "+$(this).attr("id_rel"));
       var id_rel=$(this).attr("id_rel");
       var id=$(this).attr("id");
       
       //--------------------------------выбросить окно подтверждения
       if(confirm('Удалить '+id_rel+'?')) {
       //--------------------------------удалить акт
            AjaxDeleteAkt(id);
            
       }
    });
});  

</script> 
