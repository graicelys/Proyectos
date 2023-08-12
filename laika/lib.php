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

 function local_laika_get_laika($user) {
    if ($user == null) {
        return get_string('laikauser', 'local_laika');
    }

    $country = $user->country;
    switch ($country) {
        case 'ES':
            $langstr = 'laikauseres';
            break;
        default:
            $langstr = 'laikalogedinuser';
            break;
    }

    return get_string($langstr, 'local_laika', fullname($user));
}


/**
 * Inserte un enlace a index.php en el menú de navegación de la página principal del sitio.
 *
 * @param navigation_node $frontpage Nodo que representa la portada en el árbol de navegación.
 */

function local_laika_extend_navigation_frontpage(navigation_node $frontpage) {
    $frontpage->add(
        get_string('pluginname', 'local_laika'),
        new moodle_url('/local/laika/index.php'),
    );
}


