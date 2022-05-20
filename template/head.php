<script src="/Js/jquery-1.9.1.js"></script><script>var OLD = jQuery.noConflict();</script>

<?php
echo'<script language="JavaScript" type="text/javascript">window.is_session=\''.$base_cookie.'\';</script>';
if($local_server_x==0)
{
echo'<link href="/public/main.min.css?cb=1653042300360" type="text/css" rel="stylesheet" />
<script language="JavaScript" type="text/javascript" src="/public/index.map.min.js?cb=1653042300360"></script>';
} else
{
echo'<link href="/_src/css/main.css?cb=1653042300360" type="text/css" rel="stylesheet" />
<script language="JavaScript" type="text/javascript" src="/public/index.map.js?cb=1653042300360"></script>';
}

?>
