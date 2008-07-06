<?php

class KTUtil
{
    public static
    function init()
    {

    }

    public static
    function writeFile($filename, $content)
    {
        $result = file_put_contents($filename, $content);

        if ($result === false)
        {
            throw new Exception('Could not write file.');
        }
    }

    public static
    function url()
    {
        $host = $_SERVER['HTTP_HOST'];
        $port = $_SERVER['SERVER_PROTOCOL'];
    }

}

/**
 * The translation helper function.
 *
 * The tr
 *
 * @param string $format
 * @return string
 */
function _kt($format)
{
    return i18nUtil::translate(func_get_args());
}

/**
 * Function to serialise php objects.
 * Currently it wraps serialize(). We can change to another format needs be.
 *
 * @param mixed $mixed
 * @return string
 */
function _serialize($mixed)
{
    return serialize($mixed);
}

function _str($format)
{
    $params = func_get_args();
    $format = array_shift($params);
    if (!is_string($format))
    {
        throw new KTapiException(_kt('_str expected first parameter to be a string.'));
    }

    array_unshift($params,$format);

    return call_user_func_array('sprintf', $params);
}

function _flatten($array)
{
    $new = $array;
    foreach($array as $key=>$value)
    {
        if (is_array($value))
        {
            $new = array_merge($new, $value);
            unset($new[$key]);
        }
    }
    return $new;
}

function _flattenArray($array)
{
    foreach($array as $i=>$a)
    {
        $array[$i] = _flatten($a);
    }
    return $array;
}

function _extractArray($rows, $property)
{
    if (!$rows instanceof Doctrine_Collection)
    {
        throw new Exception('Doctrine_Collection expected!');
    }
    if ($rows->count() == 0)
    {
        return array();
    }
    $array = array();
    foreach($rows as $row)
    {
        $array[] = $row->$property;
    }
    return $array;
}


/**
 * Ensures the path ends with the appropriate slash depending on operating system and
 * that all slashes are the same.
 *
 * @param string $path
 * @param boolean $append [optional] default true
 * @return string
 */
function _path($path, $append=true)
{
    if ($append && substr($path, -1) != DIRECTORY_SEPARATOR)
    {
        $path .= DIRECTORY_SEPARATOR;
    }
    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}

/**
 * Prepends KT_ROOT_DIR to the path and ensures that slashes are correct.
 *
 * @param string $path
 * @param boolean $append [optional] default true
 * @return string
 */
function _ktpath($path, $append=true)
{
    return KT_ROOT_DIR . _path($path,$append);
}

/**
 * Removes KT_ROOT_DIR from the path if it is present.
 *
 * @param string $path
 * @return string
 */
function _relativepath($path)
{
    if (strpos($path, KT_ROOT_DIR) === 0)
    {
        $path = substr($path, strlen(KT_ROOT_DIR));
    }
    return $path;
}

/**
 * Prepends KTAPI2_DIR to the path and ensures that slashes are correct.
 *
 * @param string $path
 * @param boolean $append [optional] default true
 * @return string
 */
function _ktapipath($path, $append=true)
{
    return KTAPI2_DIR . _path($path,$append);
}



function _require($path, $parent)
{
    if (!empty($path) && dirname($path) == '.')
    {
        $path = _path($parent) . $path;
    }

    if (!file_exists($path))
    {
        $tmp = _path($parent) . $path;
        if (file_exists($tmp))
        {
            return $tmp;
        }
        throw new KTapiException(_kt('File expected: %s', $path));
    }
    return $path;
}

?>