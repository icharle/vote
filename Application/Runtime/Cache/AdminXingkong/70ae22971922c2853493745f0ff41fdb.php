<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="http://soarteam.cn/class/Application/Public/admin/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://soarteam.cn/class/Application/Public/admin/bootstrap.min.css" />
    <script type="text/javascript" src="http://soarteam.cn/class/Application/Public/first/js/jquery.1.10.2.js"></script>
    <title>管理员后台</title>
</head>
<body>
    <div class="container table-responsive">
        <h2>投票控制</h2>
        <table class="table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr>
                <th>班级</th>
                <th>控制</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>工商一班</td>
                <td>
                    <a href="javascript:;" onclick="start('1')">启用</a>
                    <a href="javascript:;" onclick="stop('1')">停止</a>
                </td>
            </tr>
            <tr>
                <td>工商二班</td>
                <td>
                    <a href="javascript:;" onclick="start('2')">启用</a>
                    <a href="javascript:;" onclick="stop('2')">停止</a>
                </td>
            </tr>
            <tr>
                <td>工商三班</td>
                <td>
                    <a href="javascript:;" onclick="start('3')">启用</a>
                    <a href="javascript:;" onclick="stop('3')">停止</a>
                </td>
            </tr>
            <tr>
                <td>工商四班</td>
                <td>
                    <a href="javascript:;" onclick="start('4')">启用</a>
                    <a href="javascript:;" onclick="stop('4')">停止</a>
                </td>
            </tr>
            <tr>
                <td>工商五班</td>
                <td>
                    <a href="javascript:;" onclick="start('5')">启用</a>
                    <a href="javascript:;" onclick="stop('5')">停止</a>
                </td>
            </tr>
            <tr>
                <td>工商六班</td>
                <td>
                    <a href="javascript:;" onclick="start('6')">启用</a>
                    <a href="javascript:;" onclick="stop('6')">停止</a>
                </td>
            </tr>
            <tr>
                <td>工商七班</td>
                <td>
                    <a href="javascript:;" onclick="start('7')">启用</a>
                    <a href="javascript:;" onclick="stop('7')">停止</a>
                </td>
            </tr>
            <tr>
                <td>工商八班</td>
                <td>
                    <a href="javascript:;" onclick="start('8')">启用</a>
                    <a href="javascript:;" onclick="stop('8')">停止</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</body>
<script>
    function start($id) {
        $.ajax({
            type: "POST",
            url: "/class/index.php/Home/Index/adddata",
            data: {
                openid : openid,
                classname : name,
            },
            success: function (data) {
                if (data.status == 1){
                    //location.href = location.href;
                }else {
                    //location.href = location.href;
                }
            }

        });
    }
    function stop($id) {
        $.ajax({
            type: "POST",
            url: "/class/index.php/Home/Index/adddata",
            data: {
                openid : openid,
                classname : name,
            },
            success: function (data) {
                if (data.status == 1){
                    //location.href = location.href;
                }else {
                    //location.href = location.href;
                }
            }

        });
    }
</script>
</html>