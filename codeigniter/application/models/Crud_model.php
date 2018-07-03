<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model {

	public function getDynaslopeTeams () {
		return $this->db->get("dynaslope_teams")->result();
	}

	public function getModulesByTeamID ($team_id) {
		return $this->db->get_where("modules", array("team_id" => $team_id))->result();
	}

	public function getMetricsByModuleID ($module_id) {
		$this->db->select("metrics.*, s.submetric_id, s.submetric_table_name, s.show_on_modal")
			->from("metrics")
			->join("submetrics AS s", "metrics.metric_id = s.metric_id", "left")
			->where("module_id", $module_id);

		return $this->db->get()->result();
	}

	public function getSubmetricTableColumns ($table_name) {
		return $this->db->list_fields($table_name);
	}

	public function generalInsertToDatabase ($table_name, $data) {
    	$this->db->insert($table_name, $data);
    	$id = $this->db->insert_id();
    	return $id;
	}

	public function generalUpdateData ($column, $key, $table, $data) {
		$this->db->where($column, $key);
		$this->db->update($table, $data);
	}

	public function createSubmetricsTable ($table_name, $columns, $key) {
		$this->load->dbforge();
		$this->dbforge->add_key($key, TRUE);
		$this->dbforge->add_field($columns);
		$this->dbforge->create_table($table_name);
	}

	public function renameSubmetricsTable ($old_name, $new_name) {
		$this->load->dbforge();
		return $this->dbforge->rename_table($old_name, $new_name);
	}

	public function updateSubmetricColumnNames ($table_name, $columns) {
		$this->load->dbforge();
		$this->dbforge->modify_column($table_name, $columns);
	}

	public function addNewColumnsOnExistingSubmetricTable ($table_name, $columns) {
		$this->load->dbforge();
		$this->dbforge->add_column($table_name, $columns);
	}

	public function getMetricID ($metric_name) {
		return $this->db->select("metrics.metric_id")
			->get_where("metrics", array("metric_name" => $metric_name))
			->row();
	}

	public function getSubmetricsTableName ($metric_id) {
		return $this->db->select("submetrics.*")
			->get_where("submetrics", array("metric_id" => $metric_id))
			->row();
	}
}

?>