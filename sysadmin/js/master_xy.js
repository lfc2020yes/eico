function onChange_MASTER_XY(FILTER,div_name)
{ //alert("запуск AJAX XY: "+FILTER );

var data = {
			filter: FILTER
            //master: MASTER,
            //slave:  SLAVE
	       };
 //               dir       pref_file     metod  data  post_js       post_data     передача формы целиком
client_request ( 'master', 'xy', '', 'POST', data, 'AfterXY',"'"+div_name+"'",'MS'  );

  //alert("end AJAX+");
}

function AfterXY( div_name, data )
{
  //alert("after AJAX");

  if ( data.status == 0 )
  {
    // Вывод добавленного кода
    //alert("html AJAX ="+data.HTML+" "+data.SQL);
    // alert("AJAX="+data.status+" SQL="+data.SQL);
    // $('div.mst').empty();
    $('#mt').empty();
	//$( 'div#'+div_name ).empty ();

	var html = ''; //'<caption><div style="padding:3px;">результат</div></caption>';
	      html =data.HTML;

	//$( 'div#master' ).empty ();
	//$( 'div#'+div_name ).append ( html );
	//$( 'div.mst').append ( html );
    $('#mt').append ( html );

  }
  else alert("ошибка AJAX="+data.status+" FLT:"+data.FLT
                                       +" xxx:"+data.xxx
                                       +" yyy:"+data.yyy
                                       +" zzz:"+data.zzz
                                       +" RES:"+data.RES
                                       +" HTML:"+data.HTML
                                       );
}
