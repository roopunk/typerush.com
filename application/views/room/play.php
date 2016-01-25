<div class="row">
    <div class="col-md-6">
        <?php $this->load->view('track', array('track' => $track, 'room' => true)); ?>
    </div>
    <div class="col-md-6">
        <?php $this->load->view('room/dashboard', array('room_id'=>$room_id, 'userid'=>$room_userid, 'username'=>$username)); ?>
    </div>
</div>