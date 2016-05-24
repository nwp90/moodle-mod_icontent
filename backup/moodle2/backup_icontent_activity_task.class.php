<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Defines backup_icontent_activity_task class
 *
 * @package   mod_icontent
 * @category  backup
 * @copyright 2016 Leo Renis Santos <leorenis@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/icontent/backup/moodle2/backup_icontent_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the icontent instance
 *
 * @package   mod_icontent
 * @category  backup
 * @copyright 2015 Leo Renis Santos <leorenis@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_icontent_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the icontent.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_icontent_activity_structure_step('icontent_structure', 'icontent.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $icontent some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the icontent with the URLs encoded
     */
    static public function encode_icontent_links($icontent) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, '/');

        // Link to the list of icontents.
        $search = '/('.$base.'\/mod\/icontent\/index.php\?id\=)([0-9]+)/';
        $icontent = preg_replace($search, '$@CONTENTINDEX*$2@$', $icontent);

        // Link to icontent view by moduleid.
        $search = '/('.$base.'\/mod\/icontent\/view.php\?id\=)([0-9]+)/';
        $icontent = preg_replace($search, '$@CONTENTVIEWBYID*$2@$', $icontent);

        return $icontent;
    }
}
