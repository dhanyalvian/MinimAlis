<div class="table-responsive dataTables_wrapper" role="grid">
    <table id="chargingDataTables" class="display table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 140px;">Operator</th>
                <th style="width: 100px;">ADN</th>
                <th>Charging ID</th>
                <th style="width:100px;text-align:center;">Gross</th>
                <th style="width:100px;text-align:center;">Netto</th>
                <th style="width: 120px;">Sender Type</th>
                <th style="width: 120px;">Message Type</th>
                <th style="width: 100px; text-align: center;">Action</th>
            </tr>
        </thead>

        <tbody></tbody>
    </table>
</div>

<!-- Modal -->
<form id="chargingForm" role="form">
    <div class="modal fade" id="chargingModal" tabindex="-1" role="dialog" aria-labelledby="chargingModalLabel" aria-hidden="true">
        <div class="modal-dialog width-1000px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add New Charging</h4>
                </div>

                <div class="modal-body">
                    <!-- message info -->
                    <div id="formChargingMessage" class="alert display-none">
                        <span></span>
                    </div>

                    <div class="pull-left width-50">
                        <div id="form-group-operator" class="form-group">
                            <label for="operator">Operator</label>
                            <select id="operator" name="operator" class="form-control">
                                <?php
                                if (is_array($combobox_operator) && count($combobox_operator) > 0):
                                    foreach ($combobox_operator as $row):
                                        ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name . ' - ' . $row->long_name; ?></option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>

                        <div id="form-group-adn" class="form-group">
                            <label for="adn">ADN</label>
                            <select id="adn" name="adn" class="form-control">
                                <?php
                                if (is_array($combobox_adn) && count($combobox_adn) > 0):
                                    foreach ($combobox_adn as $row):
                                        ?>
                                        <option value="<?php echo $row->name; ?>"><?php echo $row->name; ?></option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>

                        <div id="form-group-charging" class="form-group">
                            <label for="charging">Charging ID *</label>
                            <input type="hidden" id="edit_id" name="edit_id" />
                            <input type="hidden" id="edit_charging" name="edit_charging" />
                            <input type="text" class="form-control width-200px" id="charging" name="charging" placeholder="Charging ID" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                        </div>

                        <div id="form-group-gross" class="form-group">
                            <label for="gross">Gross *</label>
                            <input type="text" class="form-control width-80px align-right" id="gross" name="gross" placeholder="" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                        </div>

                        <div id="form-group-netto" class="form-group">
                            <label for="netto">Netto *</label>
                            <input type="text" class="form-control width-80px align-right" id="netto" name="netto" placeholder="" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                        </div>
                    </div>

                    <div class="pull-left width-50">
                        <div id="form-group-username" class="form-group">
                            <label for="username">Username *</label>
                            <input type="text" class="form-control width-200px" id="username" name="username" placeholder="Username" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                        </div>

                        <div id="form-group-password" class="form-group">
                            <label for="password">Password *</label>
                            <input type="text" class="form-control width-200px" id="password" name="password" placeholder="Password" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                        </div>

                        <div id="form-group-sender_type" class="form-group">
                            <label for="sender_type">Sender Type *</label>
                            <select id="sender_type" name="sender_type" class="form-control">
                                <?php if (is_array($combobox_sender_type) && count($combobox_sender_type) > 0): ?>
                                    <?php foreach ($combobox_sender_type as $value): ?>
                                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div id="form-group-message_type" class="form-group">
                            <label for="message_type">Message Type *</label>
                            <select id="message_type" name="message_type" class="form-control">
                                <?php if (is_array($combobox_message_type) && count($combobox_message_type) > 0): ?>
                                    <?php foreach ($combobox_message_type as $value): ?>
                                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
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
