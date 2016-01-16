    		</div> <!-- ending wrapper -->
		</div>
            <script>
                var configObj = new function() {
                    this.baseUrl = "<?php echo base_url(); ?>";
                    this.backendUrl = "<?php echo site_url('/backend'); ?>";
                    this.countdown_limit = "<?php echo $this->config->item('countdown_time'); ?>";
                };
            </script>

            <script type="text/javascript" src="<?php echo base_url(); ?>js/<?php echo getCSSJSVer('jquery', 'js'); ?>.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>js/<?php echo getCSSJSVer('base', 'js'); ?>.js"></script>
            <?php
            if(!empty($js)) {
                foreach($js as $j) {
                    echo '<script type="text/javascript" src="'.base_url().'js/'.getCSSJSVer($j, 'js').'.js"></script>';
                }
            }
            ?>
            </body>
</html>

