<!DOCTYPE html>
<html>
    <head>
        <!--

                       /$$     /$$                          
                      | $$    | $$                          
  /$$$$$$  /$$   /$$ /$$$$$$  | $$$$$$$   /$$$$$$   /$$$$$$ 
 |____  $$| $$  | $$|_  $$_/  | $$__  $$ /$$__  $$ /$$__  $$
  /$$$$$$$| $$  | $$  | $$    | $$  \ $$| $$  \ $$| $$  \__/
 /$$__  $$| $$  | $$  | $$ /$$| $$  | $$| $$  | $$| $$      
|  $$$$$$$|  $$$$$$/  |  $$$$/| $$  | $$|  $$$$$$/| $$      
 \_______/ \______/    \___/  |__/  |__/ \______/ |__/      
                                                            
                                                            
        << roopampoddar.com >>


    -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Type Rush</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/<?php echo getCSSJSVer('base', 'css'); ?>.css" />
        <link href='http://fonts.googleapis.com/css?family=Ubuntu+Mono' rel='stylesheet' type='text/css'>
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon.ico">
        <script type="text/javascript" src="<?php echo base_url(); ?>js/<?php echo getCSSJSVer('jquery', 'js'); ?>.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/<?php echo getCSSJSVer('base', 'js'); ?>.js"></script>
        <?php
            if(!empty($js)) {
                foreach($js as $j) {
                    echo '<script type="text/javascript" src="'.base_url().'js/'.getCSSJSVer($j, 'js').'.js"></script>';
                }
            }
        ?>
        <script>
            var configObj = new function() {
                this.baseUrl = "<?php echo base_url(); ?>";
                this.backendUrl = "<?php echo site_url('/backend'); ?>";
                this.countdown_limit = "<?php echo $this->config->item('countdown_time'); ?>";
            };
        </script>
        <?php if($this->config->item('track_on')): ?>
        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-49041065-1']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
        <?php endif; ?>
    </head>
    <body>
        <div id="header" class="p20">
            <div id="witText">
                <div id="headerLogo">
                    <h1>
                        <a href="<?php echo base_url(); ?>" class="no-underline">
                            <span class="lightGrey">TypeRush</span>
                        </a>
                    </h1>
                </div>
                <span class="largeText">Typing practice, gamified!</span>
            </div>
            <br> 
            <?php if (!empty($username)) : ?>
                <div>
                    playing as <span id="username" class="grey"><?php echo ((isset($username) ? $username : 'anonymous')); ?></span>
                    <a href="<?php echo site_url('track/add')?>" class="large-blue-button" style="float:right;margin-right:20px;">Add a track</a>
                    <a href="<?php echo site_url('room/start')?>" class="large-blue-button" style="float:right;margin-right:20px;">Start a room</a>
                    <div class="clr"></div>
                </div>
            <?php endif; ?>
        </div>
        <div id="wrapper">
