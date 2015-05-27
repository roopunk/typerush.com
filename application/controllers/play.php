<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Play extends CI_Controller {

	public function index()
	{
        $this->load->model('tracks_model');
		$r = $this->tracks_model->getTopTracks(); 
        $topTracks = $r['d'];
		$r = $this->tracks_model->getRecentTracks(); 
        $recentTracks = $r['d'];
  
        // fetch the current track details and store it in the session      
        $r = $this->tracks_model->getTrack();
        $trackid = $r['d']['trackid'];
        $track = $r['d'];
        $this->session->set_userdata(array('trackid'=>$trackid));

        // about the user
        // read the cookie
        $username = "anon";
        if(!empty($_COOKIE['tr_username']))
            $username = $_COOKIE['tr_username'];
        if(!$this->session->userdata('userid'))
            $this->session->set_userdata(array('userid'=>(!empty($userid)?$userid:0))); // a userid=0 means anonymous user

        $this->load->view('page_start', array('username'=>$username));
		$this->load->view('track', array('track'=>$track));
		$this->load->view('trackCharts', array('topTracks'=>$topTracks, 'recentTracks'=>$recentTracks));
        $this->load->view('page_end');
	}
}

