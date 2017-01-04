"use strict";

function check(){

	var risultato = true;

	if(document.getElementById("codeErr")){
		document.getElementById("codeErr").innerHTML = "";
		var id =document.getElementsByName("idIns")[0].value;
		if(id == ""){
			document.getElementById("codeErr").innerHTML = " *Il campo è obbligatorio";
			if(risultato)risultato = false;
		}
		else if(!(/^[a-zA-Z0-9_.-]+$/.test(id))){
			document.getElementById("codeErr").innerHTML = " *Codice non valido";
			if(risultato)risultato = false;
		}
	}
	

	if(document.getElementById("titoloErr")){
		document.getElementById("titoloErr").innerHTML = "";
		if(document.getElementsByName("titoloIns")[0].value == ""){
			document.getElementById("titoloErr").innerHTML = " *Il campo è obbligatorio";
			if(risultato)risultato = false;
		}
	}

	if(document.getElementById("autoErr")){
		document.getElementById("autoErr").innerHTML = "";
		if(document.getElementsByName("autoreIns")[0].value == ""){
			document.getElementById("autoErr").innerHTML = " *Il campo è obbligatorio";
			if(risultato)risultato = false;
		}
	}

	if(document.getElementById("isbnErr")){
		document.getElementById("isbnErr").innerHTML = "";
		var code = document.getElementsByName("isbnIns")[0].value;
		if(code == "" ){
			document.getElementById("isbnErr").innerHTML = " *Il campo è obbligatorio";
			if(risultato)risultato = false;
		}
		else if (!(/^([0-9]{13})+$/.test(code))) {
			document.getElementById("isbnErr").innerHTML = " *Il campo deve essere 13 caratteri numerici";
			if(risultato)risultato = false;
		}
	}

	if(document.getElementById("cognomeErr")){
		document.getElementById("cognomeErr").innerHTML = "";
		if(document.getElementsByName("cognomeIns")[0].value == ""){
			document.getElementById("cognomeErr").innerHTML = " *Il campo è obbligatorio";
			if(risultato)risultato = false;
		}
	}
	if(document.getElementById("nomeErr")){
		document.getElementById("nomeErr").innerHTML = "";
		if(document.getElementsByName("nomeIns")[0].value == ""){
			document.getElementById("nomeErr").innerHTML = " *Il campo è obbligatorio";
			if(risultato)risultato = false;
		}
	}
	if(document.getElementById("emailErr")){
		document.getElementById("emailErr").innerHTML = "";
		var mail = document.getElementsByName("emailIns")[0].value;
		if(mail == ""){
			document.getElementById("emailErr").innerHTML = " *Il campo è obbligatorio";
			if(risultato)risultato = false;
		}
		else if(!(/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/.test(mail))){
			document.getElementById("emailErr").innerHTML = " *Email non corretta";
			if(risultato)risultato = false;
		}
	}
	if(document.getElementById("nicknameErr")){
		document.getElementById("nicknameErr").innerHTML = "";
		var nick = document.getElementsByName("nicknameIns")[0].value;
		if(nick == ""){
			document.getElementById("nicknameErr").innerHTML = " *Il campo è obbligatorio";
			if(risultato)risultato = false;
		}
		else if(nick.length < 4){
			document.getElementById("nicknameErr").innerHTML = " *Il nickname troppo corto (minimo 4 caratteri)";
			if(risultato)risultato = false;
		}
		else if(nick.length > 12){
			document.getElementById("nicknameErr").innerHTML = " *Il nickname troppo lungo (massimo 12 caratteri)";
			if(risultato)risultato = false;
		}
		else if(!(/^[a-z0-9]+$/.test(nick))) {
			document.getElementById("nicknameErr").innerHTML = " *Il nickname può contenere solo lettere o numeri";
			if(risultato)risultato = false;
		}
	}
	if(document.getElementById("dataErr")){
		document.getElementById("dataErr").innerHTML = "";
		var data = document.getElementsByName("dataIns")[0].value;
		if(data == ""){
		}
		else if(!(/^([0-9]{2})[\/\-\.]([0-9]{2})[\/\-\.]([0-9]{4})+$/.test(data))){
			document.getElementById("dataErr").innerHTML = " *Data non corretta";
			if(risultato)risultato = false;
		}
	}
	if(document.getElementById("residenzaErr")){
		document.getElementById("residenzaErr").innerHTML = "";
		if(document.getElementsByName("residenzaIns")[0].value == ""){
			document.getElementById("residenzaErr").innerHTML = " *Il campo è obbligatorio";
		if(risultato)risultato = false;
		}
	}
	if(document.getElementById("passwordErr")){
		document.getElementById("passwordErr").innerHTML = "";
		var pass = document.getElementsByName("passwordIns")[0].value;
		if(pass == ""){
			document.getElementById("passwordErr").innerHTML = " *Il campo è obbligatorio";
			if(risultato)risultato = false;
		}
		else if(!(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,50}$/.test(pass))){
			document.getElementById("passwordErr").innerHTML = " *La password deve essere lunga almeno 8 caratteri e deve contenere almeno una lettera minuscola, una maiuscola e un numero";
			if(risultato)risultato = false;
		}
	}
	return risultato;
}