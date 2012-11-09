(function ($) {

    "use strict";

    window.ModuleRouter = Backbone.Router.extend({

        routes: {
            // 'module/list/:type/:page' : 'list',
            'module/create/:id' : 'create',
            'module/edit/:id' : 'edit'
            // 'module/view/:id' : 'view'
        },

        /*
        list: function(type, page) {
            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = {};
            model.modules = new window.Modules();
            model.modules.url += '/' + type + '/' + page;

            model.modules.fetch({
                success: function(data) {
                    // create DOM
                    var view = doT.template($('#tpl-module-list').text());
                    var $page = $('.container');
                    data.baseurl = Tc.Config.baseurl;
                    $page.html(view(data));

                    // terrific bootstrap
                    var application = window.application = new Tc.Application($page, $.extend({}, Tc.Config, { 'model' : model }));
                    application.registerModules();
                    application.start();
                },
                error: function(response) {
                    console.error('an error occured during loading the modules');
                }
            });
        },
        */

        create: function(id) {
            // validation
            if(!id) {
                console.error('the module needs to be added to an existing project – please specifiy the project id')
            }

            var self = this;

            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = window.model = window.model || {};
            model.module = new window.Module();

            model.module.save({ project : id }, {
                success: function(data) {
                   self.navigate('module/edit/' + data.id, { trigger : true, replace : true });
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
        }

        /*
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
        */
    });
})(Tc.$);
