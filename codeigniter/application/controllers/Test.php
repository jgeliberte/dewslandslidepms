<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct () {
		parent::__construct();
		$this->load->database();
	}

	public function index () {
		$query = $this->db->get("accomplishment_report");
		print_r($query->result());

		$this->load->view('test_view');
	}
}
