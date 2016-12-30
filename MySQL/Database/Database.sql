SET foreign_key_checks = 0;

/* PULIZIA DATABASE */

DROP TABLE IF EXISTS Utente;
DROP TABLE IF EXISTS Scrittore;
DROP TABLE IF EXISTS Libro;
DROP TABLE IF EXISTS Recensione;
DROP TABLE IF EXISTS Redazione;
DROP TABLE IF EXISTS Commenti;
DROP TABLE IF EXISTS VotoRecensione;
DROP TABLE IF EXISTS VotoLibro;
DROP TABLE IF EXISTS Notizie;

/* TABELLE */

CREATE TABLE Utente
(	Email	varchar (40) PRIMARY KEY,
	Nome	varchar(30) NOT NULL,
	Cognome	varchar(30) NOT NULL,
	Nickname	varchar(20) UNIQUE NOT NULL,
	Data_Nascita	date NOT NULL,	
	Password varchar(20) NOT NULL,
	Residenza	varchar(30) 
);

CREATE TABLE Scrittore
(	Id varchar(20) PRIMARY KEY,
	Nome	varchar(30) NOT NULL,
	Cognome	varchar(30) NOT NULL,
	Data_Nascita	date NOT NULL,
	Nazionalita	varchar(30) NOT NULL
);

CREATE TABLE Libro
(	ISBN varchar(13) PRIMARY KEY,
	Titolo	varchar(80) NOT NULL,
	Autore	varchar(20) NOT NULL,
	Anno_Pubblicazione	date NOT NULL,
	Casa_Editrice	varchar (20) NOT NULL,
	Genere enum('Commedia','Horror','Fantasy','Narrativa','Saggistica','Classico','Thriller','Fantascienza','Carta da fuoco') NOT NULL,
	Trama text NOT NULL,
	FOREIGN KEY (Autore) REFERENCES Scrittore(Id)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Recensione
(	Id	varchar(20)	PRIMARY KEY,
	Libro varchar(13) NOT NULL,
	Autore varchar(40) NOT NULL,
	Data_Pubblicazione	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	Valutazione enum('1','1,5','2','2,5','3','3,5','4','4,5','5') NOT NULL,
	Testo	text NOT NULL,
	FOREIGN KEY (Autore) REFERENCES Redazione(Email)
  	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Libro) REFERENCES Libro(ISBN)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Redazione
(	Email	varchar (40) PRIMARY KEY,
	Password varchar(20) NOT NULL,
	Nome	varchar(30) NOT NULL,
	Cognome	varchar(30) NOT NULL
	
);

CREATE TABLE Commenti
(	Recensione varchar(20),
	Autore varchar(40),
	Commento text(3000) NOT NULL,
	Data_Pubblicazione	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (Recensione, Autore, Data_Pubblicazione),
	FOREIGN KEY (Autore) REFERENCES Utente(Email)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Recensione) REFERENCES Recensione(Id)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE VotoRecensione
(	Recensione varchar(20),
	Autore varchar(40),
	Valutazione enum('1','1,5','2','2,5','3','3,5','4','4,5','5') NOT NULL,
	PRIMARY KEY (Recensione, Autore),
	FOREIGN KEY (Autore) REFERENCES Utente(Email)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Recensione) REFERENCES Recensione(Id)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);
CREATE TABLE VotoLibro
(	Libro varchar(13),
	Autore varchar(40),
	Valutazione enum('1','1,5','2','2,5','3','3,5','4','4,5','5') NOT NULL,
	PRIMARY KEY (Libro, Autore),
	FOREIGN KEY (Autore) REFERENCES Utente(Email)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Libro) REFERENCES Libro(ISBN)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Notizie
(	Id varchar(20) PRIMARY KEY,
	Titolo varchar(90),
	Autore varchar(40),
	Data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Testo text,
	FOREIGN KEY (Autore) REFERENCES Redazione(Email)
	ON DELETE CASCADE
	ON UPDATE CASCADE
);

LOAD DATA INFILE '../../../lampp/htdocs/Test/TecWeb/MySQL/Database/Dati/libri.txt' INTO TABLE Libro;
LOAD DATA INFILE '../../../lampp/htdocs/Test/TecWeb/MySQL/Database/Dati/scrittore.txt' INTO TABLE Scrittore;
LOAD DATA INFILE '../../../lampp/htdocs/Test/TecWeb/MySQL/Database/Dati/utenti.txt' INTO TABLE Utente;
LOAD DATA INFILE '../../../lampp/htdocs/Test/TecWeb/MySQL/Database/Dati/recensioni.txt' INTO TABLE Recensione;
LOAD DATA INFILE '../../../lampp/htdocs/Test/TecWeb/MySQL/Database/Dati/commenti.txt' INTO TABLE Commenti;
LOAD DATA INFILE '../../../lampp/htdocs/Test/TecWeb/MySQL/Database/Dati/notizie.txt' INTO TABLE Notizie;
SET foreign_key_checks = 1;
