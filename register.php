<?php

foreach (glob('classes/' . "*.php") as $file) {
    include_once $file;
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
    $access_level = $_POST['access-level'];
    $access_level = filter_var($access_level, FILTER_VALIDATE_INT);

    if ($access_level === false) {
        $errors['access-level'] = 'Invalid Access Level';
    }

    if ($email !== false && $access_level !== false) {
        if (User::checkEmail($email)) {
            $errors['email'] = 'This email address already exists. Login instead!';
        } else {
           if (User::register($firstname, $lastname, $email, $password, $access_level)) {
               $_POST = [];
               $successfully_registered = true;
           }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <title>Register - Restaurant</title>
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
                        Inregistrare
                    </h1>
                    <div class="mainSocials">

                    </div>
                    <!--<p class="mainNote">
                        sau foloseste adresa e-mail
                    </p>-->
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
                        <input type="password" name="password" <?php if (isset($errors['password'])) echo 'class="input-error"'; ?> placeholder="Parola" value="<?php if (isset($_POST['password'])) echo $_POST['password'];?>" required>
                        <?php
                        if (isset($errors['password'])) {
                            echo '<span class="display-error">'.$errors['password'].'</span>';
                        }
                        ?>
                    </div>
                    <div class="inputContainer">
                        <select name="access-level" required <?php if (isset($errors['access-level'])) echo 'class="input-error"'; ?>>
                            <option value="" disabled selected>Access Level</option>
                            <option value="2" <?php if (isset($_POST['access-level']) && $_POST['access-level'] == 2) echo 'selected';?>>Manager</option>
                            <option value="1" <?php if (isset($_POST['access-level']) && $_POST['access-level'] == 1) echo 'selected';?>>Ospatar</option>
                            <option value="0" <?php if (isset($_POST['access-level']) && $_POST['access-level'] == 0) echo 'selected';?>>Bucatar</option>
                        </select>
                        <?php
                        if (isset($errors['access-level'])) {
                            echo '<span class="display-error">'.$errors['access-level'].'</span>';
                        }
                        ?>
                    </div>
                    <!--<p class="forgotPassword">
                        Ti-ai uitat parola?
                    </p>-->
                    <input type="submit" name="submit" class="mainButton" value="Înregistrare">
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
                    Bun venit!
                </h1>
                <p class="sideText">
                    Introdu datele tale personale pentru a te înregistra
                </p>
                <a class="sideButton" href="<?php echo Link::getLink('login') ?>">
                    Autentificare
                </a>
            </div>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
</html>