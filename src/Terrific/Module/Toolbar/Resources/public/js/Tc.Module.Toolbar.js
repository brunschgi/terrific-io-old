(function ($) {

    "use strict";

    Tc.Module.Toolbar = Tc.Module.extend({
        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
            this.model = sandbox.getConfigParam('model').module;
        },

        on:function (callback) {
            var self = this,
                $ctx = this.$ctx,
                model = this.model;

            // create DOM
            var view = doT.template($('#mod-toolbar').text());
            $ctx.html(view({ module : model.toJSON() }));

            $ctx.on('click', 'a', function() {
                var $this = $(this);

                if($this.is('.save')) {
                    // save -> the module source is precompiled for faster displaying
                    self.fire('save');
                }
                if($this.is('.share')) {
                    // share -> module can now be displayed in module lists (implicit save)
                    self.fire('share');
                }
                else if($this.is('.back')) {
                    // back to project
                    Backbone.history.navigate($this.attr('href').substring(1), { trigger:true });
                }
                else {
                    // code & preview
                    $('.active', $ctx).removeClass('active');
                    $this.addClass('active');

                    self.fire('activate', { type : $this.attr('href').substring(1) });
                }

                return false;
            });

            callback();
        },

        after:function() {
            var self = this,
                $ctx = this.$ctx;

            $('a[href*="preview"]', $ctx).trigger('click');
        }
    });
})(Tc.$);
