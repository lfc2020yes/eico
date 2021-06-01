

function toArray(list) {
  return Array.prototype.slice.call(list || [], 0);
}

function listResults(entries) {
  var fragment = document.createDocumentFragment();

  entries.forEach(function(entry, i) {
    var img = entry.isDirectory ? '<img src="folder-icon.gif">' :
                                  '<img src="file-icon.gif">';
    var li = document.createElement('li');
    li.innerHTML = [img, '<span>', entry.name, '</span>'].join('');
    fragment.appendChild(li);
  });

  document.querySelector('#filelist').appendChild(fragment);
}

// ----------------------------------- Проверяем поддержку File API
	if (window.File && window.FileReader && window.FileList && window.Blob) {
	  // Работает
	   //alert('yes API');
       onload = function () {
          //alert('onload');
          window.RequestFileSystem = window.requestFileSystem || window.webkitRequestFileSystem;
              //window.mozRequestFileSystem;
          window.RequestFileSystem(window.PERSISTENT, 5*1024*1024 /*5MB*/, onInitFs, errorHandler);
       }

	} else {
	  alert('File API не поддерживается данным браузером');
	}

 function onInitFs(fs) {                  //sandbox

     console.log('Opened file system: ' + fs.name);
                         //Documents and Settings\NUMERUS\Documents\Мои рисунки\AtSUN\Крым\Ялта\Аквамарин  //create: true
     var dir = 'sandbox';

     fs.root.getDirectory('sandbox', {create: true}, function(dirEntry) {
          console.log('You have just created the ' + dirEntry.name + ' directory.');
     }, errorHandler);

     /*
     function createDir(rootDir, folders) {
        rootDir.getDirectory(folders[0], {create: true},function(dirEntry) {
          console.log('You have just created the ' + dirEntry.name + ' directory.');
          if (folders.length) {
              createDir(dirEntry, folders.slice(1));
              console.log('Created the ' + dirEntry.name + ' directory.');
          }
        }, errorHandler);
     };
     */
     //createDir(fs.root, dir+'/Images/Nature/Sky/'.split('/'));

/*
     fs.root.getDirectory( '', {create: false},
        function(dirEntry){
		  var dirReader = dirEntry.createReader();
		  dirReader.readEntries(function(entries) {
		    for(var i = 0; i < entries.length; i++) {
		      var entry = entries[i];
		      if (entry.isDirectory){
		        console.log('Directory: ' + entry.fullPath);
		      }
		      else if (entry.isFile){
		        console.log('File: ' + entry.fullPath);
		      }
		    }

		  }, errorHandler
	      );
	}, errorHandler
	);
*/

 /*
  var dirReader = fs.root.createReader();
  var entries = [];

  var readEntries = function() {
      dirReader.readEntries (function(results) {
	      if (!results.length) {
	        listResults(entries.sort());
	      } else {
	        entries = entries.concat(toArray(results));
	        readEntries();
	      }
      }, errorHandler);
  };

  readEntries();
  */
 }


function errorHandler(err){
 var ee=err;
 /*
 var msg = 'An error occured: ';

  switch (err.name) {
    case FileError.NOT_FOUND_ERR:
      msg = 'File or directory not found';
      break;

    case FileError.NOT_READABLE_ERR:
      msg = 'File or directory not readable';
      break;

    case FileError.PATH_EXISTS_ERR:
      msg = 'File or directory already exists';
      break;

    case FileError.TYPE_MISMATCH_ERR:
      msg = 'Invalid filetype';
      break;

    case FileError.QUOTA_EXCEEDED_ERR:
      msg = 'QUOTA_EXCEEDED_ERR';
      break;
    case FileError.SECURITY_ERR:
      msg = 'SECURITY_ERR';
      break;
    case FileError.INVALID_MODIFICATION_ERR:
      msg = 'INVALID_MODIFICATION_ERR';
      break;
    case FileError.INVALID_STATE_ERR:
      msg = 'INVALID_STATE_ERR';
      break;

    default:
      msg = 'Unknown Error';
      break;
  };
  */
 //console.log('Error: ' +msg+'|'+err.code);
 alert('Error: '/*+err.code*/+'|'+err.name+'|'+err.message);
 console.log('Error: '+err.name+'|'+err.message);
};


