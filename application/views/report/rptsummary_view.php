<div>
    <div class="report-filter">
        <form id="reportSummaryFilterForm">
            <div class="float-left">
                <label>Month</label>
                <select id="month" name="month" class="form-control">
                    <?php foreach ($combobox_month as $key => $value): ?>
                        <?php $selected = $current_month_year['month'] == $key ? 'selected="selected"' : ''; ?>
                        <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="float-left margin-left-10px">
                <label>Year</label>
                <select id="year" name="year" class="form-control">
                    <?php foreach ($combobox_year as $year): ?>
                        <?php $selected = $current_month_year['year'] == $year ? 'selected="selected"' : ''; ?>
                        <option value="<?php echo $year; ?>" <?php echo $selected; ?>><?php echo $year; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="float-left margin-left-10px">
                <label>Shortcode</label>
                <select id="adn" name="adn" class="form-control">
                    <option value="">All</option>
                    <?php foreach ($combobox_adn as $adn): ?>
                        <option value="<?php echo $adn['name']; ?>"><?php echo $adn['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="float-left margin-left-10px">
                <label>Operator</label>
                <select id="operator" name="operator" class="form-control">
                    <option value="">All</option>
                    <?php foreach ($combobox_operator as $operator): ?>
                        <option value="<?php echo $operator['id']; ?>"><?php echo $operator['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="float-left margin-left-10px">
                <label>Service</label>
                <select id="service" name="service" class="form-control">
                    <option value="">All</option>
                    <?php foreach ($combobox_service as $service): ?>
                        <option value="<?php echo $service['name']; ?>"><?php echo $service['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="float-left margin-left-10px" style="padding-top:23px;">
                <div class="btn-group">
                    <button class="btn btn-default btn-sm" type="submit">
                        <span class="icon-fixed-width glyphicon glyphicon-search icon-button-left"></span>
                        Filter
                    </button>

                    <button class="btn btn-default btn-sm" type="reset">
                        <span class="icon-fixed-width glyphicon glyphicon-repeat icon-button-left"></span>
                        Reset
                    </button>
                </div>
            </div>

            <div class="clearfix"></div>
        </form>
    </div>
    
    <div class="table-responsive dataTables_wrapper overflow-auto" role="grid">
        <table id="rptsummaryReportTables" class="display table table-bordered report-table">
            <thead></thead>
            <tbody></tbody>
        </table>
    </div>
</div>
