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
 * Informations block
 *
 * @package    block_informations
 * @copyright  2022 Fondation UNIT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->dirroot/blocks/informations/locallib.php");

class block_informations_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        // Titre de l'en-tête de section selon le fichier de langue.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Block title.
        $mform->addElement('text', 'config_title', get_string('blocktitle', 'block_informations'));
        $mform->setDefault('config_title', "Informations");
        $mform->setType('config_title', PARAM_TEXT);

        // Block text.
        $mform->addElement('editor', 'config_text', get_string('blockstring', 'block_informations'));
        $mform->setType('config_text', PARAM_RAW);

        // Images.
        $options = array(
            // TODO    
        );
        $mform->addElement('select', 'config_image', get_string('image', 'block_informations'), $options);
        $mform->setDefault('config_image', 'unit-informations');

        // Licences.
        $licences = block_informations_get_all_licences_names();
        $mform->addElement('select', 'config_licence', get_string('licences', 'block_informations'), $licences);
        $mform->setDefault('config_licence', '');

        // Author.
        $mform->addElement('text', 'config_author', get_string('config:author', 'block_informations'));
        $mform->setDefault('config_author', '');
        $mform->setType('config_author', PARAM_TEXT);
    }
}
