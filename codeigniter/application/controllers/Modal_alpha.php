<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modal_alpha extends CI_Controller {

	public function __construct () {
		parent::__construct();
		$this->load->database();

		header("Access-Control-Allow-Origin: http://localhost");
		header("Access-Control-Allow-Methods: GET, POST");
	}

	public function index () {

		$data['page'] = $_POST['page'];

		switch ($data['page']) {
			case "bulletin":
				$additional = $this->load->view("pms_modal/bulletin_entries", $data, true);
				break;
			case "ewi_sms":
				$additional = $this->load->view("pms_modal/ewi_sms_entries", $data, true);
				break;
			case "chatterbox":
				$additional = $this->load->view("pms_modal/chatterbox_entries", $data, true);
				break;
			default:
				$additional = "";
				break;
		}

		$data["additional_entries"] = $additional;

		$modal = $this->load->view("pms_modal/main", $data, true);
		echo json_encode($modal);
	}
}

?>