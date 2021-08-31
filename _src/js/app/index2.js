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
		/*
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
*/


		$.arcticmodal({
			type: 'ajax',
			url: 'forms/form_edit_grafic.php?id='+$(this).attr("for"),
			beforeOpen: function (data, el) {
				//во время загрузки формы с ajax загрузчик
				$('.loader_ada_forms').show();
				$('.loader_ada1_forms').addClass('select_ada');
			},
			afterLoading: function (data, el) {
				//после загрузки формы с ajax
				data.body.parents('.arcticmodal-container').addClass('yoi');
				$('.loader_ada_forms').hide();
				$('.loader_ada1_forms').removeClass('select_ada');
			},
			beforeClose: function (data, el) { // после закрытия окна ArcticModal
				if (typeof timerId !== "undefined") {
					clearInterval(timerId);
				}
				BodyScrool();
			}

		});






}
	
}
  
return false;

	
	};