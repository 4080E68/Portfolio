<!doctype html>
<html lang="zh_tw">

<head>
    <meta charset="utf-8">
    <title>處理結果</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="rebots" content="index, follow" />
    <meta name="description" content="網頁說明文字">
    <meta name="author" content="作者" />
    <title>購物車</title>
    <link rel="icon" href="./icon/online-shopping.png">
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
    <?php
    //require('cart_mauth.php');
    require('mauth.php');

    $op = (int) $_REQUEST['op'];
    $Commodity_id = (int) $_REQUEST['Commodity_id'];

    $db = new PDO('mysql:dbname=h568;host=localhost;', 'h568', 'My^4DqPam');
    if ($op == 1) { //刪除
        $Q = "delete from Commodity where Commodity_id=$Commodity_id";
        $result = $db->query($Q);
        if (!$result)
            echo '<br/><a href="./cart_index.php">刪除失敗，按此離開</a>';
        else {
            $Aimg = 'img/' . $Commodity_id . '.jpg';
            $ALimg = 'img/LL' . $Commodity_id . '.jpg';
            unlink($Aimg); //刪除圖片檔案
            unlink($ALimg);
            echo "<script>alert('刪除成功')</script>";
            echo "<script>window.location.href='./cart_index.php';</script>";
        }
    } else if ($op == 9) { //訂單刪除
        require('cart_mauth.php');
        $client_id = (int) $_REQUEST['client_id'];
        $order_time = $_REQUEST['order_time'];
        $QQ = "delete details from details LEFT JOIN state ON details.order_number = state.order_number where order_time='${order_time}' ;";
        $qresult = $db->query($QQ);
        $Q = "delete from state where client_id=${client_id} and order_time='${order_time}';";
        $result = $db->query($Q);
        //echo $QQ;

        if (!$result) {
            echo $Q;
            echo "<script>alert('訂單刪除失敗!')</script>";
        } else {
            echo "<script>alert('訂單刪除成功')</script>";
            echo "<script>window.location.href='./Backstage.php';</script>";
        }
        if (!$qresult) {
            echo $QQ;
            echo "<script>alert('訂單刪除失敗!')</script>";
        } 
    } else if ($op == 2) { //修改
        $Q = "select * from Commodity where Commodity_id = $Commodity_id ";
        $result = $db->query($Q);
        $A = $result->fetchAll(PDO::FETCH_ASSOC);

        $data = join('', file('cart_edit.html'));
        $data = str_replace("%Commodity_id%", $Commodity_id, $data);
        $data = str_replace("%vendor%", $A[0]['vendor'], $data);
        $data = str_replace("%name%", $A[0]['Commodity_name'], $data);
        $data = str_replace("%price%", $A[0]['Price'], $data);
        $data = str_replace("%reserve%", $A[0]['reserve'], $data);

        echo $data;

        // echo '
        //     <h1>商品修改</h1>
        //     <form method="post" action="mproc.php"
        //     enctype="multipart/form-data">
        //     <input type="hidden" name="Commodity_id" id="Commodity_id" value="' . $Commodity_id . '"/>
        //     <input type="hidden" name="op" id="op" value="12"/>
        //     廠商:<input type="text" name="name" id="name" size="20" value="' . $A[0]['vendor'] . '"/><br/>
        //     名稱:<input type="text" name="place" id="place" size="10" value="' . $A[0]['Commodity_name'] . '"/><br/>
        //     價格:<input type="text" name="num" id="num" size="4" value="' . $A[0]['price'] . '" /><br/>
        //     庫存:<input type="text" name="price" id="price" size="4" value="' . $A[0]['reserve'] . '"/><br/>
        //     <input type="submit" name="sub" id="sub" value="修改"/>
        //     </form>';

    } else if ($op == 12) {
        $Commodity_id = (int) $_REQUEST['Commodity_id'];
        $vendor = str_replace("'", "''", $_REQUEST['vendor']);
        $Commodity_name = str_replace("'", "''", $_REQUEST['name']);
        $price = (int) $_REQUEST['price'];
        $reserve = (int) $_REQUEST['reserve'];

        $Q = "update Commodity set vendor='${vendor}',Commodity_name='${Commodity_name}',Price=${price},reserve=${reserve} where Commodity_id = $Commodity_id;";
        $result = $db->query($Q);
        if (!$result) {
            echo "<script>alert('修改失敗!')</script>";
            echo "<script>window.location.href='./cart_index.php';</script>";
        } else {
            echo "<script>alert('修改成功!')</script>";
            echo "<script>window.location.href='./cart_index.php';</script>";
        }
    } else if ($op == 3) { //購買
        $Commodity_id = (int) $_REQUEST['Commodity_id'];
        $num = (int) $_REQUEST['num'];
        $Q = "select * from Commodity where Commodity_id = $Commodity_id";
        $result = $db->query($Q);
        $A = $result->fetchAll(PDO::FETCH_ASSOC);
        // echo '貨號' . $Commodity_id . ' 買' . $num . '個' . $A[0]['Commodity_name'] . '價格為:' . $A[0]['Price'];
        //session_start();
        echo "<script>alert('加入成功!')</script>";
        echo "<script>window.location.href='./cart_index.php';</script>";
        $_SESSION['cart'] = $_SESSION['cart'] . ',' .  $Commodity_id . ',' . $num .
            ',' . $A[0]['Commodity_name'] . ',' . $A[0]['Price'] . ',' . ($num * $A[0]['Price'])
            . '|';
    } else if ($op == 99) { //結帳
        $data = explode('|', $_SESSION['cart']);
        $t = 0;
        $mobile = $_SESSION['id'];
        $Q = "select name,phone,address from client where account='${mobile}';";
        //echo $Q;
        $result = $db->query($Q);
        $A = $result->fetchAll(PDO::FETCH_ASSOC);
        $num = count($A);
        echo '<main><section class="main3">';
        echo "<h2>配送資訊</h2><hr>";
        for ($i = 0; $i < $num; $i = $i + 1) {
            $name = $A[$i]['name'];
            $phone = $A[$i]['phone'];
            $address = $A[$i]['address'];
            echo "<p>客戶姓名:${name}</p>";
            echo "<p>連絡電話:${phone}</p>";
            echo "<p>配送地址:${address}</p>";
            echo '<span><p>付款方式: </p><form id="form1" method="post" action="./mproc.php?op=79"><div class="form-check">
            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
            <label class="form-check-label" for="exampleRadios1">
                貨到付款
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
            <label class="form-check-label" for="exampleRadios2">
                ATM轉帳
            </label>
            </div></div></form><br><br></span>';
        }

        echo "<h2>購買細目</h2><hr>";
        echo '<table class="table table-striped">
        <tr>
        <th scope="col" width="30%">編號</th>
        <th scope="col" width="40%">項目</th>
        <th scope="col">小記</th>
        </tr>
        ';
        for ($i = 0; $i < count($data); $i = $i + 1) {
            if ($data[$i] == '') continue;
            $item = explode(',', $data[$i]);
            $total = $item[2] * $item[4];
            $tag = $i + 1;
            $t += $total;

            //$item[1] //commodity id
            echo "<tr>
            <td>($tag)</td>
            
            <td>$item[3]</td>
            <td  >NT$$total</td>
            </tr>
            ";
        }
        echo "</table><p class='end' id='totalid'>NT$$t</p>";
        echo '<input type="submit" id="submit" class="btn btn-success btn-lg btn-block" value="確認結帳"></input>';
        echo '</section></main>';
    } elseif ($op == 79) {
        $item = $_REQUEST['exampleRadios'];
        if ($item == 'option1') {
            $payment = '貨到付款';
        } else {
            $payment = 'ATM付款';
        }

        $data = explode('|', $_SESSION['cart']);

        $mobile = $_SESSION['id'];

        $Q = "select client_id,name,phone,address from client where account='${mobile}';";
        $result = $db->query($Q);
        $A = $result->fetchAll(PDO::FETCH_ASSOC);
        $num = count($A);
        date_default_timezone_set("Asia/Taipei");
        $today = date("Y-m-d H:i:s");
        for ($i = 0; $i < $num; $i = $i + 1) {
            $client_id = $A[$i]['client_id'];
        }
        echo $client_id;
        for ($i = 0; $i < count($data); $i = $i + 1) {
            if ($data[$i] == '') continue;
            $item = explode(',', $data[$i]);
            $Commodity_id = $item[1];
            $num = $item[2]; //數量
            $price = $item[4]; //價格
            $Q = "insert into state select max(order_number)+1,'${client_id}','${Commodity_id}','${payment}','${today}' from state ";
            $result = $db->query($Q);
            $Q = "insert into details select max(details_number)+1,max(details_number)+1,'${Commodity_id}','${price}','${num}' from details ";
            $result = $db->query($Q);
        }

        if (!$result) {
            echo "<script>alert('購買失敗!')</script>";
            echo "<script>window.location.href='./cart_index.php';</script>";
        } else {
            echo "<script>alert('購買成功!')</script>";
            $_SESSION['cart'] = '';
            echo "<script>window.location.href='./cart_index.php';</script>";
        }
    } else {
        echo '<br/><a href="index.html">你是駭客嗎?滾!</a>';
    }
    if ($op != 2) {
        echo '</body>
                        </html>';
    }

    ?>
</body>
<script>
    let sub = document.getElementById('submit');
    console.log(sub);
    let a = document.getElementById('form1')
    console.log(a);
    let total = document.getElementById('totalid')
    console.log(total.textContent);
    sub.addEventListener('click', () => {
        if (total.textContent == 'NT$0') {
            return alert("購物車目前為空!請選擇商品加入購物車")
        } else {
            a.submit();

        }


    })
</script>

</html>