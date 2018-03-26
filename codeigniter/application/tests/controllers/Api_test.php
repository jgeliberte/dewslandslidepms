<?php
class Api_test extends TestCase
{
	public function test_insertDynaslopeTeam() {
		$output = $this->request("GET",["Api","insertDynaslopeTeam","team_".rand(),"team description"]);
		$this->assertEquals($output,true);
	}

	public function test_insertModule() {
		$output = $this->request("GET",["Api","insertModule",1,"module_".rand(),"module_description"]);
		$this->assertEquals($output,true);
	}

	public function test_insertMetric() {
		$output = $this->request("GET",["Api","insertMetric",1,"metric_".rand(),"module_description"]);
		$this->assertEquals($output,true);
	}

	public function test_inserAccuracyReport() {
		$data = [
			'type' => 'accuracy',
			'metric_id' => '29',
			'metric' => 'metric_1965136936',
			'ts_received' => '2017-09-21 03:33:33',
			'ts_data' => '2017-09-21 03:30:00',
			'report_message' => 'This is just a test No.'.rand()
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertEquals($output,true);
	}

	public function test_inserErrorRateReport() {
		$data = [
			'type' => 'error_rate',
			'metric_id' => '29',
			'metric' => 'metric_1965136936',
			'ts_received' => '2017-09-21 03:33:33',
			'report_message' => 'This is just a test No.'.rand()
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertEquals($output,true);
	}

	public function test_inserTimelinessReport() {
		$data = [
			'type' => 'timeliness',
			'metric_id' => '29',
			'metric' => 'metric_1965136936',
			'ts_received' => '2017-09-21 03:33:33',
			'execution_time' => rand()
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertEquals($output,true);
	}
}
