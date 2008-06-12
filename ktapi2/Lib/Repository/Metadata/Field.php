<?php

class Repository_Metadata_Field extends BaseGrouping
{
    const CLASSNAME = 'Repository_Metadata_Field';
    const BASENAME = 'Base_Field';
    const TYPE = 'Field';

    public static
    function get($id)
    {
        return parent::get(self::BASENAME, self::CLASSNAME, $id);
    }

    public static
    function getByFieldName($name, $unitId = null)
    {
        return parent::getByGroupingName(self::BASENAME, self::CLASSNAME,$name, $unitId);
    }

    public static
    function getFieldsByFilter($filter, $unitId = null)
    {
        return parent::getGroupingsByFilter(self::BASENAME, self::CLASSNAME,$filter, $unitId);
    }

    public static
    function create($name, $options = array())
    {
        return parent::create(self::CLASSNAME, self::TYPE, $name, $options);
    }

    public
    function getGroupings($relation)
    {
        return array();
    }
}

?>