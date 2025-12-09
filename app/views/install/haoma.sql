#
# TABLE STRUCTURE FOR: fox_models
#

DROP TABLE IF EXISTS `fox_models`;

CREATE TABLE `fox_models` (
  `moid` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `motitle` varchar(16) NOT NULL COMMENT 'Title',
  `mourl` varchar(32) NOT NULL COMMENT 'URL',
  `moico` varchar(12) DEFAULT NULL COMMENT 'Icon',
  `moremark` varchar(30) NOT NULL COMMENT 'Remark',
  `motime` int(11) DEFAULT '0' COMMENT 'Create time',
  `moord` int(3) NOT NULL DEFAULT '0' COMMENT 'Ord',
  `molock` int(1) NOT NULL DEFAULT '0' COMMENT 'Lock',
  PRIMARY KEY (`moid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: fox_citys
#

DROP TABLE IF EXISTS `fox_citys`;

CREATE TABLE `fox_citys` (
  `cid` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cpid` int(3) NOT NULL DEFAULT '0' COMMENT 'PId',
  `ctitle` varchar(16) NOT NULL COMMENT 'Title',
  `cico` varchar(12) DEFAULT NULL COMMENT 'Icon',
  `ckeywords` varchar(100) NULL COMMENT 'Keywords',
  `cdescription` varchar(250) NULL COMMENT 'Description',
  `ctime` int(11) DEFAULT '0' COMMENT 'Create time',
  `cord` int(3) NOT NULL DEFAULT '0' COMMENT 'Ord',
  `clock` int(1) NOT NULL DEFAULT '0' COMMENT 'Lock',
  `cdomain` varchar(150) DEFAULT NULL COMMENT 'Domain',
  `clogo` varchar(250) DEFAULT NULL COMMENT 'Logo',
  `cnums` int(3) NOT NULL DEFAULT '0' COMMENT 'Nums',
  `cthemes` varchar(100) DEFAULT NULL COMMENT 'Themes',
  `cowner` varchar(100) DEFAULT NULL COMMENT 'Owner',
  `ctel` varchar(100) DEFAULT NULL COMMENT 'Tel',
  `cdress` varchar(100) DEFAULT NULL COMMENT 'Dress',
  PRIMARY KEY (`cid`,`cpid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: fox_login_log
#

DROP TABLE IF EXISTS `fox_login_log`;

CREATE TABLE `fox_login_log` (
  `loid` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `lotype` varchar(16) NOT NULL COMMENT 'Type',
  `louid` varchar(16) NOT NULL COMMENT 'User',
  `loip` varchar(16) NOT NULL COMMENT 'IP addr',
  `lotime` int(11) DEFAULT '0' COMMENT 'Login Time',
  `loagent` varchar(255) DEFAULT NULL COMMENT 'User Agent',
  PRIMARY KEY (`loid`,`louid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: fox_users
#

DROP TABLE IF EXISTS `fox_users`;

CREATE TABLE `fox_users` (
  `userid` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(16) NOT NULL COMMENT 'UserName',
  `upassword` varchar(32) NOT NULL COMMENT 'PassWord',
  `uemail` varchar(32) NOT NULL COMMENT 'Email',
  `uname` varchar(24) DEFAULT NULL COMMENT 'Name',
  `ucity` varchar(12) DEFAULT NULL COMMENT 'City',
  `utel` varchar(12) DEFAULT NULL COMMENT 'Tel',
  `uqq` varchar(12) DEFAULT NULL COMMENT 'QQ',
  `udress` varchar(12) DEFAULT NULL COMMENT 'Dress',
  `uregtime` int(11) DEFAULT '0' COMMENT 'Reg time',
  `ucity` text COMMENT 'City',
  `utype` int(3) DEFAULT '0' COMMENT 'Type',
  `ugroup` int(3) DEFAULT '0' COMMENT 'Group',
  `uperm` text COMMENT 'Authority',
  `uregip` varchar(16) NOT NULL COMMENT 'IP addr',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: fox_sys_menus
#

DROP TABLE IF EXISTS `fox_sys_menus`;

CREATE TABLE `fox_sys_menus` (
  `id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(3) NOT NULL COMMENT 'PID',
  `title` varchar(32) NOT NULL COMMENT 'Name',
  `url` varchar(32) NOT NULL COMMENT 'Controller',
  `ico` varchar(16) DEFAULT NULL COMMENT 'ICON',
  `remark` varchar(30) DEFAULT NULL COMMENT 'Remark',
  `ctime` int(11) DEFAULT '0' COMMENT 'Create time',
  `utype` int(3) DEFAULT '0' COMMENT 'Type',  
  `ugroup` int(3) DEFAULT '0' COMMENT 'Group',  
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT 'Sort',
  PRIMARY KEY (`id`,`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

