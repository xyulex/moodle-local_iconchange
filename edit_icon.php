<?php
// This file is part of the local_iconchange plugin for Moodle - http://moodle.org/
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
 * Icon changer
 * A Moodle plugin for changing your theme icons
 * @package     local
 * @copyright   2019 Raúl Martínez <raulmartinez911@hotmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

include ('../../config.php');
defined('MOODLE_INTERNAL') || die('');

require_once($CFG->dirroot.'/local/iconchange/edit_icon_form.php');

$PAGE->set_url('/local/iconchange/edit_icon.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('changeicons', 'local_iconchange'));
$PAGE->set_heading(get_string('changeicons', 'local_iconchange'));
$activityname = optional_param('activityname', 0, PARAM_TEXT);

if (!$activityname) {
    redirect($CFG->wwwroot . '/local/iconchange/list_icon.php');
}

$mform = new edit_icon_form();

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/local/iconchange/list_icon.php'));
} else if ($fromform = $mform->get_data()) {

    if (!file_exists($CFG->dirroot.'/theme/'.$CFG->theme.'/pix_plugins/mod/'.$activityname)) {
        if (!mkdir($CFG->dirroot.'/theme/'.$CFG->theme.'/pix_plugins/mod/'.$activityname, 0777)) {
            echo $OUTPUT->error_text(get_string('cantcreatedirectory', 'local_iconchange'));
        }
    }

    // To do. BOOST
    $success = $mform->save_file('newicon', $CFG->dirroot.'/theme/'.$CFG->theme.'/pix_plugins/mod/'.$activityname.'/icon.png', true);
    theme_reset_all_caches();
    redirect($CFG->wwwroot . '/local/iconchange/list_icon.php', get_string('iconupdated', 'local_iconchange'), null, \core\output\notification::NOTIFY_SUCCESS);
} else {
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('changeicons', 'local_iconchange') . ': ' . $activityname);
    echo $OUTPUT->box_start('generalbox');
    echo $OUTPUT->box_end();
    $mform->display();
    echo $OUTPUT->footer();
}