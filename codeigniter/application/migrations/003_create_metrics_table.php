<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_metrics_table extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "metrics";

	public function up () {
		$fields = array(
			"metric_id" => array(
				"type" => "INT",
				"null" => FALSE,
				"auto_increment" => TRUE,
			),
			"module_id" => array(
				"type" => "INT"
			),
			"CONSTRAINT FOREIGN KEY (module_id) references modules(module_id)",
			"name" => array(
				"type" => "VARCHAR",
				"constraint" => "100",
				"unique" => TRUE
			),
			"description" => array(
				"type" => "VARCHAR",
				"constraint" => "300"
			)
		);
		// Add primary key
		$this->dbforge->add_key("metric_id", TRUE);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table($this->_table_name, TRUE);
	}

	public function down () {
		$this->dbforge->drop_table($this->_table_name, TRUE);
	}

}

?>