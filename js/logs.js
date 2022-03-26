let $user = $('#user');
let $action = $('#action');

$('body')
    .on('click', '.button_get_logs', function () {
        if (!$user.val()) {
            $('.select-user').find('.display-error').text('Please select an user');
            $user.addClass('input-error');
            return true;
        }

        if (!$action.val()) {
            $('.select-action').find('.display-error').text('Please select an action');
            $action.addClass('input-error');
            return true;
        }

        if ($action.val() && $user.val()) {
            let order = $('#sort_order').prop('checked');
            order ? order = 'ASC' : order = 'DESC';
            let date_from = $('#date-from').val();
            let date_to = $('#date-to').val();
            let $loading = $(this).closest('.page').find('.go-loader-wrapper');
            $loading.fadeIn(200);

            $.ajax({
                method: "POST",
                dataType: "json",
                url: AJAX_URL,
                data: {
                    action: 'getLogs',
                    user: $user.val(),
                    action_user: $action.val(),
                    sort: order,
                    date_from: date_from,
                    date_to: date_to
                },
                success: function(data) {
                    $loading.fadeOut(200);
                    $('.table-rows').remove();
                    $('.log-table').append(data.response);
                }
            })
        }

    })
    .on('change', '#user', function () {
        $('.select-user').find('.display-error').text('');
        $user.removeClass('input-error');
    })
    .on('change', '#action', function () {
        $('.select-action').find('.display-error').text('');
        $action.removeClass('input-error');
    })
