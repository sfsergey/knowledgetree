<?php

class Security_Group extends BaseGrouping
{
    const UNIT_ADMIN_NAMESPACE = 'unit.administrator';
    const SYSTEM_ADMIN_NAMESPACE = 'system.administrator';

    public static
    function get($id)
    {
        return parent::get('Base_Group', 'Security_Group', $id);
    }

    public static
    function getByGroupName($groupName, $unitId = null)
    {
        return parent::getByGroupingName('Base_Group','Security_Group',$groupName, $unitId);
    }

    /**
     * Get a list of groups based on a filter and optional  unit id.
     *
     * @param string $filter
     * @param int $unitId
     * @return array of Security_Group
     */
    public static
    function getGroupsByFilter($filter, $unitId = null)
    {
        return parent::getMembersByFilter('Base_Group','Security_Group',$filter, $unitId);
    }

    /**
     * Add a subgroup to the current group.
     *
     * @param string $group
     * @param array $options
     */
    public
    function addSubgroup($group, $options = array())
    {
        $group = Util_Security::validateGroup($group);

        return parent::addSubmember($group, $options);
    }

    /**
     * Returns true if $group is a subgroup
     *
     * @param mixed $group Int or Security_Group
     * @return boolean
     */
    public
    function hasSubgroup($group)
    {
        $group = Util_Security::validateGroup($group);

        return $this->checkMembership($this->getId(), $group->getId());
    }

    /**
     * Returns true if current group is a member of $group
     *
     * @param mixed $group Int or Security_Group
     * @return boolean
     */
    public
    function isMemberOf($group)
    {
        $group = Util_Security::validateGroup($group);

        return $this->checkMembership($group->getId(), $this->getId());
    }

    /**
     * Updates membership by removing $group from the current group.
     *
     * @param mixed $group Int or Security_Group
     */
    public
    function removeSubgroup($group)
    {
        $group = Util_Security::validateGroup($group);

        return $this->removeSubmember($group);
    }

    public
    function getSubgroups()
    {
        return $this->getGroupings('Children');
    }

    public
    function getParentGroups()
    {
        return $this->getGroupings('Parents');
    }

    public static
    function create($groupName, $options = array())
    {
        return parent::create('Security_Group','Group', $groupName, $options);
    }

    public
    function assignToUnit($unit)
    {
        $unit = Util_Security::validateUnit($unit);

        $this->setUnitId($unit->getId());
        $this->save();
    }

    public
    function delete()
    {
        $name = $this->base->name;

        $this->base->name = $name . '  - ' . _kt('Deleted')  . ' - ' . $this->getId();

        try
        {
            parent::delete();
        }
        catch(Exception $ex)
        {
            $this->base->name = $name;
            throw $ex;
        }
    }

}

?>