<?php

//                           Отправить Сброс Назад
function SHOW_tfoot($COLSPAN,$B1,$B2,$B3,$tfoot="tfoot",$display="block")
{
   echo '<'.$tfoot.'><tr><td colspan="'.$COLSPAN.'">';
   echo'<div style="display:'.$display.';" id="panel_button"  >'; 
   //------------------------Отправить

   if ($B1) BUTTON("submit","Отправить",'/images/tree_S/okay.png');
   if ($B2) BUTTON("reset", "Сброс",    '/images/tree_S/gem_cancel_2.png');
   //echo '<p/>B3='.$B3;
   if ($B3==1)         BUTTON("button","Назад",    '/images/tree_S/refresh_backwards.png',"history.back(-1)");
   else { if (!$B3==0)  BUTTON("button","Назад",    '/images/tree_S/refresh_backwards.png','location.href=\''.$B3.'\''); }
   echo '</div></td></tr></'.$tfoot.'>';
}

function BUTTON($TYPE,$VAL,$IMG,$OnCLICK='',$FONT='')
{
     $DiiR='http://'.$_SERVER['HTTP_HOST'];
     if ($OnCLICK<>'') $OnCLICK='onclick="'.$OnCLICK.'"';
     else
     { //if (array_key_exists('id', $_GET))
       //$OnCLICK='onclick="'.'location.href=\''.$_SERVER['HTTP_REFERER'].'&mr='.$_GET['id'].'#op\'"';       //.$_SERVER['HTTP_REFERER']
       //else
       $OnCLICK='';
       //echo "<p>OnCLICK=$OnCLICK</p>";

     }

     if ($FONT=='') { $FONTb=''; $FONTe=''; }
     else           { $FONTb='<font size="-1"  face="'.$FONT.'">'; $FONTe='</font>'; }

     echo   '<button '.$OnCLICK.' type="'.$TYPE.'" style="padding: 0px 4px;">'
           .'<a title="'.$VAL.'"><img src="'.$DiiR.$IMG.'" alt="'.$VAL.'" >'     //.DirR.$IMG
           .$FONTb.'  '.$VAL.$FONTe
           .'</a></button>';
}

?>



