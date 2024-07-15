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

use plugin_renderer_base;

class renderer extends plugin_renderer_base {
    /**
     *
     * @param content $output
     *
     * @return string html for the page
     */
    public function render_content(content $output) {
        $data = $output->export_for_template($this);
        return parent::render_from_template('block_informations/content', $data);
    }

    /**
     *
     * @param configure_page $output
     *
     * @return string html for the page
     */
    public function render_configure_page(configure_page $output) {
        $data = $output->export_for_template($this);
        return parent::render_from_template('block_informations/configure_page', $data);
    }
}
