;(function ($, window, document) {
    // Printing wizard
    var $validateBtn = $('#ticket-print-validate-btn');
    var $printBtn = $('#ticket-print-print-btn');
    var $finishBtn = $('#ticket-print-finish-btn');

    var $form = $validateBtn.closest('form');
    var barcodesStr;

    $validateBtn.on('click', function (e) {
        e.preventDefault();

        if (!$validateBtn.hasClass('disabled')) {
            $.ajax({
                "dataType": "json",
                "method": $form.attr('method'),
                "url": $form.attr('action'),
                "data": $form.serialize().replace('_method=POST&', '') + '&action=validate',
                "success": function (json) {
                    barcodesStr = json.barcodesStr;
                    $form.append('<input type="hidden" name="barcodesStr" value="' + barcodesStr + '">');
                    $validateBtn.addClass('disabled');
                    $printBtn.removeClass('disabled');
                }
            });
        }
    });

    $printBtn.on('click', function (e) {
        e.preventDefault();

        if (!$printBtn.hasClass('disabled')) {
            var win = window.open($form.attr('action') + '.pdf?codes=' + barcodesStr, '_blank');
            if (win) {
                win.focus();
                $finishBtn.removeClass('disabled');
            }
        }
    });
})(jQuery, window, window.document);