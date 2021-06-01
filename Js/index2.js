//изменения в index.js
//-------------------------------
//функция update_block изменилась




var date_graf = function() {
	
	
	if($('#date_hidden_table_gr1').val()>$('#date_hidden_table_gr2').val())
		{
			
			$('#date_hidden_table_gr2').val('');
			$('#date_table_gr2').val('');
			
			
		}
	
	
}


//редактировать работу в разделе в себестоимости
var edit_grafik_click = function() {
	
if ( $(this).is("[for]") )
{
	if($.isNumeric($(this).attr("for")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_edit_grafic.php?id='+$(this).attr("for"),
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
}
	
}
  
return false;

	
	};