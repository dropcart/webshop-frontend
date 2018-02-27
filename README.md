# Dropcart Webshop
See also [https://dropcart.github.io/webshop-frontend](https://dropcart.github.io/webshop-frontend).

Zie ook [https://dropcart.github.io/webshop-frontend](https://dropcart.github.io/webshop-frontend).


- [**English**](#english)
   - [Installation](#installation)
   - [Configuration](#configuration)
- [**Nederlands**](#nederlands)
   - [Installatie](#installatie)
   - [Configuratie](#configuratie)

## English
Are you looking for the PHP Client? Please visit the [Dropcart PHP Client repository](https://gitbub.com/dropcart/php-client)

Dropcart makes it extremely easy setting up an online shop. All orders, payments and invoices are created and 
processed automatically. There is no need for for pushing the order manually to a wholesaler, or to create a 
package slip, or whatever.

This repository contains an fully functional, but basic PHP / HTML implementation of Dropcart.
  
  
### Installation

1. Download latest version of this repository: [https://github.com/dropcart/webshop-frontend/archive/master.zip](https://github.com/dropcart/webshop-frontend/archive/master.zip)
2. Upload (via (S)FTP) the (extracted) files to your server.
3. There is a folder `public` in the .zip file, the contents of this folder need to be placed in your webroot folder. 
   Sometimes this folder is called `public_html` or `htdocs`. The other files and folders need to be placed right outside 
   the webroot directory.
4. Create the folder `templates/compilation_cache` when it doesn't exist. And chmod it to 777.


### Configuration

First copy the file `config/config.php.example` and rename it to `config/config.php`. Change the values in the file to your demands. 
Please check at least the emphasized options, those are mandatory.

| **NAME** | **DESCRIPTION** |
| ---------| --------------- |
| APP_ENV | The environment the app will be installed on. Normally you can leave this to 'live' |
| APP_DEBUG | When this value is set to 'true' it will output technical debug information on errors. This is not desired in production. Leave it to 'false' |
| APP_TIMEZONE | The timezone where you operate. CET = central eastern time. |
| APP_LOCALE | This configuration is in preparation to multilingual support. For now 'NL' is fine. |
|    |   |
| **DROPCART_KEY** | Here you have to paste your Dropcart public key. Please login to the management console and you'll find it in the settings of your store |
| **DROPCART_SECRET** |  Please paste your Dropcart secret here. |
| DROPCART_ENDPOINT | You can change the REST endpoint here. Normally you'll use: 'https://rest-api.dropcart.nl/v3' |
| TIMEOUT | This is the max amount of time a request to the Dropcart servers may take. 5.0 is a good max amount |
|      |    |
| **SITE_NAME** | Set you desired store name. |
| **SITE_SLUG** | Set the slogan of your store or leave empty when you don't use a slogan |
| BASE_URL | This is used when your assets live on an other domain. Normally '/' is sufficient |
| MULTILINGUAL | Don't do anything for now. So 'false' is fine |
| COUNTRIES | Don't do anything for now. So 'Nederland' is fine |
|   |   |
| TEMPLATE_PATH | Change only when you know what you're doing. The path to the Twig templates. |
| CACHE_PATH |  Change only when you know what you're doing. The path to the Twig cache. |
| AUTO_RELOAD | Change only when you know what you're doing. Whether Twig uses auto reloading |
 
### License
This code is published under the MIT license.

### Support
Please file an GitHub issue when there are errors in this code.

When failing to install please contact us: [info@dropcart.nl](mailto:info@dropcart.nl)

## Nederlands

Ben je op zoek naar de PHP Client? Bezoek de [Dropcart PHP Client repository](https://gitbub.com/dropcart/php-client)

Met Dropcart is het opzetten van een webshop bijzonder eenvoudig. Alle bestellingen, betalingen en facturen worden automatisch aangemaakt en verwerkt. Het is dus niet meer nodig om handmatig een bestelling bij een groothandel in te voeren, pakbon te verzenden etcetera.

Deze repository bevat een volledig functioneel, maar basale PHP / HTML implementatie van een Dropcart webshop.

### Installatie

1. Download de laatste versie van deze repository: [https://github.com/dropcart/webshop-frontend/archive/master.zip](https://github.com/dropcart/webshop-frontend/archive/master.zip)
2. Upload (via (S)FTP) de (uitgepakte) bestanden naar je server.
3. In het .zip bestand staat een map `public`, in deze map staan de bestanden die in de webroot-map geplaatst dienen te worden.
   De naam verschilt per webhosting soms heet deze `public_html` of `htdocs`. De overige bestanden en mappen moeten net buiten 
   deze webroot map geplaats worden.
4. Maak de map `templates/compilation_cache` aan als deze nog niet bestaat. Zet de rechten naar 777.


### Configuratie

Kopieer het bestand `config/config.php.example` and hernoem het naar `config/config.php`. Wijzig de waardes in het bestand naar jouw wensen.  
Bekijk in elk geval de dikgedrukte opties; deze zijn verplicht.

| **NAME** | **DESCRIPTION** |
| ---------| --------------- |
| APP_ENV | The environment the app will be installed on. Normally you can leave this to 'live' |
| APP_DEBUG | When this value is set to 'true' it will output technical debug information on errors. This is not desired in production. Leave it to 'false' |
| APP_TIMEZONE | The timezone where you operate. CET = central eastern time. |
| APP_LOCALE | This configuration is in preparation to multilingual support. For now 'NL' is fine. |
|    |   |
| **DROPCART_KEY** | Plak hier je Dropcart public key. Login op het managment console en je vind de sleutel onder de instellingen van je winkel. |
| **DROPCART_SECRET** | Plak hier je Dropcart secret. (HOUD DEZE GEHEIM!) |
| DROPCART_ENDPOINT | You can change the REST endpoint here. Normally you'll use: 'https://rest-api.dropcart.nl/v3' |
| TIMEOUT | This is the max amount of time a request to the Dropcart servers may take. 5.0 is a good max amount |
|      |    |
| **SITE_NAME** | Geef je winkel een naam. |
| **SITE_SLUG** | Stel de slogan van je winkel in, of laat leeg als je geen slogan gebruikt. |
| BASE_URL | This is used when your assets live on an other domain. Normally '/' is sufficient |
| MULTILINGUAL | Don't do anything for now. So 'false' is fine |
| COUNTRIES | Don't do anything for now. So 'Nederland' is fine |
|   |   |
| TEMPLATE_PATH | Change only when you know what you're doing. The path to the Twig templates. |
| CACHE_PATH |  Change only when you know what you're doing. The path to the Twig cache. |
| AUTO_RELOAD | Change only when you know what you're doing. Whether Twig uses auto reloading |
 
### License
Deze code is beschikbaar gesteld onder de MIT-licentie.

### Support
Mocht je fouten ontdekken in de code maak dan een GitHub-issue aan.

Lukt het installeren niet, neem dan contact met ons op: [info@dropcart.nl](mailto:info@dropcart.nl)
