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
 * @copyright  2024 Fondation UNIT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_informations\output;

use renderable;
use renderer_base;
use templatable;

class content implements renderable, templatable {
    public $text;
    public $image;
    public $licencename;
    public $licenceurl;
    public $licenceimage;

    /**
     * Constructor.
     *
     * @param  string $text
     * @param  string $image
     * @param  string $licencename
     * @param  string $licenceurl
     * @param  string $licenceimage
     * @return void
     */
    public function __construct($text, $image, $licencename, $licenceurl, $licenceimage) {
        $this->text = $text;
        $this->image = $image;
        $this->licencename = $licencename;
        $this->licenceurl = $licenceurl;
        $this->licenceimage = $licenceimage;
    }

    /**
     * Export the data for the template.
     *
     * @param \renderer_base $output
     * @return array
     */
    public function export_for_template(renderer_base $output) {
        $data = array(
            'content' => $this->text,
            'image' => $this->image ? $this->image : null,
            'licencename' => $this->licencename,
            'licenceurl' => $this->licenceurl,
            'licenceimage' => $this->licenceimage,
            'imagealt' => get_config('block_informations', 'image_alt')
        );
        return $data;
    }
}
