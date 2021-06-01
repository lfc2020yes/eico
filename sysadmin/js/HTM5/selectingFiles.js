/*
function addFiles(files) {
   //alert ('typeof ff:'+ (typeof ff));
   for(var i = 0; i < files.length; i++) {             // Перебираем все файлы в FileList'е
     full.files.push(files[i]);
   }

   full.files=full.files.concat(files);
   alert ('files='+full.files.length);
}
*/

/*
 * Функция для добавления строки (<tr>),
 * содержащей информацию о файле
 * в тело таблицы (tbody)
 */

function appendFileInfo(tbody, data,num) {
  var tr = document.createElement('tr');
  var td;
  var div;
    for(var j = 0; j < data.length; j++) {
      td = document.createElement('td');
      td.innerHTML = '<div name="'+num+'_'+j+'">'+(data[j] || 'неизвестно')+'</div>';
      tr.appendChild(td);
    }
    tbody.appendChild(tr);
    div = document.createElement('div')
    div.innerHTML = '<input type="hidden" name="file_'+num+'"value="'+data[1]+'|'+data[2]+'|'+data[3+'|'+data[4]]+'"/>';
    output.appendChild(div);

  return tbody;
}

/*
 * Функция для создания превью т.е
 * определение его размеров
 * по исходным размером изображения
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
 * Эту функцию мы будем вызывать при изменении (onchange)
 * input'а т.е. когда пользователь выберет файлы.
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

  var files=GreateFileList(fa);                       // получаем объект FileList
  var output = document.getElementById('output');     // div, куда помещаятется таблица с информацией о файлах
  var table = document.createElement('table');        // таблица с информацией
  var tbody = document.createElement('tbody');        // её тело
  var row;                                            // строка с информациейф о файле (Перезаписывается каждый шаг цикла)
  var fr;                                             // FileReader (Создаётся для каждого файла)
  var file;                                           // объект file из FileList'a
  var data;                                           // массив с информацией о файле
  var div;
    //alert('1');

  output.innerHTML = '';                              // Чистим контейнер с таблицей


  table.appendChild(tbody);                           // Втавляем в таблицу её тело
  //alert('2');
  tbody.innerHTML = "<b><tr><td>Превью</td><td>Имя</td><td>MIME тип</td><td>Размер (байт)</td></tr></b>";
  //alert('3');
  div = document.createElement('div')
  div.innerHTML = '<input type="hidden" name="count_file" value="'+files.length+'"/>';
  output.appendChild(div);

  for(var i = 0; i < files.length; i++) {             // Перебираем все файлы в FileList'е
    file = files[i];

    if(/image.*/.test(file.type)) {                 // Если в файле содержится изображение
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


      fr.readAsDataURL(file);                       // считываем его в строку base64
      fr.onload = (function (file, data,i) {          // как только файл загружен
        return function (e) {
          var img = new Image();
          img.src = e.target.result;

          /*
           * и как только загружено изображение
           * добавляем в информацию о файле html-код первьюшки
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
    // Если не изображение
    } else {
      //data = ['none',file.name, file.type, file.size];   // то вместо превью выводим соответствующею надпись
      //appendFileInfo(tbody, data);
    }
  }
  output.appendChild(table);          // помещаем таблицу с информацией о файле в div
}

// проверяем поддерживает ли браузер file API
if(window.File && window.FileReader && window.FileList && window.Blob) {
  onload = function () {
    // вешаем обработчик события, срабатывающий при изменении input'а
    //alert('onload');
    //document.querySelector('input').addEventListener('change', onFilesSelect, false);
  }
} else {
  alert('К сожалению ваш браузер не поддерживает file API');
}