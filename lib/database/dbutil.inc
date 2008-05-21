<?php
/**
 * $Id$
 *
 * Database access utility class
 *
 * KnowledgeTree Community Edition
 * Document Management Made Simple
 * Copyright (C) 2008 KnowledgeTree Inc.
 * Portions copyright The Jam Warehouse Software (Pty) Limited
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * You can contact KnowledgeTree Inc., PO Box 7775 #87847, San Francisco,
 * California 94120-7775, or email info@knowledgetree.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * KnowledgeTree" logo and retain the original copyright notice. If the display of the
 * logo is not reasonably feasible for technical reasons, the Appropriate Legal Notices
 * must display the words "Powered by KnowledgeTree" and retain the original
 * copyright notice.
 * Contributor( s): ______________________________________
 */

//require_once ('PEAR.php');

require_once('lib/Doctrine.php');
spl_autoload_register(array('Doctrine', 'autoload'));

class DBUtil {
    static private $last_query;

    static function connect($dsn) {
        $conn = Doctrine_Manager::connection($dsn);
        $conn->setCharset('utf8');
        return $conn;
    }

    static function getDoctrineConnection($conn = null)
    {
        global $default;

        if(!is_null($conn)){
            $default->_conn = $conn;
        }

        if (is_null($default->_conn)) {
            $conn = DBUtil::connect("mysql://root:root@localhost/kt_refactor");
            $default->_conn = $conn;
        }else{
            $conn = $default->_conn;
        }
        return $conn;
    }

    static function &getDB($db = null) {
        global $default;
        if (is_null($db)) {
            $db =& $default->_db;
        }

    	if(!isset($db->_kt_initialized) || !$db->_kt_initialized) {
    	    $db->query("SET NAMES 'utf8'");
    	    $db->_kt_initialized = true;
    	}

        return $db;
    }

    /**
     * Execute a sql query
     *
     * @param array|string $query
     * @param Doctrine_Connection $conn
     * @return integer The number of rows affected by the query
     */
    static function &runQuery($query, $conn = null) {
        try {
            $aParams = array();

            if (is_array($query)) {
                $sQuery = $query[0];
                $aParams = (count($query) > 1)?$query[1]:array();
            } else {
                $sQuery = $query;
            }

            $conn = DBUtil::getDoctrineConnection($conn);
            $res = $conn->exec($sQuery, $aParams);

        } catch (Exception  $e) {
            DBUtil::logQueryError(DBUtil::lastQuery($conn), $e);
            $res = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . DBUtil::lastQuery($conn));
        }

        return $res;
    }

    /**
     * Fetches a single record from the table
     *
     * @param array|string $query The sql query and parameters.
     * @param Doctrine_Connection $conn The database connection.
     * @return array
     */
    static function getOneResult($query, $conn = null) {
        try {
            $aParams = array();

             if (is_array($query)) {
                $sQuery = $query[0];
                $aParams = (count($query) > 1) ? $query[1]:array();

                if(!is_array($aParams)){
                    $aParams = array($aParams);
                }
            } else {
                $sQuery = $query;
            }

            $conn = DBUtil::getDoctrineConnection($conn);
            $aRow = $conn->fetchRow($sQuery, $aParams);
        }catch (Exception $e){
            DBUtil::logQueryError(DBUtil::lastQuery($conn), $e);
            $aRow = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . DBUtil::lastQuery($conn));
        }

        return $aRow;
    }

    /**
     * Fetches the value for a given column in a record.
     *
     * @param array|string $query The sql query and parameters.
     * @param string $key The column name.
     * @param Doctrine_Connection $conn The database connection.
     * @return array
     */
    static function getOneResultKey($query, $key, $conn = null) {
        $aRow = DBUtil::getOneResult($query, $conn);
        if (PEAR::isError($aRow)) {
            // logging by runQuery
            return $aRow;
        }
        return $aRow[$key];
    }

    /**
     * Fetches an array of records
     *
     * @param array|string $query The sql query and parameters.
     * @param Doctrine_Connection $conn The database connection.
     * @return array
     */
    static function getResultArray($query, $conn = null) {
        try {
            $aParams = array();

             if (is_array($query)) {
                $sQuery = $query[0];
                $aParams = (count($query) > 1) ? $query[1]:array();

                if(!is_array($aParams)){
                    $aParams = array($aParams);
                }
            } else {
                $sQuery = $query;
            }

            $conn = DBUtil::getDoctrineConnection($conn);
            $aRow = $conn->fetchAssoc($sQuery, $aParams);
        } catch (Exception $e) {
            DBUtil::logQueryError(DBUtil::lastQuery($conn), $e);
            $aRow = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . DBUtil::lastQuery($conn));
        }

        return $aRow;
    }

    /**
     * Fetches an array of values for a given column in the table.
     *
     * @param array|string $query The sql query and parameters.
     * @param string $key The column name.
     * @param Doctrine_Connection $conn The database connection.
     * @return array
     */
    static function getResultArrayKey($query, $key, $conn = null) {
        // This should use $conn->fetchColumn() but that require the query
        // to specify the column and not use *.
        $result = DBUtil::getResultArray($query, $conn);

        if(PEAR::isError($result)){
            return $result;
        }

        $aReturn = array();
        if(!empty($result)){
            foreach ($result as $item){
                $aReturn[] = $item[$key];
            }
        }
        return $aReturn;
    }

    /**
     * Write the query and error to the log file
     *
     * @param string $query The sql query
     * @param PEAR_ERROR $result
     */
    function logQueryError($query, $result) {
        global $default;
        $default->log->error('Problem Query: ' . $query);
        $default->log->error('Problem: ' . $result->getMessage());
    }

    /**
     * Get the next id for inserting in the table
     *
     * @param unknown_type $seqname
     * @param unknown_type $ondemand
     * @param unknown_type $db
     * @return unknown
     */
    function nextId($seqname, $ondemand = false, $conn = null) {
        $conn = DBUtil::getDoctrineConnection($conn);

        // To Do: Find a better way to achieve this!
        $query = "SELECT id FROM {$seqname} ORDER BY id DESC";
        $res = DBUtil::getOneResultKey($query, 'id');
        $id = (int) $res;
        return $id + 1;

        /*
        $db =& DBUtil::getDB($db);
        return $db->nextId($seqname, $ondemand);
        */
    }

    /**
     * Execute a set of queries
     *
     * @param array $aQueries
     * @param Doctrine_Connection $conn
     * @return bool
     */
    function runQueries($aQueries, $conn = null) {
        foreach ($aQueries as $sQuery) {
            $res = DBUtil::runQuery($sQuery, $conn);
            if (PEAR::isError($res)) {
                return $res;
            }
        }
        return true;
    }

    /**
     * Insert a new record
     *
     * @param unknown_type $sTable
     * @param unknown_type $aFieldValues
     * @param unknown_type $aOptions
     * @return unknown
     */
    function &autoInsert($sTable, $aFieldValues, $aOptions = null) {
        $conn = DBUtil::getDoctrineConnection();

        if (is_null($aOptions)) {
            $aOptions = array();
        }

        $bNoId = KTUtil::arrayGet($aOptions, 'noid', false);

        if (!array_key_exists('id', $aFieldValues) && ($bNoId === false)) {
            $res = DBUtil::nextId($sTable, null, $db);
            if (PEAR::isError($res)) {
                return $res;
            }
            $aFieldValues['id'] = $res;
        }

        $oTable = new Doctrine_Table($sTable, $conn);

        $res = $conn->insert($oTable, $aFieldValues);
        return $res;


        /*
        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . DBUtil::lastQuery($db));
        }
        if ($res === DB_OK) {
            return $aFieldValues['id'];
        }
        if (PEAR::isError($res)) {
        	DBUtil::logQueryError(DBUtil::lastQuery($db), $res);
            return $res;
        }
        return PEAR::raiseError(_kt('Unknown return value for autoInsert'));

        /*
        if (is_null($aOptions)) {
            $aOptions = array();
        }

        $bNoId = KTUtil::arrayGet($aOptions, 'noid', false);
        global $default;
        // $default->log->debug('AutoInsert called for table ' . $sTable);
        $db =& DBUtil::getDB();
        if (!array_key_exists('id', $aFieldValues) && ($bNoId === false)) {
            $res = DBUtil::nextId($sTable, null, $db);
            if (PEAR::isError($res)) {
                return $res;
            }
            $aFieldValues['id'] = $res;
        }
        $res = $db->autoExecute($sTable, $aFieldValues);
        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . DBUtil::lastQuery($db));
        }
        if ($res === DB_OK) {
            return $aFieldValues['id'];
        }
        if (PEAR::isError($res)) {
        	DBUtil::logQueryError(DBUtil::lastQuery($db), $res);
            return $res;
        }
        return PEAR::raiseError(_kt('Unknown return value for autoInsert'));
        */
    }

    function &autoUpdate($sTable, $aFieldValues, $iId, $db = null) {
        $conn = DBUtil::getDoctrineConnection($db);
        $oTable = new Doctrine_Table($sTable, $conn);
        $oTable->initIdentifier();
        $aIdentifier = array('id' => $iId);

        $res = $conn->update($oTable, $aFieldValues, $aIdentifier);
        return $res;

        /*
        $res = $db->autoExecute($sTable, $aFieldValues, DB_AUTOQUERY_UPDATE, 'id = ' . $iId);
        $default->queryLog->debug('Query: ' . DBUtil::lastQuery($db));
        if ($res === DB_OK) {
            return $res;
        }
        if (PEAR::isError($res)) {
        	DBUtil::logQueryError(DBUtil::lastQuery($db), $res);
        	return $res;
        }
        return PEAR::raiseError(_kt('Unknown return value for autoUpdate'));

        /*
        global $default;
        // $default->log->debug('AutoUpdate called for table ' . $sTable . ' with id ' . $iId);
        $db =& DBUtil::getDB();
        $res = $db->autoExecute($sTable, $aFieldValues, DB_AUTOQUERY_UPDATE, 'id = ' . $iId);
        $default->queryLog->debug('Query: ' . DBUtil::lastQuery($db));
        if ($res === DB_OK) {
            return $res;
        }
        if (PEAR::isError($res)) {
        	DBUtil::logQueryError(DBUtil::lastQuery($db), $res);
        	return $res;
        }
        return PEAR::raiseError(_kt('Unknown return value for autoUpdate'));
        */
    }

    function &whereUpdate($sTable, $aFieldValues, $aWhereFieldValues, $db = null) {
        if(empty($aFieldValues)){
            return PEAR::raiseError(_kt('No fields are being updated'));
        }

        $conn = DBUtil::getDoctrineConnection($db);

        /* Can't use the table identifier, the identifier columns need to be set somewhere ... ?
        $oTable = new Doctrine_Table($sTable, $conn);
        $oTable->initIdentifier();
        $res = $conn->update($oTable, $aFieldValues, $aWhereFieldValues);
        */

        // Create the sql
        $aWhereFields = array();
        foreach (array_keys($aWhereFieldValues) as $k) {
            $aWhereFields[] = $k . ' = ?';
        }
        $sWhere = join(' AND ', $aWhereFields);

        $aFields = array();
        foreach (array_keys($aFieldValues) as $key){
            $aFields[] = $key . ' = ?';
        }
        $sFields = join(', ', $aFields);

        $aParams = array_merge(array_values($aFieldValues), array_values($aWhereFieldValues));

        $sql = "UPDATE {$sTable} SET {$sFields} WHERE {$sWhere}";

        $res = $conn->exec($sql, $aParams);
        return $res;

        /*
        global $default;
        //$default->log->debug('WhereUpdate called for table ' . $sTable);
        $db =& DBUtil::getDB();
        $aWhereFields = array();
        foreach (array_keys($aWhereFieldValues) as $k) {
            $aWhereFields[] = $k . ' = ?';
        }
        $sWhere = join(' AND ', $aWhereFields);
        $aValues = kt_array_merge(array_values($aFieldValues), array_values($aWhereFieldValues));

        $sth = $db->autoPrepare($sTable, array_keys($aFieldValues), DB_AUTOQUERY_UPDATE, $sWhere);
        $res =& $db->execute($sth, array_values($aValues));
        $db->freePrepared($sth);

        $default->queryLog->debug('Query: ' . DBUtil::lastQuery($db));
        if ($res === DB_OK) {
            return $res;
        }
        if (PEAR::isError($res)) {
            return $res;
        }
        return PEAR::raiseError(_kt('Unknown return value for whereUpdate'));
        */
    }

    static function &lastQuery($db = null) {
        return 'xyz';
        // DBUtil::last_query;
        $conn = DBUtil::getDoctrineConnection($db);
        return $conn->getAttribute(Doctrine::ATTR_LISTENER);

        /*
        $db =& DBUtil::getDB();
        return $db->last_query;
        */
    }

    function autoDelete($sTable, $iId, $db = null) {
        $conn = DBUtil::getDoctrineConnection($db);
        $oTable = new Doctrine_Table($sTable, $conn);
        $oTable->initIdentifier();
        $aIdentifier = array('id' => $iId);

        return $conn->delete($oTable, $aIdentifier);

        /*
        global $default;
        // $default->log->debug('AutoDelete called for table ' . $sTable . ' with id ' . $iId);
        $db =& DBUtil::getDB();
        $sQuery = "DELETE FROM " . $sTable . " WHERE id = ?";
        $aParams = array($iId);
        return DBUtil::runQuery(array($sQuery, $aParams), $db);
        */
    }

    function deReference($sTable, $iId, $db = null) {
        $aFieldValues = array('disabled' => true);
        return DBUtil::autoUpdate($sTable, $aFieldValues, $iId);

        /*
        global $default;
        // $default->log->debug('AutoDelete called for table ' . $sTable . ' with id ' . $iId);
        $db =& DBUtil::getDB();
        $sQuery = "UPDATE " . $sTable . " SET disabled = true WHERE id = ?";
        $aParams = array($iId);
        return DBUtil::runQuery(array($sQuery, $aParams), $db);
        */
    }

    function &whereDelete($sTable, $aWhereFieldValues, $db = null) {
        $conn = DBUtil::getDoctrineConnection($db);

        $aWhereFields = array();
        foreach (array_keys($aWhereFieldValues) as $k) {
            $aWhereFields[] = $k . ' = ?';
        }
        $sWhere = join(' AND ', $aWhereFields);
        $aValues = array_values($aWhereFieldValues);

        $sQuery = "DELETE FROM {$sTable} WHERE {$sWhere}";
        return $conn->exec($sQuery, $aValues);
    }

    function paramArray($aArray) {
        $iNumIds = count($aArray);
        if (empty($iNumIds)) {
            return "";
        }
        return join(",", array_fill(0, $iNumIds, '?'));
    }

    function &escapeSimple($sString, $db = null) {
        // TODO: Check outside quotes ...
        $conn = DBUtil::getDoctrineConnection($db);
        return $conn->quote($sString);
        /*
        $db =& DBUtil::getDB();
        return $db->escapeSimple($sString);
        */
    }

    function compactQuery($sQuery) {
        return str_replace("\n", " ", $sQuery);
    }

    function startTransaction() {
        $conn = DBUtil::getDoctrineConnection();
        $conn->beginTransaction();
        /*
        DBUtil::runQuery("START TRANSACTION");
        $oCache =& KTCache::getSingleton();
        $oCache->startTransaction();
        */
    }
    function rollback() {
        $conn = DBUtil::getDoctrineConnection();
        $conn->rollback();
        /*
        DBUtil::runQuery("ROLLBACK");
        $oCache =& KTCache::getSingleton();
        $oCache->rollback();
        */
    }
    function commit() {
        $conn = DBUtil::getDoctrineConnection();
        $conn->commit();
        /*
        DBUtil::runQuery("COMMIT");
        $oCache =& KTCache::getSingleton();
        $oCache->commit();
        */
    }

    function setupAdminDatabase() {
        global $default;
        $dsn = array(
            'phptype'  => $default->dbType,
            'username' => $default->dbAdminUser,
            'password' => $default->dbAdminPass,
            'hostspec' => $default->dbHost,
            'database' => $default->dbName,
        );

        $options = array(
            'debug'       => 2,
            'portability' => DB_PORTABILITY_ERRORS,
            'seqname_format' => 'zseq_%s',
        );

        $default->_admindb = &DB::connect($dsn, $options);
        if (PEAR::isError($default->_admindb)) {
            die($default->_admindb->toString());
        }
        $default->_admindb->setFetchMode(DB_FETCHMODE_ASSOC);
        return;
    }
}

?>
