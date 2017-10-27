<?php
namespace Home\Controller;
use Think\Controller;
class DetailController extends Controller {

    /**
     * 主页面显示
     */
    public function index()
    {
        $this->display();
    }

    public function seldata()
    {
        if (!empty($_POST)){
            $vote = D('Vote');
            $img = D('Img');
            $sql = "SELECT class, COUNT(id) AS total FROM  `vote` GROUP BY class";
            $result = $vote->query($sql);

            foreach ($result as $key){
                $img->updatedata($key['class'],$key['total']);
            }

            $sql = "SELECT  `class` ,  `count` FROM  `img` ";
            $result = $img->query($sql);

            foreach ($result as $key){
                if ($key['class'] == '工管6班'){
                    $datainfo['one'] = $key['count'] ;
                }elseif ($key['class'] == '会计10班'){
                    $datainfo['two'] = $key['count'];
                }elseif ($key['class'] == '人力2班'){
                    $datainfo['three'] = $key['count'] ;
                }elseif ($key['class'] == '会计5班'){
                    $datainfo['four'] = $key['count'] ;
                }elseif ($key['class'] == '工管2班'){
                    $datainfo['five'] = $key['count'];
                }elseif ($key['class'] == '人力4班,会计4, 6班'){
                    $datainfo['six'] = $key['count'] ;
                }elseif ($key['class'] == '市营1, 2班'){
                    $datainfo['seven'] = $key['count'];
                }
            }

            $this->ajaxReturn($datainfo);
        }

    }

}