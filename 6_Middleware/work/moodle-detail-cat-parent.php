<?php
/*
 * Details per REST zu einer Kategorie in Moodle
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

// config file einbinden
// config liegt z.b. einen Ordner drüber
// require_once ('../config.inc.php');

/* Lese Parameter name */
if (isset($_GET["name"])) {
    $name = (string) htmlspecialchars($_GET["name"]);
} else {
    $name = "";
}

if (isset($_GET["parent"])) {
    $parent = (string) htmlspecialchars($_GET["parent"]);
} else {
    $parent = "";
}

//aufruf der Methode in der Klasse mit Übergabe der Parameter
$catarry = Moodlerest::detailCatParent($name);

$catid = array_search($parent, $catarry);

// catid zum angegebenen parent
if (empty($catid)) {
    $nocatid = 0;
    echo $nocatid;
} else {

    echo $catid;
}
