
--
-- 表的结构 `hl_company`
--

CREATE TABLE IF NOT EXISTS `hl_company` (
    `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
    `user_name` varchar(30) NOT NULL DEFAULT '',
    `ug_id` smallint(4) unsigned NOT NULL DEFAULT '0',
    `company_name` varchar(100) NOT NULL DEFAULT '',
    `company_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
    `company_validate` tinyint(1) unsigned NOT NULL DEFAULT '0',
    `company_type` smallint(4) unsigned NOT NULL DEFAULT '0',
    `category_id` int(10) unsigned NOT NULL DEFAULT '0',
    `company_from_time` int(10) unsigned NOT NULL DEFAULT '0',
    `company_to_time` int(10) unsigned NOT NULL DEFAULT '0',
    `company_capital` float unsigned NOT NULL DEFAULT '0',
    `company_unit` smallint(4) unsigned NOT NULL DEFAULT '0',
    `company_size` smallint(4) unsigned NOT NULL DEFAULT '0',
    `company_year` smallint(4) unsigned NOT NULL DEFAULT '0',
    `company_city` int(10) unsigned NOT NULL DEFAULT '0',
    `company_scope` varchar(255) NOT NULL DEFAULT '',
    `company_tel` varchar(50) NOT NULL DEFAULT '',
    `company_fax` varchar(50) NOT NULL DEFAULT '',
    `company_mail` varchar(50) NOT NULL DEFAULT '',
    `company_address` varchar(255) NOT NULL DEFAULT '',
    `company_postcode` varchar(20) NOT NULL DEFAULT '',
    `company_url` varchar(255) NOT NULL DEFAULT '',
    `company_thumb` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`user_id`),
    KEY `company_city` (`company_city`),
    KEY `ug_id` (`ug_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司';

--
-- 转存表中的数据 `hl_company`
--

INSERT INTO `hl_company` (`user_id`, `user_name`, `ug_id`, `company_name`, `company_level`, `company_validate`, `company_type`, `category_id`, `company_from_time`, `company_to_time`, `company_capital`, `company_unit`, `company_size`, `company_year`, `company_city`, `company_scope`, `company_tel`, `company_fax`, `company_mail`, `company_address`, `company_postcode`, `company_url`, `company_thumb`) VALUES
(1, 'guoyue', 1, 'GUOYUE CMS', 0, 0, 0, 6, 0, 0, 0, 0, 0, 2018, 1, '', '01080782944', '', '', '北京市昌平区天通苑东三区33号楼401', '', '', 'http://www.guoyuecloud.com/data/company_thumb/default180&#120;180.gif'),
(2, 'julong', 6, '北京巨龙', 0, 0, 0, 15, 0, 0, 0, 0, 0, 2018, 1, '软件 研发', '01088888888', '', '', '北京市昌平区', '', '', ''),
(3, 'wuwu', 2, '北京呜呜网络', 0, 0, 0, 3, 0, 0, 1, 0, 0, 2018, 1, '装修 设计', '01088888899', '', '', '北京市昌平区', '', '', ''),
(4, 'tete', 6, '北京特特网络科技有限公司', 0, 0, 0, 1, 0, 0, 2, 0, 0, 2018, 1, '', '01088888800', '', '', '北京海淀区科技路78号', '', '', 'http://jianzhan.guoyuecloud.com/data/company_thumb/default180&#120;180.gif'),
(5, 'zhuangxiu', 6, '北京华芯大装修网络', 0, 0, 0, 2, 0, 0, 1, 0, 0, 2018, 1, '', '01088888800', '', '', '北京昌平区天通地区王', '', '', 'http://www.guoyuecloud.com/data/company_thumb/default180&#120;180.gif'),
(12, 'testzh002', 6, '北京房客装修设计有限公司', 0, 0, 0, 1, 0, 0, 1000, 0, 0, 2019, 1, '装修', '01086969696', '01086969696', '01086969696@qq.com', '北京昌平区回龙观89号', '102218', 'http://www.wula.com', 'http://jianzhan.guoyuecloud.com/web/static/uploadfile/201902/03/1-2019-02-03-13-53-36-18.jpg'),
(16, 'guoyuecn', 6, '北京芯乌拉科技有限公司', 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, '', '01084828009', '', 'guoyue11@163.com', '北京市昌平区天通苑东三区', '', '', 'http://jwb.guoyuecloud.com/data/company_thumb/default180&#120;180.gif'),
(17, 'newguoyue', 6, '北京北乌拉科技有限公司', 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, '', '01084828009', '', 'guoyue@163.com', '北京市昌平区天通苑东三区', '', '', ''),
(18, 'malltest1', 6, '北京国阅财务有限公司', 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '', '010-86868686', '', '1445981036122@qq.com', '北京市昌平区立汤路81号', '', '', 'http://www.guoyuecloud.com/data/company_thumb/default180&#120;180.gif'),
(37, 'test2021', 6, '北京华华装修工程有限公司', 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, '', '010-85858585', '', 'test2021@163.com', '北京市昌平区立水桥', '', '', ''),
(36, 'zxzstest', 6, '华郎装修有限公司', 0, 0, 0, 3, 0, 0, 5000, 0, 0, 2019, 1, '装修行业', '010-888998888', '010-889998888', 'zxzstest@163.com', '北京市昌平区天通苑32号1', '101010', 'http://www.huaxiu.com', 'http://www.guoyuecloud.com/data/company_thumb/default180&#120;180.gif'),
(35, 'hualang', 6, '华郎技术有限公司', 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, '', '01056939636', '', '14459810342@qq.com', '北京市昌平区天通苑58号', '', '', 'http://www.guoyuecloud.com/data/company_thumb/default180&#120;180.gif'),
(34, 'malltete55', 2, '华络栏网络科技有限公司', 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, '', '01058899888', '', '1543281036@qq.com', '北京市昌平区天通家园7560号', '', '', 'http://www.guoyuecloud.com/data/company_thumb/default180&#120;180.gif');
