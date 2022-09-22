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

if ($ADMIN->fulltree) {
    $configureurl = "{$CFG->wwwroot}/blocks/informations/configure.php?action=add&amp;sesskey={$USER->sesskey}";
    $configurestr = get_string('licences_configuration', 'block_informations');

    $template = <<< EOD
    <div class="yui-content mb-5">
        <a href="{$configureurl}">{$configurestr}</a>
    </div>
    EOD;

    $settings->add(new admin_setting_heading('block_informations', new lang_string('configuration_settings', 'block_informations') .
        null, $template));

    $settings->add(new admin_setting_configselect(
        'block_informations/default_licence',
        new lang_string('settings:default_licence', 'block_informations'),
        new lang_string('settings:default_licence_desc', 'block_informations'),
        null,
        block_informations_get_licences_names())
    );

    $settings->add(new admin_setting_configstoredfile(
        'block_informations/image',
        new lang_string('settings:image', 'block_informations'),
        new lang_string('settings:image_desc', 'block_informations'),
        'image',
        0,
        ['accepted_types' => ['image']])
    );

    $settings->add(new admin_setting_configtext(
        'block_informations/image_url',
        new lang_string('settings:image_url', 'block_informations'),
        new lang_string('settings:image_url_desc', 'block_informations'),
        '',
        PARAM_URL)
    );

    $settings->add(new admin_setting_configtext(
        'block_informations/imagealt',
        new lang_string('settings:image_alt', 'block_informations'),
        new lang_string('settings:image_alt_desc', 'block_informations'),
        '',
        PARAM_TEXT)
    );
}
