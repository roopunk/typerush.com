<?php if(isset($data['track']) && $data['track']): ?>  

		<hr>
        <p> Word Length: <?php echo $data['track']['words']; ?></p>
        <p id="para" style="font-size:20pt"><?php echo $data['track']['text']; ?></p>
        <form onsubmit="return false">
            <input type="text" style="font-size: 150%" disabled="disabled" autocomplete="off" value="" id="typeValue"/>&nbsp;<span id="timeElapsed" style="font-size:200%">0</span> seconds
        <span id="wrongIndicator" style="display:none"><strong>wrong</wrong></span>
        </form>
        <br/><br>
        <button id="startGame">lets race!</button>
        <button id="endGame" style="display:none">give up</button>
        <span id="message" style="display:none;font-weight:bold"></span>
        <br><br>
        <form onsubmit="return false;" id="scoreForm">
            <span id="msg" style="display: none"></span>
        </form>
        <hr>
        <div id="scoreTable"></div>
<?php else: ?>
		<strong>Something went wrong!</strong>
<?php endif; ?>

