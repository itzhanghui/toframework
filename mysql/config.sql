
--
-- 表的结构 `hl_setting`
--

CREATE TABLE IF NOT EXISTS `hl_setting` (
`setting_mark` varchar(30) NOT NULL DEFAULT '',
`setting_key` varchar(100) NOT NULL DEFAULT '',
`setting_val` mediumtext NOT NULL,
KEY `setting_mark` (`setting_mark`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站设置';
