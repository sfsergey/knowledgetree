<?php

class Security_Role extends BaseGrouping
{
    const CLASSNAME = 'Security_Role';
    const BASENAME = 'Base_Role';
    const TYPE = 'Role';

    public static
    function get($id)
    {
        return parent::get(self::BASENAME , self::CLASSNAME , $id);
    }

    public static
    function getByRoleName($RoleName, $unitId = null)
    {
        return parent::getByGroupingName(self::BASENAME , self::CLASSNAME,$RoleName, $unitId);
    }

    /**
     * Get a list of Roles based on a filter and optional  unit id.
     *
     * @param string $filter
     * @param int $unitId
     * @return array of Security_Role
     */
    public static
    function getRolesByFilter($filter, $unitId = null)
    {
        return parent::getGroupingsByFilter(self::BASENAME , self::CLASSNAME,$filter, $unitId);
    }

    public static
    function create($RoleName, $options = array())
    {
        return parent::create(self::CLASSNAME, self::TYPE , $RoleName, $options);
    }

}

?>