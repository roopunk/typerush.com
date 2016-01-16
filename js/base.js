function textClass(b) {
    this.wordsLen = 1;
    this.currWordIndex = 1;
    this.id = b;
    this.readPara = function() {
        var c = this.id;
        this.resetText();
        this.wordsLen = $("#" + c + " span").length;
        this.highlightWord(this.currWordIndex)
    };
    this.highlightWord = function(c) {
        var d = this.id;
        $("#" + d + " span.green").removeClass("green");
        $("#" + d + " span:nth-child(" + (parseInt(c)) + ")").addClass("green")
    };
    this.getWord = function(d) {
        var c = $("#" + this.id + " span:nth-child(" + (parseInt(d)) + ")").text();
        return c
    };
    this.nextWord = function() {
        if (this.currWordIndex < this.wordsLen) {
            this.currWordIndex++;
            this.highlightWord(this.currWordIndex);
            return true
        } else {
            return false
        }
    };
    this.paraOver = function() {
        return (this.currWordIndex >= this.wordsLen)
    };
    this.resetText = function() {
        this.currWordIndex = 1;
        $("#" + this.id + " span.green").removeClass("green");
        $("#" + this.id + " span.red").removeClass("red")
    };
    this.indicateWrong = function(c) {
        c = typeof c !== "undefined" ? c : false;
        if (c) {
            $("#" + this.id + " span.green").addClass("red")
        } else {
            $("#" + this.id + " span.green").removeClass("red")
        }
    };
    this.getProgress = function() {
        return parseInt((this.currWordIndex - 1) / this.wordsLen * 100)
    }
}

function timerClass() {
    this.timer = null;
    this.timerVal = 0;
    this.callBack;
    this.limit = 1000;
    this.scopeObj;
    this.startTimer = function(e, b, c) {
        var d = this;
        d.timerVal = 0;
        d.limit = parseInt(c, 10) || 10000;
        d.callBack = b;
        d.scopeObj = e;
        d.timer = window.setInterval(function() {
            d.incrementTimer()
        }, 100)
    };
    this.endTimer = function() {
        clearInterval(this.timer)
    };
    this.incrementTimer = function() {
        var b = this;
        b.timerVal++;
        if (b.timerVal >= b.limit) {
            b.endTimer()
        }
        b.callBack.call(b.scopeObj, b.timerVal)
    }
}

function gameClass(b, d, c, f, h, g) {
    this.timeElapsed = 0;
    this.timerObj = new timerClass();
    this.textObj = new textClass(b);
    this.input_id = d;
    this.msg_id = c;
    this.button = f;
    this.trackid = h;
    this.status = "off";
    this.no_submit = g || false;
    this.top_margin = 0;
    this.countdown_limit = parseInt(configObj.countdown_limit, 10) * 10;
    this.initGame = function() {
        // track completion of game
        _gtrack('game', 'start');

        this.timerObj.startTimer(this, this.countDownCallBack, this.countdown_limit)
    };
    this.countDownCallBack = function(i) {
        var j = this.countdown_limit - i;
        if (j == 0) {
            $("#countdownlayerbg, #countdownlayer").addClass("hid");
            this.startGame()
        } else {
            $("#countdownlayerbg, #countdownlayer").removeClass("hid");
            $("#countdownlayer").text(parseInt(j / 10, 10) + 1)
        }
    };
    this.startGame = function() {
        var i = this;
        i.textObj.readPara();
        i.timerObj.startTimer(i, i.timerCallBack);
        $("#" + i.input_id).removeAttr("disabled").val("").focus();
        if ($("#" + i.button).length > 0) {
            $("#" + i.button).text("stop!")
        }
        i.handlePositioning();
        i.handleProgress();
        i.timeElapsed = 0;
        i.status = "on"
    };
    this.showMessage = function(j, i) {
        if (j === true) {
            $("#" + this.msg_id).show();
            if (i) {
                $("#" + this.msg_id).html(i)
            }
        } else {
            if (j === false) {
                $("#" + this.msg_id).hide()
            }
        }
    };
    this.showTimeInMessage = function(i) {
        if (typeof i == "undefined") {
            i = this.timeElapsed / 10
        }
        this.showMessage(true, String(i))
    };
    this.timerCallBack = function(i) {
        this.timeElapsed = i;
        this.showTimeInMessage()
    };
    this.handleChange = function(k) {
        var j = this.textObj.getWord(this.textObj.currWordIndex);
        var i = $("#" + this.input_id).val();
        i = i.trim();
        if (this.textObj.paraOver() && i == j) {
            this.endGame();
            return
        }
        if (i != j.substr(0, i.length)) {
            this.textObj.indicateWrong(true)
        } else {
            this.textObj.indicateWrong(false)
        }
        if (typeof k != "undefined" && (k == 13 || k == 32)) {
            if (i == j) {
                $("#" + this.input_id).val("");
                this.textObj.nextWord();
                this.handlePositioning();
                this.handleProgress()
            }
        }
    };
    this.handlePositioning = function() {
        var k, i, j;
        if ($("#" + this.trackid).find("span.green").length > 0) {
            k = $("#" + this.trackid).find("span.green").position().top;
            i = $("#" + this.trackid).height() - k
        }
        if (k && k > 100 && i > 50) {
            j = parseInt(k - 100);
            if (j != this.top_margin) {
                $("#" + this.trackid).animate({
                    "margin-top": "-" + j + "px"
                }, 500);
                this.top_margin = j
            }
        } else {
            j = Math.abs(this.top_margin);
            if (typeof k != "undefined" && k < 100 && j != 0) {
                $("#" + this.trackid).animate({
                    "margin-top": "0px"
                });
                this.top_margin = 0;
                j = 0
            }
        }
        if (j + 200 < $("#" + this.trackid).height()) {
            $("#" + this.trackid + "bs").show()
        } else {
            $("#" + this.trackid + "bs").hide()
        }
        if (j > 0) {
            $("#" + this.trackid + "ts").show()
        } else {
            $("#" + this.trackid + "ts").hide()
        }
    };
    var e = this;
    if ($("#" + this.button).length > 0) {
        $("#" + this.button).text("start");
        $("#" + this.button).bind("click", function() {
            if (e.status == "off") {
                if (!e.no_submit && document.cookie.indexOf("tr_username") == -1) {
                    userObj.askUsername()
                }
                e.initGame()
            } else {
                e.endGame(true)
            }
        })
    }
    $("#" + this.input_id).val("").attr("disabled", "disabled");
    $("#" + this.input_id).bind("keyup keypress", function(j) {
        var i = j.which || j.charCode;
        e.handleChange(i)
    })
}

gameClass.prototype.handleProgress = function() {
    var b;
    if (typeof complete != "undefined" && complete) {
        b = 100
    } else {
        b = this.textObj.getProgress()
    }
    $("#" + this.trackid + "progress").css("width", b + "%")
};

/*
Function to end the game
Arguments : "b"
if b is true, the game was ended manually, as in the user did not complete the game
 */
gameClass.prototype.endGame = function(b) {
    var manual = (typeof b !== "undefined") ? b : false;
    this.showTimeInMessage();
    this.textObj.resetText();
    $("#" + this.input_id).val("").attr("disabled", "disabled");
    if ($("#" + this.button).length > 0) {
        $("#" + this.button).text("start!")
    }
    this.timerObj.endTimer();
    if (!manual && !this.no_submit) {
        ajaxObj.submitScore(this.timeElapsed);

        // track completion of game
        _gtrack('game', 'complete');
    }
    this.handleProgress(true);
    this.status = "off"

    // track end of game
    _gtrack('game', 'end');
};

var userObj = new function() {
    this.askUsername = function() {
        var username, t = $('#username'), oldText = t.text();
        if (username = prompt("Want to choose a username?", t.text())) {
            t.text(username);
        }
        setCookie('tr_username', t.text());

        // track changing if usernames
        if(oldText != username) {
            _gtrack('username', 'change')
        }
    }
};

var layerObj = new function() {
    this.show = function(b, f) {
        this.closeAll();
        var e = $("#" + f).position();
        var c = $("#" + f).width();
        var d = $('<div id="layerObj" class="box-shadow"></div>').html(b).appendTo("body").css("left", e.left + c).css("top", e.top)
    };
    this.closeAll = function() {
        $("#layerObj").remove()
    }
};

var ajaxObj = new function() {
    this.submitScore = function(d) {
        if (!d) {
            return false
        }
        var c = $("#username").text();
        if (!c) {
            alert("You ain't got no name?");
            return false
        }
        $("#messageDiv").show().text("submitting score");
        $.post(configObj.backendUrl + "/submitScore", {
            blah: d,
            name: c
        }, function(b) {
            var e = JSON.parse(b);
            if (!e.s) {
                alert("something went wrong!");
                gameObj.showMessage("", false)
            } else {
                ajaxObj.updateScoreTable()
            }
            $("#messageDiv").hide().text("")
        });
        return false
    };
    this.updateScoreTable = function() {
        $("#messageDiv").text("updating score table..");
        $.get(configObj.backendUrl + "/fetchScore", function(c) {
            var d = JSON.parse(c);
            if (d.status == 1) {
                $("#scoreTable").html(d.content)
            } else {
                $("#scoreTable").html(d.content)
            }
            $("#messageDiv").text("")
        })
    };
    this.longPollRoom = function() {
        $.get(configObj.backendUrl + "/roomPing", {
            room_id: roomData.room_id,
            mod: roomData.mod
        }, function(c) {
            var d = JSON.parse(c);
            if (d.s) {
                if (d.d) {
                    roomData.mod = d.mod;
                    roomData.players = d.info;
                    room_showPlayers();
                    room_updateStatus(true)
                }
                ajaxObj.longPollRoom()
            } else {
                room_updateStatus(false)
            }
        }).fail(function() {
            room_updateStatus(false)
        })
    };
    this.markReady = function() {
        $.get(configObj.backendUrl + "/markReady", {
            room_id: roomData.room_id
        }, function(c) {
            var d = JSON.parse(c);
            if (!d.s) {
                room_updateStatus(false)
            }
        }).fail(function() {
            room_updateStatus(false)
        })
    };
    this.updateProgress = function(b, c) {
        $.post(configObj.backendUrl + "/updateProgress", {
            progress: roomData.p,
            time: roomObj.timeElapsed,
            room_id: roomData.room_id
        }, function(d) {
            var e = JSON.parse(d);
            if (!e.s) {
                room_updateStatus(false)
            }
        }).fail(function() {
            room_updateStatus(false)
        })
    }
};

function setCookie(b, e, c) {
    var f = new Date();
    f.setDate(f.getDate() + c);
    var d = escape(e) + ((c == null) ? "" : "; expires=" + f.toUTCString());
    document.cookie = b + "=" + d
};

// tracking function
function _gtrack(category, action) {
    if(typeof ga == 'function') {
        ga('send', 'event', category, action)
    }
}

// global variables
var gameObj;

// on page load 
$(function() {
    $('#username').bind("click", function() {
        userObj.askUsername();
    });

    // event handlers
    $('.trackDiv').bind("click", function() {
        window.location = configObj.baseUrl + "?trackid=" + $(this).attr('trackid');
    });

    if( $('#track').length > 0 ) {
        gameObj = new gameClass("para", "typeValue", "timeDiv", "gameHandle", "para");
        ajaxObj.updateScoreTable()
    }
});