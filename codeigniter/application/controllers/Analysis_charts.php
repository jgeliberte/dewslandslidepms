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

	public function getTimelinessResult () {
		$data = [];
		$timeliness = $this->Analysis_charts_model->getTimeliness();

		foreach ($timeliness as $key) {
			if (!array_key_exists($key->metric_name, $data)) {
                $data[$key->metric_name] = [];
            }
            $ts = explode(" ", $key->ts_received);
			$date = strtotime($ts[0]) * 1000;
			$execution_time = $key->execution_time/60000;

			$timeliness_data = [$date, $execution_time];
			array_push($data[$key->metric_name], $timeliness_data);
		}

		echo json_encode([$data]);

	}

	public function getTeamMetrics () {
		$team_metrics = $this->Analysis_charts_model->getTeamMetrics();

		echo json_encode($team_metrics);
	}
}

?>