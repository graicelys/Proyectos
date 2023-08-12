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

 function require_user_login(){

    global $USER;

    require_login();
    if (isguestuser()) {
    throw new moodle_exception('noguest');
    }
}
 
 function display_contentuser_records(){
 
     global $DB,$USER;
     


$userqfields = \core_user\fields::for_name()->with_identity($context);
$userqfieldssql = $userqfields->get_sql('q');

$user = $USER->id;

$sql = "SELECT u.id,u.is_bot, u.chat_id,u.contentuser,u.exact_question_id ,u.timecreated, u.enabled, q.contentq,q.answer_id, a.content {$userqfieldssql->select}
    FROM {laika_user_questions} AS u 
    INNER JOIN {laika_exact_questions} AS q ON u.exact_question_id = q.id 
    INNER JOIN {laika_answers} AS a ON q.answer_id = a.id
    WHERE u.chat_id = :user_id
    ORDER BY u.id ASC";

    $params = array('user_id' =>$user);

   $exact_question_id = $DB->get_records_sql($sql,$params);

   echo '<div class="message-container">';
   
foreach ($exact_question_id as $m) {
    // Establecer la zona horaria de Venezuela
    date_default_timezone_set('America/Caracas');
    echo '<div class="message">';
    
    if ($m->is_bot == 0) {
    
        echo '<div class="alert alert-primary text-left">';
        if (isloggedin()) {
            echo '<div class="image-container-user">';
            echo '<img src="images/user.png" alt="user" style="width: 80px; height: 80px;">';
            echo '</div>';
        } else {
            echo '<div class="image-container-user">';
            echo '<img src="images/user.png" alt="user" style="width: 80px; height: 80px;">';
            echo '</div>';
        }
        if (isloggedin()) {
            echo local_laika_get_laika($USER);
        } else {
            echo get_string('laikauser', 'local_laika');
        }
        echo '<strong>escribió:</strong><br>';
        echo '<h6>' . $m->contentuser . '</h6>';
        echo'<p></p>';
        echo'<p></p>';
        echo '<small class="text-muted">' . date('d M Y H:i', $m->timecreated) . '</small>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-secondary text-left">';
        echo '<div class="image-container-laika">';
        echo '<img src="images/laika.png" alt="laika" style="width: 80px; height: 80px;">';
        echo '</div>';
        echo '<strong> Laika respondió:</strong><br>';
        echo '<h6>' . $m->contentuser . ' ' . $m->content . '</h6>';
        echo'<p></p>';
        echo '<small class="text-muted">' . date('d M Y H:i', $m->timecreated) . '</small>';
        echo '</div>';
    }
    echo '</div>';
   
}
echo '</div>';

}

try {
    require_user_login();
    display_contentuser_records();
     
    } catch (Exception $cu) {
     
    echo $cu->getMessage();
    }
 