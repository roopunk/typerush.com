<?php
class Score_model extends CI_model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function fetchScore($data) {
        $query = "SELECT name, time FROM score WHERE `track`= ? ORDER BY `time` LIMIT 50";
        $result1 = $this->db->query($query, array($data['trackid']));
        
        $this->load->model('tracks_model');
        $result2 = $this->tracks_model->getTrack($data['trackid']);
        if($result1 && $result2['s'])
            return array('s'=>true, 'd'=>array('scores'=>$result1->result_array(), 'trackInfo'=>$result2['d']));
        else return array('s'=>false, 'm'=>'FAILED_QUERY');
    }

    function submitScore($data) {        
        // validating score
        $this->load->model('tracks_model');
        $trackInfo = $this->tracks_model->getTrackLength($data['trackid']);
        if(!$trackInfo['s']) return array('s'=>false, 'm'=>'INVALID_TRACK');
        $wordLength = $trackInfo['d'];
        $timeTaken = $data['blah']/10;
        if($timeTaken==0  || ($wordLength/$timeTaken*60 > $this->config->item('max_wpm'))) return array('s'=>false, 'm' => 'SCORE_HACKED ');

        $query = " INSERT INTO score (`user`, `time`, `name`, `track`) VALUES ( ?, ?, ?, ?)";
        $this->db->query($query , array($data['userid'], $data['blah'], $data['name'], $data['trackid']));   
        return array('s'=>true, 'd'=>$this->db->affected_rows());
    }
    
}
