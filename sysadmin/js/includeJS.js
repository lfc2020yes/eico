
function includeJS ( src ) { 
    var Elem = document.createElement('script'); 
    Elem.src = src; 
    document.getElementsByTagName('head')[0].appendChild( Elem ); 
} 

// includeJS ('scripts/demo.js'); 
