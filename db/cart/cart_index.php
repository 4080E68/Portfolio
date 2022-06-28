<!doctype html>
<html lang="zh_tw">

<head>

    <meta charset="utf-8">
    <title>崑山百貨</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="icon" href="./icon/online-shopping.png">
    <link rel="stylesheet" href="./css/style.css">
</head>

<header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between fixed-top">
        <a class="navbar-brand" href="#">崑山百貨</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">首頁 <span class="sr-only">(current)</span></a>
                </li>
            </ul>

            <?php
            session_start();
            if ($_SESSION['login'] == 1 && $_SESSION['identity'] == 2) {
                echo '<a href="./Backstage.php"><button style="margin-right:1rem;" type="button" class="btn btn-info">後台管理</button></a>';
                echo '<a href="./cart_ins.html"><button style="margin-right:1rem;" type="button" class="btn btn-primary">上架商品</button></a>';
                echo '<a href="./cart_login.php?op=-1"><button  type="button" class="btn btn-danger">登出</button></a>';
            } elseif ($_SESSION['login'] == 1) {
                // if ($_SESSION['login'] == 1 && strlen($_SESSION['cart']) > 0) {
                //     echo '<button  type="button" class="btn btn-primary"><a href="./cart_login.php?op=-1">加入購物車</a></button>';
                // }

                echo '<a href="./order.php"><button  type="button" style="margin-right:1rem;" class="btn btn-warning">我的訂單</button></a>';
                echo '<a href="./cart.php"><button  type="button" style="margin-right:1rem;" class="btn btn-primary">購物車</button></a>';
                echo '<a href="./cart_login.php?op=-1"><button  type="button" class="btn btn-danger">登出</button></a>';
            } else {
                echo '<a href="./cart_login.html"><button style="margin-right:1rem;" type="button" class="btn btn-success btn-mr">登入</button></a>';
                echo '<a href="./cart_reg.html"><button type="button" class="btn btn-info btn-mr">註冊</button></a>';
            }
            ?>

        </div>

    </nav>

</header>

<body>
    <style>
        img {
            object-fit: cover;
        }

        td,
        th {
            font-size: 1.25rem;
            text-align: center;
        }

        .table tbody tr td {
            vertical-align: middle;
        }
    </style>

    <main style="padding: 1.5rem;margin-top:48px;">
        <?php

        //認證
        $key = str_replace("'", "''", $_REQUEST['key']);
        $db = new PDO('mysql:dbname=h568;host=localhost;', 'h568', 'My^4DqPam');
        $Q = "select Commodity_id,vendor,Commodity_name,price,reserve from Commodity where Commodity_name like '%${key}%'";
        $result = $db->query($Q);
        if (!$result) echo "Error! $Q ";
        $A = $result->fetchAll(PDO::FETCH_ASSOC);
        $num = count($A);

        echo "<h1>共有 <span class='badge badge-secondary'>${num}筆資料</span></h1>";
        echo '<div class="table-responsive-sm"> <table border="1" class="table table-striped" style="padding:1rem; width: 100vw;">';


        if ($_SESSION['identity'] == 2) {
            echo '<thead class="thead-dark"> <th class="text-nowrap" width="150px">操作</th><th class="text-nowrap">廠商</th><th class="text-nowrap">商品圖片</th><th class="text-nowrap">商品名稱</th><th class="text-nowrap">價格</th><th class="text-nowrap">庫存量</th></thead>';
        } else {
            echo '<thead class="thead-dark">  <th class="text-nowrap">廠商</th><th class="text-nowrap">商品圖片</th><th class="text-nowrap">商品名稱</th><th class="text-nowrap">價格</th><th class="text-nowrap">庫存量</th><th class="text-nowrap" style="min-width:240px;" width="250px">購買</th> </thead>';
        }


        for ($i = 0; $i < $num; $i = $i + 1) {
            $ACommodity_id = $A[$i]['Commodity_id'];
            $vendor = $A[$i]['vendor'];
            $Aname = $A[$i]['Commodity_name'];
            $Aprice = $A[$i]['price'];
            $Areserve = $A[$i]['reserve'];
            $Aimg = 'img/' . $A[$i]['Commodity_id'] . '.jpg';
            $ALimg = 'img/LL' . $A[$i]['Commodity_id'] . '.jpg'; //<a target='ph' href='${ALimg}'>



            if ($_SESSION['identity'] == 2) {
                echo "<tr><td>
                <form action='mproc.php'/><input type='hidden' name='op' value='3'/>
                <a href='mproc.php?Commodity_id=${ACommodity_id}&op=1'><button type='button' class='btn btn-danger'>刪除</button></a>  
                <a href='mproc.php?Commodity_id=${ACommodity_id}&op=2'><button type='button' class='btn btn-secondary'>修改</button></a> 
                </td>";
                //<a href='mproc.php?Commodity_id=${ACommodity_id}&op=3'>購買</a>
                if (is_file($Aimg))
                    echo "<td>${vendor}</td><td width='430px' ><a target='ph' href='${ALimg}'><img width='430px' height='300px' src='${Aimg}' title='${Aname}' alert='${Aname}'/></a></td><td>{$Aname}</td><td>${Aprice}</td><td>${Areserve}</td>";
                else
                    echo "<td>${vendor}</td><td>無圖</td><td>{$Aname}</td><td>${Aprice}</td><td>${Areserve}</td>";
                echo '</tr>';
            } else {

                if (is_file($Aimg)) {
                    // echo "<td>
                    //     <form action='mproc.php'/><input type='hidden' name='op' value='3'/>
                    //     <input type='hidden' name='Commodity_id' value='${ACommodity_id}'/>
                    //     <input type='text' name='num' size='1' value='1'/>份
                    //     <input type='submit' name='sub' value='買'/>
                    //     </form>
                    //     </td>";

                    echo "<tr>
                        <td>${vendor}</td><td width='430px'><a target='ph' href='${ALimg}'><img width='430px' height='300px' src='${Aimg}' title='${Aname}' alert='${Aname}'/></a></td><td>{$Aname}</td><td>${Aprice}</td><td>${Areserve}</td>
                        <td>
                        <form action='mproc.php'/><input type='hidden' name='op' value='3'/>
                        <input type='hidden' name='Commodity_id' value='${ACommodity_id}'/>
                        <input type='text' name='num' size='1' value='1'/>份
                        <input type='submit' class='btn btn-success name='sub' value='加入購物車'/>
                        </form>
                        </td></tr>";
                } else {
                    echo "<tr>
                        <td>${vendor}</td><td>無圖</td><td>{$Aname}</td><td>${Aprice}</td><td>${Areserve}</td>
                        <td>
                        <form action='mproc.php'/><input type='hidden' name='op' value='3'/>
                        <input type='hidden' name='Commodity_id' value='${ACommodity_id}'/>
                        <input type='text' name='num' size='1' value='1'/>份
                        <input type='submit' class='btn btn-success name='sub' value='加入購物車'/>
                        </form>
                        </td></tr>";
                }
            }
        }
        echo '</table></div>';
        pg_close($db);
        //echo '<br/><a href="../index.html">按此離開</a>';
        ?>
    </main>
</body>

</html>