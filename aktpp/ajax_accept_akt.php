<?php
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header('Content-type: text/html; charset=utf-8');

$id_act=htmlspecialchars(trim($_POST["id"]));
//echo '<p>id_act='.$id_act;
//echo '<p>id_user='.$id_user;
$AAkt = new accept_akt(&$link,$id_user);
$AAkt->update($id_act);

class accept_akt {
var $link;
var $id_user;
var $id_act;

function __construct(&$link,$id_user){
    $this->link=$link;
    $this->id_user=$id_user;
}

function update($id_act){
$this->id_act=$id_act;

//получить z_act_material
  //если количество по id_stock_material ==count_units
                        //да  update z_stock_material по id_user
                        //нет update z_stock_material по остатку
                        //    insert z_stock_material на id_user по  count_units
//update  z_act date1
$sql_akt='select * from z_act where id="'.$this->id_act.'"';
$res_a=mysql_time_query($this->link,$sql_akt);
if($res_a->num_rows>0) {
    $row_a = mysqli_fetch_assoc($res_a);

    $COMA=''; $sql='';
    $sql_mat="
select a.*,a.count_units as count_units_akt,m.*,m.id as idsm
from
z_act_material a left join z_stock_material m on (a.id_stock_material=m.id)
where id_act='$this->id_act'
    ";
    //получить z_act_material z_stock_material
    $res_0=mysql_time_query($this->link,$sql_mat);
    if($res_0->num_rows>0) {
        $transaction=true;
        for ($i=0;$i<$res_0->num_rows;$i++) {
            $row_0 = mysqli_fetch_assoc($res_0);

//здесь

            if ($row_0['id_stock_material'] <> null) {
               //если количество по id_stock_material ==count_units
               if ($row_0['count_units_akt']==$row_0['count_units']) {     //все передается
                   $sql.= $COMA.'update z_stock_material set id_user="'.$this->id_user.'", date_res="'.$row_a['date'].'" where id="'.$row_0['idsm'].'"';
                   $COMA=';';
               } elseif ($row_0['count_units_akt']<$row_0['count_units']) { //передача делиться на части
                   $sql.= $COMA.'update z_stock_material set count_units="'.($row_0['count_units']-$row_0['count_units_akt']).'" where id="'.$row_0['idsm'].'"';
                   $COMA=';';
                   $sql.= $COMA.'
insert into z_stock_material
set
id_stock="'.$row_0['id_stock'].'",
date_res="'.$row_a['date'].'",
count_units="'.$row_0['count_units_akt'].'",
price="'.$row_0['price'].'",
id_user="'.$this->id_user.'"';
               } else { 
                    echo " передается больше чем на складе ".$row_0['count_units_akt']." : ".$row_0['count_units']; 
                    $transaction=false;
                    break;
               }  //Ошибка передается больше чем на складе
               //---------------------------------------------------------------СТАТУС ПО ЗАЯВКЕ
               if ($row_a['id_doc']>0 && $row_0['count_units_akt']>0) {    // Есть заявка и есть смысл
                   if (($sql_doc=$this->Set_Status_Doc(&$row_a,&$row_0))!==false) $sql.= $COMA.$sql_doc;;
               }
            } else { 
                echo " материал не привязан к складу ...."; 
                $transaction=false;
                break;
            } //Material не привязан к складу - это приход !!!
        }  //for
       
        if ($transaction) {
            $sql.= $COMA.'update z_act set id1_user="'.$this->id_user.'", date1=now() where id="'.$this->id_act.'"';
            //открыть транзакцию
            //echo "<p/>".$sql;
            $transaction=Nariad_transaction(&$this->link,&$sql,false);   
        }
        if ($transaction){
            $note='материальные ценности по Акту приема-передачи № ';
            $note0=$row_a['number'].' от '.$row_a['date'];
            $arr_user=array();
            if ($row['id0_user']<>$this->id_user) $arr_user[]=$row_a['id0_user'];
            if ($row['id_user']<>$this->id_user) $arr_user[]=$row_a['id_user'];

            notification_send('<strong>Получены</strong> '.$note.' <a href="aktpp/print/'.$this->id_act.'/">'.$note0.'</a>',  $arr_user, $this->id_user,$this->link);


            //пишем уведомление админу что новая заявка создана и отправлена на согласование
            //пишем уведомление админу что новая заявка создана и отправлена на согласование
            $user_admin= array();
            array_push($user_admin, 11);

            $title='Получены материальные ценности по Акту приема-передачи №'.$row_a['number'];
            $kto=name_sql_x($this->id_user);
            $message=$kto.' получил материальные ценности по Акту приема-передачи - <a href="aktpp/print/'.$this->id_act.'/">№'.$note0.'</a>';
            notification_send_admin($title,$message,$user_admin,$id_user,$this->link);

            //пишем уведомление админу что новая заявка создана и отправлена на согласование
            //пишем уведомление админу что новая заявка создана и отправлена на согласование


        }
        if ($transaction && $row_a['id_doc']>0) {            //Поправить общий статус заявки
            if(($ret=$this->Update_Doc_status($row_a['id_doc'],10))!==true) {
                echo "Ошибка изменения статуса заявки №".$row_a['number']." от ".$row_a['date'].": $ret";
            } 
        }
    }
    unset ($res_0);
} //akt
unset($res_a);
} //update

function Read_Doc_Material_Count($id_doc,$id_stock) {  //Кол-во материала по заявке
  $count=false;  
  $sql="
select sum(count_units) as count_units 
from 
z_doc_material 
where 
id_doc='$id_doc' and id_stock='$id_stock'      
  ";
  $result=$this->link->query($sql);
  //echo "<p/>step2=".$sql.'='.$result->num_rows;
  if($result->num_rows>0) {
     $row = $result->fetch_assoc(); 
     $count=$row['count_units'];
     if (is_null($count))$count=false; 
  }
  return $count;
}
function Read_Act_Material_Count($id_act,$id_stock) {  //Кол-во материала по заявке
  $count=0;  
  $sql="
select sum(count_units) as count_units 
from 
z_act_material 
where 
id_act='$id_act' and id_stock='$id_stock'      
  ";
  $result=$this->link->query($sql);
  //echo "<p/>step0=".$sql.'='.$result->num_rows;
  if($result->num_rows>0) {
     $row = $result->fetch_assoc(); 
     $count=$row['count_units'];
     if (is_null($count))$count=0; 
  }
  return $count;
}
function Read_Act_Material_Before_Count(&$row_a,&$row_0) {  //Кол-во материала по уже сделанным заявкам
  $count=0;  
  $sql='
select IFNULL(sum(m.count_units),0) as cnt from z_act_material m, z_act a 
where 
m.id_stock="'.$row_0['id_stock'].'" 
and a.id_doc="'.$row_a['id_doc'].'"  
and m.id_act=a.id 
and a.date1 is not null and a.id1_user is not null 
and m.id_act<>"'.$row_a['id'].'"             
';
  $result=$this->link->query($sql);
  //echo "<p/>step3=".$sql.'='.$result->num_rows;
  if($result->num_rows>0) {
     $row = $result->fetch_assoc(); 
     $count=$row['cnt'];
  }
  return $count;
}

//подтвердить получение материалов по заякам
function Set_Status_Doc(&$row_a,&$row_0) {
    //echo "<p/>step1 id_doc=".$row_a['id_doc']." id_stock=".$row_0['id_stock'];
    $sql_result=false;
    if (($count_doc=$this->Read_Doc_Material_Count($row_a['id_doc'],$row_0['id_stock']))!==false) {    //Кол-во нужного материала по заявке
        // по текущей заявке, проведенные, исключая наш акт(он не проведенный)
        $count_before = $this->Read_Act_Material_Before_Count(&$row_a,&$row_0);
        $count_act    = $this->Read_Act_Material_Count($row_a['id'],$row_0['id_stock']);
        //$count_doc - количество материала по заявке
        //$count_before  - количество принятых материалов по другим актам по этой заявке  - не $row['cnt']
        //$count_act  - количество принимаемых материалов по акту  - не $row_0['count_units_akt'] если несколько позиций
        //echo '<p/>step4 $count_doc='.$count_doc.' $count_before='.$count_before.' $count_act='.$count_act;
        $status = ($count_doc>$count_before+$count_act)?15:10;  //Не вся заявка погашена //погашение заявки
        $sql_result="
update z_doc_material 
set count_units_act='".($count_before+$count_act)."', status='$status'
where id_doc='".$row_a['id_doc']."' and id_stock='".$row_0['id_stock']."'";
    }
    return $sql_result;
}   

function Update_Doc_status($id_doc,$status) {   //Переписать статус если все его материалы status=10
    $ret=true;
    $sql="select id from z_doc_material where id_doc='$id_doc' and status<>'$status'"; 
    $result=mysql_time_query($this->link,$sql);
    //echo "<p/>step8=".$sql.'='.$result->num_rows;
    if($result->num_rows==0) {        //перенести статус на заявку
        $usql="update z_doc set status='$status' where id='$id_doc'";
        //echo "<p/>step8=".$usql.'='.$result->num_rows;
    
        if (($ret=$this->link->query($usql))!==true) {
            $ret=$this->link->errno;
        }  
    }
    return $ret;
}
/*
} //id_user>0
} //id_user session


function GetBaseUser($link){
   $id_user==0;
   $sql='select @id_user as id';
   $res=mysql_time_query($link,$sql);
   if($res->num_rows>0) {
      $row = mysqli_fetch_assoc($res);
      $id_user=$row['id'];
   }
   return $id_user;
}
 */ 

/*        
        $row_a['id_doc'] -- заявка
              $row_0['count_units_akt'] - кол-во материала по акту
        z_doc_material -- материалы id_stock 
                                    count_units  - кол-во материала по заявке
                                    status  
// Выбор уже проведенных по этой заявке
select sum(m.count_units) from z_act_material m, z_act a 
where 
m.id_stock=499 
and a.id_doc=53  -- по заявке
and m.id_act=a.id 
and a.date1 is not null and a.id1_user is not null -- проведенные
and m.id_act<>51 -- исключить наш акт
*/    

}