<?php

class Security_Unit extends BaseGrouping
{
    const CLASSNAME = 'Security_Unit';
    const BASENAME = 'Base_Unit';
    const TYPE = 'Unit';

    public static
    function get($id)
    {
        return parent::get(self::BASENAME , self::CLASSNAME , $id);
    }

    public static
    function getByUnitName($name, $unitId = null)
    {
        return parent::getByGroupingName(self::BASENAME , self::CLASSNAME,$name, $unitId);
    }

    /**
     * Get a list of Roles based on a filter and optional  unit id.
     *
     * @param string $filter
     * @param int $unitId
     * @return array of Security_Role
     */
    public static
    function getUnitsByFilter($filter, $unitId = null)
    {
        return parent::getGroupingsByFilter(self::BASENAME , self::CLASSNAME,$filter, $unitId);
    }

    public static
    function create($name, $options = array())
    {
        return parent::create(self::CLASSNAME, self::TYPE , $name, $options);
    }

}

?>