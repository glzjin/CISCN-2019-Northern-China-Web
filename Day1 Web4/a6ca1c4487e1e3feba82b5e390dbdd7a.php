<?php
sleep(2);
echo'1';
function getFileExt($file_name)
{
    while ($dot = strpos($file_name, ".")) {
        $file_name = substr($file_name, $dot + 1);
    }
    return $file_name;
}
$handler = opendir('file');
$fileTypes2 = array('jpg');
while( ($filename = readdir($handler)) !== false )
{
    if($filename != "." && $filename != "..")
    {
        $test2 = strtolower(getFileExt($filename));
        if (!in_array($test2, $fileTypes2)) {
            echo $filename;
            unlink('./file/' . $filename);
        }//5秒后会删除
    }
}

?>