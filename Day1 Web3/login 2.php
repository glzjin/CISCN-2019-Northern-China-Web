<?php
error_reporting(0);
session_start();
define("METHOD", "aes-128-cbc");
define("KEY", "******"); 
function privCode(){
    $code = '';
    $seeds = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    for($i = 0; $i < 15; $i++){
        $code .= substr($seeds, rand(1, 61), 1);
    }
    return $code;
}

$privcode = privCode();


function get_iv(){
    $iv = '';
    $seeds = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    for($i = 0; $i < 16; $i++){
        $iv .= substr($seeds, rand(1, 61), 1);
    }
    return $iv;
}

function loginpriv(){
	global $privcode;
    $token = get_iv();
    $c = openssl_encrypt($privcode, METHOD, KEY, OPENSSL_RAW_DATA, $token);
    $_SESSION['privcode'] = base64_encode($c);
    if($privcode === 'admin'){
    	$_SESSION['admin'] = 1;
    }else{
    	$_SESSION['admin'] = 0;
    }
    setcookie("token", base64_encode($token));
}
function iflogin(){
    if (isset($_SESSION['privcode'])) {
        $id_decode = base64_decode($_SESSION['privcode']);
        $token_decode = base64_decode($_COOKIE["token"]);
        if($u = openssl_decrypt($id_decode, METHOD, KEY, OPENSSL_RAW_DATA, $token_decode)){
            if ($u === 'admin') {
                $_SESSION['admin'] = 1;
                return 1;
            }
        }else{
            die("Error!");
        } 
    }
    return 0;
}
if(isset($_POST['username'])&&isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
	if($username === "admin" && md5($password) === "21232f297a57a5a743894a0e4a801fc3"){
  		loginpriv();
  		header('location: ./admin.php');
  	}else{
  		die('Login failed.');
  	}
}else{
	if(iflogin()){
        header('location: ./admin.php');
	}else{
        header('location: ./login.html');
    }
}
?>
