#!/bin/bash

# 
# Das Skript erstellt ein lock damit das Skript nicht mehrmals gleichzeitig laufen kann.
# Die Datei wird später in die anderen Skripte eingebunden.
# Wird das das Skript nochmals gestartet wird es direkt beendet es findet kein Queue statt
# Copyright (C) 2021-2022 Tim-Florian Reinartz
# 
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published
# by the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
# 
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <https://www.gnu.org/licenses/>.
#

#create exclusive lock
exec 100>/opt/moodle-rest-cron/moodlelock.lock || exit 1
flock -n 100 || exit 1
# remove lock on exit
trap 'rm -f /opt/moodle-rest-cron/moodlelock.lock' EXIT
