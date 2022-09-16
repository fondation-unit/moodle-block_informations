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

function add_licence($licence) {
    global $DB;

    if ($licence->licencename && $licence->licenceurl && $licence->licenceimage) {
        $id = $DB->insert_record('block_informations_licences', $licence);

        if ($id) {
            $url = new moodle_url('/blocks/informations/configure.php');
            redirect($url);
        }
    }
    throw new moodle_exception('errorinsertingrecord', 'block_informations');
}

function get_licences() {
    global $DB;

    $licences = $DB->get_records('block_informations_licences');
    $items = [];
    foreach ($licences as $licence) {
        array_push($items, (array) $licence);
    }
    return $items;
}

function delete_licence($itemid, $redirecto) {
    global $DB;

    $params = ['id' => $itemid];
    if ($DB->delete_records('block_informations_licences', $params)) {
        $redirecto = new moodle_url('/blocks/informations/configure.php');
        redirect($redirecto);
    }
    throw new moodle_exception('errordeletingrecord', 'block_informations');
}

function get_licences_names() {
    global $DB;

    $licences = $DB->get_records('block_informations_licences');
    $items = [];
    foreach ($licences as $licence) {
        $items[$licence->id] = $licence->licencename;
    }
    return $items;
}


function get_licence($id) {
    global $DB;

    $licence = $DB->get_record('block_informations_licences', array('id' => $id));
    return $licence;
}
