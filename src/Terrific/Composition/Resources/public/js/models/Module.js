(function ($) {

    "use strict";

    window.Module = Backbone.Model.extend({

        urlRoot: Tc.Config.baseurl + '/api/module',

        parse: function(response) {
            // handle nested models
            this.set('markup', new window.Snippet(response.markup));
            delete response.markup;

            this.set('style', new window.Snippet(response.style));
            delete response.style;

            this.set('script', new window.Snippet(response.script));
            delete response.script;

            return response;
        },

        clear:function () {
            this.destroy();
        }
    });
})(Tc.$);
