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

class IconChange {	
	
	public static function get_path() {
		global $CFG, $PAGE;
		
		if (array_key_exists(0, $PAGE->theme->parents)) {
			$parent = $PAGE->theme->parents[0];
			$url = "{$CFG->dirroot}/theme/{$parent}/pix_plugins/mod/*";

		} else {
			if ($CFG->theme == 'boost') { // To Do. Boost.
				$url = "{$CFG->dirroot}/mod/*";
			} else {
				$url = "{$CFG->dirroot}/theme/{$CFG->theme}/pix_plugins/mod/*";
			}
		}
		
		return $url;
	}

	public static function create_table_data($activities) {
		global $OUTPUT;

		foreach ($activities as $a) {
			$a = explode('/', $a);
			$a = end($a);

			$currentimage = $OUTPUT->image_url('icon', $a);

			$editicon = new moodle_url('edit_icon.php', [ 'activityname' => $a ]);

			$options = html_writer::link($editicon, $OUTPUT->pix_icon('t/edit', get_string('edit')));

			$deleteicon = new moodle_url('delete_icon.php', [ 'activityname' => $a ]);

	 		$deleteaction = new confirm_action(get_string('deleteconfirm', 'local_iconchange'));
			$delete = $OUTPUT->action_icon($deleteicon, new pix_icon('t/delete', get_string('delete')), $deleteaction);
			$options.= $delete;

			$imgattributes = ['style' => 'width: 32px'];

	        $img_tag = html_writer::img($currentimage, null, $imgattributes);

	        $data[] = [$a, $img_tag,$options];
    	}

        return $data;
	}

	public static function print_table_data($data) {
		 $table = new html_table();
    	$table->head = [mb_strtoupper(get_string('activity')), mb_strtoupper(get_string('icon')), mb_strtoupper(get_string('actions'))];
    	$table->align = ['left', 'left', 'left'];
    	$table->data = $data;
    	return html_writer::table($table);
	}
}

function local_iconchange_extend_navigation($navigation) {
	$systemcontext = context_system::instance();

	if(has_capability('moodle/site:config', $systemcontext)) {
		$node = $navigation->add(get_string('changeicons', 'local_iconchange'), new moodle_url('/local/iconchange/list_icon.php'), navigation_node::TYPE_CONTAINER, null, null, new pix_icon('i/edit',''));
		$node->showinflatnavigation = true;
	}
}