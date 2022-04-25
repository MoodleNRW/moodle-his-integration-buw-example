<?php

/*
 * Stellt für den SOAP-TagesTerminService eine passende SOAP API zur Verfügung
 * ein Teil der Moodle-His Verknüpfung an der Bergischen Universität Wuppertal (BUW)
 * Copyright (C) 2021-2022 Florian Siegmund and Tim-Florian Reinartz
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */
require_once ('soap.class.php');

class Moodlelectureservice extends Soap {

    private $soapServiceName = "MoodleLectureService";

    private $soapAttributeNs = "tag";

    /*
     * Konstruktor
     * $trace: Wenn TRUE kann der Soap Request und Response als XML angezeigt werden
     * $exceptions: Wenn TRUE wird bei einem Soap-Fehler eine Exception vom Typ SoapFault geworfen wird (TRUE empfehlenswert)
     */
    public function __construct($trace = TRUE, $exceptions = TRUE) {

        /* Verbindungsdaten einlesen */
        require_once ('soap.moodlelectureservice.secrets.class.php'); // TODO: datei anpassen
        $soapSecrets = new MoodlelectureserviceSecrets();
        $soapUser = $soapSecrets->getSoapUser();
        $soapPassword = $soapSecrets->getSoapPassword();
        $soapUrl = $soapSecrets->getSoapUrl();

        parent::__construct($soapUrl, $soapUser, $soapPassword, $this->soapServiceName, $this->soapAttributeNs, $trace, $exceptions);
    }

    /**
     * Holt erstellte Veranstaltgungen von Dez7-Soap
     *
     * @param type $termYear
     * @param type $termTypeId
     * @param type $verId
     *            // Wert oder null (nicht mit offset & limit zusammen)
     * @param type $offset
     *            // Wert oder null
     * @param type $limit
     *            // Wert oder null
     * @return type
     *
     */
    public function getSemesterVA($params) {
        $soapAction = "getSemesterVA"; // Soap-Action nach Definition von Dez7
        $tags = "";
        /*
         * Zwei mögliche Calls
         * a) lectureId + $termYear + termTypeId => Eintrag zu einer VA
         * b) $termYear + termTypeId (+ offset + limit) => Einträge zu allen VAs, ggf. gefiltert per Offset/Limit
         * Reihenfolge wichtig!
         */
        if (isset($params["lectureId"]))
            $tags .= "<tag:lectureId>" . $params['lectureId'] . "</tag:lectureId>"; // Ja, lectureId!
        if (isset($params["termYear"]))
            $tags .= "<tag:termYear>" . $params['termYear'] . "</tag:termYear>";
        if (isset($params["termTypeId"]))
            $tags .= "<tag:termTypeId>" . $params['termTypeId'] . "</tag:termTypeId>";
        if (isset($params["offset"]))
            $tags .= "<tag:offset>" . $params['offset'] . "</tag:offset>";
        if (isset($params["limit"]))
            $tags .= "<tag:limit>" . $params['limit'] . "</tag:limit>";

        return parent::soapCall($soapAction, $tags);
    }
}
