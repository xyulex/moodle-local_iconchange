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
include ('lib.php');

defined('MOODLE_INTERNAL') || die('');

$title = get_string('changeicons', 'local_iconchange');

$PAGE->set_url('/local/iconchange/list_icon.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);

echo $OUTPUT->header();

$url = IconChange::get_path();

echo html_writer::tag('h3', get_string('currenttheme', 'local_iconchange') . ': '. $CFG->theme);

$activities = array_filter(glob($url), 'is_dir');

if ($activities && !empty($activities)) {
    $data = IconChange::create_table_data($activities);    
    $data_table = IconChange::print_table_data($data);

    echo $data_table;   
}

echo $OUTPUT->footer();
?>