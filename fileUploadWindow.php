<div id="fileUploadWindow" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; overflow: hidden; overflow-y: auto; pointer-events: none;">
    <div id="fileUploadWindowContent" style="margin: 100px auto; background-color: black; border: 2px solid gray; width: 20%; text-align:center; pointer-events: auto;">
        <div style="border-bottom: 1px solid gray; font-size: 26px;">File upload</div>
        <center style="margin: 15px;">Select file</center>
        <center><input id="fileUploadWindowInput" type="file" style="width: 80%;"/></center>
        <center id="fileUploadWindowInfo"></center>
        <center><input type="checkbox" id="fileUploadWindowCheckbox" checked="true">Post link in the chat</input></center>
        <center style="margin-bottom: 15px; margin-top: 15px;">
            <button onclick="FileUploadConfirm()">Upload</button>
            <button onclick="$('#fileUploadWindow').hide();">Cancel</button>
        </center>
    </div>
</div>

<div id="fileUploadProgressWindow" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; pointer-events: none;">
    <div id="fileUploadProgressContent" style="min-width: 150px; max-width: 400px; margin: 3% auto; background-color: black; border: 2px outset gray;
         font-size: 16px; word-break: break-word; background-image: linear-gradient(black 15%, rgba(25, 25, 25)); border-radius: 10px; pointer-events: auto;
         padding: 5px; padding-top: 2px;">
        <center id="fileUploadProgressTop" style="cursor: move;">Uploading file...</center>
        <center id="fileUploadProgressMiddle" style="padding: 3px;">asdffdsa</center>
        <center id="fileUploadProgressBottom;">
            <button id="fileUploadAbort" onclick="AbortFileUpload()" style="height: 18px; font-size: 15px; font-weight: bold; width: 75px; padding: 0px; border: 0px;">Abort</button>
            <button id="fileUploadCopy" onclick="CopyUploadLink()" style="height: 18px; font-size: 15px; font-weight: bold; width: 75px; padding: 0px; border: 0px;">Copy link</button>
            </center>
    </div>
</div>

<div id="fileUploadWindowOverlay" style="display: none; background-color: rgba(0, 0, 0, 0.8);
        width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; overflow: hidden; overflow-y: auto; color: white; font-size: 36px;">
    <center style="margin: 0 auto;">
        Drop file to upload it
        <br/>
        <button onclick="$('#fileUploadWindowOverlay').hide();">Cancel</button>
    </center>
</div>
<script>
    var isUploadingFile = false;
    var fileUploadBeginTime = 0;
    var fileUploadXhr = null;
    $fileUploadWindowOverlay = $('#fileUploadWindowOverlay');

    function ShortFileSize(bytes){
        if(bytes == 0) return '0 Bytes';
        var k = 1024,
           sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
           i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2))+' '+sizes[i];
    }
    function FileUploadWindow(){
        if(isUploadingFile) $('#fileUploadProgressWindow').toggle();
        else $('#fileUploadWindow').show();
        if(!isUploadingFile){
            $('#fileUploadProgressBottom').show();
            $('#fileUploadAbort').html("Abort");
            $('#fileUploadCopy').hide();
        }
    }

    function FileUploadError(errText){
        $('#fileUploadProgressTop').html("Error");
        $('#fileUploadProgressMiddle').html(errText);
        $('#fileUploadProgressBottom').show();
        $('#fileUploadProgressWindow').show();
        $('#fileUploadAbort').html("Ok");
        $('#fileUploadCopy').hide();
        $('#fileUploadWindowInput').val('');
    }

    function FileUploadConfirm(){
        var fileData = $('#fileUploadWindowInput').prop("files");
        if(fileData[0] == null){
            $('#fileUploadWindowInfo').html("No file chosen for upload");
            return;
        }

        isUploadingFile = true;
        $('#fileUploadWindow').hide();
        $('#fileUploadProgressWindow').show();
        $('#fileUploadProgressTop').html("Uploading...");

        var postInChat = $('#fileUploadWindowCheckbox').prop("checked")?"true":"false";
        var data = new FormData();
        data.append('action', "FileUpload");
        data.append('postInChat', postInChat);
        data.append('file', fileData[0]);
        data.append('privTarget', pmTarget);
        $.ajax({
            url: '/fileupload.php',
            type: 'POST',
            data: data,
            timeout: 12*60*60*1000,
            xhr: function(){
                    fileUploadXhr = $.ajaxSettings.xhr();
                    fileUploadBeginTime = Date.now();

                    fileUploadXhr.upload.onprogress = function(e){
                        var p = Math.floor((e.loaded / e.total)*100);
                        if(p <= 100){
                            $('#fileUploadProgressTop').html("Uploading: "+p+"%");

                            var timepassed = (Date.now() - fileUploadBeginTime)/1000;
                            var bps = (timepassed)? e.loaded/timepassed : 0;

                            var midstr = ShortFileSize(e.loaded)+" / "+ShortFileSize(e.total)+"</br>";
                            midstr += ShortFileSize(bps)+"/s";
                            $('#fileUploadProgressMiddle').html(ShortFileSize(e.loaded)+" / "+ShortFileSize(e.total));
                        }else{
                            $('#fileUploadProgressTop').html("Processing file...");
                            $('#fileUploadProgressMiddle').html("");
                            $('#fileUploadProgressBottom').hide();
                        }
                    };
                    fileUploadXhr.onerror = function(e){
                        console.log("Error uploading file: ");
                        console.log(e);
                        FileUploadError("Error uploading file");
                    }
                    fileUploadXhr.onabort = function(e){
                        console.log("File aborted");
                        console.log(e);
                        FileUploadError("Error uploading file (aborted)");
                    }
                    return fileUploadXhr;
            },
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            dataType: 'json',
            success: function(response){
                isUploadingFile = false;
                if(response[0] != ""){
                    console.log(response[0]);
                    $('#fileUploadProgressTop').html("Error");
                    $('#fileUploadProgressMiddle').html(response[0]);
                }else{
                    $('#fileUploadProgressTop').html("File uploaded successfully");
                    $('#fileUploadCopy').show();
                    //var midstr = "File link:</br>";
                    var midstr = "http://"+document.location.host+"/download/?"+encodeURIComponent(response[1]);
                    $('#fileUploadProgressMiddle').html(midstr);
                }
                $('#fileUploadProgressBottom').show();
                $('#fileUploadProgressWindow').show();
                $('#fileUploadAbort').html("Ok");
                $('#fileUploadWindowInput').val('');

                if(response[0] == "" && postInChat == "true") $('#fileUploadProgressWindow').hide();
            },
            error: function(fdsa, status, msg){
                isUploadingFile = false;
                console.log(fdsa);
                $('#fileUploadProgressTop').html("Error");
                $('#fileUploadProgressMiddle').html(msg);
                $('#fileUploadProgressBottom').show();
                $('#fileUploadProgressWindow').show();
                $('#fileUploadAbort').html("Ok");
                $('#fileUploadCopy').hide();
                $('#fileUploadWindowInput').val('');
            }
        });
    }

    function AbortFileUpload(){
        console.log("File upload aborted");
        if(fileUploadXhr != null && isUploadingFile) fileUploadXhr.abort();
        $('#fileUploadProgressWindow').hide();
        $('#fileUploadWindowInput').val('');
    }

    function CopyUploadLink(){
        var text = document.getElementById("fileUploadProgressMiddle");
        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand('copy');
        $('#fileUploadProgressWindow').hide();
    }

    $('#fileUploadWindowInput').on("change", function(){
        var file = $('#fileUploadWindowInput').prop("files");

        if(file[0] == null){
            $('#fileUploadWindowInput').html('');
            return;
        }

        $('#fileUploadWindowInfo').html(ShortFileSize(file[0].size));
    });

    $('#fileUploadProgressTop').on('mousedown', function(e){
        e.preventDefault();
        var target = $('#fileUploadProgressWindow');
        height = target.outerHeight();
        width = target.outerWidth();
        ypos = target.offset().top + height - e.pageY,
        xpos = target.offset().left + width - e.pageX;
        $(document.body).on('mousemove', function(e){
            if(target != null){
                var itop = e.pageY + ypos - height;
                var ileft = e.pageX + xpos - width;
                target.offset({top: itop,left: ileft});
            }
        }).on('mouseup', function(){ target = null; });
    });

    $(window).on('dragenter', function(e){
        $fileUploadWindowOverlay.show();
    });
    $fileUploadWindowOverlay.on('dragend', function(e){
        $fileUploadWindowOverlay.hide();
    });
    $fileUploadWindowOverlay.on('dragexit', function(e){
        $fileUploadWindowOverlay.hide();
    });
    $fileUploadWindowOverlay.on('dragleave', function(e){
        $fileUploadWindowOverlay.hide();
    });
    $fileUploadWindowOverlay.on('dragover', function(e){
        e.stopPropagation();
        return false;
    });
    $($fileUploadWindowOverlay).on('drop', function(e){
        $('#fileUploadWindowInput').prop("files", e.originalEvent.dataTransfer.files);
        if(e.target == $fileUploadWindowOverlay[0] && e.originalEvent.dataTransfer.files.length > 0) FileUploadWindow();
        $fileUploadWindowOverlay.hide();
        e.stopPropagation();
        e.preventDefault();
    });
</script>
