
--
-- 表的结构 `hl_company_data`
--

CREATE TABLE IF NOT EXISTS `hl_company_data` (
    `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
    `content` text NOT NULL,
    PRIMARY KEY (`user_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司内容';

--
-- 转存表中的数据 `hl_company_data`
--

INSERT INTO `hl_company_data` (`user_id`, `content`) VALUES
(1, ''),
(2, '&nbsp;北京巨龙网络科技有限公司'),
(3, '北京呜呜网络科技有限公司'),
(4, ''),
(5, ''),
(12, '&nbsp;公司介绍北京昌平区回龙观89号'),
(16, ''),
(17, ''),
(18, '&nbsp;MALE TEST COPORATION TEST'),
(36, '&nbsp;华郎装修有限公司内容1'),
(35, ''),
(34, ''),
(37, '');
