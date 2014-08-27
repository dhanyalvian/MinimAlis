<div class="header">
    <div class="pull-left">
        <div class="header-title">
            <!--span class="fa fa-dashboard"></span-->
            <?php echo $page_title; ?>
        </div>


    </div>

    <div class="pull-right global-button">
        <!--div class="btn-group">
            <button type="button" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-compressed"></span>
                Button
                <span class="glyphicon glyphicon-log-out"></span>
            </button>
            <button type="button" class="btn btn-default btn-sm">Edit</button>
        </div-->
        <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm">
                Submit
            </button>

            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                Action
                <span class="caret"></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
            </ul>
        </div>
        
        <div class="btn-group btn-theme">
            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                Action <span class="caret"></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
            </ul>
        </div>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="#">MinimalisAbis</a></li>
    <li class="active">Dashboard</li>
</ol>

<?php if (is_array($dashboard_overview) && count($dashboard_overview)): ?>
    <div class="row-panel dashboard-overview">
        <?php $x = 1; ?>
        <?php foreach ($dashboard_overview as $key => $row): ?>
            <?php
            if ($x == 1):
                $panelPosition = 'panel-left';
            elseif ($x == count($dashboard_overview)):
                $panelPosition = 'panel-right';
            else:
                $panelPosition = 'panel-center';
            endif;
            ?>
            <div class="<?php echo $panelPosition; ?> col-lg-3 container-fluid">
                <div class="panel">
                    <div class="pull-left do-icon">
                        <span class="fa <?php echo $row['icon']; ?>"></span>
                    </div>

                    <div class="pull-left do-value">
                        <div class="total"><?php echo number_format(rand(10, 10000)); ?></div>
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
                        <a class="toggle"><span class="fa fa-angle-down"></span></a>
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
                        <a class="toggle"><span class="fa fa-angle-down"></span></a>
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
                        <a class="toggle"><span class="fa fa-angle-down glyphicon-right"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div class="panel-body">
                Panel content
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
                        <a class="toggle"><span class="fa fa-angle-down glyphicon-right"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div class="panel-body">
                Panel content
            </div>
        </div>
    </div>

    <div class="col-sm-4 panel-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">
                        <span class="fa fa-bar-chart-o glyphicon-left"></span>
                        Audience Overview
                    </div>
                    <div class="pull-right">
                        <a class="toggle"><span class="fa fa-angle-down glyphicon-right"></span></a>
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
                        <a class="toggle"><span class="fa fa-angle-down glyphicon-right"></span></a>
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
                        <a class="toggle"><span class="fa fa-angle-down glyphicon-right"></span></a>
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
                        <a class="toggle"><span class="fa fa-angle-down glyphicon-right"></span></a>
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
                        <a class="toggle"><span class="fa fa-angle-down glyphicon-right"></span></a>
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
                        <a class="toggle"><span class="fa fa-angle-down glyphicon-right"></span></a>
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