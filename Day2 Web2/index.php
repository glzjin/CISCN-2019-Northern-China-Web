<html>
<body>
<!-- ?src -->
</body>

<?php
echo "Null          ...            Null            ...            Null          ...  ";

if(isset($_GET['src'])) {
    die(highlight_file('index.php', true));
}

error_reporting(0);
if($_REQUEST){
    foreach ($_REQUEST as $key => $value) {
        if(preg_match('/[a-zA-Z]/i', $value))   die('Hello Hack.');
    }
}
 
if($_SERVER){
    if(preg_match('/cyber|flag|ciscn/i', $_SERVER['QUERY_STRING']))  die('Hello Hack..');
}
 
if(isset($_GET['cyber'])){
    if(!(substr($_GET['cyber'], 32) === md5($_GET['cyber']))){ 
        die('Hello Hack...');
    }else{
        if(preg_match('/^ciscnsec$/', $_GET['ciscn']) && $_GET['ciscn'] !== 'ciscnsec'){
            $getflag = file_get_contents($_GET['flag']);
        }else
	die('Hello Hack....');
        if(isset($getflag) && $getflag === 'security'){
            include 'flag.php';
            echo $flag;
        }else die('Hello Hack.....');
    }
}
?>
