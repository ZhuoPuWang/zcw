<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"D:\phpStudy\PHPTutorial\WWW\zcw2\public/../application/admin\view\course\coursekj.html";i:1544676015;s:80:"D:\phpStudy\PHPTutorial\WWW\zcw2\application\admin\view\template\basecourse.html";i:1544676015;s:76:"D:\phpStudy\PHPTutorial\WWW\zcw2\application\admin\view\template\header.html";i:1544676015;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link type="text/css" rel="stylesheet" href="/zcw2/public/static/css/global-pc.css" />
    <link type="text/css" rel="stylesheet" href="/zcw2/public/static/css/index.css" />
    <link type="text/css" rel="stylesheet" href="/zcw2/public/static/css/page.css" />
    <link type="text/css" rel="stylesheet" href="/zcw2/public/static/css/validform.css"/>
    <link type="text/css" rel="stylesheet" href="/zcw2/public/static/css/swiper.css"/>
    <link type="text/css" rel="stylesheet" href="/zcw2/public/static/css/Hui-iconfont/iconfont.css"/>
    <script src="/zcw2/public/static/js/jquery-1.8.2.min.js"></script>
    <script src="/zcw2/public/static/js/index.js" type="text/javascript" charset="utf-8"></script>
    <script src="/zcw2/public/static/js/page.js" type="text/javascript" charset="utf-8"></script>
    <script src="/zcw2/public/static/js/jquery.media.js" type="text/javascript" charset="utf-8"></script>
    
    
</head>
<body>
<!--顶部-->



<div class="header">
    <div class="header_top">
        <div class="header_cont clear">
            <div class="header_cont_l">服务热线：<?php echo $_SESSION['sh']['phone'];; ?> </div>
            <div class="header_cont_r clear">
                <div class="user">
                    <div class="user_name" style="width: 160px"><img src="/zcw2/public/static/images/tx.png"/>
                        <span><?php echo \think\Request::instance()->session('username'); if($_SESSION['think']['role'] == 0): ?>(学员)<?php elseif($_SESSION['think']['role'] == 1): ?>(教师)<?php elseif($_SESSION['think']['role'] == 2): ?>(管理员)<?php endif; ?></span>
                    </div>
                    <dl class="hide">
                        <dd><a href="<?php echo url('index/User/info','',false,true); ?>">我的信息</a></dd>
                        <dd><a href="<?php echo url('index/User/team','',false,true); ?>">我的团队</a></dd>
                        <dd><a href="<?php echo url('index/User/help','',false,true); ?>">使用帮助</a></dd>
                        <dd><a href="<?php echo url('User/logout','',false,true); ?>">注销</a></dd>
                    </dl>
                </div>
                <span class="xinxi"><img src="/zcw2/public/static/images/ld.png"/></span>
            </div>
        </div>
    </div>
    <!--导航栏-->
    <div class="header_box clear">
        <div class="header_logo">
            <a href="<?php echo url('index/index/index','',false,true); ?>">
                <img src="/zcw2/public/static/images/logo.png"/><?php echo $_SESSION['sh']['name'];; ?>
            </a>
        </div>
        <ul class="header_nav clear">
            <li <?php if($base == 1): ?> class="header_nav_a" <?php endif; ?>><a href="<?php echo url('index/index/index','',false,true); ?>">首页</a></li>
            <li <?php if($base == 2): ?> class="header_nav_a" <?php endif; ?>><a href="<?php echo url('index/train/index','',false,true); ?>">我的培训</a></li>
            <li <?php if($base == 3): ?> class="header_nav_a" <?php endif; ?>><a href="<?php echo url('index/database/index','',false,true); ?>">资料库</a></li>
            <li <?php if($base == 4): ?> class="header_nav_a" <?php endif; ?>><a href="<?php echo url('index/teacher/index','',false,true); ?>">讲师</a></li>
            <li <?php if($base == 5): ?> class="header_nav_a" <?php endif; ?>><a href="<?php echo url('index/discuz/index','',false,true); ?>">讨论区</a></li>
            <li <?php if($base == 6): ?> class="header_nav_a" <?php if($_SESSION['think']['role'] < 1): ?>style="display:none;"<?php endif; endif; ?>><a href="<?php echo url('report/index','',false,true); ?>">报表</a></li>
            <li <?php if($base == 7): ?> class="header_nav_a" <?php if($_SESSION['think']['role'] < 2): ?>style="display:none;"<?php endif; endif; ?>><a href="<?php echo url('course/index','',false,true); ?>">管理</a></li>
        </ul>
    </div>
</div>

<!--container-->
<div class="container clear">
    <ul class="bj_list">
        <li class="li_bj">
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g4.png"  alt="" />
                <a href="<?php echo url('Course/edit',array('id'=>$ids),false,true); ?>">课程属性</a>
            </div>
        </li>
        <!--<li>-->
            <!--<div class="li_tit">-->
                <!--<img src="/zcw2/public/static/images/g2.png" alt="" />-->
                <!--<a href="<?php echo url('course/coursereport',array('id'=>$ids),false,true); ?>">课程报表</a>-->
            <!--</div>-->
        <!--</li>-->
        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g2.png" alt="" />
                <a href="<?php echo url('course/courseteacher',array('id'=>$ids),false,true); ?>">关联教师</a>
            </div>
        </li>
        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g2.png" alt="" />
                <a href="<?php echo url('course/coursestudent',array('id'=>$ids),false,true); ?>">关联学生</a>
            </div>
        </li>

        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g2.png" alt="" />
                <a href="<?php echo url('course/courseplay',array('id'=>$ids),false,true); ?>">课程预览</a>
            </div>
        </li>
        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g2.png" alt="" />
                <a href="<?php echo url('course/coursekj',array('id'=>$ids),false,true); ?>">课程更新</a>
            </div>
        </li>
        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g2.png" alt="" />
                <a href="<?php echo url('course/ks',array('id'=>$ids),false,true); ?>">关联考试</a>
            </div>
        </li>
        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g2.png" alt="" />
                <a href="<?php echo url('course/pg',array('id'=>$ids),false,true); ?>">关联评估</a>
            </div>
        </li>
        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g2.png" alt="" />
                <a href="<?php echo url('course/dy',array('id'=>$ids),false,true); ?>">关联调研</a>
            </div>
        </li>
        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g2.png" alt="" />
                <a href="<?php echo url('course/dz',array('id'=>$ids),false,true); ?>">关联讨论区</a>
            </div>
        </li>

        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g2.png" alt="" />
                <a href="<?php echo url('course/zs',array('id'=>$ids),false,true); ?>">关联证书</a>
            </div>
        </li>

        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g2.png" alt="" />
                <a href="<?php echo url('course/delete',array('id'=>$ids),false,true); ?>">删除课程</a>
            </div>
        </li>
        <li>
            <div class="li_tit">
                <img src="/zcw2/public/static/images/g3.png" alt="" />
                <a href="<?php echo url('course/index','',false,true); ?>">返回</a>
            </div>
        </li>
    </ul>
    
<div class="container_content">
    <div class="container_content_tit">课件上传</div>
    <div class="add">

        <form id="form" action="<?php echo url('Course/coursekj','',false,true); ?>" method="post">
            <input type="hidden" name="course_id" value="<?php echo $ids; ?>">
            <ul class="add_ul">

                <li class="clear">

                    <h1>附件类型： </h1>

                    <div class="add_ul_r clear">

                        <select name="attachment_type" class="select-box">

                                <option value="0">照片</option>
                                <option value="1">视频</option>
                                <option value="2">ppt</option>

                        </select>

                    </div>

                </li>
                <li class="clear">

                    <h1>附件： </h1>

                    <div class="add_ul_r clear">

                        <div id="add" style="float: left">
                            <input name="attach" type="file" id="attach" style="display:none"/>
                            <label for="attach">
                                <i class="Hui-iconfont" style="font-size:100px">&#xe610;</i>
                            </label>
                        </div>

                    </div>
                </li>


                <li class="clear">

                    <h1></h1>

                    <div class="add_ul_r clear">

                        <input type="submit" id="btn" style="opacity:0;">

                        <label for="btn">
                            <div class="add_btn kuang_lan">确定</div>
                        </label>

                        <a href="<?php echo url('Course/index','',false,true); ?>" class="add_btn kuang_hong">取消</a>

                    </div>

                </li>

            </ul>

        </form>

    </div>

</div>

</div>
<div class="footer">
    <p>© 2017-2018 Aliyun.com 版权所有 ICP证：陕B2-20080101</p>
    <p>陕西蔚来信息科技有限公司</p>
</div>
</body>
</html>

<script src="/zcw2/public/static/Validform/5.3.2/Validform.min.js"></script>

<script src="/zcw2/public/static/layer/2.4/layer.js"></script>

<script src="/zcw2/public/static/js/jquery.form.js"></script>

<script src="/zcw2/public/static/js/AjaxAction.js"></script>
<script type="text/javascript">
    $(".header_nav li").click(function () {
        $(this).addClass("header_nav_a").siblings("li").removeClass("header_nav_a");
    })

    $("#form").Validform({

        tiptype: 3,

        showAllError: true,

        callback: function (ret) {
            submit_form($("#form"), function (data) {
                console.log(data);
                if (data.state == 1) {
                    layer.msg(data.succ, {icon: 6, time: 5000});
                    //location.href = "<?php echo url('Course/index','',false,true); ?>"
                } else {
                    layer.msg(data.err, {icon: 5, time: 5000});
                }
            }, function (err) {
                console.log(err)
            });
            return false;
        }
    });
</script>
<script>
    $(".tcdPageCode").createPage({
        pageCount: 6,
        current: 1,
        backFn: function (p) {
            console.log(p);
        }
    });

</script>
<script type="text/javascript">
    $(".fabu").click(function () {
        $(this).addClass("hide");
        $(".chexiao").removeClass("hide");
    })
    $(".chexiao").click(function () {
        $(this).addClass("hide");
        $(".fabu").removeClass("hide");
    })


    $('#attach').change(function () {
        var this_ele = $(this);
        this_ele.wrap("<form id='ajax_form' action='<?php echo url('course/uploadPic',array('pic_name' => 'attach'),false,true); ?>' method='post'enctype='multipart/form-data'></form>");
        //防网速慢，弹出加载层
        var loading = layer.load(3, {shade: [0.8, '#393D49']})
        $('#ajax_form').ajaxSubmit({
            data: {
                type: $('select[name=attachment_type]').val()
            },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                console.log($('select[name=attachment_type]').val());
                this_ele.unwrap();
                layer.close(loading);
                if (data.state == 1) {
                    if ($('select[name=attachment_type]').val() == 1) {
                        var inner_html = '<div style="float: left">\n' +
                                '                    <input name="attaches[]" type="hidden" id="attach" style="display:none"  value="' + data.path + '"/>\n' +
                                '                    <label>\n' +
                                '                       <div style="width:250px;height:250px;line-height:250px;text-align: center;position: relative">' +
                                '                            <i class="Hui-iconfont" style="font-size:50px;position:absolute;margin-left:105px;color:red" onclick="layer_open(\'播放视频\',\'<?php echo url('course/play','',false,true); ?>\')">&#xe6e6;</i>' +
                                '                            <img src="/zcw2/public/static/uploads/' + data.cover_path + '"  style="width:250px;height:200px">\n' +
                                '                       </div>' +
                                '                    </label>\n' +
                                '                </div>';
                        $('#add').before(inner_html);
                        $('#add').css({'display': 'none'});
                    } else if($('select[name=attachment_type]').val() == 0){
                        var count = $('#add').siblings('div').length;
                        if (count >= 8) {
                            $('#add').css({'display': 'none'});
                        }
                        var inner_html = '<div style="float: left;width:130px;margin:10px 0 0 10px">\n' +
                                '                    <input name="attaches[]" type="hidden" value="' + data.path + '">' +
                                '                    <input name="attach" type="file" id="attach' + count + '" style="display:none"  onchange="changePhoto(this)"/>\n' +
                                '                    <label for="attach' + count + '">\n' +
                                '                            <img src="/zcw2/public/static/uploads/' + data.path + '" style="width:130px;height:130px;">\n' +
                                '                    </label>\n' +
                                '                </div>';
                        $('#add').before(inner_html);
                    }else{
                        var count = $('#add').siblings('div').length;
                        if (count >= 0) {
                            $('#add').css({'display': 'none'});
                        }
                        inner_html = '<div style="float: left;width:130px;margin:10px 0 0 10px">\n' +
                            '                    <input name="attaches[]" type="hidden" value="' + data.path + '">' +
                            '                    <input name="attach" type="file" id="attach' + count + '" style="display:none"  onchange="changePhoto(this)"/>\n' +
                            '                    <label for="attach' + count + '">\n' +
                            '                            <i>上传成功</i>\n' +
                            '                    </label>\n' +
                            '                </div>';
                    }
                    $('#add').before(inner_html);
                } else {

                    layer.msg(data.reason, {icon: 5, time: 1000});
                }
            },
            error: function (err) {
                console.log(err.responseText)
                this_ele.unwrap();
                layer.close(loading);
                layer.msg('网络错误，请重试！', {icon: 5, time: 1000});
            }
        });
        this_ele.val(null);
    });

    $('select[name=attachment_type]').change(function () {
        $('#add').siblings('div').remove();
        $('#add').show();
    });

    function changePhoto(obj) {
        $(obj).wrap("<form id='ajax_form' action='<?php echo url('course/uploadPic',array('pic_name' => 'attach'),false,true); ?>' method='post'enctype='multipart/form-data'></form>");
        var loading = layer.load(3, {shade: [0.8, '#393D49']})
        $('#ajax_form').ajaxSubmit({
            data: {
                type: 0
            },
            dataType: 'json',
            success: function (data) {
                $(obj).unwrap();
                layer.close(loading);
                if (data.state == 1) {
                    $($(obj).parent().find('input')[0]).val(data.path);
                    //  $(obj).before().val(data.path);
                    $(obj).next().find('img').attr('src', '/zcw2/public/static/uploads/' + data.path);
                } else {
                    layer.msg(data.reason, {icon: 5, time: 1000});
                }
            },
            error: function (err) {
                $(obj).unwrap();
                layer.close(loading);
                layer.msg('网络错误，请重试！', {icon: 5, time: 1000});
            }
        });
    }

</script>
