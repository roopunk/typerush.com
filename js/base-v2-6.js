/*
* Class to manage the track
*/
function textClass(b) {
    this.currWordIndex = 1;
    this.wordsLen = 1;
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
        return parseInt((this.currWordIndex - 1) / this.wordsLen * 100, 10)
    }
}

/*
    Just a timer class with
        a. option to set a max limit
        b. option to give a callback on every call
*/
function timerClass() {
    this.timer = null;
    this.timerVal = 0;
    this.callBack;
    this.limit = 1000;
    this.scopeObj;
    this.startTimer = function(scopeObj, callBack, limit) {
        var th = this;
        th.timerVal = 0;
        th.limit = parseInt(limit, 10) || 10000;
        th.callBack = callBack;
        th.scopeObj = scopeObj;
        th.timer = window.setInterval(function() {
            th.incrementTimer()
        }, 100)
    };
    this.endTimer = function() {
        clearInterval(this.timer)
    };
    this.incrementTimer = function() {
        var th = this;
        th.timerVal++;
        if (th.timerVal >= th.limit) {
            th.endTimer()
        }
        th.callBack.call(th.scopeObj, th.timerVal)
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
        if (i == this.countdown_limit) { // remove the grey bg layer and start the game
            $("#countdownlayerbg, #countdownlayer").addClass("hid");
            this.startGame()
        } else {
            $("#countdownlayerbg, #countdownlayer").removeClass("hid");
            $("#countdownlayer").text(parseInt((this.countdown_limit - i) / 10, 10) + 1)
        }
    };
    this.startGame = function() {
        var th = this;
        th.textObj.readPara();
        th.timerObj.startTimer(th, th.timerCallBack);

        // activate the text field
        $("#" + th.input_id).removeAttr("disabled").val("").focus();
        if ($("#" + th.button).length > 0) {
            $("#" + th.button).text("stop!")
        }

        th.handleScrollPosition();
        th.handleProgress();
        th.timeElapsed = 0;
        th.status = "on"
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
    this.handleInput = function(k) {
        var j = this.textObj.getWord(this.textObj.currWordIndex);
        var i = $("#" + this.input_id).val();
        i = i.trim();
        if (i == j && this.textObj.paraOver()) {
            this.endGame();
            return true;
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
                this.handleScrollPosition();
                this.handleProgress()
            }
        }
    };

    // manages the scroll position of the track
    this.handleScrollPosition = function() {
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
        e.handleInput(i)
    })
}

gameClass.prototype.handleProgress = function(complete) {
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

var ajaxObj = {
    submitScore : function(d) {
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
            var e = _parseJson(b);
            if (!e.s) {
                alert("something went wrong!");
                gameObj.showMessage("", false)
            } else {
                ajaxObj.updateScoreTable()
            }
            $("#messageDiv").hide().text("")
        });
        return false
    },
    updateScoreTable : function() {
        $("#messageDiv").text("updating score table..");
        $.get(configObj.backendUrl + "/fetchScore", function(c) {
            var d = _parseJson(c);
            if (d.status == 1) {
                $("#scoreTable").html(d.content)
            } else {
                $("#scoreTable").html(d.content)
            }
            $("#messageDiv").text("")
        })
    },
    markReady : function() {
        $.get(configObj.backendUrl + "/markReady", {
            room_id: roomData.room_id
        }, function(c) {
            var d = _parseJson(c);
            if (!d.s) {
                room_updateStatus(false)
            }
        }).fail(function() {
            room_updateStatus(false)
        })
    },
    updateProgress : function(b, c) {
        $.post(configObj.backendUrl + "/updateProgress", {
            progress: roomData.p,
            time: roomObj.timeElapsed,
            room_id: roomData.room_id
        }, function(d) {
            var e = _parseJson(d);
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

// parsing json
function _parseJson(str) {
    try {
        return JSON.parse(str);
    } catch(e) {
        alert("Something went wrong");
        return {};
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
});
