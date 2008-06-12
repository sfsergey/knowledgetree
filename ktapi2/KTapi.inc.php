<?php

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
    return Util_i18n::translate(func_get_args());
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
        throw new KTapiException(_kt('File expected: %s', $path));
    }
    return $path;
}

final class KTapi
{
    const PRE_INIT = 'pre-init';
    const POST_INIT = 'post-init';

    /**
     * Database connection
     *
     * @var Doctrine_Connection
     */
    private static $db;

    /**
     * Identifies initialised modules
     *
     * @var array
     */
    private static $initModules = array();

    private static $postInitModules = array();

    private static $includePaths = array();

    public
    function __construct()
    {
        throw new KTapiException(_kt('Doctrine is static class. No instances can be created.'));
    }

    private static
    function loadDBConfig()
    {
        $logger = LoggerManager::getLogger('init');
        if ($logger->isDebugEnabled())
        {
            $logger->debug('KTapi::loadDBConfig() init');
        }
        if (!defined('KT_ROOT_DIR'))
        {
            throw new KTapiConfigurationException('KTapi::loadDBConfig() requires KT_ROOT_DIR.');
        }
        $configPath = _path(KT_ROOT_DIR . 'config/config-path');
        $path = str_replace(array("\n"),array(''),file_get_contents($configPath));
        if ($path === false)
        {
            throw new KTapiConfigurationException('KTapi::loadDBConfig() requires config/config-path to exist.');
        }
        /* TODO:
            Change config-path to contain the directory only?
            Or add a new file for dbconfig-path?
        */
        $path = 'config/dbconfig.inc.php';

        $configPath = KT_ROOT_DIR .  $path;
        if(!file_exists($configPath))
        {
            throw new KTapiConfigurationException(_kt('KTapi::loadDBConfig() requires dbconfig.ini.php to exist in %s relative to %s.', $path, KT_ROOT_DIR));
        }

        require_once($configPath);

        if (!defined('DSN'))
        {
            throw new KTapiConfigurationException(_kt('KTapi::loadDBConfig() requires the DSN to be defined in dbconfig.inc.php'));
        }
    }

    private static
    function initModule($name)
    {
        KTapi::$initModules[] = $name;
    }

    private static
    function isModuleInitialised($name)
    {
        return in_array($name, KTapi::$initModules);
    }

    private static
    function addIncludePath($path)
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        if (substr($path, -1) != DIRECTORY_SEPARATOR)
        {
            $path .= DIRECTORY_SEPARATOR;
        }

        if (!is_dir($path))
        {
            $testPath = KT_ROOT_DIR . $path;
            if (!is_dir($testPath))
            {
                throw new KTapiConfigurationException('Include path does not exist: %s', $testPath);
            }
            $path = $testPath;
        }

        KTapi::$includePaths[] = $path;
    }

    private static
    function initPEAR($init = KTapi::PRE_INIT)
    {
        if ($init == KTapi::PRE_INIT)
        {
            if (!defined('KT_ROOT_DIR'))
            {
                throw new KTapiConfigurationException('KTapi::initPEAR() requires KT_ROOT_DIR.');
            }
            KTapi::addIncludePath('thirdparty/pear');
            KTapi::registerPostInit('initPEAR');
            return;
        }
        // Cannot log in pre-init because paths for pear need to be setup first.
        $logger = LoggerManager::getLogger('init');
        if ($logger->isDebugEnabled())
        {
            $logger->debug(_str('KTapi::initPEAR() %s', $init));
        }
        require_once('PEAR.php');
        KTapi::initModule('pear');
    }

    public static
    function initTestFramework()
    {
        if (!defined('KT_ROOT_DIR'))
        {
            throw new KTapiConfigurationException('KTapi::initTestFramework() requires KT_ROOT_DIR.');
        }

        $fullPath = _ktpath('thirdparty/simpletest');
        if (!is_dir($fullPath))
        {
            throw new KTapiException(_kt('SimpleTest framework not resolved.'));
        }

        require_once(_path($fullPath . 'simpletest/autorun.php'));

        KTapi::initModule('test');
    }

    private static
    function initLogging()
    {
        // NOTE: no need for PRE_INIT checking. LOG4PHP doesn't need to be part of the include path as it maintains
        // it's own directory state once included.

        if (!defined('KT_ROOT_DIR'))
        {
            throw new KTapiConfigurationException('KTapi::initLogging() requires KT_ROOT_DIR.');
        }

        if (KTapi::isModuleInitialised('pear'))
        {
            throw new KTapiConfigurationException('KTapi::initLogging() requires PEAR initialisation.');
        }

        define('KT_LOG4PHP_DIR', KT_ROOT_DIR . 'thirdparty/apache-log4php/src/main/php' . DIRECTORY_SEPARATOR);

        define('LOG4PHP_CONFIGURATION', _path(KT_ROOT_DIR . '/config/ktlog.ini'));


        define('LOG4PHP_DEFAULT_INIT_OVERRIDE', true);
        require_once(KT_LOG4PHP_DIR . 'LoggerManager.php');
        require_once(KT_LOG4PHP_DIR . 'LoggerPropertyConfigurator.php');

        $configurator = new LoggerPropertyConfigurator();
        $repository =& LoggerManager::getLoggerRepository();
        $properties = @parse_ini_file(LOG4PHP_CONFIGURATION);
        $properties['log4php.appender.default'] = 'LoggerAppenderDailyFile';
        $properties['log4php.appender.default.layout'] = 'LoggerPatternLayout';
        $properties['log4php.appender.default.layout.conversionPattern'] = '%d{Y-m-d | H:i:s} | %p | %t | %r | %X{username} | %c | %M | %m%n';
        $properties['log4php.appender.default.datePattern'] = 'Y-m-d';
        $properties['log4php.appender.default.file'] = KT_ROOT_DIR . 'var/log/kt%s.log.txt';

        $configurator->doConfigureProperties($properties, $repository);

        KTapi::initModule('logging');

        LoggerMDC::put('username', 'n/a');

        register_shutdown_function(array('KTapi','pageDone'));
    }

    public static
    function pageDone()
    {
        if (!KTapi::isModuleInitialised('logging'))
        {
            return;
        }

        $logger = LoggerManager::getLogger('page');
        if ($logger->isDebugEnabled())
        {
            $logger->debug('page end');
        }
        LoggerManager::shutdown();
    }

    private static
    function initDoctrine($init = KTapi::PRE_INIT)
    {
        $logger = LoggerManager::getLogger('init');
        if ($logger->isDebugEnabled())
        {
            $logger->debug(_str('KTapi::initDoctrine() %s', $init));
        }
        if ($init == KTapi::PRE_INIT)
        {
            if (!defined('KT_ROOT_DIR'))
            {
                throw new KTapiConfigurationException('KTapi::initDoctrine() requires KT_ROOT_DIR');
            }
            KTapi::addIncludePath('thirdparty/Doctrine');
            KTapi::registerPostInit('initDoctrine');
            return;
        }

        require_once('lib/Doctrine.php');
        spl_autoload_register(array('Doctrine', 'autoload'));
        KTapi::initModule('doctrine');
    }

    private static
    function initPaths($init = KTapi::PRE_INIT)
    {
        // NOTE: when defining constant paths, the last character must be DIRECTORY_SEPARATOR
        //

        // TODO: once the paths are validated, we should cache this either to a file or to something
        // like memcache

        // NOTE: this should be used when adding new folders
        //
        // We can disable this when new folders

        if ($init == KTapi::PRE_INIT)
        {
            define('KTAPI2_DIR', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
            define('KT_ROOT_DIR', realpath(KTAPI2_DIR . '..') . DIRECTORY_SEPARATOR);
            KTapi::registerPostInit('initPaths');
            return;
        }

        // We can't log init path because logging requires paths to be setup
        $logger = LoggerManager::getLogger('init');
        if ($logger->isDebugEnabled())
        {
            $logger->debug(_str('KTapi::initDoctrine() %s', $init));
        }

        $testPathExistance = true;

        // define directory

        // Add paths that are required to this array

        foreach(KTapi::$includePaths as $i=>$path)
        {
            $full_path = KT_ROOT_DIR . $path;
            if ($testPathExistance)
            {
                if (!is_dir($full_path) && !is_dir($path))
                {
                    throw new KTapiException(_kt('Directory does not exist: %s', $path));
                }

            }
             $include_paths[$i] = (strpos($path, KT_ROOT_DIR) === 0)?$path:$full_path;
        }

        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . implode(PATH_SEPARATOR, $include_paths));
        KTapi::initModule('paths');
    }

    private static
    function registerPostInit($func)
    {
        if (in_array($func, KTapi::$postInitModules))
        {
            throw new KTapiException(_kt('Post initialisation function already registerd: %s', $func));
        }
        KTapi::$postInitModules[] = $func;
    }

    private static
    function postInit()
    {
        foreach(KTapi::$postInitModules as $func)
        {
            KTapi::$func(KTapi::POST_INIT);
        }
    }

    /**
     * Initialise database connection
     *
     * @todo ...
     */
    public static
    function init($standalone = false)
    {
        // initialise KTapi class loading
        spl_autoload_register(array('KTapi', 'autoload'));

        KTapi::initPaths();
        KTapi::initPEAR();
        KTapi::initLogging();
        KTapi::loadDBConfig();
        KTapi::initDoctrine();

        KTapi::postInit();

        // Connect to DB
        KTAPI::connect();

        $logger = LoggerManager::getLogger('sql');
        if ($logger->isDebugEnabled())
        {
            $db = KTapi::getDb();
            $db->setListener(new KTAPI_LogListener());
        }

        $logger = LoggerManager::getLogger('page');
        if ($logger->isDebugEnabled())
        {
            $logger->debug('page start');
        }
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

        $directory = KTAPI2_DIR . 'Lib/';
        $filename = $classname;

        if(strpos($classname, 'KTAPI_') === 0) {
            $filename = substr($classname, 6);
        }
//        if(strpos($classname, 'Base') === 0){
//            $directory .=  'Base' . DIRECTORY_SEPARATOR;
//        }
        if (substr($classname, -9) == 'Exception')
        {
            $directory .= 'Exception' . DIRECTORY_SEPARATOR;
            if (strpos($classname,'KTapi') === 0)
            {
                $filename = substr($classname, 5);
            }
        }
        elseif (substr($classname, -9) == 'Parameter')
        {
            $directory .= 'Parameter' . DIRECTORY_SEPARATOR;
            if (strpos($classname,'KTapi') === 0)
            {
                $filename = substr($classname, 5);
            }
        }


        $source = array('');
        foreach ($source as $dir) {

            $class_file = $directory . $dir . str_replace('_', DIRECTORY_SEPARATOR, $filename) . '.php';

            if (file_exists($class_file)) {
                require_once($class_file);
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
        $logger = LoggerManager::getLogger('init');
        if ($logger->isDebugEnabled())
        {
            $logger->debug(_str('KTapi::connect() to database'));
        }

        if(is_null($dsn)){
            $dsn = DSN;
        }
        $db = Doctrine_Manager::connection($dsn);
        $db->setCharset('utf8');
        $db->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
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
                throw new KTapiException(_kt('Database connection not established.'));
            }
        }
        return KTAPI::$db;
    }

    public static
    function validateClass($classname, $object)
    {
        if (is_numeric($object))
        {
            $object = eval("return $classname::get(\$object);");
        }
        if (!eval("return \$object instanceof $classname;"))
        {
            throw new KTapiException(_kt('%s expected', $classname));
        }
        return $object;
    }

}

KTapi::init();


//$manager = PluginManager::registerTrigger(new CustomAddDocumentTrigger());



/* Random test :)

KTapi::init();

$manager = PluginManager::get();

$namespaces = $manager->getAction('Action.AddDocument');

print_r($namespaces);
*/
?>