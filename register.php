<?php

foreach (glob('classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

session_start();

if (isset($_SESSION['id_user'])) {
    Link::redirect('index');
}

$errors = [];
$successfully_registered = false;

if (isset($_POST['submit'])) {
    $firstname = trim(htmlspecialchars($_POST['first-name']));
    $lastname = trim(htmlspecialchars($_POST['last-name']));
    $password = trim(htmlspecialchars($_POST['password']));

    $email = trim(htmlspecialchars($_POST['email']));
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        $errors['email'] = 'Invalid Email Address';
    }

    if ($email !== false) {
        if (User::checkEmail($email)) {
            $errors['email'] = 'This email address already exists. Login instead!';
        } else {
           if (User::register($firstname, $lastname, $email, $password)) {
               $_POST = [];
               $successfully_registered = true;
           }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register • Restaurant</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <?php include './head.php'; ?>
</head>
<body>
    <div class="page-register">
        <div class="mainScreen">
            <div class="mainContent">
                <form method="post" id="register_form">
                    <h1 class="mainTitle">
                        Register
                    </h1>
                    <div class="mainSocials">

                    </div>
                    <div class="inputContainer">
                        <input type="text" name="first-name" <?php if (isset($errors['first-name'])) echo 'class="input-error"'; ?> placeholder="First Name" value="<?php if (isset($_POST['first-name'])) echo $_POST['first-name'];?>" required>
                        <?php
                        if (isset($errors['first-name'])) {
                            echo '<span class="display-error">'.$errors['first-name'].'</span>';
                        }
                        ?>
                    </div>
                    <div class="inputContainer">
                        <input type="text" name="last-name" <?php if (isset($errors['last-name'])) echo 'class="input-error"'; ?> placeholder="Last Name" value="<?php if (isset($_POST['last-name'])) echo $_POST['last-name'];?>" required>
                        <?php
                        if (isset($errors['last-name'])) {
                            echo '<span class="display-error">'.$errors['last-name'].'</span>';
                        }
                        ?>
                    </div>
                    <div class="inputContainer">
                        <input type="email" name="email" <?php if (isset($errors['email'])) echo 'class="input-error"'; ?> placeholder="E-mail" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>" required>
                        <?php
                        if (isset($errors['email'])) {
                            echo '<span class="display-error">'.$errors['email'].'</span>';
                        }
                        ?>
                    </div>
                    <div class="inputContainer">
                        <input type="password" name="password" <?php if (isset($errors['password'])) echo 'class="input-error"'; ?> placeholder="Password" value="<?php if (isset($_POST['password'])) echo $_POST['password'];?>" required>
                        <?php
                        if (isset($errors['password'])) {
                            echo '<span class="display-error">'.$errors['password'].'</span>';
                        }
                        ?>
                    </div>
                    <input type="submit" name="submit" class="mainButton" value="Register">
                </form>
                <?php
                    if ($successfully_registered) {
                        echo '<div class="confirmation_message confirmation_success">
                            <span>Successfully registered. You will be redirected in 3 seconds ..</span>
                        </div>'.'<script type="text/javascript">
                        $("#register_form").css("pointer-events", "none");
                        setTimeout(function () {
                        location.replace(BASE_URL + "login.php");
                        }, 3000);
                        </script>';
                    }
                ?>
            </div>
        </div>
        <div class="sideScreen">
            <div class="sideContent">
                <h1 class="sideTitle">
                    Welcome!
                </h1>
                <p class="sideText">
                    Enter your personal data to register
                </p>
                <a class="sideButton" href="<?php echo Link::getLink('login') ?>">
                    Login
                </a>
            </div>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
</html>