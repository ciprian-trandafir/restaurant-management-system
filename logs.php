<?php

foreach (glob('classes/' . "*.php") as $file)
{
    include_once $file;
}

User::check_page();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Logs - Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/logs.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
        <div class="sideMenu">
            <div class="menu-item">
                <label for="user">User</label>
                <select name="user" id="user">
                    <option value="" disabled selected>Select User</option>
                    <option value="manager">Manager</option>
                    <option value="ospatar">Ospatar</option>
                    <option value="bucatar">Bucatar</option>
                </select>
            </div>
            <div class="menu-item">
                <label for="actions">Actions</label>
                <select name="actions">
                    <option value="" disabled selected>Action Type</option>
                    <option value="manager">Manager</option>
                    <option value="ospatar">Ospatar</option>
                    <option value="bucatar">Bucatar</option>
                </select>
            </div>
            <div class="menu-item">
                <h4 class="sort-by">Sort by:</h4>
                <div class="item-container checkbox-container">
                    <label class="radiobox-container">ASC
                        <input type="radio" checked="checked" name="radio">
                        <span class="checkmark"></span>
                    </label>
                    <label class="radiobox-container">DESC
                        <input type="radio" name="radio">
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
                    <input class="date-input" type="date" name="date-from">
                </div>
                <div class="item-container">
                    <label for="date-to">Date To</label>
                    <input class="date-input" type="date" name="date-to">
                </div>
            </div>
            <button>Apply</button>
        </div>
        <div class="container_custom">
            <div class="go-loader-wrapper">
                <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
            <table class="log-table">
                <tr class="table-headers">
                    <th class="table-title">ID</th>
                    <th class="table-title">User</th>
                    <th class="table-title">Action</th>
                    <th class="table-title">Details</th>
                    <th class="table-title">Date</th>
                </tr>
                <tr class="table-rows">
                    <td class="table-cell">1</td>
                    <td class="table-cell">user3 user3</td>
                    <td class="table-cell">select</td>
                    <td class="table-cell">SELECT * FROM 'invoice' WHERE...</td>
                    <td class="table-cell">2021-11-23 23:01:20</td>
                </tr>
                <tr class="table-rows">
                    <td class="table-cell">1</td>
                    <td class="table-cell">user3 user3</td>
                    <td class="table-cell">select</td>
                    <td class="table-cell">SELECT * FROM 'invoice' WHERE...</td>
                    <td class="table-cell">2021-11-23 23:01:20</td>
                </tr>
            </table>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
</html>
