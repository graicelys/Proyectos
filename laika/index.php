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

 
 // Requiere.
require_once('../../config.php');
require_once($CFG->dirroot. '/local/laika/lib.php');
require_once($CFG->dirroot. '/local/laika/classes/form/chat_interaction_form.php');

function set_page_context_layout(){

    global $PAGE,$SITE,$CFG;

    $context = context_system::instance();
    $PAGE->set_context($context);
    $PAGE->set_url(new moodle_url('/local/laika/index.php'));
    $PAGE->set_pagelayout('standard');
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading(get_string('pluginname', 'local_laika'));

}

function require_user_login(){

    global $USER;

    require_login();
    if (isguestuser()) {
    throw new moodle_exception('noguest');
    }
}

function handle_form_submission(){

    global $DB,$PAGE,$OUTPUT,$USER;

    $messageform = new \local_laika\form\chat_interaction_form();
    
    if ($data = $messageform->get_data()) {

     $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
     $user_id++;
     //actualizar el valor el valor del número de sesion.
     $_SESSION['user_id'] = $user_id;
    
        if (!empty($user_id)) { //no tocar que si guarda.
            $record = new stdClass;
            $record->created = time();
            $record->user_id = $user_id;	
            $record->status = true;
            $record->user = $USER->id;
        
            $DB->insert_record('laika_chat', $record);
            header("Location: chatbot.php");

           
        
        }
    }

    echo $OUTPUT->header();
   
    
    $courseId = 2; // ID del curso en el que deseas permitir el acceso

    if ( has_capability('moodle/role:assign', context_system::instance()) || is_enrolled(context_course::instance($courseId), $USER->id)) {

        echo'<p><p/>';
        echo '<img src="images/login.jpg" alt="login" style="width: 785px; height: 330px;">';
        echo'<p><p/>';
        $messageform->display();
        
    } else {
        echo '<p></p>';
        echo '<div class="alert alert-primary">';
        echo '<h3>No tienes autorización para ingresar a Laika.</h3>';
        echo '</div>';
        echo '<img src="images/403.jpg" alt="403" style="width: 785px; height: 330px;">';
       
    } 
}

function display_user_id_records(){

    global $DB,$OUTPUT;

    $user_id = $DB->get_records('laika_chat');

    echo $OUTPUT->footer();
}

try {

    set_page_context_layout();
    require_user_login();
    handle_form_submission();
    display_user_id_records();

    } catch (Exception $ui) {
    
    echo $ui->getMessage();
}


