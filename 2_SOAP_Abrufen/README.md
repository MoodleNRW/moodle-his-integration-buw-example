# SOAP-Webservice von HISinOne abfragen

Der Webservice, der an BUW zur Verfügung steht, ist ein SOAP-Service.

Die Abfrage kann in jeder beliebigen Sprache erfolgen, an der BUW wurde es in PHP umgesetzt.

Die Klassen, die so an der BUW verwendet werden, befinden sich im Ordner "classes".

Damit der Webservice genutzt werden kann, muss nur eine angepasste Methode zur Klasse hinzugefügt werden. An der BUW ist dies _public function getSemesterVA($params)_

Die Datei _soap.moodlelectureservice.secrets.class.dist.php_ sollte um entsprechende Login-Daten ergänzt und in _soap.moodlelectureservice.secrets.class.php_ umbenannt werden.

Ein Beispielaufruf ist in _GetSemesterVACron.php_ zu finden. Dieser muss an die entsprechende Methode, den Servicenamen und die Parameter der jeweiligen Hochschule angepasst werden.
