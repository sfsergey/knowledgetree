<?php

class TypeUtil
{
    /**
     * Encode a value based by type.
     *
     * @param mixed $value
     * @param string $type
     * @return mixed
     */
    public static
    function encodeValue($value, $type)
    {
        switch ($type)
        {
            case 'bool':
            case 'boolean':
                return ($value == 'true')?true:false;
            case 'int':
            case 'integer':
                return (int) $value;
            case 'double':
            case 'float':
                return (double) $value;
            default:
                return $value;
        }
    }

    /**
     * Decodes a value based by type.
     *
     * @param mixed $value
     * @param string $type
     * @return mixed
     */
    public static
    function decodeValue($value, $type)
    {
        switch($type)
        {
            case 'bool':
            case 'boolean':
                switch($value)
                {
                    case 1:
                    case true:
                    case 'true':
                        $value = 'true';
                        break;
                    case 0:
                    case false:
                    case 'false':
                        $value = 'false';
                        break;
                    default:
                        throw new KTAPI_InvalidValueException();
                }
        }
        return $value;
    }

}