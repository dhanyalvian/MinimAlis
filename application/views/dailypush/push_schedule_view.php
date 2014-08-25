<div>
    <div class="header-title">
        <h2>
            <?php echo $page_title; ?>
        </h2>
    </div>
    
    <div class="table-responsive dataTables_wrapper" role="grid">
        <table id="pushScheduleDataTables" class="display table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Operator</th>
                    <th>ADN</th>
                    <th>Recurring Type</th>
                    <th>Content Label</th>
                    <th>Handler File</th>
                    <th style="width:140px;">Push Time</th>
                    <th style="width:90px;text-align:center;">Price</th>
                    <th style="width:90px;">Status</th>
                    <th style="width:90px;text-align:center;">Action</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <form id="pushScheduleForm" role="form">
        <div class="modal fade" id="pushScheduleModal" tabindex="-1" role="dialog" aria-labelledby="pushScheduleModalLabel" aria-hidden="true">
            <div class="modal-dialog width-1000px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Push Schedule</h4>
                    </div>

                    <div class="modal-body">
                        <!-- message info -->
                        <div id="formPushScheduleMessage" class="alert display-none">
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
                            
                            <div id="form-group-operator" class="form-group">
                                <label for="operator">Operator</label>
                                <select id="operator" name="operator" class="form-control">
                                    <?php if (is_array($combobox_operator) && count($combobox_operator) > 0): ?>
                                        <?php foreach ($combobox_operator as $operator): ?>
                                            <option value="<?php echo $operator['name']; ?>"><?php echo $operator['name'] . ' [' . $operator['long_name'] . ']'; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div id="form-group-adn" class="form-group">
                                <label for="adn">ADN</label>
                                <select id="adn" name="adn" class="form-control">
                                    <?php if (is_array($combobox_adn) && count($combobox_adn) > 0): ?>
                                        <?php foreach ($combobox_adn as $adn): ?>
                                            <option value="<?php echo $adn['name']; ?>"><?php echo $adn['name']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div id="form-group-recurring_type" class="form-group">
                                <label for="recurring_type">Recurring Type</label>
                                <select id="recurring_type" name="recurring_type" class="form-control">
                                    <?php if (is_array($combobox_recurring_type) && count($combobox_recurring_type) > 0): ?>
                                        <?php foreach ($combobox_recurring_type as $key => $value): ?>
                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div id="form-group-handler_file_custom" class="form-group">
                                <label for="handler_file">Handler File *</label>
                                <div class="form-group">
                                    <div class="pull-left">
                                        <select id="handler_file" name="handler_file" class="form-control">
                                            <?php if (is_array($combobox_handler_file) && count($combobox_handler_file) > 0): ?>
                                                <?php foreach ($combobox_handler_file as $handler_file): ?>
                                                    <option value="<?php echo $handler_file; ?>"><?php echo $handler_file; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="pull-left margin-left-10px">
                                        <input type="text" id="handler_file_custom" name="handler_file_custom" class="form-control display-none" />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            
                            <div id="form-group-status" class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="1">Enabled</option>
                                    <option value="2">Disabled</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="pull-left width-50">
                            <div id="form-group-push_time" class="form-group">
                                <div><label for="push_time">Date Push *</label></div>

                                <div id="push_time_group" class='pull-left input-group date datetimepicker width-200px'>
                                    <input type='text' class="form-control" data-format="DD-MMM-YYYY hh:mm A" id="push_time" name="push_time" value="<?php echo $today; ?>" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                            
                            <div id="form-group-content_label" class="form-group">
                                <label for="content_label">Content Label *</label>
                                <input type="text" class="form-control width-200px" id="content_label" name="content_label" placeholder="Content Label" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-content_select" class="form-group">
                                <label for="content_select">Content Select *</label>
                                <input type="text" class="form-control width-200px" id="content_select" name="content_select" placeholder="Content Select" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-notes" class="form-group">
                                <label for="notes">Notes</label>
                                <textarea id="notes" name="notes" rows="3" class="form-control width-300px" placeholder="Notes"></textarea>
                            </div>
                            
                            <div id="form-group-price" class="form-group">
                                <label for="price">Price *</label>
                                <input type="text" class="form-control width-80px align-right" id="price" name="price" placeholder="" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>

                    <div class="modal-footer align-left">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-default btn-sm">
                                <span class="icon-fixed-width glyphicon glyphicon-ok icon-button-left"></span>
                                Save changes
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
