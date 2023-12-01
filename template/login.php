<?php 
$title = 'Авторизация';
$cssAccess[] = '../css/authentication.css';

$msg = "";

if(isset($_POST['submit'])){
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password = md5($password);

    if(!empty($login) and !empty($password)){
        $query = mysqli_query($db, "SELECT * FROM `users` WHERE `login` = '$login' and `password` = '$password'");
        $result = mysqli_fetch_array($query);

        if(is_array($result) && $result['login'] == $login && $result['password'] == $password){
            setcookie('login', $login);
            setcookie('password', $password);
            header('Location: ../profile');
        }else{
            $msg = "Вы ввели некорректные данные";
        }
    }else{
        $msg = "Вы заполнили не все данные";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php foreach($cssAccess as $css): ?>
        <link rel="stylesheet" href="<?=$css?>">
    <?php endforeach; ?>
    
    <title><?=$title?></title>

</head>
<body>
    <?php echo $msg; ?>
    
    <section class="authentication">
        <div class="container">
            <div class="center">
                <div class="authenticationContent">
                    <div class="authenticationTitle">
                        <div class="authenticationLogo">
                            <!-- <img src="img/elements/logo.svg" alt=""> -->
                        </div>

                        <div class="authenticationText">
                            <h2>Авторизация</h2>
                            <p>CL - Закладки фильмов: ваше личное кинематографическое приключение! </p>
                        </div>
                    </div>
                    <form action="" method="post" class="authenticationForm">
                        <input type="text" name="login" class="input" placeholder="Логин"><br>
                        <input type="password" name="password" class="input" placeholder="Пароль"><br>
                        <input type="submit" name="submit" class="submit" value="Войти">

                        <div class="footerFormBtn">
                            <p>Нет аккаунта? <a href="../register">Регистрация</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



</body>
</html>