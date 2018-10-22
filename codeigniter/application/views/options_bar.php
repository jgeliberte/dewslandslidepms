
    <div class="panel panel-default" id="options-bar-affix">
        <div class="panel-heading text-right">
            <span class="hideable-hide pull-left"><strong>PLOT OPTIONS: </strong></span><a id="toggle-options-bar" style="cursor: pointer"><strong><span class="fa fa-angle-double-left"></span></strong></a>
        </div>
        <div class="panel-body">
            <form id="site-analysis-form">

                <div class="row options-section-title hideable">
                    <div class="col-sm-12 text-center">
                        DYNASLOPE TEAM
                    </div>
                    <hr/>
                </div>

                <div class="form-group hideable">
                    <label class="control-label" for="team_name">Team Name</label>
                    <select class="form-control" id="team_name" name="team_name">
                        <option value="">---</option>
                    </select>
                </div>

                <div class="row options-section-title hideable">
                    <div class="col-sm-12 text-center">
                        MODULE
                    </div>
                    <hr/>
                </div>

                <div class="form-group hideable">
                    <label class="control-label" for="module_name">Module Name</label>
                    <select class="form-control" id="module_name" name="module_name">
                        <option value="">---</option>
                    </select>
                </div>
                
                <div class="row options-section-title hideable">
                    <div class="col-sm-12 text-center">
                        METRIC
                    </div>
                    <hr/>
                </div>

                <div class="form-group hideable">
                    <label class="control-label" for="metric_name">Metric Name</label>
                    <select class="form-control" id="metric_name" name="metric_name">
                        <option value="">---</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary btn-sm btn-block" id="download-charts">
                Download Charts <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
            </button>
        </div>
    </div>
