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
 */

function appendFileInfo(tbody, data,num) {
  var tr = document.createElement('tr');
  var td;
  var div;
    for(var j = 0; j < data.length; j++) {
      td = document.createElement('td');
      td.innerHTML = '<div name="'+num+'_'+j+'">'+(data[j] || '����������')+'</div>';
      tr.appendChild(td);
    }
    tbody.appendChild(tr);
    div = document.createElement('div')
    div.innerHTML = '<input type="hidden" name="file_'+num+'"value="'+data[1]+'|'+data[2]+'|'+data[3+'|'+data[4]]+'"/>';
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
  var div;
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

    if(/image.*/.test(file.type)) {                 // ���� � ����� ���������� �����������
      fr = new FileReader();

                //================================================================
            var URL = window.URL || window.webkitURL;
		    var imageUrl;
		    var image;

			if (URL) {
			    imageUrl = URL.createObjectURL(file);
			    context = document.createElement("");
			    img = document.createElement("img");
			    img.onload =
			    function(file, data,i)
			    {
			        URL.revokeObjectURL(imageUrl);
			        context.drawImage(img, 100, 100);
			    };
			    image.src = imageUrl;


			    document.body.appendChild(image);
			}

                //================================================================


      fr.readAsDataURL(file);                       // ��������� ��� � ������ base64
      fr.onload = (function (file, data,i) {          // ��� ������ ���� ��������
        return function (e) {
          var img = new Image();
          img.src = e.target.result;

          /*
           * � ��� ������ ��������� �����������
           * ��������� � ���������� � ����� html-��� ���������
           */
          /*
          if(img.complete) {
            img = makePreview(img, 128);
            data = ['<img src="' + img.src + '" width=' + img.width + '" height="' + img.height + '" />'
                   ,file.name, file.type, file.size, file.tmp_name];
            appendFileInfo(tbody, data,i);
          } else */
           {
            img.onload =  function () {
              img = makePreview(img, 128);
               data = ['<img src="' + img.src + '" width=' + img.width + '" height="' + img.height + '" />'
                   ,file.name, file.type, file.size, i];
              appendFileInfo(tbody, data,i);
            }
          }

        }
      }) (file, data);
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