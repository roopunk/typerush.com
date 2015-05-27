<div id="l1" class="box-shadow pagecolumn">
    <?php if (!empty($recentTracks)): ?>
        <div >
            <strong>Recent Tracks</strong>
            <?php
            foreach ((array) $recentTracks as $trackInfo) {
                echo '<div class="p5 dash-bottom trackDiv" trackid="' . $trackInfo['id'] . '">' . $trackInfo['content'] . (($trackInfo['length'] > $this->config->item('preview_limit'))?"...":"").'</div>';
            }
            ?>
        </div><br>
<?php endif; ?>
</div>

<div id="l2" class="box-shadow pagecolumn">
        <?php if (!empty($topTracks)): ?>
        <div >
            <strong>Top Tracks</strong>
            <?php
            foreach ((array) $topTracks as $trackInfo) {
                echo '<div class="p5 dash-bottom trackDiv" trackid="' . $trackInfo['id'] . '">' . $trackInfo['content'] . (($trackInfo['length'] > $this->config->item('preview_limit'))?"...":"") .'</div>';
            }
            ?>
        </div><br>
<?php endif; ?>

</div>