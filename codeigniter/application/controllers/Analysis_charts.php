<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analysis_charts extends CI_Controller {

	public function __construct() {
			parent::__construct();
			$this->load->model("Analysis_charts_model");
			$this->load->model("Crud_model");
		}

	public function index () {
		$data['title'] = "PMS";

        $data['options_bar'] = $this->load->view('options_bar', $data, true);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('analysis_charts', $data);
		$this->load->view('templates/footer');
	}

	public function getTeamMetrics () {
		$team_metrics = $this->Analysis_charts_model->getTeamMetrics();

		echo json_encode($team_metrics);
	}

	public function getAccuracyResult () {
		$data = [];
		$accuracy = $this->Analysis_charts_model->getAccuracy();

		foreach ($accuracy as $key) {
			if (!array_key_exists($key->metric_name, $data)) {
                $data[$key->metric_name] = [];
            }
            date_default_timezone_set('Asia/Manila');
			$ts = $key->ts_received;
			$date = strtotime($ts) * 1000;
			$accuracy_data = [
				'ts_received' => $date,
				'value' =>  	(int) $key->accuracy_value,
				'report_id' => (int) $key->report_id,
				'report_message' => $key->report_message,
				'reference_id' => (int) $key->reference_id, 
				'reference_table' => (int) $key->reference_table 
			];
			array_push($data[$key->metric_name], $accuracy_data);
		}
		echo json_encode([$data]);
	}

	public function getErrorLogsResult () {
		$data = [];
		$error_log = $this->Analysis_charts_model->getErrorLogs();

		foreach ($error_log as $key) {
			if (!array_key_exists($key->metric_name, $data)) {
                $data[$key->metric_name] = [];
            }
            date_default_timezone_set('Asia/Manila');
            $ts = $key->ts_received;
			$date = strtotime($ts) * 1000;
			$error_logs_data = [
				'ts_received' => $date,
				'value' =>  	(int) $key->error_instances,
				'report_id' => (int) $key->report_id,
				'report_message' => $key->report_message,
				'reference_id' => (int) $key->reference_id, 
				'reference_table' => (int) $key->reference_table 
			];
			array_push($data[$key->metric_name], $error_logs_data);
		}
		echo json_encode([$data]);
	}

	public function getTimelinessResult () {
		$data = [];
		$timeliness = $this->Analysis_charts_model->getTimeliness();

		foreach ($timeliness as $key) {
			if (!array_key_exists($key->metric_name, $data)) {
                $data[$key->metric_name] = [];
            }
            date_default_timezone_set('Asia/Manila');
            $ts = $key->ts_received;
			$date = strtotime($ts) * 1000;
			$execution_time = $key->execution_time/60000;

			$timeliness_data = [
				'ts_received' => $date,
				'value' =>  	(int) $key->execution_time/1000,
				'report_id' => (int) $key->report_id,
				'report_message' => $key->report_message,
				'reference_id' => (int) $key->reference_id, 
				'reference_table' => (int) $key->reference_table
			];
			array_push($data[$key->metric_name], $timeliness_data);
		}
		echo json_encode([$data]);
	}
}

?>