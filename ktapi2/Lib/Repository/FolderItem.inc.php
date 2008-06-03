<?php


class Repository_FolderItem
{
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
            return call_user_func_array($method);
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
        return $this->base->full_path;
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
        return $this->getStatus() == 1;
    }

    public
    function IsDeleted()
    {
        return $this->getStatus() == 3;
    }

    public
    function IsArchived()
    {
        return $this->getStatus() == 4;
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

}

?>