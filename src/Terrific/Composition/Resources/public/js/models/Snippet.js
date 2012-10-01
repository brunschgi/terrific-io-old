(function ($) {

    "use strict";

    window.Snippet = Backbone.Model.extend({

        urlRoot: '/app_dev.php/data/snippet',

        defaults:function () {
            return {
                mode:'text/plain',
                code:'Plain Text'
            };
        },

        clear:function () {
            this.destroy();
        }
    });
})(Tc.$);