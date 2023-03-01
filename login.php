<?php
session_start();
include_once('./include/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>
        body {
            text-align: center;
        }
    </style>
    <title>LOGIN</title>
</head>

<body>
    <div style="margin: 50px 0 0 0 ;">
        <p>Đăng nhập</p>
    </div>
    <div>
        <form method="post">
            <input type="text" name="username" placeholder="User Name" required=''>
            <br>
            <input style="margin: 10px 0 10px 0 ;" placeholder="Password" type="password" name="password"> 
            <br>
            <button type="submit" name="submitlogin" class="btn btn-primary">Đăng nhập</button>
        </form>
    </div>

</body>

</html>