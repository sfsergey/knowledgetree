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
    function init($standalone = false)
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
        if(is_null(KTAPI::$db)){
            $db = KTAPI::connect($dsn);
            if(is_null($db)){
                throw new KTapiException('Database connection not established.');
            }
        }
        return KTAPI::$db;
    }

}

KTapi::init();

/* Straight sql test */

$conn = KTapi::getDb();

$manager = Doctrine_Manager::getInstance();

/*
$c = $conn->fetchAll('
    SELECT * FROM entity E
    INNER JOIN details D ON E.id = D.entity_id
    ');
*/
/*
$c = $conn->fetchOne('SELECT E.name FROM entity E
    INNER JOIN details D ON E.id = D.entity_id
    WHERE D.id = ?', array(3));
*/
/*
$c = $conn->fetchColumn('SELECT name FROM entity E
    INNER JOIN details D ON E.id = D.entity_id');
*/
/*
$c = $conn->fetchArray('SELECT * FROM entity E
    INNER JOIN details D ON E.id = D.entity_id');
*/
/*
$c = $conn->fetchRow('SELECT * FROM entity E
    INNER JOIN details D ON E.id = D.entity_id');
*/
$c = $conn->fetchAssoc('SELECT * FROM entity E
    INNER JOIN details D ON E.id = D.entity_id');

echo "\n";
print_r($c);



/*
$conn->exec('DROP TABLE entity');
$conn->exec('CREATE TABLE entity (id INT, name TEXT)');

$conn->exec("INSERT INTO entity (id, name) VALUES (1, 'zYne')");
$conn->exec("INSERT INTO entity (id, name) VALUES (2, 'John')");
$conn->exec("INSERT INTO entity (id, name) VALUES (3, 'Gareth')");
$conn->exec("INSERT INTO entity (id, name) VALUES (4, 'Brat')");

$a = $conn->fetchAll('SELECT * FROM entity');

echo "\n";
print_r($a);

$conn->exec('DROP TABLE details');
$conn->exec('CREATE TABLE details (id INT, entity_id INT, cell INT)');

$conn->exec("INSERT INTO details (id, entity_id, cell) VALUES (1, 1, 0823456789)");
$conn->exec("INSERT INTO details (id, entity_id, cell) VALUES (2, 2, 0831234567)");
$conn->exec("INSERT INTO details (id, entity_id, cell) VALUES (3, 3, 0728765432)");
$conn->exec("INSERT INTO details (id, entity_id, cell) VALUES (4, 4, 0734569872)");

$d = $conn->fetchAll('SELECT * FROM details');

echo "\n";
print_r($d);

*/



/* Trigger test
class CustomAddDocumentTrigger extends Trigger
{
    public
    function __construct()
    {
        parent::__construct();

    }

    public
    function execute($context, $action_namespace, $action_params, $runningWhen)
    {

    }

    function GetParameters()
    {
        return array(
            'extra'=>array('insert_after'=>'title','type'=>'string', 'required'=>false),
        );
    }

    function AppliesToNamespaces()
    {
        return array('action.document.checkin','action.document.add');
    }
}


$manager = PluginManager::registerTrigger(new CustomAddDocumentTrigger());
*/


/* Random test :)

KTapi::init();

$manager = PluginManager::get();

$namespaces = $manager->getAction('Action.AddDocument');

print_r($namespaces);
*/
?>