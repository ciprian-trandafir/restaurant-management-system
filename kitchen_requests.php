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
    <title>Kitchen Requests • Restaurant</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/kitchen_requests.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
        <div class="kitchen_requests_wrapper">
            <div class="kitchen_requests">
                <div class="row">
                    <?php
                    $kitchen_requests = KitchenRequest::getAllPendingRequests();
                    if (!count($kitchen_requests)) {
                        echo '<div class="no-results">
                            <span>There are no pending kitchen requests</span>
                        </div>';
                    }
                    foreach ($kitchen_requests as $kitchen_request) {
                        $amount = KitchenRequest::getAmountByDetails($kitchen_request['id_invoice'], $kitchen_request['id_recipe'])[0]['amount'];
                        $recipe = new Recipe($kitchen_request['id_recipe']);
                        $footer = '';
                        $show_footer = (bool)$kitchen_request['date_finished'];
                        if ($show_footer) {
                            $respondent_user = User::getDetails($kitchen_request['respondent_user']);
                            $footer = '<div class="recipe_footer">
                                        <span>'.$respondent_user['first_name'].' '.$respondent_user['last_name'].'</span>
                                        <span>'.$kitchen_request['date_finished'].'</span>
                                    </div>';
                        }
                        echo '<div class="recipe">
                            <div class="recipe_inner '.($kitchen_request['date_finished'] ? 'request_finished' : '').'">
                                <div class="recipe_header">
                                    <div class="recipe_image">
                                        <img src="./assets/recipe.png" alt="" class="recipe_img">
                                    </div>
                                    <span class="request_placed">'.$kitchen_request['date_add'].'</span>
                                </div>
                                <div class="recipe_body">
                                    <div class="recipe_name">
                                        <span>'.$amount.'x '.$recipe->getName().'</span>
                                    </div>
                                    <div class="recipe_price">
                                        <span>'.$recipe->getPrice().' RON</span>
                                    </div>'.$footer.'
                                </div>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include './footer.php'; ?>
</html>
