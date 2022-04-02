let $modal = $('#edit_user_details');

$('body')
    .on('click', '.user_action_edit', function() {
        $modal.find('.modal-title').text($(this).closest('tr').find('.user_full_name').text());
        $modal.find('.button_save_user_details').attr('data-id', $(this).closest('tr').attr('data-id'));
        $modal.modal('show');
    })
    .on('click', '.button_save_user_details', function() {
        let $submitButton = $(this);
        let $edit_role= $('#edit_role');
        let $edit_active = $('#edit-active');
        let $loading = $modal.find('.go-loader-wrapper');
        let do_ajax = true;

        if (!$edit_role.val()) {
            $edit_role.addClass('input-error');
            $edit_role.closest('div').find('.display-error').text('Please select a role!');
            do_ajax = false;
        }

        if (!$edit_active.val()) {
            $edit_active.addClass('input-error');
            $edit_active.closest('div').find('.display-error').text('Please select account status!');
            do_ajax = false;
        }

        if (do_ajax) {
            $loading.fadeIn(200);
            $.ajax({
                method: "POST",
                dataType: "json",
                url: AJAX_URL,
                data: {
                    action: 'updateUser',
                    role: $edit_role.val(),
                    status: $edit_active.val(),
                    id_user: $submitButton.attr('data-id')
                },
                success: function(data) {
                    $loading.fadeOut(200);
                    if (data.response) {
                        $modal.find('.confirmation_message').fadeIn(100);
                        $submitButton.attr('disabled', true);
                        $modal.find('.modal-footer .btn-secondary').attr('disabled', true);

                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                }
            })
        }
    })
    .on('change', '#edit_role, #edit-active', function () {
        $(this).removeClass('input-error');
        $(this).closest('div').find('.display-error').text('');
    });
