<?php
session_start();
$session_id = (integer) $_SESSION['session_id'];
$time = (float) $_GET['time'];
$word = $_GET['word'];
$correct = $_GET['was_correct'];
$sem_field_id = $_GET['sem_field_id'];
$sem_field_pair_id = (integer) $_SESSION['sem_field_pair_id'];
$is_orientation_correct = $_GET['is_orientation_correct'];
$result_in_session = $_SESSION['tests_taken'] + 1;

//Increment $tests_taken
$_SESSION['tests_taken']++;

//The JavaScript sends was_correct as "true" or "false", which would both get typecasted to TRUE, so we explicitly convert here
if($correct == "true")
{
    $correct = 1;
}
else
{
    $correct = 0;
}

//$time is a mess - a string-ey float-ey monster
$time = round($time,2);
//The MySQL column is set to DECIMAL(4,2) so we need to check if this is more than 9999.99 and die() if that is the case.
if ($time >9999.99)
{
    die("Variable time was too large - please see staff.");
}


include 'dbconn.php';
$db = connect(); //Connect to MySQL, get a DB handle
$stmt = $db->prepare("INSERT INTO results (sem_field_id,sem_field_pair_id,word,time,correct,session_id,is_orientation_correct,result_in_session) VALUES (?,?,?,?,?,?,?,?)");
$stmt->bind_param("sisdiiii",$sem_field_id,$sem_field_pair_id,$word,$time,$correct,$session_id,$is_orientation_correct,$result_in_session);
if(!$stmt)
{
    die("Error (MySQLi statement build failed)");
}
$stmt->execute();

//If there are more tests to be taken, redirect to them, else redirect to the ending page
if ($_SESSION['tests_taken'] < $_SESSION['tests_desired'])
{
    header("Location: test.php?taken=$_SESSION[tests_taken]&total=$_SESSION[tests_desired]");
}
else
{
    header("Location: session_conclude.php");
}

?>


