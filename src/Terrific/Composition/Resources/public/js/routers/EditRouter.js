(function ($) {

    "use strict";

    window.EditRouter = Backbone.Router.extend({

        routes: {
            "edit" : 'edit'
        },

        edit: function(state) {
            // clear recent terrific application
            delete window.application;

            // model stuff
            var model = window.model = window.model || {};
            model.module = new window.Module();

            model.module.fetch({
                success: function() {
                    // create DOM
                    var view = doT.template($('#view-edit').text());
                    var $page = $('.container');
                    $page.html(view());

                    // terrific bootstrap
                    var application = window.application = new Tc.Application($page, { 'model' : model });
                    application.registerModules();
                    application.start();
                },
                error: function(response) {
                    console.error('an error occured during loading the model');
                }
            });
        }
    });
})(Tc.$);
