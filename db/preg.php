<!doctype html>
<html lang="zh_tw">

<head>
    <meta charset="utf-8">
    <title>P註冊結果</title>
</head>

<body>
    <h3>PSQL註冊結果</h3>
    <?php
        $mobile = $_REQUEST['mobile'];
        $name = $_REQUEST['name'];
        $pwd1 = $_REQUEST['pw1'];
        $pwd1 = sha1($pwd1);
        $pwd2 = $_REQUEST['pw2'];
        $email = $_REQUEST['email'];
        $addr = $_REQUEST['addr'];
        $remark=$_REQUEST['remark'];
        $db = pg_connect("host=localhost dbname=h568 user=h568 password=P#3Maf5mr");
        $Q = "insert into auser values('${mobile}','${name}','${pwd1}','${email}','${addr}','${remark}');";
        $result = pg_query($db, $Q);
        if (!$result) echo "Error! $Q ";
        pg_close($db);
        echo '<br/><a href="index.html">註冊成功，按此離開</a>';
    ?>
</body>

</html>