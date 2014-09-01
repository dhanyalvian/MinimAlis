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
                        <span class="fa <?php echo $row['icon']; ?>"></span>
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
                        <span class="fa fa-bar-chart-o glyphicon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class=""><span class="fa fa-refresh"></span></a>
                        <a class="toggle"><span class="fa fa-angle-up"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="panel-body">
                <div>
                    <div class="pull-left">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                Today
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                <li><a href="#">Last 7 days</a></li>
                                <li><a href="#">Last Month</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 panel-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-hdd-o glyphicon-left"></span>
                        HDD Usage
                    </div>
                    
                    <div class="pull-right">
                        <a class=""><span class="fa fa-refresh"></span></a>
                        <a class="toggle"><span class="fa fa-angle-up"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
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
    <div class="col-sm-4 panel-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-bar-chart-o glyphicon-left"></span>
                        Audience Overview
                    </div>
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-up glyphicon-right"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div class="panel-body" style="height: 285px;">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
            </div>
        </div>
    </div>

    <div class="col-sm-4 panel-center">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-bar-chart-o glyphicon-left"></span>
                        Audience Overview
                    </div>
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-up glyphicon-right"></span></a>
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
                            <span class="fa fa-clock-o glyphicon-left"></span>
                            Collapsible Group Item #1
                        </div>
                        
                        <div class="pull-right">
                            <a class="toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="fa fa-angle-up glyphicon-right"></span></a>
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
                            <span class="fa fa-calendar glyphicon-left"></span>
                            Collapsible Group Item #2
                        </div>
                        
                        <div class="pull-right">
                            <a class="toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="fa fa-angle-up glyphicon-right"></span></a>
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
                            <span class="fa fa-cloud-download glyphicon-left"></span>
                            Collapsible Group Item #3
                        </div>
                        
                        <div class="pull-right">
                            <a class="toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="fa fa-angle-up glyphicon-right"></span></a>
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
                        <span class="fa fa-bar-chart-o glyphicon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-up glyphicon-right"></span></a>
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
                        <span class="fa fa-bar-chart-o glyphicon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-up glyphicon-right"></span></a>
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
                        <span class="fa fa-bar-chart-o glyphicon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-up glyphicon-right"></span></a>
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
                        <span class="fa fa-bar-chart-o glyphicon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-up glyphicon-right"></span></a>
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
                        <span class="fa fa-bar-chart-o glyphicon-left"></span>
                        Audience Overview
                    </div>
                    
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-up glyphicon-right"></span></a>
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