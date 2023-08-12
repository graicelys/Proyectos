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
require_once($CFG->dirroot. '/local/laika/classes/form/answer_form.php');

// Establecer contexto y configuración de la página
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/laika/capability/answer.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('pluginname', 'local_laika'));

// Requiere estar registrado.
require_login();
if (isguestuser()) {
throw new moodle_exception('noguest');
}

// Van Justo ante de $messageform = new \local_laika\form\message_form();.
$allowpost = has_capability('local/laika:postmessages', $context);
$allowview = has_capability('local/laika:viewmessages', $context);
$deleteanypost = has_capability('local/laika:deleteanymessage', $context);
 
// Ahora elimina al dar click.
$action = optional_param('action', '', PARAM_TEXT);
if ($action == 'del') {
    $id = required_param('id', PARAM_INT);
 
    $DB->delete_records('laika_answers', array('id' => $id));
}
 
// Esto crea una instancia del formulario.
$messageform = new \local_laika\form\answer_form();
if ($data = $messageform->get_data()) {
    require_capability('local/laika:postmessages', $context);
    require_capability('local/laika:viewmessages', $context);
    require_capability('local/laika:deleteanymessage', $context);
    $content = required_param('content', PARAM_TEXT);
 
    // Formulario laika_answers.
    if (!empty($content)) { //no tocar que si guarda.
        $record = new stdClass;
        $record->content = nl2br($content);
        $record->enabled = true;
         
        $DB->insert_record('laika_answers', $record);
        redirect($PAGE->url);
    }
}

echo $OUTPUT->header();
// Logiando...
/*if (isloggedin()) {
    echo local_laika_get_laika($USER);
} else {
    echo get_string('laikauser', 'local_laika');
}*/
echo"<p></p>";
echo" <a class='btn btn-primary' href='../index.php' role='button'>Ir a inicio</a>";
echo" <a class='btn btn-primary' href='exact_question.php' role='button'>Ir a escribir preguntas para el chat</a>";
echo"<p></p>";

// Esto mostrará el formulario en la página.
if ($allowpost) {
    $messageform->display();
}

echo '<p></p>';
        echo '<div class="alert alert-primary">';
        echo '<h5>Se recomienda que se escriban las respuestas con mayúscula inicial.</h5>';
        echo '</div>';
    echo'<p></p>';

if (has_capability('local/laika:viewmessages', $context)) {
    
    $sql = "SELECT m.content, m.id 
        FROM {laika_answers} AS m";

    $messages = $DB->get_records_sql($sql);
    echo $OUTPUT->box_start('card-columns');
 
    foreach ($messages as $m) {

        echo html_writer::start_tag('div', array('class' => 'card', 'style' => "background: #FDEBD0"));
        echo html_writer::start_tag('div', array('class' => 'card-body'));
        //echo html_writer::tag('p', format_text($m->id,  FORMAT_PLAIN), array('class' => 'card-text'));
        echo html_writer::tag('p', format_text($m->content,  FORMAT_PLAIN), array('class' => 'card-text'));
        echo html_writer::start_tag('p', array('class' => 'card-text'));
     
        if ($deleteanypost) {

            echo html_writer::start_tag('p', array('class' => 'card-footer text-center'));
            echo html_writer::link(
            new moodle_url(
                '/local/laika/capability/answer.php', 
                array('action' => 'del', 'id' => $m->id)),
                $OUTPUT->pix_icon('t/delete', 'ALT') . get_string('delete'),
                array('class'=>'btn btn-primary')
            );
            echo html_writer::end_tag('p');
        }

        echo html_writer::end_tag('div');
        echo html_writer::end_tag('div');
    }
    
    echo $OUTPUT->box_end();  
}

echo $OUTPUT->footer();

