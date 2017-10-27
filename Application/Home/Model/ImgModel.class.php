<?php
namespace Home\Model;
use Think\Model;

class ImgModel extends Model {

    /**
     * @param $class
     * @return mixed
     * 是否在投票时间
     */
    function seltime($class){

        $img = M('img');
        $map['class'] = $class;
        $result = $img->where($map)->find();
        $result = $result['img'];
        return $result;

    }


    /**
     * @param $class
     * @param $total
     * @return bool
     * 更新插库
     */
    function updatedata($class,$total){

        $img = M('img');
        $where['class'] = $class;
        $map['count'] = $total;
        $result = $img->where($where)->save($map);
        return $result;

    }

}