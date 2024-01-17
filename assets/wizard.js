(function ($) {
    $(document).ready(function () {
        $('.ccb_pro_wizard__close').on('click', function () {
            $('.ccb_pro_wizard__overlay, .ccb_pro_wizard').remove();
        });
    });
})(jQuery);