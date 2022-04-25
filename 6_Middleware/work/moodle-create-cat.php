<?php
/*
 * Erstellt per REST eine Kategorie in Moodle
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

/* Lese Parameter parent */
if (isset($_GET["parent"])) {
    $parent = (int) htmlspecialchars($_GET["parent"]);
    // id enthält nur 0-9
    if (! preg_match("#^[0-9]+$#", $parent)) {
        $parent = NULL;
    } else {
        // noop
    }
} else {
    // wenn nichts übergeben wurde
    $parent = NULL;
}

/* Lese Parameter description */
if (isset($_GET["description"])) {
    $description = (string) htmlspecialchars($_GET["description"]);
} else {

    $description = "";
}

//aufruf der Methode in der Klasse mit Übergabe der Parameter
$catid = Moodlerest::createCat($name, $parent, $description);

if (empty($catid[0])) {
    $itiszero = 0;
    echo $itiszero;
} else {
    echo $catid[0];
}
