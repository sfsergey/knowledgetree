<?php
/**
* Presentation information when adding a Org is successful
*
* @author Mukhtar Dharsey
* @date 5 February 2003
* @package presentation.lookAndFeel.knowledgeTree.
*
*/

require_once("../../../../../config/dmsDefaults.php");

global $default;

if(checkSession()) {

    // include the page template (with navbar)
    require_once("$default->fileSystemRoot/presentation/webpageTemplate.inc");

    $sToRender .= renderHeading("Add Unit");
    $sToRender .= "<table>\n";
    $sToRender .= "<tr>\n";
    if($fSuccess) {
    	$sToRender .= "<td>Organisation added Successfully!</td>\n";
    } else {
    	$sToRender .= "<td>Organisation not added. Organisation may already exist!</td>\n";
    }
    $sToRender .= "</tr>\n";
    $sToRender .= "<tr></tr>\n";
    $sToRender .= "<tr></tr>\n";
    $sToRender .= "<tr></tr>\n";
    $sToRender .= "<tr></tr>\n";
    $sToRender .= "<tr>\n";
    $sToRender .= "<td align = right><a href=\"$default->rootUrl/control.php?action=listOrg\"><img src =\"$default->graphicsUrl/widgets/back.gif\" border = \"0\" /></a></td>\n";
    $sToRender .= "</tr>\n";
    $sToRender .= "</table>\n";

    $oPatternCustom = & new PatternCustom();
    $oPatternCustom->setHtml($sToRender);
    $main->setCentralPayload($oPatternCustom);
    $main->render();
}
?>