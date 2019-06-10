<?php
echo'<!--YOU HAVE MY \'name\'-->';
error_reporting(0);
$file=$_GET['name'].'.php';
if(!file_exists($file)){
    echo $file." not exists!";
}
include($file);
?>