var textObj=new function(){this.wordsLen=0;this.currWordIndex=1;this.readPara=function(){textObj.resetText();textObj.wordsLen=$("#para span").length;textObj.highlightWord(textObj.currWordIndex)};this.highlightWord=function(a){$("#para span.green").removeClass("green");$("#para span:nth-child("+(parseInt(a))+")").addClass("green")};this.getWord=function(a){var b=$("#para span:nth-child("+(parseInt(a))+")").text();return b};this.nextWord=function(){if(textObj.currWordIndex<textObj.wordsLen){textObj.currWordIndex++;textObj.highlightWord(textObj.currWordIndex)}else{gameObj.endGame()}};this.resetText=function(){textObj.currWordIndex=1;$("#para span.green").removeClass("green");$("#para span.red").removeClass("red")};this.indicateWrong=function(a){a=typeof a!=="undefined"?a:false;if(a){$("#para span.green").addClass("red")}else{$("#para span.green").removeClass("red")}}};var typeObj=new function(){this.oldValue="";this.readInput=function(){typeObj.oldValue=$("#typeValue").val()};this.checkAgainstPara=function(b){var a=textObj.getWord(textObj.currWordIndex);if(b!=(a+" ").substr(0,b.length)){textObj.indicateWrong(true)}else{textObj.indicateWrong(false)}if(b==(a+" ")){$("#typeValue").val("");textObj.nextWord()}};this.checkChange=function(){var a=$("#typeValue").val();if(a!=typeObj.oldValue){typeObj.oldValue=a;typeObj.checkAgainstPara(a)}}};var timerObj=new function(){this.timer=0;this.timerVal=0;this.startTimer=function(){this.timerVal=0;$("#timeElapsed").text(this.timerVal/10);timerObj.timer=setInterval(function(){timerObj.incrementTimer()},100)};this.endTimer=function(){clearInterval(timerObj.timer);return timerObj.timerVal};this.incrementTimer=function(){this.timerVal++;$("#timeElapsed").text(this.timerVal/10)}};var gameObj=new function(){this.startGame=function(){textObj.readPara();typeObj.readInput();timerObj.startTimer();$("#wrongIndicator").hide();$("#startGame").hide();$("#endGame").show();$("#typeValue").removeAttr("disabled").val("").focus();$("#typeValue").bind("propertychange keyup input paste",typeObj.checkChange)};this.endGame=function(a){a=typeof a!=="undefined"?a:false;if(a){gameObj.showMessage("ok! :( ",true);$("#timeElapsed").text("0")}textObj.resetText();$("#typeValue").unbind().val("").attr("disabled","disabled");$("#wrongIndicator").hide();$("#startGame").show();$("#endGame").hide();if(!a){ajaxObj.submitScore(timerObj.endTimer());gameObj.showMessage("Time taken "+$("#timeElapsed").text()+". Submitting..",true)}else{timerObj.endTimer()}};this.showMessage=function(b,a){if(a===true){$("#message").hide().show().text(b)}else{if(a===false){$("#message").hide()}}}};var ajaxObj=new function(){this.hostUrl=mainObj.hostUrl;this.submitScore=function(a){if(!a){return false}var b=document.getElementById("nickname").value;if(!b){alert("You ain't got no mame?");return false}$("#msg").show().text("submitting score");$.post(ajaxObj.hostUrl+"models/submitTime.php",{blah:a,name:b},function(d){var c=JSON.parse(d);if(c.status=="0"){alert("something went wrong!");gameObj.showMessage("",false)}else{ajaxObj.updateScoreTable()}$("#msg").hide().text("")});return false};this.updateScoreTable=function(){gameObj.showMessage("updating score table..",true);$.post(ajaxObj.hostUrl+"models/fetchScore.php",function(b){var a=JSON.parse(b);if(a.status==1){$("#scoreTable").html(a.content)}else{$("#scoreTable").html(a.message)}gameObj.showMessage("",false)})}};$(function(){$("#startGame").bind("click",function(){gameObj.startGame()});$("#endGame").bind("click",function(){gameObj.endGame(true)});ajaxObj.updateScoreTable()});
