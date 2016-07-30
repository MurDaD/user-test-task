<?php namespace includes;
include 'Settings.php';
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Creates and inserts faked users into DB
 * Using: fzaninotto/faker, mysqli, Prepared statements
 */

final class DB
{
    private static $instance;
    protected $mysqli;

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
        $this->mysqli = new \mysqli(Settings::get('db_host'), Settings::get('db_user'), Settings::get('db_password'), Settings::get('db_database'));
        if ($this->mysqli->connect_errno) {
            echo "Couldn't connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
    }

    /**
     * Returns mysql connection
     * @return mysqli
     */
    public function getConnection() {
        return $this->mysqli;
    }

    private function __clone()
    {
    }

    private function __sleep()
    {
    }

    private function __wakeup()
    {
    }
}