<?php

/*
 * Stellt für SOAP-Service eine passende SOAP API als abstrakte Klasse zur Verfügung
 * Jeder SOAP-Service benötigt dann eine eigene Child-Klasse für Individuelles
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

/**
 * Abstract soap class for basic implementations
 */
abstract class Soap
{

    /* aus secrets über Child-Konstruktor */
    private $soapUrl;

    private $soapUser;

    private $soapPassword;

    /* aus Child-Konstruktur */
    private $soapServiceName;

    private $soapAttributeNs;

    /* aus Konstruktor */
    private $soapClient;

    /**
     * Called from derived class with soap-service specific information
     *
     * @param String $soapUrl
     * @param String $soapUser
     * @param String $soapPassword
     * @param String $soapServiceName
     * @param String $soapAttributeNs
     * @param boolean $trace
     * @param boolean $exceptions
     */
    protected function __construct($soapUrl, $soapUser, $soapPassword, $soapServiceName, $soapAttributeNs, $trace, $exceptions)
    {
        $this->soapUrl = $soapUrl;
        $this->soapUser = $soapUser;
        $this->soapPassword = $soapPassword;
        $this->soapServiceName = $soapServiceName;
        $this->soapAttributeNs = $soapAttributeNs;

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        $this->soapClient = new SoapClient(null, [
            'location' => $this->soapUrl,
            'uri' => $this->soapUrl,
            'trace' => $trace,
            'stream_context' => $context,
            'exceptions' => $exceptions
        ]);
        /* nötiger Security-Header via soapCall-Function! */
    }

    /*
     * Anzeigen des Soap XML Requests. Funktioniert nur, wenn
     * die trace-Option im Konstruktor aktiviert wurde.
     */
    public function echoLastSoapRequest()
    {
        echo "Last SOAP Request:\n";
        echo $this->soapClient->__getLastRequest() . "\n";
    }

    /*
     * Anzeigen des Soap XML Response. Funktioniert nur, wenn
     * die trace-Option im Konstruktor aktiviert wurde.
     */
    public function echoLastSoapResponse()
    {
        echo "Last SOAP Response:\n";
        echo $this->soapClient->__getLastResponse() . "\n";
    }

    /**
     * Prüft, ob response Begriffe enthält, die auf fehlerhafte Antwort hinweisen
     *
     * @param type $xmlResponse
     * @return boolean
     */
    protected function isSoapFaulty($xmlResponse)
    {
        // TODO: ggf genauer prüfen
        return stripos($xmlResponse, "soapenv:Fault");
    }

    /**
     * Soap-Aufruf per XML
     *
     * @param type $soapAction
     *            per Service-spezifischem-Tag
     * @param type $tags
     *            per per Service-spezifischem-Tag
     * @return \SoapFault
     */
    protected function soapCall($soapAction, $tags)
    {
        $request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:' . $this->soapAttributeNs . '="http://uni-wuppertal.de/cm/hisinone/' . $this->soapServiceName . '">
				<soapenv:Header>
				   <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" >
					  <wsse:UsernameToken>
						 <wsse:Username>' . $this->soapUser . '</wsse:Username>
						 <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $this->soapPassword . '</wsse:Password>
					  </wsse:UsernameToken>
				   </wsse:Security>
				</soapenv:Header>
				<soapenv:Body>
				   <' . $this->soapAttributeNs . ':' . $soapAction . '>' . $tags . '</' . $this->soapAttributeNs . ':' . $soapAction . '>
				</soapenv:Body>
			 </soapenv:Envelope>';

        try {
            $xmlResponse = $this->soapClient->__doRequest(
                $request,
                $this->soapClient->uri, // SOAP-URL
                "http://www.his.de/ws/" . $this->soapServiceName . "/" . $soapAction, // namespace
                "1.1"
            ); // SOAP-Version

            // var_dump($xmlResponse);

            if (!$this->isSoapFaulty($xmlResponse)) {
                // all clear
                $out = array(
                    "OK",
                    $xmlResponse
                );
            } else {
                // 200; well-formed, but no processable information
                // like serviceFault when service is not configured properly / too few parameters

                // ins logfile schreiben
                $out = array(
                    "SOAPERROR",
                    $xmlResponse
                );
            }

            return $out;
        } catch (SoapFault $e) {
            // exception like
            // Soap-Service down: "The service cannot be found for the endpoint reference (EPR) https://h1web02...TagesTerminService
            // bad credentials: "The security token could not be authenticated or authorized"

            // var_dump($e);
            // ins logfile schreiben

            $out = array(
                "SOAPEXCEPTION",
                $e
            );
            return $out;
        }
    }
}
