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

    /**
     * Validates that the parameter is a reference to a group.
     *
     * @param mixed $group This may be an integer or Security_Group.
     * @return Security_Group
     */
    public static
    function validateGroup($group)
    {
        return KTapi::validateClass('Security_Group', $group);
    }

    /**
     * Validates the parameter as a reference to a user.
     *
     * @param string $user
     * @return Security_User
     */
    public static
    function validateUser($user)
    {
        return KTapi::validateClass('Security_User', $user);
    }


}