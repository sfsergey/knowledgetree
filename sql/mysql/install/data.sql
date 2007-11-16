--
-- $Id$
--
-- KnowledgeTree Open Source Edition
-- Document Management Made Simple
-- Copyright (C) 2004 - 2007 The Jam Warehouse Software (Pty) Limited
--
-- This program is free software; you can redistribute it and/or modify it under
-- the terms of the GNU General Public License version 3 as published by the
-- Free Software Foundation.
--
-- This program is distributed in the hope that it will be useful, but WITHOUT
-- ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
-- FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
-- details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see <http://www.gnu.org/licenses/>.
--
-- You can contact The Jam Warehouse Software (Pty) Limited, Unit 1, Tramber Place,
-- Blake Street, Observatory, 7925 South Africa. or email info@knowledgetree.com.
--
-- The interactive user interfaces in modified source and object code versions
-- of this program must display Appropriate Legal Notices, as required under
-- Section 5 of the GNU General Public License version 3.
--
-- In accordance with Section 7(b) of the GNU General Public License version 3,
-- these Appropriate Legal Notices must retain the display of the "Powered by
-- KnowledgeTree" logo and retain the original copyright notice. If the display of the
-- logo is not reasonably feasible for technical reasons, the Appropriate Legal Notices
-- must display the words "Powered by KnowledgeTree" and retain the original
-- copyright notice.
-- Contributor( s): ______________________________________
--
-- MySQL dump 10.11
--
-- Host: localhost    Database: ktdms
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
-- Dumping data for table `active_sessions`
--

LOCK TABLES `active_sessions` WRITE;
/*!40000 ALTER TABLE `active_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `active_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `archive_restoration_request`
--

LOCK TABLES `archive_restoration_request` WRITE;
/*!40000 ALTER TABLE `archive_restoration_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_restoration_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `archiving_settings`
--

LOCK TABLES `archiving_settings` WRITE;
/*!40000 ALTER TABLE `archiving_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `archiving_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `archiving_type_lookup`
--

LOCK TABLES `archiving_type_lookup` WRITE;
/*!40000 ALTER TABLE `archiving_type_lookup` DISABLE KEYS */;
INSERT INTO `archiving_type_lookup` VALUES (1,'Date'),(2,'Utilisation');
/*!40000 ALTER TABLE `archiving_type_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `authentication_sources`
--

LOCK TABLES `authentication_sources` WRITE;
/*!40000 ALTER TABLE `authentication_sources` DISABLE KEYS */;
/*!40000 ALTER TABLE `authentication_sources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `column_entries`
--

LOCK TABLES `column_entries` WRITE;
/*!40000 ALTER TABLE `column_entries` DISABLE KEYS */;
INSERT INTO `column_entries` VALUES (1,'ktcore.columns.selection','ktcore.views.browse','',0,1),(2,'ktcore.columns.title','ktcore.views.browse','',1,1),(3,'ktcore.columns.download','ktcore.views.browse','',2,0),(4,'ktcore.columns.creationdate','ktcore.views.browse','',3,0),(5,'ktcore.columns.modificationdate','ktcore.views.browse','',4,0),(6,'ktcore.columns.creator','ktcore.views.browse','',5,0),(7,'ktcore.columns.workflow_state','ktcore.views.browse','',6,0),(8,'ktcore.columns.selection','ktcore.views.search','',0,1),(9,'ktcore.columns.title','ktcore.views.search','',1,1),(10,'ktcore.columns.download','ktcore.views.search','',2,0),(11,'ktcore.columns.creationdate','ktcore.views.search','',3,0),(12,'ktcore.columns.modificationdate','ktcore.views.search','',4,0),(13,'ktcore.columns.creator','ktcore.views.search','',5,0),(14,'ktcore.columns.workflow_state','ktcore.views.search','',6,0);
/*!40000 ALTER TABLE `column_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `comment_searchable_text`
--

LOCK TABLES `comment_searchable_text` WRITE;
/*!40000 ALTER TABLE `comment_searchable_text` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment_searchable_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `dashlet_disables`
--

LOCK TABLES `dashlet_disables` WRITE;
/*!40000 ALTER TABLE `dashlet_disables` DISABLE KEYS */;
/*!40000 ALTER TABLE `dashlet_disables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `data_types`
--

LOCK TABLES `data_types` WRITE;
/*!40000 ALTER TABLE `data_types` DISABLE KEYS */;
INSERT INTO `data_types` VALUES (1,'STRING'),(2,'CHAR'),(3,'TEXT'),(4,'INT'),(5,'FLOAT');
/*!40000 ALTER TABLE `data_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `discussion_comments`
--

LOCK TABLES `discussion_comments` WRITE;
/*!40000 ALTER TABLE `discussion_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `discussion_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `discussion_threads`
--

LOCK TABLES `discussion_threads` WRITE;
/*!40000 ALTER TABLE `discussion_threads` DISABLE KEYS */;
/*!40000 ALTER TABLE `discussion_threads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_archiving_link`
--

LOCK TABLES `document_archiving_link` WRITE;
/*!40000 ALTER TABLE `document_archiving_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_archiving_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_content_version`
--

LOCK TABLES `document_content_version` WRITE;
/*!40000 ALTER TABLE `document_content_version` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_content_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_fields`
--

LOCK TABLES `document_fields` WRITE;
/*!40000 ALTER TABLE `document_fields` DISABLE KEYS */;
INSERT INTO `document_fields` VALUES (2,'Tag','STRING',0,0,0,2,0,'Tag Words'),(3,'Document Author','STRING',0,0,0,3,0,'Please add a document author'),(4,'Category','STRING',0,1,0,3,0,'Please select a category'),(5,'Media Type','STRING',0,1,0,3,0,'Please select a media type');
/*!40000 ALTER TABLE `document_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_fields_link`
--

LOCK TABLES `document_fields_link` WRITE;
/*!40000 ALTER TABLE `document_fields_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_fields_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_incomplete`
--

LOCK TABLES `document_incomplete` WRITE;
/*!40000 ALTER TABLE `document_incomplete` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_incomplete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_link`
--

LOCK TABLES `document_link` WRITE;
/*!40000 ALTER TABLE `document_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_link_types`
--

LOCK TABLES `document_link_types` WRITE;
/*!40000 ALTER TABLE `document_link_types` DISABLE KEYS */;
INSERT INTO `document_link_types` VALUES (-1,'depended on','was depended on by','Depends relationship whereby one documents depends on another\'s creation to go through approval'),(0,'Default','Default (reverse)','Default link type'),(3,'Attachment','','Document Attachment'),(4,'Reference','','Document Reference'),(5,'Copy','','Document Copy');
/*!40000 ALTER TABLE `document_link_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_metadata_version`
--

LOCK TABLES `document_metadata_version` WRITE;
/*!40000 ALTER TABLE `document_metadata_version` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_metadata_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_role_allocations`
--

LOCK TABLES `document_role_allocations` WRITE;
/*!40000 ALTER TABLE `document_role_allocations` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_role_allocations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_searchable_text`
--

LOCK TABLES `document_searchable_text` WRITE;
/*!40000 ALTER TABLE `document_searchable_text` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_searchable_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_subscriptions`
--

LOCK TABLES `document_subscriptions` WRITE;
/*!40000 ALTER TABLE `document_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_tags`
--

LOCK TABLES `document_tags` WRITE;
/*!40000 ALTER TABLE `document_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_text`
--

LOCK TABLES `document_text` WRITE;
/*!40000 ALTER TABLE `document_text` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_transaction_text`
--

LOCK TABLES `document_transaction_text` WRITE;
/*!40000 ALTER TABLE `document_transaction_text` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_transaction_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_transaction_types_lookup`
--

LOCK TABLES `document_transaction_types_lookup` WRITE;
/*!40000 ALTER TABLE `document_transaction_types_lookup` DISABLE KEYS */;
INSERT INTO `document_transaction_types_lookup` VALUES (1,'Create','ktcore.transactions.create'),(2,'Update','ktcore.transactions.update'),(3,'Delete','ktcore.transactions.delete'),(4,'Rename','ktcore.transactions.rename'),(5,'Move','ktcore.transactions.move'),(6,'Download','ktcore.transactions.download'),(7,'Check In','ktcore.transactions.check_in'),(8,'Check Out','ktcore.transactions.check_out'),(9,'Collaboration Step Rollback','ktcore.transactions.collaboration_step_rollback'),(10,'View','ktcore.transactions.view'),(11,'Expunge','ktcore.transactions.expunge'),(12,'Force CheckIn','ktcore.transactions.force_checkin'),(13,'Email Link','ktcore.transactions.email_link'),(14,'Collaboration Step Approve','ktcore.transactions.collaboration_step_approve'),(15,'Email Attachment','ktcore.transactions.email_attachment'),(16,'Workflow state transition','ktcore.transactions.workflow_state_transition'),(17,'Permissions changed','ktcore.transactions.permissions_change'),(18,'Role allocations changed','ktcore.transactions.role_allocations_change'),(19,'Bulk Export','ktstandard.transactions.bulk_export'),(20,'Copy','ktcore.transactions.copy'),(21,'Delete Version','ktcore.transactions.delete_version');
/*!40000 ALTER TABLE `document_transaction_types_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_transactions`
--

LOCK TABLES `document_transactions` WRITE;
/*!40000 ALTER TABLE `document_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_type_fields_link`
--

LOCK TABLES `document_type_fields_link` WRITE;
/*!40000 ALTER TABLE `document_type_fields_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_type_fields_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_type_fieldsets_link`
--

LOCK TABLES `document_type_fieldsets_link` WRITE;
/*!40000 ALTER TABLE `document_type_fieldsets_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_type_fieldsets_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `document_types_lookup`
--

LOCK TABLES `document_types_lookup` WRITE;
/*!40000 ALTER TABLE `document_types_lookup` DISABLE KEYS */;
INSERT INTO `document_types_lookup` VALUES (1,'Default',0);
/*!40000 ALTER TABLE `document_types_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `download_files`
--

LOCK TABLES `download_files` WRITE;
/*!40000 ALTER TABLE `download_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `download_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `field_behaviour_options`
--

LOCK TABLES `field_behaviour_options` WRITE;
/*!40000 ALTER TABLE `field_behaviour_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `field_behaviour_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `field_behaviours`
--

LOCK TABLES `field_behaviours` WRITE;
/*!40000 ALTER TABLE `field_behaviours` DISABLE KEYS */;
/*!40000 ALTER TABLE `field_behaviours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `field_orders`
--

LOCK TABLES `field_orders` WRITE;
/*!40000 ALTER TABLE `field_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `field_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `field_value_instances`
--

LOCK TABLES `field_value_instances` WRITE;
/*!40000 ALTER TABLE `field_value_instances` DISABLE KEYS */;
/*!40000 ALTER TABLE `field_value_instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `fieldsets`
--

LOCK TABLES `fieldsets` WRITE;
/*!40000 ALTER TABLE `fieldsets` DISABLE KEYS */;
INSERT INTO `fieldsets` VALUES (2,'Tag Cloud','tagcloud',0,0,NULL,1,0,0,0,'Tag Cloud',0),(3,'General information','generalinformation',0,0,NULL,1,0,0,0,'General document information',0);
/*!40000 ALTER TABLE `fieldsets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `folder_descendants`
--

LOCK TABLES `folder_descendants` WRITE;
/*!40000 ALTER TABLE `folder_descendants` DISABLE KEYS */;
/*!40000 ALTER TABLE `folder_descendants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `folder_doctypes_link`
--

LOCK TABLES `folder_doctypes_link` WRITE;
/*!40000 ALTER TABLE `folder_doctypes_link` DISABLE KEYS */;
INSERT INTO `folder_doctypes_link` VALUES (1,1,1);
/*!40000 ALTER TABLE `folder_doctypes_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `folder_searchable_text`
--

LOCK TABLES `folder_searchable_text` WRITE;
/*!40000 ALTER TABLE `folder_searchable_text` DISABLE KEYS */;
INSERT INTO `folder_searchable_text` VALUES (1,'Root Folder');
/*!40000 ALTER TABLE `folder_searchable_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `folder_subscriptions`
--

LOCK TABLES `folder_subscriptions` WRITE;
/*!40000 ALTER TABLE `folder_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `folder_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `folder_transactions`
--

LOCK TABLES `folder_transactions` WRITE;
/*!40000 ALTER TABLE `folder_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `folder_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `folder_workflow_map`
--

LOCK TABLES `folder_workflow_map` WRITE;
/*!40000 ALTER TABLE `folder_workflow_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `folder_workflow_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `folders`
--

LOCK TABLES `folders` WRITE;
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
INSERT INTO `folders` VALUES (1,'Root Folder','Root Document Folder',NULL,1,0,NULL,NULL,1,5,0,1);
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `folders_users_roles_link`
--

LOCK TABLES `folders_users_roles_link` WRITE;
/*!40000 ALTER TABLE `folders_users_roles_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `folders_users_roles_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `groups_groups_link`
--

LOCK TABLES `groups_groups_link` WRITE;
/*!40000 ALTER TABLE `groups_groups_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups_groups_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `groups_lookup`
--

LOCK TABLES `groups_lookup` WRITE;
/*!40000 ALTER TABLE `groups_lookup` DISABLE KEYS */;
INSERT INTO `groups_lookup` VALUES (1,'System Administrators',1,0,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `groups_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `help`
--

LOCK TABLES `help` WRITE;
/*!40000 ALTER TABLE `help` DISABLE KEYS */;
INSERT INTO `help` VALUES (1,'browse','dochelp.html'),(2,'dashboard','dashboardHelp.html'),(3,'addFolder','addFolderHelp.html'),(4,'editFolder','editFolderHelp.html'),(5,'addFolderCollaboration','addFolderCollaborationHelp.html'),(6,'modifyFolderCollaboration','addFolderCollaborationHelp.html'),(7,'addDocument','addDocumentHelp.html'),(8,'viewDocument','viewDocumentHelp.html'),(9,'modifyDocument','modifyDocumentHelp.html'),(10,'modifyDocumentRouting','modifyDocumentRoutingHelp.html'),(11,'emailDocument','emailDocumentHelp.html'),(12,'deleteDocument','deleteDocumentHelp.html'),(13,'administration','administrationHelp.html'),(14,'addGroup','addGroupHelp.html'),(15,'editGroup','editGroupHelp.html'),(16,'removeGroup','removeGroupHelp.html'),(17,'assignGroupToUnit','assignGroupToUnitHelp.html'),(18,'removeGroupFromUnit','removeGroupFromUnitHelp.html'),(19,'addUnit','addUnitHelp.html'),(20,'editUnit','editUnitHelp.html'),(21,'removeUnit','removeUnitHelp.html'),(22,'addOrg','addOrgHelp.html'),(23,'editOrg','editOrgHelp.html'),(24,'removeOrg','removeOrgHelp.html'),(25,'addRole','addRoleHelp.html'),(26,'editRole','editRoleHelp.html'),(27,'removeRole','removeRoleHelp.html'),(28,'addLink','addLinkHelp.html'),(29,'addLinkSuccess','addLinkHelp.html'),(30,'editLink','editLinkHelp.html'),(31,'removeLink','removeLinkHelp.html'),(32,'systemAdministration','systemAdministrationHelp.html'),(33,'deleteFolder','deleteFolderHelp.html'),(34,'editDocType','editDocTypeHelp.html'),(35,'removeDocType','removeDocTypeHelp.html'),(36,'addDocType','addDocTypeHelp.html'),(37,'addDocTypeSuccess','addDocTypeHelp.html'),(38,'manageSubscriptions','manageSubscriptionsHelp.html'),(39,'addSubscription','addSubscriptionHelp.html'),(40,'removeSubscription','removeSubscriptionHelp.html'),(41,'preferences','preferencesHelp.html'),(42,'editPrefsSuccess','preferencesHelp.html'),(43,'modifyDocumentGenericMetaData','modifyDocumentGenericMetaDataHelp.html'),(44,'viewHistory','viewHistoryHelp.html'),(45,'checkInDocument','checkInDocumentHelp.html'),(46,'checkOutDocument','checkOutDocumentHelp.html'),(47,'advancedSearch','advancedSearchHelp.html'),(48,'deleteFolderCollaboration','deleteFolderCollaborationHelp.html'),(49,'addFolderDocType','addFolderDocTypeHelp.html'),(50,'deleteFolderDocType','deleteFolderDocTypeHelp.html'),(51,'addGroupFolderLink','addGroupFolderLinkHelp.html'),(52,'deleteGroupFolderLink','deleteGroupFolderLinkHelp.html'),(53,'addWebsite','addWebsiteHelp.html'),(54,'addWebsiteSuccess','addWebsiteHelp.html'),(55,'editWebsite','editWebsiteHelp.html'),(56,'removeWebSite','removeWebSiteHelp.html'),(57,'standardSearch','standardSearchHelp.html'),(58,'modifyDocumentTypeMetaData','modifyDocumentTypeMetaDataHelp.html'),(59,'addDocField','addDocFieldHelp.html'),(60,'editDocField','editDocFieldHelp.html'),(61,'removeDocField','removeDocFieldHelp.html'),(62,'addMetaData','addMetaDataHelp.html'),(63,'editMetaData','editMetaDataHelp.html'),(64,'removeMetaData','removeMetaDataHelp.html'),(65,'addUser','addUserHelp.html'),(66,'editUser','editUserHelp.html'),(67,'removeUser','removeUserHelp.html'),(68,'addUserToGroup','addUserToGroupHelp.html'),(69,'removeUserFromGroup','removeUserFromGroupHelp.html'),(70,'viewDiscussion','viewDiscussionThread.html'),(71,'addComment','addDiscussionComment.html'),(72,'listNews','listDashboardNewsHelp.html'),(73,'editNews','editDashboardNewsHelp.html'),(74,'previewNews','previewDashboardNewsHelp.html'),(75,'addNews','addDashboardNewsHelp.html'),(76,'modifyDocumentArchiveSettings','modifyDocumentArchiveSettingsHelp.html'),(77,'addDocumentArchiveSettings','addDocumentArchiveSettingsHelp.html'),(78,'listDocFields','listDocumentFieldsAdmin.html'),(79,'editDocFieldLookups','editDocFieldLookups.html'),(80,'addMetaDataForField','addMetaDataForField.html'),(81,'editMetaDataForField','editMetaDataForField.html'),(82,'removeMetaDataFromField','removeMetaDataFromField.html'),(83,'listDocs','listDocumentsCheckoutHelp.html'),(84,'editDocCheckout','editDocCheckoutHelp.html'),(85,'listDocTypes','listDocTypesHelp.html'),(86,'editDocTypeFields','editDocFieldHelp.html'),(87,'addDocTypeFieldsLink','addDocTypeFieldHelp.html'),(88,'listGroups','listGroupsHelp.html'),(89,'editGroupUnit','editGroupUnitHelp.html'),(90,'listOrg','listOrgHelp.html'),(91,'listRole','listRolesHelp.html'),(92,'listUnits','listUnitHelp.html'),(93,'editUnitOrg','editUnitOrgHelp.html'),(94,'removeUnitFromOrg','removeUnitFromOrgHelp.html'),(95,'addUnitToOrg','addUnitToOrgHelp.html'),(96,'listUsers','listUsersHelp.html'),(97,'editUserGroups','editUserGroupsHelp.html'),(98,'listWebsites','listWebsitesHelp.html'),(99,'loginDisclaimer','loginDisclaimer.html'),(100,'pageDisclaimer','pageDisclaimer.html');
/*!40000 ALTER TABLE `help` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `help_replacement`
--

LOCK TABLES `help_replacement` WRITE;
/*!40000 ALTER TABLE `help_replacement` DISABLE KEYS */;
/*!40000 ALTER TABLE `help_replacement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `index_files`
--

LOCK TABLES `index_files` WRITE;
/*!40000 ALTER TABLE `index_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `index_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `interceptor_instances`
--

LOCK TABLES `interceptor_instances` WRITE;
/*!40000 ALTER TABLE `interceptor_instances` DISABLE KEYS */;
/*!40000 ALTER TABLE `interceptor_instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `links`
--

LOCK TABLES `links` WRITE;
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
/*!40000 ALTER TABLE `links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `metadata_lookup`
--

LOCK TABLES `metadata_lookup` WRITE;
/*!40000 ALTER TABLE `metadata_lookup` DISABLE KEYS */;
INSERT INTO `metadata_lookup` VALUES (2,4,'Technical',NULL,0,0),(3,4,'Financial',NULL,0,0),(4,4,'Legal',NULL,0,0),(5,4,'Administrative',NULL,0,0),(6,4,'Miscellaneous',NULL,0,0),(7,4,'Sales',NULL,0,0),(8,5,'Text',NULL,0,0),(9,5,'Image',NULL,0,0),(10,5,'Audio',NULL,0,0),(11,5,'Video',NULL,0,0);
/*!40000 ALTER TABLE `metadata_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `metadata_lookup_tree`
--

LOCK TABLES `metadata_lookup_tree` WRITE;
/*!40000 ALTER TABLE `metadata_lookup_tree` DISABLE KEYS */;
/*!40000 ALTER TABLE `metadata_lookup_tree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mime_document_mapping`
--

LOCK TABLES `mime_document_mapping` WRITE;
/*!40000 ALTER TABLE `mime_document_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `mime_document_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mime_documents`
--

LOCK TABLES `mime_documents` WRITE;
/*!40000 ALTER TABLE `mime_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `mime_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mime_extractors`
--

LOCK TABLES `mime_extractors` WRITE;
/*!40000 ALTER TABLE `mime_extractors` DISABLE KEYS */;
/*!40000 ALTER TABLE `mime_extractors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mime_types`
--

LOCK TABLES `mime_types` WRITE;
/*!40000 ALTER TABLE `mime_types` DISABLE KEYS */;
INSERT INTO `mime_types` VALUES (1,'ai','application/postscript','pdf','Postscript Document',NULL,NULL),(2,'aif','audio/x-aiff',NULL,'',NULL,NULL),(3,'aifc','audio/x-aiff',NULL,'',NULL,NULL),(4,'aiff','audio/x-aiff',NULL,'',NULL,NULL),(5,'asc','text/plain','text','Plain Text',NULL,NULL),(6,'au','audio/basic',NULL,'',NULL,NULL),(7,'avi','video/x-msvideo',NULL,'Video File',NULL,NULL),(8,'bcpio','application/x-bcpio',NULL,'',NULL,NULL),(9,'bin','application/octet-stream',NULL,'Binary File',NULL,NULL),(10,'bmp','image/bmp','image','BMP Image',NULL,NULL),(11,'cdf','application/x-netcdf',NULL,'',NULL,NULL),(12,'class','application/octet-stream',NULL,'',NULL,NULL),(13,'cpio','application/x-cpio',NULL,'',NULL,NULL),(14,'cpt','application/mac-compactpro',NULL,'',NULL,NULL),(15,'csh','application/x-csh',NULL,'',NULL,NULL),(16,'css','text/css',NULL,'',NULL,NULL),(17,'dcr','application/x-director',NULL,'',NULL,NULL),(18,'dir','application/x-director',NULL,'',NULL,NULL),(19,'dms','application/octet-stream',NULL,'',NULL,NULL),(20,'doc','application/msword','word','Word Document',NULL,NULL),(21,'dvi','application/x-dvi',NULL,'',NULL,NULL),(22,'dxr','application/x-director',NULL,'',NULL,NULL),(23,'eps','application/postscript','pdf','Encapsulated Postscript',NULL,NULL),(24,'etx','text/x-setext',NULL,'',NULL,NULL),(25,'exe','application/octet-stream',NULL,'',NULL,NULL),(26,'ez','application/andrew-inset',NULL,'',NULL,NULL),(27,'gif','image/gif','image','GIF Image',NULL,NULL),(28,'gtar','application/x-gtar','compressed','',NULL,NULL),(29,'hdf','application/x-hdf',NULL,'',NULL,NULL),(30,'hqx','application/mac-binhex40',NULL,'',NULL,NULL),(31,'htm','text/html','html','HTML Webpage',NULL,NULL),(32,'html','text/html','html','HTML Webpage',NULL,NULL),(33,'ice','x-conference/x-cooltalk',NULL,'',NULL,NULL),(34,'ief','image/ief','image','',NULL,NULL),(35,'iges','model/iges',NULL,'',NULL,NULL),(36,'igs','model/iges',NULL,'',NULL,NULL),(37,'jpe','image/jpeg','image','JPEG Image',NULL,NULL),(38,'jpeg','image/jpeg','image','JPEG Image',NULL,NULL),(39,'jpg','image/jpeg','image','JPEG Image',NULL,NULL),(40,'js','application/x-javascript','html','',NULL,NULL),(41,'kar','audio/midi',NULL,'',NULL,NULL),(42,'latex','application/x-latex',NULL,'',NULL,NULL),(43,'lha','application/octet-stream',NULL,'',NULL,NULL),(44,'lzh','application/octet-stream',NULL,'',NULL,NULL),(45,'man','application/x-troff-man',NULL,'',NULL,NULL),(46,'mdb','application/access','database','Access Database',NULL,NULL),(47,'mdf','application/access','database','Access Database',NULL,NULL),(48,'me','application/x-troff-me',NULL,'',NULL,NULL),(49,'mesh','model/mesh',NULL,'',NULL,NULL),(50,'mid','audio/midi',NULL,'',NULL,NULL),(51,'midi','audio/midi',NULL,'',NULL,NULL),(52,'mif','application/vnd.mif',NULL,'',NULL,NULL),(53,'mov','video/quicktime',NULL,'Video File',NULL,NULL),(54,'movie','video/x-sgi-movie',NULL,'Video File',NULL,NULL),(55,'mp2','audio/mpeg',NULL,'',NULL,NULL),(56,'mp3','audio/mpeg',NULL,'',NULL,NULL),(57,'mpe','video/mpeg',NULL,'Video File',NULL,NULL),(58,'mpeg','video/mpeg',NULL,'Video File',NULL,NULL),(59,'mpg','video/mpeg',NULL,'Video File',NULL,NULL),(60,'mpga','audio/mpeg',NULL,'',NULL,NULL),(61,'mpp','application/vnd.ms-project','office','',NULL,NULL),(62,'ms','application/x-troff-ms',NULL,'',NULL,NULL),(63,'msh','model/mesh',NULL,'',NULL,NULL),(64,'nc','application/x-netcdf',NULL,'',NULL,NULL),(65,'oda','application/oda',NULL,'',NULL,NULL),(66,'pbm','image/x-portable-bitmap','image','',NULL,NULL),(67,'pdb','chemical/x-pdb',NULL,'',NULL,NULL),(68,'pdf','application/pdf','pdf','Acrobat PDF',NULL,NULL),(69,'pgm','image/x-portable-graymap','image','',NULL,NULL),(70,'pgn','application/x-chess-pgn',NULL,'',NULL,NULL),(71,'png','image/png','image','PNG Image',NULL,NULL),(72,'pnm','image/x-portable-anymap','image','',NULL,NULL),(73,'ppm','image/x-portable-pixmap','image','',NULL,NULL),(74,'ppt','application/vnd.ms-powerpoint','office','Powerpoint Presentation',NULL,NULL),(75,'ps','application/postscript','pdf','Postscript Document',NULL,NULL),(76,'qt','video/quicktime',NULL,'Video File',NULL,NULL),(77,'ra','audio/x-realaudio',NULL,'',NULL,NULL),(78,'ram','audio/x-pn-realaudio',NULL,'',NULL,NULL),(79,'ras','image/x-cmu-raster','image','',NULL,NULL),(80,'rgb','image/x-rgb','image','',NULL,NULL),(81,'rm','audio/x-pn-realaudio',NULL,'',NULL,NULL),(82,'roff','application/x-troff',NULL,'',NULL,NULL),(83,'rpm','audio/x-pn-realaudio-plugin',NULL,'',NULL,NULL),(84,'rtf','text/rtf',NULL,'',NULL,NULL),(85,'rtx','text/richtext',NULL,'',NULL,NULL),(86,'sgm','text/sgml',NULL,'',NULL,NULL),(87,'sgml','text/sgml',NULL,'',NULL,NULL),(88,'sh','application/x-sh',NULL,'',NULL,NULL),(89,'shar','application/x-shar',NULL,'',NULL,NULL),(90,'silo','model/mesh',NULL,'',NULL,NULL),(91,'sit','application/x-stuffit',NULL,'',NULL,NULL),(92,'skd','application/x-koan',NULL,'',NULL,NULL),(93,'skm','application/x-koan',NULL,'',NULL,NULL),(94,'skp','application/x-koan',NULL,'',NULL,NULL),(95,'skt','application/x-koan',NULL,'',NULL,NULL),(96,'smi','application/smil',NULL,'',NULL,NULL),(97,'smil','application/smil',NULL,'',NULL,NULL),(98,'snd','audio/basic',NULL,'',NULL,NULL),(99,'spl','application/x-futuresplash',NULL,'',NULL,NULL),(100,'src','application/x-wais-source',NULL,'',NULL,NULL),(101,'sv4cpio','application/x-sv4cpio',NULL,'',NULL,NULL),(102,'sv4crc','application/x-sv4crc',NULL,'',NULL,NULL),(103,'swf','application/x-shockwave-flash',NULL,'',NULL,NULL),(104,'t','application/x-troff',NULL,'',NULL,NULL),(105,'tar','application/x-tar','compressed','Tar or Compressed Tar File',NULL,NULL),(106,'tcl','application/x-tcl',NULL,'',NULL,NULL),(107,'tex','application/x-tex',NULL,'',NULL,NULL),(108,'texi','application/x-texinfo',NULL,'',NULL,NULL),(109,'texinfo','application/x-texinfo',NULL,'',NULL,NULL),(110,'tif','image/tiff','image','TIFF Image',NULL,NULL),(111,'tiff','image/tiff','image','TIFF Image',NULL,NULL),(112,'tr','application/x-troff',NULL,'',NULL,NULL),(113,'tsv','text/tab-separated-values',NULL,'',NULL,NULL),(114,'txt','text/plain','text','Plain Text',NULL,NULL),(115,'ustar','application/x-ustar',NULL,'',NULL,NULL),(116,'vcd','application/x-cdlink',NULL,'',NULL,NULL),(117,'vrml','model/vrml',NULL,'',NULL,NULL),(118,'vsd','application/vnd.visio','office','',NULL,NULL),(119,'wav','audio/x-wav',NULL,'',NULL,NULL),(120,'wrl','model/vrml',NULL,'',NULL,NULL),(121,'xbm','image/x-xbitmap','image','',NULL,NULL),(122,'xls','application/vnd.ms-excel','excel','Excel Spreadsheet',NULL,NULL),(123,'xml','text/xml',NULL,'',NULL,NULL),(124,'xpm','image/x-xpixmap','image','',NULL,NULL),(125,'xwd','image/x-xwindowdump','image','',NULL,NULL),(126,'xyz','chemical/x-pdb',NULL,'',NULL,NULL),(127,'zip','application/zip','compressed','ZIP Compressed File',NULL,NULL),(128,'gz','application/x-gzip','compressed','GZIP Compressed File',NULL,NULL),(129,'tgz','application/x-gzip','compressed','Tar or Compressed Tar File',NULL,NULL),(130,'sxw','application/vnd.sun.xml.writer','openoffice','OpenOffice.org Writer Document',NULL,NULL),(131,'stw','application/vnd.sun.xml.writer.template','openoffice','OpenOffice.org File',NULL,NULL),(132,'sxc','application/vnd.sun.xml.calc','openoffice','OpenOffice.org Spreadsheet',NULL,NULL),(133,'stc','application/vnd.sun.xml.calc.template','openoffice','OpenOffice.org File',NULL,NULL),(134,'sxd','application/vnd.sun.xml.draw','openoffice','OpenOffice.org File',NULL,NULL),(135,'std','application/vnd.sun.xml.draw.template','openoffice','OpenOffice.org File',NULL,NULL),(136,'sxi','application/vnd.sun.xml.impress','openoffice','OpenOffice.org Presentation',NULL,NULL),(137,'sti','application/vnd.sun.xml.impress.template','openoffice','OpenOffice.org File',NULL,NULL),(138,'sxg','application/vnd.sun.xml.writer.global','openoffice','OpenOffice.org File',NULL,NULL),(139,'sxm','application/vnd.sun.xml.math','openoffice','OpenOffice.org File',NULL,NULL),(140,'xlt','application/vnd.ms-excel','excel','Excel Template',NULL,NULL),(141,'dot','application/msword','word','Word Template',NULL,NULL),(142,'bz2','application/x-bzip2','compressed','BZIP2 Compressed File',NULL,NULL),(143,'diff','text/plain','text','Source Diff File',NULL,NULL),(144,'patch','text/plain','text','Patch File',NULL,NULL),(145,'odt','application/vnd.oasis.opendocument.text','opendocument','OpenDocument Text',NULL,NULL),(146,'ott','application/vnd.oasis.opendocument.text-template','opendocument','OpenDocument Text Template',NULL,NULL),(147,'oth','application/vnd.oasis.opendocument.text-web','opendocument','HTML Document Template',NULL,NULL),(148,'odm','application/vnd.oasis.opendocument.text-master','opendocument','OpenDocument Master Document',NULL,NULL),(149,'odg','application/vnd.oasis.opendocument.graphics','opendocument','OpenDocument Drawing',NULL,NULL),(150,'otg','application/vnd.oasis.opendocument.graphics-template','opendocument','OpenDocument Drawing Template',NULL,NULL),(151,'odp','application/vnd.oasis.opendocument.presentation','opendocument','OpenDocument Presentation',NULL,NULL),(152,'otp','application/vnd.oasis.opendocument.presentation-template','opendocument','OpenDocument Presentation Template',NULL,NULL),(153,'ods','application/vnd.oasis.opendocument.spreadsheet','opendocument','OpenDocument Spreadsheet',NULL,NULL),(154,'ots','application/vnd.oasis.opendocument.spreadsheet-template','opendocument','OpenDocument Spreadsheet Template',NULL,NULL),(155,'odc','application/vnd.oasis.opendocument.chart','opendocument','OpenDocument Chart',NULL,NULL),(156,'odf','application/vnd.oasis.opendocument.formula','opendocument','OpenDocument Formula',NULL,NULL),(157,'odb','application/vnd.oasis.opendocument.database','opendocument','OpenDocument Database',NULL,NULL),(158,'odi','application/vnd.oasis.opendocument.image','opendocument','OpenDocument Image',NULL,NULL),(159,'zip','application/x-zip','compressed','ZIP Compressed File',NULL,NULL),(160,'csv','text/csv','spreadsheet','Comma delimited spreadsheet',NULL,NULL),(161,'msi','application/msword','compressed','MSI Installer file',NULL,NULL),(162,'pps','application/vnd.ms-powerpoint','office','Powerpoint Presentation',NULL,NULL);
/*!40000 ALTER TABLE `mime_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `organisations_lookup`
--

LOCK TABLES `organisations_lookup` WRITE;
/*!40000 ALTER TABLE `organisations_lookup` DISABLE KEYS */;
INSERT INTO `organisations_lookup` VALUES (1,'Default Organisation');
/*!40000 ALTER TABLE `organisations_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_assignments`
--

LOCK TABLES `permission_assignments` WRITE;
/*!40000 ALTER TABLE `permission_assignments` DISABLE KEYS */;
INSERT INTO `permission_assignments` VALUES (1,1,1,2),(2,2,1,2),(3,3,1,2),(4,4,1,2),(5,5,1,2),(6,6,1,2),(7,7,1,2),(8,8,1,2);
/*!40000 ALTER TABLE `permission_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_descriptor_groups`
--

LOCK TABLES `permission_descriptor_groups` WRITE;
/*!40000 ALTER TABLE `permission_descriptor_groups` DISABLE KEYS */;
INSERT INTO `permission_descriptor_groups` VALUES (2,1);
/*!40000 ALTER TABLE `permission_descriptor_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_descriptor_roles`
--

LOCK TABLES `permission_descriptor_roles` WRITE;
/*!40000 ALTER TABLE `permission_descriptor_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_descriptor_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_descriptor_users`
--

LOCK TABLES `permission_descriptor_users` WRITE;
/*!40000 ALTER TABLE `permission_descriptor_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_descriptor_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_descriptors`
--

LOCK TABLES `permission_descriptors` WRITE;
/*!40000 ALTER TABLE `permission_descriptors` DISABLE KEYS */;
INSERT INTO `permission_descriptors` VALUES (1,'d41d8cd98f00b204e9800998ecf8427e',''),(2,'a689e7c4dc953de8d93b1ed4843b2dfe','group(1)');
/*!40000 ALTER TABLE `permission_descriptors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_dynamic_assignments`
--

LOCK TABLES `permission_dynamic_assignments` WRITE;
/*!40000 ALTER TABLE `permission_dynamic_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_dynamic_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_dynamic_conditions`
--

LOCK TABLES `permission_dynamic_conditions` WRITE;
/*!40000 ALTER TABLE `permission_dynamic_conditions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_dynamic_conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_lookup_assignments`
--

LOCK TABLES `permission_lookup_assignments` WRITE;
/*!40000 ALTER TABLE `permission_lookup_assignments` DISABLE KEYS */;
INSERT INTO `permission_lookup_assignments` VALUES (1,1,1,1),(2,2,1,1),(3,3,1,1),(4,1,2,2),(5,2,2,2),(6,3,2,2),(7,1,3,2),(8,2,3,2),(9,3,3,2),(10,4,3,2),(11,5,3,2),(12,1,4,2),(13,2,4,2),(14,3,4,2),(15,4,4,2),(16,5,4,2),(17,6,4,2),(18,1,5,2),(19,2,5,2),(20,3,5,2),(21,4,5,2),(22,5,5,2),(23,6,5,2),(24,7,5,2);
/*!40000 ALTER TABLE `permission_lookup_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_lookups`
--

LOCK TABLES `permission_lookups` WRITE;
/*!40000 ALTER TABLE `permission_lookups` DISABLE KEYS */;
INSERT INTO `permission_lookups` VALUES (1),(2),(3),(4),(5);
/*!40000 ALTER TABLE `permission_lookups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_objects`
--

LOCK TABLES `permission_objects` WRITE;
/*!40000 ALTER TABLE `permission_objects` DISABLE KEYS */;
INSERT INTO `permission_objects` VALUES (1);
/*!40000 ALTER TABLE `permission_objects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'ktcore.permissions.read','Read',1),(2,'ktcore.permissions.write','Write',1),(3,'ktcore.permissions.addFolder','Add Folder',1),(4,'ktcore.permissions.security','Manage security',1),(5,'ktcore.permissions.delete','Delete',1),(6,'ktcore.permissions.workflow','Manage workflow',1),(7,'ktcore.permissions.folder_details','Folder Details',1),(8,'ktcore.permissions.folder_rename','Rename Folder',1);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `plugin_rss`
--

LOCK TABLES `plugin_rss` WRITE;
/*!40000 ALTER TABLE `plugin_rss` DISABLE KEYS */;
/*!40000 ALTER TABLE `plugin_rss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `plugins`
--

LOCK TABLES `plugins` WRITE;
/*!40000 ALTER TABLE `plugins` DISABLE KEYS */;
INSERT INTO `plugins` VALUES
	(1,'ktcore.tagcloud.plugin','plugins/tagcloud/TagCloudPlugin.php',0,0,NULL,0,'Tag Cloud Plugin'),
	(2,'ktcore.rss.plugin','plugins/rssplugin/RSSPlugin.php',0,0,NULL,0,'RSS Plugin'),
	(3,'ktcore.language.plugin','plugins/ktcore/KTCoreLanguagePlugin.php',0,0,NULL,0,'Core Language Support'),
	(4,'ktcore.plugin','plugins/ktcore/KTCorePlugin.php',0,0,NULL,0,'Core Application Functionality'),
	(5,'ktstandard.adminversion.plugin','plugins/ktstandard/AdminVersionPlugin/AdminVersionPlugin.php',0,0,NULL,0,'Admin Version Notifier'),
	(6,'ktstandard.ldapauthentication.plugin','plugins/ktstandard/KTLDAPAuthenticationPlugin.php',0,0,NULL,0,'LDAP Authentication Plugin'),
	(7,'ktstandard.pdf.plugin','plugins/ktstandard/PDFGeneratorPlugin.php',0,0,NULL,0,'PDF Generator Plugin'),
	(8,'ktstandard.bulkexport.plugin','plugins/ktstandard/KTBulkExportPlugin.php',0,0,NULL,0,'Bulk Export Plugin'),
	(9,'ktstandard.immutableaction.plugin','plugins/ktstandard/ImmutableActionPlugin.php',0,0,NULL,0,'Immutable action plugin'),
	(10,'ktstandard.subscriptions.plugin','plugins/ktstandard/KTSubscriptions.php',0,0,NULL,0,'Subscription Plugin'),
	(11,'ktstandard.discussion.plugin','plugins/ktstandard/KTDiscussion.php',0,0,NULL,0,'Document Discussions Plugin'),
	(12,'ktstandard.email.plugin','plugins/ktstandard/KTEmail.php',0,0,NULL,0,'Email Plugin'),
	(13,'ktstandard.indexer.plugin','plugins/ktstandard/KTIndexer.php',0,0,NULL,0,'Full-text Content Indexing'),
	(14,'ktstandard.documentlinks.plugin','plugins/ktstandard/KTDocumentLinks.php',0,0,NULL,0,'Inter-document linking'),
	(15,'ktstandard.workflowassociation.plugin','plugins/ktstandard/KTWorkflowAssociation.php',0,0,NULL,0,'Workflow Association Plugin'),
	(16,'ktstandard.workflowassociation.documenttype.plugin','plugins/ktstandard/workflow/TypeAssociator.php',0,0,NULL,0,'Workflow allocation by document type'),
	(17,'ktstandard.workflowassociation.folder.plugin','plugins/ktstandard/workflow/FolderAssociator.php',0,0,NULL,0,'Workflow allocation by location'),
	(18,'ktstandard.disclaimers.plugin','plugins/ktstandard/KTDisclaimers.php',0,0,NULL,0,'Disclaimers Plugin'),
	(19,'nbm.browseable.plugin','plugins/browseabledashlet/BrowseableDashletPlugin.php',0,0,NULL,0,'Orphaned Folders Plugin'),
	(20,'ktstandard.ktwebdavdashlet.plugin','plugins/ktstandard/KTWebDAVDashletPlugin.php',0,0,NULL,0,'WebDAV Dashlet Plugin'),
	(21,'ktcore.housekeeper.plugin','plugins/housekeeper/HouseKeeperPlugin.php',0,0,NULL,0,'Housekeeper');
/*!40000 ALTER TABLE `plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `role_allocations`
--

LOCK TABLES `role_allocations` WRITE;
/*!40000 ALTER TABLE `role_allocations` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_allocations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (-4,'Authenticated Users'),(4,'Creator'),(-3,'Everyone'),(-2,'Owner'),(2,'Publisher'),(3,'Reviewer');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `saved_searches`
--

LOCK TABLES `saved_searches` WRITE;
/*!40000 ALTER TABLE `saved_searches` DISABLE KEYS */;
/*!40000 ALTER TABLE `saved_searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `scheduler_tasks`
--

LOCK TABLES `scheduler_tasks` WRITE;
/*!40000 ALTER TABLE `scheduler_tasks` DISABLE KEYS */;
INSERT INTO `scheduler_tasks` VALUES
(1,'Indexing','search2/indexing/bin/cronIndexer.php','',0,'1min','2007-10-01',NULL,0),
(2,'Index Migration','search2/indexing/bin/cronMigration.php','',0,'5mins','2007-10-01',NULL,0),
(3,'Index Optimisation','search2/indexing/bin/optimise.php','',0,'weekly','2007-10-01',NULL,0);
/*!40000 ALTER TABLE `scheduler_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `search_document_user_link`
--

LOCK TABLES `search_document_user_link` WRITE;
/*!40000 ALTER TABLE `search_document_user_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_document_user_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `search_ranking`
--

LOCK TABLES `search_ranking` WRITE;
/*!40000 ALTER TABLE `search_ranking` DISABLE KEYS */;
INSERT INTO `search_ranking` VALUES ('Discussion','',150,'S'),('documents','checked_out_user_id',1,'T'),('documents','created',1,'T'),('documents','creator_id',1,'T'),('documents','id',1,'T'),('documents','immutable',1,'T'),('documents','is_checked_out',1,'T'),('documents','modified',1,'T'),('documents','modified_user_id',1,'T'),('documents','title',300,'T'),('DocumentText','',100,'S'),('document_content_version','filesize',1,'T'),('document_content_version','filename',10,'T'),('document_metadata_version','document_type_id',1,'T'),('document_metadata_version','name',1,'T'),('document_metadata_version','workflow_id',1,'T'),('document_metadata_version','workflow_state_id',1,'T'),('tag_words','tag',1,'T');
/*!40000 ALTER TABLE `search_ranking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `search_saved`
--

LOCK TABLES `search_saved` WRITE;
/*!40000 ALTER TABLE `search_saved` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_saved` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `search_saved_events`
--

LOCK TABLES `search_saved_events` WRITE;
/*!40000 ALTER TABLE `search_saved_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_saved_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `status_lookup`
--

LOCK TABLES `status_lookup` WRITE;
/*!40000 ALTER TABLE `status_lookup` DISABLE KEYS */;
INSERT INTO `status_lookup` VALUES (1,'Live'),(2,'Published'),(3,'Deleted'),(4,'Archived'),(5,'Incomplete'),(6,'Version Deleted');
/*!40000 ALTER TABLE `status_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (1,'lastIndexUpdate','0'),(2,'knowledgeTreeVersion','3.5'),(3,'databaseVersion','3.5.0');
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tag_words`
--

LOCK TABLES `tag_words` WRITE;
/*!40000 ALTER TABLE `tag_words` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `time_period`
--

LOCK TABLES `time_period` WRITE;
/*!40000 ALTER TABLE `time_period` DISABLE KEYS */;
/*!40000 ALTER TABLE `time_period` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `time_unit_lookup`
--

LOCK TABLES `time_unit_lookup` WRITE;
/*!40000 ALTER TABLE `time_unit_lookup` DISABLE KEYS */;
INSERT INTO `time_unit_lookup` VALUES (1,'Years'),(2,'Months'),(3,'Days');
/*!40000 ALTER TABLE `time_unit_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `trigger_selection`
--

LOCK TABLES `trigger_selection` WRITE;
/*!40000 ALTER TABLE `trigger_selection` DISABLE KEYS */;
/*!40000 ALTER TABLE `trigger_selection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `type_workflow_map`
--

LOCK TABLES `type_workflow_map` WRITE;
/*!40000 ALTER TABLE `type_workflow_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `type_workflow_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `units_lookup`
--

LOCK TABLES `units_lookup` WRITE;
/*!40000 ALTER TABLE `units_lookup` DISABLE KEYS */;
/*!40000 ALTER TABLE `units_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `units_organisations_link`
--

LOCK TABLES `units_organisations_link` WRITE;
/*!40000 ALTER TABLE `units_organisations_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `units_organisations_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `upgrades`
--

LOCK TABLES `upgrades` WRITE;
/*!40000 ALTER TABLE `upgrades` DISABLE KEYS */;
INSERT INTO `upgrades` VALUES (1,'sql*2.0.6*0*2.0.6/create_upgrade_table.sql','Database upgrade to version 2.0.6: Create upgrade table','2005-06-16 00:30:06',1,'upgrade*2.0.6*0*upgrade2.0.6'),(2,'upgrade*2.0.6*0*upgrade2.0.6','Upgrade from version 2.0.2 to 2.0.6','2005-06-16 00:30:06',1,'upgrade*2.0.6*0*upgrade2.0.6'),(3,'func*2.0.6*0*addTemplateMimeTypes','Add MIME types for Excel and Word templates','2005-06-16 00:30:06',1,'upgrade*2.0.6*0*upgrade2.0.6'),(4,'sql*2.0.6*0*2.0.6/add_email_attachment_transaction_type.sql','Database upgrade to version 2.0.6: Add email attachment transaction type','2005-06-16 00:30:06',1,'upgrade*2.0.6*0*upgrade2.0.6'),(5,'sql*2.0.6*0*2.0.6/create_link_type_table.sql','Database upgrade to version 2.0.6: Create link type table','2005-06-16 00:30:06',1,'upgrade*2.0.6*0*upgrade2.0.6'),(6,'sql*2.0.6*1*2.0.6/1-update_database_version.sql','Database upgrade to version 2.0.6: Update database version','2005-06-16 00:30:06',1,'upgrade*2.0.6*0*upgrade2.0.6'),(7,'upgrade*2.0.7*0*upgrade2.0.7','Upgrade from version 2.0.7 to 2.0.7','2005-07-21 22:35:15',1,'upgrade*2.0.7*0*upgrade2.0.7'),(8,'sql*2.0.7*0*2.0.7/document_link_update.sql','Database upgrade to version 2.0.7: Document link update','2005-07-21 22:35:16',1,'upgrade*2.0.7*0*upgrade2.0.7'),(9,'sql*2.0.8*0*2.0.8/nestedgroups.sql','Database upgrade to version 2.0.8: Nestedgroups','2005-08-02 16:02:06',1,'upgrade*2.0.8*0*upgrade2.0.8'),(10,'sql*2.0.8*0*2.0.8/help_replacement.sql','Database upgrade to version 2.0.8: Help replacement','2005-08-02 16:02:06',1,'upgrade*2.0.8*0*upgrade2.0.8'),(11,'upgrade*2.0.8*0*upgrade2.0.8','Upgrade from version 2.0.7 to 2.0.8','2005-08-02 16:02:06',1,'upgrade*2.0.8*0*upgrade2.0.8'),(12,'sql*2.0.8*0*2.0.8/permissions.sql','Database upgrade to version 2.0.8: Permissions','2005-08-02 16:02:07',1,'upgrade*2.0.8*0*upgrade2.0.8'),(13,'func*2.0.8*1*setPermissionObject','Set the permission object in charge of a document or folder','2005-08-02 16:02:07',1,'upgrade*2.0.8*0*upgrade2.0.8'),(14,'sql*2.0.8*1*2.0.8/1-metadata_versions.sql','Database upgrade to version 2.0.8: Metadata versions','2005-08-02 16:02:07',1,'upgrade*2.0.8*0*upgrade2.0.8'),(15,'sql*2.0.8*2*2.0.8/2-permissions.sql','Database upgrade to version 2.0.8: Permissions','2005-08-02 16:02:07',1,'upgrade*2.0.8*0*upgrade2.0.8'),(16,'sql*2.0.9*0*2.0.9/storagemanager.sql','','0000-00-00 00:00:00',1,NULL),(17,'sql*2.0.9*0*2.0.9/metadata_tree.sql','','0000-00-00 00:00:00',1,NULL),(18,'sql*2.0.9*0*2.0.9/document_incomplete.sql','','0000-00-00 00:00:00',1,NULL),(20,'upgrade*2.99.1*0*upgrade2.99.1','Upgrade from version 2.0.8 to 2.99.1','2005-10-07 14:26:15',1,'upgrade*2.99.1*0*upgrade2.99.1'),(21,'sql*2.99.1*0*2.99.1/workflow.sql','Database upgrade to version 2.99.1: Workflow','2005-10-07 14:26:15',1,'upgrade*2.99.1*0*upgrade2.99.1'),(22,'sql*2.99.1*0*2.99.1/fieldsets.sql','Database upgrade to version 2.99.1: Fieldsets','2005-10-07 14:26:16',1,'upgrade*2.99.1*0*upgrade2.99.1'),(23,'func*2.99.1*1*createFieldSets','Create a fieldset for each field without one','2005-10-07 14:26:16',1,'upgrade*2.99.1*0*upgrade2.99.1'),(24,'sql*2.99.2*0*2.99.2/saved_searches.sql','','0000-00-00 00:00:00',1,NULL),(25,'sql*2.99.2*0*2.99.2/transactions.sql','','0000-00-00 00:00:00',1,NULL),(26,'sql*2.99.2*0*2.99.2/field_mandatory.sql','','0000-00-00 00:00:00',1,NULL),(27,'sql*2.99.2*0*2.99.2/fieldsets_system.sql','','0000-00-00 00:00:00',1,NULL),(28,'sql*2.99.2*0*2.99.2/permission_by_user_and_roles.sql','','0000-00-00 00:00:00',1,NULL),(29,'sql*2.99.2*0*2.99.2/disabled_metadata.sql','','0000-00-00 00:00:00',1,NULL),(30,'sql*2.99.2*0*2.99.2/searchable_text.sql','','0000-00-00 00:00:00',1,NULL),(31,'sql*2.99.2*0*2.99.2/workflow.sql','','0000-00-00 00:00:00',1,NULL),(32,'sql*2.99.2*1*2.99.2/1-constraints.sql','','0000-00-00 00:00:00',1,NULL),(33,'sql*2.99.3*0*2.99.3/notifications.sql','','0000-00-00 00:00:00',1,NULL),(34,'sql*2.99.3*0*2.99.3/last_modified_user.sql','','0000-00-00 00:00:00',1,NULL),(35,'sql*2.99.3*0*2.99.3/authentication_sources.sql','','0000-00-00 00:00:00',1,NULL),(36,'sql*2.99.3*0*2.99.3/document_fields_constraints.sql','','0000-00-00 00:00:00',1,NULL),(37,'sql*2.99.5*0*2.99.5/dashlet_disabling.sql','','0000-00-00 00:00:00',1,NULL),(38,'sql*2.99.5*0*2.99.5/role_allocations.sql','','0000-00-00 00:00:00',1,NULL),(39,'sql*2.99.5*0*2.99.5/transaction_namespaces.sql','','0000-00-00 00:00:00',1,NULL),(40,'sql*2.99.5*0*2.99.5/fieldset_field_descriptions.sql','','0000-00-00 00:00:00',1,NULL),(41,'sql*2.99.5*0*2.99.5/role_changes.sql','','0000-00-00 00:00:00',1,NULL),(42,'sql*2.99.6*0*2.99.6/table_cleanup.sql','Database upgrade to version 2.99.6: Table cleanup','2006-01-20 17:04:05',1,'upgrade*2.99.7*99*upgrade2.99.7'),(43,'sql*2.99.6*0*2.99.6/plugin-registration.sql','Database upgrade to version 2.99.6: Plugin-registration','2006-01-20 17:04:05',1,'upgrade*2.99.7*99*upgrade2.99.7'),(44,'sql*2.99.7*0*2.99.7/documents_normalisation.sql','Database upgrade to version 2.99.7: Documents normalisation','2006-01-20 17:04:05',1,'upgrade*2.99.7*99*upgrade2.99.7'),(45,'sql*2.99.7*0*2.99.7/help_replacement.sql','Database upgrade to version 2.99.7: Help replacement','2006-01-20 17:04:05',1,'upgrade*2.99.7*99*upgrade2.99.7'),(46,'sql*2.99.7*0*2.99.7/table_cleanup.sql','Database upgrade to version 2.99.7: Table cleanup','2006-01-20 17:04:07',1,'upgrade*2.99.7*99*upgrade2.99.7'),(47,'func*2.99.7*1*normaliseDocuments','Normalise the documents table','2006-01-20 17:04:07',1,'upgrade*2.99.7*99*upgrade2.99.7'),(48,'sql*2.99.7*10*2.99.7/10-documents_normalisation.sql','Database upgrade to version 2.99.7: Documents normalisation','2006-01-20 17:04:07',1,'upgrade*2.99.7*99*upgrade2.99.7'),(49,'sql*2.99.7*20*2.99.7/20-fields.sql','Database upgrade to version 2.99.7: Fields','2006-01-20 17:04:07',1,'upgrade*2.99.7*99*upgrade2.99.7'),(50,'upgrade*2.99.7*99*upgrade2.99.7','Upgrade from version 2.99.5 to 2.99.7','2006-01-20 17:04:07',1,'upgrade*2.99.7*99*upgrade2.99.7'),(51,'sql*2.99.7*0*2.99.7/discussion.sql','','0000-00-00 00:00:00',1,NULL),(52,'func*2.99.7*-1*applyDiscussionUpgrade','func upgrade to version 2.99.7 phase -1','2006-02-06 12:23:41',1,'upgrade*2.99.8*99*upgrade2.99.8'),(53,'sql*2.99.8*0*2.99.8/mime_types.sql','Database upgrade to version 2.99.8: Mime types','2006-02-06 12:23:41',1,'upgrade*2.99.8*99*upgrade2.99.8'),(54,'sql*2.99.8*0*2.99.8/category-correction.sql','Database upgrade to version 2.99.8: Category-correction','2006-02-06 12:23:41',1,'upgrade*2.99.8*99*upgrade2.99.8'),(55,'sql*2.99.8*0*2.99.8/trigger_selection.sql','Database upgrade to version 2.99.8: Trigger selection','2006-02-06 12:23:41',1,'upgrade*2.99.8*99*upgrade2.99.8'),(56,'sql*2.99.8*0*2.99.8/units.sql','Database upgrade to version 2.99.8: Units','2006-02-06 12:23:41',1,'upgrade*2.99.8*99*upgrade2.99.8'),(57,'sql*2.99.8*0*2.99.8/type_workflow_map.sql','Database upgrade to version 2.99.8: Type workflow map','2006-02-06 12:23:41',1,'upgrade*2.99.8*99*upgrade2.99.8'),(58,'sql*2.99.8*0*2.99.8/disabled_documenttypes.sql','Database upgrade to version 2.99.8: Disabled documenttypes','2006-02-06 12:23:42',1,'upgrade*2.99.8*99*upgrade2.99.8'),(59,'func*2.99.8*1*fixUnits','func upgrade to version 2.99.8 phase 1','2006-02-06 12:23:42',1,'upgrade*2.99.8*99*upgrade2.99.8'),(60,'sql*2.99.8*10*2.99.8/10-units.sql','Database upgrade to version 2.99.8: Units','2006-02-06 12:23:42',1,'upgrade*2.99.8*99*upgrade2.99.8'),(61,'sql*2.99.8*15*2.99.8/15-status.sql','Database upgrade to version 2.99.8: Status','2006-02-06 12:23:42',1,'upgrade*2.99.8*99*upgrade2.99.8'),(62,'sql*2.99.8*20*2.99.8/20-state_permission_assignments.sql','Database upgrade to version 2.99.8: State permission assignments','2006-02-06 12:23:42',1,'upgrade*2.99.8*99*upgrade2.99.8'),(63,'sql*2.99.8*25*2.99.8/25-authentication_details.sql','Database upgrade to version 2.99.8: Authentication details','2006-02-06 12:23:42',1,'upgrade*2.99.8*99*upgrade2.99.8'),(64,'upgrade*2.99.8*99*upgrade2.99.8','Upgrade from version 2.99.7 to 2.99.8','2006-02-06 12:23:42',1,'upgrade*2.99.8*99*upgrade2.99.8'),(65,'func*2.99.9*0*createSecurityDeletePermissions','Create the Core: Manage Security and Core: Delete permissions','2006-02-28 09:23:21',1,'upgrade*3.0*99*upgrade3.0'),(66,'func*2.99.9*0*createLdapAuthenticationProvider','Create an LDAP authentication source based on your KT2 LDAP settings (must keep copy of config/environment.php to work)','2006-02-28 09:23:21',1,'upgrade*3.0*99*upgrade3.0'),(67,'sql*2.99.9*0*2.99.9/mimetype-friendly.sql','Database upgrade to version 2.99.9: Mimetype-friendly','2006-02-28 09:23:21',1,'upgrade*3.0*99*upgrade3.0'),(68,'sql*2.99.9*5*2.99.9/5-opendocument-mime-types.sql','Database upgrade to version 2.99.9: Opendocument-mime-types','2006-02-28 09:23:21',1,'upgrade*3.0*99*upgrade3.0'),(69,'sql*3.0*0*3.0/zipfile-mimetype.sql','Database upgrade to version 3.0: Zipfile-mimetype','2006-02-28 09:23:21',1,'upgrade*3.0*99*upgrade3.0'),(70,'upgrade*3.0*99*upgrade3.0','Upgrade from version 2.99.8 to 3.0','2006-02-28 09:23:21',1,'upgrade*3.0*99*upgrade3.0'),(71,'sql*3.0.1.1*0*3.0.1.1/document_role_allocations.sql','Database upgrade to version 3.0.1.1: Document role allocations','2006-03-28 11:22:19',1,'upgrade*3.0.1.1*99*upgrade3.0.1.1'),(72,'upgrade*3.0.1.1*99*upgrade3.0.1.1','Upgrade from version 3.0 to 3.0.1.1','2006-03-28 11:22:19',1,'upgrade*3.0.1.1*99*upgrade3.0.1.1'),(73,'sql*3.0.1.2*0*3.0.1.2/user_more_authentication_details.sql','Database upgrade to version 3.0.1.2: User more authentication details','2006-04-07 16:50:28',1,'upgrade*3.0.1.2*99*upgrade3.0.1.2'),(74,'upgrade*3.0.1.2*99*upgrade3.0.1.2','Upgrade from version 3.0.1.1 to 3.0.1.2','2006-04-07 16:50:28',1,'upgrade*3.0.1.2*99*upgrade3.0.1.2'),(75,'sql*3.0.1.2*0*3.0.1.2/owner_role_move.sql','Database upgrade to version 3.0.1.2: Owner role move','2006-04-18 11:06:34',1,'upgrade*3.0.1.4*99*upgrade3.0.1.4'),(76,'func*3.0.1.3*0*addTransactionTypes3013','Add new folder transaction types','2006-04-18 11:06:34',1,'upgrade*3.0.1.4*99*upgrade3.0.1.4'),(77,'sql*3.0.1.3*0*3.0.1.3/user_history.sql','Database upgrade to version 3.0.1.3: User history','2006-04-18 11:06:34',1,'upgrade*3.0.1.4*99*upgrade3.0.1.4'),(78,'sql*3.0.1.3*0*3.0.1.3/folder_transactions.sql','Database upgrade to version 3.0.1.3: Folder transactions','2006-04-18 11:06:34',1,'upgrade*3.0.1.4*99*upgrade3.0.1.4'),(79,'sql*3.0.1.3*0*3.0.1.3/plugin-unavailable.sql','Database upgrade to version 3.0.1.3: Plugin-unavailable','2006-04-18 11:06:34',1,'upgrade*3.0.1.4*99*upgrade3.0.1.4'),(80,'func*3.0.1.4*0*createWorkflowPermission','Create the Core: Manage Workflow','2006-04-18 11:06:34',1,'upgrade*3.0.1.4*99*upgrade3.0.1.4'),(81,'upgrade*3.0.1.4*99*upgrade3.0.1.4','Upgrade from version 3.0.1.2 to 3.0.1.4','2006-04-18 11:06:34',1,'upgrade*3.0.1.4*99*upgrade3.0.1.4'),(82,'sql*3.0.1.5*0*3.0.1.5/anonymous-user.sql','Database upgrade to version 3.0.1.5: Anonymous-user','2006-04-18 12:38:41',1,'upgrade*3.0.1.5*99*upgrade3.0.1.5'),(83,'upgrade*3.0.1.5*99*upgrade3.0.1.5','Upgrade from version 3.0.1.4 to 3.0.1.5','2006-04-18 12:38:41',1,'upgrade*3.0.1.5*99*upgrade3.0.1.5'),(84,'sql*3.0.1.6*0*3.0.1.6/workflow-into-metadata.sql','Database upgrade to version 3.0.1.6: Workflow-into-metadata','2006-04-20 14:22:24',1,'upgrade*3.0.1.6*99*upgrade3.0.1.6'),(85,'upgrade*3.0.1.6*99*upgrade3.0.1.6','Upgrade from version 3.0.1.5 to 3.0.1.6','2006-04-20 14:22:24',1,'upgrade*3.0.1.6*99*upgrade3.0.1.6'),(86,'sql*3.0.1.7*0*3.0.1.7/session_id.sql','Database upgrade to version 3.0.1.7: Session id','2006-04-20 17:03:55',1,'upgrade*3.0.1.7*99*upgrade3.0.1.7'),(87,'upgrade*3.0.1.7*99*upgrade3.0.1.7','Upgrade from version 3.0.1.6 to 3.0.1.7','2006-04-20 17:03:56',1,'upgrade*3.0.1.7*99*upgrade3.0.1.7'),(88,'sql*3.0.1.8*0*3.0.1.8/friendly-plugins.sql','Database upgrade to version 3.0.1.8: Friendly-plugins','2006-04-23 12:54:12',1,'upgrade*3.0.1.8*99*upgrade3.0.1.8'),(89,'sql*3.0.1.8*0*3.0.1.8/longer-text.sql','Database upgrade to version 3.0.1.8: Longer-text','2006-04-23 12:54:12',1,'upgrade*3.0.1.8*99*upgrade3.0.1.8'),(90,'sql*3.0.1.8*0*3.0.1.8/admin-mode-logging.sql','Database upgrade to version 3.0.1.8: Admin-mode-logging','2006-04-23 12:54:12',1,'upgrade*3.0.1.8*99*upgrade3.0.1.8'),(91,'upgrade*3.0.1.8*99*upgrade3.0.1.8','Upgrade from version 3.0.1.7 to 3.0.1.8','2006-04-23 12:54:12',1,'upgrade*3.0.1.8*99*upgrade3.0.1.8'),(92,'upgrade*3.0.2*99*upgrade3.0.2','Upgrade from version 3.0.1.8 to 3.0.2','2006-05-02 10:08:13',1,'upgrade*3.0.2*99*upgrade3.0.2'),(93,'sql*3.0.2.1*0*3.0.2.1/disclaimer-help-files.sql','Database upgrade to version 3.0.2.1: Disclaimer-help-files','2006-05-25 16:04:23',1,'upgrade*3.0.2.2*99*upgrade3.0.2.2'),(94,'sql*3.0.2.2*0*3.0.2.2/folder_search.sql','Database upgrade to version 3.0.2.2: Folder search','2006-05-25 16:04:23',1,'upgrade*3.0.2.2*99*upgrade3.0.2.2'),(95,'upgrade*3.0.2.2*99*upgrade3.0.2.2','Upgrade from version 3.0.2 to 3.0.2.2','2006-05-25 16:04:24',1,'upgrade*3.0.2.2*99*upgrade3.0.2.2'),(96,'sql*3.0.2.3*0*3.0.2.3/msi-filetype.sql','Database upgrade to version 3.0.2.3: Msi-filetype','2006-05-30 10:55:58',1,'upgrade*3.0.2.4*99*upgrade3.0.2.4'),(97,'sql*3.0.2.4*0*3.0.2.4/discussion-fulltext.sql','Database upgrade to version 3.0.2.4: Discussion-fulltext','2006-05-30 10:55:59',1,'upgrade*3.0.2.4*99*upgrade3.0.2.4'),(98,'upgrade*3.0.2.4*99*upgrade3.0.2.4','Upgrade from version 3.0.2.2 to 3.0.2.4','2006-05-30 10:55:59',1,'upgrade*3.0.2.4*99*upgrade3.0.2.4'),(99,'upgrade*3.0.3*99*upgrade3.0.3','Upgrade from version 3.0.2.4 to 3.0.3','2006-05-31 13:02:04',1,'upgrade*3.0.3*99*upgrade3.0.3'),(100,'sql*3.0.3.1*0*3.0.3.1/utf8.sql','Database upgrade to version 3.0.3.1: Utf8','2006-07-12 12:00:33',1,'upgrade*3.0.3.4*99*upgrade3.0.3.4'),(101,'sql*3.0.3.1*0*3.0.3.1/document_immutable.sql','Database upgrade to version 3.0.3.1: Document immutable','2006-07-12 12:00:33',1,'upgrade*3.0.3.4*99*upgrade3.0.3.4'),(102,'sql*3.0.3.1*0*3.0.3.1/workflow-triggers.sql','Database upgrade to version 3.0.3.1: Workflow-triggers','2006-07-12 12:00:33',1,'upgrade*3.0.3.4*99*upgrade3.0.3.4'),(103,'func*3.0.3.2*0*createFolderDetailsPermission','Create the Core: Folder Details permission','2006-07-12 12:00:33',1,'upgrade*3.0.3.4*99*upgrade3.0.3.4'),(104,'func*3.0.3.3*0*generateWorkflowTriggers','Migrate old in-transition guards to triggers','2006-07-12 12:00:33',1,'upgrade*3.0.3.4*99*upgrade3.0.3.4'),(105,'sql*3.0.3.4*0*3.0.3.4/column_entries.sql','Database upgrade to version 3.0.3.4: Column entries','2006-07-12 12:00:33',1,'upgrade*3.0.3.4*99*upgrade3.0.3.4'),(106,'sql*3.0.3.4*0*3.0.3.4/bulk_export_transaction.sql','Database upgrade to version 3.0.3.4: Bulk export transaction','2006-07-12 12:00:33',1,'upgrade*3.0.3.4*99*upgrade3.0.3.4'),(107,'upgrade*3.0.3.4*99*upgrade3.0.3.4','Upgrade from version 3.0.3 to 3.0.3.4','2006-07-12 12:00:34',1,'upgrade*3.0.3.4*99*upgrade3.0.3.4'),(108,'sql*3.0.3.5*0*3.0.3.5/notifications_data_text.sql','Database upgrade to version 3.0.3.5: Notifications data text','2006-07-14 15:26:49',1,'upgrade*3.0.3.5*99*upgrade3.0.3.5'),(109,'upgrade*3.0.3.5*99*upgrade3.0.3.5','Upgrade from version 3.0.3.4 to 3.0.3.5','2006-07-14 15:26:49',1,'upgrade*3.0.3.5*99*upgrade3.0.3.5'),(110,'sql*3.0.3.6*0*3.0.3.6/document-restore.sql','Database upgrade to version 3.0.3.6: Document-restore','2006-07-26 11:48:28',1,'upgrade*3.0.3.7*99*upgrade3.0.3.7'),(111,'func*3.0.3.7*0*rebuildAllPermissions','Rebuild all permissions to ensure correct functioning of permission-definitions.','2006-07-26 11:48:28',1,'upgrade*3.0.3.7*99*upgrade3.0.3.7'),(112,'upgrade*3.0.3.7*99*upgrade3.0.3.7','Upgrade from version 3.0.3.5 to 3.0.3.7','2006-07-26 11:48:28',1,'upgrade*3.0.3.7*99*upgrade3.0.3.7'),(113,'upgrade*3.1*99*upgrade3.1','Upgrade from version 3.0.3.7 to 3.1','2006-07-31 10:41:12',1,'upgrade*3.1*99*upgrade3.1'),(114,'sql*3.1.1*0*3.1.1/parentless-documents.sql','Database upgrade to version 3.1.1: Parentless-documents','2006-08-15 11:58:07',1,'upgrade*3.1.1*99*upgrade3.1.1'),(115,'upgrade*3.1.1*99*upgrade3.1.1','Upgrade from version 3.1 to 3.1.1','2006-08-15 11:58:07',1,'upgrade*3.1.1*99*upgrade3.1.1'),(116,'sql*3.1.2*0*3.1.2/user-disable.sql','Database upgrade to version 3.1.2: User-disable','2006-09-08 17:08:26',1,'upgrade*3.1.2*99*upgrade3.1.2'),(117,'upgrade*3.1.2*99*upgrade3.1.2','Upgrade from version 3.1.1 to 3.1.2','2006-09-08 17:08:26',1,'upgrade*3.1.2*99*upgrade3.1.2'),(118,'func*3.1.5*0*upgradeSavedSearches','Upgrade saved searches to use namespaces instead of integer ids','2006-10-17 12:09:45',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(119,'sql*3.1.6*0*3.1.6/interceptor_instances.sql','Database upgrade to version 3.1.6: Interceptor instances','2006-10-17 12:09:45',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(120,'sql*3.1.6*0*3.1.6/workflow-sanity.sql','Database upgrade to version 3.1.6: Workflow-sanity','2006-10-17 12:09:45',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(121,'sql*3.1.6.2*0*3.1.6.2/workflow_state_disabled_actions.sql','Database upgrade to version 3.1.6.2: Workflow state disabled actions','2006-10-17 12:09:45',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(122,'sql*3.1.6.2*0*3.1.6.2/folder_owner_role.sql','Database upgrade to version 3.1.6.2: Folder owner role','2006-10-17 12:09:45',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(123,'func*3.1.6.3*0*cleanupGroupMembership','Cleanup any old references to missing groups, etc.','2006-10-17 12:09:45',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(124,'sql*3.1.6.3*0*3.1.6.3/groups-integrity.sql','Database upgrade to version 3.1.6.3: Groups-integrity','2006-10-17 12:09:46',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(125,'sql*3.1.6.5*0*3.1.6.5/workflow-state-referencefixes.sql','Database upgrade to version 3.1.6.5: Workflow-state-referencefixes','2006-10-17 12:09:46',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(126,'sql*3.1.6.6*0*3.1.6.6/copy_transaction.sql','Database upgrade to version 3.1.6.6: Copy transaction','2006-10-17 12:09:46',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(127,'sql*3.1.6.7*0*3.1.6.7/sane-names-for-stuff.sql','Database upgrade to version 3.1.6.7: Sane-names-for-stuff','2006-10-17 12:09:46',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(128,'upgrade*3.1.6.7*99*upgrade3.1.6.7','Upgrade from version 3.1.2 to 3.1.6.7','2006-10-17 12:09:46',1,'upgrade*3.1.6.7*99*upgrade3.1.6.7'),(129,'sql*3.3.0.1*0*3.3.0.1/system-settings-to-text.sql','Database upgrade to version 3.3.0.1: System-settings-to-text','2007-01-28 23:49:52',1,'upgrade*3.3.1*99*upgrade3.3.1'),(130,'upgrade*3.3.0.1*99*upgrade3.3.0.1','Upgrade from version 3.1.6.7 to 3.3.0.1','2006-10-30 12:49:33',1,'upgrade*3.3.0.1*99*upgrade3.3.0.1'),(131,'sql*3.3.1*0*3.3.1/rss.sql','Database upgrade to version 3.3.1: Rss','2007-01-28 23:49:52',1,'upgrade*3.3.1*99*upgrade3.3.1'),(132,'upgrade*3.3.1*99*upgrade3.3.1','Upgrade from version 3.3.0.1 to 3.3.1','2007-01-28 23:49:52',1,'upgrade*3.3.1*99*upgrade3.3.1'),(133,'sql*3.3.2*0*3.3.2/tagclouds.sql','Database upgrade to version 3.3.2: Tagclouds','2007-02-23 11:55:09',1,'upgrade*3.3.2*99*upgrade3.3.2'),(134,'upgrade*3.3.2*99*upgrade3.3.2','Upgrade from version 3.3.1 to 3.3.2','2007-02-23 11:55:09',1,'upgrade*3.3.2*99*upgrade3.3.2'),(135,'sql*3.4.0*0*3.4.0/upload_download.sql','Upgrade to version 3.4.0: Upload download','2007-04-17 00:00:00',1,'upgrade*3.4.0*99*upgrade3.4.0'),(136,'upgrade*3.4.0*99*upgrade3.4.0','Upgrade from version 3.3.2 to 3.4.0','2007-04-17 00:00:00',1,'upgrade*3.4.0*99*upgrade3.4.0'),(137,'sql*3.5.0*0*3.5.0/admin_version_path_update.sql','Update Admin Version Plugin Path','2007-08-28 00:00:00',1,'upgrade*3.5.0*99*upgrade3.5.0'),(138,'sql*3.5.0*0*3.5.0/saved_searches.sql','Database upgrade to version 3.5.0: Saved searches','2007-09-25 00:00:00',1,'upgrade*3.5.0*99*upgrade3.5.0'),(139,'sql*3.5.0*0*3.5.0/index_files.sql','Database upgrade to version 3.5.0: Index files','2007-09-25 00:00:00',1,'upgrade*3.5.0*99*upgrade3.5.0'),(140,'sql*3.5.0*0*3.5.0/search_ranking.sql','Database upgrade to version 3.5.0: Search ranking','2007-09-25 00:00:00',1,'upgrade*3.5.0*99*upgrade3.5.0'),(142,'sql*3.5.0*0*3.5.0/document_checkout.sql','Database upgrade to version 3.5.0: Document checkout','2007-09-25 00:00:00',1,'upgrade*3.5.0*99*upgrade3.5.0'),(144,'func*3.5.0*0*cleanupOldKTAdminVersionNotifier','Cleanup any old files from the old KTAdminVersionNotifier','2007-09-25 00:00:00',1,'upgrade*3.5.0*99*upgrade3.5.0'),(145,'upgrade*3.5.0*99*upgrade3.5.0','Upgrade from version 3.4.0 to 3.5.0','2007-09-25 00:00:00',1,'upgrade*3.5.0*99*upgrade3.5.0'),(146,'sql*3.5.0*0*3.5.0/folder_descendants.sql','Database upgrade to version 3.5.0: Folder descendants','2007-10-11 17:41:32',1,'upgrade*3.5.0*99*upgrade3.5.0'),(147,'sql*3.5.0*0*3.5.0/relation_friendly.sql','Database upgrade to version 3.5.0: Relation friendly','2007-10-11 17:41:33',1,'upgrade*3.5.0*99*upgrade3.5.0'),(148,'sql*3.5.0*0*3.5.0/plugin_rss_engine.sql','Database upgrade to version 3.5.0: Plugin rss engine','2007-10-11 17:41:33',1,'upgrade*3.5.0*99*upgrade3.5.0'),(149,'sql*3.5.0*0*3.5.0/document_transaction_type.sql','Database upgrade to version 3.5.0: Document transaction type','2007-10-11 17:41:33',1,'upgrade*3.5.0*99*upgrade3.5.0'),(150,'sql*3.5.0*0*3.5.0/scheduler_tables.sql','Database upgrade to version 3.5.0: Scheduler tables','2007-10-23 15:40:56',1,'upgrade*3.5.0*99*upgrade3.5.0'),(151,'func*3.5.0*0*registerIndexingTasks','Register the required indexing background tasks','2007-10-23 15:40:56',1,'upgrade*3.5.0*99*upgrade3.5.0'),(152,'func*3.5.0*0*updateConfigFile35','Update the config.ini file for 3.5','2007-10-23 15:40:56',1,'upgrade*3.5.0*99*upgrade3.5.0'),(153,'sql*3.5.0*0*3.5.0/mime_types.sql','Database upgrade to version 3.5.0: Mime types','2007-10-23 15:40:58',1,'upgrade*3.5.0*99*upgrade3.5.0');
/*!40000 ALTER TABLE `upgrades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `uploaded_files`
--

LOCK TABLES `uploaded_files` WRITE;
/*!40000 ALTER TABLE `uploaded_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploaded_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_history`
--

LOCK TABLES `user_history` WRITE;
/*!40000 ALTER TABLE `user_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (-2,'anonymous','Anonymous','---------------',0,0,NULL,NULL,0,0,NULL,30000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(1,'admin','Administrator','21232f297a57a5a743894a0e4a801fc3',0,0,'','',1,1,'',1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users_groups_link`
--

LOCK TABLES `users_groups_link` WRITE;
/*!40000 ALTER TABLE `users_groups_link` DISABLE KEYS */;
INSERT INTO `users_groups_link` VALUES (1,1,1);
/*!40000 ALTER TABLE `users_groups_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_actions`
--

LOCK TABLES `workflow_actions` WRITE;
/*!40000 ALTER TABLE `workflow_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_documents`
--

LOCK TABLES `workflow_documents` WRITE;
/*!40000 ALTER TABLE `workflow_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_state_actions`
--

LOCK TABLES `workflow_state_actions` WRITE;
/*!40000 ALTER TABLE `workflow_state_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_state_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_state_disabled_actions`
--

LOCK TABLES `workflow_state_disabled_actions` WRITE;
/*!40000 ALTER TABLE `workflow_state_disabled_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_state_disabled_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_state_permission_assignments`
--

LOCK TABLES `workflow_state_permission_assignments` WRITE;
/*!40000 ALTER TABLE `workflow_state_permission_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_state_permission_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_state_transitions`
--

LOCK TABLES `workflow_state_transitions` WRITE;
/*!40000 ALTER TABLE `workflow_state_transitions` DISABLE KEYS */;
INSERT INTO `workflow_state_transitions` VALUES (2,2),(3,3),(3,4),(5,5),(6,6);
/*!40000 ALTER TABLE `workflow_state_transitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_states`
--

LOCK TABLES `workflow_states` WRITE;
/*!40000 ALTER TABLE `workflow_states` DISABLE KEYS */;
INSERT INTO `workflow_states` VALUES (2,2,'Draft','Draft',NULL,0,0),(3,2,'Approval','Approval',NULL,0,0),(4,2,'Published','Published',NULL,0,0),(5,3,'Draft','Draft',NULL,0,0),(6,3,'Final','Final',NULL,0,0),(7,3,'Published','Published',NULL,0,0);
/*!40000 ALTER TABLE `workflow_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_transitions`
--

LOCK TABLES `workflow_transitions` WRITE;
/*!40000 ALTER TABLE `workflow_transitions` DISABLE KEYS */;
INSERT INTO `workflow_transitions` VALUES (2,2,'Request Approval','Request Approval',3,NULL,NULL,NULL,NULL),(3,2,'Reject','Reject',2,NULL,NULL,NULL,NULL),(4,2,'Approve','Approve',4,NULL,NULL,NULL,NULL),(5,3,'Draft Completed','Draft Completed',6,NULL,NULL,NULL,NULL),(6,3,'Publish','Publish',7,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `workflow_transitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_trigger_instances`
--

LOCK TABLES `workflow_trigger_instances` WRITE;
/*!40000 ALTER TABLE `workflow_trigger_instances` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_trigger_instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflows`
--

LOCK TABLES `workflows` WRITE;
/*!40000 ALTER TABLE `workflows` DISABLE KEYS */;
INSERT INTO `workflows` VALUES (2,'Review Process','Review Process',2,1),(3,'Generate Document','Generate Document',5,1);
/*!40000 ALTER TABLE `workflows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_active_sessions`
--

LOCK TABLES `zseq_active_sessions` WRITE;
/*!40000 ALTER TABLE `zseq_active_sessions` DISABLE KEYS */;
INSERT INTO `zseq_active_sessions` VALUES (1);
/*!40000 ALTER TABLE `zseq_active_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_archive_restoration_request`
--

LOCK TABLES `zseq_archive_restoration_request` WRITE;
/*!40000 ALTER TABLE `zseq_archive_restoration_request` DISABLE KEYS */;
INSERT INTO `zseq_archive_restoration_request` VALUES (1);
/*!40000 ALTER TABLE `zseq_archive_restoration_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_archiving_settings`
--

LOCK TABLES `zseq_archiving_settings` WRITE;
/*!40000 ALTER TABLE `zseq_archiving_settings` DISABLE KEYS */;
INSERT INTO `zseq_archiving_settings` VALUES (1);
/*!40000 ALTER TABLE `zseq_archiving_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_archiving_type_lookup`
--

LOCK TABLES `zseq_archiving_type_lookup` WRITE;
/*!40000 ALTER TABLE `zseq_archiving_type_lookup` DISABLE KEYS */;
INSERT INTO `zseq_archiving_type_lookup` VALUES (2);
/*!40000 ALTER TABLE `zseq_archiving_type_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_authentication_sources`
--

LOCK TABLES `zseq_authentication_sources` WRITE;
/*!40000 ALTER TABLE `zseq_authentication_sources` DISABLE KEYS */;
INSERT INTO `zseq_authentication_sources` VALUES (1);
/*!40000 ALTER TABLE `zseq_authentication_sources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_browse_criteria`
--

LOCK TABLES `zseq_browse_criteria` WRITE;
/*!40000 ALTER TABLE `zseq_browse_criteria` DISABLE KEYS */;
INSERT INTO `zseq_browse_criteria` VALUES (5);
/*!40000 ALTER TABLE `zseq_browse_criteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_column_entries`
--

LOCK TABLES `zseq_column_entries` WRITE;
/*!40000 ALTER TABLE `zseq_column_entries` DISABLE KEYS */;
INSERT INTO `zseq_column_entries` VALUES (14);
/*!40000 ALTER TABLE `zseq_column_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_dashlet_disables`
--

LOCK TABLES `zseq_dashlet_disables` WRITE;
/*!40000 ALTER TABLE `zseq_dashlet_disables` DISABLE KEYS */;
INSERT INTO `zseq_dashlet_disables` VALUES (1);
/*!40000 ALTER TABLE `zseq_dashlet_disables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_data_types`
--

LOCK TABLES `zseq_data_types` WRITE;
/*!40000 ALTER TABLE `zseq_data_types` DISABLE KEYS */;
INSERT INTO `zseq_data_types` VALUES (5);
/*!40000 ALTER TABLE `zseq_data_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_dependant_document_instance`
--

LOCK TABLES `zseq_dependant_document_instance` WRITE;
/*!40000 ALTER TABLE `zseq_dependant_document_instance` DISABLE KEYS */;
INSERT INTO `zseq_dependant_document_instance` VALUES (1);
/*!40000 ALTER TABLE `zseq_dependant_document_instance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_dependant_document_template`
--

LOCK TABLES `zseq_dependant_document_template` WRITE;
/*!40000 ALTER TABLE `zseq_dependant_document_template` DISABLE KEYS */;
INSERT INTO `zseq_dependant_document_template` VALUES (1);
/*!40000 ALTER TABLE `zseq_dependant_document_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_discussion_comments`
--

LOCK TABLES `zseq_discussion_comments` WRITE;
/*!40000 ALTER TABLE `zseq_discussion_comments` DISABLE KEYS */;
INSERT INTO `zseq_discussion_comments` VALUES (1);
/*!40000 ALTER TABLE `zseq_discussion_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_discussion_threads`
--

LOCK TABLES `zseq_discussion_threads` WRITE;
/*!40000 ALTER TABLE `zseq_discussion_threads` DISABLE KEYS */;
INSERT INTO `zseq_discussion_threads` VALUES (1);
/*!40000 ALTER TABLE `zseq_discussion_threads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_archiving_link`
--

LOCK TABLES `zseq_document_archiving_link` WRITE;
/*!40000 ALTER TABLE `zseq_document_archiving_link` DISABLE KEYS */;
INSERT INTO `zseq_document_archiving_link` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_archiving_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_content_version`
--

LOCK TABLES `zseq_document_content_version` WRITE;
/*!40000 ALTER TABLE `zseq_document_content_version` DISABLE KEYS */;
INSERT INTO `zseq_document_content_version` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_content_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_fields`
--

LOCK TABLES `zseq_document_fields` WRITE;
/*!40000 ALTER TABLE `zseq_document_fields` DISABLE KEYS */;
INSERT INTO `zseq_document_fields` VALUES (5);
/*!40000 ALTER TABLE `zseq_document_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_fields_link`
--

LOCK TABLES `zseq_document_fields_link` WRITE;
/*!40000 ALTER TABLE `zseq_document_fields_link` DISABLE KEYS */;
INSERT INTO `zseq_document_fields_link` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_fields_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_link`
--

LOCK TABLES `zseq_document_link` WRITE;
/*!40000 ALTER TABLE `zseq_document_link` DISABLE KEYS */;
INSERT INTO `zseq_document_link` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_link_types`
--

LOCK TABLES `zseq_document_link_types` WRITE;
/*!40000 ALTER TABLE `zseq_document_link_types` DISABLE KEYS */;
INSERT INTO `zseq_document_link_types` VALUES (5);
/*!40000 ALTER TABLE `zseq_document_link_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_metadata_version`
--

LOCK TABLES `zseq_document_metadata_version` WRITE;
/*!40000 ALTER TABLE `zseq_document_metadata_version` DISABLE KEYS */;
INSERT INTO `zseq_document_metadata_version` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_metadata_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_role_allocations`
--

LOCK TABLES `zseq_document_role_allocations` WRITE;
/*!40000 ALTER TABLE `zseq_document_role_allocations` DISABLE KEYS */;
/*!40000 ALTER TABLE `zseq_document_role_allocations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_subscriptions`
--

LOCK TABLES `zseq_document_subscriptions` WRITE;
/*!40000 ALTER TABLE `zseq_document_subscriptions` DISABLE KEYS */;
INSERT INTO `zseq_document_subscriptions` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_tags`
--

LOCK TABLES `zseq_document_tags` WRITE;
/*!40000 ALTER TABLE `zseq_document_tags` DISABLE KEYS */;
INSERT INTO `zseq_document_tags` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_transaction_types_lookup`
--

LOCK TABLES `zseq_document_transaction_types_lookup` WRITE;
/*!40000 ALTER TABLE `zseq_document_transaction_types_lookup` DISABLE KEYS */;
INSERT INTO `zseq_document_transaction_types_lookup` VALUES (20);
/*!40000 ALTER TABLE `zseq_document_transaction_types_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_transactions`
--

LOCK TABLES `zseq_document_transactions` WRITE;
/*!40000 ALTER TABLE `zseq_document_transactions` DISABLE KEYS */;
INSERT INTO `zseq_document_transactions` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_type_fields_link`
--

LOCK TABLES `zseq_document_type_fields_link` WRITE;
/*!40000 ALTER TABLE `zseq_document_type_fields_link` DISABLE KEYS */;
INSERT INTO `zseq_document_type_fields_link` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_type_fields_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_type_fieldsets_link`
--

LOCK TABLES `zseq_document_type_fieldsets_link` WRITE;
/*!40000 ALTER TABLE `zseq_document_type_fieldsets_link` DISABLE KEYS */;
INSERT INTO `zseq_document_type_fieldsets_link` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_type_fieldsets_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_document_types_lookup`
--

LOCK TABLES `zseq_document_types_lookup` WRITE;
/*!40000 ALTER TABLE `zseq_document_types_lookup` DISABLE KEYS */;
INSERT INTO `zseq_document_types_lookup` VALUES (1);
/*!40000 ALTER TABLE `zseq_document_types_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_documents`
--

LOCK TABLES `zseq_documents` WRITE;
/*!40000 ALTER TABLE `zseq_documents` DISABLE KEYS */;
INSERT INTO `zseq_documents` VALUES (1);
/*!40000 ALTER TABLE `zseq_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_field_behaviours`
--

LOCK TABLES `zseq_field_behaviours` WRITE;
/*!40000 ALTER TABLE `zseq_field_behaviours` DISABLE KEYS */;
INSERT INTO `zseq_field_behaviours` VALUES (1);
/*!40000 ALTER TABLE `zseq_field_behaviours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_field_value_instances`
--

LOCK TABLES `zseq_field_value_instances` WRITE;
/*!40000 ALTER TABLE `zseq_field_value_instances` DISABLE KEYS */;
INSERT INTO `zseq_field_value_instances` VALUES (1);
/*!40000 ALTER TABLE `zseq_field_value_instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_fieldsets`
--

LOCK TABLES `zseq_fieldsets` WRITE;
/*!40000 ALTER TABLE `zseq_fieldsets` DISABLE KEYS */;
INSERT INTO `zseq_fieldsets` VALUES (3);
/*!40000 ALTER TABLE `zseq_fieldsets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_folder_doctypes_link`
--

LOCK TABLES `zseq_folder_doctypes_link` WRITE;
/*!40000 ALTER TABLE `zseq_folder_doctypes_link` DISABLE KEYS */;
INSERT INTO `zseq_folder_doctypes_link` VALUES (2);
/*!40000 ALTER TABLE `zseq_folder_doctypes_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_folder_subscriptions`
--

LOCK TABLES `zseq_folder_subscriptions` WRITE;
/*!40000 ALTER TABLE `zseq_folder_subscriptions` DISABLE KEYS */;
INSERT INTO `zseq_folder_subscriptions` VALUES (1);
/*!40000 ALTER TABLE `zseq_folder_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_folder_transactions`
--

LOCK TABLES `zseq_folder_transactions` WRITE;
/*!40000 ALTER TABLE `zseq_folder_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `zseq_folder_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_folders`
--

LOCK TABLES `zseq_folders` WRITE;
/*!40000 ALTER TABLE `zseq_folders` DISABLE KEYS */;
INSERT INTO `zseq_folders` VALUES (2);
/*!40000 ALTER TABLE `zseq_folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_folders_users_roles_link`
--

LOCK TABLES `zseq_folders_users_roles_link` WRITE;
/*!40000 ALTER TABLE `zseq_folders_users_roles_link` DISABLE KEYS */;
INSERT INTO `zseq_folders_users_roles_link` VALUES (1);
/*!40000 ALTER TABLE `zseq_folders_users_roles_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_groups_groups_link`
--

LOCK TABLES `zseq_groups_groups_link` WRITE;
/*!40000 ALTER TABLE `zseq_groups_groups_link` DISABLE KEYS */;
INSERT INTO `zseq_groups_groups_link` VALUES (1);
/*!40000 ALTER TABLE `zseq_groups_groups_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_groups_lookup`
--

LOCK TABLES `zseq_groups_lookup` WRITE;
/*!40000 ALTER TABLE `zseq_groups_lookup` DISABLE KEYS */;
INSERT INTO `zseq_groups_lookup` VALUES (3);
/*!40000 ALTER TABLE `zseq_groups_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_help`
--

LOCK TABLES `zseq_help` WRITE;
/*!40000 ALTER TABLE `zseq_help` DISABLE KEYS */;
INSERT INTO `zseq_help` VALUES (98);
/*!40000 ALTER TABLE `zseq_help` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_help_replacement`
--

LOCK TABLES `zseq_help_replacement` WRITE;
/*!40000 ALTER TABLE `zseq_help_replacement` DISABLE KEYS */;
INSERT INTO `zseq_help_replacement` VALUES (1);
/*!40000 ALTER TABLE `zseq_help_replacement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_interceptor_instances`
--

LOCK TABLES `zseq_interceptor_instances` WRITE;
/*!40000 ALTER TABLE `zseq_interceptor_instances` DISABLE KEYS */;
/*!40000 ALTER TABLE `zseq_interceptor_instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_links`
--

LOCK TABLES `zseq_links` WRITE;
/*!40000 ALTER TABLE `zseq_links` DISABLE KEYS */;
INSERT INTO `zseq_links` VALUES (1);
/*!40000 ALTER TABLE `zseq_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_metadata_lookup`
--

LOCK TABLES `zseq_metadata_lookup` WRITE;
/*!40000 ALTER TABLE `zseq_metadata_lookup` DISABLE KEYS */;
INSERT INTO `zseq_metadata_lookup` VALUES (11);
/*!40000 ALTER TABLE `zseq_metadata_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_metadata_lookup_tree`
--

LOCK TABLES `zseq_metadata_lookup_tree` WRITE;
/*!40000 ALTER TABLE `zseq_metadata_lookup_tree` DISABLE KEYS */;
INSERT INTO `zseq_metadata_lookup_tree` VALUES (1);
/*!40000 ALTER TABLE `zseq_metadata_lookup_tree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_mime_documents`
--

LOCK TABLES `zseq_mime_documents` WRITE;
/*!40000 ALTER TABLE `zseq_mime_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `zseq_mime_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_mime_extractors`
--

LOCK TABLES `zseq_mime_extractors` WRITE;
/*!40000 ALTER TABLE `zseq_mime_extractors` DISABLE KEYS */;
INSERT INTO `zseq_mime_extractors` VALUES (1);
/*!40000 ALTER TABLE `zseq_mime_extractors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_mime_types`
--

LOCK TABLES `zseq_mime_types` WRITE;
/*!40000 ALTER TABLE `zseq_mime_types` DISABLE KEYS */;
INSERT INTO `zseq_mime_types` VALUES (161);
/*!40000 ALTER TABLE `zseq_mime_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_news`
--

LOCK TABLES `zseq_news` WRITE;
/*!40000 ALTER TABLE `zseq_news` DISABLE KEYS */;
INSERT INTO `zseq_news` VALUES (1);
/*!40000 ALTER TABLE `zseq_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_notifications`
--

LOCK TABLES `zseq_notifications` WRITE;
/*!40000 ALTER TABLE `zseq_notifications` DISABLE KEYS */;
INSERT INTO `zseq_notifications` VALUES (1);
/*!40000 ALTER TABLE `zseq_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_organisations_lookup`
--

LOCK TABLES `zseq_organisations_lookup` WRITE;
/*!40000 ALTER TABLE `zseq_organisations_lookup` DISABLE KEYS */;
INSERT INTO `zseq_organisations_lookup` VALUES (1);
/*!40000 ALTER TABLE `zseq_organisations_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_permission_assignments`
--

LOCK TABLES `zseq_permission_assignments` WRITE;
/*!40000 ALTER TABLE `zseq_permission_assignments` DISABLE KEYS */;
INSERT INTO `zseq_permission_assignments` VALUES (8);
/*!40000 ALTER TABLE `zseq_permission_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_permission_descriptors`
--

LOCK TABLES `zseq_permission_descriptors` WRITE;
/*!40000 ALTER TABLE `zseq_permission_descriptors` DISABLE KEYS */;
INSERT INTO `zseq_permission_descriptors` VALUES (2);
/*!40000 ALTER TABLE `zseq_permission_descriptors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_permission_dynamic_conditions`
--

LOCK TABLES `zseq_permission_dynamic_conditions` WRITE;
/*!40000 ALTER TABLE `zseq_permission_dynamic_conditions` DISABLE KEYS */;
INSERT INTO `zseq_permission_dynamic_conditions` VALUES (1);
/*!40000 ALTER TABLE `zseq_permission_dynamic_conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_permission_lookup_assignments`
--

LOCK TABLES `zseq_permission_lookup_assignments` WRITE;
/*!40000 ALTER TABLE `zseq_permission_lookup_assignments` DISABLE KEYS */;
INSERT INTO `zseq_permission_lookup_assignments` VALUES (24);
/*!40000 ALTER TABLE `zseq_permission_lookup_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_permission_lookups`
--

LOCK TABLES `zseq_permission_lookups` WRITE;
/*!40000 ALTER TABLE `zseq_permission_lookups` DISABLE KEYS */;
INSERT INTO `zseq_permission_lookups` VALUES (5);
/*!40000 ALTER TABLE `zseq_permission_lookups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_permission_objects`
--

LOCK TABLES `zseq_permission_objects` WRITE;
/*!40000 ALTER TABLE `zseq_permission_objects` DISABLE KEYS */;
INSERT INTO `zseq_permission_objects` VALUES (1);
/*!40000 ALTER TABLE `zseq_permission_objects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_permissions`
--

LOCK TABLES `zseq_permissions` WRITE;
/*!40000 ALTER TABLE `zseq_permissions` DISABLE KEYS */;
INSERT INTO `zseq_permissions` VALUES (8);
/*!40000 ALTER TABLE `zseq_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_plugin_rss`
--

LOCK TABLES `zseq_plugin_rss` WRITE;
/*!40000 ALTER TABLE `zseq_plugin_rss` DISABLE KEYS */;
INSERT INTO `zseq_plugin_rss` VALUES (1);
/*!40000 ALTER TABLE `zseq_plugin_rss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_plugins`
--

LOCK TABLES `zseq_plugins` WRITE;
/*!40000 ALTER TABLE `zseq_plugins` DISABLE KEYS */;
INSERT INTO `zseq_plugins` VALUES (21);
/*!40000 ALTER TABLE `zseq_plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_role_allocations`
--

LOCK TABLES `zseq_role_allocations` WRITE;
/*!40000 ALTER TABLE `zseq_role_allocations` DISABLE KEYS */;
INSERT INTO `zseq_role_allocations` VALUES (1);
/*!40000 ALTER TABLE `zseq_role_allocations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_roles`
--

LOCK TABLES `zseq_roles` WRITE;
/*!40000 ALTER TABLE `zseq_roles` DISABLE KEYS */;
INSERT INTO `zseq_roles` VALUES (4);
/*!40000 ALTER TABLE `zseq_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_saved_searches`
--

LOCK TABLES `zseq_saved_searches` WRITE;
/*!40000 ALTER TABLE `zseq_saved_searches` DISABLE KEYS */;
INSERT INTO `zseq_saved_searches` VALUES (1);
/*!40000 ALTER TABLE `zseq_saved_searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_scheduler_tasks`
--

LOCK TABLES `zseq_scheduler_tasks` WRITE;
/*!40000 ALTER TABLE `zseq_scheduler_tasks` DISABLE KEYS */;
INSERT INTO `zseq_scheduler_tasks` VALUES (3);
/*!40000 ALTER TABLE `zseq_scheduler_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_search_saved`
--

LOCK TABLES `zseq_search_saved` WRITE;
/*!40000 ALTER TABLE `zseq_search_saved` DISABLE KEYS */;
/*!40000 ALTER TABLE `zseq_search_saved` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_status_lookup`
--

LOCK TABLES `zseq_status_lookup` WRITE;
/*!40000 ALTER TABLE `zseq_status_lookup` DISABLE KEYS */;
INSERT INTO `zseq_status_lookup` VALUES (5);
/*!40000 ALTER TABLE `zseq_status_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_system_settings`
--

LOCK TABLES `zseq_system_settings` WRITE;
/*!40000 ALTER TABLE `zseq_system_settings` DISABLE KEYS */;
INSERT INTO `zseq_system_settings` VALUES (3);
/*!40000 ALTER TABLE `zseq_system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_tag_words`
--

LOCK TABLES `zseq_tag_words` WRITE;
/*!40000 ALTER TABLE `zseq_tag_words` DISABLE KEYS */;
INSERT INTO `zseq_tag_words` VALUES (1);
/*!40000 ALTER TABLE `zseq_tag_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_time_period`
--

LOCK TABLES `zseq_time_period` WRITE;
/*!40000 ALTER TABLE `zseq_time_period` DISABLE KEYS */;
INSERT INTO `zseq_time_period` VALUES (1);
/*!40000 ALTER TABLE `zseq_time_period` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_time_unit_lookup`
--

LOCK TABLES `zseq_time_unit_lookup` WRITE;
/*!40000 ALTER TABLE `zseq_time_unit_lookup` DISABLE KEYS */;
INSERT INTO `zseq_time_unit_lookup` VALUES (3);
/*!40000 ALTER TABLE `zseq_time_unit_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_units_lookup`
--

LOCK TABLES `zseq_units_lookup` WRITE;
/*!40000 ALTER TABLE `zseq_units_lookup` DISABLE KEYS */;
INSERT INTO `zseq_units_lookup` VALUES (1);
/*!40000 ALTER TABLE `zseq_units_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_units_organisations_link`
--

LOCK TABLES `zseq_units_organisations_link` WRITE;
/*!40000 ALTER TABLE `zseq_units_organisations_link` DISABLE KEYS */;
INSERT INTO `zseq_units_organisations_link` VALUES (1);
/*!40000 ALTER TABLE `zseq_units_organisations_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_upgrades`
--

LOCK TABLES `zseq_upgrades` WRITE;
/*!40000 ALTER TABLE `zseq_upgrades` DISABLE KEYS */;
INSERT INTO `zseq_upgrades` VALUES (153);
/*!40000 ALTER TABLE `zseq_upgrades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_user_history`
--

LOCK TABLES `zseq_user_history` WRITE;
/*!40000 ALTER TABLE `zseq_user_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `zseq_user_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_users`
--

LOCK TABLES `zseq_users` WRITE;
/*!40000 ALTER TABLE `zseq_users` DISABLE KEYS */;
INSERT INTO `zseq_users` VALUES (3);
/*!40000 ALTER TABLE `zseq_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_users_groups_link`
--

LOCK TABLES `zseq_users_groups_link` WRITE;
/*!40000 ALTER TABLE `zseq_users_groups_link` DISABLE KEYS */;
INSERT INTO `zseq_users_groups_link` VALUES (3);
/*!40000 ALTER TABLE `zseq_users_groups_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_workflow_state_disabled_actions`
--

LOCK TABLES `zseq_workflow_state_disabled_actions` WRITE;
/*!40000 ALTER TABLE `zseq_workflow_state_disabled_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `zseq_workflow_state_disabled_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_workflow_state_permission_assignments`
--

LOCK TABLES `zseq_workflow_state_permission_assignments` WRITE;
/*!40000 ALTER TABLE `zseq_workflow_state_permission_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `zseq_workflow_state_permission_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_workflow_states`
--

LOCK TABLES `zseq_workflow_states` WRITE;
/*!40000 ALTER TABLE `zseq_workflow_states` DISABLE KEYS */;
INSERT INTO `zseq_workflow_states` VALUES (7);
/*!40000 ALTER TABLE `zseq_workflow_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_workflow_transitions`
--

LOCK TABLES `zseq_workflow_transitions` WRITE;
/*!40000 ALTER TABLE `zseq_workflow_transitions` DISABLE KEYS */;
INSERT INTO `zseq_workflow_transitions` VALUES (6);
/*!40000 ALTER TABLE `zseq_workflow_transitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_workflow_trigger_instances`
--

LOCK TABLES `zseq_workflow_trigger_instances` WRITE;
/*!40000 ALTER TABLE `zseq_workflow_trigger_instances` DISABLE KEYS */;
/*!40000 ALTER TABLE `zseq_workflow_trigger_instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zseq_workflows`
--

LOCK TABLES `zseq_workflows` WRITE;
/*!40000 ALTER TABLE `zseq_workflows` DISABLE KEYS */;
INSERT INTO `zseq_workflows` VALUES (3);
/*!40000 ALTER TABLE `zseq_workflows` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2007-10-23 13:43:26
