<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot."/lib/formslib.php");

class edit_icon_form extends moodleform
{

    public function definition()
    {
        $mform = $this->_form;
        $activityname = !empty(filter_input(INPUT_GET, 'activityname')) ? filter_input(INPUT_GET, 'activityname') : '-';

        $mform->addElement('hidden', 'activityname', $activityname);
        $mform->setType('activityname', PARAM_TEXT);
        $mform->addElement('filepicker', 'newicon', get_string('file'), null,
            array('accepted_types' => 'png,svg'));
        $mform->setType('newicon', PARAM_RAW);
        $this->add_action_buttons(true, get_string('save'));
    }
}
