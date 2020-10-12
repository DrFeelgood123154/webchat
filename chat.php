<?php
    include_once("frame_normal.php");
?>

<script>
    var hasLoadedLoginform = false;
    var lastMsgContainer = null, lastMsgSender = "", lastPrivTarget = "";

    $(document).on('mousemove', function(){ lastActive = Date.now(); }).on('keydown', function(){ lastActive = Date.now(); });

    var muteAllSounds = false;
    if(window.location.search.indexOf("muted=1") != -1 || GetCookie("muted") == "true") muteAllSounds = true;
    muteAllSounds = !muteAllSounds;
    MuteAllSounds();

    if(window.location.search.indexOf("binds=1") != -1) settings2.set('bindSounds', '1');
    else if(window.location.search.indexOf("binds=0") != -1) settings2.set('bindSounds', '0');

    function MuteAllSounds(){
        muteAllSounds = !muteAllSounds;
        if(muteAllSounds){
            $('audio').each(function(index){ if($(this).attr('class') == 'bindsound') $(this).remove(); });
            $('#muteAllSounds').html("Unmute");
            $('#muteAllSounds').css('background-color', '#224422');
        }else{
            $('#muteAllSounds').html("Mute");
            $('#muteAllSounds').css('background-color', '');
        }
        SetCookie("muted", muteAllSounds);
    }
    //---
    $userListContainer = $('#userListContainer');
    $msgContainer = $('#msgContainer');

    $.get('firsttime.php', function(data){
        $('body').append(data);
        if(GetCookie("chat_firstTime") == ""){
            $('#firstTimeWindow').show();
            muteAllSounds = true;
            $('#muteAllSounds').html("Unmute all sounds");
        }
        SetCookie("chat_firstTime", "1");
    });
    $.get('imageUploadWindow.php', function(data){ $('body').append(data); });
    $.get('fileUploadWindow.php', function(data){ $('body').append(data); });
    $.get('/users/profileimageWindow.php', function(data){ $('body').append(data); });
    $.get('loginform.php', function(data){
        $('body').append(data);
        $.getScript("loginform.js");
        $loginformWindow = $('#loginFormWindow');
        hasLoadedLoginform = true;
    });
    $.get('soundswindow.php', function(data){ $('body').append(data); });
    ///greetings sound
    settings2.onInit = function(){
        if(settings2.get("greetingSound") == "1" && !muteAllSounds && GetCookie("chat_firstTime") != ""){
            var greetingsAudio = new Audio();
            /*var randSound = Math.floor(Math.random()*9+1);
            if(randSound==1) greetingsAudio.setAttribute('src', "sounds/siema.mp3");
            else if(randSound==2) greetingsAudio.setAttribute('src', "sounds/dziendobry.mp3");
            else if(randSound==3) greetingsAudio.setAttribute('src', "sounds/haj.mp3");
            else if(randSound==4) greetingsAudio.setAttribute('src', "sounds/siemanko.mp3");
            else if(randSound==5) greetingsAudio.setAttribute('src', "sounds/siemano.mp3");
            else if(randSound==6) greetingsAudio.setAttribute('src', "sounds/siemaziomus.mp3");
            else if(randSound==7) greetingsAudio.setAttribute('src', "sounds/witam.mp3");
            else if(randSound==8) greetingsAudio.setAttribute('src', "sounds/ey.mp3");
            else if(randSound==9)*/ greetingsAudio.setAttribute('src', "sounds/welcome.mp3");
            greetingsAudio.addEventListener('ended', function(){ $(this).remove(); });
            var volume = parseFloat($('#bindSoundVolume').val()/100);
            if(isNaN(volume)) volume = 0.8;
            volume = Math.min(Math.max(volume, 0), 1);
            greetingsAudio.volume = volume;
            greetingsAudio.preload = "auto";
            greetingsAudio.play();
        }
    }

    function PlaySound(src, isBind = false){
        /*var audio = new Audio();
        audio.setAttribute('src', src);
        audio.addEventListener('ended', function(){ $(this).remove(); });
        var volume = $('#bindSoundVolume').val()/100;
        volume = Math.min(Math.max(volume, 0), 1);
        audio.volume = volume;
        audio.preload = "auto";
        audio.addEventListener('canplaythrough', function(){ console.log($(this).play); $(this).play(); });
        //audio.play();*/
        if(isBind && settings2.get("bindSounds") != "1") return;
        var newAudio = new Audio(src);
        newAudio.addEventListener("ended", function(){ $(newAudio).remove(); });
        newAudio.setAttribute("style", "display:none");
        newAudio.className = "bindsound";
        newAudio.preload = "auto";
        var volume = $('#bindSoundVolume').val()/100;
        volume = Math.min(Math.max(volume, 0), 1);
        newAudio.volume = volume;
        document.body.appendChild(newAudio);
        newAudio.onloadeddata = function(){ newAudio.play(); };
    }
    function AddLeadingZero(v){ if(v <= 9) return "0"+v; else return v; };
    function DecodeHTML(str){
        var textArea = document.createElement('textarea');
        textArea.innerHTML = str;
        return textArea.value;
    }

    function HasAudio(video){ return video.mozHasAudio || Boolean(video.webkitAudioDecodedByteCount) || Boolean(video.audioTracks && video.audioTracks.length); }

    function GetDateFromTs(ts){
        var d = new Date(ts*1000);
        return AddLeadingZero(d.getDate())+"-"+AddLeadingZero(d.getMonth()+1)+"-"+d.getFullYear()+" "
            +AddLeadingZero(d.getHours())+":"+AddLeadingZero(d.getMinutes())+":"+AddLeadingZero(d.getSeconds());
    }
    function GetShortDateFromTs(ts){
        var d = new Date(ts*1000);
        return AddLeadingZero(AddLeadingZero(d.getHours())+":"+AddLeadingZero(d.getMinutes())+":"+AddLeadingZero(d.getSeconds()));
    }

    function GetTimeFromTs(ts){
        var d = ~~(ts / (3600*24));
        var h = ~~((ts % (3600*24))/3600);
        var m = ~~((ts % 3600) / 60);
        var s = Math.floor(ts % 60);

        var ret = "";
        if(d>0) ret += d+"d ";
        if(h>0) ret += h+"h ";
        if(m>0 && ts > 60) ret += m+"m ";
        if(h==0 && m==0) ret += s+"s";
        return ret;
    }

    function GetStrBetween(text, begin, end){
        if(text.indexOf(begin) == -1) return "";
        var SP = text.indexOf(begin)+begin.length;
        var string1 = text.substr(0,SP);
        var string2 = text.substr(SP);
        var endpos = text.indexOf
        if(string2.indexOf(end) == -1) return text.substring(SP);
        var TP = string1.length + string2.indexOf(end);
        return text.substring(SP,TP);
    }
    function ReplaceMsgTag(str, tag, replacement){
        var pos = str.indexOf(tag)+tag.length;
        var part = str.substr(0, str.indexOf(tag));
        pos = str.indexOf("}", pos-1);
        return part+replacement+str.substr(pos+1);
    }
    function RemoveTag(str, tag){
        var pos = str.indexOf(tag)+tag.length;
        var part = str.substr(0, str.indexOf(tag));
        pos = str.indexOf("}", pos-1);
        return [part,str.substr(pos+1)];
    }
    function RemoveWord(str, searchFor, caseSensitive = false){
        if(!caseSensitive) var searchFor = searchFor.toLowerCase();
        var pos = str.indexOf(searchFor);
        var cutpos1 = str.substr(0, pos).lastIndexOf(" ");
        if(cutpos1 == -1) cutpos1 = 0;
        var cutpos2 = str.indexOf(" ", pos);
        var newstr;
        if(cutpos2 == -1) newstr = str.substr(0, cutpos1);
        else newstr = str.substr(0, cutpos1)+str.substr(cutpos2);
        return newstr;
    }
    function StrGetWord(str, searchFor, caseSensitive = false){
        if(!caseSensitive) var searchFor = searchFor.toLowerCase();
        var pos = str.indexOf(searchFor);
        if(pos == -1) return "";
        var cutpos1 = str.substr(0, pos).lastIndexOf(" ");
        if(cutpos1 == -1) cutpos1 = 0;
        var cutpos2 = str.indexOf(" ", pos);
        if(cutpos2 != -1) return str.substr(cutpos1, cutpos2);
        return str.substr(cutpos1);
    }
    function GetMessageTags(msgdata){
        var rep = "";
        var tag = "";

        if(hasLoaded){
            tag = msgdata.text.indexOf("/poke");
            if(tag == 0){
                tag = msgdata.text.substring("/poke".length).trim();
                if(tag == userName && Date.now() >= lastPokeTime + 1*60*1000){
                    PlaySound("sounds/poke.mp3");
                    lastPokeTime = Date.now();
                }
            }
            tag = msgdata.text.indexOf("/goomba");
            if(tag == 0){
                tag = msgdata.text.substring("/goomba".length).trim();
                if(tag == userName && Date.now() >= lastPokeTime + 1*60*1000){
                    PlaySound("sounds/goomba.mp3");
                    lastPokeTime = Date.now();
                }
            }
        }
        tag = GetStrBetween(msgdata.text, "{nolink:", "}");
        if(tag != ""){
            msgdata.text = ReplaceMsgTag(msgdata.text, "{nolink:", tag);
            msgdata.linkify = "no";
        }

        tag = GetStrBetween(msgdata.text, "{img:", "}");
        if(tag != ""){
            if(settings2.get("displayImages") == "1"){
                if(tag.match(/.webp$/) && !HasWEBPSupport){
                    msgdata.text = ReplaceMsgTag(msgdata.text, "{img", "<a href='"+tag+"'>"+tag+"</a><b style='color: red;'>Your web browser doesn't support WEBP images</b>");
                    return msgdata;
                }
                msgdata.callback = function(parentEl){
                    var image = document.createElement("img");
                    image.setAttribute("style", 'max-width: '+settings2.get("maxImageWidth")+'px; max-height: '+settings2.get("maxImageHeight")+'px');
                    image.setAttribute("src", tag);
                    image.setAttribute('class', "chatimage");
                    image.scroll = IsChatAtBottom();
                    image.onload = function(){
                        if(this.scroll) ScrollChat();
                    }
                    parentEl.appendChild(image);
                }
                msgdata.modified = true;
                return msgdata;
            }else{
                rep = "<a href='"+tag+"' target='_blank'>Image: "+tag+"</a>";
                msgdata.text = ReplaceMsgTag(msgdata.text, "{img:", rep);
            }
            msgdata.modified = true;
            return msgdata;
        }

        tag = GetStrBetween(msgdata.text, "{bind:", "}")
        if(tag != ""){
            if(settings2.get("displayImages") == "1"){
                if(tag.match(/.webp$/) && !HasWEBPSupport){
                    msgdata.text = ReplaceMsgTag(msgdata.text, "{img", "<a href='"+tag+"'>"+tag+"</a><b style='color: red;'>Your web browser doesn't support WEBP images</b>");
                    return msgdata;
                }
                msgdata.callback = function(parentEl){
                    var image = document.createElement("img");
                    image.setAttribute("style", 'max-width: '+settings2.get("maxImageWidth")+'px; max-height: '+settings2.get("maxImageHeight")+'px');
                    image.setAttribute("src", tag);
                    image.setAttribute('class', "chatimage");
                    image.scroll = $msgContainer.scrollTop() + $msgContainer.innerHeight() >= $msgContainer[0].scrollHeight-30 || init;
                    image.onload = function(){
                        if(this.scroll && settings2.get("reverseMessages") != "1") ScrollChat();
                    }
                    parentEl.appendChild(image);
                }
                msgdata.modified = true;
                return msgdata;
            }else{
                rep = "<a href='"+tag+"' target='_blank'>Image: "+tag+"</a>";
                msgdata.text = ReplaceMsgTag(msgdata.text, "{img:", rep);
            }
        }

        tag = GetStrBetween(msgdata.text, "{videogif:", "}");
        if(tag != "" && settings2.get("displayImages") == "1"){
            msgdata.callback = function(parentEl){
                var preloadVideos = (settings2.get("preloadVideos")?"auto":"none");
                parentEl.innerHTML += ReplaceMsgTag(msgdata.text, "{file_download:", rep)+"<br/>";
                var video = document.createElement("video");
                var source = document.createElement("source");
                video.setAttribute("style", 'max-width: '+settings2.get("maxImageWidth")+"px; max-height: "+settings2.get("maxImageHeight")+"px");
                video.setAttribute("controls", true);
                video.setAttribute("preload", preloadVideos);
                video.setAttribute("class", "videobind");
                video.autoplay = true;
                video.loop = true;
                video.addEventListener("loadeddata", function(){
                    if(this.scroll && settings2.get("reverseMessages") != "1") ScrollChat();
                    video.play();
                });

                source.setAttribute("src", tag);
                if(/\.mp4$/i.test(tag)) source.setAttribute("type", "video/mp4");
                else if(/\.webm$/i.test(tag)) source.setAttribute("type", "video/webm");
                else if(/\.ogg$/i.test(tag)) source.setAttribute("type", "video/ogg");
                video.appendChild(source);
                parentEl.appendChild(video);
            }
            msgdata.modified = true;
            return msgdata;
        }

        tag = GetStrBetween(msgdata.text, "{bindsound:", "}");
        if(tag != ""){
            if(settings2.get("bindSounds") == "1" && hasLoaded && (Date.now() - lastActive < 5*60*1000 || settings2.get("alwaysPlaySoundMessagse") == "1") && !muteAllSounds){
                var newAudio = new Audio(tag);
                newAudio.addEventListener("ended", function(){ $(newAudio).remove(); });
                newAudio.setAttribute("style", "display:none");
                newAudio.className = "bindsound";
                newAudio.preload = "auto";
                var volume = $('#bindSoundVolume').val()/100;
                volume = Math.min(Math.max(volume, 0), 1);
                newAudio.volume = volume;
                document.body.appendChild(newAudio);
                newAudio.onloadeddata = function(){ newAudio.play(); };
                _playSoundNotification = false; /// variable from js.js
            }
            msgdata.text = ReplaceMsgTag(msgdata.text, "{bindsound:", "<img src='speakericon.png' onclick='PlaySound(\""+tag+"\", true)' title='"+tag+"' style='display: inline-block; height: "+settings2.get('msgFontSize')+"px;'>");
        }

        tag = GetStrBetween(msgdata.text, "{file_download:", "}");
        if(tag != ""){
            link = encodeURIComponent(tag);
            rep = "<b>"+tag+"</b> <a href='/download/?"+link+"' target='_blank'>[Download]</a>";
            if(settings2.get("previewFiles") == "1"){
                if(/\.mp4$/i.test(tag) || /\.webm$/i.test(tag) || /\.ogg$/i.test(tag)){
                    msgdata.callback = function(parentEl){
                        var preloadVideos = (settings2.get("preloadVideos")?"auto":"none");
                        parentEl.innerHTML += ReplaceMsgTag(msgdata.text, "{file_download:", rep)+"<br/>";
                        var video = document.createElement("video");
                        var source = document.createElement("source");
                        video.setAttribute("style", 'max-width: '+settings2.get("maxImageWidth")+"px; max-height: "+settings2.get("maxImageHeight")+"px");
                        video.setAttribute("controls", true);
                        video.setAttribute("preload", preloadVideos);
                        video.scroll = IsChatAtBottom();
                        video.addEventListener("loadeddata", function(){
                            if(this.duration <= 10 && !HasAudio(video)){
                                this.autoplay = true;
                                this.loop = true;
                                this.play();
                                this.oncanplay = null;
                            }
                            if(this.scroll) ScrollChat();
                        });
                        source.setAttribute("src", "/download/files/"+tag);
                        if(/\.mp4$/i.test(tag)) source.setAttribute("type", "video/mp4");
                        else if(/\.webm$/i.test(tag)) source.setAttribute("type", "video/webm");
                        else if(/\.ogg$/i.test(tag)) source.setAttribute("type", "video/ogg");
                        video.appendChild(source);
                        parentEl.appendChild(video);
                    }
                    msgdata.modified = true;
                    return msgdata;
                }else if(/\.mp3$/i.test(tag)){
                    rep += "<br/><audio preload='"+preloadVideos+"' controls>";
                    rep += "<source src='/download/files/"+tag+"' type='audio/mpeg'>";
                    rep += "</audio>";
                }else if(/\.wav$/i.test(tag)){
                    rep += "<br/><audio preload='"+preloadVideos+"' controls>";
                    rep += "<source src='/download/files/"+tag+"' type='audio/wav'>";
                    rep += "</audio>";
                }
            }
            if(settings2.get("displayImages") == "1"){
                if(/\.png$/i.test(tag) || /\.jpg$/i.test(tag) || /\.jpeg$/i.test(tag) || /\.bmp$/i.test(tag) || /\.webp$/i.test(tag) || /\.gif$/i.test(tag)){
                    msgdata.callback = function(parentEl){
                        parentEl.innerHTML += ReplaceMsgTag(msgdata.text, "{file_download:", rep)+"<br/>";
                        var image = document.createElement("img");
                        image.setAttribute("style", 'max-width: '+settings2.get("maxImageWidth")+'px; max-height: '+settings2.get("maxImageHeight")+'px');
                        image.setAttribute("src", "/download/files/"+tag);
                        image.setAttribute('class', "chatimage");
                        image.scroll = IsChatAtBottom();
                        image.onload = function(){
                            if(this.scroll) ScrollChat();
                        }
                        parentEl.appendChild(image);
                    }
                    msgdata.modified = true;
                return msgdata;
                }
            }
            msgdata.text = ReplaceMsgTag(msgdata.text, "{file_download:", rep);
            msgdata.modified = true;
            return msgdata;
        }
        //youtube videos
        if(settings2.get("previewYTVideos") == "1"){
            tag = msgdata.text.indexOf("youtu.be/");
            if(tag == -1) tag = msgdata.text.indexOf("youtube.com/watch");
            if(tag != -1){
                //get link
                var link = GetStrBetween(msgdata.text, "youtu.be/", " ");
                if(link == "") link = GetStrBetween(msgdata.text, "youtube.com/watch?", " ");
                if(link != ""){
                    //if(link.indexOf("&") != -1) link = link.substr(0, link.indexOf("&"));
                    if(link.indexOf("&") != -1 && link.indexOf("v=") != -1) link = GetStrBetween(link, "v=", "&");
                    else if(link.indexOf("v=") != -1) link = link.substr(link.indexOf("v=")+2);
                    var time = link.substr(link.lastIndexOf("t=")+2);
                    if(!(!isNaN(parseFloat(time)) && isFinite(time))){
                        var buffer = 0;
                        var regex = /\d+h/gi;
                        var match = regex.exec(time);
                        if(match != null) buffer += parseInt(match[0].substr(0, match[0].length-1))*60*60;
                        regex = /\d+m/gi;
                        match = regex.exec(time);
                        if(match != null) buffer += parseInt(match[0].substr(0, match[0].length-1))*60;
                        regex = /\d+s/gi;
                        match = regex.exec(time);
                        if(match != null) buffer += parseInt(match[0].substr(0, match[0].length-1));
                        time = buffer;
                    }
                    if(!isNaN(parseFloat(time)) && isFinite(time) && time != 0){
                        if(link.indexOf("?") != -1) link += "&start="+time;
                        else link += "?start="+time;
                    }
                    //msgdata.text = RemoveWord(msgdata.text, "youtube.com/watch");
                    //msgdata.text = RemoveWord(msgdata.text, "youtu.be/");
                    msgdata.text = linkify(msgdata.text);
                    if(msgdata.text != "") msgdata.text += "<br/>";
                    msgdata.text += '<iframe width="'+settings2.get('videoWidth')+'" height="'+settings2.get('videoHeight')+'" src="//www.youtube.com/embed/'+link+'" frameborder="0" allowfullscreen></iframe>';
                    msgdata.modified = true;
                    return msgdata;
                }
            }
        }
        //image and video links
        if(settings2.get("displayImages") == "1"){
            tag = StrGetWord(msgdata.text, ".jpg");
            if(tag == "") tag = StrGetWord(msgdata.text, ".jpeg");
            if(tag == "") tag = StrGetWord(msgdata.text, ".png");
            if(tag == "") tag = StrGetWord(msgdata.text, ".bmp");
            if(tag == "") tag = StrGetWord(msgdata.text, ".gif");
            if(tag == "") tag = StrGetWord(msgdata.text, ".webp");
            if(tag != "" && tag.indexOf("http") == 0){
                tag = DecodeHTML(tag);
                var isLocalServerImage = false;
                if(tag.indexOf("/download/?")){
                    tag = tag.replace("/download/?", "/download/files/");
                    isLocalServerImage = true;
                }
                if(tag.match(/.webp$/) && !HasWEBPSupport){
                    //for 9gag images
                    if(tag.match(/9gag/g)){
                        tag = tag.substr(0, tag.lastIndexOf('_'));
                        tag += "_700b.jpg";
                        msgdata.callback = function(parentEl){
                            parentEl.innerHTML += linkify(this.text)+"<br/>";
                            var image = document.createElement("img");
                            image.setAttribute("style", 'max-width: '+settings2.get("maxImageWidth")+'px; max-height: '+settings2.get("maxImageHeight")+'px');
                            image.setAttribute("src", tag);
                            image.setAttribute("class", "chatimage");
                            image.scroll = IsChatAtBottom();
                            image.onload = function(){
                                if(this.scroll && settings2.get("reverseMessages") != "1") ScrollChat();
                            }
                            parentEl.appendChild(image);
                        }
                        msgdata.modified = true;
                        return msgdata;
                    }else{
                        msgdata.text = ReplaceMsgTag(msgdata.text, "{img", "<b style='color: red;'>Your web browser doesn't support WEBP images</b>");
                        return msgdata;
                    }
                }
                msgdata.callback = function(parentEl){
                    if(!isLocalServerImage) parentEl.innerHTML += linkify(this.text)+"<br/>";
                    var image = document.createElement("img");
                    image.setAttribute("style", 'max-width: '+settings2.get("maxImageWidth")+'px; max-height: '+settings2.get("maxImageHeight")+'px');
                    image.setAttribute("src", tag);
                    image.setAttribute("class", "chatimage");
                    image.scroll = IsChatAtBottom();
                    image.onload = function(){
                        if(this.scroll && settings2.get("reverseMessages") != "1") ScrollChat();;
                    }
                    parentEl.appendChild(image);
                }
                msgdata.modified = true;
                return msgdata;
            }
            tag = StrGetWord(msgdata.text, ".webm");
            if(tag == "") tag = StrGetWord(msgdata.text, ".mp4");
            if(tag == "") tag = StrGetWord(msgdata.text, ".ogg");
            if(tag != "" && tag.indexOf("http") == 0){
                tag = tag.replace("&amp;", "&");
                msgdata.callback = function(parentEl){
                    var preloadVideos = (settings2.get("preloadVideos")?"auto":"none");
                    parentEl.innerHTML += linkify(this.text)+"<br/>";
                    var video = document.createElement("video");
                    var source = document.createElement("source");
                    video.setAttribute("style", 'max-width: '+settings2.get("maxImageWidth")+"px; max-height: "+settings2.get("maxImageHeight")+"px");
                    video.setAttribute("controls", true);
                    video.setAttribute("preload", preloadVideos);
                    video.scroll = IsChatAtBottom();
                    video.addEventListener("loadeddata", function(){
                        if(this.duration <= 10 && !HasAudio(video)){
                            this.autoplay = true;
                            this.loop = true;
                            this.play();
                            this.oncanplay = null;
                        }
                        if(this.scroll) ScrollChat();
                    });
                    source.setAttribute("src", tag);
                    if(tag.indexOf(".webm") != -1) source.setAttribute("type", "video/webm");
                    if(tag.indexOf(".mp4") != -1) source.setAttribute("type", "video/mp4");
                    if(tag.indexOf(".ogg") != -1) source.setAttribute("type", "video/ogg");
                    video.appendChild(source);
                    parentEl.appendChild(video);
                }
                msgdata.modified = true;
                return msgdata;
            }
        }
        return msgdata;
    }

    function GetSimpleMessageTags(msgdata){
        var rep = "";
        var tag = GetStrBetween(msgdata.text, "{img:", "}");
        if(tag != ""){
            if(settings2.get("displayImages") == "1") rep = "<img class='chatimage' src='"+tag+"' style='max-width: "+settings2.get("maxImageWidth")+"px; max-height: "+settings2.get("maxImageHeight")+"px'/>";
            else rep = "<a href='"+tag+"' target='_blank'>Image: "+tag+"</a>";
            msgdata.text = ReplaceMsgTag(msgdata.text, "{img:", rep);
            msgdata.modified = true;
            return msgdata;
        }
        tag = GetStrBetween(msgdata.text, "{file_download:", "}");
        if(tag != ""){
            rep = "<a href='/download/?"+tag+"' target='_blank'>"+tag+"</a>";

            msgdata.text = ReplaceMsgTag(msgdata.text, "{file_download:", rep);
            msgdata.modified = true;
            return msgdata;
        }

        tag = GetStrBetween(msgdata.text, "{bindsound:", "}");
        if(tag != ""){
            if(settings2.get("bindSounds") == "1" && hasLoaded && Date.now() - lastActive < 5*60*1000 && !muteAllSounds){
                var newAudio = new Audio(tag);
                newAudio.addEventListener("ended", function(){ $(newAudio).remove(); });
                newAudio.setAttribute("style", "display:none");
                newAudio.className = "bindsound";
                newAudio.preload = "auto";
                var volume = $('#bindSoundVolume').val()/100;
                volume = Math.min(Math.max(volume, 0), 1);
                newAudio.volume = volume;
                document.body.appendChild(newAudio);
                newAudio.onloadeddata = function(){ newAudio.play(); };
            }
            msgdata.text = ReplaceMsgTag(msgdata.text, "{bindsound:", "");
        }
        return msgdata;
    }

    function _UpdateUserList(data){
        $userListContainer.html('');
        if(data == null || data.length == 'undefined' || data.length == null){
            $('#usersConnected').html("Users: 0?");
            return;
        }
        $('#usersConnected').html("Users: "+data.length);
        $.each(data, function(i, val){
            var timeDiff = Date.now()/1000 - val[2];

            var userTable = document.createElement("table");
            userTable.setAttribute('style', settings2.get("userlist_table"));
            userTable.setAttribute('user', val[1]);
            userTable.className = "userDataTable";
            if(val[1] == pmTarget) $(userTable).css('background-color', settings2.get('pmInputColor'));
            var timeRow = document.createElement("tr");
            var td1 = document.createElement("td");
            var statusRow = document.createElement("tr");
            var statusCell = document.createElement("td");
            var nameRow = document.createElement("tr");
            var td2 = document.createElement("td");
            var imageRow = document.createElement("tr");
            var td3 = document.createElement("td");
            var image = document.createElement("img");
            var src = val[4];
            if(src == "") src = "noimg.png?1";
            else src = "/users/userimages/"+src;
            image.setAttribute('src', src);
            image.setAttribute('style', settings2.get("userlist_userimage"));
            image.setAttribute('onError', 'DefaultImage(this)');
            if(Date.now()/1000-val[3] >= 10 && Date.now()/1000-val[3] < 30) timeRow.setAttribute("style", "color: yellow");
            else if(Date.now()/1000-val[3] > 30) timeRow.setAttribute("style", "color: red");
            td1.setAttribute("style", settings2.get("userlist_usertime"));
            td2.setAttribute("style", settings2.get("userlist_username"));
            td3.setAttribute('style', settings2.get("userlist_userimagecell"));

            if(settings2.get("userListBorderColor") != ""){
                $(td3).css("border-bottom-color", settings2.get("userListBorderColor"));
            }

            $(nameRow).css('color', settings2.get('userListNameColor'));
            $(td1).css('color', settings2.get('userListTimeColor'));
            //user status
            statusRow.setAttribute("style", "font-size: 10.5px; font-weight: bold; margin: 0px; height: 8px; line-height: 8px;");
            if(val[5] == '1'){
                statusCell.setAttribute("style", "color: rgb(230, 180, 0);");
                statusCell.innerHTML = "AFK";
            }else if(val[5] == '2'){
                statusCell.setAttribute("style", "color: rgb(230, 130, 0);");
                statusCell.innerHTML = "Snooze";
            }else{
                if(Date.now()/1000-val[3] > 30){
                    statusCell.setAttribute('style', "color: red");
                    statusCell.innerHTML = "Offline";
                }else if(Date.now()/1000-val[3] >= 10){
                    statusCell.setAttribute("style", "color: yellow");
                    statusCell.innerHTML = "-";
                }else{
                    statusCell.setAttribute("style", "color: rgb(0, 190, 0);");
                    statusCell.innerHTML = "Online";
                }
            }
            if(val[6] == 0){
                var speakerIcon = $('<img>');
                $(speakerIcon).attr('src', "speakericon2.png");
                $(speakerIcon).attr('style', "display: inline; max-height: 12px");
                speakerIcon.appendTo(statusCell);
                userTable.title += "User has disabled sound messages\n";
            }
            $(statusCell).css("margin-top: -5px;");

            userTable.appendChild(timeRow);
            timeRow.appendChild(td1);
            userTable.appendChild(statusRow);
            statusRow.appendChild(statusCell);
            userTable.appendChild(nameRow);
            nameRow.appendChild(td2);
            userTable.appendChild(imageRow);
            imageRow.appendChild(td3);
            td1.innerHTML = GetTimeFromTs(timeDiff);
            td2.innerHTML = val[1];
            td3.appendChild(image);
            $userListContainer.append(userTable);
        });
    }

    var lastEventTs = 0;
    function ChatEventsHandler(msgData){
        if(msgData[6] == 1 && msgData[3].indexOf("{EVENT") === 0){
            var event = msgData[3].substring(0, msgData[3].lastIndexOf("}"));
            event = event.split(":", 2);
            if(event[1] != null) event = event[1];
            else event = "";

            var isNewEvent = true;
            if(lastEventTs >= msgData[1]) isNewEvent = false;
            else lastEventTs = msgData[1];
            if(event == "CLEAR"){
                for(var i = $msgContainer.children().length; i>0; i--) $msgContainer.children()[i-1].remove();
                msgData[3] = "-The chat log has been cleared-";
            }else if(event == "LOGRESET"){
                if(hasLoaded && isNewEvent){
                    for(var i = $msgContainer.children().length; i>0; i--) $msgContainer.children()[i-1].remove();
                    lastMsgId = 0;
                }
                return false;
            }else if(event.indexOf("DELETEMSG") === 0){
                var msgId = event.substr(event.indexOf("=")+1);
                $target = $('div[msgid="'+msgId+'"]');
                if($target.length == 0) return false;
                $parent = $($target).parent();
                $($target).remove();

                if($($parent).children().length == 0){
                    $($parent).parentsUntil(".chatmsg").parent().remove();
                    lastMsgContainer = null;
                }
                return false;
            }
        }
        return true;
    }

    function _UpdateMessages(data){
        ///is new message
        var lineDiv = null;
        if((document.hidden || !window.document.hasFocus()) && $newMessagesLine == null && hasLoaded){
            var lineDiv = document.createElement("div");
            lineDiv.setAttribute('style', "width: 75%; margin: 0 auto; border-bottom: double 2px; border-radius: 5px; text-align: center; font-size: 26px; text-shadow: 2px 2px black;");
            $(lineDiv).css("color", settings2.get("newMsgLineColor"));
            if(settings2.get("reverseMessages") == "1"){
                $(lineDiv).css("border-top", "double 2px");
                $(lineDiv).css("border-bottom", "none");
            }
            $(lineDiv).css("border-color", settings2.get("newMsgLineBorderColor"));
            lineDiv.id = "newMessagesLine";
            lineDiv.innerHTML = "New messages";
        }
        if(settings2.get("simpleChat") == "0"){
            $.each(data, function(i, val){
                if(ChatEventsHandler(val) == false) return;
                ///tags and links
                var msgdata = { text: val[3], modified: false, callback: null };
                GetMessageTags(msgdata);
                if(msgdata.modified == false && !msgdata.linkify) msgdata.text = linkify(msgdata.text);
                ///colors
                var msgColor = settings2.get("fixedMsgTextColor");
                if(msgColor == "" && val[4] != "") msgColor = val[4];
                if(msgColor == "") msgColor = settings2.get("msgTextColor");

                //join
                if(lastMsgSender == val[2] && $msgContainer.length < 1000 && lastPrivTarget == val[7]){ ///append to last
                    if(settings2.get("joinMessages") == "1" && val[1] - lastMsgTime < settings2.get("joinMessagesTime")){
                        if(lastMsgContainer != null){
                            if(lineDiv != null){
                                $(lineDiv).css("border-top", "");
                                if(settings2.get("reverseMessages") == "1"){
                                    $(lineDiv).css("border-bottom", "double 2px");
                                    $(lineDiv).css("border-color", settings2.get("newMsgLineBorderColor"));
                                }
                                lastMsgContainer.appendChild(lineDiv);
                                $newMessagesLine = lineDiv;
                            }
                            var textDiv = document.createElement("div");
                            textDiv.setAttribute("msgid", val[0]);
                            if(msgColor != "") textDiv.setAttribute("style", "color: "+msgColor);

                            if(msgdata.callback != null) msgdata.callback(textDiv);
                            else textDiv.innerHTML = msgdata.text;

                            lastMsgContainer.appendChild(textDiv);
                        }
                        lastMsgSender = val[2];
                        lastMsgTime = val[1];
                        return;
                    }
                }
                //normal
                if(lineDiv != null){
                    if(settings2.get("reverseMessages") != "1") $msgContainer.append(lineDiv);
                    else $msgContainer.prepend(lineDiv);
                    $newMessagesLine = lineDiv;
                }
                lastMsgSender = val[2];
                lastMsgTime = val[1];
                lastPrivTarget = val[7];

                if(typeof MessageBuildMethod === "function") var msgDiv = MessageBuildMethod(val, msgdata, msgColor);
                else{
                    var msgDiv = document.createElement("div");
                    msgDiv.setAttribute('style', "margin-bottom: "+settings2.get("msgMargin")+"px;");
                    msgDiv.setAttribute('class', 'chatmsg');
                    msgDiv.setAttribute('sender', val[2]);
                    if(val[7].length > 0) msgDiv.setAttribute('pm', val[7]);
                    if(pmTarget != "") $(msgDiv).hide();
                    if((pmTarget != "" && val[7] == userName) || (pmTarget != "" &&  val[2] == userName)
                        || (val[7] == "" && settings2.get("globalWithPM") == "1")) $(msgDiv).show();
                    var table1 = document.createElement("table");
                    table1.style.width = "100%";
                    var tr1 = document.createElement("tr");
                    var imageCell = document.createElement("td");
                    imageCell.setAttribute('rowspan', '2');
                    imageCell.setAttribute("style", "vertical-align:top; horizontal-align: center; width: "+settings2.get("avatarSize")+"px;");
                    var imageCenter = document.createElement("center");
                    var image = document.createElement("img");
                    var imgsrc = "";
                    if(val[6] == 1) imgsrc = "server.jpg";
                    else if(val[5] != "") imgsrc = "/users/userimages/"+val[5];
                    else imgsrc = "noimg.png?1";
                    image.setAttribute('src', imgsrc);
                    image.setAttribute('onError', 'DefaultImage(this)');
                    image.setAttribute('style', "margin-left: -5px; max-width: "+settings2.get("avatarSize")+"px; max-height: "+settings2.get("avatarSize")+"px;");

                    imageCell.appendChild(imageCenter);
                    imageCenter.appendChild(image);
                    var msgSendData = document.createElement("td");
                    msgSendData.innerHTML = val[2];
                    if(val[7] != ""){
                        var text = document.createElement("div");
                        if(val[2] == userName) text.innerHTML = " ⇨ "+val[7]+" ⇦";
                        else text.innerHTML = " (PM)";
                        text.style = "display: inline; font-weight: bold; font-size: "+(settings2.get("senderFontSize") - 6)+"px; color: "+settings2.get("pmColor")+";";
                        msgSendData.appendChild(text);
                    }

                    //msg data + border
                    msgSendData.setAttribute('style', 'position: relative; height: 1px; color: '+settings2.get("senderTextColor")+'; border-bottom: 1px solid #465645; vertical-align: top; font-size: '+settings2.get("senderFontSize")+'px;');
                    if(settings2.get("msgTopBorder") == "0") $(msgSendData).css('border-bottom', 'none');
                    else if(settings2.get("messageDataBorderColor") != "") $(msgSendData).css("border-bottom-color", settings2.get("messageDataBorderColor"));
                    if(val[7] != "" && settings2.get("pmMsgBackground") != "none"){
                        $(msgSendData).css("background-color", settings2.get("pmMsgBackground"));
                        $(msgSendData).css("border-radius", "5px");
                    }

                    var rightDiv = document.createElement('div');
                    rightDiv.setAttribute('style', 'float:right; margin-left: 15px; margin-right: 5px; color: '+settings2.get("dateTextColor")+'; font-size: '+settings2.get("dateFontSize")+'px;');
                    if(settings2.get("datePosition") == "0"){
                        $(rightDiv).css("float", "none");
                        $(rightDiv).css("display", "inline-block");
                    }
                    if(settings2.get("dateBelowSender") == "1"){
                        $(rightDiv).css("float", "");
                        $(rightDiv).css("position", "absolute");
                        $(rightDiv).css("top", settings2.get("senderFontSize")+"px");
                        $(rightDiv).css("left", "10px");
                    }
                    rightDiv.innerHTML = GetDateFromTs(val[1]);

                    var tr2 = document.createElement("tr");
                    var msgTextContainer = document.createElement("td");
                    msgTextContainer.setAttribute('style', 'font-size: '+settings2.get("msgFontSize")+'px; color: '+msgColor+';');
                    msgTextContainer.setAttribute("class", "msgTextContainer");
                    var msgText = document.createElement("div");
                    if(settings2.get("msgBackground") == "1") msgText.setAttribute('style', DecodeHTML(settings2.get("msgStyle")));

                    var msgTextLine = document.createElement("div");
                    msgTextLine.setAttribute("msgid", val[0]);
                    if(msgdata.callback != null) msgdata.callback(msgTextLine);
                    else msgTextLine.innerHTML = msgdata.text;

                    msgDiv.appendChild(table1);
                    table1.appendChild(tr1);
                    tr1.appendChild(imageCell);
                    tr1.appendChild(msgSendData);
                    msgSendData.appendChild(rightDiv);
                    table1.appendChild(tr2);
                    msgTextContainer.appendChild(msgText);
                    msgText.appendChild(msgTextLine);
                    tr2.appendChild(msgTextContainer);
                }

                //msgDiv.className = "msgDiv";
                if(settings2.get("reverseMessages") != "1") $msgContainer.append(msgDiv);
                else $msgContainer.prepend(msgDiv);
                lastMsgContainer = msgText;
            });
        }else{
            $.each(data, function(i, val){
                if(ChatEventsHandler(val) == false) return;
                ///tags and links
                var msgdata = { text: val[3], modified: false };
                GetSimpleMessageTags(msgdata);
                val[3] = linkify(val[3]);
                ///colors
                var msgColor = settings2.get("fixedMsgTextColor");
                if(msgColor == "" && val[4] != "") msgColor = val[4];
                if(msgColor == "") msgColor = settings2.get("msgTextColor");

                //join
                if(settings2.get("joinMessages") == "1" && lastMsgSender == val[2] && $msgContainer.length < 1000 && lastPrivTarget == val[7]){ ///append to last
                    if(val[1] - lastMsgTime < settings2.get("joinMessagesTime")){
                        if(lastMsgContainer != null){
                            if(lineDiv != null){
                                if(settings2.get("reverseMessages") != "1") lastMsgContainer.appendChild(lineDiv);
                                else lastMsgContainer.prepend(lineDiv);
                                $newMessagesLine = lineDiv;
                            }
                            var textDiv = document.createElement("div");
                            textDiv.setAttribute("msgid", val[0]);
                            if(msgColor != "") textDiv.setAttribute("style", "color: "+msgColor);
                            textDiv.innerHTML = val[3];
                            lastMsgContainer.appendChild(textDiv);
                        }
                        lastMsgSender = val[2];
                        lastMsgTime = val[1];
                        return;
                    }
                }
                //normal
                if(lineDiv != null){
                    if(settings2.get("reverseMessages") != "1") $msgContainer.append(lineDiv);
                    else $msgContainer.prepend(lineDiv);
                    $newMessagesLine = lineDiv;
                }
                lastMsgSender = val[2];
                lastMsgTime = val[1];
                lastPrivSender = val[7];

                var msgDiv = document.createElement("div");
                msgDiv.setAttribute('class', 'chatmsg');
                msgDiv.setAttribute('style', "margin-bottom: "+settings2.get("msgMargin")+"px;font-size: "+settings2.get("msgFontSize")+'px; width: '+($('#table3').width*0.8)+"px");
                var msgTime = document.createElement("div");
                msgTime.setAttribute("style", "display: inline-block; text-align: left; margin-right: 10px; color: "+settings2.get("dateTextColor")+";");
                msgTime.innerHTML = "["+GetShortDateFromTs(val[1])+"]";
                var msgSender = document.createElement("div");
                msgSender.setAttribute("style", "display: inline-block; text-align: left; margin-right: 10px;");
                msgSender.innerHTML = val[2];
                if(val[7] != "") msgSender.innerHTML += " (PM→"+val[7]+")";
                msgSender.innerHTML += ": ";
                var msgText = document.createElement("div");
                msgText.setAttribute("style", "display: inline-block; text-align: left; color: "+msgColor+'; word-break: break-word;');

                var msgTextLine = document.createElement("div");
                if(msgdata.callback != null) msgdata.callback(msgTextLine);
                else msgTextLine.innerHTML = msgdata.text;
                msgTextLine.setAttribute("msgid", val[0]);

                msgDiv.appendChild(msgTime);
                msgDiv.appendChild(msgSender);
                msgDiv.appendChild(msgText);
                msgText.appendChild(msgTextLine);

                if(settings2.get("reverseMessages") != "1") $msgContainer.append(msgDiv);
                else $msgContainer.prepend(msgDiv);
                lastMsgContainer = msgText;
            });
        }
    }

    //login stuff
    function UpdateUsername(){
        $('#renameInput').val(guestName);
    }

    if(userName != ""){
        $('#userData_name').html(userName);
        $('#userData_notlogged').hide();
        $('#userData_logged').show();
    }

    function Logout(){
        $.ajax({
            timeout: 30000,
            url: '/loginRequest.php',
            data: {action: 'Logout'},
            type: 'post',
            success: function(){
                $('#userData_notlogged').show();
                $('#userData_logged').hide();
                userName = "";
            },
            error: function(xml, status, msg){
                console.log("Logout request failed: ");
                console.log(msg);
            }
        });
    }

    function OnLoginSuccess(username){
        console.log("Logged in as "+username);
        $('#userData_name').html(username);
        $('#userData_notlogged').hide();
        $('#userData_logged').show();
        $('#loginFormWindow').hide();
        userName = username;
    }

    $('#loginButton').click(function(){
        if(!hasLoadedLoginform){
            $.get('loginform.php', function(data){
                $('body').append(data);
                $.getScript("loginform.js");
                hasLoadedLoginform = true;
                $loginformWindow = $('#loginFormWindow');
                $loginformWindow.toggle();
            });
        }else $loginformWindow.toggle();
    });

    //radio
    function Radio(){
        if($('#radioDivContainer').length == 0){
            var radioDivContainer = document.createElement("div");
            radioDivContainer.id = "radioDivContainer";
            radioDivContainer.setAttribute("style", "z-index: 5; position: fixed; right: 0px; top: 0px; height: 100%; width: 20%; pointer-events: none;");
            var table = document.createElement("table");
            table.setAttribute("style", "float:right; height: 100%;");
            var tr = document.createElement("tr");

            var buttonPart = document.createElement("td");
            buttonPart.setAttribute("style", "vertical-align:top; margin-right: 0px;");
            var toggleRadioButton = document.createElement("button");
            toggleRadioButton.id = "toggleRadioButton";
            toggleRadioButton.setAttribute("style", "width: 20px; float:right; margin: 50px auto; pointer-events: auto;");
            toggleRadioButton.setAttribute("onclick", "ToggleRadio()");
            toggleRadioButton.innerHTML = ">";

            var contentPart = document.createElement("td");
            contentPart.id = "contentPart";
            contentPart.setAttribute("style", "display: block; height: 100%; background-color:gray; color: black; border-left: 2px solid black; pointer-events: auto;");
            var radioContent = document.createElement("div");
            radioContent.innerHTML = "<center>Loading</center>";
            $.get("/asdf4/nobody.php", function(data){
                $(radioContent).html(data);
            });
            radioContent.setAttribute("style", "height: "+$(window).height()*0.93+"px; overflow: auto;");
            var bottom = document.createElement("div");
            bottom.setAttribute("style", "float: bottom; height: "+$(window).height()*0.07+"px; margin: 0 auto; padding-top: 10px; border-top: solid 2px black;");
            var buttonCenter = document.createElement("center");
            var closeButton = document.createElement("button");
            closeButton.setAttribute("style", "width: 100px;");
            closeButton.setAttribute("onclick", "$('#radioDivContainer').remove()");
            closeButton.innerHTML = "Close";
            var mainPageButton = document.createElement("button");
            mainPageButton.setAttribute("style", "width: 100px;");
            mainPageButton.setAttribute("onclick", "window.open('/asdf4/');");
            mainPageButton.innerHTML = "Main page";

            radioDivContainer.appendChild(table);
            table.appendChild(tr);
            tr.appendChild(buttonPart);
            buttonPart.appendChild(toggleRadioButton);
            tr.appendChild(contentPart);
            contentPart.appendChild(radioContent);
            contentPart.appendChild(bottom);
            buttonCenter.appendChild(closeButton);
            buttonCenter.appendChild(mainPageButton);
            bottom.appendChild(buttonCenter);
            $('body').append(radioDivContainer);
        }else ToggleRadio();
    }

    function ToggleRadio(){
        $contentPart = $('#contentPart');
        $contentPart.toggle();
        $_button = $('#toggleRadioButton');
        if($contentPart.is(':visible')) $_button.html(">");
        else $_button.html("<");
    }

    ///events
    var wasBottomBeforeHover = false;
    $(document).on("mouseenter", ".chatimage", function(e){
        wasBottomBeforeHover = IsChatAtBottom();
        if(settings2.get("expandOnHover") != "1") return;
        var _width = settings2.get('maxExpandWidth');
        if(_width >= $('#msgContainer').width() * 0.80) _width = $('#msgContainer').width() * 0.80 + "px";
        else _width += "px";
        $(this).stop().animate({ maxWidth: _width, maxHeight: settings2.get("maxExpandHeight")+"px"}, 250);
        /*if($(e.target).parent().find("#imgZoomButton").length == 0){
            var button = document.createElement("div");
            var href = document.createElement("a");
            button.setAttribute("style", "position: absolute; top: 0px; left: 0px; width: 30px; height: 30px; cursor: zoom-in; font-size: 25px; text-align: center; color: white; background: rgba(0, 0, 0, 0.7)");
            button.id = "imgZoomButton";
            button.innerHTML = "+";
            $(button).on("click", function(){ window.open($(e.target).prop("src")); });
            $(e.target).parent().append(button);
            $(e.target).parent().css("position", "relative");
        }*/
        $(e.target).on("mouseleave", function(){
            if(wasBottomBeforeHover) ScrollChat();
            $(e.target).parent().find("#imgZoomButton").remove();
            $(e.target).off("mouseleave");
            $(e.target).stop().animate({maxWidth: settings2.get("maxImageWidth")+"px", maxHeight: settings2.get("maxImageHeight")+"px"}, 0);
        });
    });

    $(document).on("click", ".chatimage", function(e){
        $msgContainer.animate({
            scrollTop: $(e.target).offset().top - $msgContainer.offset().top + $msgContainer.scrollTop() - (parseInt(settings2.get("senderFontSize"))+10)
        }, 250);
    });

    $(document).on("dblclick", ".chatimage", function(e){
        window.open($(this).attr("src"), "_blank");
    });

    $($msgContainer).on("scroll", function(){
        $('video').each(function(){
            if($(this).attr("autoplay") == "autoplay" && $(this).attr("class") != "videobind"){
                var rect = $(this)[0].getBoundingClientRect();
                var visible = (rect.top+rect.height > $(window).height() || rect.bottom < 0+rect.height);

                var d = new Date();
                if(visible && !$(this)[0].paused) $(this)[0].pause();
            }
        });
    });
    $('#userListContainer').on('click', '.userDataTable', function(){
        var target = $(this).attr('user');
        if(target == pmTarget) target = "";
        $('#privInput').val(target);
        $('#privInput').trigger('change');
        $('#msgInput').focus();
        TogglePM(target);
    });

    $('#privInput').on("change", function(){
        if($('#privInput').val().length > 0){
            $('#privInput').css('background-color', settings2.get('pmInputColor'));
            $('#msgInput').css('background-color', settings2.get('pmInputColor'));
        }else{
            $('#privInput').css('background-color', "");
            $('#msgInput').css('background-color', "");
            settings2.apply("messageInputStyle");
        }
    }).on('focusout', function(){
        TogglePM($(this).val());
    });

    //-colors
    var defaultColor = $('#userMsgColor').css('color');
    settings2.afterLoad.push( function(){ setTimeout(function(){ defaultColor = $('#msgInput').css('color'); }, 1000); } )
    function isHex(h){
        var a = parseInt(h,16);
        return(a.toString(16) === h.toLowerCase());
    }
    function ApplyColor(){
        var color = $('#userMsgColor').val();
        if(!color){
            $('#userMsgColor').css('color', defaultColor);
            $('#msgInput').css('color', defaultColor);
            settings2.apply("messageInputStyle");
        }
        color = color.replace(/ /g, '').toLowerCase();
        if(color == '') color = defaultColor;
        if(isHex(color) && (color.length == 3 || color.length == 6)) color = "#"+color;
        $('#userMsgColor').css('color', defaultColor);
        $('#msgInput').css('color', defaultColor);
        $('#userMsgColor').css('color', color);
        $('#msgInput').css('color', color);
    }
    $('#userMsgColor').on('input', function(){ ApplyColor(); });
    setTimeout(function(){ ApplyColor(); }, 1000);

    //other
    if(spooktober) $.getScript('spooktober/script.js');

    sourcesLoaded['chat'] = true;
    if(typeof(LoadSettings) == "function") LoadSettings();
</script>
