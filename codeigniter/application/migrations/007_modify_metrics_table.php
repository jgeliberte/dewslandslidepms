<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_metrics_table extends CI_Migration {

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
				"auto_increment" => TRUE
			),
			"module_id" => array(
				"type" => "INT"
			),
			"metric_name" => array(
				"type" => "VARCHAR",
				"constraint" => "100",
				"unique" => FALSE
			),
			"metric_desc" => array(
				"type" => "VARCHAR",
				"constraint" => "300"
			)
		);
		$this->dbforge->modify_column($this->_table_name, $fields);
	}

	public function down () {
		if (is_array($this->_fields())) {
			foreach($this->_fields() as $key => $val)
			{
				$this->dbforge->drop_column($this->_table_name,$key);
			}
		}
	}

	/**
	 * Returns an array of the fields to be used within the up and down functions!
	 *
	 * @return array
	 */
	protected function _fields () {
		return array();
	}

}

?>