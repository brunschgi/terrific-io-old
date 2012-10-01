(function ($) {

    "use strict";

    Tc.Module.Editor = Tc.Module.extend({
        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
            this.model= sandbox.getConfigParam('model').module.get($ctx.data('type'));
        },

        on:function (callback) {
            var self = this,
                $ctx = this.$ctx,
                model = this.model,
                delay;

            // create DOM
            var view = doT.template($('#mod-editor').text());
            $ctx.html(view());

            var editor = CodeMirror($('.editor', $ctx)[0], {
                mode: model.get('mode'),
                value: model.get('code'),
                theme: 'solarized-light',
                onChange: function() {
                    clearTimeout(delay);
                    delay = setTimeout(function() {
                        // change model
                        model.save({'code' : editor.getValue()});
                    }, 300);
                }
            });

            callback();
        },

        onActivate: function(data) {
            var self = this,
                $ctx = this.$ctx;

            if(data.type === $ctx.data('type')) {
                $ctx.show();
            }
            else {
                $ctx.hide();
            }
        }
    });
})(Tc.$);
