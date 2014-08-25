<div>
    <div class="header-title">
        <h2>
            <?php echo $page_title; ?>
        </h2>
    </div>
    
    <div class="table-responsive dataTables_wrapper" role="grid">
        <table id="usersDataTables" class="display table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="width: 200px;">Username</th>
                    <th>Fullname</th>
                    <th style="width: 200px;">Role</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <form id="usersForm" role="form">
        <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New User</h4>
                    </div>

                    <div class="modal-body">
                        <!-- message info -->
                        <div id="formUsersMessage" class="alert display-none">
                            <span></span>
                        </div>

                        <div class="pull-left">
                            <div id="form-group-username" class="form-group">
                                <label for="username">Username *</label>
                                <input type="hidden" id="edit_id" name="edit_id" />
                                <input type="hidden" id="edit_username" name="edit_username" />
                                <input type="text" class="form-control width-200px" id="username" name="username" placeholder="Username" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>

                            <div id="form-group-fullname" class="form-group">
                                <label for="fullname">Fullname *</label>
                                <input type="text" class="form-control width-300px" id="fullname" name="fullname" placeholder="Fullname" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-role" class="form-group">
                                <label for="role">Role</label>
                                <select id="role" name="role" class="form-control">
                                    <?php
                                    if (is_array($combobox_role) && count($combobox_role) > 0):
                                        foreach ($combobox_role as $row):
                                            ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
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
