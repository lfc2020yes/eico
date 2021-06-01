<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>тест</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />

</head>
<body>

 <?

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     echo '<h1>Привет, <b>' . $_POST['doo'] . '</b></h1>!';
   }


 echo var_dump($_POST);             //   =$_SERVER['PHP_SELF'] $_SERVER['HTTP_HOST']    "http://www.sysmaster.rr/"   <base href="/"/>
?>
<form  action="/sysadmin/test/index.php"  method="post" enctype="multipart/form-data">
 <input type="hidden" name="doo" value="sy!ys" />
 <input type="submit" value="послать" name="edt1"/>

</form>
</body>
</html>
