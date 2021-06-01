<div class="menu_top" style="border-bottom:0; box-shadow: 0 20px 30px -30px rgba(0, 0, 0, 0.6);">
  <?
   echo'<h3 class="head_h" style=" margin-bottom:0px; float:left;">Оформление наряда<div></div></h3>';
	$D = explode('.', $_COOKIE["basket_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);
	if(count($D)>0)
	{
echo'<div class="font-rank1"><span class="font-rank-inner1 basket_order">'.count($D).'</span></div>

<div class="save_button add_nar"><i>Сохранить</i></div>';	
if((isset($stack_error))and((count($stack_error)!=0)))
   {
	echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';
} else
   {
echo'<div class="error_text_add"></div>';	
}
	}
	?>
	



	</div>
	