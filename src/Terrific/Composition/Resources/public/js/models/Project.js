(function ($) {

    "use strict";

    window.Project = Backbone.Model.extend({

        urlRoot:Tc.Config.baseurl + '/api/project',

        defaults: {
            'selected':false
        },

        parse:function (response) {
            // handle nested models
            if(response.modules) {
                var modules = new window.Modules();
                modules.add(response.modules);
                this.set('modules', modules);
                delete response.modules;
            }

            return response;
        },

        clear:function () {
            this.destroy();
        }
    });
})(Tc.$);
