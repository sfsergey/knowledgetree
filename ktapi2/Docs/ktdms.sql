-- MySQL dump 10.11
--
-- Host: localhost    Database: ktdms_kt36
-- ------------------------------------------------------
-- Server version	5.0.41-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `active_sessions`
--

DROP TABLE IF EXISTS `active_sessions`;
CREATE TABLE `active_sessions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `session` varchar(100) NOT NULL,
  `user_member_id` int(11) NOT NULL,
  `start_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ip` int(10) unsigned NOT NULL,
  `is_webservice` tinyint(3) unsigned NOT NULL default '0',
  `activity_date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `active_sessions`
--

LOCK TABLES `active_sessions` WRITE;
/*!40000 ALTER TABLE `active_sessions` DISABLE KEYS */;
INSERT INTO `active_sessions` VALUES (23,'ac5119e485611ebbd268922289ba52ca',3865,'2008-06-16 21:10:15',2130706433,0,'2008-06-16 23:10:15'),(25,'be30e72c49435f876b7cb9f40d2ebec4',3865,'2008-06-16 21:11:28',2130706433,0,'2008-06-16 23:11:28'),(27,'14f025c273ae3fa8baddaf6a9a7968f9',3865,'2008-06-16 21:11:41',2130706433,0,'2008-06-16 23:11:41'),(31,'ba4042a90b4b409b02ed78755859474a',3891,'2008-06-16 21:12:48',2130706433,0,'2008-06-16 23:12:48'),(33,'9b4a91b4d5df97f219479342594ff77d',3891,'2008-06-16 21:13:07',2130706433,0,'2008-06-16 23:13:07'),(34,'9b4a91b4d5df97f219479342594ff77d',3892,'2008-06-16 21:13:18',2130706433,0,'2008-06-16 23:13:18'),(36,'4c71d07b2811407909cbf0eef4c94df6',3891,'2008-06-16 21:13:25',2130706433,0,'2008-06-16 23:13:25'),(40,'26056dc2fd40e333779a2a6253de2cbb',3917,'2008-06-16 21:13:45',2130706433,0,'2008-06-16 23:13:45'),(42,'390b7a780e8b585a6f605bb1dcb0810b',3917,'2008-06-16 21:14:11',2130706433,0,'2008-06-16 23:14:11'),(43,'390b7a780e8b585a6f605bb1dcb0810b',3918,'2008-06-16 21:14:13',2130706433,0,'2008-06-16 23:14:13'),(44,'b595bc4c14a42e5adf59b817933ae11a',3917,'2008-06-16 21:15:19',2130706433,0,'2008-06-16 23:15:19'),(48,'1c023f0875a45fe35986871b0f5464c5',3929,'2008-06-16 21:15:30',2130706433,0,'2008-06-16 23:15:30'),(49,'1c023f0875a45fe35986871b0f5464c5',3930,'2008-06-16 21:17:26',2130706433,0,'2008-06-16 23:17:26'),(51,'1936bd013c85360465d6aa4a5ef7903d',3955,'2008-06-16 21:17:33',2130706433,0,'2008-06-16 23:17:33'),(53,'b85ca3e1d2afe18344004a816cc0b591',3955,'2008-06-16 21:17:51',2130706433,0,'2008-06-16 23:17:51'),(55,'00db6ed5a7d427beb9da5e8b8de937a5',3955,'2008-06-16 21:18:19',2130706433,0,'2008-06-16 23:18:19'),(59,'c3aa0a524c13eae6aeb9b94fbea21b6d',3969,'2008-06-16 21:18:30',2130706433,0,'2008-06-16 23:18:30'),(61,'010e7d31475ab28996bf3ac913eae007',3969,'2008-06-16 21:18:39',2130706433,0,'2008-06-16 23:18:39'),(63,'e9c3d0bf9db758f3b03146ccdae69076',3969,'2008-06-16 21:18:46',2130706433,0,'2008-06-16 23:18:46'),(67,'e1e024e5f7133c2031d46b4564b0dfb1',3980,'2008-06-16 21:19:28',2130706433,0,'2008-06-16 23:19:28'),(69,'a91f15b30de551219f6201aef1feff13',3980,'2008-06-16 21:20:06',2130706433,0,'2008-06-16 23:20:06'),(71,'28df17d981341e631b64a7606c9f0167',4005,'2008-06-16 21:23:57',2130706433,0,'2008-06-16 23:23:57'),(73,'4f30d2d790b98b4ceceeb2289cedf865',4030,'2008-06-16 21:24:23',2130706433,0,'2008-06-16 23:24:23'),(75,'6c5c516b73d4ffb6f8800d85275abcfb',4055,'2008-06-16 21:24:29',2130706433,0,'2008-06-16 23:24:29'),(77,'8184fb3d4743b2789f1aef1e410a86ee',4080,'2008-06-16 21:24:37',2130706433,0,'2008-06-16 23:24:37'),(79,'3214313d1e8d742b5289ae3958fcb6d0',4105,'2008-06-16 21:24:40',2130706433,0,'2008-06-16 23:24:40'),(81,'1a291f82632527a6713b4dbe5910b875',4130,'2008-06-16 21:24:47',2130706433,0,'2008-06-16 23:24:47'),(83,'6d401fe4626227943423c8fa47861096',4155,'2008-06-16 21:25:21',2130706433,0,'2008-06-16 23:25:21'),(85,'6d9f20d808d05b802cf63ba3d7818724',4180,'2008-06-16 21:30:54',2130706433,0,'2008-06-16 23:30:54'),(87,'e2a6a75a6d234901bc958f8b4517ab4e',4205,'2008-06-16 22:17:27',2130706433,0,'2008-06-17 00:17:27'),(89,'f20d90492343ed6f6f70cf87151f4fc9',4205,'2008-06-16 22:19:08',2130706433,0,'2008-06-17 00:19:08'),(91,'e8a8f797b3ae233f6a6e655167f584f0',4205,'2008-06-16 22:20:10',2130706433,0,'2008-06-17 00:20:10'),(99,'b1a2970edc35d36644e54ff8bbe7a71e',4231,'2008-06-16 22:21:01',2130706433,0,'2008-06-17 00:21:01'),(101,'82b2143984c23ffa2e5ce4dd3595aa4b',4231,'2008-06-16 22:21:39',2130706433,0,'2008-06-17 00:21:39'),(103,'077a87dd9ba8e84ba532ce2c0ad22713',4231,'2008-06-16 22:21:50',2130706433,0,'2008-06-17 00:21:50');
/*!40000 ALTER TABLE `active_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `active_users`
--

DROP TABLE IF EXISTS `active_users`;
/*!50001 DROP VIEW IF EXISTS `active_users`*/;
/*!50001 CREATE TABLE `active_users` (
  `member_id` int(11),
  `username` varchar(100),
  `name` varchar(100),
  `email` varchar(100),
  `mobile` varchar(20),
  `language_id` char(2),
  `last_login_date` datetime,
  `invalid_login` tinyint(4),
  `timezone` float,
  `status` enum('Enabled','Disabled','Deleted'),
  `auth_source_id` int(10) unsigned,
  `auth_config` mediumtext,
  `created_date` timestamp
) */;

--
-- Table structure for table `authentication_source_groups`
--

DROP TABLE IF EXISTS `authentication_source_groups`;
CREATE TABLE `authentication_source_groups` (
  `auth_source_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'group name on authentication source',
  `member_group_id` int(10) unsigned NOT NULL COMMENT 'local group name',
  `configuration` mediumtext NOT NULL COMMENT 'any configuration that may assist to identify the authentication sources group'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authentication_source_groups`
--

LOCK TABLES `authentication_source_groups` WRITE;
/*!40000 ALTER TABLE `authentication_source_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `authentication_source_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authentication_sources`
--

DROP TABLE IF EXISTS `authentication_sources`;
CREATE TABLE `authentication_sources` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `auth_module_namespace` varchar(100) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `auth_config` mediumtext NOT NULL,
  `status` enum('Enabled','Disabled','Deleted') NOT NULL,
  `is_system` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `authentication_sources`
--

LOCK TABLES `authentication_sources` WRITE;
/*!40000 ALTER TABLE `authentication_sources` DISABLE KEYS */;
INSERT INTO `authentication_sources` VALUES (15,'authentication.provider.hashed.password.plugin.core','Hashed Authentication Source','a:1:{s:9:\"is_system\";b:1;}','Enabled',0);
/*!40000 ALTER TABLE `authentication_sources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `cache_namespace` varchar(100) NOT NULL,
  `cache_id` int(11) NOT NULL,
  `cache_date` mediumtext NOT NULL,
  PRIMARY KEY  (`cache_namespace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complex_conditional_data`
--

DROP TABLE IF EXISTS `complex_conditional_data`;
CREATE TABLE `complex_conditional_data` (
  `complex_condition_id` int(11) default NULL,
  `effect_member_id` int(11) NOT NULL COMMENT 'results in this field chaning',
  `parent_data_id` int(10) unsigned NOT NULL COMMENT 'it looks for all data matching this parent_data_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `complex_conditional_data`
--

LOCK TABLES `complex_conditional_data` WRITE;
/*!40000 ALTER TABLE `complex_conditional_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `complex_conditional_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complex_conditions`
--

DROP TABLE IF EXISTS `complex_conditions`;
CREATE TABLE `complex_conditions` (
  `documenttype_member_id` int(11) default NULL,
  `condition_id` int(11) default NULL,
  `id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `complex_conditions`
--

LOCK TABLES `complex_conditions` WRITE;
/*!40000 ALTER TABLE `complex_conditions` DISABLE KEYS */;
/*!40000 ALTER TABLE `complex_conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conditional_data`
--

DROP TABLE IF EXISTS `conditional_data`;
CREATE TABLE `conditional_data` (
  `field_member_id` int(11) NOT NULL COMMENT 'user selects this field',
  `to_data_id` int(10) unsigned NOT NULL COMMENT 'they enter this value',
  `effect_member_id` int(11) NOT NULL COMMENT 'results in this field chaning',
  `parent_data_id` int(10) unsigned NOT NULL COMMENT 'it looks for all data matching this parent_data_id',
  `documenttype_member_id` int(11) default NULL COMMENT 'could the behaviour be specific to a document type',
  `unit_member_id` int(11) default NULL COMMENT 'could the behaviour be linked to a unit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `conditional_data`
--

LOCK TABLES `conditional_data` WRITE;
/*!40000 ALTER TABLE `conditional_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `conditional_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `config_namespace` varchar(100) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `value` varchar(100) default NULL,
  `default` varchar(100) default NULL,
  `can_edit` tinyint(4) NOT NULL default '1',
  `type` enum('string','int','bool','enum') NOT NULL default 'string',
  `type_config` varchar(1024) default NULL,
  `config_group_id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'session.max','Maximum Sessions','3','3',1,'string',NULL,0,''),(3,'invalid.password.threshold','Invalid Password Count','3','3',1,'int',NULL,0,''),(4,'invalid.password.threshold.action','Invalid Password Threshold Action','disable','disable',1,'enum','allow, disable, alert',0,''),(5,'smtp.host','Host','localhost',NULL,1,'string',NULL,0,''),(6,'smtp.port','Port','25',NULL,1,'int',NULL,0,''),(7,'smtp.username','Authentication Username',NULL,NULL,1,'string',NULL,0,''),(8,'smtp.password','Authentication Password',NULL,NULL,1,'string',NULL,0,''),(9,'smtp.ssl','Enable SSL','false',NULL,1,'bool',NULL,0,''),(11,'language.default','Default Language','EN','EN',1,'string',NULL,0,''),(12,'session.timeout','Session Timeout (minutes)','10','10',1,'int',NULL,0,''),(13,'session.allow.anonymous','Allow Anonymous Users','false','false',1,'bool','',0,''),(92,'timezone.default','Default Timezone','0','0',1,'int',NULL,0,''),(177,'session.webservice.timeout','Webservice Session Timeout (minutes)','30','30',1,'int',NULL,0,''),(178,'session.webservice.max','Maximum Webservice Sessions','3','3',1,'int',NULL,0,''),(450,'my.test','Test','Value',NULL,1,'string',NULL,446,'');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_groups`
--

DROP TABLE IF EXISTS `config_groups`;
CREATE TABLE `config_groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `display_name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `group_namespace` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `config_groups`
--

LOCK TABLES `config_groups` WRITE;
/*!40000 ALTER TABLE `config_groups` DISABLE KEYS */;
INSERT INTO `config_groups` VALUES (4,'stuff','stuff','gen.t'),(446,'stuff','stuff','group.test');
/*!40000 ALTER TABLE `config_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE `data` (
  `id` int(11) NOT NULL auto_increment,
  `data_member_id` int(10) unsigned NOT NULL,
  `displayValue` varchar(255) NOT NULL,
  `storageValue` varchar(255) default NULL,
  `parent_data_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `data`
--

LOCK TABLES `data` WRITE;
/*!40000 ALTER TABLE `data` DISABLE KEYS */;
INSERT INTO `data` VALUES (1,188,'Africa',NULL,NULL),(2,188,'Europe',NULL,NULL),(3,188,'South Africa','ZA',1),(4,188,'United Kingdom','UK',2);
/*!40000 ALTER TABLE `data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_content_version`
--

DROP TABLE IF EXISTS `document_content_version`;
CREATE TABLE `document_content_version` (
  `id` int(11) NOT NULL default '0',
  `document_id` int(11) NOT NULL default '0',
  `filename` text NOT NULL,
  `size` bigint(20) NOT NULL default '0',
  `mime_type_id` int(11) default '9',
  `storage_config` mediumtext NOT NULL,
  `storage_location_id` int(11) NOT NULL,
  `md5hash` char(32) default NULL,
  PRIMARY KEY  (`id`),
  KEY `document_id_idx` (`document_id`),
  CONSTRAINT `document_content_version_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `document_content_version`
--

LOCK TABLES `document_content_version` WRITE;
/*!40000 ALTER TABLE `document_content_version` DISABLE KEYS */;
INSERT INTO `document_content_version` VALUES (1,1,'boo',0,9,'',0,NULL);
/*!40000 ALTER TABLE `document_content_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_metadata_content_versions`
--

DROP TABLE IF EXISTS `document_metadata_content_versions`;
CREATE TABLE `document_metadata_content_versions` (
  `metadata_version_id` int(10) unsigned NOT NULL,
  `content_version_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`metadata_version_id`,`content_version_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `document_metadata_content_versions`
--

LOCK TABLES `document_metadata_content_versions` WRITE;
/*!40000 ALTER TABLE `document_metadata_content_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_metadata_content_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_metadata_version`
--

DROP TABLE IF EXISTS `document_metadata_version`;
CREATE TABLE `document_metadata_version` (
  `node_metadata_version_id` int(11) NOT NULL default '0',
  `document_type_id` int(11) NOT NULL default '0',
  `workflow_state_id` int(11) default NULL,
  `custom_doc_no` varchar(255) NOT NULL,
  `version` float NOT NULL default '0.1',
  `workflow_state_start_date` datetime default NULL,
  PRIMARY KEY  (`node_metadata_version_id`),
  KEY `document_type_id` (`document_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `document_metadata_version`
--

LOCK TABLES `document_metadata_version` WRITE;
/*!40000 ALTER TABLE `document_metadata_version` DISABLE KEYS */;
INSERT INTO `document_metadata_version` VALUES (1,1,NULL,'',0.1,NULL);
/*!40000 ALTER TABLE `document_metadata_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `document_types`
--

DROP TABLE IF EXISTS `document_types`;
/*!50001 DROP VIEW IF EXISTS `document_types`*/;
/*!50001 CREATE TABLE `document_types` (
  `member_id` int(11),
  `name` text,
  `status` enum('Enabled','Disabled','Deleted'),
  `unit_id` int(11)
) */;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL default '0',
  `creator_id` int(11) default NULL,
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `folder_id` int(11) default NULL,
  `is_checked_out` tinyint(4) NOT NULL default '0',
  `parent_folder_ids` text,
  `full_path` text,
  `checked_out_user_id` int(11) default NULL,
  `status_id` int(11) default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `permission_object_id` int(11) default NULL,
  `permission_lookup_id` int(11) default NULL,
  `metadata_version` int(11) NOT NULL default '0',
  `modified_user_id` int(11) default NULL,
  `metadata_version_id` int(11) default NULL,
  `owner_id` int(11) default NULL,
  `immutable` tinyint(4) NOT NULL default '0',
  `restore_folder_id` int(11) default NULL,
  `restore_folder_path` text,
  `checkedout` datetime default NULL,
  `oem_no` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `folder_id_idx` (`folder_id`),
  KEY `metadata_version_id_idx` (`metadata_version_id`),
  CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (1,1,'0000-00-00 00:00:00',1,0,NULL,'boo',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL,0,NULL,1,NULL,0,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE `email_templates` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `namespace` varchar(100) NOT NULL,
  `lang_id` char(2) NOT NULL default 'EN',
  `subject` varchar(100) NOT NULL,
  `body` mediumtext NOT NULL,
  `html_body` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `email_templates`
--

LOCK TABLES `email_templates` WRITE;
/*!40000 ALTER TABLE `email_templates` DISABLE KEYS */;
INSERT INTO `email_templates` VALUES (1,'email.account.created.user','EN','','',''),(2,'email.account.created.admin','EN','','',''),(3,'email.account.disabled','EN','','',''),(4,'email.account.logon.failure.alert','EN','','',''),(5,'email.account.created','EN','','',''),(6,'email.account.disabled.user','EN','','',''),(7,'email.account.disabled.admin','EN','','',''),(8,'email.account.logon.failure.alert.user','EN','','',''),(9,'email.account.logon.failure.alert.admin','EN','','','');
/*!40000 ALTER TABLE `email_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `fields`
--

DROP TABLE IF EXISTS `fields`;
/*!50001 DROP VIEW IF EXISTS `fields`*/;
/*!50001 CREATE TABLE `fields` (
  `member_id` int(11),
  `name` text,
  `status` enum('Enabled','Disabled','Deleted'),
  `unit_id` int(11)
) */;

--
-- Temporary table structure for view `fieldsets`
--

DROP TABLE IF EXISTS `fieldsets`;
/*!50001 DROP VIEW IF EXISTS `fieldsets`*/;
/*!50001 CREATE TABLE `fieldsets` (
  `member_id` int(11),
  `name` text,
  `status` enum('Enabled','Disabled','Deleted'),
  `unit_id` int(11)
) */;

--
-- Table structure for table `folders`
--

DROP TABLE IF EXISTS `folders`;
CREATE TABLE `folders` (
  `id` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `parent_id` int(11) default NULL,
  `creator_id` int(11) default NULL,
  `is_public` tinyint(4) NOT NULL default '0',
  `parent_folder_ids` text,
  `full_path` text,
  `permission_object_id` int(11) default NULL,
  `permission_lookup_id` int(11) default NULL,
  `restrict_document_types` tinyint(4) NOT NULL default '0',
  `owner_id` int(11) default NULL,
  `depth` int(10) unsigned NOT NULL,
  `workflow_id` int(10) unsigned default NULL,
  `document_type_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `parent_id_idx` (`parent_id`),
  CONSTRAINT `folders_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `folders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `folders`
--

LOCK TABLES `folders` WRITE;
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
INSERT INTO `folders` VALUES (1,'Root Folder','Root Folder',NULL,1,0,NULL,NULL,1,1,0,1,0,NULL,NULL),(2,'Invoice','Invoices',1,1,0,'1','invoice',1,1,0,1,1,NULL,NULL);
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grouping_properties`
--

DROP TABLE IF EXISTS `grouping_properties`;
CREATE TABLE `grouping_properties` (
  `grouping_member_id` int(11) NOT NULL,
  `property_namespace` varchar(100) NOT NULL,
  `value` mediumtext NOT NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `grouping_member_id` (`grouping_member_id`,`property_namespace`),
  CONSTRAINT `FK_grouping_properties` FOREIGN KEY (`grouping_member_id`) REFERENCES `groupings` (`member_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `grouping_properties`
--

LOCK TABLES `grouping_properties` WRITE;
/*!40000 ALTER TABLE `grouping_properties` DISABLE KEYS */;
INSERT INTO `grouping_properties` VALUES (4232,'grouping.property.system.administrator.plugin.core','b:1;',100);
/*!40000 ALTER TABLE `grouping_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupings`
--

DROP TABLE IF EXISTS `groupings`;
CREATE TABLE `groupings` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` enum('Group','Role','Unit','Fieldset','Field','DocumentType','Data','DataTree') NOT NULL,
  `properties` mediumtext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `member_id_idx` (`member_id`),
  CONSTRAINT `groupings_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groupings`
--

LOCK TABLES `groupings` WRITE;
/*!40000 ALTER TABLE `groupings` DISABLE KEYS */;
INSERT INTO `groupings` VALUES (2523,4227,'Default Type','DocumentType',''),(2524,4228,'Invoice','Fieldset',''),(2525,4229,'Invoice No','Field',''),(2526,4230,'Invoice Date','Field',''),(2527,4232,'sysadmin group','Group','');
/*!40000 ALTER TABLE `groupings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!50001 DROP VIEW IF EXISTS `groups`*/;
/*!50001 CREATE TABLE `groups` (
  `member_id` int(11),
  `name` text,
  `status` enum('Enabled','Disabled','Deleted'),
  `unit_id` int(11)
) */;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` char(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES ('EN','English');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_effective_users`
--

DROP TABLE IF EXISTS `member_effective_users`;
CREATE TABLE `member_effective_users` (
  `member_id` int(11) NOT NULL,
  `user_member_id` int(11) NOT NULL,
  PRIMARY KEY  (`member_id`,`user_member_id`),
  KEY `FK_member_effective_users2` (`user_member_id`),
  CONSTRAINT `FK_member_effective_users1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_member_effective_users2` FOREIGN KEY (`user_member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `member_effective_users`
--

LOCK TABLES `member_effective_users` WRITE;
/*!40000 ALTER TABLE `member_effective_users` DISABLE KEYS */;
INSERT INTO `member_effective_users` VALUES (4232,4231);
/*!40000 ALTER TABLE `member_effective_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_submembers`
--

DROP TABLE IF EXISTS `member_submembers`;
CREATE TABLE `member_submembers` (
  `member_id` int(11) NOT NULL,
  `submember_id` int(11) NOT NULL,
  PRIMARY KEY  (`member_id`,`submember_id`),
  KEY `FK_member_submembers2` (`submember_id`),
  CONSTRAINT `FK_member_submembers1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_member_submembers2` FOREIGN KEY (`submember_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member_submembers`
--

LOCK TABLES `member_submembers` WRITE;
/*!40000 ALTER TABLE `member_submembers` DISABLE KEYS */;
INSERT INTO `member_submembers` VALUES (4227,4228),(4228,4229),(4228,4230),(4232,4231);
/*!40000 ALTER TABLE `member_submembers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(11) NOT NULL auto_increment,
  `member_type` enum('Group','User','Role','Unit','DocumentType','Fieldset','Field','Data','DataTree') NOT NULL,
  `status` enum('Enabled','Disabled','Deleted') NOT NULL default 'Enabled',
  `node_id` int(11) default NULL,
  `unit_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (4227,'DocumentType','Enabled',NULL,NULL),(4228,'Fieldset','Enabled',NULL,NULL),(4229,'Field','Deleted',NULL,NULL),(4230,'Field','Enabled',NULL,NULL),(4231,'User','Enabled',NULL,NULL),(4232,'Group','Enabled',NULL,NULL);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_version`
--

DROP TABLE IF EXISTS `migration_version`;
CREATE TABLE `migration_version` (
  `version` int(11) default NULL,
  `context` varchar(100) default NULL,
  KEY `context_idx` (`context`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration_version`
--

LOCK TABLES `migration_version` WRITE;
/*!40000 ALTER TABLE `migration_version` DISABLE KEYS */;
INSERT INTO `migration_version` VALUES (2,'plugin.testdiff'),(1,'plugin.test');
/*!40000 ALTER TABLE `migration_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mime_extensions`
--

DROP TABLE IF EXISTS `mime_extensions`;
CREATE TABLE `mime_extensions` (
  `extension` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mime_type_id` int(11) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mime_extensions`
--

LOCK TABLES `mime_extensions` WRITE;
/*!40000 ALTER TABLE `mime_extensions` DISABLE KEYS */;
/*!40000 ALTER TABLE `mime_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mime_groupings`
--

DROP TABLE IF EXISTS `mime_groupings`;
CREATE TABLE `mime_groupings` (
  `mime_type_id` int(10) unsigned NOT NULL,
  `mime_group_member_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mime_groupings`
--

LOCK TABLES `mime_groupings` WRITE;
/*!40000 ALTER TABLE `mime_groupings` DISABLE KEYS */;
/*!40000 ALTER TABLE `mime_groupings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mime_types`
--

DROP TABLE IF EXISTS `mime_types`;
CREATE TABLE `mime_types` (
  `id` int(10) unsigned NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `group_id` int(10) unsigned default NULL,
  `extractor_namespace` int(10) unsigned default NULL,
  `icon` varchar(100) NOT NULL,
  `mime_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mime_types`
--

LOCK TABLES `mime_types` WRITE;
/*!40000 ALTER TABLE `mime_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `mime_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `named_conditions`
--

DROP TABLE IF EXISTS `named_conditions`;
CREATE TABLE `named_conditions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `expression` mediumtext NOT NULL,
  `type` enum('DynamicCondition','SavedSearch','ComplexConditionalMetadata') NOT NULL,
  `user_member_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `named_conditions`
--

LOCK TABLES `named_conditions` WRITE;
/*!40000 ALTER TABLE `named_conditions` DISABLE KEYS */;
INSERT INTO `named_conditions` VALUES (1,'Immutable Documents','IsImmutable','DynamicCondition',0);
/*!40000 ALTER TABLE `named_conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node_discussion_comments`
--

DROP TABLE IF EXISTS `node_discussion_comments`;
CREATE TABLE `node_discussion_comments` (
  `id` int(11) NOT NULL,
  `node_discussion_thread_id` int(11) NOT NULL,
  `user_member_id` int(11) NOT NULL,
  `subject` mediumtext,
  `body` mediumtext,
  `added_date` datetime default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `node_discussion_comments`
--

LOCK TABLES `node_discussion_comments` WRITE;
/*!40000 ALTER TABLE `node_discussion_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `node_discussion_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node_discussion_threads`
--

DROP TABLE IF EXISTS `node_discussion_threads`;
CREATE TABLE `node_discussion_threads` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `node_id` int(10) unsigned NOT NULL,
  `user_member_id` int(11) NOT NULL,
  `subject` mediumtext NOT NULL,
  `added_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `views` int(10) unsigned NOT NULL default '0',
  `replies` int(10) unsigned NOT NULL default '0',
  `status` enum('Enabled','Disabled','Deleted') NOT NULL default 'Enabled',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `node_discussion_threads`
--

LOCK TABLES `node_discussion_threads` WRITE;
/*!40000 ALTER TABLE `node_discussion_threads` DISABLE KEYS */;
/*!40000 ALTER TABLE `node_discussion_threads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node_dynamic_permissions`
--

DROP TABLE IF EXISTS `node_dynamic_permissions`;
CREATE TABLE `node_dynamic_permissions` (
  `node_id` int(11) default NULL,
  `group_id` int(11) default NULL,
  `dynamic_condition_id` int(11) default NULL,
  `permission_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `node_dynamic_permissions`
--

LOCK TABLES `node_dynamic_permissions` WRITE;
/*!40000 ALTER TABLE `node_dynamic_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `node_dynamic_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node_member_permissions`
--

DROP TABLE IF EXISTS `node_member_permissions`;
CREATE TABLE `node_member_permissions` (
  `node_id` int(11) default NULL,
  `member_id` int(11) default NULL,
  `permission_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `node_member_permissions`
--

LOCK TABLES `node_member_permissions` WRITE;
/*!40000 ALTER TABLE `node_member_permissions` DISABLE KEYS */;
INSERT INTO `node_member_permissions` VALUES (1,4,5);
/*!40000 ALTER TABLE `node_member_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node_metadata_field_values`
--

DROP TABLE IF EXISTS `node_metadata_field_values`;
CREATE TABLE `node_metadata_field_values` (
  `metadata_version_id` int(10) unsigned NOT NULL,
  `field_member_id` int(11) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY  (`metadata_version_id`,`field_member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `node_metadata_field_values`
--

LOCK TABLES `node_metadata_field_values` WRITE;
/*!40000 ALTER TABLE `node_metadata_field_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `node_metadata_field_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node_metadata_versions`
--

DROP TABLE IF EXISTS `node_metadata_versions`;
CREATE TABLE `node_metadata_versions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `node_id` int(10) unsigned NOT NULL,
  `name` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(4) NOT NULL,
  `metadata_version` mediumint(9) NOT NULL default '0',
  `created_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_node_metadata_versions` (`node_id`),
  KEY `FK_node_metadata_versions2` (`created_by_id`),
  CONSTRAINT `FK_node_metadata_versions` FOREIGN KEY (`node_id`) REFERENCES `nodes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `node_metadata_versions`
--

LOCK TABLES `node_metadata_versions` WRITE;
/*!40000 ALTER TABLE `node_metadata_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `node_metadata_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node_relations`
--

DROP TABLE IF EXISTS `node_relations`;
CREATE TABLE `node_relations` (
  `node_id` int(10) unsigned NOT NULL,
  `related_node_id` int(10) unsigned NOT NULL,
  `relation_type` enum('Related To','Depends On') default NULL,
  PRIMARY KEY  (`node_id`,`related_node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `node_relations`
--

LOCK TABLES `node_relations` WRITE;
/*!40000 ALTER TABLE `node_relations` DISABLE KEYS */;
/*!40000 ALTER TABLE `node_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node_subscriptions`
--

DROP TABLE IF EXISTS `node_subscriptions`;
CREATE TABLE `node_subscriptions` (
  `node_id` int(10) unsigned NOT NULL,
  `user_member_id` int(11) NOT NULL,
  PRIMARY KEY  (`node_id`,`user_member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `node_subscriptions`
--

LOCK TABLES `node_subscriptions` WRITE;
/*!40000 ALTER TABLE `node_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `node_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node_tags`
--

DROP TABLE IF EXISTS `node_tags`;
CREATE TABLE `node_tags` (
  `node_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`node_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `node_tags`
--

LOCK TABLES `node_tags` WRITE;
/*!40000 ALTER TABLE `node_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `node_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nodes`
--

DROP TABLE IF EXISTS `nodes`;
CREATE TABLE `nodes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_node_id` int(10) unsigned default NULL,
  `full_path` mediumtext NOT NULL,
  `node_type` enum('Document','Folder','Shortcut') NOT NULL,
  `permission_node_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `nodes`
--

LOCK TABLES `nodes` WRITE;
/*!40000 ALTER TABLE `nodes` DISABLE KEYS */;
INSERT INTO `nodes` VALUES (1,NULL,'','Folder',1,0),(2,1,'invoices','Folder',1,0),(3,2,'invoices/jamwarehouse','Folder',3,0),(4,3,'invoices/jamwarehouse/2008','Folder',3,0),(5,2,'invoices/knowledgetree','Folder',5,0),(6,1,'my inv','Shortcut',1,0),(7,2,'my inv','Shortcut',3,0);
/*!40000 ALTER TABLE `nodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_action_allocation`
--

DROP TABLE IF EXISTS `permission_action_allocation`;
CREATE TABLE `permission_action_allocation` (
  `permission_id` int(11) default NULL,
  `action_namespace` varchar(100) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission_action_allocation`
--

LOCK TABLES `permission_action_allocation` WRITE;
/*!40000 ALTER TABLE `permission_action_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_action_allocation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) default NULL,
  `display_name` varchar(100) default NULL,
  `namespace` varchar(100) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plugin_module_relations`
--

DROP TABLE IF EXISTS `plugin_module_relations`;
CREATE TABLE `plugin_module_relations` (
  `plugin_module_namespace` varchar(255) NOT NULL,
  `related_module_namespace` varchar(255) NOT NULL,
  PRIMARY KEY  (`plugin_module_namespace`,`related_module_namespace`),
  KEY `related_module_namespace` (`related_module_namespace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plugin_module_relations`
--

LOCK TABLES `plugin_module_relations` WRITE;
/*!40000 ALTER TABLE `plugin_module_relations` DISABLE KEYS */;
/*!40000 ALTER TABLE `plugin_module_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plugin_modules`
--

DROP TABLE IF EXISTS `plugin_modules`;
CREATE TABLE `plugin_modules` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `plugin_id` int(10) unsigned NOT NULL default '0',
  `module_type` enum('Action','Trigger','GroupingProperty','AuthenticationProvider') NOT NULL,
  `display_name` varchar(255) NOT NULL default ' ',
  `status` int(11) NOT NULL default '0',
  `classname` varchar(255) NOT NULL default ' ',
  `path` text NOT NULL,
  `module_config` text,
  `ordering` int(11) NOT NULL default '0',
  `can_disable` tinyint(3) unsigned NOT NULL default '0',
  `namespace` varchar(255) NOT NULL default ' ',
  `dependencies` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `namespace_idx` (`namespace`),
  KEY `plugin_id_idx` (`plugin_id`),
  CONSTRAINT `plugin_modules_ibfk_1` FOREIGN KEY (`plugin_id`) REFERENCES `plugins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plugin_modules`
--

LOCK TABLES `plugin_modules` WRITE;
/*!40000 ALTER TABLE `plugin_modules` DISABLE KEYS */;
INSERT INTO `plugin_modules` VALUES (71,6,'','_tr(Test Action)',0,'Test2Action','ktapi2/Tests/Plugin/Test2Upgrade/Test2Action.inc.php','s:0:\"\";',0,0,'action.test.plugin.test','s:0:\"\";'),(4948,643,'GroupingProperty','',0,'Security_Group','','a:5:{s:12:\"display_name\";s:20:\"System Administrator\";s:6:\"getter\";s:21:\"isSystemAdministrator\";s:6:\"setter\";s:22:\"setSystemAdministrator\";s:4:\"type\";s:7:\"boolean\";s:7:\"default\";b:0;}',0,0,'grouping.property.system.administrator.plugin.core','s:0:\"\";'),(4949,643,'GroupingProperty','',0,'Security_Group','','a:5:{s:12:\"display_name\";s:18:\"Unit Administrator\";s:6:\"getter\";s:19:\"isUnitAdministrator\";s:6:\"setter\";s:20:\"setUnitAdministrator\";s:4:\"type\";s:7:\"boolean\";s:7:\"default\";b:0;}',0,0,'grouping.property.unit.administrator.plugin.core','s:0:\"\";'),(4950,643,'AuthenticationProvider','Hashed Password Provider',0,'HashedAuthenticationProvider','ktapi2/Plugins/Core/Authentication/HashedAuthentication.php','s:0:\"\";',0,0,'authentication.provider.hashed.password.plugin.core','s:0:\"\";');
/*!40000 ALTER TABLE `plugin_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plugin_relations`
--

DROP TABLE IF EXISTS `plugin_relations`;
CREATE TABLE `plugin_relations` (
  `plugin_namespace` varchar(255) NOT NULL,
  `related_plugin_namespace` varchar(255) NOT NULL,
  PRIMARY KEY  (`plugin_namespace`,`related_plugin_namespace`),
  KEY `related_plugin_namespace` (`related_plugin_namespace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plugin_relations`
--

LOCK TABLES `plugin_relations` WRITE;
/*!40000 ALTER TABLE `plugin_relations` DISABLE KEYS */;
/*!40000 ALTER TABLE `plugin_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plugins`
--

DROP TABLE IF EXISTS `plugins`;
CREATE TABLE `plugins` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `display_name` varchar(255) NOT NULL default ' ',
  `path` text NOT NULL,
  `status` bigint(20) NOT NULL default '1',
  `version` int(11) NOT NULL default '1',
  `can_disable` tinyint(3) unsigned NOT NULL default '1',
  `can_delete` tinyint(3) unsigned NOT NULL default '1',
  `ordering` int(11) NOT NULL default '0',
  `namespace` varchar(255) NOT NULL default ' ',
  `dependencies` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `namespace_idx` (`namespace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plugins`
--

LOCK TABLES `plugins` WRITE;
/*!40000 ALTER TABLE `plugins` DISABLE KEYS */;
INSERT INTO `plugins` VALUES (6,'_tr(Test Plugin)','ktapi2/Tests/Plugin/Test2Upgrade/Test2Plugin.inc.php',0,0,1,1,0,'plugin.test','a:2:{s:12:\"dependencies\";a:0:{}s:8:\"includes\";a:0:{}}'),(643,'_tr(KT Core Plugin)','ktapi2/Plugins/Core/CorePlugin.inc.php',0,0,1,1,0,'plugin.core','a:2:{s:12:\"dependencies\";a:0:{}s:8:\"includes\";a:0:{}}');
/*!40000 ALTER TABLE `plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue_downloads`
--

DROP TABLE IF EXISTS `queue_downloads`;
CREATE TABLE `queue_downloads` (
  `id` int(10) unsigned NOT NULL,
  `node_content_id` int(10) unsigned NOT NULL COMMENT 'the specific file to be downloaded',
  `hash` char(40) NOT NULL COMMENT 'has for validation',
  `expires` datetime default NULL COMMENT 'when this entry expires from downloading'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `queue_downloads`
--

LOCK TABLES `queue_downloads` WRITE;
/*!40000 ALTER TABLE `queue_downloads` DISABLE KEYS */;
/*!40000 ALTER TABLE `queue_downloads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue_expunging`
--

DROP TABLE IF EXISTS `queue_expunging`;
CREATE TABLE `queue_expunging` (
  `node_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `queue_expunging`
--

LOCK TABLES `queue_expunging` WRITE;
/*!40000 ALTER TABLE `queue_expunging` DISABLE KEYS */;
/*!40000 ALTER TABLE `queue_expunging` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue_indexing`
--

DROP TABLE IF EXISTS `queue_indexing`;
CREATE TABLE `queue_indexing` (
  `node_id` int(10) unsigned NOT NULL,
  `stage` enum('Request','Processed','Error') NOT NULL default 'Request',
  `request_date` datetime NOT NULL,
  `processed_date` datetime default NULL,
  `error` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `queue_indexing`
--

LOCK TABLES `queue_indexing` WRITE;
/*!40000 ALTER TABLE `queue_indexing` DISABLE KEYS */;
/*!40000 ALTER TABLE `queue_indexing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue_notifications`
--

DROP TABLE IF EXISTS `queue_notifications`;
CREATE TABLE `queue_notifications` (
  `email_id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `email_config` mediumtext NOT NULL,
  `node_id` int(11) default NULL,
  PRIMARY KEY  (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `queue_notifications`
--

LOCK TABLES `queue_notifications` WRITE;
/*!40000 ALTER TABLE `queue_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `queue_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue_uploads`
--

DROP TABLE IF EXISTS `queue_uploads`;
CREATE TABLE `queue_uploads` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `temp_filename` varchar(1024) NOT NULL COMMENT 'the file on the file system',
  `orig_filename` varchar(1024) NOT NULL COMMENT 'the file on the source system',
  `filesize` int(11) NOT NULL,
  `hash` char(32) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `queue_uploads`
--

LOCK TABLES `queue_uploads` WRITE;
/*!40000 ALTER TABLE `queue_uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `queue_uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!50001 DROP VIEW IF EXISTS `roles`*/;
/*!50001 CREATE TABLE `roles` (
  `member_id` int(11),
  `name` text,
  `status` enum('Enabled','Disabled','Deleted'),
  `unit_id` int(11)
) */;

--
-- Table structure for table `storage_location_history`
--

DROP TABLE IF EXISTS `storage_location_history`;
CREATE TABLE `storage_location_history` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `storage_location_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `history` mediumtext NOT NULL,
  `log_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `storage_location_history`
--

LOCK TABLES `storage_location_history` WRITE;
/*!40000 ALTER TABLE `storage_location_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `storage_location_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `storage_locations`
--

DROP TABLE IF EXISTS `storage_locations`;
CREATE TABLE `storage_locations` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `storage_module_namespace` varchar(100) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `location_config` mediumtext NOT NULL,
  `status` enum('Enabled','Disabled','Deleted') NOT NULL default 'Enabled',
  `num_files` bigint(20) NOT NULL default '0',
  `disk_usage` bigint(20) NOT NULL default '0',
  `mount` varchar(100) default NULL,
  `is_mounted` tinyint(4) NOT NULL default '0',
  `is_readonly` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `storage_locations`
--

LOCK TABLES `storage_locations` WRITE;
/*!40000 ALTER TABLE `storage_locations` DISABLE KEYS */;
INSERT INTO `storage_locations` VALUES (1,'storage.engine.hashed','Default Storage','','Enabled',0,0,'var/Documents',1,0);
/*!40000 ALTER TABLE `storage_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`,`tag`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_log`
--

DROP TABLE IF EXISTS `transaction_log`;
CREATE TABLE `transaction_log` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `log_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  `action_namespace` varchar(100) NOT NULL,
  `action_config` mediumtext NOT NULL,
  `node_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `transaction_log`
--

LOCK TABLES `transaction_log` WRITE;
/*!40000 ALTER TABLE `transaction_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `units`
--

DROP TABLE IF EXISTS `units`;
/*!50001 DROP VIEW IF EXISTS `units`*/;
/*!50001 CREATE TABLE `units` (
  `member_id` int(11),
  `name` text,
  `status` enum('Enabled','Disabled','Deleted'),
  `unit_id` int(11)
) */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `member_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `language_id` char(2) NOT NULL default 'EN',
  `last_login_date` datetime default NULL,
  `invalid_login` tinyint(4) NOT NULL default '0',
  `timezone` float NOT NULL,
  `status` enum('Enabled','Disabled','Deleted') NOT NULL default 'Enabled',
  `auth_source_id` int(10) unsigned NOT NULL,
  `auth_config` mediumtext NOT NULL,
  `created_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`member_id`),
  UNIQUE KEY `member_id_idx` (`member_id`),
  CONSTRAINT `FK_users` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4231,'admin','Test User 1','test1@knowledgetree.com','','EN','2008-06-17 00:35:09',0,0,'Enabled',15,'a:1:{s:8:\"password\";s:32:\"202cb962ac59075b964b07152d234b70\";}','2008-06-16 22:35:09');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_actions`
--

DROP TABLE IF EXISTS `workflow_actions`;
CREATE TABLE `workflow_actions` (
  `workflow_state_id` int(10) unsigned NOT NULL,
  `action_namespace` varchar(100) NOT NULL,
  `action_config` mediumtext NOT NULL,
  `node_id` int(11) default NULL,
  `ordering` int(11) default '0',
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `workflow_actions`
--

LOCK TABLES `workflow_actions` WRITE;
/*!40000 ALTER TABLE `workflow_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_auto_start`
--

DROP TABLE IF EXISTS `workflow_auto_start`;
CREATE TABLE `workflow_auto_start` (
  `node_id` int(11) default NULL,
  `workflow_id` int(11) default NULL,
  `action_date` datetime default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workflow_auto_start`
--

LOCK TABLES `workflow_auto_start` WRITE;
/*!40000 ALTER TABLE `workflow_auto_start` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_auto_start` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_auto_transition`
--

DROP TABLE IF EXISTS `workflow_auto_transition`;
CREATE TABLE `workflow_auto_transition` (
  `node_id` int(11) default NULL,
  `state_id` int(11) default NULL,
  `transition_id` int(11) default NULL,
  `action_date` datetime default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workflow_auto_transition`
--

LOCK TABLES `workflow_auto_transition` WRITE;
/*!40000 ALTER TABLE `workflow_auto_transition` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_auto_transition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_document_type_association`
--

DROP TABLE IF EXISTS `workflow_document_type_association`;
CREATE TABLE `workflow_document_type_association` (
  `workflow_id` int(10) unsigned NOT NULL,
  `document_type_id` int(11) NOT NULL,
  PRIMARY KEY  (`workflow_id`,`document_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workflow_document_type_association`
--

LOCK TABLES `workflow_document_type_association` WRITE;
/*!40000 ALTER TABLE `workflow_document_type_association` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_document_type_association` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_node_associations`
--

DROP TABLE IF EXISTS `workflow_node_associations`;
CREATE TABLE `workflow_node_associations` (
  `document_node_id` int(11) default NULL,
  `workflow_id` int(11) default NULL,
  `action_date` datetime default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `workflow_node_associations`
--

LOCK TABLES `workflow_node_associations` WRITE;
/*!40000 ALTER TABLE `workflow_node_associations` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_node_associations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_state_allow_actions`
--

DROP TABLE IF EXISTS `workflow_state_allow_actions`;
CREATE TABLE `workflow_state_allow_actions` (
  `workflow_state_id` int(10) unsigned NOT NULL,
  `action_namespace` varchar(100) NOT NULL,
  PRIMARY KEY  (`workflow_state_id`,`action_namespace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `workflow_state_allow_actions`
--

LOCK TABLES `workflow_state_allow_actions` WRITE;
/*!40000 ALTER TABLE `workflow_state_allow_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_state_allow_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_state_block_actions`
--

DROP TABLE IF EXISTS `workflow_state_block_actions`;
CREATE TABLE `workflow_state_block_actions` (
  `workflow_state_id` int(10) unsigned NOT NULL,
  `action_namespace` varchar(100) NOT NULL,
  PRIMARY KEY  (`workflow_state_id`,`action_namespace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `workflow_state_block_actions`
--

LOCK TABLES `workflow_state_block_actions` WRITE;
/*!40000 ALTER TABLE `workflow_state_block_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_state_block_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_state_permissions`
--

DROP TABLE IF EXISTS `workflow_state_permissions`;
CREATE TABLE `workflow_state_permissions` (
  `workflow_state_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`workflow_state_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workflow_state_permissions`
--

LOCK TABLES `workflow_state_permissions` WRITE;
/*!40000 ALTER TABLE `workflow_state_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_state_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_states`
--

DROP TABLE IF EXISTS `workflow_states`;
CREATE TABLE `workflow_states` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `workflow_id` int(11) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `status` enum('Enabled','Disabled','Deleted') NOT NULL default 'Enabled',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workflow_states`
--

LOCK TABLES `workflow_states` WRITE;
/*!40000 ALTER TABLE `workflow_states` DISABLE KEYS */;
INSERT INTO `workflow_states` VALUES (2,1,'Review','Enabled'),(3,1,'Approved','Enabled'),(4,1,'Rejected','Enabled');
/*!40000 ALTER TABLE `workflow_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_transitions`
--

DROP TABLE IF EXISTS `workflow_transitions`;
CREATE TABLE `workflow_transitions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from_state_id` int(11) NOT NULL,
  `to_state_id` int(11) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `status` enum('Enabled','Disabled','Deleted') NOT NULL default 'Enabled',
  `period_type` enum('DayPeriod','DayOfMonth','SpecificDate') default NULL,
  `period_value` varchar(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `workflow_transitions`
--

LOCK TABLES `workflow_transitions` WRITE;
/*!40000 ALTER TABLE `workflow_transitions` DISABLE KEYS */;
INSERT INTO `workflow_transitions` VALUES (1,2,3,'Approve','Enabled',NULL,NULL),(2,2,4,'Reject','Enabled',NULL,NULL);
/*!40000 ALTER TABLE `workflow_transitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflows`
--

DROP TABLE IF EXISTS `workflows`;
CREATE TABLE `workflows` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `display_name` varchar(100) NOT NULL,
  `start_state_id` int(11) default NULL,
  `status` enum('Enabled','Disabled','Deleted') NOT NULL default 'Enabled',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workflows`
--

LOCK TABLES `workflows` WRITE;
/*!40000 ALTER TABLE `workflows` DISABLE KEYS */;
INSERT INTO `workflows` VALUES (1,'Review',2,'Enabled');
/*!40000 ALTER TABLE `workflows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `active_users`
--

/*!50001 DROP TABLE IF EXISTS `active_users`*/;
/*!50001 DROP VIEW IF EXISTS `active_users`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `active_users` AS select `u`.`member_id` AS `member_id`,`u`.`username` AS `username`,`u`.`name` AS `name`,`u`.`email` AS `email`,`u`.`mobile` AS `mobile`,`u`.`language_id` AS `language_id`,`u`.`last_login_date` AS `last_login_date`,`u`.`invalid_login` AS `invalid_login`,`u`.`timezone` AS `timezone`,`u`.`status` AS `status`,`u`.`auth_source_id` AS `auth_source_id`,`u`.`auth_config` AS `auth_config`,`u`.`created_date` AS `created_date` from `users` `u` where (`u`.`status` <> _utf8'Deleted') */;

--
-- Final view structure for view `document_types`
--

/*!50001 DROP TABLE IF EXISTS `document_types`*/;
/*!50001 DROP VIEW IF EXISTS `document_types`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `document_types` AS select `m`.`id` AS `member_id`,`dt`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `dt` join `members` `m` on((`dt`.`member_id` = `m`.`id`))) where ((`dt`.`type` = _utf8'DocumentType') and (`m`.`status` <> _utf8'Deleted')) */;

--
-- Final view structure for view `fields`
--

/*!50001 DROP TABLE IF EXISTS `fields`*/;
/*!50001 DROP VIEW IF EXISTS `fields`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `fields` AS select `m`.`id` AS `member_id`,`f`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `f` join `members` `m` on((`f`.`member_id` = `m`.`id`))) where ((`f`.`type` = _utf8'Field') and (`m`.`status` <> _utf8'Deleted')) */;

--
-- Final view structure for view `fieldsets`
--

/*!50001 DROP TABLE IF EXISTS `fieldsets`*/;
/*!50001 DROP VIEW IF EXISTS `fieldsets`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `fieldsets` AS select `m`.`id` AS `member_id`,`fs`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `fs` join `members` `m` on((`fs`.`member_id` = `m`.`id`))) where ((`fs`.`type` = _utf8'FieldSet') and (`m`.`status` <> _utf8'Deleted')) */;

--
-- Final view structure for view `groups`
--

/*!50001 DROP TABLE IF EXISTS `groups`*/;
/*!50001 DROP VIEW IF EXISTS `groups`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `groups` AS select `m`.`id` AS `member_id`,`g`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `g` join `members` `m` on((`g`.`member_id` = `m`.`id`))) where ((`g`.`type` = _utf8'Group') and (`m`.`status` <> _utf8'Deleted')) */;

--
-- Final view structure for view `roles`
--

/*!50001 DROP TABLE IF EXISTS `roles`*/;
/*!50001 DROP VIEW IF EXISTS `roles`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `roles` AS select `m`.`id` AS `member_id`,`r`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `r` join `members` `m` on((`r`.`member_id` = `m`.`id`))) where ((`r`.`type` = _utf8'Role') and (`m`.`status` <> _utf8'Deleted')) */;

--
-- Final view structure for view `units`
--

/*!50001 DROP TABLE IF EXISTS `units`*/;
/*!50001 DROP VIEW IF EXISTS `units`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `units` AS select `m`.`id` AS `member_id`,`u`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `u` join `members` `m` on((`u`.`member_id` = `m`.`id`))) where ((`u`.`type` = _utf8'Unit') and (`m`.`status` <> _utf8'Deleted')) */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-06-17  6:19:07
