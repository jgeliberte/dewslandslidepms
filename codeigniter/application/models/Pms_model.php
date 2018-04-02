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

	public function getTeam($team, $limit) {
		$this->db->select("*");
		$this->db->from("dynaslope_teams");
		if ($limit == "specific") {$this->db->where("name",$team);$this->db->limit(1);}
		$result = $this->db->get();
		$raw_data = $result->result();
		if ($limit == "specific") {
			if (sizeOf($raw_data) > 0) {
				$data = [
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

	public function getModule($module, $limit) {
		$this->db->select('*');
		$this->db->from('modules');
		if ($limit == "specific") {$this->db->where('name',$module);$this->db->limit(1);}
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

	public function getMetric($metric, $limit) {
		$this->db->select('*');
		$this->db->from('metrics');
		if ($limit == "specific") {$this->db->where('name', $metric);$this->db->limit(1);}
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

	public function getAccuracyReport($report_id, $metric_id, $limit) {
		$this->db->select('*');
		$this->db->from('accuracy');
		if ($limit == "specific") {
			$this->db->where('report_id', $report_id);
			$this->db->where('metric_id', $metric_id);
			$this->db->limit(1);
		}
		$result = $this->db->get();
		$raw_data = $result->result();
		if ($limit == "specific") {
			if (sizeOf($raw_data) > 0) {
				$data = [
					'report_id' => $raw_data[0]->report_id,
					'metric_id' => $raw_data[0]->metric_id,
					'ts_received' => $raw_data[0]->ts_received,
					'ts_data' => $raw_data[0]->ts_data,
					'report_message' => $raw_data[0]->report_message
				];
			} else {
				$data = $raw_data;
			}
		} else {
			$data = $raw_data;
		}
		return $data;
	}

	public function getErrorRateReport($report_id, $metric_id, $limit) {
		$this->db->select('*');
		$this->db->from('error_rate');
		if ($limit == "specific") {
			$this->db->where('report_id', $report_id);
			$this->db->where('metric_id', $metric_id);
			$this->db->limit(1);
		}
		$result = $this->db->get();
		$raw_data = $result->result();
		if ($limit == "specific") {
			if (sizeOf($raw_data) > 0) {
				$data = [
					'report_id' => $raw_data[0]->report_id,
					'metric_id' => $raw_data[0]->metric_id,
					'ts_received' => $raw_data[0]->ts_received,
					'report_message' => $raw_data[0]->report_message
				];
			} else {
				$data = $raw_data;
			}
		} else {
			$data = $raw_data;
		}
		return $data;
	}

	public function getTimelinessReport($report_id, $metric_id, $limit) {
		$this->db->select('*');
		$this->db->from('timeliness');
		if ($limit == "specific") {
			$this->db->where('report_id', $report_id);
			$this->db->where('metric_id', $metric_id);
			$this->db->limit(1);
		}
		$result = $this->db->get();
		$raw_data = $result->result();
		if ($limit == "specific") {
			if (sizeOf($raw_data) > 0) {
				$data = [
					'report_id' => $raw_data[0]->report_id,
					'metric_id' => $raw_data[0]->metric_id,
					'ts_received' => $raw_data[0]->ts_received,
					'execution_time' => $raw_data[0]->execution_time
				];
			} else {
				$data = $raw_data;
			}
		} else {
			$data = $raw_data;
		}
		return $data;
	}
}

?>