<?php

class BaseGrouping extends KTAPI_BaseMember
{

    protected $propertyValues;

    /**
     * Get a reference to a group object(s) using an int, or array of int.
     *
     * @param mixed $id int or array of int
     * @return Security_Group
     */
    protected static
    function get($baseClass, $instanceClass, $id)
    {
        return Util_Doctrine::getEntityByIds($baseClass, $instanceClass, 'member_id', $id);
    }

    /**
     * Get a reference to a group object using the group name and optional unit id.
     *
     * @param string $groupName
     * @param int $unitId Optional.
     * @return Security_Group
     */
    protected static
    function getByGroupingName($baseClass, $instanceClass, $groupName, $unitId = null)
    {
        // TODO: must cater for unitId
        return Util_Doctrine::getEntityByField($baseClass, $instanceClass, array('name' => $groupName));
    }

    protected
    function getPropertyValues()
    {
        if (is_null($this->propertyValues))
        {
            $temp = Util_Doctrine::simpleQuery('Base_GroupingPropertyValue', array('grouping_member_id'=>$this->getId()));

            $properties = array();
            foreach($temp as $property)
            {
                $properties[$property->property_namespace] = unserialize($property->value);
            }
            $this->propertyValues = $properties;
        }
        return $this->propertyValues;
    }

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

        $prop = new Base_GroupingPropertyValue();
        $prop->grouping_member_id = $this->getId();
        $prop->property_namespace = $property_namespace;
        $prop->value = serialize($default);
        $prop->save();

        $this->propertyValues[$property_namespace] = $default;

        return $default;
    }

    protected
    function setPropertyByName(GroupingPropertyModule $groupingProperty, $value)
    {
        $groupingProperty->isValueValid($value);

        $property_namespace = $groupingProperty->getNamespace();

        $val = $this->getPropertyByName($property_namespace, $value);

        if ($val != $value)
        {
            Util_Doctrine::update('Base_GroupingPropertyValue',
                        array('value'=>serialize($value)),
                        array('grouping_member_id'=>$this->getId(), 'property_namespace'=>$property_namespace));

            $this->propertyValues[$property_namespace] = $value;
        }
    }


    /**
     * Add a subgroup to the current group.
     *
     * @param string $group
     * @param array $options
     */
    protected
    function addSubmember($group, $options = array())
    {
        $currentId = $this->getId();
        $groupId = $group->getId();

        if ($this->checkMembership($currentId,$groupId))
        {
            return;
        }

        $db = KTapi::getDb();

        try
        {
            $db->beginTransaction();

            $mapping = new Base_MemberSubMember();
            $mapping->member_id = $currentId;
            $mapping->submember_id = $groupId;
            $mapping->save();

            $this->updateEffectiveUsers();
            $db->commit();
        }
        catch (Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }
    }

    /**
     * Returns true if membership relation is defined.
     *
     * @param int $groupId
     * @param int $subgroupId
     * @return boolean
     */
    protected
    function checkMembership($groupId, $subgroupId)
    {
        $query = Doctrine_Query::create();
        $rows = $query->select('sm.member_id')
        ->from('Base_MemberSubMember sm')
        ->where('sm.member_id = :member_id AND sm.submember_id = :submember_id',
        array(':member_id'=> $groupId, ':submember_id'=>$subgroupId))
        ->limit(1);

        return $rows->count() == 1;
    }

    /**
     * Updates membership by removing $group from the current group.
     *
     * @param mixed $group Int or Security_Group
     */
    protected
    function removeSubmember($group)
    {
        $db = KTapi::getDb();

        try
        {
            $db->beginTransaction();

            $query = Doctrine_Query::create();
            $rows = $query->delete()
            ->from('Base_MemberSubMember sm')
            ->where('sm.member_id = :member_id AND sm.submember_id = :submember_id',
            array(':member_id'=> $this->getId(), ':submember_id'=>$group->getId()))
            ->limit(1)
            ->execute();

            $this->updateEffectiveUsers();
            $db->commit();
        }
        catch (Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }
    }

    /**
     * Resolves groups based on the relation
     *
     * @param string $relation 'Parent' or 'Children'
     * @return array of Security_Group
     */
    protected
    function getGroupings($relation)
    {
        if (!in_array($relation, array('Parents', 'Children','Fieldsets','Fields')))
        {
            throw new KTapiException('Relation is not understood.');
        }
        $rows = $this->base->$relation;

        $classname = get_class($this);

        return Util_Doctrine::getObjectArrayFromCollection($rows, $classname);
    }

    /**
     * Create a new group
     *
     * @param string $groupName
     * @param array $options
     * @return Security_Group
     */
    protected static
    function create($instanceClass, $type, $groupName, $options = array())
    {
        // TODO: check unitIds
        try
        {
            $group = eval("return $instanceClass::getBy{$type}Name(\$groupName);");
        }
        catch(Exception $ex)
        {
            // catch exception where user does not exist
        }
        if (isset($group))
        {
            throw new KTapiException(_kt('%s with name %s already exists.', $type, $groupName));
        }

        $db = KTapi::getDb();

        try
        {
            $db->beginTransaction();

            $member = new Base_Member();
            $member->member_type = $type;
            if (isset($options['unitId'])) $member->unit_id = $options['unitId'];
            $member->save();

            $groupId = $member->id;

            $group = new Base_Grouping();
            $group->member_id = $member->id;
            $group->name = $groupName;
            $group->type = $type;

            $group->save();

            $db->commit();
        }
        catch(Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }

        $group = eval("return $instanceClass::get({$groupId});");

        return $group;
    }

    /**
     * Returns the id for the group.
     *
     * @return int
     */
    public
    function getId()
    {
        return $this->base->member_id;
    }

    /**
     * Returns the name for the group.
     *
     * @return string
     */
    public
    function getName()
    {
        return $this->base->name;
    }

    /**
     * Set the name for the group.
     *
     * @param string $name
     */
    public
    function setName($name)
    {
        $this->base->name = $name;
    }

    /**
     * Get the unit Id.
     *
     * @return unknown
     */
    public
    function getUnitId()
    {
        return $this->base->unit_id;
    }

    /**
     * Associate the group with a specific unit.
     *
     * @param mixed $unit
     */
    protected
    function setUnit($unit)
    {
        $unit = Util_Security::validateUnit($unit);
        $this->base->unit_id = $unit->getId();
    }

    /**
     * Updates the effective users for the group.
     *
     * This is typically called when adding or removing subgroups.
     *
     */
    protected
    function updateEffectiveUsers()
    {
        $currentUsers = $this->getEffectiveUsers('',array('clear'=>true));

        $users = array();
        $groups = $this->getSubgroups();
        foreach($groups as $group)
        {
            $groupUsers = $group->getEffectiveUsers('',array('clear'=>true));

            $users = array_merge($users, array_diff_assoc($groupUsers, $users));
        }


        $removedUsers = array_diff_assoc($currentUsers, $users);
        $addedUsers = array_diff_assoc($users, $currentUsers);

        $db = KTapi::getDb();

        try
        {
            if (!empty($addedUsers))
            {
                $addedIds = array_keys($addedUsers);

                $db->beginTransaction();
                foreach($addedIds as $userId)
                {
                    $this->addEffectiveUser($userId);
                }
                $db->commit();
            }
            elseif (!empty($removedUsers))
            {
                $removedIds = array_keys($removedUsers);

                $db->beginTransaction();
                foreach($removedIds as $userId)
                {
                    $this->removeEffectiveUser($userId);
                }
                $db->commit();
            }
        }
        catch(Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }
        $this->base->clearRelated();
    }

    /**
     * Return a list of effective users.
     *
     * @param string $filter
     * @param array $options
     * @return array
     */
    public
    function getEffectiveUsers($filter = '', $options=array())
    {
        if (isset($options['clear']) && $options['clear'])
        {
            $this->base->clearRelated();
        }
        $rows = $this->base->EffectiveUsers;

        return Util_Doctrine::getObjectArrayFromCollection($rows, 'Security_User', 'member_id');

    }

    /**
     * Indicates if the user is an effective user.
     *
     * @param Security_User $user
     * @return boolean
     */
    public
    function hasEffectiveUser($user)
    {
        $user = Util_Security::validateUser($user);

        $userId = $user->getId();

        $effective = $this->getEffectiveUser($userId, false);

        return $effective !== false;
    }

    /**
     * An internal function to resolve the effective user.
     *
     * @param int $userId
     * @param boolean $throwException
     * @return Base_MemberEffectiveUser
     */
    private
    function getEffectiveUser($userId, $throwException = true)
    {
        $groupId = $this->getId();

        $pk = array($groupId, $userId);

        $effective = Util_Doctrine::findByPrimary('Base_MemberEffectiveUser', $pk, $throwException);

        return $effective;
    }

    /**
     * Updates membership by adding a user to the current group.
     *
     * @param mixed $user Int or Security_User
     * @return void
     */
    public
    function addUser($user)
    {
        $user = Util_Security::validateUser($user);

        $groupId = $this->getId();
        $userId = $user->getId();

        $db = KTapi::getDb();
        try
        {
            $db->beginTransaction();
            $mapping = new Base_MemberSubMember();
            $mapping->member_id = $groupId;
            $mapping->submember_id = $userId;
            $mapping->save();

            $this->addEffectiveUser($userId);

            $db->commit();
        }
        catch(Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }
    }

    /**
     * Update the effective user membership by adding a user.
     *
     * @param int $userId
     */
    private
    function addEffectiveUser($userId)
    {
        $groupId = $this->getId();

        $effective = new Base_MemberEffectiveUser();
        $effective->member_id = $groupId;
        $effective->user_member_id = $userId;
        $effective->save();

        $groups = $this->getGroupings('Parents');
        foreach($groups as $group)
        {
            $group->addEffectiveUser($userId);
        }
    }

    /**
     * Updates membership by removing a user from the current group.
     *
     * @param mixed $user Int or Security_User
     */
    public
    function removeUser($user)
    {
        $user = Util_Security::validateUser($user);

        $groupId = $this->getId();
        $userId = $user->getId();
        $pk = array($groupId, $userId);

        $db = KTapi::getDb();
        try
        {
            $db->beginTransaction();
            $effective = Util_Doctrine::deleteByPrimary('Base_MemberSubMember', $pk);

            $this->removeEffectiveUser($userId);
            $db->commit();
        }
        catch(Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }
    }

    /**
     * Update the effective user membership by removing a user.
     *
     * @param int $userId
     */
    private
    function removeEffectiveUser($userId)
    {
        $effective = $this->getEffectiveUser($userId);
        $effective->delete();

        $groups = $this->getGroupings('Parents');
        foreach($groups as $group)
        {
            $group->removeEffectiveUser($userId);
        }
    }

    /**
     * Get a list of users assigned directly to the current group.
     *
     * @param string $filter
     * @return array
     */
    public
    function getUsers($filter = '')
    {
        $rows = $this->base->Users;

        $filter = strtolower($filter);
        $users = array();

        $numRows = $rows->count();

        if  ($numRows > 0)
        {

            foreach($rows as $row)
            {
                if (!empty($filter) && strpos(strtolower($row->name), $filter) === false)
                {
                    continue;
                }
                $users[] = new Security_User($row);
            }
        }

        return $users;
    }

    /**
     * Indicates if the user is a direct member of the current group.
     *
     * @param mixed $user
     * @return boolean
     */
    public
    function hasUser($user)
    {
        $user = Util_Security::validateUser($user);

        return $this->checkMembership($this->getId(), $user->getId());
    }

    /**
     * Reflective function to help deal with the dynamic group properies.
     *
     * @param string $property
     * @return mixed
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
                        throw new Exception('Only one parameter expected.');
                    }
                    $value = $params[0];
                    $this->setPropertyByName($gp, $value);
                    return;
            }
        }
        throw new KTapiUnknownPropertyException($method);
    }
}

?>