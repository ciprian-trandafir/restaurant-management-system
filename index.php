<?php

foreach (glob('classes/' . "*.php") as $file) {
    include_once $file;
}

User::check_page();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurant</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
        <?php
            $user = new User($_SESSION['id_user']);
            switch ($user->getAccessLevel()) {
                case -1:
                    include './index_customer.php';
                    break;
                case 2:
                    include './index_manager.php';
                    break;
            }
        ?>
    </div>
</body>
<?php include './footer.php'; ?>
</html>
