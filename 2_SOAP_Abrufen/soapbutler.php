<?php
/*
 * Dient als Schnittstelle zwischen Server und SOAP
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

/* Input einsammeln */
$entityBody = file_get_contents('php://input');
$EchoJArray = json_decode($entityBody, true);

if (isset($EchoJArray["msoapservice"])) {
    $soapservice = $EchoJArray["msoapservice"];
}
if (isset($EchoJArray["mcall"])) {
    $call = $EchoJArray["mcall"];
}
if (isset($EchoJArray["mparams"])) {
    $params = $EchoJArray["mparams"]; // mparams = ein assoz. Array!
}

/* SOAP-Call */
$data = array();

/* SoapServices je nach Projektanforderung*/
switch ($soapservice) {

    case "MoodleLectureService":

        require_once(PATH_CLASSES . 'soap.moodlelectureservice.class.php');
        try {
            $soapService = new Moodlelectureservice();

            /* SoapActions innerhalb dieses Services */
            switch ($call) {
                case "GetSemesterVA":
                    $soapResponse = $soapService->getSemesterVA($params);
                    break;

                default:
                    break;
            }
        } catch (SoapFault $e) {
            Log::write(LOG_SOAP, $e);
        }
        break;

    default:
        break;
}

/*
 * $data[0]
 * OK = SOAP-OK
 * SOAPERROR = Fehler bei SOAP-Request
 * SOAPEXCEPTION = Fehler bei SOAP-API (Service down, bad login...)
 * BUTLERERROR = Fehler bei call-Parameter ("GET...")
 * SOAPCLASSERROR = Fehler beim Generieren des SOAP-Objekt, z.B. USer/PW falsch
 *
 * $data[1] XML
 */
/* Antwort senden */
if (!empty($soapResponse)) {
    $output["status"] = $soapResponse[0];
    $output["data"] = $soapResponse[1];
} else {
    $output["status"] = "SOAPCLASSERROR";
    $output["data"] = "SOAP-Service-Objekt konnte nicht erzeugt werden!";
}
header('Content-Type: application/json');
$jsonReturn = json_encode($output, JSON_UNESCAPED_SLASHES);
echo $jsonReturn;
