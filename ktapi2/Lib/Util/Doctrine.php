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

    static public
    function getEntityByField($baseClass, $instanceClass, $pair)
    {
        if (!is_array($pair))
        {
            throw new Exception('Pair array expected.');
        }
        if (empty($pair))
        {
            throw new Exception('Non empty array expected.');
        }
        $query = Doctrine_Query::create();
        $query = $query->select('c.*')
                ->from($baseClass . ' c')
                ->limit(1);

        $i = 0;
        foreach($pair as $fieldname=>$value)
        {
            if ($i++)
            {
                $query->addWhere(' AND ');
            }
            $query->addWhere('c.' . $fieldname . ' = :value', array(':value'=>$value));
        }

        $rows = $query->execute();

        if ($rows->count() == 0)
        {
            throw new KTapiException('No records found matching the criteria.');
        }

        return new $instanceClass($rows[0]);
    }

    public static
    function getEntityByIds($baseClass, $instanceClass, $idfield, $id)
    {
        if (is_numeric($id))
        {
            $id = array($id);
        }
        if (!is_array($id))
        {
            throw new KTapiException('Array expected.');
        }

        if (empty($id))
        {
            throw new KTapiException('Non empty array expected.');
        }

        $query = Doctrine_Query::create();
        $rows = $query->select('c.*')
                ->from($baseClass . ' c')
                ->whereIn('c.' . $idfield, $id)
                ->limit(count($id))
                ->execute();

        $count = $rows->count();

        if ($count == 0)
        {
            throw new KTapiException(_str('No record(s) found matching id(s): %s.', implode(',', $id)));
        }

        $records = array();
        foreach($rows as $row)
        {
            $records[] = new $instanceClass($row);
        }

        if ($count == 1)
        {
            return $records[0];
        }
        else
        {
            return $records;
        }
    }

    public static
    function createView($viewname, $query)
    {
        if (!$query instanceof Doctrine_Query)
        {
            throw new KTapiException('Doctrine_Query object expected.');
        }
        $view  = new Doctrine_View($query, $viewname);

        $view->create();
    }

    public static
    function dropView($viewname)
    {
        $db = KTapi::getDb();
        try {
        $db->execute('DROP VIEW ' . $viewname);
        }
        catch(Exception $ex)
        {
            print $ex->getMessage();
        }
    }

    public static
    function dropTable($tablename)
    {
        $db = KTapi::getDb();
        try {
            $db->export->dropTable($tablename);
         }
        catch(Exception $ex)
        {
            print $ex->getMessage();

        }
    }

    public static
    function addPrimaryKey($tablename, $fields)
    {
        $db = KTapi::getDb();
        try {
            $flds = array();
            foreach ($fields as $fld)
            {
                $flds[$fld] = array();
            }
            $db->export->createConstraint($tablename, $tablename . '_primary',
                array( 'fields' => $flds , 'primary'=>true));

         }
        catch(Exception $ex)
        {
            print $ex->getMessage();

        }
    }

    public static
    function dropIndex($tablename, $indexname)
    {
        $db = KTapi::getDb();
        try {
            $db->export->dropIndex($tablename, $indexname);
         }
        catch(Exception $ex)
        {
            print $ex->getMessage();

        }
    }

    public static
    function dropField($tablename, $fieldname)
    {
        $db = KTapi::getDb();
        try {
            $db->export->alterTable($tablename, array('remove' => array(

                                          $fieldname => array()
                                  )));
         }
        catch(Exception $ex)
        {
            print $ex->getMessage();

        }
    }

    public static
    function findByPrimary($class, $value, $throwException = true)
    {
        $class = Doctrine::getTable($class);
        $row = $class->find($value);

        if ($throwException && $row === false)
        {
            throw KTapiException('Could not delete row.');
        }

        return $row;
    }

    public static
    function deleteByPrimary($class, $value)
    {
        $row = self::findByPrimary($class, $value);

        return $row->delete();
    }
}

?>