(function ($) {

    "use strict";

    window.Modules = Backbone.Collection.extend({
        model: window.Module,
        url: Tc.Config.baseurl + '/api/module/list'
    });
})(Tc.$);
