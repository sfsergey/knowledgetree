<?php

class Repository_Metadata_DocumentType extends BaseGrouping
{
    const CLASSNAME = 'Repository_Metadata_DocumentType';
    const BASENAME = 'Base_DocumentType';
    const TYPE = 'DocumentType';

    public static
    function get($id)
    {
        return parent::get(self::BASENAME, self::CLASSNAME, $id);
    }

    public static
    function getByDocumentTypeName($name, $unitId = null)
    {
        return parent::getByGroupingName(self::BASENAME, self::CLASSNAME,$name, $unitId);
    }

    public static
    function getDocumentTypesByFilter($filter, $unitId = null)
    {
        return parent::getMembersByFilter(self::BASENAME, self::CLASSNAME,$filter, $unitId);
    }

    public static
    function create($name, $options = array())
    {
        return parent::create(self::CLASSNAME, self::TYPE, $name, $options);
    }

    public
    function addFieldset($fieldset, $options = array())
    {
        $fieldset = MetadataUtil::validateFieldset($fieldset);

        return parent::addSubmember($fieldset, $options);
    }

    public
    function removeFieldset($fieldset, $options = array())
    {
        $fieldset = MetadataUtil::validateFieldset($fieldset);

        parent::removeSubmember($fieldset);

        $this->base->clearRelated();
    }

    public
    function getFieldsets()
    {
        return $this->getGroupings('Fieldsets');
    }

    protected
    function getGroupings($relation)
    {
        if ($relation != 'Fieldsets')
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