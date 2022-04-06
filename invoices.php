<?php

foreach (glob('classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

User::check_page(2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoices • Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/invoices.css">
    <?php include './head.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
                            <option value="" selected>Select User</option>
                            <?php
                            $users = User::getUsers(1);
                            foreach($users as $user) {
                                echo '<option value="'.$user['ID'].'">'.$user['first_name'].' '.$user['last_name'].'</option>';
                            }
                            ?>
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
            <span class="total_rewards"></span>
            <div>
                <button class="btn button_view_graph" disabled="disabled">View Graph</button>
                <button class="button_get_invoice_history">Apply</button>
            </div>

        </div>
    </div>
    <div class="container_custom">
        <div class="go-loader-wrapper">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
        <table class="invoices-table">
            <tr class="table-headers">
                <th class="table-title">ID</th>
                <th class="table-title">User</th>
                <th class="table-title">Total(RON)</th>
                <th class="table-title">Mentions</th>
                <th class="table-title">Date placed</th>
                <th class="table-title">Date paid</th>
            </tr>
        </table>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="sales_graph">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sales Graph</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <canvas id="chartSales" style="width:100%; max-width:600px"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<?php include './foo.php'; ?>
<script src="./js/invoices.js"></script>
</html>
