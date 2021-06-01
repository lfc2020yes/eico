function writeFlash(w, h, url,n) 
{
    document.write('	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="' + w + '" height="' + h + '" id="' + n + '" align="middle">');
    document.write('<param name="allowScriptAccess" value="sameDomain" />');
    document.write('<param name="allowFullScreen" value="false" />');
    document.write('<param name="movie" value="' + url + '" />');
    document.write('<param name="quality" value="high" />');
    document.write('<param name="bgcolor" value="#ffffff" />');	
				   
	document.write('<embed src="' + url + '" quality="high" bgcolor="#ffffff"  width="' + w + '" height="' + h + '" name="' + n + '" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
	document.write('</object>');
}

function writeFlashCenter(w, h, url,n) 
{
    document.write('	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="100%" height="' + h + '" id="' + n + '" align="middle">');
    document.write('<param name="allowScriptAccess" value="sameDomain" />');
    document.write('<param name="allowFullScreen" value="false" />');
    document.write('<param name="movie" value="' + url + '" />');
    document.write('<param name="quality" value="high" />');
    document.write('<param name="bgcolor" value="#ffffff" />');	
				   
	document.write('<embed src="' + url + '" quality="high" bgcolor="#ffffff"  width="100%" height="' + h + '" name="' + n + '" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
	document.write('</object>');
}
