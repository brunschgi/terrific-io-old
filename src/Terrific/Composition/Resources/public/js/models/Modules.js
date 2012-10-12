(function ($) {

    "use strict";

    window.Modules = Backbone.Collection.extend({
        model: window.Module,
        url: '/app_dev.php/data/module/list'
    });
})(Tc.$);
