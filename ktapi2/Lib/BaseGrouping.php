<?php

class BaseGrouping extends KTAPI_Base
{
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

    /**
     * Get a list of groups based on a filter and optional  unit id.
     *
     * @param string $filter
     * @param int $unitId
     * @return array of Security_Group
     */
    protected static
    function getGroupingsByFilter($baseClass, $instanceClass, $filter, $unitId = null)
    {
        throw new Exception('TODO');
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
        $groupId = $this->getId();

        $rows = $this->base->$relation;

        $class = get_class($this);
        $subgroups = array();
        foreach($rows as $row)
        {
            $subgroups[] = new $class($row);
        }
        return $subgroups;
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

    private
    function setStatus($status)
    {
        $this->base->status = $status;
        $this->base->save();
    }

    public
    function delete()
    {
        $db = KTapi::getDb();

        try
        {
            $db->beginTransaction();

            $this->setStatus('Deleted');

            $query = Doctrine_Query::create();
            $query->delete()
                ->from('Base_MemberSubmember m')
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

    protected
    function enable()
    {
        $this->setStatus('Enabled');
    }

    protected
    function disable()
    {
        $this->setStatus('Disabled');
    }

    public
    function isEnabled()
    {
        return $this->base->status == 'Enabled';
    }

    public
    function isDeleted()
    {
        return $this->base->status == 'Deleted';
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
     * Save settings
     *
     */
    public
    function save()
    {
        $this->base->save();
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

        $users = array();
        $numRows = $rows->count();

        if  ($numRows > 0)
        {
            foreach($rows as $row)
            {
                $users[$row->member_id] = new Security_User($row);
            }
        }

        return $users;
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

}

?>