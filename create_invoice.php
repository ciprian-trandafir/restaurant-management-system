<?php

foreach (glob('classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

User::check_page(1);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Invoice • Restaurant</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/create_invoice.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
        <div class="go-loader-wrapper">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
        <div class="tableContainer">
            <div class="container1">
                <table class="invoice-table mainTable">
                    <tr class="table-headers">
                        <th class="table-title">Product</th>
                        <th class="table-title">Price</th>
                        <th class="table-title">Amount</th>
                    </tr>
                </table>
            </div>
            <div class="container2">
                <div class="smallTable">
                    <table class="inventory-table halfTable">
                        <tr class="table-headers">
                            <th class="table-title">Product</th>
                            <th class="table-title">Price</th>
                            <th class="table-title">Stock</th>
                        </tr>
                        <?php
                        $products = Inventory::loadInventory();
                        foreach ($products as $product) {
                            echo '<tr class="table-rows" data-id="'.$product['ID'].'">
                                <td class="table-cell product_name">'.$product['product'].'</td>
                                <td class="table-cell product_price">'.$product['price'].'</td>
                                <td class="table-cell product_stock">'.$product['stock'].'</td>
                            </tr>';
                        }
                        ?>
                    </table>
                    <div class="actions small-actions">
                        <div class="category">
                            <div class="inputContainer">
                                <label for="filter-products">Name</label>
                                <div class="d-flex between">
                                    <input type="text" name="name" id="filter-products">
                                    <button class="smallBtn buttonApplyProductsFilter">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="smallTable">
                    <table class="recipes-table halfTable">
                        <tr class="table-headers">
                            <th class="table-title">Name</th>
                            <th class="table-title">Price</th>
                        </tr>
                        <?php
                        $recipes = Recipe::loadRecipes(true);
                        foreach ($recipes as $recipe) {
                            echo '<tr class="table-rows" data-id="'.$recipe['ID'].'">
                                <td class="table-cell recipe_name">'.$recipe['name'].'</td>
                                <td class="table-cell recipe_price">'.$recipe['price'].'</td>
                            </tr>';
                        }
                        ?>
                    </table>
                    <div class="actions">
                        <div class="category">
                            <div class="inputContainer">
                                <label for="filter-recipes">Name</label>
                                <div class="d-flex between">
                                    <input type="text" name="name" id="filter-recipes">
                                    <button class="smallBtn buttonApplyRecipesFilter">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottomPanel d-flex">
        <div class="d-flex flex-end">
            <div class="info">
                <h4 class="infoText">Special requests:</h4>
                <input type="text" name="mentions" id="mentions" class="chosen">
            </div>
            <div class="d-flex leftMargin1">
                <button class="doneBtn buttonFinishInvoice">Done</button>
                <a class="doneBtn xBtn" href="<?php echo Link::getLink('index'); ?>">X</a>
            </div>
        </div>
        <div class="d-flex">
            <div class="actions small-actions">
                <div class="category">
                    <div class="d-flex specialContainer">
                        <div class="bigWidth">
                            <label for="chosen">You've selected:</label>
                            <input type="text" name="chosen" id="chosen" readonly>
                        </div>
                        <div>
                            <label for="amount_add">Amount</label>
                            <div class="d-flex between">
                                <input type="number" step="0.01" name="amount_add" id="amount_add">
                                <button class="addBtn buttonAddToInvoice">ADD</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
<script src="./js/create_invoice.js"></script>
</html>
