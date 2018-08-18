<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input extends CI_Controller {

	public function __construct() {
			parent::__construct();
			$this->load->model("crud_model");
		}

	public function index () {
		$data['title'] = "PMS";

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('crud_page', $data);
		$this->load->view('templates/footer');
	}

	public function getDynaslopeTeams () {
		$result = $this->crud_model->getDynaslopeTeams();
		echo json_encode($result);
	}

	public function getModulesByTeamID ($team_id) {
		$result = $this->crud_model->getModulesByTeamID($team_id);
		echo json_encode($result);
	}

	public function getMetricsByModuleID ($module_id) {
		$result = $this->crud_model->getMetricsByModuleID($module_id);

		for ($i = 0; $i < count($result); $i += 1) { 
			if (!is_null($result[$i]->submetric_id)) {
				$columns = $this->crud_model->getSubmetricTableColumns($result[$i]->submetric_table_name);
				$columns = array_diff($columns, array("instance_id", "metric_ref_id"));
				$result[$i]->submetric_columns = array_values($columns);
			}
		}

		echo json_encode($result);
	}

	public function generalInsertToDatabase () {
		$table_name = $_POST["table_name"];
		$data = $_POST["data"];
		$result = $this->crud_model->generalInsertToDatabase($table_name, $data);
		echo json_encode($result);
	}

	public function generalUpdateData () {
		$table_name = $_POST["table_name"];
		$column = $_POST["column"];
		$key = $_POST["key"];
		$data = $_POST["data"];
		$result = $this->crud_model->generalUpdateData($column, $key, $table_name, $data);
	}

	public function createSubmetricsTable ($obj) {
		if (isset($_POST)) {
			$table_name = $_POST["submetric_table_name"];
			$column_names = $_POST["submetric_columns"];
			$metric_id = $_POST["metric_id"];
			$show_on_modal = $_POST["show_on_modal"];
		} else {
			$table_name = $obj["submetric_table_name"];
			$column_names = $obj["submetric_columns"];
			$metric_id = $obj["metric_id"];
			$show_on_modal = $obj["show_on_modal"];
		}
		
		$fields = array(
			"instance_id" => array(
				"type" => "INT",
				"null" => FALSE,
				"auto_increment" => TRUE
			),
			"metric_ref_id" => array(
				"type" => "INT",
				"null" => FALSE
			)
		);

		foreach ($column_names as $name) {
			$fields[$name] = array(
				"type" => "TINYINT",
				"default" => "0"
			);
		}

		$this->crud_model->createSubmetricsTable($table_name, $fields, "instance_id");

		// Insert metric-submetric pair on submetrics table
		$data = array(
			"metric_id" => $metric_id,
			"submetric_table_name" => $table_name,
			"show_on_modal" => $show_on_modal
		);

		$result = $this->crud_model->generalInsertToDatabase("submetrics", $data);
	}

	public function updateSubmetricsTable () {
		$table_name = $_POST["submetric_table_name"];
		$column_names = $_POST["submetric_columns"];
		$metric_id = $_POST["metric_id"];
		$show_on_modal = $_POST["show_on_modal"];

		$old_table_name = isset($_POST["old_table_name"]) ? $_POST["old_table_name"] : null;
		$old_columns = isset($_POST["old_columns"]) ? $_POST["old_columns"] : null;

		if (!is_null($old_table_name)) {
			if ($old_table_name === "new") {
				$obj = array(
					"submetric_table_name" => $table_name,
					"submetric_columns" => $column_names,
					"metric_id" => $metric_id,
					"show_on_modal" => $show_on_modal
				);
				$this->createSubmetricsTable($obj);
			} else {
				try {
					$bool = $this->crud_model->renameSubmetricsTable($old_table_name, $table_name);
					if ($bool === false) {
						throw new Exception("Error renaming table");
					}
				} catch (Exception $e) {
					echo $e->getMessage();
				}

				if (!is_null($old_columns)) {
					$count_new = count($column_names);
					$count_old = count($old_columns);
					$modified_columns = [];
					$new_columns = [];
					for ($i = 0; $i < $count_new; $i += 1) {
						if ($i < $count_old) {
							$modified_columns[$old_columns[$i]] = array(
								"name" => $column_names[$i],
								"type" => "TINYINT",
								"default" => "0"
							);
						} else {
							$new_columns[$column_names[$i]] = array(
								"type" => "TINYINT",
								"default" => "0"
							);
						}
					}

					$this->crud_model->updateSubmetricColumnNames($table_name, $modified_columns);

					if (count($new_columns) > 0) {
						$this->crud_model->addNewColumnsOnExistingSubmetricTable($table_name, $new_columns);
					}
				}

				$data = array("submetric_table_name" => $table_name, "show_on_modal" => $show_on_modal);
				$this->crud_model->generalUpdateData("submetric_id", $_POST["submetric_id"], "submetrics", $data);
			}
		}
	}
}
