<html xmlns="http://www.w3.org/1999/xhtml">
<?php

class TRight
 {
//----------------------массивы для заполнения
  var  $P =array();         //параграфф
  var  $R =array();         //права
}

/*
  $PERMISSION = new  TRight;
  get_permission($user, &$PERMISSION);         //права
  $ROW_role=get_role($user);                   //Роль
*/

function  get_permission($user, &$PERMISSION)
{
  $sql_R=new Tsql("select * from admin u, _RIGHT r
                   where user='$user' and u.id=r.id_user order by r.PARAGRAF DESC");
  //echo "\n".'sql_R='.$sql_R->num.'='.$sql_R->sql;
  for($k=0; $k<$sql_R->num; $k++)
  {
    $sql_R->NEXT();
    $PERMISSION->P[]=$sql_R->row["PARAGRAF"];      //параграф
    $PERMISSION->R[]=$sql_R->row["permissions"];   //права
//    echo '<p>'.$PERMISSION->P[$k].'->'.$PERMISSION->R[$k].'</p>';    ///
  }
}

//Поиск прав на параграф их массива (массив отсортирован по убыванию)
function find_permission(&$PERMISSION,$PARAGRAF)
{
    $FP='';
    for($i=0; $i<count($PERMISSION->P); $i++)
    {
	  //echo '<p>'.$i.'/'.count($PERMISSION->P).':'.$PERMISSION->P[$i].' in '.$PARAGRAF.'</p>';    ///
      $offset=strpos($PARAGRAF,$PERMISSION->P[$i]);  
      if (!(($offset===false) or ($offset>0))) {      
      //if (strpos( $PARAGRAF,$PERMISSION->P[$i])!==false)       //Есть вхождение
        $FP=$PERMISSION->R[$i];
        break;
      }
    }
    return $FP;
}
//                   'R w adm'  'r'
function if_permission($permission,$RiGHT)
{  $IP=false;
   if (strpos( strtolower($permission),$RiGHT)!==false)
       $IP=true;
   return $IP;
}

function  get_role($user)
{
  $ROW_role=0;
  $sql_R=new Tsql("select * from admin u, _ROLE r
                   where user='$user' and u.id=r.id_user");
  //echo "\n".'sql_R='.$sql_R->num.'='.$sql_R->sql;   //
  if ($sql_R->num>0)
  { $sql_R->NEXT();
    $ROW_role=$sql_R->row;
  }
  return($ROW_role);
}

function  if_role_admin(&$ROW_role)
{
  $IRA=false;
  if ($ROW_role['role']=='admin') $IRA=true;
  return $IRA;
}

?>
</html>