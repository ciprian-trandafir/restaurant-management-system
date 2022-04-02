let $recipe_name = $('.addRecipe #add-name');
let $price = $('.addRecipe #add-price');

let $edit_id = $('.editRecipe #edit-id');
let $edit_recipe_name = $('.editRecipe #edit-name');
let $edit_price = $('.editRecipe #edit-price');

let $loading = $('.go-loader-wrapper');

$('body')
    .on('dblclick', '.addRecipeBtn', function() {
        let do_ajax = true;

        if (!$recipe_name.val()) {
            $recipe_name.addClass('input-error');
            $recipe_name.closest('div').find('.display-error').text('Name cannot be empty');
            do_ajax = false;
        }

        if (!$price.val()) {
            $price.addClass('input-error');
            $price.closest('div').find('.display-error').text('Price cannot be empty');
            do_ajax = false;
        }

        if (do_ajax) {
            $loading.fadeIn(200);
            $.ajax({
                method: "POST",
                dataType: "json",
                url: AJAX_URL,
                data: {
                    action: 'insertRecipe',
                    recipe_name: $recipe_name.val(),
                    price: $price.val(),
                },
                success: function(data) {
                    $loading.fadeOut(200);
                    if (data.response) {
                        $('.recipe-table .table-headers').after(data.response);
                        resetAddRecipeFields();
                    }
                }
            })
        }
    })
    .on('dblclick', '.editRecipeBtn', function() {
        let do_ajax = true;

        if (!$edit_id.val()) {
            alert('Please select a recipe to edit!');
        } else {
            if (!$edit_recipe_name.val()) {
                $edit_recipe_name.addClass('input-error');
                $edit_recipe_name.closest('div').find('.display-error').text('Name cannot be empty');
                do_ajax = false;
            }

            if (!$edit_price.val()) {
                $edit_price.addClass('input-error');
                $edit_price.closest('div').find('.display-error').text('Price cannot be empty');
                do_ajax = false;
            }

            if (do_ajax) {
                $loading.fadeIn(200);
                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: AJAX_URL,
                    data: {
                        action: 'updateRecipe',
                        recipe_id: $edit_id.val(),
                        name: $edit_recipe_name.val(),
                        price: $edit_price.val(),
                    },
                    success: function(data) {
                        $loading.fadeOut(200);
                        if (data.success) {
                            let $row = $('tr[data-id=' + $edit_id.val() + ']');
                            $row.find('.recipe_name').text($edit_recipe_name.val());
                            $row.find('.recipe_price').text($edit_price.val());
                        }
                    }
                })
            }
        }
    })
    .on('click', '.goToIngredients', function () {
        if (!$edit_id.val()) {
            alert('Please select a recipe to edit ingredients!');
        }
    })
    .on('click', '.add-recipe-clear', function() {
        resetAddRecipeFields();
    })
    .on('click', '.edit-recipe-clear', function() {
        resetEditRecipeFields();
    })
    .on('click', '.table-rows', function() {
        $('.table-rows').each(function() {
            $(this).removeClass('row-selected');
        })

        let $row = $(this);
        $row.addClass('row-selected');

        $edit_id.val($row.find('.recipe_id').text());
        $edit_recipe_name.val($row.find('.recipe_name').text());
        $edit_price.val($row.find('.recipe_price').text());

        $edit_recipe_name.attr('disabled', false);
        $edit_price.attr('disabled', false);

        $('.goToIngredients').attr('href', ingredients_partial_url + '?recipe=' + $row.find('.recipe_id').text());
    });

function resetAddRecipeFields() {
    $recipe_name.val('');
    $recipe_name.removeClass('input-error');
    $recipe_name.closest('div').find('.display-error').text('');

    $price.val('');
    $price.removeClass('input-error');
    $price.closest('div').find('.display-error').text('');
}

function resetEditRecipeFields() {
    $edit_id.val('');

    $edit_recipe_name.val('');
    $edit_recipe_name.removeClass('input-error');
    $edit_recipe_name.closest('div').find('.display-error').text('');

    $edit_price.val('');
    $edit_price.removeClass('input-error');
    $edit_price.closest('div').find('.display-error').text('');

    $edit_recipe_name.attr('disabled', true);
    $edit_price.attr('disabled', true);

    $('.table-rows').each(function() {
        $(this).removeClass('row-selected');
    });

    $('.goToIngredients').attr('href', '#');
}
