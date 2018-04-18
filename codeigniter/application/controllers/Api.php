<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	// print is for testing purposes only. remove if necessary.

	public function __construct() {
		parent::__construct();
		$this->load->model('pms_model');
		$this->load->helper('url');
		$this->load->library('form_validation');

		header("Access-Control-Allow-Origin: http://localhost");
		header("Access-Control-Allow-Methods: GET, POST");
	}

	public function insertReport() {
		$err = "";
		$report = $_POST;
		$report_exists = $this->checkDuplicateReport($report);
		if ($report_exists == false) {
			try {
				$report['ts_received'] = date('Y-m-d h:m:i');
				$metric = $this->pms_model->getMetric($report['metric_name'],$report['limit']);
				$metric_exist = sizeOf($metric) > 0 ? true : false;
				if ($metric_exist) {
					$report['metric_id'] = $metric['metric_id'];
					$status = $this->categorizeReport($report);
				} else {
					$status = false;
					// $module = $this->pms_model->getModule($report['module_name'],$report['limit']);
					// $module_exist = sizeOf($module) > 0 ? true : false;
					// if ($module_exist) {
					// 	$metric_id = $this->insertMetric($module['module_id'],$report['metric_name']);
					// 	$report['metric_id'] = $metric_id;
					// } else {
					// 	$metric_id = $this->insertMetric($module_id = $this->insertModule($report['team_id'],$report['module_name']),$report['metric_name']);
					// 	$report['metric_id'] = $module_id;
					// 	$report['module_id'] = $metric_id;
					// }
					// $status = $this->categorizeReport($report);
				}
			} catch (Exception $e) {
				$err = $e->getMessage();
			};
		} else {
			$status = false;
			$err = "Duplicate report.";
		}
		print json_encode($this->returnStatus($status, $err));
		return $this->returnStatus($status, $err);
	}

	public function insertDynaslopeTeam($team, $description = "") {
		$err = "";
		try {
			$team_data = array("name" => $team,"description" => $description) ;
			$status = $this->pms_model->insertTeam($team_data);
		} catch (Exception $e) {
			$err = $e->getMessage();
		}

		print json_encode($this->returnStatus($status, $err));
		return $this->returnStatus($status, $err);
	}

	public function insertModule($team_id, $module_name, $description = "") {
		try {
			$module = array(
				"team_id" => $team_id,
				"name" => $module_name,
				"description" => $description
			);
			$result = $this->pms_model->insertModule($module);
		} catch (Exception $e) {
			$err = $e->getMessage();
		}


		return $result;
	}

	public function insertMetric($module_id, $metric_name, $description = "") {
		$metric = array(
			"module_id" => $module_id,
			"name" => $metric_name,
			"description" => $description
		);
		$results = $this->pms_model->insertMetric($metric);

		return $results;
	}

	public function categorizeReport($report) {
		switch ($report['type']) {
			case 'accuracy':
				$report_summary = [
					'metric_id' => $report['metric_id'],
					'ts_received' => $report['ts_received'],
					'report_message' => $report['report_message'],
					'reference_id' => $report['reference_id'],
					'reference_table' => $report['reference_table']
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
		$err = "";
		try {
			$module = $_POST['data'];
			$updated_module = [
				"team_id" => $module["team_id"],
				"name" => $module["name"],
				"description" => $module["description"]
			];
			$status = $this->pms_model->updateModule($updated_module,$module['module_id']);
		} catch (Exception $e) {
			$err = $e->getMessage();
		}

		print json_encode($this->returnStatus($status, $err));
		return $this->returnStatus($status, $err);
	}

	public function updateMetric() {
		$err = "";
		try {
			$metric = $_POST['data'];
			$updated_module = [
				"module_id" => $metric["module_id"],
				"name" => $metric["name"],
				"description" => $metric["description"]
			];
			$status = $this->pms_model->updateMetric($updated_module,$metric['metric_id']);
		} catch (Exception $e) {
			$err = $e->getMessage();
		}

		print json_encode($this->returnStatus($status, $err));
		return $this->returnStatus($status, $err);
	}

	public function updateDynaslopeTeams() {
		$err = "";
		try {
			$team = $_POST['data'];
			$updated_team = [
				"name" => $team['name'],
				"description" => $team['description']
			];
			$status = $this->pms_model->updateTeam($updated_team,$team['team_id']);
		} catch (Exception $e) {
			$err = $e->getMessage();
		}

		print json_encode($this->returnStatus($status, $err));
		return $this->returnStatus($status, $err);
	}

	public function updateReport() {
		$err = "";
		try {
			$report = $_POST['data'];	
			switch ($report['type']) {
				case 'accuracy':
					$updated_report = [
						'metric_id' => $report['metric_id'],
						'ts_received' => $report['ts_received'],
						'report_message' => $report['report_message'],
						'reference_id' => $report['reference_id'],
						'reference_table' => $report['reference_table']
					];
					$status = $this->pms_model->updateAccuracyReport($updated_report,$report['report_id']);
					break;
				case 'error_rate':
					$updated_report = [
						'metric_id' => $report['metric_id'],
						'ts_received' => $report['ts_received'],
						'report_message' => $report['report_message']
					];
					$status = $this->pms_model->updateErrorRateReport($updated_report,$report['report_id']);
					break;
				case 'timeliness':
					$updated_report = [
						'metric_id' => $report['metric_id'],
						'ts_received' => $report['ts_received'],
						'execution_time' => $report['execution_time']
					];
					$status = $this->pms_model->updateTimelinessReport($updated_report,$report['report_id']);
					break;
				default:
					echo "Invalid report category!\n\n";
					break;
			}
		} catch (Exception $e) {
			$err = $e->getMessage();
		}

		print json_encode($this->returnStatus($status, $err));
		return $this->returnStatus($status, $err);
	}

	public function deleteMetric() {
		$err = "";
		try {
			$metric = $_POST['data'];
			$status = $this->pms_model->deleteMetric($metric['metric_id']);
		} catch(Exception $e) {
			$err = $e->getMessage();
		}

		print json_encode($this->returnStatus($status, $err));
		return $this->returnStatus($status, $err);
	}

	public function deleteModule() {
		$err = "";
		try {
			$module = $_POST['data'];
			$status = $this->pms_model->deleteModule($module['module_id']);
		} catch (Exception $e) {
			$err = $e->getMessage();
		}

		print json_encode($this->returnStatus($status, $err));
		return $this->returnStatus($status, $err);
	}

	public function deleteTeam() {
		$err = "";
		try {
			$team = $_POST['data'];
			$status = $this->pms_model->deleteTeam($team['team_id']);
		} catch (Exception $e) {
			$err = $e->getMessage();
		}

		print json_encode($this->returnStatus($status, $err));
		return $this->returnStatus($status, $err);
	}

	public function deleteReport() {
		$err = "";
		$report = $_POST['data'];
		switch ($report['type']) {
			case 'accuracy':
				$status = $this->pms_model->deleteAccuracyReport($report['report_id']);
				break;
			case 'error_rate':
				$status = $this->pms_model->deleteErrorRateReport($report['report_id']);
				break;
			case 'timeliness':
				$status = $this->pms_model->deleteTimelinessReport($report['report_id']);
				break;
			default:
				echo "Invalid report category";
				$status = false;
				break;
		}

		print json_encode($this->returnStatus($status, $err));
		return $this->returnStatus($status, $err);
	}

	public function returnStatus($status, $err = "") {
		if ($status == true) {
			$result = ['status' => $status];
		} else {
			$result = ['status' => false, 'err' => $err];
		}
		return $result;
	}

	public function checkDuplicateReport($report) {
		switch ($report['type']) {
			case 'accuracy':
				$status = $this->pms_model->checkAccuracyExists($report);
				break;
			case 'error_rate':
				$status = $this->pms_model->checkErrorRateExists($report);
				break;
			case 'timeliness':
				$status = $this->pms_model->checkTimelinessExists($report);
				break;
			default:
				$status = false;
				break;
		}
		return $status;
	}
}

?>