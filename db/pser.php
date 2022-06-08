<!doctype html>
<html lang="zh_tw">

<head>
    <meta charset="utf-8">
    <title>搜尋結果</title>
</head>

<body>
    <h3>搜尋結果</h3>
    <?php

    //認證
    require('psmauth.php');
    $key = str_replace("'", "''", $_REQUEST['key']);
    $db = pg_connect("host=localhost dbname=h568 user=h568 password=P#3Maf5mr");
    $Q = "select mobile,name,email,addr from auser where name like '%${key}%'";
    //';delete from auser;select '


    $result = pg_query($db, $Q); //執行查詢
    if (!$result) echo "Error! $Q ";
    $num = pg_num_rows($result); //回傳查詢筆數

    echo $num . '筆資料<br>';
    echo '<table border="1">';
    for ($i = 0; $i < $num; $i++) {
        $A = pg_fetch_row($result);
        echo "<tr><td>${A[0]}</td><td>{$A[1]}</td><td>${A[2]}</td><td>${A[3]}</td></tr>";
    }
    echo '</table>';
    pg_close($db);
    echo '<br/><a href="https://db.vexp.idv.tw/~h568/db/pser.html">查詢成功，按此返回</a>';
    ?>
</body>

</html>