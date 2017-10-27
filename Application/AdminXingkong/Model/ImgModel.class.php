<?php
namespace AdminXingkong\Model;
use Think\Model;
class ImgModel extends Model{

    function startchange($id){
        $img = M('img');
        $where['id'] = $id;
        $map['img'] = '1';
        $result = $img->where($where)->save($map);
        return $result;

    }


    function stopchange($id){

        $img = M('img');
        $where['id'] = $id;
        $map['img'] = '0';
        $result = $img->where($where)->save($map);
        return $result;

    }

}