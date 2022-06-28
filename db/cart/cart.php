<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <link rel="icon" href="./icon/online-shopping.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="rebots" content="index, follow" />
    <meta name="description" content="網頁說明文字">
    <meta name="author" content="作者" />
    <title>購物車</title>
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
                <!-- <li class="nav-item">
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
                </li> -->
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
                echo '<a href="#"><button  type="button" style="margin-right:1rem;" class="btn btn-primary">購物車</button></a>';
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
        require('mauth.php');
        $op = (int) $_REQUEST['op'];
        if ($op == -99) {
            $_SESSION['cart'] = '';
            echo "<script>alert('清除成功!')</script>";
            echo "<script>window.location.href='./cart.php';</script>";
            die('');
        }
        //echo $_SESSION['id'] . '  ' . $_SESSION['cart'] . '<br/>';
        $data = explode('|', $_SESSION['cart']);



        $t = 0;
        //main1
        echo '<section class="main1">';

        echo '<h1>購物車</h1><hr><table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">編號</th>
            <th scope="col">項目</th>
            
            <th scope="col">數量</th>
            <th scope="col">售價</th>
            
            </tr>
        </thead>';
        if (count($data) == 1) {
            echo '</table>';
            echo '<h1 style="text-align: center; padding:2rem"><i class="fa-solid fa-cart-arrow-down"></i> 購物車是空的!</h1></section>';
        } else {
            for ($i = 0; $i < count($data); $i = $i + 1) {
                if ($data[$i] == '') continue;
                $item = explode(',', $data[$i]);
                $total = $item[2] * $item[4];
                $tag = $i + 1;
                echo "<tbody>
            <tr>
            <th scope='row'>($tag)</th>
            <td>$item[3]</td>
            
            <td>$item[2]</td>
            <td>$item[4]</td>
            
            </tr>
            </tbody>";
                // echo
                // '編號:' . ($i + 1)
                //     . ' 名稱:' . $item[3]
                //     . ' 單價:' . $item[4]
                //     . ' 數量:' . $item[2]
                //     . ' 總價為:' . $item[5] . '<br/>';
                // $t = $t + (int)$item[5];
                $t = $t + (int)$item[5];
            }
            echo '</table></section>';
        }




        //main2
        echo '<section class="main2">';
        echo "<h1>小記</h1><hr>";
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
            echo "<tr>
            <td>($tag)</td>
            <td>$item[3]</td>
            <td  >NT$$total</td>
            </tr>
            ";
        }
        echo "</table><p class='end'>NT$$t</p>";
        echo '<a href="mproc.php?op=99"><button type="button" class="btn btn-primary btn-lg btn-block">前往結帳</button></a>
        <a href="cart.php?op=-99"><button type="button" class="btn btn-danger btn-lg btn-block">清空購物車</button></a>';
        echo '</section>';

        ?>

    </main>

</body>

</html>