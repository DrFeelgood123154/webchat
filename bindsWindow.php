<?php include_once("filescan.php"); ?>

<style>
    .bindListItem{
        max-width: 50px;
        max-height: 50px;
        margin: 2px;
        cursor: pointer;
        vertical-align: middle;
        background-position: center center; background-size: cover; width: 50px; height: 50px; display: inline-block;
    }
    .bindListItem:hover{
        border: 2px solid green;
        margin: 0px;
    }

    .bindsWindowPageButton{
        margin-left: 1px; margin-right: 1px;
        padding: 1px;
        border: 1px solid gray;
        background-color: black;
        width: 50px;
        display: inline-block;
        cursor: pointer;
    }

    .bindsWindowPageButton:hover{
        background-color: rgb(25, 75, 25);
    }
</style>

<div id="bindsWindow" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; background: rgba(0, 0, 0, 0.8); overflow: hidden; font-family: arial;">
    <div id="bindsWindowContent" style="margin: 10px auto; background-color: black; border: 2px solid gray; width: 50%; text-align:center;">
        <div id="bindsWindowHead" style="font-size: 26px; border-bottom: 1px solid gray;">Reaction images/gifs</div>
        <!-- <div id="bindsWindowTabs" style="border-bottom: 1px solid green;">Page</br></div> -->
        <div id="bindsWindowMiddle" style="background-color: #121212; overflow-y: auto; max-height: 500px;">
            <?php
                $files = ListFiles("binds");
                foreach($files as $listname => $list){
                    foreach($list as $file){
                        $basename = substr($file, 0, strrpos($file, "."));
                        $src = "binds_icons/$basename.png";
                        if(!file_exists($src)) $src = "noimg.png";
                        /*if(preg_match("/(.mp4)$/", $file)){
                            echo "<video class='bindListItem' title='$basename' onclick='SelectBind(\"$basename\")' loop>";
                                echo "<source src='binds/$file' type='video/mp4'>";
                            echo "</video>";
                        }else if(preg_match("/(.webm)$/", $file)){
                            echo "<video class='bindListItem' title='$basename' onclick='SelectBind(\"$basename\")' loop>";
                                echo "<source src='binds/$file' type='video/webm'>";
                            echo "</video>";
                        }else echo "<img class='bindListItem' src='$src' title='$basename' onclick='SelectBind(\"$basename\")'/>";*/
                        //echo "<img class='bindListItem' src='$src' title='$basename' onclick='SelectBind(\"$basename\")'/>";
                        echo "<div class='bindListItem' title='$basename' onclick='SelectBind(\"$basename\")' style='background-image: url(\"$src\");'></div>";
                    }
                }
            ?>
        </div>
        <div id="bindsWindowBottom" style="background-color: #121212; position: relative; padding: 5px;">
            <button onclick="ToggleBindsWindow()" style="width: 15%; display: inline-block;">Cancel</button>
            <div id="bindsWindowSearch" style="display: inline-block; position: absolute; right: 10px;">
                Search:
                <input id="bindsWindowSearchInput" style="width: 100px;"/>
            </div>
        </div>
    </div>
</div>

<script>
    /*var bindsList = <?php echo json_encode(ListFiles("binds")); ?>;

    var bindsPerPage = 15;
    var totalCount = 0;
    var lastPageElement = null;
    var bufferElement = null;
    var bufferBasename = null;
    var bufferSource = null;
    for(var list in bindsList){
        if(bindsList.hasOwnProperty(list)){
            for(var i = 0; i < bindsList[list].length; i++){
                //create new page
                if(totalCount%bindsPerPage == 0){
                    lastPageElement = document.createElement("div");
                    lastPageElement.setAttribute("class", "bindsWindowPage");
                    lastPageElement.setAttribute("id", "bindsWindowPage_"+Math.floor(totalCount/bindsPerPage));
                    if(totalCount != 0) $(lastPageElement).css("display", "none");

                    $(lastPageElement).appendTo("#bindsWindowMiddle");

                    bufferElement = document.createElement("div");
                    bufferElement.setAttribute("class", "bindsWindowPageButton");
                    bufferElement.setAttribute("id", "bindsWindowPageButton_"+Math.floor(totalCount/bindsPerPage));
                    bufferElement.setAttribute("onclick", "SelectBindPage("+Math.floor(totalCount/bindsPerPage)+");");
                    bufferElement.innerHTML = Math.floor(totalCount/bindsPerPage)+1;
                    $(bufferElement).appendTo("#bindsWindowTabs");
                }

                bufferBasename = bindsList[list][i].substr(0, bindsList[list][i].lastIndexOf("."));
                if(bindsList[list][i].match(/(.webm)$/) || bindsList[list][i].match(/(.mp4)$/)){
                    bufferElement = document.createElement("video");
                    bufferElement.setAttribute("loop", "loop");

                    bufferSource = document.createElement("source");
                    //bufferSource.setAttribute("src", "binds/"+bindsList[list][i]);
                    if(bindsList[list][i].match(/(.webm)$/)) bufferSource.setAttribute("type", "video/webm");
                    else bufferSource.setAttribute("type", "video/mp4");
                    bufferElement.appendChild(bufferSource);
                }else{
                    bufferElement = document.createElement("img");
                    //bufferElement.setAttribute("src", "binds/"+bindsList[list][i]);
                }

                if(bufferElement == null) continue;
                bufferElement.setAttribute("file", bindsList[list][i]);
                bufferElement.setAttribute("class", "bindListItem");
                bufferElement.setAttribute("title", bufferBasename);
                bufferElement.setAttribute("onclick", "SelectBind('"+bufferBasename+"')");
                $(bufferElement).load(function(){ console.log("loaded "+$(this).attr("id")); });
                $(bufferElement).appendTo(lastPageElement);
                totalCount++;
            }
        }
    }

    function SelectBindPage(id){
        $('.bindsWindowPage').each(function(){ $(this).hide(); });
        $('.bindsWindowPageButton').each(function(){ $(this).css("background-color", "").css("border-color", ""); });
        $('#bindsWindowPage_'+id).show();
        $('#bindsWindowPageButton_'+id).css("background-color", "rgb(25, 75, 25)").css("border-color", "gold");
        $('#bindsWindowPage_'+id).children().each(function(){
            if($(this).is("video")){
                $(this).children()[0].attr("src", "/binds/"+$(this).attr("file"));
                console.log("test");
            }
        });
    }
    SelectBindPage(0);*/

    function SelectBind(name){
        ToggleBindsWindow();
        $('#msgInput').val("#"+name).focus();
        $('#bindsWindowSearchInput').val("");
        $('#bindsWindowMiddle').children().each(function(){ $(this).show(); });
    }

    $('video.bindListItem').mouseenter(function(event){
        event.target.play();
    }).mouseleave(function(event){
        event.target.pause();
    });

    $('#bindsWindowSearchInput').on("input", function(){
        var search = this.value;
        if(search != ""){
            $('#bindsWindowMiddle').children().each(function(){
                if($(this).attr("title").indexOf(search) == -1) $(this).hide();
                else $(this).show();
            });
        }else $('#bindsWindowMiddle').children().each(function(){ $(this).show(); });
    });
</script>

