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


function block_informations_add_licence($licence) {
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

function block_informations_get_all_licences() {
    global $DB;

    $licences = $DB->get_records('block_informations_licences');
    $items = [];
    foreach ($licences as $licence) {
        $licence->categoryname = NULL;
        if ($licence->categoryid > 0) {
            $category = \core_course_category::get($licence->categoryid);
            $licence->categoryname = $category->name;
        }
        array_push($items, (array) $licence);
    }
    return $items;
}

function block_informations_delete_licence($itemid, $redirecto) {
    global $DB;

    $params = ['id' => $itemid];
    if ($DB->delete_records('block_informations_licences', $params)) {
        $redirecto = new moodle_url('/blocks/informations/configure.php');
        redirect($redirecto);
    }
    throw new moodle_exception('errordeletingrecord', 'block_informations');
}

function block_informations_get_licences_names() {
    global $DB;

    $licences = $DB->get_records('block_informations_licences');
    $items = [];
    foreach ($licences as $licence) {
        $items[$licence->id] = $licence->licencename;
    }
    return $items;
}


function block_informations_get_licence($id) {
    global $DB;

    $licence = $DB->get_record('block_informations_licences', array('id' => $id));
    return $licence;
}

function block_informations_get_available_categories() {
    global $DB;

    $categories = core_course_category::get_all(['returnhidden' => true]);
    $categories = array_map(function($obj) { return $obj->id;}, $categories);

    $usedcategoriesids = $DB->get_records_sql('SELECT DISTINCT(categoryid) as id FROM {block_informations_licences} WHERE categoryid IS NOT NULL');
    $usedcategoriesids = array_map(function($obj) { return $obj->id;}, $usedcategoriesids);

    $availablecategoriesids = array_diff($categories, $usedcategoriesids);
    $availablecategories = \core_course_category::get_many($availablecategoriesids);

    return $availablecategories;
}

function block_informations_category_licence($categoryid) {
    global $DB;

    $licence = $DB->get_record_sql('SELECT * FROM {block_informations_licences} WHERE categoryid = :categoryid', array('categoryid' => $categoryid));
    return $licence;
}

function block_informations_get_course_category($coursecontext) {
    global $DB;

    $categoryid = null;
    $courseid = $coursecontext->instanceid;
    $course = $DB->get_record('course', array('id' => $courseid), 'id, category');
    if ($course) {
        $categoryid = $course->category;
    }

    return $categoryid;
}
