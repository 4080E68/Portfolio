<!doctype html>
<html lang="zh_tw">

<head>
    <meta charset="utf-8">
    <title>M查詢結果</title>
</head>

<body>
    <h3>M查詢結果</h3>
    <?php
    //認證
    require('mauth.php');    
    $key = str_replace("'", "''", $_REQUEST['key']);
    $db = new mysqli("localhost", "h568", "My^4DqPam", "h568");
    $Q = "select mobile,name,email,addr from auser2 where name like '%${key}%'";
    $result = $db->query($Q);
    if (!$result) echo "Error! $Q ";
    $num = $result->num_rows;
    echo $num . '筆<br/>';
    echo '<table border="1">';
    for ($i = 0; $i < $num; $i = $i + 1) {
        $A = $result->fetch_row();//取得行數
        echo "<tr><td>${A[0]}</td><td>{$A[1]}</td><td>${A[2]}</td><td>${A[3]}</td></tr>";
    }
    echo '</table>';
    $db->close();
    echo '<br/><a href="index.html">按此離開</a>';
    ?>
</body>

</html>