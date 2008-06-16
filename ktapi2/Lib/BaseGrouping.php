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
    function getProperties()
    {
        if (is_null($this->propertyValues))
        {
            $temp = Util_Doctrine::simpleQuery('Base_GroupingProperty', array('grouping_member_id'=>$this->getId()));

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
        $properties = $this->getProperties();
        if (isset($properties[$property_namespace]))
        {
            return $properties[$property_namespace];
        }
        if (is_null($default))
        {
            throw new KTapiUnknownPropertyException($property);
        }

        $value = new Base_GroupingProperty();
        $value->grouping_member_id = $this->getId();
        $value->property_namespace = $property_namespace;
        $value->value = serialize($default);
        $value->save();

        $this->propertyValues = null;

        return $default;
    }

    protected
    function setPropertyByName(GroupingPropertyModule $groupingProperty, $value)
    {
        $groupingProperty->isValueValid($value);

        Util_Doctrine::update('Base_GroupingProperty',
                        array('value'=>serialize($value)),
                        array('grouping_member_id'=>$this->getId(), 'property_namespace'=>$groupingProperty->getNamespace()));

        $this->propertyValues = null;
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

    public
    function getUnitId()
    {
        return $this->base->unit_id;
    }

    protected
    function setUnitId($unit_id)
    {
         $this->base->unit_id = $unit_id;
    }


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

    public
    function hasEffectiveUser($user)
    {
        $user = Util_Security::validateUser($user);

        $userId = $user->getId();

        $effective = $this->getEffectiveUser($userId, false);

        return $effective !== false;
    }

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

    public
    function hasUser($user)
    {
        $user = Util_Security::validateUser($user);

        return $this->checkMembership($this->getId(), $user->getId());
    }

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

            throw $ex;
        }
    }

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

            throw $ex;
        }
    }

    protected
    function __call($method, $params)
    {
        $properties = PluginManager::getGroupingProperties(get_class($this));

        if (isset($properties['funcs'][$method]))
        {
            $ns = $properties['funcs'][$method];
            $gp = $properties['namespaces'][$ns];
            $getter = $gp->getGetter();
            $setter = $gp->getSetter();

            switch ($method)
            {
                case $getter:
                    $default = $gp->getDefault();
                    return $this->getPropertyByName($ns, $default);
                case $setter:
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