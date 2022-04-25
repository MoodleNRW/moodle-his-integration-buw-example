<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="../pub/wsdl/wsdl-viewer.xsl"?>
<definitions name="MoodleLectureServiceDefinition" targetNamespace="http://uni-wuppertal.de/cm/hisinone/MoodleLectureService" xmlns="http://schemas.xmlsoap.org/wsdl/" xmlns:wsp="http://schemas.xmlsoap.org/ws/2004/09/policy" xmlns:wns="http://uni-wuppertal.de/cm/hisinone/MoodleLectureService" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/">
  <types>
    <schema elementFormDefault="qualified" targetNamespace="http://uni-wuppertal.de/cm/hisinone/MoodleLectureService" xmlns="http://www.w3.org/2001/XMLSchema">
            <complexType abstract="false" name="hisAccount">
                <sequence>
                    <element minOccurs="0" name="username" nillable="true" type="string">
                        <annotation>
                            <documentation>Benutzername des HisAccountes</documentation>
                        </annotation>
                    </element>
                </sequence>
            </complexType>
            <complexType abstract="false" name="parallelgroup">
                <sequence>
                    <element minOccurs="0" name="unitId" nillable="true" type="long">
                        <annotation>
                            <documentation>Veranstaltungs-ID</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="unitComment" nillable="true" type="string">
                        <annotation>
                            <documentation>Veranstaltungskommentar</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="unitDefaulttext" nillable="true" type="string">
                        <annotation>
                            <documentation>semesterunabh. Veranstaltungstitel</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="unitElementnr" nillable="true" type="string">
                        <annotation>
                            <documentation>Veranstaltungsnummer</documentation>
                        </annotation>
                    </element>
                    <element name="planelementId" type="long">
                        <annotation>
                            <documentation>PlanelementId</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="parallelgroupId" nillable="true" type="long">
                        <annotation>
                            <documentation>Parallelgruppen-Nr</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="attendeeMaximum" nillable="true" type="integer">
                        <annotation>
                            <documentation>max. Anzahl Teilnehmer/-innen</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="attendeeMinimum" nillable="true" type="integer">
                        <annotation>
                            <documentation>min. Anzahl Teilnehmer/-innen</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="cancelled" nillable="true" type="long">
                        <annotation>
                            <documentation>0 nicht aus ausgefallen / 1 ausgefallen</documentation>
                        </annotation>
                    </element>
                    <element name="parallelgroupTitle" type="string">
                        <annotation>
                            <documentation>semesterabh. Veranstaltungstitel</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="hoursPerWeek" nillable="true" type="decimal">
                        <annotation>
                            <documentation>Semesterwochenstunden der Veranstaltung</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="longtext" nillable="true" type="string">
                        <annotation>
                            <documentation/>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="shorttext" nillable="true" type="string">
                        <annotation>
                            <documentation/>
                        </annotation>
                    </element>
                    <element name="termTypeId" type="long">
                        <annotation>
                            <documentation>31 für Wintersemester / 30 für Sommersemester</documentation>
                        </annotation>
                    </element>
                    <element name="year" type="integer">
                        <annotation>
                            <documentation>Semesterjahr</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="compulsoryRequirement" nillable="true" type="string">
                        <annotation>
                            <documentation>zwingende Voraussetzung der Veranstaltung</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="credits" nillable="true" type="string">
                        <annotation>
                            <documentation/>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="examinationAchievement" nillable="true" type="string">
                        <annotation>
                            <documentation>zu erbringende Prüfungsleistung</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="targetGroup" nillable="true" type="string">
                        <annotation>
                            <documentation>Zielgruppe der Veranstaltung</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="responsible_lecturer" nillable="true" type="wns:responsible_lecturerType">
                        <annotation>
                            <documentation>Liste der verantwortlichen Lehrpersonen</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="orgunit" type="wns:orgunitType">
                        <annotation>
                            <documentation>Baum der Organisationseinheiten, dem die VA zugeordnet ist</documentation>
                        </annotation>
                    </element>
                </sequence>
            </complexType>
            <complexType abstract="false" name="orgunit">
                <sequence>
                    <element minOccurs="0" name="defaulttext" type="string">
                        <annotation>
                            <documentation>Titel der Organisationseinheit</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="uniquename" type="string">
                        <annotation>
                            <documentation>PBP-ID der Organisationseinheit</documentation>
                        </annotation>
                    </element>
                </sequence>
            </complexType>
            <complexType abstract="false" name="SemesterLectures">
                <complexContent>
                    <extension base="wns:statistics">
                        <sequence>
                            <element minOccurs="0" name="SemesterLectures" nillable="true" type="wns:SemesterLecturesType"/>
                        </sequence>
                    </extension>
                </complexContent>
            </complexType>
            <complexType abstract="false" name="Lehrperson">
                <sequence>
                    <element minOccurs="0" name="degree" nillable="true" type="string">
                        <annotation>
                            <documentation>akadem. Titel der Lehrperson</documentation>
                        </annotation>
                    </element>
                    <element name="firstname" type="string">
                        <annotation>
                            <documentation>Vorname der Lehrperson</documentation>
                        </annotation>
                    </element>
                    <element name="lastname" type="string">
                        <annotation>
                            <documentation>Nachname der Lehrperson</documentation>
                        </annotation>
                    </element>
                    <element name="buwId" nillable="true" type="string">
                        <annotation>
                            <documentation>BUW ID der Lehrperson</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="hisAccounts" nillable="true" type="wns:hisAccountsType">
                        <annotation>
                            <documentation>Liste der His-Accounts der Lehrperson</documentation>
                        </annotation>
                    </element>
                    <element minOccurs="0" name="sort" nillable="true" type="integer">
                        <annotation>
                            <documentation>Reihenfolge</documentation>
                        </annotation>
                    </element>
                </sequence>
            </complexType>
            <complexType abstract="false" name="statistics">
                <sequence>
                    <element name="unitsCount" nillable="true" type="integer">
                        <annotation>
                            <documentation>Anzahl der zurückgelieferten Veranstaltungen</documentation>
                        </annotation>
                    </element>
                    <element name="planelementsCount" nillable="true" type="integer">
                        <annotation>
                            <documentation>Anzahl der zurückgelieferten Parallelgruppen (Planelemente)</documentation>
                        </annotation>
                    </element>
                </sequence>
            </complexType>
            <element name="getSemesterVA">
                <complexType>
                    <sequence>
                        <element minOccurs="0" name="lectureId" nillable="true" type="integer">
                            <annotation>
                                <documentation>Veranstaltungs-ID</documentation>
                            </annotation>
                        </element>
                        <element minOccurs="0" name="termYear" nillable="true" type="date">
                            <annotation>
                                <documentation>Semesterjahr</documentation>
                            </annotation>
                        </element>
                        <element name="termTypeId" type="integer">
                            <annotation>
                                <documentation>31 für Wintersemester / 30 für Sommersemester</documentation>
                            </annotation>
                        </element>
                        <element minOccurs="0" name="offset" type="integer">
                            <annotation>
                                <documentation>Wie viele Veranstaltungen geskippt werden sollen</documentation>
                            </annotation>
                        </element>
                        <element minOccurs="0" name="limit" type="integer">
                            <annotation>
                                <documentation>Anzahl der abzufragenden Veranstaltungen</documentation>
                            </annotation>
                        </element>
                    </sequence>
                </complexType>
            </element>
            <element name="getSemesterVAResponse">
                <complexType>
                    <sequence>
                        <element name="SemesterLectures" type="wns:SemesterLectures"/>
                    </sequence>
                </complexType>
            </element>
            <complexType name="SemesterLecturesType">
                <sequence>
                    <element maxOccurs="unbounded" minOccurs="0" name="parallelgroup" nillable="true" type="wns:parallelgroup"/>
                </sequence>
            </complexType>
            <complexType name="orgunitType">
                <sequence>
                    <element maxOccurs="unbounded" minOccurs="0" name="orgunit" nillable="true" type="wns:orgunit"/>
                </sequence>
            </complexType>
            <complexType name="hisAccountsType">
                <sequence>
                    <element maxOccurs="unbounded" minOccurs="0" name="hisAccount" nillable="true" type="wns:hisAccount"/>
                </sequence>
            </complexType>
            <complexType name="responsible_lecturerType">
                <sequence>
                    <element maxOccurs="unbounded" minOccurs="0" name="lecturer" nillable="true" type="wns:Lehrperson"/>
                </sequence>
            </complexType>
            <element name="ServiceFault">
                <complexType>
                    <sequence>
                        <element maxOccurs="1" minOccurs="0" name="rootCause" type="string"/>
                        <element name="message" type="string"/>
                        <element maxOccurs="unbounded" minOccurs="0" name="validationMessage" type="wns:ValidationMessage"/>
                    </sequence>
                </complexType>
            </element>
            <complexType name="ValidationMessage">
                <sequence>
                    <element name="messageType" type="string"/>
                    <element name="messageKey" type="string"/>
                    <element maxOccurs="unbounded" minOccurs="0" name="messageParameter" type="string"/>
                </sequence>
            </complexType>
        </schema>
  </types>
  <message name="ServiceFault">
    <part name="serviceFault" element="wns:ServiceFault">
    </part>
  </message>
  <message name="getSemesterVA">
    <part name="parameters" element="wns:getSemesterVA">
    </part>
  </message>
  <message name="getSemesterVAResponse">
    <part name="parameters" element="wns:getSemesterVAResponse">
    </part>
  </message>
  <portType name="MoodleLectureServicePortType">
    <operation name="getSemesterVA">
<documentation>Gibt alle Parallelgruppen der Veranstaltungen im bestimmten Semester zurück</documentation>
      <input message="wns:getSemesterVA">
    </input>
      <output message="wns:getSemesterVAResponse">
    </output>
      <fault name="serviceFault" message="wns:ServiceFault">
    </fault>
    </operation>
  </portType>
  <binding name="MoodleLectureServiceBinding" type="wns:MoodleLectureServicePortType">
    <soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http"/>
    <operation name="getSemesterVA">
      <soap:operation soapAction="http://www.his.de/ws/MoodleLectureService/getSemesterVA"/>
      <input>
        <soap:body use="literal"/>
      </input>
      <output>
        <soap:body use="literal"/>
      </output>
      <fault name="serviceFault">
        <soap:fault name="serviceFault" use="literal"/>
      </fault>
    </operation>
  </binding>
  <service name="MoodleLectureService">
<documentation>orchestr. Webservice zur Abfrage von VA-Daten zur Anlage von Moodle-Kursen. Benötigte Standard-WS: AccountService,
        CourseInterfaceService, ExternalRelationService KeyvalueService, OrgunitService201806, PersonService</documentation>
    <port name="MoodleLectureServicePort" binding="wns:MoodleLectureServiceBinding">
      <soap:address location="https://XYZ.uni-wuppertal.de/qisserver/services2/MoodleLectureService"/>
    </port>
    <wsp:PolicyReference URI="#UsernameToken"/>
  </service>
    <wsp:Policy wsu:Id="UsernameToken" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
        <wsp:ExactlyOne>
            <wsp:All>
                <sp:SupportingTokens xmlns:sp="http://docs.oasis-open.org/ws-sx/ws-securitypolicy/200702">
                    <wsp:Policy>
                        <sp:UsernameToken sp:IncludeToken="http://docs.oasis-open.org/ws-sx/ws-securitypolicy/200702/IncludeToken/AlwaysToRecipient">
                            <wsp:Policy/>
                        </sp:UsernameToken>
                    </wsp:Policy>
                </sp:SupportingTokens>
            </wsp:All>
        </wsp:ExactlyOne>
    </wsp:Policy>
</definitions>
