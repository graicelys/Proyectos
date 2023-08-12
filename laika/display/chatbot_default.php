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

 
    
    $sql = "SELECT u.contentuser
    FROM {laika_user_questions} AS u
    ORDER BY u.id DESC
    LIMIT 2
    OFFSET 1";

$contentuserD = $DB->get_records_sql($sql);

date_default_timezone_set('America/Caracas');


if (!empty($contentuserD)) {
    $contentuser = reset($contentuserD)->contentuser;
    if (stripos(strtolower($contentuser), 'tarea') !== false || stripos(strtolower($contentuser), 'tareas') !== false) {

        echo '<div class="alert alert-secondary text-left">';
        echo '<div class="image-container-laika">';
        echo '<img src="images/laika.png" alt="laika" style="width: 80px; height: 80px;">';
        echo '</div>';
        echo '<strong> Laika respondió:</strong>';
        echo"<p><strong> Pero esto puede ayudarte </strong></p>";

        echo "<h6>Para enviar una tarea, sigue estos pasos:<br />
        - Accede al curso y encuentra la tarea específica.<br />
        - Haz clic en el enlace de la tarea para abrir el formulario de envío.<br />
        - Adjunta el archivo de tu tarea o escribe tu respuesta directamente en el formulario.<br />
        - Si es necesario, proporciona comentarios adicionales o instrucciones relevantes.<br />
        - Finalmente, haz clic en el botón Enviar para enviar tu tarea.</h6>";

        echo'<p></p>';
        echo '<small class="text-muted">' . date('d M Y H:i') . '</small>';
        echo '</div>';

    } elseif (stripos(strtolower($contentuser), 'curso') !== false || stripos(strtolower($contentuser), 'cursos') !== false) {

        echo '<div class="alert alert-secondary text-left">';
        echo '<div class="image-container-laika">';
        echo '<img src="images/laika.png" alt="laika" style="width: 80px; height: 80px;">';
        echo '</div>';
        echo '<strong> Laika respondió:</strong>';
        echo"<p><strong> Pero esto puede ayudarte </strong></p>";

        echo "<h6>Para acceder a un curso, sigue estos pasos:<br />
        - En la página principal, busca la lista de cursos disponibles o utiliza la barra de búsqueda para encontrar un curso específico.<br />
        - Haz clic en el nombre del curso al que deseas acceder.<br />
        - Serás redirigido a la página del curso, donde encontrarás materiales, actividades y recursos relacionados con el curso.</h6>";

        echo'<p></p>';
        echo '<small class="text-muted">' . date('d M Y H:i') . '</small>';
        echo '</div>';
    }elseif (stripos(strtolower($contentuser), 'foro') !== false || stripos(strtolower($contentuser), 'foros') !== false) {

        echo '<div class="alert alert-secondary text-left">';
        echo '<div class="image-container-laika">';
        echo '<img src="images/laika.png" alt="laika" style="width: 80px; height: 80px;">';
        echo '</div>';
        echo '<strong> Laika respondió:</strong>';
        echo"<p><strong> Pero esto puede ayudarte </strong></p>";

        echo"<h6> Para participar en un foro de discusión, sigue estos pasos:<br />
        - Accede al curso y encuentra el foro de discusión en el que deseas participar.<br />
        - Haz clic en el título del tema de discusión que te interesa.<br />
        - Verás los mensajes existentes y un formulario para agregar tu respuesta.<br />
        - Escribe tu respuesta en el formulario y, si es necesario, adjunta archivos o enlaces relevantes.<br />
        - Finalmente, haz clic en el botón Enviar o Publicar para enviar tu respuesta al foro.</h6>";

        echo'<p></p>';
        echo '<small class="text-muted">' . date('d M Y H:i') . '</small>';
        echo '</div>';
    }elseif (stripos(strtolower($contentuser), 'perfil') !== false || stripos(strtolower($contentuser), 'perfiles') !== false) {

        echo '<div class="alert alert-secondary text-left">';
        echo '<div class="image-container-laika">';
        echo '<img src="images/laika.png" alt="laika" style="width: 80px; height: 80px;">';
        echo '</div>';
        echo '<strong> Laika respondió:</strong>';
        echo"<p><strong> Pero esto puede ayudarte </strong></p>";

        echo"<h6> Para actualizar tu perfil, sigue estos pasos:<br />
        - Haz clic en tu nombre de usuario en la esquina superior derecha y selecciona Perfil.<br />
        - Aquí puedes editar tu información personal, como tu nombre, dirección de correo electrónico, foto de perfil, etc.<br />
        - Después de realizar los cambios necesarios, asegúrate de guardar los cambios.<br />";
        
        echo'<p></p>';
        echo '<small class="text-muted">' . date('d M Y H:i') . '</small>';
        echo '</div>';
    }    
}
    
//echo json_encode($response);   
 