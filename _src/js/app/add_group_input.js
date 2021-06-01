// JavaScript Document
$(function (){

//добавить группу в форме кнопка +	
$('body').on("change keyup input click",'.js-add-group',AddGroup);	
//удалить группу в форме кнопка -	
$('body').on("change keyup input click",'.js-dell-group',DellGroup);	

});



//удалить группу в форме кнопка -	
//  |
// \/
function DellGroup()
{
	var group=$(this).parents('.js-group');
	
	group.slideUp("slow",function () {group.remove();  });
	
}


//добавить группу в форме кнопка +	
//  |
// \/
function AddGroup()
{
	//alert("!!");
	var group=$(this).parents('.js-group');
	var class_group='';
	if(group.is('.group-right'))
	{
			class_group='group-right';
	}
	
	var group_html=group.html();
	
	group.after('<div class="js-group '+class_group+' contact-group line-group">'+group_html+'</div>');
	
	var next_group=group.next();
	
	next_group.find('.active_in_2018').removeClass('active_in_2018');
	next_group.find('.required_in_2018').removeClass('required_in_2018');
	
	
	if(next_group.find('.js-dell-group').length==0)
		{
	next_group.find('.js-add-group').after('<div data-tooltip="Удалить" class="dell-group js-dell-group"><div></div></div>');
		}
	ToolTip();
	next_group.find('input').val('');
	next_group.find('textarea').val('');
	
	//удаляем лишнее из textarea с resize и активируем к новым полям
	next_group.find('.js-resize-block').each(function(i,elem) {
		
		if($(this).find('textarea').length==2)
			{
				$(this).find('textarea').first().remove();
				$(this).find('textarea').removeAttr('style');
				$(this).find('textarea').autoResize({extraSpace : 10});
			}
		
		
	});
	
	
	next_group.find('.list_2018').removeClass('active_in_2018').removeClass('active1_in_2018');
	next_group.find('.list_2018 input').val('');
	next_group.find('.list_2018 .sel_active').removeClass('sel_active');
	
	next_group.find('.slct').attr('data_src','').empty();
	
	//jQuery.scrollTo(next_group, 1000, {offset:-70});
	
	Zindex();
	SelectUpdate();
}// JavaScript Document

//обновить селекты при добавлении новых
//  |
// \/
function SelectUpdate()
{
	$(".slct").unbind('click.sys');
    $(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
}
