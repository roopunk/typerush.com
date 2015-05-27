<div class="box-shadow pd10">	
		<?php if(!empty($trackList)): ?>
			<div>
				<form method='get'> Choose Track:  <select name='trackid' onchange=' $("#trackSelForm").click(); '>
				<option value=''></option>
				<?php  foreach ((array)$trackList as $row) {
					echo '<option value="'.$row['id'].'" >words: '.$row['words'].'; '.substr($row['content'], 0, 10).'...</option>';
					$r = $row;
				}?>
				</select><input type="submit" value="ok" id="trackSelForm"></form>
			</div>
			<?php endif; ?>
	<a href="<?php echo base_url();?>">Back</a>
</div>