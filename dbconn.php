<?php
define("DB_HOST","localhost");
define("DB_USER","root"); //Root is bad, change this sometime
define("DB_PASSWORD","rootMySQL153");
define("DB_NAME","yzReact");

function connect()
{
    $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    return $db;
}
?>
