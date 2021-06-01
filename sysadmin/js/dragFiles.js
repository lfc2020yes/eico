  // Проверяем поддерживает ли браузер drag and drop
  if('ondrop' in document.createElement('div')) {
    if (atr=='photo') {
    onload = function () {
      //alert('onload-drop');

      var dropZone = document.getElementById('dropZone');

      asel = [0, 0];
      afiles = [0, 0];

      full = document.getElementById('file');    //input
      if (full.files.length>0) {                     //Это обновление страницы
          getFiles(full.files,0);
      }

      /*
       * Обработчик, срабатывающий, когда курсор с
       * перетаскиваем объектом оказывается над dropZone
       */

      dropZone.addEventListener('dragover', function (e) {

        e.stopPropagation();                    // Останавливаем всплытие события
        e.preventDefault();                     // останавливаем действие по умолчанию, связанное с эти событием.
        e.dataTransfer.dropEffect = 'copy';
        //dropZone.addClass('hover');
      }, false);

      /*
       * Обработчик, срабатывающий, когда мы
       * бросаем перетаскиваемые файлы в dropZone
       */

      dropZone.addEventListener('drop', function (e) {

        //e.stopPropagation();
         //dropZone.removeClass('hover');
        e.preventDefault();
        getFiles(e.dataTransfer.files,1);
        /*
        var files = e.dataTransfer.files, info = '', file;

        for(var i = 0; file = files[i]; i++) {
          info += [file.name, '(', file.type, ')', '-', file.size, 'байт'].join(' ') + '\n';
        }

        alert(info);
        */
      }, false);
    }
    } //atr
  } else {
    alert("браузер не поддерживает Drag&Drop(");
  }
