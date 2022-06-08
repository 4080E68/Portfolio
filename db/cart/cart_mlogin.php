<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>認證</title>
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
        echo $op . '登出成功<a href="index.html">按此離開</a>';
        die('');

    }

    $db = new mysqli("localhost", "h568", "My^4DqPam", "h568");
    $Q = "select mobile,name,email,addr from auser2 where mobile = '${id}' and pwd='${pwd}'";
    $result = $db->query($Q);

    if (!$result) echo "Error! $Q ";
    $num = $result->num_rows;
    if ($num == 1) {
        $_SESSION['login'] = 1;
        $_SESSION['id'] = $id;
        echo $op . '認證成功<a href="index.html"> 按此離開 </a>';
        echo "login為" . $_SESSION['login'];
    } else {
        $_SESSION['login'] = 0;
        $_SESSION['id'] = '';
        header('location: login.html');
    }


    ?>

</body>

</html>