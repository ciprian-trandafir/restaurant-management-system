<?php

foreach (glob('classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

User::check_page(2);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Accounts • Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/accounts.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
        <div class="container_custom">
            <table class="accounts-table">
                <tr class="table-headers">
                    <th class="table-title">ID</th>
                    <th class="table-title">Name</th>
                    <th class="table-title">Email</th>
                    <th class="table-title">Role</th>
                    <th class="table-title">Active</th>
                    <th class="table-title">Last Login</th>
                    <th class="table-title"></th>
                </tr>
                <?php
                $users = User::getUsers();
                foreach ($users as $user) {
                    $last_login = User::getLastLogin($user['ID']);
                    $lastLogin = '---';
                    if ($last_login) {
                        $lastLogin = $last_login[0]['date'] .' (IP: '.explode(' ', $last_login[0]['details'])[count(explode(' ', $last_login[0]['details'])) - 1].')';
                    }

                    switch ($user['access_level']) {
                        case -1:
                            $role = 'Client';
                            break;
                        case 0:
                            $role = 'Bucătar';
                            break;
                        case 1:
                            $role = 'Ospătar';
                            break;
                        case 2:
                            $role = 'Manager';
                            break;
                        default:
                            $role = 'Undefined';
                            break;
                    }

                    echo '<tr class="table-rows '.($user['active'] ? '' : 'account_inactive').'" data-id="'.$user['ID'].'">
                        <td class="table-cell">'.$user['ID'].'</td>
                        <td class="table-cell user_full_name">'.$user['first_name'].' '.$user['last_name'].'</td>
                        <td class="table-cell">'.$user['email'].'</td>
                        <td class="table-cell">'.$role.'</td>
                        <td class="table-cell">'.($user['active'] ? 'YES' : 'NO').'</td>
                        <td class="table-cell">'.$lastLogin.'</td>
                        <td class="table-cell">'.($user['ID'] == $_SESSION['id_user'] ? '' : '
                            <div class="user_action_image user_action_edit">
                                <img src="assets/edit.png" class="user_action_img" alt="">
                            </div>').'                   
                        </td>
                    </tr>';
                }
                ?>
            </table>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="edit_user_details" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">aaa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="go-loader-wrapper">
                        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                    </div>
                    <div class="menu-items">
                        <div class="menu-item">
                            <select name="edit_role" id="edit_role">
                                <option value="" disabled selected>Select role</option>
                                <option value="2">Manager</option>
                                <option value="1">Ospătar</option>
                                <option value="0">Bucătar</option>
                                <option value="-1">Client</option>
                            </select>
                            <span class="display-error"></span>
                        </div>
                        <div class="menu-item">
                            <select name="edit-active" id="edit-active">
                                <option value="" disabled selected>Select account status</option>
                                <option value="1">Active</option>
                                <option value="0">Disabled</option>
                            </select>
                            <span class="display-error"></span>
                        </div>
                    </div>
                    <div class="confirmation_message confirmation_success">
                        <span>Success. Reloading in 3 seconds.. </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary button_save_user_details">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
<script src="./js/accounts.js"></script>
</html>

