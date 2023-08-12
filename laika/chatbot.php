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
require_once('../../config.php');
require_once($CFG->dirroot. '/local/laika/lib.php');
require_once($CFG->dirroot. '/local/laika/classes/form/user_questions_form.php');

function set_page_context_layout(){

    global $PAGE,$SITE,$CFG;

    $context = context_system::instance();
    $PAGE->set_context($context);
    $PAGE->set_url(new moodle_url('/local/laika/chatbot.php'));
    $PAGE->set_pagelayout('standard');
    $PAGE->set_title($SITE->fullname);
    //$PAGE->set_heading(get_string('pluginname', 'local_laika'));
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

    $messageform = new \local_laika\form\user_questions_form();

   if ($data = $messageform->get_data()) {

    $contentuser = required_param('contentuser', PARAM_TEXT);
    //$contentuser = $data->contentuser;

    if (!empty($contentuser)) { //no tocar que si guarda.
            
            $record = new stdClass;
            $record->chat_id = $USER->id;
            $record->contentuser = $contentuser;
            //$record->exact_question_id = $answer;
            $record->timecreated = time();
            $record->enabled = true;
            $record->is_bot = 0;

      
            $insert_id = $DB->insert_record('laika_user_questions', $record);
            
            
            header('Content-Type: application/json');
            die(json_encode(['success' => true, 'insert_id' => $insert_id])); 
            exit();
        }
    }


    echo $OUTPUT->header();
    //Audio.
    echo'<audio id="myaudio" controls style="display: none;">
    <source src="audio/welcome.mp3" type="audio/mp3">
        Tu navegador no soporta audio HTML5.
    </audio>';

    //Botones
    
    echo"<p><p/>";
    echo" <a class='btn btn-primary text left' href='index.php' role='button'>Ir a inicio</a>";
    if(has_capability('moodle/site:config',context_system::instance())){
        echo" <a class='btn btn-primary text left' href='capability/answer.php' role='button'>Ir a escribir respuestas para el chat</a>";
        echo" <a class='btn btn-primary text left' href='capability/exact_question.php' role='button'>Ir a escribir preguntas para el chat</a>";
        echo"<p></p>";
   }
  /*echo"<pre>";
   var_dump($insert_id);
   die();*/
    $messageform->display();
}



function show_footer(){

    global $OUTPUT;

   echo"<link rel='stylesheet' type='text/css' href='style/style_chatbot.css'>";

    echo "<script src='https://code.jquery.com/jquery-3.7.0.min.js' 
           integrity='sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g='crossorigin='anonymous'></script>";
    echo "<script src='javascript/check.js'></script>";
    echo "<script src='javascript/audio.js'></script>";
    echo "<script src='javascript/chatbot_functionh.js'></script>";
    echo "<script src='javascript/delete_chatbot_time_hms.js'></script>";
    
    

  
   
    echo $OUTPUT->footer();
}

try {

    set_page_context_layout();
    require_user_login();
    handle_form_submission();
    show_footer();

    } catch (Exception $cu) {
    
    echo $cu->getMessage();
}