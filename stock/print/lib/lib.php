<?php
function MONEY($data,$rasdl='-',$probel=' ') {
return number_format($data, 2, $rasdl, $probel);
}

/*  Читать cookie c именем
 *  $arr=ReadCookie('material'); 
 */
function ReadCookie($name) {
  $str=GetCookie($name);
  if ($str===false)
       $arr=explode(',','');
  else $arr=explode(',',$str);
  return $arr;
}
function GetCookie($name) {  //Читать кукие как строку
  $ret=false;
  if (array_key_exists($name, $_COOKIE)) {
      $ret=$_COOKIE[$name];
  } 
  return $ret;
}
/*  Найти значение в массиве (cookie)
 *  if (IsDataIn(&$arr,55) )
 */
function IsDataIn(&$arr,$item) {
    $res=false;
    for($k=0; $k<count($arr);$k++)  
    {   if ($arr[$k]==$item){
            $res=true;
            break;
        }    
    }
    return $res;
}
//------возвращает ===false или номер найденного значения
function IsDataNum(&$arr,$item) {
    $res=false;
    for($k=0; $k<count($arr);$k++)  
    {   if ($arr[$k]==$item){
            $res=$k;
            break;
        }    
    }
    return $res;
}

//($id_zay,"Заявки","z_invoice","id,number,date,summa",$link)
function get_box_data($id,$def,$table,$fields,$mysqli,$sql='') {
  $arr=explode(',',$fields);
  if ($sql=='')
      $sql="select $fields from $table where ".$arr[0]."='$id'";
  //echo "<p\>$sql";
  if ($result = $mysqli->query($sql)) {
            if($row = $result->fetch_assoc() ){
              $str=''; 
              for ($i=1;$i<count($arr);$i++) {  
                   $str.=$arr[$i++];
                   $str.=$row[$arr[$i++]];
                   $str.=$arr[$i]; 
              }
            } else $str=$def;
            $result->close();  
  } else $str=$def;
  return $str;
}
/*
//data_row($row_z,"id,number,date,summa")
function data_row($row,$fields) {
    $arr=explode(',',$fields);
    $str=''; $COMA='';
    for ($i=1;$i<count($arr);$i++) {  
                   $str.=$COMA.$row[$arr[$i]]; 
                   $COMA=' ';
    }
    return $str;
}
*/