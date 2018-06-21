<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_timeliness_table extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "timeliness";

	public function up () {
		$fields = array(
			"report_id" => array(
				"type" => "INT",
				"null" => FALSE,
				"auto_increment" => TRUE
			),
			"metric_id" => array(
				"type" => "INT"
			),
			"CONSTRAINT FOREIGN KEY (metric_id) references metrics(metric_id)",
			"ts_received TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
			"execution_time" => array(
				"type" => "FLOAT",
			),
			"report_message" => array(
				"type" => "VARCHAR",
				"constraint" => "500",
				"null" => TRUE
			)
		);
		// Add primary keyx
		$this->dbforge->add_key("report_id", TRUE);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table($this->_table_name, TRUE);
	}

	public function down () {
		$this->dbforge->drop_table($this->_table_name, TRUE);
	}

}

?>