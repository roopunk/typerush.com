<div>
    <?php if($form_errors = validation_errors()) {
        echo '<div class="error_box">'.$form_errors.'</div>';
    } ?>
    <?php if(!empty($error)) {
        echo '<div class="error_box">'.$error.'</div>';
    } ?>

    <form name="enterRoomForm" method="POST">
    Give us a nick name: <br>
    <input type="text" name="username" class="largeText">
    <input type="hidden" name="room_id" value="<?php echo (!empty($room_id))?$room_id:"0"; ?>" /><br><br>

    <input type="submit" value="enter" class="large-button">
    </form>
</div>
<br><br>
<a href="<?php echo base_url(); ?>">Back Home</a>