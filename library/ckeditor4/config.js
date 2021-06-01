/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
//подключаем загрузчик изображений
   config.filebrowserImageBrowseUrl = 'PLUGIN/ckeditor4/kcfinder/browse.php?opener=ckeditor&type=images';
   config.filebrowserFlashBrowseUrl = 'PLUGIN/ckeditor4/kcfinder/browse.php?opener=ckeditor&type=flash';
   config.filebrowserUploadUrl = 'PLUGIN/ckeditor4/kcfinder/upload.php?opener=ckeditor&type=files';
   config.filebrowserImageUploadUrl = 'PLUGIN/ckeditor4/kcfinder/upload.php?opener=ckeditor&type=images';
   config.filebrowserFlashUploadUrl = 'PLUGIN/ckeditor4/kcfinder/upload.php?opener=ckeditor&type=flash'; '/uploader/upload.php';




	
//скин редактора
config.skin = 'kama';


//отключаем низ редактора
config.removePlugins = 'elementspath';
config.resize_enabled = false;


//плагин разтягивания поля вниз
config.extraPlugins = 'autogrow';



//делаем чтобы enter был не новый p а просто br
config.enterMode = CKEDITOR.ENTER_BR;
config.shiftEnterMode = CKEDITOR.ENTER_P;

//добавление ссылок
config.extraPlugins = 'SimpleLink';


//мой написанный плагин
config.extraPlugins = 'ulmenu_one,autogrow,SimpleLink,imageuploader';

config.allowedContent = true;


//отключаем кодирование ковычек
//config.entities = false;

//формат выводим только h3
config.format_tags = 'h3';


//подключение своих стилей
config.contentsCss = 'stylesheets/ckeditor/ckeditor_ulmenu.css';

//выравнивание с помощью тегов
config.justifyClasses = [ 'left_p', 'center_p', 'right_p', 'justify_p' ];
 
//НАСТРОЙКА ИКОНОК ПАНЕЛИ РЕДАКТИРОВАНИЯ
config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Copy,Cut,Paste,Replace,Find,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Strike,Subscript,Superscript,NumberedList,BulletedList,Outdent,Indent,CreateDiv,JustifyRight,JustifyBlock,BidiLtr,BidiRtl,Language,Anchor,Unlink,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Font,FontSize,TextColor,BGColor,About';

	



};


