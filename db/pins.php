<!doctype html>
<html lang="zh_tw">

<head>
    <meta charset="utf-8">
    <title>psql上架結果</title>
</head>

<body>
    <h3>psql上架結果</h3>
    <?php

    //認證
    require('mauth.php');
    session_start();
    if ($_SESSION['approved'] != true) {
        header('location: login.html');
    } else{
        $name = str_replace("'", "''", $_REQUEST['name']);
        $place = str_replace("'", "''", $_REQUEST['place']);
        $num = (int) $_REQUEST['num'];
        $price = (int) $_REQUEST['price'];


        $db = new PDO('pgsql:dbname=h568;host=localhost;', 'h568', 'P#3Maf5mr');
        $Q = "insert into good select max(gid)+1,'${name}','${place}',${num},${price} from good;";
        $result = $db->query($Q);
        if (!$result) echo "Error! $Q ";


        $Q = "select max(gid) as gid from good where name='${name}';";
        $result = $db->query($Q);
        $A = $result->fetchAll(PDO::FETCH_ASSOC);
        copy($_FILES['photo']['tmp_name'], 'img/LL' . $A[0]['gid'] . '.jpg');
        $im = imagecreatefromjpeg('img/LL' . $A[0]['gid'] . '.jpg');
        $W = imagesx($im);
        $H = imagesy($im);
        $r = 100 / $W;
        $nW = 100;
        $nH = $H * $r;
        $nim = imagecreatetruecolor($nW, $nH);
        imagecopyresampled($nim, $im, 0, 0, 0, 0, $nW, $nH, $W, $H);
        imagejpeg($nim, 'img/' . $A[0]['gid'] . '.jpg');
        echo $A[0]['gid'];
        echo '<br/><a href="index.html">上架成功，按此離開</a>';
    }


    ?>
</body>

</html>