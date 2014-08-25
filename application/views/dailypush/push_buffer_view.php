<div>
    <div class="header-title">
        <h2>
            <?php echo $page_title; ?>
        </h2>
    </div>
    
    <div class="table-responsive dataTables_wrapper" role="grid">
        <table id="pushBufferDataTables" class="display table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <!--pid,src,dest,operator_id,service,subject,message,price,stat,created,tid,type-->
                    <th>PID</th>
                    <th>Src</th>
                    <th>Dest</th>
                    <th>Operator</th>
                    <th>Service</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th style="text-align:center;">Price</th>
                    <th>Stat</th>
                    <th>Date Created</th>
                    <th>TID</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <form id="pushBufferForm" role="form">
        <div class="modal fade" id="pushBufferModal" tabindex="-1" role="dialog" aria-labelledby="pushBufferModalLabel" aria-hidden="true">
            <div class="modal-dialog width-1000px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Push Buffer</h4>
                    </div>

                    <div class="modal-body">
                        <!-- message info -->
                        <div id="formPushBufferMessage" class="alert display-none">
                            <span></span>
                        </div>

                        <div class="pull-left width-50">
                            <div id="form-group-pid" class="form-group">
                                <label for="pid">PID *</label>
                                <input type="hidden" id="edit_id" name="edit_id" />
                                <input type="text" class="form-control width-150px" id="pid" name="pid" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-src" class="form-group">
                                <label for="src">Source *</label>
                                <input type="text" class="form-control width-200px" id="src" name="src" placeholder="Source" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-dest" class="form-group">
                                <label for="dest">Destination *</label>
                                <input type="text" class="form-control width-200px" id="dest" name="dest" placeholder="Destination" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-operator" class="form-group">
                                <label for="operator">operator *</label>
                                <select id="operator" name="operator" class="form-control">
                                    <?php if (is_array($combobox_operator) && count($combobox_operator) > 0): ?>
                                        <?php foreach ($combobox_operator as $operator): ?>
                                            <option value="<?php echo $operator['id']; ?>"><?php echo $operator['name'] . ' (' . $operator['long_name'] . ')'; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div id="form-group-service" class="form-group">
                                <label for="service">Service *</label>
                                <select id="service" name="service" class="form-control">
                                    <?php if (is_array($combobox_service) && count($combobox_service) > 0): ?>
                                        <?php foreach ($combobox_service as $service): ?>
                                            <option value="<?php echo $service['name']; ?>"><?php echo $service['name'] . ' (' . $service['adn'] . ')'; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div id="form-group-subject" class="form-group">
                                <label for="subject">Subject *</label>
                                <input type="text" class="form-control width-200px" id="subject" name="subject" placeholder="Subject" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                        </div>
                        
                        <div class="pull-left width-50">
                            <div id="form-group-message" class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" name="message" rows="2" class="form-control width-300px" placeholder="Message"></textarea>
                            </div>
                            
                            <div id="form-group-datecreated" class="form-group">
                                <div><label for="datecreated">Date Created *</label></div>
                                <div id="datecreated_group" class='pull-left input-group date datetimepicker width-200px'>
                                    <input type='text' class="form-control" data-format="DD-MMM-YYYY hh:mm A" id="datecreated" name="datecreated" value="<?php echo $today; ?>" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div id="form-group-price" class="form-group">
                                <label for="price">Price *</label>
                                <input type="text" class="form-control width-100px align-right" id="price" name="price" placeholder="" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-stat" class="form-group">
                                <label for="stat">Stat *</label>
                                <input type="text" class="form-control width-200px" id="stat" name="stat" placeholder="Stat" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-tid" class="form-group">
                                <label for="tid">TID *</label>
                                <input type="text" class="form-control width-150px" id="tid" name="tid" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-type" class="form-group">
                                <label for="type">Type *</label>
                                <input type="text" class="form-control width-200px" id="type" name="type" placeholder="Type" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
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
