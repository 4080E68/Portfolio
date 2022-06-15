<!doctype html>
<html lang="zh_tw">

<head>
    <meta charset="utf-8">
    <title>註冊結果</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    $account = $_REQUEST['account'];
    $pwd = $_REQUEST['pwd'];
    $pwd = sha1($pwd);
    $name = $_REQUEST['name'];
    $age = $_REQUEST['age'];
    $phone = $_REQUEST['phone'];
    $addr = $_REQUEST['addr'];
    $db = new PDO('mysql:dbname=h568;host=localhost;', 'h568', 'My^4DqPam');
    $Q = "insert into client select max(client_id)+1,'${account}','${pwd}','${name}',${age},'${phone}','${addr}','1' from client;";
    $result = $db->query($Q);
    if (!$result) {
        echo "<script>alert('註冊失敗!!')</script>";
        echo "<script>window.location.href='./cart_list.php';</script>";
        // . "Error! $Q ";
    } else {
        echo "<script>alert('註冊成功!!')</script>";
        echo "<script>window.location.href='./cart_list.php';</script>";
    }
    echo'<button type="submit" class="btn btn-secondary"><a href="./cart_list.php"
                        style="color:white; text-decoration: none;">回首頁</a></button>';
    //echo $Q;
    ?>
</body>

</html>