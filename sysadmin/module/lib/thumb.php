<html xmlns="http://www.w3.org/1999/xhtml">
<?php

// creates an image thumbnail, fitting to specified dimensions

function create_thumbnail($srcpath, $destpath, $maxw = false, $maxh = false, $quality = false)
{
	if (!($size = @getimagesize($srcpath)))
	{
		return false;
	}
	list ($oldw, $oldh, $type) = $size;
	$funcs = array(1 => 'imagecreatefromgif', 'imagecreatefromjpeg', 'imagecreatefrompng');
	if ($type <= 0 OR $type > 3 OR !($src = $funcs[$type]($srcpath)))
	{
		return false;
	}
	$k = max($maxw / $oldw, $maxh / $oldh);
	if ($k > 1)
	{
		$k = 1;
	}
	$realw = $maxw / $k;
	$realh = $maxh / $k;
	$x0 = intval(($oldw - $realw) / 2);
	$y0 = intval(($oldh - $realh) / 2);

	$dest = imagecreatetruecolor($maxw, $maxh);
	imagecopyresampled($dest, $src, 0, 0, $x0, $y0, $maxw, $maxh, $realw, $realh);
	imagejpeg($dest, $destpath, $quality);
	imagedestroy($src);
	imagedestroy($dest);
	@chmod($destpath, 0755);
	return true;
}
// creates an image thumbnail, fitting to specified dimensions
?>
</html>
