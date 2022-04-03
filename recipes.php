<?php

foreach (glob('classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

User::check_page(2);

if (isset($_POST['submitApply'])) {
    $name = trim(htmlspecialchars($_POST['filter-name']));
    $price_from = trim(htmlspecialchars($_POST['filter-price-from']));
    $price_to = trim(htmlspecialchars($_POST['filter-price-to']));

    $filters = [
        'name' => $name,
        'price_from' => $price_from,
        'price_to' => $price_to
    ];

    setcookie('recipeFilters', json_encode($filters), time() + (86400 * 30), "/");
    Link::redirect(Link::get_current_location());
}

if (isset($_POST['submitReset'])) {
    setcookie('recipeFilters', '', time() - 3600);
    Link::redirect(Link::get_current_location());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recipes - Restaurant</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/recipe.css">
    <?php include './head.php'; ?>
    <script>
        <?php
        echo "var ingredients_partial_url = '".Link::getLink('ingredients')."'";
        ?>
    </script>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
        <div class="sideMenu">
            <h4 class="categoryTitle">Add Recipe</h4>
            <div class="divider"></div>
            <div class="category addRecipe">
                <div class="inputContainer">
                    <div class="add-recipe-header">
                        <label for="add-name">Product Name</label>
                        <span class="add-recipe-clear" title="Clear add recipe details">×</span>
                    </div>
                    <input type="text" name="add-name" id="add-name">
                    <span class="display-error"></span>
                </div>
                <div class="inputContainer">
                    <label for="add-price">Price</label>
                    <input type="number" min="0" name="add-price" id="add-price">
                    <span class="display-error"></span>
                </div>
                <button class="addRecipeBtn">Add</button>
            </div>
            <h4 class="categoryTitle">Edit Recipe</h4>
            <div class="divider"></div>
            <div class="category editRecipe">
                <div class="inputContainer">
                    <div class="edit-recipe-header">
                        <label for="edit-name">Product Name</label>
                        <span class="edit-recipe-clear" title="Clear edit recipe details">×</span>
                    </div>
                    <input type="text" name="edit-name" id="edit-name" disabled="disabled">
                    <span class="display-error"></span>
                </div>
                <div class="inputContainer">
                    <label for="edit-price">Price</label>
                    <input type="number" min="0" name="edit-price" id="edit-price" disabled="disabled">
                    <span class="display-error"></span>
                </div>
                <input type="hidden" id="edit-id">
                <button class="editRecipeBtn">Save</button>
            </div>
            <h4 class="categoryTitle">Filters</h4>
            <div class="divider"></div>
            <form class="category" method="post">
                <div class="inputContainer">
                    <label for="filter-name">Name</label>
                    <input type="text" name="filter-name" id="filter-name" <?php if (isset($_COOKIE['recipeFilters'])) {echo 'value="'.json_decode($_COOKIE['recipeFilters'], true)['name'].'"';} ?>>
                </div>
                <div class="inputGroup">
                    <div class="inputContainer setWidth">
                        <label for="filter-price">Price</label>
                        <input type="number" min="0" step="0.01" name="filter-price-from" id="filter-price" placeholder="from" <?php if (isset($_COOKIE['recipeFilters'])) {echo 'value="'.json_decode($_COOKIE['recipeFilters'], true)['price_from'].'"';} ?>>
                    </div>
                    <div class="inputContainer setWidth">
                        <input type="number" min="0" step="0.01" name="filter-price-to" id="filter-price" placeholder="to" <?php if (isset($_COOKIE['recipeFilters'])) {echo 'value="'.json_decode($_COOKIE['recipeFilters'], true)['price_to'].'"';} ?>>
                    </div>
                </div>
                <div class="btnSection">
                    <input type="submit" value="Apply" name="submitApply" class="addRecipeBtnSmall">
                    <input type="submit" value="Reset" name="submitReset" class="addRecipeBtnSmall">
                </div>
            </form>
            <div class="btnContainer">
                <a href="#" class="majorBtn btnFullWidth goToIngredients">Go to Ingredients</a>
            </div>
        </div>
        <div class="container_custom">
            <div class="go-loader-wrapper">
                <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
            <table class="recipe-table">
                <tr class="table-headers">
                    <th class="table-title">ID</th>
                    <th class="table-title">Picture</th>
                    <th class="table-title">Name</th>
                    <th class="table-title">Price(RON)</th>
                </tr>
                <?php
                    $recipes = Recipe::loadRecipes();
                    foreach ($recipes as $recipe) {
                        echo '<tr class="table-rows" data-id="'.$recipe['ID'].'">
                    <td class="table-cell recipe_id">'.$recipe['ID'].'</td>
                    <td class="table-cell">
                        <div class="recipe_image">
                            <img src="assets/recipe.png" class="recipe_img" alt="">
                        </div>
                    </td>
                    <td class="table-cell recipe_name">'.$recipe['name'].'</td>
                    <td class="table-cell recipe_price">'.$recipe['price'].'</td>
                </tr>';
                    }
                ?>
            </table>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
<script src="./js/recipes.js"></script>
</html>
