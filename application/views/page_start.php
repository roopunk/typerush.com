<!DOCTYPE html>
<html>
    <head>
        <!--

                                           /\ \        
 _ __   ___     ___   _____   __  __    ___\ \ \/'\    
/\`'__\/ __`\  / __`\/\ '__`\/\ \/\ \ /' _ `\ \ , <    
\ \ \//\ \L\ \/\ \L\ \ \ \L\ \ \ \_\ \/\ \/\ \ \ \\`\  
 \ \_\\ \____/\ \____/\ \ ,__/\ \____/\ \_\ \_\ \_\ \_\
  \/_/ \/___/  \/___/  \ \ \/  \/___/  \/_/\/_/\/_/\/_/
                        \ \_\                          
                         \/_/     
                                                            
        << roopampoddar.com >>


    -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Type Rush</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/<?php echo getCSSJSVer('base', 'css'); ?>.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
        <!-- <link href='http://fonts.googleapis.com/css?family=Ubuntu+Mono' rel='stylesheet' type='text/css'> -->
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon.ico">
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>-->
        <?php if($this->config->item('track_on') && $this->config->item('is_live')): ?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-49041065-1', 'auto');
            ga('send', 'pageview');

        </script>
        <?php endif; ?>
    </head>
    <body>
        <div class="container">
            <div class="">
                <div class="row">
                    <div class="col-md-6">
                        <h1>
                            <a href="<?php echo base_url(); ?>" class="no-underline">
                                <span class="lightGrey">TypeRush</span>
                            </a>
                        </h1>
                    </div>
                    <div class="col-md-6 text-right" style="padding-top:20px;">
                        <a href="<?php echo site_url('track/add')?>" class="btn btn-primary m10" >Add a track</a>
                        <!--<a href="<?php echo site_url('room/start')?>" class="btn btn-primary m10">Start a room</a>-->
                    </div>
                </div>
                <!-- <h4 >Typing practice, gamified!</h4> -->
                <hr>
                <?php if (!empty($username)) : ?>
                <div>
                    Playing as <span id="username" class="grey"><?php echo ((isset($username) ? $username : 'anonymous')); ?></span>
                </div>
                <br>
                <?php endif; ?>
            </div>
            <div>
