<?php

class KTAPI_BaseMember extends KTAPI_Base
{
    /**
     * Set status for member.
     *
     * @param string $status
     * @return void
     * @access private
     */
    private
    function setStatus($status)
    {
        $this->base->status = $status;
        $this->base->save();
    }

    /**
     * Sets the status to enabled.
     * @return void
     * @access protected
     */
    protected
    function enable()
    {
        $this->setStatus(GeneralStatus::ENABLED);
    }

    /**
     * Sets the status to disabled.
     * @return void
     * @access protected
     */
    protected
    function disable()
    {
        $this->setStatus(GeneralStatus::DISABLED);
    }

    /**
     * Checks if the object is enabled.
     *
     * @return boolean
     * @access public
     */
    public
    function isEnabled()
    {
        return $this->base->status == GeneralStatus::ENABLED;
    }

    /**
     * Checks if the object is deleted.
     *
     * @return boolean
     * @access public
     */
    public
    function isDeleted()
    {
        return $this->base->status == GeneralStatus::DELETED;
    }

    /**
     * Sets the status to deleted.
     *
     * @return void
     * @access public
     */
    public
    function delete()
    {
        $db = KTapi::getDb();

        try
        {
            $db->beginTransaction();

            // yes, this save statement must be here.
            // it is in case the name of the grouping record has
            // changed. the grouping records are retrieved from a view,
            // a join between the groupings table and members table.
            // updating a view with a join results in a conflict if
            // updates result in updates to multiple tables.
            $this->save();

            $this->setStatus(GeneralStatus::DELETED);

            $query = Doctrine_Query::create();
            $query->delete()
                ->from('Base_MemberSubMember m')
                ->where('m.member_id = :member_id', array(':member_id'=>$this->getId()))
                ->execute();

            $query = Doctrine_Query::create();
            $query->delete()
                ->from('Base_MemberEffectiveUser u')
                ->where('u.member_id = :member_id', array(':member_id'=>$this->getId()))
                ->execute();

            $groupings = $this->getGroupings('Parents');
            foreach($groupings as $groups)
            {
                $groups->updateEffectiveUsers();
            }
            $db->commit();
        }
        catch(Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }
        $this->base->clearRelated();
    }

    /**
     * Returns array of groupings.
     *
     * @param string $relation
     * @return array
     * @access protected
     */
    protected
    function getGroupings($relation)
    {
        return array();
    }

    /**
     * Get a list of groups based on a filter and optional  unit id.
     *
     * @param string $filter
     * @param int $unitId
     * @return array of Security_Group
     * @access protected
     */
    protected static
    function getMembersByFilter($baseClass, $instanceClass, $filter, $unitId = null)
    {
        $query = Doctrine_Query::create();
        $query = $query->select('b.*')
            ->from($baseClass . ' b')
            ->where('b.name like :filter', array(':filter'=> "%$filter%"));

        if (!is_null($unitId))
        {
            $query->addWhere(' AND b.unit_id = :unit_id', array(':unit_id' => $unitId));
        }

        $rows = $query->execute();

        return DoctrineUtil::getObjectArrayFromCollection($rows, $instanceClass);

    }

    /**
     * Cache of property values.
     *
     * @var array
     */
    protected $propertyValues;

    /**
     * Fetches property values for the current class.
     *
     * @return array
     * @access protected
     */
    protected
    function getPropertyValues()
    {
        if (is_null($this->propertyValues))
        {
            $temp = DoctrineUtil::simpleQuery('Base_MemberPropertyValue', array('member_id'=>$this->getId()));

            $properties = array();
            foreach($temp as $property)
            {
                $properties[$property->property_namespace] = unserialize($property->value);
            }
            $this->propertyValues = $properties;
        }
        return $this->propertyValues;
    }

    /**
     * Used to resolve dynamic properties.
     *
     * @param string $property_namespace
     * @param mixed $default
     * @return mixed
     * @access protected
     */
    protected
    function getPropertyByName($property_namespace, $default = null)
    {
        $properties = $this->getPropertyValues();
        if (isset($properties[$property_namespace]))
        {
            return $properties[$property_namespace];
        }
        if (is_null($default))
        {
            throw new KTapiUnknownPropertyException($property);
        }

        $prop = new Base_MemberPropertyValue();
        $prop->member_id = $this->getId();
        $prop->property_namespace = $property_namespace;
        $prop->value = serialize($default);
        $prop->save();
        $this->base->clearRelated();

        $this->propertyValues[$property_namespace] = $default;

        return $default;
    }

    /**
     * Used to set dynamic properties.
     *
     * @param MemberPropertyModule $groupingProperty
     * @param mixed $value
     * @access protected
     */
    protected
    function setPropertyByName(MemberPropertyModule $groupingProperty, $value)
    {
        $groupingProperty->isValueValid($value);

        $property_namespace = $groupingProperty->getNamespace();

        $val = $this->getPropertyByName($property_namespace, $value);

        if ($val != $value)
        {
            DoctrineUtil::update('Base_MemberPropertyValue',
                        array('value'=>serialize($value)),
                        array('member_id'=>$this->getId(), 'property_namespace'=>$property_namespace));

            $this->propertyValues[$property_namespace] = $value;
            $this->base->clearRelated();
        }
    }

    /**
     * Reflective function to help deal with the dynamic group properies.
     *
     * @param string $property
     * @return mixed
     * @access protected
     */
    protected
    function __get($property)
    {
        try
        {
            return parent::__get($property);
        }
        catch(KTapiUnknownPropertyException $ex)
        {
            $properties = PluginManager::getGroupingProperties(get_class($this));

            if (isset($properties['properties'][$property]))
            {
                $ns = $properties['properties'][$property];
                $gp = $properties['ns'][$ns];

                return $this->getPropertyByName($ns, $gp->getDefault());
            }

            // if the property could not be resolved, rethrow it.
            throw $ex;
        }
    }

    /**
     * Reflective function to help deal with dynamic group properties.
     *
     * @param string $property
     * @param mixed $value
     * @return void
     * @access protected
     */
    protected
    function __set($property, $value)
    {
        try
        {
            return parent::__set($property, $value);
        }
        catch(KTapiUnknownPropertyException $ex)
        {
            $properties = PluginManager::getGroupingProperties(get_class($this));

            if (isset($properties['properties'][$property]))
            {
                $ns = $properties['properties'][$property];
                $gp = $properties['ns'][$ns];

                $setter = $gp->getSetter();
                if (!empty($setter))
                {
                    $this->setPropertyByName($gp, $value);
                    $this->base->clearRelated();
                }
            }

            // if the property could not be resolved, rethrow it.
            throw $ex;
        }
    }

    /**
     * Reflective function to help deal with dynamic group functions.
     *
     * @param string $method
     * @param array $params
     * @return mixed
     * @access protected
     */
    protected
    function __call($method, $params)
    {
        $properties = PluginManager::getGroupingProperties(get_class($this));

        if (isset($properties['funcs'][$method]))
        {
            // resolve the namespace
            $ns = $properties['funcs'][$method];

            // resolve the grouping property module
            $gp = $properties['namespaces'][$ns];

            $getter = $gp->getGetter();
            $setter = $gp->getSetter();

            switch ($method)
            {
                case $getter:
                    // the method is the getter function, get the property, possibly returning the default value.
                    $default = $gp->getDefault();
                    return $this->getPropertyByName($ns, $default);

                case $setter:
                    // the method is the setter function.
                    if (count($params) != 1)
                    {
                        throw new KTAPI_ParameterValueException('Only one parameter expected.');
                    }
                    $value = $params[0];
                    $this->setPropertyByName($gp, $value);
                    return;
            }
        }
        throw new KTAPI_UnknownMethodException($method);
    }
}

?>