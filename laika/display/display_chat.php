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

 require_once('../../../config.php');
 require_once($CFG->dirroot. '/local/laika/lib.php');
 
// Consulta SQL para obtener el último registro de laika_user_questions
$sql = "SELECT id, exact_question_id FROM {laika_user_questions} ORDER BY id DESC LIMIT 1";
$lastQuestion = $DB->get_record_sql($sql);

// Verificar si se obtuvo el registro
if ($lastQuestion) {
    $response = array(
        'exact_question_id' => $lastQuestion->exact_question_id
    );
} else {
    $response = array(
        'exact_question_id' => ''
    );
}

// Devolver el resultado como JSON
header('Content-Type: application/json');
echo json_encode($response);