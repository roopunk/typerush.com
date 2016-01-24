<div class="row">
	<div class="col-md-6">
		<?php echo $this->load->view('track', array('track'=>$track), true);?>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-6">
				<div class="box-shadow pagecolumn">
					<?php if (!empty($recentScores)): ?>
			        <div >
			            <div class="bg-success p10">Recent Scores</div>
			            <table class="table">
    					<tr><th>user</th><th>wpm</th><th>when</th></tr>
			            <?php
			            foreach ((array) $recentScores as $score) {
			                echo '<tr><td>'.
									$score['name'].'</td><td>'.
									$score['wpm'].'</td><td>'.
									timespan($score['timestamp'], time(), 1).' ago</td></tr>';
			            }
			            ?>
			            </table>
			        </div><br>
					<?php endif; ?>
				</div>
				<div class="box-shadow pagecolumn">
			        <?php if (!empty($topTracks)): ?>
			        <div >
			            <div class="bg-success p10">Top Tracks</div>
			            <?php
			            foreach ((array) $topTracks as $trackInfo) {
			                echo '<div class="p10 dash-bottom trackDiv" trackid="' . $trackInfo['id'] . '">' . $trackInfo['content'] . (($trackInfo['length'] > $this->config->item('preview_limit'))?"...":"") .'</div>';
			            }
			            ?>
			        </div><br>
					<?php endif; ?>

				</div>
			</div>
			<div class="col-md-6">
				<div class="box-shadow pagecolumn">
			    <?php if (!empty($recentTracks)): ?>
			        <div >
			            <div class="bg-success p10">Recent Tracks</div>
			            <?php
			            foreach ((array) $recentTracks as $trackInfo) {
			                echo '<div class="p10 dash-bottom trackDiv" trackid="' . $trackInfo['id'] . '">' . $trackInfo['content'] . (($trackInfo['length'] > $this->config->item('preview_limit'))?"...":"").'</div>';
			            }
			            ?>
			        </div><br>
				<?php endif; ?>
				</div>
				
			</div>
		</div>
	</div>
</div>