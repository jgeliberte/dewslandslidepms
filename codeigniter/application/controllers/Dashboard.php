<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$data['title'] = "PMS";

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('dashboard', $data);
		$this->load->view('templates/footer');
	}
}
