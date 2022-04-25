# Middleware

Die Middleware nimmt die Daten aus HISinOne entgegen und übergibt diese an den Moodle-Webservice.

An der BUW wird die SOAP-Antwort in REST umgewandelt - dies ist aber nicht zwingend notwendig. In Moodle kann auch ein SOAP-Webservice konfiguriert werden.

## Dokumentation

Der einfachste Weg, an eine geeignete Dokumentation zu gelangen, ist, den Webservice auf der eigenen Moodle-Instanz zu aktivieren.

Der Aufruf ist mit den entsprechenden Rechten über

https://**moodle.meine-uni.de**/admin/webservice/documentation.php

möglich. Dort sind jeweils die Aufrufe des eigenen Servers direkt aufgeführt.

## Dateien der Middleware

Abgesehen von der Klasse gibt es Dateien, in denen die Aufrufe der Methoden stattfinden, wie z.B. in _moodle-create-cat.php_

In _moodle-create-cat.php_ ist das Erstellen einer Kategorie gezeigt, die anderen Methoden funktionieren analog.

Danach werden die verschiedenen Dateien in der passenden Reihenfolge aufgerufen, wie z.B. _init_cat.php_, um die "oberste" Kategorie anzulegen.

Durch diesen Aufbau ist es möglich, verschiedene Aktionen durchzuführen. Dabei wird jeweils nur eine neue Datei benötigt.

Ein Beispiel wäre ein _init_course.php_, bei dem zuerst die Kategorie überprüft wird, dann der Kurs, und wenn dieser okay ist, wird der Kurs angelegt.
