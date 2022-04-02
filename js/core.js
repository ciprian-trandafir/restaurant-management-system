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