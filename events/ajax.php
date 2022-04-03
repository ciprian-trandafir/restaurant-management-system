<?php

foreach (glob('../classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

if (!isset($_POST['action'])) {
    Link::redirect('index');
    exit;
}

session_start();

$action = trim(htmlspecialchars($_POST['action']));

if ($action === 'updatePassword') {
    $update_password = User::changePassword(trim(htmlspecialchars($_POST['old_password'])), trim(htmlspecialchars($_POST['new_password'])));

    die(json_encode(['response' => $update_password]));
}

if ($action === 'getLogs') {
    $user = trim(htmlspecialchars($_POST['user']));
    $action_user = trim(htmlspecialchars($_POST['action_user']));
    $sort = trim(htmlspecialchars($_POST['sort']));
    $date_from = trim(htmlspecialchars($_POST['date_from']));
    $date_to = trim(htmlspecialchars($_POST['date_to']));

    $date_from = str_replace('T', ' ', $date_from);
    $date_to = str_replace('T', ' ', $date_to);

    $logs = Log::getLogs($user, $action_user, $sort, $date_from, $date_to);

    $output = '';
    foreach ($logs as $log) {
        $output .= '<tr class="table-rows">
                    <td class="table-cell">'.$log['ID'].'</td>
                    <td class="table-cell">'.$log['first_name'].' '.$log['last_name'].'</td>
                    <td class="table-cell">'.$log['details'].'</td>
                    <td class="table-cell">'.$log['date'].'</td>
                </tr>';
    }

    die(json_encode(['response' => $output]));
}

if ($action === 'insertInventory') {
    $product_name = trim(htmlspecialchars($_POST['product_name']));
    $stock = trim(htmlspecialchars($_POST['stock']));
    $price = trim(htmlspecialchars($_POST['price']));
    $measure_unit = trim(htmlspecialchars($_POST['measure_unit']));

    $insert_id = Inventory::insertInventory($product_name, $stock, $price, $measure_unit);

    $output = '<tr class="table-rows" data-id="'.$insert_id.'">
                <td class="table-cell product_id">'.$insert_id.'</td>
                <td class="table-cell">
                    <div class="product_image">
                        <img src="assets/food.png" class="product_img" alt="">
                    </div>
                </td>
                <td class="table-cell product_name">'.$product_name.'</td>
                <td class="table-cell product_stock">'.$stock.'</td>
                <td class="table-cell product_measure">'.$price.'</td>
                <td class="table-cell product_price">'.$measure_unit.'</td>
            </tr>';

    die(json_encode(['response' => $output]));
}

if ($action === 'updateInventory') {
    $product_id = trim(htmlspecialchars($_POST['product_id']));
    $stock = trim(htmlspecialchars($_POST['stock']));
    $price = trim(htmlspecialchars($_POST['price']));

    Inventory::updatePrice($product_id, $price);
    Inventory::updateStock($product_id, $stock);

    die(json_encode(['success' => true]));
}

if ($action === 'deleteInventory') {
    $product_id = trim(htmlspecialchars($_POST['product_id']));

    DbUtils::deleteRow($product_id, 'inventory');

    die(json_encode(['success' => true]));
}

if ($action === 'insertRecipe') {
    $recipe_name = trim(htmlspecialchars($_POST['recipe_name']));
    $price = trim(htmlspecialchars($_POST['price']));

    $insert_id = Recipe::insertRecipe($recipe_name, $price);

    $output = '<tr class="table-rows" data-id="'.$insert_id.'">
                <td class="table-cell recipe_id">'.$insert_id.'</td>
                <td class="table-cell">
                    <div class="recipe_image">
                        <img src="assets/recipe.png" class="recipe_img" alt="">
                    </div>
                </td>
                <td class="table-cell recipe_name">'.$recipe_name.'</td>
                <td class="table-cell recipe_price">'.$price.'</td>
            </tr>';

    die(json_encode(['response' => $output]));
}

if ($action === 'updateRecipe') {
    $recipe_id = trim(htmlspecialchars($_POST['recipe_id']));
    $name = trim(htmlspecialchars($_POST['name']));
    $price = trim(htmlspecialchars($_POST['price']));

    Recipe::editRecipe($recipe_id, $name, $price);

    die(json_encode(['success' => true]));
}

if ($action === 'updateUser') {
    $id_user = trim(htmlspecialchars($_POST['id_user']));
    $role = trim(htmlspecialchars($_POST['role']));
    $status = trim(htmlspecialchars($_POST['status']));

    User::updateRoleAndStatus($id_user, $role, $status);

    die(json_encode(['response' => true]));
}

if ($action === 'applyInventoryFilters') {
    $filter = trim(htmlspecialchars($_POST['filter']));

    $inventories = Inventory::loadInventory($filter);
    $output = '';
    foreach ($inventories as $inventory) {
        $output .= '<tr class="table-rows" data-id="'.$inventory['ID'].'">
                        <td class="table-cell">'.$inventory['ID'].'</td>
                        <td class="table-cell product_name">'.$inventory['product'].'</td>
                        <td class="table-cell">'.$inventory['stock'].'</td>
                    </tr>';
    }

    die(json_encode(['response' => $output]));
}

if ($action === 'addIngredient') {
    $recipe = trim(htmlspecialchars($_POST['recipe']));
    $product_id = trim(htmlspecialchars($_POST['product_id']));
    $product_name = trim(htmlspecialchars($_POST['product_name']));
    $qty = trim(htmlspecialchars($_POST['qty']));

    $insert_id = Recipe::addIngredient($recipe, $product_id, $qty);
    $output = '<tr class="table-rows" data-id="'.$insert_id.'">
                <td class="table-cell product_id">'.$product_id.'</td>
                <td class="table-cell">'.$product_name.'</td>
                <td class="table-cell product_qty">'.$qty.'</td>
            </tr>';

    die(json_encode(['response' => $output]));
}

if ($action === 'deleteIngredient') {
    $ing_id = trim(htmlspecialchars($_POST['ing_id']));

    DbUtils::deleteRow($ing_id, 'recipes_ingredients');

    die(json_encode(['response' => true]));
}

if ($action === 'updateIngredientQty') {
    $ing_id = trim(htmlspecialchars($_POST['ing_id']));
    $qty = trim(htmlspecialchars($_POST['qty']));

    Recipe::updateIngredientQty($ing_id, $qty);

    die(json_encode(['response' => true]));
}

if ($action === 'getRecipeIngredients') {
    $id_recipe = trim(htmlspecialchars($_POST['id_recipe']));
    $recipe = new Recipe($id_recipe);

    $output = '';
    foreach ($recipe->getIngredients() as $ingredient) {
        $output .= '<tr class="table-rows">
                        <td class="table-cell">'.$ingredient['product'].'</td>
                        <td class="table-cell user_full_name">'.$ingredient['quantity'].'</td>
                    </tr>';
    }

    die(json_encode(['response' => $output]));
}

if ($action === 'payInvoice') {
    $id_invoice = trim(htmlspecialchars($_POST['id_invoice']));

    Invoice::payInvoice($id_invoice);

    die(json_encode(['response' => true]));
}

if ($action === 'finishKitchenRequest') {
    $id_request = trim(htmlspecialchars($_POST['id_request']));

    KitchenRequest::finishRequest($id_request);

    die(json_encode(['response' => true]));
}

Link::redirect('index');
exit;
