function onChange_MASTER(FILTER,div_name)
{ // alert("������ AJAX: "+PHP_programm+" FILTER="+FILTER );

var data = {
			filter: FILTER
            //master: MASTER,
            //slave:  SLAVE
	       };
 //               dir       pref_file     metod  data  post_js       post_data     �������� ����� �������
client_request ( 'master', 'filter', '', 'POST', data, 'AfterFLT',"'"+div_name+"'",'MS'  );

//alert("end AJAX+");
}

function AfterFLT( div_name, data )
{
  //alert("after AJAX="+div_name+" FLT[0]="+data.FLT[0]+" MST[0]="+data.MST[0]+" SLV[0]="+data.SLV[0]+" RES[1]="+data.RES[1] );

  if ( data.status == 0 )
  {
    // ����� ������������ ����
    //  alert("html AJAX ="+data.HTML+" "+data.SQL);
    // alert("AJAX="+data.status+" SQL="+data.SQL);
    // $('div.mst').empty();
    $('#mt').empty();
	//$( 'div#'+div_name ).empty ();

	var html = ''; //'<caption><div style="padding:3px;">���������</div></caption>';
	      html =data.HTML;

	//$( 'div#master' ).empty ();
	//$( 'div#'+div_name ).append ( html );
	//$( 'div.mst').append ( html );
    $('#mt').append ( html );

  }
  else alert("������ AJAX="+data.status+" "+data.SQL);
}
