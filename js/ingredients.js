let $loading = $('.go-loader-wrapper');

$('body')
    .on('click', '.applyInventoryFilter', function() {
        $loading.fadeIn(200);
        let filter = $('#filter-inventory-name').val();
        $.ajax({
            method: "POST",
            dataType: "json",
            url: AJAX_URL,
            data: {
                action: 'applyInventoryFilters',
                filter: filter,
            },
            success: function(data) {
                $loading.fadeOut(200);
                $('.inventory-table .table-rows').each(function () {
                    $(this).remove();
                })

                resetAddProductsFields();
                $('.inventory-table tbody').append(data.response);
            }
        })
    })
    .on('click', '.inventory-table .table-rows', function() {
        $('.inventory-table .table-rows').each(function() {
            $(this).removeClass('row-selected');
        })

        $(this).addClass('row-selected');

        $('#id-add-product').val($(this).attr('data-id'));
        $('#qty-add-product, .addProductToList').attr('disabled', false);
    })
    .on('click', '.addProductToList', function() {
        let $qty = $('#qty-add-product');
        if (!$qty.val()) {
            $qty.addClass('input-error');
            alert('Please complete quantity');
        } else {
            $loading.fadeIn(200);
            $.ajax({
                method: "POST",
                dataType: "json",
                url: AJAX_URL,
                data: {
                    action: 'addIngredient',
                    qty: $qty.val(),
                    product_id: $('#id-add-product').val(),
                    product_name: $('.inventory-table').find('.row-selected').find('.product_name').text(),
                    recipe: $('#currentRecipeId').text()
                },
                success: function(data) {
                    $loading.fadeOut(200);
                    resetAddProductsFields();
                    resetEditProductsFields();

                    $('.ingredients-table .table-headers').after(data.response);
                }
            })
        }
    })
    .on('dblclick', '.deleteIngredient', function() {
        let $delete_product = $('.ingredients-table').find('.row-selected');
        $loading.fadeIn(200);
        $.ajax({
            method: "POST",
            dataType: "json",
            url: AJAX_URL,
            data: {
                action: 'deleteIngredient',
                ing_id: $delete_product.attr('data-id'),
            },
            success: function() {
                $loading.fadeOut(200);
                resetEditProductsFields();

                $delete_product.remove();
            }
        })
    })
    .on('click', '.ingredients-table .table-rows', function() {
        $('.ingredients-table .table-rows').each(function() {
            $(this).removeClass('row-selected');
        })

        $(this).addClass('row-selected');
        $('#id-edit-ingredient').val($(this).find('.product_id').text());
        $('#qty-edit-ingredient').val($(this).find('.product_qty').text());
        $('#qty-edit-ingredient, .deleteBtn ,.saveIngredient').attr('disabled', false);
    })
    .on('click', '.saveIngredient', function() {
        let $qty = $('#qty-edit-ingredient');
        let $ing = $('.ingredients-table').find('.row-selected');

        if (!$qty.val()) {
            $qty.addClass('input-error');
            alert('Please complete quantity');
        } else {
            $loading.fadeIn(200);
            $.ajax({
                method: "POST",
                dataType: "json",
                url: AJAX_URL,
                data: {
                    action: 'updateIngredientQty',
                    ing_id: $ing.attr('data-id'),
                    qty: $qty.val(),
                },
                success: function() {
                    $loading.fadeOut(200);
                    $ing.find('.product_qty').text($qty.val());
                }
            })
        }
    })

function resetAddProductsFields() {
    $('.inventory-table .table-rows').each(function() {
        $(this).removeClass('row-selected');
    })
    $('#id-add-product').val('');
    $('#qty-add-product').val('');
    $('#qty-add-product, .addProductToList').attr('disabled', true);
}

function resetEditProductsFields() {
    $('.ingredients-table .table-rows').each(function() {
        $(this).removeClass('row-selected');
    })
    $('#id-edit-ingredient').val('');
    $('#qty-edit-ingredient').val('');
    $('#qty-edit-ingredient, .deleteBtn ,.saveIngredient').attr('disabled', true);
}
