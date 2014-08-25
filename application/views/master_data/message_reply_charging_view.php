<div class="table-responsive dataTables_wrapper" role="grid">
    <table id="messageReplyChargingDataTables" class="display table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th style="width:150px;">Service</th>
                <th style="width:160px;">Operator</th>
                <th style="width:200px;">Name</th>
                <th>Reply</th>
                <th style="width:110px;text-align:center;">Charging</th>
                <th style="width:100px;text-align:center;">Status</th>
                <th style="width:100px;text-align:center;">Action</th>
            </tr>
        </thead>

        <tbody></tbody>
    </table>
</div>

<!-- Modal -->
<form id="messageReplyChargingForm" role="form">
    <div class="modal fade" id="messageReplyChargingModal" tabindex="-1" role="dialog" aria-labelledby="messageReplyChargingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add New Message Reply/Charging</h4>
                </div>

                <div class="modal-body">
                    <!-- message info -->
                    <div id="formMessageReplyChargingMessage" class="alert display-none">
                        <span></span>
                    </div>

                    <div class="pull-left">
                        <div id="form-group-service_adn" class="form-group">
                            <label for="service_adn">Service *</label>
                            <select id="service_adn" name="service_adn" class="form-control">
                                <?php if (is_array($combobox_service) && count($combobox_service) > 0): ?>
                                    <?php foreach ($combobox_service as $row): ?>
                                        <option value="<?php echo $row['id'] . '_' . $row['adn']; ?>"><?php echo $row['name'] . ' (' . $row['adn'] . ')'; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div id="form-group-operator" class="form-group">
                            <label for="operator">Operator *</label>
                            <select id="operator" name="operator" class="form-control">
                                <option value=""></option>
                                <?php if (is_array($combobox_operator) && count($combobox_operator) > 0): ?>
                                    <?php foreach ($combobox_operator as $row): ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . ' (' . $row['long_name'] . ')'; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div id="form-group-name" class="form-group">
                            <label for="name">Name *</label>
                            <input type="hidden" id="edit_id" name="edit_id" />
                            <input type="hidden" id="edit_service_adn" name="edit_service_adn" />
                            <input type="hidden" id="edit_name" name="edit_name" />
                            <input type="text" class="form-control width-200px" id="name" name="name" placeholder="Name" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                        </div>

                        <div id="form-group-reply" class="form-group">
                            <label for="reply">Reply *</label>
                            <textarea id="reply" name="reply" rows="3" class="form-control width-300px" placeholder="Reply"></textarea>
                        </div>

                        <div id="form-group-charging" class="form-group">
                            <label for="charging">Charging ID *</label>
                            <select id="charging" name="charging" class="form-control">
                                <!-- event on Operator-ADN change -->
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
