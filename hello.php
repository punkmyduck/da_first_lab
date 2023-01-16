<?php
ini_set('session.gc_maxlifetime', 60);
ini_set('session.cookie_lifetime', 60);
session_start();
if (!isset($_SESSION["username"]) or !isset($_SESSION["password_hash"])){
    $err='You do not have permission to visit this page.';
    $_SESSION["msg"]=$err;
    header('Location: signin.php', true, 303);
}

$maxlifetime = ini_get("session.gc_maxlifetime");
$cookielifetime = ini_get("session.cookie_lifetime");

echo 'maxlifetime: ', $maxlifetime;
echo '<br>cookielifetime: ', $cookielifetime;

?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title></title>
    </head>
    <body>
        <h1>Personal area</h1>
        Hello, <?php echo $_SESSION["username"]; ?>
    </body>
</html>