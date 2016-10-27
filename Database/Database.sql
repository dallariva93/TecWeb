SET foreign_key_checks = 0;

/* PULIZIA DATABASE */

DROP FUNCTION IF EXISTS Sposta_In_Letti;

DROP TRIGGER IF EXISTS Incongruenza;

DROP TABLE IF EXISTS Utente;
DROP TABLE IF EXISTS Scrittore;
DROP TABLE IF EXISTS Libro;
DROP TABLE IF EXISTS Recensione;
DROP TABLE IF EXISTS Redazione;
DROP TABLE IF EXISTS DaLeggere;
DROP TABLE IF EXISTS Letti;
DROP TABLE IF EXISTS Commento;
DROP TABLE IF EXISTS Amicizia;


/* TABELLE */

CREATE TABLE Utente
(	Email	varchar (20) PRIMARY KEY,
	Nome	varchar(20) NOT NULL,
	Cognome	varchar(20) NOT NULL,
	Nickname	varchar(20) NOT NULL,
	Data_Nascita	date NOT NULL,	
	Password varchar(20) NOT NULL,
	Residenza	varchar(10) 
);

CREATE TABLE Scrittore
(	Id varchar(20) PRIMARY KEY,
	Nome	varchar(20) NOT NULL,
	Cognome	varchar(20) NOT NULL,
	Data_Nascita	date NOT NULL,
	Nazionalita	varchar(20) NOT NULL
);

CREATE TABLE Libro
(	ISBN varchar(13) PRIMARY KEY,
	Titolo	varchar(20) NOT NULL,
	Autore	varchar(20) NOT NULL,
	Anno_Pubblicazione	date NOT NULL,
	Casa_Editrice	varchar (20) NOT NULL,
	Genere enum('Commedia','Horror','Fantasy','Narrativa','Saggistica','Classico','Thriller','Fantascienza','Carta da fuoco') NOT NULL,
	FOREIGN KEY (Autore) REFERENCES Scrittore(Id)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Recensione
(	Id	varchar(20)	PRIMARY KEY,
	Libro varchar(13),
	Autore varchar(20),
	Data_Pubblicazione	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Valutazione enum('1','1,5','2','2,5','3','3,5','4','4,5','5'),
	Testo	text,
	FOREIGN KEY (Autore) REFERENCES Redazione(Email)
  	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Libro) REFERENCES Libro(ISBN)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Redazione
(	Email	varchar (20) PRIMARY KEY,
	Nome	varchar(10) NOT NULL,
	Cognome	varchar(10) NOT NULL
	
);

CREATE TABLE Commento
(	Recensione varchar(20),
	Autore varchar(20),
	Commento text(2000),
	Data_Pubblicazione	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
	PRIMARY KEY (Recensione, Autore, Data_Pubblicazione),
	FOREIGN KEY (Autore) REFERENCES Utente(Email)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Recensione) REFERENCES Recensione(Id)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Amicizia
(	Persona1	varchar(20),
	Persona2	varchar(20),
	PRIMARY KEY(Persona1,Persona2),
	FOREIGN KEY (Persona1) REFERENCES Utente(Email)
    	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Persona2) REFERENCES Utente(Email)
    	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE DaLeggere
(	Utente	varchar(20),
	Libro	varchar(13),
	PRIMARY KEY(Utente,Libro),
	FOREIGN KEY (Utente) REFERENCES Utente(Email)
    	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Libro) REFERENCES Libro(ISBN)
    	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Letti
(	Utente	varchar(20),
	Libro	varchar(13),
	PRIMARY KEY(Utente,Libro),
	FOREIGN KEY (Utente) REFERENCES Utente(Email)
    	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Libro) REFERENCES Libro(ISBN)
    	ON DELETE CASCADE
	ON UPDATE CASCADE
);

/* FUNZIONI */

DELIMITER $

CREATE FUNCTION Sposta_In_Letti(utente_dato varchar (20), libro_dato varchar(13))
RETURNS BOOL
BEGIN
	DECLARE Risultato BOOl;
	SET Risultato = false;
	IF EXISTS ( SELECT * FROM DaLeggere WHERE Utente = utente_dato && Libro = libro_dato)
	THEN
			INSERT INTO Letti VALUES ( utente_dato, libro_dato );
			DELETE FROM DaLeggere WHERE Utente = utente_dato && Libro = libro_dato;
			SET Risultato = true;
	END IF;
	RETURN Risultato;
END$

CREATE TRIGGER Incongruenza BEFORE INSERT ON Amicizia
FOR EACH ROW
BEGIN
	IF (NEW.Persona1 = NEW.Persona2)
	THEN
		SIGNAL SQLSTATE '45000'
    		SET MESSAGE_TEXT = "Si sta cercando di inserire la stessa persona";
	END IF;
END$
DELIMITER ;

SET foreign_key_checks = 1;
