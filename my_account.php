<?php

foreach (glob('classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

User::check_page();

$user = User::getDetails($_SESSION['id_user']);

$errors = [];
$update_state = 0;

if (isset($_POST['submit'])) {
    $firstname = trim(htmlspecialchars($_POST['first-name']));
    $lastname = trim(htmlspecialchars($_POST['last-name']));

    $email = trim(htmlspecialchars($_POST['email']));
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        $errors['email'] = 'Invalid Email Address';
    } else {
        $update_state = User::update($user, $email, $firstname, $lastname);
        if ($update_state == 0) {
            $errors['email'] = 'This email address already exists!';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Account - Restaurant</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/my_account.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
        <div class="sideScreen">
            <div class="sideContent">
                <div class="imageContainer">
                    <img src="assets/profile.jpg">
                </div>
                <h1 class="sideTitle">
                    <?php echo $user['first_name'].' '.$user['last_name'] ?>
                </h1>
                <p class="sideText">
                    <?php
                    switch ($user['access_level']) {
                        case -1:
                            echo 'Client';
                            break;
                        case 0:
                            echo 'Bucătar';
                            break;
                        case 1:
                            echo 'Ospătar';
                            break;
                        case 2:
                            echo 'Manager';
                            break;
                    }
                    ?>
                </p>
            </div>
        </div>
        <div class="mainScreen">
            <div class="mainContent">
                <div class="headerContainer flex">
                    <img class="headerImg" src="assets/information-security.png">
                    <div>
                        <h1 class="mainTitle">
                            Personal Information
                        </h1>
                        <div class="mainSocials">

                        </div>
                        <p class="mainNote">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis porttitor, enim ac posuere commodo, nibh ipsum tempus velit, eu aliquet tellus erat nec nisi.
                        </p>
                    </div>
                </div>
                <form method="post">
                    <div class="inputContainer">
                        <input class="spacer-right" type="text" name="first-name" placeholder="First name" value="<?php if (isset($_POST['first-name'])) echo $_POST['first-name']; else echo $user['first_name'];?>">
                        <input type="text" name="last-name" placeholder="Last Name" value="<?php if (isset($_POST['last-name'])) echo $_POST['last-name']; else echo $user['last_name'];?>">
                    </div>
                    <div class="inputContainer">
                        <div class="inputContainer_inner">
                            <input type="email" name="email" placeholder="E-mail" value="<?php if (isset($_POST['email'])) echo $_POST['email']; else echo $user['email'];?>" <?php if (isset($errors['email'])) echo 'class="input-error"'; ?>>
                            <?php
                            if (isset($errors['email'])) {
                                echo '<span class="display-error">'.$errors['email'].'</span>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="buttonContainer">
                        <input type="submit" class="mainButton" name="submit" value="Save">
                        <span class="secondaryButton">
                            Update Password
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="go-loader-wrapper">
                        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                    </div>
                    <div class="oldPasswordContainer">
                        <label for="old_password">Old password</label>
                        <input id="old_password" type="password" name="old_password" placeholder="Password">
                        <span class="display-error"></span>
                    </div>
                    <div class="newPasswordContainer">
                        <label for="new_password">New password</label>
                        <input id="new_password" type="password" name="new_password" placeholder="Password">
                        <span class="display-error"></span>
                    </div>
                    <div class="newPasswordCContainer">
                        <label for="new_passwordC">New password confirm</label>
                        <input id="new_passwordC" type="password" name="new_passwordC" placeholder="Password">
                        <span class="display-error"></span>
                    </div>
                    <div class="confirmation_message confirmation_success">
                        <span>Success. Reloading in 3 seconds.. </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary button_update_password">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
<script src="./js/my_account.js"></script>
</html>
