<?php include_once("filescan.php"); ?>

<style>
    .firstTimeWindowTabButton{
        display: inline-block;
        cursor: pointer;
        border-top: 0px solid black;
        background-color: black;
        font-size: 20px;
        padding-right: 5px;
        padding-left: 5px;
    }
    .firstTimeWindowTabButton:hover{
        background-color: #333333;
    }
    .soundBindsListCell{
        text-align: center;
        width: 150px;
        display: inline-block;
        cursor: pointer;
    }
    .soundBindsListCell:hover{
        cursor: pointer;
        background-color: #454545;
    }
    .soundBindCategoryHeader{
        font-size: 20px;
        background-color: #002110;
        border-bottom: 2px solid black;
        border-top: 2px solid black;
    }
</style>

<div id="firstTimeWindow" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; background: rgba(0, 0, 0, 0.8); overflow: hidden; font-family: arial;">
    <div id="firstTimeWindowContent" style="margin: 10px auto; background-color: black; border: 2px solid gray; width: 50%; text-align:center;">
        <div id="firstTimeWindowHead" style="font-size: 26px; border-bottom: 1px solid gray;">First time visit</div>
        <div id="firstTimeWindowTabs">
            <div class="firstTimeWindowTabButton" id="firstTimeWindowTab1Button" tab="1" tabname="First time visit">Basics</div>
            <div class="firstTimeWindowTabButton" id="firstTimeWindowTab2Button" tab="2" tabname="Settings">Settings</div>
            <div class="firstTimeWindowTabButton" id="firstTimeWindowTab4Button" tab="3" tabname="Chat commands">Chat commands</div>
        </div>
        <div id="firstTimeWindowMiddle" style="background-color: #121212; overflow-y: auto; max-height: 500px;">
            <div class="firstTimeWindowTab" id="firstTimeWindowTab1">
                <p style="color: yellow; font-size: 18px;">This chat has been tested only on google chrome so it's advised you use that</p>
                <p style="color: red;">This chat uses sounds. They will be muted on your first visit of this chat, you can unmute them by clicking the 'unmute all sounds' button
                    on the top bar.</br>
                    The next time you visit the sounds won't be muted unless you set it so in the settings in the "sounds" tab.
                </p>
                <p style="margin: 5px;">This page uses cookies to save your settings - if you have cookies disabled then they won't be saved </br>
                    (and this message will pop up every time you visit this page)</p>
                <p style="margin: 5px;">You can set your name without having to register, it will change once you're done typing it:</p>
                <img src="firsttime2.png" style="border: 1px solid black; outline: 2px solid orange; margin: 5px;"/></br>
                <p style="margin: 5px;">
                    Since this is your first time viewing this chat you may want to know that you can easily customize it to your liking by changing the settings.
                </p>
                <img src="firsttime1.png" style="border: 1px solid black; outline: 2px solid orange; margin: 5px;"/></br>
                <p style="margin: 5px;">By default the chat has a plain background but you can enable a fancy one (and more features) in the settings, click the "off" button to toggle it "on"</p>
                <img src="firsttime3.png" style="border: 1px solid black; outline: 2px solid orange; margin: 5px;"/></br>
                <p style="margin: 5px;">You can paste images (not files) directly into the chat, just select the message text box and ctrl+v or right click>paste
                    </br>
                    Files can be uploaded by clicking "upload file", or drag them from your disk and drop onto the chat to upload them
                </p>
            </div>
            <div class="firstTimeWindowTab" id="firstTimeWindowTab2" style="display: none;">
                <p style="margin: 5px;">Click the buttons to toggle
                    things on or off, or type desired value into the input field. The settings will be saved and applied once you click outside of the settings window or click
                    the "save" button</p>
                <p style="margin: 5px;">Some settings are initially set according to your browser properties, so you may want to reset the settings if you change your browser or device
                    and they will adjust to your new browser properties (or at least some will)</p>
                <p style="margin: 5px;">You can export your settings and share it with others so they can import them and see the chat the same way that you do</p>
                <p style="margin: 5px;">There are some styles already prepared. Click the style button and then click save to use that style</p>
            </div>
            <div class="firstTimeWindowTab" id="firstTimeWindowTab3" style="display: none;">
                User commands:</br>
                /sstop - stops all currently playing sounds</br>
                /poke [username] - sends a poke sound message to [username], the message can play only one time within a minute</br>
                /goomba [username] - does the same as /poke but with different sound</br>
                /motd - displays the 'message of the day'</br>
                /math [equation] - does the math and displays the result</br>
                </br>
                Admin commands:</br>
                /clear - hides existing chat messages</br>
                /force reload - reloads chat messages for all users</br>
                /delete last message - probably deletes last message from the chat log</br>
                /hide message [id] - stabs a gnome with a spoon</br>
                /rename bind: [name] to [newname] - renames image bind</br>
                /rename sound bind: [name] to [newname] - renames sound bind</br>
                /delete sound bind: [name] - deletes sound bind permanently</br>
                /add sound bind category: [name] - adds a new sound bind category</br>
                /delete sound bind category: [name] - deletes a sound bind category</br>
                /set sound bind category: [name] to [categoryname] - sets sound bind [name] to category [categoryname], if category doesn't exist then it will be created,
                        if [categoryname] is 'none' (without the quotes) then the bind will be set to category 'other'</br>
                /set motd: [content]</br>
                /add motd: [content] - adds content to already existing motd starting from new line</br>
                /unset motd</br>
                /shutdown</br>
                /server code stats - displays stats on the server code</br>
                /add sound message: [link] - adds a new sound message</br>
                /create bind icons</br>
                /check bind icons</br>
                /copy invalid binds (local only)</br>
                </br>
                /scan</br>
                /banlist</br>
                /ban [username]</br>
                /ban ip [ip]</br>
                /unban ip [ip]</br>
                /unban all</br>
            </div>
        </div>
        <div class="firstTimeWindowTab" id="firstTimeWindowBottom" style="background-color: #121212;">
            <button onclick="$('#firstTimeWindow').toggle();" style="width: 15%; margin-bottom: 10px;">Ok</button>
        </div>
    </div>
</div>

<script>
    function CookiesEnabled(){
        var cookiesEnabled = (navigator.cookieEnabled)?true:false;
        if(typeof navigator.cookieEnabled == "undefined" && !cookieEnabled){
            document.cookie += "testcookie";
            cookieEnabled = (document.cookie.indexOf("testcookie") != -1)?true:false;
        }
        return cookiesEnabled;
    }
    if(!CookiesEnabled()){
        alert("This chat uses cookies to store your session id (just like all websites do) and it can't function without it so you have to turn them on. You will be redirected to the main page.");
        document.location.href="/";
    }
    $('#firstTimeWindowMiddle').css('max-height',$(window).height() * 0.8);
    $('#firstTimeWindowTab1Button').css("background-color", "#333333");
    $('#firstTimeWindowTab1Button').css("border-bottom", "1px solid white");
    $(document).on("click", ".firstTimeWindowTabButton", function(e){
        $('#firstTimeWindowMiddle').find('.firstTimeWindowTab').each(function(){
            $(this).hide();
        });
        $('#firstTimeWindowTabs').find('.firstTimeWindowTabButton').each(function(){
            $(this).css("background-color", "");
            $(this).css("border-bottom", "none");
        });
        $('#firstTimeWindowTab'+$(e.currentTarget).attr("tab")).show();
        $(e.currentTarget).css("background-color", "#333333");
        $(e.currentTarget).css("border-bottom", "1px solid white");
        $('#firstTimeWindowHead').html($(e.currentTarget).attr("tabname"));
    });

    $('#firstTimeWindowSoundMessagesList').on('click', '.soundBindsListCell', function(e){
        $('#msgInput')[0].value += "!"+$(e.target).html();
        $('#firstTimeWindow').hide();
        $('#msgInput').focus();
    });
</script>

