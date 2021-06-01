/*

Мышка logitech 401
Память Radion 20010
Монитор Samsung l3000 - жидк
...
|
V
Раскрыть все скрыть если их больше какого то количества

*/
$(document).ready(function() {


//загрузка файлов
    $('body').on("click", '.js-more', JsMoreB);
//после выбора файла и нажатие кнопки ок

});


//загрузка файлов -	удалить загруженный файл крестик
//  |
// \/
function JsMoreB()
{

    var mmor=$(this).parents('.js-more-block');

    if(mmor.is('.show-more-all'))
    {
        mmor.removeClass('show-more-all');
    } else
    {
        mmor.addClass('show-more-all');
    }




}
