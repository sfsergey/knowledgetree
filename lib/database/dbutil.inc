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
            $dsn = "{$default->dbType}://{$default->dbUser}:{$default->dbPass}@{$default->dbHost}/{$default->dbName}";
            $conn = DBUtil::connect($dsn);
            $default->_conn = $conn;
        }else{
            $conn = $default->_conn;
        }
        return $conn;
    }

    static function &getDB($db = null) {
        global $default;
        if (is_null($db)) {
            $db = $default->_db;
        }
        if(is_null($db)){
            $db = DBUtil::getDoctrineConnection();
            $default->_db = $db;
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
            DBUtil::logQueryError($sQuery, $e);  // DBUtil::lastQuery($conn)
            $res = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . $sQuery, $aParams);  // DBUtil::lastQuery($conn)
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
            DBUtil::logQueryError($sQuery, $e); // DBUtil::lastQuery($conn)
            $aRow = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . $sQuery, $aParams);  // DBUtil::lastQuery($conn)
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
            DBUtil::logQueryError($sQuery, $e); // DBUtil::lastQuery($conn)
            $aRow = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . $sQuery, $aParams); // DBUtil::lastQuery($conn)
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
        try {
            $conn = DBUtil::getDoctrineConnection();

            if (is_null($aOptions)) {
                $aOptions = array();
            }

            $bNoId = KTUtil::arrayGet($aOptions, 'noid', false);

            if (!array_key_exists('id', $aFieldValues) && ($bNoId === false)) {
                $res = DBUtil::nextId($sTable, null, $conn);
                if (PEAR::isError($res)) {
                    return $res;
                }
                $aFieldValues['id'] = $res;
            }

            $oTable = new Doctrine_Table($sTable, $conn);

            $result = $conn->insert($oTable, $aFieldValues);
            $result = $aFieldValues['id'];
        } catch (Exception $e) {
            DBUtil::logQueryError('Insert '.$sTable, $e); // DBUtil::lastQuery($conn)
            $result = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . DBUtil::lastQuery($conn));
        }

        return $result;
    }

    function &autoUpdate($sTable, $aFieldValues, $iId, $db = null) {
        try {
            $conn = DBUtil::getDoctrineConnection($db);
            $oTable = new Doctrine_Table($sTable, $conn);
            $oTable->initIdentifier();
            $aIdentifier = array('id' => $iId);

            $res = $conn->update($oTable, $aFieldValues, $aIdentifier);
        } catch (Exception $e) {
            DBUtil::logQueryError('Update '.$sTable.' '.$iId, $e); // DBUtil::lastQuery($conn)
            $res = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . DBUtil::lastQuery($conn));
        }

        return $res;
    }

    function &whereUpdate($sTable, $aFieldValues, $aWhereFieldValues, $db = null) {
        if(empty($aFieldValues)){
            return PEAR::raiseError(_kt('No fields are being updated'));
        }

        try {
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
        } catch (Exception $e) {
            DBUtil::logQueryError($sql, $e); // DBUtil::lastQuery($conn)
            $res = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . DBUtil::lastQuery($conn));
        }

        return $res;
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
        try {
            $conn = DBUtil::getDoctrineConnection($db);
            $oTable = new Doctrine_Table($sTable, $conn);
            $oTable->initIdentifier();
            $aIdentifier = array('id' => $iId);
        } catch (Exception $e) {
            DBUtil::logQueryError('Delete '.$sTable.' '.$iId, '', $e); // DBUtil::lastQuery($conn)
            $res = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . DBUtil::lastQuery($conn));
        }

        return $conn->delete($oTable, $aIdentifier);
    }

    function deReference($sTable, $iId, $db = null) {
        $aFieldValues = array('disabled' => true);
        $res = DBUtil::autoUpdate($sTable, $aFieldValues, $iId);
        return $res;
    }

    function &whereDelete($sTable, $aWhereFieldValues, $db = null) {
        try {
            $conn = DBUtil::getDoctrineConnection($db);

            $aWhereFields = array();
            foreach (array_keys($aWhereFieldValues) as $k) {
                $aWhereFields[] = $k . ' = ?';
            }
            $sWhere = join(' AND ', $aWhereFields);
            $aValues = array_values($aWhereFieldValues);

            $sQuery = "DELETE FROM {$sTable} WHERE {$sWhere}";
            $res = $conn->exec($sQuery, $aValues);
        }catch (Exception $e) {
            DBUtil::logQueryError($sQuery, $e); // DBUtil::lastQuery($conn)
            $res = PEAR::raiseError($e->getMessage());
        }

        if ($default->queryLog) {
            $default->queryLog->debug('Query: ' . DBUtil::lastQuery($conn));
        }

        return $res;
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
        return addslashes($sString);
    }

    function compactQuery($sQuery) {
        return str_replace("\n", " ", $sQuery);
    }

    function startTransaction() {
        $conn = DBUtil::getDoctrineConnection();
        $conn->beginTransaction();
    }
    function rollback() {
        $conn = DBUtil::getDoctrineConnection();
        $conn->rollback();
    }
    function commit() {
        $conn = DBUtil::getDoctrineConnection();
        $conn->commit();
    }

    function setupAdminDatabase() {
        global $default;

        // Create connection dsn
        $dsn = "{$default->dbType}://{$default->dbAdminUser}:{$default->dbAdminPass}@{$default->dbHost}/{$default->dbName}";

        $conn = DBUtil::connect($dsn);
        $default->_admindb = $conn;
        return $conn;
    }
}

?>
