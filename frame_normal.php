<div id="chatContainer">
    <table id="table1" style="height: 16px; width: 100%; background-color: black; font-size: 14px;">
        <tr style="outline: 2px solid gray;">
            <td id="table1_userData" style="width: 92%;">
                <a href="/">⬅ Return</a> |
                <div id="userData" style="display: inline;">
                    <div style="display: inline-block">
                        <div id="userData_notlogged">
                            Your name: X-
                            <input type="input" id="renameInput"></input>
                            <button class="topBarButton" id="loginButton">Log in / register</button>
                        </div>
                        <div id="userData_logged" style="display: none;">
                            Logged in as
                            <div id="userData_name" style="display: inline-block; margin-right: 15px;">-</div>|
                            <button class="topBarButton" id="logoutButton" onclick="Logout();">Log out</button>
                            <button class="topBarButton" id="avatarButton" onclick="ProfileImageWindow();">Profile image</button>
                        </div>
                    </div>
                    <div id="asdf" style="display: inline-block;"> |
                        <button class="topBarButton" id="fileUploadButton" onclick="FileUploadWindow();">Upload file</button>
                        <button class="topBarButton" id='toggleBindsWindow' onclick="ToggleBindsWindow();" title="Binds/gifs/images/whatever">Image</button>
                        <button class="topBarButton" id='toggleSoundsWindow' onclick="ToggleSoundsWindow();" title="Sound messages">Sounds</button>
                    </div>
                </div>
                <div style="float:right;">
                    <div style="display: inline-block;" id="latency">-</div>
                    <button class="topBarButton" id='muteAllSounds' onclick="MuteAllSounds();"
                                title="This will stop all currently playing sounds and will prevent any sounds from playing">Mute</button>
                    |
                    <!-- <button class="topBarButton" onclick="Radio()">Radio</button> -->
                    <button class="topBarButton" onclick="$('#firstTimeWindow').show()">Help</button>
                    <button class="topBarButton" onclick="ShowSettingsWindow();">Settings</button>
                </div>
            </td>
            <td id="table1_usersConnected" style="border-left: solid 1px gray; background-color: black;">
                <div style="width: 100%; height: 100%; text-align:center; white-space: nowrap;">
                    <div id="usersConnected" style="display: inline-block; line-height: 175%;">-</div>
                    <div id="togglePanelButton" title="Toggle users list"
                            onclick="$('#rightPanel').toggle(); if($(this).html() == '←') $(this).html('→'); else $(this).html('←'); ">→</div>
                </div>
            </td>
        </tr>
    </table>
    <table id="table2" style="width: 100%; border-bottom: 2px solid gray; margin-bottom: -5px; margin-top: -2px;">
        <tr>
            <td id="leftPanel" width="92%" style="position: relative; margin-left: -1px;">
                <div id="msgContainer" style="height: 500px; overflow: auto; white-space:pre-wrap;"></div>
                <div id="scrollToBottom" style=""
                     onclick="ScrollChat();"><div style="margin: auto;" id="scrollToBottom_text">&#8681 Scroll to bottom &#8681 </div>
                </div>
            </td>
            <td id="rightPanel" style="border-left: solid 1px gray; vertical-align: top; padding: 0px;">
                <div id="userListContainer" style='height: 100%; overflow: auto;'></div>
            </td>
        </tr>
    </table>
    <table id="table3" style="width: 100%; border-collapse: collapse; display: block; margin-top: 2px;" cellspacing="0" cellpadding="0">
        <tr>
            <td id="table2_msgInput" style="width: 85%; padding: 0px;">
                <table style="width: 100%; padding: 0px; height: 100%; border-spacing: 0px; margin: 0px; display: block;">
                    <tr>
                        <td style="width: 100%;"><center><textarea id="msgInput" style="width: 100%; height:100%; resize: none; margin:1px;"></textarea></center></td>
                        <td id="msgSendButton" onclick="SendMessage();">Send</td>
                    </tr>
                </table>
            </td>
            <td id="table2_msgData" style="width: 15%; vertical-align: top;" cellspacing="0" cellpadding="0">
                <table style="width: 100%; font-size: 14px;">
                    <tr>
                        <td>Color:</td>
                        <td><input type="text" id="userMsgColor" maxlength="15" placeholder="Your message color" style="width: 100%; height: 19px;"></input></td>
                        </td>
                    </tr>
                    <tr>
                        <td>PM:</td>
                        <td style="position:relative;">
                            <input type="text" id="privInput" maxlength="15" placeholder="Username" style="width: 100%; height: 19px;"></input>
                            <button style="position:absolute; right: 0px; top: 0px; width:20px; height:90%; padding: 0px; color:darkred; font-weight: bold;"
                                    onclick="$('#privInput').val('').trigger('change'); $('#msgInput').focus(); TogglePM('')">X</button>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<script>
    function ToggleBindsWindow(){
        if(!$('#bindsWindow').length){
            var tempDiv = document.createElement("div");
            tempDiv.setAttribute("style", "position: fixed; top: 10%; left: 50%; border: 1px solid gray; background-color: black; color: white; z-index: 10; font-size: 24px; padding: 14px;");
            tempDiv.innerHTML = "Loading...";
            $('body').append(tempDiv);
            $.get('bindsWindow.php', function(data){ $('body').append(data); $('#bindsWindow').toggle(); $(tempDiv).remove(); });
        }else $('#bindsWindow').toggle();
    }
</script>

