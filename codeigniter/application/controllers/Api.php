<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('pms_model');
		$this->load->helper('url');
		$this->load->library('form_validation');

	}

	public function insertReport() {
		$report = json_decode($_POST['data']);
		$metric_exist = (count($metric = $this->pms_model->getMetric($report->metric)) > 0) ? true : false;

		if ($metric_exist) {
			$status = categorizeReport($report);
		} else {
			$module_exist = (count($module = $this->pms_model->getModule($report->module)) > 0) ? true : false;
			if ($module_exist) {
				insertMetric($module->id,$metric_name);
			} else {
				insertMetric(insertModule($report->team_id,$report->module),$metric_name);
			}
			$status = categorizeReport($report);
		}
	}

	public function insertDynaslopeTeam($team, $description = "") {
		$team_data = array("name" => $team,"description" => $description) ;
		$this->pms_model->insertTeam($team_data);
	}

	public function insertModule($team_id, $module_name, $description = "") {
		$module = array(
			"team_id" => $team_id,
			"name" => $module_name,
			"description" => $description
		);
		$this->pms_model->insertModule($module);
	}

	public function insertMetric($module_id, $metric_name, $description = "") {
		$metric = array(
			"module_id" => $module_id,
			"name" => $metric_name,
			"description" => $description
		);
		$this->pms_model->insertMetric($metric);
	}

	public function categorizeReport($report) {
		switch ($report->type) {
			case 'accuracy':
				$result = $this->pms_model->insertAccuracyReport();
				break;
			case 'error_rate':
				$result = $this->pms_model->insertErrorRateReport();
				break;
			case 'timeliness':
				$result = $this->pms_model->insertTimelinessReport();
				break;
			default:
				echo "Unknown category!\n\n";
				break;
		}
		return $result;
	}
}

?>