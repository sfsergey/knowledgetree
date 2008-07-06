<?php

class ValidationUtil
{
    public static
    function staticClass()
    {
        throw new KTAPI_BaseException('Static class cannot be instanciated.');
    }

    public static
    function validateType($object, $classname)
    {
        if (!eval("return \$object instanceof $classname;"))
        {
            throw new KTAPI_UnexpectedTypeException(get_class($object), $classname);
        }
    }

    public static
    function classExists($classname, $filename = null)
    {
        if (is_null($filename))
        {
            $filename = KTUtil::resolveCallerFilename();
        }
        if (!class_exists($classname))
        {
           throw new KTAPI_UnknownClassException($classname, $filename);
        }
    }

    public static
    function valueExpected($value, $what)
    {
        if (empty($value))
        {
            throw new KTAPI_Configuration_ValueExpectedException($value, $what);
        }
    }

    public static
    function directoryExists($location, $forWhat = null)
    {
        if (!is_dir($location))
        {
            throw new KTAPI_FileSystem_FileNotFoundException($location, $forWhat);
        }
    }

    public static
    function recordsExpected($doctrineRecords)
    {
        if (is_array($doctrineRecords))
        {
            $count = count($doctrineRecords);
        }
        else
        {
            $count = $doctrineRecords->count();
        }

        if ($count == 0)
        {
            throw new KTAPI_Database_Record_ExpectedException('No records found matching the criteria.');
        }

        return $count;
    }

    public static
    function fileExists($location, $forWhat = null)
    {
        if (!file_exists($location))
        {
            throw new KTAPI_FileSystem_DirectoryNotFoundException($location, $forWhat);
        }
    }

    const ALLOW_EMPTY = false;
    const NON_EMPTY = true;

    public static
    function arrayExpected($array, $what, $allowEmpty = self::NON_EMPTY)
    {
        if (!is_array($array))
        {
            throw new KTAPI_BaseException('Array expected for %s.', $what);
        }
        if (empty($array) && $allowEmpty != self::ALLOW_EMPTY)
        {
            throw new KTAPI_BaseException('Expected array for %s to be non empty.', $what);
        }
    }

    public static
    function arrayOptionExpected($options, $what, $allowEmpty = self::NON_EMPTY)
    {
        self::arrayExpected($options, 'options');
        if (!isset($options[$what]))
        {
            throw new KTAPI_ValueExpectedException($what);
        }
        $value = $options[$what];
        if (empty($value) && $allowEmpty != self::ALLOW_EMPTY)
        {
            throw new KTAPI_ValueExpectedException($what);
        }

        return $value;
    }


    public static
    function arrayValueExpected($value, $array, $what)
    {
        if (!in_array($value, $array))
        {
            $values = implode(', ', $array);
            throw new KTAPI_BaseException('%s (%s) must be a value in [%s]', $what, $value, $values);
        }
    }

    public static
    function arrayKeyExpected($value, $array, $what = null)
    {
        if (empty($what))
        {
            $what = $value;
        }
        ValidationUtil::arrayExpected($array, $what, true);
        if (!array_key_exists($value, $array))
        {
            $values = implode(', ', $array);
            throw new KTAPI_BaseException('%s (%s) must be a key in [%s]', $what, $value, $values);
        }

        return $array[$value];
    }


    public static
    function stringExpected($string, $what)
    {
        if (empty($string) || !is_string($string))
        {
            throw new KTAPI_BaseException('String expected for %s.', $what);
        }
    }

}

?>