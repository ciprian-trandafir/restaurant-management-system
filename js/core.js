$('.my-account')
    .hover(function () {
        $('.my-account-preview').fadeIn(200);
    })
    .mouseleave(function () {
        $('.my-account-preview').fadeOut(200);
    });

$('.management_inner')
    .hover(function () {
        $('.management_actions').fadeIn(200);
    })
    .mouseleave(function () {
        $('.management_actions').fadeOut(200);
    });

$('body')
    .on('keyup', 'input', function() {
        $(this).removeClass('input-error');
        $(this).closest('div').find('.display-error').text('');
    })
    .on('click', '.home_refresh', function() {
        location.reload();
    })
    .on('dragstart', 'img', function(e) {
        e.preventDefault();
    })
    .on('click', '.customer_index .recipe_inner, .chef_index .recipe_image', function() {
        let $recipe = $(this);
        let $modal = $('#recipe_details');
        let $loading = $modal.find('.go-loader-wrapper');
        $modal.find('.modal-title').text($recipe.closest('.recipe').find('.recipe_name span').text() + ' - Ingredients');
        $modal.modal('show');
        $loading.fadeIn(200);
        $.ajax({
            method: "POST",
            dataType: "json",
            url: AJAX_URL,
            data: {
                action: 'getRecipeIngredients',
                id_recipe: $recipe.closest('.recipe').attr('data-id')
            },
            success: function(data) {
                $loading.fadeOut(200);
                if (data.response) {
                    $modal.find('.ingredients-table').append(data.response);
                }
            }
        })
    })
    .on('hidden.bs.modal', '#recipe_details', function () {
        $(this).find('.table-rows').each(function() {$(this).remove();});
    })
    .on('dblclick', '.buttonKitchenRequestDone', function() {
        let $button = $(this);
        let $loading = $('.chef_index .go-loader-wrapper');
        $loading.fadeIn(200);

        $.ajax({
            method: "POST",
            dataType: "json",
            url: AJAX_URL,
            data: {
                action: 'finishKitchenRequest',
                id_request: $button.attr('data-id'),
            },
            success: function() {
                $loading.fadeOut(200);
                $button.closest('.recipe').remove();
            }
        })
    })
    .on('click', '.home_sales', function() {
        $('#home_sales').modal('show');
        let xValues = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
        let yValues = [45.99, 42.99, 64.99, 59.99, 49.99, 59.99, 69.99, 41.99, 41.99];

        new Chart("chartSales", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0, 0, 255, 1.0)",
                    borderColor: "rgba(0, 0, 255, 0.1)",
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    yAxes: [{ticks: {min: 40, max: 70}}],
                }
            }
        });
    });
