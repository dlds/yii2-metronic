(function ($) {

    var fixHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    };
    $.fn.SortableGridView = function (action, _options) {
        var widget = this;
        var grid = $('tbody', this);
        var options = {
            items: 'tr',
        };

        options = $.extend(options, _options);

        grid.sortable({
            items: options.items,
            update: function () {
                var data = [];
                $(options.items, grid).each(function () {
                    data.push(JSON.stringify($(this).data('key')));
                });
                $.ajax({
                    'url': action,
                    'type': 'post',
                    'data': {
                        "items[]": data,
                    },
                    'success': function () {
                        widget.trigger('sortableSuccess');
                    },
                    'error': function (request, status, error) {
                        alert(status + ' ' + error);
                    }
                });
            },
            helper: fixHelper
        }).disableSelection();
    };
})(jQuery);