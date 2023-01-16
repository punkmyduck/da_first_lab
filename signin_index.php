<?php
ini_set('session.gc_maxlifetime', 60);
ini_set('session.cookie_lifetime', 60);
session_start();
$username=$_GET['username'];
$password=$_GET['password'];
$password_hash=md5($password);

$connection=mysqli_connect('localhost', 'root', '', 'lab1_db');
if ($connection==false){
    echo 'something went wrong!';
    mysqli_connect_error();
}
mysqli_set_charset($connection, "utf8");

$sql = "SELECT *  FROM `lab1` WHERE `username` LIKE '$username' AND `password_hash` LIKE '$password_hash';";
$count=mysqli_query($connection, $sql);
if ($count==false){
    echo 'something went wrong!';
    echo mysqli_error($connection);
} else
if (mysqli_num_rows($count)>0){
    $_SESSION["username"]=$username;
    $_SESSION["password_hash"]=$password_hash;

    $auth_token=rand();
    $auth_token=md5($auth_token);
    setcookie("auth_token", $auth_token);
    $sql = "UPDATE `lab1` SET `auth_token` = '$auth_token' WHERE `lab1`.`username` = '$username';";
    mysqli_query($connection, $sql);

    header('Location: hello.php', true, 303);
} else
{
    $err='The username or password you entered is incorrect.';
    $_SESSION["msg"]=$err;
    header('Location: signin.php', true, 303);
}

?>