<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_timeliness_table extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "timeliness";

	public function up () {
		$this->dbforge->add_column($this->_table_name, $this->_fields());
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
		return array(
			"reference_id" => array(
				"type" => "INT",
				"default" => 0
			),
			"reference_table" => array(
				"type" => "int",
				"default" => 0
			)
		);
	}

}

?>