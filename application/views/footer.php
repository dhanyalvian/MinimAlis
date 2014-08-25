        <!-- Bootstrap core and other JavaScript -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php
        if (is_array($js_data['default_bottom']) && count($js_data['default_bottom']) > 0):
            foreach ($js_data['default_bottom'] as $js_bottom):
                ?>
                <script src="<?php echo $js_data['path_core'] . $js_bottom; ?>.js" type="text/javascript" charset="utf-8"></script>
                <?php
            endforeach;
        endif;
        
        if (is_array($js_data['additional']) && count($js_data['additional']) > 0):
            foreach ($js_data['additional'] as $js_additional):
                ?>
                <script src="<?php echo $js_data['path_module'] . $js_additional; ?>.js" type="text/javascript" charset="utf-8"></script>
                <?php
            endforeach;
        endif;
        ?>
    </body>
</html>