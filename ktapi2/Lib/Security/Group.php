<?php

class Security_Group extends KTAPI_Base
{
    /**
     * Enter description here...
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
     * Enter description here...
     *
     * @param string $groupName
     * @param int $unitId
     * @return Security_Group
     */
    public static
    function getByGroupName($groupName, $unitId = null)
    {
        // TODO: must cater for unitId
        return Util_Doctrine::getEntityByField('Base_Group', 'Security_Group', array('name' => $groupName));
    }

    public static
    function getGroupsByFilter($filter, $unitId = null)
    {
        throw new Exception('TODO');
    }

    private
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

    public
    function addSubgroup($group, $options = array())
    {
        $group = $this->validateGroup($group);

        if ($this->hasSubgroup($group))
        {
            return;
        }

        $mapping = new Base_MemberSubMembers();
        $mapping->member_id = $this->getId();
        $mapping->submember_id = $group->getId();
        $mapping->save();
    }

    private
    function checkGroupMembership($groupId, $subgroupId)
    {
        $query = Doctrine_Query::create();
        $rows = $query->select('sm.member_id')
                ->from('Base_MemberSubMembers sm')
                ->where('sm.member_id = :member_id AND sm.submember_id = :submember_id',
                    array(':member_id'=> $groupId, ':submember_id'=>$subgroupId))
                ->limit(1);

        return $rows->count() == 1;
    }


    public
    function hasSubgroup($group)
    {
        $group = $this->validateGroup($group);

        return $this->checkGroupMembership($this->getId(), $group->getId());
    }

    public
    function isMemberOf($group)
    {
        $group = $this->validateGroup($group);

        return $this->checkGroupMembership($group->getId(), $this->getId());
    }

    public
    function removeSubgroup($group)
    {
        $group = $this->validateGroup($group);

        if (!$this->hasSubgroup($group))
        {
            throw new KTapiException('Cannot remove group as it is not a member.');
        }

        $query = Doctrine_Query::create();
        $rows = $query->delete()
                ->from('Base_MemberSubMembers sm')
                ->where('sm.member_id = :member_id AND sm.submember_id = :submember_id',
                    array(':member_id'=> $this->getId(), ':submember_id'=>$group->getId()))
                ->limit(1);
    }

    protected
    function getGroups($member, $memberId)
    {
        $groupId = $this->getId();
        $query = Doctrine_Query::create();
        $rows = $query->query('SELECT g.* FROM Base_Group g INNER JOIN g.Children c WHERE c.member_id', array(':groupId'=>$groupId));

        $subgroups = array();
        foreach($rows as $row)
        {
            $subgroups[] = new Security_Group($row);
        }
        return $subgroups;
    }


    public
    function getSubgroups()
    {
        return $this->getGroups('Member', 'submember_id');
    }

    public
    function memberOfGroups()
    {
        return $this->getGroups('SubMember', 'member_id');
    }


    /**
     * Enter description here...
     *
     * @param string $groupName
     * @param array $options
     * @return Security_Group
     */
    public static
    function create($groupName, $options = array())
    {
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

            $group = new Base_Grouping();
            $group->member_id = $member->id;
            $group->name = $groupName;
            $group->type = 'Group';

            $group->save();

            $db->commit();

            $group = new Security_Group($group);
        }
        catch(Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }

        return $group;
    }

    public
    function getId()
    {
        return $this->base->member_id;
    }

    public
    function getName()
    {
        return $this->base->name;
    }

    public
    function setName($name)
    {
        $this->base->name = $name;
    }

    public
    function save()
    {
        $this->base->save();
    }
}

?>