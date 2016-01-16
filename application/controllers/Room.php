<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room extends CI_Controller {

    public function __construct()
       {
            parent::__construct();
            $this->load->library('session');
            $this->load->model('room_model');
       }

    public function index() {
        // display details of all the tracks currently active
        // list of all the prople you can select and add to a track
        echo "yo dawg!";
        echo " playing as ".$this->session->userdata('roomuser');;
        // ping on the ping data
        $userlist = $this->room_model->getOnlineUsers();
        echo "<br><br>";
        print_r($userlist);
    }

    public function start() {
        $this->load->view('page_start', array('js'=>array('room')));

        $this->load->library('form_validation');
        $this->load->helper('form_helper');
            
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('track', 'Track', 'trim|required|integer');

        if($this->form_validation->run() == false) {
            $this->load->view("room/new_room");
        } else {
            $postdata = $this->input->post();
            $r = $this->room_model->startRoom($postdata);    
            if($r['s'])
                redirect(site_url('room/play/'.$r['url']));
            else $this->load->view('room/room_failure');
        }
        $this->load->view('page_end');
    }

	public function enter($room_id)
	{
        $this->load->view('page_start', array('js'=>array('room')));

        if($this->room_model->checkRoomPresence($room_id)) {
            $this->load->library('form_validation');
            $this->load->helper('form_helper');
                
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[20]');
            $this->form_validation->set_rules('room_id', 'Room ID', 'trim|required|integer');

            if($this->form_validation->run() == false) {
                $this->load->view("room/enter_room", array('room_id'=>$room_id));
            } else {
                $postdata = $this->input->post();
                $r = $this->room_model->enterRoom($postdata);    
                if($r['s'])
                    redirect(site_url('room/play/'.$r['url']));
                else $this->load->view("room/enter_room", array('room_id'=>$postdata['room_id'], 'error' => $r['d']));
                //$this->load->view('room/room_failure');
            }
        } else {
            $this->load->view('room/room_failure', array('err' => 'You are already present in this room!'));   
        }
        $this->load->view('page_end');
    }

    public function play($room_id, $token) {
        $this->load->view('page_start', array('js'=>array('room')));
        if($this->room_model->verifyRoom($room_id, $token)) {
            $rooms_data = $this->session->userdata('rooms_data');
            $found = false;
            if($rooms_data) {
                foreach($rooms_data as $room_data) {
                    if($room_data['room_id'] == $room_id) {
                        $found = true;
                        $room_userid = $room_data['room_userid'];
                        $username = $room_data['username'];
                        $track_id = $room_data['track_id'];
                    }
                }
            }
            if(!$found) {
                $this->load->view('room/room_failure', array('err' => "You are not in this room yet!"));
            } else {
                $this->load->model('tracks_model');
                $r = $this->tracks_model->getTrack($track_id);
                $track = $r['d'];
                $this->load->view('track', array('track'=>$track, 'room' => true));
                $this->load->view('room/dashboard', array('room_id'=>$room_id, 'userid'=>$room_userid, 'username'=>$username));    
            }
        } else {
            $this->load->view('room/room_failure', array('err' => 'Room seems to be invalid!'));
        }
        $this->load->view('page_end');
    }
}

