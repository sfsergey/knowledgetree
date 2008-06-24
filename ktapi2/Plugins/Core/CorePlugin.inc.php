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

        $this->registerMemberProperty('system.administrator', 'Security_Group', 'System Administrator',  'isSystemAdministrator', 'setSystemAdministrator','', 'boolean', false);
        $this->registerMemberProperty('unit.administrator', 'Security_Group', 'Unit Administrator',  'isUnitAdministrator', 'setUnitAdministrator','', 'boolean', false);
        $this->registerMemberProperty('taggable', 'Repository_Metadata_Field', 'Taggable',  'isTaggable', 'setTaggable','', 'boolean', false);

//        $this->registerNodeProperty('immutable', 'Repository_Document', 'Immutable',  'isImmutable', 'setImmutable','', 'boolean', false);
//        $this->registerNodeProperty('oem_no', 'Repository_Document', 'OemNo',  'getOemNo', 'setOemNo','OemNo', 'string', false);



        $this->registerAuthenticationProvider('HashedAuthenticationProvider', 'Authentication/HashedAuthentication.php');

        $this->registerStorageProvider('DiskStorageProvider', 'Storage/DiskStorageProvider.php');
        $this->registerStorageProvider('MirrorStorageProvider', 'Storage/MirrorStorageProvider.php');
        $this->registerStorageProvider('S3StorageProvider', 'Storage/S3StorageProvider.php');
    }

}

?>