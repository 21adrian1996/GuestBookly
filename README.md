# Installation #
Führen Sie die Datei createDB.sql auf ihrem MySql Server aus.
Diese Datei erstellt die komplette Datenbank.

## Installation via bash ##
```
mysql -u BENUTZERNAME DATENBNAK_NAME < /Pfad/Zu/createdb.sql
```
Datenbank muss zuvor durch `CREATE DATABASE DATABASE_NAME` erstellt worden sein.
## Andere Datenbankserver ##
Alternativ kann der SQL-Code via ein Verbindungstool wie beispielsweise PHPMyAdmin importiert werden.


## Zusatzinfo ##
Wenn Sie einen anderen Datenbank Benutzer verwenden wollen als edp,
können Sie dies in der Datei Controller/config/settings.yml anpassen.
