/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : zcw

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2018-12-21 09:42:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zcw_ability
-- ----------------------------
DROP TABLE IF EXISTS `zcw_ability`;
CREATE TABLE `zcw_ability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ability_title` varchar(255) DEFAULT NULL COMMENT '能力标题',
  `ability_number` varchar(255) DEFAULT NULL COMMENT '能力ID',
  `ability_content` text COMMENT '能力描述',
  `study_id` int(11) DEFAULT NULL COMMENT '职位id',
  `add_time` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `uid` int(11) DEFAULT NULL COMMENT '创建者id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_ability
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_assess
-- ----------------------------
DROP TABLE IF EXISTS `zcw_assess`;
CREATE TABLE `zcw_assess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `createtime` int(20) DEFAULT NULL,
  `open` varchar(255) DEFAULT '0' COMMENT '是否公开',
  `content` varchar(255) DEFAULT NULL COMMENT '介绍',
  `subject` text COMMENT '题目',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_assess
-- ----------------------------
INSERT INTO `zcw_assess` VALUES ('14', '12312312', '1543379115', '0', '321', null);

-- ----------------------------
-- Table structure for zcw_assessti
-- ----------------------------
DROP TABLE IF EXISTS `zcw_assessti`;
CREATE TABLE `zcw_assessti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `tname` varchar(50) DEFAULT NULL,
  `content` text COMMENT '内容',
  `type` int(11) DEFAULT NULL COMMENT '题目类型1单选2多选3是非4简答5填空',
  `answer` text COMMENT '答案',
  `questionid` int(11) DEFAULT NULL COMMENT '题库ID',
  `question` text COMMENT '题目选项',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_assessti
-- ----------------------------
INSERT INTO `zcw_assessti` VALUES ('20', '2c11a011210e0b1ccfa7db763c716960', null, '<p>qweqeqwe</p>', '1', 'a', '14', '{\"data1\":\"qweqw\",\"data2\":\"eqwqwe\",\"data3\":\"qweqw\",\"data4\":\"eqwe\"}');

-- ----------------------------
-- Table structure for zcw_auditing
-- ----------------------------
DROP TABLE IF EXISTS `zcw_auditing`;
CREATE TABLE `zcw_auditing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(3) DEFAULT '1',
  `did` int(11) DEFAULT NULL,
  `verification` int(3) DEFAULT '1',
  `auditing` int(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_auditing
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_business
-- ----------------------------
DROP TABLE IF EXISTS `zcw_business`;
CREATE TABLE `zcw_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `createtime` int(20) DEFAULT NULL,
  `open` varchar(255) DEFAULT '0' COMMENT '是否公开',
  `content` varchar(255) DEFAULT NULL COMMENT '介绍',
  `subject` text COMMENT '题目',
  `obj` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_business
-- ----------------------------
INSERT INTO `zcw_business` VALUES ('13', '请问问', '1543113302', '0', null, null, '8');

-- ----------------------------
-- Table structure for zcw_businessti
-- ----------------------------
DROP TABLE IF EXISTS `zcw_businessti`;
CREATE TABLE `zcw_businessti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `tname` varchar(50) DEFAULT NULL,
  `content` text COMMENT '内容',
  `type` int(11) DEFAULT NULL COMMENT '题目类型1单选2多选3是非4简答5填空',
  `answer` text COMMENT '答案',
  `questionid` int(11) DEFAULT NULL COMMENT '题库ID',
  `question` text COMMENT '题目选项',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_businessti
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_catalog
-- ----------------------------
DROP TABLE IF EXISTS `zcw_catalog`;
CREATE TABLE `zcw_catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `no` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `pid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `no` (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_catalog
-- ----------------------------
INSERT INTO `zcw_catalog` VALUES ('8', '总部', 'zb_001', '1', '1');
INSERT INTO `zcw_catalog` VALUES ('9', '保安部', 'bn_001', '1', '1');

-- ----------------------------
-- Table structure for zcw_certificate
-- ----------------------------
DROP TABLE IF EXISTS `zcw_certificate`;
CREATE TABLE `zcw_certificate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(255) DEFAULT NULL COMMENT '证书编号',
  `chtitle` varchar(255) DEFAULT NULL COMMENT 'z中文标题',
  `entitle` varchar(255) DEFAULT NULL COMMENT '英文标题',
  `endtime` int(20) DEFAULT NULL COMMENT '证书到期日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_certificate
-- ----------------------------
INSERT INTO `zcw_certificate` VALUES ('10', '011110001', '培训证书', 'Certification', '1543420800');
INSERT INTO `zcw_certificate` VALUES ('11', '00001111222', '培训证书', 'Certification', '1543507200');

-- ----------------------------
-- Table structure for zcw_configure
-- ----------------------------
DROP TABLE IF EXISTS `zcw_configure`;
CREATE TABLE `zcw_configure` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `ewm` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_configure
-- ----------------------------
INSERT INTO `zcw_configure` VALUES ('0', '课程中心', '010-13289223170', '123', null, null);

-- ----------------------------
-- Table structure for zcw_course
-- ----------------------------
DROP TABLE IF EXISTS `zcw_course`;
CREATE TABLE `zcw_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_type` varchar(6) DEFAULT NULL COMMENT '课程类型',
  `course_number` varchar(255) DEFAULT NULL COMMENT '课程编号',
  `course_title` varchar(255) DEFAULT NULL COMMENT '课程标题',
  `course_content` text COMMENT '课程描述',
  `credit` int(10) DEFAULT '0' COMMENT '学分',
  `course_time_d` varchar(10) DEFAULT '0' COMMENT '课程时长',
  `day` varchar(10) DEFAULT '1' COMMENT '过期天数',
  `user_object` varchar(255) DEFAULT NULL COMMENT '用户对象',
  `catalog` varchar(255) DEFAULT NULL COMMENT '目录',
  `target_user` varchar(255) DEFAULT NULL COMMENT '目标用户',
  `email` varchar(1) DEFAULT '0' COMMENT '邮箱提醒   0否 1是',
  `weixin` varchar(1) DEFAULT '0' COMMENT '微信提醒   0否 1是',
  `self_help` varchar(1) DEFAULT '0' COMMENT '是否自助报名   0否 1是',
  `to_examine` varchar(1) DEFAULT '0' COMMENT '审核    0  否   1 是',
  `data` varchar(1) DEFAULT '0' COMMENT '关联资料区    0  否   1 是',
  `certificate` varchar(1) DEFAULT '0' COMMENT '是否拥有证书    0  否   1 是',
  `auto_distribution` varchar(1) CHARACTER SET utf8 DEFAULT '0' COMMENT '是否自动分配   0否  1是',
  `distribution_condition` varchar(255) DEFAULT NULL COMMENT '分配条件',
  `order` varchar(1) DEFAULT '0' COMMENT '是否按照  （课程->考试->评估）的顺序  0 否 1是',
  `order_course` varchar(1) DEFAULT '1' COMMENT '是否可以打开 过期课程 0否 1是',
  `language` varchar(1) DEFAULT '0' COMMENT '语言选择   0  中文  1英文 2繁体中文',
  `addtime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `updatetime` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `uid` varchar(11) DEFAULT NULL COMMENT '创建者',
  `diz` varchar(1) DEFAULT '0' COMMENT '关联讨论区   0否 1是',
  `course_time_h` varchar(3) CHARACTER SET utf8 DEFAULT '0' COMMENT '课程时长',
  `ks_id` int(5) DEFAULT NULL COMMENT '考试ID',
  `dz_id` int(11) DEFAULT NULL COMMENT '讨论区ID ',
  `assess_id` int(11) DEFAULT NULL COMMENT '评估ID ',
  `sur_id` int(11) DEFAULT NULL COMMENT '调研ID',
  `zs_id` int(11) DEFAULT NULL COMMENT '证书ID ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_course
-- ----------------------------
INSERT INTO `zcw_course` VALUES ('48', '0', 'ceshikecheng5', '测试课程5', 'ceshikecheng5', '100', '1', '1', '8', null, 'ceshikecheng5', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '1543658242', '1543658242', '27', '0', '0', null, null, null, null, null);
INSERT INTO `zcw_course` VALUES ('49', '0', 'cehsikechegn ', '测试课程1', '测试课程', '0', '10', '10', '8', null, '测试课程测试课程', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '1543749752', '1543749752', '27', '0', '0', '36', '3', '14', '15', null);
INSERT INTO `zcw_course` VALUES ('47', '1', 'ceshikecheng3', '测试课程2', '测试课程2', '100', '0', '0', '8', null, '测试课程2', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '1543657669', '1543657669', '27', '0', '0', null, null, null, null, null);
INSERT INTO `zcw_course` VALUES ('46', '0', 'ceshikecheng2', '测试课程2', '测试课程2', '0', '5', '10', '8', null, '测试课程2', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '1543657642', '1543657865', '27', '0', '0', null, null, null, null, null);
INSERT INTO `zcw_course` VALUES ('45', '0', 'ceshi', '测试', '测试', '100', '1', '10', '8', null, '测试测试', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '1543649876', '1543649876', '27', '0', '0', '36', null, null, null, null);
INSERT INTO `zcw_course` VALUES ('50', '0', '20181204', '20181204', '20181204', '100', '1', '1', '9', null, 'df ', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '1543922603', '1543922603', '27', '0', '0', null, null, null, null, null);
INSERT INTO `zcw_course` VALUES ('51', '0', 'asdasdasqwweqweqwe1231231', 'hahah ', 'sadsdasdasda', '10', '1', '1', '1', null, 'sadasdasd ', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '1543925309', '1543925309', '27', '0', '0', null, null, null, null, null);
INSERT INTO `zcw_course` VALUES ('52', '0', '20181206', '保安条例', '保安条例学习', '10', '1', '1', '9', null, '各项目点队员', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '1544068519', '1544068519', '27', '0', '0', '37', null, null, null, null);
INSERT INTO `zcw_course` VALUES ('53', '0', '20181213', '21081213', '21081213', '100', '1', '1', '9', null, '21081213', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '1544668926', '1544668926', '27', '0', '0', '37', null, '14', '15', '11');

-- ----------------------------
-- Table structure for zcw_coursereport
-- ----------------------------
DROP TABLE IF EXISTS `zcw_coursereport`;
CREATE TABLE `zcw_coursereport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `course_id` int(11) DEFAULT NULL COMMENT '课程id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_coursereport
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_coursesurvey
-- ----------------------------
DROP TABLE IF EXISTS `zcw_coursesurvey`;
CREATE TABLE `zcw_coursesurvey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `createtime` int(20) DEFAULT NULL,
  `open` varchar(255) DEFAULT '0' COMMENT '是否公开',
  `content` varchar(255) DEFAULT NULL COMMENT '介绍',
  `subject` text COMMENT '题目',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_coursesurvey
-- ----------------------------
INSERT INTO `zcw_coursesurvey` VALUES ('15', '12312312312', '1543385726', '0', '13213123', null);

-- ----------------------------
-- Table structure for zcw_coursesurveyti
-- ----------------------------
DROP TABLE IF EXISTS `zcw_coursesurveyti`;
CREATE TABLE `zcw_coursesurveyti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `tname` varchar(50) DEFAULT NULL,
  `content` text COMMENT '内容',
  `type` int(11) DEFAULT NULL COMMENT '题目类型1单选2多选3是非4简答5填空',
  `answer` text COMMENT '答案',
  `questionid` int(11) DEFAULT NULL COMMENT '题库ID',
  `question` text COMMENT '题目选项',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_coursesurveyti
-- ----------------------------
INSERT INTO `zcw_coursesurveyti` VALUES ('20', 'b372c3c7be9d4ecfad4a5c13532401c5', null, '<p>12312312</p>', '1', null, '15', '{\"data1\":\"123123123\",\"data2\":\"\",\"data3\":\"\",\"data4\":\"\"}');

-- ----------------------------
-- Table structure for zcw_courseware
-- ----------------------------
DROP TABLE IF EXISTS `zcw_courseware`;
CREATE TABLE `zcw_courseware` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL COMMENT '课程id',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `courseware` varchar(255) DEFAULT NULL COMMENT '课件地址',
  `addtime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `updatetime` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `ware_type` varchar(255) DEFAULT NULL COMMENT '课件类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_courseware
-- ----------------------------
INSERT INTO `zcw_courseware` VALUES ('20', '53', '27', '[\"20181213\\/6fc8d170e192dd83c7a761c25fb304d6v.mp4\",\"20181213\\/6fc8d170e192dd83c7a761c25fb304d6v.mp4\"]', '1544677456', '1544680454', '1');

-- ----------------------------
-- Table structure for zcw_course_assess
-- ----------------------------
DROP TABLE IF EXISTS `zcw_course_assess`;
CREATE TABLE `zcw_course_assess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL COMMENT '课程id',
  `assess_id` int(11) DEFAULT NULL COMMENT '评估id',
  `addtime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_course_assess
-- ----------------------------
INSERT INTO `zcw_course_assess` VALUES ('18', '27', '14', '1543379124');

-- ----------------------------
-- Table structure for zcw_course_classify
-- ----------------------------
DROP TABLE IF EXISTS `zcw_course_classify`;
CREATE TABLE `zcw_course_classify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL COMMENT '课程id',
  `status` int(11) DEFAULT NULL COMMENT '课程状态0过期，1进行中，2已完成，3待审批',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_course_classify
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_course_group
-- ----------------------------
DROP TABLE IF EXISTS `zcw_course_group`;
CREATE TABLE `zcw_course_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_number` varchar(255) DEFAULT NULL COMMENT '课程编号',
  `course_title` varchar(255) DEFAULT NULL COMMENT '课程标题',
  `course_content` text COMMENT '课程描述',
  `catalog` varchar(255) DEFAULT NULL COMMENT '目录',
  `target_user` varchar(255) DEFAULT NULL COMMENT '目标用户',
  `email` varchar(1) DEFAULT '0' COMMENT '邮箱提醒   0否 1是',
  `weixin` varchar(1) DEFAULT '0' COMMENT '微信提醒   0否 1是',
  `self_help` varchar(1) DEFAULT '0' COMMENT '是否自助报名   0否 1是',
  `to_examine` varchar(1) DEFAULT '0' COMMENT '审核    0  否   1 是',
  `data` varchar(1) DEFAULT '0' COMMENT '关联资料区    0  否   1 是',
  `auto_distribution` varchar(1) CHARACTER SET utf8 DEFAULT '0' COMMENT '是否自动分配   0否  1是',
  `distribution_condition` varchar(255) DEFAULT NULL COMMENT '分配条件',
  `order` varchar(1) DEFAULT '0' COMMENT '是否按照  （课程->考试->评估）的顺序  0 否 1是',
  `order_course` varchar(1) DEFAULT '1' COMMENT '是否可以打开 过期课程 0否 1是',
  `language` varchar(1) DEFAULT '0' COMMENT '语言选择   0  中文  1英文 2繁体中文',
  `addtime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `updatetime` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `uid` varchar(11) DEFAULT NULL COMMENT '创建者',
  `diz` varchar(1) DEFAULT '0' COMMENT '关联讨论区   0否 1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_course_group
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_course_group_info
-- ----------------------------
DROP TABLE IF EXISTS `zcw_course_group_info`;
CREATE TABLE `zcw_course_group_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_p_id` int(11) DEFAULT NULL COMMENT '组合课程id',
  `c_id` varchar(255) DEFAULT NULL COMMENT '课程id',
  `k_id` int(11) DEFAULT NULL COMMENT '考试id',
  `first` tinyint(3) DEFAULT NULL COMMENT '优先级',
  `must` varchar(255) DEFAULT NULL COMMENT '是否必修',
  `addtime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_course_group_info
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_course_teacher
-- ----------------------------
DROP TABLE IF EXISTS `zcw_course_teacher`;
CREATE TABLE `zcw_course_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL COMMENT '课程id',
  `teacher_id` int(11) DEFAULT NULL COMMENT '老师id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_course_teacher
-- ----------------------------
INSERT INTO `zcw_course_teacher` VALUES ('15', '53', '27');
INSERT INTO `zcw_course_teacher` VALUES ('14', '52', '27');
INSERT INTO `zcw_course_teacher` VALUES ('7', '45', '27');
INSERT INTO `zcw_course_teacher` VALUES ('8', '46', '27');
INSERT INTO `zcw_course_teacher` VALUES ('9', '47', '27');
INSERT INTO `zcw_course_teacher` VALUES ('10', '48', '27');
INSERT INTO `zcw_course_teacher` VALUES ('11', '49', '27');
INSERT INTO `zcw_course_teacher` VALUES ('12', '50', '27');
INSERT INTO `zcw_course_teacher` VALUES ('13', '51', '27');

-- ----------------------------
-- Table structure for zcw_cpstudy
-- ----------------------------
DROP TABLE IF EXISTS `zcw_cpstudy`;
CREATE TABLE `zcw_cpstudy` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL COMMENT '用户的id',
  `course_group_id` int(11) DEFAULT NULL COMMENT '课程组合id',
  `addtime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_cpstudy
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_database
-- ----------------------------
DROP TABLE IF EXISTS `zcw_database`;
CREATE TABLE `zcw_database` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_database
-- ----------------------------
INSERT INTO `zcw_database` VALUES ('48', '刷刷刷', '1.jpg', '20181125/13286b53ca83b7a5e09551784c779693.jpg', '8', '8', '1543114559');
INSERT INTO `zcw_database` VALUES ('49', '111111111', 'banner_LatestNews.jpg', '20181125/7d1ec440f664172d2c26d3e7e2a39a26.jpg', '8', '8', '1543118351');
INSERT INTO `zcw_database` VALUES ('50', 'qweqweqwe', 'banner_application.jpg', '', '8', '8', '1543133058');

-- ----------------------------
-- Table structure for zcw_depart
-- ----------------------------
DROP TABLE IF EXISTS `zcw_depart`;
CREATE TABLE `zcw_depart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `no` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `pid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `no` (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_depart
-- ----------------------------
INSERT INTO `zcw_depart` VALUES ('7', '总部', 'z_001', '1', '1');
INSERT INTO `zcw_depart` VALUES ('8', '保安部', 'bn_001', '1', '7');
INSERT INTO `zcw_depart` VALUES ('9', '运营部', '01212445', '1', '8');

-- ----------------------------
-- Table structure for zcw_discuz
-- ----------------------------
DROP TABLE IF EXISTS `zcw_discuz`;
CREATE TABLE `zcw_discuz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  `userid` int(11) NOT NULL,
  `depid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `isfirst` tinyint(4) NOT NULL DEFAULT '0',
  `viewnum` int(11) NOT NULL DEFAULT '1',
  `addtime` int(11) DEFAULT NULL COMMENT '讨论区添加时间                             ',
  `Reply` int(255) DEFAULT '0' COMMENT '回复数',
  `summary` varchar(255) DEFAULT NULL COMMENT '摘要',
  `course_id` int(11) DEFAULT NULL COMMENT '课程id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_discuz
-- ----------------------------
INSERT INTO `zcw_discuz` VALUES ('1', '1', '<p>11</p>', '26', '8', '1', '0', '7', '1543133202', '0', '1', null);
INSERT INTO `zcw_discuz` VALUES ('2', 'qwe', '<p>eqweqwew</p>', '26', '8', '1', '0', '1', '1543393386', '0', 'qweqw', null);
INSERT INTO `zcw_discuz` VALUES ('3', '测试讨论', '<p>测试讨论</p><p>测试讨论</p><p>测试讨论</p>', '27', '8', '1', '0', '3', '1543750437', '0', '测试讨论', null);

-- ----------------------------
-- Table structure for zcw_discuz_feedback
-- ----------------------------
DROP TABLE IF EXISTS `zcw_discuz_feedback`;
CREATE TABLE `zcw_discuz_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `addtime` varchar(255) DEFAULT NULL COMMENT '回复时间',
  `replycontent` varchar(255) DEFAULT NULL COMMENT '回复评论',
  `replytime` varchar(255) DEFAULT NULL COMMENT '回复时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_discuz_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_email
-- ----------------------------
DROP TABLE IF EXISTS `zcw_email`;
CREATE TABLE `zcw_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_type` int(3) DEFAULT NULL COMMENT '邮件类型',
  `email_title` varchar(255) DEFAULT NULL COMMENT '邮件标题',
  `email_content` text COMMENT '邮件内容',
  `add_time` varchar(255) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_email
-- ----------------------------
INSERT INTO `zcw_email` VALUES ('6', '1', '', '', '1543133151');

-- ----------------------------
-- Table structure for zcw_examination
-- ----------------------------
DROP TABLE IF EXISTS `zcw_examination`;
CREATE TABLE `zcw_examination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(50) DEFAULT NULL COMMENT '考试编号',
  `name` varchar(50) DEFAULT NULL COMMENT '考试标题',
  `describe` text COMMENT '考试描述',
  `credit` int(5) DEFAULT NULL COMMENT '学分',
  `limitstart` int(20) DEFAULT NULL COMMENT '限定开始时间 ',
  `limitend` int(20) DEFAULT NULL COMMENT '限定结束时间 ',
  `limittime` varchar(20) DEFAULT NULL COMMENT '限定时长',
  `limitcount` int(5) DEFAULT NULL COMMENT '限定次数',
  `outtime` int(5) DEFAULT NULL COMMENT '过期天数',
  `adopt` int(5) DEFAULT NULL COMMENT '通过分数',
  `userobject` int(5) DEFAULT NULL COMMENT '用户对象 ',
  `catalog` int(5) DEFAULT NULL COMMENT '目录',
  `mode` int(5) DEFAULT NULL COMMENT '问题显示方式',
  `review` int(5) DEFAULT NULL COMMENT '是否允许参与者审阅 ',
  `problem` int(5) DEFAULT NULL COMMENT '问题反馈显示方式 ',
  `email` varchar(5) DEFAULT NULL COMMENT '是否发送邮件提醒',
  `wx` varchar(5) DEFAULT NULL COMMENT '是否发送微信消息',
  `curriculum` varchar(5) DEFAULT NULL COMMENT '是否允许关联到课程',
  `independently` varchar(5) DEFAULT NULL COMMENT '是否允许学员自助报名',
  `examine` varchar(5) DEFAULT NULL COMMENT '是否需要审核',
  `certificate` varchar(5) DEFAULT NULL COMMENT '是否拥有证书',
  `certificatetime` int(20) DEFAULT NULL COMMENT '证书有效期 ',
  `certificatetype` varchar(20) DEFAULT NULL COMMENT '选择证书格式',
  `sequence` varchar(5) DEFAULT NULL COMMENT '是否强制题目顺序',
  `answers` varchar(5) DEFAULT NULL COMMENT '是否强制答案顺序',
  `createuser` int(5) DEFAULT NULL COMMENT '创建者',
  `cour_id` int(11) DEFAULT NULL COMMENT '课程id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_examination
-- ----------------------------
INSERT INTO `zcw_examination` VALUES ('36', '275376616a', '测试考试', '测试考试测试考试测试考试', '100', '1543650790', '1544514790', '20', '10', '10', '60', '8', '1', '0', '0', '0', '', '', null, '', '', '', null, '', '', '', '27', null);
INSERT INTO `zcw_examination` VALUES ('37', '178a069801', '保安条例', '111111111', '10', '1544068659', '1544932659', '60', '3', '1', '6', '9', '1', '0', '0', '0', '', '', null, '', '', 'on', null, null, '', '', '27', null);

-- ----------------------------
-- Table structure for zcw_fl
-- ----------------------------
DROP TABLE IF EXISTS `zcw_fl`;
CREATE TABLE `zcw_fl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(5) DEFAULT NULL COMMENT '类型，1级2级',
  `name` varchar(50) DEFAULT NULL,
  `fid` int(5) DEFAULT NULL COMMENT '上级id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_fl
-- ----------------------------
INSERT INTO `zcw_fl` VALUES ('16', '1', '角色', '0');
INSERT INTO `zcw_fl` VALUES ('17', '1', '职务', '0');
INSERT INTO `zcw_fl` VALUES ('18', '1', '运营部', '0');
INSERT INTO `zcw_fl` VALUES ('19', '1', '梯队人员', '0');
INSERT INTO `zcw_fl` VALUES ('20', '1', '部门', '0');
INSERT INTO `zcw_fl` VALUES ('21', '1', '是否党员', '0');
INSERT INTO `zcw_fl` VALUES ('22', '1', '语言', '0');
INSERT INTO `zcw_fl` VALUES ('23', '1', '性别', '0');
INSERT INTO `zcw_fl` VALUES ('24', '2', '学员', '16');
INSERT INTO `zcw_fl` VALUES ('25', '2', '教师', '16');
INSERT INTO `zcw_fl` VALUES ('26', '2', '经理', '16');
INSERT INTO `zcw_fl` VALUES ('27', '2', '管理员', '16');
INSERT INTO `zcw_fl` VALUES ('28', '2', '超级管理员', '16');
INSERT INTO `zcw_fl` VALUES ('29', '2', '办公室人员', '17');
INSERT INTO `zcw_fl` VALUES ('30', '2', '队长', '17');
INSERT INTO `zcw_fl` VALUES ('31', '2', '班长', '17');
INSERT INTO `zcw_fl` VALUES ('32', '2', '副队长', '17');
INSERT INTO `zcw_fl` VALUES ('33', '2', '骨干积极分子', '17');
INSERT INTO `zcw_fl` VALUES ('34', '2', '助理', '17');
INSERT INTO `zcw_fl` VALUES ('35', '2', '二部', '18');
INSERT INTO `zcw_fl` VALUES ('36', '2', '三部', '18');
INSERT INTO `zcw_fl` VALUES ('37', '2', '五部', '18');
INSERT INTO `zcw_fl` VALUES ('38', '2', '特勤', '18');
INSERT INTO `zcw_fl` VALUES ('39', '2', '扶梯对人员', '19');
INSERT INTO `zcw_fl` VALUES ('40', '2', '班长梯队人员', '19');
INSERT INTO `zcw_fl` VALUES ('41', '2', '市场部', '20');
INSERT INTO `zcw_fl` VALUES ('42', '2', '运营部', '20');
INSERT INTO `zcw_fl` VALUES ('43', '2', '人事部', '20');
INSERT INTO `zcw_fl` VALUES ('44', '2', '后勤部', '20');
INSERT INTO `zcw_fl` VALUES ('45', '2', '总经办', '20');
INSERT INTO `zcw_fl` VALUES ('46', '2', '指挥中心', '20');
INSERT INTO `zcw_fl` VALUES ('47', '2', '联网报警', '20');
INSERT INTO `zcw_fl` VALUES ('48', '2', '其他分公司人员', '21');
INSERT INTO `zcw_fl` VALUES ('49', '2', '党员', '21');
INSERT INTO `zcw_fl` VALUES ('50', '2', '预备党员', '21');
INSERT INTO `zcw_fl` VALUES ('51', '2', '入党积极分子', '21');
INSERT INTO `zcw_fl` VALUES ('52', '2', '中文', '22');
INSERT INTO `zcw_fl` VALUES ('53', '2', 'English', '22');
INSERT INTO `zcw_fl` VALUES ('54', '2', '繁体中文', '22');
INSERT INTO `zcw_fl` VALUES ('55', '2', '男', '23');
INSERT INTO `zcw_fl` VALUES ('56', '2', '女', '23');

-- ----------------------------
-- Table structure for zcw_home
-- ----------------------------
DROP TABLE IF EXISTS `zcw_home`;
CREATE TABLE `zcw_home` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `icn` varchar(50) DEFAULT NULL,
  `status` int(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_home
-- ----------------------------
INSERT INTO `zcw_home` VALUES ('1', '首页banner', '20180917/0127515aa12d65b0a73aa94910789004.png', '0');
INSERT INTO `zcw_home` VALUES ('2', '首页课程', '20180917/64ccb58e2e6338604fe3489f5a1ac511.png', '0');
INSERT INTO `zcw_home` VALUES ('3', '首页讲师', '20180917/b85225f18978a084b3977a4638a5a3ff.png', '0');
INSERT INTO `zcw_home` VALUES ('4', '首页资料', '20180917/46e7be90e15b744f1b4f15e2851c5edf.png', '0');

-- ----------------------------
-- Table structure for zcw_juan
-- ----------------------------
DROP TABLE IF EXISTS `zcw_juan`;
CREATE TABLE `zcw_juan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ti` text,
  `ex_id` int(11) DEFAULT NULL COMMENT '考试ID ',
  `qu_id` int(11) DEFAULT NULL COMMENT '题库ID ',
  `addtime` int(20) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `state` int(5) DEFAULT '0' COMMENT '是否阅卷  01 ',
  `fen` int(10) DEFAULT '0' COMMENT '分数',
  `pass` int(5) DEFAULT '0' COMMENT '是否通过 01 ',
  `cer_id` int(11) DEFAULT NULL COMMENT '证书ID ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_juan
-- ----------------------------
INSERT INTO `zcw_juan` VALUES ('4', '{\"ex_id\":\"31\",\"qu_id\":\"31\",\"24\":\"A\",\"25\":\"B,C,\"}', '31', '31', '1543311073', '26', '1', '8', '1', null);
INSERT INTO `zcw_juan` VALUES ('5', '{\"ex_id\":\"30\",\"qu_id\":\"30\",\"24\":\"B\",\"25\":\"B,C,\"}', '30', '30', '1543401399', '26', '1', '6', '1', null);
INSERT INTO `zcw_juan` VALUES ('6', '{\"ex_id\":\"36\",\"qu_id\":\"39\"}', '36', '39', '1543749428', '30', '0', '0', '0', null);
INSERT INTO `zcw_juan` VALUES ('7', '{\"ex_id\":\"36\",\"qu_id\":\"39\",\"27\":\"A,\"}', '36', '39', '1543750556', '30', '0', '0', '0', null);
INSERT INTO `zcw_juan` VALUES ('8', '{\"ex_id\":\"37\",\"qu_id\":\"40\",\"kc_id\":\"52\",\"31\":\"A\",\"32\":\"B,\",\"33\":\"\\u5bf9\",\"34\":\"easrgsr\",\"35\":\"dsafgesr\",\"36\":\"A\",\"37\":\"B,\",\"38\":\"\\u9519\",\"39\":\"sfr\",\"40\":\"sfgsr\",\"26\":\"B\",\"27\":\"C,\",\"28\":\"\\u5bf9\",\"29\":\"dsfegvr\",\"30\":\"sfgvs\"}', '37', '40', '1544070107', '36', '1', '75', '1', null);

-- ----------------------------
-- Table structure for zcw_juandiaoyan
-- ----------------------------
DROP TABLE IF EXISTS `zcw_juandiaoyan`;
CREATE TABLE `zcw_juandiaoyan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ti` text,
  `addtime` int(20) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_juandiaoyan
-- ----------------------------
INSERT INTO `zcw_juandiaoyan` VALUES ('34', '{\"course_id\":\"15\",\"20\":\"C\"}', '1543385969', '26', '15');

-- ----------------------------
-- Table structure for zcw_juanpinggu
-- ----------------------------
DROP TABLE IF EXISTS `zcw_juanpinggu`;
CREATE TABLE `zcw_juanpinggu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ti` text,
  `addtime` int(20) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_juanpinggu
-- ----------------------------
INSERT INTO `zcw_juanpinggu` VALUES ('33', '{\"course_id\":\"14\",\"20\":\"C\"}', '1543386583', '26', '14');

-- ----------------------------
-- Table structure for zcw_kc
-- ----------------------------
DROP TABLE IF EXISTS `zcw_kc`;
CREATE TABLE `zcw_kc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kc_id` int(11) DEFAULT NULL COMMENT '课程ID',
  `starttime` varchar(20) DEFAULT NULL COMMENT '开始时间',
  `state` int(20) DEFAULT '0' COMMENT '状态0尚未开始1学习中2等待考试3已完成',
  `endtime` varchar(20) DEFAULT NULL COMMENT '结束时间',
  `u_id` int(11) DEFAULT NULL COMMENT '用户ID ',
  `zs` int(11) DEFAULT '1' COMMENT '0通过1未通过',
  `outtime` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_kc
-- ----------------------------
INSERT INTO `zcw_kc` VALUES ('51', '49', '1543923150', '2', '1544613752', '36', '1', '1543924363');
INSERT INTO `zcw_kc` VALUES ('52', '49', '1543749752', '0', '1544613752', '37', '1', null);
INSERT INTO `zcw_kc` VALUES ('50', '49', '1543750884', '2', '1544613752', '30', '1', '1543751739');
INSERT INTO `zcw_kc` VALUES ('38', '45', '1543649876', '0', '1543736276', '30', '1', '1543750618');
INSERT INTO `zcw_kc` VALUES ('39', '45', '1543651438', '2', '1543736276', '36', '1', null);
INSERT INTO `zcw_kc` VALUES ('40', '45', '1543649876', '0', '1543736276', '37', '1', null);
INSERT INTO `zcw_kc` VALUES ('42', '46', '1543923189', '1', '1544089642', '36', '1', null);
INSERT INTO `zcw_kc` VALUES ('43', '46', '1543657642', '0', '1544089642', '37', '1', null);
INSERT INTO `zcw_kc` VALUES ('45', '47', '1543657669', '0', '1543657669', '36', '1', null);
INSERT INTO `zcw_kc` VALUES ('46', '47', '1543657669', '0', '1543657669', '37', '1', null);
INSERT INTO `zcw_kc` VALUES ('47', '48', '1543658242', '0', '1543744642', '30', '1', null);
INSERT INTO `zcw_kc` VALUES ('48', '48', '1543658242', '0', '1543744642', '36', '1', null);
INSERT INTO `zcw_kc` VALUES ('49', '48', '1543658242', '0', '1543744642', '37', '1', null);
INSERT INTO `zcw_kc` VALUES ('56', '50', '1543923762', '2', '1544009003', '30', '1', null);
INSERT INTO `zcw_kc` VALUES ('54', '50', '1543923126', '2', '1544009003', '36', '1', null);
INSERT INTO `zcw_kc` VALUES ('55', '50', null, '0', '1544009003', '37', '1', null);
INSERT INTO `zcw_kc` VALUES ('57', '51', '1543925347', '2', '1544011709', '36', '1', null);
INSERT INTO `zcw_kc` VALUES ('58', '51', null, '0', '1544011709', '30', '1', null);
INSERT INTO `zcw_kc` VALUES ('59', '51', null, '0', '1544011709', '37', '1', null);
INSERT INTO `zcw_kc` VALUES ('63', '53', '1544670470', '2', '1544755326', '36', '1', null);
INSERT INTO `zcw_kc` VALUES ('62', '52', '1544070045', '2', '1544154919', '36', '1', '1544073721');
INSERT INTO `zcw_kc` VALUES ('64', '53', '1544673318', '2', '1544755326', '36', '1', null);

-- ----------------------------
-- Table structure for zcw_logs
-- ----------------------------
DROP TABLE IF EXISTS `zcw_logs`;
CREATE TABLE `zcw_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `type` varchar(255) DEFAULT NULL COMMENT '类型',
  `time` int(11) DEFAULT NULL COMMENT '时间',
  `cont` varchar(255) DEFAULT NULL COMMENT '声明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=205 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_logs
-- ----------------------------
INSERT INTO `zcw_logs` VALUES ('80', '26', '登录', '1543112546', null);
INSERT INTO `zcw_logs` VALUES ('81', '26', '退出', '1543136395', null);
INSERT INTO `zcw_logs` VALUES ('82', '26', '登录', '1543143614', null);
INSERT INTO `zcw_logs` VALUES ('83', '26', '课程管理', '1543145671', '创建测试课程');
INSERT INTO `zcw_logs` VALUES ('84', '26', '考试管理', '1543146805', '创建测试考题');
INSERT INTO `zcw_logs` VALUES ('85', '26', '课程管理', '1543147958', '创建12321312321qweqw');
INSERT INTO `zcw_logs` VALUES ('86', '26', '考试管理', '1543148201', '创建123123123');
INSERT INTO `zcw_logs` VALUES ('87', '26', '考试管理', '1543148362', '创建0000000000');
INSERT INTO `zcw_logs` VALUES ('88', '26', '考试管理', '1543148803', '创建');
INSERT INTO `zcw_logs` VALUES ('89', '26', '考试管理', '1543148960', '创建12312312');
INSERT INTO `zcw_logs` VALUES ('90', '26', '考试管理', '1543149057', '创建');
INSERT INTO `zcw_logs` VALUES ('91', '26', '登录', '1543237413', null);
INSERT INTO `zcw_logs` VALUES ('92', '26', '课程管理', '1543237942', '创建1231231232');
INSERT INTO `zcw_logs` VALUES ('93', '26', '登录', '1543281462', null);
INSERT INTO `zcw_logs` VALUES ('94', '26', '课程管理', '1543310435', '创建12312');
INSERT INTO `zcw_logs` VALUES ('95', '26', '登录', '1543317631', null);
INSERT INTO `zcw_logs` VALUES ('96', '26', '退出', '1543318062', null);
INSERT INTO `zcw_logs` VALUES ('97', null, '退出', '1543318063', null);
INSERT INTO `zcw_logs` VALUES ('98', '26', '登录', '1543318086', null);
INSERT INTO `zcw_logs` VALUES ('99', '26', '登录', '1543367972', null);
INSERT INTO `zcw_logs` VALUES ('100', '26', '退出', '1543368215', null);
INSERT INTO `zcw_logs` VALUES ('101', null, '退出', '1543368219', null);
INSERT INTO `zcw_logs` VALUES ('102', '29', '登录', '1543368287', null);
INSERT INTO `zcw_logs` VALUES ('103', '48', '退出', '1543378273', null);
INSERT INTO `zcw_logs` VALUES ('104', '26', '登录', '1543378610', null);
INSERT INTO `zcw_logs` VALUES ('105', '26', '退出', '1543393636', null);
INSERT INTO `zcw_logs` VALUES ('106', '26', '登录', '1543393646', null);
INSERT INTO `zcw_logs` VALUES ('107', '26', '课程管理', '1543393685', '创建123213');
INSERT INTO `zcw_logs` VALUES ('108', '26', '登录', '1543400751', null);
INSERT INTO `zcw_logs` VALUES ('109', '26', '课程管理', '1543407773', '创建31232131');
INSERT INTO `zcw_logs` VALUES ('110', '26', '登录', '1543457122', null);
INSERT INTO `zcw_logs` VALUES ('111', '26', '退出', '1543457203', null);
INSERT INTO `zcw_logs` VALUES ('112', '26', '登录', '1543457367', null);
INSERT INTO `zcw_logs` VALUES ('113', '30', '登录', '1543629602', null);
INSERT INTO `zcw_logs` VALUES ('114', '27', '登录', '1543629868', null);
INSERT INTO `zcw_logs` VALUES ('115', '27', '课程管理', '1543636359', '创建广播体操');
INSERT INTO `zcw_logs` VALUES ('116', '27', '课程管理', '1543639694', '创建12312321');
INSERT INTO `zcw_logs` VALUES ('117', '27', '课程管理', '1543640158', '创建12312');
INSERT INTO `zcw_logs` VALUES ('118', '27', '课程管理', '1543649876', '创建测试');
INSERT INTO `zcw_logs` VALUES ('119', '27', '考试管理', '1543650513', '创建');
INSERT INTO `zcw_logs` VALUES ('120', '27', '考试管理', '1543650560', '创建');
INSERT INTO `zcw_logs` VALUES ('121', '27', '考试管理', '1543650569', '创建');
INSERT INTO `zcw_logs` VALUES ('122', '27', '考试管理', '1543650615', '创建');
INSERT INTO `zcw_logs` VALUES ('123', '27', '考试管理', '1543650790', '创建测试考试');
INSERT INTO `zcw_logs` VALUES ('124', '36', '登录', '1543651426', null);
INSERT INTO `zcw_logs` VALUES ('125', '27', '课程管理', '1543657642', '创建测试课程2');
INSERT INTO `zcw_logs` VALUES ('126', '27', '课程管理', '1543657669', '创建测试课程2');
INSERT INTO `zcw_logs` VALUES ('127', '27', '课程管理', '1543658242', '创建测试课程5');
INSERT INTO `zcw_logs` VALUES ('128', '27', '登录', '1543678680', null);
INSERT INTO `zcw_logs` VALUES ('129', '27', '登录', '1543746194', null);
INSERT INTO `zcw_logs` VALUES ('130', '27', '退出', '1543749231', null);
INSERT INTO `zcw_logs` VALUES ('131', '30', '登录', '1543749242', null);
INSERT INTO `zcw_logs` VALUES ('132', '30', '退出', '1543749690', null);
INSERT INTO `zcw_logs` VALUES ('133', '27', '登录', '1543749711', null);
INSERT INTO `zcw_logs` VALUES ('134', '27', '课程管理', '1543749752', '创建测试课程1');
INSERT INTO `zcw_logs` VALUES ('135', '30', '登录', '1543749859', null);
INSERT INTO `zcw_logs` VALUES ('136', '30', '登录', '1543751504', null);
INSERT INTO `zcw_logs` VALUES ('137', null, '退出', '1543922254', null);
INSERT INTO `zcw_logs` VALUES ('138', null, '退出', '1543922260', null);
INSERT INTO `zcw_logs` VALUES ('139', '27', '登录', '1543922419', null);
INSERT INTO `zcw_logs` VALUES ('140', '27', '登录', '1543922481', null);
INSERT INTO `zcw_logs` VALUES ('141', '27', '课程管理', '1543922604', '创建20181204');
INSERT INTO `zcw_logs` VALUES ('142', '36', '登录', '1543923092', null);
INSERT INTO `zcw_logs` VALUES ('143', '27', '退出', '1543923117', null);
INSERT INTO `zcw_logs` VALUES ('144', '36', '登录', '1543923144', null);
INSERT INTO `zcw_logs` VALUES ('145', '27', '退出', '1543923151', null);
INSERT INTO `zcw_logs` VALUES ('146', '36', '登录', '1543923164', null);
INSERT INTO `zcw_logs` VALUES ('147', '27', '登录', '1543923498', null);
INSERT INTO `zcw_logs` VALUES ('148', '30', '登录', '1543923756', null);
INSERT INTO `zcw_logs` VALUES ('149', '30', '登录', '1543924648', null);
INSERT INTO `zcw_logs` VALUES ('150', '30', '退出', '1543924685', null);
INSERT INTO `zcw_logs` VALUES ('151', '27', '登录', '1543924703', null);
INSERT INTO `zcw_logs` VALUES ('152', '36', '退出', '1543924759', null);
INSERT INTO `zcw_logs` VALUES ('153', '27', '登录', '1543924769', null);
INSERT INTO `zcw_logs` VALUES ('154', '27', '课程管理', '1543925309', '创建hahah ');
INSERT INTO `zcw_logs` VALUES ('155', '36', '登录', '1543973907', null);
INSERT INTO `zcw_logs` VALUES ('156', '27', '登录', '1544064554', null);
INSERT INTO `zcw_logs` VALUES ('157', '27', '退出', '1544064563', null);
INSERT INTO `zcw_logs` VALUES ('158', '36', '登录', '1544064623', null);
INSERT INTO `zcw_logs` VALUES ('159', '27', '登录', '1544067014', null);
INSERT INTO `zcw_logs` VALUES ('160', '27', '课程管理', '1544068519', '创建保安条例');
INSERT INTO `zcw_logs` VALUES ('161', '27', '考试管理', '1544068659', '创建保安条例');
INSERT INTO `zcw_logs` VALUES ('162', '36', '退出', '1544069522', null);
INSERT INTO `zcw_logs` VALUES ('163', '27', '登录', '1544069541', null);
INSERT INTO `zcw_logs` VALUES ('164', '27', '登录', '1544069814', null);
INSERT INTO `zcw_logs` VALUES ('165', '27', '退出', '1544070021', null);
INSERT INTO `zcw_logs` VALUES ('166', '36', '登录', '1544070037', null);
INSERT INTO `zcw_logs` VALUES ('167', '36', '登录', '1544071436', null);
INSERT INTO `zcw_logs` VALUES ('168', '36', '登录', '1544071818', null);
INSERT INTO `zcw_logs` VALUES ('169', '36', '退出', '1544074683', null);
INSERT INTO `zcw_logs` VALUES ('170', '27', '登录', '1544074706', null);
INSERT INTO `zcw_logs` VALUES ('171', '27', '退出', '1544074781', null);
INSERT INTO `zcw_logs` VALUES ('172', '36', '登录', '1544074804', null);
INSERT INTO `zcw_logs` VALUES ('173', '36', '退出', '1544075204', null);
INSERT INTO `zcw_logs` VALUES ('174', null, '退出', '1544075214', null);
INSERT INTO `zcw_logs` VALUES ('175', null, '退出', '1544075220', null);
INSERT INTO `zcw_logs` VALUES ('176', null, '退出', '1544075234', null);
INSERT INTO `zcw_logs` VALUES ('177', null, '退出', '1544075243', null);
INSERT INTO `zcw_logs` VALUES ('178', null, '退出', '1544075256', null);
INSERT INTO `zcw_logs` VALUES ('179', '27', '登录', '1544075273', null);
INSERT INTO `zcw_logs` VALUES ('180', '36', '登录', '1544092913', null);
INSERT INTO `zcw_logs` VALUES ('181', '36', '退出', '1544092976', null);
INSERT INTO `zcw_logs` VALUES ('182', '27', '登录', '1544092991', null);
INSERT INTO `zcw_logs` VALUES ('183', null, '退出', '1544093036', null);
INSERT INTO `zcw_logs` VALUES ('184', '27', '登录', '1544667358', null);
INSERT INTO `zcw_logs` VALUES ('185', '27', '退出', '1544667625', null);
INSERT INTO `zcw_logs` VALUES ('186', '36', '登录', '1544667648', null);
INSERT INTO `zcw_logs` VALUES ('187', '36', '退出', '1544667694', null);
INSERT INTO `zcw_logs` VALUES ('188', '27', '登录', '1544667717', null);
INSERT INTO `zcw_logs` VALUES ('189', '27', '课程管理', '1544668926', '创建21081213');
INSERT INTO `zcw_logs` VALUES ('190', '27', '退出', '1544670409', null);
INSERT INTO `zcw_logs` VALUES ('191', '36', '登录', '1544670430', null);
INSERT INTO `zcw_logs` VALUES ('192', '36', '登录', '1544673279', null);
INSERT INTO `zcw_logs` VALUES ('193', '27', '登录', '1544673383', null);
INSERT INTO `zcw_logs` VALUES ('194', '27', '退出', '1544673569', null);
INSERT INTO `zcw_logs` VALUES ('195', '36', '登录', '1544673582', null);
INSERT INTO `zcw_logs` VALUES ('196', '36', '退出', '1544673637', null);
INSERT INTO `zcw_logs` VALUES ('197', '27', '登录', '1544673661', null);
INSERT INTO `zcw_logs` VALUES ('198', '36', '登录', '1544674792', null);
INSERT INTO `zcw_logs` VALUES ('199', '36', '登录', '1544680084', null);
INSERT INTO `zcw_logs` VALUES ('200', '36', '退出', '1544680106', null);
INSERT INTO `zcw_logs` VALUES ('201', '27', '登录', '1544680116', null);
INSERT INTO `zcw_logs` VALUES ('202', '27', '退出', '1544680170', null);
INSERT INTO `zcw_logs` VALUES ('203', '36', '登录', '1544680187', null);
INSERT INTO `zcw_logs` VALUES ('204', null, '退出', '1544733759', null);

-- ----------------------------
-- Table structure for zcw_member
-- ----------------------------
DROP TABLE IF EXISTS `zcw_member`;
CREATE TABLE `zcw_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(50) DEFAULT NULL COMMENT '人物图片',
  `usernumber` varchar(50) NOT NULL,
  `realname` varchar(50) NOT NULL,
  `role` int(5) NOT NULL DEFAULT '0' COMMENT '0学院1教师2经理3管理员4超级',
  `email` varchar(50) NOT NULL,
  `state` int(5) NOT NULL DEFAULT '1' COMMENT '0已审批，1未审批',
  `password` varchar(50) NOT NULL,
  `approval` varchar(50) NOT NULL COMMENT '审批人',
  `starttime` int(20) NOT NULL,
  `endtime` int(20) NOT NULL,
  `organization` int(5) NOT NULL DEFAULT '0' COMMENT '组织',
  `phone` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zw` int(5) DEFAULT NULL COMMENT '0办公室人员1服队长2队长3班长4骨干5助理',
  `operate` int(5) NOT NULL DEFAULT '0' COMMENT '运营部',
  `echelon` int(5) DEFAULT '0' COMMENT '梯队',
  `depart` int(5) DEFAULT NULL COMMENT '部门',
  `dangy` int(5) DEFAULT '0' COMMENT '是否党员',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `language` int(5) DEFAULT '0' COMMENT '语言',
  `sex` int(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_member
-- ----------------------------
INSERT INTO `zcw_member` VALUES ('33', null, 'ceshi16', 'ceshi16', '1', 'idkdid_521@163.com', '0', 'e10adc3949ba59abbe56e057f20f883e', '12345678', '1543633235', '0', '8', '13289223170', '西安高新路支行招商银行', '30', '36', '40', '42', '48', '', '52', '55');
INSERT INTO `zcw_member` VALUES ('34', null, 'ceshi12', 'ceshi12', '1', 'idkdid_521@163.com', '0', 'e10adc3949ba59abbe56e057f20f883e', '12345678', '1543633235', '0', '8', '13289223170', '西安高新路支行招商银行', '30', '36', '40', '42', '48', '', '52', '55');
INSERT INTO `zcw_member` VALUES ('35', null, 'ceshi13', 'ceshi13', '1', '1592969504@qq.com', '0', 'e10adc3949ba59abbe56e057f20f883e', '下次是持续形成v', '0', '0', '8', '13289223170', '陕西省显示', '30', '35', '39', '44', '49', '', '52', '55');
INSERT INTO `zcw_member` VALUES ('30', null, 'ceshi11', '王卓', '0', '1592969504@qq.com', '0', 'e10adc3949ba59abbe56e057f20f883e', '下次是持续形成v', '0', '0', '8', '13289223170', '陕西省显示', '30', '35', '39', '44', '49', '', '52', '55');
INSERT INTO `zcw_member` VALUES ('27', null, 'admin1', 'admin1', '2', 'idkdid_521@163.com', '0', 'e10adc3949ba59abbe56e057f20f883e', '12345678', '1543633235', '0', '8', '13289223170', '西安高新路支行招商银行', '30', '36', '40', '42', '48', '', '52', '55');
INSERT INTO `zcw_member` VALUES ('36', null, 'ceshi14', 'ceshi14', '0', 'idkdid_521@163.com', '0', 'e10adc3949ba59abbe56e057f20f883e', '12345678', '1543633235', '0', '8', '13289223170', '西安高新路支行招商银行', '30', '36', '40', '42', '48', '', '52', '55');
INSERT INTO `zcw_member` VALUES ('37', null, 'ceshi15', 'ceshi15', '0', 'idkdid_521@163.com', '0', 'e10adc3949ba59abbe56e057f20f883e', '12345678', '1543633235', '0', '8', '13289223170', '西安高新路支行招商银行', '30', '36', '40', '42', '48', '', '52', '55');

-- ----------------------------
-- Table structure for zcw_news
-- ----------------------------
DROP TABLE IF EXISTS `zcw_news`;
CREATE TABLE `zcw_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `userid` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `isfrist` tinyint(4) NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_news
-- ----------------------------
INSERT INTO `zcw_news` VALUES ('8', '测试新闻', '26', '1543112619', '1', '0', '<p>测试新闻测试新闻</p><p>测试新闻测试新闻</p><p>测试新闻测试新闻测试新闻</p><p>测试新闻测试新闻测试新闻</p>');
INSERT INTO `zcw_news` VALUES ('9', 'newsnewsnewsnewsnews', '26', '1543112686', '1', '0', '<p>newsnewsnewsnewsnewsnewsnews</p>');

-- ----------------------------
-- Table structure for zcw_question
-- ----------------------------
DROP TABLE IF EXISTS `zcw_question`;
CREATE TABLE `zcw_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `question` text COMMENT '题目',
  `count` int(11) DEFAULT '0' COMMENT '题目数量',
  `createtime` int(20) DEFAULT NULL COMMENT '创建时间',
  `userobject` varchar(50) DEFAULT NULL,
  `kaoti` varchar(255) DEFAULT NULL,
  `ex_id` int(11) DEFAULT NULL COMMENT '考试ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_question
-- ----------------------------
INSERT INTO `zcw_question` VALUES ('37', '测试试卷1', null, '0', '1543650877', null, null, null);
INSERT INTO `zcw_question` VALUES ('38', '测试试卷2', null, '0', '1543650887', null, null, null);
INSERT INTO `zcw_question` VALUES ('39', '测试试卷3', null, '0', '1543650894', null, ',36,31,33,27', '36');
INSERT INTO `zcw_question` VALUES ('40', '保安条例', null, '0', '1544068659', '9', ',36,37,38,39,40,31,32,33,34,35,26,27,28,29,30', '37');
INSERT INTO `zcw_question` VALUES ('41', '宝宝', null, '0', '1544085154', null, null, '37');

-- ----------------------------
-- Table structure for zcw_question_sort
-- ----------------------------
DROP TABLE IF EXISTS `zcw_question_sort`;
CREATE TABLE `zcw_question_sort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL,
  `sort` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of zcw_question_sort
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_rank
-- ----------------------------
DROP TABLE IF EXISTS `zcw_rank`;
CREATE TABLE `zcw_rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_rank
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_report
-- ----------------------------
DROP TABLE IF EXISTS `zcw_report`;
CREATE TABLE `zcw_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `training_records` int(11) DEFAULT '0' COMMENT '0不发送1每日2每周3每月',
  `examination_records` int(11) DEFAULT '0',
  `training_information` int(11) DEFAULT '0',
  `user_information` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_report
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_study
-- ----------------------------
DROP TABLE IF EXISTS `zcw_study`;
CREATE TABLE `zcw_study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `study_number` varchar(255) DEFAULT NULL COMMENT '职位编号',
  `study_title` varchar(255) DEFAULT NULL COMMENT '职位标题',
  `study_content` text COMMENT '职位描述',
  `auto_distribution` smallint(255) DEFAULT NULL COMMENT '分配类型   0否 1是',
  `distribution_condition` varchar(255) DEFAULT NULL COMMENT '分配条件',
  `addtime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `uid` int(11) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_study
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_survey
-- ----------------------------
DROP TABLE IF EXISTS `zcw_survey`;
CREATE TABLE `zcw_survey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `createtime` int(20) DEFAULT NULL,
  `open` varchar(255) DEFAULT '0' COMMENT '是否公开',
  `content` varchar(255) DEFAULT NULL COMMENT '介绍',
  `subject` text COMMENT '题目',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_survey
-- ----------------------------
INSERT INTO `zcw_survey` VALUES ('14', '测试调研测试调研测试调研', '1543112893', '0', '测试调研测试调研测试调研', null);
INSERT INTO `zcw_survey` VALUES ('15', 'eee', '1543119651', '0', 'eeee', null);

-- ----------------------------
-- Table structure for zcw_surveyti
-- ----------------------------
DROP TABLE IF EXISTS `zcw_surveyti`;
CREATE TABLE `zcw_surveyti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `tname` varchar(50) DEFAULT NULL,
  `content` text COMMENT '内容',
  `type` int(11) DEFAULT NULL COMMENT '题目类型1单选2多选3是非4简答5填空',
  `answer` text COMMENT '答案',
  `questionid` int(11) DEFAULT NULL COMMENT '题库ID',
  `question` text COMMENT '题目选项',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_surveyti
-- ----------------------------
INSERT INTO `zcw_surveyti` VALUES ('20', 'e5be35e61264ba3d5c63534a6a3656d7', null, '<p>测试调研测试调研测试调研</p>', '1', 'a', '14', '{\"data1\":\"1\",\"data2\":\"2\",\"data3\":\"3\",\"data4\":\"4\"}');
INSERT INTO `zcw_surveyti` VALUES ('21', '7496b397dd100cb4aab38a5ec997b1d0', null, '<p>撒大大大</p>', '2', '{\"data1\":\"a\",\"data2\":\"b\",\"data3\":null,\"data4\":null}', '14', '{\"data1\":\"\\u4e0as\",\"data2\":\"\\u5237\\u5237\\u5237\",\"data3\":\"1\",\"data4\":\"2\"}');
INSERT INTO `zcw_surveyti` VALUES ('22', 'fc4a9982bb5fe99fc87d9a270db69ca9', null, '<p>啊撒大声地</p>', '3', '1', '14', '');
INSERT INTO `zcw_surveyti` VALUES ('23', 'd92562c4fe5a70c8d9fa6db300e20c9b', null, '<p>的点点滴滴</p>', '4', null, '14', null);
INSERT INTO `zcw_surveyti` VALUES ('24', '179660b116d4c91e09eaaf77a7fc8fdd', null, '<p>大的行政村自行车在线</p>', '5', '擦擦擦', '14', '');

-- ----------------------------
-- Table structure for zcw_teacher
-- ----------------------------
DROP TABLE IF EXISTS `zcw_teacher`;
CREATE TABLE `zcw_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(255) NOT NULL COMMENT '老师id',
  `aptitude` text NOT NULL COMMENT '资质',
  `intro` text NOT NULL COMMENT '简介',
  `shot_inintro` text COMMENT '备注',
  `experience` varchar(255) NOT NULL COMMENT '经验',
  `honor` text NOT NULL COMMENT '荣誉',
  `course` int(11) NOT NULL COMMENT '课程id',
  `head` varchar(255) NOT NULL,
  `status` smallint(255) DEFAULT '1',
  `addtime` varchar(255) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_teacher
-- ----------------------------
INSERT INTO `zcw_teacher` VALUES ('22', '27', '111', '111', '11', '111', '111', '0', '20181124\\0a784536de0c56ffafde3ab284c30d02.png', '1', '1543025573');
INSERT INTO `zcw_teacher` VALUES ('23', '33', '3123', '12312312321', '3123', '12312', '3123', '0', '20181201\\9c912591707dde0027a8a23cfb712796.png', '1', '1543640715');

-- ----------------------------
-- Table structure for zcw_ti
-- ----------------------------
DROP TABLE IF EXISTS `zcw_ti`;
CREATE TABLE `zcw_ti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `tname` varchar(50) DEFAULT NULL,
  `content` text COMMENT '内容',
  `type` int(11) DEFAULT NULL COMMENT '题目类型1单选2多选3是非4简答5填空',
  `answer` text COMMENT '答案',
  `questionid` int(11) DEFAULT NULL COMMENT '题库ID',
  `question` text COMMENT '题目选项',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_ti
-- ----------------------------
INSERT INTO `zcw_ti` VALUES ('31', '8374bd0a22f6bc6622fe9d119ceb5e53', '', '<p>我今天萌萌哒</p>', '1', 'c', '38', '{\"data1\":\"\\u77e5\\u9053\",\"data2\":\"\\u4e0d\\u77e5\\u9053\",\"data3\":\"\\u7ba1\\u8001\\u5b50\\u5c41\\u4e8b\",\"data4\":\"\\u5367\\u69fd\"}');
INSERT INTO `zcw_ti` VALUES ('32', '0164bf38225ac2370bfcd1c4b94a3d70', '', '<p>哥帅不</p>', '2', '{\"data1\":\"a\",\"data2\":\"b\",\"data3\":null,\"data4\":null}', '38', '{\"data1\":\"\\u5e05\",\"data2\":\"\\u5e05\\u5e05\\u5e05\\u5e05\",\"data3\":\"\\u5e05\\u5e05\",\"data4\":\"\\u5e05\\u5e05\"}');
INSERT INTO `zcw_ti` VALUES ('33', '2389369ed5fc5dd1ad978de168e17dea', '', '<p>妖气航sbss??</p>', '3', '1', '38', '');
INSERT INTO `zcw_ti` VALUES ('34', '7a09bd2f4362bdb95b9a19e9ddc69684', '', '<p>关于你们呢晚上加班你有啥说的？？？</p>', '4', '', '38', '');
INSERT INTO `zcw_ti` VALUES ('35', 'a83304491a44720e81aac47511de0d02', '', '<p>今天（）班！！！</p>', '5', '加', '38', '');
INSERT INTO `zcw_ti` VALUES ('36', '8374bd0a22f6bc6622fe9d119ceb5e53', '', '<p>我今天萌萌哒</p>', '1', 'c', '37', '{\"data1\":\"\\u77e5\\u9053\",\"data2\":\"\\u4e0d\\u77e5\\u9053\",\"data3\":\"\\u7ba1\\u8001\\u5b50\\u5c41\\u4e8b\",\"data4\":\"\\u5367\\u69fd\"}');
INSERT INTO `zcw_ti` VALUES ('37', '0164bf38225ac2370bfcd1c4b94a3d70', '', '<p>哥帅不</p>', '2', '{\"data1\":\"a\",\"data2\":\"b\",\"data3\":null,\"data4\":null}', '37', '{\"data1\":\"\\u5e05\",\"data2\":\"\\u5e05\\u5e05\\u5e05\\u5e05\",\"data3\":\"\\u5e05\\u5e05\",\"data4\":\"\\u5e05\\u5e05\"}');
INSERT INTO `zcw_ti` VALUES ('38', '2389369ed5fc5dd1ad978de168e17dea', '', '<p>妖气航sbss??</p>', '3', '1', '37', '');
INSERT INTO `zcw_ti` VALUES ('39', '7a09bd2f4362bdb95b9a19e9ddc69684', '', '<p>关于你们呢晚上加班你有啥说的？？？</p>', '4', '', '37', '');
INSERT INTO `zcw_ti` VALUES ('40', 'a83304491a44720e81aac47511de0d02', '', '<p>今天（）班！！！</p>', '5', '加', '37', '');
INSERT INTO `zcw_ti` VALUES ('26', '8374bd0a22f6bc6622fe9d119ceb5e53', null, '<p>我今天萌萌哒</p>', '1', 'c', '39', '{\"data1\":\"\\u77e5\\u9053\",\"data2\":\"\\u4e0d\\u77e5\\u9053\",\"data3\":\"\\u7ba1\\u8001\\u5b50\\u5c41\\u4e8b\",\"data4\":\"\\u5367\\u69fd\"}');
INSERT INTO `zcw_ti` VALUES ('27', '0164bf38225ac2370bfcd1c4b94a3d70', null, '<p>哥帅不</p>', '2', '{\"data1\":\"a\",\"data2\":\"b\",\"data3\":null,\"data4\":null}', '39', '{\"data1\":\"\\u5e05\",\"data2\":\"\\u5e05\\u5e05\\u5e05\\u5e05\",\"data3\":\"\\u5e05\\u5e05\",\"data4\":\"\\u5e05\\u5e05\"}');
INSERT INTO `zcw_ti` VALUES ('28', '2389369ed5fc5dd1ad978de168e17dea', null, '<p>妖气航sbss??</p>', '3', '1', '39', '');
INSERT INTO `zcw_ti` VALUES ('29', '7a09bd2f4362bdb95b9a19e9ddc69684', null, '<p>关于你们呢晚上加班你有啥说的？？？</p>', '4', null, '39', null);
INSERT INTO `zcw_ti` VALUES ('30', 'a83304491a44720e81aac47511de0d02', null, '<p>今天（）班！！！</p>', '5', '加', '39', '');

-- ----------------------------
-- Table structure for zcw_user
-- ----------------------------
DROP TABLE IF EXISTS `zcw_user`;
CREATE TABLE `zcw_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `realname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `addr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zcw_user
-- ----------------------------

-- ----------------------------
-- Table structure for zcw_vote
-- ----------------------------
DROP TABLE IF EXISTS `zcw_vote`;
CREATE TABLE `zcw_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `createtime` int(20) DEFAULT NULL,
  `open` int(5) DEFAULT '0' COMMENT '是否发布',
  `content` varchar(255) DEFAULT NULL COMMENT '介绍',
  `subject` text COMMENT '题目',
  `obj` int(5) DEFAULT NULL COMMENT '用户对象',
  `answer` text,
  `question` text,
  `type` int(5) DEFAULT '2' COMMENT '多选',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of zcw_vote
-- ----------------------------
INSERT INTO `zcw_vote` VALUES ('20', '三生三', '1543113826', '0', null, null, '8', '{\"data1\":null,\"data2\":null,\"data3\":null,\"data4\":null}', '{\"data1\":\"\",\"data2\":\"\",\"data3\":\"\",\"data4\":\"\"}', '2');
INSERT INTO `zcw_vote` VALUES ('21', '发发发', '1543113885', '0', '请修改题目', null, '8', '{\"data1\":null,\"data2\":null,\"data3\":null,\"data4\":null}', '{\"data1\":\"\",\"data2\":\"\",\"data3\":\"\",\"data4\":\"\"}', '2');
INSERT INTO `zcw_vote` VALUES ('22', 'www', '1543119671', '0', '请修改题目', null, '8', '{\"data1\":null,\"data2\":null,\"data3\":null,\"data4\":null}', '{\"data1\":\"\",\"data2\":\"\",\"data3\":\"\",\"data4\":\"\"}', '2');
DROP TRIGGER IF EXISTS `course_time_d`;
DELIMITER ;;
CREATE TRIGGER `course_time_d` AFTER UPDATE ON `zcw_course` FOR EACH ROW begin
    update zcw_kc  set endtime = new.course_time_d *24*3600 + new.addtime where kc_id =  new.id;
end
;;
DELIMITER ;
