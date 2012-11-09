(function ($) {

    "use strict";

    Tc.Module.Preview = Tc.Module.extend({

        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
            this.model = sandbox.getConfigParam('model').module;
        },

        on:function (callback) {
            var self = this,
                $ctx = this.$ctx,
                $iframe = $('iframe', $ctx),
                iframe = $iframe[0],
                model = this.model;

            var render = function() {
                iframe.contentDocument.location.reload(true);
            };

            // initial rendering
            $iframe.attr('src', this.sandbox.getConfigParam('baseurl') + '/api/module/render/' + model.get('id'));

            // editor events
            model.get('markup').on('change:code', function() {
                render();
            });

            model.get('style').on('change:code', function() {
                render();
            });

            model.get('script').on('change:code', function() {
                render();
            });

            callback();
        },

        onActivate: function(data) {
            var self = this,
                $ctx = this.$ctx;

            if(data.type === 'preview') {
                $ctx.show();
            }
            else {
                $ctx.hide();
            }
        }
    });
})(Tc.$);
