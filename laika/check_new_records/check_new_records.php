<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_laika
 * @copyright   2023 graicelys volcan <graicelys@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 //funciona bien.
require_once('../../../config.php');
require_once($CFG->dirroot. '/local/laika/lib.php');

function check_new_records(){

    global $DB;

    $recentTime = time() - 60;
    $sql = "SELECT COUNT(*) AS count FROM {laika_chat} WHERE created > :recenttime";
    $params = ['recenttime' => $recentTime];

    $result = $DB->get_record_sql($sql,$params);

    return $result->count > 0;
}

$hasNewRecords = check_new_records();

header('Content-type: application/json');
echo json_encode($hasNewRecords); 