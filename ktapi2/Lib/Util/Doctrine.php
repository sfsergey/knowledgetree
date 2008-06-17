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

        $records = Util_Doctrine::getObjectArrayFromCollection($rows, $instanceClass);

        $count = count($records);

        switch ($count)
        {
            case 0:
                throw new KTapiException(_str('No %s records(s) found matching id(s): %s.', $instanceClass, implode(',', $id)));
            case 1;
                return $records[0];
            default:
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

    public static
    function simpleQuery($classname, $condition, $instanceClass = null)
    {
        $query = Doctrine_Query::create()
            ->select('c.*')
            ->from($classname . ' c');
        foreach($condition as $k=>$v)
        {
            $query->addWhere("c.$k = :$k", array(":$k"=>$v));
        }

        $rows = $query->execute();

        return self::getObjectArrayFromCollection($rows, $instanceClass);
    }

    public static
    function simpleOneQuery($classname, $condition, $instanceClass = null)
    {
        $records = self::simpleQuery($classname, $condition, $instanceClass);

        switch (count($records))
        {
            case 1;
                return $records[0];
            default:
                throw new KTapiException(_str('No %s records(s) found matching conditions.', $classname));
        }
    }


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