<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	// print is for testing purposes only. remove if necessary.

	public function __construct() {
		parent::__construct();
		$this->load->model('pms_model');
		$this->load->helper('url');
		$this->load->library('form_validation');
	}

	public function insertReport() {
		$report = $_POST['data'];
		$metric_exist = (sizeOf($metric = $this->pms_model->getMetric($report['metric_name'],$report['limit'])) > 0) ? true : false;
		if ($metric_exist) {
			$status = $this->categorizeReport($report);
		} else {
			$module_exist = (sizeOf($module = $this->pms_model->getModule($report['module'],$report['limit'])) > 0) ? true : false;
			if ($module_exist) {
				$metric_id = $this->insertMetric($module['module_id'],$report['metric_name']);
				$report['metric_id'] = $metric_id;
			} else {
				$metric_id = $this->insertMetric($module_id = $this->insertModule($report['team_id'],$report['module']),$report['metric_name']);
				$report['metric_id'] = $module_id;
				$report['module_id'] = $metric_id;
			}
			$status = $this->categorizeReport($report);
		}
		print $status;
		return $status;
	}

	public function insertDynaslopeTeam($team, $description = "") {
		$team_data = array("name" => $team,"description" => $description) ;
		$results = $this->pms_model->insertTeam($team_data);
		print $results;
		return $results;
	}

	public function insertModule($team_id, $module_name, $description = "") {
		$module = array(
			"team_id" => $team_id,
			"name" => $module_name,
			"description" => $description
		);
		$results = $this->pms_model->insertModule($module);
		print $results;
		return $results;
	}

	public function insertMetric($module_id, $metric_name, $description = "") {
		$metric = array(
			"module_id" => $module_id,
			"name" => $metric_name,
			"description" => $description
		);
		$results = $this->pms_model->insertMetric($metric);
		print $results;
		return $results;
	}

	public function categorizeReport($report) {
		switch ($report['type']) {
			case 'accuracy':
				$report_summary = [
					'metric_id' => $report['metric_id'],
					'ts_received' => $report['ts_received'],
					'ts_data' => $report['ts_data'],
					'report_message' => $report['report_message']
					];
				$result = $this->pms_model->insertAccuracyReport($report_summary);
				break;
			case 'error_rate':
				$report_summary = [
					'metric_id' => $report['metric_id'],
					'ts_received' => $report['ts_received'],
					'report_message' => $report['report_message']
					];
				$result = $this->pms_model->insertErrorRateReport($report_summary);
				break;
			case 'timeliness':
				$report_summary = [
				'metric_id' => $report['metric_id'],
				'ts_received' => $report['ts_received'],
				'execution_time' => $report['execution_time']
				];
				$result = $this->pms_model->insertTimelinessReport($report_summary);
				break;
			default:
				echo "Unknown category!\n\n";
				break;
		}
		return $result;
	}

	public function getModule($module = "", $limit = "specific") {
		$result = $this->pms_model->getModule($module,$limit);
		print_r($result);
		return $result;
	}

	public function getAllModules($module = "", $limit = "all") {
		$result = $this->pms_model->getModule($module,$limit);
		print_r($result);
		return $result;
	}

	public function getMetric($metric = "",$limit = "all") {
		$result = $this->pms_model->getMetric($metric,$limit);
		print_r($result);
		return $result;
	}

	public function getAllMetrics($metric = "", $limit = "all") {
		$result = $this->pms_model->getMetric($metric,$limit);
		print_r($result);
		return $result;
	}

	public function getDynaslopeTeams($team = "", $limit = "all") {
		$result = $this->pms_model->getTeam($team, $limit);
		print_r($result);
		return $result;
	}

	public function getReports($type, $report_id = "", $metric_id = "" , $limit = "all") {
		switch ($type) {
			case 'accuracy':
				$result = $this->pms_model->getAccuracyReport($report_id, $metric_id , $limit);
				break;

			case 'error_rate':
				$result = $this->pms_model->getErrorRateReport($report_id, $metric_id , $limit);
				break;

			case 'timeliness':
				$result = $this->pms_model->getTimelinessReport($report_id, $metric_id , $limit);
				break;
			
			default:
				$result = "Type Error: Contact Developer for now.";
				break;
		}
		print_r($result);
		return $result;
	}

	public function updateModule() {
		$module = $_POST['data'];
		$updated_module = [
			"team_id" => $module["team_id"],
			"name" => $module["name"],
			"description" => $module["description"]
		];
		$result = $this->pms_model->updateModule($updated_module,$module['module_id']);

		print $result;
		return $result;
	}

	public function updateMetric() {
		$metric = $_POST['data'];
		$updated_module = [
			"module_id" => $metric["module_id"],
			"name" => $metric["name"],
			"description" => $metric["description"]
		];
		$result = $this->pms_model->updateMetric($updated_module,$metric['metric_id']);

		print $result;
		return $result;
	}

	public function updateDynaslopeTeams() {
		$team = $_POST['data'];
		$updated_team = [
			"name" => $team['name'],
			"description" => $team['description']
		];
		$result = $this->pms_model->updateTeam($updated_team,$team['team_id']);

		print $result;
		return $result;
	}

	public function updateReports() {

	}

	public function deleteModule() {

	}

	public function deleteMetric() {

	}

	public function deleteReport() {

	}
	
}

?>