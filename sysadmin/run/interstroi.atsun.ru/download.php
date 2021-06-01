<?php
$url=$_SERVER["DOCUMENT_ROOT"].'/for_load_excel/make/';
$filename = $url.$_POST['file'];
//if (rename($url.'test.xlsx',$filename)===true) {

$mm_type="application/octet-stream";

header("Cache-Control: public, must-revalidate"); // кешировать
header("Pragma: hack");


header('Content-Disposition: attachment; filename="'.$filename.'"');
header("Content-Description: File Transfer");
header("Content-Length: " .(string)(filesize($filename)) );
//header('Content-Type: application/x-force-download; name="'.$_POST['file'].'"');
header('Content-Type: '.$mm_type.'; name="'.$_POST['file'].'"');
//header('Content-type: text/html; charset=utf-8');
header("Content-Transfer-Encoding: binary");
//echo '<p/>$filename='.$filename;

readfile($filename);

/*
set_time_limit(300);
$handle = fopen($filename, "rb");
if (FALSE === $handle) {
    exit("Failed to open stream to URL");
}

while (!feof($handle)) {
    echo fread($handle, 1024*1024*10);
    sleep(3);
}

fclose($handle);
*/
