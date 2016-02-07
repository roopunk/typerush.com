<div class="row">
    <?php if ($form_errors = validation_errors()) {
        echo '<div class="error_box">' . $form_errors . '</div>';
    } ?>

    <?php if (!empty($error)) {
        echo '<div class="error_box">' . $error . '</div>';
    } ?>

    <div class="col-md-6">
        <form name="enterRoomForm" method="POST">
            <input type="text" placeholder="Choose a nick name" name="username" class="form-control"/><br>
            <?php if(!empty($track)): ?>
                <input type="text" placeholder="Choose a track" readonly="readonly" name="track" class="form-control" value="<?php echo $track; ?>" /><br>
            <?php else: ?>
                <input type="text" placeholder="Choose a track" name="track" class="form-control" /><br>
            <?php endif; ?>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                   value="<?php echo $this->security->get_csrf_hash(); ?>"/>
            <input type="submit" value="Enter" class="btn btn-primary   ">
        </form>
    <br><br>
    <a href="<?php echo base_url(); ?>">Back Home</a>
    </div>

</div>