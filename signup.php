<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title></title>
    </head>
    <body>
        <h1>Registration</h1>
        <?php
            ini_set('session.gc_maxlifetime', 60);
            ini_set('session.cookie_lifetime', 60);
            session_start();
            if (isset($_SESSION["msg"]))
                {
                    echo $_SESSION["msg"];
                    session_destroy();
                }
        ?>
        <form method="$_GET" action="signup_index.php">
            <table>
                <tr>
                    <td>
                        Enter username:
                    </td>
                    <td>
                        <input type="text" name="username" placeholder="username"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Enter password:
                    </td>
                    <td>
                        <input type="password" name="password" placeholder="password"/>
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>
                        <input type="submit" value="отправить"/>
                    </td>
                    <td>
                        <a href="signin.php">sign in</href>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>