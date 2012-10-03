(function ($) {

    "use strict";

    window.ModuleRouter = Backbone.Router.extend({

        routes: {
            'list' : 'list',
            'create' : 'create',
            'edit/:id' : 'edit',
            'view/:id' : 'view'
        },

        create: function() {
            var self = this;

            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = {};
            model.module = new window.Module();

            model.module.save({}, {
                success: function(data) {
                    self.navigate('edit/' + data.id, { trigger : false });
                },
                error: function(response) {
                    console.error('an error occured during creating the module');
                }
            });
        },

        edit: function(id) {
            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = {};
            model.module = new window.Module({ id : id });

            model.module.fetch({
                success: function() {
                    // create DOM
                    var view = doT.template($('#tpl-module-edit').text());
                    var $page = $('.container');
                    $page.html(view());

                    // terrific bootstrap
                    var application = window.application = new Tc.Application($page, $.extend({}, Tc.Config, { 'model' : model }));
                    application.registerModules();
                    application.start();
                },
                error: function(response) {
                    console.error('an error occured during loading the module');
                }
            });
        },

        view: function(id) {
            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = {};
            model.module = new window.Module({ id : id });

            model.module.fetch({
                success: function() {
                    // create DOM
                    var view = doT.template($('#tpl-module-view').text());
                    var $page = $('.container');
                    $page.html(view());

                    // terrific bootstrap
                    var application = window.application = new Tc.Application($page, $.extend({}, Tc.Config, { 'model' : model }));
                    application.registerModules();
                    application.start();
                },
                error: function(response) {
                    console.error('an error occured during loading the module');
                }
            });
        }
    });
})(Tc.$);
