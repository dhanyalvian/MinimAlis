<div class="table-responsive dataTables_wrapper" role="grid">
    <table id="handlerDataTables" class="display table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 200px;">Handler Name</th>
                <th>Description</th>
                <th style="width: 200px;">Date Created</th>
                <th style="width: 100px; text-align: center;">Status</th>
                <th style="width: 100px; text-align: center;">Action</th>
            </tr>
        </thead>

        <tbody></tbody>
    </table>
</div>

<!-- Modal -->
<form id="handlerForm" role="form">
    <div class="modal fade" id="handlerModal" tabindex="-1" role="dialog" aria-labelledby="handlerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add New Handler</h4>
                </div>

                <div class="modal-body">
                    <!-- message info -->
                    <div id="formHandlerMessage" class="alert display-none">
                        <span></span>
                    </div>

                    <div class="pull-left">
                        <div id="form-group-handler" class="form-group">
                            <label for="handler">Handler Name *</label>
                            <input type="hidden" id="edit_id" name="edit_id" />
                            <input type="hidden" id="edit_handler" name="edit_handler" />
                            <input type="text" class="form-control width-200px" id="handler" name="handler" placeholder="Handler Name" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                        </div>

                        <div id="form-group-description" class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="3" class="form-control width-300px" placeholder="Description"></textarea>
                        </div>

                        <div id="form-group-status" class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="1">Enabled</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer align-left">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-default btn-sm">
                            <span class="icon-fixed-width glyphicon glyphicon-ok icon-button-left"></span>
                            Save
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <span class="icon-fixed-width glyphicon glyphicon-remove icon-button-left"></span>
                            Close
                        </button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>