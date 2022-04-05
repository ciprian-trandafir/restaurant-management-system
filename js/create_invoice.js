let $loading = $('.go-loader-wrapper');
let $button_add_to_invoice = $('.buttonAddToInvoice');
let $amount = $('#amount_add');
let $chosen = $('#chosen');

$('body')
    .on('click', '.buttonApplyProductsFilter', function () {
        if ($button_add_to_invoice.attr('data-type') === '1') {
            $button_add_to_invoice.attr('data-id', '');
            $button_add_to_invoice.attr('data-type', '');
            $chosen.val('');
            $amount.val('');
        }

        let search = $('#filter-products').val();
        $loading.fadeIn(200);
        $.ajax({
            method: "POST",
            dataType: "json",
            url: AJAX_URL,
            data: {
                action: 'applyInventoryFilters_1',
                filter: search,
            },
            success: function(data) {
                $loading.fadeOut(200);
                $('.inventory-table .table-rows').each(function () {
                    $(this).remove();
                })
                $('.inventory-table tbody').append(data.response);
            }
        })
    })
    .on('click', '.buttonApplyRecipesFilter', function() {
        if ($button_add_to_invoice.attr('data-type') === '2') {
            $button_add_to_invoice.attr('data-id', '');
            $button_add_to_invoice.attr('data-type', '');
            $chosen.val('');
            $amount.val('');
        }

        let search = $('#filter-recipes').val();
        $loading.fadeIn(200);
        $.ajax({
            method: "POST",
            dataType: "json",
            url: AJAX_URL,
            data: {
                action: 'applyRecipeFilters',
                filter: search,
            },
            success: function(data) {
                $loading.fadeOut(200);
                $('.recipes-table .table-rows').each(function () {
                    $(this).remove();
                })
                $('.recipes-table tbody').append(data.response);
            }
        })
    })
    .on('click', '.inventory-table .table-rows', function() {
        $('.inventory-table .table-rows').each(function() {
           $(this).removeClass('row-selected');
        });

        $('.recipes-table .table-rows').each(function() {
            $(this).removeClass('row-selected');
        });

        $(this).addClass('row-selected');
        $('#chosen').val('Product: ' + $(this).find('.product_name').text());
        $button_add_to_invoice.attr('data-id', $(this).closest('.table-rows').attr('data-id'));
        $button_add_to_invoice.attr('data-type', 1);

        $chosen.removeClass('input-error');
        $amount.removeClass('input-error');
    })
    .on('click', '.recipes-table .table-rows', function() {
        $('.recipes-table .table-rows').each(function() {
            $(this).removeClass('row-selected');
        });

        $('.inventory-table .table-rows').each(function() {
            $(this).removeClass('row-selected');
        });

        $(this).addClass('row-selected');
        $('#chosen').val('Recipe: ' + $(this).find('.recipe_name').text());
        $button_add_to_invoice.attr('data-id', $(this).closest('.table-rows').attr('data-id'));
        $button_add_to_invoice.attr('data-type', 2);

        $chosen.removeClass('input-error');
        $amount.removeClass('input-error');
    })
    .on('click', '.buttonAddToInvoice', function() {
        let id = $(this).attr('data-id');
        let type = $(this).attr('data-type');
        let amount = $amount.val();
        if (!id) {
            $chosen.addClass('input-error');
            alert('Please select a product or recipe to add to invoice!');
        } else if (!amount) {
            $amount.addClass('input-error');
            alert('Please input the amount to add to invoice!');
        } else {
            let item_name = '';
            let item_price = '';
            let item_stock = '';

            if (type === '1') {
                let $row = $('.inventory-table tr[data-id=' + id + ']');
                item_name = $row.find('.product_name').text();
                item_price = $row.find('.product_price').text();
                item_stock = parseFloat($row.find('.product_stock').text());

                if (item_stock >= parseFloat(amount)) {
                    $row.find('.product_stock').text(item_stock - amount);
                    addProductToInvoice(id, item_name, item_price, amount, 1);
                } else {
                    alert('Isn\'t enough in stock!');
                }
            } else {
                let $row = $('.recipes-table tr[data-id=' + id + ']');
                item_name = $row.find('.recipe_name').text();
                item_price = $row.find('.recipe_price').text();
                let difference = 0;

                $('.invoice-table .table-rows').each(function() {
                    if ($(this).attr('data-id') === id && $(this).attr('data-type') === type) {
                        difference = parseFloat($(this).find('.invoice_amount').text());
                        amount = parseFloat(amount);
                        amount += difference;
                    }
                });

                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: AJAX_URL,
                    data: {
                        action: 'checkRecipeAvailability',
                        id_recipe: id,
                        amount: amount
                    },
                    success: function(data) {
                        if (data.success) {
                            addProductToInvoice(id, item_name, item_price, amount - difference, 2);
                        } else {
                            alert('Isn\'t enough in stock!');
                        }
                    }
                })
            }
        }
    })
    .on('click', '.buttonFinishInvoice', function() {
        let $mentions = $('#mentions');
        if (!$mentions.val()) {
            $mentions.addClass('input-error');
            alert('Please type mentions!');
        } else {
            let data = [];
            $('.invoice-table .table-rows').each(function() {
                data.push({
                    'id': $(this).attr('data-id'),
                    'type': $(this).attr('data-type'),
                    'qty': $(this).find('.invoice_amount').text()
                })
            });

            if (!data.length) {
                alert('The invoice are empty');
            } else {
                $loading.fadeIn(200);
                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: AJAX_URL,
                    data: {
                        action: 'finishInvoice',
                        data: data,
                        mentions: $mentions.val()
                    },
                    success: function() {
                        location.replace(BASE_URL);
                    }
                })
            }
        }
    })

function addProductToInvoice(id, item_name, item_price, amount, type) {
    $('.inventory-table .table-rows').each(function() {
        $(this).removeClass('row-selected');
    });

    $('.recipes-table .table-rows').each(function() {
        $(this).removeClass('row-selected');
    });

    let $invoice_table = $('.invoice-table');
    $invoice_table.append('<tr class="table-rows" data-id="' + id +'" data-type="' + type + '">' +
        '<td class="table-cell">' + item_name + '</td>' +
        '<td class="table-cell">' + (item_price * amount) + '</td>' +
        '<td class="table-cell invoice_amount">' + amount + '</td>' +
        '</tr>');
    $chosen.val('');
    $amount.val('');
}
