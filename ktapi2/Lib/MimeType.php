<?php

class MimeType extends KTAPI_Base
{
    public static
    function get($mimeType)
    {
        return DoctrineUtil::getEntityByField('Base_MimeType', 'MimeType', array('mime_type' => $mimeType));
    }

    public static
    function getByExtension($extension)
    {
        $db = KTapi::getDb();
        $mimeExt = $db->getTable('Base_MimeTypeExtension');
        $mimeExt = $mimeExt->findOneByExtension($extension);

        if ($mimeExt === false)
        {
            throw new Exception('Extension not found.');
        }

        return new MimeType($mimeExt->MimeType);
    }

    public static
    function getAll($filter = '')
    {
        $query = Doctrine_Query::create()
                    ->select('mt.*')
                    ->from('Base_MimeType mt');
        if (!empty($filter))
        {
            $query->where('mt.name like :name', array(':name'=>'%'.$filter.'%'));
        }

        $rows = $query->execute();

        return DoctrineUtil::getObjectArrayFromCollection($rows, 'MimeType');
    }

    private
    function saveExtensions($extArray, $mimeId = null)
    {
        if (is_null($mimeId))
        {
            $mimeId = $this->base->id;
        }

        Doctrine_Query::create()
            ->delete()
            ->from('Base_MimeTypeExtension e')
            ->where('e.mime_type_id = :mime_type_id', array(':mime_type_id'=>$mimeId))
            ->execute();

        foreach($extArray as $extension)
        {
            $mimeExt = new Base_MimeTypeExtension();
            $mimeExt->mime_type_id = $mimeId;
            $mimeExt->extension = strtolower(trim($extension));
            $mimeExt->save();
        }
    }

    public static
    function create($mimeType, $icon, $name, $extensions, $groupMember = null, $extractor = null)
    {
        $mimeType = strtolower($mimeType);
        $icon = strtolower($icon);
        $name = trim($name);

        if (is_array($extensions))
        {
            $extStr = implode(', ', $extensions);
        }
        else
        {
            $extensions = str_replace(' ', '', $extensions);
            $extStr = $extensions;
        }

        $mime = new Base_MimeType();
        $mime->mime_type = $mimeType;
        $mime->icon = $icon;
        $mime->name = $name;
        $mime->extensions = $extStr;
        $mime->group_member_id = $groupMemberId;
        $mime->extractor_namespace = $extractorNamespace;
        $mime->save();

        $mimeType = new MimeType($mime);

        $mimeType->saveExtensions($extensions, $mime->id);

        return $mimeType;
    }

    public
    function getMimeType()
    {
        return $this->base->mime_type;
    }

    public
    function setMimeType($mimeType)
    {
        $this->base->mime_type = $mimeType;
    }

    public
    function getIcon()
    {
        return $this->base->icon;
    }

    public
    function setIcon($icon)
    {
        $this->base->icon = $icon;
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
    function getExtensions()
    {
        return $this->base->extensions;
    }

    public
    function setExtensions($extensions)
    {
        if (is_array($extensions))
        {
            $extArray = $extensions;
            $extStr = implode(', ', $extensions);
        }
        else
        {
            $extArray = explode(',', $extensions);
            $extStr = $extensions;
        }

        $this->base->extensions = $extStr;
        $this->saveExtensions($extArray);
        $this->save();

    }

    public
    function getGroupMemberId()
    {
        return $this->base->group_member_id;
    }

    public
    function setGroupMember($groupMember)
    {
        // TODO
    }

    public
    function getExtractorNamespace()
    {
        return $this->base->extractor_namespace;
    }

    public
    function getExtractor()
    {
        return PluginMember::getModule($this->base->extractor_namespace);
    }

    public
    function setExtractor($extractor)
    {
        // TODO
    }

    public
    function delete()
    {
        $this->base->delete();
    }

}

?>