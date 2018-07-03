<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_submetrics_table extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "submetrics";

	public function up () {
		$fields = array(
			"submetric_id" => array(
				"type" => "INT",
				"null" => FALSE,
				"auto_increment" => TRUE,
			),
			"metric_id" => array(
				"type" => "INT",
				"null" => FALSE
			),
			"CONSTRAINT FOREIGN KEY (metric_id) references metrics(metric_id)",
			"submetric_table_name" => array(
				"type" => "VARCHAR",
				"constraint" => "100",
				"unique" => TRUE
			),
			"show_on_modal" => array(
				"type" => "TINYINT",
				"default" => 0
			)
		);
		// Add primary key
		$this->dbforge->add_key("submetric_id", TRUE);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table($this->_table_name, TRUE);
	}

	public function down () {
		$this->dbforge->drop_table($this->_table_name, TRUE);
	}

}

?>