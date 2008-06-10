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
-- Table structure for table `document_content_version`
--

DROP TABLE IF EXISTS `document_content_version`;
CREATE TABLE `document_content_version` (
  `id` int(11) NOT NULL default '0',
  `document_id` int(11) NOT NULL default '0',
  `filename` text NOT NULL,
  `size` bigint(20) NOT NULL default '0',
  `mime_id` int(11) default '9',
  `major_version` int(11) NOT NULL default '0',
  `minor_version` int(11) NOT NULL default '0',
  `storage_path` varchar(250) default NULL,
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
INSERT INTO `document_content_version` VALUES (1,1,'boo',0,9,0,0,NULL,NULL);
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
  `id` int(11) NOT NULL default '0',
  `document_id` int(11) NOT NULL default '0',
  `document_type_id` int(11) NOT NULL default '0',
  `name` text NOT NULL,
  `description` varchar(200) NOT NULL default ' ',
  `status_id` int(11) default NULL,
  `metadata_version` int(11) NOT NULL default '0',
  `version_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `version_creator_id` int(11) NOT NULL default '0',
  `workflow_id` int(11) default NULL,
  `workflow_state_id` int(11) default NULL,
  `custom_doc_no` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `document_id_idx` (`document_id`),
  KEY `document_type_id` (`document_type_id`),
  CONSTRAINT `document_metadata_version_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `document_metadata_version`
--

LOCK TABLES `document_metadata_version` WRITE;
/*!40000 ALTER TABLE `document_metadata_version` DISABLE KEYS */;
INSERT INTO `document_metadata_version` VALUES (1,1,1,'hello','hello',1,0,'0000-00-00 00:00:00',0,NULL,NULL,NULL);
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
  CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`metadata_version_id`) REFERENCES `document_metadata_version` (`id`),
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
-- Table structure for table `fieldset_1`
--

DROP TABLE IF EXISTS `fieldset_1`;
CREATE TABLE `fieldset_1` (
  `fs_f_1` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fieldset_1`
--

LOCK TABLES `fieldset_1` WRITE;
/*!40000 ALTER TABLE `fieldset_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `fieldset_1` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY  (`id`),
  KEY `parent_id_idx` (`parent_id`),
  CONSTRAINT `folders_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `folders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `folders`
--

LOCK TABLES `folders` WRITE;
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
INSERT INTO `folders` VALUES (1,'Root Folder','Root Folder',NULL,1,0,NULL,NULL,1,1,0,1,0),(2,'Invoice','Invoices',1,1,0,'1','invoice',1,1,0,1,1);
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grouping_properties`
--

DROP TABLE IF EXISTS `grouping_properties`;
CREATE TABLE `grouping_properties` (
  `grouping_id` int(11) NOT NULL,
  `property_namespace` varchar(100) NOT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY  (`grouping_id`,`property_namespace`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grouping_properties`
--

LOCK TABLES `grouping_properties` WRITE;
/*!40000 ALTER TABLE `grouping_properties` DISABLE KEYS */;
INSERT INTO `grouping_properties` VALUES (9,'documenttype.scheme','<DOCID>'),(9,'documenttype.checking.regen','true'),(10,'system.administrator','true'),(10,'unit.administrator','true');
/*!40000 ALTER TABLE `grouping_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grouping_property_names`
--

DROP TABLE IF EXISTS `grouping_property_names`;
CREATE TABLE `grouping_property_names` (
  `property_namespace` varchar(100) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `getter` varchar(100) default NULL,
  `setter` varchar(100) default NULL,
  `type` enum('bool','string','float') default 'string',
  `default` varchar(100) default NULL,
  `property` varchar(100) default NULL,
  PRIMARY KEY  (`property_namespace`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grouping_property_names`
--

LOCK TABLES `grouping_property_names` WRITE;
/*!40000 ALTER TABLE `grouping_property_names` DISABLE KEYS */;
INSERT INTO `grouping_property_names` VALUES ('documenttype.scheme','Document Type Scheme','getScheme','setScheme','string',NULL,'DocumentTypeScheme'),('documenttype.checking.regen','Regen on Checkin','getRegen','setRegen','bool','false','CheckinRegen'),('system.administrator','System Administrator','isAdministrator','setAsSystemAdministrator','bool','false',NULL),('unit.administrator','Unit Administrator','isUnitAdministator','setAsUnitAdministrator','bool','false',NULL);
/*!40000 ALTER TABLE `grouping_property_names` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupings`
--

DROP TABLE IF EXISTS `groupings`;
CREATE TABLE `groupings` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` enum('Group','Role','Unit','Fieldset','Field','DocumentType') NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `member_id_idx` (`member_id`),
  CONSTRAINT `groupings_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groupings`
--

LOCK TABLES `groupings` WRITE;
/*!40000 ALTER TABLE `groupings` DISABLE KEYS */;
INSERT INTO `groupings` VALUES (19,35,'Group 1 - Update','Group');
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
-- Table structure for table `member_effective_users`
--

DROP TABLE IF EXISTS `member_effective_users`;
CREATE TABLE `member_effective_users` (
  `member_id` int(11) default NULL,
  `user_member_id` int(11) default NULL,
  KEY `FK_member_effective_users` (`member_id`),
  KEY `FK_member_effective_users2` (`user_member_id`),
  CONSTRAINT `FK_member_effective_users` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_member_effective_users2` FOREIGN KEY (`user_member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `member_effective_users`
--

LOCK TABLES `member_effective_users` WRITE;
/*!40000 ALTER TABLE `member_effective_users` DISABLE KEYS */;
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
  KEY `submember_id` (`submember_id`),
  CONSTRAINT `member_submembers_ibfk_1` FOREIGN KEY (`submember_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  CONSTRAINT `member_submembers_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member_submembers`
--

LOCK TABLES `member_submembers` WRITE;
/*!40000 ALTER TABLE `member_submembers` DISABLE KEYS */;
/*!40000 ALTER TABLE `member_submembers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(11) NOT NULL auto_increment,
  `member_type` enum('Group','User','Role','Unit') NOT NULL,
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
INSERT INTO `members` VALUES (35,'Group','Enabled',NULL,NULL);
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
-- Table structure for table `named_conditions`
--

DROP TABLE IF EXISTS `named_conditions`;
CREATE TABLE `named_conditions` (
  `id` int(11) default NULL,
  `name` varchar(100) default NULL,
  `expression` mediumtext,
  `type` enum('DynamicCondition','SavedSearch') default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `named_conditions`
--

LOCK TABLES `named_conditions` WRITE;
/*!40000 ALTER TABLE `named_conditions` DISABLE KEYS */;
INSERT INTO `named_conditions` VALUES (NULL,'Immutable Documents','IsImmutable','DynamicCondition');
/*!40000 ALTER TABLE `named_conditions` ENABLE KEYS */;
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
  `module_type` int(11) NOT NULL,
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
INSERT INTO `plugin_modules` VALUES (13,3,0,'_tr(Test Action)',0,'TestAction','ktapi2/Tests/Plugin/Test/TestAction.inc.php','s:0:\"\";',0,0,'action.test.plugin.test','s:0:\"\";'),(14,3,2,'tag',0,'Base_Tag','ktapi2/Tests/Plugin/Test/BaseTag.inc.php','N;',0,0,'table.tag.plugin.test','s:0:\"\";'),(15,3,3,'CustomDocumentNo',0,'Document','','a:2:{s:9:\"tablename\";s:13:\"Base_Document\";s:9:\"fieldname\";s:18:\"custom_document_no\";}',0,0,'field.base_document.custom_document_no.plugin.test','s:0:\"\";'),(16,3,4,'Français',0,'fr_FR','ktapi2/Tests/Plugin/Test/TestLanguage.po','s:0:\"\";',0,0,'language.fr_fr.plugin.test','s:0:\"\";'),(17,3,1,'_tr(Test Trigger)',0,'TestTrigger','ktapi2/Tests/Plugin/Test/TestTrigger.inc.php','s:0:\"\";',0,0,'trigger.test.plugin.test','s:0:\"\";'),(18,3,5,'TestUnitTest',0,'TestUnitTest','ktapi2/Tests/Plugin/Test/TestUnitTest.inc.php','s:0:\"\";',0,0,'unittest.testunittest.plugin.test','s:0:\"\";');
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
INSERT INTO `plugins` VALUES (3,'_tr(Test Plugin)','ktapi2/Tests/Plugin/Test/TestPlugin.inc.php',0,0,1,1,0,'plugin.test','a:2:{s:12:\"dependencies\";a:0:{}s:8:\"includes\";a:1:{i:0;s:16:\"Base_Tag.inc.php\";}}');
/*!40000 ALTER TABLE `plugins` ENABLE KEYS */;
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
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL,
  `username` varchar(100) default NULL,
  `name` varchar(100) default NULL,
  `password` varchar(32) default NULL,
  `quota_max` varchar(4) default NULL,
  `quota_current` int(11) default NULL,
  `email` varchar(100) default NULL,
  `mobile` varchar(20) default NULL,
  `language_id` varchar(2) default NULL,
  `last_login` datetime default NULL,
  `invalid_login` tinyint(4) default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `member_id_idx` (`member_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `document_types`
--

/*!50001 DROP TABLE IF EXISTS `document_types`*/;
/*!50001 DROP VIEW IF EXISTS `document_types`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `document_types` AS select `m`.`id` AS `member_id`,`dt`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `dt` join `members` `m` on((`dt`.`member_id` = `m`.`id`))) where (`dt`.`type` = _utf8'DocumentType') */;

--
-- Final view structure for view `fields`
--

/*!50001 DROP TABLE IF EXISTS `fields`*/;
/*!50001 DROP VIEW IF EXISTS `fields`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `fields` AS select `m`.`id` AS `member_id`,`f`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `f` join `members` `m` on((`f`.`member_id` = `m`.`id`))) where (`f`.`type` = _utf8'Field') */;

--
-- Final view structure for view `fieldsets`
--

/*!50001 DROP TABLE IF EXISTS `fieldsets`*/;
/*!50001 DROP VIEW IF EXISTS `fieldsets`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `fieldsets` AS select `m`.`id` AS `member_id`,`fs`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `fs` join `members` `m` on((`fs`.`member_id` = `m`.`id`))) where (`fs`.`type` = _utf8'FieldSet') */;

--
-- Final view structure for view `groups`
--

/*!50001 DROP TABLE IF EXISTS `groups`*/;
/*!50001 DROP VIEW IF EXISTS `groups`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `groups` AS select `m`.`id` AS `member_id`,`g`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `g` join `members` `m` on((`g`.`member_id` = `m`.`id`))) where (`g`.`type` = _utf8'Group') */;

--
-- Final view structure for view `roles`
--

/*!50001 DROP TABLE IF EXISTS `roles`*/;
/*!50001 DROP VIEW IF EXISTS `roles`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `roles` AS select `m`.`id` AS `member_id`,`r`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `r` join `members` `m` on((`r`.`member_id` = `m`.`id`))) where (`r`.`type` = _utf8'Role') */;

--
-- Final view structure for view `units`
--

/*!50001 DROP TABLE IF EXISTS `units`*/;
/*!50001 DROP VIEW IF EXISTS `units`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `units` AS select `m`.`id` AS `member_id`,`u`.`name` AS `name`,`m`.`status` AS `status`,`m`.`unit_id` AS `unit_id` from (`groupings` `u` join `members` `m` on((`u`.`member_id` = `m`.`id`))) where (`u`.`type` = _utf8'Unit') */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-06-10  9:45:09
