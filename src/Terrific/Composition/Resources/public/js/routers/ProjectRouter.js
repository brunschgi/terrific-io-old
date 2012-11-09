(function ($) {

    "use strict";

    window.ProjectRouter = Backbone.Router.extend({

        routes: {
            'project/list' : 'list',
            'project/:id/*name' : 'view',
            'project/create' : 'create'
        },

        list: function() {
            // init model
            var model = window.model = window.model || {};
            model.projects = new window.Projects();

            // init application
            var application = new Tc.Application($('html'), $.extend({}, Tc.Config, { 'model' : model }));

            // create DOM
            var tpl = doT.template($('#tpl-project-list').text());
            var $container = $('.container');
            var $view = $(tpl());
            $container.html($view);

            // terrific bootstrap
            application.registerModules($container);
            application.start();

            // fill model
            model.projects.fetch();
        },

        view: function(id, name) {
            // validation
            id = parseInt(id, 10);

            // init model
            var initProjects = false;
            var model = window.model = window.model || {};
            model.project = new window.Project({ id : id });

            if(!model['projects']) {
                initProjects = true;
                model.projects = new window.Projects();
            }

            // init application
            var application = new Tc.Application($('html'), $.extend({}, Tc.Config, { 'model' : model }));

            // create DOM
            var tpl = doT.template($('#tpl-project-list').text());
            var $container = $('.container');
            var $view = $(tpl());
            $container.html($view);

            // terrific bootstrap
            application.registerModules($container);
            application.start();

            // fill model
            if(initProjects) {
                model.projects.fetch({ silent: true, success : function() {
                    model.projects.get(id).set({ selected : true }, { silent : true });
                    model.projects.trigger('reset');
                }});
            }
            else {
               model.projects.each(function(project) {
                   project.set({ selected : false }, { silent : true });
               });
               model.projects.get(id).set({ selected : true }, { silent : true });
               model.projects.trigger('reset');
            }

            model.project.fetch();
        },

        create: function() {
            var self = this;

            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = window.model = {};
            model.project = new window.Project();

            model.project.save({}, {
                success: function(data) {
                   self.navigate('project/' + data.id + '/new', { trigger : true, replace: true });
                },
                error: function(response) {
                   console.error('an error occured during creating the project');
                }
            });
        }
    });
})(Tc.$);
