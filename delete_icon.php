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

$deleteicons = get_string('changeicons', 'local_iconchange');

$PAGE->set_url('/local/iconchange/delete_icon.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title($deleteicons);
$PAGE->set_heading($deleteicons);

$deleteiconname = filter_input(INPUT_GET, 'activityname');

// TO DO. Boost.
$path = "{$CFG->dirroot}/theme/{$CFG->theme}/pix_plugins/mod/";

$filename =  $path . $deleteiconname.'/icon.png';

if (!file_exists($filename)) {
    redirect($CFG->wwwroot . '/local/iconchange/list_icon.php', get_string('iconnotdeleted', 'local_iconchange'), null, \core\output\notification::NOTIFY_ERROR);
} else {
    unlink($filename);
    theme_reset_all_caches();
    redirect($CFG->wwwroot . '/local/iconchange/list_icon.php', get_string('icondeleted', 'local_iconchange'), null, \core\output\notification::NOTIFY_SUCCESS);
}