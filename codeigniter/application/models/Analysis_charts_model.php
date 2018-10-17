<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analysis_charts_model extends CI_Model {
	
	public function getTimeliness () {
		return $this->db->get_where("timeliness")->result(); 
	}
}

?>