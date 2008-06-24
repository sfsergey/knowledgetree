<?php

final class Length
{
    const FULL_PATH     = 65536;
    const FILENAME      = 512;
    const NAMESPACE     = 100;
    const NAME          = 255;
    const LANGUAGE_ID = 5;
}

final class ClientType
{
    const WEBCLIENT     = 'WebClient';
    const WEBDAV        = 'WebDav';
    const WEBSERVICE    = 'WebService';

    public static
    function get()
    {
        return array(
            0=> ClientType::WEBCLIENT,
            1=> ClientType::WEBDAV,
            2=> ClientType::WEBSERVICE
            );
    }

}

final class Frequency
{
    const DAY_OF_WEEK = 'DayOfWeek';
    const DAY_OF_MONTH = 'DayOfMonth';
    const SPECIFIC_DATE = 'SepecificDate';

    public static
    function get()
    {
        return array(
            0=> Frequency::DAY_OF_WEEK,
            1=> Frequency::DAY_OF_MONTH,
            2=> Frequency::SPECIFIC_DATE
            );
    }

}

final class ContentVersionRelation
{
    const ORIGINAL      = 'Original';
    const TRANSLATION   = 'Translation';
    const THUMBNAIL     = 'Thumbnail';
    const CACHE         = 'Cache';
}

final class DataType
{
    const STRING        = 'string';
    const INTEGER       = 'int';
    const BOOLEAN       = 'bool';
    const FLOAT         = 'double';
    const ENUMERATION   = 'enum';

    public static
    function get()
    {
        return array(
            0=> DataType::STRING,
            1=> DataType::INTEGER,
            2=> DataType::BOOLEAN,
            3=> DataType::FLOAT,
            4=> DataType::ENUMERATION
            );
    }

}

final class IndexStage
{
    const REQUEST = 'Request';
    const PROCESSED = 'Processed';
    const ERROR = 'Error';

    public static
    function get()
    {
        return array(
            0=> IndexStage::REQUEST,
            1=> IndexStage::PROCESSED,
            2=> IndexStage::ERROR
            );
    }
}

final class PluginModuleType
{
    const ACTION = 'Action';
    const TRIGGER = 'Trigger';
    const PROPERTY = 'Property'; // member property and node properties
    const AUTHENTICATION_PROVIDER = 'AuthProvider';
    const STORAGE_PROVIDER = 'StorageProvider';
    const TRANSLATION = 'Translation';
    const UNIT_TEST = 'UnitTest';
    const TABLE = 'Table';
    const FIELD = 'Field';
    const SEARCH_CRITERIA = 'SearchCriteria'; // close to Field, but specific to searching
    const DASHLET = 'Dashlet'; // namespace is filter
    const CATEGORY = 'Category'; // namespace is filter

    public static
    function get()
    {
        return array(
            0=> PluginModuleType::ACTION,
            1=> PluginModuleType::TRIGGER,
            2=> PluginModuleType::PROPERTY,
            3=> PluginModuleType::AUTHENTICATION_PROVIDER,
            4=> PluginModuleType::STORAGE_PROVIDER,
            5=> PluginModuleType::TRANSLATION,
            6=> PluginModuleType::UNIT_TEST,
            7=> PluginModuleType::TABLE,
            8=> PluginModuleType::FIELD,
            9=> PluginModuleType::SEARCH_CRITERIA,
            10=> PluginModuleType::DASHLET,
            11=> PluginModuleType::CATEGORY
            );
    }

}


class GroupType
{
    const GROUP         = 'Group';
    const ROLE          = 'Role';
    const UNIT          = 'Unit';
    const FIELDSET      = 'Fieldset';
    const FIELD         = 'Field';
    const DOCUMENT_TYPE = 'DocumentType';
    const DATA          = 'DataList';
    const DATATREE      = 'DataTree';
    const MIME_GROUP    = 'MimeGroup';
    const NODE_TYPE     = 'NodeType';

    public static
    function get()
    {
        return array(
            0=> GroupType::GROUP,
            1=> GroupType::ROLE,
            2=> GroupType::UNIT,
            3=> GroupType::FIELDSET,
            4=> GroupType::FIELD,
            5=> GroupType::DOCUMENT_TYPE,
            6=> GroupType::DATA,
            7=> GroupType::DATATREE,
            8=> GroupType::MIME_GROUP,
            9=> GroupType::NODE_TYPE
            );
    }
}


final class MemberType extends GroupType
{
    const USER          = 'User';

    public static
    function get()
    {
        return array(
            0=> GroupType::GROUP,
            1=> GroupType::ROLE,
            2=> GroupType::UNIT,
            3=> GroupType::FIELDSET,
            4=> GroupType::FIELD,
            5=> GroupType::DOCUMENT_TYPE,
            6=> GroupType::DATA,
            7=> GroupType::DATATREE,
            8=> GroupType::MIME_GROUP,
            9=> GroupType::NODE_TYPE,
            10=> MemberType::USER
            );
    }
}

final class GeneralStatus
{
    const ENABLED   = 'Enabled';
    const DISABLED  = 'Disabled';
    const DELETED   = 'Deleted';

    public static
    function get()
    {
        return array(
            0=> GeneralStatus::ENABLED,
            1=> GeneralStatus::DISABLED,
            2=> GeneralStatus::DELETED
            );
    }

}

final class PluginStatus
{
    const ENABLED     = 'Enabled';
    const DISABLED   = 'Disabled';
    const UNAVAILABLE       = 'Unavailable';

    public static
    function get()
    {
        return array(
            0=> PluginStatus::ENABLED,
            1=> PluginStatus::DISABLED,
            2=> PluginStatus::UNAVAILABLE
            );
    }
}


final class NodeStatus
{
    const AVAILALBE     = 'Available';
    const UNAVAILABLE   = 'Unavailable';
    const DELETED       = 'Deleted';
    const ARCHIVED      = 'Archived';

    public static
    function get()
    {
        return array(
            0=> NodeStatus::AVAILALBE,
            1=> NodeStatus::UNAVAILABLE,
            2=> NodeStatus::DELETED,
            3=> NodeStatus::ARCHIVED
            );
    }
}

?>