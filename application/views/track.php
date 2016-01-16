<?php
    if(isset($track)): ?>  
    <div id="right" class="box-shadow pagecolumn">
        <div id="paraMeta" class="paraMeta"> <div id="paraprogress" class="paraprogress"></div></div>
        <div class="" id="track">
            <div id="parawrapper" class="parawrapper p10">
                <div id="para" class="para"><?php echo $track['text']; ?></div>
                <div id="parabs" class="bottomshadow"></div>
                <div id="parats" class="topshadow"></div>
            </div><br>
                <div class="row p10">
                    <div class="col-md-9">
                        <form onsubmit="return false" class="wp100 frm">
                            <input type="text" class="wp100" style="font-size: 150%;" autocomplete="off" value="" disabled="disabled" id="typeValue"/>
                        </form>
                    </div>
                    <?php if(empty($room)): ?>
                    <div class="col-md-3">
                        <button id="gameHandle" class="btn btn-primary wp100" >Start!</button> 
                    </div>
                    <?php endif; ?>
                </div>
            <div id="countdownlayer" class="hid box-shadow"></div>
            <div id="countdownlayerbg" class="hid"></div>
        </div>
        <div class="p10" style="display:inline-block;width:50%;">
            <span class="smallText" >Word Length:</span> <?php echo $track['words']; ?><br>
            <?php if(!empty($track['about'])) : ?>
                <span class="smallText">About: </span><span> <?php echo $track['about']; ?></span>
            <?php endif; ?>
        </div>
        <div style="display:inline-block;width:40%;"><strong class="veryLargeText" id="timeDiv">0</strong> seconds</div>
        <?php if(empty($room)): ?>
            <hr><br>
            <div id="messageDiv"></div>
            <div id="scoreTable" class="p10"></div>
        <?php endif; ?>
        
	</div>

    <?php else: ?>
        <strong>Something went wrong!</strong>
    <?php endif; 
?>
