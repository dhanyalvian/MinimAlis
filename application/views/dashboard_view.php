<?php if (is_array($dashboard_overview) && count($dashboard_overview)): ?>
    <div class="row-panel dashboard-overview">
        <?php
        $x = 1;
        $colLg = 12 / count($dashboard_overview);
        ?>
        <?php foreach ($dashboard_overview as $key => $row): ?>
            <?php
            if ($x == 1):
                $panelPosition = 'panel-left';
            elseif ($x == count($dashboard_overview)):
                $panelPosition = 'panel-right';
            else:
                $panelPosition = 'panel-center';
            endif;
            
            $currency = $row['currency'] ? $row['currency'] : '';
            $total = number_format($row['total']);
            ?>
            <div class="<?php echo $panelPosition; ?> col-lg-<?php echo $colLg; ?> container-fluid">
                <div class="panel">
                    <div class="do-icon">
                        <span class="fa <?php echo $row['icon']; ?> fa-fw"></span>
                    </div>

                    <div class="do-value container-fluid">
                        <div class="total"><?php echo $currency . $total; ?></div>
                        <div class="title"><?php echo $row['title']; ?></div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
            <?php $x++; ?>
        <?php endforeach; ?>
        
        <div class="clearfix"></div>
    </div>
<?php endif; ?>

<div class="row-panel">
    <div class="col-sm-6 panel-left panel-theme">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-shopping-cart icon-left"></span>
                        Orders
                    </div>
                    
                    <div class="pull-right">
                        <a class=""><span class="fa fa-refresh"></span></a>
                        <a class="toggle"><span class="fa fa-angle-down"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="panel-body">
                <div id="chart1" class="chart"></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 panel-right panel-theme">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-dollar icon-left"></span>
                        Amount
                    </div>
                    
                    <div class="pull-right">
                        <a class=""><span class="fa fa-refresh"></span></a>
                        <a class="toggle"><span class="fa fa-angle-down"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="panel-body">
                <div id="chart2" class="chart"></div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</div>

<div class="row-panel">
    <div class="col-sm-4 panel-left panel-theme">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-tags icon-left"></span>
                        Best Sellers
                    </div>
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-down icon-right"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            
            <?php if (is_array($best_sellers) && count($best_sellers) > 0): ?>
                <div class="list-group">
                    <?php foreach ($best_sellers as $key => $value): ?>
                        <a class="list-group-item">
                            <?php echo $value; ?>
                            <span class="badge"><?php echo number_format($key); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-sm-4 panel-center">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-bar-chart-o icon-left"></span>
                        Audience Overview
                    </div>
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-down icon-right"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div class="panel-body" style="height: 285px;">
                Panel content
            </div>
        </div>
    </div>

    <div class="col-sm-4 panel-right panel-theme">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left">
                            <span class="fa fa-clock-o icon-left"></span>
                            Collapsible Group Item #1
                        </div>
                        
                        <div class="pull-right">
                            <a class="toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="fa fa-angle-down icon-right"></span></a>
                        </div>
                        
                        <div class="clearfix"></div>
                    </h3>
                </div>
    
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
  
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left">
                            <span class="fa fa-calendar icon-left"></span>
                            Collapsible Group Item #2
                        </div>
                        
                        <div class="pull-right">
                            <a class="toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="fa fa-angle-down icon-right"></span></a>
                        </div>
                        
                        <div class="clearfix"></div>
                    </h3>
                </div>
                
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left">
                            <span class="fa fa-cloud-download icon-left"></span>
                            Collapsible Group Item #3
                        </div>
                        
                        <div class="pull-right">
                            <a class="toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="fa fa-angle-down icon-right"></span></a>
                        </div>
                        
                        <div class="clearfix"></div>
                    </h3>
                </div>
            
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</div>

<div class="row-panel">
    <div class="col-sm-3 panel-left panel-theme">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-bar-chart-o icon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-down icon-right"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div class="panel-body">
                <div>
                    <div class="pull-left">
                        <select class="form-control">
                            <option value="">Visits</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-3 panel-center">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-bar-chart-o icon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-down icon-right"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div class="panel-body">
                <div>
                    <div class="pull-left">
                        <select class="form-control">
                            <option value="">Visits</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-3 panel-center">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-bar-chart-o icon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-down icon-right"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div class="panel-body">
                <div>
                    <div class="pull-left">
                        <select class="form-control">
                            <option value="">Visits</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-3 panel-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-bar-chart-o icon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-down icon-right"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div class="panel-body">
                <div>
                    <div class="pull-left">
                        <select class="form-control">
                            <option value="">Visits</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</div>

<div class="row-panel">
    <div class="col-sm-12 panel-full">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-bar-chart-o icon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-down icon-right"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div class="panel-body">
                Panel content
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</div>