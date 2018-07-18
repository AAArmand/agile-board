<?php


namespace database;


class db
{
    static protected $connection = null;

    /**
     * @return bool
     */
    static function init ()
    {
        self::$connection = mysqli_connect('localhost', 'root', '');
        if (self::$connection) {
            return mysqli_select_db(self::$connection,'agile_board');
        }
        return false;
    }

    /**
     * @param $query
     * @return bool|\mysqli_result
     */
    static function query ($query) {
        return mysqli_query(self::$connection, $query);
    }

    /**
     * @param $result \mysqli_result
     * @return array|null
     */
    static function fetch_assoc ($result) {
        return mysqli_fetch_assoc($result);
    }

    /**
     * @param $str string
     * @return string
     */
    static function escape_string ($str) {
        return mysqli_real_escape_string(self::$connection, $str);
    }
}