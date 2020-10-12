<style>
    .settingsWindowTabButton{
        display: inline-block;
        cursor: pointer;
        border-top: 0px solid black;
        background-color: black;
        font-size: 20px;
        padding-right: 5px;
        padding-left: 5px;
        border-top: 1px solid #444444;
        border-left: 1px solid #444444;
        border-right: 1px solid #444444;
    }
    .settingsWindowTabButton:hover {
        background-color: #333333;
    }
    .settingsWindowTab{ display: none; }
</style>

<div id="settings" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 2; background: rgba(0, 0, 0, 0.0); overflow: hidden; font-family: arial;">
    <div id="settingsContainer" style="margin: 60px auto; background-color: black; border: 2px solid gray; width: 50%; position: relative;">
        <div id="settingsContentTop" style="border-bottom: 1px solid gray; width: 100%; font-size: 26px; text-align: center;">
            Settings
        </div>
        <div id="settingsWindowTabs" style="text-align:center;">
            <div class="settingsWindowTabButton" id="settingsWindowTab1Button" tab="1">General</div>
            <div class="settingsWindowTabButton" id="settingsWindowTab2Button" tab="2">Layout</div>
            <div class="settingsWindowTabButton" id="settingsWindowTab3Button" tab="3">Messages</div>
            <div class="settingsWindowTabButton" id="settingsWindowTab4Button" tab="4">Sounds</div>
        </div>
        <div id="settingsContentMiddle" class="settings" width="100%" style="text-align: center; max-height: 600px; overflow-y: auto;">
            <div class="settingsWindowTab" id="settingsWindowTab1">
                <table class="settings">
                    <tr>
                        <td>Notify on new message</td>
                        <td><button class="settings" id="notifyOnNewMsg" onClick="settings2.toggle(this, 'notifyOnNewMsg')"></button></td>
                        <td>Preview files</td>
                        <td><button class="settings" id="previewFiles" onClick = "settings2.toggle(this, 'previewFiles')"></td>
                    </tr>
                    <tr>
                        <td>Join messages</td>
                        <td><button class="settings" id="joinMessages" onclick="settings2.toggle(this, 'joinMessages');"></input></td>
                        <td>Join messages time (seconds)</td>
                        <td><input class="settings" id="joinMessagesTime"></input></td>
                    </tr>
                    <tr>
                        <td>Change icon on new message</td>
                        <td><button class="settings" id="changeIconOnNewMsg" onClick="settings2.toggle(this, 'changeIconOnNewMsg')"></button></td>
                    </tr>
                    <tr>
                        <td>Always online</td>
                        <td><button class="settings" id="alwaysOnline" onclick="settings2.toggle(this, 'alwaysOnline');"></input></td>
                        <td cellspan="2">Having this enabled will always show you as online</td>
                    </tr>
                    <tr>
                        <td>Ignore events</td>
                        <td><button class="settings" id="ignoreEvents" onclick="settings2.toggle(this, 'ignoreEvents');"></input></td>
                        <td cellspan="2">If this is enabled the chat will not change according to current holidays/other events (refresh required)</td>
                    </tr>
                    <tr>
                        <td>Scroll chat after message send</td>
                        <td><button class="settings" id="scrollOnSend" onclick="settings2.toggle(this, 'scrollOnSend');"></input></td>
                    </tr>
                    <tr>
                        <td colspan="100%">Userlist update interval (1-10s)
                            <input type="range" min="1" max="10" value="5" id="userlistUpdateInterval"/>
                            <div id="userlistUpdateIntervalVal" style="display: inline;">5s</div>
                        </td>
                    </tr>
                </table>
                <p style="font-size: 22px; margin: 0 auto;">Images</p>
                <table class="settings">
                    <tr>
                        <td>Confirm image upload</td>
                        <td><button class="settings" id="confirmImageUpload" onclick="settings2.toggle(this, 'confirmImageUpload');"></input></td>
                        <td>Display images</td>
                        <td><button class="settings" id="displayImages" onclick="settings2.toggle(this, 'displayImages');"></input></td>
                    </tr>
                    <tr>
                        <td>Expand images on hover</td>
                        <td><button class="settings" id="expandOnHover" onclick="settings2.toggle(this, 'expandOnHover');"></input></td>
                    </tr>
                    <tr>
                        <td>Max image width</td>
                        <td><input class="settings" id="maxImageWidth"></input></td>
                        <td>Max image height</td>
                        <td><input class="settings" id="maxImageHeight"></input></td>
                    </tr>
                    <tr>
                        <td>Max expand width</td>
                        <td><input class="settings" id="maxExpandWidth"></input></td>
                        <td>Max expand height</td>
                        <td><input class="settings" id="maxExpandHeight"></input></td>
                    </tr>
                </table>
                <p style="font-size: 22px; margin: 0 auto;">Videos</p>
                <table class="settings">
                    <tr>
                        <td>Preview youtube videos</td>
                        <td><button class="settings" id="previewYTVideos" onClick = "settings2.toggle(this, 'previewYTVideos')"></td>
                        <td>Preload videos</td>
                        <td><button class="settings" id="preloadVideos" onClick = "settings2.toggle(this, 'preloadVideos')"></td>
                    </tr>
                    <tr>
                        <td>Video width</td>
                        <td><input class="settings" id="videoWidth"></input></td>
                        <td>Video height</td>
                        <td><input class="settings" id="videoHeight"></input></td>
                    </tr>
                </table>
            </div>
            <!-- layout -->
            <div class="settingsWindowTab" id="settingsWindowTab2">
                <table class="settings">
                    <tr>
                        <td>Simple chat</td>
                        <td><button class="settings" id="simpleChat" onClick = "settings2.toggle(this, 'simpleChat')"></td>
                        <!-- <td>Chat height</td>
                        <td>
                            <input class="settings" id="chatHeightSetting"></input>
                            <button class="settings" id="resetChatHeight">Reset</button>
                        </td> -->
                    </tr>
                    <tr>
                        <td>Reverse input</td>
                        <td><button class="settings" id="reverseMsgInputPosition" onClick = "settings2.toggle(this, 'reverseMsgInputPosition')"></td>
                        <td>Input width %</td>
                        <td><input class="settings" id="msgInputWidth"></input></td>
                    </tr>
                    <tr>
                        <td>Reverse messages</td>
                        <td><button class="settings" id="reverseMessages" onClick = "settings2.toggle(this, 'reverseMessages')"></td>
                        <!-- <td>Input height</td>
                        <td>
                            <input class="settings" id="msgInputHeight"></input>
                            <button class="settings" id="resetInputHeight">Reset</button>
                        </td> -->
                    </tr>
                    <tr>
                        <td>Custom font type</td>
                        <td><input class="settings" id="fontType"></input></td>
                    </tr>
                    <tr>
                        <td>Private message color</td>
                        <td><input class="settings" id="pmColor"></input></td>
                        <td>Private message input color</td>
                        <td><input class="settings" id="pmInputColor"></input></td>
                    </tr>
                </table>
                <p style="font-size: 22px; margin: 0 auto;">Background</p>
                <table class="settings">
                    <tr>
                        <td>Background</td>
                        <td><button class="settings" id="backgroundButton" onClick="settings2.toggle(this, 'background');"></button></td>
                        <td>Image (you can use url)</td>
                        <td><input class="settings" id="backgroundImage" style="width: 200px;"></button></td>
                    </tr>
                    <tr>
                        <td>Background color (no image)</td>
                        <td><input class="settings" id="backgroundColor"></input></td>
                        <td>Background color (with image)</td>
                        <td><input class="settings" id="backgroundColorImage" style="width: 200px;"></input></td>
                    </tr>
                    <tr>
                        <td>Bottom border</td>
                        <td><button class="settings" id="bottomBorder" onClick="settings2.toggle(this, 'bottomBorder');"></button></td>
                    </tr>
                </table>
                <p style="font-size: 22px; margin: 0 auto;">User list</p>
                <table class="settings">
                    <tr>
                        <td>User name color</td>
                        <td><input class="settings" id="userListNameColor"></input></td>
                        <td>Border color</td>
                        <td><input class="settings" id="userListBorderColor"></input></td>
                    </tr>
                </table>
                <p style="font-size: 22px; margin: 0 auto;">User list styles (advanced)</p>
                <table class="settings">
                    <tr>
                        <td>Table style</td>
                        <td><input class="settings" id="userlist_table"></input></td>
                        <td>User image style</td>
                        <td><input class="settings" id="userlist_userimage"></input></td>
                    </tr>
                    <tr>
                        <td>User time style</td>
                        <td><input class="settings" id="userlist_usertime"></input></td>
                        <td>User name style</td>
                        <td><input class="settings" id="userlist_username"></input></td>
                    </tr>
                    <tr>
                        <td>User image cell style</td>
                        <td><input class="settings" id="userlist_userimagecell"></input></td>
                    </tr>
                </table>
                <p style="font-size: 22px; margin: 0 auto;">Other</p>
                <table class="settings">
                    <tr>
                        <td>Message input style</td>
                        <td><input class="settings" id="messageInputStyle" style="width: 150px"></input></td>
                    </tr>
                    <tr>
                        <td>PM background</td>
                        <td><input class="settings" id="pmMsgBackground" style="width: 150px"></input></td>
                        <td colspan="2">Use "none" for no background</td>
                    </tr>
                    <tr>
                        <td>Scroll bar</td>
                        <td><input class="settings" id="scrollBar" style="width: 150px"></input></td>
                        <td>Scroll bar track</td>
                        <td><input class="settings" id="scrollBarTrack" style="width: 150px"></input></td>
                    </tr>
                    <tr>
                        <td>Scroll bar thumb</td>
                        <td><input class="settings" id="scrollBarThumb" style="width: 150px"></input></td>
                        <td>Scroll bar thumb hover</td>
                        <td><input class="settings" id="scrollBarThumbHover" style="width: 150px"></input></td>
                    </tr>
                </table>
            </div>
            <!-- messages -->
            <div class="settingsWindowTab" id="settingsWindowTab3">
                <p style="font-size: 22px; margin: 0 auto;">Messages</p>
                <table class="settings">
                    <tr>
                        <td>Max displayed messages</br>(limited to 1000)</td>
                        <td><input class="settings" id="maxMsgSetting"></input></td>
                    </tr>
                    <tr>
                        <td>Avatar size</td>
                        <td><input class="settings" id="avatarSize"></input></td>
                        <td>Space between messages</td>
                        <td><input class="settings" id="msgMargin"></input></td>
                    </tr>
                    <tr>
                        <td>Sender text size</td>
                        <td><input class="settings" id="senderFontSize"></input></td>
                        <td>Sender text color</td>
                        <td><input class="settings" id="senderTextColor"></input></td>
                    </tr>
                    <tr>
                        <td>Date text size</td>
                        <td><input class="settings" id="dateFontSize"></input></td>
                        <td>Date text color</td>
                        <td><input class="settings" id="dateTextColor"></input></td>
                    </tr>
                    <tr>
                        <td>Message text size</td>
                        <td><input class="settings" id="msgFontSize"></input></td>
                        <td>Message color</td>
                        <td><input class="settings" id="msgTextColor"></input></td>
                    </tr>
                    <tr>
                        <td>Message top border</td>
                        <td><button class="settings" id="msgTopBorder" onclick="settings2.toggle(this, 'msgTopBorder');"></input></td>
                        <td>Fixed message color</td>
                        <td><input class="settings" id="fixedMsgTextColor"></input></td>
                    </tr>
                    <tr>
                        <td>Message background</td>
                        <td><button class="settings" id="msgBackground" onclick="settings2.toggle(this, 'msgBackground');"></input></td>
                        <td>Message style</td>
                        <td><input class="settings" id="msgStyle"></input></td>
                    </tr>
                    <tr>
                        <td>Message top border color</td>
                        <td><input class="settings" id="messageDataBorderColor"></input></td>
                    </tr>
                    <tr>
                        <td>New message notification color</td>
                        <td><input class="settings" id="newMsgLineColor"></input></td>
                        <td>New message notification border color</td>
                        <td><input class="settings" id="newMsgLineBorderColor"></input></td>
                    </tr>
                    <tr>
                        <td>Date position</td>
                        <td><button class="settings" id="datePosition" onClick="settings2.toggle(this, 'datePosition');"></button></td>
                        <td>Display date below sender</td>
                        <td><button class="settings" id="dateBelowSender" onClick="settings2.toggle(this, 'dateBelowSender');"></button></td>
                    </tr>
                    <tr>
                        <td>Show global with private</td>
                        <td><button class="settings" id="globalWithPM" onClick="settings2.toggle(this, 'globalWithPM');"></button></td>
                        <td colspan='2'>Enabling this will show global messages when PM'ing</td>
                    </tr>
                </table>
            </div>
            <!-- sounds -->
            <div class="settingsWindowTab" id="settingsWindowTab4">
                <p style="font-size: 22px; margin: 0 auto;">Sounds</p>
                <table class="settings">
                    <tr>
                        <td>Sound on new message</td>
                        <td><button class="settings" id="soundOnNewMsg" onClick="settings2.toggle(this, 'soundOnNewMsg');"></button></td>
                        <td>Notification sound cooldown (s)</td>
                        <td><input class="settings" id="notificationSoundCooldown"></input></td>
                    </tr>
                    <tr>
                        <td>Sound</td>
                        <td><input class="settings" id="newMsgSound" style='width:100px'></input></td>
                        <td colspan="2">newmsg.mp3 // newmsg2.mp3 // newmsg3.wav</td>
                    </tr>
                    <tr>
                        <td>Greeting sound</td>
                        <td><button class="settings" id="greetingSound" onClick="settings2.toggle(this, 'greetingSound');"></button></td>
                        <td>Sound messages</td>
                        <td><button class="settings" id="bindSounds" onClick="settings2.toggle(this, 'bindSounds');"></button></td>
                    </tr>
                    <tr>
                        <td>Sound msg volume (0-100)</td>
                        <td><input class="settings" id="bindSoundVolume"></input></td>
                        <td>New message volume (0-100)</td>
                        <td><input class="settings" id="msgNotificationVolume"></input></td>
                    </tr>
                    <tr>
                        <td colspan="2">Play sound messages regardless of inactivity</td>
                        <td><button class="settings" id="alwaysPlaySoundMessagse" onClick="settings2.toggle(this, 'alwaysPlaySoundMessagse');"></button></td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="settingsContentBottom" style="margin-top: 10px; margin-bottom: 5px;">
            <table class="settings" style="border-bottom: none; margin-bottom: 0px;">
            <tr>
                <td style="width: 100px;"><button onclick="Export()" style="width: 100px;">Export</button></td>
                <td style="width: 100px;"><button onclick="Import()" style="width: 100px;">Import</button></td>
                <td style="width: 100px;"><button onclick="ResetAll(); settings2.applyAll(); ReloadMessages(); $('#reloadMessages').prop('checked', false);" style="width: 150px;">Style 1 (default)</button></td>
                <td style="width: 100px;"><button onclick="settings2.load(chatstyle2); settings2.applyAll(); ReloadMessages(); $('#reloadMessages').prop('checked', false);" style="width: 100px;">Style 2</button></td>
                <td style="width: 100px;"><button onclick="settings2.load(chatstyle3); settings2.applyAll(); ReloadMessages(); $('#reloadMessages').prop('checked', false);" style="width: 100px;">Style 3</button></td>
            </tr>
            <tr>
                <td colspan="100%">
                    <center>
                        <button onclick="SaveOnline()" style="width: 100px;">Save online</button>
                        <button onclick="LoadOnline()" style="width: 100px;">Load online</button>
                    </center>
                </td>
            </tr>
            <tr>
                <td style="width: 100px;"></td>
                <td style="width: 100px;"></td>
                <td style="width: 100px;"><input type="checkbox" id="reloadMessages" checked="true"/>Reload messages</td>
            </tr>
            </table>
            <table style="width: 100%; text-align: center; position: relative;">
                <tr>
                    <td style="width: 100%">
                    <button onclick="SaveSettings()" style="width: 100px; font-weight: bold;">Save</button>
                    <button onclick="Cancel()" style="width: 100px;">Cancel</button>
                    <div style="position: absolute; right: 10px; top: 5px;"><a href="versionhistory.txt" target="_blank">
                        <?php
                            $f = fopen("versionhistory.txt", 'r');
                            echo "v".fgets($f);
                            fclose($f);
                        ?>
                    </a></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div id="exportWindow" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; overflow: hidden;">
    <div id="exportWindowContent" style="margin: 150px auto; background-color: black; border: 2px solid gray; width: 25%; padding:15px;">
        <center><textarea id="exportText" style="width: 90%; height: 100px; margin: 5px"></textarea></center>
        <center>
            <button onclick="document.execCommand('copy'); $('#exportWindow').hide(); $('#exportText').html('');" style="width: 100px;">Copy</button>
            <button onclick="$('#exportWindow').hide(); $('#exportText').html('');" style="width: 100px;">Cancel</button>
        </center>
    </div>
</div>
<div id="importWindow" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; overflow: hidden;">
    <div id="importWindowContent" style="margin: 150px auto; background-color: black; border: 2px solid gray; width: 25%; padding:15px;">
        <center>Paste settings text here</center>
        <center><textarea id="importText" style="width: 90%; height: 100px; margin: 5px"></textarea></center>
        <center>
            <button onclick="ConfirmImport();" style="width: 100px;">Load</button>
            <button onclick="$('#importWindow').hide(); $('#importText').html(''); settings2.updateInputs();" style="width: 100px;">Cancel</button>
        </center>
    </div>
</div>

<div id="settingsNotificationWindow" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; overflow: hidden; pointer-events: none;">
    <div id="settingsNotificationWindowContent"
         style="margin: 150px auto; background-color: black; background-image: linear-gradient(black 30%, rgba(0, 15, 15));
         border: 2px outset rgba(0, 125, 0); width: 25%; padding:15px; padding-bottom: 5px; pointer-events: auto; border-radius: 10px; text-align: center;">
            <div id="settingsNotificationWindowText"></div>
            </br>
            <center><button onclick="$('#settingsNotificationWindow').hide();" style="width: 100px;">Ok</button></center>
    </div>
</div>

<script>
    var lastUsedStyle = "";
    $('#settingsContentMiddle').css('max-height',$(window).height() * 0.7);
    var chatstyle2 = "greetingSound::0|dateBelowSender::1|maxMessages::50|msgContainerHeight::|msgInputHeight::|msgInputWidth::50|notifyOnNewMsg::1|soundOnNewMsg::1|reverseMessages::1|reverseMsgInputPosition::1|simpleChat::0|background::1|backgroundImage::kknd/Background.png|backgroundColor::#111111|backgroundColorImage::rgba(0.15, 0.15, 0.15, 0.0)|bottomBorder::0|datePosition::0|avatarSize::100|msgMargin::0|senderFontSize::24|senderTextColor::#888888|dateFontSize::12|dateTextColor::#444444|msgFontSize::16|msgTextColor::#00ff00|fixedMsgTextColor::|joinMessages::1|joinMessagesTime::60|msgBackground::1|msgTopBorder::0|msgStyle::border-radius: 6px&#sc. border: 0px solid #0000ff&#sc. box-shadow: 4px 4px 0px rgba(0, 0, 150, 1)&#sc. background: -webkit-linear-gradient(top, #000033, #000000, #000000, #000000)&#sc. display:inline-block&#sc. min-width: 150px&#sc. padding: 10px&#sc. padding-left: 20px&#sc. padding-right: 20px&#sc.|confirmImageUpload::1|displayImages::1|maxImageWidth::500|maxImageHeight::300|expandOnHover::1|maxExpandWidth::1300|maxExpandHeight::1300|previewFiles::1|previewYTVideos::1|";
    var chatstyle3 = "greetingSound::0|maxMessages::50|msgContainerHeight::|msgInputHeight::|msgInputWidth::100|notifyOnNewMsg::1|soundOnNewMsg::1|reverseMessages::0|reverseMsgInputPosition::0|simpleChat::1|background::1|backgroundImage::bg1.jpg|backgroundColor::#111111|backgroundColorImage::rgba(0.15, 0.15, 0.15, 0.9)|bottomBorder::0|datePosition::1|avatarSize::75|msgMargin::5|senderFontSize::20|senderTextColor::#888888|dateFontSize::16|dateTextColor::#444444|msgFontSize::16|msgTextColor::lightgray|fixedMsgTextColor::|joinMessages::0|joinMessagesTime::60|msgBackground::0|msgTopBorder::1|msgStyle::background-color: black&#sc. border: solid 1px gray&#sc. border-radius: 6px&#sc. padding: 3px&#sc. display:inline-block&#sc.|confirmImageUpload::1|displayImages::0|maxImageWidth::500|maxImageHeight::300|expandOnHover::1|maxExpandWidth::1000|maxExpandHeight::1000|"
    ///KKND STYLE
    ///also a part in LoadSettings();
    var chatstylekknd = "maxMessages::200|msgContainerHeight::0.88|msgInputHeight::0.05|msgInputWidth::100|notifyOnNewMsg::1|changeIconOnNewMsg::1|reverseMessages::1|reverseMsgInputPosition::1|simpleChat::0|alwaysOnline::0|ignoreEvents::0|background::1|backgroundImage::bg2.png|backgroundColor::#111111|backgroundColorImage::rgba(0.1, 0.1, 0.1, 0.5) |bottomBorder::0|datePosition::1|avatarSize::75|msgMargin::-2|senderFontSize::20|senderTextColor::#00ff00|dateFontSize::14|dateTextColor::#aaaaff|msgFontSize::15|msgTextColor::aaffaa|fixedMsgTextColor::|joinMessages::1|joinMessagesTime::60|msgBackground::0|msgTopBorder::1|msgStyle::background-color: black&#sc. border: solid 1px gray&#sc. border-radius: 6px&#sc. padding: 3px&#sc. display:inline-block&#sc.|dateBelowSender::0|newMsgLineColor::rgb(230, 230, 230)|newMsgLineBorderColor::blue|confirmImageUpload::1|displayImages::1|maxImageWidth::500|maxImageHeight::250|expandOnHover::1|maxExpandWidth::10000|maxExpandHeight::10000|previewFiles::1|previewYTVideos::1|preloadVideos::1|videoWidth::500|videoHeight::300|notificationSoundCooldown::60|userMsgColor::|fontType::arial|newMsgSound::newmsg3.wav|msgNotificationVolume::80|soundOnNewMsg::1|greetingSound::0|bindSounds::1|bindSoundVolume::100|globalWithPM::1|pmColor::#aaaaaa|pmInputColor::#005555|pmMsgBackground::rgba(40, 0, 70, 0.2)|userListNameColor::aaffaa|userListBorderColor::aaffaa|messageDataBorderColor::339933|messageInputStyle::font-family:Arial&#sc. color: #aaffaa&#sc. background: #000000&#sc. border-radius: 3px&#sc. border: 2px solid #aaffaa &#sc. height: 48px&#sc.|scrollBar::|scrollBarTrack::background-color: #000000&#sc. box-shadow: inset 0 0 8px #335533&#sc.|scrollBarThumb::border-radius: 5px&#sc. background-color: #000000&#sc. box-shadow: inset 0 0 20px #aaffaa&#sc. border:none&#sc.|scrollBarThumbHover::background-color: #000000&#sc. box-shadow: inset 0 0 20px #aaaaaa&#sc.|scrollOnSend::1|userlistUpdateInterval::1|";
    ///

    function LoadSettings(){
        for(var key in sourcesLoaded) if(sourcesLoaded.hasOwnProperty(key)) if(sourcesLoaded[key] == false) return;
        if(window.location.href.indexOf("chat=kknd") != -1) settings2.load(chatstylekknd);
        else settings2.load();
        settings2.applyAll();
        if(typeof(settings2.onInit) === "function") settings2.onInit();
        if(typeof(settings2.onLoad) === "function") settings2.onLoad();
        for(i=0; i<settings2.afterLoad.length; i++) if(typeof(settings2.afterLoad[i]) === "function") settings2.afterLoad[i]();
    }
    //tabs
    $('#settingsWindowTab1Button').css("background-color", "#333333");
    $('#settingsWindowTab1Button').css("border-bottom", "1px solid white");
    $('#settingsWindowTab1').show();
    $(document).on("click", ".settingsWindowTabButton", function(e){
        $('#settingsContainer').find('.settingsWindowTab').each(function(){
            $(this).hide();
        });
        $('#settingsWindowTabs').find('.settingsWindowTabButton').each(function(){
            $(this).css("background-color", "");
            $(this).css("border-bottom", "none");
        });
        $('#settingsWindowTab'+$(e.currentTarget).attr("tab")).show();
        $(e.currentTarget).css("background-color", "#333333");
        $(e.currentTarget).css("border-bottom", "1px solid white");
        $('#fsettingsWindowHead').html($(e.currentTarget).attr("tabname"));
    });
    //
    function ShowSettingsWindow(){
        $('#settings').toggle();
        lastUsedStyle = settings2.toStr();
    }
    function ReloadMessages(){
        _reloadMessages = true;
        $('#msgContainer').html('');
        lastMsgId = 0;
        lastMsgTime = 0;
        hasLoaded = false;
        UpdateMessages();
        $('#reloadMessages').prop('checked', true);
    }
    function SaveSettings(){
        settings2.updateAll();

        settings2.set("userlistUpdateInterval", $('#userlistUpdateInterval').val());

        settings2.save();
        if($('#reloadMessages').prop('checked')) ReloadMessages();

        settings2.applyAll();
        if(settings2.get("reverseMessages") != "1") $msgContainer.scrollTop($msgContainer.outerHeight(true)*10);
        else $msgContainer.scrollTop(0);
        $('#settings').toggle();

        OnResize();
    }
    function Cancel(){
        if(lastUsedStyle != ""){
            settings2.load(lastUsedStyle);
            settings2.applyAll();
        }
        lastUsedStyle = "";
        settings2.updateInputs();
        $('#settings').toggle();

        OnResize();
    }
    function Export(){
        $('#exportWindow').show();
        $('#exportText').html(settings2.toStr());
        $('#exportText').select();
    }
    function Import(){
        $('#importWindow').show();
        $('#importText').select();
    }
    function ConfirmImport(data = ""){
        if(data == "") settings2.load($('#importText').val());
        else settings2.load(data);
        $('#importText').val('');
        $('#importWindow').hide();

        OnResize();
    }
    function ResetAll(){
        settings2.resetAll();
    }

    var settingsNotificationTimeout = null;
    function SettingsNotification(text){
        $('#settingsNotificationWindow').stop().animate({opacity:'100'}).show();
        $('#settingsNotificationWindowText').html(text);
    }

    function SettingsNotificationFadeout(delay, fadeTime){
        clearTimeout(settingsNotificationTimeout);
        settingsNotificationTimeout = setTimeout(function(){
            $('#settingsNotificationWindow').fadeOut(fadeTime, function(){ $('#settingsNotificationWindow').hide(); });
        }, delay);
    }

    var settingsRequestLock = false;
    function SaveOnline(){
        if(settingsRequestLock) return;
        settingsRequestLock = true;
        SaveSettings();
        SettingsNotification("Saving settings to the server...");
        $.ajax({
            url: 'jsRequest.php',
            data: {action: 'SaveChatSettings', data: settings2.toStr()},
            type: 'post',
            timeout: 10000,
            success: function(output){
                settingsRequestLock = false;
                if(output == ""){
                    console.log("Saved user settings on the server");
                    SettingsNotification("Successfully saved your settings to the server");
                    SettingsNotificationFadeout(3000, 2000);
                }else{
                    console.log("Error saving user settings on the server: "+output);
                    SettingsNotification("Error saving user settings on the server:</br>"+output);
                }
            },
            error: function(xhr, status, err){
                settingsRequestLock = false;
                console.log(err);
            }
        });
    }
    function LoadOnline(){
        if(settingsRequestLock) return;
        settingsRequestLock = true;
        $.ajax({
            url: 'jsRequest.php',
            data: {action: 'LoadChatSettings'},
            type: 'post',
            dataType: 'json',
            timeout: 10000,
            success: function(output){
                settingsRequestLock = false;
                if(output[0] == 1){
                    console.log("Error loading settings from the server: "+output[1]);
                    SettingsNotification("Error loading settings from the server:</br>"+output[1]);
                }else{
                    if(output[1][0] != ""){
                        ConfirmImport(output[1][0]);
                        console.log("Loaded settings from the server");
                        SettingsNotification("Successfully loaded settings from the server, press 'save' to apply them");
                        SettingsNotificationFadeout(3000, 3000);
                    }else{
                        SettingsNotification("You don't have any chat settings saved on the server");
                    }
                }
            },
            error: function(xhr, status, err){
                settingsRequestLock = false;
                console.log(err);
            }
        });
    }


    //events
    $('#userlistUpdateInterval').on("change", function(){ $('#userlistUpdateIntervalVal').html($(this).val()+"s"); });

    //chat height
    $('#settings').click(function(event){ if(event.target === $('#settings')[0]) SaveSettings(); });
    $('#resetChatHeight').click(function(){ settings2.setDefault('msgContainerHeight'); });
    $('#chatHeightSetting').change(function(){
        settings2.update('msgContainerHeight');
        settings2.apply('msgContainerHeight');
    });

    //input height
    $('#resetInputHeight').click(function(){ settings2.setDefault('msgInputHeight'); });
    $('#chatInputSetting').change(function(){ settings2.update('msgInputHeight'); });

    //max msg
    $('#resetMaxMsg').click(function(){ settings2.setDefault('maxMessages'); });

    sourcesLoaded['settings'] = true;
    if(typeof(LoadSettings) == "function") LoadSettings();
</script>
