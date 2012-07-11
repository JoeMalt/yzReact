<?php
session_start();
if(!isset($_SESSION['session_id']))
{
    header("Location: index.php");
}
$session_id = $_SESSION['session_id']; //This is stored only in $_SESSION and verifired against the DB on session_start, so no need to escape.
include 'dbconn.php';
$db = connect();
$db->query("UPDATE sessions SET status = \"C\" WHERE session_id = $session_id");

session_destroy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>yzReact - Survey complete</title></head>
<body>
Thank you for taking part in this survey
</body>
</html>
