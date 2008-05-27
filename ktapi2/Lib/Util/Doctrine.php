<?php

class Util_Doctrine
{
    /**
     * Initialise doctrine classes
     *
     */
    static public
    function init()
    {
        require_once('lib/Doctrine.php');
        spl_autoload_register(array('Doctrine', 'autoload'));
    }

    /**
     * Establish connection to database using doctrine
     *
     * @param unknown_type $dsn
     * @return unknown
     */
    static private
    function connect($dsn)
    {
        $db = Doctrine_Manager::connection($dsn);
        $db->setCharset('utf8');
        return $db;
    }

    /**
     * Fetch the database connection
     *
     * @param unknown_type $db
     * @return unknown
     */
    static public
    function &getDB($db = null) {
        global $default;

        if(!is_null($db)){
            $default->_db = $db;
        }

        if (is_null($default->_db)) {
            $db = DBUtil::connect("mysql://root:root@localhost/ktdms_kt36");
            $default->_db = $db;
        }else{
            $db = $default->_db;
        }
        return $db;
    }

    /**
     * Returns a flat array containing only the given column value
     *
     * @param string $column
     * @param array $array
     * @return array
     */
    static public
    function getColumnFromArray($column, $array)
    {
        if(!is_array($array)){
            throw new KTapiException(_kt('Array expected.'));
        }

        if(empty($column)) {
            throw new KTapiException(_kt('Column name must be specified.'));
        }

        $temp = array();
        foreach ($array as $row) {
            $temp[] = $row[$column];
        }
        return $temp;
    }
}

?>