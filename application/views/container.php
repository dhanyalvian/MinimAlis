<div class="container-fluid page-content">
    <?php if (is_array($navigation) && count($navigation) > 0): ?>
        <div class="navbar-side">
            <ul class="nav">
                <?php
                foreach ($navigation as $nav):
                    if ($nav['display'] == 0):
                        continue;
                    endif;
                    
                    if ($nav['controller'] == 'dashboard'):
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
                
                    <li class="subnav">
                        <a><?php echo $navTitle; ?></a>
                    </li>
                    
                    <?php if (is_array($navSub) && count($navSub) > 0): ?>
                        <?php foreach ($navSub as $_nav): ?>
                            <?php
                            $_navActive = ($_nav['controller'] == $page_controller) ? 'active' : '';
                            $_navTitle = $_nav['title'];
                            $_navUrl = $_nav['url'] == '#' ? $_nav['url'] : $base_url . $_nav['url'] . $url_suffix;
                            $_navIcon = is_null($_nav['icon']) || empty ($_nav['icon']) ? '' : $_nav['icon'];
                            ?>
                            <li class="<?php echo $_navActive; ?>">
                                <a href="<?php echo $_navUrl; ?>">
                                    <?php if ($_navIcon): ?>
                                        <span class="fa <?php echo $_navIcon; ?> glyphicon-left"></span>
                                    <?php endif; ?>
                                    <?php echo $_navTitle; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php /*if (is_array($sub_navigation) && count($sub_navigation) > 0): ?>
        <div class="navbar-side">
            <ul class="nav">
                <li class="subnav">
                    <a><?php echo $parent_title; ?></a>
                </li>
                
                <?php
                foreach ($sub_navigation as $sub_nav):
                    $subNavActive = ($sub_nav['controller'] == $page_controller) ? 'active' : '';
                    $subNavTitle = $sub_nav['title'];
                    $subNavUrl = $base_url . $sub_nav['url'];
                    ?>
                    <li class="<?php echo $subNavActive; ?>">
                        <a href="<?php echo $subNavUrl; ?>">
                            <span class="fa fa-bar-chart-o glyphicon-left"></span>
                            <?php echo $subNavTitle; ?>
                        </a>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>
    <?php endif;*/ ?>
    
    <div class="container-fluid content">
        <?php $this->load->view($page_views . '_view'); ?>
        
        <div class="footer">&copy; 2014 - <a href="mailto:dhanyalvian@gmail.com">Dhany Noor Alfian</a></div>
    </div>
</div>
