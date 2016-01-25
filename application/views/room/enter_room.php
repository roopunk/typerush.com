<div class="row">
    <?php if($form_errors = validation_errors()) {
        echo '<div class="error_box">'.$form_errors.'</div>';
    } ?>
    <?php if(!empty($error)) {
        echo '<div class="error_box">'.$error.'</div>';
    } ?>

    <div class="col-md-6">
        <form name="enterRoomForm" method="POST">
        <input type="text" placeholder="Give us a nick name" name="username" class="largeText form-control">

        <input type="hidden" name="room_id" value="<?php echo (!empty($room_id))?$room_id:"0"; ?>" /><br>
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

        <input type="submit" value="enter" class="btn btn-primary">
        </form>
    </div>
</div>
<br><br>
<a href="<?php echo base_url(); ?>">Back Home</a>