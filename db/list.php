<!doctype html>
<html lang="zh_tw">

<head>
    <meta charset="utf-8">
    <title>P註冊結果</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

    

<body>
    <h1>查詢結果</h1>

    <?php
    //認證
    $key = str_replace("'", "''", $_REQUEST['key']);
    $db = new PDO('pgsql:dbname=h568;host=localhost;', 'h568', 'P#3Maf5mr');
    $Q = "select gid,name,place,num,price from good where name like '%${key}%'";
    $result = $db->query($Q);
    if (!$result) echo "Error! $Q ";
    $A = $result->fetchAll(PDO::FETCH_ASSOC);
    //$A=$result->fetchAll(PDO::FETCH_NUM);
    $num = count($A);
    echo $num . '筆<br/>';
    echo '<table border="1" class="table table-striped">';
    for ($i = 0; $i < $num; $i = $i + 1) {
        $Agid = $A[$i]['gid'];
        $Aname = $A[$i]['name'];
        $Aprice = $A[$i]['price'];
        $Aplace = $A[$i]['place'];
        $Anum = $A[$i]['num'];
        $Aimg = 'img/' . $A[$i]['gid'] . '.jpg';

        if (is_file($Aimg))
            echo "<tr><td>${Agid}</td><td><img width='500px' height='300px' src='${Aimg}'/></td><td>{$Aname}</td><td>${Aplace}</td><td>${Anum}</td><td>${Aprice}</td></tr>";
        else
            echo "<tr><td>${Agid}</td><td>無圖</td><td>{$Aname}</td><td>${Aplace}</td><td>${Anum}</td><td>${Aprice}</td></tr>";
    }
    echo '</table>';
    pg_close($db);
    echo '<br/><a href="index.html">按此離開</a>';
    ?>
</body>

</html>