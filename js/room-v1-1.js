function roomClass(h,m,g,l,j,k){gameClass.apply(this,[h,m,g,l,j,k])}roomClass.prototype=new gameClass();roomClass.prototype.constructor=roomClass;roomClass.prototype.endGame=function(){this.handleProgress(true);this.showTimeInMessage();this.textObj.resetText();console.log("ending");$("#"+this.input_id).val("").attr("disabled","disabled");this.timerObj.endTimer();this.status="off"};roomClass.prototype.handleProgress=function(d){var c;if(typeof d!="undefined"&&d){c=100}else{c=this.textObj.getProgress()}$("#"+this.trackid+"progress").css("width",c+"%");roomData.p=c;ajaxObj.updateProgress(c)};function room_showPlayers(){var g=roomData.players,f,h=true,e=0;$("#room_players").html("");for(i in g){text='<div class="largeText">'+g[i].username+' (<span class="smallText">'+(g[i].time_taken/10)+"s</span>) </div>";if(g[i].completed!==null){text+='<div id="paraMeta_'+g[i].id+'" class="paraMeta"> <div id="paraprogress_'+g[i].id+'" class="paraprogress" style="width:'+g[i].completed+'%"></div></div>';if(g[i].username==roomData.username){$("#readyToPlay").hide()}if(g[i].username==roomData.username&&g[i].completed=="100"){h=false}}else{h=false}$("#room_players").append(text);e++}if(e>1&&h&&!roomObj){$("#roomMsg").text("");roomObj=new roomClass("para","typeValue","timeDiv","gameHandle","para");roomObj.initGame()}}function room_updateStatus(b){if(b){$("#onlineStatus").html("<span class='label label-succcess' >online</span>")}else{$("#onlineStatus").html("<span class='label label-danger' >offline</span>")}}$(function(){ajaxObj.longPollRoom();$("#readyToPlay").click(function(){$(this).hide();$("#roomMsg").text("waiting for other players!");ajaxObj.markReady()})});