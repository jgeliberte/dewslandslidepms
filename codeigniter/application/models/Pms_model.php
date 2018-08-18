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
		$result = $this->db->insert("error_logs",$report);
		return $result;
	}

	public function insertTimelinessReport($report) {
		$result = $this->db->insert("timeliness",$report);
		return $result;
	}

	public function getTeam($team, $limit) {
		$this->db->select("*");
		$this->db->from("dynaslope_teams");
		if ($limit == "specific") {$this->db->where("team_name",$team);$this->db->limit(1);}
		$result = $this->db->get();
		$raw_data = $result->result();
		if ($limit == "specific") {
			if (sizeOf($raw_data) > 0) {
				$data = [
					'team_id' => $raw_data[0]->team_id,
					'team_name' => $raw_data[0]->team_name,
					'team_desc' => $raw_data[0]->team_desc<<<<<<< 2018-s10-input_page_submetrics
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
		if ($limit == "specific") {$this->db->where('module_name',$module);$this->db->limit(1);}
		$result = $this->db->get();
		$raw_data = $result->result();
		if ($limit == "specific") {
			if (sizeOf($raw_data) > 0) {
				$data = [
					'module_id' => $raw_data[0]->module_id,
					'team_id' => $raw_data[0]->team_id,
					'module_name' => $raw_data[0]->name,
					'module_desc' => $raw_data[0]->module_desc
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
		if ($limit == "specific") {$this->db->where('metric_name', $metric);$this->db->limit(1);}
		$result = $this->db->get();
		$raw_data = $result->result();
		if ($limit == "specific") {
			if (sizeOf($raw_data) > 0) {
				$data = [
					'metric_id' => $raw_data[0]->metric_id,
					'module_id' => $raw_data[0]->module_id,
					'metric_name' => $raw_data[0]->metric_name,
					'metric_desc' => $raw_data[0]->metric_desc
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
		$this->db->from('error_logs');
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

	public function updateModule($module, $id) {
		$this->db->set($module);
		$this->db->where('module_id', $id);
		$result = $this->db->update('modules');
		return $result;
	}

	public function updateMetric($metric, $id) {
		$this->db->set($metric);
		$this->db->where('metric_id', $id);
		$result = $this->db->update('metrics');
		return $result;
	}

	public function updateTeam($team, $id) {
		$this->db->set($team);
		$this->db->where('team_id', $id);
		$result = $this->db->update('dynaslope_teams');
		return $result;
	}

	public function updateAccuracyReport($report, $id) {
		$this->db->set($report);
		$this->db->where('report_id',$id);
		$result = $this->db->update('accuracy');
		return $result;
	}

	public function updateErrorRateReport($report, $id) {
		$this->db->set($report);
		$this->db->where('report_id',$id);
		$result = $this->db->update('error_logs');
		return $result;
	}

	public function updateTimelinessReport($report, $id) {
		$this->db->set($report);
		$this->db->where('report_id',$id);
		$result = $this->db->update('timeliness');
		return $result;
	}

	public function deleteMetric($id) {
		$this->db->where('metric_id', $id);
		$result = $this->db->delete('metrics');
		return $result;
	}

	public function deleteModule($id) {
		$this->db->where('module_id', $id);
		$result = $this->db->delete('modules');
		return $result;
	}

	public function deleteTeam($id) {
		$this->db->where('team_id', $id);
		$result = $this->db->delete('dynaslope_teams');
		return $result;
	}

	public function deleteAccuracyReport($id) {
		$this->db->where('report_id', $id);
		$result = $this->db->delete('accuracy');
		return $result;
	}

	public function deleteErrorRateReport($id) {
		$this->db->where('report_id', $id);
		$result = $this->db->delete('error_logs');
		return $result;
	}

	public function deleteTimelinessReport($id) {
		$this->db->where('report_id', $id);
		$result = $this->db->delete('timeliness');
		return $result;
	}

	public function checkAccuracyExists($report) {
		$metric = $this->getMetric($report['metric_name'],"specific");
		if (sizeOf($metric) == 0) {
			$status = false;
		} else {
			$this->db->select('*');
			$this->db->from('accuracy');
			$this->db->where('reference_id',$report['reference_id']);
			$this->db->where('reference_table',$report['reference_table']);
			$this->db->where('report_message',$report['report_message']);
			$this->db->where('metric_id',$metric['metric_id']);
			$result = $this->db->get();
			$status = sizeOf($result->result()) > 0 ? true : false;
		}
		return $status;
	}

	public function checkIfSubmetricExists($metric_id) {
		$this->db->select('*');
		$this->db->from('submetrics');
		$this->db->where('metric_id',$metric_id);
		$result = $this->db->get();
		return $result->result();
	}

	public function insertSubmetricReport($metric, $submetric) {
		$submetric_summary = [];
		$fields = $this->db->list_fields($metric->submetric_table_name);
		foreach ($fields as $field) {
			if ($field != "instance_id") {
				if ($field == "metric_ref_id") {
					$submetric_summary["metric_ref_id"] = $metric->metric_id;
				} else {
					if ($field == $submetric) {
						$submetric_summary[$field] = 1;
					} else {
						$submetric_summary[$field] = 0;
					}
				}
			}
		}
		$result = $this->db->insert($metric->submetric_table_name,$submetric_summary);
		return $result;
	}

	public function checkErrorRateExists($report) {

	}

	public function checkTimelinessExists($report) {

	}
}

?>