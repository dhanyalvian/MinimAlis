<div class="container-fluid page-content">
    <?php if (is_array($sub_navigation) && count($sub_navigation) > 0): ?>
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
    <?php endif; ?>
    
    <div class="container-fluid content">
        <?php $this->load->view($page_views . '_view'); ?>
        
        <div class="footer">&copy; 2014 - <a href="mailto:dhanyalvian@gmail.com">Dhany Noor Alfian</a></div>
    </div>
</div>
