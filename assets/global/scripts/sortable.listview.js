(function ($) {
    var fixHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    };
    $.fn.SortableListView = function (action) {
        console.log('ahoj');
        var widget = this;
        var list = $('tbody', this);
        list.sortable({
            items: 'div',
            update: function () {
                var data = [];
                $('div', list).each(function () {
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