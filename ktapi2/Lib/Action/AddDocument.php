<?php

/**
 * Definition of add new document action
 *
 */
class Action_AddDocument extends Action
{
    const ACTION_NAMESPACE  = 'action.document.add';
    const ACTION_NAME       = 'GeneratePDF';
    const ACTION_CATEGORY   = array('category.action.document.actions','Document Actions');

    /**
     * Initialise the add document action
     *
     * @return void
     */
    public
    function __construct()
    {
        parent::__constructor(
            Action_AddDocument::ACTION_NAMESPACE_ADD_DOCUMENT,
            Action_AddDocument::ACTION_NAME );

        $this->setCategory(Action_AddDocument::ACTION_CATEGORY_NAMESPACE, Action_AddDocument::ACTION_CATEGORY_NAME);
        $this->setParameters($this->getParameters());
        $this->setReturn($this->getReturn());
    }

    /**
     * Controls access to private properties
     *
     * @param string $property
     * @return mixed
     */
    protected
    function __get($property)
    {
        switch ($property)
        {
            default:
                return parent::__get($property);
        }
    }

    /**
     * Helper function to return input parameters required by the action
     *
     * @return array
     */
    private
    function getParameters()
    {
        return array(
            'folder_id'=>array('type'=>'Folder', 'required'=>true, 'description'=>'', 'label'=>'Folder'),
            'title'=>array('type'=>'string', 'required'=>true),
            'description'=>array('type'=>'string', 'required'=>true),
            'document_type'=>array('type'=>'DocumentType', 'required'=>true),
            'filename'=>array('type'=>'string', 'required'=>false),
        );
    }

    /**
     * Helper function to get the output return type
     *
     * @return array
     */
    private
    function getReturn()
    {
        return array(
            array('Document') // must provide a mechanism to serialise properties on internal classes to action/property format
        );
    }

    /**
     * Performs the add action taking in parameters
     *
     * @param array $params Keys for the array should be 'folder_id', 'title', 'description', 'document_type', 'filename'
     * @return Document
     */
    public
    function execute($params)
    {
        $folder_id = $params['folder_id'];
        $folder = Folder::get($folder_id);
        $title = $params['title'];
        //...
        $filename = $params['filename'];

        $document = $folder->addDocument($title, $description, $document_type, array('filename'=>$filename));

        return $document;
    }
}