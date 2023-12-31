<div class="customer_index">
    <div class="recipes">
        <div class="row">
            <?php
            $recipes = Recipe::loadRecipes(true);
            foreach ($recipes as $recipe) {
                echo '<div class="recipe" data-id="'.$recipe['ID'].'">
                <div class="recipe_inner">
                    <div class="recipe_header">
                        <div class="recipe_image">
                            <img src="./assets/recipe.png" alt="" class="recipe_img">
                        </div>
                    </div>
                    <div class="recipe_body">
                        <div class="recipe_name">
                            <span>'.$recipe['name'].'</span>
                        </div>
                        <div class="recipe_price">
                            <span>'.$recipe['price'].' RON</span>
                        </div>
                    </div>
                </div>
            </div>';
            }
            ?>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="recipe_details">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="go-loader-wrapper">
                        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                    </div>
                    <div class="modal-body-content">
                        <table class="ingredients-table">
                            <tr class="table-headers">
                                <th class="table-title">Name</th>
                                <th class="table-title">Quantity (g)</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
