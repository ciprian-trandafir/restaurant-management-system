<?php

foreach(glob('classes/' . "*.php") as $file)
{
    include_once $file;
}

session_start();

if (isset($_SESSION['id_user'])) {
    Link::redirect('index');
}

$errors = [];
$login_state = 0;

if (isset($_POST['submit'])) {
    $password = trim(htmlspecialchars($_POST['password']));
    $email = trim(htmlspecialchars($_POST['email']));
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        $errors['email'] = 'Invalid Email Address';
    }

    if ($email !== false) {
        $login_state = User::login($email, $password);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <?php include './head.php'; ?>
</head>
<body>
    <div class="page-login">
        <div class="sideScreen">
            <div class="sideContent">
                <h1 class="sideTitle">
                    Bun venit!
                </h1>
                <p class="sideText">
                    Introdu datele tale personale pentru a te autentifica
                </p>
                <a class="sideButton" href="<?php echo Link::getLink('register') ?>">
                    Inregistrare
                </a>
            </div>
        </div>
        <div class="mainScreen">
            <div class="mainContent">
                <form method="post" id="login_form">
                    <h1 class="mainTitle">
                        Autentificare
                    </h1>
                    <div class="mainSocials">

                    </div>
                    <div class="inputContainer">
                        <input type="email" name="email" placeholder="E-mail" <?php if (isset($_POST['email'])) echo 'value="'.$_POST['email'].'"';?> required>
                    </div>
                    <div class="inputContainer">
                        <input type="password" name="password" placeholder="Parola" <?php  if (isset($_POST['password'])) echo 'value="'.$_POST['password'].'"';?> required>
                    </div>
                    <p class="forgotPassword">
                        Ti-ai uitat parola?
                    </p>
                    <input type="submit" name="submit" class="mainButton" value="Autentificare">
                </form>
                <?php
                    if ($login_state == 1) {
                        echo '<div class="confirmation_message confirmation_error">
                                <span>Wrong Email or Password</span>
                            </div>';
                    } elseif ($login_state == 2) {
                        echo '<div class="confirmation_message confirmation_success">
                                <span>This account is not yet validated!</span>
                            </div>';
                    } elseif ($login_state == 3) {
                        echo '<div class="confirmation_message confirmation_success">
                            <span>Successfully login. You will be redirected in 3 seconds ..</span>
                        </div>'.'<script type="text/javascript">
                        $("#login_form").css("pointer-events", "none");
                        setTimeout(function () {
                        location.replace(BASE_URL + "index.php");
                        }, 3000);
                        </script>';
                    }
                ?>
            </div>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
</html>
