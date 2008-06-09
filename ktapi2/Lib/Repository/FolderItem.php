<?php


abstract class Repository_FolderItem
{
    const ACTIVE_STATUS     = 1;
    const PUBLISHED_STATUS  = 2;
    const DELETED_STATUS    = 3;
    const ARCHIVED_STATUS   = 4;

    /**
     *
     *
     * @var Base_Document or Base_Folder
     */
    protected $base; //

    public
    function __construct($base)
    {
        $this->base = $base;
    }

    protected
    function __get($property)
    {
        $method = 'get' . $property;
        if (method_exists($this, $method))
        {
            return call_user_func(array($this,$method));
        }
        else
        {
            throw new KTapiUnknownPropertyException($this, $property);
        }
    }

    public
    function getId()
    {
        return $this->base->id;
    }

    public abstract
    function getParentId();

    public
    function getParent()
    {
        return Folder::get($this->getParentId());
    }

    public
    function getCreatedById()
    {
        return $this->base->creator_id;
    }

    public
    function getCreatedByName()
    {
        return User::getUserName($this->getCreatedById());
    }

    public
    function getCreatedDate()
    {
        return 'n/a';
    }

    public
    function getModifiedById()
    {
        return 'n/a';
    }

    public
    function getModifiedByName()
    {
        return 'n/a';
    }

    public
    function getModifiedDate()
    {
        return 'n/a';
    }

    public
    function getParentFolderIds()
    {
        return $this->base->parent_folder_ids;
    }


    public
    function getPermissionObjectId()
    {
        return $this->base->permission_object_id;
    }

    public
    function getPermissionLookupId()
    {
        return $this->base->permission_lookup_id;
    }

    public
    function getOwnerId()
    {
        return $this->base->owner_id;
    }

    public
    function getOwnerName()
    {
        return User::getUserName($this->getOwnerId());
    }

    public
    function getFullPath()
    {
        $path = $this->base->full_path;

        if (empty($path))
        {
            $path = '';
        }

        return $path;
    }

    public
    function getStatus()
    {
        return 1; // 0 = LIVE
    }

    public abstract
    function getName();

    public abstract
    function getDescription();

    public
    function isActive()
    {
        return $this->getStatus() == self::ACTIVE_STATUS ;
    }

    public
    function IsDeleted()
    {
        return $this->getStatus() == self::DELETED_STATUS ;
    }

    public
    function IsArchived()
    {
        return $this->getStatus() == self::ARCHIVED_STATUS ;
    }

    public
    function getMetadata()
    {
        return array(); // not available on anything but documents currently
    }

    public
    function getMetadataVersionId()
    {
        return null;
    }

    public
    function getMetadataVersion()
    {
        return null;
    }

    public
    function getMetadataVersionObject()
    {
        return null;
    }

    public abstract
    function rename($name, $options = array());

    public abstract
    function copyTo($folder, $options = array());

    public abstract
    function moveTo($folder, $options = array());

    public abstract
    function delete($options = array());

    public abstract
    function diffMetadata($versionBase, $versionWith);

    const CHECKEDOUT_ROLE       = 7;
    const MODIFIER_ROLE         = -6;
    const CREATOR_ROLE          = -5;
    const AUTHENTICATED_ROLE    = -4;
    const OWNER_ROLE            = -2;
    const EVERYONE_ROLE         = -3;
    const ANONYMOUS_USER        = -1;

    /**
     * Add permissions
     *
     * @param Doctrine_Query $query
     */
    protected
    function addPermissionConditions($query)
    {
        if (!$query instanceof Doctrine_Query)
        {
            throw new KTapiException('Doctrine_Query expected.');
        }

        $session = KTapi::getSession();
        $userId = $session->getUserId();
        $unitId = $session->getUnitId();


        $query->distinct()
            ->innerJoin('n.Node pn')
            ->innerJoin('pn.MemberPermission nmp')
            ->innerJoin('nmp.Permission p')
            ->innerJoin('p.ActionPermission ap')
            ->leftJoin('n.Document d WITH n.type = :doctype', array(':doctype'=>'Document'))
            ->leftJoin('d.WorkflowStateDisabledActions wsda')
            ->leftJoin('nmp.Member m_user WITH m_user.member_type= :user', array(':user'=>'User'))
            ->leftJoin('m_user.EffectiveMember effuser')
            ->leftJoin('nmp.Member m_group WITH m_user.member_type= :group', array(':group'=>'Group'))
            ->leftJoin('m_group.EffectiveMember effgroupuser')
            ->leftJoin('nmp.Member m_role WITH m_user.member_type= :role', array(':role'=>'Role'))
            ->leftJoin('m_role.EffectiveMember effroleuser')

            ->addWhere(' AND ap.namespace = :action AND', array(':action'=>'action_namespace'))
            ->addWhere(' AND (d.state_id is null or wsda.action_namespace != :action) ', array(':action'=>'action_namespace'))

            ->addWhere(' AND (n.unit_id IN (:default_unit, :current_unit))', array(':default_unit'=>1, ':current_unit'=>$unitId))
            ->addWhere('
    effgroupuser.effective_member_id = :user_id or
	effuser.effective_member_id = :user_id or

	effroleuser.effective_member_id = :user_id or

	(effroleuser.member_id = :authenticated_role AND :user_id != :anon_user) or
	(effroleuser.member_id = :owner_role AND :user_id = node.owner_id)  or
	(effroleuser.member_id = :creator_role AND :user_id = node.creator_id)  or
	(effroleuser.member_id = :modifier_role AND :user_id = node.modified_user_id)  or
	(effroleuser.member_id = :checkedout_role AND :user_id = d.checked_out_id)  or
	(effroleuser.member_id = :everyone_role)',



            array(':user_id'=>$userId,
                ':authenticated_role'=>self::AUTHENTICATED_ROLE ,
                ':owner_role'=>self::OWNER_ROLE ,
                ':everyone_role'=>self::EVERYONE_ROLE ,
                ':anon_user'=>self::ANONYMOUS_USER ,
                ':creator_role'=>self::CREATOR_ROLE,
                ':modifier_role'=>self::MODIFIER_ROLE ,
                ':checkedout_role'=>self::CHECKEDOUT_ROLE ,


                ));

        /*

        input: userid, unitid

        derive user's effective member id


        select
	distinct n.*

from
	nodes n
	inner join nodes pn on n.permission_node_id = pn.id x

	inner join node_member_permissions nmp on pn.id = nmp.node_id x
	inner join permissions p on nmp.permission_id = p.id x
	inner join action_permission ap on ap.permission_id = p.id x

	left join documents d on n.id = d.node_id and
	left join workflow_state_disabled_actions wsda on d.state_id = wsda.state_id

	left join members m_user on nmp.member_id = m_user.id AND m_user.type='user'
	left join member_effective_members m_user_members on m_user.id = m_user_members.member_id

	left join members m_group on nmp.member_id = m_group.id AND m_user.type='group'
	left join member_effective_members m_group_members on m_group.id = m_group_members.member_id
	left join members m_role on nmp.member_id = m_role.id AND m_user.type='role'
	left join member_effective_members m_role_members on m_role.id = m_role_members.member_id


where
	(filter for nodes in n based on id, folder,etc) AND
	ap.namespace = @action_namespace AND

    (d.state_id is null or wsda.action_namespace != @action_namespace) AND

	(m_group_members.effective_member_id = @my_effective_member_id or
	m_user_members.effective_member_id = @my_effective_member_id or

	m_role_members.effective_member_id = @my_effective_member_id or

	(m_role_members.effective_member_id = -4 AND @my_effective_member_id != anonymoususerid) or
	(m_role_members.effective_member_id = -2 AND @my_effective_member_id = node.owner_id)  or
	(m_role_members.effective_member_id = -3)

	)

        */



    }


}

?>