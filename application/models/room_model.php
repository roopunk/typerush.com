<?php
class Room_model extends CI_model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getOnlineUsers() {
        $time = time();
        $ping = $this->config->item('check_online_limit');
        $checkTime = $time-$ping;
        $onlineUsers = $this->db->query("SELECT id, user from room where outtime > $checkTime");
        if($onlineUsers->num_rows() == 0)
            return array();
        return $onlineUsers->result_array();
    }

    function addUser($postdata) {
        $nick = $postdata['nick'];
            
        // check if somewith the same nick name is already online
        $matches = $this->db->query("SELECT outtime from room where `user`='$nick' order by outtime desc limit 1");
        if($matches->num_rows()!=0) {
            $match = $matches->row();
            $outtime = $match->outtime;
            
            $diff = time() - $outtime;
            if($diff < $this->config->item('ovrride_online_limit'))
                return array('s'=>false, 'd'=>"Someone with this handle is already present in the room. <a href='".site_url('room/enter')."'>Try again!</a>");
        }    
    
        // process nick nameo       
        $time = time();
        $this->db->query("INSERT INTO room (`user`, `intime`, `outtime`) VALUES ('$nick', '$time', '$time')");
        $insert_id = $this->db->insert_id();
        return array('s'=>true, 'd'=>$insert_id);
    }

    function startRoom($postData) {
        $username = $postData['username'];
        $track = $postData['track'];

        // add a row to the rooms table, timestamp, id, rand1, rand2, players
        $token = rand(1, 1000);
        $this->db->query("INSERT INTO rooms (`trackid`, `token`) VALUES ( ? , ? )", array($track, $token));
        $room_id = $this->db->insert_id();

        // create a user session 
        $this->db->query("INSERT INTO room_users (`room_id`, `username`) VALUES ( ? , ? )", array($room_id, $username));
        $user_id = $this->db->insert_id();

        // get the room id and generate the url.
        $room_url = $room_id."/".$token;

        // generate a file name and store that in the session
        $file_name = "room_".$room_id;
        file_put_contents("rooms/".$file_name, time());
        $sess_data = array('room_id'=>$room_id, 'room_userid' => $user_id, 'username'=>$username, 'track_id'=>$track);
        $rooms_data = $this->session->userdata('rooms_data');
        if(!$rooms_data) $rooms_data = array($sess_data);
        else $rooms_data[] = $sess_data;
        $this->session->set_userdata(array('rooms_data' => $rooms_data));

        return array('s'=>true, 'url'=>$room_url);
    }

    function enterRoom($postData) {
        $username = $postData['username'];
        $room_id = $postData['room_id'];

        // checking user availablity
        $userCheck = $this->db->query("SELECT `id` from room_users where `username` = ? AND `room_id` = ?", array($username, $room_id));
        if($userCheck->num_rows() > 0) return array('s'=>false, 'd'=>'This username has already been taken in this room!');

     
        $roomInfo = $this->db->query("SELECT `trackid`,`token` from rooms where `id` = ? ", array($room_id));
        $roomData = $roomInfo->row_array();
        $token = $roomData['token'];
        $track = $roomData['trackid'];

        // create a user session 
        $this->db->query("INSERT INTO room_users (`room_id`, `username`) VALUES ( ? , ? )", array($room_id, $username));
        $user_id = $this->db->insert_id();

        // get the room id and generate the url.
        $room_url = $room_id."/".$token;

        // update the file and create a session
        $file_name = "room_".$room_id;
        file_put_contents("rooms/".$file_name, time());
        $sess_data = array('room_id'=>$room_id, 'room_userid' => $user_id, 'username'=>$username, 'track_id' => $track);
        $rooms_data = $this->session->userdata('rooms_data');
        if(!$rooms_data) $rooms_data = array($sess_data);
        else $rooms_data[] = $sess_data;
        $this->session->set_userdata(array('rooms_data' => $rooms_data));
        
        return array('s'=>true, 'url'=>$room_url);
    }

    function verifyRoom($room_id, $token) {
        $roomCheck = $this->db->query("SELECT id from rooms where `id` = ? AND `token` = ?", array($room_id, $token));
        return ($roomCheck->num_rows() > 0);
    }

    function checkRoomPresence($room_id) {
        $rooms_data = $this->session->userdata('rooms_data');
        if($rooms_data) {
            foreach($rooms_data as $room_data) {
                if($room_data['room_id'] == $room_id) {
                    return false;                    
                }
            }
            return true;
        } else return true;
    }

    function getRoomInfo($room_id) {
        $result = array();
        $complete =  true;
        $query = $this->db->query("SELECT `id`, `username`, `completed`, `time_taken` from room_users where `room_id` = ?", array($room_id));
        foreach($query->result_array() as $row) {
            if($row['completed'] != '100')
                $complete = false;
            $result[] = $row;
        }
        // if complete, then mark room as complete
        if($complete) {
            $update_query = $this->db->query("UPDATE rooms set `status` =1 where `id`=?", array($room_id));
        }
        return $result;
    }

    function updateProgress($room_id, $progress, $time) {

        $rooms_data = $this->session->userdata('rooms_data');
        if($rooms_data) {
            foreach($rooms_data as $room_data) {
                if($room_data['room_id'] == $room_id)
                    $userid = $room_data['room_userid'];
            }
        }
        // updating the ping file
        $file_name = "room_".$room_id;
        $temp = file_put_contents("rooms/".$file_name, time());

        $update_query = $this->db->query("UPDATE room_users set `completed` =?, `time_taken`= ? where `room_id`=? and `id`=?", array($progress, $time, $room_id, $userid));
        if(!$update_query) return false;


        else return true;
    }
}
