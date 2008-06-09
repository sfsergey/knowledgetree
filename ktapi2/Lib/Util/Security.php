<?php

class Util_Security
{

    public static
    function hashPassword($password)
    {
        return md5($password);
    }

    public static
    function randomPassword()
    {
        // TODO
        return 'randompwd';
    }

}