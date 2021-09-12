$(document).ready(function() {


//загрузка файлов
    $('body').on("click", '.js-upload-file', UploadInvoice);

    $('body').on("dragover dragleave", '.js-upload-file', FileDragHover);

    $('body').on("drop", '.js-upload-file', FileSelectHandler);

//после выбора файла и нажатие кнопки ок
    $('body').on("change", '.js-file-load', UploadScanSChange);
//удалить загруженный файл
    $('body').on("change keyup input click", '.js-image-gl .js-dell-image', DellImageBlock);

//расставить номера для блоков с загрузкой файлов
    NumberBlockFile();

});


// Файл над нужной областью
function FileDragHover(e){
    e.stopPropagation();
    e.preventDefault();
    $(this).parents('.js-image-gl').addClass('draghover');
}

function FileSelectHandler(e)
{
    FileDragHover(e);


    if (typeof(window.FileReader) == 'undefined') {

        alert_message('error','Перетаскивание не поддерживается браузером');
    }

    // проходимся по объекту FileList
    var file = e.originalEvent.dataTransfer.files;

    // парсим все объекты типа File
    for (var i = 0, f; f = file[i]; i++){
        //ParseFile(f);
        var id_block=$(this).attr('type_block');   //номер блока в форме
        var id_type=$(this).attr('type_load');     //тип загрузки 1- сертификаты  2- сро и так далее
        var id_object=$(this).attr('id_object');

        var formaa=$('[name=myfile]').parents('form');
        formaa.attr('type_load',id_type);
        formaa.attr('type_block',id_block);
        formaa.attr('id_object',id_object);


        var type=id_type;
        var number_block=id_block;

        var id_object=id_object;

        var gll=$('div[type_block="'+number_block+'"]').parents('.js-image-gl');

        //определяем сколько их уже картинок в списке
        var number_li = (gll.find('.li-image').length+1);

        //file = this.files[0];
        if (f) {
            var size_blu='';
            if(gll.find('.list-image-icons').length!=0)
            {
                size_blu='<span class="type-img"></span>';
            }


            gll.find('.list-image').append('<div number_li="'+number_li+'" class="li-image"><span class="name-img"><a>'+f.name+'</a></span>'+size_blu+'<span class="del-img js-dell-image"></span><span class="size-img">'+(f.size / 1024 / 1024).toFixed(2)+' МБ</span><div class="progress-img"><div class="p-img" style="width: 0%;"></div></div></div>');

            gll.find('.list-image').show();

            gll.find('.js-upload-file').hide().addClass('eshe-load-file');  //спрять кнопку выбрать файл пока грузится

            //показываем загрузчик для этой картинки
            gll.find('[number_li='+number_li+'] .p-img').show();


            uploadS(f,type,id_object,number_li,number_block);
        }
        return false;

    }
}
function ParseFile(file) {
    alert(
        "<p>File information: <strong>" + file.name +
        "</strong> type: <strong>" + file.type +
        "</strong> size: <strong>" + file.size +
        "</strong> bytes</p>"
    );
}


//загрузка файлов -	нажатие на кнопку выбрать файл
//  |
// \/
var UploadInvoice = function()
{
    var id_block=$(this).attr('type_block');   //номер блока в форме
    var id_type=$(this).attr('type_load');     //тип загрузки 1- сертификаты  2- сро и так далее
    var id_object=$(this).attr('id_object');

    var formaa=$('[name=myfile]').parents('form');
    formaa.attr('type_load',id_type);
    formaa.attr('type_block',id_block);
    formaa.attr('id_object',id_object);

    $('[name=myfile]').trigger('click');
}

//расставить номера для блоков с загрузкой файлов
//  |
// \/
function NumberBlockFile() {
    //alert("!");
//расставляется только при загрузке. в процессе нельзя менять номера так как в это время может грузится файл с этим номером блока
    var number_file=1;
    $('.js-upload-file').each(function (i, elem) {
        $(this).attr('type_block',number_file);
        number_file++;
    });


    //для отправки файлов нужна пустая форма с input=file если нет создаем ее
    //alert($('.form_up').length);
    if($('.form_up').length==0)
    {

        $('body').append('<form class="form_up"><input class="js-file-load" type="file" name="myfile"></form>');
    }



}






//загрузка файлов -	после выбора файла начало загрузки
//  |
// \/
var UploadScanSChange = function()
{
    var type=$(this).parents('form').attr('type_load');
    var number_block=$(this).parents('form').attr('type_block');

    var id_object=$(this).parents('form').attr('id_object');


    //alert(id_object);
    var gll=$('div[type_block="'+number_block+'"]').parents('.js-image-gl');

    //определяем сколько их уже картинок в списке
    var number_li = (gll.find('.li-image').length+1);

    file = this.files[0];
    if (file) {
var size_blu='';
       if(gll.find('.list-image-icons').length!=0)
       {
           size_blu='<span class="type-img"></span>';
       }


        gll.find('.list-image').append('<div number_li="'+number_li+'" class="li-image"><span class="name-img"><a>'+this.files[0].name+'</a></span>'+size_blu+'<span class="del-img js-dell-image"></span><span class="size-img">'+(this.files[0].size / 1024 / 1024).toFixed(2)+' МБ</span><div class="progress-img"><div class="p-img" style="width: 0%;"></div></div></div>');

        gll.find('.list-image').show();

        gll.find('.js-upload-file').hide().addClass('eshe-load-file');  //спрять кнопку выбрать файл пока грузится

        //показываем загрузчик для этой картинки
        gll.find('[number_li='+number_li+'] .p-img').show();


        uploadS(file,type,id_object,number_li,number_block);
    }
    return false;
}

//загрузка файлов -	удалить загруженный файл крестик
//  |
// \/
function DellImageBlock()
{
    var li=$(this).parents('.li-image');
    var list=$(this).parents('.list-image');
    DellFile($(this).attr('id'));
    //удалить название файла из input
    $(this).parents('.js-image-gl').find('input').val(DellValString('dell',',',$(this).parents('.js-image-gl').find('input').val(),$(this).attr('id')));


    li.slideUp("slow", function () {
        $(this).remove();
        if (list.find('.li-image').length == 0) {
            list.slideUp("slow");
            list.parents('.js-image-gl').find('.js-upload-file').removeClass('eshe-load-file');
        }

        var number_li = 1;
        list.find('.li-image').each(function (i, elem) {

            $(this).attr('number_li', number_li);
            number_li++;

        });


    });





}

//загрузка файлов -	процесс загрузки файла на сервер
//  |
// \/
function uploadS(file,type,id_object,number_li,number_block) {
    var gll=$('div[type_block='+number_block+']').parents('.js-image-gl');
    var xhr = new XMLHttpRequest();

    // обработчики можно объединить в один,
    // если status == 200, то это успех, иначе ошибка
    xhr.onload = xhr.onerror = function() {
        //alert(this.status);
        if (this.status == 200) {


            gll.find('.js-upload-file').show();
            gll.find('[number_li='+number_li+'] .p-img').width(0).hide();
            gll.find('[number_li='+number_li+']').addClass('yes-load');
//alert("!!!");
            alert_message('ok','Файл загружен');
            //осталось добавить в input загруженный id файла


            var r=JSON.parse(this.responseText);
            //alert_message('ok',r.type);
            gll.find('[number_li='+number_li+'] .del-img').attr('id',r.echo);

            if(gll.find('[number_li='+number_li+'] .type-img').length!=0)
            {
                gll.find('[number_li='+number_li+'] .type-img').empty().append(r.type);
            }

            gll.find('[number_li='+number_li+'] .name-img a').attr('href',r.link);

            name_sql_image=r.echo;  //id фотки которую загрузили

            var inpu=gll.find('input');
            //alert(inpu.val());
            if(inpu.val()=='')
            {
                inpu.val(name_sql_image);
            } else
            {
                inpu.val(inpu.val()+','+name_sql_image);
            }


            //UpdateImageSupply(id);
        }
        else {
            gll.find('.js-upload-file').show();
            gll.find('[number_li='+number_li+'] .p-img').width(0).hide();
            gll.find('[number_li='+number_li+']').addClass('no-load');
            alert_message('error','Файл не загружен. Неверный формат');
            setTimeout(function () {
                gll.find('[number_li=' + number_li + ']').slideUp("slow", function () {
                    var list=$(this).parents('.list-image');
                    $(this).remove();



                    if (list.find('.li-image').length == 0) {
                        list.slideUp("slow");
                        gll.find('.js-upload-file').removeClass('eshe-load-file');
                    }
                });
            }, 3000);
        }
    };

    // обработчик для закачки
    xhr.upload.onprogress = function(event) {
        var widths=Math.round((event.loaded*100)/event.total);
        gll.find('[number_li='+number_li+'] .p-img').width(widths);
    }

    xhr.open("POST", "Ajax/file/upload.php", true);
    //xhr.send(file);

    var formData = new FormData();
    formData.append("thefile", file);
    formData.append("type",type);
    formData.append("object",id_object);
    xhr.send(formData);

}

//удалить файл на сервере
//  |
// \/
function DellFile(id)
{
    if(id!='')
    {
        var data ='id='+id;

        AjaxClient('file','dell','GET',data,'AfterZero',0,0);
    }
}
//постфункция пустышка
//  |
// \/
function AfterZero(data,update){}
//добавление и удаление из строки значение с определенным разделителем
//  |
// \/
//DellValString('dell',',','2,5,8',5) - >  получим строку 2,8
function DellValString(command,separator,string,val)
{
//dell - add
    var text = '';
    if (command == 'dell') {

        var cc = string.split(separator);
        var lp = 0;
        for (var t = 0; t < cc.length; t++) {
            if (cc[t] != val) {
                if (cc[t] != '') {
                    if (lp == 0) {
                        text = cc[t];
                    } else {
                        text = text + separator + cc[t];
                    }
                    lp++;
                }
            }
        }


    } else {
        //добавление
        if (jQuery.trim(string) != '') {
            text = string + separator + val;
        } else {
            text = val;
        }


    }
    return text;
}
