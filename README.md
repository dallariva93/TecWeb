# TecWeb

Titolo: ----

Nome Gruppo: ---

###!! Questo file può essere ampliato se qualcuno nota che manca qualcosa !!

#N.B.
 
Validare **SEMPRE** tutti i documenti (html, css, ecc), esistono siti apposta per farlo (es. w3c validator)

(Per approfondimenti vedere slide!!)

##Regole:
- avvertire tutti i membri del gruppo prima di ogni modifica
- rispettate i gusti della gaggi e le specifiche anche se pensate non abbiano senso

##Bug noti:
- ~~Breadcrump: non responsive( non si allontana dal menu senza dargli la distanza e non si ridimensiona a seconda della grandezza degli elementi interni)~~
- ~~Menu: in vista mobile, accedi e iscriviti non prendono il colore di sfondo del menu~~
- Mobile: manca tutta la gestione per gli schermi piccoli
- ~~Classe content non colora lo sfondo~~

##Specifiche:

Si richiede la progettazione e lo sviluppo di un sito web con contenuto a scelta dello studente ma che rispetti le seguenti caratteristiche:

- il sito web deve essere realizzato con lo standard XHTML Strict, eventuali pagine in HTML5 sono permesse, 
ma queste devono degradare in modo elegante;
- il layout deve essere realizzato con CSS puri;
- il sito web deve rispettare la completa separazione tra contenuto, presentazione e comportamento
- il sito web deve essere accessibile a tutte le categorie di utenti;
- il sito web deve organizzare i propri contenuti in modo da poter essere facilmente reperiti 
da qualsiasi utente;
- il sito web deve contenere pagine che utilizzino gli script per collezionare e pubblicare dati 
inseriti dagli utenti;
- i dati inseriti dagli utenti devono essere salvati in un database;
- è preferibile che il database sia in forma normale.

Il progetto deve essere accompagnato da una relazione che ne illustri le fasi di progettazione, realizzazione e test ed evidenzi il ruolo svolto dai 
singoli componenti del gruppo.

Viene richiesta un'analisi iniziale delle caratteristiche degli utenti che il sito si propone di raggiungere. Le pagine web devono essere accessibili 
indipendentemente dal browser e dalle dimensioni dello schermo del dispositivo degli utenti. 
Considerazioni riguardanti diversi dispositivi (laddove possibile) verranno valutate 
positivamente.

##Idea generale:

- i libri nel sito possono essere visti in 2 categorie: libri recensiti e libri non 
 ancora recensiti perchè sono appena usciti. Entrambe le categorie hanno una trama del libro

- le recensioni sono scritte solo dalla redazione

- gli utenti possono crearsi un account per commentare e/o valutare un libro o per valutare una recensione
 (niente gestione delle amicizie o della libreria personale)

- sono presenti anche notizie (news) riguardo ai libri, queste non sono le uscite del mese(gestite a parte)
 ma sono più contenuti che possono interessare l'utente

##Proposte:
1. sondaggi


##Pagine necessarie:

1. Index [ ]	
	- [X] HTML
	- [ ] CSS
	- [ ] PHP
	- [ ] JS
	
2. News [ ]
	- [ ] HTML
	- [ ] CSS
	- [ ] PHP
	- [ ] JS
3. Recensioni [E]
	- [X] HTML
	- [ ] CSS
	- [ ] PHP
	- [ ] JS
4. Classifica [ ]
	- [ ] HTML
	- [ ] CSS
	- [ ] PHP
	- [ ] JS
5. Contatti [E]
	- [X] HTML
	- [ ] CSS
	- [ ] PHP
	- [ ] JS
6. Accesso [G]
	- [X] HTML
	- [X] CSS
	- [ ] PHP
	- [ ] JS
7. Iscrizione [G]
	- [X] HTML
	- [ ] CSS
	- [ ] PHP
	- [ ] JS
8. Pagina utente [G]
	- [X] HTML
	- [ ] CSS
	- [ ] PHP
	- [ ] JS
9. Pagina libro/recensione + commenti [L ]
	- [X] HTML
	- [ ] CSS
	- [ ] PHP
	- [ ] JS
10. Pagina autore [L ]
	- [X] HTML
	- [ ] CSS
	- [ ] PHP
	- [ ] JS
11. Pagina amministrazione [A ]
	- [X] HTML
	- [ ] CSS
	- [ ] PHP
	- [ ] JS

	A: Andrea
	
	E: Edoardo
	
	I: Isacco
	
	G: Giovanni
	
	L: Luca

##Accessibilità:

Principi:

1. Trasformazione elegante:

	* separare struttura dalla presentazione

	* Fornire sempre un’equivalente testuale per ogni media diverso dal testo: il testo può 
	 essere riprodotto secondo modalità accessibili a quasi tutti gli utenti

	* Creare documenti che veicolino l’informazione anche se l’utente non può vedere o sentire: 
	 fornire informazioni attraverso diversi canali sensoriali alternativi

	* Creare documenti che non necessitino di un hw specifico: 
	 le pagine dovrebbero essere utilizzabili anche senza 
	 le pagine dovrebbero essere utilizzabili anche senza 
	 mouse, con piccoli schermi, a bassa risoluzione, in bianco 
	 e nero, oppure senza schermo attraverso output di voce o 
	 testo

2. Contenuto comprensibile e navigabile

	* Dotare la pagina di strumenti di navigazione ed orientamento

	* Considerare strumenti ed informazioni di orientamento per utenti non vedenti

###Breakpoint:

* 320 pixel   Piccoli schermi, telefoni usati in modalità portrait

* 480 pixel   Piccoli schermi, telefoni usati in modalità landscape
* 600 pixel   Piccoli tablet, (Amazon kindle) usati in modalità portrait
* 768 pixel   Tablet da 10 pollici(iPad 1024x768) usati in modalità portrait

* 1024 pixel  Tablet (iPad) usati in modalità landscape, piccoli desktop o portatili, in generale una finestra che non occupa tutto lo schermo in un qualsiasi schermo

* 1200 pixel Schermi grandi,pensato per computer ad alta definizione e/o desktop
