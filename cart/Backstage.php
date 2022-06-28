<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <link rel="icon" href="./icon/online-shopping.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="rebots" content="index, follow" />
    <meta name="description" content="網頁說明文字">
    <meta name="author" content="作者" />
    <title>全部訂單</title>
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

                echo '<a href="#"><button  type="button" style="margin-right:1rem;" class="btn btn-warning">我的訂單</button></a>';
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


    <main style="height: 110vh;">


        <?php
        require('cart_mauth.php');

        $mobile = $_SESSION['id'];
        //echo $mobile;
        $db = new PDO('mysql:dbname=h568;host=localhost;', 'h568', 'My^4DqPam');

        echo '<section class="order">
            <h2>全部訂單</h2><hr>
            <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">刪除</th>
                <th scope="col">訂單編號</th>
                <th scope="col">品項數量</th>
                <th scope="col">購買時間</th>
                <th scope="col">詳細資訊</th>
                </tr>
            </thead><tbody>';

        // $Q = "select * from client where account='${mobile}';";
        // $result = $db->query($Q);
        // $A = $result->fetchAll(PDO::FETCH_ASSOC);
        // $num = count($A);
        // for ($i = 0; $i < $num; $i = $i + 1) {
        //     $client_id = $A[$i]['client_id'];
        // }

        $Q = "select *,count(*) from state group by order_time;";
        $result = $db->query($Q);
        $A = $result->fetchAll(PDO::FETCH_ASSOC);
        $num = count($A);

        for ($i = 0; $i < $num; $i = $i + 1) {

            $client_id = $A[$i]['client_id'];
            $order_number = $A[$i]['order_number'];
            $cnum = $A[$i]['count(*)'];
            $order_time = $A[$i]['order_time'];
            echo
            "
                <tr>
                <td><a href='mproc.php?client_id=${client_id}&op=9&order_time=${order_time}'><button type='button' class='btn btn-danger'>刪除</button></a> </td>
                <td>${order_number}</td>
                <td>${cnum}</td>
                <td>${order_time}</td>
                <td><form action='detail.php' method='post'/>
                        <input type='hidden' name='order_time' value='${order_time}'/>
                        <input type='hidden' name='client_id' value='${client_id}'/>
                        <input class='btn btn-info' type='submit' value='詳細資訊'/>
                    </form>
                </td>
                </tr>
              
            ";
            //select * from details,state where details.order_number = state.order_number and client_id=11 and order_time='2022-06-23 07:33:48';
            //<a href='detail.php?${order_time}><button type='button' class='btn btn-info'>詳細資訊</button></a>
        }

        echo '</tbody></table>';






        ?>

    </main>

</body>

</html>