<?php

class Security_Group extends KTAPI_Base
{
    /**
     * Get a reference to a group object(s) using an int, or array of int.
     *
     * @param mixed $id int or array of int
     * @return Security_Group
     */
    public static
    function get($id)
    {
        return Util_Doctrine::getEntityByIds('Base_Group', 'Security_Group', 'member_id', $id);
    }

    /**
     * Get a reference to a group object using the group name and optional unit id.
     *
     * @param string $groupName
     * @param int $unitId Optional.
     * @return Security_Group
     */
    public static
    function getByGroupName($groupName, $unitId = null)
    {
        // TODO: must cater for unitId
        return Util_Doctrine::getEntityByField('Base_Group', 'Security_Group', array('name' => $groupName));
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
        throw new Exception('TODO');
    }

    /**
     * Validates that the parameter is a reference to a group.
     *
     * @param mixed $group This may be an integer or Security_Group.
     * @return Security_Group
     */
    public
    function validateGroup($group)
    {
        if (is_numeric($group))
        {
            $group = Security_Group::get($group);
        }
        if (!$group instanceof Security_Group)
        {
            throw new KTapiException('Security_Group expected');
        }
        return $group;
    }

    /**
     * Validates the parameter as a reference to a user.
     *
     * @param string $user
     * @return Security_User
     */
    public
    function validateUser($user)
    {
        if (is_numeric($user))
        {
            $user = Security_User::get($user);
        }
        if (!$user instanceof Security_User)
        {
            throw new KTapiException('Security_User expected');
        }
        return $user;
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
        $group = $this->validateGroup($group);

        if ($this->hasSubgroup($group))
        {
            return;
        }

        $mapping = new Base_MemberSubMember();
        $mapping->member_id = $this->getId();
        $mapping->submember_id = $group->getId();
        $mapping->save();

        self::updateEffectiveUsers();
    }

    /**
     * Returns true if membership relation is defined.
     *
     * @param int $groupId
     * @param int $subgroupId
     * @return boolean
     */
    private
    function checkGroupMembership($groupId, $subgroupId)
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
     * Returns true if $group is a subgroup
     *
     * @param mixed $group Int or Security_Group
     * @return boolean
     */
    public
    function hasSubgroup($group)
    {
        $group = $this->validateGroup($group);

        return $this->checkGroupMembership($this->getId(), $group->getId());
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
        $group = $this->validateGroup($group);

        return $this->checkGroupMembership($group->getId(), $this->getId());
    }

    /**
     * Updates membership by removing $group from the current group.
     *
     * @param mixed $group Int or Security_Group
     */
    public
    function removeSubgroup($group)
    {
        $group = $this->validateGroup($group);

        $query = Doctrine_Query::create();
        $rows = $query->delete()
                ->from('Base_MemberSubMember sm')
                ->where('sm.member_id = :member_id AND sm.submember_id = :submember_id',
                    array(':member_id'=> $this->getId(), ':submember_id'=>$group->getId()))
                ->limit(1)
                ->execute();

        self::updateEffectiveUsers();
    }

    /**
     * Resolves groups based on the relation
     *
     * @param string $relation 'Parent' or 'Children'
     * @return array of Security_Group
     */
    protected
    function getGroups($relation)
    {
        if (!in_array($relation, array('Parent', 'Children')))
        {
            throw new KTapiException('Relation must be set to Parent or Children');
        }
        $groupId = $this->getId();

        $rows = $this->base->$relation;

        $subgroups = array();
        foreach($rows as $row)
        {
            $subgroups[] = new Security_Group($row);
        }
        return $subgroups;
    }

    /**
     * Updates membership by adding a user to the current group.
     *
     * @param mixed $user Int or Security_User
     */
    public
    function addUser($user)
    {
        $user = self::validateUser($user);

        $groupId = $this->getId();
        $userId = $user->getId();

        $mapping = new Base_MemberSubMember();
        $mapping->member_id = $groupId;
        $mapping->submember_id = $userId;
        $mapping->save();

        $this->addEffectiveUser($userId);
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

        $groups = $this->getParentGroups();
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
        $user = self::validateUser($user);

        $groupId = $this->getId();
        $userId = $user->getId();
        $pk = array($groupId, $userId);

        $effective = Util_Doctrine::deleteByPrimary('Base_MemberSubMember', $pk);

        $this->removeEffectiveUser($userId);
    }

    /**
     * Update the effective user membership by removing a user.
     *
     * @param int $userId
     */
    private
    function removeEffectiveUser($userId)
    {
        $effective = self::getEffectiveUser($userId);
        $effective->delete();

        $groups = $this->getParentGroups();
        foreach($groups as $group)
        {
            $group->removeEffectiveUser($userId);
        }
    }

    private
    function updateEffectiveUsers()
    {
        throw new Exception('TODO');
    }

    public
    function getUsers($filter = '')
    {
        throw new Exception('TODO');
    }

    public
    function getEffectiveUsers($filter = '')
    {
        throw new Exception('TODO');
    }

    public
    function hasEffectiveUser($user)
    {
        $user = self::validateUser($user);

        $userId = $user->getId();

        $effective = self::getEffectiveUser($userId, false);

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



    public
    function hasUser($user)
    {
        return self::checkGroupMembership($this->getId(), $user->getId());
    }

    public
    function getSubgroups()
    {
        return $this->getGroups('Children');
    }

    public
    function getParentGroups()
    {
        return $this->getGroups('Parents');
    }


    /**
     * Create a new group
     *
     * @param string $groupName
     * @param array $options
     * @return Security_Group
     */
    public static
    function create($groupName, $options = array())
    {
        // TODO: check unitIds
        try
        {
            $group = self::getByGroupName($groupName);
        }
        catch(Exception $ex)
        {
            // catch exception where user does not exist
        }
        if (isset($group))
        {
            throw new KTapiException(_kt('Group with name %s already exists.', $groupName));
        }

        $db = KTapi::getDb();

        try
        {
            $db->beginTransaction();

            $member = new Base_Member();
            $member->member_type = 'Group';
            $member->save();

            $groupId = $member->id;

            $group = new Base_Grouping();
            $group->member_id = $member->id;
            $group->name = $groupName;
            $group->type = 'Group';

            $group->save();

            $db->commit();


        }
        catch(Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }

        $group = Security_Group::get($groupId);

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
     * Save settings
     *
     */
    public
    function save()
    {
        $this->base->save();
    }
}

?>