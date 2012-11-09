(function ($) {

    "use strict";

    Tc.Module.ModuleBrowser = Tc.Module.extend({
        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
            this.model = sandbox.getConfigParam('model');
        },

        on: function (callback) {
            var self = this,
                $ctx = this.$ctx;

            if(!this.model.project) {
                var view = doT.template($('#mod-module-browser-initial').text());
                $ctx.html(view({ user : this.model.user }));

                $ctx.on('click', '.createproject', function() {
                    Backbone.history.navigate('project/create', { trigger:true });
                    return false;
                });
            }
            else {
                this.model.project.bind('change', function () {
                    // create DOM
                    var view = doT.template($('#mod-module-browser').text());
                    $ctx.html(view({ baseurl: self.sandbox.getConfigParam('baseurl'), project : self.model.project.toJSON() }));

                    callback();
                });

                $ctx.on('click', '.create', function() {
                    var $this = $(this);
                    Backbone.history.navigate($this.attr('href').substring(1), { trigger:true });
                    return false;
                });

                $ctx.on('click', 'a', function() {
                    var $this = $(this);
                    Backbone.history.navigate($this.attr('href').substring(1), { trigger:true });
                    return false;
                });

                $ctx.on('mouseenter', '.wrap', function() {
                    var $this = $(this);
                    $this.find('.cover').show();
                    return false;
                }).on('mouseleave', '.wrap', function() {
                    var $this = $(this);
                    $this.find('.cover').hide();
                    return false;
                });
            }
        }
    });
})(Tc.$);
