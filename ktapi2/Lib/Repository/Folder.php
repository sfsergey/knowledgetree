<?php

class Repository_Folder extends Repository_FolderItem
{
    /**
     * Working variable with list of contents. Used by getListing().
     *
     * @var array of FolderItems
     */
    private $listing;

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

        $folderDocuments = array();
        if (($contentTypes & Repository_Folder::DOCUMENT_LISTING) == Repository_Folder::DOCUMENT_LISTING)
        {
            $query = Doctrine_Query::create();
            $documents = $query->select('d.*,mv.*, cv.*')
                ->from('Base_Document d')
                ->innerJoin('d.MetadataVersion mv')
                ->innerJoin('mv.ContentVersion cv')
                ->where('d.full_path like :full_path')
                ->execute(array(':full_path' => $this->getFullPath() . '/%'));

            if ($documents->count() > 0)
            {
                $currentPathDepth = count(explode('/', $this->getFullPath()));

                foreach($documents as $key=>$document)
                {
                    $pathDepth = count(explode('/', $document->full_path));
                    if ($depth > 0 && $pathDepth >= $currentPathDepth + $depth)
                    {
                        $documents->remove($key);
                    }
                    else
                    {
                        $document = new Repository_Document($document);
                        $folderDocuments[$document->folder_id][] = $document;
                    }
                }
            }
            unset($documents);
        }

        $folderFolders = array();
        $folderObjs = array();
        if (($contentTypes & Repository_Folder::FOLDER_LISTING) == Repository_Folder::FOLDER_LISTING)
        {
            $query = Doctrine_Query::create();
            $folders = $query->select('f.*')
                ->from('Base_Folder f')
                ->where('f.full_path like :full_path')
                ->execute(array(':full_path' => $this->getFullPath() . '/%'));

            if ($folders->count() > 0)
            {
                $currentPathDepth = count(explode('/', $this->getFullPath()));

                foreach($folders as $key=>$folder)
                {
                    $pathDepth = count(explode('/', $folder->full_path));
                    if ($depth > 0 && $pathDepth >= $currentPathDepth + $depth)
                    {
                        $folders->remove($key);
                    }
                    else
                    {
                        $folder = new Repository_Folder($folder);
                        if (isset($folderDocuments[$folder->getId()]))
                        {
                            $documents = $folderDocuments[$folder->getId()];
                            $folder->addListItems($documents);
                        }

                        $folderObjs[$folder->id] = $folder;
                        $folderFolders[$folder->parent_id][] = $folder;
                    }
                }
            }
            unset($folders);
        }

        // creating tree

        $this->addListItems($folderDocuments[$this->getId()]);

        $this->createFolderTree($this->getId(), $folderObjs, $folderFolders);

        return $this->listing;
    }

    private
    function addListItems($item)
    {
        if (is_array($item))
        {
            $this->listing = array_merge($this->listing, $item);
        }
        else
        {
            $this->listing[] = $item;
        }
    }


    private
    function createFolderTree($currentId, $folderObjs, $folderFolders)
    {
        $folder = $folderObjs[$currentId];

        if (!empty($folderFolders[$currentId]))
        {
            foreach ($folderFolders[$currentId] as $subfolder)
            {
                $subfolderId = $subfolder->getId();
                $folder->addListItems($this->createFolderTree($subfolderId, $folderObjs, $folderFolders));
            }
        }

        return $folder;
    }

/*
Properties
IsPublic
MustRestrictDocumentTypes


*/



    /**
     * Return a folder or array of folders based on folder id.
     *
     * @param mixed $id Folder id, or array of ids
     * @return Folder Returns Folder, or array of Folder
     */
    public static
    function get($id)
    {
        if ($id instanceof Repository_Folder)
        {
            $id = array($id->getId());
        }
        elseif (is_numeric($id))
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

        $folders = array();
        foreach($rows as $folder)
        {
            $folder = new Repository_Folder($folder);
            $folders[] = $folder;
        }

        if (count($folders) == 1)
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