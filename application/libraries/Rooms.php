<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rooms {

    private $CI = null;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('room_model');
    }

    public function updateRoomStatus()
    {
        $this->CI->room_model->update();
    }
}
