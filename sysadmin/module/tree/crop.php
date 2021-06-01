<?
//Двойной POST

$miniatura_w=165;
$miniatura_h=130;


//первый шаг
if(($_POST["photo"]=='yes')and(isset($_POST["photo"])))
{

   //просто копируем фото. переименовавываем имя
   copy($_FILES["uploadfile"]["tmp_name"],"./img/photo/1.jpg");

   //узнаем ее размеры. высоты и ширины
   $srcpath=$_FILES["uploadfile"]['tmp_name'];
   if (!($size = @getimagesize($srcpath))){ return false; }
   list ($oldw, $oldh, $type) = $size; $funcs = array(1 => 'imagecreatefromgif', 'imagecreatefromjpeg', 'imagecreatefrompng');
   if ($type <= 0 OR $type > 3 OR !($src = $funcs[$type]($srcpath))) { return false; }

}


//второй шаг, где обрезаем по выбранным размерам
if(($_POST["photo"]=='yes1')and(isset($_POST["photo"])))
{
	/*
	мы получили координаты с формы
	$_POST["x"] $_POST["y"] $_POST["w"] $_POST["h"]
	*/
	$src = 'img/photo/1.jpg';
	$thumbpath = $_SERVER["DOCUMENT_ROOT"]."/img/photo/165x130.jpg";
	$jpeg_quality=100;
	$img_r = imagecreatefromjpeg($src);
    $dst_r = ImageCreateTrueColor( $miniatura_w, $miniatura_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$miniatura_w,$miniatura_h,$_POST['w'],$_POST['h']);

	imagejpeg($dst_r, $thumbpath, $jpeg_quality);
	imagedestroy($img_r);
	@chmod($thumbpath, 0755);

}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Пример резки фото.</title>
<base href="http://www.load1.ru/"/>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

		<script src="Js/Jcrop/jquery.min.js"></script>
		<script src="Js/Jcrop/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="Js/Jcrop/jquery.Jcrop.css" type="text/css" />


<script language="Javascript">

			$(window).load(function(){

				var api = $.Jcrop('#cropbox',{
					setSelect: [ 0, 0, <? echo($miniatura_w) ?>, <? echo($miniatura_h) ?> ],
					aspectRatio: <? echo($miniatura_w/$miniatura_h) ?>,
					onChange: showPreview,
					onSelect: showPreview
				});
				       //       x1  y1   x2   y2
				var i, ac;


			});

			//функция которая будет выпалняться при любых изменениях выбранной области и подставлять в форму выбранные координаты чтобы потом эту форму на обрезку отправить
			function showPreview(coords)
			{

				$('#x_avatar').val(coords.x);
				$('#y_avatar').val(coords.y);
				$('#w_avatar').val(coords.w);
				$('#h_avatar').val(coords.h);


				if (parseInt(coords.w) > 0)
				{
					var rx = <? echo($miniatura_w) ?> / coords.w;
					var ry = <? echo($miniatura_h) ?> / coords.h;

					jQuery('#preview').css({
						width: Math.round(rx * <? echo($oldw) ?>) + 'px',
						height: Math.round(ry * <? echo($oldh) ?>) + 'px',
						marginLeft: '-' + Math.round(rx * coords.x) + 'px',
						marginTop: '-' + Math.round(ry * coords.y) + 'px'
					});



					//большие цифры это размеры большой картинки. ширина и высота
				}
			}


			//при отправки формы вызывает, по кнопки обрезать или отправить
			function checkCoords()
			{
				if (parseInt($('#w_avatar').val())) return true;
				alert('Пожалуйста выберите нужную область на изображении.');
				return false;
			};



		</script>


</head>

<body>
Задача простая. Обрезать фото и сделать 1 миниатюры 165x130! и положить это все в папку img/photo/. название файлов следующее<br>
165x130.jpg<br>
<br><br>
<?


if(($_POST["photo"]=='yes1')and(isset($_POST["photo"])))
{
  echo('<span style="color:blue">Миниатюра создана!</span><br><img src="/img/photo/165x130.jpg" />');
}


if(($_POST["photo"]=='yes')and(isset($_POST["photo"])))
{
//первый шаг

//выводим скопированное фото


//форму с координатами

echo'		<table>
		<tr>
		<td>
		<img src="/img/photo/1.jpg" id="cropbox" />
		</td>
		<td valign="bottom">
		<div style="width:'.$miniatura_w.'px;height:'.$miniatura_h.'px;overflow:hidden;">
			<img src="/img/photo/1.jpg" id="preview" />
		</div>

		</td>
		</tr>
		</table>';


echo'		<form action="/" method="post" onSubmit="return checkCoords();">
			<input type="hidden" id="x_avatar" name="x" />
			<input type="hidden" id="y_avatar" name="y" />
			<input type="hidden" id="w_avatar" name="w" />
			<input type="hidden" id="h_avatar" name="h" />
			<input type="hidden" name="photo" value="yes1">
			<input type="submit" value="Сохранить" />
            <input type="button" value="Отмена" />
		</form>';

}
if(!isset($_POST["photo"]))
{
?>
<form method="POST" action="/" enctype="multipart/form-data">
<input type="hidden" name="photo" value="yes">

<input name="uploadfile" type="file" size="28" />

<input type="submit" value="Загрузить">
</form>
<?
}
?>



</body>
</html>