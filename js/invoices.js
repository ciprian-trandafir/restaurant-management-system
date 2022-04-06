let $loading = $('.go-loader-wrapper');
let xValues = [];
let yValues = [];
let yMin = 0;
let yMax = 0;

$('body')
    .on('click', '.button_get_invoice_history', function() {
        $loading.fadeIn(200);
        let $user = $('#user');
        let order = $('#sort_order').prop('checked');
        order ? order = 'ASC' : order = 'DESC';
        let date_from = $('#date-from').val();
        let date_to = $('#date-to').val();

        $.ajax({
            method: "POST",
            dataType: "json",
            url: AJAX_URL,
            data: {
                action: 'getInvoices',
                sort: order,
                date_from: date_from,
                date_to: date_to,
                user: $user.val()
            },
            success: function(data) {
                $loading.fadeOut(200);
                $('.table-rows').remove();
                $('.invoices-table').append(data.response);
                if (data.total) {
                    $('.total_rewards').html('Total rewards: <strong>' + data.total + ' RON</strong>');
                }

                if (parseFloat(data.total)) {
                    $('.button_view_graph').attr('disabled', false);

                    xValues = [];
                    yValues = [];
                    yMax = 0;
                    yMin = 0;

                    for (let i = 0; i < data.invoices.length; i++) {
                        xValues.push(data.invoices[i][7]);
                        yValues.push(data.invoices[i][3]);

                        if (data.invoices[i][3] > yMax) {
                            yMax = data.invoices[i][3];
                        }

                        if (data.invoices[i][3] < yMin) {
                            yMin = data.invoices[i][3];
                        }
                    }
                } else {
                    $('.button_view_graph').attr('disabled', true);
                }
            }
        })
    })
    .on('click', '.invoices-table .table-rows', function() {
        window.open(BASE_URL + 'pdf/invoice_' + $(this).attr('data-id') + '.pdf', '_blank').focus();
    })
    .on('click', '.button_view_graph', function() {
        $('#sales_graph').modal('show');

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
                    yAxes: [{ticks: {min: yMin + 1, max: yMax + 1}}],
                }
            }
        });
    });
