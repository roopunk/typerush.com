<?php
	class trackModel {
		public function getTracksDropDown() {
		 	$para1 = mysql_query("SELECT `id`, `words`, `content` FROM para ORDER BY `id`");
			echo "<form method='get'> Custom Track:  <select name='paraid'><option value=''></option>";
			while($row = mysql_fetch_assoc($para1)) {
				echo '<option value="'.$row['id'].'">words: '.$row['words'].'; '.substr($row['content'], 0, 10).'...</option>';
				$r = $row;
			}
			echo '</select><input type="submit" value="ok"></form>';

		}

		public function getTrack() {
			
			if(isset($_GET['paraid']) && $_GET['paraid']) {
				$paraid = $_GET['paraid'];
			} else {
				$query = mysql_query("SELECT r1.id as id FROM para AS r1 JOIN 
					(SELECT (RAND()*(SELECT MAX(id) FROM para)) AS id)
					AS r2
					WHERE r1.id >= r2.id
					ORDER BY r1.id ASC
					LIMIT 1");
				$row = mysql_fetch_assoc($query);
				$paraid = $row['id'];
			}

			$paraid = mysql_real_escape_string($paraid);
			$para = mysql_query("SELECT `id`, `words`, `content` FROM para WHERE `id`='$paraid'");
			// fallback
			/*if(mysql_num_rows($para) == 0) {
				$para = mysql_query("SELECT `id`, `content` FROM para ORDER BY `id` DESC LIMIT 1");
			}*/
			if(mysql_num_rows($para) == 0) { 
				return false;
			}
			$r = mysql_fetch_assoc($para);
  
			$text = $r['content'];
			$paraid = $r['id'];
			$words = $r['words'];
			$text = preparePara($text);
			
			return array('text'=>$text, 'paraid'=>$paraid, 'words'=>$words);
		}
	}
?>
