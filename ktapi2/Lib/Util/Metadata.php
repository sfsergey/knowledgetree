<?php

class MetadataUtil
{
    public static
    function validateField($field)
    {
        return KTapi::validateClass('Repository_Metadata_Field', $field);
    }

    public static
    function validateFieldset($fieldset)
    {
        return KTapi::validateClass('Repository_Metadata_Fieldset', $fieldset);
    }

    public static
    function validateMimeType($mimeType)
    {
        return KTapi::validateClass('MimeType', $mimeType);
    }
}

?>