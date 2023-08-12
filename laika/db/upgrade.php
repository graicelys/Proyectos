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

 /**
 * Define upgrade steps to be performed to upgrade the plugin from the old version to the current one.
 *
 * @param int $oldversion Version number the plugin is being upgraded from.
 */
function xmldb_local_laika_upgrade($oldversion)
{
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2023042226) {

        // Define field userid to be added to local_laika.
        $table = new xmldb_table('local_laika');
        $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '1', 'timecreated');

        // Conditionally launch add field userid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }


        // Define key laika-user-foreigh-key (foreign) to be added to local_laika.
          $table = new xmldb_table('local_laika');
          $key = new xmldb_key('laika-user-foreigh-key', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);

        // Launch add key laika-user-foreigh-key.
          $dbman->add_key($table, $key);

        // Laika savepoint reached.
         upgrade_plugin_savepoint(true, 2023042226, 'local', 'laika');

        // Laika savepoint reached.
        upgrade_plugin_savepoint(true, 2023042226, 'local', 'laika');
    }

    return true;
}