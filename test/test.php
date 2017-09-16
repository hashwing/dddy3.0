<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/25
 * Time: 19:46
 */
    require_once '../class/qiniusdk/autoload.php';

    // 引入鉴权类
    use Qiniu\Auth;

    // 引入上传类
    use Qiniu\Storage\UploadManager;

    // 需要填写你的 Access Key 和 Secret Key
    $accessKey = 'jz6cvRXwY1vyWWAX6AEL6B4rRzgBTrIHm_u8Z3xp';
    $secretKey = '1cEnusTXzjh_7uE3grZ11FxW4QRBEYWkVBjp3v--';

    // 构建鉴权对象
    $auth = new Auth($accessKey, $secretKey);

// 要上传的空间
    $bucket = 'ggjk';

    // 生成上传 Token
    $token = $auth->uploadToken($bucket);
    ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upload test</title>
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
</head>
<body>
<input id="token" name="token" type="hidden" value="<?php echo $token;?>">
<input id="file" name="file" type="file" accept="audio/mp4,video/mp4"><br><br>
<progress id="progress" value="0" max="100"></progress>

<script type="text/javascript">
    document.getElementById('file').addEventListener('change', function(e) {
        var fd = new FormData();
        fd.append("file",$('#file')[0].files[0]);
        fd.append("token",$("#token").val());
        var xhr = new XMLHttpRequest();
        xhr.addEventListener('progress', function(e) {
            var done = e.loaded || e.loaded, total = e.total || e.total;
            console.log('xhr上传进度: ' + (Math.floor(done/total*1000)/10) + '%');
        }, false);
        if ( xhr.upload ) {
            xhr.upload.onprogress = function(e) {
                var done = e.loaded || e.loaded, total = e.total || e.total;
                console.log('xhr.upload上传进度: ' + done + ' / ' + total + ' = ' + (Math.floor(done/total*1000)/10) + '%');
                document.getElementById("progress").value = Math.floor(done/total*1000)/10;
            };
        }
        xhr.onreadystatechange = function(e) {
            if ( 4 == this.readyState ) {
                console.log(['xhr upload complete', e]);
            }
        };
        xhr.open('post', 'http://up.qiniu.com?', true);
        xhr.send(fd);
    }, false);
</script>
</body>
</html>