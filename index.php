<?php include_once $_SERVER['DOCUMENT_ROOT']."\\globaltrack.php" ?>

<?php session_start(); ?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-16">
    <meta name="description" content="Just a normal chat with no retarded ads and some nice features.">
    <title>Chat</title>
    <link rel="stylesheet" type="text/css" href="style.css?3"/>
    <link id="pageIcon" rel="shortcut icon" type="image/x-icon" href="icon.ico"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<!--
        This is a private chat, it was entirely written by me and it's not for sale.
        I didn't obfuscate the code because it's already unreadable enough and it probably has no uses for a commercial application.
        If you have questions then ask in chat or email thewhitewizard@interia.pl
                                                                            Enjoy
-->
<body style="background-size: fixed; background-repeat: no-repeat; height: 100%; margin: 0px;">
    <?php
    if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== false || strpos($_SERVER['HTTP_USER_AGENT'], "Trident/7.0") !== false){
        ?>
        <center>Internet explorer is not supported here. Get a real web browser.<br/><a href='/'>Return</a></center>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <div id='translateElement' style="text-align: center;"></div>
        <script type="text/javascript">
            function googleTranslateElementInit(){ new google.translate.TranslateElement({pageLanguage: 'auto'}, 'translateElement'); }
        </script>

        </body>
        </html>
        <?php
        exit;
    }

    @$con = new mysqli("localhost", "root", "", "asdfchat");
    if($con->connect_error){
        echo "<center>Failed to connect to the server database (it's probably off).<br/><a href='/'>Return</a></center></body></html>";
        exit;
    }
    ?>
    <center id="initialMsg">Connecting...</center>
</body>
</html>
<script>
    setTimeout(function(){
        var el = document.getElementById("initialMsg");
        if(el != null) el.innerHTML = "Error?";
    }, 15000);

    function isMobile(){
         if(navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)
         || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) return true;
         else return false;
    }

    //if(isMobile()) window.location.href = "/asdf10/mobile";
</script>
<script src="settingsClass.js"></script>
<script>
    var silentEnter = (window.location.href.indexOf("silent=1") != -1)?true:false;
    var windowTitle = document.title;
    var scrollOnFocus = false;
    var connectAttempts = 0;
    var isConnected = false;
    var init = true;
    var guestId = "", guestName = "", userName = <?php echo isset($_SESSION['username'])?"'{$_SESSION['username']}'":"''"; ?>;

    var lastMsgId = 0, lastMsgTime = 0, hasLoaded = false, isReconnecting = false, nextReconnectTime = 0;
    var sourcesLoaded = {"chat":false, "settings": false, "js":false}

    var $loginformWindow = null;
    var $newMessagesLine = null;
    var imageData = null;
    //event data
    var spooktober = <?php
        $data = file_get_contents("eventdata.txt");
        if(stripos($data, "spooktober=1") !== false) echo 'true';
        else echo 'false';
    ?>;
    //--cookies
    function SetCookie(cname, cvalue, exdays = 1000) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    function DeleteCookie(name){ document.cookie = name + "=;" + 1 + ";path=/"; }
    function GetCookie(cname){
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }
    //--settings
    var settings2 = new Settings();
    settings2.afterLoad = [];
    settings2.afterLoad.push(function(){
        if(settings2.get('msgContainerHeight') > 1) settings2.setDefault('msgContainerHeight');
        if(settings2.get('msgInputHeight') > 1) settings2.setDefault('msgInputHeight');
    });
    //name, type, settings element id, default value, apply method
    settings2.add("maxMessages", "str", "maxMsgSetting", "50", null);
    settings2.add("msgContainerHeight", "str", "chatHeightSetting", function(){
            this.val = 0.88;
            this.applyMethod();
        }, function(){
            $('#msgContainer').height($(window).height() * this.val) - $('table1').height();
            $('#userListContainer').height($(window).height() * this.val) - $('table1').height();
    });
    settings2.add("msgInputHeight", "str", "msgInputHeight", function(){
            this.val = 0.05;
            this.applyMethod();
        }, function(){
            return;
            $('#msgInput').height($(window).height() * this.val);
    });
    settings2.add("msgInputWidth", "str", "msgInputWidth", "100", function(){
            $('#msgInput').css("width", this.val+"%");
    });
    settings2.add("notifyOnNewMsg", "bool", "notifyOnNewMsg", "1", null);
    settings2.add("changeIconOnNewMsg", "bool", "changeIconOnNewMsg", "1", null);
    settings2.add("reverseMessages", "bool", "reverseMessages", "0", null);
    settings2.add("reverseMsgInputPosition", "bool", "reverseMsgInputPosition", "0", function(){
        $table = $('#table3');
        if(this.val == "1") $('#chatContainer').children().eq(1).insertAfter($table);
        else $('#chatContainer').append($table);
    });
    settings2.add("simpleChat", "bool", "simpleChat", "0", null);
    settings2.add("alwaysOnline", "bool", "alwaysOnline", "0", null);
    settings2.add("ignoreEvents", "bool", "ignoreEvents", "0", null);
    //bg
    settings2.add("background", "bool", "backgroundButton", "1", function(){
        if(this.val == "1"){
            $('body').css("background-image", "url('"+settings2.get("backgroundImage")+"')");
            $('#table2').css("background-color", settings2.get("backgroundColorImage"));
            $('#table3').css("background-color", settings2.get("backgroundColorImage"));
        }else{
            $('body').css("background-image", "none");
            $('body').css("background-color", settings2.get("backgroundColor"));
            $('#table2').css("background-color", "");
            $('#table3').css("background-color", "");
        }
    });
    settings2.add("backgroundImage", "str", "backgroundImage", "bg1.jpg", null);
    settings2.add("backgroundColor", "str", "backgroundColor", "#111111", null);
    settings2.add("backgroundColorImage", "str", "backgroundColorImage", "rgba(0.15, 0.15, 0.15, 0.9)", null);
    settings2.add("bottomBorder", "bool", "bottomBorder", "0", function(){
        if(this.val == "1") $('#table2').css("border-bottom", "2px solid gray");
        else $('#table2').css("border-bottom","none");
    });
    settings2.add("datePosition", "bool", "datePosition", "1", null);
    //msg
    settings2.add("avatarSize", "str", "avatarSize", "75", null);
    settings2.add("msgMargin", "str", "msgMargin", "0", null);
    settings2.add("senderFontSize", "str", "senderFontSize", "20", null);
    settings2.add("senderTextColor", "str", "senderTextColor", "#888888", null);
    settings2.add("dateFontSize", "str", "dateFontSize", "14", null);
    settings2.add("dateTextColor", "str", "dateTextColor", "#444444", null);
    settings2.add("msgFontSize", "str", "msgFontSize", "15", null);
    settings2.add("msgTextColor", "str", "msgTextColor", "lightgray", null);
    settings2.add("fixedMsgTextColor", "str", "fixedMsgTextColor", "", null);
    settings2.add("joinMessages", "bool", "joinMessages", "1", null);
    settings2.add("joinMessagesTime", "str", "joinMessagesTime", "60", null);
    settings2.add("msgBackground", "bool", "msgBackground", "0", null);
    settings2.add("msgTopBorder", "bool", "msgTopBorder", "1", null);
    settings2.add("msgStyle", "str", "msgStyle", "background-color: black; border: solid 1px gray; border-radius: 6px; padding: 3px; display:inline-block;", null);
    settings2.add("dateBelowSender", "bool", "dateBelowSender", "0", null);
    settings2.add("newMsgLineColor", "str", "newMsgLineColor", "rgb(230, 230, 230)", null);
    settings2.add("newMsgLineBorderColor", "str", "newMsgLineBorderColor", "blue", null);
    //image
    settings2.add("confirmImageUpload", "bool", "confirmImageUpload", "1", null);
    settings2.add("displayImages", "bool", "displayImages", "1", null);
    settings2.add("maxImageWidth", "str", "maxImageWidth", "500", null);
    settings2.add("maxImageHeight", "str", "maxImageHeight", "500", null);
    settings2.add("expandOnHover", "bool", "expandOnHover", "1", null);
    settings2.add("maxExpandWidth", "str", "maxExpandWidth", "1000", null);
    settings2.add("maxExpandHeight", "str", "maxExpandHeight", "1000", null);
    settings2.add("previewFiles", "bool", "previewFiles", "1", null);
    settings2.add("previewYTVideos", "bool", "previewYTVideos", "1", null);
    settings2.add("preloadVideos", "bool", "preloadVideos", "1", null);
    settings2.add("videoWidth", "str", "videoWidth", "500", null);
    settings2.add("videoHeight", "str", "videoHeight", "300", null);
    settings2.add("notificationSoundCooldown", "str", "notificationSoundCooldown", "60", null);
    settings2.add("userMsgColor", "str", "userMsgColor", "", null);
    settings2.add("fontType", "str", "fontType", "arial", function(){
        $('#chatContainer').css("font-family", this.val);
    });
    //sounds
    settings2.add("newMsgSound", "str", "newMsgSound", "newmsg.mp3", function(){
        if(this.val == "") return;
        if(typeof(messageSound) != 'undefined'){
            $(messageSound).attr('src', this.val);
            $(messageSound).load();
        }else console.log("Error setting new message sound from settings");
    });
    settings2.add("msgNotificationVolume", "str", "msgNotificationVolume", "80", function(){
        this.val = Math.min(Math.max(this.val, 0), 100);
        if(typeof(messageSound) != 'undefined') messageSound.volume = this.val/100;
        else console.log("Error setting volume for new message sound");
    });
    settings2.add("soundOnNewMsg", "bool", "soundOnNewMsg", "1", null);
    settings2.add("greetingSound", "bool", "greetingSound", "0", null);
    settings2.add("bindSounds", "bool", "bindSounds", "0", null);
    settings2.add("bindSoundVolume", "str", "bindSoundVolume", "75", null);
    settings2.add("alwaysPlaySoundMessagse", "bool", "alwaysPlaySoundMessagse", "0", null);
    //some other
    settings2.add("globalWithPM", "bool", "globalWithPM", "0", null);
    settings2.add("pmColor", "str", "pmColor", "#111155", null);
    settings2.add("pmInputColor", "str", "pmInputColor", "#121288", null);
    settings2.add("pmMsgBackground", "str", "pmMsgBackground", "rgba(30, 0, 80, 0.4)", null); // plz dont judge for the name
    settings2.add("userListNameColor", "str", "userListNameColor", "", null);
    settings2.add("userListBorderColor", "str", "userListBorderColor", "", null);
    settings2.add("messageDataBorderColor", "str", "messageDataBorderColor", "", null);

    settings2.add("messageInputStyle", "str", "messageInputStyle", "", function(){
        $('#msgInput').css('height', "100%");
        $('#msgInput').css('margin', "0px");
        if(this.val == "") return;
        $('#msgInput').attr("style", this.val);
        settings2.apply("msgInputWidth");
        if(pmTarget != null && pmTarget != ""){
            if($('#privInput').val().length > 0){
                $('#privInput').css('background-color', settings2.get('pmInputColor'));
                $('#msgInput').css('background-color', settings2.get('pmInputColor'));
            }else{
                $('#privInput').css('background-color', "");
                $('#msgInput').css('background-color', "");
            }
        }
    });
    settings2.afterLoad.push(function(){ setTimeout(function(){ settings2.apply("messageInputStyle"); }, 1000); });

    settings2.add("scrollBar", "str", "scrollBar", "", function(){ if(this.val != "") document.styleSheets[0].addRule("::-webkit-scrollbar", this.val); });
    settings2.add("scrollBarTrack", "str", "scrollBarTrack", "", function(){ if(this.val != "") document.styleSheets[0].addRule("::-webkit-scrollbar-track", this.val); });
    settings2.add("scrollBarThumb", "str", "scrollBarThumb", "", function(){ if(this.val != "") document.styleSheets[0].addRule("::-webkit-scrollbar-thumb", this.val); });
    settings2.add("scrollBarThumbHover", "str", "scrollBarThumbHover", "", function(){ if(this.val != "") document.styleSheets[0].addRule("::-webkit-scrollbar-thumb:hover", this.val); });

    settings2.add("scrollOnSend", "bool", "scrollOnSend", "1", null);
    settings2.add("userlistUpdateInterval", "str", "", "5", function(){
        if(!hasLoaded) return;
        clearInterval(updateUserListInterval);
        var newInterval = (this.val != 0)?this.val*1000:5000;
        updateUserListInterval = setInterval(UpdateUserList, newInterval);
    });
    //-USERLIST STYLES
    settings2.add("userlist_table", "str", "userlist_table", "width: 100%; text-align: center; cursor: pointer; margin-right: 0px;", null);
    settings2.add("userlist_userimage", "str", "userlist_userimage", "max-width: 100px; max-height: 100px; margin: 0px;", null);
    settings2.add("userlist_usertime", "str", "userlist_usertime", "font-size: 10px; height: 8px; line-height: 0px; padding-bottom: -1px;", null);
    settings2.add("userlist_username", "str", "userlist_username", "font-size: 13px; font-weight: bold; height: 8px; line-height: 8px; padding-top: 2px;", null);
    settings2.add("userlist_userimagecell", "str", "userlist_userimagecell", "border-bottom: 1px solid darkgreen; height: 8px; line-height: 8px;", null);
    //-
    settings2.afterLoad.push(function(){
        $('#userlistUpdateInterval').val(settings2.get("userlistUpdateInterval"));
        $('#userlistUpdateIntervalVal').html(settings2.get("userlistUpdateInterval")+"s");
        settings2.apply("userlistUpdateInterval");
    });
    //--connect
    function Connect(username, loadChat = true){
        console.log("Connecting...");
        isConnected = false;
        hasLoaded = false;
        $.ajax({
            url: 'jsRequest.php',
            data: {action: 'Connect', username: username, silent: silentEnter},
            type: 'post',
            dataType: 'json',
            timeout: 15000,
            success: function(output){
                if(output[2] != ""){
                    console.log("Failed to connect: "+output[2]);
                    console.log(output);
                    $('body').html("<center>Error connecting to the chat. Try again by refreshing the page or <a href='/'>click here to return</a></center>");
                }else if(output[0] == "" && output[1] == ""){
                    console.log("Server replied with empty user name");
                    $('body').html("<center>There seems to be some problem with the server, try connecting again later.<br/><a href='/'>Return</a></center>");
                }else{
                    console.log(" Connected as "+output[0]+output[1]);
                    guestId = output[0];
                    guestName = output[1];
                    if(guestId != "") SetCookie("guestname", guestName);
                    isConnected = true;
                    if(loadChat){
                        lastMsgId = 0;
                        $('body').html("<center>Connected, loading the chat...</center>");
                        $('body').load('chat.php', function(){ $.getScript("js.js"); $.get('settings.php', function(data){ $('body').append(data); }); });
                    }
                    if(!init && typeof(AutoLogin) == "function") AutoLogin();
                    init = false;
                    if($('#connectionLost').length > 0) $('#connectionLost').hide();
                }
            },
            error: function(xhr, status, err){
                connectAttempts++;
                if(connectAttempts > 3 && !isReconnecting){
                    if($('#connectionLost').length == 0){
                        $radioWindow = $('#radioDivContainer');
                        $radioWindow.css('z-index', 50);
                        var el = document.createElement('div');
                        var elText = document.createElement('div');
                        el.id = 'connectionLost';
                        el.style = "position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.85); z-index: 49;";
                        elText.id = "connectionLostText";
                        elText.style = "text-align: center; font-size: 26px; margin: 0 auto;";
                        elText.innerHTML = "Disconnected";
                        el.appendChild(elText);
                        $('body').append(el);
                    }else{
                        $('#connectionLost').show();
                        $('#connectionLostText').html("Disconnected");
                    }
                    var d = new Date();
                    nextReconnectTime = d.getTime() + 17*1000;
                    setTimeout(ReconnectUpdate, 1500, username);
                    isReconnecting = true;

                    isConnected = false;
                    return;
                }
                if(init) $('body').html("<center>Connecting... ("+connectAttempts+")");
                console.log("Failed to connect, retrying in 5s");
                if(xhr.responseText != "") console.log(xhr);
                setTimeout(function(){Connect(username); }, 5000);
            }
        });
    }

    function ReconnectUpdate(username){
        var d = new Date();
        if(d.getTime() >= nextReconnectTime){
            isReconnecting = false;
            Connect(username, false);
        }else{
            var s = Math.floor((nextReconnectTime - d.getTime()) / 1000);
            $('#connectionLostText').html("Attempting to reconnect in " + s + "s...<br/><a href='/'>Main page</a>");
            setTimeout(ReconnectUpdate, 1000, username);
        }
    }

    $(document).ready(function(){
            if(!silentEnter) Connect(GetCookie("guestname"));
            else Connect();
    });
    /*$(window).on('error', function(error, url, line, column){
        if(error.originalEvent.error !== null){
            var msg = error.originalEvent.error.toString();
            if(msg.indexOf("ERR_CONNECTION_RESET") != -1) alert("There seems to be a connection error, try reloading the page and let me know it happened");
        }
    });*/
    $(window).focus(function(){
        document.title = windowTitle;
        if($newMessagesLine != null) setTimeout(function(){ if($newMessagesLine != null){ $('#newMessagesLine').remove(); $newMessagesLine = null; }}, 15000);
        soundNotificationCooldown = 0;
        setTimeout(function(){ $('#pageIcon').attr('href', 'icon.ico');}, 500);
        if(scrollOnFocus){
            ScrollChat();
            scrollOnFocus = false;
        }
    });
</script>
