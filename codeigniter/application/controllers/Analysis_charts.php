<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analysis_charts extends CI_Controller {

	public function __construct() {
			parent::__construct();
			$this->load->model("Analysis_charts_model");
		}

	public function index () {
		$data['title'] = "PMS";

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('analysis_charts', $data);
		$this->load->view('templates/footer');
	}

	public function getTimelinessResult () {
		$final_data = [];
		$result = $this->Analysis_charts_model->getTimeliness();

		foreach ($result as $data) {
				$ts = explode(" ", $data->ts_received);
				$date = strtotime($ts[0]) * 1000;
				$execution_time = $data->execution_time/60000;
				$timeliness_data = [$date, (int) $execution_time, (int) $data->metric_id];
				array_push($final_data, $timeliness_data);
			}
		echo json_encode($final_data);
	}
}

?>