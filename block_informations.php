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

class block_informations extends block_base
{
    public function init() {
        $this->title = get_string('defaulttitle', 'block_informations');
    }

    public function instance_allow_multiple() {
        return false;
    }

    public function has_config() {
        return true;
    }

    public function instance_allow_config() {
        return true;
    }

    public function get_content() {
        global $PAGE, $OUTPUT;

        $this->content = new stdClass();
        $defaultlicence = get_config('block_informations', 'default_licence');
        $licenceid = $this->config && isset($this->config->licence) ? $this->config->licence : $defaultlicence;
        $text = get_string('defaulttext', 'block_informations');
        $defaultimage = get_config('block_informations', 'default_image');

        if (isset($defaultimage) && strlen($defaultimage) > 0) {
            $image = moodle_url::make_pluginfile_url(
                context_system::instance()->id,
                'block_informations',
                'default_image',
                null,
                null,
                $defaultimage);
        } else {
            $image = null;
        }

        if (!empty($this->config->text['text'])) {
            $text = $this->config->text['text'];
        }

        $licence = new \stdClass();
        $licence->licencename = null;
        $licence->licenceurl = null;
        $licence->licenceimage = null;

        $context = $PAGE->context;
        $coursecontext = $context->get_course_context();
        $coursecategory = block_informations_get_course_category($coursecontext);
        $licence = block_informations_category_licence($coursecategory);

        $renderer = $this->page->get_renderer('block_informations');

        if (!$licence) {
            // No category licence.
            if (!$licence = block_informations_get_licence($licenceid)) {
                // Render the block without a licence.
                $content = new \block_informations\output\content($text, $image, null, null, null);
                $this->content->text = $renderer->render($content);
                return $this->content;
            }
        }
        
        $content = new \block_informations\output\content(
            $text,
            $image,
            $licence->licencename,
            $licence->licenceurl,
            $licence->licenceimage
        );

        $this->content->text = $renderer->render($content);
        return $this->content;
    }

    public function specialization() {
        $defaulttitle = get_string('defaulttitle', 'block_informations');
        $defaulttext = get_string('defaulttext', 'block_informations');

        if (isset($this->config)) {
            $this->title = empty($this->config->title) ? $defaulttitle : $this->config->title;
            $this->text = empty($this->config->text) ? $defaulttext : $this->config->text;
        }
    }

    public function applicable_formats() {
        return array(
            'admin' => false,
            'site-index' => false,
            'course-view' => true,
            'mod' => true,
            'my' => false,
        );
    }
}
