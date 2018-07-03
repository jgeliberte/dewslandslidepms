
<link rel="stylesheet" type="text/css" href="/css/local/crud_page.css">
<link rel="stylesheet" type="text/css" href="/css/local/switch.css">
<script type="text/javascript" src="/js/crud_page.js"></script>

<div id="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div id="page-header">GENERAL INPUT PAGE</div>
            </div>
        </div>

        <!-- TILE TEMPLATES -->
        <div hidden="hidden">
            <div id="tile-template" class="tile" data-id="1">
                <div class="row">
                    <div class="col-sm-9">
                        <h4 class="tile-title">SWAT</h4>
                    </div>
                    <div class="col-sm-3 tile-buttons">
                        <span class="fa fa-expand tile-expand"></span>
                    </div>
                </div>
                <div class="tile-description">Short, sweet data point goes here...</div>
            </div>

            <div id="add-tile-template" class="tile add-tile" hidden="hidden">
                <span class="fa fa-plus"></span>
            </div>
        </div>
        <!-- END OF TILE TEMPLATES -->

        <div class="tile-field" id="teams">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="container-line timeline-head">
                        <span class="circle left"></span>
                        <div class="container-line-text timeline-head-text">Dynaslope Teams</div>
                        <span class="circle right"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 instruction">
                    Select a team tile...
                </div>
            </div>

            <div class="tile-rows"></div>
        </div>

        <div class="tile-field" id="modules" hidden="hidden">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="container-line timeline-head">
                        <span class="circle left"></span>
                        <div class="container-line-text timeline-head-text">Modules</div>
                        <span class="circle right"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 instruction">
                    Select a module tile...
                </div>
            </div>

            <div class="tile-rows"></div>
        </div>

        <div class="tile-field" id="metrics" hidden="hidden">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="container-line timeline-head">
                        <span class="circle left"></span>
                        <div class="container-line-text timeline-head-text">Metrics</div>
                        <span class="circle right"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 instruction">
                    Select a metrics tile...
                </div>
            </div>

            <div class="tile-rows"></div>
        </div>
    </div>

    <!-- MODAL AREA -->
    <div class="modal fade" id="input-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div><strong><span class="modal-title">Performance Monitoring System</span></strong></div>
                </div>
                <form id="input-form">
                    <div class="modal-body">
                        <div><strong><span id="field-id">Team</span> Input</strong></div>
                        <div class="row"><hr/></div>
                        <div class="form-group">
                            <label class="control-label" for="name">Name</label>
                            <input type="text" class="form-control form-input" id="name" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="desc">Description</label>
                            <textarea row="5" maxlength="300" class="form-control form-input" id="desc" name="desc" placeholder="Description"></textarea>
                        </div>
                        <div id="metrics-options" hidden="hidden">
                            <div class="form-group">
                                <label class="control-label" for="type">Metric Type</label>
                                <select class="form-control form-input metric-option" id="type" name="type">
                                    <option value="">---</option>
                                    <option value="1">Accuracy</option>
                                    <option value="2">Error Log</option>
                                    <option value="3">Timeliness</option>
                                </select>
                            </div>
                        </div>
                        <div id="submetrics-switch" hidden="hidden">
                            <div class="row"><hr/></div>
                            <div class="form-group" style="margin-bottom: 0">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="control-label" for="submetrics_cbox">Submetrics</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <label class="switch">
                                            <input type="checkbox" id="submetrics_cbox" name="submetrics_cbox" value="1"><span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div id="submetrics-option" hidden="hidden">
                            <div class="row"><hr/></div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3" style="line-height: 29px">
                                        <label class="control-label" for="submetric_table_name">Table Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><strong>submetrics_</strong></span>
                                            <input type="text" class="form-control form-input" id="submetric_table_name" name="submetric_table_name" placeholder="Submetrics table name" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 0">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="control-label" for="show_on_modal">Show On Modal</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <label class="switch">
                                            <input type="checkbox" id="show_on_modal" name="show_on_modal" value="1" disabled="disabled"><span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="submetric-template" hidden="hidden">
                                <div class="row">
                                    <div class="col-sm-3" style="line-height: 29px">
                                        <label class="control-label" for="submetric-name">Checkbox Label</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-input submetric_column" name="submetric_column" placeholder="Submetric Name" disabled="disabled">
                                            <span class="input-group-btn">
                                                <button class="remove btn btn-danger" type="button">X</button>
                                            </span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="row"><hr/></div>
                            <div id="less-column-alert" class="alert alert-danger fade in" hidden="hidden">
                                <strong>Warning!</strong> You must have at least two table columns.
                            </div>
                            <div id="submetric-columns"></div>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button type="button" id="add-submetric" class="btn btn-info" role="button">Add Column</button>
                                </div>
                            </div>
                        </div>                         
                    </div>
                    <div class="modal-footer">
                        <button id="submit" class="btn btn-danger" role="submit">Submit</button>
                        <button id="cancel" class="btn btn-info" data-dismiss="modal" role="button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- End of MODAL AREA -->
</div>
