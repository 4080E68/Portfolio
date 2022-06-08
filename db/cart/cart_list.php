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

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown link
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<body>
    

    <?php

    
    //認證
    $key = str_replace("'", "''", $_REQUEST['key']);
    $db = new PDO('mysql:dbname=h568;host=localhost;', 'h568', 'My^4DqPam');
    $Q = "select Commodity_id,Commodity_name,price from Commodity where Commodity_name like '%${key}%'";
    $result = $db->query($Q);
    if (!$result) echo "Error! $Q ";
    $A = $result->fetchAll(PDO::FETCH_ASSOC);
    $num = count($A);
    
    echo "<h1>查詢結果 <span class='badge badge-secondary'>${num}筆</span></h1>";
    echo '<table border="1" class="table table-striped">';
    for ($i = 0; $i < $num; $i = $i + 1) {
        $Agid = $A[$i]['Commodity_id'];
        $Aname = $A[$i]['Commodity_name'];
        $Aprice = $A[$i]['price'];
        $Aimg = 'img/' . $A[$i]['Commodity_id'] . '.jpg';

        if (is_file($Aimg))
            echo "<tr><td>${Agid}</td><td><img width='500px' height='300px' src='${Aimg}'/></td><td>{$Aname}</td><td>${Aprice}</td></tr>";
        else
            echo "<tr><td>${Agid}</td><td>無圖</td><td>{$Aname}</td><td>${Aprice}</td></tr>";
    }
    echo '</table>';
    pg_close($db);
    echo '<br/><a href="../index.html">按此離開</a>';
    ?>
</body>

</html>