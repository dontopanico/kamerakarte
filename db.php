<?php
if(!defined('DB')) {
    define('DB', 1);
    include('settings.php');

    function connect_db() {
	global $server, $user, $pass, $db;

        $link = pg_connect("host=$server user=$user password=$pass dbname=$db");
        //$link = mysql_connect($server, $user, $pass) or die(mysql_error());
        //mysql_select_db($db) or die(mysql_error());
        return $link;
    }

    function close_db($link) {
        //mysql_close($link) or die(mysql_error());
        pg_close($link) or die(pg_last_error());
	return true;
    }

    function db_escape_string($data) {
        return pg_escape_string($data);
    }

    function walk_db_escape_string($item, $key) {
        return db_escape_string($item);
    }

    /*
    function my_mysql_escape_string($item, $key) {
        return mysql_escape_string($item);
    }
     */

    function db_query($query) {
        $res = pg_query($query);
        if($res == false)
            die(pg_last_error());
        return $res;
    }

    function db_num_rows($result) {
        return pg_num_rows($result);
    }

    function db_fetch_assoc($result) {
        return pg_fetch_assoc($result);
    }

    function db_fetch_row($result) {
        return pg_fetch_row($result);
    }

    function db_fetch_array($result) {
        $array = pg_fetch_array($result);
        if($array == false) {
            echo pg_last_error();
        }
        return $array;
    }

    function db_free_result($result) {
        return pg_free_result($result);
    }

    function db_error() {
	die(pg_last_error());
    }
}
?>
