/*
function addFiles(files) {
   //alert ('typeof ff:'+ (typeof ff));
   for(var i = 0; i < files.length; i++) {             // ���������� ��� ����� � FileList'�
     full.files.push(files[i]);
   }

   full.files=full.files.concat(files);
   alert ('files='+full.files.length);
}
*/

/*
 * ������� ��� ���������� ������ (<tr>),
 * ���������� ���������� � �����
 * � ���� ������� (tbody)
 */                                       //style="display: none;">

function appendFileInfo(tbody,img,data,num) {
  var div;
  var tr = document.createElement('tr');
  var td = document.createElement('td');
      td.appendChild(img);
      tr.appendChild(td);

  var canvas = document.createElement("canvas");
      canvas.id=img.id;
      canvas.height=150;
	  canvas.width=150;

  var context = canvas.getContext("2d");
      context.height=120;
      context.width=120;
      //context.drawImage(img,100,100);

      td = document.createElement('td');
      td.appendChild(canvas);
      tr.appendChild(td);

    for(var j = 0; j < data.length; j++) {
      td = document.createElement('td');
      td.innerHTML = '<div name="'+num+'_'+j+'">'+(data[j] || '����������')+'</div>';
      tr.appendChild(td);
    }
    tbody.appendChild(tr);

    div = document.createElement('div')
    div.innerHTML = '<input type="hidden" name="file_'+num+'"value="'+data[0]+'|'+data[1]+'|'+data[2]+'|'+num+'"/>';
    output.appendChild(div);

  return tbody;
}

/*
 * ������� ��� �������� ������ �.�
 * ����������� ��� ��������
 * �� �������� �������� �����������
 */

function makePreview(image, a) {
  var img = image,
    w = img.width, h = img.height,
    s = w / h;

  if(w > a && h > a) {
    if(img.width > img.height) {
      img.width = a;
      img.height = a / s;
    } else {
      img.height = a;
      img.width = a * s;
    }
  }

  return img;
}

/*
 * ��� ������� �� ����� �������� ��� ��������� (onchange)
 * input'� �.�. ����� ������������ ������� �����.
 */

function onFilesSelect(target) {
     //alert('onFilesSelect');
     getFiles(target.files,0);
}



function GreateFileList(fa) {
  var files=fa;
  files = [];
  for (var k=0; k<2; k++) {
      if (window.asel[k]>0) {          for(var i = 0; i < window.afiles[k].length; i++) {
             files.push(window.afiles[k][i]);
          }
      }
  }
  return files;
}

function getFiles(fa,num) {
     window.asel[num]=1;
     window.afiles[num]=fa;
     //alert(window.asel[0]+':'+window.asel[1]);

  var files=GreateFileList(fa);                       // �������� ������ FileList
  var output = document.getElementById('output');     // div, ���� ������������ ������� � ����������� � ������
  var table = document.createElement('table');        // ������� � �����������
  var tbody = document.createElement('tbody');        // � ����
  var row;                                            // ������ � ������������ � ����� (���������������� ������ ��� �����)
  var fr;                                             // FileReader (�������� ��� ������� �����)
  var file;                                           // ������ file �� FileList'a
  var data;                                           // ������ � ����������� � �����
  var img;
    //alert('1');

  output.innerHTML = '';                              // ������ ��������� � ��������


  table.appendChild(tbody);                           // �������� � ������� � ����
  //alert('2');
  tbody.innerHTML = "<b><tr><td>������</td><td>���</td><td>MIME ���</td><td>������ (����)</td></tr></b>";
  //alert('3');
  div = document.createElement('div')
  div.innerHTML = '<input type="hidden" name="count_file" value="'+files.length+'"/>';
  output.appendChild(div);

  for(var i = 0; i < files.length; i++) {             // ���������� ��� ����� � FileList'�
    file = files[i];

  if(/image.*/.test(file.type))                  // ���� � ����� ���������� �����������
  {  var URL = window.webkitURL || window.URL;
     if (URL) { img = document.createElement("img");
			    imageUrl = URL.createObjectURL(file);
                img.onload = (function(file, data,i)
			    {
			        do {}while (!img.complete)
                    /*
				    var s = img.width / img.height;
                    var a=128;
                    alert (img.width+'|'+img.height);
				    if(img.width > a && img.height > a) {				    	alert ('128');
					    if(img.width > img.height) {
					      img.width = a;
					      img.height = a / s;
					    } else {
					      img.height = a;
					      img.width = a * s;
					    }
				    }
				    */
				    img.width=128;
                    img.id='loc'+num;
                    img.src = img.src;

			        data = [file.name, file.type, file.size];
                    appendFileInfo(tbody,img,data,i);
                    //URL.revokeObjectURL(imageUrl);
			    })(file, data,i);
			    img.src = imageUrl;

     }

    // ���� �� �����������
    } else {
      //data = ['none',file.name, file.type, file.size];   // �� ������ ������ ������� ��������������� �������
      //appendFileInfo(tbody, data);
    }
  }
  output.appendChild(table);          // �������� ������� � ����������� � ����� � div
}

// ��������� ������������ �� ������� file API
if(window.File && window.FileReader && window.FileList && window.Blob) {
  onload = function () {
    // ������ ���������� �������, ������������� ��� ��������� input'�
    //alert('onload');
    //document.querySelector('input').addEventListener('change', onFilesSelect, false);
  }
} else {
  alert('� ��������� ��� ������� �� ������������ file API');
}