<?php

class KTapi
{
    /**
     * Database connection
     *
     * @var Doctrine_Connection
     */
    private static $db;

    /**
     * Initialise database connection
     *
     * @todo ...
     */
    public static
    function init()
    {
        // Root directory
        define('KTAPI2_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        define('KT_ROOT_DIR', realpath(KTAPI2_DIR . '..') . DIRECTORY_SEPARATOR);

        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . KT_ROOT_DIR.'/thirdparty/Doctrine');

        require_once('lib/Doctrine.php');
        spl_autoload_register(array('Doctrine', 'autoload'));
        spl_autoload_register(array('KTapi', 'autoload'));


        // Connect to DB
        KTAPI::connect();

        // Plugin manager if required
        // Any other initialisation
    }

    /**
     * Automatically loads the core classes
     *
     * @param string $classname
     * @return boolean True on success, false otherwise
     */
    public static
    function autoload($classname)
    {
        if (class_exists($classname, false) || interface_exists($classname, false)) {
            return false;
        }

        $directory = KTAPI2_DIR;
        if(strpos($classname, 'Base') === 0){
            $directory .=  'Base' . DIRECTORY_SEPARATOR;
        }

        $source = array('', 'Commercial' . DIRECTORY_SEPARATOR);
        foreach ($source as $dir){

            $class = $directory . $dir . str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';

            if (file_exists($class)) {
                require $class;
                return true;
            }
        }

        return false;
    }

    /**
     * Establish connection to the database
     *
     * @todo Get dsn string from dbconfig file
     * @param string $dsn
     * @return Doctrine_Connection
     */
    private static
    function connect($dsn = null)
    {
        if(is_null($dsn)){
            // TODO: Get from dbconfig file
            $dsn = "mysql://root:root@localhost/ktdms_kt36";
        }
        $db = Doctrine_Manager::connection($dsn);
        $db->setCharset('utf8');
        KTAPI::$db = $db;
        return $db;
    }

    /**
     * Get the database connection object
     *
     * @return Doctrine_Connection
     */
    public static
    function getDb($dsn = null)
    {
        if(is_null(KTAPI::db)){
            $db = KTAPI::connect($dsn);
            if(is_null($db)){
                throw new KTapiException('Database connection not established.');
            }
        }
        return KTAPI::db;
    }

}

// Random test :)

KTapi::init();

$manager = PluginManager::get();

$namespaces = $manager->getNamespaces();

echo "\n".$namespaces[0]->display_name;

?>