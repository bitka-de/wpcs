# WPCS - Webpage Content System
Leider habe ich noch keinen Namen für das Projekt - es ist jedoch ein CMS für Webpages also WPCS 😁
Das Ziel ist es für kleine Untenehmen eine einfach diterbare Weblösung zu Bieten 


## Use Cases
### New Installation (Done but Minimal)
Wenn der user die Software installiert wird er aufgefordert seine Daten anzugeben wenn (first-run.php) wenn dieses erfolgreich passiert ist (daten landen in data/users.json) wird die (first-run.php in _first-run.php) umgeschrieben und somit kann sich der user ab diesem Moment anmelden 

### Login (Done but Minimal)
Der Nutzer geht auf {URL}/login.php und gibt seine zuvor gesetzten Dateb ein und gelangt auf ein Dashboard 

### Componenten bearbeiten (in Process)
Jede componente kann in eine Editierbare componente umgewandelt werden in dem man    
```php
<?= editComponent(__FILE__); ?>
```
in den code der jeweiligen comonente einsetzt - Es ist drauf zu achten das es innerhalb des HTML-TAG ist welcher die Componente umschliesst. Die Function editComponent liegt aktuell noch in core/app.php


## Backlog
### Maintenance 
maintenance Modus so das die Seite nur im Logedin status sichtbar ist 

### Layout editing 
die möglichkeit das Layout einer seite zu wechseln oder anzupassen 

### Componenten editing 
die möglichkeit componenten zu bearbeiten einer seite hinzu zu fügen und so weiter 

### History Mode 
Die letzen änderungen sowohl bei den Layouts als auch bei den componenten sollen in /backups gesichert werden (max3) je element 

### Activity Log 
Änderungen werden im activity-log protokoliert# wpcs
