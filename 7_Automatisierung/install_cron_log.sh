#!/bin/bash

# 
# Kopiert die Cron Skripte an die passende Stelle, es wird cron.d verwendet nicht die crontab vom user root
# Kopiert eine logrotate Datei an die passende Stelle.
# Copyright (C) 2021-2022 Tim-Florian Reinartz
# 
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published
# by the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
# 
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <https://www.gnu.org/licenses/>.
#

#Variablen
SCRIPTPATH="/opt/moodle-rest-cron"
CRONPATH="/etc/cron.d"
CRONFILE="moodle-cron"
LOGROTATEPATH="/etc/logrotate.d/"
LOGROTATEFILE="moodlerestcron"

#Bildschirm leeren
#tput clear

# Skriptpfad und Wechsel ins Verzeichnis
printf "%s \n" "Wechsel in das Verzeichnis des Skripts"
cd ${SCRIPTPATH} || exit
printf "%s \n" "Skript arbeitet im Verzeichnis:"
pwd

printf "%s \n" "Cron Daten vorhanden?"
if test ! -e ./dist/$CRONFILE
then
        printf "%s \n" "Nein -> Abbruch" 1>&2
        exit 1
else
        printf "%s \n" "Ja -> Weiter"
fi

printf "%s \n" "Logrotate Daten vorhanden?"
if test ! -e ./dist/logrotate/$LOGROTATEFILE
then
        printf "%s \n" "Nein -> Abbruch" 1>&2
        exit 1
else
        printf "%s \n" "Ja -> Weiter"
fi

# Copy cron file
printf "%s \n" "Kopiere Cron Datei: $CRONFILE nach $CRONPATH "
cp ./dist/$CRONFILE $CRONPATH/$CRONFILE
printf "%s \n" "Fertig"

# Copy logrotate file
printf "%s \n" "Kopiere Logrotate Datei: $LOGROTATEFILE nach $LOGROTATEPATH "
cp ./dist/logrotate/$LOGROTATEFILE $LOGROTATEPATH/$LOGROTATEFILE
printf "%s \n" "Fertig"

#fertig
exit 0
