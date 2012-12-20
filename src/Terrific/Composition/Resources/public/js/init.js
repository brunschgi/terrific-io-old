(function($) {
    "use strict";

    // routing stuff
    var moduleRouter = new window.ModuleRouter();
    var projectRouter = new window.ProjectRouter();

    // global require config
    window.require = {
        baseUrl: '', // is overriden from the specific module
        paths:{
            lib:'../libraries'
        },
        shim:{
            'lib/terrific':{
                deps:['lib/jquery'],
                exports:'Tc'
            }
        }
    };

    Backbone.history.start({pushState: true, root: Tc.Config.baseurl + '/'});

})(Tc.$);


// global error handler
/*window.onerror = function (msg, url, line) {
    console.log(msg);
};*/