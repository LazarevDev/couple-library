<?php 
session_start();

$title = 'Авторизация';
$cssAccess[] = '../css/authentication.css';

$msg = "";

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $lastName = $_POST['lastname'];
    $gender = $_POST['gender'];
    $login = $_POST['login'];
    $passwordNoMD5 = $_POST['password'];

    $_SESSION['name'] = $name;
    $_SESSION['lastName'] = $lastName;
    $_SESSION['gender'] = $gender;
    $_SESSION['login'] = $login;

    if(!empty($name) AND !empty($lastName) AND !empty($login) AND !empty($passwordNoMD5) AND !empty($gender)){
        
        if(strlen($passwordNoMD5) < 5) {
            $msg = "Пароль слишком короткий. Пароль должен быть не менее 5 символов";
        }elseif(!preg_match("#[a-zA-Z]+#", $passwordNoMD5)) {
            $msg = "Пароль должен быть на английском языке";
        }else{
            $password = md5($passwordNoMD5);

            $userQuery = mysqli_query($db, "SELECT * FROM `users` WHERE `login` = '$login'"); 
            $resultUserQuery = mysqli_fetch_array($userQuery);
    
            if(!$resultUserQuery){
                $query = "INSERT INTO `users` (login, name, lastname, gender, password) VALUES ('$login', '$name', '$lastName', '$gender','$password')";
                $result = mysqli_query($db, $query) or die(mysqli_error($db));
    
                // Желаемая структура папок
                $structure = 'img/ava-user/'.$login;
    
                if (!mkdir($structure, 0777, true)) {
                    die('Не удалось создать директории...');
                }
    
                setcookie('login', $login);
                setcookie('password', $password);
                
                // удаляем сессию, чтобы в последующем не было ошибок при регистрации нового пользователя
                session_destroy();

                header('Location: ../profile');    
            }else{
                $msg = "Пользователь с таким логином уже существует";
            }
        }
    }else{
        $msg = "Вы не ввели данные";
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

    <?php if(!empty($msg)){ ?>
        <div class="msgContent">
            <div class="msgBg"></div>
            <div class="msgText"><p><?php echo $msg; ?></p></div>
        </div>
    <?php } ?>

    <section class="authentication">
        <div class="container">
            <div class="center">
                <div class="authenticationContent">
                    <div class="authenticationTitle">
                        <div class="authenticationLogo">
                            <img src="img/elements/logo.svg" alt="">
                        </div>

                        <div class="authenticationText">
                            <h2>Регистрация</h2>
                            <p>CL - Закладки фильмов: ваше личное кинематографическое приключение! </p>
                        </div>
                    </div>
                    <form action="" method="post" class="authenticationForm">
                        <input type="text" name="name" class="input" value="<?php if(!empty($_SESSION['name'])){ echo $_SESSION['name']; } ?>" placeholder="Имя" required>
                        <input type="text" name="lastname" class="input" placeholder="Фамилия" value="<?php if(!empty($_SESSION['lastName'])){ echo $_SESSION['lastName']; } ?>" required>

                        <select name="gender" class="select input" required>
                            <option selected disabled value="s1">Выберите пол</option>
                            <option value="male" <?php if(!empty($_SESSION['gender'])){if($_SESSION['gender'] == 'male'){ echo "selected";}} ?>>Мужской</option>
                            <option value="female" <?php if(!empty($_SESSION['gender'])){if($_SESSION['gender'] == 'female'){ echo "selected";}}?>>Женский</option>
                        </select>
                        
                        <input type="text" name="login" class="input" placeholder="Логин" value="<?php if(!empty($_SESSION['login'])){ echo $_SESSION['login']; } ?>" required>
                        <input type="password" name="password" class="input" placeholder="Пароль" required>
                        <input type="submit" name="submit" class="submit" value="Регистрация">

                        <div class="footerFormBtn">
                            <p>Есть аккаунт? <a href="../login">Авторизация</a></p>
                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>