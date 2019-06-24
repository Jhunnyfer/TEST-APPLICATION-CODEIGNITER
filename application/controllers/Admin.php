<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url' );
        $this->load->library(array('session', 'form_validation' ) );
        $this->load->helper(array('url', 'form' ) );
    } 
}
