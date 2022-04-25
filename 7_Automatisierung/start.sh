#!/bin/bash

# 
# Initialisierung vor dem Durchlauf der Skripte für kurse.sh oder person.sh
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
OUTPUTPATH="/var/www/html/moodle-rest/output"
ENTRYCOUNTFILE="entrycount.txt"
#steht in ENTRYCOUNTFILE
#ENTRYCOUNT=5

#Bildschirm leeren
#tput clear

# Skriptpfad und Wechsel ins Verzeichnis
printf "%s \n" "Wechsel in das Verzeichnis des Skripts"
cd ${SCRIPTPATH} || exit
printf "%s \n" "Skript arbeitet im Verzeichnis:"
pwd

# lock.sh vorhanden ?
printf "%s \n" "lock.sh vorhanden?"
if test ! -e ./lock.sh
then
        printf "%s \n" "Nein" 1>&2
        exit 1
else
        printf "%s \n" "Ja"
        #auth Daten
        source ./lock.sh
fi

# entrycount Daten vorhanden ?
printf "%s \n" "entrycount Daten vorhanden?"
        if test ! -e $OUTPUTPATH/$ENTRYCOUNTFILE
        then
                printf "%s \n" "Nein" 1>&2
                exit 1
        else
                printf "%s \n" "Ja"
                #auth Daten
                source $OUTPUTPATH/$ENTRYCOUNTFILE
        fi
# echo $ENTRYCOUNT

#Eingabe überprüfen ob es eine Zahl ist
REG='^[0-9]+$'

#=~ für Regex
if ! [[ $ENTRYCOUNT =~ $REG ]] ;
then
   echo "ENTRYCOUNT ist keine ganze Zahl" 1>&2
   exit 1
fi

printf "%s \n" "$ENTRYCOUNT ist der ENTRYCOUNT"

# init ausführen!
printf "%s \n" "INIT"

# für den nächsten Durchlauf
cd $OUTPUTPATH && ./init_cat_cron.php >> /var/www/html/moodle-rest/global/log/cron.log 2>&1

printf "%s \n" "Ende:"
echo $(date +%m/%d/%Y-%H:%M:%S)
printf "%s \n" "Laufzeit (in Sekunden):"
DURATIONTIMER=$[ $(date +%s) - ${STARTTIMER} ]
echo ${DURATIONTIMER}

#fertig
exit 0
