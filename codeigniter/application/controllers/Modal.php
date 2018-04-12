<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modal extends CI_Controller {

	public function __construct () {
		parent::__construct();
		$this->load->database();
	}

	public function index () {

		// $page = "default", $modal_timer = false
		$data["page"] = $page = "bulletin";

		if ($page === "bulletin") {
			$additional = $this->load->view("pms_modal/bulletin_entries", $data, true);
		} else if ($page === "ewi_sms") {
			$additional = $this->load->view("pms_modal/ewi_sms_entries", $data, true);
		} else {
			$additional = "";
		}

		$data["additional_entries"] = $additional;

		$modal = $this->load->view("pms_modal/main", $data, true);

		echo $modal;
	}
}

?>