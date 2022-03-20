$('.my-account')
    .hover(function () {
        $('.my-account-preview').fadeIn(200);
    })
    .mouseleave(function () {
        $('.my-account-preview').fadeOut(200);
    });

$('body')
    .on('change', 'input', function() {
        $(this).removeClass('input-error');
        $(this).closest('div').find('.display-error').text('');
    })