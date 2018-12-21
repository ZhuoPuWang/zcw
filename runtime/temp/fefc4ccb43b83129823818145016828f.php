<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"D:\phpStudy\PHPTutorial\WWW\zcw2\public/../application/admin\view\course\play.html";i:1544676015;s:74:"D:\phpStudy\PHPTutorial\WWW\zcw2\application\admin\view\template\base.html";i:1544676015;s:76:"D:\phpStudy\PHPTutorial\WWW\zcw2\application\admin\view\template\header.html";i:1544676015;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo $title; ?></title>

    <link type="text/css" rel="stylesheet" href="/zcw2/public/static/css/global-pc.css" />
    <link type="text/css" rel="stylesheet" href="/zcw2/public/static/css/index.css" />
    <link type="text/css" rel="stylesheet" href="/zcw2/public/static/css/page.css" />
    <link type="text/css" rel="stylesheet" href="/zcw2/public/static/css/validform.css" />

    
    <script src="/zcw2/public/static/js/jquery-1.8.2.min.js"></script>
    <script src="/zcw2/public/static/js/index.js" type="text/javascript" charset="utf-8"></script>
    <script src="/zcw2/public/static/js/page.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<?php if(!isset($haveHead)): ?>
    
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
<?php endif; ?>
<!--container-->
<div class="container clear">
    <?php if(!isset($haveLeft)): ?>
    <ul class="container_list">
        <li>
            <div class="li_tit li_tit_bg">
                <img src="/zcw2/public/static/images/icon1.png" alt="" />
                学习管理
            </div>
            <dl>
                <dd><a href="<?php echo url('course/index','',false,true); ?>">课程管理</a></dd>
                <!--<dd><a href="<?php echo url('Coursegroup/index','',false,true); ?>">课程组合管理</a></dd>-->
                <dd><a href="<?php echo url('examination/index','',false,true); ?>">考试管理</a></dd>
                <dd><a href="<?php echo url('Question/index','',false,true); ?>">题库管理</a></dd>
                <dd><a href="<?php echo url('Assess/index','',false,true); ?>">评估管理</a></dd>
                <dd><a href="<?php echo url('Coursesurvey/index','',false,true); ?>">课前调研</a></dd>
            </dl>
        </li>
        <li>
            <div class="li_tit li_tit_bg">
                <img src="/zcw2/public/static/images/icon1.png" alt="" />
                用户管理
            </div>
            <dl>
                <dd><a href="<?php echo url('member/index','',false,true); ?>">用户管理</a></dd>
                <dd <?php if($_SESSION['think']['role'] < 2): ?>style="display:none;"<?php endif; ?>><a href="<?php echo url('depart/index','',false,true); ?>" >组织结构管理</a></dd>
                <!--<dd><a href="<?php echo url('Userimport/index','',false,true); ?>">用户导入</a></dd>-->
                <dd <?php if($_SESSION['think']['role'] < 2): ?>style="display:none;"<?php endif; ?>><a href="<?php echo url('fl/index','',false,true); ?>" >用户属性分类</a></dd>
                <!--<dd><a href="<?php echo url('member/index','',false,true); ?>">用户属性管理</a></dd>-->
            </dl>
        </li>
        <li>
            <div class="li_tit li_tit_bg">
                <img src="/zcw2/public/static/images/icon1.png" alt="" />
                系统管理
            </div>
            <dl>

                <dd <?php if($_SESSION['think']['role'] < 2): ?>style="display:none;"<?php endif; ?>><a href="<?php echo url('Catalog/index','',false,true); ?>" >目录管理</a></dd>
                <!--<dd><a href="<?php echo url('Study/index','',false,true); ?>">学习路径管理</a></dd>-->
                <dd <?php if($_SESSION['think']['role'] < 2): ?>style="display:none;"<?php endif; ?>><a href="<?php echo url('teacher/index','',false,true); ?>" >讲师库管理</a></dd>
                <dd <?php if($_SESSION['think']['role'] < 2): ?>style="display:none;"<?php endif; ?>><a href="<?php echo url('news/index','',false,true); ?>" >新闻管理</a></dd>
                <!--<dd><a href="<?php echo url('Survey/index','',false,true); ?>">调研管理</a></dd>-->
                <dd><a href="<?php echo url('Vote/index','',false,true); ?>">投票管理</a></dd>
                <!--<dd><a href="<?php echo url('Wechat/index','',false,true); ?>">微信管理</a></dd>-->
                <dd><a href="<?php echo url('Business/index','',false,true); ?>">业务辅导管理</a></dd>
                <dd><a href="<?php echo url('Database/index','',false,true); ?>">资料管理</a></dd>
                <!--<dd><a href="<?php echo url('discuz/index','',false,true); ?>">讨论区管理</a></dd>-->
                <dd><a href="<?php echo url('Email/index','',false,true); ?>">邮件管理</a></dd>
                <!--<dd><a href="<?php echo url('Logs/index','',false,true); ?>">日志管理</a></dd>-->
                <dd <?php if($_SESSION['think']['role'] < 2): ?>style="display:none;"<?php endif; ?>><a href="<?php echo url('Configure/index','',false,true); ?>"  >配置管理</a></dd>
            </dl>
        </li>
    </ul>
    <?php endif; ?>



    
<div class="container_content" >
    <div class="container_content_tit">课件预览</div>
    <video src="/zcw2/public/static/uploads/<?php echo $preview_src; ?>" controls autoplay></video>
</div>

</div>
<div class="footer">
    <p>© 2017-2018 Aliyun.com 版权所有 ICP证：陕B2-20080101</p>
    <p>陕西蔚来信息科技有限公司</p>
</div>
</body>
</html>
