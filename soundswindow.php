<?php include_once("filescan.php"); ?>

<style>
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

<div id="soundsWindow" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 3; background: rgba(0, 0, 0, 0.8); overflow: hidden; font-family: arial;">
    <div id="soundsWindowContent" style="margin: 10px auto; background-color: black; border: 2px solid gray; width: 50%; text-align:center;">
        <div id="soundsWindowHead" style="font-size: 26px; border-bottom: 1px solid gray;">Sound messages</div>
        <div id="soundsWindowMiddle" style="background-color: #121212; overflow-y: auto; max-height: 500px;">
                <div id="soundsWindowList">
                    <?php
                        $files = @ListFiles("binds_sounds");
                        $v = $files['Other'];
                        unset($files['Other']);
                        $files['Other'] = $v;
                        foreach($files as $category => $list){
                            echo '<div>';
                                echo '<div id="bindcategory_'.$category.'" class="soundBindCategoryHeader">';
                                    echo '<center>'.$category.'</center>';
                                echo '</div>';
                                foreach($list as $file){
                                    echo "<div class='soundBindsListCell'>".pathinfo($file, PATHINFO_FILENAME)."</div>";
                                }
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
        <div id="soundsWindowBottom" style="background-color: #121212; position: relative;">
            <button onclick="HideSoundsWindow();" style="width: 15%; margin-bottom: 10px;">Close</button>
            <div id="soundsWindowSearch" style="display: inline-block; position: absolute; right: 10px;">
                Search:
                <input id="soundsWindowSearchInput" style="width: 100px;"/>
            </div>
        </div>
    </div>
</div>

<script>
    function ToggleSoundsWindow(){
        $('#soundsWindow').show();
        $('#soundsWindowSearchInput').focus();
    }

    function HideSoundsWindow(){
        $('#soundsWindow').hide();
        $('#msgInput').focus();
    }

    $('#soundsWindowList').on('click', '.soundBindsListCell', function(e){
        $('#msgInput')[0].value += "!"+$(e.target).html();
        $('#soundsWindow').hide();
        $('#msgInput').focus();
        $('#soundsWindowSearchInput').val('');
        $('.soundBindsListCell').each(function(){ $(this).show(); });
    });

    $('#soundsWindowSearchInput').on("input", function(){
        var search = this.value;
        if(search != ""){
            $('.soundBindsListCell').each(function(){
                if($(this).html().indexOf(search) == -1) $(this).hide();
                else $(this).show();
            });
        }else $('.soundBindsListCell').each(function(){ $(this).show(); });
    });
</script>

