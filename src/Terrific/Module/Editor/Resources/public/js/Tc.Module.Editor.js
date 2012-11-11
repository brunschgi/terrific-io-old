(function ($) {

    "use strict";

    Tc.Module.Editor = Tc.Module.extend({
        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
            this.model= sandbox.getConfigParam('model').module.get($ctx.data('type'));
            this.editor = null;
        },

        on:function (callback) {
            var self = this,
                $ctx = this.$ctx,
                model = this.model,
                readonly = $ctx.data('readonly'),
                delay;

            // create DOM
            var view = doT.template($('#mod-editor').text());
            $ctx.html(view());

            var editor = this.editor = CodeMirror($('.editor', $ctx)[0], {
                mode: model.get('mode'),
                value: model.get('code'),
                theme: 'solarized-light',
                lineNumbers: true,
                onChange: function() {
                    clearTimeout(delay);
                    delay = setTimeout(function() {
                        // change model
                        if(readonly) {
                            model.set({'code' : editor.getValue()});
                        }
                        else {
                            model.save({'code' : editor.getValue()});
                        }
                    }, 300);
                },
                onViewportChange: function() {
                    editor.refresh();
                }
            });

            callback();
        },

        onActivate: function(data) {
            var self = this,
                $ctx = this.$ctx;

            if(data.type === $ctx.data('type')) {
                $ctx.show();
                this.editor.refresh();
            }
            else {
                $ctx.hide();
            }
        }
    });
})(Tc.$);
