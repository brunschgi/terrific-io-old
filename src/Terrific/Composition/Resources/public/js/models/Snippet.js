(function ($) {

    "use strict";

    window.Snippet = Backbone.Model.extend({

        urlRoot: Tc.Config.baseurl + '/api/snippet',

        defaults:function () {
            return {
                mode:'text/plain',
                code:'Sample Code'
            };
        },

        clear:function () {
            this.destroy();
        }
    });
})(Tc.$);
