var testRunObj;
function testTrack() {
    var txt;
    // check the track
    txt = $('#addPara').val();
    if(!txt) {
        alert("Track looks empty pal!");
        return false;
    }
    if(txt.length < 5 || txt.length > 1000) {
        alert("Track length should be more than 5 and less than 1000!");
        return false;
    }
    // if track is fine, then initiate the game Obj
    $.post(configObj.backendUrl+"/prepareForTesting", {
        'track' : txt
    }, function (b) {
        var a = JSON.parse(b);
        if (a.status == 1) {
            $('#testSpaceDiv').removeClass('hid');
            $('#testSpace').html(a.content);
            $('#testSpaceLength').text(a.length);
            if(testRunObj) testRunObj.endGame(true);
            else testRunObj = new gameClass('testSpace', 'testTypeValue', 'testMsgDiv', 'testStartGame', "testSpace", true);
        } else {
            //$("#scoreTable").html(a.content)
        }
    })
}