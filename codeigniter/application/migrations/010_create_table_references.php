<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_references extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "table_references";

	public function up () {
		$fields = array(
			"table_id" => array(
				"type" => "INT",
				"null" => FALSE,
				"auto_increment" => TRUE,
			),
			"table_name" => array(
				"type" => "VARCHAR",
				"null" => FALSE,
				"constraint" => "100",
				"unique" => TRUE
			),
		);
		// Add primary key
		$this->dbforge->add_key("table_id", TRUE);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table($this->_table_name, TRUE);
	}

	public function down () {
		$this->dbforge->drop_table($this->_table_name, TRUE);
	}

}

?>