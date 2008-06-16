<?php

class CorePlugin extends Plugin
{
    public
    function getDisplayName()
    {
        return _kt('KT Core Plugin');
    }

    public
    function getNamespace()
    {
        return 'plugin.core';
    }

    public
    function register()
    {
        parent::register(__FILE__);

        $this->registerGroupingProperty('system.administrator', 'Security_Group', 'System Administrator',  'isSystemAdministrator', 'setSystemAdministrator','', 'boolean', false);
        $this->registerGroupingProperty('unit.administrator', 'Security_Group', 'Unit Administrator',  'isUnitAdministrator', 'setUnitAdministrator','', 'boolean', false);

        $this->registerAuthenticationProvider('HashedAuthenticationProvider', 'Authentication/HashedAuthentication.php');
    }

}

?>