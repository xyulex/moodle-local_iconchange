<?php

class IconChange {	
	
	public static function get_mod_path() {
		global $CFG, $PAGE;
		
		// Check theme parents.
		$current_theme = $CFG->theme;
		$current_theme_parents = $PAGE->theme->parents;
		
		if ($current_theme_parents) {
			foreach($current_theme_parents as $p) {
				if ($p == 'boost') {
					$url = IconChange::child_boost_url($current_theme);
				}

				if ($p == 'remui') {
					$url = IconChange::child_remui_url($current_theme);	
				}
			}

		} else {
			// Fallback to core.		
			switch ($current_theme) {
			    case 'boost': // Boost core.
			        $url = "{$CFG->dirroot}/mod/*";
			        break;
			    case 'remui': // RemUI core.
			        $url = "{$CFG->dirroot}/theme/remui/pix_plugins/mod/*";
			        break;
			}

			
	    }	
	    $activities = array_filter(glob($url), 'is_dir');

		return $activities;
	}

	public static function child_boost_url($current_theme) {
		global $CFG;
		echo '<h2>Child boost</h2>';
		//to do.
		return "{$CFG->dirroot}/mod/*";
		
	}

	public static function child_remui_url($current_theme) {
		global $CFG;
		echo '<h2>Child remui</h2>';
		return "{$CFG->dirroot}/theme/{$current_theme}/pix_plugins/mod/*";	
	}

}

function local_iconchange_extend_navigation($navigation) {
	$systemcontext = context_system::instance();

	if(has_capability('moodle/site:config', $systemcontext)) {
		$node = $navigation->add(get_string('changeicons', 'local_iconchange'), new moodle_url('/local/iconchange/list_icon.php'), navigation_node::TYPE_CONTAINER, null, null, new pix_icon('i/edit',''));
		$node->showinflatnavigation = true;
	}

}