<html>
<head>
<title>Hack World</title>
</head>
<body>
<h3>All You Want Is In Table 'ctf' and the column is 'flag'</h3>
<h3>Now, just give the id of passage</h3>
<form action="index.php" method="POST">
<input type="text" name="id">
<input type="submit"> 
</form>
</body>
</html>
<?php
$dbuser='ctf';
//$dbuser='root';
$dbpass='anvue91kd';
//$dbpass='root';

function safe($sql){
    $blackList = array(' ','||','#','-',';','&','+','or','and','`','"','insert','group','limit','update','delete','*','into','union','load_file','outfile','./');
    foreach($blackList as $blackitem){
        if(stripos($sql,$blackitem)){
            return False;
        }
    }
    return True;
}
if(isset($_POST['id'])){
    $id = $_POST['id'];
}else{
    die();
}
$db = mysql_connect("localhost",$dbuser,$dbpass);
if(!$db){
    die(mysql_error());
}   
mysql_select_db("ctf",$db);

if(safe($id)){
    $query = mysql_query("SELECT content from passage WHERE id = ${id} limit 0,1");
    
    if($query){
        $result = mysql_fetch_array($query);
        
        if($result){
            echo $result['content'];
        }else{
            echo "Error Occured When Fetch Result.";
        }
    }else{
    	var_dump($query);
    }
}else{
    die("SQL Injection Checked.");
}
