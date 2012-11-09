(function ($) {

    "use strict";

    Tc.Module.Sidebar = Tc.Module.extend({
        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
            this.model = sandbox.getConfigParam('model');
        },

        on:function (callback) {
            var self = this,
                $ctx = this.$ctx;

            this.model.projects.bind('reset', function () {
                // create DOM
                var view = doT.template($('#mod-sidebar').text());
                $ctx.html(view({ projects: self.model.projects.toJSON() }));

                callback();
            });

            $ctx.on('click', '.create', function() {
                Backbone.history.navigate('project/create', { trigger:true });
                return false;
            });

            $ctx.on('click', 'li a', function () {
                var $this = $(this);
                Backbone.history.navigate('project/' + $this.attr('href').substring(1), { trigger:true });
                return false;
            });
        }
    });
})(Tc.$);
