(function ($) {

    "use strict";

    window.ProjectRouter = Backbone.Router.extend({

        routes: {
            'project/list' : 'list',
            'project/list/:page' : 'list',
            'project/create' : 'create',
            'project/edit/:id' : 'edit',
            'project/view/:id' : 'view'
        },

        list: function(page) {
            // validation
            if(!page) {
                page = 1;
            }

            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = {};
            model.projects = new window.Projects();
            model.projects.url += '/' + page;

            model.projects.fetch({
                success: function(data) {
                    // create DOM
                    var view = doT.template($('#tpl-project-list').text());
                    var $page = $('.container');
                    data.baseurl = Tc.Config.baseurl;
                    $page.html(view(data));

                    // terrific bootstrap
                    var application = window.application = new Tc.Application($page, $.extend({}, Tc.Config, { 'model' : model }));
                    application.registerModules();
                    application.start();
                },
                error: function(response) {
                    console.error('an error occured during loading the projects');
                }
            });
        },

        create: function() {
            var self = this;

            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = {};
            model.module = new window.Project();

            model.module.save({}, {
                success: function(data) {
                   self.navigate('project/edit/' + data.id, { trigger : true });
                },
                error: function(response) {
                   console.error('an error occured during creating the project');
                }
            });
        },

        edit: function(id) {
            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = {};
            model.module = new window.Project({ id : id });

            model.module.fetch({
                success: function() {
                    // create DOM
                    var view = doT.template($('#tpl-project-edit').text());
                    var $page = $('.container');
                    $page.html(view());

                    // terrific bootstrap
                    var application = window.application = new Tc.Application($page, $.extend({}, Tc.Config, { 'model' : model }));
                    application.registerModules();
                    application.start();
                },
                error: function(response) {
                    console.error('an error occured during loading the project');
                }
            });
        },

        view: function(id) {
            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = {};
            model.project = new window.Project({ id : id });

            model.project.fetch({
                success: function() {
                    // create DOM
                    var view = doT.template($('#tpl-project-view').text());
                    var $page = $('.container');
                    $page.html(view());

                    // terrific bootstrap
                    var application = window.application = new Tc.Application($page, $.extend({}, Tc.Config, { 'model' : model }));
                    application.registerModules();
                    application.start();
                },
                error: function(response) {
                    console.error('an error occured during loading the project');
                }
            });
        }
    });
})(Tc.$);
