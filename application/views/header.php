<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        
        <!-- enable / disable Responsive -->
        <!--meta name="viewport" content="width=device-width, initial-scale=1.0"-->
    
        <link rel="icon" type="image/png" href="<?php echo $base_url; ?>assets/ico/html5.png" />

        <title><?php echo $apps_title . ' - ' . $page_title; ?></title>
        
        <!-- Load css default -->
        <?php
        if (is_array($css_data['default']) && count($css_data['default']) > 0):
            foreach ($css_data['default'] as $css):
                ?>
                <link href="<?php echo $css_data['path'] . $css; ?>.css" rel="stylesheet" type="text/css" />
                <?php
            endforeach;
        endif;
        ?>
                
        <!-- Load css additional -->
        <?php
        if (is_array($css_data['additional']) && count($css_data['additional']) > 0):
            foreach ($css_data['additional'] as $css):
                ?>
                <link href="<?php echo $css_data['path'] . $css; ?>.css" rel="stylesheet" type="text/css" />
                <?php
            endforeach;
        endif;
        ?>
                
        <!-- Load js default top -->
        <?php
        if (is_array($js_data['default_top']) && count($js_data['default_top']) > 0):
            foreach ($js_data['default_top'] as $js_top):
                ?>
                <script src="<?php echo $js_data['path_core'] . $js_top; ?>.js" type="text/javascript" charset="utf-8"></script>
                <?php
            endforeach;
        endif;
        ?>
        
        <script type="text/javascript">
            var base_url = '<?php echo $base_url; ?>';
            var pageController = '<?php echo $page_controller; ?>';
        </script>
    </head>

    <body>
        <div class="navbar navbar-static-top" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                    <a href="<?php echo $home_url . ".html"; ?>" class="navbar-brand">
                        <span class="fa fa-html5"></span>
                        <?php echo $apps_title; ?>
                    </a>
                </div>
                
                <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="toggle">
                            <a id="toggle-navbar-side" data-toggle="tooltip" data-placement="bottom" title="Show/Hide&nbsp;Sidebar">
                                <span class="fa fa-th-large fa-fw"></span>
                            </a>
                        </li>
                        
                        <?php
                        if (is_array($navigation) && count($navigation) > 0):
                            foreach ($navigation as $nav):
                                if ($nav['display'] == 0):
                                    continue;
                                endif;

                                $navActive = ($nav['controller'] == $page_active) ? 'active' : '';
                                $navTitle = $nav['title'];
                                $navUrl = $nav['url'] == '#' ? $nav['url'] : $base_url . $nav['url'] . $url_suffix;
                                $navSub = $nav['sub_nav'];
                                $navToggle = (is_array($navSub) && count($navSub) > 0) ? 'dropdown-toggle' : '';
                                $navDropdown = (is_array($navSub) && count($navSub) > 0) ? 'dropdown' : '';
                                $navCaret = (is_array($navSub) && count($navSub) > 0) ? '<b class="caret"></b>' : '';
                                ?>
                                <li class="<?php echo $navDropdown . ' ' . $navActive; ?>">
                                    <a href="<?php echo $navUrl; ?>" class="<?php echo $navToggle; ?>" data-toggle="<?php echo $navDropdown; ?>">
                                        <?php echo $navTitle; ?>
                                        <?php echo $navCaret; ?>
                                    </a>
                                    
                                    <?php if (is_array($navSub) && count($navSub) > 0): ?>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($navSub as $_nav): ?>
                                                <?php
                                                $_navTitle = $_nav['title'];
                                                $_navUrl = $_nav['url'] == '#' ? $_nav['url'] : $base_url . $_nav['url'] . $url_suffix;
                                                ?>
                                                <li>
                                                    <a href="<?php echo $_navUrl; ?>"><?php echo $_navTitle; ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="fa fa-user fa-fw icon-left"></span>
                                <?php $user_fullname = 'Dzaky Nazran Alfian'; //hardcode ?>
                                <?php echo $user_fullname; ?>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Account</a></li>
                                <li><a href="#">Settings</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo $base_url; ?>login/out">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <?php /*
        <!-- Fixed navbar -->
        <div class="navbar <?php echo $header_skin; ?> navbar-static-top">
            <div class="">
                <div class="navbar-header">
                    <?php if ($page_header): ?>
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    <?php endif; ?>
                    <a class="navbar-brand" href="<?php echo $home_url; ?>"><?php echo $apps_title; ?></a>
                </div>
                
                <?php if ($page_header): ?>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <?php
                            if (is_array($navigation) && count($navigation) > 0):
                                foreach ($navigation as $nav):
                                    if ($nav['display'] == 0):
                                        continue;
                                    endif;
                                        
                                    $navActive = ($nav['controller'] == $page_active) ? 'active' : '';
                                    $navTitle = $nav['title'];
                                    $navUrl = $base_url . $nav['url'];
                                    $navSub = $nav['sub_nav'];
                                    $navToggle = (is_array($navSub) && count($navSub) > 0) ? 'dropdown-toggle' : '';
                                    $navDropdown = (is_array($navSub) && count($navSub) > 0) ? 'dropdown' : '';
                                    $navCaret = (is_array($navSub) && count($navSub) > 0) ? '<b class="caret"></b>' : '';
                                    ?>
                                    <li class="<?php echo $navDropdown . ' ' . $navActive; ?>">
                                        <a href="<?php echo $navUrl; ?>" class="<?php echo $navToggle; ?>" data-toggle="<?php echo $navDropdown; ?>">
                                            <?php echo $navTitle; ?>
                                            <?php echo $navCaret; ?>
                                        </a>
                                    </li>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                        
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="<?php echo $base_url; ?>profile/password">
                                    <?php echo $user_fullname; ?>
                                </a>
                            </li>
                            <!--li>
                                <a href="#" style="padding-left:5px;padding-right:5px;">
                                    <span class="icon-fixed-width glyphicon glyphicon-wrench"></span>
                                </a>
                            </li-->
                            <li>
                                <a href="<?php echo $base_url; ?>login/out" title="Logout">
                                    <!--span class="icon-fixed-width glyphicon glyphicon-log-out"></span-->
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                <?php endif; ?>
            </div>
        </div>
        */ ?>