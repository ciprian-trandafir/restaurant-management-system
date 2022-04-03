$('body')
    .on('dblclick', '.buttonPayInvoice', function() {
        let $button = $(this);
        let $loading = $('.go-loader-wrapper');
        $loading.fadeIn(200);

        $.ajax({
            method: "POST",
            dataType: "json",
            url: AJAX_URL,
            data: {
                action: 'payInvoice',
                id_invoice: $button.attr('data-id'),
            },
            success: function() {
                $loading.fadeOut(200);
                $button.closest('.invoice').remove();
            }
        })
    })
