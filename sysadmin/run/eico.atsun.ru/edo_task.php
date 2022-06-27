<?php

include_once '../ilib/lib_interstroi.php';
include_once '../ilib/lib_edo.php';
include_once '../ilib/Isql.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{
  
    
  $GT=array();
  GET_PARAM($GT,$PARAM);

    $status =  (isset($_POST["status"]))?$_POST["status"] : '=0';
    $action =  (isset($_POST["action"]))?$_POST["action"] : null;
    $type =  (isset($_POST["type"]))?$_POST["type"]:0;
    $id_user =  (isset($_POST["id_user"]))?$_POST["id_user"]:0;
    $id_doc =  (isset($_POST["id_doc"]))?$_POST["id_doc"] : null;
    $id_doc_ = ($id_doc=='null') ? null : $id_doc;

    $ids_town =  (isset($_POST["ids_town"]))?$_POST["ids_town"] : '';
    $ids_kvartal =  (isset($_POST["ids_kvartal"]))?$_POST["ids_kvartal"] : '';
    $ids_object =  (isset($_POST["ids_object"]))?$_POST["ids_object"] : '';
    $id_owner =  (isset($_POST["id_owner"]))?$_POST["id_owner"] : '';
    $dates = (isset($_POST[dates]))?$_POST[dates] : 0;   //2022-05-05/2022-06-15

    $number_doc =  (isset($_POST["number_doc"]))?$_POST["number_doc"] : '';
    $summa_work =  (isset($_POST["summa_work"]))?$_POST["summa_work"] : '';
    $id_implementer =  (isset($_POST["id_implementer"]))?$_POST["id_implementer"] : '';
    $comment =  (isset($_POST[comment]))?$_POST[comment] : '';

    if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          }
          else { $styleH=''; $styleF=''; }
//$mysqli
//$id_user
//$id_doc
//$type

/*
    статья [текст типо 1.2]
создатель [id одно]
объект [id,id,id]
квартал [id,id,id]
 город [id,id,id]
промежуток создания  0 или период  вида [2022-05-05/2022-06-15]
*/

  ?>        
  <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="edo" value="1"/>

  <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">            
  <caption <?=$styleH?>><div style="padding:3px;">ЗАДАЧИ МНЕ</div></caption>

      <tr><td style="padding-right: 10px">тип документа (0-doc 1-acc 2-nariad 3-договор 4-тендер):<td>
      <input class="text"  name="type" size="2" value="<?=$type?>" />

      <tr><td style="padding-right: 10px">status [=0 =1 >0 >1 =3...]:<td>
      <input class="text"  name="status" size="2" value="<?=$status?>" />

      <tr><td style="padding-right: 10px">action [0,1,2,6,9]:<td>
              <input class="text"  name="action" size="2" value="<?=$action?>" />

      <tr><td style="padding-right: 10px">id_user:<td>
      <input class="text"  name="id_user" size="2" value="<?=$id_user?>" />

      <tr><td style="padding-right: 10px">id_doc:<td>
              <input class="text"  name="id_doc" size="2" value="<?=$id_doc?>" />
      <tr><td style="padding-right: 10px">--дополнительные фильтры---------универсальные<td>
      <tr><td style="padding-right: 10px">Город ids_town:<td>
              <input class="text"  name="ids_town" size="2" value="<?=$ids_town?>" />
      <tr><td style="padding-right: 10px">Квартал ids_kvartal:<td>
              <input class="text"  name="ids_kvartal" size="2" value="<?=$ids_kvartal?>" />
      <tr><td style="padding-right: 10px">Объекты ids_object:<td>
              <input class="text"  name="ids_object" size="10" value="<?=$ids_object?>" />
      <tr><td style="padding-right: 10px">Создатель документа id_owner:<td>
              <input class="text"  name="id_owner" size="2" value="<?=$id_owner?>" />
      <tr><td style="padding-right: 10px">период 2022-05-05/2022-06-15 dates:<td>
              <input class="text"  name="dates" size="20" value="<?=$dates?>" />
      <tr><td style="padding-right: 10px">--дополнительные фильтры---------наряды<td>
      <tr><td style="padding-right: 10px">Номер документа number_doc:<td>
              <input class="text"  name="number_doc" size="2" value="<?=$number_doc?>" />
      <tr><td style="padding-right: 10px">Сумма документа <>= summa_work:<td>
              <input class="text"  name="summa_work" size="10" value="<?=$summa_work?>" />
      <tr><td style="padding-right: 10px">Производитель id_implementer:<td>
              <input class="text"  name="id_implementer" size="2" value="<?=$id_implementer?>" />
      <tr><td style="padding-right: 10px">Комментарий %% comment:<td>
              <input class="text"  name="comment" size="20" value="<?=$comment?>" />
<?php
   SHOW_tfoot(4,1,1,1);

//==============================================================================
  if ($_POST["edo"]>0) {
    $ret=0;
    
    $mysqli=new_connect($ret);
    echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
    if (!$mysqli->connect_errno) {
      echo "<p>step one";
//-----------------------------------------------------------------------------
      $edo = new EDO($mysqli,$id_user,false);
      if($id_owner!='') $edo->task_owner(0+$id_owner);   //Фильтр на создателя
      if($ids_town!='') $edo->task_town(explode(',',$ids_town));
      if($ids_kvartal!='') $edo->task_kvartal(explode(',',$ids_kvartal));
      if($ids_object!='') $edo->task_object(explode(',',$ids_object));
      if($dates!=0) $edo->task_date($dates);

        if($number_doc!='') $edo->task_n_number($number_doc);
        if($summa_work!='') $edo->task_n_summa_work($summa_work);
        if($id_implementer!='') $edo->task_n_implementer(0+$id_implementer);
        if($comment!='') $edo->task_n_comment($comment);

      $arr_tasks = $edo->my_tasks($_POST["type"], $_POST["status"]
      ,'ORDER BY d.date_create DESC'
      ,'LIMIT 0,100'
      , $action
      , $id_doc_ );

          echo '<pre>'.print_r($edo->arr_sql,true) .'</pre>';
          echo '<pre>'.print_r($edo->func,true) .'</pre>';
      echo '<pre>arr_document:'.print_r($arr_tasks,true) .'</pre>';
    }
    $mysqli->close();
?>
    <tr><td style="padding-right: 10px">error:<td><?=$edo->error?>
<?php
  }
?>
  </table>
  </form>
  </html>
<?php
}
?>