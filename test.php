<?php
/* This file provides the UI in which the test is actually taken. It works as follows:
1. Load session variables and generate random data as necessary
2. Connect to MySQL to get the necessary data (including word list locations)
3. Read the word lists and select the word
4. Load in test_static.htm and str_replace() in the appropriate variables
5. Echo the whole thing to the user.
*/
session_start();

include 'dbconn.php';
$db = connect(); //Connect to MySQL, $db is a MySQLi database object

//We need this for the SQL queries
$sem_field_pair_id = $_SESSION['sem_field_pair_id'];

//Decide whether to use text A or B from the pair (1 = use A, 2 = use B)
$a_or_b = mt_rand(1,2);

$will_be_correct = mt_rand(1,2); //1 is true, 2 is false


//Initialise the SQL to get the word list location
$result = $db->query("SELECT * FROM sem_field_pairs WHERE sem_field_pair_id = $sem_field_pair_id");
$result_array = $result->fetch_assoc();

//Depending on whether we're using set A or B, load the appropriate one:
if ($a_or_b == 1)
{
    $file = $result_array['sem_field_a_file'];
    $correct_orientation = $result_array['sem_field_a_orientation'];
}
elseif ($a_or_b == 2)
{
    $file = $result_array['sem_field_b_file'];
    $correct_orientation = $result_array['sem_field_b_orientation'];
}

//If $will_be_correct is 1, we tell the JS to orient the word as $correct_orientation from the DB, otherwise we invert it
if($correct_orientation == "U" && $will_be_correct == 1)
{
    $forjs_orientation = "U";
}
if($correct_orientation == "U" && $will_be_correct == 2)
{
    $forjs_orientation = "D";
}
if($correct_orientation == "D" && $will_be_correct == 1)
{
    $forjs_orientation = "D";
}
if($correct_orientation == "D" && $will_be_correct == 2)
{
    $forjs_orientation = "U";
}
$wordlist = file_get_contents($file); //Open the word list file and convert it to an array
$wordlist = explode("\n",$wordlist);
array_pop($wordlist); //The last element appears to be a blank string, so we strip it off here.
$word = $wordlist[array_rand($wordlist)]; //Pick a random word.


//Now for the nasty bit. Load the JS file and regex in the variables. Inefficient, but I've already written all the JS.
$page = file_get_contents("test_static.htm");
$page = str_replace("PHP_WORD",$word,$page);
$page = str_replace("PHP_SEM_FIELD_ID",($a_or_b = 1 ? "A" : "B"),$page);
$page = str_replace("PHP_ORIENTATION",$forjs_orientation,$page);
$page = str_replace("PHP_CORRECT_ORIENTATION",$correct_orientation,$page);
echo $page; //Step seven - the entire page is in this string.
?>

