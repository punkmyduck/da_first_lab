<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title></title>
    </head>
    <body>
        <h1>Authorization</h1>
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
        <form method="$_GET" action="signin_index.php">
            <table>
                <tr>
                    <td>
                        Enter your username:
                    </td>
                    <td>
                        <input type="text" name="username" placeholder="username"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Enter your password:
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
                        <a href="signup.php">sign up</href>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>