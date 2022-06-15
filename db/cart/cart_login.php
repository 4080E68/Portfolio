<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購物車 | 登入</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
        $_SESSION['identity'] = 1;

        echo "<script>alert('登出成功!!')</script>";
        echo "<script>window.location.href='./cart_list.php';</script>";
       
        //echo $op . '登出成功<a href="../index.html">按此離開</a>';
        die('');
    }

    $db = new PDO('mysql:dbname=h568;host=localhost;', 'h568', 'My^4DqPam');
    $Q = "select * from client where account = '${id}' and password='${pwd}'";
    $result = $db->query($Q);
    if (!$result) echo "Error! $Q ";
    $A = $result->fetchAll(PDO::FETCH_ASSOC);
    $num = count($A);

    if ($num == 1) {
        $_SESSION['login'] = 1;
        $_SESSION['id'] = $id;
        
        //echo $op . '認證成功<a href="../index.html"> 按此離開 </a>';
        for ($i = 0; $i < $num; $i = $i + 1) {
            $identity = $A[$i]['identity']; //取得權限
            //echo "你的權限為:" . $identity;
        }
        $_SESSION['identity'] = $identity; //存取權限
        echo "<script>alert('登入成功')</script>";
        echo "<script>window.location.href='./cart_list.php';</script>";
        //header('location: ./cart_list.php');
    } else {
        $_SESSION['login'] = 0;
        $_SESSION['id'] = '';
        $_SESSION['identity'] = 1;
        echo "<script>alert('帳號或密碼錯誤!!')</script>";
        echo "<script>window.location.href='./cart_login.html';</script>";
    }
    

    ?>

</body>

</html>