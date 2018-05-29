<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_dynaslope_teams_table extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "dynaslope_teams";

	public function up () {
		$fields = array(
			"team_id" => array(
				"type" => "INT",
				"null" => FALSE,
				"auto_increment" => TRUE,
			),
			"name" => array(
				"type" => "VARCHAR",
				"constraint" => "60",
				"unique" => TRUE
			),
			"description" => array(
				"type" => "VARCHAR",
				"constraint" => "300",
			)
		);
		// Add primary key
		$this->dbforge->add_key("team_id", TRUE);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table($this->_table_name, TRUE);
	}

	public function down () {
		$this->dbforge->drop_table($this->_table_name, TRUE);
	}

}

?>