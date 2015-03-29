/**
 * Initialization script for Metronic theme
 */
jQuery(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    App.init();
});

jQuery('.portlet').ajaxComplete(function (event, xhr, settings) {
    Metronic.initAjax();
});