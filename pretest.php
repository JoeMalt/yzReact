<?php
session_start();
if(empty($_SESSION))
{
    header("Location: session_initialise.php");
}
$tests_remaining = $_SESSION['tests_desired'] - $_SESSION['tests_taken'];

$message = <<< EOT
Your session ID is {$_SESSION['session_id']}. <br />
You have taken {$_SESSION['tests_taken']} tests so far. <br />
You have $tests_remaining to go. <br />
Please do not hesitate to ask if you have any problems. <br />
When you are ready to take the next test, please <a href='test.php'>click here.</a>
EOT;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>yzReact - Begin test</title></head>
<body>
<?php
echo $message;
?>
</body>
</html>
