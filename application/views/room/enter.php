<div class="p20">
    
    <?php if($form_errors = validation_errors()) {
        echo '<div class="error_box">'.$form_errors.'</div>';
    } ?>

    <form name="enterRoomForm" method="POST">
    Give us a nick name: <br><Br>
    <input type="text" name="nick">
    <input type="submit" value="enter">
    </form>
</div>

