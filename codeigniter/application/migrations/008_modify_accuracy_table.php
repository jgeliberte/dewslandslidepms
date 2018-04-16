<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_accuracy_table extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "accuracy";

	public function up () {
		$this->dbforge->add_column($this->_table_name, $this->_fields());
		$this->dbforge->drop_column($this->_table_name, "ts_data");
	}

	public function down () {
		if (is_array($this->_fields())) {
			foreach($this->_fields() as $key => $val)
			{
				$this->dbforge->drop_column($this->_table_name, $key);
			}
		}

		$this->dbforge->add_column($this->_table_name, array(
			"ts_data" => array(
				"type" => "TIMESTAMP",
				"after" => "ts_received"
			)
		));
	}

	/**
	 * Returns an array of the fields to be used within the up and down functions!
	 *
	 * @return array
	 */
	protected function _fields () {
		return array(
			"reference_id" => array(
				"type" => "INT",
				"null" => FALSE
			),
			"reference_table" => array(
				"type" => "VARCHAR",
				"constraint" => "30",
			)
		);
	}
}

?>