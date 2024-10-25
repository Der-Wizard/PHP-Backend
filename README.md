Anforderungen:
Windows 11
Visual Studio Code

PHP installiert mit version 8.13.12:

    https://windows.php.net/download/

  => hier die Zip Datei von der Distribution: VS16 x64 Thread Safe (2024-Oct-22 21:26:42) installieren

  extrahieren und auf folgendem Pfad speichern: C:\Program Files\php-8.3.12-Win32-vs16-x64

  In der php.ini datei müssen folgende Änderungen forgenommen werden:
  
    extension_dir = "C:\Program Files\php-8.3.12-Win32-vs16-x64\ext"
    extension=mysqli
    extension=openssl
    extension=zip

  Unter System Properties > Environment Variables => unter Pfad muss `C:\php` hinzugefügt werden

    
MySQL Server der auf Port 3006 läuft:

    https://dev.mysql.com/downloads/installer/

    Version 8.0.40
    Microsoft Windows
Hier die (mysql-installer-community-8.0.40.0.msi) mit 306.4M auswählen

Hier müssen alle Produkte ausgewählt und erstellt werden mit folgenden Werten:

MySQL Server:

  Config Type: Development Computer
  Connectivity > 'TCP/IP' anhacken; Port: '3006'; X Protocol Port: '33060'
  'Open Windows Firewall ports for network access' anhacken
  'Use Strong Password Encryption for Authentication' anhacken
  Current-Root-Password setzen als: Saw0UsFw72LanVrCJri19KBuGBW3Up6Hgt9CYtVjOOjqkeUdvY

    Alles andere beim Standard lassen

Alle Dateien aus dem Main Branch pullen und lokal abspeichern
SQL Datei DUMP20241017.sql aus dem Verzeichnis PHP-BACKEDN/private kopieren und in MySQL ausführen

Server starten mit folgendem Befehl: php -S localhost:8000 -t public
