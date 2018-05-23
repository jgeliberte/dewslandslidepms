
<link rel="stylesheet" type="text/css" href="/css/local/crud_page.css">
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
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button id="submit" class="btn btn-info" role="submit">Okay</button>
                        <button id="cancel" class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- End of MODAL AREA -->
</div>
