<?php
error_reporting(0);
session_start();
if(!$_SESSION['admin']){
	die('Not admin.<br>When you are admin, you will get flag.');
}
echo file_get_contents("/flag");
?>
