<?php
    $newmsg = "";
    $bindsound = '';
    if(substr($msg, 0, 2) == "!!"){
        if(substr($msg, 0, strlen("!!random")) == "!!random"){
            function rglob($pattern, $flags = 0) {
                $files = glob($pattern, $flags);
                foreach(glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
                return $files;
            }
            $files = rglob("binds_sounds/*.*");
            $target = $files[rand(0, count($files))];
            if($target != "") $msg .= "{bindsound:$target}";
            goto endBind;
        }else if(substr($msg, 0, strlen("!!other")) == "!!other"){
            $files = glob("binds_sounds/*.*");
            $target = $files[rand(0, count($files))];
            if($target != "") $msg .= "{bindsound:$target}";
            goto endBind;
        }else{
            $query = substr($msg, 2);
            if(file_exists($_SERVER['DOCUMENT_ROOT']."/chat/binds_sounds/$query")){
                $files = glob("binds_sounds/$query/*");
                $target = $files[rand(0, count($files))];
                if($target != "") $msg .= "{bindsound:$target}";
                goto endBind;
            }
        }
    }

    if($msg == "!binds"){
        $serverMsg = "Binds list:</br>";
        $files = scandir("binds");
        for($i = 0; $i < count($files); $i++){
            $file = &$files[$i];
            if($file == "." || $file == "..") continue;
            $serverMsg .= pathinfo($file, PATHINFO_FILENAME);
            if($i != count($files)-1) $serverMsg .= ", ";
        }
        goto endBind;
    }else if($msg == "!soundbinds"){
        $binds = ListFiles("binds_sounds");
        $str = '';
        $amt = 0;
        foreach($binds as $category => $binds){
            $str .= "</br>";
            $str .= "-$category:</br>";
            $bindcount = count($binds);
            if($bindcount == 0){
                $str .= "No sounds";
                continue;
            }
            $amt += $bindcount;
            for($i = 0; $i < $bindcount; $i++){
                $str .= pathinfo($binds[$i], PATHINFO_FILENAME);
                if($i != $bindcount-1) $str .= ", ";
            }
        }

        $serverMsg = "$amt sound binds$str";
        goto endBind;
    }
    $command = strtolower(substr($msg, 1));
    if(strlen($command) == 0 || $command == "." || $command == "..") goto endBind;

    if(strpos($command, " ") !== false) $command = substr($command, 0, strpos($command, " "));
    if(strpos($command, "</br>") !== false) $command = substr($command, 0, strpos($command, "</br>"));

    if($msg[0] == "#"){
        $files = scandir("binds");
        foreach($files as $file){
            if(pathinfo($file, PATHINFO_FILENAME) == $command){
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if($ext == "mp4" || $ext == "webm") $newmsg .= "{videogif:binds/$file}";
                else $newmsg .= "{bind:binds/$file}";
                break;
            }
        }
    }else if($msg[0] == "!"){
        $bindsound = FindFile("binds_sounds", $command);
    }

    if($bindsound != ''){
        if($newmsg == "") $newmsg .= $msg."{bindsound:binds_sounds/$bindsound}";
        else $newmsg .= "{bindsound:binds_sounds/$bindsound}";
    }
    /*
    $files = scandir("binds_sounds");
    foreach($files as $file){
        if(pathinfo($file, PATHINFO_FILENAME) == $command){
            if($newmsg == "") $newmsg .= $msg."{bindsound:binds_sounds/$file}";
            else $newmsg .= "{bindsound:binds_sounds/$file}";
            break;
        }
    }*/

    if($newmsg != "") $msg = $newmsg;
    endBind:
?>
