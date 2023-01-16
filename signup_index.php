<?php
ini_set('session.gc_maxlifetime', 60);
ini_set('session.cookie_lifetime', 60);
session_start();
$username=$_GET['username'];
$password=$_GET['password'];
$password_hash = md5($password);

if ($username===''){
    $err='Enter username!';
    $_SESSION["msg"]=$err;
    header('Location: signup.php', true, 303);
}
else {
    if (strlen($username)<4){
        $err='Too short username! The name must be at least 4 characters long.';
        $_SESSION["msg"]=$err;
        header('Location: signup.php', true, 303);
    }
    if (strlen($username)>25){
        $err='Too long username! The name must not be longer than 25 characters.';
        $_SESSION["msg"]=$err;
        header('Location: signup.php', true, 303);
    }
}
if ($password===''){
    $err='Enter password!';
    $_SESSION["msg"]=$err;
    header('Location: signup.php', true, 303);
}
else {
    if (strlen($password)<7){
        $err='The password is too short! The password must be at least 7 characters long.';
        $_SESSION["msg"]=$err;
        header('Location: signup.php', true, 303);
    }
    if (strlen($password)>30){
        $err='Too long password! The password length must not exceed 30 characters.';
        $_SESSION["msg"]=$err;
        header('Location: signup.php', true, 303);
    }
}

$connection=mysqli_connect('localhost', 'root', '', 'lab1_db');
if ($connection==false){
    echo 'something went wrong';
    mysqli_connect_error();
}
mysqli_set_charset($connection, "utf8");

$sql = "SELECT *  FROM `lab1` WHERE `username` LIKE '$username';";
$count=mysqli_query($connection, $sql);
if ($count==false){
    echo 'something went wrong!<br>';
    echo mysqli_error($connection);
} else
if (mysqli_num_rows($count) > 0){
    $err='username is already taken!';
    $_SESSION["msg"]=$err;
    mysqli_close($connection);
    header('Location: signup.php', true, 303);
}

$sql = "INSERT INTO `lab1` (`id`, `username`, `password_hash`, `auth_token`) VALUES (NULL, '$username', '$password_hash', '');";
$result = mysqli_query($connection, $sql);

if ($result==false){
    echo 'something went wrong!<br>';
    echo mysqli_error($connection);
    mysqli_close($connection);
}
else {
    $_SESSION["msg"]='You have successfully registered! Now you can sign in.';
    mysqli_close($connection);
    header('Location: signin.php', true, 303);
}

?>