<?php
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
   
    // To do. Save depending on URL.
    $success = $mform->save_file('newicon', $CFG->dirroot.'/mod/'.$activityname.'/pix/icon.svg', true);
    redirect($CFG->wwwroot . '/local/iconchange/list_icon.php', get_string('iconupdated', 'local_iconchange'), null, \core\output\notification::NOTIFY_SUCCESS);
} else {
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('changeicons', 'local_iconchange') . ': ' . $activityname);
    echo $OUTPUT->box_start('generalbox');
    echo $OUTPUT->box_end();
    $mform->display();
    echo $OUTPUT->footer();
}