<?php

class DoctrineUtil
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
        ValidationUtil::arrayExpected($array, 'array', ValidationUtil::ALLOW_EMPTY);
        ValidationUtil::valueExpected($column, 'column');

        $temp = array();
        foreach ($array as $row) {
            $temp[] = $row[$column];
        }
        return $temp;
    }

    static public
    function getEntityByField($baseClass, $instanceClass, $pair)
    {
        ValidationUtil::arrayExpected($pair, 'pair');

        $query = Doctrine_Query::create();
        $query = $query->select('c.*')
                ->from($baseClass . ' c')
                ->limit(1);

        $i = 0;
        foreach($pair as $fieldname=>$value)
        {
            $where = (($i++ > 0)? ' AND ':'') .   'c.' . $fieldname . ' = :value';
            $query->addWhere( $where, array(':value'=>$value));
        }

        $rows = $query->execute();
        ValidationUtil::recordsExpected($rows);

        return new $instanceClass($rows[0]);
    }

    public static
    function getEntityByIds($baseClass, $instanceClass, $idfield, $id)
    {
        if (is_numeric($id))
        {
            $id = array($id);
        }
        ValidationUtil::arrayExpected($id, 'id');

        $query = Doctrine_Query::create();
        $rows = $query->select('c.*')
                ->from($baseClass . ' c')
                ->whereIn('c.' . $idfield, $id)
                ->limit(count($id))
                ->execute();

        $records = DoctrineUtil::getObjectArrayFromCollection($rows, $instanceClass);

        $count = ValidationUtil::recordsExpected($records);

        switch ($count)
        {
            case 1;
                return $records[0];
            default:
                return $records;
        }
    }

    public static
    function createView($viewname, $query)
    {
        ValidationUtil::validateType($query, 'Doctrine_Query');

        $view  = new Doctrine_View($query, $viewname);

        $view->create();
    }

    public static
    function dropView($viewname)
    {
        $db = KTapi::getDb();
        try
        {
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
        try
        {
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
        try
        {
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
            throw new KTAPI_Database_Record_DeletionException('Could not delete record.');
        }

        return $row;
    }

    public static
    function deleteByPrimary($class, $value)
    {
        $row = self::findByPrimary($class, $value);

        return $row->delete();
    }

    public static
    function getObjectArrayFromCollection($rows, $classname = null, $key = null)
    {
        $count = $rows->count();
        if ($count == 0)
        {
            return array();
        }

        $array = array();
        if (is_null($classname))
        {
            if (is_null($key))
            {
                foreach($rows as $row)
                {
                    $array[] = $row;
                }
            }
            else
            {
                foreach($rows as $row)
                {
                    $array[$row->$key] = $row;
                }
            }
        }
        else
        {
            if (is_null($key))
            {
                foreach($rows as $row)
                {
                    $array[] = new $classname($row);
                }
            }
            else
            {
                foreach($rows as $row)
                {
                    $array[$row->$key] = new $classname($row);
                }
            }

        }

        return $array;
    }

    public static
    function simpleDelete($classname, $condition)
    {
        $query = Doctrine_Query::create()
            ->delete()
            ->from($classname . ' c');
        foreach($condition as $k=>$v)
        {
            $query->addWhere("c.$k = :$k", array(":$k"=>$v));
        }

        $rows = $query->execute();
    }

    /**
     * Does a simple query on a table, where the condition is an array of fields thus must all match.
     *
     * $condition is an array of all matches. e.g. array(firstname=>'conrad', 'age'=>17) implies firstname = conrad and age= 17.
     * $classname is the Doctrine_Record class that should be used to query the relevant table.
     * $instanceClass is to help instanciate the correct wrapper class.
     *
     * @param string $classname
     * @param array $condition
     * @param string $instanceClass
     * @param int $limit
     * @return array
     */
    public static
    function simpleQuery($classname, $condition, $instanceClass = null, $limit = null)
    {
        $query = Doctrine_Query::create()
            ->select('c.*')
            ->from($classname . ' c');

        if (isset($limit))
        {
            $query->limit($limit);
        }

        foreach($condition as $k=>$v)
        {
            $query->addWhere("c.$k = :$k", array(":$k"=>$v));
        }

        $rows = $query->execute();

        return self::getObjectArrayFromCollection($rows, $instanceClass);
    }

    /**
     * This is aimed at performing a specific query where only one record should be returned.
     *
     * @param string $classname
     * @param array $condition
     * @param string $instanceClass
     * @return mixed Normally descendant of Doctrine_Record
     */
    public static
    function simpleOneQuery($classname, $condition, $instanceClass = null)
    {
        $records = self::simpleQuery($classname, $condition, $instanceClass, 1);

        switch (count($records))
        {
            case 1;
                return $records[0];
            default:
                throw new KTAPI_Database_Record_ExpectedException('No %s records(s) found matching conditions.', $classname);
        }
    }

    /**
     * Updates a class.
     *
     * $classname is the Doctrine_Record class that should be used to query the relevant table.
     * $condition is an array of all matches. e.g. array(firstname=>'conrad', 'age'=>17) implies firstname = conrad and age= 17.
     * $update is an array of fields that must be updated.
     *
     * @param string $classname
     * @param array $update
     * @param array $condition
     * @return int Number of affected records.
     */

    public static
    function update($classname, $update, $condition)
    {
        $query = Doctrine_Query::create()
            ->update($classname . ' c');
        foreach($update as $k=>$v)
        {
            $query->set("c.$k", ":$k", array(":$k"=>$v));
        }
        foreach($condition as $k=>$v)
        {
            $query->addWhere("c.$k = :$k", array(":$k"=>$v));
        }

        return $query->execute();
    }

}

?>