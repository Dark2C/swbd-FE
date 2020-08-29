# FRONTEND per esame di SWBD

Il frontend fornisce un'interfaccia WEB user-friendly per l'utilizzo delle API implementate nek server REST (quest'ultimo disponibile nel repository swbd-API).


## Guida per l'installazione
### Step 1: Predisporre un web server con sopra installato l'interprete PHP (è sufficiente installare il pacchetto XAMPP)

### Step 2: Clonare il repository corrente nella root del server
user@localhost:\~$ cd /var/www/html
user@localhost:\~/var/www/html/$ git clone https://github.com/Dark2C/swbd-FE .

### Step 3: Modifica il file config.php con le impostazioni della tua configurazione
Ti sarà richiesto di indicare l'indirizzo del server REST e una chiave API per l'utilizzo dei servizi di Google Maps.
Per quest'ultima, visita https://developers.google.com/maps/documentation/javascript/get-api-key per maggiori informazioni.

### Il frontend sarà accessibile con le credenziali di default (admin:admin)

Enjoy!