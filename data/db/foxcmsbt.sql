-- --------------------------------------------------------

--
-- 表的结构 `fox_ads`
--

DROP TABLE IF EXISTS `fox_ads`;

CREATE TABLE `fox_ads` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `ads_city` varchar(255) DEFAULT 'NULL',
  `ads_title` varchar(50) DEFAULT 'NULL',
  `ads_url` varchar(255) DEFAULT 'NULL',
  `ads_time` int(11) DEFAULT '0',
  `ads_pic` varchar(255) DEFAULT 'NULL',
  PRIMARY KEY (`id`),
  KEY `ads_city` (`ads_city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `fox_ads`
--

INSERT INTO `fox_ads` (`id`, `ads_city`, `ads_title`, `ads_url`, `ads_time`, `ads_pic`) VALUES
(2, '1', '广告招商', '#', 1449292719, 'uploads/ads/20151205131837_77923.jpg'),
(3, '1', '广告招商', '#', 1449292749, 'uploads/ads/20151205131906_5829.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `fox_citys`
--

DROP TABLE IF EXISTS `fox_citys`;

CREATE TABLE `fox_citys` (
  `cid` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `sid` int(3) NOT NULL DEFAULT '0' COMMENT 'SId',
  `pingcid` int(11)  DEFAULT '0',
  `stitle` varchar(16) NOT NULL COMMENT 'Title',
  `sabc` varchar(10) NOT NULL COMMENT 'ABC',
  `cname` varchar(16) NOT NULL COMMENT 'Name',
  `cabc` varchar(10) NOT NULL COMMENT 'ABC',
  `cico` varchar(12) DEFAULT NULL COMMENT 'Icon',
  `ctitle` varchar(50) NOT NULL COMMENT 'Title',
  `ckeywords` varchar(100) DEFAULT NULL COMMENT 'Keywords',
  `cdescription` varchar(250) DEFAULT NULL COMMENT 'Description',
  `cmemu` varchar(250) DEFAULT NULL COMMENT 'Memu',
  `ctime` int(11) DEFAULT '0' COMMENT 'Create time',
  `cord` int(3) DEFAULT '0' COMMENT 'Ord',
  `clock` int(1) DEFAULT '0' COMMENT 'Lock',
  `cmoren` int(1) NOT NULL DEFAULT '0' COMMENT 'Moren',
  `cdomain` varchar(150) DEFAULT NULL COMMENT 'Domain',
  `clogo` varchar(250) DEFAULT NULL COMMENT 'Logo',
  `ctelpic` varchar(250) DEFAULT NULL COMMENT 'Telpic',
  `cwxpic` varchar(250) DEFAULT NULL COMMENT 'Wxpic',
  `cnums` decimal(10,1) DEFAULT '0.0' COMMENT 'Nums',
  `cthemes` varchar(100) DEFAULT NULL COMMENT 'Themes',
  `cowner` varchar(100) DEFAULT NULL COMMENT 'Owner',
  `ctel` varchar(100) DEFAULT NULL COMMENT 'Tel',
  `cqq` varchar(200) DEFAULT NULL COMMENT 'QQ',
  `cdress` varchar(100) DEFAULT NULL COMMENT 'Dress',
  `cbeian` varchar(100) DEFAULT NULL COMMENT 'Beian',
  `cstats` text COMMENT 'Stats',
  `cz_email` varchar(250) DEFAULT NULL COMMENT 'Email',
  `cz_tel` varchar(50) DEFAULT NULL COMMENT 'TEL',
  `cz_email_me` varchar(250) DEFAULT NULL,
  `cz_shouji_me` varchar(200) DEFAULT NULL,
  `cz_search` varchar(250) DEFAULT NULL,
  `cz_memu` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`cid`,`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `fox_citys`
--

INSERT INTO `fox_citys` (`cid`, `sid`, `pingcid`, `stitle`, `sabc`, `cname`, `cabc`, `cico`, `ctitle`, `ckeywords`, `cdescription`, `cmemu`, `ctime`, `cord`, `clock`, `cmoren`, `cdomain`, `clogo`, `ctelpic`, `cwxpic`, `cnums`, `cthemes`, `cowner`, `ctel`, `cqq`, `cdress`, `cbeian`, `cstats`, `cz_email`, `cz_tel`, `cz_email_me`, `cz_shouji_me`, `cz_search`, `cz_memu`) VALUES
(1, 0, 0, '直辖市', 'Z', '北京', 'B', NULL, '北京手机号码站', '北京手机号码站', '北京手机号码站', NULL, 1476354724, 0, 0, 1, 'xinhaoma.php.dokuai.com:8999', 'uploads/mbg/weblogo.png', 'uploads/mbg/ctelpic_a.png', '', '1.2', 'default', '', '13713815432', '1183648628', '广东深圳', '国字20161228', '', '1336999601@qq.com', '137-138-15432', '', '', '000|111|222|333|444|555|666|777|888|999', 'haoma/yidong,haoma/liantong,haoma/dianxin,haoma/guhua'),
(2, 0, 0, '直辖市', 'Z', '上海', 'S', NULL, '上海手机号码站', '上海手机号码站', '上海手机号码站', NULL, 1476359516, 0, 0, 0, 'shanghai.dokuai.com', 'uploads/mbg/weblogo.png', 'uploads/mbg/ctelpic_a.png', '', '1.5', 'mb_tiaohao', '', '13713815432', '1183648628', '广东深圳', '国字20161228', '', '1336999601@qq.com', '137-138-15432', '', '', '000|111|222|333|444|555|666|777|888|999', 'haoma/yidong,haoma/liantong,haoma/dianxin'),
(3, 7, 0, '山东省', 'S', '临沂', 'L', NULL, '临沂手机号码站', '精品号码，靓号', '低价出售靓号的平台', NULL, 1449992208, 0, 0, 0, 'linyi.dokuai.com', 'uploads/mbg/clogo_20151209028.png', 'uploads/mbg/ctelpic_20151209028.png', '', '1.2', 'default', '', '13713815432', '1183648628', '广东深圳', '国字20161228', '', '1183648628@qq.com', '137-138-54322', '1183648628@qq.com', '13713815432', '000|111|222|333|444|555|666|777|888|999', 'haoma/yidong,haoma/liantong,haoma/dianxin'),
(4, 7, 0, '山东省', 'S', '青岛', 'Q', NULL, '青岛手机号码站', '青岛手机号码站', '青岛手机号码站', NULL, 1449992221, 0, 0, 0, 'www.dokuai.com', 'uploads/mbg/weblogo.png', 'uploads/mbg/telpic.png', '', '1.2', 'default', '', '13713815432', '1183648628', '广东深圳', '国字20161228', '', '1336999601@qq.com', '青137-138-15432', '1183648628@qq.com', '13713515432', '000|111|222|333|444|555|666|777|888|999', 'haoma/yidong,haoma/liantong,haoma/dianxin,haoma/guhua'),
(5, 7, 0, '山东省', 'S', '济南', 'J', NULL, '济南手机号码站', '济南手机号码站', '济南手机号码站', NULL, 1449992232, 0, 0, 0, 'www.dokuai.com', 'uploads/mbg/weblogo.png', 'uploads/mbg/telpic.png', '', '1.2', 'default', '', '13713815432', '1183648628', '广东深圳', '国字20161228', '', '1336999601@qq.com', '济137-138-15432', '1183648628@qq.com', '13713515432', '000|111|222|333|444|555|666|777|888|999', 'haoma/yidong,haoma/liantong,haoma/dianxin'),
(6, 1, 0, '黑龙江', 'H', '大庆', 'D', NULL, '大庆选号网', '选号网，大庆选号网，选号网大庆', '大庆最大最全的号码选号网站', NULL, 1463674887, 0, 0, 0, 'www.dokuai.com', 'uploads/mbg/weblogo.png', 'uploads/mbg/telpic.png', '', '1.2', 'default', '', '40089058888', '800002989', '北京市海淀区中关村大街48号', '京ICP备13003226号-3', '', 'xuanhaowang@163.com', '400-890-5888', 'xuanhaowang@163.com', '18800000605', '000|111|222|333|444|555|666|777|888|999', 'haoma/yidong,haoma/liantong,haoma/dianxin,haoma/guhua,haoma/othera,haoma/yihaotong,haoma/xunihao'),
(7, 2, 1, '吉林省', 'J', '长春', 'C', NULL, '长春选号网', '选号网，长春选号网，选号网长春', '长春最大最全的号码选号网站', NULL, 1462358326, 0, 0, 0, 'www.dokuai.com', 'uploads/mbg/weblogo.png', 'uploads/mbg/telpic.png', '', '1.2', 'default', '', '40089058888', '800002989', '北京市海淀区中关村大街48号', '京ICP备13003226号-3', '', 'xuanhaowang@163.com', '400-890-5888', 'xuanhaowang@163.com', '18800000605', '000|111|222|333|444|555|666|777|888|999', 'haoma/yidong,haoma/liantong,haoma/dianxin,haoma/guhua');

-- --------------------------------------------------------

--
-- 表的结构 `fox_haoma`
--

DROP TABLE IF EXISTS `fox_haoma`;

CREATE TABLE `fox_haoma` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `hao_title` varchar(50) DEFAULT 'NULL',
  `hao_type` tinyint(5) DEFAULT '0',
  `hao_city` tinyint(5) DEFAULT '0',
  `hao_pinpai` int(11) DEFAULT '0',
  `hao_jiage` int(11) DEFAULT '0',
  `hao_huafei` int(11) DEFAULT '0',
  `hao_lock` tinyint(5) DEFAULT '0',
  `hao_user` varchar(100) DEFAULT 'NULL',
  `hao_time` int(11) DEFAULT '0',
  `hao_dig` tinyint(3) DEFAULT '0',
  `hao_heyue` varchar(255) DEFAULT 'NULL',
  `hao_beizhu` varchar(255) DEFAULT 'NULL',
  `hao_llcs` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `hao_type` (`hao_type`),
  KEY `hao_city` (`hao_city`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- 转存表中的数据 `fox_haoma`
--

INSERT INTO `fox_haoma` (`id`, `hao_title`, `hao_type`, `hao_city`, `hao_pinpai`, `hao_jiage`, `hao_huafei`, `hao_lock`, `hao_user`, `hao_time`, `hao_dig`, `hao_heyue`, `hao_beizhu`, `hao_llcs`) VALUES
(110, '13753151239', 0, 1, 12, 15000, 300, 0, 'hezuo01', 1450468380, 0, '', '', 3),
(109, '13753851238', 0, 1, 11, 1800, 300, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(105, '13753815234', 0, 1, 11, 1800, 300, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(106, '13753811235', 0, 1, 11, 1200, 300, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(107, '13753811236', 0, 1, 11, 1500, 300, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(108, '13753851237', 0, 1, 11, 1500, 300, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(111, '13615695645', 0, 1, 11, 1500, 200, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(104, '13753815233', 0, 1, 11, 1200, 300, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(103, '13753815232', 0, 1, 11, 1100, 300, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(102, '13753815231', 0, 1, 11, 1200, 300, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(92, '13713151239', 0, 1, 11, 1500, 300, 0, 'hezuo01', 1450401123, 0, '', '', 0),
(91, '13718151238', 0, 1, 11, 1800, 300, 0, 'hezuo01', 1450401123, 0, '', '', 0),
(90, '13713151237', 0, 1, 11, 1500, 300, 0, 'hezuo01', 1450401123, 0, '', '', 0),
(89, '13713151236', 0, 1, 11, 1500, 300, 0, 'hezuo01', 1450401123, 0, '', '', 0),
(88, '13713851235', 0, 1, 11, 1200, 300, 0, 'hezuo01', 1450401123, 0, '', '', 0),
(87, '13713851234', 0, 1, 11, 1800, 300, 0, 'hezuo01', 1450401123, 0, '', '', 0),
(86, '13713851233', 0, 1, 11, 1200, 300, 0, 'hezuo01', 1450401123, 0, '', '', 0),
(85, '13713811232', 0, 1, 11, 1100, 300, 0, 'hezuo01', 1450401123, 0, '', '', 0),
(84, '13713851231', 0, 1, 11, 1200, 300, 0, 'hezuo01', 1450401123, 0, '', '', 0),
(112, '13658698598', 0, 1, 11, 1100, 200, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(113, '13586954685', 0, 1, 11, 500, 220, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(114, '13568952569', 0, 1, 11, 1000, 200, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(115, '13845685568', 0, 1, 11, 1000, 200, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(116, '13856899636', 0, 1, 11, 1000, 200, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(117, '13586598562', 0, 1, 11, 1000, 200, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(118, '13756895652', 0, 1, 11, 1000, 200, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(119, '13956856888', 0, 1, 11, 18000, 500, 0, 'hezuo01', 1450402399, 0, '', '', 0),
(120, '13965899999', 0, 1, 11, 25000, 1000, 0, 'hezuo01', 1450402399, 0, '', '', 0);

-- --------------------------------------------------------
--
-- 表的结构 `fox_shoucangs`
--

DROP TABLE IF EXISTS `fox_shoucangs`;
CREATE TABLE IF NOT EXISTS `fox_shoucangs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `shoucangid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- 表的结构 `fox_ches`
--

DROP TABLE IF EXISTS `fox_ches`;

CREATE TABLE `fox_ches` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `che_hao` varchar(50) DEFAULT 'NULL',
  `che_userid` int(11) DEFAULT '0',
  `che_city` tinyint(5) DEFAULT '0',
  `che_time` int(11) DEFAULT '0',
  `che_haoid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `che_hao` (`che_hao`),
  KEY `che_haoid` (`che_haoid`),
  KEY `che_userid` (`che_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- 表的结构 `fox_dingdan`
--

DROP TABLE IF EXISTS `fox_dingdan`;

CREATE TABLE `fox_dingdan` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `che_hao` varchar(50) DEFAULT 'NULL',
  `dan_hao` varchar(50) DEFAULT 'NULL',
  `dan_userid` int(11) DEFAULT '0',
  `dan_city` tinyint(5) DEFAULT '0',
  `dan_time` int(11) DEFAULT '0',
  `dan_name` varchar(50) DEFAULT 'NULL',
  `dan_dress` varchar(250) DEFAULT 'NULL',
  `dan_tel` varchar(50) DEFAULT 'NULL',
  `dan_tels` varchar(50) DEFAULT 'NULL',
  `dan_content` text,
  `dan_paytype` int(11) DEFAULT '0',
  `dan_haoid` text,
  PRIMARY KEY (`id`),
  KEY `dan_hao` (`dan_hao`),
  KEY `dan_userid` (`dan_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------
--
-- 表的结构 `fox_dingdan_list`
--

DROP TABLE IF EXISTS `fox_dingdan_list`;

CREATE TABLE `fox_dingdan_list` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `che_hao` varchar(50) DEFAULT 'NULL',
  `dan_hao` varchar(50) DEFAULT 'NULL',
  `dan_userid` int(11) DEFAULT '0',
  `dan_city` tinyint(5) DEFAULT '0',
  `dan_time` int(11) DEFAULT '0',
  `dan_haoid` int(11) DEFAULT '0',
  `dan_hao_lock` tinyint(5) DEFAULT '0',
  `dan_hao_chengben` varchar(20) DEFAULT '',
  `dan_hao_shoujia` varchar(20) DEFAULT '',
  `dan_hao_shoujias` varchar(20) DEFAULT '',
  `dan_hao_maichujias` varchar(20) DEFAULT '',
  `dan_hao_lock_queren` tinyint(5) DEFAULT '0',
  `dan_hao_lock_zhifu` tinyint(5) DEFAULT '0',
  `dan_hao_lock_fahuo` tinyint(5) DEFAULT '0',
  `dan_hao_lock_shouhuo` tinyint(5) DEFAULT '0',
  `dan_hao_lock_wuxiao` tinyint(5) DEFAULT '0',
  `dan_hao_lock_wancheng` tinyint(5) DEFAULT '0',
  `dan_hao_lock_zuofei` tinyint(5) DEFAULT '0',
  `dan_hao_lock_guozhang` int(11) DEFAULT '0',
  `dan_hao_fahuo_type` varchar(50) DEFAULT '',
  `dan_hao_shoukuan_type` varchar(50) DEFAULT '',
  `dan_hao_kuaidi_type` varchar(50) DEFAULT '',
  `dan_hao_fahuo_danhao` varchar(200) DEFAULT '',
  `dan_hao_fahuo_kuan` varchar(20) DEFAULT '',
  `dan_hao_fahuo_beizhu` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `dan_hao` (`dan_hao`),
  KEY `dan_haoid` (`dan_haoid`),
  KEY `dan_userid` (`dan_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `fox_do_work`
--

DROP TABLE IF EXISTS `fox_do_work`;
CREATE TABLE `fox_do_work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_type` int(11) NOT NULL DEFAULT '0',
  `do_lei` int(11) NOT NULL DEFAULT '0',
  `do_id` int(11) NOT NULL DEFAULT '0',
  `do_userid` int(11) NOT NULL DEFAULT '0',
  `do_memo` varchar(128) DEFAULT NULL,
  `do_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`do_type`,`do_lei`,`do_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- 表的结构 `fox_dingzhi`
--

DROP TABLE IF EXISTS `fox_dingzhi`;

CREATE TABLE `fox_dingzhi` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `dz_city` tinyint(3) DEFAULT '0',
  `dz_title` varchar(50) DEFAULT 'NULL',
  `dz_content` text,
  `dz_name` varchar(50) DEFAULT 'NULL',
  `dz_tel` varchar(100) DEFAULT 'NULL',
  `dz_qq` varchar(100) DEFAULT 'NULL',
  `dz_email` varchar(100) DEFAULT 'NULL',
  `dz_time` int(11) DEFAULT '0',
  `dz_userid` int(11) DEFAULT '0',
  `dz_lock` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `fox_dingzhi`
--

INSERT INTO `fox_dingzhi` (`id`, `dz_city`, `dz_title`, `dz_content`, `dz_name`, `dz_tel`, `dz_qq`, `dz_email`, `dz_time`, `dz_userid`, `dz_lock`) VALUES
(1, 1, '139****6666', '<p>555555</p>', '刘三', '13713815432', '5555555', '5555@323323.com', 1450703595, 8, 0);

-- --------------------------------------------------------

--
-- 表的结构 `fox_jixiong`
--

DROP TABLE IF EXISTS `fox_jixiong`;

CREATE TABLE `fox_jixiong` (
  `jx_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `jx_name` varchar(50) NOT NULL DEFAULT '' COMMENT '吉凶',
  `jx_memo` varchar(500) NOT NULL DEFAULT '' COMMENT '内容',
  `jx_order` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`jx_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

--
-- 转存表中的数据 `fox_jixiong`
--

INSERT INTO `fox_jixiong` (`jx_id`, `jx_name`, `jx_memo`, `jx_order`) VALUES
(1, '吉', '大展鸿图，信用得固，名利双收，可获成功', 0),
(2, '凶', '根基不固，摇摇欲坠，一盛一衰，劳而无获', 0),
(3, '吉', '根深蒂固，蒸蒸日上，如意吉祥，百事顺遂', 0),
(4, '凶', '前途坎坷，苦难折磨，非有毅力，难望成功', 0),
(5, '吉', '阴阳和合，生意兴隆，名利双收，后福重重', 0),
(6, '吉', '万宝集门，天降幸运，立志奋发，得成大功', 0),
(7, '吉', '独营生意，和气吉祥，排除万难，必获成功', 0),
(8, '吉', '努力发达，贯彻志望，不忘进退，可望成功', 0),
(9, '凶', '虽抱奇才，有才无命，独营无力，财力难望', 0),
(10, '凶', '乌云遮月，暗淡无光，空费心力，徒劳无功', 0),
(11, '吉', '草木逢春，枝叶沾露，稳健着实，必得人望', 0),
(12, '凶', '薄弱无力，孤立无援，外祥内苦，谋事难成', 0),
(13, '吉', '天赋吉运，能得人望，善用智慧，必获成功', 0),
(14, '凶', '忍得若难，必有后福，是成是败，惟靠紧毅', 0),
(15, '吉', '谦恭做事，外得人和，大事成就，一门兴隆', 0),
(16, '吉', '能获众望，成就大业，名利双收，盟主四方', 0),
(17, '吉', '排除万难，有贵人助，把握时机，可得成功', 0),
(18, '吉', '经商做事，顺利昌隆，如能慎始，百事亨通', 0),
(19, '凶', '成功虽早，慎防亏空，内外不合，障碍重重', 0),
(20, '凶', '智商志大，历尽艰难，焦心忧劳，进得两难', 0),
(21, '吉', '先历困苦，后得幸福，霜雪梅花，春来怒放', 0),
(22, '凶', '秋草逢霜，怀才不遇，忧愁怨苦，事不如意', 0),
(23, '吉', '旭日升天，名显四方，渐次进展，终成大业', 0),
(24, '吉', '绵绣前程，须靠自力，多用智谋，能奏大功', 0),
(25, '吉', '天时地利，只欠人和，讲信修睦，即可成功', 0),
(26, '凶', '波澜起伏，千变万化，凌架万难，必可成功', 0),
(27, '凶带吉', '一成一败，一盛一衰，惟靠谨慎，可守成功', 0),
(28, '凶', '鱼临旱地，难逃恶运，此数大凶，不如更名', 0),
(29, '吉', '如龙得云，青云直上，智谋奋进，才略奏功', 0),
(30, '凶', '吉凶参半，得失相伴，投机取巧，吉凶无常', 0),
(31, '吉', '此数大吉，名利双收，渐进向上，大业成就', 0),
(32, '吉', '池中之龙，风云际会，一跃上天，成功可望', 0),
(33, '吉', '意气用事，人和必失，如能慎始，必可昌隆', 0),
(34, '凶', '灾难不绝，难望成功，此数大凶，不如更名', 0),
(35, '吉', '中吉之数，进退保守，生意安稳，成就普通', 0),
(36, '凶', '波澜得叠，常陷穷困，动不如静，有才无命', 0),
(37, '吉', '逢凶化吉，吉人天相，风调雨顺，生意兴隆', 0),
(38, '凶带吉', '名虽可得，利则难获，艺界发展，可望成功', 0),
(39, '吉', '云开见月，虽有劳碌，光明坦途，指日可望', 0),
(40, '吉带凶', '一成一衰，沉浮不定，知难而退，自获天佑', 0),
(41, '吉', '天赋吉运，德望兼备，继续努力，前途无限', 0),
(42, '吉带凶', '事业不专，十九不成，专心进取，可望成功', 0),
(43, '吉带凶', '雨夜之花，外祥内苦，忍耐自重，转凶为吉', 0),
(44, '凶', '虽用心计，事难遂愿，贪功冒进，必招失败', 0),
(45, '吉', '杨柳遇春，绿叶发枝，冲破难关，一举成名', 0),
(46, '凶', '坎坷不平，艰难重重，若无耐心，难望有成', 0),
(47, '吉', '有贵人助，可成大业，虽遇不幸，浮沉不定', 0),
(48, '吉', '美化丰实，鹤立鸡群，名利俱全，繁荣富贵', 0),
(49, '凶带吉', '遇吉则吉，遇凶则凶，惟靠谨慎，逢凶化吉', 0),
(50, '吉带凶', '吉凶互见，一成一败，凶中有吉，吉中有凶', 0),
(51, '吉带凶', '一盛一衰，浮沉不常，自重自处，可保平安', 0),
(52, '吉', '草木逢春，雨过天晴，渡过难关，即获成功', 0),
(53, '吉带凶', '盛衰参半，外祥内苦，先吉后凶，先凶后吉', 0),
(54, '凶', '虽倾全力，难望成功，此数大凶，最好改名', 0),
(55, '吉带凶', '外观昌隆，内隐祸患，克服难关，开出泰运', 0),
(56, '凶', '事与愿违，终难成功，欲速不达，有始无终', 0),
(57, '吉', '虽有困难，时来运转，旷野枯草，春来花开', 0),
(58, '凶带吉', '半凶半吉，浮沉多端，始凶终吉，能保成功', 0),
(59, '凶', '遇事猜疑，难望成事，大刀阔斧，始可有成', 0),
(60, '凶', '黑暗无光，心迷意乱，出尔反尔，难定方针', 0),
(61, '凶带吉', '运遮半月，内隐风波，应有谨慎，始保平安', 0),
(62, '凶', '烦闷懊恼，事业难展，自防灾祸，始免困境', 0),
(63, '吉', '万物化育，繁荣之象，专心一意，必能成功', 0),
(64, '凶', '见异思迁，十九不成，徒劳无功，不如更名', 0),
(65, '吉', '吉运自来，能享盛名，把握时机，必获成功', 0),
(66, '凶', '黑夜温长，进退维谷，内外不和，信用缺乏', 0),
(67, '吉', '独营事业，事事如意，功成名就，富贵自来', 0),
(68, '吉', '思虑周祥，计书力行，不失先机，可望成功', 0),
(69, '凶', '动摇不安，常陷逆境，不得时运，难得利润', 0),
(70, '凶', '惨淡经营，难免贫困，此数不吉，最好改名', 0),
(71, '吉带凶', '吉凶参半，惟赖勇气，贯彻力行，始可成功', 0),
(72, '凶', '利害混集，凶多吉少，得而复失，难以安顺', 0),
(73, '吉', '安乐自来，自然吉祥，力行不懈，终必成功', 0),
(74, '凶', '利不及费，坐食山空，如无章法，难望成功', 0),
(75, '吉带凶', '吉中带凶，欲速不达，进不如守，可保安祥', 0),
(76, '凶', '此数大凶，破产之象，宜速改名，以避厄运', 0),
(77, '吉带凶', '先苦后甘，先甜后苦，如能守成，不致失败', 0),
(78, '吉带凶', '有得有失，华而不实，须防劫财，始保安顺', 0),
(79, '凶', '如走夜路，前途无光，希望不大，劳而无功', 0),
(80, '凶带吉', '辛苦不绝，早入隐遁，安心立命，化凶转吉', 0),
(81, '吉', '万物回春，还本归元，吉祥重叠，富贵尊荣', 0);

-- --------------------------------------------------------

--
-- 表的结构 `fox_login_log`
--

DROP TABLE IF EXISTS `fox_login_log`;

CREATE TABLE `fox_login_log` (
  `loid` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `lotype` varchar(16) NOT NULL COMMENT 'Type',
  `louid` varchar(16) NOT NULL COMMENT 'User',
  `loip` varchar(16) NOT NULL COMMENT 'IP addr',
  `lotime` int(11) DEFAULT '0' COMMENT 'Login Time',
  `loagent` varchar(255) DEFAULT NULL COMMENT 'User Agent',
  PRIMARY KEY (`loid`,`louid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- 表的结构 `fox_model`
--

DROP TABLE IF EXISTS `fox_model`;

CREATE TABLE `fox_model` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` char(30) NOT NULL COMMENT '标识',
  `title` char(30) NOT NULL COMMENT '名称',
  `table_name` varchar(50) NOT NULL COMMENT '表名',
  `is_extend` varchar(10) NOT NULL DEFAULT '0' COMMENT '允许子模型',
  `extend` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '继承的模型',
  `list_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '列表类型',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` tinyint(2) NOT NULL DEFAULT '1',
  `engine_type` varchar(25) NOT NULL DEFAULT 'MyISAM' COMMENT '数据库引擎',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `fox_model_field`
--

DROP TABLE IF EXISTS `fox_model_field`;

CREATE TABLE `fox_model_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `model` varchar(100) NOT NULL DEFAULT '' COMMENT '表名',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段注释',
  `types` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `field` varchar(100) NOT NULL COMMENT '字段定义',
  `defaults` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `keys` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'Key',
  `ords` int(11) unsigned NOT NULL COMMENT '排序',
  `create_time` int(11) unsigned NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `fox_news`
--

DROP TABLE IF EXISTS `fox_news`;

CREATE TABLE `fox_news` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `news_city` tinyint(3) DEFAULT '0',
  `news_type` tinyint(3) DEFAULT '0',
  `news_title` varchar(50) DEFAULT 'NULL',
  `news_from` varchar(50) DEFAULT 'NULL',
  `news_content` text,
  `news_time` int(11) DEFAULT '0',
  `news_llcs` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `news_type` (`news_type`),
  KEY `news_city` (`news_city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `fox_news`
--

INSERT INTO `fox_news` (`id`, `news_city`, `news_type`, `news_title`, `news_from`, `news_content`, `news_time`, `news_llcs`) VALUES
(2, 1, 0, '这是一个移动资讯内容', '', '<p>&lt;p&gt;&lt;/p&gt;&lt;p&gt;这是一个移&lt;span style="line-height: 1.5;"&gt;动资讯内容&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;</p>', 1450025606, 5),
(3, 0, 0, '测试一个全站资讯内容', '', '<p>&lt;p&gt;测试一个全站资讯内容测试一个全站&lt;/p&gt;&lt;p&gt;资讯内容测试一个全站资讯内容&lt;br&gt;&lt;/p&gt;</p>', 1450625146, 1),
(4, 0, 0, '测试一个移动资讯', '', '<p>&lt;p&gt;测试一个移动资讯&lt;br&gt;&lt;/p&gt;</p>', 1450626027, 6),
(5, 0, 5, '这是行业新闻', '', '<p>&lt;p&gt;这是行业新闻&lt;br&gt;&lt;/p&gt;</p>', 1450628596, 1),
(6, 0, 6, '这是优惠政策', '', '<p>&lt;p&gt;这是优惠政策&lt;br&gt;&lt;/p&gt;</p>', 1450628615, 2),
(7, 0, 7, '这是经典短信', '', '<p>&lt;p&gt;这是经典短信&lt;br&gt;&lt;/p&gt;</p>', 1450628637, 0),
(8, 0, 8, '这是生活休闲', '', '<p>&lt;p&gt;这是生活休闲&lt;br&gt;&lt;/p&gt;</p>', 1450628656, 1);
-- --------------------------------------------------------

--
-- 表的结构 `fox_question`
--

DROP TABLE IF EXISTS `fox_question`;

CREATE TABLE `fox_question` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `q_city` tinyint(3) DEFAULT '0',
  `q_type` tinyint(3) DEFAULT '0',
  `q_title` varchar(50) DEFAULT 'NULL',
  `q_content` text,
  `q_time` int(11) DEFAULT '0',
  `q_userid` int(11) DEFAULT '0',
  `q_name` varchar(50) DEFAULT 'NULL',
  `q_tel` varchar(50) DEFAULT 'NULL',
  `q_llcs` int(11) DEFAULT '0',
  `q_recontent` text,
  `q_retime` int(11) DEFAULT '0',
  `q_reuserid` int(11) DEFAULT '0',
  `q_rename` varchar(50) DEFAULT 'NULL',
  PRIMARY KEY (`id`),
  KEY `q_city` (`q_city`),
  KEY `q_type` (`q_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `fox_question`
--

INSERT INTO `fox_question` (`id`, `q_city`, `q_type`, `q_title`, `q_content`, `q_time`, `q_userid`, `q_name`, `q_tel`, `q_llcs`, `q_recontent`, `q_retime`, `q_reuserid`, `q_rename`) VALUES
(1, 1, 0, '我选的移动号怎么还没送到？', '<p>&lt;p&gt;&lt;/p&gt;&lt;p&gt;我选的移动号怎么还没送到？13821321866&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;</p>', 1450029471, 0, 'xxx', 'xxxxxxxx', 0, '<p>&lt;p&gt;&lt;/p&gt;&lt;p&gt;于先生您好，您当前预定的13821991866 这个天津移动号码并不属于我们网站所有，请您核实一下信息，感谢您的支持。&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;</p>', 1450031164, 8, '郑经理'),
(2, 1, 0, '有个问题不明白问一下啊', '<p>怎么付款购买啊</p>', 1450299392, 10, '刘三姐', '13713815432', 0, NULL, 0, 0, 'NULL'),
(3, 1, 0, '再提出一个问题', '<p>最近老是找不到好的号码，能推荐一些么</p>', 1450299560, 10, '刘三姐', '13713815432', 0, NULL, 0, 0, 'NULL');

-- --------------------------------------------------------

--
-- 表的结构 `fox_xinxi`
--

DROP TABLE IF EXISTS `fox_xinxi`;

CREATE TABLE `fox_xinxi` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `x_city` tinyint(3) DEFAULT '0',
  `x_type` tinyint(3) DEFAULT '0',
  `x_title` varchar(50) DEFAULT 'NULL',
  `x_jiage` int(11) DEFAULT '0',
  `x_content` text,
  `x_time` int(11) DEFAULT '0',
  `x_userid` int(11) DEFAULT '0',
  `x_name` varchar(50) DEFAULT 'NULL',
  `x_tel` varchar(50) DEFAULT 'NULL',
  `x_qq` varchar(50) DEFAULT 'NULL',
  `x_email` varchar(50) DEFAULT 'NULL',
  `x_llcs` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `x_city` (`x_city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `fox_xinxi`
--

INSERT INTO `fox_xinxi` (`id`, `x_city`, `x_type`, `x_title`, `x_content`, `x_time`, `x_userid`, `x_name`, `x_tel`, `x_qq`, `x_email`, `x_llcs`) VALUES
(1, 1, 0, '号码精选，不可多得', '<p>欢迎来购买，靓号多多</p>', 1450302698, 10, '刘二姐', '13713815432', '1183648628', '1183648628@qq.com', 0),
(2, 1, 0, '13713815432转让', '<p>价格18000元。欢迎抢购</p>', 1450304831, 10, '刘二姐', '13713815432', '', '', 0);


-- --------------------------------------------------------

--
-- 表的结构 `fox_pages`
--

DROP TABLE IF EXISTS `fox_pages`;

CREATE TABLE `fox_pages` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `pages_city` tinyint(3) DEFAULT '0',
  `pages_type` tinyint(3) DEFAULT '0',
  `pages_title` varchar(50) DEFAULT 'NULL',
  `pages_content` text,
  `pages_time` int(11) DEFAULT '0',
  `pages_llcs` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pages_city` (`pages_city`),
  KEY `pages_type` (`pages_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `fox_pages`
--

INSERT INTO `fox_pages` (`id`, `pages_city`, `pages_type`, `pages_title`, `pages_content`, `pages_time`, `pages_llcs`) VALUES
(1, 1, 0, '新版手机号码网全新上线', '', 1449331689, 9),
(2, 3, 0, '临沂号码站开通啦', '<p>&lt;p&gt;临沂号码站开通啦临沂号码站开通啦临沂号码站开通啦临沂号码站开通啦&lt;br&gt;&lt;/p&gt;</p>', 1450649392, 13),
(3, 1, 0, '中国移动通信', '<p>&lt;p&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;快网科技(www.kuaiwww.com)是中国蓝狐工作室旗下品牌网站,中国蓝狐工作室成立于2005年，成立之初是一家以网络开发、企业建站，产品推广，软件制作，影视宣传为主的高科技企业。服务的客户遍及政府机关、学校、事务所、医院以及包括工厂在内的各企事业单位，曾经服务的企业的有：临沂市政府网站，沂蒙晚报，新波浪传媒，山东华菱汽贸集团，所罗门策划公司，临沂市场信息网，江苏南通信息网，甘肃敦煌信息网，临沂友谊日化，山东大陆药业集团，中国视频在线，苍山清水湾房产，中国金银花网，中国三农产业网，文峰山网站，中国购物网，中国缘圈等多家。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　随着电子商务的发展，2006年公司涉足从事信息技术领域内的Internet网络服务和网络商业应用研究（包括电子商务、网络营销、网络广告、商业网站规划和网页设计等），面向政府机构、企事业单位和广大个人用户提供Internet和Intranet基础服务和增值服务。为迎合商业企业高端应用需求，公司作为一个“企业电子商务应用服务商”，致力于开发并提供企业对企业、企业对客户的业务平台，向中小型企业提供在线应用服务。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　快网科技(www.kuaiwww.com)作为在INTERNET域名注册、虚拟主机、服务器托管等一系列电子商务平台建设服务的业务网站， 与国内外各大服务商直接合作，以最优质的服务和高性能的产品推荐给广大客户。虚拟主机超市向客户承诺我们的服务和价格优势是同行中的佼佼者。域名实时在线 注册、虚拟主机、企业邮局自动开设、自助建站系统等国际领先的自主或专有技术，使企业可以在低成本、高效率、强保障的前提下建立自己的上网平台，从而大大 降低了企业信息化的门槛。&lt;/span&gt;&lt;br&gt;&lt;/p&gt;</p>', 1449593668, 1),
(4, 1, 0, '联通公司推出新套餐', '<p>&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;快网科技(www.kuaiwww.com)是中国蓝狐工作室旗下品牌网站,中国蓝狐工作室成立于2005年，成立之初是一家以网络开发、企业建站，产品推广，软件制作，影视宣传为主的高科技企业。服务的客户遍及政府机关、学校、事务所、医院以及包括工厂在内的各企事业单位，曾经服务的企业的有：临沂市政府网站，沂蒙晚报，新波浪传媒，山东华菱汽贸集团，所罗门策划公司，临沂市场信息网，江苏南通信息网，甘肃敦煌信息网，临沂友谊日化，山东大陆药业集团，中国视频在线，苍山清水湾房产，中国金银花网，中国三农产业网，文峰山网站，中国购物网，中国缘圈等多家。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　随着电子商务的发展，2006年公司涉足从事信息技术领域内的Internet网络服务和网络商业应用研究（包括电子商务、网络营销、网络广告、商业网站规划和网页设计等），面向政府机构、企事业单位和广大个人用户提供Internet和Intranet基础服务和增值服务。为迎合商业企业高端应用需求，公司作为一个“企业电子商务应用服务商”，致力于开发并提供企业对企业、企业对客户的业务平台，向中小型企业提供在线应用服务。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　快网科技(www.kuaiwww.com)作为在INTERNET域名注册、虚拟主机、服务器托管等一系列电子商务平台建设服务的业务网站， 与国内外各大服务商直接合作，以最优质的服务和高性能的产品推荐给广大客户。虚拟主机超市向客户承诺我们的服务和价格优势是同行中的佼佼者。域名实时在线 注册、虚拟主机、企业邮局自动开设、自助建站系统等国际领先的自主或专有技术，使企业可以在低成本、高效率、强保障的前提下建立自己的上网平台，从而大大 降低了企业信息化的门槛。&lt;/span&gt;</p>', 1449593723, 16),
(5, 1, 0, '与中国电信一起畅想未来', '<p>&lt;p&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;快网科技(www.kuaiwww.com)是中国蓝狐工作室旗下品牌网站,中国蓝狐工作室成立于2005年，成立之初是一家以网络开发、企业建站，产品推广，软件制作，影视宣传为主的高科技企业。服务的客户遍及政府机关、学校、事务所、医院以及包括工厂在内的各企事业单位，曾经服务的企业的有：临沂市政府网站，沂蒙晚报，新波浪传媒，山东华菱汽贸集团，所罗门策划公司，临沂市场信息网，江苏南通信息网，甘肃敦煌信息网，临沂友谊日化，山东大陆药业集团，中国视频在线，苍山清水湾房产，中国金银花网，中国三农产业网，文峰山网站，中国购物网，中国缘圈等多家。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　随着电子商务的发展，2006年公司涉足从事信息技术领域内的Internet网络服务和网络商业应用研究（包括电子商务、网络营销、网络广告、商业网站规划和网页设计等），面向政府机构、企事业单位和广大个人用户提供Internet和Intranet基础服务和增值服务。为迎合商业企业高端应用需求，公司作为一个“企业电子商务应用服务商”，致力于开发并提供企业对企业、企业对客户的业务平台，向中小型企业提供在线应用服务。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　快网科技(www.kuaiwww.com)作为在INTERNET域名注册、虚拟主机、服务器托管等一系列电子商务平台建设服务的业务网站， 与国内外各大服务商直接合作，以最优质的服务和高性能的产品推荐给广大客户。虚拟主机超市向客户承诺我们的服务和价格优势是同行中的佼佼者。域名实时在线 注册、虚拟主机、企业邮局自动开设、自助建站系统等国际领先的自主或专有技术，使企业可以在低成本、高效率、强保障的前提下建立自己的上网平台，从而大大 降低了企业信息化的门槛。&lt;/span&gt;&lt;br&gt;&lt;/p&gt;</p>', 1449593748, 2),
(6, 0, 0, '靓号限时特价出售', '', 1450341868, 0),
(11, 1, 2, '北京手机号配送说明', '<p>&lt;p&gt;同城配送：&lt;/p&gt;&lt;p&gt;异地发货：&lt;/p&gt;</p>', 1450455386, 0),
(12, 0, 1, '业务合作', '<p>&lt;p&gt;全站业务合作联系事宜&lt;/p&gt;</p>', 1450629904, 0),
(13, 0, 4, '如何网站购号？', '<p>&lt;p&gt;在网站购买号码时，请先挑选好所要购买的号码，然后联系客服，通过客服确认号码是否售出。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;如果号码未出售，请从网站下订单，按照网站的购号流程认真填写相关信息，以免出现不必要的错误。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;在收到订单后，客服会主动与您联系，在确认信息之后，就可以付款了，具体付款方式详见：支付方式。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;付款完成之后，提交客服需要的个人信息，方便给你办理业务，之后我们会尽快将手机卡邮寄到您手里。&lt;/p&gt;&lt;p&gt;您也可以参照：购号流程来完成购买。&lt;/p&gt;</p>', 1450631952, 0),
(14, 0, 4, '号码已售出？', '<p>&lt;p&gt;因为每个号码都是独一无二的，所以在碰到心仪的号码时就赶紧出手吧，晚一秒钟都有可能与您擦肩而过，而这样的错过可能就是永久的，所以，如果您心动了就快快行动起来吧。&lt;br&gt;&lt;/p&gt;</p>', 1450632003, 0),
(15, 0, 5, '如何开通', '<p>&lt;p&gt;如何开通&lt;br&gt;&lt;/p&gt;</p>', 1450633070, 0),
(16, 0, 5, '实行认证', '<p>&lt;p&gt;实行认证&lt;br&gt;&lt;/p&gt;</p>', 1450633091, 0),
(17, 0, 5, '套餐选择', '<p>&lt;p&gt;套餐选择&lt;br&gt;&lt;/p&gt;</p>', 1450633125, 0),
(18, 0, 6, '加急送货服务', '<p>&lt;p&gt;加急送货需要支付一定的送货费用，具体联系客服&lt;br&gt;&lt;/p&gt;</p>', 1450633333, 0),
(7, 1, 0, '买靓号就上北京靓号网', '<p>&lt;p&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;快网科技(www.kuaiwww.com)是中国蓝狐工作室旗下品牌网站,中国蓝狐工作室成立于2005年，成立之初是一家以网络开发、企业建站，产品推广，软件制作，影视宣传为主的高科技企业。服务的客户遍及政府机关、学校、事务所、医院以及包括工厂在内的各企事业单位，曾经服务的企业的有：临沂市政府网站，沂蒙晚报，新波浪传媒，山东华菱汽贸集团，所罗门策划公司，临沂市场信息网，江苏南通信息网，甘肃敦煌信息网，临沂友谊日化，山东大陆药业集团，中国视频在线，苍山清水湾房产，中国金银花网，中国三农产业网，文峰山网站，中国购物网，中国缘圈等多家。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　随着电子商务的发展，2006年公司涉足从事信息技术领域内的Internet网络服务和网络商业应用研究（包括电子商务、网络营销、网络广告、商业网站规划和网页设计等），面向政府机构、企事业单位和广大个人用户提供Internet和Intranet基础服务和增值服务。为迎合商业企业高端应用需求，公司作为一个“企业电子商务应用服务商”，致力于开发并提供企业对企业、企业对客户的业务平台，向中小型企业提供在线应用服务。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　快网科技(www.kuaiwww.com)作为在INTERNET域名注册、虚拟主机、服务器托管等一系列电子商务平台建设服务的业务网站， 与国内外各大服务商直接合作，以最优质的服务和高性能的产品推荐给广大客户。虚拟主机超市向客户承诺我们的服务和价格优势是同行中的佼佼者。域名实时在线 注册、虚拟主机、企业邮局自动开设、自助建站系统等国际领先的自主或专有技术，使企业可以在低成本、高效率、强保障的前提下建立自己的上网平台，从而大大 降低了企业信息化的门槛。&lt;/span&gt;&lt;br&gt;&lt;/p&gt;</p>', 1449593810, 10),
(8, 1, 0, '选择沃选择超越', '<p>&lt;p&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;快网科技(www.kuaiwww.com)是中国蓝狐工作室旗下品牌网站,中国蓝狐工作室成立于2005年，成立之初是一家以网络开发、企业建站，产品推广，软件制作，影视宣传为主的高科技企业。服务的客户遍及政府机关、学校、事务所、医院以及包括工厂在内的各企事业单位，曾经服务的企业的有：临沂市政府网站，沂蒙晚报，新波浪传媒，山东华菱汽贸集团，所罗门策划公司，临沂市场信息网，江苏南通信息网，甘肃敦煌信息网，临沂友谊日化，山东大陆药业集团，中国视频在线，苍山清水湾房产，中国金银花网，中国三农产业网，文峰山网站，中国购物网，中国缘圈等多家。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　随着电子商务的发展，2006年公司涉足从事信息技术领域内的Internet网络服务和网络商业应用研究（包括电子商务、网络营销、网络广告、商业网站规划和网页设计等），面向政府机构、企事业单位和广大个人用户提供Internet和Intranet基础服务和增值服务。为迎合商业企业高端应用需求，公司作为一个“企业电子商务应用服务商”，致力于开发并提供企业对企业、企业对客户的业务平台，向中小型企业提供在线应用服务。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　快网科技(www.kuaiwww.com)作为在INTERNET域名注册、虚拟主机、服务器托管等一系列电子商务平台建设服务的业务网站， 与国内外各大服务商直接合作，以最优质的服务和高性能的产品推荐给广大客户。虚拟主机超市向客户承诺我们的服务和价格优势是同行中的佼佼者。域名实时在线 注册、虚拟主机、企业邮局自动开设、自助建站系统等国际领先的自主或专有技术，使企业可以在低成本、高效率、强保障的前提下建立自己的上网平台，从而大大 降低了企业信息化的门槛。&lt;/span&gt;&lt;br&gt;&lt;/p&gt;</p>', 1449593838, 2),
(9, 1, 0, '中国移动带您提前体验4G时', '<p>&lt;p&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;快网科技(www.kuaiwww.com)是中国蓝狐工作室旗下品牌网站,中国蓝狐工作室成立于2005年，成立之初是一家以网络开发、企业建站，产品推广，软件制作，影视宣传为主的高科技企业。服务的客户遍及政府机关、学校、事务所、医院以及包括工厂在内的各企事业单位，曾经服务的企业的有：临沂市政府网站，沂蒙晚报，新波浪传媒，山东华菱汽贸集团，所罗门策划公司，临沂市场信息网，江苏南通信息网，甘肃敦煌信息网，临沂友谊日化，山东大陆药业集团，中国视频在线，苍山清水湾房产，中国金银花网，中国三农产业网，文峰山网站，中国购物网，中国缘圈等多家。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　随着电子商务的发展，2006年公司涉足从事信息技术领域内的Internet网络服务和网络商业应用研究（包括电子商务、网络营销、网络广告、商业网站规划和网页设计等），面向政府机构、企事业单位和广大个人用户提供Internet和Intranet基础服务和增值服务。为迎合商业企业高端应用需求，公司作为一个“企业电子商务应用服务商”，致力于开发并提供企业对企业、企业对客户的业务平台，向中小型企业提供在线应用服务。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　快网科技(www.kuaiwww.com)作为在INTERNET域名注册、虚拟主机、服务器托管等一系列电子商务平台建设服务的业务网站， 与国内外各大服务商直接合作，以最优质的服务和高性能的产品推荐给广大客户。虚拟主机超市向客户承诺我们的服务和价格优势是同行中的佼佼者。域名实时在线 注册、虚拟主机、企业邮局自动开设、自助建站系统等国际领先的自主或专有技术，使企业可以在低成本、高效率、强保障的前提下建立自己的上网平台，从而大大 降低了企业信息化的门槛。&lt;/span&gt;&lt;br&gt;&lt;/p&gt;</p>', 1449593858, 9),
(10, 1, 0, '热烈庆祝网站全新改版', '<p>&lt;p&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;快网科技(www.kuaiwww.com)是中国蓝狐工作室旗下品牌网站,中国蓝狐工作室成立于2005年，成立之初是一家以网络开发、企业建站，产品推广，软件制作，影视宣传为主的高科技企业。服务的客户遍及政府机关、学校、事务所、医院以及包括工厂在内的各企事业单位，曾经服务的企业的有：临沂市政府网站，沂蒙晚报，新波浪传媒，山东华菱汽贸集团，所罗门策划公司，临沂市场信息网，江苏南通信息网，甘肃敦煌信息网，临沂友谊日化，山东大陆药业集团，中国视频在线，苍山清水湾房产，中国金银花网，中国三农产业网，文峰山网站，中国购物网，中国缘圈等多家。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　随着电子商务的发展，2006年公司涉足从事信息技术领域内的Internet网络服务和网络商业应用研究（包括电子商务、网络营销、网络广告、商业网站规划和网页设计等），面向政府机构、企事业单位和广大个人用户提供Internet和Intranet基础服务和增值服务。为迎合商业企业高端应用需求，公司作为一个“企业电子商务应用服务商”，致力于开发并提供企业对企业、企业对客户的业务平台，向中小型企业提供在线应用服务。&lt;/span&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;br style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;&lt;span style="color: rgb(75, 75, 75); font-family: 微软雅黑, ''Arial Narrow''; font-size: 14px; line-height: 30px;"&gt;　 　快网科技(www.kuaiwww.com)作为在INTERNET域名注册、虚拟主机、服务器托管等一系列电子商务平台建设服务的业务网站， 与国内外各大服务商直接合作，以最优质的服务和高性能的产品推荐给广大客户。虚拟主机超市向客户承诺我们的服务和价格优势是同行中的佼佼者。域名实时在线 注册、虚拟主机、企业邮局自动开设、自助建站系统等国际领先的自主或专有技术，使企业可以在低成本、高效率、强保障的前提下建立自己的上网平台，从而大大 降低了企业信息化的门槛。&lt;/span&gt;&lt;br&gt;&lt;/p&gt;</p>', 1449593892, 12);

-- --------------------------------------------------------

--
-- 表的结构 `fox_pinpai`
--

DROP TABLE IF EXISTS `fox_pinpai`;

CREATE TABLE `fox_pinpai` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `pin_num` int(11) DEFAULT '0',
  `pin_city` tinyint(5) DEFAULT '0',
  `pin_tezheng` varchar(255) DEFAULT 'NULL',
  `pin_time` int(11) DEFAULT '0',
  `pin_type` tinyint(5) DEFAULT '0',
  `pin_title` varchar(50) DEFAULT 'NULL',
  `pin_shuxing` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pin_city` (`pin_city`),
  KEY `pin_num` (`pin_num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `fox_pinpai`
--

INSERT INTO `fox_pinpai` (`id`, `pin_num`, `pin_city`, `pin_tezheng`, `pin_time`, `pin_type`, `pin_title`) VALUES
(1, 11, 1, '0,2,5', 1448596522, 0, '神州行畅听卡'),
(2, 12, 1, '0,2,4,5', 1448596623, 0, '动感地带'),
(3, 201, 2, '0,2,5', 1448597636, 0, '动感地带'),
(4, 13, 1, '1,3,6', 1449082076, 0, '全球通');

-- --------------------------------------------------------

--
-- 表的结构 `fox_sys_menus`
--

DROP TABLE IF EXISTS `fox_sys_menus`;

CREATE TABLE `fox_sys_menus` (
  `id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(3) DEFAULT '0' COMMENT 'PID',
  `title` varchar(32) NOT NULL COMMENT 'Name',
  `url` varchar(32) NOT NULL COMMENT 'Controller',
  `group_type` varchar(255) NOT NULL DEFAULT '0' COMMENT 'Group',
  `ico` varchar(30) DEFAULT NULL COMMENT 'ICON',
  `remark` varchar(100) DEFAULT NULL COMMENT 'Remark',
  `ctime` int(11) DEFAULT '0' COMMENT 'Create time',
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT 'Sort',
  `mtype` int(3) NOT NULL DEFAULT '0' COMMENT 'Type',
  `mlock` int(3) NOT NULL DEFAULT '0' COMMENT 'Lock',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `mtype` (`mtype`),
  KEY `url` (`url`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- 转存表中的数据 `fox_sys_menus`
--

INSERT INTO `fox_sys_menus` (`id`, `pid`, `title`, `url`, `group_type`, `ico`, `remark`, `ctime`, `sort`, `mtype`, `mlock`) VALUES
(1, 0, '系统设置', 'admin/webset', '19,18', 'fa-anchor', 'fa-anchor', 1448268159, 0, 11, 1),
(2, 1, '通用配置', 'admin/webset/allset', '19', 'fa-circle-o', '', 1448079534, 0, 11, 1),
(3, 1, '主站设置', 'admin/webset/zhana', '19', 'fa-circle-o', '', 1448079551, 0, 11, 1),
(4, 1, '分站管理', 'admin/webset/zhanb', '19,18', 'fa-circle-o', '', 1448267927, 0, 11, 1),
(5, 1, '邮箱配置', 'admin/webset/email', '19', 'fa-circle-o', '', 1448079598, 0, 11, 1),
(6, 1, '支付设置', 'admin/webset/pay', '19', 'fa-circle-o', '', 1448079612, 0, 11, 1),
(7, 1, '短信接口', 'admin/webset/sms', '19', 'fa-circle-o', '', 1448079628, 0, 11, 1),
(8, 0, '会员管理', 'admin/users', '19,18,17', 'fa-user', '', 1448223490, 0, 11, 1),
(9, 8, '角色分组', 'admin/users/groups', '19', 'fa-circle-o', '', 1448196715, 0, 11, 1),
(10, 8, '管理人员', 'admin/users/lista', '19,18,17', 'fa-circle-o', '', 1448214232, 0, 11, 1),
(11, 0, '品牌管理', 'admin/pinpai', '19,18,17', 'fa-cog', '', 1448402667, 0, 11, 1),
(12, 4, '增加分站', 'admin/webset/zhanb_add', '19', 'fa-circle-o', '', 1448190938, 0, 12, 1),
(13, 4, '修改分站', 'admin/webset/zhanb_edit', '19,18', 'fa-circle-o', '', 1448267947, 0, 12, 1),
(14, 4, '删除分站', 'admin/webset/zhanb_del', '19', 'fa-circle-o', '', 1448191051, 0, 12, 1),
(15, 8, '普通会员', 'admin/users/listu', '19,18,17', 'fa-circle-o', '', 1448273767, 0, 11, 1),
(16, 10, '添加管理', 'admin/users/adda', '19,18,17', 'fa-circle-o', '', 1448214307, 0, 12, 1),
(17, 10, '修改管理', 'admin/users/edita', '19,18,17', 'fa-circle-o', '', 1448214415, 0, 12, 1),
(18, 10, '删除管理', 'admin/users/dela', '19,18,17', 'fa-circle-o', '', 1448214379, 0, 12, 1),
(19, 15, '会员增加', 'admin/users/addu', '19,18,17', 'fa-circle-o', '', 1448273745, 0, 12, 1),
(20, 15, '会员修改', 'admin/users/editu', '19,18,17', 'fa-circle-o', '', 1448273806, 0, 12, 1),
(21, 15, '会员删除', 'admin/users/delu', '19,18,17', 'fa-circle-o', '', 1448273846, 0, 12, 1),
(22, 9, '修改分组', 'admin/users/groupedit', '19', 'fa-circle-o', '', 1448285037, 0, 12, 1),
(23, 11, '品牌列表', 'admin/pinpai/listpp', '19,18,17', 'fa-circle-o', '', 1448581320, 0, 11, 1),
(24, 23, '增加品牌', 'admin/pinpai/add', '19,18,17', 'fa-circle-o', '', 1448402773, 0, 12, 1),
(25, 23, '修改品牌', 'admin/pinpai/edit', '19,18,17', 'fa-circle-o', '', 1448402801, 0, 12, 1),
(26, 23, '删除品牌', 'admin/pinpai/del', '19,18', 'fa-circle-o', '', 1448402827, 0, 12, 1),
(27, 0, '资费套餐', 'admin/zifei', '19,18,17', 'fa-cube', '', 1448603884, 0, 11, 1),
(28, 27, '资费中心', 'admin/zifei/listzf', '19,18,17', 'fa-circle-o', '', 1448603922, 0, 11, 1),
(29, 27, '套餐中心', 'admin/zifei/taocan', '19,18,17', 'fa-circle-o', '', 1448611599, 0, 11, 1),
(30, 28, '资费添加', 'admin/zifei/add', '19,18,17', 'fa-circle-o', '', 1448605902, 0, 12, 1),
(31, 28, '资费修改', 'admin/zifei/edit', '19,18,17', 'fa-circle-o', '', 1448605915, 0, 12, 1),
(32, 28, '资费删除', 'admin/zifei/del', '19,18,17', 'fa-circle-o', '', 1448605928, 0, 12, 1),
(33, 29, '套餐添加', 'admin/zifei/taocan_add', '19,18,17', 'fa-circle-o', '', 1448611626, 0, 12, 1),
(34, 29, '套餐修改', 'admin/zifei/taocan_edit', '19,18,17', 'fa-circle-o', '', 1448611642, 0, 12, 1),
(35, 29, '套餐删除', 'admin/zifei/taocan_del', '19,18,17', 'fa-circle-o', '', 1448611661, 0, 12, 1),
(36, 0, '管理号码', 'admin/haoma', '19,18,17,16', 'fa-phone-square', '', 1448629403, 0, 11, 1),
(37, 36, '号码列表', 'admin/haoma/haolist', '19,18,17,16', 'fa-circle-o', '', 1448629447, 0, 11, 1),
(38, 37, '添加号码', 'admin/haoma/add', '19,18,17,16', 'fa-circle-o', '', 1448630621, 0, 12, 1),
(39, 37, '编辑号码', 'admin/haoma/edit', '19,18,17,16', 'fa-circle-o', '', 1448630636, 0, 12, 1),
(40, 37, '删除号码', 'admin/haoma/del', '19,18,17,16', 'fa-circle-o', '', 1448630652, 0, 12, 1),
(41, 36, '已订号码', 'admin/haoma/listd', '19,18,17,16', 'fa-circle-o', '', 1448703917, 0, 11, 1),
(42, 36, '已售号码', 'admin/haoma/lists', '19,18,17,16', 'fa-circle-o', '', 1448703948, 0, 11, 1),
(43, 36, '批量删除', 'admin/haoma/delall', '19,18,17', 'fa-circle-o', '', 1448706223, 0, 11, 1),
(44, 36, '批量调整', 'admin/haoma/tiaozheng', '19,18,17,16', 'fa-circle-o', '', 1448706267, 0, 11, 1),
(45, 0, '导入导出', 'admin/daohao', '19,18,17,16', 'fa-exchange', '', 1448985332, 0, 11, 1),
(46, 45, '号码导入', 'admin/daohao/daoru', '19,18,17,16', 'fa-circle-o', '', 1448985368, 0, 11, 1),
(47, 45, '号码导出', 'admin/daohao/daochu', '19,18,17,16', 'fa-circle-o', '', 1448985392, 0, 11, 1),
(48, 1, '广告管理', 'admin/ads', '19,18,17', 'fa-picture-o', '', 1449328566, 0, 11, 1),
(49, 48, '广告添加', 'admin/ads/add', '19,18,17', 'fa-circle-o', '', 1449287228, 0, 12, 1),
(50, 48, '广告编辑', 'admin/ads/edit', '19,18,17', 'fa-circle-o', '', 1449287259, 0, 12, 1),
(51, 48, '广告删除', 'admin/ads/del', '19,18,17', 'fa-circle-o', '', 1449287285, 0, 12, 1),
(52, 1, '站内单页', 'admin/pages', '19,18,17', 'fa-circle-o', '', 1449328890, 0, 11, 1),
(53, 52, '单页添加', 'admin/pages/add', '19,18,17', 'fa-circle-o', '', 1449328941, 0, 12, 1),
(54, 52, '单页编辑', 'admin/pages/edit', '19,18,17', 'fa-circle-o', '', 1449328971, 0, 12, 1),
(55, 52, '单页删除', 'admin/pages/del', '19,18,17', 'fa-circle-o', '', 1449329004, 0, 12, 1),
(56, 0, '订单管理', 'admin/order', '19,18,17,16', 'fa-shopping-cart', '', 1449856285, 0, 11, 1),
(57, 56, '订单列表', 'admin/order/flist', '19,18,17,16', 'fa-circle-o', '', 1449856307, 0, 11, 1),
(58, 0, '客服问答', 'admin/question', '19,18,17,16', 'fa-comments-o', '', 1449856447, 0, 11, 1),
(59, 0, '资讯管理', 'admin/news', '19,18,17,16', 'fa-file-text-o', '', 1449856497, 0, 11, 1),
(60, 0, '二手交易', 'admin/xinxi', '19,18,17,16', 'fa-random', '', 1449856592, 0, 11, 1),
(61, 59, '资讯列表', 'admin/news/flist', '19,18,17,16', 'fa-circle-o', '', 1449885837, 0, 11, 1),
(62, 61, '资讯添加', 'admin/news/add', '19,18,17,16', 'fa-circle-o', '', 1449885869, 0, 12, 1),
(63, 61, '资讯编辑', 'admin/news/edit', '19,18,17,16', 'fa-circle-o', '', 1449885890, 0, 12, 1),
(65, 61, '资讯删除', 'admin/news/del', '19,18,17,16', 'fa-circle-o', '', 1449886051, 0, 12, 1),
(66, 60, '供求列表', 'admin/xinxi/flist', '19,18,17,16', 'fa-circle-o', '', 1449886191, 0, 11, 1),
(67, 66, '供求删除', 'admin/xinxi/del', '19,18,17,16', 'fa-circle-o', '', 1449886239, 0, 12, 1),
(68, 58, '问答列表', 'admin/question/flist', '19,18,17,16', 'fa-circle-o', '', 1449886292, 0, 11, 1),
(69, 68, '添加问答', 'admin/question/add', '19,18,17,16', 'fa-circle-o', '', 1449886312, 0, 12, 1),
(70, 68, '回复问答', 'admin/question/edit', '19,18,17,16', 'fa-circle-o', '', 1449886345, 0, 12, 1),
(71, 68, '删除问答', 'admin/question/del', '19,18,17,16', 'fa-circle-o', '', 1449886367, 0, 12, 1),
(72, 0, '导航菜单', 'memu', '10,19,18,17,16,5,4,3,2,1,0', 'fa-circle-o', '', 1449891438, 0, 10, 1),
(73, 72, '移动选号', 'haoma/yidong', '10,19,18,17,16,5,4,3,2,1,0', 'fa-circle-o', '', 1449891539, 0, 10, 1),
(74, 72, '联通选号', 'haoma/liantong', '10,19,18,17,16,5,4,3,2,1,0', 'fa-circle-o', '', 1449891594, 0, 10, 1),
(75, 72, '电信选号', 'haoma/dianxin', '10,19,18,17,16,5,4,3,2,1,0', 'fa-circle-o', '', 1449891713, 0, 10, 1),
(76, 72, '固话选号', 'haoma/guhua', '10,19,18,17,16,5,4,3,2,1,0', 'fa-circle-o', '', 1449891769, 0, 10, 1),
(77, 72, '400选号', 'haoma/othera', '10,19,18,17,16,5,4,3,2,1,0', 'fa-circle-o', '', 1449891890, 0, 10, 1),
(78, 0, '会员资料', 'member/edit', '5,4,3,2,1', 'fa-user', '', 1450193224, 0, 1, 1),
(79, 78, '完善资料', 'member/editme', '5,4,3,2,1', 'fa-circle-o', '', 1450203319, 0, 1, 1),
(80, 78, '密码修改', 'member/editpass', '5,4,3,2,1', 'fa-circle-o', '', 1450193309, 0, 1, 1),
(81, 78, '头像设置', 'member/editavatar', '5,4,3,2,1', 'fa-circle-o', '', 1450203380, 0, 1, 1),
(82, 0, '购物信息', 'member/gouwu', '4,3,2,1', 'fa-shopping-cart', '', 1450203883, 0, 1, 1),
(83, 82, '我的购物车', 'member/gouwuche', '4,3,2,1', 'fa-circle-o', '', 1450203772, 0, 1, 1),
(84, 82, '我的订单', 'member/gouwudd', '4,3,2,1', 'fa-circle-o', '', 1450203751, 0, 1, 1),
(85, 82, '我的积分', 'member/gouwufen', '4,3,2,1', 'fa-circle-o', '', 1450203801, 0, 1, 1),
(86, 82, '我的收藏', 'member/gouwusc', '4,3,2,1', 'fa-circle-o', '', 1450203827, 0, 1, 1),
(87, 0, '代理平台', 'member/daili', '5', 'fa-heart', '', 1450204008, 0, 1, 1),
(88, 87, '我的号码', 'member/dailihao', '5', 'fa-circle-o', '', 1450204034, 0, 1, 1),
(89, 88, '添加号码', 'member/dailiaddhao', '5', 'fa-circle-o', '', 1450204575, 0, 2, 1),
(90, 88, '编辑号码', 'member/dailiedithao', '5', 'fa-circle-o', '', 1450204592, 0, 2, 1),
(91, 88, '删除号码', 'member/dailidelhao', '5', 'fa-circle-o', '', 1450204609, 0, 2, 1),
(92, 87, '号码导入', 'member/dailiruhao', '5', 'fa-circle-o', '', 1450204641, 0, 1, 1),
(93, 87, '批量删除', 'member/dailidelallhao', '5', 'fa-circle-o', '', 1450204664, 0, 1, 1),
(94, 87, '已售号码', 'member/dailishouhao', '5', 'fa-circle-o', '', 1450204712, 0, 1, 1),
(95, 0, '客服咨询', 'member/kefu', '4,3,2,1', 'fa-comments-o', '', 1450204797, 0, 1, 1),
(96, 95, '添加咨询', 'member/kefuadd', '4,3,2,1', 'fa-circle-o', '', 1450204836, 0, 1, 1),
(97, 95, '我的咨询', 'member/kefulist', '4,3,2,1', 'fa-circle-o', '', 1450204865, 0, 1, 1),
(98, 0, '供求信息', 'member/xinxi', '5,4,3,2,1', 'fa-random', '', 1450204933, 0, 1, 1),
(99, 98, '发布信息', 'member/xinxiadd', '5,4,3,2,1', 'fa-circle-o', '', 1450204953, 0, 1, 1),
(100, 98, '我的信息', 'member/xinxilist', '5,4,3,2,1', 'fa-circle-o', '', 1450204973, 0, 1, 1),
(101, 56, '号码订制', 'admin/order/dingzhi', '19,18,17,16', 'fa-circle-o', '', 1450703783, 0, 11, 1),
(102, 101, '删除订制', 'admin/order/dingzhidel', '19,18,17,16', 'fa-circle-o', '', 1450703843, 0, 12, 1),
(103, 0, '站内统计', 'admin/tongji', '19,18,17,16', 'fa-line-chart', '', 1450900091, 0, 11, 1),
(104, 103, '订单操作', 'admin/tongji/dingdan', '19,18,17,16', 'fa-circle-o', '', 1450900128, 0, 11, 1),
(105, 103, '销售利润', 'admin/tongji/xiaoshou', '19,18,17', 'fa-circle-o', '', 1450900215, 0, 11, 1),
(106, 1, '平级分站', 'admin/webset/zhanp', '19', 'fa-circle-o', '', 1451244180, 0, 11, 1);


-- --------------------------------------------------------

--
-- 表的结构 `fox_taocan`
--

DROP TABLE IF EXISTS `fox_taocan`;

CREATE TABLE `fox_taocan` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `tc_type` tinyint(3) DEFAULT '0',
  `tc_city` tinyint(3) DEFAULT '0',
  `tc_title` varchar(100) DEFAULT 'NULL',
  `tc_content` text,
  `tc_time` int(11) DEFAULT '0',
  `tc_llcs` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tc_type` (`tc_type`),
  KEY `tc_city` (`tc_city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `fox_taocan`
--

INSERT INTO `fox_taocan` (`id`, `tc_type`, `tc_city`, `tc_title`, `tc_content`, `tc_time`, `tc_llcs`) VALUES
(4, 0, 1, '增加一个套餐', '<p>&lt;p&gt;&lt;/p&gt;&lt;p&gt;增加一个套餐&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;</p>', 1448626944, 0);

-- --------------------------------------------------------

--
-- 表的结构 `fox_users`
--

DROP TABLE IF EXISTS `fox_users`;

CREATE TABLE `fox_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(16) NOT NULL COMMENT 'UserName',
  `upassword` varchar(32) NOT NULL COMMENT 'PassWord',
  `salt` char(6) DEFAULT NULL COMMENT 'Salt',
  `openid` char(32) DEFAULT NULL COMMENT 'OpenID',
  `avatar` varchar(100) DEFAULT 'uploads/avatar/default/',
  `uemail` varchar(32) DEFAULT NULL COMMENT 'Email',
  `uemailrz` int(3) DEFAULT '0' COMMENT 'Emailrz',
  `uname` varchar(24) DEFAULT NULL COMMENT 'Name',
  `uzname` varchar(24) DEFAULT NULL COMMENT 'Zname',
  `uznamerz` int(3) DEFAULT '0' COMMENT 'Znamerz',
  `ucity` int(11) DEFAULT '0' COMMENT 'City',
  `utel` varchar(12) DEFAULT NULL COMMENT 'Tel',
  `utelrz` int(3) DEFAULT '0' COMMENT 'Telrz',
  `uqq` varchar(12) DEFAULT NULL COMMENT 'QQ',
  `udress` varchar(12) DEFAULT NULL COMMENT 'Dress',
  `ucredit` int(11) DEFAULT '0' COMMENT 'Credit',
  `umoney` int(11) DEFAULT '0' COMMENT 'Money',
  `uthemes` varchar(24) DEFAULT NULL COMMENT 'Themes',
  `uregtime` int(11) DEFAULT '0' COMMENT 'Reg time',
  `ulogtime` int(11) DEFAULT '0' COMMENT 'Reg time',
  `ucitys` varchar(250) DEFAULT NULL COMMENT 'City',
  `utype` int(3) DEFAULT '0' COMMENT 'Type',
  `ulock` int(3) DEFAULT '0' COMMENT 'Lock',
  `ugroup` int(3) DEFAULT '0' COMMENT 'Group',
  `ulognum` int(11) DEFAULT '0' COMMENT 'Lognum',
  `unums` decimal(10,1) DEFAULT '1.0' COMMENT 'Nums',
  `uregip` varchar(16) NOT NULL COMMENT 'IP addr',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `fox_users`
--

INSERT INTO `fox_users` (`userid`, `username`, `upassword`, `salt`, `openid`, `avatar`, `uemail`, `uname`, `uzname`, `ucity`, `utel`, `uqq`, `udress`, `ucredit`, `umoney`, `uthemes`, `uregtime`, `ulogtime`, `ucitys`, `utype`, `ulock`, `ugroup`, `ulognum`, `unums`, `uregip`) VALUES
(2, 'hezuo01', '2f0c8f6aa65ad1864d1f382063140194', 'f8f466', NULL, 'uploads/avatar/2/02/2_', 'hezuo@hezuo.com', '代理商', '', 1, '', '', '', 310, 0, NULL, 1448306723, 1450305148, NULL, 0, 0, 5, 5, '1.3', '127.0.0.1'),
(3, 'user01', '0e7494c214122c472352d5b1f353fb2f', '441714', NULL, 'uploads/avatar/default/', 'user@user.com', NULL, NULL, 0, NULL, NULL, NULL, 300, 0, NULL, 1448307460, 1448307460, NULL, 0, 0, 4, 0, '1.2', '127.0.0.1'),
(5, 'test01', '5513aeb456dda5bb761ed84e75b0ccaf', '14a0a7', NULL, 'uploads/avatar/default/', 'test@test.com', NULL, NULL, 1, NULL, NULL, NULL, 310, 0, NULL, 1448597025, 1448597025, NULL, 0, 0, 18, 0, '1.0', '127.0.0.1'),
(6, 'test02', 'bdf74b125eb21d98d703941d185e52ce', '8cbf21', NULL, 'uploads/avatar/default/', 'test@test02.com', NULL, NULL, 2, NULL, NULL, NULL, 308, 0, NULL, 1448597256, 1448597256, NULL, 0, 0, 18, 0, '1.0', '127.0.0.1'),
(7, '3088', '123456', NULL, NULL, 'uploads/avatar/default/', 'xxx@xxx.com', NULL, NULL, 1, NULL, NULL, NULL, 0, 0, NULL, 1449072950, 1449072950, NULL, 5, 0, 5, NULL, '1.3', '127.0.0.1'),
(9, 'kuaiwww', '26ed7065b7e090d180b0b7b4e1204dd8', '58c32e', NULL, 'uploads/avatar/default/', '', NULL, NULL, 5, NULL, NULL, NULL, 102, 0, 'default', 1450195413, 1450205089, NULL, 1, 0, 1, 1, '1.2', '112.95.100.78'),
(10, 'w2w2w2w2', '1abd473e133b6d9dfbc7cacae4919e2a', '39b60a', NULL, 'uploads/avatar/0/10/10_', '', NULL, NULL, 5, NULL, NULL, NULL, 112, 0, 'default', 1450200339, 1450340838, NULL, 1, 0, 1, 7, '1.2', '112.95.100.78');

-- --------------------------------------------------------

--
-- 表的结构 `fox_user_groups`
--

DROP TABLE IF EXISTS `fox_user_groups`;

CREATE TABLE `fox_user_groups` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `group_type` tinyint(3) NOT NULL DEFAULT '0',
  `group_name` varchar(50) DEFAULT NULL,
  `credit` int(11) DEFAULT '0',
  `zhekou` int(11) DEFAULT '0',
  `usernum` int(11) DEFAULT '0',
  PRIMARY KEY (`gid`,`group_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `fox_user_groups`
--

INSERT INTO `fox_user_groups` (`gid`, `group_type`, `group_name`, `credit`, `zhekou`, `usernum`) VALUES
(1, 19, '高级管理', 0, 100, 1),
(2, 18, '分站管理', 0, 100, 0),
(3, 17, '普通管理', 0, 100, 0),
(4, 16, '客服人员', 0, 100, 0),
(5, 5, '合作代理', 0, 80, 0),
(6, 4, '钻石会员', 100000, 85, 0),
(7, 3, '金牌会员', 50000, 90, 0),
(8, 2, '银牌会员', 10000, 95, 0),
(9, 1, '初级会员', 0, 100, 0);

-- --------------------------------------------------------

--
-- 表的结构 `fox_zifei`
--

DROP TABLE IF EXISTS `fox_zifei`;

CREATE TABLE `fox_zifei` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `zf_type` tinyint(3) DEFAULT '0',
  `zf_city` tinyint(3) DEFAULT '0',
  `zf_pinpai` int(11) DEFAULT '0',
  `zf_title` varchar(100) DEFAULT 'NULL',
  `zf_content` text,
  `zf_time` int(11) DEFAULT '0',
  `zf_llcs` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `zf_type` (`zf_type`),
  KEY `zf_city` (`zf_city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `fox_zifei`
--

INSERT INTO `fox_zifei` (`id`, `zf_type`, `zf_city`, `zf_pinpai`, `zf_title`, `zf_content`, `zf_time`, `zf_llcs`) VALUES
(3, 0, 2, 3, '移动全球通资费', '<p>&lt;p&gt;移动全球通资费&lt;br&gt;&lt;/p&gt;</p>', 1448619350, 0);