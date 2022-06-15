<!doctype html>
<html lang="zh_tw">

<head>
    <meta charset="utf-8">
    <title>處理結果</title>
</head>

<body>
    <?php
    require('mauth.php');
    $op = (int) $_REQUEST['op'];
    $gid = (int) $_REQUEST['gid'];
    $db = new PDO('pgsql:dbname=h568;host=localhost;', 'h568', 'P#3Maf5mr');
    if ($op == 1) {
        $Q = "delete from good where gid=$gid";
        $result = $db->query($Q);
        if (!$result)
            echo '<br/><a href="index.html">刪除失敗，按此離開</a>';
        else {
            echo '<br/><a href="./list.php">刪除成功，按此離開</a>';
            $Aimg = 'img/' . $gid . '.jpg';
            $ALimg = 'img/LL' . $gid . '.jpg';
            unlink($Aimg);//刪除圖片檔案
            unlink($ALimg);
        }
    } else if ($op == 2) {
        $Q = "select name,place,num,price from good where gid = $gid ";
        $result = $db->query($Q);
        $A = $result->fetchAll(PDO::FETCH_ASSOC);
        echo '
            <h1>商品修改</h1>
            <form method="post" action="mproc.php"
            enctype="multipart/form-data">
            <input type="hidden" name="gid" id="gid" value="' . $gid . '"/>
            <input type="hidden" name="op" id="op" value="12"/>
            商品名稱:<input type="text" name="name" id="name" size="20" value="' . $A[0]['name'] . '"/><br/>
            產地:<input type="text" name="place" id="place" size="10" value="' . $A[0]['place'] . '"/><br/>
            存量:<input type="text" name="num" id="num" size="4" value="' . $A[0]['num'] . '" /><br/>
            價格:<input type="text" name="price" id="price" size="4" value="' . $A[0]['price'] . '"/><br/>
            <input type="submit" name="sub" id="sub" value="修改"/>
            </form>';
    } else if ($op == 12) {
        $name = str_replace("'", "''", $_REQUEST['name']);
        $place = str_replace("'", "''", $_REQUEST['place']);
        $num = (int) $_REQUEST['num'];
        $price = (int) $_REQUEST['price'];
        $Q = "update good set name='${name}',place='${place}',num=${num},price=${price} where gid=$gid;";
        $result = $db->query($Q);
        if (!$result)
            echo '<br/><a href="index.html">修改失敗，按此離開</a>';
        else {
            echo '<br/><a href="index.html">修改成功，按此離開</a>';
        }
    }
    else {
        echo '<br/><a href="index.html">你是駭客嗎?滾!</a>';
    }

    ?>
</body>

</html>