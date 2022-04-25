# Moodle-Webservice

Die Schritte sind in der Doku von Moodle erläutert:  
[https://docs.moodle.org/311/de/Webservices_nutzen](https://docs.moodle.org/311/de/Webservices_nutzen)

Kurzzusammenfassung:  
Es ist notwendig, dass ein API-User angelegt wird, der einen REST-Webservice nutzen darf. Die u.a. notwendigen Rechte stehen im folgenden Abschnitt.

Der User für den Webservice muss auch einer Rolle zugewiesen werden.
[https://docs.moodle.org/311/de/Rollen_importieren_und_exportieren](https://docs.moodle.org/311/de/Rollen_importieren_und_exportieren)  
Die Datei zum Importieren ist die _webservice.xml_. Nicht vorhandene Abschnitte werden von Moodle ignoriert. Die Rollen für Studierende und Lehrende müssen entsprechend angepasst bzw. ergänzt werden.

Sollte ein SOAP-Service bevorzugt werden, muss entsprechend ein SOAP-Webservice eingerichtet werden.

## Notwendige Rechte

    moodle/category:manage
    moodle/course:create
    moodle/course:visibility
    moodle/course:delete
    moodle/category:viewhiddencategories
    moodle/course:view
    moodle/course:update
    moodle/course:viewhiddencourses
    moodle/course:changecategory
    moodle/course:changefullname
    moodle/course:changeshortname
    moodle/course:changeidnumber
    moodle/course:changesummary
    moodle/user:viewdetails
    moodle/user:viewhiddendetails
    moodle/course:useremail
    moodle/user:update
    moodle/site:accessallgroups
    moodle/course:enrolreview
    moodle/course:viewparticipants
    enrol/manual:enrol
    enrol/manual:unenrol
    role:assign
    site:viewuseridentity

## Anpassungen

Die oben genannten Rechte wurden für den Webservice an der BUW verwendet. Je nach Bedarf können Rechte entfallen oder es sind zusätzliche Rechte notwendig.
