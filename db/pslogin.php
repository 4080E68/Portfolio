<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSQL認證</title>
</head>

<body>
    <?php

    $id = str_replace("'", "''", $_REQUEST['id']);
    $pwd = str_replace("'", "''", $_REQUEST['pwd']);
    $pwd = sha1($pwd);
    $op = (int) $_REQUEST['op'];
    session_start();

    if ($op == -1) { //href="mlogin.php?op=-1 當點選登出時$op會等於-1即登出
        $_SESSION['login'] = 0;
        $_SESSION['id'] = '';
        echo $op . '登出成功
            <a href="index.html"> 按此離開 </a>';
        die('');
    }
    $db = pg_connect("host=localhost dbname=h568 user=h568 password=P#3Maf5mr");
    $Q = "select mobile,name,email,addr from auser where mobile = '${id}' and pwd = '${pwd}'";
    // echo "結果".$Q;
    $result = pg_query($db, $Q); //執行查詢
    if (!$result) echo "Error! $Q ";

    $num = pg_num_rows($result); //回傳查詢筆數

    if ($num == 1) {
        $_SESSION['login'] = 1;
        $_SESSION['id'] = $id;
        echo $op . '認證成功<a href="index.html"> 按此離開 </a>';
    }
    else {
        header('location: pslogin.html');
        $_SESSION['login'] = 0;
        $_SESSION['id'] = '';
    }


    ?>

</body>

</html>