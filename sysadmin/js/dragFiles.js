  // ��������� ������������ �� ������� drag and drop
  if('ondrop' in document.createElement('div')) {
    if (atr=='photo') {
    onload = function () {
      //alert('onload-drop');

      var dropZone = document.getElementById('dropZone');

      asel = [0, 0];
      afiles = [0, 0];

      full = document.getElementById('file');    //input
      if (full.files.length>0) {                     //��� ���������� ��������
          getFiles(full.files,0);
      }

      /*
       * ����������, �������������, ����� ������ �
       * ������������� �������� ����������� ��� dropZone
       */

      dropZone.addEventListener('dragover', function (e) {

        e.stopPropagation();                    // ������������� �������� �������
        e.preventDefault();                     // ������������� �������� �� ���������, ��������� � ��� ��������.
        e.dataTransfer.dropEffect = 'copy';
        //dropZone.addClass('hover');
      }, false);

      /*
       * ����������, �������������, ����� ��
       * ������� ��������������� ����� � dropZone
       */

      dropZone.addEventListener('drop', function (e) {

        //e.stopPropagation();
         //dropZone.removeClass('hover');
        e.preventDefault();
        getFiles(e.dataTransfer.files,1);
        /*
        var files = e.dataTransfer.files, info = '', file;

        for(var i = 0; file = files[i]; i++) {
          info += [file.name, '(', file.type, ')', '-', file.size, '����'].join(' ') + '\n';
        }

        alert(info);
        */
      }, false);
    }
    } //atr
  } else {
    alert("������� �� ������������ Drag&Drop(");
  }
