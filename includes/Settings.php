<?php namespace includes;
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Settings. Registry template
 */

class Settings
{
    /**
     * Default settings balues
     * @var mixed[]
     */
    protected static $data = [
        'db_host' => 'localhost',
        'db_user' => 'users-test',
        'db_password' => 'qwert123',
        'db_database' => 'users-test'
    ];


    /**
     * Add to settings
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        self::$data[$key] = $value;
    }

    /**
     * Get settings value
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        return isset(self::$data[$key]) ? self::$data[$key] : null;
    }

    /**
     * Remove settings value
     *
     * @param string $key
     * @return void
     */
    final public static function removeProduct($key)
    {
        if (array_key_exists($key, self::$data)) {
            unset(self::$data[$key]);
        }
    }
}