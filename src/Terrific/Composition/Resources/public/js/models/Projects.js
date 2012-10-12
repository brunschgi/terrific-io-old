(function ($) {

    "use strict";

    window.Projects = Backbone.Collection.extend({
        model: window.Project,
        url: Tc.Config.baseurl + '/api/project/list'
    });
})(Tc.$);
