<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_modules_table extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "modules";

	public function up () {
		$fields = array(
			"module_id" => array(
				"type" => "INT",
				"null" => FALSE,
				"auto_increment" => TRUE
			),
			"team_id" => array(
				"type" => "INT"
			),
			"CONSTRAINT FOREIGN KEY (team_id) references dynaslope_teams(team_id)",
			"module_name" => array(
				"type" => "VARCHAR",
				"constraint" => "100",
				"unique" => TRUE
			),
			"module_desc" => array(
				"type" => "VARCHAR",
				"constraint" => "300"
			)
		);
		// Add primary key
		$this->dbforge->add_key("module_id", TRUE);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table($this->_table_name, TRUE);
	}

	public function down () {
		$this->dbforge->drop_table($this->_table_name, TRUE);
	}

}

?>