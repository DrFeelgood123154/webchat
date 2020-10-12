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
                                                                       N7ZO=++$$+I                                         ..DI???I77Z
                                                                       77~O~7IZ$?~7                                      ~$++++?7$$D
 $N888++                                                               $77$DOOD7??                                   ?D7+++?+?I$ZD$..
      7MN8OZOD=I                                                        :I+D8D7+Z                                 +$+==+???I7ZO??77$I
           ?IDDDD88OOI=                                                  O8D8N7+:                               ?+===+++?7II+II77$8
                +NDDDD88OOZD~                                            OZN8DZ+~                             ~I+==+=~====+=I7$O8OD
                   N8D88888888ZOO                                        DI?7+??                           Z7+~:,.,,:+:~=+?$$I77$:,
                     D88D8DD88D8DD8$Z                                    DI88ZI?                         O~~::...,:~+++??I7I7$$D
                       8888D8888D8D888$O                                  8N8OZD                       D==~:::.:,==~~+==?II$ZO
                        IOO88888D8D888888OZ,                              I78Z7D                      ?=:,..,:==,:=++???7$7$77Z
                          $$$ZZZOO88888O8888$O?                           $7O7I8                    D+,,,..~+~::~+??7?I?++I$$8
                          :$ZZZZZ$$7$ZZOOOOO8887+                         $77?$8                  :I~..,,,=:,,++=~=+??II7ZODOD
                            8D888888OOZZ$$77ZOO8OZZ                       7Z8ZI8                 +?=,,,:~..,:=:,:+?77ZZ7I$778
                            7$$$$$77777$7$Z$OZ$IZO887?                    Z88ZI8               .8?+~,:=:::,=~::=+I++?I7I77$?
                            ZIII77IIII777777II7777ZZOO$$~                $O?OI$I               .$I~~=+~,.:+==?+=:.~=77$$$D
                            $??IIII????I77I??III7IIIIII7$$7               MN8OZD               .7++?=::,:~,~=:~::+I??I77Z7
                            7??I????I?????++III777$7I7IIIII7              DNIZZO                +,?+===:,,+++?IIII+777$$O
                            $??II???+++7$$$Z$$$$ZZ$$ZZ$Z8                DNNI$O7               .8I,?7+:...,7I77III7Z$ZZ
                            I?+++?7$$$$7$$ZZZZZ$ZZZZZO                   MDNZ$$Z                  7:?+=:~~~?I++?IZZO?
                            +I$ZZZ$$$$$$$ZZZZZZZZZZ$$                    8$$Z7$$                  O?=I~:~+I+??I7II$I7
                                  7?O7$$$$ZZZZ$$ZZZZ$         =O$$8+    :?==?~===     =O$$O+~     Z7~$?+?II?I?II$O?
                                        :DZ$77$$$$$$$I      Z=$Z88O$?$OD$II+7~7=~Z8OZ?$OOOO?7     O7??++7$$77$$??IZ
                                            87$$$Z$$$$      +7DZ8$7OO=$O7Z8OO7+?ZI$7$ZZ?788D~Z    Z77?I7?$ZZ$$7$Z+
                                              O$$$$ZZOOZ    ~$N8:$$I7$=7OZZ$Z7+?$77I777$?78N=7D$DZ7ZZ$7I777$Z8:
                                               ~$ZOOZ7I?I$$$I+OD~77$7$+$$?ZZ$7?Z+7+7I777$I8Z7Z$I$Z7?7II?IZ$7$7$M
                                                DO$I?+??+??ZOO77:$777O=7OI?$Z7$+$Z+IZ7IZI7I$ZZ77ZI$OOOZZZ7ZN
                                                 I?+++++IZZ888ND+77?7I$7ZO=7OO?$7$$~I77$I$O$DOZ7?$I?$ZOOO$$Z8
                                                 =?I?+7Z$ZO$$8D +:IOOOI777Z$O8?777II8OZ=$ $OO8O8O7ZZOZZ$778
                                                8~=+7$$$OOI7O8Z  N~I$Z$OZD?IO87ZO$Z~$7~$  +DDOZ8O$OO$$87O
                                                $,?ZZ$7ZZO+ZOD    I~I8$$Z777ZNIO$Z7+$?O    O888ZOOZ$8O8
                                                :IZZ8?$8ZI~$Z      M=$ZZOZ+$$8+7OZI7?$      8Z$8Z$D8O?
                                               D$?      8:=$8       ?78$$ZO8$IOZ$$$8I8       D$DD8O
                                                         :IO?  ZDZOOOZ$7ZI8ZI?$O77$Z8OO$$OM    M
                                                         I?Z  $$8DD8O77Z$7OO~,IZ7Z$+7Z8DD8$$IO            ZO
                                                         8IO $$NMMMMMNO77O7ZI?$ZO=7ZNMMMMMNZN             I$
                                                          ID IZMMMMMMN88$$8O$$8ZI7$ZMMNMMMMOO             ?$~
                                                          7, D?8MNDZZO7$$I7O$$Z$$O$7I$IDMMDI?            N7I~
                                                          I   MO777$Z87D8OO7ZO$OOO8Z8O$7778Z             $I?~
                                                                 $O8$+87DD$I7OZZO878?$OIO7               II+D
                                                                  8Z88I878D$IO$OO7$+OZ7O                Z??ID
                                                                   NZ8OO87N?I$$87Z7ZZI=                7I?I7D
                                                                    8ZOZD78D??Z8$O7D?M                D?77I7M
                                                                     Z$IOZ8D?+OZZIII$                D???II7:
                                                                     N$8ZOO8?+D$Z+8I~           ~7NN$II???I$
                                                                      Z88OZ8??O$Z$OI=          ,OIIIIIII?I7O
                                                                      ZO?OZZ?IO$Z:OI          =~I7I77IIIIIZ8
                                                                      ZO88O$IIO$$O$+       =  ++$77III7I7IO
                                                                      OOZ$D7?IZZZ+7?      O78$+?ZI777II77ZO
                                                                      OOD7N$IIZ878I7     M$I?++I$7II777IIO7
                                                                      OO$ON7I7Z8ZZIZ    +7$+=++$+II?III7$O
                                                                      Z78NN$77$8DO?8= 8 $7++~+77+?II7II7OM
                                                                      $8NNN$77$88DINM8$IIZ++++Z+++???IIOO
                                                                       O8NN$$7$OOO7MMZ++Z+===Z=+=+?+?IZ$:
                                                                       OZDNZZ7$88I8MOI=II+++$?=+=+???7O
                                                                       DO8N$$$$8O?NDI+IZ?++$7+?++=??788
                                                                       $ZZD$$$$8?$8$I7Z??I$Z???++???8$
                                                                      ZOZ77$$Z$?ZOI?$ZI?IOO77I???I?OZ
                                                                      $$$ZI?8O7O8I$ZZ777OZ777IIII7O$
                                                                     77$ZZONIZDZI7O$7$7ZO$$$7IIIZO$
                                                                    7ZZZZZOD8$Z7$Z7$77ZOZZ$$7$7OO7
                                                                   I$$ZZO8NO7$IZ$77$OO$ZZZ$$$ZOOD
                                                                 DI$ZZO8ND777ZZ7$ZZOOZZZZZZZOZZ,,
                                                                ?$ZZZZDNN$7$$$$$$7OO$$OZZ$Z8O$~
                                                               M$ZZZ8NNO77$$OI$$ZZ$Z$$$$ZOZO8
                                                              8ZZOODDNZIIIODOOO7ZO7ZZZZZ88$M
                                                            =$$O8DDND$7$$$$ZOOZZZZZZZZ8$DZ,
                                                           I7O8DDMDD7OZZ$Z$7ZZ$8OOOOO8O8N
                                                          7I88ONMO8$Z8NOZ$$O8OOOO8O8NO88
                                                         DI88NMNZZZODD8DZZZZ$OOO8ODDO8Z
                                                         788NNMZ$OO8O8DDDDOZZZOODNDN8O
                                                        OZ8MMM$$ZNNOO88DDDD8$ZDDD8DN8D
                                                        Z8NMN7ZONMMMOOO888+8DD$888DD8M
                                                        Z8NMZZONMNMMM888D7DOZ8D88DNNO
                                                        O8N8Z8NMMMMMMO888I88ZZ8O88DMZ
                                                        NZNOZDMMMMMMMZ888ZN$$OODO8DMOD
                                                         ZZODMMMMMNMNZO88$NNOOD8DDDNOO
                                                         $Z87MMMNNMD$888DDZO8N78D88DO+
                                                        Z78DDO$ZOOODOND+D$NDODDODD8O,
                                                        O$8MMNMNMN$ZO8O$D88O8ON8DDO=       ,
                                                        $ZDMMMMMMNNIOO$DD8O888DN8Z~:    $~:
                                                        $ONMMMMMMMM$$88O8$8OO88D+~:~+M7:~~~
                                                        O$DMMMMMMMMZ$8OOOZOOO8D8=:~::~~~~:~
                                                        $78NNMMMMNN+OZZZOZZZO888+~:=~~~~~:~
                                                         N$O88NMN8$8 ZZZOOZZO888?~:~~~~~~~=
                                                           ?D88O887 NOZZOO$ZO8D8=~~~~~~~~~=
                                                                   +OZZZZZ$$O8DO~~~~:~~~~:+
                                                                   ZZ$$$$Z$$Z8DZ=:~~~~~~~~+
                                                                 Z$$$$ZZ$Z$$Z8D$~~:~~~~~~~?
                                                                Z$ZZZZZZ$Z$$Z8D7=~~~~~:~~~?
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
