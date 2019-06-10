<?php

require_once "config.php";

if(!empty($_POST["user_name"]) && !empty($_POST["phone"]))
{
    $msg = '';
    $pattern = '/select|insert|update|delete|and|or|join|like|regexp|where|union|into|load_file|outfile/i';
    $user_name = $_POST["user_name"];
    $phone = $_POST["phone"];
    if (preg_match($pattern,$user_name) || preg_match($pattern,$phone)){ 
        $msg = 'no sql inject!';
    }else{
        $sql = "select * from `user` where `user_name`='{$user_name}' and `phone`='{$phone}'";
        $fetch = $db->query($sql);
    }

    if (isset($fetch) && $fetch->num_rows>0){
        $row = $fetch->fetch_assoc();
        $result = $db->query('delete from `user` where `user_id`=' . $row["user_id"]);
        if(!$result) {
            echo 'error';
            print_r($db->error);
            exit;
        }
        $msg = "订单删除成功";
    } else {
        $msg = "未找到订单!";
    }
}else {
    $msg = "信息不全";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>删除订单</title>
<base href="./">
<meta charset="utf-8" />

<link href="assets/css/bootstrap.css" rel="stylesheet">
<link href="assets/css/custom-animations.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">

</head>
<body>
<div id="h">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 centered">
                <p style="margin:35px 0;"><br></p>
                <h1>删除订单</h1>
                <form method="post">
                    <p>
                    <h3>姓名:</h3>
                    <input type="text" class="subscribe-input" name="user_name">
                    <h3>电话:</h3>
                    <input type="text" class="subscribe-input" name="phone">
                    </p>
                    <p>
                    <button class='btn btn-lg  btn-sub btn-white' type="submit">删除订单</button>
                    </p>
                </form>
                <?php global $msg; echo '<h2 class="mb" style="color:#ffffff;">'.$msg.'</h2>';?>
            </div>
        </div>
    </div>
</div>
<div id="f">
    <div class="container">
		<div class="row">
            <h2 class="mb">订单管理</h2>
            <a href="./index.php">
                <button class='btn btn-lg btn-register btn-sub btn-white'>返回</button>
            </a>
            <a href="./search.php">
                <button class="btn btn-lg btn-register btn-white" >我要查订单</button>
            </a>
            <a href="./change.php">
                <button class="btn btn-lg btn-register btn-white" >我要修改收货地址</button>
            </a>
		</div>
	</div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/retina-1.1.0.js"></script>
<script src="assets/js/jquery.unveilEffects.js"></script>
</body>
</html>
