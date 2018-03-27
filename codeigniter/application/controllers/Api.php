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
			} else {
				$metric_id = $this->insertMetric($module_id = $this->insertModule($report['team_id'],$report['module']),$report['metric_name']);
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
}

?>