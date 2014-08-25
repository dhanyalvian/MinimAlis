<div>
    <div class="header-title">
        <h2>
            <?php echo $page_title; ?>
        </h2>
    </div>
    
    <div class="table-responsive dataTables_wrapper" role="grid">
        <table id="operatorDataTables" class="display table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="width: 300px;">Operator Name</th>
                    <th>Operator Long Name</th>
                    <!--th style="width: 100px; text-align: center;">Status</th-->
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <form id="operatorForm" role="form">
        <div class="modal fade" id="operatorModal" tabindex="-1" role="dialog" aria-labelledby="operatorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Operator</h4>
                    </div>

                    <div class="modal-body">
                        <!-- message info -->
                        <div id="formOperatorMessage" class="alert display-none">
                            <span></span>
                        </div>

                        <div class="pull-left">
                            <div id="form-group-operator" class="form-group">
                                <label for="operator">Operator Name *</label>
                                <input type="hidden" id="edit_id" name="edit_id" />
                                <input type="hidden" id="edit_operator" name="edit_operator" />
                                <input type="text" class="form-control width-200px lowercase" id="operator" name="operator" placeholder="Operator Name" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>

                            <div id="form-group-operator_long" class="form-group">
                                <label for="operator_long">Operator Long Name *</label>
                                <input type="text" class="form-control width-300px uppercase" id="operator_long" name="operator_long" placeholder="Operator Long Name" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
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
</div>
