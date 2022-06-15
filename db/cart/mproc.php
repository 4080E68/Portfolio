<!doctype html>
<html lang="zh_tw">

<head>
    <meta charset="utf-8">
    <title>處理結果</title>
</head>

<body>
    <?php
    require('cart_mauth.php');
    $op = (int) $_REQUEST['op'];
    $Commodity_id = (int) $_REQUEST['Commodity_id'];
    $db = new PDO('mysql:dbname=h568;host=localhost;', 'h568', 'My^4DqPam');
    if ($op == 1) {
        $Q = "delete from Commodity where Commodity_id=$Commodity_id";
        $result = $db->query($Q);
        if (!$result)
            echo '<br/><a href="./cart_list.php">刪除失敗，按此離開</a>';
        else {
            $Aimg = 'img/' . $Commodity_id . '.jpg';
            $ALimg = 'img/LL' . $Commodity_id . '.jpg';
            unlink($Aimg); //刪除圖片檔案
            unlink($ALimg);
            echo "<script>alert('刪除成功')</script>";
            echo "<script>window.location.href='./cart_list.php';</script>";
        }
    } else if ($op == 2) {
        $Q = "select * from Commodity where Commodity_id = $Commodity_id ";
        $result = $db->query($Q);
        $A = $result->fetchAll(PDO::FETCH_ASSOC);
        echo '
            <h1>商品修改</h1>
            <form method="post" action="mproc.php"
            enctype="multipart/form-data">
            <input type="hidden" name="Commodity_id" id="Commodity_id" value="' . $Commodity_id . '"/>
            <input type="hidden" name="op" id="op" value="12"/>
            廠商:<input type="text" name="name" id="name" size="20" value="' . $A[0]['vendor'] . '"/><br/>
            名稱:<input type="text" name="place" id="place" size="10" value="' . $A[0]['Commodity_name'] . '"/><br/>
            價格:<input type="text" name="num" id="num" size="4" value="' . $A[0]['price'] . '" /><br/>
            庫存:<input type="text" name="price" id="price" size="4" value="' . $A[0]['reserve'] . '"/><br/>
            <input type="submit" name="sub" id="sub" value="修改"/>
            </form>';
    } else if ($op == 12) {
        $name = str_replace("'", "''", $_REQUEST['name']);
        $place = str_replace("'", "''", $_REQUEST['place']);
        $num = (int) $_REQUEST['num'];
        $price = (int) $_REQUEST['price'];
        $Q = "update Commodity set name='${name}',place='${place}',num=${num},price=${price} where Commodity_id=$Commodity_id;";
        $result = $db->query($Q);
        if (!$result)
            echo '<br/><a href="index.html">修改失敗，按此離開</a>';
        else {
            echo '<br/><a href="index.html">修改成功，按此離開</a>';
        }
    } else {
        echo '<br/><a href="index.html">你是駭客嗎?滾!</a>';
    }

    ?>
</body>

</html>