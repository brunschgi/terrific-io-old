(function ($) {

    "use strict";

    window.Project = Backbone.Model.extend({

        urlRoot: Tc.Config.baseurl + '/api/project',

        parse: function(response) {
            // handle specials (init if necessary)
            if(!this.markup) {
                response.markup = new window.Snippet(response.markup);
            }

            if(!this.style) {
                response.style = new window.Snippet(response.style);
            }

            if(!this.modules) {
                response.modules = [];
            }

            return response;
        },

        clear:function () {
            this.destroy();
        }
    });
})(Tc.$);
