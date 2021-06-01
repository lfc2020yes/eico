
$(function() {

//index of current item
var current = 0;
//var num_li_w=1020;
var num_li_w=$('#thumbScroller').width();
var num_li_h=443;
var left_ul=0;
var flag_anim=2;
//speeds / ease type for animations
var fadeSpeed = 400;
var animSpeed = 600;
var easeType = 'easeOutCirc';
var calscrool=0;
//caching
var  thumbScroller = $('#thumbScroller');
var  scrollerContainer =  thumbScroller.find('.container');
var  scrollerContent =  thumbScroller.find('.b-main-slider_list_item');
var  pg_title = $('#pg_title');
var  pg_preview = $('#pg_preview');
var  pg_desc1 = $('#pg_desc1');
var  pg_desc2 = $('#pg_desc2');
var  overlay = $('#overlay');
//number of items
var scrollerContentCnt =  scrollerContent.length;
var sliderHeight = $(window).height();
//var sliderWidth = $(window).width();
//var sliderWidth =1020;
var sliderWidth = $('#thumbScroller').width();
var width_lii= scrollerContent.width();


scrollerContainer.css('width',((width_lii+35)*scrollerContentCnt));
//we will store the total height
//of the scroller container in this variable
var totalContent = 0;
//one items height
var itemHeight = 0;
var itemWidth = 0;
//First let's create the scrollable container,
//after all its images are loaded
var cnt = 0;

thumbScroller.find('img').each(function(){
var  img = $(this);
$('<img/>').load(function(){
++cnt;
if(cnt == scrollerContentCnt){
//one items height
itemHeight =  thumbScroller.find('.b-main-slider_list_item:first').height();
itemWidth =  (thumbScroller.find('.b-main-slider_list_item:first').width()+35);
buildScrollableItems();
//show the scrollable container
 thumbScroller.stop().animate({'left':'0px'},animSpeed);
}
}).attr('src', img.attr('src'));
});

//when we click an item from the scrollable container
//we want to display the items content
//we use the index of the item in the scrollable container
//to know which title / image / descriptions we will show




//create the scrollable container
//taken from Manos :
//http://manos.malihu.gr/jquery-thumbnail-scroller
var handler_move = function(e,thiss) {
	
if( scrollerContainer.width()>sliderWidth){
	
  var mouseCoords = (e.pageX - thiss.offset().left);
  var mousePercentX = mouseCoords/sliderWidth;
  var destX = -(((totalContent-(sliderWidth-itemWidth))-sliderWidth)*(mousePercentX));
  var thePosA = mouseCoords-destX;
  var thePosB = destX-mouseCoords;
  
if(mouseCoords==destX)
 scrollerContainer.stop();
else if(mouseCoords>destX)
 scrollerContainer.stop().animate({left: -thePosA},animSpeed,easeType);
else if(mouseCoords<destX)
 scrollerContainer.stop().animate({left: thePosB},animSpeed,easeType);

}	

	
};


function buildScrollableItems(){
totalContent = (scrollerContentCnt-1)*itemWidth;
thumbScroller.css('width',sliderWidth);


thumbScroller.bind('mousemove', function(event){
       handler_move(event,thumbScroller);
    });
}
});