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
    <title>Logs • Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/logs.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
        <div class="sideMenu">
            <div class="sideMenuInner">
                <div class="menu-items">
                    <div class="menu-item">
                        <div class="select-user">
                            <label for="user">User</label>
                            <select name="user" id="user">
                                <option value="" disabled selected>Select User</option>
                                <?php
                                $users = User::getUsers();
                                foreach($users as $user) {
                                    echo '<option value="'.$user['ID'].'">'.$user['first_name'].' '.$user['last_name'].'</option>';
                                }
                                ?>
                            </select>
                            <span class="display-error"></span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <div class="select-action">
                            <label for="actions">Actions</label>
                            <select name="actions" id="action">
                                <option value="" disabled selected>Action Type</option>
                                <option value="login">Login</option>
                                <option value="delete">Delete</option>
                                <option value="insert inventory">Insert Inventory Product</option>
                                <option value="update inventory">Update Inventory Product</option>
                                <option value="insert recipe">Insert Recipe</option>
                                <option value="update recipe">Update Recipe</option>
                                <option value="insert ingredient">Insert Ingredient</option>
                                <option value="update ingredient">Update Ingredient</option>
                                <option value="create invoice">Create invoice</option>
                                <option value="pay invoice">Pay Invoice</option>
                                <option value="finish kitchen request">Finish kitchen request</option>
                            </select>
                            <span class="display-error"></span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <h4 class="sort-by">Sort by:</h4>
                        <div class="item-container checkbox-container">
                            <label class="radiobox-container">ASC
                                <input type="radio" checked="checked" name="sort_order" id="sort_order">
                                <span class="checkmark"></span>
                            </label>
                            <label class="radiobox-container">DESC
                                <input type="radio" name="sort_order" id="sort_order">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <!-- <div class="item-container checkbox-container">
                            <label for="asc">ASC</label>
                            <input type="checkbox" name="asc">
                        </div>
                        <div class="item-container checkbox-container">
                            <label for="desc">DESC</label>
                            <input type="checkbox" name="desc">
                        </div> -->
                    </div>
                    <div class="menu-item">
                        <div class="item-container">
                            <label for="date-from">Date From</label>
                            <input class="date-input" type="datetime-local" name="date-from" id="date-from">
                        </div>
                        <div class="item-container">
                            <label for="date-to">Date To</label>
                            <input class="date-input" type="datetime-local" name="date-to" id="date-to">
                        </div>
                    </div>
                </div>
                <button class="button_get_logs">Apply</button>
            </div>
        </div>
        <div class="container_custom">
            <div class="go-loader-wrapper">
                <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
            <table class="log-table">
                <tr class="table-headers">
                    <th class="table-title">ID</th>
                    <th class="table-title">User</th>
                    <th class="table-title">Details</th>
                    <th class="table-title">Date</th>
                </tr>
            </table>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
<script src="./js/logs.js"></script>
</html>
