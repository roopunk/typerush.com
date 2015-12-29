@extends('layouts.main')

@section('content')
<?php
    if(isset($track)): ?>  
    <div id="right" class="box-shadow pagecolumn">
        <div id="paraMeta" class="paraMeta"> <div id="paraprogress" class="paraprogress"></div></div>
        <div class="p10" id="track">
            <div id="parawrapper" class="parawrapper">
                <div id="para" class="para"><?php echo $track['text']; ?></div>
                <div id="parabs" class="bottomshadow"></div>
                <div id="parats" class="topshadow"></div>
            </div><br>
                <form onsubmit="return false" style="width:400px;display:inline-block">
                    <input type="text" style="font-size: 150%;width:350px" autocomplete="off" value="" disabled="disabled" id="typeValue"/>
                </form>
                <?php if(empty($room)): ?>
                <button id="gameHandle" class="large-button">Start!</button> 
                <?php endif; ?>
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

<script type="text/javascript">
$(function() {
    <?php if(empty($room)): ?>
        var gameObj = new gameClass("para", "typeValue", "timeDiv", "gameHandle", "para");
        ajaxObj.updateScoreTable()

        // event handlers
        $('.trackDiv').bind("click", function() {
            window.location = configObj.baseUrl + "?trackid=" + $(this).attr('trackid');
        });
        $('#username').bind("click", function() {
            var username;
            if (username = prompt("Want to choose a username?", $('#username').text())) {
                $(this).html(username);
            } else {
                setCookie('tr_username', $('#username').text());
            }
        });
    <?php endif; ?>
});
</script>

@endsection