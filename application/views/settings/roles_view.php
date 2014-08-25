<div>
    <div class="header-title">
        <h2>
            <?php echo $page_title; ?>
        </h2>
    </div>
    
    <div class="table-responsive dataTables_wrapper" role="grid">
        <table id="rolesDataTables" class="display table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="width: 300px;">Role Name</th>
                    <th>Description</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <form id="rolesForm" role="form">
        <div class="modal fade" id="rolesModal" tabindex="-1" role="dialog" aria-labelledby="rolesModalLabel" aria-hidden="true">
            <div class="modal-dialog width-1000px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Role</h4>
                    </div>

                    <div class="modal-body">
                        <!-- message info -->
                        <div id="formRolesMessage" class="alert display-none">
                            <span></span>
                        </div>

                        <div class="pull-left width-50">
                            <div id="form-group-role" class="form-group">
                                <label for="role">Role Name *</label>
                                <input type="hidden" id="edit_id" name="edit_id" />
                                <input type="hidden" id="edit_role" name="edit_role" />
                                <input type="text" class="form-control width-250px" id="role" name="role" placeholder="Role Name" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
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
                        
                        <div class="pull-left width-50 padding-left-60px">
                            <div id="form-group-role_resources" class="form-group">
                                <label id="role_resources" class="form-control-label" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual">Resources *</label>
                                <div class="role_resources_list">
                                    <ul>
                                        <?php if (is_array($role_resources) && count($role_resources) > 0): ?>
                                            <?php $x = 1; ?>
                                            <?php foreach ($role_resources as $role): ?>
                                                <li>
                                                    <label>
                                                        <input type="checkbox" id="role-<?php echo $role['id']; ?>" name="role_resources[]" class="checklist parent-<?php echo $x; ?>" dataid="<?php echo $x; ?>" dataname="parent" value="<?php echo $role['id']; ?>" />
                                                        <?php echo $role['name']; ?>
                                                    </label>
                                                    <?php if (is_array($role['child']) && count($role['child']) > 0): ?>
                                                        <ul class="child">
                                                            <?php foreach ($role['child'] as $row): ?>
                                                                <li>
                                                                    <label>
                                                                        <input type="checkbox" id="role-<?php echo $row['id']; ?>" name="role_resources[]" class="checklist child-<?php echo $x; ?>" dataid="<?php echo $x; ?>" dataname="child" value="<?php echo $row['id']; ?>" />
                                                                        <?php echo $row['name']; ?>
                                                                    </label>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </li>
                                                <?php $x++; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
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
