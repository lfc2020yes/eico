Как настроить Ckeditor 4 под свои нужды
Копируем плагин в папку PLUGIN/ckeditor4/


//запускаем файл samples/index.html до изменения всех файлов и в нем устанавливаем панель которую хотим видеть. ненужные иконки удаляем
//Изменяем там файл config.js. Заменяем на существующий
//Копируем в папку PLUGIN необходимые дополнительные плагины ulmenu_one,autogrow,SimpleLink
//Копируем файл skins/kama/
//изменяем файл styles.js в корни плагина который выводит чекбокс необходимых стилей для проекта
//если стили не обновляются. закомментите все настройки config.js перезагрузите редактор а потом снова откройте настройки.
//чтобы все изменения вступили в силу запускаем файл samples/index.html
//не забываем про свой файл стилей чтобы пользователь видел в редакторе такой же стиль как и потом на сайте
//копируем файл в корень сайта ckeditor_ulmenu.css и указываем путь к нему в файле config.js


//Установка в php 
<script src="/PLUGIN/ckeditor4/ckeditor.js" type="text/javascript"></script>


<textarea cols="60" name="order" id="editor_kama"></textarea>
<script type="text/javascript">
var ckeditor = CKEDITOR.replace('editor_kama');
</script>>