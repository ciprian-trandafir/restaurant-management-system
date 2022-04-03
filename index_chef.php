<div class="chef_index">
    <div class="go-loader-wrapper">
        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
    <div class="recipes">
        <div class="row">
            <?php
            $pending_requests = KitchenRequest::getKitchenPendingRequests();
            if (!count($pending_requests)) {
                echo '<div class="no-results">
                <span>There are no pending kitchen requests</span>
            </div>';
            }
            foreach ($pending_requests as $request) {
                $recipe = new Recipe($request['id_recipe']);
                echo '<div class="recipe" data-id="'.$request['id_recipe'].'">
                <div class="recipe_inner">
                    <div class="recipe_header">
                        <div class="recipe_image">
                            <img src="./assets/recipe.png" alt="" class="recipe_img">
                        </div>
                        <span class="request_placed">'.$request['date_add'].'</span>
                        <span class="request_id">'.$request['ID'].'</span>
                    </div>
                    <div class="recipe_body">
                        <div class="recipe_name">
                            <span>'.$recipe->getName().'</span>
                        </div>
                    </div>
                    <div class="recipe_footer">
                        <button class="btn buttonKitchenRequestDone" data-id="'.$request['ID'].'">DONE</button>            
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
