<?php
//This script authenticates users into the admin control area (/adm)

define('ADM_HASH','3dad50160e80980262c8b3dd0af7df89'); //MD5 of admin password, currently set to "react_admin"
session_start();

if(!isset($_POST['password']))
{
    header("Location: login.php");
    die();
}
else
{
    $password = md5($_POST['password']);
}
if(ADM_HASH != $password)
{
    header("Location: login.php?r=1");
    die();
}
elseif(ADM_HASH == $password)
{
    $_SESSION['adm_auth'] = TRUE;
    header("Location: index.php");
}
?>
