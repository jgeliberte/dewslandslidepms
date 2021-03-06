<?php
class Api_test extends TestCase
{	
	// public function testInsertDynaslopeTeam() {
	// 	$output = $this->request("GET",["Api","insertDynaslopeTeam","team_".rand(),"team description"]);
	// 	$status = json_decode($output);
	// 	$this->assertEquals(true,$status->status);
	// }

	// public function testInsertModule() {
	// 	$output = $this->request("GET",["Api","insertModule",1,"module_".rand(),"module_description"]);
	// 	$this->assertInternalType("int",(int) $output);
	// }

	// public function testInsertMetric() {
	// 	$output = $this->request("GET",["Api","insertMetric",1,"metric_".rand(),"module_description"]);
	// 	$this->assertInternalType("int",(int) $output);
	// }

	// public function testInsertAccuracyReport() {
	// 	$data = [
	// 		'type' => 'accuracy',
	// 		'team_id' => '1',
	// 		'metric_name' => 'metric_495645986',
	// 		'module_name' => 'chatterbox',
	// 		'reference_id' => '1',
	// 		'reference_table' => 'smsinbox',
	// 		'report_message' => 'This is just a test No. 1',
	// 		'limit' => 'specific'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","insertReport"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true,$result->status);
	// }

	// public function testInsertErrorRateReport() {
	// 	$data = [
	// 		'type' => 'error_rate',
	// 		'metric_id' => '1',
	// 		'team_id' => '1',
	// 		'metric_name' => 'metric_495645986',
	// 		'module_name' => 'chatterbox',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'report_message' => 'This is just a test No.'.rand(). " from test case No. 5",
	// 		'limit' => 'specific'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","insertReport"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true,$result->status);
	// }

	// public function testInsertTimelinessReport() {
	// 	$data = [
	// 		'type' => 'timeliness',
	// 		'metric_id' => '1',
	// 		'team_id' => '1',
	// 		'metric_name' => 'metric_495645986',
	// 		'module_name' => 'chatterbox',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'execution_time' => rand(),
	// 		'limit' => 'specific'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","insertReport"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true,$result->status);
	// }

	public function testAccuracyReportWithSubmetrics() {
		$data = [
			'type' => 'accuracy',
			'team_name' => 'swat',
			'metric_name' => 'quick_search',
			'module_name' => 'chatterbox',
			'reference_id' => '1',
			'reference_table' => 'smsinbox',
			'report_message' => 'This is just a test No. '.rand(0,99999999999),
			'limit' => 'specific',
			'submetrics' => ['test1']
		];
		$output = $this->request("POST",["Api","insertReport"],$data);
		$result = json_decode($output);
		$this->assertEquals(true,$result->status);
	}

	// public function testErrorLogReportWithSubmetrics() {
	// 	$data = [
	// 		'type' => 'error_logs',
	// 		'metric_id' => '1',
	// 		'team_id' => '1',
	// 		'metric_name' => 'metric_495645986',
	// 		'module_name' => 'chatterbox',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'execution_time' => rand(),
	// 		'limit' => 'specific'
	// 	];
	// 	$output = $this->request("POST",["Api","insertReport"],$data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true,$result->status);
	// }

	// public function testTimelinessReportWithSubmetrics() {
	// 	$data = [
	// 		'type' => 'timeliness',
	// 		'metric_id' => '1',
	// 		'team_id' => '1',
	// 		'metric_name' => 'metric_495645986',
	// 		'module_name' => 'chatterbox',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'execution_time' => rand(),
	// 		'limit' => 'specific'
	// 	];
	// 	$output = $this->request("POST",["Api","insertReport"],$data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true,$result->status);
	// }


	// public function testInsertAccuracyReportNewMetric() {
	// 	$data = [
	// 		'type' => 'accuracy',
	// 		'team_id' => '1',
	// 		'metric_id' => '',
	// 		'metric_name' => 'new_metric_'.rand(),
	// 		'module_name' => 'chatterbox',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'reference_id' => '1',
	// 		'reference_table' => 'smsinbox',
	// 		'report_message' => 'This is just a test No.'.rand().' for Accuracy report without metric',
	// 		'limit' => 'specific'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","insertReport"],$send_data);
	// 	$raw = explode("{",$output);
	// 	$result = json_decode("{".$raw[1]);
	// 	$this->assertEquals(true,$result->status);
	// }

	// public function testInsertErrorRateReportNewMetric() {
	// 	$data = [
	// 		'type' => 'error_rate',
	// 		'team_id' => '1',
	// 		'metric_id' => '',
	// 		'metric_name' => 'new_metric_'.rand(),
	// 		'module_name' => 'chatterbox',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'ts_data' => '2017-09-21 03:30:00',
	// 		'report_message' => 'This is just a test No.'.rand().' for Accuracy report without metric',
	// 		'limit' => 'specific'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","insertReport"],$send_data);
	// 	$raw = explode("{",$output);
	// 	$result = json_decode("{".$raw[1]);
	// 	$this->assertEquals(true,$result->status);
	// }

	// public function testInsertTimelinessReportNewMetric() {
	// 	$data = [
	// 		'type' => 'timeliness',
	// 		'team_id' => '1',
	// 		'metric_id' => '',
	// 		'metric_name' => 'new_metric_'.rand(),
	// 		'module_name' => 'chatterbox',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'execution_time' => '23',
	// 		'report_message' => 'This is just a test No.'.rand().' for Accuracy report without metric',
	// 		'limit' => 'specific'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","insertReport"],$send_data);
	// 	$raw = explode("{",$output);
	// 	$result = json_decode("{".$raw[1]);
	// 	$this->assertEquals(true,$result->status);
	// }

	// public function testInsertAccuracyReportNewModuleMetrics() {
	// 	$data = [
	// 		'type' => 'accuracy',
	// 		'team_id' => '1',
	// 		'metric_id' => '',
	// 		'metric_name' => 'new_metric_'.rand(),
	// 		'module_name' => 'new_module_'.rand(),
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'reference_id' => '1',
	// 		'reference_table' => 'smsinbox',
	// 		'report_message' => 'This is just a test No.'.rand().' for Accuracy report new module and metric',
	// 		'limit' => 'specific'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","insertReport"],$send_data);
	// 	$raw = explode("{",$output);
	// 	$result = json_decode("{".$raw[1]);
	// 	$this->assertEquals(true,$result->status);
	// }

	// public function testInsertErrorRateReportWithoutModule() {
	// 	$data = [
	// 		'type' => 'error_rate',
	// 		'team_id' => '1',
	// 		'metric_id' => '',
	// 		'metric_name' => 'new_metric_'.rand(),
	// 		'module_name' => 'new_module_'.rand(),
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'ts_data' => '2017-09-21 03:30:00',
	// 		'report_message' => 'This is just a test No.'.rand().' for Error rate report new module and metric',
	// 		'limit' => 'specific'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","insertReport"],$send_data);
	// 	$raw = explode("{",$output);
	// 	$result = json_decode("{".$raw[1]);
	// 	$this->assertEquals(true,$result->status);
	// }

	// public function testInsertTimelinessReportNewModuleMetric() {
	// 	$data = [
	// 		'type' => 'timeliness',
	// 		'team_id' => '1',
	// 		'metric_id' => '',
	// 		'metric_name' => 'new_metric_'.rand(),
	// 		'module_name' => 'new_module',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'execution_time' => '23',
	// 		'report_message' => 'This is just a test No.'.rand().' for Timeliness report without metric',
	// 		'limit' => 'specific'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","insertReport"],$send_data);
	// 	$raw = explode("{",$output);
	// 	$result = json_decode("{".$raw[1]);
	// 	$this->assertEquals(true,$result->status);
	// }

	// public function testGetModule() {
	// 	$output = $this->request("GET",["Api","getModule","chatterbox","specific"]);
	// 	$this->assertInternalType("array",(array) $output);
	// }

	// public function testGetAllModules() {
	// 	$output = $this->request("GET",["Api","getAllModules"]);
	// 	$this->assertInternalType("array",(array) $output);
	// }

	// public function testGetMetric() {
	// 	$output = $this->request("GET",["Api","getAllModules","metric_2057687492","specific"]);
	// 	$this->assertInternalType("array",(array) $output);
	// }

	// public function testGetAllMetrics() {
	// 	$output = $this->request("GET",["Api","getAllModules"]);
	// 	$this->assertInternalType("array",(array) $output);	
	// }

	// public function testGetDynaslopeTeam() {
	// 	$output = $this->request("GET",["Api","getDynaslopeTeams","team_2018124281","specific"]);
	// 	$this->assertInternalType("array",(array) $output);	
	// }

	// public function testGetAllDynaslopeTeams() {
	// 	$output = $this->request("GET",["Api","getDynaslopeTeams"]);
	// 	$this->assertInternalType("array",(array) $output);	
	// }

	// public function testGetSpecificAccuracyReport() {
	// 	$output = $this->request("GET",["Api","getReports","accuracy","1","2","specific"]);
	// 	$this->assertInternalType("array", (array) $output);
	// }

	// public function testGetAllAccuracyReport() {
	// 	$output = $this->request("GET",["Api","getReports","accuracy"]);
	// 	$this->assertInternalType("array", (array) $output);
	// }

	// public function testGetSpecificErrorRateReport() {
	// 	$output = $this->request("GET",["Api","getReports","error_rate","1","1","specific"]);
	// 	$this->assertInternalType("array", (array) $output);
	// }

	// public function testGetAllErrorRateReport() {
	// 	$output = $this->request("GET",["Api","getReports","error_rate"]);
	// 	$this->assertInternalType("array", (array) $output);
	// }

	// public function testGetSpecificTimelinessReport() {
	// 	$output = $this->request("GET",["Api","getReports","timeliness","1","1","specific"]);
	// 	$this->assertInternalType("array", (array) $output);
	// }

	// public function testGetAllTimelinessReport() {
	// 	$output = $this->request("GET",["Api","getReports","timeliness"]);
	// 	$this->assertInternalType("array", (array) $output);
	// }

	// public function testUpdateModule() {
	// 	$data = [
	// 		'module_id' => '1',
	// 		'team_id' => '1',
	// 		'name' => 'update_module_'.rand(),
	// 		'description' => 'Update Module description'
	// 	];

	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","updateModule"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testUpdateMetric() {
	// 	$data = [
	// 		'metric_id' => '1',
	// 		'module_id' => '1',
	// 		'name' => 'update_metric_'.rand(),
	// 		'description' => 'Update Metric description'
	// 	];

	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","updateMetric"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testUpdateDynaslopeTeam() {
	// 	$data = [
	// 		'team_id' => '1',
	// 		'name' => 'new team name baby'.rand(),
	// 		'description' => 'new description baby'.rand()
	// 	];

	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","updateDynaslopeTeams"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testUpdateAccuracyReport() {
	// 	$data = [
	// 		'type' => 'accuracy',
	// 		'report_id' => '1',
	// 		'metric_id' => '1',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'module_name' => 'bulletin',
	// 		'reference_id' => '1',
	// 		'reference_table' => 'smsoubox',
	// 		'report_message' => 'This is just a test No.'.rand(). " from test case No. 4, updating of accuracy report"
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","updateReport"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testUpdateErrorRateReport() {
	// 	$data = [
	// 		'type' => 'error_rate',
	// 		'report_id' => '1',
	// 		'metric_id' => '1',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'report_message' => 'This is just a test No.'.rand(). " from test case No. 4, updating of accuracy report"
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","updateReport"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testUpdateTimelinessReport() {
	// 	$data = [
	// 		'type' => 'timeliness',
	// 		'report_id' => '1',
	// 		'metric_id' => '1',
	// 		'ts_received' => '2017-09-21 03:33:33',
	// 		'execution_time' => rand(1,10)
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","updateReport"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testDeleteMetric() {
	// 	$data = [
	// 		'metric_id' => '1'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","deleteMetric"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testDeleteModule() {
	// 	$data = [
	// 		'module_id' => '1'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","deleteModule"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testDeleteDynaslopeTeam() {
	// 	$data = [
	// 		'team_id' => '1'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","deleteTeam"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testDeleteAccuracyReport() {
	// 	$data = [
	// 		'type' => 'accuracy',
	// 		'report_id' => '1'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","deleteReport"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testDeleteErrorRateReport() {
	// 	$data = [
	// 		'type' => 'error_rate',
	// 		'report_id' => '1'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","deleteReport"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }

	// public function testDeleteTimelinessReport() {
	// 	$data = [
	// 		'type' => 'timeliness',
	// 		'report_id' => '1'
	// 	];
	// 	$send_data = ['data' => $data];
	// 	$output = $this->request("POST",["Api","deleteReport"],$send_data);
	// 	$result = json_decode($output);
	// 	$this->assertEquals(true, $result->status);
	// }
}