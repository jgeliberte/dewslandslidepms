<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modal extends CI_Controller {

	public function __construct () {
		parent::__construct();
		$this->load->database();
		$this->load->model("crud_model");
	}

	public function index () {
		$metric_name = $_GET["metric_name"] === "" ? null : $_GET["metric_name"];
		$submetric_columns = null;
		$data = [];

		if (!is_null($metric_name)) {
			$data["submetric_checkboxes"] = $this->getSubmetricCheckboxes($metric_name);
    }
    
		if ($page === "bulletin") {
			$additional = $this->load->view("pms_modal/bulletin_entries", $data, true);
		} else if ($page === "ewi_sms") {
			$additional = $this->load->view("pms_modal/ewi_sms_entries", $data, true);
		} else if ($page === "chatterbox") {
			$additional = $this->load->view("pms_modal/chatterbox_entries", $data, true);
		} else {
			$additional = "";
		}

		$modal = $this->load->view("pms_modal/main", $data, true);

		header("Access-Control-Allow-Origin: http://www.dewslandslide.com");
		echo json_encode($modal);
	}

	public function getSubmetricCheckboxes ($metric_name, $is_ajax = false) {
		$is_ajax = $is_ajax === "1" ? true : false;

		$submetric_columns = $this->getSubmetricTableColumns($metric_name);

		$data["submetric_columns"] = $submetric_columns;
		$div = $this->load->view("pms_modal/submetric_checkboxes", $data, true);

		if (!$is_ajax) return $div;

		header("Access-Control-Allow-Origin: http://localhost");
		echo json_encode($div);
	}

	public function getSubmetricTableColumns ($metric_name) {
		$metric_id = $this->crud_model->getMetricID($metric_name);

		if (!is_null($metric_id)) {
			$metric_id = $metric_id->metric_id;
		} else {
			// echo("Error: No such metric name on the database");
			return null;
		}

		$sub = $this->crud_model->getSubmetricsTableName($metric_id);
		if (!is_null($sub)) {
			$submetric_table_name = $sub->submetric_table_name;
			$show_on_modal = $sub->show_on_modal;
		} else {
			// echo "No submetric table for $metric_name";
			return null;
		}

		if ((int) $show_on_modal === 0) return null;

		$columns = $this->crud_model->getSubmetricTableColumns($submetric_table_name);
		$columns = array_values(array_diff($columns, array("instance_id", "reference_id")));
		
		return $columns;
	}
}

?>