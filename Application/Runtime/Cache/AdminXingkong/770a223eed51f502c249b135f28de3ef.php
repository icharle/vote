<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员登录</title>
</head>
<style>
    body{
        background-color: blue;
    }
    h1{
        color: white;
    }
    input{
        width: 200px;
        height: 30px;
        border-radius: 6px;
        margin-top: 30px;
    }
</style>
<body>
    <center>
        <h1>后台管理登录</h1>
        <form action="<?php echo U('Index/login');?>" method="post">
            <input type="text" name="admin_user" id="admin_user" placeholder="用户名">
            <br>
            <input type="password" name="admin_pw" id="admin_pw" placeholder="密码">
            <br>
            <input type="submit" value="登录">
        </form>
    </center>
</body>
</html>