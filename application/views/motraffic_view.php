<div>
    <div class="header-title">
        <h2><?php echo $page_title; ?></h2>
    </div>

    <div class="row report-panel">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Today MO
                        <a id="today_mo_refresh" class="panel-refresh" title="Refresh">
                            <span class="icon glyphicon glyphicon-refresh pull-right"></span>
                        </a>
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="panel-total">
                        <span id="today_mo">0</span>
                    </div>
                    
                    <ul class="list-group" style="margin-bottom:0;">
                        <li class="list-group-item">
                            Yesterday
                            <span id="yesterday_mo" class="badge">0</span>
                        </li>
                        
                        <li class="list-group-item">
                            Last 7 days
                            <span id="lastsevenday_mo" class="badge">0</span>
                        </li>
                    </ul>
                    
                    <!--div class="panel-detail-information">
                        <div>
                            <div class="panel-detail font-bold">Period</div>
                            <div class="panel-detail-right font-bold">Total MO</div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div>
                            <div class="panel-detail">Yesterday</div>
                            <div class="panel-detail-right">
                                <span id="yesterday_mo">0</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div>
                            <div class="panel-detail panel-detail-last">Last 7 days</div>
                            <div class="panel-detail-right panel-detail-last">
                                <span id="lastsevenday_mo">0</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div-->
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" style="position:relative;">
                    <h3 class="panel-title">
                        MO Trends
                    </h3>
                    
                    <div id="motrends_months_area">
                        <select id="motrends_months" name="motrends_months" class="form-control panel-select" style="">
                            <option value="3">Last 3 months</option>
                            <option value="6">Last 6 months</option>
                            <option value="12">Last 12 months</option>
                        </select>
                    </div>
                </div>

                <div class="panel-body">
                    <div id="mo_trends_chart"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Total MO
                        <a id="total_mo_refresh" class="panel-refresh" title="Refresh">
                            <span class="icon glyphicon glyphicon-refresh pull-right"></span>
                        </a>
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="panel-total">
                        <span id="total_mo">0</span>
                    </div>
                    
                    <ul class="list-group" style="margin-bottom:0;">
                        <li class="list-group-item">
                            Last months
                            <span id="lastmonth_mo" class="badge">0</span>
                        </li>
                        
                        <li class="list-group-item">
                            Last 6 months
                            <span id="lastsixmonth_mo" class="badge">0</span>
                        </li>
                    </ul>
                    
                    <!--div class="panel-detail-information">
                        <div>
                            <div class="panel-detail font-bold">Period</div>
                            <div class="panel-detail-right font-bold">Total MO</div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div>
                            <div class="panel-detail">Last months</div>
                            <div class="panel-detail-right">
                                <span id="lastmonth_mo">0</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div>
                            <div class="panel-detail panel-detail-last">Last 6 months</div>
                            <div class="panel-detail-right panel-detail-last">
                                <span id="lastsixmonth_mo">0</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div-->
                </div>
            </div>
        </div>
    </div>

    <div class="row report-filter">
        <div class="col-md-12">
            <form id="motrafficForm">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Filter
                            <a id="filter-toggle" class="panel-refresh">
                                <span class="icon glyphicon glyphicon-chevron-down pull-right"></span>
                            </a>
                        </h3>
                    </div>

                    <div id="filter-area" class="panel-body display-none">
                        <div class="pull-left width-50">
                            <div id="form-group-start_date" class="form-group">
                                <div><label for="start_date">Date Range</label></div>

                                <div id="start_date_group" class='pull-left input-group date datetimepicker width-150px'>
                                    <input type='text' class="form-control" data-format="DD-MMM-YYYY" id="start_date" name="start_date" value="<?php echo $today; ?>" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                </div>

                                <div class="pull-left" style="padding:7px 10px 0px 10px;"><label>to</label></div>

                                <div id="end_date_group" class='pull-left input-group date datetimepicker width-150px'>
                                    <input type='text' class="form-control" data-format="DD-MMM-YYYY" id="end_date" name="end_date" value="<?php echo $today; ?>" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                </div>

                                <div class="clearfix"></div>
                            </div>

                            <div id="form-group-adn" class="form-group">
                                <label for="adn">ADN</label>
                                <select id="adn" name="adn" class="form-control">
                                    <option value="">All</option>
                                    <?php if (is_array($combobox_adn) && count($combobox_adn) > 0): ?>
                                        <?php foreach ($combobox_adn as $row): ?>
                                            <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div id="form-group-operator" class="form-group">
                                <label for="operator">Operator</label>
                                <select id="operator" name="operator" class="form-control">
                                    <option value="">All</option>
                                    <?php if (is_array($combobox_operator) && count($combobox_operator) > 0): ?>
                                        <?php foreach ($combobox_operator as $row): ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . ' (' . $row['long_name'] . ')'; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div id="form-group-service" class="form-group">
                                <label for="service">Service</label>
                                <select id="service" name="service" class="form-control">
                                    <option value="">All</option>
                                    <?php if (is_array($combobox_service) && count($combobox_service) > 0): ?>
                                        <?php foreach ($combobox_service as $row): ?>
                                            <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="pull-left width-50">
                            <div id="form-group-motype" class="form-group">
                                <label for="motype">Type</label>
                                <select id="motype" name="motype" class="form-control">
                                    <option value="">All</option>
                                    <?php if (is_array($combobox_motype) && count($combobox_motype) > 0): ?>
                                        <?php foreach ($combobox_motype as $value): ?>
                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div id="form-group-msisdn" class="form-group">
                                <label for="msisdn">MSISDN</label>
                                <input type="text" class="form-control width-200px" id="msisdn" name="msisdn" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>

                            <div id="form-group-sms" class="form-group">
                                <label for="sms">SMS</label>
                                <input type="text" class="form-control width-200px" id="sms" name="sms" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                            </div>

                            <div class="padding-top-20px">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-default btn-sm">
                                        <span class="icon-fixed-width glyphicon glyphicon-search icon-button-left"></span>
                                        Search
                                    </button>
                                    <button type="reset" id="reset-form" class="btn btn-default btn-sm margin-left-5px">
                                        <span class="icon-fixed-width glyphicon glyphicon-repeat icon-button-left"></span>
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive dataTables_wrapper" role="grid">
        <table id="motrafficDataTables" class="display table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>MSISDN</th>
                    <th>Operator</th>
                    <th>ADN</th>
                    <th>Service</th>
                    <th>SMS</th>
                    <th>Req. Type</th>
                    <th>Channel</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>
</div>
