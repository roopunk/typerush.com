<div>
    <?php if($form_errors = validation_errors()) {
        echo '<div class="error_box">'.$form_errors.'</div>';
    } ?>

    <?php if(!empty($error)) {
        echo '<div class="error_box">'.$error.'</div>';
    } ?>

    <form name="enterRoomForm" method="POST">
        Give us a nick name: <br>
        <input type="text" name="username" class="largeText"><br><br>
        Choose a track: <br>
        <input type="text" name="track" class="largeText"><br><br>

        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <input type="submit" value="enter" class="btn btn-primary   ">
    </form>
</div>
<br><br>
<a href="<?php echo base_url(); ?>">Back Home</a>

