"use strict";
var indice=0;
var tempo;
slideShow();
function slideShow() {
	
	var i;
	var x = document.getElementsByClassName("slide");
	var punti = document.getElementsByClassName("dot");
	var lunghezza = x.length;
	
	if (indice >= lunghezza) {indice = 0;}
	for (i = 0; i < lunghezza; i++) {
	    x[i].style.display = "none";
	}
	for (i = 0; i < punti.length; i++) {
	  punti[i].className = punti[i].className.replace(" active", "");
	}
	indice++;
	x[indice-1].style.display = "block";
	punti[indice-1].className += " active";
	clearTimeout(tempo);    
	tempo= setTimeout(slideShow, 2000);
}
function mobileMenu() {
    var x = document.getElementById("menu");
    if (x.className === "menu") {
        x.className += " mobile";
    } else {
        x.className = "menu";
    }
}

function dotCambia(n) {
	slideShow(indice=n);
	 
	 /*clearTimeout(tempo); ----> Cosi rimane fermo
  	 var i;
    var x = document.getElementsByClassName("slide");
    var punti = document.getElementsByClassName("dot");
    var lunghezza = x.length;
    if (n >= lunghezza) {n = 0;}
    for (i = 0; i < lunghezza; i++) {
        x[i].style.display = "none";
    }
    for (i = 0; i < punti.length; i++) {
      punti[i].className = punti[i].className.replace(" active", "");
	 }
	 n++;
    x[n-1].style.display = "block";
    punti[n-1].className += " active";*/
}