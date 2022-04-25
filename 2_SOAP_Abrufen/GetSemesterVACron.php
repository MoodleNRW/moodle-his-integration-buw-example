#!/usr/bin/php -q
<?php
/*
 * Datei wird per Cron aufgerufen, mit dieser Datei werden wird die SOAP Schnittstelle abgefragt
 * und die Antwort als XML Datei gespeichert.
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

//hier config einbinden mit den notwendigen Settings
//require ('config.inc.php');

// xml aus SOAP abrufen anfang
$soapservice = "MoodleLectureService";
$call = "GetSemesterVA";

$params = [];

/* Lese Parameter */
if (isset($_GET["lectureId"])) {
    $lectureId = urlencode($_GET["lectureId"]);
    $lectureId = (string) htmlspecialchars($lectureId);
    $lectureId = Util::replaceSpace($lectureId);
    $params["lectureId"] = $lectureId;
} else {
    // bleibt leer
}

/* Lese Parameter */
if (isset($_GET["termYear"]) && isset($_GET["termTypeId"])) {
    $termYear = urlencode($_GET["termYear"]);
    $termYear = (string) htmlspecialchars($termYear);
    $termYear = Util::replaceSpace($termYear);
    $params["termYear"] = $termYear;

    $termTypeId = urlencode($_GET["termTypeId"]);
    $termTypeId = (string) htmlspecialchars($termTypeId);
    $termTypeId = Util::replaceSpace($termTypeId);
    $params["termTypeId"] = $termTypeId;
} else {
    // Achtung hier geht es um das aktuelle Semster!
    if (in_array($monat, $sose)) { // aus config
        $termTypeId = TERMTYPEID_SOSE;
        $params["termYear"] = $jahr;
    } else {
        $termTypeId = TERMTYPEID_WISE;
        if ($monat == 1 || $monat == 2 || $monat == 3) {
            $params["termYear"] = $jahr - 1;
        } else {
            $params["termYear"] = $jahr;
        }
    }
    $params["termTypeId"] = $termTypeId;
}

/* Lese Parameter */
if (isset($_GET["offset"])) {
    $offset = urlencode($_GET["offset"]);
    $offset = (string) htmlspecialchars($offset);
    $offset = Util::replaceSpace($offset);
    $params["offset"] = $offset;
} else {
    // bleibt leer
}

/* Lese Parameter */
if (isset($_GET["limit"])) {
    $limit = urlencode($_GET["limit"]);
    $limit = (string) htmlspecialchars($limit);
    $limit = Util::replaceSpace($limit);
    $params["limit"] = $limit;
} else {
    // bleibt leer
}

// zum testen
// print_r($params);

#
// argument als offset
if (isset($argv[1])) {
    $offset = (int) $argv[1];

    // offset enthält nur 0-9
    if (!preg_match("#^[0-9]+$#", $offset)) {
        $offset = 0;
        // echo 'argv enthält auch andere Zeichen.';
    } else {
        // echo 'argv enthält nur Zahlen.';
    }
} else {
    $offset = 0;
}

$params["offset"] = func::getOffset($offset);

$params["limit"] = SOAPLIMIT;
#

// Antwort leer
$json_response = "";
$json_response = func::makeCall($soapservice, $call, $params);

$checkData = $json_response["data"];

if ($checkData != "") {

    // XML in Datei speichern
    $xml = func::writeResponseToFile($call, $json_response);
} else {
    $status = "SOAP Response ohne Inhalt";
    Log::write(LOG_SOAP, $status);
    Log::write(LOG_SOAP, $checkData);
}

// xml aus SOAP abrufen ende
?>