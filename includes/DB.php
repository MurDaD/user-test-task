<?php namespace includes;
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Database class
 */
include 'DBAdapterInterface.php';
include 'Settings.php';

final class DB implements DBAdapterInterface
{
    private static $instance;
    protected $mysqli;
    private $_result;

    /**
     * Returnes class instance
     *
     * @return self
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * DB constructor.
     */
    function __construct()
    {
        $this->connect();
    }

    /**
     * Connection via mysqli
     */
    public function connect()
    {
        if(!$this->mysqli) {
            $this->mysqli = new \mysqli(
                Settings::get('db_host'),
                Settings::get('db_user'),
                Settings::get('db_password'),
                Settings::get('db_database')
            );
            if ($this->mysqli->connect_errno) {
                echo "Couldn't connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
            }
        } else {
            return $this->mysqli;
        }
    }

    /**
     * Query DB
     */
    public function query($query)
    {
        if (!is_string($query) || empty($query)) {
            throw new \Exception('The specified query is not valid.');
        }
        // lazy connect to MySQL
        $this->connect();
        if (!$this->_result = mysqli_query($this->mysqli, $query)) {
            throw new \Exception('Error executing the specified query ' . $query . mysqli_error($this->mysqli));
        }
        return $this->_result;
    }

    /**
     * Select statement (easy)
     */
    public function select($table, $where = '', $fields = '*', $order = '', $limit = null, $offset = null)
    {
        $query = 'SELECT ' . $fields . ' FROM ' . $table
               . (($where) ? ' WHERE ' . $where : '')
               . (($limit) ? ' LIMIT ' . $limit : '')
               . (($offset && $limit) ? ' OFFSET ' . $offset : '')
               . (($order) ? ' ORDER BY ' . $order : '');
        $this->query($query);
        return $this->countRows();
    }

    /**
     * Insert statement
     */
    public function insert($table, array $data)
    {
        $fields = implode(',', array_keys($data));
        $values = implode(',', array_map(array($this, 'quoteValue'), array_values($data)));
        $query = 'INSERT INTO ' . $table . ' (' . $fields . ') ' . ' VALUES (' . $values . ')';
        $this->query($query);
        return $this->getInsertId();
    }

    /**
     * Update statement
     */
    public function update($table, array $data, $where = '')
    {
        $set = array();
        foreach ($data as $field => $value) {
            $set[] = $field . '=' . $this->quoteValue($value);
        }
        $set = implode(',', $set);
        $query = 'UPDATE ' . $table . ' SET ' . $set
                . (($where) ? ' WHERE ' . $where : '');
        $this->query($query);
        return $this->getAffectedRows();
    }

    /**
     * Delete statement
     */
    public function delete($table, $where = '')
    {
        $query = 'DELETE FROM ' . $table
                . (($where) ? ' WHERE ' . $where : '');
        $this->query($query);
        return $this->getAffectedRows();
    }

    /**
     * Escape the specified value
     */
    private function quoteValue($val)
    {
        if ($val === null) {
            $val = 'NULL';
        }
        else if (!is_numeric($val)) {
            $val = "'" . mysqli_real_escape_string($this->mysqli, $val) . "'";
        }
        return $val;
    }

    /**
     * Fetch a single row from the result
     */
    public function fetch()
    {
        if ($this->_result !== null) {
            if (($row = mysqli_fetch_array($this->_result, MYSQLI_ASSOC)) === false) {
                $this->freeResult();
            }
            return $row;
        }
        return false;
    }

    /**
     * Get the number of rows returned
     */
    public function countRows()
    {
        return $this->_result !== null
            ? mysqli_num_rows($this->_result) : 0;
    }

    /**
     * Get the number of affected rows
     */
    public function getAffectedRows()
    {
        return $this->mysqli !== null
            ? mysqli_affected_rows($this->mysqli) : 0;
    }

    /**
     * Returns mysql connection
     * @return mysqli
     */
    public function getConnection() {
        return $this->mysqli;
    }

    /**
     * Close mysqli connection
     */
    public function close() {
        return $this->mysqli->close();
    }

    /**
     * Closing all magic methods
     */
    private function __clone(){}
    private function __sleep(){}
    private function __wakeup(){}
}