<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pms_model extends CI_Model {

	public function insertTeam($team) {
		$result = $this->db->insert("dynaslope_teams",$team);
		return $result;
	}

	public function insertModule($module) {
		$result = $this->db->insert("modules",$module);
		return $result;
	}

	public function insertMetric($metric) {
		$result = $this->db->insert("metrics",$metric);
		return $result;
	}

	public function insertAccuracyReport($report) {
		$result = $this->db->insert("accuracy",$report);
		return $result;
	}

	public function insertErrorRateReport($report) {
		$result = $this->db->insert("error_rate",$report);
		return $result;
	}

	public function insertTimelinessReport($report) {
		$result = $this->db->insert("timeliness",$report);
		return $result;
	}

	public function getTeam() {
		switch (variable) {
			case 'value':
				# code...
				break;
			
			default:
				# code...
				break;
		}
	}

	public function getModule($module, $type = "") {
		switch ($module['type']) {
			case 'accuracy':
				# code...
				break;
			case 'error_rate':
				# code...
				break;
			case 'timeliness':
				# code...
				break;
			default:
				# code...
				break;
		}
	}

	public function getMetric($metric, $type = "") {
		$this->db->select('*');
		$this->db->from('metrics');
		$this->db->where('name', $metric);
		$result = $this->db->get();
		return $result->result();
	}

	public function getModuleByType($module) {

	}

	public function getMetricByType($metric) {

	}
}

?>