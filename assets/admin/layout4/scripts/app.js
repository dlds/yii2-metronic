var App = function () {

    var initTabsErrors = function () {

        $(document).find('label.error').closest('.tab-pane').each(function (i, e) {

            var tab = $('a[href=#' + this.id + ']');

            tab.prepend('<span class="fa fa-warning"></span>');

            initFormErrors(tab);
        });
    }

    var initErrors = function (elements) {

        elements.addClass('error');
    }

    return {
        init: function () {
            initTabsErrors();
        }
    };


}();