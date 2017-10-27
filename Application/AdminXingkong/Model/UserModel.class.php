<?php
namespace AdminXingkong\Model;
use Think\Model;
class UserModel extends Model{

    function login($admin_user,$admin_pw){
        $user = M('user');
        $map['admin_user'] =$admin_user;
        $map['admin_pw'] =$admin_pw;
        $result = $user->where($map)->find();
        return $result;

    }
}