<?php

include ('../../config.php');
include ('lib.php');

defined('MOODLE_INTERNAL') || die('');

$PAGE->set_url('/local/iconchange/list_icon.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('changeicons', 'local_iconchange'));
$PAGE->set_heading(get_string('changeicons', 'local_iconchange'));

echo $OUTPUT->header();

$activities = IconChange::get_mod_path();

if ($activities && !empty($activities)) {
    foreach ($activities as $a) {
        $a = explode('/', $a);
        $a = end($a);
        // To do. change depending on path.
        $currentimage = "{$CFG->wwwroot}/mod/{$a}/pix/icon.png";
        
        $url = new moodle_url('edit_icon.php', [ 'activityname' => $a ]);
        $options = html_writer::link($url, $OUTPUT->pix_icon('t/editstring', get_string('edit')));

        $data[] = array($a, '<img src="'.$currentimage.'" style="width:32px">',$options); // Change to moodle_url
    }
    $table = new html_table();
    $table->head = array(mb_strtoupper(get_string('activity')), mb_strtoupper(get_string('icon')), mb_strtoupper(get_string('edit')));
    $table->align = array('left', 'left', 'left');
    $table->data = $data;
    echo html_writer::table($table);
}

echo $OUTPUT->footer();
?>
