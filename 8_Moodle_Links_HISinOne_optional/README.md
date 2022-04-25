# Moodle-Links für HISinOne

Hierbei werden für die vorher erstellten Kurse Einträge in einer DB erstellt.
Diese werden dann wie bei Teil 4 wieder mit einer REST-Schnittstelle bereitgestellt und von HISinOne verarbeitet.

An der BUW wird dafür MySQL und PHP genutzt, allerdings sind Sprache und DB nicht festgelegt.
Auch hier muss wieder jede Uni eine Lösung für sich finden.

An der BUW wollten wir ursprünglich nur die Verknüpfung moodle _courseid_ und his _planelementid_ ausliefern.
Nach Rücksprache haben wir diese Daten noch erweitert um Name des Kurses, Semester und weitere Einträge, damit der Abgleich auf HISinOne-Seite schneller und einfacher möglich ist.
