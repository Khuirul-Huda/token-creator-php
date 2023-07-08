<?php 
include('./config.php');
session_start();
$config = new Config();


$adminPassword = $config->adminPassword;
$loginFail = false;
$sessionCode = $config->sessionAuthValue;

if(array_key_exists('adminauth', $_SESSION)) {
    if ($_SESSION['adminauth'] == $config->sessionAuthValue) {
        header('Location: index.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['password'] == $adminPassword) {
        $_SESSION['adminauth'] = $sessionCode;
        header('Location: index.php');
    } else {
        $loginFail = true; 
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css"
        integrity="sha512-HqxHUkJM0SYcbvxUw5P60SzdOTy/QVwA1JJrvaXJv4q7lmbDZCmZaqz01UPOaQveoxfYRv1tHozWGPMcuTBuvQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .gap {
                margin: 20px;
            }
            .mt {
                margin-top: 5px;

            }
        </style>
    <title>Admin Login</title>
</head>
<body>
    <div class="container"> 
        <div class="box gap">
            <?php 
            if ($loginFail) {
                echo("
                
                <div class=\"notification is-danger is-light\">
                Wrong Password!
            </div>
                
                ");
            }
            ?>
            <h2 class="subtitle">Admin Login</h2>
            <form method="post">
                <input type="password" name="password" id="password" class="input is-primary">
                <input type="submit" value="Login" class="button is-primary mt">
            </form>
        </div>
    </div>
</body>
</html>