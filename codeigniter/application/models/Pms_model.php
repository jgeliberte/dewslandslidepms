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

	}

	public function insertErrorRateReport($report) {

	}

	public function insertErrorRateReport($report) {

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

	public function getModule() {
		switch (variable) {
			case 'value':
				# code...
				break;
			
			default:
				# code...
				break;
		}
	}

	public function getMetric($metric) {
		$query = $this->db->get('metrics');
		$this->db->where('name', $metric);
		return $query->result();
	}
}

?>