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
 * Informations block settings
 *
 * @package    block_informations
 * @copyright  2024 Fondation UNIT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once("$CFG->dirroot/blocks/informations/locallib.php");

// No guest autologin.
require_login(0, false);
admin_externalpage_setup('manageblocks');

$configurenameparam     = optional_param('cc-licence-name', '', PARAM_TEXT);
$configurelicenceparam  = optional_param('cc-licence-url', '', PARAM_URL);
$configureimageparam    = optional_param('cc-image-url', '', PARAM_URL);
$configurecategoryparam = optional_param('categoryid', null, PARAM_INTEGER);

if ($configurelicenceparam && $configureimageparam) {
    $licence = new stdClass();
    $licence->licencename = $configurenameparam;
    $licence->licenceurl = $configurelicenceparam;
    $licence->licenceimage = $configureimageparam;
    $licence->categoryid = $configurecategoryparam;
    block_informations_add_licence($licence);
}

$systemcontext = context_system::instance();
$pageurl = new moodle_url('/blocks/informations/configure.php');
$PAGE->set_url($pageurl);
$PAGE->set_title("{$SITE->shortname}: " . get_string('licences_configuration', 'block_informations'));
$PAGE->set_context($systemcontext);
$PAGE->navbar->add(get_string('pluginname', 'block_informations'));
$output = $PAGE->get_renderer('block_informations');


echo $output->header();

$page = new \block_informations\output\configure_page();
echo $output->render($page);

echo $output->footer();
