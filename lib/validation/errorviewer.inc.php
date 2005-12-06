<?php

class KTErrorViewerRegistry {
    var $aViewers = array();

    function &getSingleton() {
        $oRegistry =& KTUtil::arrayGet($GLOBALS, 'KTErrorViewerRegistry');
        if ($oRegistry) {
            return $oRegistry;
        }
        $GLOBALS['KTErrorViewerRegistry'] =& new KTErrorViewerRegistry();
        return $GLOBALS['KTErrorViewerRegistry'];
    }

    function register($sViewerClassName, $sHandledClass) {
        $this->aViewers[$sHandledClass] = $sViewerClassName;
    }

    function getViewer($oError) {
        $sErrorClass = get_class($oError);

        // Try for direct hit first
        $sClass = $sErrorClass;
        $sHandlerClass = KTUtil::arrayGet($this->aViewers, $sClass);
        if ($sHandlerClass) {
            return new $sHandlerClass($oError);
        }

        // PHP 4.0.5 added get_parent_class - this offers us the
        // best/first match
        if (function_exists('get_parent_class')) {
            while ($sClass = get_parent_class($sClass)) {
                $sHandlerClass = KTUtil::arrayGet($this->aViewers, $sClass);
                if ($sHandlerClass) {
                    return new $sHandlerClass($oError);
                }
            }
        }

        // Now try things the hard way - no best/first match (ick!)
        // Reverse, since hopefully the best/first match will be added
        // after the other matches.
        foreach (array_reverse($this->aViewers) as $sHandlerClass => $sClass) {
            if (is_a($oError, $sClass)) {
                return new $sHandlerClass($oError);
            }
        }

        // Just in case we have an unhandled i18n-friendly error
        if (method_exists($oError, 'geti18nMessage')) {
            return new KTStringErrorViewer($oError->getMessage());
        }

        // PEAR_Error should have caught things above, but just in case,
        // check if getMessage is there, and use that:
        if (method_exists($oError, 'getMessage')) {
            return new KTStringErrorViewer($oError->getMessage());
        }

        // Check if we are a string
        if (is_string($oError)) {
            return new KTStringErrorViewer($oError);
        }

        // Give up.
        return new KTStringErrorViewer(_("Unknown error"));
    }
}

$oEVRegistry =& KTErrorViewerRegistry::getSingleton();
class KTErrorViewer {
    function KTErrorViewer($oError) {
        $this->oError = $oError;
    }
    function view() {
        return $this->oError->getMessage();
    }

    function viewFull() {
        return $this->oError->getString();
    }
}
$oEVRegistry->register("KTErrorViewer", "PEAR_Error");

class KTDBErrorViewer extends KTErrorViewer {
    function view() {
        return _("Database error:") . " " . $this->oError->errorMessage();
    }
}
$oEVRegistry->register("KTDBErrorViewer", "DB_Error");

class KTStringErrorViewer extends KTErrorViewer {
    function view() {
        return $this->oError;
    }
    
    function viewFull() {
        return $this->oError;
    }
}
