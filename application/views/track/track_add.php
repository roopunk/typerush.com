<div class="row">
    <div id="addForm" class="col-md-6">
        <?php
        if ($form_errors = validation_errors()) {
            echo '<div class="error_box">' . $form_errors . '</div>';
        }
        ?>
        <form name="newTrackForm" method="POST">
            <textarea name="para" style="height:200px;" class="form-control" id="addPara" placeholder="Insert you para here..."></textarea><br>
            <span>something about this text?</span><br>
            <input type="text" placeholder="book / movie dialogue / random" class="largeText form-control" name="aboutPara"/> <br>
            <?php
                require_once('recaptchalib.php');
                $publickey = "6LdhawcTAAAAAH84MAcozmtseiUYtuRchOf4OD0M"; // you got this from the signup page
                echo recaptcha_get_html($publickey);
            ?>
            <br>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="submit" value="check and submit" class="btn btn-primary">
            <input type="button" value="test run" class="btn btn-default" onclick="testTrack()">
        </form>
    </div>
    <div id="testSpaceDiv" class="hid col-md-6">
        <span >Word Length:</span> <span id="testSpaceLength" class="largeText"></span><br><br>
        <div id="testSpaceMeta" class="paraMeta"> <div id="testSpaceprogress" class="paraprogress"></div></div>
        <div id="testSpacewrapper" class="parawrapper">
            <div id="testSpace" class="para"><?php echo $track['text']; ?></div>
            <div id="testSpacebs" class="bottomshadow"></div>
            <div id="testSpacets" class="topshadow"></div>
            <div id="countdownlayer" class="hid box-shadow"></div>
            <div id="countdownlayerbg" class="hid"></div>
        </div><br>
        <form onsubmit="return false">
            <input type="text" style="font-size: 150%" autocomplete="off" value="" id="testTypeValue"/>&nbsp;
            <button id="testStartGame" class="btn btn-primary">Start!</button>
        </form>
        <div><span id="testMsgDiv" class="veryLargeText">0</span> seconds</div>
    </div>
</div>
<br><br>
<a href="<?php echo base_url(); ?>">Back Home</a>
