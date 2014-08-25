<div>
    <div class="header-title">
        <h2>
            <?php echo $page_title; ?>
            
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" data-type="add" class="btn btn-default btn-sm serviceModal">
                        <span class="icon-fixed-width glyphicon glyphicon-plus icon-button-left"></span>
                        Add New Service
                    </button>
                </div>
            </div>
        </h2>
    </div>
    
    <div class="table-responsive dataTables_wrapper" role="grid">
        <div id="tableServiceMessage" class="bs-callout display-none">
            <span></span>
            <button class="close" type="button" onclick="javascript: $(this).parent().hide();">×</button>
        </div>
        
        <table id="serviceDataTables" class="display table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th style="width:300px;">Shortname</th>
                    <th style="width:200px;">ADN</th>
                    <th style="width:150px;text-align:center;">Date Created</th>
                    <th style="width:100px;text-align:center;">Action</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <form id="serviceForm" role="form">
        <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel" aria-hidden="true">
            <div class="modal-dialog width-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Service</h4>
                    </div>

                    <div class="modal-body">
                        <!-- message info -->
                        <div id="formServiceMessage" class="alert display-none">
                            <span></span>
                        </div>

                        <div class="pull-left">
                            <div id="form-group-service" class="form-group">
                                <label for="service">Service Name *</label>
                                <input type="hidden" id="edit_id" name="edit_id" />
                                <input type="hidden" id="edit_service" name="edit_service" />
                                <input type="text" class="form-control width-300px" id="service" name="service" placeholder="Service Name" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-shortname" class="form-group">
                                <label for="shortname">Shortname *</label>
                                <input type="hidden" id="edit_shortname" name="edit_shortname" />
                                <input type="text" class="form-control width-300px" id="shortname" name="shortname" placeholder="Shortname" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>
                            
                            <div id="form-group-adn" class="form-group">
                                <label for="adn">ADN *</label>
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
                            
                            <div id="form-group-goto" class="form-group">
                                <label>
                                    <input type="checkbox" id="goto" name="goto" value="1" />
                                    <span class="font-normal margin-left-5px">Go to Add Keyword when finish</span>
                                </label>
                            </div>
                            
                            <!--div id="form-group-goto" class="">
                                <input type="checkbox" id="goto" name="goto" value="1" />
                                <label for="goto" style="font-weight:normal;margin-left:4px;">Go to Keyword creation page when finish</label>
                            </div-->
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
