<?php

define('KT_ROOT_DIR', realpath(__FILE__ . '../../') . DIRECTORY_SEPARATOR);
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . KT_ROOT_DIR.'/thirdparty/Doctrine');

define('KT_DOCTRINE_BASE_DIR', KT_ROOT_DIR.'/sql/doctrine/base');

require_once('lib/Doctrine.php');
spl_autoload_register(array('Doctrine', 'autoload'));

class ModelManager
{
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
    static public
    function exportTables($dir = null)
    {
        if(is_null($dir)){
            $dir = KT_DOCTRINE_BASE_DIR;
        }

        if(!file_exists($dir)){
            mkdir($dir, 0755);
            if(!file_exists($dir)){
                throw new Exception('Cannot create export directory for models '.$dir);
            }
        }

        $db = DoctrineUtil::getDB();
        Doctrine::generateModelsFromDb($dir);
    }

    static public
    function importTables($dir = null)
    {
        if(is_null($dir)){
            $dir = KT_DOCTRINE_BASE_DIR . DIRECTORY_SEPARATOR . 'generated';
        }

        if(!file_exists($dir)){
            throw new Exception('Cannot find import directory for models');
        }

        $db = DoctrineUtil::getDB();
        $manager->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL); // Doctrine::EXPORT_TABLES | Doctrine::EXPORT_CONSTRAINTS

        Doctrine::createTablesFromModels($dir);
    }
}

DoctrineUtil::

?>