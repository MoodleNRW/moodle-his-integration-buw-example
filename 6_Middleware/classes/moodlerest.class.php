<?php
/*
 * Klasse mit Methoden zum Aufruf
 * ein Teil der Moodle-His Verknüpfung an der Bergischen Universität Wuppertal (BUW)
 * Copyright (C) 2021-2022 Tim-Florian Reinartz
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
//festlegen wo die Datei relativ zu dieser liegt
//define('ROOT_PATH', __DIR__ . '/../../');
//require (ROOT_PATH . 'config.inc.php');

// Aus config Datei
define('TOKEN', $token);
define('DOMAINNAME', $domainname);

// Einheitlich für alle Calls json
define('RESTFORMAT', 'json');

class Moodlerest {

    public static function createCat($name, $parent, $description) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_create_categories';

        $category = new stdClass();
        $category->name = $name;
        $category->parent = $parent;
        $category->description = $description;
        // immer als Format 1 wählen
        $category->descriptionformat = 1;
        $categories = array(
            $category
        );
        $params = array(
            'categories' => $categories
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;

        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        // Hier gezielt nur ID(s) ausgeben
        $rows = json_decode($resp);

        // leeres array anlegen
        $cat_daten = array();

        // Antwort auf das Filtern was benötigt wird
        if ($name != "") {

            foreach ($rows as $entry) {

                $id = addslashes($entry->id);
                $cat_daten[] = $id;
            }
        }

        // return array mit oder ohne id
        return $cat_daten;
    }

    public static function createCourse($fullname, $shortname, $categoryid, $summary) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_create_courses';

        $course = new stdClass();

        $course->fullname = $fullname;
        $course->shortname = $shortname;
        $course->categoryid = $categoryid;

        // Standardwerte siehe settings.md
        // immer als Format 1 wählen
        $course->summaryformat = 1;
        // immer als Grades zeigen
        $course->showgrades = 1;
        // 5 News items
        $course->newsitems = 5;
        // Kein Upload Limit
        $course->maxbytes = 0;
        // Reports zeigen
        $course->showreports = 1;
        // Kein Groupmode erzwingen
        $course->groupmodeforce = 0;
        $course->defaultgroupingid = 0;

        $course->summary = $summary;

        // Kurs ist NICHT sichtbar
        $course->visible = 0;

        // Kein Gruppenmodus
        $course->groupmode = 0;
        // Format
        $course->format = "topics";

        // Enable completion tracking
        $course->enablecompletion = 0;
        $course->completionnotify = 0;

        $courses = array(
            $course
        );
        $params = array(
            'courses' => $courses
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        return $resp;
    }

    public static function deleteCat($id) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_delete_categories';

        $category = new stdClass();
        $category->id = $id;
        $category->recursive = 0;
        $categories = array(
            $category
        );
        $params = array(
            'categories' => $categories
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        return $resp;
    }

    public static function delteCourse($cid) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_delete_courses';

        $courseid = new stdClass();
        $courseid = $cid;
        $courseids = array(
            $courseid
        );
        $params = array(
            'courseids' => $courseids
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        return $resp;
    }

    public static function updateCat($id, $name, $description) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_update_categories';

        $category = new stdClass();
        $category->id = $id;
        $category->name = $name;
        $category->description = $description;

        // immer als Format 1 wählen
        $category->descriptionformat = 1;
        $categories = array(
            $category
        );
        $params = array(
            'categories' => $categories
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        return $resp;
    }

    public static function updateCourse($id, $fullname, $shortname, $categoryid, $summary) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_update_courses';

        $course = new stdClass();

        $course->id = $id;
        $course->fullname = $fullname;
        $course->shortname = $shortname;
        $course->categoryid = $categoryid;

        // Standardwerte siehe settings.md
        $course->summaryformat = 1;
        $course->showgrades = 1;
        $course->newsitems = 5;
        $course->maxbytes = 0;
        $course->showreports = 0;
        $course->groupmodeforce = 0;
        $course->defaultgroupingid = 0;

        $course->summary = $summary;

        $course->visible = 1;
        $course->groupmode = 0;
        $course->format = "weeks";

        // Enable completion tracking
        $course->enablecompletion = 1;
        $course->completionnotify = 0;

        $courses = array(
            $course
        );
        $params = array(
            'courses' => $courses
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        return $resp;
    }

    public static function enroleUser($roleid, $userid, $courseid) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'enrol_manual_enrol_users';

        // Achtung rollen ids müssen überprüft werden
        // diese finden sich z.B. in der config.inc.php
        // ('BUWMOODLEDOZENT', 3)
        // ('BUWMOODLESTUDENT', 5)
        // ('BUWMOODLEGAST', 6)
        // Diese können sich je nach System unterschieden

        $enrolment = new stdClass();

        $enrolment->roleid = $roleid;
        $enrolment->userid = $userid;
        $enrolment->courseid = $courseid;

        // folgende Werte sind fest
        $enrolment->timestart = 0;
        $enrolment->timeend = 0;
        $enrolment->suspend = 0;
        $enrolments = array(
            $enrolment
        );
        $params = array(
            'enrolments' => $enrolments
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        return $resp;
    }

    public static function unenroleUser($userid, $courseid) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'enrol_manual_unenrol_users';

        $enrolment = new stdClass();
        $enrolment->userid = $userid;
        $enrolment->courseid = $courseid;
        $enrolments = array(
            $enrolment
        );
        $params = array(
            'enrolments' => $enrolments
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        return $resp;
    }

    public static function showEnroledUser($courseid) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_enrol_get_enrolled_users';

        $params = array(
            "courseid" => $courseid
        );

        // Zum Testen
        // print_r($params);

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        // gezielt nur einige Daten ausgeben
        $rows = json_decode($resp);

        // leeres array anlegen
        $enrole_daten = array();

        if ($courseid != "") {

            foreach ($rows as $entry) {

                $id = addslashes($entry->id);
                $idnumber = addslashes($entry->idnumber);
                // echo " id: " . $id;
                $enrole_daten[$idnumber] = $id;
            }
        }

        return $enrole_daten;
    }

    public static function searchCourse($name) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_get_courses_by_field';

        $params = array(
            "field" => "shortname",
            "value" => $name
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        // gezielt nur ID ausgeben
        $rows = json_decode($resp);

        // leeres array anlegen
        $course_daten = array();

        if ($name != "") {

            foreach ($rows->courses as $entry) {

                $id = addslashes($entry->id);
                // echo " id: " . $id;
                $course_daten[] = $id;
            }
        }

        // return array mit oder ohne id
        return $course_daten;
    }

    public static function searchUser($name) {

        // Format
        $restformat = RESTFORMAT;

        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_user_get_users_by_field';

        // name wird verwendet
        $params = "field=idnumber&values[0]=" . $name;

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        // gezielt nur ID ausgeben
        $rows = json_decode($resp);

        // leeres array anlegen
        $user_daten = array();

        if ($name != "") {

            foreach ($rows as $entry) {

                $id = addslashes($entry->id);
                // echo " id: " . $id;
                $user_daten[] = $id;
            }
        }

        // return array mit oder ohne id
        return $user_daten;
    }

    public static function detailCat($name) {

        // Format
        $restformat = RESTFORMAT;
        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_get_categories';

        $criterias = new stdClass();

        // zu einem Namen wird die ID gesucht
        $criterias->key = 'name';
        // $criterias->value = 'CreatedwithRestEdit';
        $criterias->value = $name;

        $criteria = array(
            $criterias
        );
        $params = array(
            'criteria' => $criteria
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        // Hier gezielt nur ID(s) ausgeben
        $rows = json_decode($resp);

        // leeres array anlegen
        $cat_daten = array();

        // Antwort auf das Filtern was benötigt wird
        if ($name != "") {

            foreach ($rows as $entry) {

                $id = addslashes($entry->id);
                // echo " id: " . $id;
                $cat_daten[] = $id;
            }
        }

        // return array mit oder ohne id
        return $cat_daten;
    }

    public static function detailCatParent($name) {

        // Format
        $restformat = RESTFORMAT;
        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_get_categories';

        $criterias = new stdClass();

        // zu einem Namen wird die ID gesucht
        $criterias->key = 'name';
        // $criterias->key = 'parent';
        // $criterias->value = 'CreatedwithRestEdit';
        $criterias->value = $name;

        // Infos zur parent cat
        $criteria = array(
            $criterias
        );
        $params = array(
            'criteria' => $criteria
        );

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        // Hier gezielt nur ID(s) ausgeben
        $rows = json_decode($resp);

        // leeres array anlegen
        $cat_daten = array();

        // Antwort auf das Filtern was benötigt wird
        if ($name != "") {

            foreach ($rows as $entry) {

                $id = addslashes($entry->id);
                $parent = addslashes($entry->parent);
                $cat_daten[$id] = $parent;
            }
        }

        // return array id=>parent
        return $cat_daten;
    }

    public static function detailCourse($id) {

        // Format
        $restformat = RESTFORMAT;
        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_get_courses';

        // holt die Details von einem Kurs, die ID muss bekannt sein
        $params = "options[ids][0]=" . $id;

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        // Hier gezielt nur Shortname ausgeben
        $rows = json_decode($resp);

        // leeres array anlegen
        $course_daten = array();

        // Antwort auf das Filtern was benötigt wird
        if ($id != NULL) {

            foreach ($rows as $entry) {

                $shortname = addslashes($entry->shortname);
                echo " shortname: " . $shortname;
                $course_daten[] = $shortname;
            }
        }
        // return array mit oder ohne id
        return $course_daten;
    }

    public static function detailCourseVisible($id) {

        // Format
        $restformat = RESTFORMAT;
        // wichtig welche Funktion soll aufgerufen werden!
        $functionname = 'core_course_get_courses';

        // holt die Details von einem Kurs, die ID muss bekannt sein
        $params = "options[ids][0]=" . $id;

        // Header passend setzen!
        header('Content-Type: text/plain');
        $serverurl = DOMAINNAME . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        // require_once('./curl.class.php');
        $curl = new curl();
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);

        // Hier gezielt nur Shortname ausgeben
        $rows = json_decode($resp);

        // leeres array anlegen
        $course_daten = array();

        // Antwort auf das Filtern was benötigt wird
        if ($id != NULL) {

            foreach ($rows as $entry) {

                $visible = addslashes($entry->visible);
                // echo " visible: " . $visible;
                $course_daten[] = $visible;
            }
        }
        // return array mit oder ohne id
        return $course_daten;
    }
}
