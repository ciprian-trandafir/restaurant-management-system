$('body')
    .on('click', '.secondaryButton', function () {
        $('#changePasswordModal').modal('show');
    })
    .on('click', '.button_update_password', function () {
        let $old_password = $('#old_password');
        let $new_password = $('#new_password');
        let $new_passwordC = $('#new_passwordC');
        let $loading = $('#changePasswordModal .go-loader-wrapper');
        let do_ajax = true;

        if ($old_password.val() === '') {
            $old_password.addClass('input-error');
            $old_password.closest('div').find('.display-error').text('Can\'t be empty');
            do_ajax = false;
        }

        if ($new_password.val() === '') {
            $new_password.addClass('input-error');
            $new_password.closest('div').find('.display-error').text('Can\'t be empty');
            do_ajax = false;
        }

        if ($new_passwordC.val() === '') {
            $new_passwordC.addClass('input-error');
            $new_passwordC.closest('div').find('.display-error').text('Can\'t be empty');
            do_ajax = false;
        }

        if (do_ajax && ($new_passwordC.val() !== $new_password.val())) {
            $new_passwordC.addClass('input-error');
            $new_password.addClass('input-error');

            $new_passwordC.closest('div').find('.display-error').text('Doesn\'t match!');
            $new_password.closest('div').find('.display-error').text('Doesn\'t match!');
            do_ajax = false;
        }

        if (do_ajax) {
            $loading.fadeIn(200);
            $new_password.removeClass('input-error');
            $new_passwordC.removeClass('input-error');
            $old_password.removeClass('input-error');

            $new_passwordC.closest('div').find('.display-error').text('');
            $new_password.closest('div').find('.display-error').text('');
            $old_password.closest('div').find('.display-error').text('');

            $.ajax({
                method: "POST",
                dataType: "json",
                url: AJAX_URL,
                data: {
                    action: 'updatePassword',
                    old_password: $old_password.val(),
                    new_password: $new_password.val()
                },
                success: function(data) {
                    $loading.fadeOut(200);
                    if (data.response) {
                        $('#changePasswordModal .confirmation_message').fadeIn(100);
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    } else {
                        $old_password.addClass('input-error');
                        $old_password.closest('div').find('.display-error').text('Doesn\'t match!');
                    }
                }
            })
        }
    });
