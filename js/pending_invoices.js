$('body')
    .on('click', '.buttonPayInvoice', function() {
        $(this).closest('.invoice').remove();
    })
