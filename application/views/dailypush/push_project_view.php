<div>
    <div class="header-title">
        <h2>
            <?php echo $page_title; ?>
        </h2>
    </div>
    
    <div class="table-responsive dataTables_wrapper" role="grid">
        <table id="pushProjectDataTables" class="display table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>SID</th>
                    <th>Source</th>
                    <th>Operator</th>
                    <th>Service</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Processed</th>
                    <th>Stat</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <form id="pushContentForm" role="form">
        <div class="modal fade" id="pushContentModal" tabindex="-1" role="dialog" aria-labelledby="pushContentModalLabel" aria-hidden="true">
            <div class="modal-dialog width-1000px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Push Content</h4>
                    </div>

                    <div class="modal-body">
                        <!-- message info -->
                        <div id="formPushContentMessage" class="alert display-none">
                            <span></span>
                        </div>

                        <div class="pull-left width-50">
                            <div id="form-group-service" class="form-group">
                                <label for="service">Service</label>
                                <input type="hidden" id="edit_id" name="edit_id" />
                                <select id="service" name="service" class="form-control">
                                    <?php if (is_array($combobox_service) && count($combobox_service) > 0): ?>
                                        <?php foreach ($combobox_service as $service): ?>
                                            <option value="<?php echo $service['name']; ?>"><?php echo $service['name']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div id="form-group-content_label" class="form-group">
                                <label for="content_label">Content Label *</label>
                                <input type="text" class="form-control width-200px" id="content_label" name="content_label" placeholder="Content Label" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-content" class="form-group">
                                <label for="content">Content *</label>
                                <input type="text" class="form-control width-250px" id="content" name="content" placeholder="Content" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-author" class="form-group">
                                <label for="author">Author *</label>
                                <input type="text" class="form-control width-200px" id="author" name="author" placeholder="Author" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                        </div>
                        
                        <div class="pull-left width-50">
                            <div id="form-group-notes" class="form-group">
                                <label for="notes">Notes</label>
                                <textarea id="notes" name="notes" rows="3" class="form-control width-300px" placeholder="Notes"></textarea>
                            </div>
                            
                            <div id="form-group-datepublish" class="form-group">
                                <div><label for="datepublish">Date Publish *</label></div>

                                <div id="datepublish_group" class='pull-left input-group date datetimepicker width-200px'>
                                    <input type='text' class="form-control" data-format="DD-MMM-YYYY hh:mm A" id="datepublish" name="datepublish" value="<?php echo $today; ?>" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>

                    <div class="modal-footer align-left">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <span class="icon-fixed-width glyphicon glyphicon-ok icon-button-left"></span>
                            Save changes
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <span class="icon-fixed-width glyphicon glyphicon-remove icon-button-left"></span>
                            Close
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>
</div>
