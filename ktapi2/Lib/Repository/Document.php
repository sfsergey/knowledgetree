<?php

class Repository_Document extends Repository_FolderItem
{
    function __construct($base)
    {
        parent::__construct($base);
    }

    public
    function getParentId()
    {
        return $this->base->folder_id;
    }

    public
    function getCreatedDate()
    {
        return $this->base->created;
    }

    public
    function getModifiedById()
    {
        return $this->base->modified_user_id;
    }

    public
    function getModifiedByName()
    {
        return User::getUserName($this->getModifiedById());
    }

    public
    function getStatus()
    {
        return $this->base->status_id;
    }

    public
    function getName()
    {
        throw new Exception('TODO');
    }

    public
    function getDescription()
    {
        throw new Exception('TODO');
    }

    function getMetadata()
    {
        throw new Exception('TODO');
    }

    function getMetadataVersionId()
    {
        throw new Exception('TODO');
    }

    function getMetadataVersion()
    {
        throw new Exception('TODO');
    }

    function getMetadataVersionObject()
    {
        throw new Exception('TODO');
    }

    /*

CheckedOutById
CheckedOutName
CheckedOutDate

ContentVersionId
ContentVersion

Version

Filename
Filesize

MimeTypeId
MimeTypeName

StoragePath
Hash
IsImmutable

OemNo
CustomDocumentNo

DocumentTypeId
DocumentType

MetadataVersionCreatedDate
MetadataVersionCreatedById

WorkflowId
Workflow

WorkflowStateId
WorkflowState

IsPublished
IsMetadataActive
IsMetadataDeleted

    */



    /**
     * Return a document or array of documents based on document id.
     *
     * @param mixed $id Document id, or array of ids
     * @return mixed Returns Document, or array of Document
     */
    public static
    function get($id)
    {

    }

    /**
     * Return a document based on metadata version
     *
     * @param int $id Document Id
     * @param int $metadataVersion
     */
    public static
    function getVersion($id, $metadataVersion)
    {

    }



}

?>