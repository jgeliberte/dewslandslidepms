<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pms_model extends CI_Model {

	public function insertTeam($team) {
		$result = $this->db->insert("dynaslope_teams",$team);
		return $result;
	}

	public function insertModule($module) {
		$this->db->insert("modules",$module);
		$result = $this->db->insert_id();
		return $result;
	}

	public function insertMetric($metric) {
		$this->db->insert("metrics",$metric);
		$result = $this->db->insert_id();
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

	public function getModule($module, $limit = "all") {
		$this->db->select('*');
		$this->db->from('modules');
		$this->db->where('name',$module);
		if ($limit == "specific") {$this->db->limit(1);}
		$result = $this->db->get();
		$raw_data = $result->result();
		if ($limit == "specific") {
			if (sizeOf($raw_data) > 0) {
				$data = [
					'module_id' => $raw_data[0]->module_id,
					'team_id' => $raw_data[0]->team_id,
					'name' => $raw_data[0]->name,
					'description' => $raw_data[0]->description
				];
			} else {
				$data = $raw_data;
			}
		} else {
			$data = $raw_data;
		}
		return $data;
	}

	public function getMetric($metric, $limit = "all") {
		$this->db->select('*');
		$this->db->from('metrics');
		$this->db->where('name', $metric);
		if ($limit == "specific") {$this->db->limit(1);}
		$result = $this->db->get();
		$raw_data = $result->result();
		if ($limit == "specific") {
			if (sizeOf($raw_data) > 0) {
				$data = [
					'metric_id' => $raw_data[0]->metric_id,
					'module_id' => $raw_data[0]->module_id,
					'name' => $raw_data[0]->name,
					'description' => $raw_data[0]->description
				];
			} else {
				$data = $raw_data;
			}
		} else {

			$data = $raw_data;
		}
		return $data;
	}

	public function getModuleByType($module) {

	}

	public function getMetricByType($metric) {

	}
}

?>