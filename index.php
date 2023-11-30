
<?php
require_once('require/db.php');

$paramOne = null;
$paramTwo = null;

function dd($param){
    print_r('<pre>');
    var_dump($param);
}

global $staticPages;
$staticPages = [
    '' => [['auth'], 'one_level'],
    'index' => [['auth'], 'one_level'],
    'register' => [['auth'], 'one_level'], 
    'login' => [['auth'], 'one_level'],

    'films' => [['user', 'admin'], 'one_level'],
    'film' => [['user', 'admin'], 'two_level', 'false'],

    'search' => [['user', 'admin'], 'one_level'],
    'notifications' => [['user', 'admin'], 'one_level'],
    'profile' => [['user', 'admin'], 'two_level'],
    'setting' => [['user', 'admin'], 'one_level'],
];

$url = $_SERVER["REQUEST_URI"];
$lineArray = explode("/", $url);

$params = null;


if(!empty($lineArray[1])){
    $paramOne = $lineArray['1'];
}

if(!empty($lineArray['2'])){
    $paramTwo = $lineArray['2'];
}

function cookieCheck() {
    $role = 'all';

    if(!empty($_COOKIE['user']) && !empty($_COOKIE['password'])){
        $role = 'user';
        $role = 'admin';
    }else{
        $role = 'auth';
    }
    $role = 'user';

    return $role;

}

function slug($db, $paramOne = null, $paramTwo = null, $paramThree = null){
    global $staticPages;

    if(!empty($paramOne)){
        if(array_key_exists($paramOne, $staticPages)){
            if(isset($staticPages[$paramOne]) && in_array(cookieCheck(), $staticPages[$paramOne][0])) {
                if(!empty($paramTwo)){
                    require('template/'.$paramOne.".php");
                }else{
                    if(!empty($staticPages[$paramOne][2]) == 'false'){
                        die('404');
                    }

                    require('template/'.$paramOne.".php");
                }
                
            } else {
                switch (cookieCheck()) {
                    case 'auth':
                        header('Location: ../login');
                        break;
                    
                    case 'user':
                        header('Location: ../profile');
                        break;
                    
                    default:
                        header('Location: ../index');
                        break;
                }
            }
        }else{
            exit('404');
        }
    }else{ 
        require_once('template/index.php');
    }
}


if(array_key_exists($paramOne, $staticPages)){
    echo $paramOne;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    
    <?php if(file_exists('css/'.$paramOne.".css")): ?>
        <link rel="stylesheet" href="../css/<?=$paramOne?>.css">
    <? endif; ?>
    
    <link rel="stylesheet" href="../css/page.css">
    <title>Document</title>
</head>
<body>
    <?=slug($db, $paramOne, $paramTwo);?>
</body>
</html>