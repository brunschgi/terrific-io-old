(function ($) {

    "use strict";

    Tc.Module.Editor = Tc.Module.extend({
        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
            this.type = $ctx.data('type');
            this.model= sandbox.getConfigParam('model').module.get(this.type);
            this.editor = null;
        },

        on:function (callback) {
            var self = this,
                $ctx = this.$ctx,
                type = this.type,
                model = this.model,
                delay;

            // create DOM
            var view = doT.template($('#mod-editor-' + type).text());
            $ctx.html(view());

            // bind DOM events
            var editor = this.editor = CodeMirror($('.editor', $ctx)[0], {
                mode: model.get('mode'),
                value: model.get('code'),
                theme: 'solarized-light',
                lineNumbers: true,
                onChange: function() {
                    clearTimeout(delay);
                    delay = setTimeout(function() {
                        // change model
                        model.save({'code' : editor.getValue()});
                    }, 500);
                },
                onViewportChange: function() {
                    editor.refresh();
                }
            });

            $ctx.on('click', '.precompilers a', function() {
               var $this = $(this),
                   mode = $this.attr('href').substring(1);

               model.save({ 'mode' : mode });
               editor.setOption('mode', mode);

               return false;
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
