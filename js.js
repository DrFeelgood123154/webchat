var HasWEBPSupport = false;
///webp support check
var elem = document.createElement('canvas');
if(!!(elem.getContext && elem.getContext('2d'))) HasWEBPSupport = elem.toDataURL('image/webp').indexOf('data:image/webp') == 0;
else console.log("That's a very outdated browser");
if(!HasWEBPSupport) console.warn("Warning: user's web browser doesn't support WEBP format. Some images may not display correctly.");

isConnected = true;
var messageSound = new Audio("newmsg3.wav?1");
messageSound.volume = 0.8;

var pmTarget = "";
///Helpers
///why didn't I create this function earlier?
function ScrollChat(){ if(settings2.get("reverseMessages") != "1") $msgContainer.scrollTop($msgContainer[0].scrollHeight); else $msgContainer.scrollTop(0); }
function IsChatAtBottom(){ return $msgContainer.scrollTop() + $msgContainer.innerHeight() >= $msgContainer[0].scrollHeight-30 || !hasLoaded; }
function IsChatAtTop(){ return $msgContainer.scrollTop() <= 20 }

///Main
var updateLock = false, updateAttempts = 0;
var soundNotificationCooldown = 0;
var lastActive = Date.now(), lastPokeTime = 0;
///is this even used?
function Update(){
    if(!isConnected || updateLock) return;
    updateLock = true;
    var tBegin = Date.now();
    $.ajax({
        url: 'jsRequest.php',
        data: {action: 'Update'},
        type: 'post',
        timeout: 10000,
        success: function(output){
            updateLock = false;
            if(output == 0){
                latency = Math.floor((Date.now() - tBegin)/2);
                $('#latency').html(latency+"ms");
                updateAttempts = 0;
            }else{
                lastMsgId = 0;
                console.log("Update error: "+output);
                $('#latency').html("-");
                if(output == 1) Connect(guestName, false);
                if(output == 2){
                    Connect(guestName, false);
                    updateAttempts++;
                }
            }
        },
        error: function(xhr, status, err){
            updateLock = false;
            if(err != "") console.log(err);
            $('#latency').html("-");
            //Connect(guestName, false);
        }
    });
}
var updateUserListLock = false;
function UpdateUserList(){
    if(!isConnected || updateUserListLock) return;
    updateUserListLock = true;
    $.ajax({
        url: 'jsRequest.php',
        data: {action: 'UpdateUserList'},
        type: 'post',
        timeout: 30000,
        dataType: 'json',
        success: function(output){
            updateUserListLock = false;
            _UpdateUserList(output);
        },
        error: function(xhr, status, err){
            if(xhr.responseText == "You're banned"){
                for(var i = 0; i < 1000; i++) clearInterval(i);
                var msg = document.createElement("div");
                msg.setAttribute("style", "z-index: 10; width: 100%; height: 100%; position: fixed; font-size: 40px; top: 0px; left: 0px; background-color: rgba(0, 0, 0, 0.5); color: white; text-align: center;")
                msg.innerHTML = "You have been banned";
                $(msg).appendTo('body');
                return;
            }
            if(xhr.responseText != "") console.log(xhr);
            Connect(guestName, false);
            updateUserListLock = false;
        }
    });
}

var updateMessagesLock = false;
var latencyTrack = [];
var latencyUpdate = 0;
var _reloadMessages = false;
var _playSoundNotification = true;
function UpdateMessages(){
    if(!isConnected || updateMessagesLock) return;
    updateMessagesLock = true;
    var $msgContainer = $('#msgContainer');
    var tBegin = 0;
    var status = 0;
    var soundMessagesStatus = (settings2.get("bindSounds") == "1" && !muteAllSounds)?"1":"0";
    if(settings2.get("alwaysOnline") == "0"){
        if(Date.now() - lastActive >= 2*60*60*1000) status = 2; ///snooze
        else if(Date.now() - lastActive >= 5*60*1000) status = 1; ///afk
    }
    $.ajax({
        url: 'jsRequest.php',
        data: {action: 'UpdateMessages', lastMsgId: lastMsgId, limit: settings2.get("maxMessages"), status: status, soundMessagesStatus: soundMessagesStatus},
        type: 'post',
        dataType: 'json',
        timeout: 30000,
        beforeSend: function(){ tBegin = Date.now(); },
        success: function(output){
            _playSoundNotification = true;
            if(output[0] == 0){
                latency = Math.floor(Date.now() - tBegin) / 2;
                latencyTrack.unshift(latency);
                latencyTrack = latencyTrack.splice(0, 5);
                latencyUpdate++;
                if(latencyUpdate >= 3){
                    latency = 0;
                    for(var i = 0; i<latencyTrack.length; i++) latency += parseInt(latencyTrack[i]);
                    latency = Math.floor(latency / latencyTrack.length);
                    latencyUpdate = 0;
                    $('#latency').html(latency+"ms");
                }
                updateAttempts = 0;

                if(output[1] == ""){
                    updateMessagesLock = false;
                    return;
                }

                var isBottom = IsChatAtBottom();
                if((document.hidden || !window.document.hasFocus()) && hasLoaded){
                    if(settings2.get("notifyOnNewMsg") == "1") document.title = "!"+windowTitle;
                    if(settings2.get("changeIconOnNewMsg") == "1") $('#pageIcon').attr("href", "icon_newmsg.ico");
                    if(isBottom) scrollOnFocus = true;
                }

                lastMsgId = output[1][0][0];
                output[1].reverse();

                _UpdateMessages(output[1]);
                ///sound
                if(_playSoundNotification && (document.hidden || !window.document.hasFocus()) && hasLoaded){
                    if(settings2.get("soundOnNewMsg") == "1" && Date.now()/1000 > soundNotificationCooldown && !muteAllSounds){
                        messageSound.play();
                        soundNotificationCooldown = (Date.now()/1000)+parseInt(settings2.get("notificationSoundCooldown"));
                    }
                }

                var msgsOverLimit = $msgContainer.children().length - settings2.get("maxMessages");
                if($newMessagesLine != null) msgsOverLimit--;
                if(msgsOverLimit>0){
                    if(settings2.get("reverseMessages") != "1") for(var i = msgsOverLimit; i>0; i--) $msgContainer.children()[i-1].remove();
                    else for(var i = 0; i<msgsOverLimit; i++) $msgContainer.children()[$msgContainer.children().length-1].remove();
                }
                if(isBottom && settings2.get("reverseMessages") != "1") setTimeout(function(){ ScrollChat(); }, 10);
                if(!hasLoaded) setTimeout(function(){ ScrollChat(); }, 1500);
                updateMessagesLock = false;
                hasLoaded = true;
                ignoreEvents = false;
                if(_reloadMessages){
                    ReloadMessages();
                    _reloadMessages = false;
                }
            }else{
                lastMsgId = 0;
                console.log("Update error: "+output[0]);
                $('#latency').html("-");
                if(output[0] == '1') Connect(guestName, false);
                if(output[0] == '2'){
                    Connect(guestName, false);
                    updateAttempts++;
                }
                updateMessagesLock = false;
            }
        },
        error: function(xhr, status, err){
            if(xhr.responseText != "") console.log(xhr);
            updateMessagesLock = false;
            $('#latency').html("-");
        }
    });
}

function OnPaste(event) {
    //if(userName == "") return;
    var items = (event.clipboardData || event.originalEvent.clipboardData).items;
    for(var i = 0; i < items.length; i++){
        if(items[i].kind === 'file'){
            imageData = items[i].getAsFile();
            if(imageData.size > 10000000){ /// 10mb
                $('#imgUploadProgressWindow').show();
                $('#imgUploadProgressWindowContent').html("Cannot send images larger than 10mb");
                imgUploadProgressWindowTimeout = setTimeout(function(){ $('#imgUploadProgressWindow').hide(); }, 3000);
                return;
            }
            var fr = new FileReader();
            fr.onload = function(event2){
                $('#imgUploadPreview').attr('src', event2.target.result);
            };
            fr.readAsDataURL(imageData);
            if(settings2.get("confirmImageUpload") == "1"){
                $('#imgUploadWindow').show();
                $('#imgUploadWindowConfirm').focus();
            }else{
                UploadImage();
                break;
            }
        }
    }
}

var imageUploadXhr;
function UploadImage(){
    if(imageData == null) return;
    $('#imgUploadProgressWindow').show();
    $('#imgUploadProgressWindowContent').html("Uploading image...");

    var data = new FormData();
    data.append('image', imageData);
    data.append("pmTarget", pmTarget);
    $.ajaxSetup({
        async: true
    });
    $.ajax({
        url: 'imageUpload.php',
        type: 'POST',
        timeout: 60*1000,
        data: data,
        async: true,
        xhr: function(){
                imageUploadXhr = $.ajaxSettings.xhr();
                imageUploadXhr.upload.onprogress = function(e){
                    var p = Math.floor((e.loaded / e.total)*100);
                    if(p < 100)$('#imgUploadProgressWindowContent').html("Uploading image: "+p+"%");
                    else{
                        $('#imgUploadProgressWindowContent').html("Image uploaded");
                        setTimeout(function(){ $('#imgUploadProgressWindow').hide(); }, 1000);
                    }
                };
                imageUploadXhr.upload.onerror = function(e){
                    console.log("Error uploading image: ");
                    console.log(e);
                }
                imageUploadXhr.upload.onabort = function(e){
                    console.log("File aborted");
                    console.log(e);
                }
                return imageUploadXhr;
        },
        cache: false,
        contentType: false,
        processData: false,
        paramName: 'files[]',
        success: function(response){
            if(response != ""){
                console.log(response);
                $('#imgUploadProgressWindow').show();
                $('#imgUploadProgressWindowContent').html(response);
                $('#msgInput').focus();
                imgUploadProgressWindowTimeout = setTimeout(function(){ $('#imgUploadProgressWindow').hide(); }, 5000);
            }
        },
        error: function(err){
            console.log("Error uploading image: ");
            console.log(err);
        }
    });
}
function linkify(text){
    if(text){
        text = text.replace(/(((https?\:\/\/)|(www\.))([-\w]+\.[-\w\.\#]+)+\w(:\d+)?(\/([\:\&\?\+-\w/_\.\,\=\#;%!$@*~\(\)]*(\?\S[|\s]+)?)?)*)+/gi,
            function(url){
                var full_url = url;
                if(!full_url.match('^https?:\/\/')) full_url = 'http://' + full_url;
                return '<a href="' + full_url + '" target="_blank">' + url + '</a>';
            }
        );
    }
    return text;
}
function DefaultImage(target){
    if(target.src.match(/.webp$/) && !HasWEBPSupport) target.setAttribute('title', "Your web browser doesn't support WEBP image format");
    target.setAttribute('src', 'noimg.png?'); target.setAttribute('onError', '');
}
///events
$('#renameInput').focusout(function(){
    var val = $('#renameInput').val();
    if(val == guestName) return;
    $.ajax({
        url: 'jsRequest.php',
        data: {action: 'Rename', newname: val},
        type: 'post',
        dataType: 'json',
        timeout: 30000,
        success: function(output){
            if(output['errorCode'] == 0){
                guestId = output[0];
                guestName = output[1];
                if(guestId != "") SetCookie("guestname", guestName);
                UpdateUsername();
            }else{
                ///display some error i guess
                console.log("Error changing name: "+output['errorCode']+"/"+output['error']);
            }
        },
        error: function(xhr, status, err){ console.log(err); }
    });
});
$('#userMsgColor').focusout(function(){
    settings2.set("userMsgColor", $(this).val());
    settings2.save();
});

var messageQueue = [];
var sendMsgLock = false;
function SubmitMessages(){
    if(sendMsgLock == true) return;
    var msgList = messageQueue.slice();

    messageQueue.length = 0;
    sendMsgLock = true;
    $.ajax({
        url: 'jsRequest.php',
        data: {action: 'SendMessage', msg: msgList},
        type: 'post',
        timeout: 30000,
        success: function(output){
            sendMsgLock = false;
            UpdateMessages();
            if(messageQueue.length > 0) SubmitMessages();
            if(output.trim() != "") console.log(output);
        },
        error: function(xhr, status, err){
            sendMsgLock = false;
            console.log(err);
        }
    });
}
function SendMessage(){
    var msg = $('#msgInput').val();
    $('#msgInput').val('');
    if(msg.length == 0 || msg.trim() == '') return;

    ///local chat commands
    if(msg == "/sstop"){
        $('audio').each(function(index){ if($(this).attr("class") == "bindsound") $(this).remove(); });
        return;
    }
    if(msg == "/motd"){
        GetMOTD(true);
        return;
    }
    ///submit msg
    var msgColor = $('#userMsgColor').val();
    if(msgColor) msgColor = msgColor.substring(0, 15);
    msgTarget = $('#privInput').val();
    if(msgTarget != "" && userName == "") return;
    messageQueue.push([msg, msgColor, msgTarget]);
    SubmitMessages();
    if(settings2.get("scrollOnSend") == "1") ScrollChat();
}
$('#msgInput').keydown(function(e){
    if(!isConnected) return;
    if(e.keyCode == 13 && !e.shiftKey){
        e.preventDefault();
        SendMessage();
    }
});

function GetMOTD(reportEmpty = false){
    $.get('motd.txt?'+Math.floor(Math.random()*1000), function(data){
        data = data.replace(/\&amp\;quot\;/gi, '"');
        ///popup window code
        /*if(data.length > 1){
            $old = $('#motdcontainer');
            if($old.length > 0) $old.remove();
            var isBottom = $msgContainer.scrollTop() + $msgContainer.innerHeight() >= $msgContainer[0].scrollHeight-30 || !hasLoaded;
            var msg = document.createElement('div');
            msg.setAttribute('style', 'z-index: 99; position: absolute; top: 0px; right: 0px; min-width: 100px; max-width: 400px; margin-bottom: 5px; width: 200px%; border: 2px outset silver; background-color: rgba(0, 20, 0, 25); text-align: center;');
            msg.id = "motdcontainer";

            var msgRemoveButton = document.createElement('button');
            msgRemoveButton.style = "position: absolute; top: 0px; right: 0px; background: none; border: none; width: 25px; height: 25px; color:red; font-weight: bold; font-size: 22px;";
            msgRemoveButton.innerHTML = "X";
            msgRemoveButton.onclick = function(){ $('#motdcontainer').remove(); };
            msgRemoveButton.title = "Close message";

            var msgContent = document.createElement('div');
            msgContent.setAttribute('style', 'padding: 5px; padding-left: 10px; padding-right: 10px;');
            data = data.replace(/\&lt;\/br\&gt;/gi, "</br>");
            $(msgContent).html(linkify(data));

            msg.appendChild(msgContent);
            msg.appendChild(msgRemoveButton);
            $('#msgContainer').append(msg);
            if(isBottom && settings2.get("reverseMessages") != "1") $msgContainer.scrollTop($msgContainer[0].scrollHeight);
        }else if(reportEmpty){
            $old = $('#motdcontainer');
            if($old.length > 0) $old.remove();
            var isBottom = $msgContainer.scrollTop() + $msgContainer.innerHeight() >= $msgContainer[0].scrollHeight-30 || !hasLoaded;
            var msg = document.createElement('div');
            msg.setAttribute('style', 'z-index: 99; position: absolute; top: 0px; right: 0px; min-width: 100px; max-width: 400px; margin-bottom: 5px; width: 200px%; border: 2px outset silver; background-color: rgba(0, 20, 0, 25); text-align: center;');
            msg.id = "motdcontainer";var msgRemoveButton = document.createElement('button');
            msgRemoveButton.style = "position: absolute; top: 0px; right: 0px; background: none; border: none; width: 25px; height: 25px; color:red; font-weight: bold; font-size: 22px;";
            msgRemoveButton.innerHTML = "X";
            msgRemoveButton.onclick = function(){ $('#motdcontainer').remove(); };
            msgRemoveButton.title = "Close message";

            var msgContent = document.createElement('div');
            msgContent.setAttribute('style', 'padding: 5px; padding-left: 10px; padding-right: 10px;');
            data = data.replace(/\&lt;\/br\&gt;/gi, "</br>");
            $(msgContent).html(linkify(data));

            msg.appendChild(msgContent);
            msg.appendChild(msgRemoveButton);
            $('#msgContainer').append(msg);
            if(isBottom && settings2.get("reverseMessages") != "1") $msgContainer.scrollTop($msgContainer[0].scrollHeight);
        }*/
        ///add as new message
        var msgDiv = document.createElement("div");
        $(msgDiv).attr("class", "chatmsg");
        $(msgDiv).attr("style", "margin: 0 auto; width: 85%; padding-left: 5%; padding-right: 5%; border-top: 1px outset gray; border-bottom: 1px outset gray;");
        msgDiv.innerHTML = data;

        if(settings2.get("reverseMessages") == "1") $('#msgContainer').prepend(msgDiv);
        else $('#msgContainer').append(msgDiv);
        ScrollChat();
    }, 'text');
}

function TogglePM(newTarget){
    ///if(newTarget == "") $('#userListContainer').children().each(function(){ if($(this).attr('user') == pmTarget) $(this).css('background-color', ''); });
    $('#userListContainer').children().each(function(){ $(this).css('background-color', ''); });
    pmTarget = newTarget;
    if(pmTarget != ""){
        if(settings2.get('globalWithPM') == "0"){
            $('#msgContainer').children().each(function(){
                $(this).hide();
                if(($(this).attr('sender') == pmTarget && $(this).attr('pm') == userName)
                   || ($(this).attr('pm') == pmTarget && $(this).attr('sender') == userName)
                    || ($(this).attr('pm') == "" && settings2.get("globalWithPM") == "1")) $(this).show();
            });
        }
        $('#userListContainer').children().each(function(){ if($(this).attr('user') == pmTarget) $(this).css('background-color', settings2.get('pmInputColor')); });
    }else $('#msgContainer').children().each(function(){ $(this).show(); });
    ScrollChat();
    OnResize();
}
///on resize
function OnResize(){
    settings2.apply('msgContainerHeight');
    /*var elementBottom = $('#msgInput').offset().top + $('#msgInput').outerHeight();
    var viewportBottom = $(window).scrollTop() + $(window).height();
    if(!(elementBottom > $(window).scrollTop() && $('#msgInput').offset().top < viewportBottom)){*/
        var wHeight = $(window).height() - $('#table3').height() - $('#table1').height();
        $('#msgContainer').height(wHeight);
        $('#userListContainer').height(wHeight);
    //}

    var box = $('#table2_msgData');
    var diff = 175 - $(box).width();
    //if(diff > 0) {
        $(box).width(175);
        $('#table2_msgInput').width($(window).width() - 175);
        //$('#msgInput').css('height', $(box).height()-4+"px");
    /*}else{
        $(box).width("175px");
        $('#table2_msgInput').width($(window).width() - 175);
    }*/

}
$(window).on('resize', function(){ OnResize(); });
$(window).on("focus", function(){ $('#msgInput').focus(); });
setTimeout(function(){ OnResize(); }, 1000);

///on scroll
$('#msgContainer').on("scroll", function(){
    if(settings2.get("reverseMessages") == "0"){
        if(!IsChatAtBottom()){
            $('#scrollToBottom').css('display', 'flex');
            $('#scrollToBottom').css({"bottom":"10px", "top":"default"});
            $('#scrollToBottom_text').html("&#8681 Scroll to bottom &#8681");
        }else $('#scrollToBottom').hide();
    }else{
        if(!IsChatAtTop()){
            $('#scrollToBottom').css('display', 'flex');
            $('#scrollToBottom').css({"bottom":"default", "top":"10px"});
            $('#scrollToBottom_text').html("&#8679 Scroll to top &#8679");
        }else $('#scrollToBottom').hide();
    }
});
///on load
UpdateUsername();
///var updateInterval = setInterval(Update, 10000);
if(!updateUserListInterval) var updateUserListInterval = setInterval(UpdateUserList, 5000);
if(!updateMessagesInterval) var updateMessagesInterval = setInterval(UpdateMessages, 500);
UpdateUserList();
$('#msgInput').on("paste", OnPaste);
setTimeout(function(){ GetMOTD(); }, 1000);

setTimeout(function(){ if(settings2.get("reverseMessages") != "1") $msgContainer.scrollTop($msgContainer.outerHeight(true)*10); }, 500);
///on unload
/*
window.onbeforeunload = function(){
    $.ajax({
        url: 'jsRequest.php',
        data: {action: 'UserDisconnect'},
        type: 'post'
    });
}*/


sourcesLoaded['js'] = true;
if(typeof(LoadSettings) == "function") LoadSettings();

///QUICKFIX
setTimeout(function(){
    if($msgContainer.children().length < 3){
        lastMsgId = 0;
        UpdateMessages();
    }
}, 5000);
