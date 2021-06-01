
function shFilm(ktr, kpop) {
		
	if (!jQuery.browser.opera || (jQuery.browser.opera && jQuery.browser.version>=9.5)) {
	jQuery("#"+ktr).parent().mouseout(function(){
		jQuery("#"+kpop).hide();
	});
	//bpops = jQuery("#apops").position();
	pos = jQuery("#"+ktr).parent().offset();
	jQuery("#"+kpop).css({'visibility':'hidden', 'display': 'block'});

	
	if ((jQuery(window).height()+jQuery(window).scrollTop())>(pos.top+jQuery("#"+ktr).height()+4+jQuery("#"+kpop).height())) {
		jQuery("#"+kpop).css({'left': pos.left+50+'px', 'top': pos.top+jQuery("#"+ktr).height()+4+'px', 'visibility': 'visible'});
	}
	else if ((pos.top-jQuery(window).scrollTop())-(jQuery("#"+kpop).height()+10)<0) {
		jQuery("#"+kpop).css({'left': pos.left+50+'px', 'top':jQuery(window).scrollTop()+jQuery(window).height()-(jQuery("#"+kpop).height()+10)+'px', 'visibility': 'visible'});
	}
	else {
		jQuery("#"+kpop).css({'left': pos.left+50+'px', 'top': pos.top-jQuery("#"+kpop).height()-10+'px', 'visibility': 'visible'});
	}
	}

}

function Form_ss(i) {
	
	$( '#bron_form_'+ i ).submit();
	
}
