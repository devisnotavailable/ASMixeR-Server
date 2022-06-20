let Optimize = {
    start: function () {
        $('select.select2').select2({width: 'resolve'});

        let table_responsive = $('.table-responsive');

        $(document).on('shown.bs.dropdown', '.table-responsive .drop-down-push-footer', function () {
            if (table_responsive.hasScrollBar()) {
                table_responsive.css('padding-bottom', 135);
            }
        }).on('hide.bs.dropdown', '.drop-actions', function () {
            table_responsive.css('padding-bottom', 0);
        });
    }
};

$.fn.hasScrollBar = function () {
    return this.get(0).scrollHeight > this.height();
};

$(function () {
    Optimize.start();
});