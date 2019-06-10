<?php
echo'<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload</title>
</head>
<style>
    #fo0kingshell{
        margin: auto;
        width: 300px;
        height: 100px;

    }
    #msg{
    margin: auto;
    width:900px;
    height: 100px;
    }
</style>
<body>
<div id=\'fo0kingshell\'>
    <form id="upload-form" action="" method="post" enctype="multipart/form-data" >
        　　　<input type="file" id="upload" name="file"/>
        　　　<input type="submit" value="Upload" />
    </form>
</div>
<!--hint1:TIME IS ALWAYS LIMITTED-->
</body>
</html>';//给第一个提示
	if($_FILES) {
        $upfile = $_FILES["file"]["name"];
        $fileTypes = array(
            'jpg', 'png', 'gif', 'zip', 'rar', 'txt');
        function getFileExt($file_name)
        {
            while ($dot = strpos($file_name, ".")) {
                $file_name = substr($file_name, $dot + 1);
            }
            return $file_name;
        }
        $test1 = strtolower(getFileExt($upfile));
        if (!in_array($test1, $fileTypes)) {
            echo $test1.'doesn\'t allow';
            exit();
        } else {
            $nfile = md5(rand(1,10000)).'.'.$test1;
            move_uploaded_file($_FILES["file"]["tmp_name"], "./file/" . $nfile);
            echo '<div id="msg">'.$nfile.'</div><div>uploaded to ./file</div>
            <!--hint3:hint-->';
            $port=$_SERVER["SERVER_PORT"];
            $host=$_SERVER["HTTP_HOST"];
            $ch=curl_init();
            curl_setopt($ch, CURLOPT_NOSIGNAL, true);
            curl_setopt ( $ch,  CURLOPT_TIMEOUT_MS,100);
            //curl_setopt($ch, CURLOPT_TIMEOUT,1);
            curl_setopt($ch, CURLOPT_URL, "http://".$host."/a6ca1c4487e1e3feba82b5e390dbdd7a.php");
            $output = curl_exec($ch);
            curl_close($ch);
        }

    }
?>
