<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model {

	public function getDynaslopeTeams () {
		return $this->db->get("dynaslope_teams")->result();
	}

	public function getModulesByTeamID ($team_id) {
		return $this->db->get_where("modules", array("team_id" => $team_id))->result();
	}

	public function getMetricsByModuleID ($module_id) {
		return $this->db->get_where("metrics", array("module_id" => $module_id))->result();
	}

	public function generalInsertToDatabase ($table_name, $data) {
    	$this->db->insert($table_name, $data);
    	$id = $this->db->insert_id();
    	return $id;
	}
}

?>