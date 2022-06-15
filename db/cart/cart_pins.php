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
    require('cart_mauth.php');

    $vendor = str_replace("'", "''", $_REQUEST['vendor']);
    $name = str_replace("'", "''", $_REQUEST['name']);
    $price = (int) $_REQUEST['price'];
    $num = (int) $_REQUEST['num'];


    $db = new PDO('mysql:dbname=h568;host=localhost;', 'h568', 'My^4DqPam');
    $Q = "insert into Commodity select max(Commodity_id)+1,'${vendor}','${name}',${price},'${num}' from Commodity;";
    $result = $db->query($Q);
    if (!$result) echo "Error! $Q ";
    $Q = "select max(Commodity_id) as Commodity_id from Commodity where Commodity_name='${name}';";
    $result = $db->query($Q);
    if (!$result) echo "Error! $Q ";
    $A = $result->fetchAll(PDO::FETCH_ASSOC);
    copy($_FILES['photo']['tmp_name'], 'img/LL' . $A[0]['Commodity_id'] . '.jpg');
    $im = imagecreatefromjpeg('img/LL' . $A[0]['Commodity_id'] . '.jpg');
    $W = imagesx($im);
    $H = imagesy($im);
    $r = 500 / $W;
    $nW = 500;
    $nH = $H * $r;
    $nim = imagecreatetruecolor($nW, $nH);
    imagecopyresampled($nim, $im, 0, 0, 0, 0, $nW, $nH, $W, $H);
    imagejpeg($nim, 'img/' . $A[0]['Commodity_id'] . '.jpg');

    //echo $A[0]['Commodity_id'];
    echo '<br/>';
    echo "<script>alert('上架成功!!')</script>";
    echo "<script>window.location.href='./cart_list.php';</script>";

    ?>
</body>

</html>