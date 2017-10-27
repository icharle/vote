<?php
namespace Home\Model;
use Think\Model;

class VoteModel extends Model {

    /**
     * @param $openid
     * @param $flag
     * @return mixed
     * 首次回复插库
     */
    function addopenid($data){

        $vote = M('Vote');
        $map['openid'] = $data['openid'];
        $map['flag'] = $data['flag'];
        $result = $vote->add($map);
        return $result;

    }


    /**
     * @param $openid
     * @return mixed
     * 查询数据库中是否存在openID
     */
    function selopenid($openid){
        $vote = M('vote');
        $map['openid'] = $openid;
        $result = $vote->where($map)->find();
        return $result;
    }


    /**
     * @param $ip
     * @return mixed
     * 查询ip是否已经投过票
     */
    function selip($ip){
        $vote = M('vote');
        $map['ip'] = $ip;
        $result = $vote->where($map)->find();
        return $result;
    }

    /**
     * @param $openid
     * @return mixed
     * 判断该用户是否投过票
     */
    function selflag($openid){
        $vote = M('vote');
        $map['openid'] = $openid;
        $result = $vote->where($map)->find();
        $result = $result['flag'];
        return $result;
    }

    /**
     * @param $openid
     * @param $class
     * @param $flag
     * @param $ip
     * @param $time
     * @return mixed
     * 投票插库
     */
    function updatedata($data){

        $vote = M('vote');
        $where['openid'] = $data['openid'];
        $map['class'] = $data['class'];
        $map['flag'] = $data['flag'];
        $map['ip'] = $data['ip'];
        $map['time'] = $data['time'];
        $result = $vote->where($where)->save($map);
        return $result;

    }

}