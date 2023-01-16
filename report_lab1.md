# Отчет о лабораторной работе №1
### По курсу: Основы программирования
### Работу выполнил студент группы №3131 Гулаков М.А.

## Цель работы: 
Спроектировать и разработать систему авторизации пользователей на протоколе HTTP

## Ход работы
### Пользовательский интерфейс

![reg](https://user-images.githubusercontent.com/122292517/212729634-0aa9deb9-3f4b-4d0f-ac6a-97f04b4dae83.jpg)

![auth](https://user-images.githubusercontent.com/122292517/212729642-abd4c919-47d3-49af-9128-de102bd9cd99.jpg)

![hello](https://user-images.githubusercontent.com/122292517/212729652-73a63bb5-e5d8-4c1f-ba6a-d782562b8c58.jpg)


### Пользовательский сценарий

Пользователь попадает на страницу регистрации, где ему необходимо придумать логин и пароль. Если логин и пароль не пустые поля, длина логина и пароля соответствуют верным значениям, логин не занят, то пользователь успешно зарегистрируется и получит приглашение войти в личный кабинет, в противном случае, ему выведет соответствующее сообщение об ошибке.

После того, как пользователь был перенаправлен на страницу авторизации, ему необходимо ввести логин и пароль. Если они подлинны, то пользователь попадает на страницу приветствия, в противном случае, ему выводит ошибку о том, что неправильно введены логин или пароль.

### API сервера
Сервер использует HTTP GET и SESSION запросы с полями **msg** *(отображение ошибок)*, **username** *(передача логина)* и **password** *(передача пароля)*. Также, сервер использует куки **token** для работы с токеном авторизации.
### Хореография 

Пользователь попадает на страницу **index.php**, на которой проверяется наличие куки с токеном авторизации. Если она есть и она подлинна, то пользователь перенаправляется на **hello.php** вместе с логином и паролем.
Если куки отсутствует, то пользователя направляет на **signup.php**, где ему нужно пройти процесс регистрации. После ввода логина и пароля, пользователь подтвержает введенные данные и перенаправляется в
**signup_index.php**, откуда в случае успешного ввода перенаправляется в **signin.php** или возвращается в **signup.php** с соответствующей ошибкой ввода.

В случае, если пользователь дошел до **signin.php**, то ему необходимо снова ввести свой логин и пароль, после чего он будет перенаправлен на **signin_index.php**, 
откуда, в случае верных введеных данных, будет перенаправлен в **hello.php** с логином и паролем, либо вернется в **signin.php** с сообщением о соответствующей ошибке.

### Структура базы данных
База данных состоит из одной таблицы **lab1**, со стобцами **id** *(ключевой, с автоинкрементом)*, **username** *(хранение логинов)*, **password_hash** *(хранение хешей паролей)* и **auth_token** *(хранение токена авторизации)*

### Алгоритмы

**index.php**

![index](https://user-images.githubusercontent.com/122292517/212733968-c17bb738-8bc0-4832-9655-25b71f9822da.png)

**signup_index.php**

![signup](https://user-images.githubusercontent.com/122292517/212736644-bec78351-544f-456f-b598-43152ee95338.png)

**signin_index.php**

![signin](https://user-images.githubusercontent.com/122292517/212737890-ed282996-7f53-4807-ab20-a4b434e1fed2.png)


## Примеры HTTP запросов/ответов
### Вход

![signin (1)](https://user-images.githubusercontent.com/122292517/212743733-d870c193-a52f-4535-8621-9657eecb8021.png)

## Значимые фрагменты кода
### Ключевая часть signup_index.php
Хеширование пароля, проверка наличие логина в базе данных; если логин не занят, то успешно зарегестрирован

    $password_hash = md5($password);
    $sql = "SELECT *  FROM `lab1` WHERE `username` LIKE '$username';";
    $count=mysqli_query($connection, $sql);
    if (mysqli_num_rows($count) > 0){
        $err='username is already taken!';
        $_SESSION["msg"]=$err;
        mysqli_close($connection);
        header('Location: signup.php', true, 303);
    }

    $sql = "INSERT INTO `lab1` (`id`, `username`, `password_hash`, `auth_token`) VALUES (NULL, '$username', '$password_hash', '');";
    $result = mysqli_query($connection, $sql);
    if ($result){
        $_SESSION["msg"]='You have successfully registered! Now you can sign in.';
        mysqli_close($connection);
        header('Location: signin.php', true, 303);
    }

### Ключевая часть signin_index.php
Проверка подлинности логина и пароля; получение прав доступа и генерация токена в случае успеха

    $password_hash=md5($password);

    $sql = "SELECT *  FROM `lab1` WHERE `username` LIKE '$username' AND `password_hash` LIKE '$password_hash';";
    $count=mysqli_query($connection, $sql);
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
        
### Проверка токена авторизации в index.php

    if (isset($_COOKIE["auth_token"])){
        $auth_token=$_COOKIE["auth_token"];
        $sql = "SELECT *  FROM `lab1` WHERE `auth_token` LIKE '$auth_token';";
        $result=mysqli_query($connection, $sql);
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
