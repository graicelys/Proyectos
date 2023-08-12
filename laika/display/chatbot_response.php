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
 
function display_chatbot_responde() {

    global $DB,$USER;
    
 
    $userqfields = \core_user\fields::for_name()->with_identity($context);
    $userqfieldssql = $userqfields->get_sql('q');
 
    // Obtener el ultimo registro is_bot.
    $sqlBot = "SELECT u.is_bot
         FROM {laika_user_questions} AS u
         ORDER BY u.id DESC
         LIMIT 1";

    $bot = $DB->get_records_sql($sqlBot);
    $bot2 = reset($bot);
    $botValue = $bot2->is_bot;

    $respuestaR = array('success' => false);
 
    if ($botValue == 1) {

        $Isbot = true;

    }else {
        $Isbot = false;
        
        // Obtener contentuser que guardó el usuario.
        $sql = "SELECT u.contentuser
        FROM {laika_user_questions} AS u
        ORDER BY u.id DESC
        LIMIT 1";

        $contentuser = $DB->get_records_sql($sql);
        $contentuserR = reset($contentuser);
        $contentuserValue = $contentuserR->contentuser;
        $contentuserValue = ucfirst(strtolower($contentuserValue));

        // Realiza la comparación con contentuserValue.
        $userqfields = \core_user\fields::for_name()->with_identity($context);
        $userqfieldssql = $userqfields->get_sql('a');
        $sql = "SELECT q.id,q.contentq, a.content, q.answer_id{$userqfieldssql->select}
            FROM {laika_exact_questions} AS q
            INNER JOIN {laika_answers} AS a ON q.answer_id = a.id";

        $contentqq = $DB->get_records_sql($sql);
        $bestMatch = '';
        $bestMatchDistance = PHP_INT_MAX;

        // Buscar la mejor coincidencia
        foreach ($contentqq as $row) {

            $contentqValue = $row->contentq;
            $distance = levenshtein($contentuserValue, $contentqValue);

            if ($distance < $bestMatchDistance) {

                $bestMatch = $contentqValue;
                $bestMatchDistance = $distance;

                // Guardar el objeto completo en caso de que sea la mejor coincidencia
                $bestMatchRow = $row;
            }
       }

    // Establecer un umbral de similitud para considerar una coincidencia
    $maxDistanceThreshold = 5; // Por ejemplo, una distancia máxima de 5

    if ($bestMatchDistance <= $maxDistanceThreshold) {
    // Se encontró una coincidencia con suficiente similitud
    // Registrar el contenido en laika_user.
    $campoVariable = $bestMatchRow->id;

    $chat_id = $USER->id;
    $exact_question_id = $campoVariable;
    $timecreated = time();
    $enabled = true;
    $is_bot = 1;

    $sql = "INSERT INTO {laika_user_questions}
        (chat_id, exact_question_id, timecreated, enabled, is_bot)
        VALUES ($chat_id, $exact_question_id, $timecreated, $enabled, $is_bot)";

    $DB->execute($sql);

        } else {
            $faulterror = 'No entiendo tu solicitud.';
            $sql = "SELECT q.contentq, a.content,q.answer_id, a.id {$userqfieldssql->select}
                FROM {laika_exact_questions} AS q
                INNER JOIN {laika_answers} AS a ON q.answer_id = a.id
                WHERE q.contentq = '" .  $faulterror. "'";

            $error = $DB->get_records_sql($sql);
            $errorR = reset($error);
            $errorValue = $errorR->content;

            $campoVariable =  $errorR->answer_id;
            $chat_id = $USER->id;
            $exact_question_id = $campoVariable;
            $timecreated = time();
            $enabled = true;
            $is_bot = 1;

            $sql = "INSERT INTO {laika_user_questions}
                (chat_id,exact_question_id,timecreated,enabled,is_bot)
                VALUES ($chat_id,$exact_question_id,$timecreated, $enabled,$is_bot)";

            $DB->execute($sql);
        }
        
        $respuestaR = array(
            'success' => true,
            'is_bot' => $Isbot
        );
        
        return $respuestaR;
   }
}

try {
    header('Content-type: application/json');
    die(json_encode(display_chatbot_responde()));
} catch (Exception $cu) {
 
    echo $cu->getMessage();
}