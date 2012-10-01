(function ($) {

    "use strict";

    window.Module = Backbone.Model.extend({

        url: '/app_dev.php/data/module',

        defaults:function () {
            var markup = new window.Snippet({ 'mode' : 'text/html', 'code' : ''});
            var style = new window.Snippet({ 'mode' : 'text/css', 'code' : ''});
            var script = new window.Snippet({ 'mode' : 'text/javascript', 'code' : ''});

            return {
                markup: markup,
                style: style,
                script: script
            };
        },

        parse: function(response) {
            if(response.markup) {
                this.get('markup').set(response.markup);
            }

            if(response.style) {
                this.get('style').set(response.style);
            }

            if(response.script) {
                this.get('script').set(response.script);
            }
        },


        clear:function () {
            this.destroy();
        }

    });
})(Tc.$);
