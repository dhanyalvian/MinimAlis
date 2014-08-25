<div>
    <div class="header-title">
        <h2>
            <?php echo $page_title; ?>
        </h2>
    </div>
    
    <div class="table-responsive dataTables_wrapper" role="grid">
        <table id="navigationsDataTables" class="display table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="min-width:120px;">Title</th>
                    <th style="min-width:120px;">Navigation Controller</th>
                    <th style="min-width:150px;">URL</th>
                    <th style="min-width:120px;">Parent</th>
                    <th style="width:90px;">Display</th>
                    <th style="width:90px;">Sort</th>
                    <th style="width:90px;">Status</th>
                    <th style="width:90px;">Action</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <form id="navigationsForm" role="form">
        <div class="modal fade" id="navigationsModal" tabindex="-1" role="dialog" aria-labelledby="navigationsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Navigation</h4>
                    </div>

                    <div class="modal-body">
                        <!-- message info -->
                        <div id="formNavigationsMessage" class="alert display-none">
                            <span></span>
                        </div>

                        <div class="pull-left">
                            <div id="form-group-username" class="form-group">
                                <label for="username">Title *</label>
                                <input type="hidden" id="edit_id" name="edit_id" />
                                <input type="hidden" id="edit_username" name="edit_username" />
                                <input type="text" class="form-control width-200px" id="username" name="username" placeholder="Username" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>

                            <div id="form-group-fullname" class="form-group">
                                <label for="fullname">Navigation Controller *</label>
                                <input type="text" class="form-control width-300px" id="fullname" name="fullname" placeholder="Fullname" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-fullname" class="form-group">
                                <label for="fullname">URL *</label>
                                <input type="text" class="form-control width-300px" id="fullname" name="fullname" placeholder="Fullname" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-role" class="form-group">
                                <label for="role">Parent</label>
                                <select id="role" name="role" class="form-control">
                                    <?php if (is_array($combobox_parent) && count($combobox_parent) > 0): ?>
                                        <?php foreach ($combobox_parent as $row): ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div>
                                <div class="pull-left width-50">
                                    <div id="form-group-status" class="form-group">
                                        <label for="status">Display</label>
                                        <select id="status" name="status" class="form-control">
                                            <option value="1">Show</option>
                                            <option value="0">Hide</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="pull-left width-50">
                                    <div id="form-group-status" class="form-group">
                                        <label for="status">Sort</label>
                                        <select id="status" name="status" class="form-control">
                                            <?php for ($x = 1; $x <= 10; $x++): ?>
                                                <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
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
</div>
