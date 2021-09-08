<!--<script type="text/javascript" src="Js/modernizr.custom.53451.js"></script>-->
<script src="/Js/jquery-1.9.1.js"></script><script>var OLD = jQuery.noConflict();</script>
<!--<script language="JavaScript" type="text/javascript" src="Js/jquery.freezeheader.js"></script>
<script language="javascript" type="text/javascript" src="/Js/jquery-2.1.1.js"></script>
<script language="javascript" type="text/javascript" src="/Js/jquery.ajax.js"></script>
<script language="javascript" type="text/javascript" src="/Js/respond.src.js"></script>
<script language="javascript" type="text/javascript" src="/Js/jquery.history.js"></script>
<script language="javascript" type="text/javascript" src="/Js/jquery.scrollTo-min.js"></script>
<script language="JavaScript" type="text/javascript" src="/Js/lightgallery.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/Js/lg-thumbnail.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/Js/lg-fullscreen.min.js"></script>-->
<!--<script language="JavaScript" type="text/javascript" src="/Js/scrollbar.js"></script> -->
  

<!--<link href="/stylesheets/main.css?<? //echo($vs); ?>" type="text/css" rel="stylesheet" />-->

<!--<script language="JavaScript" type="text/javascript" src="/Js/index.js?<? //echo($vs); ?>"></script>
<script language="JavaScript" type="text/javascript" src="/Js/index2.js?<? //echo($vs); ?>"></script>-->




<?php
$local='C:/OpenServer/domains/'.$local_host.'';
if($_SERVER['DOCUMENT_ROOT']!=$local)
{
echo'<link href="/public/main.min.css?cb=1631103263837" type="text/css" rel="stylesheet" />
<script language="JavaScript" type="text/javascript" src="/public/index.map.min.js?cb=1631103263837"></script>';
} else
{
echo'<link href="/_src/css/main.css?cb=1631103263837" type="text/css" rel="stylesheet" />
<script language="JavaScript" type="text/javascript" src="/public/index.map.js?cb=1631103263837"></script>';
}

?>
