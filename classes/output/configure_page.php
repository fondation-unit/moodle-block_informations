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

namespace block_informations\output;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/blocks/informations/locallib.php');

use moodle_url;
use renderable;
use templatable;
use renderer_base;
use stdClass;
use help_icon;
use core_course_category;


class configure_page implements renderable, templatable {
    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output The renderer
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        global $CFG;

        $namehelp = new help_icon('cc_licence_name_desc', 'block_informations');
        $licencehelp = new help_icon('cc_licence_url_desc', 'block_informations');
        $imagehelp = new help_icon('cc_image_url_desc', 'block_informations');

        $licences = block_informations_get_all_licences();

        $data = new stdClass();
        $data->wwwroot = $CFG->wwwroot;
        $data->licences = $licences;

        $deleteurl = new moodle_url('/blocks/informations/deletelicence.php', array('sesskey' => sesskey(), 'returnto' => 'configure'));
        $data->deleteurl = $deleteurl->out();

        $data->namehelp = $namehelp;
        $data->licencehelp = $licencehelp;
        $data->imagehelp = $imagehelp;
        $data->categories = [
            ['id' => NULL, 'name' => get_string('licence_category_empty', 'block_informations')]
        ];

        $categories = block_informations_get_available_categories();
        foreach($categories as $category) {
            $data->categories[] = [
                'id' => $category->id,
                'name' => $category->name
            ];
        }

        return $data;
    }
}
