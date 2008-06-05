<?php

class Repository_Folder extends Repository_FolderItem
{
    /**
     * Working variable with list of contents. Used by getListing().
     *
     * @var array of FolderItems
     */
    private $listing;

    public
    function __construct($base)
    {
        parent::__construct($base);
        $this->listing = null;
    }

    public
    function getParentId()
    {
        return $this->base->parent_id;
    }

    public
    function getName()
    {
        return $this->base->name;
    }

    public
    function getDescription()
    {
        return $this->base->description;
    }

    public
    function getDepth()
    {
        return $this->base->depth;
    }

    public
    function isRootFolder()
    {
        return $this->getId() == 1;
    }

    const FOLDER_LISTING = 1;
    const DOCUMENT_LISTING = 2;

    /**
     * Get a folder listing.
     *
     * @param array $options
     * @return array
     */
    public
    function getListing($options = array())
    {
        // TODO: check user permissions

        if (isset($this->listing))
        {
            if (!isset($options['forceRefresh']) || $options['forceRefresh'])
            {
                return $this->listing;
            }
        }

        $depth = 1;
        if (isset($options['depth']))
        {
            $depth = $options['depth'];
            if ($depth == 'infinity')
            {
                $depth = -1;
            }

            if (is_numeric($depth))
            {
                throw new KTapiException('Depth must have a numeric value or \'infinity\'');
            }
        }
        $contentTypes = self::FOLDER_LISTING | self::DOCUMENT_LISTING;
        if (isset($options['contentTypes']))
        {
            $contentTypes = $options['contentTypes'];
            if (!is_numeric($contentTypes))
            {
                throw new KTapiException('Content Type must be a numeric value. ');
            }
        }

        $this->listing = array();

        $currentDepth = $this->getDepth();
        if ($this->isRootFolder())
        {
            $fullpath = '%';
        }
        else
        {
            $fullpath = $this->getFullPath() . '/%';
        }


        $folderDocuments = array();
        if (($contentTypes & Repository_Folder::DOCUMENT_LISTING) == Repository_Folder::DOCUMENT_LISTING)
        {
            $query = Doctrine_Query::create();
            $documents = $query->select('d.*,mv.*, cv.*')
                ->from('Base_Document d')
                ->innerJoin('d.Folder f')
                ->innerJoin('d.MetadataVersion mv')
                ->innerJoin('mv.ContentVersion cv')
                ->where('d.full_path like :full_path AND f.depth >= :minDepth AND f.depth <= :maxDepth')
                ->execute(array(':full_path' => $fullpath, ':minDepth'=> $currentDepth, ':maxDepth'=>$depth + $currentDepth));

            if ($documents->count() > 0)
            {
                foreach($documents as $document)
                {
                    $document = new Repository_Document($document);
                    $documentParentId = $document->getParentId();
                    $folderDocuments[$documentParentId][] = $document;
                }
            }
            unset($documents);
        }

        $currentId = $this->getId();

        $folderObjs = array();
        $folderObjs[$currentId] = $this;

        $folderFolders = array();
        if (($contentTypes & Repository_Folder::FOLDER_LISTING) == Repository_Folder::FOLDER_LISTING)
        {
            $query = Doctrine_Query::create();
            $folders = $query->select('f.*')
                ->from('Base_Folder f')
                ->where('f.full_path like :full_path AND f.depth > :minDepth AND f.depth <= :maxDepth')
                ->execute(array(':full_path' => $fullpath, ':minDepth'=> $currentDepth, ':maxDepth'=>$depth + $currentDepth));

            if ($folders->count() > 0)
            {
                foreach($folders as $folder)
                {
                    $folder = new Repository_Folder($folder);
                    $folderId = $folder->getId();
                    if (isset($folderDocuments[$folderId]))
                    {
                        $documents = $folderDocuments[$folderId];
                        $folder->addListItems($documents);
                    }

                    $folderObjs[$folderId] = $folder;
                    $folderParentId = $folder->getParentId();
                    $folderFolders[$folderParentId][] = $folder;
                }
            }
            unset($folders);
        }

        // creating tree


        $this->addListItems($folderDocuments[$currentId]);

        $this->createFolderTree($currentId, $folderObjs, $folderFolders);

        return $this->listing;
    }

    public
    function addListItems($item)
    {
        if (empty($item))
        {
            return;
        }
        if (is_array($item))
        {
            $this->listing = array_merge($this->listing, $item);
        }
        else
        {
            $this->listing[] = $item;
        }
    }


    public
    function createFolderTree($currentId, $folderObjs, $folderFolders)
    {
        $folder = $folderObjs[$currentId];

        $subfolders = $folderFolders[$currentId];
        if (!empty($subfolders))
        {
            foreach ($subfolders as $subfolder)
            {
                $subfolderId = $subfolder->getId();
                $folder->addListItems($subfolder->createFolderTree($subfolderId, $folderObjs, $folderFolders));
            }
        }

        return $folder;
    }

    /**
     * TODO: check me out....
     * Not sure what this is for. Possible old? Delete????
     *
     * @return boolean
     */
    public
    function isPublic()
    {
        return $this->base->is_public;
    }

    /**
     * Indicates if document types are restricted in the current folder.
     *
     * @return boolean
     */
    public
    function mustRestrictDocumentTypes()
    {
        return $this->base->restrict_document_types;
    }

    /**
     * Return list of document types that are allowed in the folder
     *
     * @return array
     */
    public
    function getRestrictedDocumentTypes()
    {
        throw new Exception('todo');
    }

    /**
     * Return a folder or array of folders based on folder id.
     *
     * @param mixed $id Folder id, or array of ids
     * @return Folder Returns Folder, or array of Folder
     */
    public static
    function get($id)
    {
        if (is_numeric($id))
        {
            $id = array($id);
        }

        if (!is_array($id))
        {
            throw new KTapiException('Array expected');
        }

        $query = Doctrine_Query::create();
        $rows = $query->select('f.*')
                ->from('Base_Folder f')
                ->whereIn('f.id', $id)
                ->execute();

        $count = $rows->count();

        if ($count == 0)
        {
            throw new KTapiException(_str('No folder(s) found matching id(s): %s.', implode(',', $id)));
        }

        $folders = array();
        foreach($rows as $folder)
        {
            $folders[] = new Repository_Folder($folder);
        }

        if ($count == 1)
        {
            return $folders[0];
        }
        else
        {
            return $folders;
        }
    }

    /**
     * Add a document to the current folder
     *
     * @param string $name
     * @param string $description
     * @param mixed $document_type DocumentType, string, document type id
     * @param mixed $metadata
     * @param array $options
     * @return Document
     */
    public
    function addDocument($name, $description, $document_type, $metadata, $options)
    {

    }

    /**
     * Add a subfolder to the current folder
     *
     * @param unknown_type $description
     * @param mixed $target full path or Folder or folder id
     * @param array $options
     * @return Folder
     */
    public
    function addFolder($name, $description, $metadata = null, $options = array())
    {

    }

    /**
     * Add a shortcut to a document or folder.
     *
     * @param string $name
     * @param string $description
     * @param mixed $target
     * @param array $options
     * @return Shortcut
     */
    public
    function addShortcut($name, $description, $target, $options = array())
    {

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


}

?>