<div id="l3" class="box-shadow pagecolumn">
    <div id="onlineStatus" class="largeText">offline</div>
    <div id="roomMsg" class="largeText"></div><hr>
    <?php if (!empty($room_id)): ?>
        <div >
            share url : <br><input type="text" class="p10" style="width:400px" value="<?php echo site_url('room/enter/'.$room_id); ?>" />
        </div><br><br>
        players: <br>
        <div id="room_players">
        	
        </div>
        <br><br>
        <input type="button" value="I am ready!" id="readyToPlay" />
    <?php endif; ?>
</div>

<script type="text/javascript">
    var roomData = new function() {
        this.status = -1; // initially -1, 0 when stagnant and 1 when online.
        this.username = "<?php echo $username; ?>";
        this.room_id = "<?php echo $room_id; ?>";
        this.players = [];
        this.mod = 0;
        this.p = 0;
    }, roomObj = false;
</script>