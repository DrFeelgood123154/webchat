<div id="imgUploadWindow" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; background: rgba(0, 0, 0, 0.8); overflow: hidden; overflow-y: auto;">
    <div id="imgUploadWindowContent" style="margin: 100px auto; background-color: black; border: 2px solid gray; width: 50%; text-align:center;">
        <div style="border-bottom: 1px solid gray; font-size: 26px;">Image upload</div>
        Send this message into the chat?</br>
        Note: you can ignore this window by setting "confirm image upload"</br>
        <img id="imgUploadPreview" src="" style="max-width: 500px; max-height: 500px; outline: 2px solid darkgreen;"/>
        </br>
        <button id="imgUploadWindowConfirm" onclick="$('#imgUploadWindow').hide(); UploadImage(); $('#imgUploadPreview').attr('src', ''); $('#msgInput').focus();">Send</button>
        <button onclick="$('#imgUploadWindow').hide(); $('#imgUploadPreview').attr('src', '')">Cancel</button>
    </div>
</div>

<div id="imgUploadProgressWindow" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; overflow: hidden;">
    <div id="imgUploadProgressWindowContent" style="margin: 5px auto; background-color: black; border: 2px solid gray; width: 200px; height:50px; text-align:center;">

    </div>
</div>

<script>var imgUploadProgressWindowTimeout = null;</script>
