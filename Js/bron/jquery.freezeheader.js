

function ChangeKolNomer(id)
{
	var kol_select=$("#cur_"+id).val();
	//alert(kol_select);
	//перебираем переменную .bron_const
	var bron=$(".bron_const").val();
	var arr = bron.split('<>');
	var bron_cost='';
	var count_bron=0;
	var flag_bron=0;
	var sum_bron=0;
	var itog_bron='';
	var itog_bron1='';
	//alert(arr.length);
	
	if(bron!='')
	{
	for (var i = 0; i < arr.length; i++) {
        var arr1 = arr[i].split('><');
		
		
		//уже был, изменили количество
		if(arr1[0]==id)
		{
			if(kol_select!=0)
			{
			sum_bron=sum_bron+kol_select*$('.sum_search_'+id).val();
			flag_bron=1;
			//заменяем эту запись
			if(count_bron!=0)
			{
			  bron_cost=bron_cost+'<>'+id+'><'+kol_select+'><'+$('.mass_search_'+id).val();
			  itog_bron1=itog_bron1+'<div class="xas_plus" style="color:#339900; font-size:11px;   color: #000;"><b>+</b></div><div class="xas_2" style="color:#339900; font-size:11px;   color: #000;"><b>'+kol_select*$('.sum_search_'+id).val()+' руб.</b></div>';
			} else
			{
			  bron_cost=bron_cost+id+'><'+kol_select+'><'+$('.mass_search_'+id).val();
			  itog_bron1=itog_bron1+'<div class="xas_2" style="color:#339900; font-size:11px;   color: #000;"><b>'+kol_select*$('.sum_search_'+id).val()+' руб.</b></div>';
			}
			count_bron++;
			
			}
		} else
		{
			sum_bron=sum_bron+arr1[1]*$('.sum_search_'+arr1[0]).val();
			if(count_bron!=0)
			{
			  bron_cost=bron_cost+'<>'+arr[i];
			  itog_bron1=itog_bron1+'<div class="xas_plus" style="color:#339900; font-size:11px;   color: #000;"><b>+</b></div><div class="xas_2" style="color:#339900; font-size:11px;   color: #000;"><b>'+arr1[1]*$('.sum_search_'+arr1[0]).val()+' руб.</b></div>';
			} else
			{
			  bron_cost=bron_cost+arr[i];
			  itog_bron1=itog_bron1+'<div class="xas_2" style="color:#339900; font-size:11px;   color: #000;"><b>'+arr1[1]*$('.sum_search_'+arr1[0]).val()+' руб.</b></div>';
			}
			count_bron++;
		}
    }
	}
	//если там уже есть такая запись с id заменяем или добавляем новую
	if((flag_bron==0)&&(kol_select!=0))
	{
            sum_bron=sum_bron+kol_select*$('.sum_search_'+id).val();		
			if(count_bron!=0)
			{
			  bron_cost=bron_cost+'<>'+id+'><'+kol_select+'><'+$('.mass_search_'+id).val();
			  itog_bron1=itog_bron1+'<div class="xas_plus" style="color:#339900; font-size:11px;   color: #000;"><b>+</b></div><div class="xas_2" style="color:#339900; font-size:11px;   color: #000;"><b>'+kol_select*$('.sum_search_'+id).val()+' руб.</b></div>';
			} else
			{
			  bron_cost=bron_cost+id+'><'+kol_select+'><'+$('.mass_search_'+id).val();
			  itog_bron1=itog_bron1+'<div class="xas_2" style="color:#339900; font-size:11px;   color: #000;"><b>'+kol_select*$('.sum_search_'+id).val()+' руб.</b></div>';
			}
			count_bron++;
	}
	
	//выводим суммы перед кнопкой забронировать
	
	if(count_bron>1)
	{
		itog_bron1=itog_bron1+'<div class="xas_ravno" style="color:#339900; font-size:11px;  color: #000;"><b>=</b></div>';
		itog_bron=itog_bron+itog_bron1;
	}
	
	if(count_bron!=0)
	{
	itog_bron=itog_bron+'<div class="xas_sum" style="color:#339900; font-size:13px;   padding-top:5px;"><b>'+sum_bron+' руб.</b></div>';
	$('.pod_bron').hide();
	} else
	{
		$('.pod_bron').show();
	}
	
	if(count_bron==1)
	{
			itog_bron=itog_bron+'<span class="xas_opis" style="color:#339900; font-size:11px; ">'+$('.dina_search_'+id).val()+'</span>';
		
		
	} 
	
	$('.bron_const').val(bron_cost);
	$('.itog_broni').empty().append(itog_bron);
}

function travel_cost_ira()
{
			var email=jQuery.trim( $("#login_vs").val());
		
		var data = {
			date1: $("#date_ira1").val(),
			/*date2:$("#date_ira2").val(),*/
			people:$("#cur_jino").val(),
			kol_day:$("#cur_jino1").val(),
			id_custom:$("#id_custom_tr").val()
		
		};

		$('.div_travel2').hide();
		$('.div_travel4').show();
		
		client_request ('account', 'cost_travel', '', 'POST', data, 'test_travel_ira', 1);
}

function test_travel_ira(email, data)
{	
  $('.div_travel4').hide();

$('.jkjkp').empty().append(data.dates);
  $('.div_travel1').show();

  $('.div_travel3').empty().append(data.cost);
  $('.div_travel3').show();
  

$("#table_freez").freezeHeader();  
 $('.room_price_inner').hover (
function(){ $(this).addClass("inner_state_active");},

function(){$(this).removeClass("inner_state_active");}
);	  
	   

$('.hhff').hover (
function(){ $(this).next().animate({"bottom": "-=40px"});},

function(){$(this).next().animate({"bottom": "+=40px"}, "slow");}
);


$('#result_columnh').attr("rowspan", data.sql);
$('#td_with_button').css({height: ''+(data.tr_colspan)+'px'});
for (var ig = 1; ig <= data.ip; ig++) {
/*
		   for ($ig=1; $ig<=count(data.tr_colspan); $ig++)
           {  
*/		   		         
				  $('.hjop_'+ig+'').attr("rowspan", data.tr_colspan[ig]);				  
				  jQuery(".gallery_room"+ig).jCarouselLite({visible: 1,btnNext: "#room-right"+ig,btnPrev: "#room-left"+ig,circular: true});				     
           }


	
var obj = $('.floating');
var offset = obj.offset();
var topOffset = offset.top;
var marginTop = obj.css("marginTop");

//var topOffset_f=obj_fooder.offset().top;



$(window).scroll(function() {

var height= obj.height();
var obj_fooder=$('#td_with_button');
var height_f=obj_fooder.height();
	
var scrollTop = $(window).scrollTop()+20;

//var topOffset_x=topOffset_f-height;
var ffg=0;

$('.sc_r').empty().append(topOffset+height_f);
$('.sc_r1').empty().append($('#table_freez').height());
//alert($('#td_with_button').css("height"));
var hj=topOffset-height;


$('#td_with_button').css({ height:($('#table_freez').height()-40)+'px'});
//alert(hj);

  if ((scrollTop>= (hj))&&(scrollTop<topOffset+height_f-height)){

    obj.css({
      position: 'fixed',
	  top:height+'px',
	  paddingTop: '30px',
    });
  }

  if (scrollTop < topOffset){

    obj.css({
      top: 0,
	  paddingTop: '30px',
      position: 'relative',
    });
  }
  
  if (scrollTop > topOffset+height_f-height-70){

    obj.css({
      top: height_f-height-30+'px',
	  paddingTop: '0px',
      position: 'relative',
    });
  }  

});


 
  
}

function sOther_ot(lnk,thiss) {
	bk = jQuery('.tr_opiss_'+lnk);
	if(bk.is(":visible"))
    {	
		
		//bk.removeClass("dnone");
		//jQuery('em',jQuery(lnk)).css("background-position","0 -10px");

		bk.slideUp("slow");
		$('#td_with_button').css({ height:'220px'});
		//$( '#ggggg' ).animate ( {opacity: 'hide'}, 0 );
		
	}
	else {
		//bk.addClass("dnone");
		bk.slideDown("slow");
		
		//jQuery('em',jQuery(lnk)).css("background-position","0 0");
//		$( '#otziviv' ).animate ( {opacity: 'hide'}, 0 );
		//$( '#otziviv' ).hide();
		//$( '#ggggg' ).animate ( {opacity: 'show'}, 0 );		
	}
}



/* ------------------------------------------------------------------------
Class: freezeHeader
Use:freeze header row in html table
Example 1:  $('#tableid').freezeHeader();
Example 2:  $("#tableid").freezeHeader({ 'height': '300px' });
Example 3:  $("table").freezeHeader();
Example 4:  $(".table2").freezeHeader();
Author(s): Laerte Mercier Junior, Larry A. Hendrix
Version: 1.0.6
-------------------------------------------------------------------------*/
$(document).ready(function(){




$('.bron_bb').on("click",function(){

	var bron=$(".bron_const").val();
	if(bron!='')
	{
		//отправляем форму
		$( '#bron_form_new' ).submit();
	}
	
	
});


$('.a_smena').on("click",function(){ $('.div_travel2').show(); $('.div_travel1').hide(); $('.div_travel3').hide(); });


$(document).mouseup(function (e) {
    var container = $(".select");
    if (container.has(e.target).length === 0){
        //клик вне блока и включающих в него элементов
	    $(".drop").hide();
    }
});


$(".slct").on( "click", function() {
	$(".drop").hide();
	//alert("!");
	  var d=$(this).parent().find(".drop");
	  if(d.is(":hidden"))
	  {
		  d.slideDown();
		  $(this).addClass("active");
		  $(".drop").find("li").click(function(){
			  var f=$(this).html();
			  var e=$(this).find("a").attr("rel");
			  $(this).parent().parent().find("input").val(e);
			  $(this).parent().parent().find(".slct").removeClass("active").html(f);
			  d.slideUp();
		  })
	  }else{
		  $(this).removeClass("active");
		  d.slideUp()}
return false});	
	

	
    var TABLE_ID = 0;
    $.fn.freezeHeader = function (params) {

        var copiedHeader = false;

        function freezeHeader(elem) {
            var idObj = elem.attr('id') || ('tbl-' + (++TABLE_ID));
            if (elem.length > 0 && elem[0].tagName.toLowerCase() == "table") {

                var obj = {
                    id: idObj,
                    grid: elem,
                    container: null,
                    header: null,
                    divScroll: null,
                    openDivScroll: null,
                    closeDivScroll: null,
                    scroller: null
                };

                if (params && params.height !== undefined) {
                    obj.divScroll = '<div id="hdScroll' + obj.id + '" style="height: ' + params.height + '; overflow-y: scroll">';
                    obj.closeDivScroll = '</div>';
                }

                obj.header = obj.grid.find('thead');

                if (params && params.height !== undefined) {
                    if ($('#hdScroll' + obj.id).length == 0) {
                        obj.grid.wrapAll(obj.divScroll);
                    }
                }

                obj.scroller = params && params.height !== undefined
                   ? $('#hdScroll' + obj.id)
                   : $(window);

                if (params && params.scrollListenerEl !== undefined) {
                    obj.scroller = params.scrollListenerEl;
                }
                obj.scroller.bind('scroll', function () {
                    if ($('#hd' + obj.id).length == 0) {
                        obj.grid.before('<div id="hd' + obj.id + '"></div>');
                    }

                    obj.container = $('#hd' + obj.id);

                    if (obj.header.offset() != null) {
                        if (limiteAlcancado(obj, params)) {
                            if (!copiedHeader) {
                                cloneHeaderRow(obj);
                                copiedHeader = true;
                            }
                        }
                        else {

                            if (($(document).scrollTop() > obj.header.offset().top)) {
                                obj.container.css("position", "absolute");
                                obj.container.css("top", (obj.grid.find("tr:last").offset().top - obj.header.height()) + "px");
                            }
                            else {
                                obj.container.css("visibility", "hidden");
                                obj.container.css("top", "0px");
                                obj.container.width(0);
                            }
                            copiedHeader = false;
                        }
                    }

                });
            }
        }

        function limiteAlcancado(obj, params) {
            if (params && (params.height !== undefined || params.scrollListenerEl !== undefined)) {
                return (obj.header.offset().top <= obj.scroller.offset().top);
            }
            else {
                return ($(document).scrollTop() > obj.header.offset().top && $(document).scrollTop() < (obj.grid.height() - obj.header.height() - obj.grid.find("tr:last").height()) + obj.header.offset().top);
            }
        }

        function cloneHeaderRow(obj) {
            obj.container.html('');
            obj.container.val('');
            var tabela = $('<table style="margin: 0 0;"></table>');
            var atributos = obj.grid.attr("attributes");

            $.each(atributos, function () {
                if (this.name != "id") {
                    tabela.attr(this.name, this.value);
                }
            });

            tabela.append('<thead>' + obj.header.html() + '</thead>');

            obj.container.append(tabela);
            obj.container.width(obj.header.width());
            obj.container.height(obj.header.height);
            obj.container.find('th').each(function (index) {
                var cellWidth = obj.grid.find('th').eq(index).width();
                $(this).css('width', cellWidth);
            });

            obj.container.css("visibility", "visible");

            if (params && params.height !== undefined) {
                obj.container.css("top", obj.scroller.offset().top + "px");
                obj.container.css("position", "absolute");
            } else if (params && params.scrollListenerEl!== undefined) { 
                obj.container.css("top", obj.scroller.find("thead > tr").innerHeight() + "px");
                obj.container.css("position", "absolute");
                obj.container.css("z-index", "2");
            } else {
                obj.container.css("top", "0px");
                obj.container.css("position", "fixed");
            }
        }

        return this.each(function (i, e) {
            freezeHeader($(e));
        });

    };
});