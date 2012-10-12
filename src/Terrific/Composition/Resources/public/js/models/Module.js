(function ($) {

    "use strict";

    window.Module = Backbone.Model.extend({

        urlRoot: '/app_dev.php/data/module',

        parse: function(response) {
            // handle specials (init if necessary)
            if(!this.markup) {
                response.markup = new window.Snippet(response.markup);
            }

            if(!this.style) {
                response.style = new window.Snippet(response.style);
            }

            if(!this.script) {
                response.script = new window.Snippet(response.script);
            }

            return response;
        },

        clear:function () {
            this.destroy();
        }
    });
})(Tc.$);
