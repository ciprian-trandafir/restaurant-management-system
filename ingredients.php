<?php

foreach (glob('classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

User::check_page(2);

$url_components = parse_url(Link::get_current_url());
parse_str($url_components['query'], $params);

if (!isset($params['recipe'])) {
    Link::redirect('index');
    exit;
}

$recipe = new Recipe($params['recipe']);

if (!$recipe->getName()) {
    Link::redirect('index');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $recipe->getName().' - Ingredients'; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/ingredients.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
        <div class="go-loader-wrapper">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
        <div class="tableContainer">
            <div class="topPanel">
                <div class="info">
                    <h4 class="infoText">ID: <span class="infoValue" id="currentRecipeId"><?php echo $recipe->id; ?></span></h4>
                    <h4 class="infoText">Name: <span class="infoValue"><?php echo $recipe->getName(); ?></span></h4>
                    <h4 class="infoText">Price: <span class="infoValue"><?php echo $recipe->getPrice(); ?></span></h4>
                </div>
                <a href="<?php echo Link::getLink('recipes');?>" class="backBtn">Back</a>
            </div>
            <div class="containersWrapper">
                <div class="containers">
                    <div class="container1">
                        <div class="actions">
                            <h4 class="categoryTitle">Ingredients</h4>
                            <div class="divider"></div>
                            <div class="category">
                                <div class="inputContainer">
                                    <label for="id-edit-ingredient">ID</label>
                                    <div class="d-flex between">
                                        <input type="text" name="id-edit-ingredient" id="id-edit-ingredient" disabled="disabled">
                                        <button class="smallBtn btn saveIngredient" disabled="disabled">Save</button>
                                    </div>
                                </div>
                                <div class="inputContainer">
                                    <label for="qty-edit-ingredient">Quantity</label>
                                    <div class="d-flex between">
                                        <input type="text" name="qty-edit-ingredient" id="qty-edit-ingredient" disabled="disabled">
                                        <button class="btn smallBtn deleteBtn deleteIngredient" disabled="disabled">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ingredients-table-wrapper">
                            <table class="ingredients-table">
                                <tr class="table-headers">
                                    <th class="table-title">ID</th>
                                    <th class="table-title">Product</th>
                                    <th class="table-title">Quantity (g)</th>
                                </tr>
                                <?php
                                foreach ($recipe->getIngredients() as $ingredient) {
                                    echo '<tr class="table-rows" data-id="'.$ingredient['recipe_ing_id'].'">
                                    <td class="table-cell product_id">'.$ingredient['id_product'].'</td>
                                    <td class="table-cell">'.$ingredient['product'].'</td>
                                    <td class="table-cell product_qty">'.$ingredient['quantity'].'</td>
                                </tr>';
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="container2">
                        <div class="actions">
                            <h4 class="categoryTitle">Products</h4>
                            <div class="divider"></div>
                            <div class="category">
                                <div class="inputContainer">
                                    <label for="id-add-product">ID</label>
                                    <div class="d-flex">
                                        <input type="text" name="id-add-product" id="id-add-product" disabled="disabled">
                                    </div>
                                </div>
                                <div class="inputContainer">
                                    <label for="qty-add-product">Quantity</label>
                                    <div class="d-flex between">
                                        <input type="text" name="qty-add-product" id="qty-add-product" disabled="disabled">
                                        <button class="smallBtn addProductToList btn" disabled="disabled">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="inventory-table-wrapper">
                            <table class="inventory-table">
                                <tr class="table-headers">
                                    <th class="table-title">ID</th>
                                    <th class="table-title">Name</th>
                                    <th class="table-title">Available quantity (g)</th>
                                </tr>
                                <?php
                                $products = Inventory::loadInventory();
                                foreach ($products as $product) {
                                    echo '<tr class="table-rows" data-id="'.$product['ID'].'">
                                <td class="table-cell">'.$product['ID'].'</td>
                                <td class="table-cell product_name">'.$product['product'].'</td>
                                <td class="table-cell">'.$product['stock'].'</td>
                            </tr>';
                                }
                                ?>
                            </table>
                        </div>
                        <div class="actions">
                            <div class="category">
                                <div class="inputContainer">
                                    <label for="name">Product Name</label>
                                    <div class="d-flex between">
                                        <input type="text" name="ilter-inventory-name" id="filter-inventory-name">
                                        <button class="smallBtn applyInventoryFilter">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
<script src="./js/ingredients.js"></script>
</html>
