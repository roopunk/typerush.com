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
        <link rel="stylesheet" href="/css/base.css" />
        <link rel="stylesheet" href="/css/bootstrap.min.css" />
        <!-- <link href='http://fonts.googleapis.com/css?family=Ubuntu+Mono' rel='stylesheet' type='text/css'> -->
        <link rel="icon" type="image/png" href="/favicon.ico">
        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="/js/base.js"></script>
        <!--<script type="text/javascript" src="/js/bootstrap.min.js"></script>-->
        <?php
        //if(!empty($js)) {
            //foreach($js as $j) {
                //echo '<script type="text/javascript" src="'.base_url().'js/'.getCSSJSVer($j, 'js').'.js"></script>';
            //}
        //}
        ?>
        <script>
            var configObj = new function() {
                this.baseUrl = "/";
                this.backendUrl = "/backend";
                this.countdown_limit = "10";
            };
        </script>
    </head>
    <body>
        <div class="container">
            <div class="p10">
                <div class="row">
                    <div class="col-md-6">
                        <h1>
                            <a href="/" class="no-underline">
                                <span class="lightGrey">TypeRush</span>
                            </a>
                        </h1>
                    </div>
                    <div class="col-md-6 text-right" style="padding-top:20px;">
                        <a href="/track/add" class="btn btn-primary m10" >Add a track</a>
                        <!--<a href="/room/start" class="btn btn-primary m10">Start a room</a>-->
                    </div>
                </div>
                <hr>
                <?php if (!empty($username)) : ?>
                <div>
                    Playing as <span id="username" class="grey"><?php echo ((isset($username) ? $username : 'anonymous')); ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div>
            @yield('content')
            </div>
        </div>
    </body>
</html>

