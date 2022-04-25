# Automatisierung

## Moodle-REST-Cron

Die Automatisierung zur Middleware

1. Schritt: mit **./start.sh** initialisieren (vor jedem Durchlauf)
2. Schritt: mit **./kurse.sh create** die Kurse und Kategorien anlegen.
3. Schritt: Dozent/innen den Kursen zuordnen mit **./person.sh create**
4. Schritt: mit **./kurse.sh check** die Sichtbarkeit der Kurse überprüfen.

Anmerkung: Die Reihenfolge ist wichtig:
Erst muss eine Initialisierung stattfinden, dann können die Kurse und Kategorien angelegt werden.
Erst danach können die Dozent/innen den Kursen zugeordnet werden.

## Cronjobs

Auch bei den Cronjobs sollte die Reihenfolge beachtet werden.

Nach ersten Tests läuft **./kurse.sh create** sowie **./person.sh create** je etwa 2 Stunden.
Die Laufzeit von **./kurse.sh check** beträgt etwas unter 1 Stunde. **./start.sh** braucht 1 Minute.

Mit dem Skript **./install_cron_log.sh** wird die Cron-Datei aus dem _dist_-Ordner auf dem Server installiert.
Zusätzlich wird eine Logrotate-Datei aus dem _dist/logrotate_-Ordner in das passende Serververzeichnis kopiert.

### Beispiel Cron-Datei /etc/cron.d/moodle-cron

```
  #cron file for moodle-rest-cron
  #minute(s) hour(s) day(s)_of_month month(s) day(s)_of_week user command

  SHELL=/bin/bash
  PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin

  ### aktuelles semester mo-sa
  ## ab 12 Uhr
  #start.sh vor den anderen aufrufen. Ausführen dauert etwa 1 Minute.

  # vor kurse create
  10 12 * * 1-6 root cd /opt/moodle-rest-cron && ./start.sh >> /var/www/html/moodle-rest/global/log/cron.log 2>&1
  #kurse.sh create dauert etwa 2 Stunden.
  15 12 * * 1-6 root cd /opt/moodle-rest-cron && ./kurse.sh create >> /var/www/html/moodle-rest/global/log/cron.log 2>&1


  # vor person create
  35 14 * * 1-6 root cd /opt/moodle-rest-cron && ./start.sh >> /var/www/html/moodle-rest/global/log/cron.log 2>&1
  #person.sh create dauert etwa 2 Stunden.
  40 14 * * 1-6 root cd /opt/moodle-rest-cron && ./person.sh create >> /var/www/html/moodle-rest/global/log/cron.log 2>&1


  # vor kurse check
  55 16 * * 1-6 root cd /opt/moodle-rest-cron && ./start.sh >> /var/www/html/moodle-rest/global/log/cron.log 2>&1
  #kurse.sh check create dauert etwa 1 Stunde.
  0 17 * * 1-6 root cd /opt/moodle-rest-cron && ./kurse.sh check >> /var/www/html/moodle-rest/global/log/cron.log 2>&1

  ### aktuelles semester mo-sa
  ## ab 0 Uhr
  #start.sh vor den anderen aufrufen. Ausführen dauert etwa 1 Minute.

  # vor kurse create
  10 0 * * 1-6 root cd /opt/moodle-rest-cron && ./start.sh >> /var/www/html/moodle-rest/global/log/cron.log 2>&1
  #kurse.sh create dauert etwa 2 Stunden.
  15 0 * * 1-6 root cd /opt/moodle-rest-cron && ./kurse.sh create >> /var/www/html/moodle-rest/global/log/cron.log 2>&1


  # vor person create
  35 2 * * 1-6 root cd /opt/moodle-rest-cron && ./start.sh >> /var/www/html/moodle-rest/global/log/cron.log 2>&1
  #person.sh create dauert etwa 2 Stunden
  40 2 * * 1-6 root cd /opt/moodle-rest-cron && ./person.sh create >> /var/www/html/moodle-rest/global/log/cron.log 2>&1


  # vor kurse check
  55 4 * * 1-6 root cd /opt/moodle-rest-cron && ./start.sh >> /var/www/html/moodle-rest/global/log/cron.log 2>&1
  #kurse.sh check create dauert etwa 1 Stunde.
  0 5 * * 1-6 root cd /opt/moodle-rest-cron && ./kurse.sh check >> /var/www/html/moodle-rest/global/log/cron.log 2>&1
```

### Beispiel Logrotate-Datei /etc/logrotate.d/moodlerestcron

```
  /var/www/html/moodle-rest/global/log/cron.log {
          daily
          copytruncate
          dateext
          compress
          maxage 60
  }
```
