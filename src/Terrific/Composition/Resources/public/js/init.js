(function($) {
    "use strict";

    // routing stuff
    var moduleRouter = new window.ModuleRouter();
    var projectRouter = new window.ProjectRouter();

    Backbone.history.start({pushState: true, root: Tc.Config.baseurl + '/'});

})(Tc.$);


// global error handler
window.onerror = function (msg, url, line) {
    console.log(msg);
};