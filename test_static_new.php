<!DOCTYPE html>
<html lang="en">
<head>
    <script type='text/javascript'>
    //Because of the way test.php works we have to inline the variable definition :/

    var word = "PHP_WORD";
    var sem_field_id = "PHP_SEM_FIELD_ID"; //Either A or B, set by PHP
    var orientation = "PHP_ORIENTATION"; //"U" for up, "D" for down (case-sensitive)
    var correct_orientation = "PHP_CORRECT_ORIENTATION";
    var help_message = "PHP_HELP_MESSAGE";

    </script>

    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="general_new.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src='yzreactjs.js'></script>
    <title>Test in progress</title>
</head>
<body>
<div id='main-container'>

    <div class='yzreact-row' id='yzreact-row-top'>
    <div class='yzreact-row-text' id='yzreact-row-text-top'></div>
    </div>

    <div class='yzreact-row' id='yzreact-row-middle'>
    <div class='yzreact-row-text' id='yzreact-row-text-middle'></div>
    </div>

    <div class='yzreact-row' id='yzreact-row-bottom'>
    <div class='yzreact-row-text' id='yzreact-row-text-bottom'></div>
    </div>

</div><!-- </div id='main_container'> -->

