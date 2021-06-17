// JavaScript Document
$(function (){

//определить zindex для select полей
Zindex();
	
});


//определить zindex для select полей
//  |
// \/
function Zindex() {
  var zindex=50;
	//alert($('.js-zindex').length);
  $('.js-zindex').each(function (i, elem) {
      $(this).css("z-index", zindex);
	  zindex--;
    });
  }