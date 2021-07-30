<?
$ini = get_cfg_var('cfg_file_path');
echo '<pre>ini: ', $ini, "\n";

foreach(file($ini) as $l) {
  if ( false!==strpos($l, '_exif') || false!==strpos($l, '_mbstring') ) {
    echo $l;
  }
}
echo '<pre>'; 



var_dump(gd_info());
?>