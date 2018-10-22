<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analysis_charts_model extends CI_Model {
	
	public function getTimeliness () {
		$this->db->select("timeliness.ts_received as ts_received, timeliness.execution_time as execution_time, metrics.metric_name as metric_name")
			->from("timeliness")
			->join("metrics", "metrics.metric_id = timeliness.metric_id");

		return $this->db->get()->result();
	}

	public function getTeamMetrics () {
		return $this->db->select("*")
			->from("team_metrics")
			->get()
			->result();
	}
}

?>