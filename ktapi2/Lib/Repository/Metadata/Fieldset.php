<?php

class Repository_Metadata_Fieldset extends BaseGrouping
{
    const CLASSNAME = 'Repository_Metadata_Fieldset';
    const BASENAME = 'Base_Fieldset';
    const TYPE = 'Fieldset';

    public static
    function get($id)
    {
        return parent::get(self::BASENAME, self::CLASSNAME, $id);
    }

    public static
    function getByFieldsetName($name, $unitId = null)
    {
        return parent::getByGroupingName(self::BASENAME, self::CLASSNAME,$name, $unitId);
    }

    /**
     * Get a list of Roles based on a filter and optional  unit id.
     *
     * @param string $filter
     * @param int $unitId
     * @return array of Security_Role
     */
    public static
    function getFieldsetsByFilter($filter, $unitId = null)
    {
        return parent::getMembersByFilter(self::BASENAME, self::CLASSNAME,$filter, $unitId);
    }

    public static
    function create($name, $options = array())
    {
        return parent::create(self::CLASSNAME, self::TYPE, $name, $options);
    }

    public
    function addField($field, $options = array())
    {
        $field = Util_Metadata::validateField($field);

        return parent::addSubmember($field, $options);
    }

    public
    function removeField($field, $options = array())
    {
        $field = Util_Metadata::validateField($field);

        $field->delete();

        $this->base->clearRelated();
    }

    public
    function getFields()
    {
        return $this->getGroupings('Fields');
    }

    public
    function getGroupings($relation)
    {
        if ($relation != 'Fields')
        {
            return array();
        }
        return parent::getGroupings($relation);
    }

    protected
    function updateEffectiveUsers()
    {
        // we don't have users, so effective users are not applicable.
    }
}

?>