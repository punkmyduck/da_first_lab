<?php
ini_set('session.gc_maxlifetime', 60);
ini_set('session.cookie_lifetime', 60);
session_start();
if (isset($_COOKIE["auth_token"])){
    $connection=mysqli_connect('localhost', 'root', '', 'lab1_db');
    if ($connection==false){
        mysqli_connect_error();
    }
    $auth_token=$_COOKIE["auth_token"];
    $sql = "SELECT *  FROM `lab1` WHERE `auth_token` LIKE '$auth_token';";
    $result=mysqli_query($connection, $sql);
    if ($result==false){
        mysqli_error($connection);
    }
    if (mysqli_num_rows($result)!=0){
        if ($row=mysqli_fetch_assoc($result)){
            $_SESSION["username"]=$row["username"];
            $_SESSION["password_hash"]=$row["password_hash"];
            header('Location: hello.php', true, 303);
        }
    }
    else header('Location: signup.php', true, 303);
}
else header('Location: signup.php', true, 303);
?>