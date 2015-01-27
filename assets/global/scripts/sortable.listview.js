(function ($) {
    var fixHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    };
    $.fn.SortableListView = function (action, options) {
        var widget = this;

        var config = $.extend(options, {
            //placeholder: options && options.placeholder || 'sortable-placeholder',
            items: '.sortable-item',
            update: function () {
                var data = [];
                $('.sortable-item', widget).each(function () {
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
        });

        widget.sortable(config);
    };
})(jQuery);