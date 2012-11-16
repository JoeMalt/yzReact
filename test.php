<?php

session_start();

include 'dbconn.php';
$db = connect(); //Connect to MySQL, $db is a MySQLi database object

//We need this for the SQL queries
$sem_field_pair_id = $_SESSION['sem_field_pair_id'];

//Decide whether to use wordset A or B, for some god-unknown reason stored as a number (what was I thinking?)
//If we're out of words, we try the other word set. If we're still out of words, we give up and end the test.
//THe old system of $_SESSION['tests_desired'] can be thrown out of the window
$a_or_b = mt_rand(1,2);

function getRemainingWords($a_or_b)
{
/*
    This function returns:
        * An array of remaining words
*/
    global $db;
    global $sem_field_pair_id;
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

    //We now have the location of the word lists, let's get the words
    $wordlist = file_get_contents($file);
    $words = explode("\n",$wordlist);
    
    //We create the array words_remaining by comparing $words against $_SESSION['had_words']
    $words_remaining = array();
    foreach($words as $word)
    {
        if(!in_array($word,$_SESSION['had_words']))
        {
            $words_remaining[] = $word;
        }
    }
    //Get rid of the last blank line in the word list
    array_pop($words_remaining);
    return $words_remaining;
    //Get rid of the last blank line in the word list

}

function getWord($a_or_b)
{
    /*
    This function does not return a string, rather:
    * an array, containing the word, what set it is *actually* in, see above and any other data
    * FALSE if we're out of words
    */
    $words_remaining = getRemainingWords($a_or_b);

    //Get rid of the last blank line in the word list
    array_pop($words_remaining);
    //If we haven't got any remaining words, we try the other set
    if(empty($words_remaining))
    {
        $a_or_b = ($a_or_b == 1) ? 2 : 1; //Switch 1 for 2 to search the other word list
        $words_remaining = getRemainingWords($a_or_b); //The ternary here just swaps 1 and 2
        //If we still haven't got any words, the survey is over
        if(empty($words_remaining))
        {
            header("Location: session_conclude.php");
            die("Thank you for taking this test");
        }
    }
    //Now we have a non-empty $words_remaining, we select a word
    $word = $words_remaining[array_rand($words_remaining)];

    //The whole point of this code is to stop the word coming up again, so...
    $_SESSION['had_words'][] = $word;

    $a_or_b_char = ($a_or_b == 1) ? "A" : "B";

    /*START DEBUG ECHO-ING*/
    echo $word . "<br /><br />";
    var_dump($words_remaining);
    echo "<br /><br />";
    var_dump($_SESSION);
    echo "<br /><br />Leaving function<br /><br />";
    /*END DEBUG ECHO-ING*/

    /*Now we need to return the data, which we do as a two-element array:
        * The word, as a string
        * Whether it came from set A or B, as a single char
    */
    return array($word,$a_or_b_char);
}
echo "vardumping getWord(): <br />";
var_dump(getWord(mt_rand(1,2)));
echo "<br /><br />End vardumping getWord() <br />";
?>

