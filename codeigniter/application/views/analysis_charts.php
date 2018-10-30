
<link rel="stylesheet" type="text/css" href="/css/local/crud_page.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/datatables.css">
<link rel="stylesheet" type="text/css" href="/css/local/analysis_charts.css">


<script type="text/javascript" src="/js/third-party/highcharts.js"></script>
<script type="text/javascript" src="/js/third-party/highcharts-more.js"></script>
<script type="text/javascript" src="/js/third-party/exporting.js"></script>
<script type="text/javascript" src="/js/third-party/export-data.js"></script>


<script type="text/javascript" src="/js/analysis_charts.js"></script>
<script type="text/javascript" src="/js/third-party/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/js/third-party/datatables.min.js"></script>
<script type="text/javascript" src="/js/third-party/no-data-to-display.js"></script>

<div id="page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<div id="page-header">PMS Analysis Charts</div>
			</div>
		</div>
        <div class="tile-field" id="teams">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="container-line timeline-head">
                        <span class="circle left"></span>
                        <div class="container-line-text timeline-head-text">Plot Generator</div>
                        <span class="circle right"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
            	<div><?php echo $options_bar ?></div>
            </div>
            <div class="col-sm-12" id="chart-container"></div>
            <div class="col-sm-12" id="table-container">
            	<table id="metric-table" class="display table table-striped" cellspacing="0"
            	width="100%" hidden="hidden">
            		<thead id="header">
            			<tr>
	            			<th>Report ID</th>
	            			<th>Data Timestamp</th>
	            			<th id="metric-value">Value</th>
	            			<th>Report Message</th>
	            			<th>Reference ID</th>
	            			<th>Reference Table</th>
            			</tr>
            		</thead>
            		<tbody id="metric-table-body">
            		</tbody>
            		<tr id="row-template" hidden="hidden">
            			<td id="report-id"></td>
		            	<td id="ts-received"></td>
		            	<td id="value"></td>
		            	<td id="report-message"></td>
		            	<td id="reference-id"></td>
		            	<td id="reference-table"></td>
            		</tr>
            	</table>
            </div>
        </div>
    </div>
