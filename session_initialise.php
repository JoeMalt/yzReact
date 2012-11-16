<?php
include 'dbconn.php';
$db = connect(); //Connect to MySQL
if(isset($_GET['session_id'])) //If the user hasn't inputted a session_id, send them to a form to do just that.
{
    $session_id = $_GET['session_id'];
}
else
{
    header("Location: index.php");
}

//Get the necessary stuff from MySQL
$stmt = $db->prepare("SELECT * FROM sessions WHERE session_id = ?");
$stmt->bind_param("i",$session_id);
$stmt->execute();
$stmt->store_result(); //This makes num_rows work
$stmt->bind_result($session_id,$tests_desired,$sem_field_pair_id,$status);
$stmt->fetch();
$num_rows = $stmt->num_rows;


//Set the session status to "Active"
$db->query("UPDATE sessions SET status = \"C\" WHERE session_id = $session_id");

//Load all the session data
session_start();
$_SESSION['session_id'] = $session_id;
$_SESSION['tests_desired'] = $tests_desired;
$_SESSION['sem_field_pair_id'] = $sem_field_pair_id;
$_SESSION['status'] = $status;
$_SESSION['tests_taken'] = 0;


if ($status != "A" && $num_rows == 1) //If this is the case, the session must already be active or dead
{
    echo "This session has already been started. Please request a new session ID.";
    die();
}

if($num_rows == 0) //If this is true, the session doesn't exist.
{
    echo "The session code you have entered could not be found in the database. Please try re-entering it.";
    die();
}
else
{
    $result = $db->query("UPDATE sessions SET status = \"B\" WHERE session_id = $session_id");
    if (!$result)
    {
        echo "Database error (UPDATE query returned false)";
    }
}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>yzReact - Session initialised</title><link rel="stylesheet" type="text/css" href="general.css" /></head>
<body>
<div id="main">
Session started. You will take <?php echo $tests_desired; ?> tests. <strong>During the test, please do not use your mouse</strong>. Place your ring, middle and index fingers on the keys A, S and D - you will be pressing these keys only. When you are ready, please <a href='test.php'>click here to continue</a></div>
</body>
</html>
