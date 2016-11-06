"use strict";
var indice=0;
slideShow(0);
function cambioSlide(n) {
    slideShow(indice += n);
}
function slideShow(n) {
    var i;
    var x = document.getElementsByClassName("slide");
    var lunghezza = x.length;
    if (n > lunghezza) {indice = 1}
    if (n < 1) {indice = lunghezza} ;
    for (i = 0; i < lunghezza; i++) {
        x[i].style.display = "none";
    }
    x[indice-1].style.display = "block";
}