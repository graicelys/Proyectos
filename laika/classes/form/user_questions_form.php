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


namespace local_laika\form;
defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');

class user_questions_form extends \moodleform {
/**
     * Defina la forma.
     */

  public function definition() {
    $mform = $this->_form;

    // Justify.
    $mform->addElement('html', '<div style=" display: flex; justify-content: center; align-items: center; text-align: justify;">');
    // Size.
    $mform->addElement('html','<div style="width: 600px; height: 600px;">');
    // header.
    $mform->addElement('html','<div class="header-container">');
    $mform->addElement('html','<h2>Laika</h2>');
    $mform->addElement('html', '</div>');
    // Sidebar, size and container.
    $mform->addElement('html','<div1 class="sidebar" style="width: 600px; height: 400px;">');
    $mform->addElement('html','<div class="chat-container">');
    $mform->addElement('html','<div class="chat-container1">');
    $mform->addElement('html','<div class="hasta-aqui">');
    $mform->addElement('html', '</div>');
    $mform->addElement('html', '</div>');
    $mform->addElement('html', '</div>');
    $mform->addElement('html', '</div1>');
    // Form, contentuser and submit.
    $mform->addElement('html', '<form id="user-questions-form" class="chat-form" method="POST" action="'.$this->_customdata["action"].'">');
    // Size.
    $mform->addElement('html','<div style="width: 600px; height: 400px;">');
    $mform->addElement('html', '<div class="chat-form-container">');
    $mform->addElement('textarea', 'contentuser', get_string('usercontent', 'local_laika'), array('id' => 'contentuserid', 'class' => 'chat-form-contentuser'));
    $mform->addElement('html', '<input type="submit" id="submit" name="submitmessage" class="chat-form-submit btn btn-primary" value="'.get_string('submit').'">');
    $mform->addElement('html', '</div>');
    $mform->addElement('html', '</div>');
    $mform->addElement('html', '</form>');
    $mform->addElement('html', '</div>');
    $mform->addElement('html', '</div>');
    
    
  }
}

      

        //$mform = $this->_form; // ¡No olvides el guión bajo! 
    
        // Formulario de la tabla laika_user_questions.  
   /* $mform->addElement('textarea', 'contentuser', get_string('usercontent', 'local_laika'));
    $mform->setType('contentuser', PARAM_TEXT);
    
    // Enviar.
    $submitlabel = get_string('submit');
    $mform->addElement('submit', 'submitmessage', $submitlabel);

    // Agregar una clase CSS al formulario
   $mform->updateAttributes(array('class' => 'chat-form'));

    // Agregar una clase CSS al campo contentuser
    $mform->getElement('contentuser')->updateAttributes(array('class' => 'chat-form-contentuser'));
    $mform->getElement('submitmessage')->updateAttributes(array('class' => 'chat-form-submit'));
    */

    //echo"<link rel='stylesheet' type='text/css' href='form.css'>";
 ////////////////////////////////////////////

 


