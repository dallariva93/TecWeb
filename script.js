"use strict";
function mobileMenu() {
    var x = document.getElementById("menu");
    if (x.className === "menu") {
        x.className += " mobile";
    } else {
        x.className = "menu";
    }
}