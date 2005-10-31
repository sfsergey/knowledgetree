<?php

// boilerplate includes
require_once("../../../../config/dmsDefaults.php");
require_once(KT_DIR . "/presentation/Html.inc");
require_once(KT_LIB_DIR . "/templating/templating.inc.php");
require_once(KT_LIB_DIR . "/database/dbutil.inc");
require_once(KT_LIB_DIR . "/util/ktutil.inc");
require_once(KT_LIB_DIR . "/dispatcher.inc.php");
require_once(KT_LIB_DIR . "/browse/Criteria.inc");
require_once(KT_LIB_DIR . "/visualpatterns/PatternBrowsableSearchResults.inc");

// specific includes

$sectionName = "General";
require_once(KT_DIR . "/presentation/webpageTemplate.inc");

/*
 * example code - tests the frontend behaviour.  remember to check ajaxConditional.php 
 * 
 */

class BooleanSearchDispatcher extends KTStandardDispatcher {
   function do_main() {
        $oTemplating = new KTTemplating;
        $oTemplate = $oTemplating->loadTemplate("ktcore/boolean_search");
        
        $aCriteria = Criteria::getAllCriteria();
        
        $aTemplateData = array(
            "aCriteria" => $aCriteria,
        );
        return $oTemplate->render($aTemplateData);
    }

    function handleOutput($data) {
        global $main;
        $main->bFormDisabled = true;
        $main->setCentralPayload($data);
        $main->render();
    }
    
    function do_performSearch() {
        // TODO first extract environ vars
        // TODO second create criterion objects (see getAdvancedSearchResults for this.
        // TODO third get each one to generate the SQL snippet. (ENSURE that they are wrapped in '('..')' )
        // TODO fourth array().join(' AND ') where appropriate
        // TODO finally return via PatternBrowseableSearchResults (urgh.)
        
        $datavars = KTUtil::arrayGet($_REQUEST, 'boolean_search');
        $booleanJoinName = KTUtil::arrayGet($_REQUEST, 'outer_boolean_condition');
        
        if (empty($datavars)) {
            $this->errorRedirectToMain('You need to have at least 1 condition.');
        }
        if (empty($booleanJoinName)) {
             $this->errorRedirectToMain('You need to specify which kind of search (ALL/ANY) you wish to perform.');
        }
        
        // Step 1:  extract the criteria selection, and create an array of criteria.
        $criteria_set = array();
        foreach (array_keys($datavars) as $k) {
            foreach ($datavars[$k] as $order => $dataset) {
                $oCriterion = Criteria::getCriterionByNumber($dataset["type"]);             
                if (PEAR::isError($oCriterion)) {
                    $this->errorRedirectToMain('Invalid criteria specified.');
                }
                $criteria_set[$k][] = array($oCriterion, $dataset["data"]);
            }
        }
        $res = $this->handleCriteriaSet($criteria_set, $booleanJoinName, $_REQUEST['boolean_condition']);
        
        return $res;
    }

    function _oneCriteriaSetToSQL($aOneCriteriaSet) {
        $aSQL = array();
        $aJoinSQL = array();
		foreach ($aOneCriteriaSet as $oCriterionPair) {
		    $oCriterion = $oCriterionPair[0];
			$aReq = $oCriterionPair[1];
			$res = $oCriterion->searchSQL($aReq);
			if (!is_null($res)) {
				$aSQL[] = $res;
			}
			$res = $oCriterion->searchJoinSQL();
			if (!is_null($res)) {
				$aJoinSQL[] = $res;
			}
		}
		
		$aCritParams = array();
		$aCritQueries = array();
		foreach ($aSQL as $sSQL) {
			if (is_array($sSQL)) {
				$aCritQueries[] = '('.$sSQL[0].')';
				$aCritParams = array_merge($aCritParams , $sSQL[1]);
			} else {
				$aCritQueries[] = '('.$sSQL.')';
			}
		}
	
		if (count($aCritQueries) == 0) {
			$this->errorRedirectToMain("No search criteria were specified");
			exit(0);
		}
	
        return array($aCritQueries, $aCritParams, $aJoinSQL);
    }

    function criteriaSetToSQL($aCriteriaSet, $mergeType='AND', $innerMergeTypes = null) {
        $aJoinSQL = array();
        $aSearchStrings = array();
        $aParams = array();
        foreach ($aCriteriaSet as $k => $aOneCriteriaSet) {
            list($aThisCritQueries, $aThisParams, $aThisJoinSQL) = $this->_oneCriteriaSetToSQL($aOneCriteriaSet);
            $aJoinSQL = array_merge($aJoinSQL, $aThisJoinSQL);
            $aParams = array_merge($aParams, $aThisParams);
            $aSearchStrings[] = "\n\t\t(\n\t\t\t" . join("\n " . KTUtil::arrayGet($innerMergeTypes, $k, "AND") . " ", $aThisCritQueries) . "\n\t\t)";
        }
		$sJoinSQL = join(" ", $aJoinSQL);
		$sSearchString = "\n\t(" . join("\n\t\t" . $mergeType . " ", $aSearchStrings) .  "\n\t)";
        return array($sSearchString, $aParams, $sJoinSQL);
    }
    
    function handleCriteriaSet($aCriteriaSet, $mergeType='AND', $innerMergeTypes = null) {
		global $default;
        list($sSQLSearchString, $aCritParams, $sJoinSQL) = $this->criteriaSetToSQL($aCriteriaSet, $mergeType);
	
		$sToSearch = KTUtil::arrayGet($aOrigReq, 'fToSearch', 'Live'); // actually never present in this version.

        $oPermission =& KTPermission::getByName('ktcore.permissions.read');
        $sPermissionLookupsTable = KTUtil::getTableName('permission_lookups');
        $sPermissionLookupAssignmentsTable = KTUtil::getTableName('permission_lookup_assignments');
        $sPermissionDescriptorsTable = KTUtil::getTableName('permission_descriptors');
        $aGroups = GroupUtil::listGroupsForUserExpand($_SESSION['userID']);
        $aPermissionDescriptors = KTPermissionDescriptor::getByGroups($aGroups, array('ids' => true));
        $sPermissionDescriptors = DBUtil::paramArray($aPermissionDescriptors);
	
		$sQuery = DBUtil::compactQuery("
	SELECT
		F.name AS folder_name, F.id AS folder_id, D.id AS document_id,
		D.name AS document_name, D.filename AS file_name, COUNT(D.id) AS doc_count, 'View' AS view
	FROM
		$default->documents_table AS D
		INNER JOIN $default->folders_table AS F ON D.folder_id = F.id
		$sJoinSQL
		INNER JOIN $default->status_table AS SL on D.status_id=SL.id
        INNER JOIN $sPermissionLookupsTable AS PL ON D.permission_lookup_id = PL.id
        INNER JOIN $sPermissionLookupAssignmentsTable AS PLA ON PL.id = PLA.permission_lookup_id AND PLA.permission_id = ?
	WHERE
        PLA.permission_descriptor_id IN ($sPermissionDescriptors)
		AND SL.name = ?
		AND ($sSQLSearchString)
	GROUP BY D.id
	ORDER BY doc_count DESC");
	
		$aParams = array();
        $aParams[] = $oPermission->getId();
        $aParams = array_merge($aParams, $aPermissionDescriptors);
		$aParams[] = $sToSearch;
		$aParams = array_merge($aParams, $aCritParams);
	
		//print '<pre>';var_dump(DBUtil::getResultArray(array($sQuery, $aParams)));
		//exit(0);
		//return '<pre>'.print_r(DBUtil::getResultArray(array($sQuery, $aParams)), true).'</pre>';
        $iStartIndex = 1;
	
		$aColumns = array("folder_name", "file_name", "document_name", "doc_count", "view");
		$aColumnTypes = array(3,3,3,1,3);
		$aColumnHeaders = array("<font color=\"ffffff\"><img src=$default->graphicsUrl/widgets/dfolder.gif>" . _("Folder") . "</font>", "<font color=\"ffffff\">" . _("Name") . "</font>", "<font color=\"ffffff\">" . _("Title") . "</font>", "<font color=\"ffffff\">" . _("Matches") . "</font>", "<font color=\"ffffff\">" . _("View") . "</font>");
		$aLinkURLs = array("$default->rootUrl/control.php?action=browse","$default->rootUrl/control.php?action=viewDocument", "$default->rootUrl/control.php?action=viewDocument", null, "$default->rootUrl/control.php?action=downloadDocument");
		$aDBQueryStringColumns = array("document_id","folder_id");
		$aQueryStringVariableNames = array("fDocumentID", "fFolderID");
	
		$oPatternBrowse = & new PatternBrowseableSearchResults(array($sQuery, $aParams), 10, $aColumns, $aColumnTypes, $aColumnHeaders, $aLinkURLs, $aDBQueryStringColumns, $aQueryStringVariableNames);
		$oPatternBrowse->setStartIndex($iStartIndex);
		$oPatternBrowse->setSearchText("");
		$sForSearch = "<input type=\"hidden\" name=\"fForSearch\" value=\"1\" />";
	
		return renderHeading(_("Advanced Search")) . $oPatternBrowse->render() . $sForSearch . $sRefreshMessage;
    }
}

$oDispatcher = new BooleanSearchDispatcher();
$oDispatcher->dispatch();

?>
