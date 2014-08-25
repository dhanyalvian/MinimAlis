<script type="text/javascript">
    var serviceId = <?php echo $service_id; ?>;
    var adn = <?php echo $adn; ?>;
    var chargings = <?php echo $chargings; ?>;
    var modules = <?php echo $modules; ?>;
</script>

<div>
    <div class="header-title">
        <h2>
            Add New <?php echo $page_title; ?>
            for <?php echo $service_adn; ?>
        </h2>
    </div>
    
    <form id="keywordForm1" role="form">
        <!-- Nav tabs -->
        <!--ul class="nav nav-tabs">
            <li class="active">
                <a href="#step1" data-toggle="tab">Step 1</a>
            </li>
            
            <li class="disabled">
                <a href="#step2" class="disabled" data-toggle="tab">Step 2</a>
            </li>
        </ul-->

        <!-- Tab panes -->
        <!--div class="tab-content padding-top-20px"-->
        <div>
            <div class="tab-pane active" id="step1">
                <div class="pull-left width-50">
                    <div id="form-group-service" class="form-group">
                        <label for="service">Service</label>
                        <select id="service" name="service" class="form-control">
                            <option value="<?php echo $service_id; ?>"><?php echo $service_name; ?></option>
                        </select>
                    </div>
                    
                    <div id="form-group-adn" class="form-group">
                        <label for="adn">ADN</label>
                        <select id="adn" name="adn" class="form-control">
                            <option value="<?php echo $adn; ?>"><?php echo $adn; ?></option>
                        </select>
                    </div>
                    
                    <div id="form-group-keyword" class="form-group">
                        <label for="keyword">Keyword *</label>
                        <input type="text" class="form-control width-250px lowercase" id="keyword" name="keyword" placeholder="Keyword" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                    </div>
                </div>
                
                <div class="pull-left width-50">
                    <div id="form-group-operator" class="form-group">
                        <label id="operator" class="form-control-label" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual">Operator *</label><br />
                        <?php if (is_array($operators) && count($operators) > 0): ?>
                            <?php foreach ($operators as $operator): ?>
                                <label>
                                    <input type="checkbox" id="operator-<?php echo $operator['id']; ?>" name="operator[]" value="<?php echo $operator['id']; ?>" data="<?php echo $operator['name']; ?>" />
                                    <span class="font-normal margin-left-5px"><?php echo sprintf("<span>%s</span> (%s)", $operator['name'], $operator['long_name']); ?></span>
                                </label>
                                <br />
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="clearfix"></div>
                
                <div id="keywordForm-action" style="border-top:1px solid #dddddd;" class="padding-top-20px">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-default btn-sm" data-dismiss="modal">
                            <span class="icon-fixed-width glyphicon glyphicon-arrow-right icon-button-left"></span>
                            Next
                        </button>
                        <a href="<?php echo $base_url; ?>services/keyword/index/<?php echo $service_id; ?>" class="btn btn-default btn-sm">
                            <span class="icon-fixed-width glyphicon glyphicon-remove icon-button-left"></span>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
            
            <!--div class="tab-pane" id="step2">efgh</div-->
            
        </div>
    </form>
    
    <form id="keywordForm2" role="form" class="display-none margin-top-20px">
        <input type="hidden" id="service" name="service" />
        <input type="hidden" id="adn" name="adn" />
        <input type="hidden" id="keyword" name="keyword" />
        <input type="hidden" id="operator" name="operator" />
        
        <div id="tab-operators"></div>
        
        <div id="keywordForm2-action" style="border-top:1px solid #dddddd;" class="padding-top-20px">
            <div class="btn-group">
                <button type="submit" class="btn btn-default btn-sm">
                    <span class="icon-fixed-width glyphicon glyphicon-ok icon-button-left"></span>
                    Save
                </button>
                <button type="button" class="btn btn-default btn-sm" onclick="javascript: cancelStep2();">
                    <span class="icon-fixed-width glyphicon glyphicon-remove icon-button-left"></span>
                    Cancel
                </button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    //var serviceId = <?php //echo $service_id; ?>;
    //var adn = <?php //echo $adn; ?>;
    $('.nav-tabs li a[data-toggle=tab]').on('click', function(e) {
        if ($(this).hasClass('disabled')) {
            e.preventDefault();
            return false;
        }
    });
</script>