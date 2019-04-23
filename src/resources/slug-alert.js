jQuery(document).ready(function() {
    $('body').on('focusin', 'input[name="slug"]', function(e) {
        var varName = 'originalSlug_' + $(this).attr('id');
        if (window[varName] === undefined) {
            window[varName] = $(this).val();
        }
    });

    $('body').on('input', 'input[name="slug"]', function(e) {
        var varName = 'originalSlug_' + $(this).attr('id');

        if (window[varName] !== $(this).val() && !confirm(window.slugAlertMessage)) {
            $(this).val(window[varName]);
            return;
        }
    });
});
