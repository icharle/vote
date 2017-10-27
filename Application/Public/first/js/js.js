$(document).ready(function() {
    // 获取每个元素
    var gs1 = document.getElementById("gs1");
    var gs2 = document.getElementById("gs2");
    var gs3 = document.getElementById("gs3");
    var gs4 = document.getElementById("gs4");
    var gs5 = document.getElementById("gs5");
    var gs6 = document.getElementById("gs6");
    var gs7 = document.getElementById("gs7");
    var gs8 = document.getElementById("gs8");
    var vote_details = document.getElementById("vote_details");
    var VerifiCode = document.getElementById("VerifiCode");
    var close = document.getElementById("close");
    var clpicture = document.getElementById("clpicture");
    var vote_clname = document.getElementById("vote_clname");
    var vote_clpg = document.getElementById("vote_clpg");
    var vote_clvote = document.getElementById("vote_clvote");
    var button = document.getElementById("button");
    var code_order = document.getElementById("code_order");
    var Code_img = document.getElementById("Code_img");       //验证码点击
    var Code_text = document.getElementById("Code_text");//客户端输入的验证码内容

    /**
     * 获取链接openID
     * @returns {*}
     * @constructor
     */
    function GetRequest() {
        var url = location.search; //获取url中"?"符后的字串
        var theRequest = new Object();
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            strs = str.split("&");
            for(var i = 0; i < strs.length; i ++) {
                theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
            }
        }
        return theRequest['openid'];
    }



    /**
     * 检查是否已经投票,改变前端样式
     * @constructor
     * 第三个参数： 0表示点击图片  1表示点击投票按钮
     * 第四个参数为验证码  xingkong表示为点击图片    其它表示点击投票按钮
     */
    function Checkvote(openid,name,value,yzm) {
        $.ajax({
            type: "POST",
            url: "/class/index.php/Home/Index/checkvote",
            data: {
                openid : openid,
                classname : name,
                yzm : yzm
            },
            success: function (data) {
                if (data.status == 1 && value==1){
                    repeat(0);
                }else if(data.status == 0){
                    if(data.class == name){               //该点击按钮跟投票班级一致的话，更改按钮
                        button_change(data.msg);
                        buttonpower = 1;
                        banji = data.class;
                    }else if (data.class != name && data.msg=='已投票'){
                        button_rec();
                        buttonpower = 1;
                        banji = data.class;
                    }else if (data.class == '非法参数'){
                        button_change(data.msg);
                        buttonpower = 1;
                    }else if (data.class == '不在投票时间'){
                        button_change(data.msg);
                        buttonpower = 1;
                    }else if (data.class == '该IP已经投过票'){
                        button_change(data.msg);
                        buttonpower = 1;
                    }else if ( data.class != name && value==1 && data.class != '验证码错误'){            //该用户已经投票，如果该用户再次点击投票会返回请勿重复投票
                        repeat(1,data.class);
                    }else if (data.class == '验证码错误' && value==1){
                        repeat(2,data.msg);
                    }else if (data.class == '星空' && value==0){
                        button_rec();
                    }
                }
            }

        });
    }


    $("#close").on("click", //关闭投票按钮点击时触发
        function(e) {
            indisplay_vote();
            button_rec();
            buttonpower =0;
            banji =0;
        });
    $("#code_close").on("click", //关闭验证码窗口按钮点击时触发
        function(e) {
            indisplay_code();
        });

    $("#gs1").on("click", //点击班级时弹出投票框，获得数据后删除下面代码的注释
        function(e) {
            display_vote("#gs1",gs1);
            Checkvote(GetRequest(),vote_clname.innerText,0,'xingkong');        //检查是否已经投票,改变前端样式
        });

    $("#gs2").on("click",
        function(e) {
            display_vote("#gs2",gs2);
            Checkvote(GetRequest(),vote_clname.innerText,0,'xingkong');        //检查是否已经投票,改变前端样式
        });
    $("#gs3").on("click",
        function(e) {
            display_vote("#gs3",gs3);
            Checkvote(GetRequest(),vote_clname.innerText,0,'xingkong');        //检查是否已经投票,改变前端样式
        });
    $("#gs4").on("click",
        function(e) {
            display_vote("#gs4",gs4);
            Checkvote(GetRequest(),vote_clname.innerText,0,'xingkong');        //检查是否已经投票,改变前端样式
        });
    $("#gs5").on("click",
        function(e) {
            display_vote("#gs5",gs5);
            Checkvote(GetRequest(),vote_clname.innerText,0,'xingkong');        //检查是否已经投票,改变前端样式
        });
    $("#gs6").on("click",
        function(e) {
            display_vote("#gs6",gs6);
            Checkvote(GetRequest(),vote_clname.innerText,0,'xingkong');        //检查是否已经投票,改变前端样式
        });
    $("#gs7").on("click",
        function(e) {
            display_vote("#gs7",gs7);
            Checkvote(GetRequest(),vote_clname.innerText,0,'xingkong');        //检查是否已经投票,改变前端样式
        });
    $("#gs8").on("click",
        function(e) {
            display_vote("#gs8",gs8);
            Checkvote(GetRequest(),vote_clname.innerText,0,'xingkong');        //检查是否已经投票,改变前端样式
        });

    $("#button").on("click",
        function(e) {                                  //投票按钮点击时触发
            if (buttonpower == 0){
                display_code();
            }else if ( buttonpower == 1 && banji != 0){
                repeat(1,banji);
            }

        });

    //提交客户端的验证值
    $("#code_order").on("click",
        function(e) {                               //验证码按钮点击时触发
            Checkvote(GetRequest(),vote_clname.innerText,1,Code_text.value);
        });


    /**
     *
     * @param value
     * 重复投票判断
     */
    function repeat(value,msg) {
        if (value==1){
            layer.msg('你已经投票给'+ msg + '!', {icon: 6});
            indisplay_code();
        }else if(value==0){

            layer.confirm("确定要投票给" + vote_clname.innerText + "吗？", {
                btn: ['确定','取消'] //按钮
            }, function(){
                vote_add(GetRequest(),vote_clname.innerText);
                button_change("已投票");
            }, function(){
                layer.msg("投票失败！", {icon: 5});
                indisplay_code();
            });
        }else if(value==2){                   //验证码错误
            layer.msg(msg + "!", {icon: 5});
            $("#Code_img").click();
        }

    }



});


var flag = 0; //判断是否已经投过票
var flag2 = 0; //判断投票窗口是否有显示
var codeflag2 = 0;//判断验证码窗口是否显示
var buttonpower = 0;
var banji =0;

function display_vote(cl,clid) {
    if (flag2 == 0) {
        if(cl == "#gs6"){
            vote_details.style.display = "block";
            var classname = $(cl).find("div").get(0).innerText+","+$(cl).find("div").get(1).innerText;;
            var pgname = $(cl).find("div").get(2).innerText;
            change_vote_clname(classname);
            change_vote_pgname(pgname);
            clpicture.style.background = clid.style.background;
            flag2 = 1;
        }else{
            vote_details.style.display = "block";
            var classname = $(cl).find("div").get(0).innerText;
            var pgname = $(cl).find("div").get(1).innerText;
            change_vote_clname(classname);
            change_vote_pgname(pgname);
            clpicture.style.background = clid.style.background;
            flag2 = 1;
        }

    }
}

function indisplay_vote() {
    vote_details.style.display = "none";
    flag2 = 0;
}

function display_code() {
    if (codeflag2 == 0) {
        $("#Code_img").click();
        VerifiCode.style.display = "block";
        codeflag2 = 1;
    }
}

function indisplay_code() {
    Code_text.value ="";//关闭验证码窗口时候清空内容
    VerifiCode.style.display = "none";
    indisplay_vote();
    codeflag2 = 0;
}


//显示每个班不同的投票框
function change_vote_bg(bg) {
    clpicture.style.background = bg.style.background;
}
function change_vote_clname(changename) {
    vote_clname.innerText = changename;
}

function change_vote_pgname(changepg) {
    vote_clpg.innerText = " ";
    vote_clpg.innerText = changepg;
}
//得到票数数据并显示在页面上
function change_vote_clvote(changevote) {
    vote_clvote.innerText = parseInt(changevote) + "票";
}

/**
 * 添加票数
 * @param openid
 * @param name
 */
function vote_add(openid,name) {
    $.ajax({
        type: "POST",
        url: "/class/index.php/Home/Index/adddata",
        data: {
            openid : openid,
            classname : name,
        },
        success: function (data) {
            if (data.status == 1){
                layer.msg('投票成功！', {icon: 6});
                indisplay_code();
                //location.href = location.href;
            }else {
                layer.msg('投票失败！', {icon: 5});
                indisplay_code();
                //location.href = location.href;
            }
        }

    });
}

//改变投票按钮样式
function button_change(msg) {
    button.innerText = msg;
    button.style.color = "white";
    button.style.background = "#56c7f5";
    flag = 1;
}



//还原投票按钮样式
function button_rec() {
    button.innerText = '投票';
    button.style.color = "#ea3f35";
    button.style.background = "white";
    flag = 0;
}