#!/bin/bash

# 
# kurse.sh
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
#absoluten Pfad nutzen oder Pfad wechseln
BENCHFILE="/var/www/html/moodle-rest/global/log/bench.log"
SCRIPTPATH="/opt/moodle-rest-cron"
OUTPUTPATH="/var/www/html/moodle-rest/output"
ENTRYCOUNTFILE="entrycount.txt"
#steht in ENTRYCOUNTFILE
#ENTRYCOUNT=5
#Counter für sleep
COUNT_NUM=0
#Teiler wann Pause gemacht wird
MODULO=10

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

case "$1" in
'create')
# create anfang
echo "create"

# init ausführen!
printf "%s \n" "INIT"

# für den nächsten Durchlauf
cd $OUTPUTPATH && ./init_cat_cron.php >> /var/www/html/moodle-rest/global/log/cron.log 2>&1

#alle Einträge durchgehen und in Moodle überprüfen
#for i in {1..$ENTRYCOUNT..1}

#kleiner gleich!
for ((i=1; i<=$ENTRYCOUNT; i++))
do
    # zum testen
    #echo "$i"
    #echo "Durchlauf $i Create:" >>$BENCHFILE
    cd $OUTPUTPATH && ./course_cat_cron.php "$i" >> /var/www/html/moodle-rest/global/log/cron.log 2>&1

    #
    #inc COUNT_NUM
    ((COUNT_NUM++))
    #nach x Abfragen an die API eine Pause einlegen
    #wird oben gesetzt
    if (( $COUNT_NUM % $MODULO == 0 ))
    then
            #Pause von 1/2 Sekunde
            # um sperre durch moodle zu verhindern
            printf "%s \n" ".... sleep ...."
            sleep .5s
            #sleep 1s
            printf "%s \n" "Einträge : $COUNT_NUM "
    fi
    #

done

# create ende
#Uhrzeit
printf "%s \n" "Ende:"
echo $(date +%m/%d/%Y-%H:%M:%S)
printf "%s \n" "Laufzeit (in Sekunden):"
DURATIONTIMER=$[ $(date +%s) - ${STARTTIMER} ]
echo ${DURATIONTIMER}

#exit code
exit 0
;;

'check')
# check anfang
echo "check"

# init ausführen!
printf "%s \n" "INIT"

# für den nächsten Durchlauf
cd $OUTPUTPATH && ./init_cat_cron.php >> /var/www/html/moodle-rest/global/log/cron.log 2>&1

#alle Einträge durchgehen und in Moodle überprüfen
#for i in {1..$ENTRYCOUNT..1}

#kleiner gleich!
for ((i=1; i<=$ENTRYCOUNT; i++))
do
    # zum testen
    # echo "$i"
    #echo "Durchlauf $i Check:" >>$BENCHFILE
    cd $OUTPUTPATH && ./check_course_cron.php "$i" >> /var/www/html/moodle-rest/global/log/cron.log 2>&1

    #
    #inc COUNT_NUM
    ((COUNT_NUM++))
    #nach x Abfragen an die API eine Pause einlegen
    #wird oben gesetzt
    if (( $COUNT_NUM % $MODULO == 0 ))
    then
            #Pause von 1/2 Sekunde
            # um sperre durch moodle zu verhindern
            printf "%s \n" ".... sleep ...."
            sleep .5s
            #sleep 1s
            printf "%s \n" "Einträge : $COUNT_NUM "
    fi
    #

done

# check ende
printf "%s \n" "Ende:"
echo $(date +%m/%d/%Y-%H:%M:%S)
printf "%s \n" "Laufzeit (in Sekunden):"
DURATIONTIMER=$[ $(date +%s) - ${STARTTIMER} ]
echo ${DURATIONTIMER}

#exit code
exit 0
;;
'help')
#terminal leeren
tput clear

echo "Help"
#help anfang
printf "%s \n" "Help - start"
printf "%s \n" ""
printf "%s \n" "create"
printf "%s \n" "- - -"
printf "%s \n" "legt Kategorien und Kurse in Moodle an, bereits vorhandene Einträge werden dabei nicht erneut verarbeitet"
printf "%s \n" ""
printf "%s \n" "Usage (c&p): "
printf "%s \n" "./kurse.sh create"
printf "%s \n" ""
printf "%s \n" ""
printf "%s \n" "check"
printf "%s \n" "- - -"
printf "%s \n" "Überprüft die eingetragenen Kurse auf ihre Sichtbarkeit."
printf "%s \n" "Bei Sichtbarkeit werden die Kurse in der REST-Schnttstelle für Dez.7 zur Verfügung gestellt"
printf "%s \n" ""
printf "%s \n" "Usage (c&p): "
printf "%s \n" "./kurse.sh check"
printf "%s \n" ""
printf "%s \n" "- - -"
printf "%s \n" "Help - end"
#help fertig

#exit code
exit 0
;;
*)
echo "Usage: $0 {create|check|help}"
#default case
#exit code
exit 0
;;
esac


#fertig
exit 0
