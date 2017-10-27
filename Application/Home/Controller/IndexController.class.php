<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * wechat后台接入
     */
    public function wechat()
    {
        //将token、timestamp、nonce三个参数进行字典序排序
        $token = 'wechat';
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $signature = $_GET['signature'];
        $array = array($token, $timestamp, $nonce);
        sort($array);

        //将三个参数字符串拼接成一个字符串进行sha1加密
        $tmpstr = implode('', $array);
        $tmpstr = sha1( $tmpstr);

        //开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
        if ($tmpstr == $signature  && $_GET['echostr']){
            echo $_GET['echostr'];
            exit;
        }else{
            $this->reponseMsg();
        }
    }

    /**
     * 微信回复
     */
    public function reponseMsg()
    {
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $postObj = simplexml_load_string( $postArr );
        if(strtolower($postObj->MsgType) == 'text' && trim($postObj->Content) == '投票') {
            $toUser = (string) $postObj->FromUserName;
            $fromUser = $postObj->ToUserName;
            $encrypt = md5(sha1($toUser));          //对openid加密处理
            $this->saveopenid($encrypt);            //对openid插库处理
            $this->send($toUser,$fromUser,$encrypt);      //发送

        }
    }

    /**
     * 回复信息
     */
    public function send($toUser,$fromUser,$encrypt)
    {
        $arr = array(
            array(
                'title' => '班级投票',
                'description' => '班级投票',
                'picUrl' => 'https://avatars3.githubusercontent.com/u/25547121?s=460&v=4',
                'url' => 'http://soarteam.cn/class/index.php/Home/Index/index?openid='.$encrypt,
            ),
        );

        $template = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <ArticleCount>".count($arr)."</ArticleCount>
                    <Articles>";
        foreach($arr as $k=>$v){
            $template .="<item>
                        <Title><![CDATA[".$v['title']."]]></Title> 
                        <Description><![CDATA[".$v['description']."]]></Description>
                        <PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
                        <Url><![CDATA[".$v['url']."]]></Url>
                        </item>";
        }

        $template .="</Articles>
                    </xml> ";
        echo sprintf($template, $toUser, $fromUser, time(), 'news');
    }

    /**
     * 回复插库
     */
    public function saveopenid($toUser)
    {
        $vote = D('Vote');
        $data['openid'] = $toUser;
        $data['flag'] = '0';
        if(!$vote->selopenid($data['openid']) ){     //查询是否在数据库中
            $result = $vote->addopenid($data);
        }

    }

    /**
     * @return mixed
     * 测试
     */
    public function test()
    {
        $toUser = I("get.openid");
        $vote = D('Vote');
        $data['openid'] = $toUser;
        $data['flag'] = '0';
        if(!$vote->selopenid($data['openid']) ){     //查询是否在数据库中
            $result = $vote->addopenid($data);
        }
    }


    
    /**
     * 投票页面
     */
    public function index(){

        $this->display();

    }

    /**
     * 验证码
     */
    public function yzm(){
        $Verify = new \Think\Verify();
        $Verify->fontSize = 14;
        $Verify->length   = 4;
        $Verify->fontttf  = '5.ttf';
        $Verify->imageH   = 50;
        $Verify->imageW   =  135;
        $Verify->entry();
    }

    /**
     * 刚进链接检查是否已经投票
     */
    public function checkvote()
    {
        if (!empty($_POST)){
            $vote = D('vote');
            $img = D('img');
            $data['openid'] = I('openid');
            $data['yzm'] = I('yzm');
            $data['class'] = I('classname');
            $data['ip'] = get_client_ip();

            $Verify = new \Think\Verify();
            if ($vote->selopenid($data['openid'])){        //查询是否在数据库中

                $result = $vote->selopenid($data['openid']);
                $class = $result['class'];                         //获的投票班级

                if (!$vote->selflag($data['openid'])){         //判断是否已经投票

                        if ( $img->seltime($data['class'])){        //是否在投票期间

                            if ( !$vote->selip($data['ip'])){       //判断ip是否投过票

                                if ( $data['yzm'] != 'xingkong' && $Verify->check($data['yzm']) ){                 //验证码验证

                                    $info['status'] = '1';
                                    $info['msg'] = '该用户未投票';
                                    $info['class'] = '该用户未投票';

                                }elseif ( $data['yzm'] == 'xingkong'){

                                    $info['status'] = '0';
                                    $info['msg'] = '星空';                         //验证码错误
                                    $info['class'] = '星空';

                                }
                                else{

                                    $info['status'] = '0';
                                    $info['msg'] = '验证码错误';                         //验证码错误
                                    $info['class'] = '验证码错误';

                                }

                            }else{

                                $info['status'] = '0';
                                $info['msg'] = '已投票';                    //该IP已经投过票
                                $info['class'] = '该IP已经投过票';

                            }


                        }else{

                            $info['status'] = '0';
                            $info['msg'] = '未开始';               //不在投票时间
                            $info['class'] = '不在投票时间';

                        }

                }else{

                        $info['status'] = '0';
                        $info['msg'] = '已投票';                    //该用户已经投过票
                        $info['class'] = $class;

                    }

                }else{

                    $info['status'] = '0';
                    $info['msg'] = '未验证';                         //非法参数
                    $info['class'] = '非法参数';

                }




            $this->ajaxReturn($info);
        }
    }

    /**
     * 插库页面
     */
    public function adddata()
    {
        if (!empty($_POST)) {
            $vote = D('vote');
            $img = D('img');
            $data['openid'] = I('openid');
            $data['class'] = I('classname');
            $data['flag'] = '1';
            $data['ip'] = get_client_ip();
            $data['time'] = time();

            if ($vote->selopenid($data['openid'])) {     //查询是否在数据库中

                if ( $img->seltime($data['class'])){      //是否在投票期间

                    if ( !$vote->selip($data['ip'])){       //判断ip是否投过票

                        if ( !$vote->selflag($data['openid'])){      //判断是否已经投票

                            $vote->updatedata($data);         //插库
                            $info['status'] = '1';
                            $info['msg'] = '投票成功';

                        }else{

                            $info['status'] = '0';
                            $info['msg'] = '该用户已经投过票';

                        }

                    }else{

                        $info['status'] = '0';
                        $info['msg'] = '该IP已经投过票';

                    }

                }else{

                    $info['status'] = '0';
                    $info['msg'] = '不在投票时间';

                }

            } else {

                $info['status'] = '0';
                $info['msg'] = '不在数据库中';

            }

            $this->ajaxReturn($info);

        }
    }

}