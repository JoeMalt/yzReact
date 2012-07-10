<?php
//This script authenticates users into the admin control area (/adm)

define('ADM_HASH','3dad50160e80980262c8b3dd0af7df89'); //MD5 of admin password, currently set to "react_admin"
session_start();
if (!isset($_POST['password']))
{
    $output = <<< EOT
<form method='post' action='auth.php'>
Please enter the password to access the admin control panel: <input type='text' name='password' /><br />
</form>
EOT;
}
else
{
    $output = "Successfully authenticated.";
    $_SESSION['adm'] = TRUE;
}
