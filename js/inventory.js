let $product_name = $('.addProduct #product-name');
let $stock = $('.addProduct #stock');
let $price = $('.addProduct #price');
let $measure_unit = $('.addProduct #measure_unit');

let $edit_id = $('.editProduct #edit-id');
let $edit_product_name = $('.editProduct #edit-product-name');
let $edit_stock = $('.editProduct #edit-stock');
let $edit_price = $('.editProduct #edit-price');

let $loading = $('.go-loader-wrapper');

$('body')
    .on('dblclick', '.addProductBtn', function() {
        let do_ajax = true;

        if (!$product_name.val()) {
            $product_name.addClass('input-error');
            $product_name.closest('div').find('.display-error').text('Name cannot be empty');
            do_ajax = false;
        }

        if (!$stock.val()) {
            $stock.addClass('input-error');
            $stock.closest('div').find('.display-error').text('Stock cannot be empty');
            do_ajax = false;
        }

        if (!$price.val()) {
            $price.addClass('input-error');
            $price.closest('div').find('.display-error').text('Price cannot be empty');
            do_ajax = false;
        }

        if (!$measure_unit.val()) {
            $measure_unit.addClass('input-error');
            $measure_unit.closest('div').find('.display-error').text('Please select measure unit');
            do_ajax = false;
        }

        if (do_ajax) {
            $loading.fadeIn(200);
            $.ajax({
                method: "POST",
                dataType: "json",
                url: AJAX_URL,
                data: {
                    action: 'insertInventory',
                    product_name: $product_name.val(),
                    stock: $stock.val(),
                    price: $price.val(),
                    measure_unit: $measure_unit.val(),
                },
                success: function(data) {
                    $loading.fadeOut(200);
                    if (data.response) {
                        $('.inventory-table .table-headers').after(data.response);
                        $product_name.val('');
                        $stock.val('');
                        $price.val('');
                        $measure_unit.val('');
                    }
                }
            })
        }
    })
    .on('dblclick', '.editProductBtn', function() {
        let do_ajax = true;

        if (!$edit_id.val()) {
            alert('Please select a product to edit!');
        } else {
            if (!$edit_stock.val()) {
                $edit_stock.addClass('input-error');
                $edit_stock.closest('div').find('.display-error').text('Stock cannot be empty');
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
                        action: 'updateInventory',
                        product_id: $edit_id.val(),
                        stock: $edit_stock.val(),
                        price: $edit_price.val(),
                    },
                    success: function(data) {
                        $loading.fadeOut(200);
                        if (data.success) {
                            let $row = $('tr[data-id=' + $edit_id.val() + ']');
                            $row.find('.product_stock').text($edit_stock.val());
                            $row.find('.product_price').text($edit_price.val());
                        }
                    }
                })
            }
        }
    })
    .on('dblclick', '.deleteProductBtn', function() {
        if (!$edit_id.val()) {
            alert('Please select a product to delete!');
        } else {
            $loading.fadeIn(200);
            $.ajax({
                method: "POST",
                dataType: "json",
                url: AJAX_URL,
                data: {
                    action: 'deleteInventory',
                    product_id: $edit_id.val(),
                },
                success: function(data) {
                    $loading.fadeOut(200);
                    if (data.success) {
                        $('tr[data-id=' + $edit_id.val() + ']').remove();
                        clearEditFields();
                    }
                }
            })
        }
    })
    .on('click', '.inventory_import_csv', function () {
        $('#inventory_import_csv').modal('show');
    })
    .on('change', '.addProduct #measure_unit', function () {
        $measure_unit.closest('div').find('.display-error').text('');
        $measure_unit.removeClass('input-error');
    })
    .on('click', '.add-product-clear', function() {
        $product_name.val('');
        $product_name.removeClass('input-error');
        $product_name.closest('div').find('.display-error').text('');

        $stock.val('');
        $stock.removeClass('input-error');
        $stock.closest('div').find('.display-error').text('');

        $price.val('');
        $price.removeClass('input-error');
        $price.closest('div').find('.display-error').text('');

        $measure_unit.val('');
        $measure_unit.removeClass('input-error');
        $measure_unit.closest('div').find('.display-error').text('');
    })
    .on('click', '.edit-product-clear', function() {
        clearEditFields();
    })
    .on('click', '.table-rows', function() {
        $('.table-rows').each(function() {
            $(this).removeClass('row-selected');
        })

        let $row = $(this);
        $row.addClass('row-selected');

        $edit_id.val($row.find('.product_id').text());
        $edit_product_name.val($row.find('.product_name').text());
        $edit_stock.val($row.find('.product_stock').text());
        $edit_price.val($row.find('.product_price').text());

        $edit_stock.attr('disabled', false);
        $edit_price.attr('disabled', false);
    });

function clearEditFields() {
    $edit_id.val('');

    $edit_product_name.val('');
    $edit_product_name.removeClass('input-error');
    $edit_product_name.closest('div').find('.display-error').text('');

    $edit_stock.val('');
    $edit_stock.removeClass('input-error');
    $edit_stock.closest('div').find('.display-error').text('');

    $edit_price.val('');
    $edit_price.removeClass('input-error');
    $edit_price.closest('div').find('.display-error').text('');

    $edit_stock.attr('disabled', true);
    $edit_price.attr('disabled', true);

    $('.table-rows').each(function() {
        $(this).removeClass('row-selected');
    })
}
