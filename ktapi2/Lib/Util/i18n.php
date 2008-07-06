<?php

class i18nUtil
{
    public static
    function translate($format, $params = array())
    {
        if (is_array($format))
        {
            $params = $format;
            $format = array_shift($params);
        }
        if (!is_string($format))
        {
            throw new KTapiException('_kt expected first parameter to be a string.');
        }

        array_unshift($params,$format);

        // TODO: wangle translation
        $params[0] = "_tr($format)";

        return call_user_func_array('sprintf', $params);
    }
}




?>