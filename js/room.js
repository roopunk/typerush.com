function roomClass(a, c, b, d, f, e) {
    gameClass.apply(this, [a, c, b, d, f, e])
}
roomClass.prototype = new gameClass();
roomClass.prototype.constructor = roomClass;
roomClass.prototype.endGame = function() {
    this.handleProgress(true);
    this.showTimeInMessage();
    this.textObj.resetText();
    $("#" + this.input_id).val("").attr("disabled", "disabled");
    this.timerObj.endTimer();
    this.status = "off"
};
roomClass.prototype.handleProgress = function(a) {
    var b;
    if (typeof a != "undefined" && a) {
        b = 100
    } else {
        b = this.textObj.getProgress()
    }
    $("#" + this.trackid + "progress").css("width", b + "%");
    roomData.p = b;
    ajaxObj.updateProgress(b)
};

function room_showPlayers() {
    var d = roomData.players,
        a, c = true,
        b = 0;
    $("#room_players").html("");
    for (i in d) {
        text = '<div class="largeText">' + d[i].username + ' (<span class="smallText">' + (d[i].time_taken / 10) + "s</span>) </div>";
        if (d[i].completed !== null) {
            text += '<div id="paraMeta_' + d[i].id + '" class="paraMeta"> <div id="paraprogress_' + d[i].id + '" class="paraprogress" style="width:' + d[i].completed + '%"></div></div>';
            if (d[i].username == roomData.username) {
                $("#readyToPlay").hide()
            }
            if (d[i].username == roomData.username && d[i].completed == "100") {
                c = false
            }
        } else {
            c = false
        }
        $("#room_players").append(text);
        b++
    }
    if (b > 1 && c && !roomObj) {
        $("#roomMsg").text("");
        roomObj = new roomClass("para", "typeValue", "timeDiv", "gameHandle", "para");
        roomObj.initGame()
    }
}

function room_updateStatus(a) {
    if (a) {
        $("#onlineStatus").html("<span class='label label-succcess' >online</span>")
    } else {
        $("#onlineStatus").html("<span class='label label-danger' >offline</span>")
    }
}

ajaxObj.longPollRoom = function() {
    $.get(configObj.backendUrl + "/roomPing", {
        room_id: roomData.room_id,
        mod: roomData.mod
    }, function(c) {
        var d = _parseJson(c);
        if (d.s) {
            if (d.d) {
                roomData.mod = d.mod;
                roomData.players = d.info;
                room_showPlayers();
                room_updateStatus(true)
            }
            ajaxObj.longPollRoom()
        } else {
            alert(d.d);
            room_updateStatus(false)
        }
    }).fail(function() {
        room_updateStatus(false)
    })
};

$(function() {
    ajaxObj.longPollRoom();
    $("#readyToPlay").click(function() {
        $(this).hide();
        $("#roomMsg").text("waiting for other players!");
        ajaxObj.markReady()
    })
});
