<?php
class Api_test extends TestCase
{
	public function testInsertDynaslopeTeam() {
		$output = $this->request("GET",["Api","insertDynaslopeTeam","team_".rand(),"team description"]);
		$this->assertEquals($output,true);
	}

	public function testInsertModule() {
		$output = $this->request("GET",["Api","insertModule",1,"module_".rand(),"module_description"]);
		$this->assertInternalType("int",(int) $output);
	}

	public function testInsertMetric() {
		$output = $this->request("GET",["Api","insertMetric",1,"metric_".rand(),"module_description"]);
		$this->assertInternalType("int",(int) $output);
	}

	public function testInsertAccuracyReport() {
		$data = [
			'type' => 'accuracy',
			'metric_id' => '1',
			'team_id' => '1',
			'metric_name' => 'metric_1965136936',
			'module' => 'chatterbox',
			'ts_received' => '2017-09-21 03:33:33',
			'ts_data' => '2017-09-21 03:30:00',
			'report_message' => 'This is just a test No.'.rand(),
			'limit' => 'specific'
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertInternalType("int",(int) $output);
	}

	public function testInsertErrorRateReport() {
		$data = [
			'type' => 'error_rate',
			'metric_id' => '1',
			'team_id' => '1',
			'metric_name' => 'metric_1965136936',
			'module' => 'chatterbox',
			'ts_received' => '2017-09-21 03:33:33',
			'report_message' => 'This is just a test No.'.rand(),
			'limit' => 'specific'
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertEquals($output,true);
	}

	public function testInsertTimelinessReport() {
		$data = [
			'type' => 'timeliness',
			'metric_id' => '1',
			'team_id' => '1',
			'metric_name' => 'metric_1965136936',
			'module' => 'chatterbox',
			'ts_received' => '2017-09-21 03:33:33',
			'execution_time' => rand(),
			'limit' => 'specific'
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertEquals($output,true);
	}

	public function testInsertAccuracyReportNewMetric() {
		$data = [
			'type' => 'accuracy',
			'team_id' => '1',
			'metric_id' => '',
			'metric_name' => 'new_metric_'.rand(),
			'module' => 'chatterbox',
			'ts_received' => '2017-09-21 03:33:33',
			'ts_data' => '2017-09-21 03:30:00',
			'report_message' => 'This is just a test No.'.rand().' for Accuracy report without metric',
			'limit' => 'specific'
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertInternalType("int",(int) $output);

	}

	public function testInsertErrorRateReportNewMetric() {
		$data = [
			'type' => 'error_rate',
			'team_id' => '1',
			'metric_id' => '',
			'metric_name' => 'new_metric_'.rand(),
			'module' => 'chatterbox',
			'ts_received' => '2017-09-21 03:33:33',
			'ts_data' => '2017-09-21 03:30:00',
			'report_message' => 'This is just a test No.'.rand().' for Accuracy report without metric',
			'limit' => 'specific'
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertInternalType("int",(int) $output);
	}

	public function testInsertTimelinessReportNewMetric() {
		$data = [
			'type' => 'timeliness',
			'team_id' => '1',
			'metric_id' => '',
			'metric_name' => 'new_metric_'.rand(),
			'module' => 'chatterbox',
			'ts_received' => '2017-09-21 03:33:33',
			'execution_time' => '23',
			'report_message' => 'This is just a test No.'.rand().' for Accuracy report without metric',
			'limit' => 'specific'
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertInternalType("int",(int) $output);
	}

	public function testInsertAccuracyReportNewModuleMetrics() {
		$data = [
			'type' => 'accuracy',
			'team_id' => '1',
			'metric_id' => '',
			'metric_name' => 'new_metric_'.rand(),
			'module' => 'new_module_'.rand(),
			'ts_received' => '2017-09-21 03:33:33',
			'ts_data' => '2017-09-21 03:30:00',
			'report_message' => 'This is just a test No.'.rand().' for Accuracy report new module and metric',
			'limit' => 'specific'
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertInternalType("int",(int) $output);
	}

	public function testInsertErrorRateReportWithoutModule() {
		$data = [
			'type' => 'error_rate',
			'team_id' => '1',
			'metric_id' => '',
			'metric_name' => 'new_metric_'.rand(),
			'module' => 'new_module_'.rand(),
			'ts_received' => '2017-09-21 03:33:33',
			'ts_data' => '2017-09-21 03:30:00',
			'report_message' => 'This is just a test No.'.rand().' for Error rate report new module and metric',
			'limit' => 'specific'
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertInternalType("int",(int) $output);
	}

	public function testInsertTimelinessReportNewModuleMetric() {
		$data = [
			'type' => 'timeliness',
			'team_id' => '1',
			'metric_id' => '',
			'metric_name' => 'new_metric_'.rand(),
			'module' => 'new_module',
			'ts_received' => '2017-09-21 03:33:33',
			'execution_time' => '23',
			'report_message' => 'This is just a test No.'.rand().' for Timeliness report without metric',
			'limit' => 'specific'
		];
		$send_data = ['data' => $data];
		$output = $this->request("POST",["Api","insertReport"],$send_data);
		$this->assertInternalType("int",(int) $output);
	}
}