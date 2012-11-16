<?php
/* This file is included by any page in /adm that needs to retrieve data. It does all the MySQLi retrieval. */

//Check this file isn't being directly run
$included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
if(!$included)
{
    die("This file is for include use only.");
}

//Connect to MySQL
include '../dbconn.php';
$db = connect();

function direct
?>
