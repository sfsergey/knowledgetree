<?php

class Repository_Document extends Repository_FolderItem
{
    public
    function __construct($base)
    {
        parent::__construct($base);
    }

    public
    function getName()
    {
        return $this->base->MetadataVersion->name;
    }

    public
    function getDescription()
    {
        $this->base->MetadataVersion->description;
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
    function rename($name, $options = array())
    {

    }

    public
    function copyTo($folder, $options = array())
    {

    }

    public
    function moveTo($folder, $options = array())
    {

    }

    public
    function delete($options = array())
    {

    }

    public
    function diffMetadata($versionBase, $versionWith)
    {

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
    function getCheckedOutById()
    {
        return $this->base->checked_out_user_id;
    }


    public
    function getCheckedOutName()
    {
        //return User::getUserName($this->getCheckedOutById());
    }

    public
    function getCheckedOutDate()
    {
        return $this->base->checkedout;
    }

    public
    function isCheckedOut()
    {
        return !is_null($this->getCheckedOutById());
    }

    public
    function getContentVersionId()
    {
        return $this->base->MetadataVersion->content_version_id;
    }

    public
    function getContentVersionObj()
    {
        return $this->base->MetadataVersion->ContentVersion;
    }

    public
    function getVersion()
    {
        $content = $this->getContentVersionObj();
        return $content->major_version . '.' . $content->minor_version;
    }

    public
    function getFilename()
    {
        return $this->getContentVersionObj()->filename;
    }

    public
    function getFilesize()
    {
        return $this->getContentVersionObj()->size;
    }

    public
    function getMimeTypeId()
    {
        return $this->getContentVersionObj()->mime_id;
    }

    public
    function getMimeTypeName()
    {
        return MimeType::getMimeTypeName($this->getMimeTypeId());
    }

    public
    function getStoragePath()
    {
        return $this->getContentVersionObj()->storage_path;
    }

    public
    function getStorageHash()
    {
        return $this->getContentVersionObj()->md5hash;
    }

    public
    function isImmutable()
    {
        return $this->base->immutable;
    }

    public
    function getOemNo()
    {
        return $this->base->oem_no;
    }

    public
    function getCustomDocumentNo()
    {
        return $this->base->MetadataVersion->custom_doc_no;
    }

    public
    function getDocumentTypeId()
    {
        return $this->base->MetadataVersion->document_type_id;
    }

    public
    function getDocumentTypeName()
    {
        return DocumentType::getDocumentTypeName($this->getDocumentTypeId());
    }

    public
    function getMetadataVersionCreatedDate()
    {
        return $this->base->MetadataVersion->version_created;
    }

    public
    function getMetadataVersionCreatedById()
    {
        return $this->base->MetadataVersion->version_creator_id;
    }

    public
    function getWorkflowId()
    {
        return $this->base->MetadataVersion->workflow_id;
    }

    public
    function getWorkflow()
    {
        return Workflow::getWorkflowName($this->getWorkflowId());
    }

    public
    function getWorkflowStateId()
    {
        return $this->base->MetadataVersion->workflow_state_id;
    }

    public
    function getWorkflowState()
    {
        return WorkflowState::getWorkflowStateName($this->getWorkflowStateId());
    }

    public
    function isPublished()
    {
        return $this->base->MetadataVersion->status_id == self::PUBLISHED_STATUS ;
    }

    public
    function isMetadataActive()
    {
        return $this->base->MetadataVersion->status_id == self::ACTIVE_STATUS ;
    }

    public
    function isMetadataDeleted()
    {
        return $this->base->MetadataVersion->status_id == self::DELETED_STATUS ;
    }


    /**
     * Return a document or array of documents based on document id.
     *
     * @param mixed $id Document id, or array of ids
     * @param boolean $published Optional.
     * @return mixed Returns Document, or array of Document
     */
    public static
    function get($id, $published = false)
    {
        if (is_numeric($id))
        {
            $id = array($id);
        }
        if (!is_array($id))
        {
            throw new KTapiException('Array expected.');
        }

        if (empty($id))
        {
            throw new KTapiException('Non empty array expected.');
        }

        $query = Doctrine_Query::create();
        $query = $query->select('d.*,mv.*, cv.*')
                ->from('Base_Document d')
                ->innerJoin('d.MetadataVersion mv')
                ->innerJoin('mv.ContentVersion cv')
                ->whereIn('d.id', $id);

        self::addPermissionConditions($query);

        if ($published)
        {
            $query->addWhere('mv.status_id = :published', array(':published'=> self::PUBLISHED_STATUS ));
        }

        $rows = $query->execute();

        $documents = Util_Doctrine::getObjectArrayFromCollection($rows, 'Repository_Document');

        $count = count($folders);

        switch ($count)
        {
            case 0:
                throw new KTapiException(_str('No documents(s) found matching id(s): %s.', implode(',', $id)));
            case 1;
                return $documents[0];
            default:
                return $documents;
        }
    }

    /**
     * Return a document based on metadata version
     *
     * @param int $id Document Id
     * @param int $metadataVersion
     */
    public static
    function getByMetadataVersion($id, $metadataVersion)
    {
        if (!is_numeric($id))
        {
            throw new KTapiException('Integer expected.');
        }

        $query = Doctrine_Query::create();
        $query = $query->select('d.*,mv.*, cv.*')
                ->from('Base_Document d')
                ->innerJoin('d.MetadataVersion mv')
                ->innerJoin('mv.ContentVersion cv')
                ->where('d.id = :id AND mv.metadata_version = :metadata_version');

        self::addPermissionConditions($query);

        $rows = $query->execute(array(':id'=>$id, ':metadata_version' => $metadataVersion));

        if ($rows->count() == 0)
        {
            throw new KTapiException('No documents found matching id and metadata version');
        }

        return new Document($rows[0]);
    }
}

?>