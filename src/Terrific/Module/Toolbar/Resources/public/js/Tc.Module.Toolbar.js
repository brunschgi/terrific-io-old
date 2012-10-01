(function ($) {

    "use strict";

    Tc.Module.Toolbar = Tc.Module.extend({
        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
        },

        on:function (callback) {
            var self = this,
                $ctx = this.$ctx;

            // create DOM
            var view = doT.template($('#mod-toolbar').text());
            $ctx.html(view());

            $ctx.on('click', 'a', function() {
                var $this = $(this);

                $('.active', $ctx).removeClass('active');
                $this.addClass('active');

                self.fire('activate', { type : $this.attr('href').substring(1) });

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
