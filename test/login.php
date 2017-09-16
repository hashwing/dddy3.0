<?php

//echo json_encode($_POST);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .fileInput{width:102px;height:34px; background:url(http://images.cnblogs.com/cnblogs_com/dreamback/upFileBtn.png);overflow:hidden;position:relative;}
        .upfile{position:absolute;top:-100px;}
        .upFileBtn{width:102px;height:34px;opacity:0;filter:alpha(opacity=0);cursor:pointer;}
    </style>

</head>
<body>
<div class="fileInput left">
    <input type="file" name="upfile" id="upfile" class="upfile" onchange="document.getElementById('upfileResult').innerHTML=this.value"/>
    <input class="upFileBtn" type="button" value="上传图片" onclick="document.getElementById('upfile').click()" />
</div>
<span class="tip left" id="upfileResult">图片大小不超过2M,大小90*90,支持jpg、png、bmp等格式。</span>
</body>
</html>
