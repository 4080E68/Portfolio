<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <link rel="icon" href="./icon/online-shopping.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="rebots" content="index, follow" />
    <meta name="description" content="網頁說明文字">
    <meta name="author" content="作者" />
    <title>詳細資訊</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2e5b67badf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/cart.css">
</head>
<header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between fixed-top">
        <a class="navbar-brand" href="./cart_index.php">崑山百貨</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./cart_index.php">首頁 <span class="sr-only">(current)</span></a>
                </li>

            </ul>

            <?php
            session_start();
            if ($_SESSION['login'] == 1 && $_SESSION['identity'] == 2) {
                echo '<a href="./cart_ins.html"><button style="margin-right:1rem;" type="button" class="btn btn-info">後台管理</button></a>';
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


    <main style="height: 110vh;flex-direction: column;justify-content: start;
    align-items: center;">


        <?php
        require('mauth.php');
        $order_time = $_REQUEST['order_time'];
        $client_id = $_REQUEST['client_id'];
        $mobile = $_SESSION['id'];
        $db = new PDO('mysql:dbname=h568;host=localhost;', 'h568', 'My^4DqPam');
        $Q = "select * from client where client_id='${client_id}';";
        //echo $Q;
        $result = $db->query($Q);
        $A = $result->fetchAll(PDO::FETCH_ASSOC);
        $num = count($A);
        // for ($i = 0; $i < $num; $i = $i + 1) {
        //     $client_id = $A[$i]['client_id'];
        // }
        echo '<section class="detail">';
        echo "<div class='detail1'><h2>配送資訊</h2><hr>";
        for ($i = 0; $i < $num; $i = $i + 1) {
            $name = $A[$i]['name'];
            $phone = $A[$i]['phone'];
            $address = $A[$i]['address'];

            echo "<div class='bolder'><p>客戶姓名:${name}</p>";
            echo "<p>連絡電話:${phone}</p>";
            echo "<p>配送地址:${address}</p>";
        }

        //echo $mobile;
        $db = new PDO('mysql:dbname=h568;host=localhost;', 'h568', 'My^4DqPam');

        $Q = "select Commodity.Commodity_name,details.price,details.num,state.payment,state.order_time from details,state,Commodity where details.order_number = state.order_number and state.commodity_id = Commodity.commodity_id  and state.client_id=${client_id} and state.order_time='${order_time}';";
        //echo $Q;
        $result = $db->query($Q);
        $A = $result->fetchAll(PDO::FETCH_ASSOC);
        $num = count($A);
        //付款方式
        // for ($i = 0; $i < $num; $i = $i + 1) {
        //     $client_id = $A[$i]['client_id'];
        // }
        for ($i = 0; $i < 1; $i = $i + 1) {
            $order_time = $A[$i]['order_time'];
            $payment = $A[$i]['payment'];
            echo "<p>訂單日期:${order_time}</p>";
            echo "<p>付款方式:${payment}</p></div></div>";
        }

        echo '
            <div class="order"><h2>訂單明細</h2><hr>
            <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">商品名稱</th>
                <th scope="col">商品價格</th>
                <th scope="col">購買數量</th>
                <th scope="col">小計</th>
                </tr>
            </thead><tbody>';

        for ($i = 0; $i < $num; $i = $i + 1) {

            $name = $A[$i]['Commodity_name'];
            $price = $A[$i]['price'];
            $cnum = $A[$i]['num'];
            $total = $A[$i]['price'] * $A[$i]['num'];
            $t += $total;

            echo
            "
                <tr>
                <td>${name}</td>
                <td>${price}</td>
                <td>${cnum}</td>
                <td>NT$${total}</td>
                </tr>
              
            ";
            //select * from details,state where details.order_number = state.order_number and client_id=11 and order_time='2022-06-23 07:33:48';

        }
        echo '</tbody></table></div></section>';
        echo "<h2 class='total'>NT$${t}</h2>";

        ?>

    </main>

</body>

</html>