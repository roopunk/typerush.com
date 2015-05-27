<?php
class Tracks_model extends CI_model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function getTracksList() {
        $tracks = $this->db->query("SELECT `id`, `words`, `content` FROM tracks ORDER BY `id`");
        if($tracks)
            return array('s'=>true, 'd'=>$tracks->result_array());  
        else return array('s'=>false, 'm'=>'FAILED_QUERY');
    }
	
	public function getTopTracks(){
		$result = $this->db->query("SELECT track FROM `score` group by track order by count(*) desc limit 10");
		if($result) {
			$tracks = array();
			$temp = $result->result_array();
			foreach($temp as $t)
				$tracks[] = $t['track'];
			
			$trackCSV = implode($tracks, ",");
			$tracksPreview = $this->db->query("SELECT `id`, `words`, substr(`content`,1,".$this->config->item('preview_limit').") as content, char_length(`content`) as length FROM tracks WHERE `id` in ($trackCSV)");
			return array('s'=>true, 'd'=>$tracksPreview->result_array());
		}
		else return array('s'=>false, 'd'=>'FAILED_QUERY');
	}
	
	public function getRecentTracks(){
		$result = $this->db->query("SELECT `id`, `words`, substr(`content`,1,".$this->config->item('preview_limit').") as content, char_length(`content`) as length FROM `tracks` order by UNIX_TIMESTAMP(timestamp) desc limit 10");
		if($result) {
			$tracks = $result->result_array();
			return array('s'=>true, 'd'=>$tracks);
		}
		else return array('s'=>false, 'd'=>'FAILED_QUERY');
	}

    public function getTrack($trackId = null) {
        if(!is_null($trackId)) {
            $trackid  = $trackId;
        } else if(!empty($_GET['trackid'])) {
            $trackid = $_GET['trackid'];
        } else {
            $query = $this->db->query("SELECT r1.id as id FROM tracks AS r1 JOIN 
                (SELECT (RAND()*(SELECT MAX(id) FROM tracks)) AS id)
                AS r2
                WHERE r1.id >= r2.id
                ORDER BY r1.id ASC
                LIMIT 1");
            $row = $query->row_array();
            $trackid = $row['id'];
        }

        $trackQuery = $this->db->query("SELECT `id`, `words`, `content`, `about` FROM tracks WHERE `id`= ? ", array($trackid));
        if($trackQuery->num_rows() == 0) return array('s'=>false, 'm'=>'NO_SUCH_TRACK'); 
        
        $track = $trackQuery->row_array();
        $text = preparePara($track['content']); // in the base helper
        $words = $track['words'];
        $about = $track['about'];
        return array('s'=>true, 'm'=>'SUCCESSFUL', 'd' => array('text'=>$text, 'trackid'=>$trackid, 'words'=>$words, 'about'=>$about));
    }

    function getTrackLength($trackId = null) {
        $trackQuery = $this->db->query("SELECT `words` FROM tracks WHERE `id`= ? ", array($trackId));
        if($trackQuery->num_rows() == 0) return array('s'=>false, 'm'=>'NO_SUCH_TRACK'); 
        $track = $trackQuery->row_array();
        return array('s'=>true, 'd'=>$track['words']);
    }
 
   function addTrack($postdata) {
        list($para, $length) = filterPara($postdata['para']);
        $aboutPara = $postdata['aboutPara'];
        if(strlen($para) > 1000)
            return array('s'=>false, 'm'=> 'INVALID_PARA', 'd'=> "Length of para cannot be more than 1000!");
        $user = $this->session->userdata('userid');
        
        $similarCheck = $this->db->query("SELECT id from tracks where `user` = ?  and `content` = ? limit 1 ", array($user, $para));
        $count = $similarCheck->num_rows();
        if($count>0) {
            return array('s'=> false, 'm' => 'SIMILAR_EXISTS', 'd'=> $similarCheck->first_row()->id);
        }
        
        $this->db->query("INSERT INTO tracks (`content`, `words`, `user`, `about`) VALUES ( ? , ?, ?, ?)", array($para, $length, $user, $aboutPara));
        if($this->db->affected_rows() == 1)
            return array('s'=> true, 'd'=> array('length'=> strlen($para), 'num_words' => $length, 'id' => $this->db->insert_id()));
        else return array('s'=> false, 'm' => 'INSERT_FAILURE');
    }


}
?>
