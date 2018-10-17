
<link rel="stylesheet" type="text/css" href="/css/local/crud_page.css">

<script type="text/javascript" src="/js/third-party/highcharts.js"></script>
<script type="text/javascript" src="/js/third-party/highcharts-more.js"></script>
<script type="text/javascript" src="/js/third-party/exporting.js"></script>
<script type="text/javascript" src="/js/third-party/export-data.js"></script>


<script type="text/javascript" src="/js/analysis_charts.js"></script>
<script type="text/javascript" src="/js/third-party/jquery-3.3.1.min.js"></script>


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
                        <div class="container-line-text timeline-head-text">Timeliness</div>
                        <span class="circle right"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
            	<div>Select a metric to view...</div>
            	<select class="form-control" id="selection-area">
            		<option value="bulletin">Bulletin</option>
					<option value="ewi">EWI</option>
            	</select>
            </div>
            <div class="col-sm-9" id="chart-container">
        </div>
        </div>
    </div>
