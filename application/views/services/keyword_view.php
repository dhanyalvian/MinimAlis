<script type="text/javascript">
    var serviceId = <?php echo $service_id; ?>;
    var adn = <?php echo $adn; ?>;
</script>
<div>
    <div class="header-title">
        <h2>
            <?php echo $page_title; ?> for
            <?php echo $service_adn; ?>
            
            <div class="pull-right">
                <div class="btn-group">
                    <a href="<?php echo $base_url; ?>services/keyword/addedit/<?php echo $service_id; ?>" class="btn btn-default btn-sm">
                        <span class="icon-fixed-width glyphicon glyphicon-plus icon-button-left"></span>
                        Add New Keyword
                    </a>
                    
                    <a href="<?php echo $base_url; ?>services/service" class="btn btn-default btn-sm">
                        <span class="icon-fixed-width glyphicon glyphicon-arrow-left icon-button-left"></span>
                        Back to Service
                    </a>
                </div>
            </div>
        </h2>
        
        
    </div>
    
    <div class="table-responsive dataTables_wrapper" role="grid">
        <div id="tableKeywordMessage" class="bs-callout display-none">
            <span></span>
            <button class="close" type="button" onclick="javascript: $(this).parent().hide();">×</button>
        </div>
        
        <table id="keywordDataTables" class="display table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="header headerSortDown">Keyword / Operator</th>
                    <th style="width:170px;text-align:center;">Action</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>
    
    <!-- Modal -->
    <form id="keywordForm" role="form">
        <div class="modal fade" id="keywordModal" tabindex="-1" role="dialog" aria-labelledby="keywordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Keyword</h4>
                    </div>

                    <div class="modal-body">
                        <!-- message info -->
                        <div id="formKeywordMessage" class="alert display-none">
                            <span></span>
                        </div>

                        <div class="pull-left">
                            <div id="form-group-service" class="form-group">
                                <label for="service">Service *</label>
                                
                                <input type="hidden" id="edit_id" name="edit_id" />
                                <input type="hidden" id="adn" name="adn" value="<?php echo $adn; ?>" />
                                <input type="hidden" id="edit_pattern" name="edit_pattern" />
                                <input type="hidden" id="edit_operator" name="edit_operator" />
                                
                                <select id="service" name="service" class="form-control">
                                    <option value="<?php echo $service_id; ?>"><?php echo $service_adn; ?></option>
                                </select>
                            </div>

                            <div id="form-group-pattern" class="form-group">
                                <label for="pattern">Pattern *</label>
                                <input type="text" class="form-control width-200px lowercase" id="pattern" name="pattern" placeholder="Pattern" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-operator" class="form-group">
                                <label for="operator">Operator *</label>
                                <select id="operator" name="operator" class="form-control">
                                    <option value=""></option>
                                    <?php foreach ($operator as $row): ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . ' (' . $row['long_name'] . ')'; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="form-group-handler" class="form-group">
                                <label for="handler">Handler *</label>
                                <select id="handler" name="handler" class="form-control">
                                    <?php foreach ($handler as $row): ?>
                                        <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="form-group-reply_charging" class="form-group">
                                <label id="reply_charging" class="form-control-label">Reply/Charging *</label>
                                <input type="hidden" name="reply_charging" class="reply_charging" value="" />
                                <div id="div_reply_charging"></div>
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
