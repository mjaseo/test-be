<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (!is_cli()) {
            show_error('This controller is only accessible from the command line.');
        }
    }

    public function index() {
        $this->load->library('migration');

        if ($this->migration->current() === FALSE) {
            echo $this->migration->error_string() . "\n";
        } else {
            echo "Migration completed successfully.\n";
        }
    }
}
