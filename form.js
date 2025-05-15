jQuery(document).ready(function ($) {
    $('.mecf-form').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        var formId = $form.attr('id');
        var data = {
            action: 'mecf_submit_form',
            nonce: window[formId].nonce,
            name: $form.find('[name="name"]').val(),
            email: $form.find('[name="email"]').val(),
            message: $form.find('[name="message"]').val(),
            to_email: window[formId].email,
            webhook: window[formId].webhook,
        };

        $.post(window[formId].ajaxurl, data, function (res) {
            let msg = res.success ? window[formId].success : window[formId].error;
            $form.find('.mecf-response').html('<div>' + msg + '</div>');
            if (res.success) $form[0].reset();
        });
    });
});
