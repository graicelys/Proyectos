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


class answer_form extends \moodleform {
/**
     * Defina la forma.
     */
      public function definition() {
        $mform = $this->_form; // ¡No olvides el guión bajo! 
        
        // Formulario de la tabla Laika_answers.
        $mform->addElement('textarea', 'content', get_string('responsecontent', 'local_laika'));
        $mform->setType('content', PARAM_TEXT);

        // Enviar.
        $submitlabel = get_string('submit');
        $mform->addElement('submit', 'submitmessage', $submitlabel);
      }
    }
