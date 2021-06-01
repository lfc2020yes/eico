<?php

class tree_m {
var $upd;
var $com;          //0-update 1-copy 2-delete
var $paragraf;
var $parent;
var $table;
var $new_paragraf;
var $new_parent='';
var $new_table='';
function tree_m($upd,$com,$paragraf,$new_paragraf='',$new_parent='',$new_table='') {
    $this->upd=$upd;
    $this->com=$com;
    $this->paragraf=$paragraf;
    $this->new_paragraf=$new_paragraf;
    $this->new_parent=$new_parent;
    $this->new_table=$new_table;
    
    $this->tree_all_update();
}

function tree_all_update() {
    echo '<tfoot><tr><td colspan=3>';
    $sqlT=new Tsql('select * from _TREE where PARAGRAF="'.$this->paragraf.'" order by PARAGRAF');
    if ($sqlT->num>0)   //Есть запись о фильтре
    { for ($i=0;$i<$sqlT->num;$i++) {
           $sqlT->NEXT();
           $this->parent=$sqlT->row['PARENT'];            //parent для замены
           $this->table=$sqlT->row['ID_TABLE'];
           
           if ($this->upd==false or $this->com==2)
               echo "<p/>".$sqlT->row['PARAGRAF'].' ['.$sqlT->row['PARENT'].'] '.$sqlT->row['NAME'].' ['.$sqlT->row['ID_TABLE'].']';
           else {
               $nPRF= Sub_str($sqlT->row['PARAGRAF'],$this->paragraf,$this->new_paragraf);
               $nPAR= Sub_str($sqlT->row['PARENT'],$this->parent,$this->new_parent);  
               echo "<p/>".$nPRF.' ['.$nPAR.'] '.$sqlT->row['NAME'].' ['.$sqlT->row['ID_TABLE'].']';
               
           }
               
           if ($this->upd) {
               switch ($this->com) {
                   case 0:
                       $this->form_update($this->paragraf,$nPRF,$this->new_table);
                       $this->tree_update($this->paragraf,$nPRF,$nPAR,$this->new_table);
                       break;
                   case 1:
                        $this->form_copy($this->paragraf,$nPRF,$this->new_table);
                        $this->tree_copy($this->paragraf,$nPRF,$nPAR,$this->new_table);
                       break;
                   case 2:
                       $this->form_delete($this->paragraf);
                       $this->tree_delete($this->paragraf);
                       break;   
               }
           }
           $this->tree_branch($this->paragraf,$nPRF,1);
           
      }
      $sqlT->FREE();
    }
    unset ($sqlT);
    echo '</tr></tfoot>';
}
function tree_branch($paragraf,$new_parent,$level) {
    
    $sqlB=new Tsql('select STRCMP(
					REPLACE(
					REPLACE(
					REPLACE(TYPE_FORM,"FORM_ADD","1")
					              ,"FORM_EDIT","1")
					              ,"FORM_DELETE","1")
					              ,"1")   AS TF,'
            . '_TREE.* from _TREE where PARENT="'.$paragraf.'"  ORDER BY TF,_TREE.PARAGRAF,_TREE.NAME');
    if ($sqlB->num>0)   //Есть запись о фильтре
    { for ($i=0;$i<$sqlB->num;$i++) {
           $sqlB->NEXT();
           
           if ($this->upd==false or $this->com==2) 
            echo '<p/><a style="padding: 0px '.($level*20).'px;" >'.$sqlB->row['PARAGRAF']
                   .' ['.$sqlB->row['PARENT'].'] '
                   .$sqlB->row['NAME']
                   .' ['.$sqlB->row['ID_TABLE'].'] '
                   .'</a>';
           else {
                $nPRF= Sub_str($sqlB->row['PARAGRAF'],$this->paragraf,$this->new_paragraf);
                echo '<p/><a style="padding: 0px '.($level*20).'px;" >'.$nPRF
                   .' ['.$new_parent.'] '
                   .$sqlB->row['NAME']
                   .' ['.$sqlB->row['ID_TABLE'].'] '
                   .'</a>'; 
           }
           
           if ($this->upd) {
                if ($this->table==$sqlB->row['ID_TABLE']) $table=$this->new_table;
                else $table='';
                switch ($this->com) {
                   case 0:
                        $this->form_update($sqlB->row['PARAGRAF'],$nPRF,$table);
                        $this->tree_update($sqlB->row['PARAGRAF'],$nPRF,$new_parent,$table);
                        break;
                   case 1:
                        $this->form_copy($sqlB->row['PARAGRAF'],$nPRF,$table);
                        $this->tree_copy($sqlB->row['PARAGRAF'],$nPRF,$new_parent,$table);
                       break;
                   case 2:
                       $this->form_delete($sqlB->row['PARAGRAF']);
                       $this->tree_delete($sqlB->row['PARAGRAF']);
                       break;     
                }        
           } 
           
           $this->tree_branch($sqlB->row['PARAGRAF'],$nPRF,$level+1);
           
      }
      $sqlB->FREE();
    }       
    unset($sqlB);
}

function form_delete($paragraf){
  $sql='DELETE FROM _FORM WHERE PARAGRAF="'.$paragraf.'"'; 
  //echo "<p/>$sql";
  $sqlTR = new Tsql($sql,1);
}
function tree_delete($paragraf){
    $sql='DELETE FROM _TREE WHERE PARAGRAF="'.$paragraf.'"'; 
  //echo "<p/>$sql";
  $sqlTR = new Tsql($sql,1); 
}
function form_update($paragraf,$new_paragraf,$new_table='') {
  if ($new_table=='') $table='';
  else $table=', TABLE_NAME="'.$new_table.'" ';   
  $sql='UPDATE _FORM set PARAGRAF="'.$new_paragraf.'"'.$table
          .' WHERE PARAGRAF="'.$paragraf.'"';
  //echo "<p/>$sql";
  $sqlTR = new Tsql($sql,1);
}
function tree_update($paragraf,$new_paragraf,$new_parent,$new_table='') {
    if ($new_table=='') $table='';
    else $table=', ID_TABLE="'.$new_table.'" ';  
    $sql='update _TREE set PARAGRAF="'.$new_paragraf.'", PARENT="'.$new_parent.'"'.$table
             . ' WHERE PARAGRAF="'.$paragraf.'"';
    // echo "<p/>$sql";
    $sqlTR=new Tsql($sql,1); 
    
}
function form_copy($paragraf,$new_paragraf,$new_table='') {
  if ($new_table=='') { $table1='TABLE_NAME,'; }
  else { $table1='"'.$new_table.'",'; }  

  $sql='
INSERT INTO _FORM
( PARAGRAF,
  displayOrder,
  TABLE_NAME,
  VISIBLE,
  NONEDIT,
  COLUMN_FIELD,
  COLUMN_SIZE,
  COLUMN_NAME,
  COLUMN_DEFAULT,
  TYPE_FIELD,
  kind_FIND,
  kind_bold,
  SOURCE_FIELD,
  SOURCE_TABLE,
  SOURCE_ID,
  SOURCE_FILTER,
  FILE_DIR,
  CHILD,
  MASTER )
 
SELECT
  
  "'.$new_paragraf.'",
  displayOrder,
  '.$table1.'
  VISIBLE,
  NONEDIT,
  COLUMN_FIELD,
  COLUMN_SIZE,
  COLUMN_NAME,
  COLUMN_DEFAULT,
  TYPE_FIELD,
  kind_FIND,
  kind_bold,
  SOURCE_FIELD,
  SOURCE_TABLE,
  SOURCE_ID,
  SOURCE_FILTER,
  FILE_DIR,
  CHILD,
  MASTER
FROM _FORM WHERE PARAGRAF="'.$paragraf.'" ORDER BY PARAGRAF,displayOrder          
          ';
  
  //echo "<p/>$sql";
  $sqlTR = new Tsql($sql,1);
}

function tree_copy($paragraf,$new_paragraf,$new_parent,$new_table='') {
  if ($new_table=='') {  $table1='ID_TABLE,'; }
  else { $table1='"'.$new_table.'",'; }  

  $sql='
INSERT INTO _TREE
( 
  PARAGRAF,
  PARENT,    
  NAME,
  TYPE_FORM,
  kind_ADD,
  kind_EDIT,
  kind_moved,
  kind_delete,
  kind_FIND,
  parent_TABLE,
  parent_COLUMN,
  parent_TITLE,
  ID_TABLE,
  ID_COLUMN,
  ID_ORDER,
  FILTER,
  sys_TEXT,
  sys_BUTTON,
  sys_URL,
  sys_SQL,
  DEBUG )

SELECT
  "'.$new_paragraf.'",
  "'.$new_parent.'",
  NAME,
  TYPE_FORM,
  kind_ADD,
  kind_EDIT,
  kind_moved,
  kind_delete,
  kind_FIND,
  parent_TABLE,
  parent_COLUMN,
  parent_TITLE,
  '.$table1.'
  ID_COLUMN,
  ID_ORDER,
  FILTER,
  sys_TEXT,
  sys_BUTTON,
  sys_URL,
  sys_SQL,
  DEBUG
  FROM _TREE WHERE PARAGRAF="'.$paragraf.'"
          ';
  //echo "<p/>$sql";
  $sqlTR = new Tsql($sql,1);
}
} //class
function Sub_str($str,$find,$substr) {
    $ret=false;
    $offset=strpos($str,$find);
    //echo "<p/>offset=$offset : ".$str.'<-'.$find;
    if (($offset===false) or ($offset>0)) {
       $ret=$substr.'.'.$str; 
    }  else {
       $ret=substr_replace($str,$substr,0,strlen($find)); // Заменить только в начале строки
    }
    return $ret;
}