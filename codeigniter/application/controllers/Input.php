<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input extends CI_Controller {

	public function __construct() {
			parent::__construct();
			$this->load->model("crud_model");
		}

	public function index () {
		$data['title'] = "PMS";

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('crud_page', $data);
		$this->load->view('templates/footer');
	}

	public function getDynaslopeTeams () {
		$result = $this->crud_model->getDynaslopeTeams();
		echo json_encode($result);
	}

	public function getModulesByTeamID ($team_id) {
		$result = $this->crud_model->getModulesByTeamID($team_id);
		echo json_encode($result);
	}

	public function getMetricsByModuleID ($module_id) {
		$result = $this->crud_model->getMetricsByModuleID($module_id);
		echo json_encode($result);
	}

	public function generalInsertToDatabase () {
		$table_name = $_POST["table_name"];
		$data = $_POST["data"];
		$result = $this->crud_model->generalInsertToDatabase($table_name, $data);
		echo json_encode($result);
	}
}
