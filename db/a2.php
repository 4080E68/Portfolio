<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>a2</title>
</head>
<body>
    <?php
        session_start();
        $t = (float)$_SESSION['t'];
        $a = (int)$_REQUEST['a'];//(int)強制轉變數型態
        $total = $t + $a;
        $_SESSION['t'] = $total;
        echo '這次輸入:'.$a.'連加答案是:'.$_SESSION['t'];
        // $b = $_REQUEST['b'];
        // for($i = 0; $i < $b;$i++){
        //     $a += 1;
        // }
        // echo $a;
    ?>
    <br>
    <a href="https://db.vexp.idv.tw/~h568/db/a2.html">
        <input type="button" value="返回" >
    </a>
</body>
</html>
