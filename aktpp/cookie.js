// name - имя cookie
// value - значение cookie
// [expires] - дата окончания действия 
//             cookie (по умолчанию - до конца сессии)
// [path] - путь, для которого cookie действительно
//          (по умолчанию - документ, в котором значение было установлено)
// [domain] - домен, для которого cookie действительно 
//           (по умолчанию - домен, в котором значение было установлено)
// [secure] - логическое значение, показывающее требуется ли 
//            защищенная передача значения cookie

function setCookie(name, value, expires, path, domain, secure) {
    if (expires) {
       var day =  new Date(new Date().getTime() + expires * 86400000);
    }
    var curCookie = name + "=" + escape(value) +
    ((expires) ? "; expires=" + day.toUTCString() : "") +
    ((path) ? "; path=" + path : "") +
    ((domain) ? "; domain=" + domain : "") +
    ((secure) ? "; secure" : "");
    if ((escape(value)).length <= 4000-10)
    document.cookie = curCookie;
    else
    if (confirm("Cookie превышает 4KB и будет вырезан !"))
    document.cookie = curCookie;
    //alert (curCookie);
}
function isValueInArr(value,arr){
    var ret=false;
    for (var i = 0; i < arr.length; i++) {
        if(arr[i]==value) {
            ret=true;
            break;
        }
    }
    return ret;
}
function DelValueArr(value,arr) {
    var arr1=[]; 
        for (var i = 0; i < arr.length; i++) {
          if(arr[i]!=value) arr1.push(arr[i]);
        }
    return arr1;
}

function AddToCookie(name, value, expires, path, domain, secure) {
    var curCookie =getCookie(name);
    var ret=0;
    if (curCookie) {
       //alert (curCookie);
       var arr = curCookie.split(',');  //join('-')
       if(isValueInArr(value,arr)==false) {
          arr.push(value); 
       }
       setCookie(name, arr.join(','), expires, path, domain, secure);
       ret=arr.length;
    } else { 
        setCookie(name, value, expires, path, domain, secure);
        ret=1;
    }    
    return ret;
}
function DelFromCookie(name, value, expires, path, domain, secure) {
    var curCookie =getCookie(name);
    var ret=0;
    if (curCookie) {
       //alert (curCookie);
       var arr = curCookie.split(',');  //join('-')
       if(isValueInArr(value,arr)==true) {
          arr=DelValueArr(value,arr);
          setCookie(name, arr.join(','), expires, path, domain, secure);
       }
       ret=arr.length;
    } 
    return ret;
}
//я вроде просто JS сохранил cookie (одну пока со временем до конца сессии)
function getCookie(name) {
    var prefix = name + "=";
    var cookieStartIndex = document.cookie.indexOf(prefix);
    if (cookieStartIndex == -1)
        return null;
    var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length);
    if (cookieEndIndex == -1)
        cookieEndIndex = document.cookie.length;
    return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex));
}
