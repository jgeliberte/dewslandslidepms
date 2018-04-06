	
<!--=================
	MODAL PROPER
===================-->
<div class="modal fade" id="pms_modal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        	<form class="pms-form" role="form">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
	                <div class="modal-title" style="font-size:16px;">
	                	<strong>Performance Monitoring System</strong>
	            	</div>
	            </div>

	            <div class="modal-body">
            		<?php echo $additional_entries; ?>

	                <div class="row">
	                	<div class="form-group col-sm-12">
	                		<label class="control-label" for="report_message">Report Message</label>
	                		<textarea class="form-control trigger_info" rows="4" id="report_message" name="report_message" 
	                		placeholder="Enter report" maxlength="500" style="resize:vertical;"></textarea>
	                	</div>
	                </div>
	            </div>

	            <div class="modal-footer">
	                <button id="submit" class="btn btn-danger" role="button" type="submit">Submit</button>
	                <button id="cancel" class="btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
	            </div>
	        </form>
        </div>
    </div>
</div>