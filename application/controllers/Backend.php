<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends CI_Controller {

	public function index()
	{
        echo "Nothing!";
   	}
    
    public function submitScore() {
        $data = array();
        $data['blah'] = isset($_POST['blah'])?$_POST['blah']:null;
        $data['name'] = isset($_POST['name'])?$_POST['name']:null;
        $data['blah'] = ($data['blah'])?$data['blah']:0;
        $data['name'] = ($data['name'])?$data['name']:"anonymous";  

        $data['userid'] = $this->session->userdata('userid');
        $data['trackid'] = $this->session->userdata('trackid');

        $this->load->model('score_model');
        $result = $this->score_model->submitScore($data);
        echo json_encode($result);
    }

    public function fetchScore() {
        $data['trackid'] = $this->session->userdata('trackid');
        
        $this->load->model('score_model');
        $scores = $this->score_model->fetchScore($data);
        
        $content = $this->load->view('scores', $scores['d'], true);
        $result = array('status'=>true, 'content'=>$content);
        echo json_encode($result);
    }

    public function prepareForTesting() {
        $track = htmlspecialchars($_POST['track']);
        list($text, $length) = filterPara($track);
        $text = preparePara($text);
        if(!$text) $result = array('status'=>false);
        else $result = array('status'=>true, 'content'=>$text, 'length'=>$length);
        echo json_encode($result);
    }

    public function roomPing() {
        $room_id = $this->input->get('room_id');
        if(!$room_id) {
            echo json_encode(array('s'=>false)); exit;
        }
        $mod = $this->input->get('mod');
        $file_url = "rooms/room_".$room_id;
        $this->load->model('room_model');
        $resource = false;

        $counter = 0;
        while($counter < 10) {
            clearstatcache();
            $modified_time = filemtime($file_url);
            if($mod < $modified_time) {    
                $mod = $modified_time;
                $resource = $this->room_model->getRoomInfo($room_id);
                break;
            }
            $counter++;
            sleep(1);
        }
        if($resource)
            echo json_encode(array('s' =>true, 'd'=>true, 'mod' => $mod, 'info'=> $resource));
        else echo json_encode(array('s' => true, 'd'=>false));
    }

    public function markReady() {
        $room_id = $this->input->get('room_id');
        if(!$room_id) { echo json_encode(array('s'=>false)); exit; }
        $this->load->model('room_model');
        $result = $this->room_model->updateProgress($room_id,0);
        if(!$result) { echo json_encode(array('s'=>false)); exit; }
        else { echo json_encode(array('s'=>true)); exit; }
    }

    public function updateProgress() {
        $progress = $this->input->post('progress');
        $room_id = $this->input->post('room_id');
        $time = $this->input->post('time');
        if(!$room_id || !is_numeric($progress) || !is_numeric($time)) { echo json_encode(array('s'=>false)); exit; }
        $this->load->model('room_model');
        $result = $this->room_model->updateProgress($room_id, $progress, $time);
        if(!$result) { echo json_encode(array('s'=>false)); exit; }
        else { echo json_encode(array('s'=>true)); exit; }
    }
}

