
--
-- 表的结构 `hl_user`
--

CREATE TABLE IF NOT EXISTS `hl_user` (
    `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_name` varchar(30) NOT NULL DEFAULT '',
    `company_name` varchar(100) NOT NULL DEFAULT '',
    `user_pwd` varchar(32) NOT NULL DEFAULT '',
    `user_pay_pwd` varchar(32) NOT NULL DEFAULT '',
    `mail` varchar(50) NOT NULL DEFAULT '',
    `is_online` tinyint(1) unsigned NOT NULL DEFAULT '1',
    `avatar` varchar(255) NOT NULL DEFAULT '',
    `sex` tinyint(1) unsigned NOT NULL DEFAULT '1',
    `real_name` varchar(20) NOT NULL DEFAULT '',
    `nickname` varchar(50) NOT NULL DEFAULT '',
    `mobile` varchar(50) NOT NULL DEFAULT '',
    `qq` varchar(20) NOT NULL DEFAULT '',
    `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
    `role` varchar(255) NOT NULL DEFAULT '',
    `ug_id` smallint(4) unsigned NOT NULL DEFAULT '4',
    `reg_ug_id` smallint(4) unsigned NOT NULL DEFAULT '0',
    `area_id` int(10) unsigned NOT NULL DEFAULT '0',
    `message` smallint(6) unsigned NOT NULL DEFAULT '0',
    `sms` int(10) NOT NULL DEFAULT '0',
    `credit` int(10) NOT NULL DEFAULT '0',
    `money` decimal(10,2) NOT NULL DEFAULT '0.00',
    `frozen_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
    `bank_name` varchar(30) NOT NULL DEFAULT '',
    `account_name` varchar(30) NOT NULL DEFAULT '',
    `edit_time` int(10) unsigned NOT NULL DEFAULT '0',
    `reg_ip` varchar(15) NOT NULL DEFAULT '',
    `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
    `login_ip` varchar(15) NOT NULL DEFAULT '',
    `login_time` int(10) unsigned NOT NULL DEFAULT '0',
    `login_times` int(10) unsigned NOT NULL DEFAULT '1',
    `black` varchar(255) NOT NULL DEFAULT '',
    `send` tinyint(1) unsigned NOT NULL DEFAULT '1',
    `auth` varchar(32) NOT NULL DEFAULT '',
    `auth_value` varchar(100) NOT NULL DEFAULT '',
    `auth_time` int(10) unsigned NOT NULL DEFAULT '0',
    `validate_mail` tinyint(1) unsigned NOT NULL DEFAULT '0',
    `validate_mobile` tinyint(1) unsigned NOT NULL DEFAULT '0',
    `validate_company` tinyint(1) unsigned NOT NULL DEFAULT '0',
    `alipay_account` varchar(50) NOT NULL DEFAULT '',
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `user_name` (`user_name`),
    UNIQUE KEY `mail` (`mail`),
    KEY `ug_id` (`ug_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='会员' AUTO_INCREMENT=1 ;

-
-- 转存表中的数据 `hl_user`
--

INSERT INTO `hl_user` (`user_id`, `user_name`, `company_name`, `user_pwd`, `user_pay_pwd`, `mail`, `is_online`, `avatar`, `sex`, `real_name`, `nickname`, `mobile`, `qq`, `is_admin`, `role`, `ug_id`, `reg_ug_id`, `area_id`, `message`, `sms`, `credit`, `money`, `frozen_money`, `bank_name`, `account_name`, `edit_time`, `reg_ip`, `reg_time`, `login_ip`, `login_time`, `login_times`, `black`, `send`, `auth`, `auth_value`, `auth_time`, `validate_mail`, `validate_mobile`, `validate_company`, `alipay_account`) VALUES
(1, 'guoyue', 'GUOYUE CMS', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', 'mail@yourdomain.com', 1, 'http://www.guoyuecloud.com/data/avatar/default48x48.gif', 1, '国阅云', '国阅云宝', '15010086996', '', 1, '网站管理员,网站创始人', 1, 0, 1, 0, 0, 349, 0.00, 0.00, '', '', 0, '127.0.0.1', 1367133411, '117.11.117.12', 1626764667, 898, '', 1, '', '', 0, 0, 0, 0, ''),
(2, 'julong', '北京巨龙', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', '1445981036@qq.com', 1, '', 1, '张先生', '阿欢', '15001094119', '1445981036', 0, '', 6, 6, 1, 0, 3, 45, 0.00, 0.00, '', '', 0, '111.194.45.207', 1521798453, '221.217.55.202', 1588908558, 56, '', 1, '', '', 0, 0, 0, 0, ''),
(3, 'wuwu', '北京呜呜网络', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', '14459810361@qq.com', 1, '', 1, '张先生', '阿乐', '15001094119', '1445981036', 0, '', 2, 6, 1, 0, 3, 28, 0.00, 0.00, '', '', 0, '111.194.49.153', 1524520863, '111.194.50.65', 1548932832, 15, '', 1, '', '', 0, 0, 0, 0, ''),
(4, 'tete', '北京特特网络科技有限公司', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', '14459810362@qq.com', 1, 'http://jianzhan.guoyuecloud.com/data/avatar/default48x48.gif', 1, '李先生', '学者', '15001094129', '1445981036', 0, '', 6, 6, 2, 0, 3, 20, 0.00, 0.00, '', '', 0, '111.194.49.153', 1524521358, '111.194.48.136', 1557049925, 19, '', 1, '', '', 0, 0, 0, 0, ''),
(5, 'zhuangxiu', '北京华芯大装修网络', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', '14459810366@qq.com', 1, 'http://www.guoyuecloud.com/data/avatar/default48x48.gif', 2, '张女士', '御用文人', '15001094118', '1445981036', 0, '', 6, 6, 1, 0, 3, 20, 0.00, 0.00, '', '', 0, '111.194.45.200', 1529978689, '60.27.177.80', 1598690450, 5, '', 1, '', '', 0, 0, 0, 0, ''),
(12, 'testzh002', '北京房客装修设计有限公司', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', '1445980026@qq.com', 1, 'http://jianzhan.guoyuecloud.com/web/static/uploadfile/201902/03/1-2019-02-03-13-52-27-52.jpg', 1, '张网', 'nikezhanh', '15010086993', '1445980026', 0, '', 6, 6, 1, 0, 0, 20, 0.00, 0.00, '', '', 0, '111.194.50.65', 1549173300, '111.194.50.65', 1549173300, 1, '', 1, '', '', 0, 0, 0, 0, ''),
(16, 'guoyuecn', '北京芯乌拉科技有限公司', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', 'guoyue11@163.com', 1, 'http://jwb.guoyuecloud.com/data/avatar/default48x48.gif', 1, '张辉', '', '15010088996', '', 0, '', 6, 6, 1, 0, 0, 20, 0.00, 0.00, '', '', 0, '111.194.45.55', 1557635330, '111.194.45.55', 1557635330, 1, '', 1, '', '', 0, 0, 0, 0, ''),
(17, 'newguoyue', '北京北乌拉科技有限公司', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', 'guoyue@163.com', 1, '', 1, '张辉', '', '15010080996', '', 0, '', 6, 6, 1, 0, 0, 20, 0.00, 0.00, '', '', 0, '111.194.45.55', 1557635794, '111.194.51.127', 1559854605, 10, '', 1, '', '', 0, 0, 0, 0, ''),
(18, 'malltest1', '北京国阅财务有限公司', '14e1b600b1fd579f47433b88e8d85291', '14e1b600b1fd579f47433b88e8d85291', '1445981036122@qq.com', 1, 'http://www.guoyuecloud.com/data/avatar/default48x48.gif', 1, 'zhanghui', '', '15010086999', '1445981036', 0, '', 6, 6, 1, 0, 0, 20, 1150.00, 0.00, '', '', 0, '117.11.239.178', 1590397744, '117.11.239.178', 1590583916, 9, '', 1, '', '', 0, 0, 0, 0, ''),
(36, 'zxzstest', '华郎装修有限公司', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', 'zxzstest@163.com', 1, 'http://www.guoyuecloud.com/wide/static/uploadfile/202010/04/36-2020-10-04-17-09-36-19.gif', 1, '张辉', '华修', '15010083996', '14459810251', 0, '', 6, 6, 1, 2, 0, 20, 0.00, 0.00, '', '', 0, '60.27.177.80', 1598691574, '117.11.117.12', 1626599374, 82, '', 1, '', '', 0, 0, 0, 0, ''),
(35, 'hualang', '华郎技术有限公司', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', '14459810342@qq.com', 1, 'http://www.guoyuecloud.com/data/avatar/default48x48.gif', 1, '张辉', '', '15010089996', '14459810362', 0, '', 6, 6, 1, 2, 0, 20, 0.00, 0.00, '', '', 0, '60.27.177.195', 1596529842, '117.14.175.48', 1625314983, 16, '', 1, '', '', 0, 0, 0, 0, ''),
(34, 'malltete55', '华络栏网络科技有限公司', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', '1543281036@qq.com', 1, 'http://www.guoyuecloud.com/data/avatar/default48x48.gif', 1, '张辉', '', '15044446996', '1543281036', 0, '', 2, 6, 1, 0, 0, 20, 0.00, 0.00, '', '', 0, '60.27.177.195', 1596512232, '60.27.177.195', 1596512232, 2, '', 1, '', '', 0, 0, 0, 0, ''),
(37, 'test2021', '北京华华装修工程有限公司', '3339851aac7b6b4cfbf57cbe1a61533f', '3339851aac7b6b4cfbf57cbe1a61533f', 'test2021@163.com', 1, '', 1, '张站', '', '15010096336', '12336996', 0, '', 6, 6, 1, 0, 0, 0, 0.00, 0.00, '', '', 0, '117.11.117.12', 1626517954, '117.11.117.12', 1626517954, 2, '', 1, '', '', 0, 0, 0, 0, '');
