SET foreign_key_checks = 0;
DROP TABLE IF EXISTS Utente;
CREATE TABLE Utente
(	Id varchar(8) PRIMARY KEY,
	Nome	varchar(20) NOT NULL,
	Cognome	varchar(20) NOT NULL,
	Nickname	varchar(20) NOT NULL,
	Data_Nascita	date NOT NULL,
	Email	varchar (20) NOT NULL,
/*  Password varchar(20) NOT NULL ??*/
	Residenza	varchar(10) 
);
DROP TABLE IF EXISTS Scrittore;
CREATE TABLE Scrittore
(	Id varchar(20) PRIMARY KEY,
	Nome	varchar(20) NOT NULL,
	Cognome	varchar(20) NOT NULL,
	Data_Nascita	date NOT NULL,
	Nazionalita	varchar(20) NOT NULL
);
DROP TABLE IF EXISTS Libro;
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
DROP TABLE IF EXISTS Recensione;
CREATE TABLE Recensione
(	Id	varchar(20)	PRIMARY KEY,	
	Libro varchar(13),
	Autore varchar(8),
	Data_Pubblicazione	date NOT NULL,
	Ora_Pubblicazione	time NOT NULL,
	Valutazione enum('1','2','3','4','5'),
	Testo	text,
	FOREIGN KEY (Autore) REFERENCES Redazione(Id)
  	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Libro) REFERENCES Libro(Id)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);
DROP TABLE IF EXISTS Redazione;
CREATE TABLE Redazione
(	Id varchar(8) PRIMARY KEY,
	Nome	varchar(10) NOT NULL,
	Cognome	varchar(10) NOT NULL,
	Email	varchar (15) NOT NULL
);
DROP TABLE IF EXISTS Commento;
CREATE TABLE Commento
(	Recensione varchar(20),
	Autore varchar(8),
	Data_Pubblicazione	date NOT NULL,
	Commento text(2000),
	FOREIGN KEY (Autore) REFERENCES Utente(Id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Recensione) REFERENCES Recensione(Id)
    	ON DELETE CASCADE
	ON UPDATE CASCADE
);
DROP TABLE IF EXISTS Amicizia;
CREATE TABLE Amicizia
(	Persona1	varchar(8),
	Persona2	varchar(8),
	PRIMARY KEY(Persona1,Persona2),
	FOREIGN KEY (Persona1) REFERENCES Utente(Id)
    	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Persona2) REFERENCES Utente(Id)
    	ON DELETE CASCADE
	ON UPDATE CASCADE
);
DROP TABLE IF EXISTS DaLeggere;
CREATE TABLE DaLeggere
(	Utente	varchar(8),
	Libro	varchar(13),
	PRIMARY KEY(Utente,Libro),
	FOREIGN KEY (Utente) REFERENCES Utente(Id)
    	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Libro) REFERENCES Libro(ISBN)
    	ON DELETE CASCADE
	ON UPDATE CASCADE
);
DROP TABLE IF EXISTS Letti;
CREATE TABLE Letti
(	Utente	varchar(8),
	Libro	varchar(13),
	PRIMARY KEY(Utente,Libro),
	FOREIGN KEY (Utente) REFERENCES Utente(Id)
    	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Libro) REFERENCES Libro(ISBN)
    	ON DELETE CASCADE
	ON UPDATE CASCADE
);
SET foreign_key_checks = 1;
