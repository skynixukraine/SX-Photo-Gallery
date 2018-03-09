<?php
/**
 * SX Photo Gallery initial class
 */

class SXPG_init {

    public function __construct() {
        $this->gallery  = new SXPG_gallery();
        $this->settings = new SXPG_settings();
    }

    public function init() {
        $this->gallery->init();
        $this->settings->init();
    }

}
