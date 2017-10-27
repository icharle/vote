<?php
namespace AdminXingkong\Controller;
use Think\Controller;
class IndexController extends Controller {

    /**
     * 后台管理页面
     */
    public function index(){
        if (!isset($_SESSION['username'])){
            $this->error('请先登录管理员账户，正在跳转...',U('Index/login'),3);
        }else{
            $img = D('img');
            $vote = D('Vote');
            $res = $img->order('id')->select();

            /**
             * 监控
             * 1509015000  2017/10/26 18:50:0
             * 1509015600  2017/10/26 19:0:0
             * 1509016200  2017/10/26 19:10:0
             * 1509016800  2017/10/26 19:20:0
             * 1509023400  2017/10/26 21:10:0
             *
             * 1508842200  2017/10/24 18:50:0
             * 1508850600  2017/10/24 21:10:0
             */
            $start = '1509015000';     //2017/10/26 18:50:0
            $stop = '1509023400';      //2017/10/26 21:10:0
            for ($i=0;$i<8;$i++){
                $plus = 1200*$i;
                $map['time']  = array('between',array($start+$plus,$stop+$plus));
                $list = $vote->field('class,count(id) as total')->where($map)->group('class')->select();
                foreach ($list as $value){
                    if ($value['class'] == '工管6班'){
                        $data1 .= $value['total'].",";
                    }else{
                        $data1 .= '0'.",";
                    }
                    if ($value['class'] == '会计10班'){
                        $data2 .= $value['total'].",";
                    }else{
                        $data2 .= '0'.",";
                    }
                    if ($value['class'] == '人力2班'){
                        $data3 .= $value['total'].",";
                    }else{
                        $data3 .= '0'.",";
                    }
                    if ($value['class'] == '会计5班'){
                        $data4 .= $value['total'].",";
                    }else{
                        $data4 .= '0'.",";
                    }
                    if ($value['class'] == '工管2班'){
                        $data5 .= $value['total'].",";
                    }else{
                        $data5 .= '0'.",";
                    }
                    if ($value['class'] == '人力4班,会计4, 6班'){
                        $data6 .= $value['total'].",";
                    }else{
                        $data6 .= '0'.",";
                    }
                    if ($value['class'] == '市营1,2班'){
                        $data7 .= $value['total'].",";
                    }else{
                        $data7 .= '0'.",";
                    }

                }
            }
            $data1 = substr($data1, 0, -1);
            $data2 = substr($data2, 0, -1);
            $data3= substr($data3, 0, -1);
            $data4 = substr($data4, 0, -1);
            $data5 = substr($data5, 0, -1);
            $data6 = substr($data6, 0, -1);
            $data7 = substr($data7, 0, -1);
            $this->assign('data1',$data1);
            $this->assign('data2',$data2);
            $this->assign('data3',$data3);
            $this->assign('data4',$data4);
            $this->assign('data5',$data5);
            $this->assign('data6',$data6);
            $this->assign('data7',$data7);

            $this->assign('res',$res);
            $this->display();
        }
    }


    /**
     * 登录
     */
    public function login()
    {
        if (!empty($_POST)){
            $user = D('User');
            $admin_user = I('admin_user');
            $admin_pw = md5( I('admin_pw') );
            $result = $user->login($admin_user,$admin_pw);
            if ($result){
                session('username',$admin_user);
                $this->success('登录成功，正在跳转...', U('Index/index'),3);
            }else{
                $this->error('用户名或者密码错误');
                $this->display();
            }
        }else{
            $this->display();
        }
    }

    /**
     * 启用投票
     */
    public function start()
    {

        if (!empty($_POST)){
            $id = I('id');
            $img = D('img');
            $result = $img->startchange($id);
            if ($result){
                $data['status'] = '1';
                $data['msg'] = '更改成功';
            }else{
                $data['status'] = '0';
                $data['msg'] = '更改失败';
            }
            $this->ajaxReturn($data);
        }

    }


    /**
 * 停止投票
 */
    public function stop()
    {

        if (!empty($_POST)){
            $id = I('id');
            $img = D('img');
            $result = $img->stopchange($id);
            if ($result){
                $data['status'] = '1';
                $data['msg'] = '更改成功';
            }else{
                $data['status'] = '0';
                $data['msg'] = '更改失败';
            }
            $this->ajaxReturn($data);
        }

    }


    /**
     * 减票
     */
    public function cut()
    {

        if (!empty($_POST)){
            $class = I('classname');
            $num = I('num');
            $vote = D('vote');
            $where['class'] = $class;
            $result = $vote->where($where)->order('id')->limit($num)->delete();
            if ($result){
                $data['status'] = '1';
                $data['msg'] = '更改成功';
            }else{
                $data['status'] = '0';
                $data['msg'] = '更改失败';
            }
            $this->ajaxReturn($data);
        }

    }

    /**
     * 清空vote表
     */
    public function clearvote()
    {
        $vote = D('vote');
        $result = $vote->where('1')->delete();
        if ($result){
            $this->success('删除成功',U('Index/index'),3);
        }

    }


    /**
     * 清空img表
     */
    public function clearimg()
    {
        $img = D('img');
        $data['count'] = '0';
        $result = $img->where('id>0')->save($data);
        if ($result){
            $this->success('删除成功',U('Index/index'),3);
        }
    }

    /**
     * 查询vote表条数
     */
    public function votecount()
    {
        $vote = D('vote');
        $total = $vote->count();
        var_dump($total);
    }

}