<?php

/**
 * $Id$
 *
 * The contents of this file are subject to the KnowledgeTree Public
 * License Version 1.1.2 ("License"); You may not use this file except in
 * compliance with the License. You may obtain a copy of the License at
 * http://www.knowledgetree.com/KPL
 * 
 * Software distributed under the License is distributed on an "AS IS"
 * basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and
 * limitations under the License.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *    (i) the "Powered by KnowledgeTree" logo and
 *    (ii) the KnowledgeTree copyright notice
 * in the same form as they appear in the distribution.  See the License for
 * requirements.
 * 
 * The Original Code is: KnowledgeTree Open Source
 * 
 * The Initial Developer of the Original Code is The Jam Warehouse Software
 * (Pty) Ltd, trading as KnowledgeTree.
 * Portions created by The Jam Warehouse Software (Pty) Ltd are Copyright
 * (C) 2007 The Jam Warehouse Software (Pty) Ltd;
 * All Rights Reserved.
 * Contributor( s): ______________________________________
 *
 */

require_once(KT_LIB_DIR . "/templating/templating.inc.php");
require_once(KT_LIB_DIR . "/help/helpreplacement.inc.php");
require_once(KT_LIB_DIR . "/help/helpentity.inc.php");
require_once(KT_LIB_DIR . "/help/help.inc.php");

require_once(KT_LIB_DIR . "/dispatcher.inc.php");
$sectionName = "Administration";
require_once(KT_LIB_DIR . "/templating/kt3template.inc.php");

require_once(KT_LIB_DIR . '/browse/browseutil.inc.php');
require_once(KT_LIB_DIR . '/browse/browseutil.inc.php');
require_once(KT_LIB_DIR . '/widgets/forms.inc.php');
class ManageCleanupDispatcher extends KTAdminDispatcher {
    function ManageCleanupDispatcher() {
        $this->aIgnore = array(
            '.', '..',
            'CVS',
            '.empty',
            '.htaccess',
            '.cvsignore',
            '.svn',
        );

        $oConfig =& KTConfig::getSingleton();
        $this->fsPath = $oConfig->get('urls/documentRoot');

        return parent::KTAdminDispatcher();
    }

    function do_main()
    {
    
    	 $oForm = new KTForm;
        $oForm->setOptions(array(
            'label' => _kt('Document Storage Verification'),
            'description' => _kt('This process performs a check to see if the documents in your repositories all are stored on the back-end storage (usually on disk). This process can take many minutes or hours depending on the size of your repository.'),
            'submit_label' => _kt('verify document storage'),
            'action' => 'verify',          
        ));
        
          return $oForm->render();	
    }
    
    
    function do_verify() {
        global $aFoldersToRemove;
        global $aFilesToRemove;
        global $aRepoDocumentProblems;
        global $aRepoFolderProblems;
        global $aRepoVersionProblems;


        $this->checkDirectory("");

        $aDocuments =& Document::getList();
        foreach ($aDocuments as $oDocument) {
            $this->checkRepoDocument($oDocument);
        }

        $oTemplate =& $this->oValidator->validateTemplate('ktcore/document/cleanup');
        $oTemplate->setData(array(
            'aFilesToRemove' => $this->aFilesToRemove,
            'aRepoDocumentProblems' => $this->aRepoDocumentProblems,
        ));
        return $oTemplate->render();
    }

    function checkDirectory($path) {
        $fullpath = sprintf("%s/%s", $this->fsPath, $path);

        if (!is_dir($fullpath)) {
            print "Not a directory: $fullpath\n";
        }

        $dh = @opendir($fullpath);
        if ($dh === false) {
            print "Could not open directory: $fullpath\n";
        }
        while (($filename = readdir($dh)) !== false) {
            if (in_array($filename, $this->aIgnore)) { continue; }
            $subrelpath = sprintf("%s/%s", $path, $filename);
            if (substr($subrelpath, 0, 1) == "/") {
                $subrelpath = substr($subrelpath, 1);
            }
            $subfullpath = sprintf("%s/%s", $this->fsPath, $subrelpath);
            if (is_dir($subfullpath)) {
                $this->checkDirectory($subrelpath);
            }
            if (is_file($subfullpath)) {
                $this->checkFile($subrelpath);
            }
        }
    }

    function checkFile($path, $first = true) {
        $oDocument = KTEntityUtil::getByDict('KTDocumentContentVersion', array(
            'storage_path' => $path,
        ));
        if (is_a($oDocument, 'ktentitynoobjects')) {
            $this->aFilesToRemove[] = $path;
            return;
        }
    }

    function checkRepoDocument($oDocument) {
        global $aRepoDocumentProblems;
        $aDCVs = KTDocumentContentVersion::getByDocument($oDocument);
        foreach ($aDCVs as $oDCV) {
            $sDocumentPath = $oDCV->getStoragePath();
            $sFullPath = sprintf("%s/%s", $this->fsPath, $sDocumentPath);
            if (!is_file($sFullPath)) {
                $this->aRepoDocumentProblems[] = array(
                    'document' => $oDocument,
                    'content' => $oDCV,
                    'path' => $sDocumentPath,
                    'doclink' => KTBrowseUtil::getUrlForDocument($oDocument),
                );
            }
        }
    }
}

?>
