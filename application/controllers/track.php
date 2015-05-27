<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Track extends CI_Controller {
	public function add()
	{
        $this->load->view('page_start', array('js'=>array('track_add')));

        $this->load->library('form_validation');
        $this->load->helper('form_helper');
            
        $this->form_validation->set_rules('para', 'Paragraph', 'trim|required|min_length[5]|max_length[1000]|xss_clean');
        $this->form_validation->set_rules('aboutPara', 'About Paragraph', 'trim|min_length[5]|max_length[200]|xss_clean');

        if($this->form_validation->run() == false) {
            $this->load->view("track/track_add");
        } else {
            $this->load->model('tracks_model');

            $postdata = $this->input->post();

            require_once('recaptchalib.php');
            $resp = recaptcha_check_answer (
                '6LdhawcTAAAAAG-AtjWFUtfS8UzvlqJF3EL5u2LS',
                $_SERVER["REMOTE_ADDR"],
                $_POST["recaptcha_challenge_field"],
                $_POST["recaptcha_response_field"]
            );

            if ($resp->is_valid) {
                $r = $this->tracks_model->addTrack($postdata);    
                if($r['s'])
                    $this->load->view('track/added_success',$r['d']);
                else $this->load->view('track/added_failure', array('m'=>$r['m'], 'd'=>$r['d']));
            } else {
                $this->load->view('track/added_failure', array('m'=>"INSERT_FAILURE"));
            }
        }
        $this->load->view('page_end');
    }
	
	public function all() {
		$this->load->model('tracks_model');

        $r = $this->tracks_model->getTracksList(); 
        $trackList = $r['d'];
		
		$username = "anonymous";
        if(!empty($_COOKIE['tr_username']))
            $username = $_COOKIE['tr_username'];
        if(!$this->session->userdata('userid'))
            $this->session->set_userdata(array('userid'=>(!empty($userid)?$userid:0))); // a userid=0 means anonymous user

        $this->load->view('page_start', array('username'=>$username));
		$this->load->view('trackList', array('trackList'=>$trackList));
        $this->load->view('page_end');
	}
}

