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

require_once(KT_DIR . '/plugins/ktstandard/contents/BaseIndexer.php');

class KTPdfIndexerTrigger extends KTBaseIndexerTrigger {
    var $mimetypes = array(
       'application/pdf' => true,
    );
    var $command = 'pdftotext';          // could be any application.
    var $commandconfig = 'indexer/pdftotext';          // could be any application.
    var $args = array("-nopgbrk", "-enc", "UTF-8");
    var $use_pipes = false;
    
    // see BaseIndexer for how the extraction works.
    function findLocalCommand() {   
	putenv('LANG=en_US.UTF-8');
        $sCommand = KTUtil::findCommand($this->commandconfig, $this->command);
        return $sCommand;
    }    
    
    function getDiagnostic() {
        $sCommand = $this->findLocalCommand();
        
        // can't find the local command.
        if (empty($sCommand)) {
            return sprintf(_kt('Unable to find required command for indexing.  Please ensure that <strong>%s</strong> is installed and in the %s Path.  For more information on indexers and helper applications, please <a href="%s">visit the %s site</a>.'), $this->command, APP_NAME, $this->support_url, APP_NAME);
        }
        
        return null;
    }
    
}

?>
