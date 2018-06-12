<?php
/**
 * Test controller
 *
 * @copyright 2009-2018 Vanilla Forums Inc.
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU GPL v2
 * @package Vanilla
 * @since 2.0
 */

class TestController extends VanillaController {

    public function index() {
        $this->render();
    }

    public function v8js() {
        $this->render();
    }

    public function react() {
        $this->render();
    }
}
