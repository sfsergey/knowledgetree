<?php

/**
 * Manager class for managing the import and export of the database tables and base classes
 */

class ModelManager
{
    /**
     * Initialise the Model Manager
     */
    public static
    function initManager()
    {
        $modelPath = dirname(__FILE__) . '/../..';
        define('KT_ROOT_DIR', realpath($modelPath) . DIRECTORY_SEPARATOR);

        define('KT_DOCTRINE_BASE_DIR', KT_ROOT_DIR.'sql/doctrine/base/');
        define('KT_DOCTRINE_TMP_DIR', KT_ROOT_DIR.'sql/doctrine/tmp/');

        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . KT_ROOT_DIR.'thirdparty/Doctrine');

        require_once('lib/Doctrine.php');
        spl_autoload_register(array('Doctrine', 'autoload'));
    }

    /**
     * Establish connection to database using doctrine
     *
     * @param string $dsn
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
     * @param Doctrine_Connection $db
     * @return Doctrine_Connection
     */
    static public
    function &getDB($db = null) {
        static $conn = null;

        if(!is_null($db) && $db instanceof Doctrine_Connection){
            $conn = $db;
        }

        if (is_null($conn)) {
            $dsn = 'mysql://root:root@localhost/kt_refactor';
            $db = Doctrine_Manager::connection($dsn);
            $conn = $db;
        }else{
            $db = $conn;
        }
        return $db;
    }

    /**
     * Create base classes from the database tables.
     *
     * @param string $dir The directory in which to save the tables
     */
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

        $tmp = KT_DOCTRINE_TMP_DIR;

        if(!file_exists($tmp)){
            mkdir($tmp, 0755);
            if(!file_exists($tmp)){
                throw new Exception('Cannot create temporary export directory for models '.$tmp);
            }
        }

        // Generate models and base classes
        $db = ModelManager::getDB();
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_CONSTRAINTS); // Doctrine::EXPORT_TABLES | Doctrine::EXPORT_CONSTRAINTS

        // Set the template
//        $tpl = <<<END
//%sclass %s extends %s
//{
//%s
//%s
//%s
//}
//END;
//
//        $options = array(
//                'BaseClassPrefix' => 'Base_',
//                'generateTableClasses' => false,
//                'BaseClassesDirectory' => 'Base',
//                '_tpl' => $tpl
//            );

        $options = array('detect_relations' => true);
        Doctrine::generateModelsFromDb($tmp, array(), $options);


        // Recurse through the base classes
        // Change the class name to match the directory structure ie BaseClass becomes Base_Class
        // Save the class to the given directory and rename the file to Class.php.
        $tmpGenerated = $tmp . 'generated' . DIRECTORY_SEPARATOR;
        $dirh = opendir($tmpGenerated);
        while (($entry = readdir($dirh)) !== false) {
            if (in_array($entry, array('.', '..'))) {
                continue;
            }
            $newpath = $tmpGenerated . $entry;
            if (is_dir($newpath) || !is_file($newpath)) {
                continue;
            }

            $class = substr($entry, 4, -4);
            $newFile = $dir . $class . '.php';

            // Rename the class from BaseClass to Base_Class and remove the abstract
            $fileData = file_get_contents($newpath);
            $fileData = str_replace('abstract class Base'.$class, 'class Base_'.$class, $fileData);
            file_put_contents($newFile, $fileData);
        }

        // Delete temporary files
        self::deleteDir($tmp);
    }

    /**
     * Create database tables from the base class definitions.
     *
     * @param string $dir The directory in which the classes are stored.
     */
    static public
    function importTables($dir = null)
    {
        if(is_null($dir)){
            $dir = KT_DOCTRINE_BASE_DIR;
        }

        if(!file_exists($dir)){
            throw new Exception('Cannot find import directory for models');
        }

        $db = self::getDB();
        Doctrine::createTablesFromModels($dir);
    }

    /**
     * Recursively delete a directory
     *
     * @param string $dir
     */
    static private
    function deleteDir($dir)
    {
        if(substr(PHP_OS, 0, 3) == 'WIN') {
            // Potentially kills off all the files in the path, speeding
            // things up a bit
            exec("del /q /s " . escapeshellarg($dir));
        } else {
            if (file_exists('/bin/rm')) {
                exec("/bin/rm -rf $dir");
                return;
            }
        }

        $hPath = @opendir($dir);
        while (($sFilename = readdir($hPath)) !== false) {
            if (in_array($sFilename, array('.', '..'))) {
                continue;
            }
            $sFullFilename = sprintf("%s/%s", $sPath, $sFilename);
            if (is_dir($sFullFilename)) {
                self::deleteDir($sFullFilename);
                continue;
            }
            @chmod($sFullFilename, 0666);
            @unlink($sFullFilename);
        }
        closedir($hPath);
        @rmdir($dir);
    }
}

//ModelManager::initManager();
//ModelManager::exportTables();

?>