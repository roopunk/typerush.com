<div class="p10 box-shadow">
    <h3>Room #<?php echo $room_id; ?></h3>
    <div id="roomMsg" class="largeText">waiting for players..</div><hr>
    <?php if (!empty($room_id)): ?>
        <div>
            <form>
                <div class="input-group">
                <span class="input-group-addon">share url</span>
                <input type="text" class="form-control"
                       value="<?php echo site_url('room/enter/' . $room_id); ?>"/>
                </div>
            </form>
        </div><br>
        <h5>Players</h5>
        You <span id="onlineStatus"></span>
        <div id="room_players">
        </div>
        <br><br>
        <input type="button" class="btn btn-primary" value="I am ready!" id="readyToPlay" />
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