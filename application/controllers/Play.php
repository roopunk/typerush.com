<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Play extends CI_Controller {

	public function index()
	{
        $this->load->model('tracks_model');
        $this->load->model('score_model');
        $this->load->helper('date');

		$topTracks = $this->tracks_model->getTopTracks()['d'];
		$recentTracks = $this->tracks_model->getRecentTracks()['d'];
  
        // fetch the current track details and store it in the session      
        $track = $this->tracks_model->getTrack()['d'];
        $trackid = $track['trackid'];
        $this->session->set_userdata(array('trackid'=>$trackid));

        // fetch the recetly played tracks
        $recentScores = $this->score_model->fetchRecentScores();

        // about the user
        // read the cookie
        $username = "anon";
        if(!empty($_COOKIE['tr_username']))
            $username = $_COOKIE['tr_username'];

        $this->load->view('page_start', array('username'=>$username));
        $this->load->view('play', array(
            'username'=>$username, 
            'track' => $track, 
            'topTracks'=>$topTracks, 
            'recentTracks'=>$recentTracks,
            'recentScores' => $recentScores
        ));
        $this->load->view('page_end', ['js' => ['play']]);
	}
}


